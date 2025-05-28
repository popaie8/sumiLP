<header class="site-header">
    <div class="container">
        <div class="logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="すみつづけ隊">
            </a>
        </div>
        <div class="header-contact">
            <div class="header-tel">
                <i class="fas fa-phone-alt"></i> 0120-XXX-XXX
            </div>
            <div class="header-hours">
                <span>受付時間：9:00〜19:00（年中無休）</span>
            </div>
        </div>
    </div>
</header>

<section class="firstview">
    <div class="container">
        <div class="firstview-content">
            <h1 class="main-headline">業界最大級｜リースバック一括査定サイト｜すみつづけ隊</h1>
            <p class="sub-headline">たった60秒で最大10社の査定額を比較</p>
            
            <div class="benefit-tags">
                <span class="benefit-tag">平均120%の高値売却を実現！</span>
                <span class="benefit-tag">最安値の家賃で住み続けられる</span>
            </div>
            
            <div class="firstview-form">
                <form id="quick-assessment-form" action="#" method="post">
                    <div class="form-group">
                        <label for="postal-code">郵便番号</label>
                        <input type="text" id="postal-code" name="postal-code" placeholder="例：123-4567" required>
                    </div>
                    <div class="form-group">
                        <label for="property-type">物件種別</label>
                        <select id="property-type" name="property-type" required>
                            <option value="">選択してください</option>
                            <option value="apartment">マンション</option>
                            <option value="house">一戸建て</option>
                            <option value="land">土地</option>
                            <option value="commercial">商業施設</option>
                        </select>
                    </div>
                    <button type="button" id="firstview-cta" class="cta-button">無料で査定額を比較する</button>
                </form>
                <p class="form-notice"></p>
            </div>
            
            <div class="realtime-counter">
                <i class="fas fa-chart-line"></i> 今月の査定依頼数：<span id="request-counter">3,782</span>件
            </div>
        </div>
        <div class="firstview-image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-image.jpg" alt="リースバック一括査定イメージ">
        </div>
    </div>
</section>