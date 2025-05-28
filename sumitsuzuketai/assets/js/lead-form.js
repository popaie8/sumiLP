// 郵便番号から住所取得 + ステップフォーム制御
import NiceSelect from 'nice-select2';

// URLパラメータから郵便番号を取得
const urlParams = new URLSearchParams(window.location.search);
const zip = urlParams.get('zip') || document.querySelector('input[name="zip"]')?.value;

// 初期化：郵便番号があれば API へ
if (zip) fetchAddress(zip);

// ステップフォーム初期化
document.addEventListener('DOMContentLoaded', () => {
  new StepForm();
});

// ---------------- 住所取得関数 ----------------
async function fetchAddress(zip) {
  try {
    const r = await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${zip}`);
    const js = await r.json();
    if (!js.results) return;

    const res = js.results[0]; // 複数該当は稀なので 0 を採用
    const prefName = res.address1; // 都道府県名
    const cityName = res.address2; // 市区町村名
    const town = res.address3.replace(/(\d.*丁目?)$/, ''); // 丁目番号を除去

    // ---------- 住所表示を更新 ----------
    const prefDisplay = document.querySelector('.js-pref-display');
    const cityDisplay = document.querySelector('.js-city-display');
    const townDisplay = document.querySelector('.js-town-display');

    if (prefDisplay) prefDisplay.value = prefName;
    if (cityDisplay) cityDisplay.value = cityName;
    if (townDisplay) townDisplay.value = town;

    // ---------- 丁目プルダウン初期化 ----------
    initChome();

    // NiceSelect適用（既存のselect要素があれば）
    const selectElements = document.querySelectorAll('.js-pref, .js-city, .js-town, .js-chome');
    selectElements.forEach(select => {
      if (select && !select.hasAttribute('data-nice-select')) {
        NiceSelect.bind(select);
        select.setAttribute('data-nice-select', 'true');
      }
    });
  } catch (error) {
    console.error('住所取得エラー:', error);
  }
}

function initChome(max = 20) {
  const chomeSel = document.querySelector('.js-chome');
  if (!chomeSel) return;
  
  chomeSel.innerHTML = '<option value="">選択してください</option>';
  for (let i = 1; i <= max; i++) {
    chomeSel.insertAdjacentHTML('beforeend', `<option value="${i}">${i}丁目</option>`);
  }
}

// ---------------- ステップフォーム制御クラス ----------------
class StepForm {
  constructor() {
    this.currentStep = 1;
    this.totalSteps = 3;
    this.propertyType = document.getElementById('propertyType')?.value || 'mansion-unit';
    this.init();
  }

  init() {
    this.bindEvents();
    this.updateUI();
  }

  bindEvents() {
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const form = document.getElementById('detailForm');

    if (nextBtn) nextBtn.addEventListener('click', () => this.nextStep());
    if (prevBtn) prevBtn.addEventListener('click', () => this.prevStep());
    if (form) form.addEventListener('submit', (e) => this.handleSubmit(e));
  }

  nextStep() {
    if (this.validateCurrentStep()) {
      if (this.currentStep < this.totalSteps) {
        this.currentStep++;
        this.updateUI();
        
        // Step 2に入る時に物件詳細を生成
        if (this.currentStep === 2) {
          this.generatePropertyDetails();
        }
      }
    }
  }

  prevStep() {
    if (this.currentStep > 1) {
      this.currentStep--;
      this.updateUI();
    }
  }

  validateCurrentStep() {
    const currentStepElement = document.querySelector(`.step-content[data-step="${this.currentStep}"]`);
    if (!currentStepElement) return true;

    const requiredFields = currentStepElement.querySelectorAll('[required]');
    
    for (let field of requiredFields) {
      if (!field.value.trim()) {
        field.focus();
        alert('必須項目を入力してください');
        return false;
      }
    }
    return true;
  }

  updateUI() {
    // ステップコンテンツの表示切り替え
    document.querySelectorAll('.step-content').forEach(content => {
      content.classList.remove('active');
    });
    const activeStep = document.querySelector(`.step-content[data-step="${this.currentStep}"]`);
    if (activeStep) activeStep.classList.add('active');

    // ステップインジケーターの更新
    document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
      const stepNum = index + 1;
      indicator.classList.remove('active', 'completed');
      
      if (stepNum === this.currentStep) {
        indicator.classList.add('active');
      } else if (stepNum < this.currentStep) {
        indicator.classList.add('completed');
      }
    });

    // プログレスバーの更新
    const progressPercentage = (this.currentStep / this.totalSteps) * 100;
    const progressFill = document.getElementById('progressFill');
    if (progressFill) progressFill.style.width = `${progressPercentage}%`;

    // ボタンの表示制御
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    if (prevBtn) prevBtn.style.display = this.currentStep === 1 ? 'none' : 'block';
    if (nextBtn) nextBtn.style.display = this.currentStep === this.totalSteps ? 'none' : 'block';
    if (submitBtn) submitBtn.style.display = this.currentStep === this.totalSteps ? 'block' : 'none';
  }

  generatePropertyDetails() {
    const container = document.getElementById('propertyDetails');
    if (!container) return;

    const propertyType = this.propertyType;
    let html = '';
    
    switch (propertyType) {
      case 'mansion-unit':
        html = this.generateMansionForm();
        break;
      case 'house':
        html = this.generateHouseForm();
        break;
      case 'land':
        html = this.generateLandForm();
        break;
      case 'mansion-building':
      case 'building':
      case 'apartment-building':
        html = this.generateBuildingForm();
        break;
      case 'other':
        html = this.generateOtherForm();
        break;
      default:
        html = this.generateMansionForm();
    }
    
    container.innerHTML = html;
    this.bindAreaUnitEvents();
  }

  generateMansionForm() {
    return `
      <div class="form-row">
        <div class="form-group">
          <label>間取り</label>
          <div class="layout-input">
            <div class="layout-rooms">
              <select name="layout_rooms">
                <option value="">部屋数を選択</option>
                ${Array.from({length: 9}, (_, i) => `<option value="${i+1}">${i+1}</option>`).join('')}
              </select>
            </div>
            <div class="layout-type">
              <select name="layout_type">
                <option value="">タイプを選択</option>
                <option value="ワンルーム">ワンルーム</option>
                <option value="K">K</option>
                <option value="DK">DK</option>
                <option value="LK">LK</option>
                <option value="LDK">LDK</option>
                <option value="SK">SK</option>
                <option value="SDK">SDK</option>
                <option value="SLK">SLK</option>
                <option value="SLDK">SLDK</option>
              </select>
            </div>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>専有面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="area" min="1" placeholder="例）80" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>築年数（経過年数）</label>
          <select name="age">
            <option value="">築年数を選択</option>
            ${Array.from({length: 31}, (_, i) => `<option value="${i}">${i}年</option>`).join('')}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  generateHouseForm() {
    return `
      <div class="form-row">
        <div class="form-group">
          <label>間取り</label>
          <div class="layout-input">
            <div class="layout-rooms">
              <select name="layout_rooms">
                <option value="">部屋数を選択</option>
                ${Array.from({length: 9}, (_, i) => `<option value="${i+1}">${i+1}</option>`).join('')}
              </select>
            </div>
            <div class="layout-type">
              <select name="layout_type">
                <option value="">タイプを選択</option>
                <option value="ワンルーム">ワンルーム</option>
                <option value="K">K</option>
                <option value="DK">DK</option>
                <option value="LK">LK</option>
                <option value="LDK">LDK</option>
                <option value="SK">SK</option>
                <option value="SDK">SDK</option>
                <option value="SLK">SLK</option>
                <option value="SLDK">SLDK</option>
              </select>
            </div>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>建物面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="building_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="building_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="building_area" min="1" placeholder="例）120" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>土地面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="land_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="land_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="land_area" min="1" placeholder="例）150" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>築年数（経過年数）</label>
          <select name="age">
            <option value="">築年数を選択</option>
            ${Array.from({length: 31}, (_, i) => `<option value="${i}">${i}年</option>`).join('')}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  generateLandForm() {
    return `
      <div class="form-row">
        <div class="form-group">
          <label>土地面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="land_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="land_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="land_area" min="1" placeholder="例）200" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  generateBuildingForm() {
    return `
      <div class="form-row">
        <div class="form-group">
          <label>建物面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="building_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="building_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="building_area" min="1" placeholder="例）500" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>土地面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="land_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="land_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="land_area" min="1" placeholder="例）300" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>築年数（経過年数）</label>
          <select name="age">
            <option value="">築年数を選択</option>
            ${Array.from({length: 31}, (_, i) => `<option value="${i}">${i}年</option>`).join('')}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  generateOtherForm() {
    return `
      <div class="form-row">
        <div class="form-group">
          <label>種類</label>
          <select name="other_type">
            <option value="">--- 選択してください ---</option>
            <option value="ビル（区分）">ビル（区分）</option>
            <option value="店舗">店舗</option>
            <option value="倉庫">倉庫</option>
            <option value="その他">その他</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>建物面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="building_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="building_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="building_area" min="1" placeholder="例）200" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>土地面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="land_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="land_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="land_area" min="1" placeholder="例）150" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>築年数（経過年数）</label>
          <select name="age">
            <option value="">築年数を選択</option>
            ${Array.from({length: 31}, (_, i) => `<option value="${i}">${i}年</option>`).join('')}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  bindAreaUnitEvents() {
    // 面積単位の切り替えイベント
    document.querySelectorAll('input[name$="_unit"]').forEach(radio => {
      radio.addEventListener('change', (e) => {
        const unitSpan = e.target.closest('.form-group').querySelector('.area-unit');
        if (unitSpan) {
          unitSpan.textContent = e.target.value;
        }
      });
    });

    // NiceSelectを新しく生成されたselect要素に適用
    const newSelects = document.querySelectorAll('#propertyDetails select:not([data-nice-select])');
    newSelects.forEach(select => {
      try {
        NiceSelect.bind(select);
        select.setAttribute('data-nice-select', 'true');
      } catch (error) {
        console.warn('NiceSelect binding failed:', error);
      }
    });
  }

  handleSubmit(e) {
    e.preventDefault();
    if (this.validateCurrentStep()) {
      // 実際の送信処理
      e.target.submit();
    }
  }
}