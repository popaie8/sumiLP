<?php
/**
 * ヘッダーテンプレート（修正版）
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-T3B4TDCC');</script>
<!-- End Google Tag Manager -->

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    
    <!-- SEO最適化のためのメタタグ -->
    <meta name="description" content="リースバック一括査定サイト「住み続け隊」。たった60秒の入力で最大10社から査定結果を取得。平均120%の高値売却を実現し、最安値の家賃で住み続けられます。">
    <meta name="keywords" content="リースバック,一括査定,住み続ける,不動産売却,高値売却,家賃,老後資金,住宅ローン返済,相続税対策">
    
    <!-- OGP設定 -->
    <meta property="og:title" content="リースバック一括査定｜住み続け隊">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo home_url(); ?>">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/ogp.jpg">
    <meta property="og:site_name" content="住み続け隊">
    <meta property="og:description" content="リースバック一括査定サイト「住み続け隊」。たった60秒の入力で最大10社から査定結果を取得。平均120%の高値売却を実現し、最安値の家賃で住み続けられます。">
    
    <!-- favicon -->
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-touch-icon.png">
    
    <?php wp_head(); ?>
    
    <!-- 緊急用直接CSS読み込み（デバッグ用） -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/main.css?v=<?php echo time(); ?>">
    
    <!-- 🔥 修正: 構造化データ（新ドメイン対応） -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "住み続け隊",
        "url": "<?php echo home_url(); ?>",
        "logo": "<?php echo get_template_directory_uri(); ?>/assets/images/logo.png",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "050-5810-5875",
            "contactType": "customer service",
            "availableLanguage": "Japanese",
            "email": "info@sumitsuzuke-tai.jp"
        },
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "神奈川県横浜市鶴見区上末吉四丁目11番4号 アネックス第一ハイムA棟102",
            "postalCode": "230-0011",
            "addressCountry": "JP"
        },
        "sameAs": [
            "https://twitter.com/sumitsuzuketai",
            "https://www.facebook.com/sumitsuzuketai"
        ]
    }
    </script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T3B4TDCC"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->