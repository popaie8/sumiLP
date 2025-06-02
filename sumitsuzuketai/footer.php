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

<!-- フローティングCTA（画像版） -->
<div class="floating-cta" id="floating-cta" style="display: none; opacity: 0;">
    <a href="#assessment-form" class="smooth-scroll floating-button" id="floating-button">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/floating-cta-button.png" 
             alt="無料査定をスタートする" 
             class="floating-button-image">
    </a>
</div>

<!-- 🎯 bodyスクロール専用最適化スクリプト -->
<script>
(function() {
    'use strict';
    
    console.log('🎯 bodyスクロール最適化版開始');
    
    // ===========================================
    // 🎯 bodyスクロール専用関数（シンプル・高速）
    // ===========================================
    function bodyScrollTo(targetSelector) {
        console.log('🎯 bodyスクロール実行:', targetSelector);
        
        if (!targetSelector || targetSelector === '#') return false;
        
        const target = document.querySelector(targetSelector);
        if (!target) {
            console.error('❌ ターゲット要素が見つかりません:', targetSelector);
            return false;
        }
        
        // シンプルな位置計算
        let targetPosition = 0;
        let element = target;
        
        while (element && element !== document.body) {
            targetPosition += element.offsetTop || 0;
            element = element.offsetParent;
        }
        
        const headerOffset = 100;
        const finalPosition = Math.max(0, targetPosition - headerOffset);
        
        console.log('📏 位置計算:', {
            targetPosition,
            finalPosition,
            currentBodyScroll: document.body.scrollTop
        });
        
        // 🎯 bodyスクロール専用実行（1つの方法のみ）
        try {
            // 進行中のアニメーションを停止
            if (window.scrollAnimationId) {
                cancelAnimationFrame(window.scrollAnimationId);
            }
            
            // カスタムスムーススクロール（bodyのscrollTop直接制御）
            const startPosition = document.body.scrollTop;
            const distance = finalPosition - startPosition;
            const duration = 800; // 0.8秒
            const startTime = performance.now();
            
            function easeInOutCubic(t) {
                return t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
            }
            
            function animateScroll(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easeProgress = easeInOutCubic(progress);
                
                const currentPosition = startPosition + (distance * easeProgress);
                document.body.scrollTop = currentPosition;
                
                console.log('🎯 スクロール進行:', {
                    progress: Math.round(progress * 100) + '%',
                    currentPosition: Math.round(currentPosition),
                    targetPosition: finalPosition
                });
                
                if (progress < 1) {
                    window.scrollAnimationId = requestAnimationFrame(animateScroll);
                } else {
                    console.log('✅ bodyスクロール完了');
                    window.scrollAnimationId = null;
                }
            }
            
            window.scrollAnimationId = requestAnimationFrame(animateScroll);
            
        } catch (error) {
            console.error('❌ bodyスクロールエラー:', error);
            // フォールバック: 即座移動
            document.body.scrollTop = finalPosition;
        }
        
        return true;
    }
    
    // ===========================================
    // 🎯 bodyスクロール専用イベントハンドラー
    // ===========================================
    function createBodyScrollHandler(element) {
        return function(e) {
            const href = element.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                
                console.log('🔗 bodyスクロールリンククリック:', href);
                
                // わずかな遅延で実行（他のイベントとの競合を避ける）
                setTimeout(() => {
                    bodyScrollTo(href);
                }, 10);
                
                return false;
            }
        };
    }
    
    // ===========================================
    // 🎯 スクロールリンク初期化
    // ===========================================
    function initBodyScrollLinks() {
        console.log('🎯 bodyスクロールリンク初期化');
        
        const selectors = [
            '.smooth-scroll',
            '.cta-button',
            '.floating-button',
            'a[href^="#assessment-form"]',
            'a[href^="#about-leaseback"]',
            'a[href^="#assessment-flow"]',
            'a[href^="#partner-companies"]',
            'a[href^="#faq-section"]',
            'a[href^="#what-is-leaseback"]',
            'a[href^="#benefits-section"]',
            'a[href^="#success-cases"]',
            'a[href^="#market-info"]'
        ];
        
        let totalElements = 0;
        
        selectors.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            
            elements.forEach(element => {
                const href = element.getAttribute('href');
                if (href && href.startsWith('#') && href !== '#') {
                    // 既存のイベントを完全に削除
                    const newElement = element.cloneNode(true);
                    element.parentNode.replaceChild(newElement, element);
                    
                    // bodyスクロール専用ハンドラーを設定
                    newElement.addEventListener('click', createBodyScrollHandler(newElement), true);
                    totalElements++;
                }
            });
            
            if (elements.length > 0) {
                console.log('✅ bodyスクロール設定:', selector, `(${elements.length}個)`);
            }
        });
        
        console.log('🎯 bodyスクロールリンク設定完了 - 合計:', totalElements + '個');
    }
    
    // ===========================================
    // 🎈 bodyスクロール対応フローティングCTA
    // ===========================================
    function initPerfectFloatingCTA() {
        console.log('🎈 完璧版フローティングCTA初期化');
        
        const floatingCTA = document.getElementById('floating-cta');
        if (!floatingCTA) {
            console.warn('⚠️ フローティングCTA要素が見つかりません');
            return;
        }
        
        // 強制スタイル設定
        floatingCTA.style.cssText = `
            position: fixed !important;
            bottom: 20px !important;
            right: 20px !important;
            z-index: 9999 !important;
            display: block !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transition: all 0.3s ease !important;
            pointer-events: auto !important;
        `;
        
        console.log('🎈 フローティングCTA初期スタイル設定完了');
        
        // bodyスクロール監視関数
        function handleFloatingCTA() {
            try {
                // 複数の方法でスクロール位置を取得
                const scrollMethods = [
                    () => document.body.scrollTop,
                    () => document.documentElement.scrollTop,
                    () => window.pageYOffset,
                    () => window.scrollY
                ];
                
                let scrollTop = 0;
                for (const method of scrollMethods) {
                    try {
                        const value = method();
                        if (value > scrollTop) {
                            scrollTop = value;
                        }
                    } catch (e) {
                        // 無視
                    }
                }
                
                const shouldShow = scrollTop > 300;
                
                console.log('🎈 フローティングCTA判定:', {
                    bodyScrollTop: document.body.scrollTop,
                    documentScrollTop: document.documentElement.scrollTop,
                    windowPageYOffset: window.pageYOffset,
                    maxScroll: scrollTop,
                    shouldShow
                });
                
                if (shouldShow) {
                    floatingCTA.style.opacity = '1';
                    floatingCTA.style.visibility = 'visible';
                    floatingCTA.style.transform = 'translateY(0)';
                    console.log('✅ フローティングCTA表示');
                } else {
                    floatingCTA.style.opacity = '0';
                    floatingCTA.style.visibility = 'hidden';
                    floatingCTA.style.transform = 'translateY(10px)';
                    console.log('🔒 フローティングCTA非表示');
                }
                
            } catch (error) {
                console.error('フローティングCTA処理エラー:', error);
            }
        }
        
        // 複数のスクロールイベントに対応
        const scrollTargets = [
            window,
            document,
            document.body,
            document.documentElement
        ];
        
        let scrollTicking = false;
        const throttledHandler = () => {
            if (!scrollTicking) {
                requestAnimationFrame(() => {
                    handleFloatingCTA();
                    scrollTicking = false;
                });
                scrollTicking = true;
            }
        };
        
        // 全てのスクロールターゲットにイベント設定
        scrollTargets.forEach(target => {
            try {
                if (target && target.addEventListener) {
                    target.addEventListener('scroll', throttledHandler, { passive: true });
                    console.log('✅ スクロールイベント設定:', target.constructor.name);
                }
            } catch (e) {
                console.warn('スクロールイベント設定失敗:', e);
            }
        });
        
        // 定期的な状態チェック（フォールバック）
        const intervalCheck = setInterval(() => {
            handleFloatingCTA();
        }, 1000);
        
        // 手動トリガー（デバッグ用）
        window.triggerFloatingCheck = handleFloatingCTA;
        
        // 初回表示チェック
        setTimeout(() => {
            handleFloatingCTA();
            console.log('🎈 フローティングCTA初回チェック完了');
        }, 500);
        
        // 5秒後に強制表示（テスト用）
        setTimeout(() => {
            console.log('🧪 フローティングCTA強制表示テスト');
            floatingCTA.style.opacity = '1';
            floatingCTA.style.visibility = 'visible';
            floatingCTA.style.transform = 'translateY(0)';
        }, 5000);
        
        console.log('✅ 完璧版フローティングCTA初期化完了');
    }
    
    // ===========================================
    // 🎵 軽量版アコーディオン
    // ===========================================
    function initLightAccordions() {
        console.log('🎵 軽量版アコーディオン初期化');
        
        // アコーディオンヘッダー
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', function() {
                const item = this.parentElement;
                const content = this.nextElementSibling;
                const isActive = item.classList.contains('active');
                
                // 他のアイテムを閉じる
                document.querySelectorAll('.accordion-item.active').forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                        const otherContent = otherItem.querySelector('.accordion-content');
                        if (otherContent) otherContent.style.maxHeight = '0px';
                    }
                });
                
                // 現在のアイテムを切り替え
                item.classList.toggle('active');
                content.style.maxHeight = isActive ? '0px' : content.scrollHeight + 'px';
            });
        });
        
        // 免責事項トグル
        const disclaimerToggle = document.getElementById('disclaimer-toggle');
        const disclaimerContent = document.getElementById('disclaimer-content');
        
        if (disclaimerToggle && disclaimerContent) {
            disclaimerToggle.addEventListener('click', (e) => {
                e.preventDefault();
                const isActive = disclaimerContent.classList.contains('active');
                
                disclaimerContent.classList.toggle('active');
                disclaimerContent.style.maxHeight = isActive ? '0px' : disclaimerContent.scrollHeight + 'px';
                disclaimerToggle.textContent = isActive ? '免責事項を表示' : '免責事項を隠す';
            });
        }
        
        console.log('✅ 軽量版アコーディオン完了');
    }
    
    // ===========================================
    // 🎯 メイン初期化
    // ===========================================
    function initializeBodyScroll() {
        console.log('🎯 bodyスクロール初期化開始');
        
        // 順次初期化
        setTimeout(() => initBodyScrollLinks(), 100);
        setTimeout(() => initPerfectFloatingCTA(), 300);
        setTimeout(() => initLightAccordions(), 500);
        
        console.log('✅ bodyスクロール初期化完了');
    }
    
    // DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeBodyScroll);
    } else {
        initializeBodyScroll();
    }
    
    // ===========================================
    // 🎯 グローバルフォールバック（bodyスクロール専用）
    // ===========================================
    document.addEventListener('click', (e) => {
        if (e.defaultPrevented) return;
        
        let element = e.target;
        let attempts = 0;
        
        while (element && element.tagName !== 'A' && attempts < 3) {
            element = element.parentElement;
            attempts++;
            if (!element || element === document) return;
        }
        
        if (element && element.tagName === 'A') {
            const href = element.getAttribute('href');
            if (href && href.startsWith('#') && href !== '#') {
                e.preventDefault();
                console.log('🎯 グローバルフォールバック実行:', href);
                bodyScrollTo(href);
            }
        }
    }, true);
    
    // ===========================================
    // 🎯 デバッグ関数
    // ===========================================
    
    window.bodyScroll = function(target = '#faq-section') {
        console.log('🧪 bodyスクロールテスト:', target);
        return bodyScrollTo(target);
    };
    
    window.checkBodyScroll = function() {
        console.log('🔍 bodyスクロール状態:', {
            bodyScrollTop: document.body.scrollTop,
            bodyScrollHeight: document.body.scrollHeight,
            bodyClientHeight: document.body.clientHeight,
            windowInnerHeight: window.innerHeight
        });
    };
    
    window.showFloating = function() {
        const cta = document.getElementById('floating-cta');
        if (cta) {
            cta.style.display = 'block';
            cta.style.opacity = '1';
            cta.style.visibility = 'visible';
            cta.style.transform = 'translateY(0)';
            console.log('✅ フローティングCTA手動表示');
        }
    };
    
    window.hideFloating = function() {
        const cta = document.getElementById('floating-cta');
        if (cta) {
            cta.style.opacity = '0';
            cta.style.visibility = 'hidden';
            cta.style.transform = 'translateY(10px)';
            console.log('🔒 フローティングCTA手動非表示');
        }
    };
    
    window.toggleFloating = function() {
        const cta = document.getElementById('floating-cta');
        if (cta) {
            const isVisible = cta.style.opacity === '1';
            if (isVisible) {
                window.hideFloating();
            } else {
                window.showFloating();
            }
        }
    };
    
    console.log('🎯 bodyスクロール最適化版読み込み完了');
    console.log('📋 テスト関数:');
    console.log('  - bodyScroll("#target")');
    console.log('  - checkBodyScroll()'); 
    console.log('  - showFloating() / hideFloating() / toggleFloating()');
    console.log('  - triggerFloatingCheck()');
    console.log('🎈 フローティングCTAは5秒後に強制表示されます（テスト用）');
    
})();
</script>

<!-- 🎯 bodyスクロール専用CSS -->
<style>
/* bodyスクロール最適化 */
html {
    overflow: hidden !important;
    height: 100% !important;
}

body {
    overflow-x: hidden !important;
    overflow-y: auto !important;
    height: 100vh !important;
    scroll-behavior: auto !important; /* カスタムスクロールを使用するため無効化 */
}

/* フローティングCTA */
/* 🚀 巨大・完全オーラなしフローティングCTA */
.floating-cta {
    position: fixed !important;
    bottom: 30px !important;
    right: 30px !important;
    z-index: 9999 !important;
    transform: translateY(10px) !important;
    background: none !important;
    box-shadow: none !important; /* 完全削除 */
    filter: none !important; /* 完全削除 */
}

/* メインボタン（巨大・完全オーラなし） */
.floating-button {
    position: relative !important;
    display: block !important;
    text-decoration: none !important;
    background: none !important;
    border: none !important;
    padding: 0 !important;
    margin: 0 !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    
    /* 🎯 CSS アニメ：1.0→1.05倍のscaleを3sでループ（さらに控えめ） */
    animation: giantPulseScale 3s ease-in-out infinite !important;
    
    /* 🗑️ オーラ・影・エフェクト完全削除 */
    filter: none !important;
    box-shadow: none !important;
    text-shadow: none !important;
    outline: none !important;
    border: none !important;
    background: transparent !important;
}

/* 🎯 巨大スケールアニメーション（非常に控えめ） */
@keyframes giantPulseScale {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* 🎯 タップ波紋効果（オーラなし・シンプル版） */
.floating-button::after {
    content: '' !important;
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    width: 0 !important;
    height: 0 !important;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%) !important;
    border-radius: 50% !important;
    transform: translate(-50%, -50%) !important;
    transition: all 0.5s ease-out !important;
    pointer-events: none !important;
    opacity: 0 !important;
    z-index: 1 !important;
}

.floating-button:active::after {
    width: 600px !important;
    height: 600px !important;
    opacity: 1 !important;
    transition: all 0.1s ease-out !important;
}

/* ホバー効果（完全オーラなし・巨大） */
.floating-button:hover {
    transform: translateY(-3px) scale(1.08) !important;
    animation-play-state: paused !important;
    
    /* 🗑️ 完全オーラなし */
    filter: none !important;
    box-shadow: none !important;
    text-shadow: none !important;
    outline: none !important;
}

/* 画像本体（巨大版） */
.floating-button-image {
    display: block !important;
    width: auto !important;
    height: 150px !important; /* 巨大化（120px→150px） */
    max-width: 550px !important; /* 巨大化（450px→550px） */
    border-radius: 0 !important;
    position: relative !important;
    z-index: 2 !important;
    background: transparent !important;
    
    /* 🗑️ 画像のオーラ・影完全削除 */
    filter: none !important;
    box-shadow: none !important;
    outline: none !important;
    border: none !important;
    
    /* 🎯 矢印アニメーション効果（非常に控えめ） */
    animation: giantImageSlide 4s ease-in-out infinite !important;
}

/* 🎯 巨大画像スライドアニメーション（非常に控えめ） */
@keyframes giantImageSlide {
    0%, 100% { 
        transform: translateX(0px);
    }
    25% { 
        transform: translateX(1px);
    }
    50% { 
        transform: translateX(0px);
    }
    75% { 
        transform: translateX(1px);
    }
}

/* アクティブ状態（完全オーラなし） */
.floating-button:active {
    transform: translateY(-1px) scale(1.03) !important;
    filter: none !important;
    box-shadow: none !important;
}

/* レスポンシブ対応（巨大版） */
@media (max-width: 768px) {
    .floating-cta {
        bottom: 20px !important;
        right: 20px !important;
    }
    
    .floating-button-image {
        height: 120px !important; /* タブレット用巨大（100px→120px） */
        max-width: 450px !important;
    }
    
    .floating-button:hover {
        transform: translateY(-2px) scale(1.06) !important;
    }
}

@media (max-width: 480px) {
    .floating-cta {
        bottom: 15px !important;
        right: 15px !important;
    }
    
    .floating-button-image {
        height: 100px !important; /* モバイル用巨大（80px→100px） */
        max-width: 380px !important;
    }
    
    .floating-button:hover {
        transform: translateY(-1px) scale(1.04) !important;
    }
}

/* 🎯 パフォーマンス最適化（オーラなし） */
.floating-button {
    will-change: transform !important;
    backface-visibility: hidden !important;
    perspective: 1000px !important;
}

/* 🎯 アクセシビリティ改善 */
@media (prefers-reduced-motion: reduce) {
    .floating-button {
        animation: none !important;
    }
    
    .floating-button-image {
        animation: none !important;
    }
}

/* 🗑️ 全てのオーラ・影・背景要素の完全削除（強制） */
.floating-cta,
.floating-cta::before,
.floating-cta::after,
.floating-button,
.floating-button::before,
.floating-button-image,
.floating-button-image::before,
.floating-button-image::after {
    box-shadow: none !important;
    filter: none !important;
    text-shadow: none !important;
    outline: none !important;
    border: none !important;
    background: transparent !important;
    backdrop-filter: none !important;
    -webkit-filter: none !important;
    -webkit-box-shadow: none !important;
}

/* アコーディオン */
.accordion-content {
    overflow: hidden !important;
    transition: max-height 0.3s ease !important;
}

/* パフォーマンス最適化 */
* {
    scroll-behavior: auto !important; /* カスタムスクロールのため無効化 */
}

@media (max-width: 768px) {
    .floating-button {
        font-size: 12px !important;
        padding: 10px 16px !important;
    }
}
</style>

<?php wp_footer(); ?>
</body>
</html>