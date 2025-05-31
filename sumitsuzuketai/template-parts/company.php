<?php
/**
 * Template Name: 会社概要
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
  max-width: 1000px;
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

/* 会社概要ページのスタイル */
.company-page {
  padding: 40px 0 60px;
  background-color: #f8f9fa;
  min-height: calc(100vh - 200px);
}

.company-page .page-container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 20px;
}

.company-page .page-header {
  text-align: center;
  margin-bottom: 50px;
}

.company-page .page-title {
  font-size: 36px;
  color: #152C5B;
  margin-bottom: 15px;
  font-weight: bold;
}

.company-page .page-subtitle {
  font-size: 18px;
  color: #666;
  margin: 0;
}

.company-page .company-content {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.company-page .company-info-section {
  background: white;
  border-radius: 15px;
  padding: 40px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.company-page .company-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 16px;
}

.company-page .company-table tbody tr {
  border-bottom: 1px solid #eee;
}

.company-page .company-table tbody tr:last-child {
  border-bottom: none;
}

.company-page .company-table th,
.company-page .company-table td {
  padding: 20px;
  text-align: left;
  vertical-align: top;
}

.company-page .company-table th {
  background-color: #f8f9fa;
  font-weight: bold;
  width: 200px;
  color: #152C5B;
  border-right: 1px solid #eee;
}

.company-page .company-table td {
  color: #555;
  line-height: 1.7;
}

.company-page .tel-link {
  color: #152C5B;
  text-decoration: none;
  font-weight: bold;
  font-size: 18px;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.company-page .tel-link:hover {
  color: #4A90E2;
  text-decoration: underline;
  transform: translateY(-1px);
}

.company-page .tel-link i {
  color: #4A90E2;
  font-size: 16px;
}

.company-page .highlight-number {
  font-size: 20px;
  font-weight: bold;
  color: #FF6A3D;
}

.company-page .section-title {
  font-size: 28px;
  color: #152C5B;
  margin-bottom: 30px;
  text-align: center;
  font-weight: bold;
}

.company-page .section-title i {
  margin-right: 10px;
  color: #4A90E2;
}

.company-page .access-section {
  background: white;
  border-radius: 15px;
  padding: 40px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.company-page .map-container {
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
  margin-bottom: 30px;
  height: 300px;
}

.company-page .map-placeholder {
  height: 100%;
  background: linear-gradient(135deg, #e3f2fd, #bbdefb);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #666;
  flex-direction: column;
  text-align: center;
}

.company-page .map-placeholder i {
  font-size: 48px;
  color: #4A90E2;
  margin-bottom: 10px;
}

.company-page .map-placeholder p {
  font-size: 18px;
  margin: 10px 0;
  font-weight: 500;
}

.company-page .map-placeholder small {
  font-size: 12px;
  opacity: 0.7;
}

.company-page .access-info {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}

.company-page .access-item {
  text-align: center;
  padding: 20px;
  background: #f8f9fa;
  border-radius: 10px;
  transition: transform 0.2s ease;
}

.company-page .access-item:hover {
  transform: translateY(-2px);
}

.company-page .access-item h3 {
  color: #152C5B;
  margin-bottom: 10px;
  font-size: 18px;
}

.company-page .access-item h3 i {
  color: #4A90E2;
  margin-right: 8px;
}

.company-page .access-item p {
  color: #666;
  margin: 0;
  font-size: 16px;
}

.company-page .company-mission {
  background: white;
  border-radius: 15px;
  padding: 40px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.company-page .mission-content {
  text-align: center;
}

.company-page .mission-content blockquote {
  font-size: 18px;
  line-height: 1.8;
  color: #555;
  font-style: italic;
  position: relative;
  margin: 0;
  padding: 30px;
  background: linear-gradient(135deg, #f8f9fa, #e3f2fd);
  border-radius: 15px;
  border-left: 5px solid #4A90E2;
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

/* 🔥 修正: 専用フッター（簡易リンク追加） */
.simple-footer {
  background-color: #152C5B;
  color: #fff;
  padding: 30px 0 20px;
  margin-top: 40px;
  font-family: "Hiragino Sans", "Hiragino Kaku Gothic ProN", Meiryo, sans-serif;
}

.simple-footer .footer-container {
  max-width: 1000px;
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

/* 🔥 追加: 簡易リンクセクション */
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
  
  .company-page .page-container {
    padding: 0 15px;
  }
  
  .company-page .page-title {
    font-size: 28px;
  }
  
  .company-page .company-info-section,
  .company-page .access-section,
  .company-page .company-mission {
    padding: 25px 20px;
    border-radius: 10px;
  }
  
  .company-page .company-table th,
  .company-page .company-table td {
    padding: 15px 10px;
    display: block;
    width: 100%;
    border: none;
  }
  
  .company-page .company-table th {
    background: #152C5B;
    color: white;
    border-radius: 5px 5px 0 0;
    border-right: none;
  }
  
  .company-page .company-table td {
    background: #f8f9fa;
    border-radius: 0 0 5px 5px;
    margin-bottom: 20px;
    border-bottom: 2px solid #eee;
  }
  
  .company-page .access-info {
    grid-template-columns: 1fr;
    gap: 15px;
  }
  
  .company-page .mission-content blockquote {
    font-size: 16px;
    padding: 20px;
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
  
  /* 🔥 追加: モバイル用リンク調整 */
  .simple-footer .footer-links {
    flex-direction: column;
    gap: 15px;
    align-items: center;
  }
  
  .simple-footer .footer-links a {
    font-size: 13px;
  }
}

/* 🔥 追加: 480px以下でのさらなる調整 */
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
                <span class="current">会社概要</span>
            </li>
        </ul>
    </nav>
</div>

<main class="company-page">
    <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">会社概要</h1>
            <p class="page-subtitle">住み続け隊について</p>
        </div>

        <div class="company-content">
            <!-- 企業理念を最初に配置 -->
            <div class="company-mission">
                <h2 class="section-title">企業理念</h2>
                <div class="mission-content">
                    <blockquote>
                        人生の重みを背負いながらも、決して諦めない。<br><br>
                        
                        家族との思い出が刻まれたその場所で、あなたが生き続けることを私たちは全力で支えます。<br><br>
                        
                        リースバックは単なる金融商品ではありません。それは、人生の再出発への希望であり、家族への愛情を形にする手段であり、未来への新たな扉を開く鍵なのです。<br><br>
                        
                        私たちは、お客様一人ひとりの物語に寄り添い、最適な選択肢を見つけ出すことで、「住み続ける」という当たり前の幸せを守り抜きます。<br><br>
                        
                        <strong>あなたの「今」を大切にし、「未来」に希望を灯す。</strong><br>
                        それが、住み続け隊の使命です。
                    </blockquote>
                </div>
            </div>

            <!-- 会社概要情報 -->
            <div class="company-info-section">
                <h2 class="section-title">会社情報</h2>
                <table class="company-table">
                    <tbody>
                        <tr>
                            <th>会社名</th>
                            <td>株式会社クロフネチンタイ管理</td>
                        </tr>
                        <tr>
                            <th>代表者</th>
                            <td>代表取締役 黒江 貴裕</td>
                        </tr>
                        <tr>
                            <th>設立</th>
                            <td>令和5年7月6日（2023年7月6日）</td>
                        </tr>
                        <tr>
                            <th>資本金</th>
                            <td>300万円</td>
                        </tr>
                        <tr>
                            <th>所在地</th>
                            <td>
                                〒230-0011<br>
                                神奈川県横浜市鶴見区上末吉四丁目11番4号<br>
                                アネックス第一ハイムA棟102
                            </td>
                        </tr>
                        <tr>
                            <th>電話番号</th>
                            <td>
                                <a href="tel:050-5810-5875" class="tel-link">
                                    <i class="fas fa-phone-alt"></i>
                                    050-5810-5875
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>営業時間</th>
                            <td>9:00〜19:00（年中無休）</td>
                        </tr>
                        <tr>
                            <th>事業内容</th>
                            <td>
                                ・リースバック一括査定サービスの提供<br>
                                ・不動産仲介業<br>
                                ・不動産コンサルティング業務<br>
                                ・Webメディア運営
                            </td>
                        </tr>
                        <tr>
                            <th>許可・登録</th>
                            <td>
                                宅地建物取引業免許　東京都知事(1)第XXXXX号<br>
                                一般社団法人全国宅地建物取引業協会連合会会員<br>
                                公益社団法人首都圏不動産公正取引協議会加盟
                            </td>
                        </tr>
                        <tr>
                            <th>提携会社数</th>
                            <td class="highlight-number">200社以上</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- アクセス情報を最後に配置 -->
            <div class="access-section">
                <h2 class="section-title">
                    <i class="fas fa-map-marker-alt"></i> アクセス
                </h2>
                
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17283.50939876552!2d139.6659718!3d35.529002399999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60185fc0e19d7679%3A0x37e4acf29e1243d3!2z44Ki44ON44OD44Kv44K556ys77yR44OP44Kk44OgQ-ajnw!5e1!3m2!1sja!2sjp!4v1748572404970!5m2!1sja!2sjp" 
                        width="100%" 
                        height="400" 
                        style="border:0; border-radius: 10px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
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

<!-- 🔥 修正: 専用フッター（簡易リンク追加版） -->
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

        <!-- 🔥 追加: 簡易リンクセクション -->
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