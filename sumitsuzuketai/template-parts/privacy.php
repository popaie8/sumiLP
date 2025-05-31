<?php
/**
 * Template Name: プライバシーポリシー
 */
get_header(); ?>

<style>
/* パンくずリストのスタイル */
.breadcrumb-container {
  background-color: #f8f9fa;
  padding: 15px 0;
  border-bottom: 1px solid #e0e0e0;
}

.breadcrumb {
  max-width: 900px;
  margin: 0 auto;
  padding: 0 20px;
  font-size: 14px;
  color: #666;
}

.breadcrumb ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}

.breadcrumb li {
  display: flex;
  align-items: center;
}

.breadcrumb li:not(:last-child)::after {
  content: '>';
  margin: 0 8px;
  color: #999;
  font-size: 12px;
}

.breadcrumb a {
  color: #152C5B;
  text-decoration: none;
  transition: color 0.2s ease;
}

.breadcrumb a:hover {
  color: #4A90E2;
  text-decoration: underline;
}

.breadcrumb .current {
  color: #999;
  font-weight: 500;
}

.breadcrumb .home-icon {
  color: #4A90E2;
  margin-right: 5px;
  font-size: 12px;
}

/* プライバシーポリシーページのスタイル */
.privacy-page {
  padding: 40px 0 60px;
  background-color: #f8f9fa;
  min-height: calc(100vh - 200px);
}

.privacy-page .page-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 0 20px;
}

.privacy-page .page-header {
  text-align: center;
  margin-bottom: 40px;
}

.privacy-page .page-title {
  font-size: 36px;
  color: #152C5B;
  margin-bottom: 10px;
  font-weight: bold;
}

.privacy-page .page-subtitle {
  font-size: 18px;
  color: #666;
  margin: 0 0 20px 0;
}

.privacy-page .privacy-content {
  background: white;
  border-radius: 15px;
  padding: 50px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  line-height: 1.8;
}

.privacy-page .updated-date {
  text-align: right;
  color: #666;
  margin-bottom: 30px;
  font-size: 14px;
  font-style: italic;
}

.privacy-page .intro-section {
  background: linear-gradient(135deg, #e3f2fd, #f8f9fa);
  border-left: 4px solid #4A90E2;
  padding: 30px;
  margin-bottom: 40px;
  border-radius: 10px;
}

.privacy-page .intro-text {
  font-size: 16px;
  color: #333;
  margin: 0;
  text-align: justify;
}

.privacy-page .intro-text strong {
  color: #152C5B;
  font-weight: bold;
}

.privacy-page .policy-section {
  margin-bottom: 40px;
  padding-bottom: 30px;
  border-bottom: 1px solid #eee;
}

.privacy-page .policy-section:last-of-type {
  border-bottom: none;
  margin-bottom: 0;
  padding-bottom: 0;
}

.privacy-page .policy-section h2 {
  font-size: 24px;
  color: #152C5B;
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 2px solid #4A90E2;
  font-weight: bold;
}

.privacy-page .policy-section h3 {
  font-size: 20px;
  color: #152C5B;
  margin: 25px 0 15px 0;
  font-weight: 600;
}

.privacy-page .policy-section p {
  margin-bottom: 15px;
  text-align: justify;
  color: #555;
  font-size: 15px;
  line-height: 1.7;
}

.privacy-page .policy-list {
  margin: 20px 0;
  padding-left: 0;
  list-style: none;
}

.privacy-page .policy-list li {
  position: relative;
  margin-bottom: 10px;
  padding-left: 25px;
  color: #555;
  font-size: 15px;
  line-height: 1.6;
}

.privacy-page .policy-list li::before {
  content: '•';
  position: absolute;
  left: 0;
  top: 0;
  color: #4A90E2;
  font-weight: bold;
  font-size: 18px;
}

.privacy-page .policy-list li:last-child {
  margin-bottom: 0;
}

/* 利用目的テーブル */
.purpose-table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
  font-size: 14px;
}

.purpose-table th,
.purpose-table td {
  padding: 15px;
  text-align: left;
  border: 1px solid #ddd;
  vertical-align: top;
}

.purpose-table th {
  background-color: #f8f9fa;
  font-weight: bold;
  color: #152C5B;
  width: 30%;
}

.purpose-table td {
  color: #555;
  line-height: 1.6;
}

.purpose-table tr:nth-child(even) {
  background-color: #fafafa;
}

/* ハイライトボックス */
.highlight-box {
  background: #fff3cd;
  border: 1px solid #ffeaa7;
  border-radius: 8px;
  padding: 20px;
  margin: 20px 0;
}

.highlight-box h4 {
  color: #856404;
  margin-bottom: 10px;
  font-size: 16px;
}

.highlight-box p {
  color: #856404;
  margin: 0;
  font-size: 14px;
}

/* お問い合わせセクション */
.contact-section {
  background: linear-gradient(135deg, #e3f2fd, #f0f8ff);
  padding: 40px;
  border-radius: 15px;
  margin: 40px 0;
  border: 2px solid #4A90E2;
}

.contact-section .contact-title {
  color: #152C5B;
  margin-bottom: 25px;
  text-align: center;
  font-size: 24px;
  font-weight: bold;
}

.contact-section .contact-title i {
  color: #4A90E2;
  margin-right: 10px;
}

.contact-section .contact-info {
  background: white;
  padding: 25px;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.contact-section .company-name {
  font-size: 18px;
  color: #152C5B;
  margin-bottom: 15px;
  font-weight: bold;
  text-align: center;
}

.contact-section .contact-details {
  display: grid;
  gap: 12px;
}

.contact-section .contact-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  font-size: 14px;
  line-height: 1.6;
}

.contact-section .contact-item i {
  color: #4A90E2;
  width: 20px;
  text-align: center;
  flex-shrink: 0;
  margin-top: 2px;
}

.contact-section .contact-item a {
  color: #152C5B;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s ease;
}

.contact-section .contact-item a:hover {
  color: #4A90E2;
  text-decoration: underline;
}

/* 戻るボタン */
.back-to-home {
  text-align: center;
  margin: 40px 0;
}

.back-button {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #152C5B;
  color: white;
  padding: 15px 30px;
  border-radius: 50px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease;
  box-shadow: 0 3px 10px rgba(21, 44, 91, 0.3);
}

.back-button:hover {
  background: #4A90E2;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
  color: white;
  text-decoration: none;
}

.back-button i {
  font-size: 16px;
}

/* 専用フッター */
.simple-footer {
  background-color: #152C5B;
  color: #fff;
  padding: 30px 0 15px;
  margin-top: 40px;
}

.simple-footer .footer-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 0 20px;
}

.simple-footer .footer-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.simple-footer .footer-logo img {
  max-width: 150px;
  margin-bottom: 8px;
}

.simple-footer .footer-tagline {
  font-size: 14px;
  color: rgba(255, 255, 255, 0.7);
  margin: 0;
}

.simple-footer .footer-contact {
  text-align: right;
}

.simple-footer .footer-tel {
  font-size: 20px;
  font-weight: bold;
  color: #fff;
  margin-bottom: 5px;
}

.simple-footer .footer-tel i {
  margin-right: 8px;
  color: #4A90E2;
}

.simple-footer .footer-hours {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.7);
}

.simple-footer .footer-bottom {
  text-align: center;
  padding-top: 15px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.simple-footer .copyright {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.7);
  margin: 0;
}

/* モバイル対応 */
@media (max-width: 768px) {
  .breadcrumb {
    padding: 0 15px;
  }
  
  .privacy-page .page-container {
    padding: 0 15px;
  }
  
  .privacy-page .page-title {
    font-size: 28px;
  }
  
  .privacy-page .privacy-content {
    padding: 30px 20px;
    border-radius: 10px;
  }
  
  .privacy-page .updated-date {
    text-align: center;
    margin-bottom: 20px;
  }
  
  .privacy-page .intro-section {
    padding: 20px;
    margin-bottom: 30px;
  }
  
  .privacy-page .policy-section {
    margin-bottom: 30px;
    padding-bottom: 20px;
  }
  
  .privacy-page .policy-section h2 {
    font-size: 20px;
    margin-bottom: 15px;
  }
  
  .privacy-page .policy-section h3 {
    font-size: 18px;
    margin: 20px 0 10px 0;
  }
  
  .privacy-page .policy-section p,
  .privacy-page .policy-list li {
    font-size: 14px;
  }
  
  .privacy-page .policy-list li {
    padding-left: 20px;
  }
  
  .purpose-table {
    font-size: 12px;
  }
  
  .purpose-table th,
  .purpose-table td {
    padding: 10px;
  }
  
  .purpose-table th {
    width: 35%;
  }
  
  .contact-section {
    padding: 25px 20px;
    margin: 30px 0;
  }
  
  .contact-section .contact-title {
    font-size: 20px;
    margin-bottom: 20px;
  }
  
  .contact-section .contact-info {
    padding: 20px;
  }
  
  .contact-section .company-name {
    font-size: 16px;
    margin-bottom: 12px;
  }
  
  .contact-section .contact-item {
    font-size: 13px;
  }
  
  .simple-footer .footer-content {
    flex-direction: column;
    gap: 20px;
    text-align: center;
  }
  
  .simple-footer .footer-contact {
    text-align: center;
  }
  
  .simple-footer .footer-tel {
    font-size: 18px;
  }
  
  .simple-footer .footer-logo img {
    max-width: 120px;
  }
}
</style>

<!-- パンくずリスト -->
<div class="breadcrumb-container">
    <nav class="breadcrumb">
        <ul>
            <li>
                <a href="<?php echo home_url(); ?>">
                    <i class="fas fa-home home-icon"></i>ホーム
                </a>
            </li>
            <li>
                <span class="current">プライバシーポリシー</span>
            </li>
        </ul>
    </nav>
</div>

<main class="privacy-page">
    <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">プライバシーポリシー</h1>
            <p class="page-subtitle">個人情報保護方針</p>
        </div>

        <div class="privacy-content">
            <div class="updated-date">
                最終更新日：<?php echo date('Y年n月j日'); ?>
            </div>

            <div class="intro-section">
                <p class="intro-text">
                    <strong>株式会社クロフネチンタイ管理（サイト名：住み続け隊）</strong>（以下「当社」といいます。）は、当社が運営するリースバック一括査定サイト（以下「本サイト」といいます。）において取得する個人情報を、<strong>「個人情報の保護に関する法律」および関連ガイドライン</strong>その他の法令を遵守し、以下のとおり適切に取扱います。
                </p>
            </div>

            <article class="policy-section">
                <h2>1. 個人情報の定義</h2>
                <p>本ポリシーにおける「個人情報」とは、氏名、生年月日、住所、電話番号、メールアドレス、物件住所その他の記述等により特定の個人を識別できる情報、ならびに単体で個人を識別できる個人識別符号（マイナンバー・運転免許証番号等）をいいます。</p>
            </article>

            <article class="policy-section">
                <h2>2. 個人情報の取得方法</h2>
                <p>当社は以下の方法で個人情報を取得します。</p>
                
                <h3>2-1. 入力フォーム</h3>
                <ul class="policy-list">
                    <li>リースバック査定申込みフォーム</li>
                    <li>お問い合わせフォーム</li>
                    <li>資料請求フォーム</li>
                    <li>メールマガジン登録フォーム</li>
                </ul>

                <h3>2-2. 自動取得</h3>
                <ul class="policy-list">
                    <li>Cookie・アクセス解析ツール（Google Analytics等）による閲覧データ</li>
                    <li>IPアドレス・ブラウザ情報・デバイス情報</li>
                    <li>サイト利用履歴・アクセス時刻</li>
                </ul>

                <h3>2-3. 提携先からの取得</h3>
                <ul class="policy-list">
                    <li>業務提携不動産会社・決済事業者等から、ユーザーの同意・法令上許された範囲で取得する場合</li>
                </ul>
            </article>

            <article class="policy-section">
                <h2>3. 個人情報の利用目的</h2>
                <p>当社は取得した個人情報を、以下の範囲で利用します。</p>

                <table class="purpose-table">
                    <thead>
                        <tr>
                            <th>利用目的</th>
                            <th>具体例</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>リースバック査定サービスの提供・管理</td>
                            <td>物件情報の確認、複数査定会社への見積もり依頼、結果通知</td>
                        </tr>
                        <tr>
                            <td>ご本人確認・本人照会</td>
                            <td>査定結果の送付、追加確認の連絡</td>
                        </tr>
                        <tr>
                            <td>サポート・お問い合わせ対応</td>
                            <td>質問対応、資料送付、アフターフォロー</td>
                        </tr>
                        <tr>
                            <td>サービス改善・分析</td>
                            <td>サイト利用状況の統計分析、UI/UX改善</td>
                        </tr>
                        <tr>
                            <td>新機能・キャンペーン等の案内</td>
                            <td>メールマガジン、プッシュ通知、DM送付</td>
                        </tr>
                        <tr>
                            <td>法令・ガイドライン等に基づく対応</td>
                            <td>会計監査、税務申告、行政機関等への届出</td>
                        </tr>
                    </tbody>
                </table>

                <div class="highlight-box">
                    <h4><i class="fas fa-exclamation-triangle"></i> 重要</h4>
                    <p>※上記目的に付随する範囲で利用する場合があります。ご本人の同意がない限り、目的外利用はいたしません。</p>
                </div>
            </article>

            <article class="policy-section">
                <h2>4. 個人情報の第三者提供</h2>
                <p>当社は、次の場合を除き、あらかじめご本人の同意なく第三者へ個人情報を提供しません。</p>
                
                <h3>4-1. 法令に基づく提供</h3>
                <ul class="policy-list">
                    <li>法令に基づく場合</li>
                    <li>人の生命・身体・財産の保護に必要かつ同意取得が困難な場合</li>
                    <li>公衆衛生の向上・児童健全育成に特に必要で同意取得が困難な場合</li>
                    <li>国・地方公共団体等の事務遂行に協力する場合で同意取得が事務遂行に支障を及ぼすおそれがあるとき</li>
                </ul>

                <h3>4-2. 共同利用</h3>
                <ul class="policy-list">
                    <li><strong>共同利用者：</strong>提携不動産会社（最大200社）</li>
                    <li><strong>共同利用目的：</strong>査定額算出、取引条件の提示</li>
                    <li><strong>共同利用項目：</strong>氏名、連絡先、物件情報、希望条件</li>
                    <li><strong>管理責任者：</strong>当社</li>
                </ul>
            </article>

            <article class="policy-section">
                <h2>5. 個人情報の安全管理</h2>
                <p>当社は、漏えい・滅失・毀損等を防止するため、以下の安全管理措置を講じます。</p>
                <ul class="policy-list">
                    <li><strong>社内規程の整備・従業員教育</strong></li>
                    <li><strong>通信の暗号化（SSL/TLS）</strong></li>
                    <li><strong>アクセス権限管理・パスワードポリシー</strong></li>
                    <li><strong>定期的な脆弱性診断・ログ監視</strong></li>
                    <li><strong>物理的安全管理措置（入退室管理等）</strong></li>
                </ul>
            </article>

            <article class="policy-section">
                <h2>6. Cookie及び類似技術の利用</h2>
                <p>本サイトでは、利用状況解析や広告配信最適化のためにCookieを使用し、Google Analytics等のツールを利用します。ブラウザ設定でCookieを無効化することも可能ですが、サービス利用に支障が生じる場合があります。</p>
                <p>Google Analyticsの仕組みやデータ取扱いについてはGoogle社のプライバシーポリシーをご確認ください。</p>
            </article>

            <article class="policy-section">
                <h2>7. 個人情報の開示・訂正・利用停止等の手続き</h2>
                <p>ご本人から、保有個人データの「開示・訂正・追加・削除・利用停止・第三者提供の停止」等をご請求いただいた場合、法令に基づき合理的な期間・範囲で対応いたします。</p>
                <ul class="policy-list">
                    <li><strong>手数料：</strong>開示請求1件あたり1,000円（税込）</li>
                    <li><strong>本人確認：</strong>運転免許証など公的書類で確認</li>
                    <li><strong>対応期間：</strong>請求から原則2週間以内</li>
                </ul>
            </article>

            <article class="policy-section">
                <h2>8. 外部委託</h2>
                <p>当社は、利用目的の達成に必要な範囲で、個人情報の取扱いを外部業者に委託する場合があります。この場合、委託先に対して適切な監督を行います。</p>
            </article>

            <article class="policy-section">
                <h2>9. 個人情報の保存期間</h2>
                <p>当社は、個人情報を利用目的の達成に必要な期間のみ保存し、目的達成後は速やかに削除いたします。ただし、法令により保存が義務付けられている場合は、当該期間中保存いたします。</p>
            </article>

            <article class="policy-section">
                <h2>10. プライバシーポリシーの変更</h2>
                <p>本ポリシーの内容は、法令の改正等により予告なく変更する場合があります。最新の内容は本サイトに掲示した時点で効力を生じます。重要な変更については、サイト上での告知やメール等でお知らせいたします。</p>
            </article>

            <div class="contact-section">
                <h2 class="contact-title">
                    <i class="fas fa-phone-alt"></i> 個人情報相談窓口
                </h2>
                <div class="contact-info">
                    <p class="company-name">株式会社クロフネチンタイ管理（住み続け隊）</p>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-user"></i>
                            <span><strong>個人情報保護管理責任者：</strong>黒江 貴裕</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>〒230-0011 神奈川県横浜市鶴見区上末吉四丁目11番4号 アネックス第一ハイムA棟102</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span><a href="tel:050-5810-5875">050-5810-5875</a></span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <span>受付時間：9:00〜19:00（年中無休）</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span><a href="mailto:info@sumitsudzuke-tai.jp">info@sumitsudzuke-tai.jp</a></span>
                        </div>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 30px; color: #666; font-size: 14px;">
                <p><strong>制定：</strong>2023年7月6日</p>
                <p><strong>改定：</strong><?php echo date('Y年n月j日'); ?></p>
            </div>
        </div>

        <!-- 戻るボタン -->
        <div class="back-to-home">
            <a href="<?php echo home_url(); ?>" class="back-button">
                <i class="fas fa-arrow-left"></i>
                ホームに戻る
            </a>
        </div>
    </div>
</main>

<!-- 専用フッター -->
<footer class="simple-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-white.png" alt="住み続け隊">
                <p class="footer-tagline">リースバック一括査定サイト</p>
            </div>
            
            <div class="footer-contact">
                <div class="footer-tel">
                    <i class="fas fa-phone-alt"></i> 050-5810-5875
                </div>
                <div class="footer-hours">
                    受付時間：9:00〜19:00（年中無休）
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="copyright">&copy; <?php echo date('Y'); ?> 住み続け隊 All Rights Reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>