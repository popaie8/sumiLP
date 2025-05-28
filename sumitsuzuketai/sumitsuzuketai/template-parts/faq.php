<section id="faq-section" class="faq-section">
    <div class="container">
        <h2 class="section-title">よくある疑問・不安</h2>
        
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question">
                    <span class="question-mark">Q.</span>
                    <h3>個人情報は安全ですか？</h3>
                    <div class="toggle-icon">
                        <i class="fas fa-plus"></i>
                        <i class="fas fa-minus"></i>
                    </div>
                </div>
                <div class="faq-answer">
                    <span class="answer-mark">A.</span>
                    <p>お客様の個人情報は厳重に管理し、査定目的以外には使用いたしません。SSL暗号化通信を採用し、情報漏洩防止に最大限の注意を払っております。また、プライバシーポリシーに基づき、適切に取り扱っておりますのでご安心ください。</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span class="question-mark">Q.</span>
                    <h3>しつこい営業電話がかかってきませんか？</h3>
                    <div class="toggle-icon">
                        <i class="fas fa-plus"></i>
                        <i class="fas fa-minus"></i>
                    </div>
                </div>
                <div class="faq-answer">
                    <span class="answer-mark">A.</span>
                    <p>対応は全て当社専任コンシェルジュが行うので、複数社からの営業電話はありません。お客様の希望に合わせた連絡方法（電話・メール・LINE）をご選択いただけますので、ご安心ください。また、査定後の営業活動に関してもお客様のご意向を最大限尊重いたします。</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span class="question-mark">Q.</span>
                    <h3>査定だけでも大丈夫ですか？</h3>
                    <div class="toggle-icon">
                        <i class="fas fa-plus"></i>
                        <i class="fas fa-minus"></i>
                    </div>
                </div>
                <div class="faq-answer">
                    <span class="answer-mark">A.</span>
                    <p>もちろん大丈夫です。査定は完全無料で、その後の契約義務は一切ありません。まずは物件の価値を知りたいという方も多くいらっしゃいますので、お気軽にご利用ください。査定結果を確認した後、検討する・しないはお客様の自由です。</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span class="question-mark">Q.</span>
                    <h3>どんな会社から査定が来るのですか？</h3>
                    <div class="toggle-icon">
                        <i class="fas fa-plus"></i>
                        <i class="fas fa-minus"></i>
                    </div>
                </div>
                <div class="faq-answer">
                    <span class="answer-mark">A.</span>
                    <p>業界大手から地域密着型まで厳選した優良企業のみです。すべての提携企業は財務状況や過去の取引実績、顧客満足度などの厳しい審査基準をクリアした信頼できる会社ばかりです。具体的な審査基準は企業秘密となりますが、お客様に安心してご利用いただける企業のみをご紹介しています。</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span class="question-mark">Q.</span>
                    <h3>査定結果はいつ届きますか？</h3>
                    <div class="toggle-icon">
                        <i class="fas fa-plus"></i>
                        <i class="fas fa-minus"></i>
                    </div>
                </div>
                <div class="faq-answer">
                    <span class="answer-mark">A.</span>
                    <p>最短で申込当日、標準的には1〜2営業日以内に査定結果が届きます。地域や物件の特性によっては、より詳細な調査が必要な場合もございますが、その場合も専任コンシェルジュから進捗状況をご連絡いたします。</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span class="question-mark">Q.</span>
                    <h3>リースバックの条件は自分で決められますか？</h3>
                    <div class="toggle-icon">
                        <i class="fas fa-plus"></i>
                        <i class="fas fa-minus"></i>
                    </div>
                </div>
                <div class="faq-answer">
                    <span class="answer-mark">A.</span>
                    <p>はい、希望の家賃や賃貸期間など、リースバックの主要な条件はお客様のご希望をベースに設定できます。専任コンシェルジュがお客様のご要望をしっかりとヒアリングし、それに最も適した提案を各社から引き出します。もちろん最終的な契約内容の決定権はお客様にあります。</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- F&Q アコーディオン JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 他のスクリプトとの競合を避けるため少し遅延
    setTimeout(function() {
        initializeFAQ();
    }, 300);
});

function initializeFAQ() {
    try {
        console.log('F&Q アコーディオンを初期化中...');
        
        // F&Q アイテムを取得
        const faqItems = document.querySelectorAll('#faq-section .faq-item');
        
        if (faqItems.length === 0) {
            console.error('F&Q アイテムが見つかりません');
            return;
        }
        
        console.log(`${faqItems.length}個のF&Qアイテムを発見`);
        
        // 各アイテムにクリックイベントを設定
        faqItems.forEach(function(item, index) {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');
            
            if (!question || !answer) {
                console.error(`F&Q ${index + 1}: 必要な要素が見つかりません`);
                return;
            }
            
            // クリックイベントを追加
            question.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const isCurrentlyActive = item.classList.contains('active');
                
                console.log(`F&Q ${index + 1} がクリックされました (現在の状態: ${isCurrentlyActive ? 'open' : 'closed'})`);
                
                // 全てのF&Qを閉じる
                faqItems.forEach(function(otherItem) {
                    otherItem.classList.remove('active');
                    const otherAnswer = otherItem.querySelector('.faq-answer');
                    if (otherAnswer) {
                        otherAnswer.style.display = 'none';
                        otherAnswer.style.maxHeight = '0px';
                        otherAnswer.style.opacity = '0';
                    }
                });
                
                // クリックされたF&Qが閉じていた場合のみ開く
                if (!isCurrentlyActive) {
                    item.classList.add('active');
                    answer.style.display = 'block';
                    setTimeout(function() {
                        answer.style.maxHeight = '1000px';
                        answer.style.opacity = '1';
                    }, 10);
                    console.log(`F&Q ${index + 1} を開きました`);
                } else {
                    console.log(`F&Q ${index + 1} を閉じました`);
                }
            });
            
            // 初期状態を設定（全て閉じた状態）
            item.classList.remove('active');
            answer.style.display = 'none';
            answer.style.maxHeight = '0px';
            answer.style.opacity = '0';
            
            console.log(`F&Q ${index + 1} にイベントを設定完了`);
        });
        
        console.log('F&Q アコーディオンの初期化が完了しました');
        
    } catch (error) {
        console.error('F&Q 初期化エラー:', error);
        
        // フォールバック処理
        setTimeout(function() {
            console.log('フォールバック処理を実行中...');
            addFallbackEvents();
        }, 500);
    }
}

// フォールバック処理
function addFallbackEvents() {
    try {
        const questions = document.querySelectorAll('#faq-section .faq-question');
        
        questions.forEach(function(question, index) {
            question.onclick = function() {
                const item = this.closest('.faq-item');
                const answer = item.querySelector('.faq-answer');
                const isActive = item.classList.contains('active');
                
                // 全て閉じる
                document.querySelectorAll('#faq-section .faq-item').forEach(function(allItem) {
                    allItem.classList.remove('active');
                    const allAnswer = allItem.querySelector('.faq-answer');
                    if (allAnswer) {
                        allAnswer.style.display = 'none';
                    }
                });
                
                // クリックしたものが閉じていた場合のみ開く
                if (!isActive && answer) {
                    item.classList.add('active');
                    answer.style.display = 'block';
                    console.log(`フォールバック: F&Q ${index + 1} を開きました`);
                }
            };
        });
        
        console.log('フォールバック処理が完了しました');
        
    } catch (error) {
        console.error('フォールバック処理エラー:', error);
    }
}

// ページ完全読み込み後の確認
window.addEventListener('load', function() {
    setTimeout(function() {
        const faqSection = document.getElementById('faq-section');
        if (faqSection) {
            console.log('F&Q セクションが正常に読み込まれました');
            
            // 動作テスト用関数をグローバルに追加
            window.testFAQ = function() {
                console.log('=== F&Q 動作テスト ===');
                const items = document.querySelectorAll('#faq-section .faq-item');
                items.forEach(function(item, i) {
                    const answer = item.querySelector('.faq-answer');
                    console.log(`F&Q ${i + 1}: ${item.classList.contains('active') ? 'OPEN' : 'CLOSED'} - Display: ${answer ? answer.style.display : 'N/A'}`);
                });
                console.log('=====================');
            };
            
        } else {
            console.error('F&Q セクションが見つかりません');
        }
    }, 1000);
});
</script>