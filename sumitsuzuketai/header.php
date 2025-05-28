<?php
/**
 * ヘッダーテンプレート
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    
    <!-- SEO最適化のためのメタタグ -->
    <meta name="description" content="リースバック一括査定サイト「すみつづけ隊」。たった60秒の入力で最大10社から査定結果を取得。平均120%の高値売却を実現し、最安値の家賃で住み続けられます。">
    <meta name="keywords" content="リースバック,一括査定,住み続ける,不動産売却,高値売却,家賃,老後資金,住宅ローン返済,相続税対策">
    
    <!-- OGP設定 -->
    <meta property="og:title" content="リースバック一括査定｜すみつづけ隊">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo home_url(); ?>">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/ogp.jpg">
    <meta property="og:site_name" content="すみつづけ隊">
    <meta property="og:description" content="リースバック一括査定サイト「すみつづけ隊」。たった60秒の入力で最大10社から査定結果を取得。平均120%の高値売却を実現し、最安値の家賃で住み続けられます。">
    
    <!-- favicon -->
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-touch-icon.png">
    
    <?php wp_head(); ?>
    
    <!-- 緊急用直接CSS読み込み（デバッグ用） -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/main.css?v=<?php echo time(); ?>">
    
    <!-- 構造化データ -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "すみつづけ隊",
        "url": "<?php echo home_url(); ?>",
        "logo": "<?php echo get_template_directory_uri(); ?>/assets/images/logo.png",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "0120-XXX-XXX",
            "contactType": "customer service",
            "availableLanguage": "Japanese"
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