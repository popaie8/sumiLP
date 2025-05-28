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

      <form action="<?= esc_url( admin_url( 'admin-post.php' ) ); ?>"
            method="post" class="js-detail-form">

        <!-- ─────────  hidden 必須パラメータ  ───────── -->
        <input type="hidden" name="action"     value="lead_submit">
        <input type="hidden" name="zip"        value="<?= esc_attr( $zip ); ?>">
        <input type="hidden" name="property-type" value="<?= esc_attr( $type ); ?>">
        <input type="hidden" name="inq_type"   value="51">

        <!-- ─────────  1. 住所  ───────── -->
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
              <label>都道府県 <span class="req">必須</span></label>
              <select name="pref" class="js-pref" required>
                <option hidden value="">自動取得中…</option>
              </select>
            </div>
            <div class="form-group">
              <label>市区町村 <span class="req">必須</span></label>
              <select name="city" class="js-city" required disabled>
                <option hidden value="">選択してください</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>町名 <span class="req">必須</span></label>
              <select name="town" class="js-town" required disabled>
                <option hidden value="">選択してください</option>
              </select>
            </div>
            <div class="form-group">
              <label>丁目 <span class="req">必須</span></label>
              <select name="chome" class="js-chome" required disabled>
                <option hidden value="">丁目</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>番地・号・建物名・部屋番号 <span class="req">必須</span></label>
              <input type="text" name="banchi" placeholder="例）5-10-3 ○○マンション101" required>
            </div>
          </div>
        </fieldset>

        <!-- ─────────  2. 物件詳細  ───────── -->
        <fieldset class="form-block">
          <legend>物件情報</legend>

          <div class="form-row">
            <div class="form-group">
              <label>専有 / 延床面積 <span class="req">必須</span></label>
              <div class="with-unit">
                <input type="number" name="area" min="1" placeholder="例）80" required>
                <span class="unit">㎡</span>
              </div>
            </div>
            <div class="form-group">
              <label>築年数 <span class="req">必須</span></label>
              <div class="with-unit">
                <input type="number" name="age" min="0" placeholder="例）15" required>
                <span class="unit">年</span>
              </div>
            </div>
          </div>
        </fieldset>

        <!-- ─────────  3. ご連絡先  ───────── -->
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
            <label class="agree">
              <input type="checkbox" name="agree" required>
              <span> <a href="/terms" target="_blank">利用規約</a> と
              <a href="/privacy" target="_blank">プライバシーポリシー</a> に同意する</span>
            </label>
          </div>
        </fieldset>

        <!-- ─────────  送信  ───────── -->
        <button type="submit" class="submit-button">無料査定を依頼する</button>
      </form>
    </div>
  </div>
</section>
<?php get_footer(); ?>
