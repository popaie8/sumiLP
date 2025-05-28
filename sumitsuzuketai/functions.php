<?php
/**
 * リースバック一括査定 LP テーマ機能 － 完全版（2025-05-13 改訂）
 * 変更点：
 *  1. ショートコード用スラッグをハイフン表記に統一
 *  2. lp_section_shortcode() で「ハイフン → アンダースコア」両形式を自動探索
 *  3. locate_template() を使い、親・子テーマを横断してテンプレートを検索
 *  4. FAQアコーディオンのjQuery実装を追加
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // 直接アクセス禁止
}

/* -------------------------------------------------
 * テーマセットアップ
 * ------------------------------------------------- */
function sumitsuzuketai_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	register_nav_menus(
		array(
			'primary' => 'メインメニュー',
			'footer'  => 'フッターメニュー',
		)
	);
}
add_action( 'after_setup_theme', 'sumitsuzuketai_setup' );

/* -------------------------------------------------
 * テンプレートパーツ存在チェック（デバッグ用）
 * ------------------------------------------------- */
function sumitsuzuketai_debug_template_parts() {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

		$parts = array(
			'header-firstview',
			'user-benefits',
			'partner-companies',
			'process-steps',
			'success-cases',
			'realtime-status',
			'main-form',
			'faq',
			'concierge',
			'seo-content',
			'reviews',
			'final-cta',
		);

		foreach ( $parts as $slug ) {
			$path = locate_template( "template-parts/{$slug}.php", false, false );
			if ( ! $path ) {
				error_log( "[sumitsuzuketai] テンプレートパーツ未検出: {$slug}.php" );
			}
		}
	}
}
add_action( 'init', 'sumitsuzuketai_debug_template_parts' );

/* -------------------------------------------------
 * スタイルシート & スクリプト
 * ------------------------------------------------- */
function sumitsuzuketai_scripts() {

	// Google Fonts
	wp_enqueue_style(
		'google-fonts',
		'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap',
		array(),
		null
	);

	// Font Awesome
	wp_enqueue_style(
		'font-awesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
		array(),
		'5.15.4'
	);

	// メイン CSS
	wp_enqueue_style(
		'sumitsuzuketai-style',
		get_template_directory_uri() . '/assets/css/main.css',
		array(),
		'1.0.0'
	);

	// jQueryを確実に読み込む
    wp_enqueue_script('jquery');

	// メイン JS
	wp_enqueue_script(
		'sumitsuzuketai-script',
		get_template_directory_uri() . '/assets/js/main.js',
		array( 'jquery' ),
		'1.0.0',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'sumitsuzuketai_scripts' );

/* -------------------------------------------------
 * FAQアコーディオンのためのスクリプト
 * ------------------------------------------------- */
function sumitsuzuketai_faq_scripts() {
    // FAQアコーディオン用のjQueryコードを追加
    wp_add_inline_script('jquery-core', '
        jQuery(document).ready(function($) {
            $(".faq-question").on("click", function() {
                var $item = $(this).closest(".faq-item");
                
                // 他の開いているアイテムを閉じる
                $(".faq-item.active").not($item).removeClass("active");
                
                // クリックしたアイテムの状態を切り替え
                $item.toggleClass("active");
                
                // 手動でスタイルを適用（CSSが動作しない場合のバックアップ）
                if ($item.hasClass("active")) {
                    $item.find(".faq-answer").css("display", "block");
                    $item.find(".fa-plus").css("opacity", 0);
                    $item.find(".fa-minus").css("opacity", 1);
                } else {
                    $item.find(".faq-answer").css("display", "none");
                    $item.find(".fa-plus").css("opacity", 1);
                    $item.find(".fa-minus").css("opacity", 0);
                }
                
                return false;
            });
        });
    ');
}
add_action( 'wp_enqueue_scripts', 'sumitsuzuketai_faq_scripts', 99 );

/* -------------------------------------------------
 * LP セクション：ショートコード本体
 * ------------------------------------------------- */
function lp_section_shortcode( $atts, $content = null, $tag = '' ) {

	if ( empty( $tag ) ) {
		return '';
	}

	// 例：header-firstview → header_firstview も試す
	$slugs = array_unique(
		array(
			$tag,
			str_replace( '_', '-', $tag ),
			str_replace( '-', '_', $tag ),
		)
	);

	foreach ( $slugs as $slug ) {
		$template = locate_template( "template-parts/{$slug}.php", false, false );
		if ( $template ) {
			ob_start();
			include $template;
			return ob_get_clean();
		}
	}

	// 見つからない場合
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( "[sumitsuzuketai] ショートコード「{$tag}」に対応するテンプレートが見つかりません。" );
	}
	return '';
}

/* -------------------------------------------------
 * ショートコード登録
 * ------------------------------------------------- */
function register_lp_shortcodes() {

	$sections = array(
		'header-firstview',
		'user-benefits',
		'partner-companies',
		'process-steps',
		'success-cases',
		'realtime-status',
		'main-form',
		'faq',
		'concierge',
		'seo-content',
		'reviews',
		'final-cta',
	);

	foreach ( $sections as $slug ) {
		add_shortcode( $slug, 'lp_section_shortcode' );
	}
}
add_action( 'init', 'register_lp_shortcodes' );

/* -------------------------------------------------
 * オプションページ（外観→カスタマイズ でも可）
 * ------------------------------------------------- */
function sumitsuzuketai_add_admin_menu() {
	add_menu_page(
		'すみつづけ隊設定',
		'すみつづけ隊設定',
		'manage_options',
		'sumitsuzuketai-settings',
		'sumitsuzuketai_settings_page',
		'dashicons-admin-home',
		20
	);
}
add_action( 'admin_menu', 'sumitsuzuketai_add_admin_menu' );

function sumitsuzuketai_settings_page() {
	?>
	<div class="wrap">
		<h1>すみつづけ隊 LP 設定</h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'sumitsuzuketai_options' );
			do_settings_sections( 'sumitsuzuketai-settings' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

function sumitsuzuketai_settings_init() {

	register_setting( 'sumitsuzuketai_options', 'sumitsuzuketai_options' );

	add_settings_section(
		'sumitsuzuketai_section_contact',
		'連絡先設定',
		'sumitsuzuketai_section_contact_callback',
		'sumitsuzuketai-settings'
	);

	add_settings_field(
		'phone_number',
		'電話番号',
		'sumitsuzuketai_phone_number_render',
		'sumitsuzuketai-settings',
		'sumitsuzuketai_section_contact'
	);

	add_settings_field(
		'business_hours',
		'営業時間',
		'sumitsuzuketai_business_hours_render',
		'sumitsuzuketai-settings',
		'sumitsuzuketai_section_contact'
	);
}
add_action( 'admin_init', 'sumitsuzuketai_settings_init' );

function sumitsuzuketai_section_contact_callback() {
	echo 'LP に表示する連絡先情報を設定してください。';
}

function sumitsuzuketai_phone_number_render() {
	$options = get_option( 'sumitsuzuketai_options' );
	?>
	<input type="text" name="sumitsuzuketai_options[phone_number]" value="<?php echo isset( $options['phone_number'] ) ? esc_attr( $options['phone_number'] ) : ''; ?>" />
	<?php
}

function sumitsuzuketai_business_hours_render() {
	$options = get_option( 'sumitsuzuketai_options' );
	?>
	<input type="text" name="sumitsuzuketai_options[business_hours]" value="<?php echo isset( $options['business_hours'] ) ? esc_attr( $options['business_hours'] ) : ''; ?>" />
	<?php
}

/* -------------------------------------------------
 * リード専用カスタム投稿タイプ
 * ------------------------------------------------- */
function sumitsuzuketai_register_post_types() {

	register_post_type(
		'lead',
		array(
			'labels'        => array(
				'name'          => '査定依頼',
				'singular_name' => '査定依頼',
			),
			'public'        => false,
			'show_ui'       => true,
			'menu_icon'     => 'dashicons-clipboard',
			'supports'      => array( 'title' ),
			'capability_type' => 'post',
		)
	);
}
add_action( 'init', 'sumitsuzuketai_register_post_types' );

/* -------------------------------------------------
 * フォーム送信処理
 * ------------------------------------------------- */
function sumitsuzuketai_process_form() {

	if (
		isset( $_POST['submit_assessment_form'] )
		&& wp_verify_nonce( $_POST['assessment_form_nonce'], 'assessment_form_action' )
	) {

		$name            = sanitize_text_field( $_POST['name'] );
		$phone           = sanitize_text_field( $_POST['phone'] );
		$email           = sanitize_email( $_POST['email'] );
		$postal_code     = sanitize_text_field( $_POST['postal-code'] );
		$property_type   = sanitize_text_field( $_POST['property-type'] );
		$property_addr   = sanitize_text_field( $_POST['property-address'] );
		$property_size   = intval( $_POST['property-size'] );
		$property_age    = intval( $_POST['property-age'] );

		$lead_id = wp_insert_post(
			array(
				'post_title'  => $name . ' - ' . current_time( 'Y-m-d H:i:s' ),
				'post_type'   => 'lead',
				'post_status' => 'publish',
			)
		);

		if ( $lead_id ) {

			update_post_meta( $lead_id, 'phone', $phone );
			update_post_meta( $lead_id, 'email', $email );
			update_post_meta( $lead_id, 'postal_code', $postal_code );
			update_post_meta( $lead_id, 'property_type', $property_type );
			update_post_meta( $lead_id, 'property_address', $property_addr );
			update_post_meta( $lead_id, 'property_size', $property_size );
			update_post_meta( $lead_id, 'property_age', $property_age );
			update_post_meta( $lead_id, 'ip_address', $_SERVER['REMOTE_ADDR'] );
			update_post_meta( $lead_id, 'user_agent', $_SERVER['HTTP_USER_AGENT'] );
			update_post_meta( $lead_id, 'referrer', isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '' );

			$to      = get_option( 'admin_email' );
			$subject = '【すみつづけ隊】新しい査定依頼がありました';
			$message = <<<EOT
以下の内容で査定依頼がありました。

名前: {$name}
電話番号: {$phone}
メールアドレス: {$email}
郵便番号: {$postal_code}
物件種別: {$property_type}
物件所在地: {$property_addr}
物件面積: {$property_size}㎡
築年数: {$property_age}年
IP: {$_SERVER['REMOTE_ADDR']}
EOT;

			wp_mail( $to, $subject, $message );

			wp_redirect( home_url( '/thanks/' ) );
			exit;
		}
	}
}
add_action( 'template_redirect', 'sumitsuzuketai_process_form' );

/* -------------------------------------------------
 * カスタマイザー
 * ------------------------------------------------- */
function sumitsuzuketai_customize_register( $wp_customize ) {

	$wp_customize->add_section(
		'sumitsuzuketai_lp_options',
		array(
			'title'    => 'LP 設定',
			'priority' => 30,
		)
	);

	// 電話番号
	$wp_customize->add_setting(
		'sumitsuzuketai_phone',
		array(
			'default'           => '0120-XXX-XXX',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sumitsuzuketai_phone',
		array(
			'label'   => '電話番号',
			'section' => 'sumitsuzuketai_lp_options',
			'type'    => 'text',
		)
	);

	// 営業時間
	$wp_customize->add_setting(
		'sumitsuzuketai_hours',
		array(
			'default'           => '9:00〜19:00（年中無休）',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sumitsuzuketai_hours',
		array(
			'label'   => '営業時間',
			'section' => 'sumitsuzuketai_lp_options',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'sumitsuzuketai_customize_register' );

/* -------------------------------------------------
 * カスタマイザーの値を取得するヘルパー
 * ------------------------------------------------- */
function sumitsuzuketai_get_option( $key, $default = '' ) {
	return esc_html( get_theme_mod( $key, $default ) );
}