<?php
/**
 * Template Name: 詳細査定フォーム (Step-2)
 * URL 例： /lead-step2/?zip=1234567&property-type=mansion-unit
 */
get_header();

// Step-1 から渡ってきた値を取得
$zip  = sanitize_text_field( $_GET['zip']  ?? '' );
$type = sanitize_text_field( $_GET['property-type'] ?? '' );

// 物件種別ラベル — Step-1 と同じ並びで
$labels = [
  'mansion-unit'       => 'マンション（区分）',
  'house'              => '一戸建て',
  'land'               => '土地',
  'mansion-building'   => 'マンション一棟',
  'building'           => 'ビル一棟',
  'apartment-building' => 'アパート一棟',
  'other'              => 'その他',
];
?>

<style>
/* パンくずリストのスタイル */
.breadcrumb-container {
  background-color: #f8f9fa;
  padding: 15px 0;
  border-bottom: 1px solid #e0e0e0;
}

.breadcrumb {
  max-width: 820px;
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

/* 戻るボタン */
.back-to-home {
  text-align: center;
  margin: 20px 0 0;
}

.back-button {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #152C5B;
  color: white;
  padding: 12px 25px;
  border-radius: 50px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease;
  box-shadow: 0 3px 10px rgba(21, 44, 91, 0.3);
  font-size: 14px;
}

.back-button:hover {
  background: #4A90E2;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
  color: white;
  text-decoration: none;
}

.back-button i {
  font-size: 14px;
}

/* 🔥 3列レイアウト用のスタイル追加 */
.form-row.three-col {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.form-row.three-col .form-group {
  flex: 1;
  min-width: 0; /* flexアイテムの最小幅をリセット */
}

/* モバイルでも横並びを維持 */
@media (max-width: 768px) {
  .form-row.three-col {
    gap: 8px; /* モバイルではギャップを狭める */
  }
  
  .form-row.three-col .form-group {
    flex: 1;
    min-width: 0;
  }
  
  /* モバイル用のフォント・パディング調整 */
  .form-row.three-col .form-group label {
    font-size: 14px;
    margin-bottom: 4px;
  }
  
  .form-row.three-col .form-group input {
    padding: 12px 10px;
    font-size: 14px;
  }
}

@media (max-width: 480px) {
  .form-row.three-col {
    gap: 6px; /* さらに狭いギャップ */
  }
  
  .form-row.three-col .form-group label {
    font-size: 12px;
    margin-bottom: 3px;
  }
  
  .form-row.three-col .form-group input {
    padding: 10px 8px;
    font-size: 14px;
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
                <span class="current">無料査定フォーム</span>
            </li>
        </ul>
    </nav>
</div>

<section class="lead-form" id="lead-form-section">
  <div class="container">
    <div class="form-wrapper">
      <h2 class="lead-title">物件詳細とご連絡先を入力してください</h2>

      <!-- プログレスメーター -->
      <div class="progress-container">
        <div class="progress-bar">
          <div class="progress-fill" id="progressFill"></div>
        </div>
        <div class="step-indicators">
          <div class="step-indicator active" data-step="1">
            <div class="step-number">1</div>
            <div class="step-label">物件所在地</div>
          </div>
          <div class="step-indicator" data-step="2">
            <div class="step-number">2</div>
            <div class="step-label">物件情報</div>
          </div>
          <div class="step-indicator" data-step="3">
            <div class="step-number">3</div>
            <div class="step-label">お客様情報</div>
          </div>
        </div>
      </div>

      <!-- フォーム -->
      <form action="<?= esc_url( admin_url( 'admin-post.php' ) ); ?>"
            method="post" class="js-detail-form" id="detailForm">

        <!-- hidden 必須パラメータ -->
        <input type="hidden" name="action" value="lead_submit">
        <input type="hidden" name="zip" value="<?= esc_attr( $zip ); ?>">
        <input type="hidden" name="property-type" value="<?= esc_attr( $type ); ?>" id="propertyType">
        <input type="hidden" name="inq_type" value="51">
        <?php wp_nonce_field( 'lead_form_nonce', 'nonce' ); ?>

        <!-- Step 1: 物件所在地 -->
        <div class="step-content active" data-step="1">
          <fieldset class="form-block">
            <legend>物件所在地</legend>

            <div class="form-row two-col">
              <div class="form-group">
                <label>郵便番号</label>
                <input type="text" class="readonly" value="<?= esc_attr( $zip ); ?>" readonly>
              </div>
              <div class="form-group">
                <label>物件種別</label>
                <input type="text" class="readonly" value="<?= esc_html( $labels[$type] ?? '' ); ?>" readonly>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>都道府県</label>
                <input type="text" name="pref" class="readonly js-pref-display" value="自動取得中…" readonly>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>市区町村</label>
                <input type="text" name="city" class="readonly js-city-display" value="自動取得中…" readonly>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>町名</label>
                <input type="text" name="town" class="readonly js-town-display" value="自動取得中…" readonly>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>丁目 <span class="req">必須</span></label>
                <select name="chome" class="js-chome" required>
                  <option value="">選択してください</option>
                </select>
              </div>
            </div>

            <!-- 🔥 修正: 番地は必須、建物名・部屋番号は任意 -->
            <div class="form-row three-col">
              <div class="form-group">
                <label>番地・号 <span class="req">必須</span></label>
                <input type="text" name="banchi" placeholder="例）10-3" required>
              </div>
              <div class="form-group">
                <label>建物名</label>
                <input type="text" name="building_name" placeholder="例）○○マンション">
                <div class="note">※マンション・ビル等の場合のみ</div>
              </div>
              <div class="form-group">
                <label>部屋番号</label>
                <input type="text" name="room_number" placeholder="例）101">
                <div class="note">※マンション・アパート等の場合のみ</div>
              </div>
            </div>
          </fieldset>
        </div>

        <!-- Step 2: 物件情報 -->
        <div class="step-content" data-step="2">
          <fieldset class="form-block">
            <legend>物件情報</legend>
            <div id="propertyDetails">
              <!-- 動的に生成される物件詳細フォーム -->
            </div>
          </fieldset>
        </div>

        <!-- Step 3: お客様情報 -->
        <div class="step-content" data-step="3">
          <fieldset class="form-block">
            <legend>お客様情報</legend>

            <div class="form-row two-col">
              <div class="form-group">
                <label>お名前 <span class="req">必須</span></label>
                <input type="text" name="name" placeholder="例）山田 太郎" required>
              </div>
              <div class="form-group">
                <label>電話番号 <span class="req">必須</span></label>
                <input type="tel" name="tel" placeholder="例）090-1234-5678"
                       pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>メールアドレス <span class="req">必須</span></label>
                <input type="email" name="email" placeholder="例）sample@example.com" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>ご質問・ご要望など</label>
                <textarea name="remarks" rows="4" placeholder="査定に関するご質問やご要望がございましたら、こちらにご記入ください。&#10;（例）売却時期、価格の希望、その他気になる点など"></textarea>
                <div class="note">※任意項目です。お気軽にご記入ください。</div>
              </div>
            </div>

            <div class="form-row">
              <label class="agree">
                <input type="checkbox" name="agree" required>
                <span> <a href="/terms" target="_blank">利用規約</a> と
                <a href="/privacy" target="_blank">プライバシーポリシー</a> に同意する</span>
              </label>
            </div>
          </fieldset>
        </div>

        <!-- ボタン -->
        <div class="button-group">
          <button type="button" class="btn btn-prev" id="prevBtn" style="display: none;">戻る</button>
          <button type="button" class="btn btn-next" id="nextBtn">次へ</button>
          <button type="submit" class="btn btn-submit" id="submitBtn" style="display: none;">無料査定を依頼する</button>
        </div>
      </form>

      <!-- 戻るボタン -->
      <div class="back-to-home">
          <a href="<?php echo home_url(); ?>" class="back-button">
              <i class="fas fa-arrow-left"></i>
              ホームに戻る
          </a>
      </div>
    </div>
  </div>
</section>

<!-- スクロール修正用スクリプト -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('detailForm');
  if (form) {
    console.log('フォームaction属性:', form.getAttribute('action'));
    console.log('leadFormAjax:', window.leadFormAjax);
  }
  
  // スムーススクロール修正（ページ最上部にいかないように）
  function fixSmoothScroll() {
    const hashLinks = document.querySelectorAll('a[href^="#"]');
    
    hashLinks.forEach(function(link) {
      link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        
        if (!href || href === '#' || href === '#top') {
          e.preventDefault();
          return false;
        }
        
        const target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          
          const headerOffset = 100;
          const elementPosition = target.getBoundingClientRect().top;
          const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
          
          console.log('修正版スクロール:', href, 'オフセット:', offsetPosition);
          
          window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
          });
        } else {
          console.warn('スクロールターゲットが見つかりません:', href);
          e.preventDefault();
        }
        
        return false;
      });
    });
  }
  
  setTimeout(fixSmoothScroll, 500);
});
</script>

<!-- 簡易フッター（詳細フォーム用） -->
<footer class="simple-footer">
    <style>
    .simple-footer {
        background-color: #152C5B;
        color: #fff;
        padding: 30px 0 20px;
        margin-top: 50px;
        font-family: "Hiragino Sans", "Hiragino Kaku Gothic ProN", Meiryo, sans-serif;
    }
    
    .simple-footer .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        text-align: center;
    }
    
    .simple-footer-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }
    
    .simple-footer-logo {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    
    .simple-footer-logo img {
        max-width: 120px;
        height: auto;
    }
    
    .simple-footer-tagline {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
    }
    
    .simple-footer-contact {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    
    .simple-footer-tel {
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        text-decoration: none;
        transition: color 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .simple-footer-tel:hover {
        color: #4A90E2;
    }
    
    .simple-footer-tel i {
        color: #4A90E2;
        font-size: 18px;
    }
    
    .simple-footer-hours {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
    }
    
    .simple-footer-links {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .simple-footer-links a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-size: 14px;
        transition: color 0.2s ease;
    }
    
    .simple-footer-links a:hover {
        color: #4A90E2;
        text-decoration: underline;
    }
    
    .simple-footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        padding-top: 15px;
        margin-top: 20px;
    }
    
    .simple-footer-copyright {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
        margin: 0;
    }
    
    /* レスポンシブ対応 */
    @media (min-width: 768px) {
        .simple-footer-content {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        
        .simple-footer-logo {
            align-items: flex-start;
        }
        
        .simple-footer-contact {
            align-items: flex-end;
        }
        
        .simple-footer-tel {
            font-size: 24px;
        }
        
        .simple-footer-hours {
            font-size: 14px;
        }
    }
    
    @media (max-width: 480px) {
        .simple-footer-links {
            flex-direction: column;
            gap: 10px;
        }
        
        .simple-footer-tel {
            font-size: 18px;
        }
    }
    </style>
    
    <div class="container">
        <div class="simple-footer-content">
            <div class="simple-footer-logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-white.png" alt="すみつづけ隊">
                <p class="simple-footer-tagline">リースバック一括査定サイト</p>
            </div>
            
            <div class="simple-footer-contact">
                <a href="tel:05058105875" class="simple-footer-tel">
                    <i class="fas fa-phone-alt"></i>
                    050-5810-5875
                </a>
                <p class="simple-footer-hours">受付時間：9:00〜19:00（年中無休）</p>
            </div>
        </div>
        
        <div class="simple-footer-links">
            <a href="<?php echo home_url(); ?>">ホーム</a>
            <a href="<?php echo home_url('/company/'); ?>" target="_blank">会社概要</a>
            <a href="<?php echo home_url('/privacy/'); ?>" target="_blank">プライバシーポリシー</a>
            <a href="<?php echo home_url('/terms/'); ?>" target="_blank">利用規約</a>
        </div>
        
        <div class="simple-footer-bottom">
            <p class="simple-footer-copyright">
                &copy; <?php echo date('Y'); ?> 住み続け隊 All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>