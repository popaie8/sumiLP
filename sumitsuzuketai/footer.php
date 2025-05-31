<footer class="site-footer">
    <div class="container">
        <div class="footer-top">
            <div class="footer-logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-white.png" alt="すみつづけ隊">
                <p class="footer-tagline">リースバック一括査定サイト</p>
            </div>

            <div class="footer-contact">
                <div class="footer-tel">
                    <i class="fas fa-phone-alt"></i> 050-5810-5875
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
<div class="floating-cta" id="floating-cta">
    <a href="#assessment-form" class="smooth-scroll floating-button">
        <i class="fas fa-calculator"></i> 無料査定をスタートする
    </a>
</div>

<!-- 退出意図ポップアップ -->
<div class="exit-intent-popup" id="exit-intent-popup">
    <div class="popup-content">
        <div class="popup-close" id="popup-close">
            <i class="fas fa-times"></i>
        </div>
        <h3 class="popup-title">このページを離れようとしています</h3>
        <p class="popup-subtitle">査定額を確認する最後のチャンスです！</p>
        <div class="popup-form">
            <input type="text" id="popup-zipcode" placeholder="郵便番号（例：123-4567）" class="popup-input" maxlength="8">
            <button class="popup-button" id="popup-start-button">査定をスタート</button>
        </div>
        <p class="popup-note">※入力は60秒で完了します。完全無料です。</p>
    </div>
</div>

<!-- フッター用JavaScript -->
<script>
// フッターアコーディオン機能
document.addEventListener('DOMContentLoaded', function() {
    // アコーディオンヘッダーのクリックイベント
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
    
    // 免責事項トグルのクリックイベント
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
    
    // 退出意図ポップアップの機能
    var exitIntentPopup = document.getElementById('exit-intent-popup');
    var popupClose = document.getElementById('popup-close');
    var popupStartButton = document.getElementById('popup-start-button');
    var popupZipcode = document.getElementById('popup-zipcode');
    var hasShownPopup = false;
    
    // マウスが画面上部に移動した時にポップアップを表示
    document.addEventListener('mouseleave', function(e) {
        if (e.clientY < 0 && !hasShownPopup) {
            showExitIntentPopup();
        }
    });
    
    // モバイル用：スクロールアップ検知
    var lastScrollTop = 0;
    var scrollUpCount = 0;
    
    window.addEventListener('scroll', function() {
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // 上にスクロールした場合
        if (scrollTop < lastScrollTop && scrollTop < 100) {
            scrollUpCount++;
            // 3回連続で上スクロールした場合にポップアップ表示
            if (scrollUpCount >= 3 && !hasShownPopup) {
                setTimeout(function() {
                    if (!hasShownPopup) {
                        showExitIntentPopup();
                    }
                }, 1000);
            }
        } else {
            scrollUpCount = 0;
        }
        
        lastScrollTop = scrollTop;
        
        // フローティングCTAの表示制御
        var floatingCta = document.getElementById('floating-cta');
        if (floatingCta) {
            if (scrollTop > 300) {
                floatingCta.style.display = 'block';
            } else {
                floatingCta.style.display = 'none';
            }
        }
    });
    
    function showExitIntentPopup() {
        if (!hasShownPopup && exitIntentPopup) {
            exitIntentPopup.style.display = 'block';
            setTimeout(function() {
                exitIntentPopup.classList.add('show');
            }, 10);
            hasShownPopup = true;
        }
    }
    
    function hideExitIntentPopup() {
        if (exitIntentPopup) {
            exitIntentPopup.classList.remove('show');
            setTimeout(function() {
                exitIntentPopup.style.display = 'none';
            }, 300);
        }
    }
    
    // ポップアップを閉じる
    if (popupClose) {
        popupClose.addEventListener('click', hideExitIntentPopup);
    }
    
    // ポップアップ外をクリックで閉じる
    if (exitIntentPopup) {
        exitIntentPopup.addEventListener('click', function(e) {
            if (e.target === exitIntentPopup) {
                hideExitIntentPopup();
            }
        });
    }
    
    // 郵便番号の入力フォーマット（日本の郵便番号形式）
    if (popupZipcode) {
        popupZipcode.addEventListener('input', function(e) {
            var value = e.target.value.replace(/[^\d]/g, '');
            if (value.length > 3) {
                value = value.slice(0, 3) + '-' + value.slice(3, 7);
            }
            e.target.value = value;
        });
        
        // Enterキーで査定開始
        popupZipcode.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                startAssessmentFromPopup();
            }
        });
    }
    
    // 査定開始ボタンのクリック
    if (popupStartButton) {
        popupStartButton.addEventListener('click', function(e) {
            e.preventDefault();
            startAssessmentFromPopup();
        });
    }
    
    function startAssessmentFromPopup() {
        var zipcode = popupZipcode ? popupZipcode.value.trim() : '';
        
        if (!zipcode) {
            alert('郵便番号を入力してください');
            if (popupZipcode) popupZipcode.focus();
            return;
        }
        
        // 郵便番号の形式チェック（簡易版）
        var zipcodePattern = /^\d{3}-?\d{4}$/;
        if (!zipcodePattern.test(zipcode)) {
            alert('正しい郵便番号を入力してください（例：123-4567）');
            if (popupZipcode) popupZipcode.focus();
            return;
        }
        
        // ハイフンを追加（ない場合）
        if (zipcode.length === 7 && zipcode.indexOf('-') === -1) {
            zipcode = zipcode.slice(0, 3) + '-' + zipcode.slice(3);
        }
        
        // メインフォームに郵便番号を反映
        var mainZipcodeFields = [
            document.querySelector('#assessment-form input[name="zipcode"]'),
            document.querySelector('#assessment-form input[placeholder*="郵便番号"]'),
            document.querySelector('input[name="postal_code"]'),
            document.querySelector('input[id*="zipcode"]'),
            document.querySelector('input[id*="postal"]')
        ];
        
        var targetField = null;
        for (var i = 0; i < mainZipcodeFields.length; i++) {
            if (mainZipcodeFields[i]) {
                targetField = mainZipcodeFields[i];
                break;
            }
        }
        
        if (targetField) {
            targetField.value = zipcode;
            
            // 視覚的なハイライト効果
            targetField.style.backgroundColor = '#fff3cd';
            targetField.style.transition = 'background-color 0.3s ease';
            
            setTimeout(function() {
                targetField.style.backgroundColor = '';
            }, 2000);
            
            // フォーカスを当てる
            setTimeout(function() {
                targetField.focus();
                targetField.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'center'
                });
            }, 300);
        }
        
        // ポップアップを閉じる
        hideExitIntentPopup();
        
        // 査定フォームまでスムーススクロール
        var assessmentForm = document.getElementById('assessment-form') || 
                           document.querySelector('.assessment-form') ||
                           document.querySelector('form');
        
        if (assessmentForm) {
            setTimeout(function() {
                assessmentForm.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 500);
        }
        
        // Google Analytics イベント送信（もしGAが設定されている場合）
        if (typeof gtag !== 'undefined') {
            gtag('event', 'popup_form_submit', {
                'event_category': 'engagement',
                'event_label': 'exit_intent_popup'
            });
        }
    }
    
    // ページ読み込み時にデスクトップとモバイル表示を調整
    function adjustAccordions() {
        if (window.innerWidth >= 769) {
            // デスクトップ表示：すべて開く
            document.querySelectorAll('.accordion-item').forEach(function(item) {
                item.classList.add('active');
                var content = item.querySelector('.accordion-content');
                if (content) {
                    content.style.maxHeight = 'none';
                    content.style.padding = '0';
                }
            });
            
            // 免責事項も表示
            if (disclaimerContent) {
                disclaimerContent.classList.add('active');
                disclaimerContent.style.maxHeight = 'none';
                disclaimerContent.style.margin = '0 0 15px';
            }
        } else {
            // モバイル表示：すべて閉じる
            document.querySelectorAll('.accordion-item').forEach(function(item) {
                item.classList.remove('active');
                var content = item.querySelector('.accordion-content');
                if (content) {
                    content.style.maxHeight = '0px';
                    content.style.padding = '0 20px';
                }
            });
            
            // 免責事項も閉じる
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
    
    // 初期化実行
    adjustAccordions();
    
    // リサイズ時の処理（デバウンス付き）
    var resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(adjustAccordions, 200);
    });
    
    // フローティングCTAのスムーススクロール
    var floatingButton = document.querySelector('.floating-button');
    if (floatingButton) {
        floatingButton.addEventListener('click', function(e) {
            var href = this.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                var target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    }
});

// スムーススクロール機能（smooth-scrollクラス用）
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('smooth-scroll')) {
        e.preventDefault();
        var href = e.target.getAttribute('href');
        if (href && href.startsWith('#')) {
            var target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>