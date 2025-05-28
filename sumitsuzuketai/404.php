<?php
/**
 * 404 エラーページテンプレート
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="error-404 not-found">
        <div class="container">
            <header class="page-header">
                <h1 class="page-title">ページが見つかりませんでした</h1>
            </header>

            <div class="page-content">
                <p>お探しのページが見つかりませんでした。URLが正しいか確認してください。</p>
                
                <div class="error-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
                        <i class="fas fa-home"></i> トップページに戻る
                    </a>
                    
                    <?php if (get_theme_mod('sumitsuzuketai_phone')) : ?>
                        <div class="error-contact">
                            <p>リースバックについてのご質問は、お電話でもお問い合わせいただけます：</p>
                            <a href="tel:<?php echo esc_attr(get_theme_mod('sumitsuzuketai_phone', '0120-XXX-XXX')); ?>" class="phone-link">
                                <i class="fas fa-phone-alt"></i> <?php echo esc_html(get_theme_mod('sumitsuzuketai_phone', '0120-XXX-XXX')); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();