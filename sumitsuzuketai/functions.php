<?php
/**
 * すみつづけ隊 LP テーマ機能 – 2025-05-28
 *  - Vite でビルドした JS/CSS の読み込みを追加
 *  - ハンドラを sumitsu_handle_lead_submit() に刷新（Step-1/2 共通）
 *  - 旧 sumitsuzuketai_process_form() は廃止
 *  - ステップフォーム対応で新フィールドを追加
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
 * 6. Step-1 / Step-2 共通ハンドラ（進化版）
 * ====================================================== */
add_action( 'admin_post_nopriv_lead_submit', 'sumitsu_handle_lead_submit' );
add_action( 'admin_post_lead_submit',        'sumitsu_handle_lead_submit' );

function sumitsu_handle_lead_submit() {

	// 基本フィールド
	$fields = array();
	foreach ( array(
		'zip', 'property-type', 'pref', 'city', 'town', 'chome', 'banchi',
		'area', 'age', 'name', 'tel', 'email', 'remarks'
	) as $key ) {
		$fields[ $key ] = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
	}

	// 新機能：物件種別ごとの詳細フィールド
	$property_details = array();
	
	// 間取り情報
	if ( isset( $_POST['layout_rooms'] ) ) {
		$property_details['layout_rooms'] = sanitize_text_field( $_POST['layout_rooms'] );
	}
	if ( isset( $_POST['layout_type'] ) ) {
		$property_details['layout_type'] = sanitize_text_field( $_POST['layout_type'] );
	}

	// 面積関連（単位付き）
	$area_fields = array( 'area', 'building_area', 'land_area' );
	foreach ( $area_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			$property_details[ $field ] = sanitize_text_field( $_POST[ $field ] );
		}
		$unit_field = $field . '_unit';
		if ( isset( $_POST[ $unit_field ] ) ) {
			$property_details[ $unit_field ] = sanitize_text_field( $_POST[ $unit_field ] );
		}
	}

	// その他の種類
	if ( isset( $_POST['other_type'] ) ) {
		$property_details['other_type'] = sanitize_text_field( $_POST['other_type'] );
	}

	/* 1) 保存 */
	$lead_id = wp_insert_post( array(
		'post_type'   => 'lead',
		'post_status' => 'publish',
		'post_title'  => $fields['name'] . ' - ' . current_time( 'Y-m-d H:i:s' ),
	) );

	if ( $lead_id ) {
		// 基本フィールドを保存
		foreach ( $fields as $k => $v ) {
			update_post_meta( $lead_id, $k, $v );
		}
		
		// 物件詳細を保存
		foreach ( $property_details as $k => $v ) {
			update_post_meta( $lead_id, $k, $v );
		}
	}

	/* 2) メール通知（進化版） */
	$to      = get_option( 'admin_email' );
	$subject = '【すみつづけ隊】新しい査定依頼';
	
	// 間取り情報の整形
	$layout_info = '';
	if ( ! empty( $property_details['layout_rooms'] ) && ! empty( $property_details['layout_type'] ) ) {
		$layout_info = $property_details['layout_rooms'] . $property_details['layout_type'];
	}

	// 面積情報の整形
	$area_info = '';
	if ( ! empty( $fields['area'] ) ) {
		$area_unit = ! empty( $property_details['area_unit'] ) ? $property_details['area_unit'] : '㎡';
		$area_info .= "専有面積: {$fields['area']}{$area_unit}\n";
	}
	if ( ! empty( $property_details['building_area'] ) ) {
		$building_unit = ! empty( $property_details['building_area_unit'] ) ? $property_details['building_area_unit'] : '㎡';
		$area_info .= "建物面積: {$property_details['building_area']}{$building_unit}\n";
	}
	if ( ! empty( $property_details['land_area'] ) ) {
		$land_unit = ! empty( $property_details['land_area_unit'] ) ? $property_details['land_area_unit'] : '㎡';
		$area_info .= "土地面積: {$property_details['land_area']}{$land_unit}\n";
	}

	$body = <<<EOT
【物件情報】
郵便番号: {$fields['zip']}
物件種別: {$fields['property-type']}
住所    : {$fields['pref']}{$fields['city']}{$fields['town']}{$fields['chome']}丁目 {$fields['banchi']}
間取り  : {$layout_info}
{$area_info}築年数  : {$fields['age']}年

【お客様情報】
お名前  : {$fields['name']}
電話    : {$fields['tel']}
メール  : {$fields['email']}

【ご要望・備考】
{$fields['remarks']}

---
投稿日時: {datetime}
EOT;

	$body = str_replace( '{datetime}', current_time( 'Y-m-d H:i:s' ), $body );
	wp_mail( $to, $subject, $body );

	/* 3) スプレッドシート転送（Apps Script）—任意 */
	$post_data = array_merge( $fields, $property_details, array( 'secret' => 'sumitsu2025' ) );
	wp_remote_post( 'https://script.google.com/macros/s/XXXXXXXXXXXXXXXX/exec', array(
		'body'    => $post_data,
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

/* ======================================================
 * 8. 管理画面での査定依頼詳細表示（進化版）
 * ====================================================== */
add_action( 'add_meta_boxes', function () {
	add_meta_box(
		'lead_details',
		'査定依頼詳細',
		'lead_details_meta_box',
		'lead'
	);
} );

function lead_details_meta_box( $post ) {
	$meta = get_post_meta( $post->ID );
	
	echo '<table class="form-table">';
	
	// 基本情報
	echo '<tr><th colspan="2"><strong>基本情報</strong></th></tr>';
	$basic_fields = array(
		'zip' => '郵便番号',
		'property-type' => '物件種別',
		'pref' => '都道府県',
		'city' => '市区町村',
		'town' => '町名',
		'chome' => '丁目',
		'banchi' => '番地・建物名'
	);
	
	foreach ( $basic_fields as $key => $label ) {
		$value = isset( $meta[ $key ][0] ) ? $meta[ $key ][0] : '';
		echo "<tr><th>{$label}</th><td>" . esc_html( $value ) . "</td></tr>";
	}
	
	// 物件詳細
	echo '<tr><th colspan="2"><strong>物件詳細</strong></th></tr>';
	
	// 間取り
	$layout_rooms = isset( $meta['layout_rooms'][0] ) ? $meta['layout_rooms'][0] : '';
	$layout_type = isset( $meta['layout_type'][0] ) ? $meta['layout_type'][0] : '';
	if ( $layout_rooms && $layout_type ) {
		echo "<tr><th>間取り</th><td>" . esc_html( $layout_rooms . $layout_type ) . "</td></tr>";
	}
	
	// 面積情報
	$area_fields = array(
		'area' => '専有面積',
		'building_area' => '建物面積',
		'land_area' => '土地面積'
	);
	
	foreach ( $area_fields as $key => $label ) {
		$value = isset( $meta[ $key ][0] ) ? $meta[ $key ][0] : '';
		$unit = isset( $meta[ $key . '_unit' ][0] ) ? $meta[ $key . '_unit' ][0] : '㎡';
		if ( $value ) {
			echo "<tr><th>{$label}</th><td>" . esc_html( $value . $unit ) . "</td></tr>";
		}
	}
	
	// 築年数
	$age = isset( $meta['age'][0] ) ? $meta['age'][0] : '';
	if ( $age ) {
		$age_display = $age === '31' ? '31年以上・正確に覚えていない' : $age . '年';
		echo "<tr><th>築年数</th><td>" . esc_html( $age_display ) . "</td></tr>";
	}
	
	// その他種類
	$other_type = isset( $meta['other_type'][0] ) ? $meta['other_type'][0] : '';
	if ( $other_type ) {
		echo "<tr><th>種類</th><td>" . esc_html( $other_type ) . "</td></tr>";
	}
	
	// お客様情報
	echo '<tr><th colspan="2"><strong>お客様情報</strong></th></tr>';
	$customer_fields = array(
		'name' => 'お名前',
		'tel' => '電話番号',
		'email' => 'メールアドレス'
	);
	
	foreach ( $customer_fields as $key => $label ) {
		$value = isset( $meta[ $key ][0] ) ? $meta[ $key ][0] : '';
		echo "<tr><th>{$label}</th><td>" . esc_html( $value ) . "</td></tr>";
	}
	
	// 備考
	$remarks = isset( $meta['remarks'][0] ) ? $meta['remarks'][0] : '';
	if ( $remarks ) {
		echo "<tr><th>ご要望・備考</th><td>" . nl2br( esc_html( $remarks ) ) . "</td></tr>";
	}
	
	echo '</table>';
}