const f="leadFormData",c=()=>({form:document.getElementById("detailForm"),propertyTypeInput:document.getElementById("propertyType"),nextBtn:document.getElementById("nextBtn"),prevBtn:document.getElementById("prevBtn"),submitBtn:document.getElementById("submitBtn"),progressFill:document.getElementById("progressFill"),propertyDetails:document.getElementById("propertyDetails")}),d={getUrlParam:a=>new URLSearchParams(window.location.search).get(a),storage:{data:{},save:a=>{try{(void 0).data={...a},typeof sessionStorage<"u"&&sessionStorage.setItem(f,JSON.stringify(a))}catch(e){console.warn("フォームデータの保存に失敗:",e)}},load:()=>{try{if(typeof sessionStorage<"u"){const a=sessionStorage.getItem(f);if(a)return(void 0).data=JSON.parse(a),(void 0).data}return(void 0).data||{}}catch(a){return console.warn("フォームデータの復元に失敗:",a),{}}},clear:()=>{try{(void 0).data={},typeof sessionStorage<"u"&&sessionStorage.removeItem(f)}catch(a){console.warn("フォームデータのクリアに失敗:",a)}}},range:a=>Array.from({length:a},(e,t)=>t+1),debounce:(a,e)=>{let t;return function(...n){const i=()=>{clearTimeout(t),a(...n)};clearTimeout(t),t=setTimeout(i,e)}}},y={async fetchAddress(a){try{const t=await(await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${a}`)).json();if(!t.results)throw new Error("住所が見つかりません");return{pref:t.results[0].address1,city:t.results[0].address2,town:t.results[0].address3.replace(/(\d.*丁目?)$/,"")}}catch(e){throw console.error("住所取得エラー:",e),e}},updateAddressFields({pref:a,city:e,town:t}){const o=document.querySelector(".js-pref-display"),n=document.querySelector(".js-city-display"),i=document.querySelector(".js-town-display");o&&(o.value=a),n&&(n.value=e),i&&(i.value=t)},initChomeSelect(a=20){const e=document.querySelector(".js-chome");e&&(e.innerHTML='<option value="">選択してください</option>',d.range(a).forEach(t=>{e.insertAdjacentHTML("beforeend",`<option value="${t}">${t}丁目</option>`)}))}},b={saveFormData(){const{form:a}=c();if(!a)return;const e={};a.querySelectorAll("input, select, textarea").forEach(o=>{o.name&&!o.classList.contains("readonly")&&(e[o.name]=o.type==="checkbox"?o.checked:o.value)}),d.storage.save(e)},restoreFormData(){const{form:a}=c();if(!a)return;const e=d.storage.load();a.querySelectorAll("input, select, textarea").forEach(o=>{o.name&&e[o.name]&&!o.classList.contains("readonly")&&(o.type==="checkbox"?o.checked=e[o.name]:o.value=e[o.name])})},setupAutoSave(){const{form:a}=c();if(!a)return;const e=d.debounce(this.saveFormData,300);["input","change","blur"].forEach(t=>{a.addEventListener(t,e,!0)})}};class S{constructor(e="mansion-unit"){this.currentStep=1,this.totalSteps=3,this.propertyType=e,console.log("StepFormManager初期化 - 物件種別:",this.propertyType),this.init()}init(){this.bindEvents(),this.updateUI()}bindEvents(){const{nextBtn:e,prevBtn:t,form:o}=c();e==null||e.addEventListener("click",n=>(n.preventDefault(),n.stopPropagation(),this.handleNext(),!1)),t==null||t.addEventListener("click",n=>(n.preventDefault(),n.stopPropagation(),this.handlePrev(),!1)),o==null||o.addEventListener("submit",n=>(n.preventDefault(),n.stopPropagation(),this.handleSubmit(n),!1))}handleNext(){if(console.log("次へボタン - 現在:",this.currentStep),!this.validateCurrentStep()){console.log("バリデーション失敗");return}this.currentStep<this.totalSteps&&(this.currentStep++,this.updateUI(),this.currentStep===2&&this.generatePropertyDetails())}handlePrev(){this.currentStep>1&&(this.currentStep--,this.updateUI())}validateCurrentStep(){var o;const e=document.querySelector(`.step-content[data-step="${this.currentStep}"]`);if(!e)return console.error("ステップが見つかりません:",this.currentStep),!1;const t=e.querySelectorAll("[required]");for(const n of t)if(n.type==="checkbox"?!n.checked:!((o=n.value)!=null&&o.trim()))return n.focus(),alert("必須項目を入力してください。"),!1;return!0}updateUI(){document.querySelectorAll(".step-content").forEach(l=>{l.classList.remove("active")});const e=document.querySelector(`.step-content[data-step="${this.currentStep}"]`);e==null||e.classList.add("active"),document.querySelectorAll(".step-indicator").forEach((l,s)=>{const r=s+1;l.classList.remove("active","completed"),r===this.currentStep?l.classList.add("active"):r<this.currentStep&&l.classList.add("completed")});const{progressFill:t}=c();if(t){const l=this.currentStep/this.totalSteps*100;t.style.width=`${l}%`}const{prevBtn:o,nextBtn:n,submitBtn:i}=c();o&&(o.style.display=this.currentStep===1?"none":"block"),n&&(n.style.display=this.currentStep===this.totalSteps?"none":"block"),i&&(i.style.display=this.currentStep===this.totalSteps?"block":"none")}generatePropertyDetails(){const{propertyDetails:e}=c();if(!e){console.error("propertyDetails コンテナが見つかりません");return}console.log("物件詳細生成:",this.propertyType);const t={"mansion-unit":()=>this.generateMansionForm(),house:()=>this.generateHouseForm(),land:()=>this.generateLandForm(),"mansion-building":()=>this.generateBuildingForm(),building:()=>this.generateBuildingForm(),"apartment-building":()=>this.generateBuildingForm(),other:()=>this.generateOtherForm()},o=t[this.propertyType]||t["mansion-unit"];e.innerHTML=o(),this.bindAreaUnitEvents()}generateMansionForm(){const e=d.range(9).map(o=>`<option value="${o}">${o}</option>`).join(""),t=d.range(31).map(o=>`<option value="${o-1}">${o-1}年</option>`).join("");return`
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
            ${t}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `}generateHouseForm(){const e=d.range(9).map(o=>`<option value="${o}">${o}</option>`).join(""),t=d.range(31).map(o=>`<option value="${o-1}">${o-1}年</option>`).join("");return`
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
            ${t}
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
            ${d.range(31).map(t=>`<option value="${t-1}">${t-1}年</option>`).join("")}
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
            ${d.range(31).map(t=>`<option value="${t-1}">${t-1}年</option>`).join("")}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `}bindAreaUnitEvents(){document.querySelectorAll('input[name$="_unit"]').forEach(e=>{e.addEventListener("change",t=>{const o=t.target.closest(".form-group").querySelector(".area-unit");o&&(o.textContent=t.target.value)})})}async handleSubmit(e){console.log("フォーム送信処理開始"),this.validateCurrentStep()&&await w.submit(e)}}const w={async submit(a){var n,i,l;const{form:e}=c();if(!e)return;console.log("AJAX送信開始");const t=e.querySelector('button[type="submit"]'),o=t.textContent;e.classList.add("form-sending"),t.disabled=!0,t.textContent="送信中...";try{let s=e.getAttribute("action");(!s||s===""||s.includes("[object"))&&(s=((n=window.leadFormAjax)==null?void 0:n.ajaxurl)||"/wp-admin/admin-post.php",console.log("フォームaction修正:",s)),console.log("送信先URL:",s);const r=new FormData(e);r.append("ajax","1"),console.log("送信データ確認:");for(let[h,g]of r.entries())console.log(`${h}: ${g}`);const p=await fetch(s,{method:"POST",body:r,headers:{"X-Requested-With":"XMLHttpRequest"}});if(console.log("レスポンス受信:",p.status,p.statusText),!p.ok)throw new Error(`HTTP Error: ${p.status} ${p.statusText}`);const m=await p.text();console.log("レスポンステキスト（最初の500文字）:",m.substring(0,500));let u;try{u=JSON.parse(m),console.log("JSON解析成功:",u)}catch(h){if(console.warn("JSON解析失敗、HTMLレスポンスを確認:",h),m.includes("エラー")||m.includes("Fatal error")||m.includes("Parse error"))throw new Error("サーバーでエラーが発生しました");const g=e.querySelector('input[name="name"]');u={success:!0,data:{customer_name:g?g.value:"お客様",message:"送信が完了しました"}}}if(u.success)console.log("送信成功"),this.handleSuccess(((i=u.data)==null?void 0:i.customer_name)||"お客様");else throw new Error(((l=u.data)==null?void 0:l.message)||u.message||"送信に失敗しました")}catch(s){console.error("送信エラー詳細:",s);let r="送信に失敗しました。";s.message.includes("Failed to fetch")||s.message.includes("NetworkError")?r+="インターネット接続を確認してください。":s.message.includes("400")?r+="入力内容に問題があります。必須項目をご確認ください。":s.message.includes("500")?r+="サーバーエラーが発生しました。しばらく時間をおいてお試しください。":s.message.includes("403")?r+="アクセスが拒否されました。ページを再読み込みしてお試しください。":s.message.includes("404")?r+="URL が見つかりません。ページを再読み込みしてお試しください。":r+=`詳細: ${s.message}`,alert(r)}finally{e.classList.remove("form-sending"),t.disabled=!1,t.textContent=o}},handleSuccess(a){console.log("送信成功処理:",a);const{form:e}=c();e&&e.reset(),d.storage.clear(),window.stepFormManager&&(window.stepFormManager.currentStep=1,window.stepFormManager.updateUI()),v.show(a)}},v={show(a=""){console.log("モーダル表示:",a);let e=document.getElementById("thanksModal");if(e||(this.create(),e=document.getElementById("thanksModal")),a){const t=e.querySelector(".thanks-message");t.innerHTML=`
        <p><strong>${a}様</strong></p>
        <p>査定依頼を受け付けました。<br>
        担当者から<strong>24時間以内</strong>にご連絡いたします。</p>
        <p>しばらくお待ちください。</p>
      `}e.classList.add("show"),document.body.style.overflow="hidden"},hide(){const a=document.getElementById("thanksModal");a&&(a.classList.remove("show"),document.body.style.overflow="",setTimeout(()=>a.remove(),300))},create(){document.body.insertAdjacentHTML("beforeend",`
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
    `)}};document.addEventListener("keydown",a=>{a.key==="Escape"&&v.hide()});document.addEventListener("click",a=>{var e;((e=a.target)==null?void 0:e.id)==="thanksModal"&&v.hide()});window.closeThanksModal=()=>v.hide();window.modalManager=v;document.addEventListener("DOMContentLoaded",async()=>{var i;console.log("リードフォーム初期化開始");const{form:a,propertyTypeInput:e}=c();if(!a){console.error("フォームが見つかりません");return}const t=(e==null?void 0:e.value)||"mansion-unit";console.log("物件種別:",t);const o=new S(t);window.stepFormManager=o,b.restoreFormData(),b.setupAutoSave();const n=d.getUrlParam("zip")||((i=document.querySelector('input[name="zip"]'))==null?void 0:i.value);if(n)try{const l=await y.fetchAddress(n);y.updateAddressFields(l),y.initChomeSelect()}catch(l){console.warn("住所取得に失敗しました:",l)}console.log("リードフォーム初期化完了")});
