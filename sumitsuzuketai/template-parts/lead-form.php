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
<section class="lead-form">
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

      <form action="<?= esc_url( admin_url( 'admin-post.php' ) ); ?>"
            method="post" class="js-detail-form" id="detailForm">

        <!-- ─────────  hidden 必須パラメータ  ───────── -->
        <input type="hidden" name="action" value="lead_submit">
        <input type="hidden" name="zip" value="<?= esc_attr( $zip ); ?>">
        <input type="hidden" name="property-type" value="<?= esc_attr( $type ); ?>" id="propertyType">
        <input type="hidden" name="inq_type" value="51">

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

            <div class="form-row two-col">
              <div class="form-group">
                <label>丁目 <span class="req">必須</span></label>
                <select name="chome" class="js-chome" required>
                  <option value="">選択してください</option>
                </select>
              </div>
              <div class="form-group">
                <label>番地・号・建物名・部屋番号 <span class="req">必須</span></label>
                <input type="text" name="banchi" placeholder="例）5-10-3 ○○マンション101" required>
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
    </div>
  </div>
</section>
<?php get_footer(); ?>