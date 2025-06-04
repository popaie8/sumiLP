const S="leadFormData",d=()=>({form:document.getElementById("detailForm"),propertyTypeInput:document.getElementById("propertyType"),nextBtn:document.getElementById("nextBtn"),prevBtn:document.getElementById("prevBtn"),submitBtn:document.getElementById("submitBtn"),progressFill:document.getElementById("progressFill"),propertyDetails:document.getElementById("propertyDetails")}),c={getUrlParam:t=>new URLSearchParams(window.location.search).get(t),storage:{data:{},save:function(t){try{if((!this.data||typeof this.data!="object")&&(this.data={}),t&&typeof t=="object"&&(this.data={...this.data,...t}),typeof Storage<"u"&&window.sessionStorage)try{sessionStorage.setItem(S,JSON.stringify(this.data))}catch(e){console.warn("sessionStorage保存エラー:",e)}return console.log("📝 フォームデータ保存成功:",this.data),!0}catch(e){return console.error("フォームデータの保存に失敗:",e),this.data||(this.data={}),!1}},load:function(){try{if((!this.data||typeof this.data!="object")&&(this.data={}),typeof Storage<"u"&&window.sessionStorage)try{const t=sessionStorage.getItem(S);if(t){const e=JSON.parse(t);if(e&&typeof e=="object")return this.data=e,console.log("🔄 データ復元成功:",this.data),this.data}}catch(t){console.warn("sessionStorage復元エラー:",t)}return console.log("🔄 メモリデータを返却:",this.data),this.data}catch(t){return console.error("フォームデータの復元に失敗:",t),this.data={},{}}},clear:function(){try{this.data={},typeof Storage<"u"&&window.sessionStorage&&sessionStorage.removeItem(S),console.log("🗑️ データクリア完了")}catch(t){console.warn("フォームデータのクリアに失敗:",t),this.data={}}}},range:t=>Array.from({length:t},(e,o)=>o+1),debounce:(t,e)=>{let o;return function(...n){const l=()=>{clearTimeout(o),t(...n)};clearTimeout(o),o=setTimeout(l,e)}}},w={async fetchAddress(t){try{const o=await(await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${t}`)).json();if(!o.results)throw new Error("住所が見つかりません");return{pref:o.results[0].address1,city:o.results[0].address2,town:o.results[0].address3.replace(/(\d.*丁目?)$/,"")}}catch(e){throw console.error("住所取得エラー:",e),e}},updateAddressFields({pref:t,city:e,town:o}){const a=document.querySelector(".js-pref-display"),n=document.querySelector(".js-city-display"),l=document.querySelector(".js-town-display");a&&(a.value=t),n&&(n.value=e),l&&(l.value=o)},initChomeSelect(t=20){const e=document.querySelector(".js-chome");e&&(e.innerHTML='<option value="">選択してください</option>',c.range(t).forEach(o=>{e.insertAdjacentHTML("beforeend",`<option value="${o}">${o}丁目</option>`)}))}},_={saveFormData(){const{form:t}=d();if(!t)return console.warn("フォームが見つかりません"),!1;try{const e={};t.querySelectorAll("input, select, textarea").forEach(s=>{s.name&&!s.classList.contains("readonly")&&(e[s.name]=s.type==="checkbox"?s.checked:s.value)});const a=t.querySelector('input[name="banchi"]'),n=t.querySelector('input[name="building_name"]'),l=t.querySelector('input[name="room_number"]');return a&&(e.banchi=a.value),n&&(e.building_name=n.value),l&&(e.room_number=l.value),c.storage.save(e)}catch(e){return console.error("フォームデータ保存エラー:",e),!1}},restoreFormData(){const{form:t}=d();if(!t)return console.warn("フォームが見つかりません"),!1;try{const e=c.storage.load();return!e||typeof e!="object"?(console.log("復元するデータがありません"),!1):(t.querySelectorAll("input, select, textarea").forEach(a=>{a.name&&e.hasOwnProperty(a.name)&&!a.classList.contains("readonly")&&(a.type==="checkbox"?a.checked=!!e[a.name]:a.value=e[a.name]||"")}),console.log("✅ フォームデータ復元完了"),!0)}catch(e){return console.error("フォームデータ復元エラー:",e),!1}},setupAutoSave(){const{form:t}=d();if(!t){console.warn("フォームが見つかりません - オートセーブ無効");return}const e=c.debounce(()=>{this.saveFormData()},500);["input","change","blur"].forEach(o=>{try{t.addEventListener(o,e,!0)}catch(a){console.warn(`${o}イベント設定エラー:`,a)}}),console.log("🤖 オートセーブ設定完了")}};class k{constructor(e="mansion-unit"){this.currentStep=1,this.totalSteps=3,this.propertyType=e,console.log("StepFormManager初期化 - 物件種別:",this.propertyType),this.init()}init(){this.bindEvents(),this.updateUI()}bindEvents(){const{nextBtn:e,prevBtn:o,form:a}=d();e&&e.addEventListener("click",n=>(n.preventDefault(),n.stopPropagation(),this.handleNext(),!1)),o&&o.addEventListener("click",n=>(n.preventDefault(),n.stopPropagation(),this.handlePrev(),!1)),a&&a.addEventListener("submit",n=>(n.preventDefault(),n.stopPropagation(),this.handleSubmit(n),!1))}handleNext(){if(console.log("次へボタン - 現在:",this.currentStep),!this.validateCurrentStep()){console.log("バリデーション失敗");return}this.currentStep<this.totalSteps&&(this.currentStep++,this.updateUI(),this.currentStep===2&&this.generatePropertyDetails())}handlePrev(){this.currentStep>1&&(this.currentStep--,this.updateUI())}validateCurrentStep(){var a;const e=document.querySelector(`.step-content[data-step="${this.currentStep}"]`);if(!e)return console.error("ステップが見つかりません:",this.currentStep),!1;const o=e.querySelectorAll("[required]");for(const n of o){if(!(n.offsetParent!==null&&n.offsetWidth>0&&n.offsetHeight>0&&n.style.display!=="none"&&n.style.visibility!=="hidden"&&!n.hasAttribute("disabled")&&!n.hasAttribute("readonly"))){console.log("非表示フィールドをスキップ:",n.name);continue}if(n.type==="checkbox"?!n.checked:!((a=n.value)!=null&&a.trim())){console.log("必須フィールドが空:",n.name);try{typeof n.focus=="function"&&(n.focus(),n.scrollIntoView({behavior:"smooth",block:"center"}))}catch(m){console.warn("フォーカス不可能:",n.name,m)}let i=n.name;const r=e.querySelector(`label[for="${n.id}"], label[data-field="${n.name}"]`);return r&&(i=r.textContent.replace(/\s*必須\s*/,"").trim()),alert(`${i}を入力してください。`),!1}}return!0}updateUI(){document.querySelectorAll(".step-content").forEach(s=>{s.classList.remove("active")});const e=document.querySelector(`.step-content[data-step="${this.currentStep}"]`);e&&e.classList.add("active"),document.querySelectorAll(".step-indicator").forEach((s,i)=>{const r=i+1;s.classList.remove("active","completed"),r===this.currentStep?s.classList.add("active"):r<this.currentStep&&s.classList.add("completed")});const{progressFill:o}=d();if(o){const s=this.currentStep/this.totalSteps*100;o.style.width=`${s}%`}const{prevBtn:a,nextBtn:n,submitBtn:l}=d();a&&(a.style.display=this.currentStep===1?"none":"block"),n&&(n.style.display=this.currentStep===this.totalSteps?"none":"block"),l&&(l.style.display=this.currentStep===this.totalSteps?"block":"none")}generatePropertyDetails(){const{propertyDetails:e}=d();if(!e){console.error("propertyDetails コンテナが見つかりません");return}console.log("物件詳細生成:",this.propertyType);const o={"mansion-unit":()=>this.generateMansionForm(),house:()=>this.generateHouseForm(),land:()=>this.generateLandForm(),"mansion-building":()=>this.generateBuildingForm(),building:()=>this.generateBuildingForm(),"apartment-building":()=>this.generateBuildingForm(),other:()=>this.generateOtherForm()},a=o[this.propertyType]||o["mansion-unit"];e.innerHTML=a(),this.bindAreaUnitEvents()}generateMansionForm(){const e=c.range(9).map(a=>`<option value="${a}">${a}</option>`).join(""),o=c.range(31).map(a=>`<option value="${a-1}">${a-1}年</option>`).join("");return`
      <div class="form-row">
        <div class="form-group">
          <label>間取り（マンション区分）</label>
          <div class="layout-input">
            <div class="layout-rooms">
              <select name="layout_rooms">
                <option value="">部屋数を選択</option>
                ${e}
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
            ${o}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `}generateHouseForm(){const e=c.range(9).map(a=>`<option value="${a}">${a}</option>`).join(""),o=c.range(31).map(a=>`<option value="${a-1}">${a-1}年</option>`).join("");return`
      <div class="form-row">
        <div class="form-group">
          <label>間取り（一戸建て）</label>
          <div class="layout-input">
            <div class="layout-rooms">
              <select name="layout_rooms">
                <option value="">部屋数を選択</option>
                ${e}
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
            ${o}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `}generateLandForm(){return`
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
    `}generateBuildingForm(){return`
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
            ${c.range(31).map(o=>`<option value="${o-1}">${o-1}年</option>`).join("")}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `}generateOtherForm(){return`
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
            ${c.range(31).map(o=>`<option value="${o-1}">${o-1}年</option>`).join("")}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `}bindAreaUnitEvents(){document.querySelectorAll('input[name$="_unit"]').forEach(e=>{e.addEventListener("change",o=>{const a=o.target.closest(".form-group").querySelector(".area-unit");a&&(a.textContent=o.target.value)})})}async handleSubmit(e){console.log("フォーム送信処理開始"),this.validateCurrentStep()&&await E.submit(e)}}const E={async submit(t){var n,l,s;const{form:e}=d();if(!e){console.error("フォームが見つかりません");return}console.log("AJAX送信開始");const o=e.querySelector('button[type="submit"]'),a=o?o.textContent:"送信";e.classList.add("form-sending"),o&&(o.disabled=!0,o.textContent="送信中...");try{let i=e.getAttribute("action");(!i||i===""||i.includes("[object"))&&(i=((n=window.leadFormAjax)==null?void 0:n.ajaxurl)||"/wp-admin/admin-post.php",console.log("フォームaction修正:",i)),console.log("送信先URL:",i);const r=new FormData(e);r.append("ajax","1");const m=e.querySelector('input[name="banchi"]'),h=e.querySelector('input[name="building_name"]'),b=e.querySelector('input[name="room_number"]');m&&m.value&&r.set("banchi",m.value),h&&h.value&&r.set("building_name",h.value),b&&b.value&&r.set("room_number",b.value),console.log("送信データ確認:");for(let[y,f]of r.entries())console.log(`${y}: ${f}`);const p=await fetch(i,{method:"POST",body:r,headers:{"X-Requested-With":"XMLHttpRequest"}});if(console.log("レスポンス受信:",p.status,p.statusText),!p.ok)throw new Error(`HTTP Error: ${p.status} ${p.statusText}`);const v=await p.text();console.log("レスポンステキスト（最初の500文字）:",v.substring(0,500));let u;try{u=JSON.parse(v),console.log("JSON解析成功:",u)}catch(y){if(console.warn("JSON解析失敗、HTMLレスポンスを確認:",y),v.includes("エラー")||v.includes("Fatal error")||v.includes("Parse error"))throw new Error("サーバーでエラーが発生しました");const f=e.querySelector('input[name="name"]');u={success:!0,data:{customer_name:f?f.value:"お客様",message:"送信が完了しました"}}}if(u.success)console.log("送信成功"),this.handleSuccess(((l=u.data)==null?void 0:l.customer_name)||"お客様");else throw new Error(((s=u.data)==null?void 0:s.message)||u.message||"送信に失敗しました")}catch(i){console.error("送信エラー詳細:",i);let r="送信に失敗しました。";i.message.includes("Failed to fetch")||i.message.includes("NetworkError")?r+="インターネット接続を確認してください。":i.message.includes("400")?r+="入力内容に問題があります。必須項目をご確認ください。":i.message.includes("500")?r+="サーバーエラーが発生しました。しばらく時間をおいてお試しください。":i.message.includes("403")?r+="アクセスが拒否されました。ページを再読み込みしてお試しください。":i.message.includes("404")?r+="URL が見つかりません。ページを再読み込みしてお試しください。":r+=`詳細: ${i.message}`,alert(r)}finally{e.classList.remove("form-sending"),o&&(o.disabled=!1,o.textContent=a)}},handleSuccess(t){console.log("送信成功処理:",t);const{form:e}=d();e&&e.reset(),c.storage.clear(),window.stepFormManager&&(window.stepFormManager.currentStep=1,window.stepFormManager.updateUI()),g.show(t)}},g={show(t=""){console.log("モーダル表示:",t);let e=document.getElementById("thanksModal");if(e||(this.create(),e=document.getElementById("thanksModal")),t){const o=e.querySelector(".thanks-message");o.innerHTML=`
        <p><strong>${t}様</strong></p>
        <p>査定依頼を受け付けました。<br>
        担当者から<strong>24時間以内</strong>にご連絡いたします。</p>
        <p>しばらくお待ちください。</p>
      `}e.classList.add("show"),document.body.style.overflow="hidden"},hide(){const t=document.getElementById("thanksModal");t&&(t.classList.remove("show"),document.body.style.overflow="",setTimeout(()=>t.remove(),300))},create(){document.body.insertAdjacentHTML("beforeend",`
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
    `)}};document.addEventListener("keydown",t=>{t.key==="Escape"&&g.hide()});document.addEventListener("click",t=>{var e;((e=t.target)==null?void 0:e.id)==="thanksModal"&&g.hide()});window.closeThanksModal=()=>g.hide();window.modalManager=g;document.addEventListener("DOMContentLoaded",async()=>{var t;console.log("🔥 リードフォーム初期化開始（3つのフィールド対応版）");try{const{form:e,propertyTypeInput:o}=d();if(!e){console.error("フォームが見つかりません");return}const a=(o==null?void 0:o.value)||c.getUrlParam("property-type")||"mansion-unit";console.log("物件種別:",a);const n=new k(a);window.stepFormManager=n,_.restoreFormData(),_.setupAutoSave();const l=c.getUrlParam("zip")||((t=document.querySelector('input[name="zip"]'))==null?void 0:t.value);if(l)try{const s=await w.fetchAddress(l);w.updateAddressFields(s),w.initChomeSelect()}catch(s){console.warn("住所取得に失敗しました:",s)}setTimeout(()=>{const s=e.querySelector('input[name="banchi"]'),i=e.querySelector('input[name="building_name"]'),r=e.querySelector('input[name="room_number"]');console.log("🔥 3つのフィールド確認:",{banchi:s?s.value:"フィールドなし",building_name:i?i.value:"フィールドなし",room_number:r?r.value:"フィールドなし"})},1e3),console.log("✅ リードフォーム初期化完了（3つのフィールド対応版）")}catch(e){console.error("❌ リードフォーム初期化エラー:",e)}});window.debugFormData=()=>{const{form:t}=d();if(!t){console.log("フォームが見つかりません");return}const e=new FormData(t);console.log("🔍 現在のフォームデータ:");for(let[l,s]of e.entries())console.log(`${l}: ${s}`);const o=t.querySelector('input[name="banchi"]'),a=t.querySelector('input[name="building_name"]'),n=t.querySelector('input[name="room_number"]');console.log("🔍 3つのフィールドの状態:"),console.log("番地・号:",o?o.value:"フィールドなし"),console.log("建物名:",a?a.value:"フィールドなし"),console.log("部屋番号:",n?n.value:"フィールドなし")};window.debugStorage=()=>{console.log("🔍 ストレージデータ:",c.storage.load())};
