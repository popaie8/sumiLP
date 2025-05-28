<?php
/*  LP ヒーロー直下などで
 *  <?php get_template_part( 'template-parts/main-form' ); ?>
 *  と呼び出してください。
 *
 *  送信先は /lead-step2/（詳細フォーム用固定ページ）を想定。
 *  URL を変える場合は <form action="..."> を書き換えてください。
 */
?>
<section id="assessment-form" class="main-form">
  <div class="container">
    <div class="form-container">
      <!-- ── ヘッダー ─────────────────────────── -->
      <header class="form-header">
        <h2 class="form-title">60秒で概算査定額をチェック</h2>
        <p  class="form-subtitle">郵便番号と物件種別だけで OK！</p>
      </header>

      <!-- ── 本体 ───────────────────────────── -->
      <div class="form-body">
        <form action="<?php echo esc_url( home_url( '/lead-step2/' ) ); ?>"
              method="get" class="js-simple-form">

          <!-- 郵便番号 -->
          <div class="form-group">
            <label for="zip">郵便番号 <span class="req">必須</span></label>
            <input type="text" id="zip" name="zip"
                   placeholder="例）1234567"
                   maxlength="7" pattern="\d{7}" required>
          </div>

          <!-- 物件種別（ご要望の 7 項目に修正） -->
          <div class="form-group">
            <label for="property-type">物件種別 <span class="req">必須</span></label>
            <select id="property-type" name="property-type" required>
              <option value="" hidden>選択してください</option>
              <option value="mansion-unit">マンション（区分）</option>
              <option value="house">一戸建て</option>
              <option value="land">土地</option>
              <option value="mansion-building">マンション一棟</option>
              <option value="building">ビル一棟</option>
              <option value="apartment-building">アパート一棟</option>
              <option value="other">その他</option>
            </select>
          </div>

          <!-- 送信ボタン -->
          <button type="submit" class="submit-button">
            無料査定スタート
          </button>

          <!-- 後続ページ識別（任意） -->
          <input type="hidden" name="step" value="1">
        </form>

        <!-- ベネフィット表示 -->
        <ul class="form-benefits">
          <li><i class="fas fa-check-circle"></i> 完全無料・匿名査定</li>
          <li><i class="fas fa-lock"></i> SSL暗号化通信で安心</li>
          <li><i class="fas fa-bolt"></i> 最大10社に一括依頼</li>
        </ul>
      </div>
    </div>
  </div>
</section>
