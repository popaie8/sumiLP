<?php
/**
 * Template Name: 利用規約
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

/* 利用規約ページのスタイル */
.terms-page {
  padding: 40px 0 60px;
  background-color: #f8f9fa;
  min-height: calc(100vh - 200px);
}

.terms-page .page-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 0 20px;
}

.terms-page .page-header {
  text-align: center;
  margin-bottom: 40px;
}

.terms-page .page-title {
  font-size: 36px;
  color: #152C5B;
  margin-bottom: 10px;
  font-weight: bold;
}

.terms-page .page-subtitle {
  font-size: 18px;
  color: #666;
  margin: 0 0 20px 0;
}

.terms-page .terms-content {
  background: white;
  border-radius: 15px;
  padding: 50px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  line-height: 1.8;
}

.terms-page .updated-date {
  text-align: right;
  color: #666;
  margin-bottom: 30px;
  font-size: 14px;
  font-style: italic;
}

.terms-page .intro-section {
  background: linear-gradient(135deg, #e3f2fd, #f8f9fa);
  border-left: 4px solid #4A90E2;
  padding: 30px;
  margin-bottom: 40px;
  border-radius: 10px;
}

.terms-page .intro-text {
  font-size: 16px;
  color: #333;
  margin: 0;
  text-align: justify;
}

.terms-page .intro-text strong {
  color: #152C5B;
  font-weight: bold;
}

.terms-page .terms-section {
  margin-bottom: 40px;
  padding-bottom: 30px;
  border-bottom: 1px solid #eee;
}

.terms-page .terms-section:last-of-type {
  border-bottom: none;
  margin-bottom: 0;
  padding-bottom: 0;
}

.terms-page .terms-section h2 {
  font-size: 24px;
  color: #152C5B;
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 2px solid #4A90E2;
  font-weight: bold;
}

.terms-page .terms-section h3 {
  font-size: 20px;
  color: #152C5B;
  margin: 25px 0 15px 0;
  font-weight: 600;
}

.terms-page .terms-section p {
  margin-bottom: 15px;
  text-align: justify;
  color: #555;
  font-size: 15px;
  line-height: 1.7;
}

.terms-page .terms-list {
  margin: 20px 0;
  padding-left: 0;
  list-style: none;
}

.terms-page .terms-list li {
  position: relative;
  margin-bottom: 10px;
  padding-left: 25px;
  color: #555;
  font-size: 15px;
  line-height: 1.6;
}

.terms-page .terms-list li::before {
  content: '•';
  position: absolute;
  left: 0;
  top: 0;
  color: #4A90E2;
  font-weight: bold;
  font-size: 18px;
}

.terms-page .terms-list li:last-child {
  margin-bottom: 0;
}

/* 定義テーブル */
.definition-table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
  font-size: 14px;
}

.definition-table th,
.definition-table td {
  padding: 15px;
  text-align: left;
  border: 1px solid #ddd;
  vertical-align: top;
}

.definition-table th {
  background-color: #f8f9fa;
  font-weight: bold;
  color: #152C5B;
  width: 25%;
}

.definition-table td {
  color: #555;
  line-height: 1.6;
}

.definition-table tr:nth-child(even) {
  background-color: #fafafa;
}

/* 重要ボックス */
.important-box {
  background: #fff3cd;
  border: 1px solid #ffeaa7;
  border-radius: 8px;
  padding: 20px;
  margin: 20px 0;
}

.important-box h4 {
  color: #856404;
  margin-bottom: 10px;
  font-size: 16px;
}

.important-box p {
  color: #856404;
  margin: 0;
  font-size: 14px;
}

/* 注意ボックス */
.warning-box {
  background: #f8d7da;
  border: 1px solid #f5c6cb;
  border-radius: 8px;
  padding: 20px;
  margin: 20px 0;
}

.warning-box h4 {
  color: #721c24;
  margin-bottom: 10px;
  font-size: 16px;
}

.warning-box p {
  color: #721c24;
  margin: 0;
  font-size: 14px;
  line-height: 1.6;
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

/* 専用フッター（簡易リンク追加） */
.simple-footer {
  background-color: #152C5B;
  color: #fff;
  padding: 30px 0 20px;
  margin-top: 40px;
  font-family: "Hiragino Sans", "Hiragino Kaku Gothic ProN", Meiryo, sans-serif;
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
  margin-bottom: 25px;
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

.simple-footer .footer-tel a {
  color: #fff;
  text-decoration: none;
  transition: color 0.3s ease;
}

.simple-footer .footer-tel a:hover {
  color: #4A90E2;
}

.simple-footer .footer-tel i {
  margin-right: 8px;
  color: #4A90E2;
}

.simple-footer .footer-hours {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.7);
}

/* 簡易リンクセクション */
.simple-footer .footer-links {
  display: flex;
  justify-content: center;
  gap: 30px;
  flex-wrap: wrap;
  margin-bottom: 20px;
  padding-bottom: 20px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.simple-footer .footer-links a {
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  gap: 6px;
}

.simple-footer .footer-links a:hover {
  color: #4A90E2;
  text-decoration: underline;
  transform: translateY(-1px);
}

.simple-footer .footer-links a i {
  font-size: 12px;
  color: #4A90E2;
}

.simple-footer .footer-bottom {
  text-align: center;
  padding-top: 15px;
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
  
  .terms-page .page-container {
    padding: 0 15px;
  }
  
  .terms-page .page-title {
    font-size: 28px;
  }
  
  .terms-page .terms-content {
    padding: 30px 20px;
    border-radius: 10px;
  }
  
  .terms-page .updated-date {
    text-align: center;
    margin-bottom: 20px;
  }
  
  .terms-page .intro-section {
    padding: 20px;
    margin-bottom: 30px;
  }
  
  .terms-page .terms-section {
    margin-bottom: 30px;
    padding-bottom: 20px;
  }
  
  .terms-page .terms-section h2 {
    font-size: 20px;
    margin-bottom: 15px;
  }
  
  .terms-page .terms-section h3 {
    font-size: 18px;
    margin: 20px 0 10px 0;
  }
  
  .terms-page .terms-section p,
  .terms-page .terms-list li {
    font-size: 14px;
  }
  
  .terms-page .terms-list li {
    padding-left: 20px;
  }
  
  .definition-table {
    font-size: 12px;
  }
  
  .definition-table th,
  .definition-table td {
    padding: 10px;
  }
  
  .definition-table th {
    width: 30%;
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
  
  .simple-footer .footer-links {
    flex-direction: column;
    gap: 15px;
    align-items: center;
  }
  
  .simple-footer .footer-links a {
    font-size: 13px;
  }
}

@media (max-width: 480px) {
  .simple-footer .footer-links {
    gap: 12px;
  }
  
  .simple-footer .footer-links a {
    font-size: 12px;
    gap: 4px;
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
                <span class="current">利用規約</span>
            </li>
        </ul>
    </nav>
</div>

<main class="terms-page">
    <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">利用規約</h1>
            <p class="page-subtitle">サービス利用規約</p>
        </div>

        <div class="terms-content">
            <div class="updated-date">
                最終更新日：<?php echo date('Y年n月j日'); ?>
            </div>

            <div class="intro-section">
                <p class="intro-text">
                    <strong>株式会社クロフネチンタイ管理（サイト名：住み続け隊）</strong>（以下「当社」といいます。）が運営するリースバック一括査定サイト（以下「本サービス」といいます。）を利用されるお客様（以下「利用者」といいます。）は、以下の利用規約（以下「本規約」といいます。）に同意の上、本サービスをご利用ください。
                </p>
            </div>

            <article class="terms-section">
                <h2>第1条（定義）</h2>
                <p>本規約において使用する用語の定義は、以下のとおりとします。</p>
                
                <table class="definition-table">
                    <tbody>
                        <tr>
                            <th>本サービス</th>
                            <td>当社が運営するリースバック一括査定サイト「住み続け隊」およびこれに付随するサービス全般</td>
                        </tr>
                        <tr>
                            <th>利用者</th>
                            <td>本サービスを利用する個人または法人</td>
                        </tr>
                        <tr>
                            <th>査定依頼</th>
                            <td>利用者が本サービスを通じて複数の提携会社に対して行うリースバック査定の申込み</td>
                        </tr>
                        <tr>
                            <th>提携会社</th>
                            <td>当社と業務提携契約を締結し、リースバック査定サービスを提供する不動産会社・金融機関等</td>
                        </tr>
                        <tr>
                            <th>個人情報</th>
                            <td>利用者が本サービス利用時に当社に提供する氏名、住所、電話番号、メールアドレス、物件情報等の情報</td>
                        </tr>
                    </tbody>
                </table>
            </article>

            <article class="terms-section">
                <h2>第2条（本規約の適用）</h2>
                <p>本規約は、利用者と当社との間の本サービスの利用に関わる一切の関係に適用されます。</p>
                <p>当社が本サービス上で別途定める個別規定は、本規約の一部を構成するものとします。本規約と個別規定との間で齟齬が生じた場合、個別規定が優先されるものとします。</p>
            </article>

            <article class="terms-section">
                <h2>第3条（本サービスの内容）</h2>
                <p>本サービスは、以下のサービスを提供します。</p>
                
                <ul class="terms-list">
                    <li>リースバック査定の一括申込み仲介サービス</li>
                    <li>提携会社からの査定結果の取りまとめ・通知</li>
                    <li>リースバックに関する情報提供・相談サービス</li>
                    <li>利用者と提携会社のマッチングサポート</li>
                    <li>その他、上記に付随する関連サービス</li>
                </ul>

                <div class="important-box">
                    <h4><i class="fas fa-info-circle"></i> 重要な注意事項</h4>
                    <p>当社は査定の仲介を行うものであり、リースバック取引そのものの当事者ではありません。実際の取引は利用者と提携会社との間で直接行われます。</p>
                </div>
            </article>

            <article class="terms-section">
                <h2>第4条（利用資格）</h2>
                <p>本サービスを利用できるのは、以下の条件を満たす方に限ります。</p>
                
                <ul class="terms-list">
                    <li>満18歳以上の個人または適法に設立された法人</li>
                    <li>日本国内に所在する不動産の所有者または所有予定者</li>
                    <li>本規約およびプライバシーポリシーに同意いただける方</li>
                    <li>正確な情報を提供いただける方</li>
                    <li>当社が利用を不適当と判断した方を除く</li>
                </ul>
            </article>

            <article class="terms-section">
                <h2>第5条（査定依頼の申込み）</h2>
                <h3>5-1. 申込み手続き</h3>
                <p>利用者は、当社の定める方法により、必要事項を入力の上、査定依頼の申込みを行うものとします。</p>
                
                <h3>5-2. 申込み内容</h3>
                <p>査定依頼の申込みには、以下の情報の提供が必要です。</p>
                <ul class="terms-list">
                    <li>利用者の氏名、住所、電話番号、メールアドレス</li>
                    <li>査定対象物件の所在地、面積、築年数等の基本情報</li>
                    <li>リースバックの希望条件</li>
                    <li>その他、当社が必要と認める情報</li>
                </ul>

                <h3>5-3. 申込みの承諾</h3>
                <p>当社は、査定依頼の申込みを受けた場合、内容を確認の上、承諾の可否を決定します。以下の場合、申込みをお断りすることがあります。</p>
                <ul class="terms-list">
                    <li>提供された情報が不正確または不完全な場合</li>
                    <li>査定対象物件が本サービスの対象外の場合</li>
                    <li>利用者が第4条の利用資格を満たさない場合</li>
                    <li>その他、当社が不適当と判断した場合</li>
                </ul>
            </article>

            <article class="terms-section">
                <h2>第6条（査定結果の提供）</h2>
                <p>当社は、提携会社から受領した査定結果を利用者に通知します。ただし、以下の点にご注意ください。</p>
                
                <ul class="terms-list">
                    <li>査定結果は提携会社の独自の判断に基づくものです</li>
                    <li>査定結果は確定的な取引条件ではありません</li>
                    <li>実際の取引条件は、利用者と提携会社との間の協議により決定されます</li>
                    <li>査定結果の提供時期は物件の状況等により異なります</li>
                </ul>

                <div class="warning-box">
                    <h4><i class="fas fa-exclamation-triangle"></i> 重要</h4>
                    <p>当社は査定結果の正確性、妥当性について保証いたしません。査定結果はあくまで参考情報としてご活用ください。</p>
                </div>
            </article>

            <article class="terms-section">
                <h2>第7条（利用者の義務）</h2>
                <p>利用者は、本サービスの利用にあたり、以下の義務を負います。</p>
                
                <ul class="terms-list">
                    <li>正確で最新の情報を提供すること</li>
                    <li>本規約およびプライバシーポリシーを遵守すること</li>
                    <li>第三者の権利を侵害しないこと</li>
                    <li>虚偽の情報を提供しないこと</li>
                    <li>本サービスを営業目的以外の目的で利用すること</li>
                    <li>当社および提携会社に迷惑をかける行為をしないこと</li>
                </ul>
            </article>

            <article class="terms-section">
                <h2>第8条（禁止事項）</h2>
                <p>利用者は、本サービスの利用にあたり、以下の行為を行ってはなりません。</p>
                
                <ul class="terms-list">
                    <li>法令または公序良俗に反する行為</li>
                    <li>犯罪行為に関連する行為</li>
                    <li>当社または第三者の知的財産権を侵害する行為</li>
                    <li>当社または第三者の名誉・信用を毀損する行為</li>
                    <li>虚偽の情報を提供する行為</li>
                    <li>同一物件について重複して査定依頼する行為</li>
                    <li>営利目的での本サービスの利用</li>
                    <li>本サービスの運営を妨害する行為</li>
                    <li>その他、当社が不適当と判断する行為</li>
                </ul>
            </article>

            <article class="terms-section">
                <h2>第9条（個人情報の取扱い）</h2>
                <p>当社は、利用者の個人情報を当社のプライバシーポリシーに従って適切に取り扱います。</p>
                <p>利用者は、査定依頼の申込みにより、当社が利用者の個人情報を提携会社に提供することに同意するものとします。</p>
            </article>

            <article class="terms-section">
                <h2>第10条（免責事項）</h2>
                <p>当社の責任は、以下のとおり制限されます。</p>
                
                <ul class="terms-list">
                    <li>当社は、本サービスの中断・停止について責任を負いません</li>
                    <li>当社は、査定結果の正確性・妥当性について保証いたしません</li>
                    <li>当社は、利用者と提携会社との取引について責任を負いません</li>
                    <li>当社は、本サービスの利用による間接損害について責任を負いません</li>
                    <li>システム障害等の不可抗力による損害について責任を負いません</li>
                </ul>

                <div class="warning-box">
                    <h4><i class="fas fa-shield-alt"></i> 免責の重要性</h4>
                    <p>本サービスは査定の仲介サービスです。実際のリースバック取引における一切の責任は、取引当事者である利用者と提携会社が負うものとします。</p>
                </div>
            </article>

            <article class="terms-section">
                <h2>第11条（サービスの変更・停止）</h2>
                <p>当社は、以下の場合、事前の通知なく本サービスの全部または一部を変更・停止することができます。</p>
                
                <ul class="terms-list">
                    <li>システムの保守・点検を行う場合</li>
                    <li>地震、停電等の不可抗力により運営が困難な場合</li>
                    <li>その他、当社が必要と判断した場合</li>
                </ul>
            </article>

            <article class="terms-section">
                <h2>第12条（利用契約の解除）</h2>
                <p>当社は、利用者が以下のいずれかに該当する場合、事前の通知なく利用契約を解除することができます。</p>
                
                <ul class="terms-list">
                    <li>本規約に違反した場合</li>
                    <li>提供された情報に虚偽があることが判明した場合</li>
                    <li>当社または提携会社に著しい迷惑をかけた場合</li>
                    <li>反社会的勢力に該当することが判明した場合</li>
                    <li>その他、当社が利用継続を不適当と判断した場合</li>
                </ul>
            </article>

            <article class="terms-section">
                <h2>第13条（損害賠償）</h2>
                <p>利用者が本規約に違反したことにより当社に損害が生じた場合、利用者はその損害を賠償する責任を負います。</p>
                <p>当社の利用者に対する損害賠償責任は、当社に故意または重大な過失がある場合を除き、いかなる場合も免責されるものとします。</p>
            </article>

            <article class="terms-section">
                <h2>第14条（秘密保持）</h2>
                <p>当社および利用者は、本サービスの利用により知り得た相手方の秘密情報を第三者に開示してはなりません。ただし、以下の場合を除きます。</p>
                
                <ul class="terms-list">
                    <li>法令により開示が義務付けられた場合</li>
                    <li>裁判所、行政機関等の公的機関から開示を求められた場合</li>
                    <li>事前に相手方の書面による同意を得た場合</li>
                </ul>
            </article>

            <article class="terms-section">
                <h2>第15条（知的財産権）</h2>
                <p>本サービスに関する知的財産権は、当社または正当な権利者に帰属します。</p>
                <p>利用者は、当社の事前の書面による許可なく、本サービスのコンテンツを複製、転載、配布等してはなりません。</p>
            </article>

            <article class="terms-section">
                <h2>第16条（本規約の変更）</h2>
                <p>当社は、利用者への事前の通知により、本規約を変更することができます。</p>
                <p>変更後の規約は、当社ウェブサイトに掲載した時点で効力を生じます。利用者が変更後も本サービスを継続利用した場合、変更後の規約に同意したものとみなします。</p>
                
                <div class="important-box">
                    <h4><i class="fas fa-bell"></i> 規約変更の通知</h4>
                    <p>重要な変更については、メール等で事前にお知らせいたします。定期的に最新の規約をご確認ください。</p>
                </div>
            </article>

            <article class="terms-section">
                <h2>第17条（準拠法・管轄裁判所）</h2>
                <p>本規約の解釈および適用は、日本法に準拠します。</p>
                <p>本サービスに関して紛争が生じた場合、横浜地方裁判所を第一審の専属的合意管轄裁判所とします。</p>
            </article>

            <article class="terms-section">
                <h2>第18条（分離可能性）</h2>
                <p>本規約のいずれかの条項が無効または執行不能と判断された場合でも、本規約の他の条項の有効性は影響を受けません。</p>
            </article>

            <article class="terms-section">
                <h2>第19条（譲渡禁止）</h2>
                <p>利用者は、当社の事前の書面による承諾なく、本規約上の地位または権利義務を第三者に譲渡してはなりません。</p>
            </article>

            <article class="terms-section">
                <h2>第20条（反社会的勢力の排除）</h2>
                <p>利用者は、現在および将来にわたって、以下のいずれにも該当しないことを表明し、保証します。</p>
                
                <ul class="terms-list">
                    <li>暴力団、暴力団員、暴力団準構成員、暴力団関係企業、総会屋等</li>
                    <li>反社会的勢力に資金提供等を行う者</li>
                    <li>反社会的勢力を不当に利用する者</li>
                    <li>その他、反社会的勢力と社会的に非難されるべき関係を有する者</li>
                </ul>
                
                <p>利用者が上記に該当することが判明した場合、当社は直ちに利用契約を解除できるものとします。</p>
            </article>

            <div class="contact-section">
                <h2 class="contact-title">
                    <i class="fas fa-phone-alt"></i> お問い合わせ窓口
                </h2>
                <div class="contact-info">
                    <p class="company-name">株式会社クロフネチンタイ管理（住み続け隊）</p>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-user"></i>
                            <span><strong>サービス責任者：</strong>黒江 貴裕</span>
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
                            <span><a href="mailto:info@sumitsuzuke-tai.jp">info@sumitsuzuke-tai.jp</a></span>
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

<!-- 専用フッター（簡易リンク追加版） -->
<footer class="simple-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-white.png" alt="住み続け隊">
                <p class="footer-tagline">リースバック一括査定サイト</p>
            </div>
            
            <div class="footer-contact">
                <div class="footer-tel">
                    <i class="fas fa-phone-alt"></i> 
                    <a href="tel:050-5810-5875">050-5810-5875</a>
                </div>
                <div class="footer-hours">
                    受付時間：9:00〜19:00（年中無休）
                </div>
            </div>
        </div>

        <!-- 簡易リンクセクション -->
        <div class="footer-links">
            <a href="<?php echo home_url(); ?>">
                <i class="fas fa-home"></i>ホーム
            </a>
            <a href="<?php echo home_url('/company/'); ?>">
                <i class="fas fa-building"></i>会社概要
            </a>
            <a href="<?php echo home_url('/privacy/'); ?>">
                <i class="fas fa-shield-alt"></i>プライバシーポリシー
            </a>
            <a href="<?php echo home_url('/terms/'); ?>">
                <i class="fas fa-file-contract"></i>利用規約
            </a>
        </div>

        <div class="footer-bottom">
            <p class="copyright">&copy; <?php echo date('Y'); ?> 住み続け隊 All Rights Reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>