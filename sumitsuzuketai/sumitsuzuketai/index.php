<?php
/**
 * メインテンプレートファイル
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    // ヘッダー/ファーストビュー
    get_template_part('template-parts/header-firstview');
    
    // ユーザーメリット訴求セクション
    get_template_part('template-parts/user-benefits');
    
    // 信頼性構築要素（提携会社一覧）
    get_template_part('template-parts/partner-companies');
    
    // 3ステッププロセス説明
    get_template_part('template-parts/process-steps');
    
    // 成功事例セクション
    get_template_part('template-parts/success-cases');
    
    // リアルタイム査定状況
    get_template_part('template-parts/realtime-status');
    
    // フォーム最適化と緊急性訴求
    get_template_part('template-parts/main-form');
    
    // オブジェクション対応（FAQ）
    get_template_part('template-parts/faq');
    
    // 専任コンシェルジュ紹介
    get_template_part('template-parts/concierge');
    
    // 情報コンテンツ（SEO対策）
    get_template_part('template-parts/seo-content');
    
    // ユーザーレビュー
    get_template_part('template-parts/reviews');
    
    // 最終CTA
    get_template_part('template-parts/final-cta');
    ?>
</main>

<?php
get_footer();