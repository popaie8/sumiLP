<footer class="site-footer">
    <div class="container">
        <div class="footer-top">
            <div class="footer-logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-white.png" alt="すみつづけ隊">
                <p class="footer-tagline">リースバック一括査定サイト</p>
            </div>

            <div class="footer-contact">
                <div class="footer-tel">
                    <i class="fas fa-phone-alt"></i> 
                    <a href="tel:05058105875" class="tel-link">050-5810-5875</a>
                </div>
                <div class="footer-hours">
                    <span>受付時間：9:00〜19:00（年中無休）</span>
                </div>
            </div>
        </div>

        <!-- アコーディオン形式のフッターメニュー -->
        <div class="footer-accordion">
            <div class="accordion-item">
                <div class="accordion-header">
                    <h3>サービス案内</h3>
                    <span class="accordion-icon"></span>
                </div>
                <div class="accordion-content">
                    <ul>
                        <li><a href="#about-leaseback" class="smooth-scroll">リースバック一括査定とは</a></li>
                        <li><a href="#assessment-flow" class="smooth-scroll">査定の流れ</a></li>
                        <li><a href="#partner-companies" class="smooth-scroll">提携会社一覧</a></li>
                        <li><a href="#faq-section" class="smooth-scroll">よくある質問</a></li>
                    </ul>
                </div>
            </div>

            <div class="accordion-item">
                <div class="accordion-header">
                    <h3>お役立ち情報</h3>
                    <span class="accordion-icon"></span>
                </div>
                <div class="accordion-content">
                    <ul>
                        <li><a href="#what-is-leaseback" class="smooth-scroll">リースバックとは</a></li>
                        <li><a href="#benefits-section" class="smooth-scroll">リースバックのメリット・デメリット</a></li>
                        <li><a href="#success-cases" class="smooth-scroll">リースバック成功事例</a></li>
                        <li><a href="#market-info" class="smooth-scroll">リースバック相場情報</a></li>
                    </ul>
                </div>
            </div>

            <div class="accordion-item">
                <div class="accordion-header">
                    <h3>会社情報</h3>
                    <span class="accordion-icon"></span>
                </div>
                <div class="accordion-content">
                    <ul>
                        <li><a href="<?php echo home_url('/company/'); ?>" target="_blank">会社概要</a></li>
                        <li><a href="<?php echo home_url('/privacy/'); ?>" target="_blank">プライバシーポリシー</a></li>
                        <li><a href="<?php echo home_url('/terms/'); ?>" target="_blank">利用規約</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="disclaimer-link">
                <a href="#" id="disclaimer-toggle">免責事項を表示</a>
            </div>
            
            <div class="disclaimer" id="disclaimer-content">
                <p>当サイトは最適なリースバック会社をご紹介するサービスです。査定結果や成約を保証するものではありません。表示されている事例や数値は過去の実績に基づくものであり、将来の成果を保証するものではありません。提携会社数や査定会社数は時期により変動する場合があります。</p>
            </div>

            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> 住み続け隊 All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- フローティングCTA -->
<div class="floating-cta" id="floating-cta" style="display: none; opacity: 0;">
    <a href="#assessment-form" class="smooth-scroll floating-button" id="floating-button">
        <i class="fas fa-calculator"></i> 無料査定をスタートする
    </a>
</div>

<!-- 🔥 完全動作版JavaScript（最終版） -->
<script>
(function() {
    'use strict';
    
    console.log('🚀 完全版フッタースクリプト開始');
    
    // 🔥 STEP 1: 完璧なスムーススクロール関数
    function perfectSmoothScroll(targetSelector) {
        console.log('📍 スクロール要求:', targetSelector);
        
        // 空のハッシュや無効なハッシュを除外
        if (!targetSelector || targetSelector === '#' || targetSelector === '#top' || targetSelector === '') {
            console.warn('⚠️ 無効なターゲット:', targetSelector);
            return false;
        }
        
        // ターゲット要素を検索
        var target = document.querySelector(targetSelector);
        if (!target) {
            console.warn('⚠️ ターゲット要素が見つかりません:', targetSelector);
            return false;
        }
        
        console.log('✅ ターゲット要素発見:', target);
        
        // スクロール位置計算
        var headerOffset = 100; // ヘッダー分のオフセット
        var elementPosition = target.getBoundingClientRect().top;
        var offsetPosition = elementPosition + window.pageYOffset - headerOffset;
        
        console.log('📏 スクロール計算:', {
            elementPosition: elementPosition,
            pageYOffset: window.pageYOffset,
            offsetPosition: offsetPosition
        });
        
        // 複数の方法でスムーススクロール実行
        try {
            // 方法1: ネイティブスムーススクロール
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
            
            // 方法2: jQueryフォールバック
            if (typeof jQuery !== 'undefined') {
                jQuery('html, body').animate({
                    scrollTop: offsetPosition
                }, 800);
            }
            
            console.log('✅ スクロール実行成功:', targetSelector);
            return true;
            
        } catch (error) {
            console.error('❌ スクロールエラー:', error);
            return false;
        }
    }
    
    // 🔥 STEP 2: 統一スクロールイベントハンドラー
    function createScrollHandler(element) {
        return function(e) {
            var href = element.getAttribute('href');
            
            // ハッシュリンクのみ処理
            if (href && href.startsWith('#')) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                
                console.log('🔗 スムーススクロールクリック:', href);
                
                // 少し遅延して確実に実行
                setTimeout(function() {
                    perfectSmoothScroll(href);
                }, 50);
                
                return false;
            }
        };
    }
    
    // 🔥 STEP 3: DOMContentLoaded での初期化
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔄 DOM読み込み完了 - 初期化開始');
        
        // 少し遅延して確実に要素が存在する状態で実行
        setTimeout(function() {
            initializeScrolling();
        }, 300);
        
        setTimeout(function() {
            initializeFloatingCTA();
        }, 600);
        
        setTimeout(function() {
            initializeAccordions();
        }, 900);
    });
    
    // 🔥 STEP 4: スクロール機能初期化
    function initializeScrolling() {
        console.log('📜 スクロール機能初期化開始');
        
        // すべてのスムーススクロール対象セレクタ
        var smoothScrollSelectors = [
            '.smooth-scroll',
            '.cta-button',
            '.floating-button',
            '.submit-button-link',
            '.btn-cta',
            'a[href^="#assessment-form"]',
            'a[href^="#about-leaseback"]',
            'a[href^="#assessment-flow"]',
            'a[href^="#partner-companies"]',
            'a[href^="#faq-section"]',
            'a[href^="#what-is-leaseback"]',
            'a[href^="#benefits-section"]',
            'a[href^="#success-cases"]',
            'a[href^="#market-info"]',
            'a[href^="#hero-section"]',
            'a[href^="#features-section"]'
        ];
        
        var totalElements = 0;
        
        smoothScrollSelectors.forEach(function(selector) {
            var elements = document.querySelectorAll(selector);
            
            elements.forEach(function(element) {
                // 既存のイベントを削除
                var newElement = element.cloneNode(true);
                element.parentNode.replaceChild(newElement, element);
                
                // 新しいイベントハンドラーを追加
                var handler = createScrollHandler(newElement);
                
                // 複数のイベントで確実にキャッチ
                newElement.addEventListener('click', handler, true);
                newElement.addEventListener('mousedown', handler, true);
                newElement.addEventListener('touchstart', handler, { passive: false });
                
                totalElements++;
            });
            
            if (elements.length > 0) {
                console.log('✅ スクロール設定完了:', selector, '(' + elements.length + '個)');
            }
        });
        
        console.log('🎯 全スクロール要素設定完了 - 合計:', totalElements + '個');
    }
    
    // 🔥 STEP 5: フローティングCTA初期化
    function initializeFloatingCTA() {
        console.log('🎈 フローティングCTA初期化開始');
        
        var floatingCta = document.getElementById('floating-cta');
        var floatingButton = document.getElementById('floating-button');
        
        if (!floatingCta || !floatingButton) {
            console.warn('⚠️ フローティングCTA要素が見つかりません');
            return;
        }
        
        // 表示制御関数
        function handleFloatingDisplay() {
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 300) {
                floatingCta.style.display = 'block';
                floatingCta.style.opacity = '1';
                floatingCta.style.visibility = 'visible';
            } else {
                floatingCta.style.display = 'none';
                floatingCta.style.opacity = '0';
                floatingCta.style.visibility = 'hidden';
            }
        }
        
        // スクロールイベント
        window.addEventListener('scroll', handleFloatingDisplay);
        handleFloatingDisplay(); // 初期状態設定
        
        // フローティングボタンのクリック処理
        var newFloatingButton = floatingButton.cloneNode(true);
        floatingButton.parentNode.replaceChild(newFloatingButton, floatingButton);
        
        var floatingHandler = createScrollHandler(newFloatingButton);
        newFloatingButton.addEventListener('click', floatingHandler, true);
        newFloatingButton.addEventListener('touchstart', floatingHandler, { passive: false });
        
        console.log('✅ フローティングCTA設定完了');
    }
    
    // 🔥 STEP 6: アコーディオン機能初期化
    function initializeAccordions() {
        console.log('🎵 アコーディオン機能初期化開始');
        
        // アコーディオンヘッダーイベント
        var accordionHeaders = document.querySelectorAll('.accordion-header');
        accordionHeaders.forEach(function(header) {
            header.addEventListener('click', function() {
                var item = this.parentElement;
                var isActive = item.classList.contains('active');
                var content = this.nextElementSibling;
                
                // 他のアクティブなアイテムを閉じる
                document.querySelectorAll('.accordion-item').forEach(function(otherItem) {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                        var otherContent = otherItem.querySelector('.accordion-content');
                        otherContent.style.maxHeight = '0px';
                        otherContent.style.padding = '0 20px';
                    }
                });
                
                // クリックしたアイテムの状態を切り替え
                if (isActive) {
                    item.classList.remove('active');
                    content.style.maxHeight = '0px';
                    content.style.padding = '0 20px';
                } else {
                    item.classList.add('active');
                    content.style.maxHeight = content.scrollHeight + 'px';
                    content.style.padding = '0 20px 15px';
                }
            });
        });
        
        // 免責事項トグル
        var disclaimerToggle = document.getElementById('disclaimer-toggle');
        var disclaimerContent = document.getElementById('disclaimer-content');
        
        if (disclaimerToggle && disclaimerContent) {
            disclaimerToggle.addEventListener('click', function(e) {
                e.preventDefault();
                var isActive = disclaimerContent.classList.contains('active');
                
                if (isActive) {
                    disclaimerContent.classList.remove('active');
                    disclaimerContent.style.maxHeight = '0px';
                    disclaimerContent.style.margin = '0';
                    this.textContent = '免責事項を表示';
                } else {
                    disclaimerContent.classList.add('active');
                    disclaimerContent.style.maxHeight = disclaimerContent.scrollHeight + 'px';
                    disclaimerContent.style.margin = '0 0 15px';
                    this.textContent = '免責事項を隠す';
                }
            });
        }
        
        // レスポンシブ調整
        function adjustAccordions() {
            if (window.innerWidth >= 769) {
                // デスクトップ：すべて開く
                document.querySelectorAll('.accordion-item').forEach(function(item) {
                    item.classList.add('active');
                    var content = item.querySelector('.accordion-content');
                    if (content) {
                        content.style.maxHeight = 'none';
                        content.style.padding = '0';
                    }
                });
                
                if (disclaimerContent) {
                    disclaimerContent.classList.add('active');
                    disclaimerContent.style.maxHeight = 'none';
                    disclaimerContent.style.margin = '0 0 15px';
                }
            } else {
                // モバイル：すべて閉じる
                document.querySelectorAll('.accordion-item').forEach(function(item) {
                    item.classList.remove('active');
                    var content = item.querySelector('.accordion-content');
                    if (content) {
                        content.style.maxHeight = '0px';
                        content.style.padding = '0 20px';
                    }
                });
                
                if (disclaimerContent) {
                    disclaimerContent.classList.remove('active');
                    disclaimerContent.style.maxHeight = '0px';
                    disclaimerContent.style.margin = '0';
                    if (disclaimerToggle) {
                        disclaimerToggle.textContent = '免責事項を表示';
                    }
                }
            }
        }
        
        adjustAccordions();
        
        var resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(adjustAccordions, 200);
        });
        
        console.log('✅ アコーディオン設定完了');
    }
    
    // 🔥 STEP 7: グローバルフォールバック
    document.addEventListener('click', function(e) {
        var target = e.target;
        var link = null;
        
        // クリックされた要素またはその親要素でリンクを探す
        var maxDepth = 5;
        var depth = 0;
        
        while (target && target !== document && depth < maxDepth) {
            if (target.tagName === 'A' && target.getAttribute('href')) {
                link = target;
                break;
            }
            target = target.parentElement;
            depth++;
        }
        
        if (link) {
            var href = link.getAttribute('href');
            
            if (href && href.startsWith('#') && href !== '#' && href !== '#top') {
                // まだ処理されていない場合のフォールバック
                setTimeout(function() {
                    if (!e.defaultPrevented) {
                        console.log('🔄 グローバルフォールバック実行:', href);
                        e.preventDefault();
                        perfectSmoothScroll(href);
                    }
                }, 100);
            }
        }
    }, true);
    
    // 🔥 STEP 8: テスト用関数
    window.testPerfectScrolling = function() {
        console.log('🧪 完全スクロールテスト開始');
        
        var testTargets = [
            '#assessment-form',
            '#about-leaseback',
            '#faq-section',
            '#benefits-section'
        ];
        
        testTargets.forEach(function(target, index) {
            setTimeout(function() {
                console.log('🎯 テスト:', target);
                perfectSmoothScroll(target);
            }, index * 3000);
        });
        
        console.log('🎉 テスト完了予定:', (testTargets.length * 3) + '秒後');
    };
    
    // 強制スクロール関数
    window.forceScroll = function(target) {
        target = target || '#assessment-form';
        console.log('💪 強制スクロール:', target);
        return perfectSmoothScroll(target);
    };
    
    // ページ読み込み完了時の最終チェック
    window.addEventListener('load', function() {
        setTimeout(function() {
            console.log('🎊 ページ読み込み完了 - 最終初期化');
            
            // 最終的なスクロール設定チェック
            var scrollElements = document.querySelectorAll('.smooth-scroll, .cta-button, .floating-button');
            console.log('📊 最終スクロール要素数:', scrollElements.length);
            
            // 不足があれば再初期化
            if (scrollElements.length < 5) {
                console.log('🔧 再初期化実行');
                initializeScrolling();
            }
        }, 1000);
    });
    
    console.log('🚀 完全版フッタースクリプト読み込み完了');
    console.log('📋 利用可能な関数: testPerfectScrolling(), forceScroll("#target")');
    
})();
</script>

<?php wp_footer(); ?>
</body>
</html>