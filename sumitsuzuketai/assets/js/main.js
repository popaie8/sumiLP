document.addEventListener('DOMContentLoaded', function() {
    // リアルタイムカウンター自動増加
    const requestCounter = document.getElementById('request-counter');
    if (requestCounter) {
        const currentValue = parseInt(requestCounter.textContent.replace(/,/g, ''));
        setInterval(function() {
            // 1〜3をランダムに加算
            const increment = Math.floor(Math.random() * 3) + 1;
            const newValue = currentValue + increment;
            requestCounter.textContent = newValue.toLocaleString();
        }, 15000); // 15秒ごと
    }
    
    // カウントダウンタイマー
    const hours = document.getElementById('hours');
    const minutes = document.getElementById('minutes');
    const seconds = document.getElementById('seconds');
    
    if (hours && minutes && seconds) {
        let hoursValue = parseInt(hours.textContent);
        let minutesValue = parseInt(minutes.textContent);
        let secondsValue = parseInt(seconds.textContent);
        
        const countdownTimer = setInterval(function() {
            secondsValue--;
            
            if (secondsValue < 0) {
                secondsValue = 59;
                minutesValue--;
                
                if (minutesValue < 0) {
                    minutesValue = 59;
                    hoursValue--;
                    
                    if (hoursValue < 0) {
                        // タイマーをリセット
                        hoursValue = 4;
                        minutesValue = 32;
                        secondsValue = 15;
                    }
                }
            }
            
            hours.textContent = hoursValue.toString().padStart(2, '0');
            minutes.textContent = minutesValue.toString().padStart(2, '0');
            seconds.textContent = secondsValue.toString().padStart(2, '0');
        }, 1000);
    }
    
    // 残りスロット数減少
    const remainingSlots = document.getElementById('remaining-slots');
    const premiumSlots = document.getElementById('premium-slots');
    
    if (remainingSlots) {
        let slotsValue = parseInt(remainingSlots.textContent);
        
        setInterval(function() {
            // 10%の確率で1減少
            if (Math.random() < 0.1 && slotsValue > 1) {
                slotsValue--;
                remainingSlots.textContent = slotsValue;
            }
        }, 30000); // 30秒ごと
    }
    
    if (premiumSlots) {
        let premiumValue = parseInt(premiumSlots.textContent);
        
        setInterval(function() {
            // 15%の確率で1減少
            if (Math.random() < 0.15 && premiumValue > 1) {
                premiumValue--;
                premiumSlots.textContent = premiumValue;
            }
        }, 40000); // 40秒ごと
    }
    
    // リアルタイム査定状況の動的更新
    const activityList = document.getElementById('realtime-activity-list');
    
    if (activityList) {
        // 地域名の配列
        const areas = ['東京都', '大阪府', '神奈川県', '埼玉県', '千葉県', '愛知県', '福岡県', '北海道', '京都府', '兵庫県'];
        // 物件タイプの配列
        const propertyTypes = ['マンション', '一戸建て', '土地', 'アパート'];
        
        setInterval(function() {
            // ランダムなデータ生成
            const area = areas[Math.floor(Math.random() * areas.length)];
            const type = propertyTypes[Math.floor(Math.random() * propertyTypes.length)];
            const minutes = Math.floor(Math.random() * 15) + 1;
            const companies = Math.floor(Math.random() * 5) + 6; // 6〜10社
            const difference = Math.floor(Math.random() * 15) + 15; // 15〜30%
            
            // 新しいアクティビティアイテム作成
            const newItem = document.createElement('div');
            newItem.className = 'activity-item';
            newItem.innerHTML = `
                <div class="activity-icon">
                    <i class="fas fa-${type === 'マンション' || type === 'アパート' ? 'building' : 'home'}"></i>
                </div>
                <div class="activity-content">
                    <p class="activity-desc">${area}・${type}・${minutes}分前に査定完了</p>
                    <div class="activity-result">
                        <span class="result-badge">${companies}社から回答</span>
                        <span class="result-diff">最高値と最安値で${difference}%の差</span>
                    </div>
                </div>
            `;
            
            // 最初の子要素を削除
            if (activityList.children.length >= 3) {
                activityList.removeChild(activityList.children[2]);
            }
            
            // 最新のアイテムを先頭に追加
            activityList.insertBefore(newItem, activityList.firstChild);
        }, 20000); // 20秒ごと
    }
    
    // 現在の閲覧者数ランダム変動
    const currentViewers = document.getElementById('current-viewers');
    if (currentViewers) {
        let viewersValue = parseInt(currentViewers.textContent);
        
        setInterval(function() {
            // -2〜+3のランダムな変動
            const change = Math.floor(Math.random() * 6) - 2;
            viewersValue += change;
            
            // 最小値は50、最大値は120
            viewersValue = Math.max(50, Math.min(viewersValue, 120));
            
            currentViewers.textContent = viewersValue;
        }, 10000); // 10秒ごと
    }
    
    // フォームステップ切り替え
    const nextButtons = document.querySelectorAll('.next-step-button');
    const prevButtons = document.querySelectorAll('.prev-step-button');
    
    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const currentStep = document.getElementById(`form-step-${button.dataset.step - 1}`);
            const nextStep = document.getElementById(`form-step-${button.dataset.step}`);
            
            if (currentStep) currentStep.style.display = 'none';
            if (nextStep) nextStep.style.display = 'block';
        });
    });
    
    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            const currentStep = document.getElementById(`form-step-${button.dataset.step}`);
            const prevStep = document.getElementById(`form-step-${button.dataset.step - 1}`);
            
            if (currentStep) currentStep.style.display = 'none';
            if (prevStep) prevStep.style.display = 'block';
        });
    });
    
    // よくある質問アコーディオン
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        if (question) {
            question.addEventListener('click', function() {
                // 現在開いている質問を閉じる
                faqItems.forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                    }
                });
                
                // クリックした質問の状態を切り替え
                item.classList.toggle('active');
            });
        }
    });
    
    // 離脱意図検知（Exit Intent）
    let exitShown = false;
    const exitPopup = document.getElementById('exit-intent-popup');
    const closePopup = document.getElementById('popup-close');
    
    if (exitPopup && closePopup) {
        document.addEventListener('mouseleave', function(e) {
            if (e.clientY < 0 && !exitShown && window.innerWidth >= 769) {
                exitPopup.style.display = 'block';
                exitShown = true;
            }
        });
        
        closePopup.addEventListener('click', function() {
            exitPopup.style.display = 'none';
        });
        
        // ポップアップ外をクリックしても閉じる
        exitPopup.addEventListener('click', function(e) {
            if (e.target === exitPopup) {
                exitPopup.style.display = 'none';
            }
        });
    }
    
    // フォームの途中経過保存（メモリベース）
    const formInputs = document.querySelectorAll('#multi-step-form input, #multi-step-form select');
    const formData = {}; // メモリ内でデータを保持
    
    formInputs.forEach(input => {
        // 保存されたデータがあれば復元
        if (formData[input.name]) {
            input.value = formData[input.name];
        }
        
        // 入力値の変更を保存
        input.addEventListener('change', function() {
            formData[input.name] = input.value;
        });
    });
    
    // 🔥 修正: フローティングCTA表示制御を統合（重複削除）
    // ※ footer.phpの完全版スクリプトに統合済みのため、こちらは削除
    
    // 疑似リアルタイム通知ポップアップ
    const notificationNames = ['田中', '佐藤', '鈴木', '高橋', '渡辺', '伊藤', '山本', '中村', '小林', '加藤'];
    
    function showNotification() {
        // 既存の通知があれば削除
        const existingNotification = document.querySelector('.realtime-notification');
        if (existingNotification) {
            document.body.removeChild(existingNotification);
        }
        
        // ランダムデータ生成
        const name = notificationNames[Math.floor(Math.random() * notificationNames.length)];
        const minutes = Math.floor(Math.random() * 10) + 1;
        
        // 通知要素作成
        const notification = document.createElement('div');
        notification.className = 'realtime-notification';
        notification.innerHTML = `
            <div class="notification-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="notification-content">
                <p>${name}さんが${minutes}分前に査定依頼しました</p>
            </div>
            <div class="notification-close">
                <i class="fas fa-times"></i>
            </div>
        `;
        
        // スタイル設定
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #fff;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            z-index: 998;
            animation: slideIn 0.5s ease-out;
            max-width: 300px;
        `;
        
        // アニメーションスタイル
        if (!document.getElementById('notification-style')) {
            const style = document.createElement('style');
            style.id = 'notification-style';
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(-100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                
                @keyframes slideOut {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(-100%); opacity: 0; }
                }
                
                .realtime-notification .notification-icon {
                    margin-right: 10px;
                    font-size: 24px;
                    color: #0066cc;
                }
                
                .realtime-notification .notification-content p {
                    margin: 0;
                    font-size: 14px;
                    line-height: 1.4;
                }
                
                .realtime-notification .notification-close {
                    margin-left: 15px;
                    cursor: pointer;
                    color: #999;
                    font-size: 12px;
                }
                
                .realtime-notification .notification-close:hover {
                    color: #333;
                }
                
                @media (max-width: 768px) {
                    .realtime-notification {
                        bottom: 80px !important;
                        left: 10px !important;
                        right: 10px !important;
                        max-width: none !important;
                    }
                }
            `;
            
            document.head.appendChild(style);
        }
        
        document.body.appendChild(notification);
        
        // 閉じるボタンの処理
        const closeButton = notification.querySelector('.notification-close');
        closeButton.addEventListener('click', function() {
            notification.style.animation = 'slideOut 0.5s ease-out';
            setTimeout(function() {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 500);
        });
        
        // 一定時間後に自動で閉じる
        setTimeout(function() {
            if (document.body.contains(notification)) {
                notification.style.animation = 'slideOut 0.5s ease-out';
                setTimeout(function() {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 500);
            }
        }, 5000);
    }
    
    // 60〜120秒ごとにランダム通知を表示
    setInterval(function() {
        showNotification();
    }, Math.floor(Math.random() * 60000) + 60000);
    
    // 初回読み込み時に5秒後に一度表示
    setTimeout(showNotification, 5000);
});

// jQueryも使用
jQuery(document).ready(function($) {
    // ファーストビューのボタンクリック時の処理
    $('#firstview-cta').on('click', function(e) {
        e.preventDefault();
        
        // 入力値を取得
        const postalCode = $('#postal-code').val();
        const propertyType = $('#property-type').val();
        
        // 3ステップフォームへスクロール（完全版スクリプトに委任）
        if (window.forceScroll) {
            window.forceScroll('#assessment-form');
        } else {
            $('html, body').animate({
                scrollTop: $('#assessment-form').offset().top - 80
            }, 500);
        }
        
        // フォームに値を設定
        setTimeout(function() {
            $('#postal-code-full').val(postalCode);
            $('#property-type-full').val(propertyType);
        }, 500);
    });
    
    // 3ステップフォームのナビゲーション
    $('.next-step-button, .prev-step-button').on('click', function() {
        const currentStep = $(this).closest('.form-step');
        const targetStep = $('#form-step-' + $(this).data('step'));
        
        currentStep.hide();
        targetStep.fadeIn(300);
    });
});