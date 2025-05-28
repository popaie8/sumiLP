<section id="assessment-form" class="main-form">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2 class="form-title">あなたの物件の適正査定額をチェック</h2>
                <p class="form-subtitle">たった60秒の入力で最大10社から査定額を取得できます</p>
                
                <div class="form-urgency">
                    <div class="urgency-badge">
                        <i class="fas fa-bolt"></i> 本日申込の方限定！
                    </div>
                    <p class="urgency-text">査定額5%アップ交渉サービス実施中</p>
                    <div class="countdown-timer" id="campaign-timer">
                        <span>キャンペーン終了まで</span>
                        <div class="timer-digits">
                            <div class="timer-unit">
                                <span class="digit" id="hours">04</span>
                                <span class="unit">時間</span>
                            </div>
                            <div class="timer-separator">:</div>
                            <div class="timer-unit">
                                <span class="digit" id="minutes">32</span>
                                <span class="unit">分</span>
                            </div>
                            <div class="timer-separator">:</div>
                            <div class="timer-unit">
                                <span class="digit" id="seconds">15</span>
                                <span class="unit">秒</span>
                            </div>
                        </div>
                    </div>
                    <p class="remaining-slots">本日の査定受付残り<span id="remaining-slots">12</span>枠</p>
                </div>
            </div>
            
            <div class="form-body">
                <form id="multi-step-form" action="#" method="post">
                    <!-- ステップ1: 最小限の情報 -->
                    <div class="form-step" id="form-step-1">
                        <div class="step-indicator">
                            <div class="step-dots">
                                <span class="step-dot active"></span>
                                <span class="step-dot"></span>
                                <span class="step-dot"></span>
                            </div>
                            <div class="step-text">ステップ 1/3</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="postal-code-full">郵便番号</label>
                            <input type="text" id="postal-code-full" name="postal-code" placeholder="例：123-4567" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="property-type-full">物件種別</label>
                            <select id="property-type-full" name="property-type" required>
                                <option value="">選択してください</option>
                                <option value="apartment">マンション</option>
                                <option value="house">一戸建て</option>
                                <option value="land">土地</option>
                                <option value="commercial">商業施設</option>
                            </select>
                        </div>
                        
                        <div class="form-buttons">
                            <button type="button" class="next-step-button" data-step="2">次へ進む</button>
                        </div>
                    </div>
                    
                    <!-- ステップ2: 物件詳細情報 -->
                    <div class="form-step" id="form-step-2" style="display: none;">
                        <div class="step-indicator">
                            <div class="step-dots">
                                <span class="step-dot completed"></span>
                                <span class="step-dot active"></span>
                                <span class="step-dot"></span>
                            </div>
                            <div class="step-text">ステップ 2/3</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="property-address">物件所在地</label>
                            <input type="text" id="property-address" name="property-address" placeholder="例：東京都新宿区○○町1-2-3" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="property-size">物件面積</label>
                            <div class="input-with-unit">
                                <input type="number" id="property-size" name="property-size" placeholder="例：80" required>
                                <span class="unit">㎡</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="property-age">築年数</label>
                            <div class="input-with-unit">
                                <input type="number" id="property-age" name="property-age" placeholder="例：15" required>
                                <span class="unit">年</span>
                            </div>
                        </div>
                        
                        <div class="form-buttons">
                            <button type="button" class="prev-step-button" data-step="1">戻る</button>
                            <button type="button" class="next-step-button" data-step="3">次へ進む</button>
                        </div>
                    </div>
                    
                    <!-- ステップ3: 連絡先情報 -->
                    <div class="form-step" id="form-step-3" style="display: none;">
                        <div class="step-indicator">
                            <div class="step-dots">
                                <span class="step-dot completed"></span>
                                <span class="step-dot completed"></span>
                                <span class="step-dot active"></span>
                            </div>
                            <div class="step-text">ステップ 3/3</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="name">お名前</label>
                            <input type="text" id="name" name="name" placeholder="例：山田 太郎" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">電話番号</label>
                            <input type="tel" id="phone" name="phone" placeholder="例：090-1234-5678" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <input type="email" id="email" name="email" placeholder="例：sample@example.com" required>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="agreement" required>
                                <span class="checkbox-text"><a href="#" target="_blank">利用規約</a>と<a href="#" target="_blank">プライバシーポリシー</a>に同意する</span>
                            </label>
                        </div>
                        
                        <div class="form-buttons">
                            <button type="button" class="prev-step-button" data-step="2">戻る</button>
                            <button type="submit" class="submit-button">無料査定をスタートする</button>
                        </div>
                    </div>
                </form>
                
                <div class="form-features">
                    <div class="form-feature">
                        <i class="fas fa-lock"></i>
                        <span>SSL暗号化通信で個人情報を保護</span>
                    </div>
                    <div class="form-feature">
                        <i class="fas fa-yen-sign"></i>
                        <span>査定は完全無料</span>
                    </div>
                    <div class="form-feature">
                        <i class="fas fa-mobile-alt"></i>
                        <span>SMS・メールで査定結果をお届け</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>