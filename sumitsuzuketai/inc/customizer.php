<?php
/**
 * 住み続け隊テーマのカスタマイザー設定
 */

if (!defined('ABSPATH')) {
    exit; // 直接アクセス禁止
}

/**
 * カスタマイザーに設定を追加
 */
function sumitsuzuketai_customize_register($wp_customize) {
    // LPセクションの追加
    $wp_customize->add_section('sumitsuzuketai_lp_options', array(
        'title'    => 'LP設定',
        'priority' => 30,
    ));
    
    // 電話番号設定
    $wp_customize->add_setting('sumitsuzuketai_phone', array(
        'default'           => '050-5810-5875',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('sumitsuzuketai_phone', array(
        'label'    => '電話番号',
        'section'  => 'sumitsuzuketai_lp_options',
        'type'     => 'text',
    ));
    
    // 営業時間設定
    $wp_customize->add_setting('sumitsuzuketai_hours', array(
        'default'           => '9:00〜19:00（年中無休）',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('sumitsuzuketai_hours', array(
        'label'    => '営業時間',
        'section'  => 'sumitsuzuketai_lp_options',
        'type'     => 'text',
    ));
    
    // トップ見出し設定
    $wp_customize->add_setting('sumitsuzuketai_headline', array(
        'default'           => '業界最大級｜リースバック一括査定サイト｜すみつづけ隊',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('sumitsuzuketai_headline', array(
        'label'    => 'メイン見出し',
        'section'  => 'sumitsuzuketai_lp_options',
        'type'     => 'text',
    ));
    
    // サブ見出し設定
    $wp_customize->add_setting('sumitsuzuketai_subheadline', array(
        'default'           => 'たった60秒で最大10社の査定額を比較',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('sumitsuzuketai_subheadline', array(
        'label'    => 'サブ見出し',
        'section'  => 'sumitsuzuketai_lp_options',
        'type'     => 'text',
    ));
    
    // メインカラー設定
    $wp_customize->add_setting('sumitsuzuketai_primary_color', array(
        'default'           => '#0066cc',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sumitsuzuketai_primary_color', array(
        'label'    => 'メインカラー',
        'section'  => 'sumitsuzuketai_lp_options',
    )));
    
    // アクセントカラー設定
    $wp_customize->add_setting('sumitsuzuketai_accent_color', array(
        'default'           => '#ff6600',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sumitsuzuketai_accent_color', array(
        'label'    => 'アクセントカラー',
        'section'  => 'sumitsuzuketai_lp_options',
    )));
    
    // フォーム送信先設定
    $wp_customize->add_setting('sumitsuzuketai_form_action', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('sumitsuzuketai_form_action', array(
        'label'       => 'フォーム送信先URL',
        'description' => '空白の場合は内部処理されます',
        'section'     => 'sumitsuzuketai_lp_options',
        'type'        => 'url',
    ));
    
    // サンクスページURL設定
    $wp_customize->add_setting('sumitsuzuketai_thanks_page', array(
        'default'           => home_url('/thanks/'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('sumitsuzuketai_thanks_page', array(
        'label'    => 'サンクスページURL',
        'section'  => 'sumitsuzuketai_lp_options',
        'type'     => 'url',
    ));
}
add_action('customize_register', 'sumitsuzuketai_customize_register');

/**
 * カスタマイザーのCSS出力
 */
function sumitsuzuketai_customize_css() {
    $primary_color = get_theme_mod('sumitsuzuketai_primary_color', '#0066cc');
    $accent_color = get_theme_mod('sumitsuzuketai_accent_color', '#ff6600');
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo $primary_color; ?>;
            --accent-color: <?php echo $accent_color; ?>;
        }
        
        /* プライマリーカラーの適用 */
        .site-header, .main-headline, .benefit-icon i, 
        .partners-feature-item i, .step-number, .review-rating i,
        .cta-button, .footer-top {
            color: var(--primary-color);
        }
        
        .section-title:after, .step-number, .process-steps .cta-button,
        .form-header, .final-cta {
            background-color: var(--primary-color);
        }
        
        /* アクセントカラーの適用 */
        .benefit-tag, .case-difference, .benefit-desc strong, 
        .stat-value, .urgency-badge, .form-group input:focus,
        .form-group select:focus {
            color: var(--accent-color);
        }
        
        .cta-button, .next-step-button, .submit-button, 
        .mini-cta a, .urgency-badge, .remaining-slots span {
            background-color: var(--accent-color);
        }
    </style>
    <?php
}
add_action('wp_head', 'sumitsuzuketai_customize_css');