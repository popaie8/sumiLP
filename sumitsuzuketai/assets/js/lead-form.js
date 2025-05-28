import NiceSelect from 'nice-select2';

const zip = document.querySelector('input[name="zip"]')?.value;

// 初期化：郵便番号があれば API へ
if (zip) fetchAddress(zip);

// ---------------- fetch & UI ----------------
async function fetchAddress(zip) {
  const r  = await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${zip}`);
  const js = await r.json();
  if (!js.results) return;

  const res   = js.results[0];                 // 複数該当は稀なので 0 を採用
  const prefC = res.prefcode.padStart(2,'0');
  const cityN = res.address2;                  // 市区町村名
  const town  = res.address3.replace(/(\d.*丁目?)$/, ''); // 丁目番号を除去

  // ---------- 都道府県プルダウン ----------
  const prefSel = document.querySelector('.js-pref');
  populatePref(prefSel, prefC);

  // ---------- 市区町村 ----------
  const citySel = document.querySelector('.js-city');
  citySel.innerHTML = `<option value="${cityN}">${cityN}</option>`;
  citySel.disabled = false;

  // ---------- 町名 ----------
  const townSel = document.querySelector('.js-town');
  townSel.innerHTML = `<option value="${town}">${town}</option>`;
  townSel.disabled = false;

  // ---------- 丁目 (1〜20 とりあえず) ----------
  initChome();
  NiceSelect.bind(prefSel); NiceSelect.bind(citySel); NiceSelect.bind(townSel);
}

function populatePref(sel, selected) {
  const prefs = [
    '北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県',
    '茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県',
    '新潟県','富山県','石川県','福井県','山梨県','長野県',
    '岐阜県','静岡県','愛知県','三重県',
    '滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県',
    '鳥取県','島根県','岡山県','広島県','山口県',
    '徳島県','香川県','愛媛県','高知県',
    '福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県',
    '沖縄県'
  ];

  sel.innerHTML = prefs.map((name, idx) => {
    const jis = String(idx + 1).padStart(2, '0');  // 01〜47
    const selAttr = jis === selected ? ' selected' : '';
    return `<option value="${name}"${selAttr}>${name}</option>`;
  }).join('');
}


function initChome(max=20){
  const chomeSel = document.querySelector('.js-chome');
  chomeSel.innerHTML = '<option hidden value="">丁目</option>';
  for(let i=1;i<=max;i++){
    chomeSel.insertAdjacentHTML('beforeend', `<option value="${i}">${i}丁目</option>`);
  }
  chomeSel.disabled = false;
  NiceSelect.bind(chomeSel);
}
