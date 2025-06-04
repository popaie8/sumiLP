/**
 * 🔥 修正版リードフォーム制御（3つのフィールド対応）
 * 住所取得 + ステップフォーム + 入力記憶 + AJAX + モーダル
 */

// 定数
const STORAGE_KEY = 'leadFormData';

// DOM要素の取得（修正版）
const getFormElements = () => ({
  form: document.getElementById('detailForm'),
  propertyTypeInput: document.getElementById('propertyType'),
  nextBtn: document.getElementById('nextBtn'),
  prevBtn: document.getElementById('prevBtn'),
  submitBtn: document.getElementById('submitBtn'),
  progressFill: document.getElementById('progressFill'),
  propertyDetails: document.getElementById('propertyDetails')
});

// ユーティリティ関数
const utils = {
  // URLパラメータ取得
  getUrlParam: (param) => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  },

  // 🔥 完全修正版メモリストレージ（dataプロパティ初期化問題解決）
  storage: {
    // 🔥 修正: クラス外でdataプロパティを初期化
    data: {},
    
    save: function(newData) {
      try {
        // 🔥 修正: 毎回確実に初期化してからマージ
        if (!this.data || typeof this.data !== 'object') {
          this.data = {};
        }
        
        // 🔥 修正: newDataが有効な場合のみマージ
        if (newData && typeof newData === 'object') {
          this.data = { ...this.data, ...newData };
        }
        
        // sessionStorageが使える場合は併用
        if (typeof Storage !== 'undefined' && window.sessionStorage) {
          try {
            sessionStorage.setItem(STORAGE_KEY, JSON.stringify(this.data));
          } catch (e) {
            console.warn('sessionStorage保存エラー:', e);
          }
        }
        
        console.log('📝 フォームデータ保存成功:', this.data);
        return true;
      } catch (e) {
        console.error('フォームデータの保存に失敗:', e);
        // エラーでもdataは確実に初期化
        if (!this.data) {
          this.data = {};
        }
        return false;
      }
    },
    
    load: function() {
      try {
        // 🔥 修正: dataが存在しない場合は初期化
        if (!this.data || typeof this.data !== 'object') {
          this.data = {};
        }
        
        // sessionStorageから復元を試行
        if (typeof Storage !== 'undefined' && window.sessionStorage) {
          try {
            const stored = sessionStorage.getItem(STORAGE_KEY);
            if (stored) {
              const parsedData = JSON.parse(stored);
              if (parsedData && typeof parsedData === 'object') {
                this.data = parsedData;
                console.log('🔄 データ復元成功:', this.data);
                return this.data;
              }
            }
          } catch (e) {
            console.warn('sessionStorage復元エラー:', e);
          }
        }
        
        // フォールバック：メモリから返す
        console.log('🔄 メモリデータを返却:', this.data);
        return this.data;
      } catch (e) {
        console.error('フォームデータの復元に失敗:', e);
        this.data = {};
        return {};
      }
    },
    
    clear: function() {
      try {
        this.data = {};
        if (typeof Storage !== 'undefined' && window.sessionStorage) {
          sessionStorage.removeItem(STORAGE_KEY);
        }
        console.log('🗑️ データクリア完了');
      } catch (e) {
        console.warn('フォームデータのクリアに失敗:', e);
        this.data = {};
      }
    }
  },

  // 配列生成ヘルパー
  range: (length) => Array.from({ length }, (_, i) => i + 1),

  // デバウンス
  debounce: (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }
};

// 住所取得API
const addressApi = {
  async fetchAddress(zip) {
    try {
      const response = await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${zip}`);
      const data = await response.json();
      
      if (!data.results) {
        throw new Error('住所が見つかりません');
      }

      return {
        pref: data.results[0].address1,
        city: data.results[0].address2,
        town: data.results[0].address3.replace(/(\d.*丁目?)$/, '')
      };
    } catch (error) {
      console.error('住所取得エラー:', error);
      throw error;
    }
  },

  updateAddressFields({ pref, city, town }) {
    const prefDisplay = document.querySelector('.js-pref-display');
    const cityDisplay = document.querySelector('.js-city-display');
    const townDisplay = document.querySelector('.js-town-display');

    if (prefDisplay) prefDisplay.value = pref;
    if (cityDisplay) cityDisplay.value = city;
    if (townDisplay) townDisplay.value = town;
  },

  initChomeSelect(max = 20) {
    const chomeSel = document.querySelector('.js-chome');
    if (!chomeSel) return;
    
    chomeSel.innerHTML = '<option value="">選択してください</option>';
    utils.range(max).forEach(i => {
      chomeSel.insertAdjacentHTML('beforeend', `<option value="${i}">${i}丁目</option>`);
    });
  }
};

// 🔥 修正版フォームデータ管理（3つのフィールド対応）
const formDataManager = {
  saveFormData() {
    const { form } = getFormElements();
    if (!form) {
      console.warn('フォームが見つかりません');
      return false;
    }

    try {
      const formData = {};
      const inputs = form.querySelectorAll('input, select, textarea');
      
      inputs.forEach(input => {
        if (input.name && !input.classList.contains('readonly')) {
          formData[input.name] = input.type === 'checkbox' ? input.checked : input.value;
        }
      });
      
      // 🔥 修正: 3つのフィールドも確実に保存
      const banchi = form.querySelector('input[name="banchi"]');
      const buildingName = form.querySelector('input[name="building_name"]');
      const roomNumber = form.querySelector('input[name="room_number"]');
      
      if (banchi) formData.banchi = banchi.value;
      if (buildingName) formData.building_name = buildingName.value;
      if (roomNumber) formData.room_number = roomNumber.value;
      
      return utils.storage.save(formData);
    } catch (e) {
      console.error('フォームデータ保存エラー:', e);
      return false;
    }
  },

  restoreFormData() {
    const { form } = getFormElements();
    if (!form) {
      console.warn('フォームが見つかりません');
      return false;
    }

    try {
      const savedData = utils.storage.load();
      if (!savedData || typeof savedData !== 'object') {
        console.log('復元するデータがありません');
        return false;
      }

      const inputs = form.querySelectorAll('input, select, textarea');
      
      inputs.forEach(input => {
        if (input.name && savedData.hasOwnProperty(input.name) && !input.classList.contains('readonly')) {
          if (input.type === 'checkbox') {
            input.checked = Boolean(savedData[input.name]);
          } else {
            input.value = savedData[input.name] || '';
          }
        }
      });
      
      console.log('✅ フォームデータ復元完了');
      return true;
    } catch (e) {
      console.error('フォームデータ復元エラー:', e);
      return false;
    }
  },

  setupAutoSave() {
    const { form } = getFormElements();
    if (!form) {
      console.warn('フォームが見つかりません - オートセーブ無効');
      return;
    }

    const debouncedSave = utils.debounce(() => {
      this.saveFormData();
    }, 500);
    
    // 🔥 修正: エラーハンドリングを追加
    ['input', 'change', 'blur'].forEach(event => {
      try {
        form.addEventListener(event, debouncedSave, true);
      } catch (e) {
        console.warn(`${event}イベント設定エラー:`, e);
      }
    });
    
    console.log('🤖 オートセーブ設定完了');
  }
};

// ステップフォーム管理
class StepFormManager {
  constructor(propertyType = 'mansion-unit') {
    this.currentStep = 1;
    this.totalSteps = 3;
    this.propertyType = propertyType;
    
    console.log('StepFormManager初期化 - 物件種別:', this.propertyType);
    this.init();
  }

  init() {
    this.bindEvents();
    this.updateUI();
  }

  bindEvents() {
    const { nextBtn, prevBtn, form } = getFormElements();

    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.handleNext();
        return false;
      });
    }
    
    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.handlePrev();
        return false;
      });
    }
    
    if (form) {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.handleSubmit(e);
        return false;
      });
    }
  }

  handleNext() {
    console.log('次へボタン - 現在:', this.currentStep);
    
    if (!this.validateCurrentStep()) {
      console.log('バリデーション失敗');
      return;
    }
    
    if (this.currentStep < this.totalSteps) {
      this.currentStep++;
      this.updateUI();
      
      if (this.currentStep === 2) {
        this.generatePropertyDetails();
      }
    }
  }

  handlePrev() {
    if (this.currentStep > 1) {
      this.currentStep--;
      this.updateUI();
    }
  }

  // 🔥 修正版バリデーション（3つのフィールド対応・非表示フィールド除外強化）
  validateCurrentStep() {
    const currentStepElement = document.querySelector(`.step-content[data-step="${this.currentStep}"]`);
    if (!currentStepElement) {
      console.error('ステップが見つかりません:', this.currentStep);
      return false;
    }

    const requiredFields = currentStepElement.querySelectorAll('[required]');
    
    for (const field of requiredFields) {
      // 🔥 より厳密な表示・有効性チェック
      const isVisible = field.offsetParent !== null && 
                       field.offsetWidth > 0 &&
                       field.offsetHeight > 0 &&
                       field.style.display !== 'none' && 
                       field.style.visibility !== 'hidden' &&
                       !field.hasAttribute('disabled') &&
                       !field.hasAttribute('readonly');
      
      if (!isVisible) {
        console.log('非表示フィールドをスキップ:', field.name);
        continue;
      }
      
      const isEmpty = field.type === 'checkbox' ? !field.checked : !field.value?.trim();
      
      if (isEmpty) {
        console.log('必須フィールドが空:', field.name);
        
        // 🔥 安全なフォーカス処理
        try {
          if (typeof field.focus === 'function') {
            field.focus();
            field.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
        } catch (e) {
          console.warn('フォーカス不可能:', field.name, e);
        }
        
        // 🔥 フィールド固有のエラーメッセージ
        let fieldLabel = field.name;
        const labelElement = currentStepElement.querySelector(`label[for="${field.id}"], label[data-field="${field.name}"]`);
        if (labelElement) {
          fieldLabel = labelElement.textContent.replace(/\s*必須\s*/, '').trim();
        }
        
        alert(`${fieldLabel}を入力してください。`);
        return false;
      }
    }
    
    return true;
  }

  updateUI() {
    // ステップコンテンツ切り替え
    document.querySelectorAll('.step-content').forEach(content => {
      content.classList.remove('active');
    });
    
    const activeStep = document.querySelector(`.step-content[data-step="${this.currentStep}"]`);
    if (activeStep) {
      activeStep.classList.add('active');
    }

    // インジケーター更新
    document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
      const stepNum = index + 1;
      indicator.classList.remove('active', 'completed');
      
      if (stepNum === this.currentStep) {
        indicator.classList.add('active');
      } else if (stepNum < this.currentStep) {
        indicator.classList.add('completed');
      }
    });

    // プログレスバー更新
    const { progressFill } = getFormElements();
    if (progressFill) {
      const percentage = (this.currentStep / this.totalSteps) * 100;
      progressFill.style.width = `${percentage}%`;
    }

    // ボタン表示制御
    const { prevBtn, nextBtn, submitBtn } = getFormElements();
    
    if (prevBtn) prevBtn.style.display = this.currentStep === 1 ? 'none' : 'block';
    if (nextBtn) nextBtn.style.display = this.currentStep === this.totalSteps ? 'none' : 'block';
    if (submitBtn) submitBtn.style.display = this.currentStep === this.totalSteps ? 'block' : 'none';
  }

  generatePropertyDetails() {
    const { propertyDetails } = getFormElements();
    if (!propertyDetails) {
      console.error('propertyDetails コンテナが見つかりません');
      return;
    }

    console.log('物件詳細生成:', this.propertyType);
    
    const formGenerators = {
      'mansion-unit': () => this.generateMansionForm(),
      'house': () => this.generateHouseForm(),
      'land': () => this.generateLandForm(),
      'mansion-building': () => this.generateBuildingForm(),
      'building': () => this.generateBuildingForm(),
      'apartment-building': () => this.generateBuildingForm(),
      'other': () => this.generateOtherForm()
    };

    const generator = formGenerators[this.propertyType] || formGenerators['mansion-unit'];
    propertyDetails.innerHTML = generator();
    
    this.bindAreaUnitEvents();
  }

  generateMansionForm() {
    const roomOptions = utils.range(9).map(i => `<option value="${i}">${i}</option>`).join('');
    const ageOptions = utils.range(31).map(i => `<option value="${i-1}">${i-1}年</option>`).join('');

    return `
      <div class="form-row">
        <div class="form-group">
          <label>間取り（マンション区分）</label>
          <div class="layout-input">
            <div class="layout-rooms">
              <select name="layout_rooms">
                <option value="">部屋数を選択</option>
                ${roomOptions}
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
            ${ageOptions}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  generateHouseForm() {
    const roomOptions = utils.range(9).map(i => `<option value="${i}">${i}</option>`).join('');
    const ageOptions = utils.range(31).map(i => `<option value="${i-1}">${i-1}年</option>`).join('');

    return `
      <div class="form-row">
        <div class="form-group">
          <label>間取り（一戸建て）</label>
          <div class="layout-input">
            <div class="layout-rooms">
              <select name="layout_rooms">
                <option value="">部屋数を選択</option>
                ${roomOptions}
              </select>
            </div>
            <div class="layout-type">
              <select name="layout_type">
                <option value="">タイプを選択</option>
                <option value="LDK">LDK</option>
                <option value="DK">DK</option>
                <option value="SLDK">SLDK</option>
                <option value="SDK">SDK</option>
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
            ${ageOptions}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  // 🔥 修正版土地フォーム（requiredを削除）
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
      <div class="form-row">
        <div class="form-group">
          <label>備考</label>
          <textarea name="land_remarks" rows="3" placeholder="土地の特徴、用途地域、接道状況など"></textarea>
          <div class="note">※任意項目です。</div>
        </div>
      </div>
    `;
  }

  // 🔥 修正版ビルフォーム（必須項目を適切に設定）
  generateBuildingForm() {
    const ageOptions = utils.range(31).map(i => `<option value="${i-1}">${i-1}年</option>`).join('');

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
          <label>総戸数・室数</label>
          <input type="number" name="total_units" min="1" placeholder="例）10">
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>築年数（経過年数）</label>
          <select name="age">
            <option value="">築年数を選択</option>
            ${ageOptions}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  generateOtherForm() {
    const ageOptions = utils.range(31).map(i => `<option value="${i-1}">${i-1}年</option>`).join('');

    return `
      <div class="form-row">
        <div class="form-group">
          <label>種類</label>
          <select name="other_type">
            <option value="">--- 選択してください ---</option>
            <option value="ビル（区分）">ビル（区分）</option>
            <option value="店舗">店舗</option>
            <option value="倉庫">倉庫</option>
            <option value="工場">工場</option>
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
            ${ageOptions}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  bindAreaUnitEvents() {
    document.querySelectorAll('input[name$="_unit"]').forEach(radio => {
      radio.addEventListener('change', (e) => {
        const unitSpan = e.target.closest('.form-group').querySelector('.area-unit');
        if (unitSpan) {
          unitSpan.textContent = e.target.value;
        }
      });
    });
  }

  async handleSubmit(e) {
    console.log('フォーム送信処理開始');
    
    if (!this.validateCurrentStep()) {
      return;
    }
    
    await ajaxSubmitter.submit(e);
  }
}

// 🔥 修正版AJAX送信・モーダル管理
const ajaxSubmitter = {
  async submit(event) {
    const { form } = getFormElements();
    if (!form) {
      console.error('フォームが見つかりません');
      return;
    }

    console.log('AJAX送信開始');

    // UI状態管理
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn ? submitBtn.textContent : '送信';
    
    form.classList.add('form-sending');
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = '送信中...';
    }

    try {
      // 🔥 修正: フォームのaction属性を正しく取得
      let actionUrl = form.getAttribute('action');
      
      if (!actionUrl || actionUrl === '' || actionUrl.includes('[object')) {
        actionUrl = window.leadFormAjax?.ajaxurl || '/wp-admin/admin-post.php';
        console.log('フォームaction修正:', actionUrl);
      }
      
      console.log('送信先URL:', actionUrl);

      // 🔥 修正: FormDataを作成してAJAXフラグを追加
      const formData = new FormData(form);
      formData.append('ajax', '1');
      
      // 🔥 修正: 3つのフィールドの値を確実に含める
      const banchi = form.querySelector('input[name="banchi"]');
      const buildingName = form.querySelector('input[name="building_name"]');
      const roomNumber = form.querySelector('input[name="room_number"]');
      
      if (banchi && banchi.value) {
        formData.set('banchi', banchi.value);
      }
      if (buildingName && buildingName.value) {
        formData.set('building_name', buildingName.value);
      }
      if (roomNumber && roomNumber.value) {
        formData.set('room_number', roomNumber.value);
      }
      
      console.log('送信データ確認:');
      for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
      }

      // WordPress AJAX送信
      const response = await fetch(actionUrl, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      console.log('レスポンス受信:', response.status, response.statusText);
      
      if (!response.ok) {
        throw new Error(`HTTP Error: ${response.status} ${response.statusText}`);
      }

      // レスポンステキストを取得
      const responseText = await response.text();
      console.log('レスポンステキスト（最初の500文字）:', responseText.substring(0, 500));

      let data;
      try {
        // JSONパース試行
        data = JSON.parse(responseText);
        console.log('JSON解析成功:', data);
      } catch (parseError) {
        console.warn('JSON解析失敗、HTMLレスポンスを確認:', parseError);
        
        // HTMLレスポンスにエラーが含まれているかチェック
        if (responseText.includes('エラー') || responseText.includes('Fatal error') || responseText.includes('Parse error')) {
          throw new Error('サーバーでエラーが発生しました');
        }
        
        // エラーがない場合は成功とみなす
        const nameInput = form.querySelector('input[name="name"]');
        const customerName = nameInput ? nameInput.value : 'お客様';
        data = { 
          success: true, 
          data: { 
            customer_name: customerName,
            message: '送信が完了しました'
          } 
        };
      }

      if (data.success) {
        console.log('送信成功');
        this.handleSuccess(data.data?.customer_name || 'お客様');
      } else {
        throw new Error(data.data?.message || data.message || '送信に失敗しました');
      }

    } catch (error) {
      console.error('送信エラー詳細:', error);
      
      // エラーメッセージを具体的に
      let errorMessage = '送信に失敗しました。';
      
      if (error.message.includes('Failed to fetch') || error.message.includes('NetworkError')) {
        errorMessage += 'インターネット接続を確認してください。';
      } else if (error.message.includes('400')) {
        errorMessage += '入力内容に問題があります。必須項目をご確認ください。';
      } else if (error.message.includes('500')) {
        errorMessage += 'サーバーエラーが発生しました。しばらく時間をおいてお試しください。';
      } else if (error.message.includes('403')) {
        errorMessage += 'アクセスが拒否されました。ページを再読み込みしてお試しください。';
      } else if (error.message.includes('404')) {
        errorMessage += 'URL が見つかりません。ページを再読み込みしてお試しください。';
      } else {
        errorMessage += `詳細: ${error.message}`;
      }
      
      alert(errorMessage);
    } finally {
      // UI状態復元
      form.classList.remove('form-sending');
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
      }
    }
  },

  handleSuccess(customerName) {
    console.log('送信成功処理:', customerName);
    
    // フォームリセット
    const { form } = getFormElements();
    if (form) {
      form.reset();
    }
    
    // データクリア
    utils.storage.clear();
    
    // ステップ1に戻る
    if (window.stepFormManager) {
      window.stepFormManager.currentStep = 1;
      window.stepFormManager.updateUI();
    }
    
    // モーダル表示
    modalManager.show(customerName);
  }
};

// モーダル管理
const modalManager = {
  show(customerName = '') {
    console.log('モーダル表示:', customerName);
    
    let modal = document.getElementById('thanksModal');
    
    if (!modal) {
      this.create();
      modal = document.getElementById('thanksModal');
    }
    
    if (customerName) {
      const messageEl = modal.querySelector('.thanks-message');
      messageEl.innerHTML = `
        <p><strong>${customerName}様</strong></p>
        <p>査定依頼を受け付けました。<br>
        担当者から<strong>24時間以内</strong>にご連絡いたします。</p>
        <p>しばらくお待ちください。</p>
      `;
    }
    
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
  },

  hide() {
    const modal = document.getElementById('thanksModal');
    if (modal) {
      modal.classList.remove('show');
      document.body.style.overflow = '';
      
      setTimeout(() => modal.remove(), 300);
    }
  },

  create() {
    const modalHtml = `
      <div id="thanksModal" class="thanks-modal">
        <div class="thanks-modal-content">
          <div class="thanks-icon">
            <i class="fas fa-check"></i>
          </div>
          <h2 class="thanks-title">お問い合わせありがとうございます</h2>
          <div class="thanks-message">
            <p>査定依頼を受け付けました。<br>
            担当者から<strong>24時間以内</strong>にご連絡いたします。</p>
            <p>しばらくお待ちください。</p>
          </div>
          <div class="thanks-buttons">
            <a href="/" class="thanks-btn thanks-btn-primary">
              <i class="fas fa-home"></i> ホームに戻る
            </a>
            <button type="button" class="thanks-btn thanks-btn-secondary" onclick="modalManager.hide()">
              <i class="fas fa-times"></i> 閉じる
            </button>
          </div>
        </div>
      </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHtml);
  }
};

// グローバルイベントリスナー
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    modalManager.hide();
  }
});

document.addEventListener('click', (e) => {
  if (e.target?.id === 'thanksModal') {
    modalManager.hide();
  }
});

// グローバル関数（テンプレート用）
window.closeThanksModal = () => modalManager.hide();
window.modalManager = modalManager; // グローバルアクセス用

// 🔥 修正版初期化（3つのフィールド対応）
document.addEventListener('DOMContentLoaded', async () => {
  console.log('🔥 リードフォーム初期化開始（3つのフィールド対応版）');
  
  try {
    const { form, propertyTypeInput } = getFormElements();
    
    if (!form) {
      console.error('フォームが見つかりません');
      return;
    }

    // 物件種別取得
    const propertyType = propertyTypeInput?.value || utils.getUrlParam('property-type') || 'mansion-unit';
    console.log('物件種別:', propertyType);

    // ステップフォーム初期化
    const stepFormManager = new StepFormManager(propertyType);
    window.stepFormManager = stepFormManager;

    // データ管理初期化
    formDataManager.restoreFormData();
    formDataManager.setupAutoSave();

    // 住所API初期化
    const zip = utils.getUrlParam('zip') || document.querySelector('input[name="zip"]')?.value;
    if (zip) {
      try {
        const address = await addressApi.fetchAddress(zip);
        addressApi.updateAddressFields(address);
        addressApi.initChomeSelect();
      } catch (error) {
        console.warn('住所取得に失敗しました:', error);
      }
    }

    // 🔥 追加: 3つのフィールドの初期化確認
    setTimeout(() => {
      const banchi = form.querySelector('input[name="banchi"]');
      const buildingName = form.querySelector('input[name="building_name"]');
      const roomNumber = form.querySelector('input[name="room_number"]');
      
      console.log('🔥 3つのフィールド確認:', {
        banchi: banchi ? banchi.value : 'フィールドなし',
        building_name: buildingName ? buildingName.value : 'フィールドなし',
        room_number: roomNumber ? roomNumber.value : 'フィールドなし'
      });
    }, 1000);

    console.log('✅ リードフォーム初期化完了（3つのフィールド対応版）');
    
  } catch (error) {
    console.error('❌ リードフォーム初期化エラー:', error);
  }
});

// 🔥 デバッグ用関数
window.debugFormData = () => {
  const { form } = getFormElements();
  if (!form) {
    console.log('フォームが見つかりません');
    return;
  }
  
  const formData = new FormData(form);
  console.log('🔍 現在のフォームデータ:');
  for (let [key, value] of formData.entries()) {
    console.log(`${key}: ${value}`);
  }
  
  // 3つのフィールドを特別にチェック
  const banchi = form.querySelector('input[name="banchi"]');
  const buildingName = form.querySelector('input[name="building_name"]');
  const roomNumber = form.querySelector('input[name="room_number"]');
  
  console.log('🔍 3つのフィールドの状態:');
  console.log('番地・号:', banchi ? banchi.value : 'フィールドなし');
  console.log('建物名:', buildingName ? buildingName.value : 'フィールドなし');
  console.log('部屋番号:', roomNumber ? roomNumber.value : 'フィールドなし');
};

window.debugStorage = () => {
  console.log('🔍 ストレージデータ:', utils.storage.load());
};