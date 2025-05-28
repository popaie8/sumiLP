<?php
/**
 * すみつづけ隊 LP テーマ機能 – 2025-05-28
 *  - Vite でビルドした JS/CSS の読み込みを追加
 *  - ハンドラを sumitsu_handle_lead_submit() に刷新（Step-1/2 共通）
 *  - 旧 sumitsuzuketai_process_form() は廃止
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ======================================================
 * 1. テーマセットアップ
 * ====================================================== */
function sumitsuzuketai_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	register_nav_menus( array(
		'primary' => 'メインメニュー',
		'footer'  => 'フッターメニュー',
	) );
}
add_action( 'after_setup_theme', 'sumitsuzuketai_setup' );

/* ======================================================
 * 2. フロント用 CSS / JS
 * ====================================================== */
function sumitsuzuketai_scripts() {

	/* 共通ライブラリ */
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap', array(), null );
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4' );
	wp_enqueue_style( 'sumitsuzuketai-style', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'sumitsuzuketai-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), '1.0.0', true );

	/* Step-2 詳細フォーム専用（template-parts/lead-form.php） */
	if ( is_page_template( 'template-parts/lead-form.php' ) ) {

		// JS（Vite 出力）
		wp_enqueue_script(
			'lead-form-js',
			get_theme_file_uri( '/dist/js/lead.js' ),
			array(), '1.0.0', true
		);

		// NiceSelect2 CSS（vite でハッシュ付きファイルが出力される）
		foreach ( glob( get_theme_file_path( '/dist/js/assets/lead-*.css' ) ) as $css ) {
			wp_enqueue_style(
				'lead-form-css',
				str_replace( get_theme_file_path(), get_theme_file_uri(), $css ),
				array(), '1.0.0'
			);
			break;
		}
	}

	/* --- Script に type="module" を付与 --- */
    add_filter( 'script_loader_tag', function ( $tag, $handle, $src ) {
	    if ( 'lead-form-js' === $handle ) {
		    return '<script type="module" src="' . esc_url( $src ) . '"></script>';
	    }
	    return $tag;
    }, 10, 3 );
}
add_action( 'wp_enqueue_scripts', 'sumitsuzuketai_scripts' );

/* ======================================================
 * 3. FAQ アコーディオン用インライン jQuery
 * ====================================================== */
add_action( 'wp_enqueue_scripts', function () {
	wp_add_inline_script( 'jquery-core', '
		jQuery(function ($) {
			$(".faq-question").on("click", function () {
				const $item = $(this).closest(".faq-item");
				$(".faq-item.active").not($item).removeClass("active");
				$item.toggleClass("active");
			});
		});
	', 'after' );
}, 99 );

/* ======================================================
 * 4. ショートコードでセクション呼び出し
 * ====================================================== */
function lp_section_shortcode( $atts, $content = null, $tag = '' ) {
	if ( ! $tag ) return '';
	foreach ( array( $tag, str_replace( array( '_', '-' ), array( '-', '_' ), $tag ) ) as $slug ) {
		if ( $path = locate_template( "template-parts/{$slug}.php", false, false ) ) {
			ob_start();
			include $path;
			return ob_get_clean();
		}
	}
	if ( WP_DEBUG ) error_log( "[sumitsuzuketai] テンプレート未検出: {$tag}" );
	return '';
}

/* 登録 */
add_action( 'init', function () {
	$sections = array(
		'header-firstview', 'user-benefits', 'partner-companies', 'process-steps',
		'success-cases', 'realtime-status', 'main-form', 'faq', 'concierge',
		'seo-content', 'reviews', 'final-cta',
	);
	foreach ( $sections as $slug ) add_shortcode( $slug, 'lp_section_shortcode' );
} );

/* ======================================================
 * 5. リード用カスタム投稿タイプ
 * ====================================================== */
add_action( 'init', function () {
	register_post_type( 'lead', array(
		'labels'       => array( 'name' => '査定依頼', 'singular_name' => '査定依頼' ),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-clipboard',
		'supports'     => array( 'title' ),
	) );
} );

/* ======================================================
 * 6. Step-1 / Step-2 共通ハンドラ
 * ====================================================== */
add_action( 'admin_post_nopriv_lead_submit', 'sumitsu_handle_lead_submit' );
add_action( 'admin_post_lead_submit',        'sumitsu_handle_lead_submit' );

function sumitsu_handle_lead_submit() {

	$fields = array();
	foreach ( array(
		'zip', 'property-type', 'pref', 'city', 'town', 'chome', 'banchi',
		'area', 'age', 'name', 'tel', 'email'
	) as $key ) {
		$fields[ $key ] = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
	}

	/* 1) 保存 */
	$lead_id = wp_insert_post( array(
		'post_type'   => 'lead',
		'post_status' => 'publish',
		'post_title'  => $fields['name'] . ' - ' . current_time( 'Y-m-d H:i:s' ),
	) );

	if ( $lead_id ) {
		foreach ( $fields as $k => $v ) update_post_meta( $lead_id, $k, $v );
	}

	/* 2) メール通知 */
	$to      = get_option( 'admin_email' );
	$subject = '【すみつづけ隊】新しい査定依頼';
	$body    = <<<EOT
郵便番号: {$fields['zip']}
物件種別: {$fields['property-type']}
住所    : {$fields['pref']}{$fields['city']}{$fields['town']}{$fields['chome']}丁目 {$fields['banchi']}
面積    : {$fields['area']}㎡
築年数  : {$fields['age']}年

お名前  : {$fields['name']}
電話    : {$fields['tel']}
メール  : {$fields['email']}
EOT;
	wp_mail( $to, $subject, $body );

	/* 3) スプレッドシート転送（Apps Script）—任意 */
	wp_remote_post( 'https://script.google.com/macros/s/XXXXXXXXXXXXXXXX/exec', array(
		'body'    => $fields + array( 'secret' => 'sumitsu2025' ),
		'timeout' => 15,
	) );

	/* 4) サンクスページへ */
	wp_safe_redirect( home_url( '/thanks/' ) );
	exit;
}

/* ======================================================
 * 7. カスタマイザー（電話・営業時間）
 * ====================================================== */
function sumitsuzuketai_customize_register( $wp_customize ) {

	$wp_customize->add_section( 'sumitsuzuketai_lp', array(
		'title'    => 'LP 連絡先',
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'sumitsuzuketai_phone', array(
		'default'           => '0120-XXX-XXX',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'sumitsuzuketai_phone', array(
		'label'   => '電話番号',
		'section' => 'sumitsuzuketai_lp',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'sumitsuzuketai_hours', array(
		'default'           => '9:00〜19:00（年中無休）',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'sumitsuzuketai_hours', array(
		'label'   => '営業時間',
		'section' => 'sumitsuzuketai_lp',
		'type'    => 'text',
	) );
}
add_action( 'customize_register', 'sumitsuzuketai_customize_register' );

/* カスタマイザー値取得ヘルパ */
function sumitsuzuketai_get_option( $key, $default = '' ) {
	return esc_html( get_theme_mod( $key, $default ) );
}
