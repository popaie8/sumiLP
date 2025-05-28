<?php
/**
 * Template Name: リースバックLP
 * 
 * リースバック一括査定LPのテンプレート
 */
get_header();
?>
<main id="primary" class="site-main lp-template">
    <?php
    // テンプレートパーツの配列
    $template_parts = [
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
        'final-cta'
    ];
    
    // 各テンプレートパーツを読み込む
    foreach ($template_parts as $part) {
        $template_path = get_template_directory() . '/template-parts/' . $part . '.php';
        
        if (WP_DEBUG) {
            echo "<!-- テンプレート読み込み試行: $part -->";
        }
        
        if (file_exists($template_path)) {
            include($template_path);
            
            if (WP_DEBUG) {
                echo "<!-- テンプレート読み込み成功: $part -->";
            }
        } else {
            if (WP_DEBUG) {
                echo "<!-- テンプレートファイルが見つかりません: $template_path -->";
            }
        }
    }
    ?>
</main>
<?php
get_footer();