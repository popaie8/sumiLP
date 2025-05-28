function v(e){const t=new MouseEvent("click",{bubbles:!0,cancelable:!1});e.dispatchEvent(t)}function y(e){const t=new Event("change",{bubbles:!0,cancelable:!1});e.dispatchEvent(t)}function w(e){const t=new FocusEvent("focusin",{bubbles:!0,cancelable:!1});e.dispatchEvent(t)}function E(e){const t=new FocusEvent("focusout",{bubbles:!0,cancelable:!1});e.dispatchEvent(t)}function _(e){const t=new UIEvent("modalopen",{bubbles:!0,cancelable:!1});e.dispatchEvent(t)}function b(e){const t=new UIEvent("modalclose",{bubbles:!0,cancelable:!1});e.dispatchEvent(t)}function L(e,t){t=="invalid"?(d(this.dropdown,"invalid"),r(this.dropdown,"valid")):(d(this.dropdown,"valid"),r(this.dropdown,"invalid"))}function p(e,t){return e[t]!=null?e[t]:e.getAttribute(t)}function c(e,t){return e?e.classList.contains(t):!1}function d(e,t){if(e)return e.classList.add(t)}function r(e,t){if(e)return e.classList.remove(t)}var x={data:null,searchable:!1,showSelectedItems:!1};function o(e,t){this.el=e,this.config=Object.assign({},x,t||{}),this.data=this.config.data,this.selectedOptions=[],this.placeholder=p(this.el,"placeholder")||this.config.placeholder||"Select an option",this.searchtext=p(this.el,"searchtext")||this.config.searchtext||"Search",this.selectedtext=p(this.el,"selectedtext")||this.config.selectedtext||"selected",this.dropdown=null,this.multiple=p(this.el,"multiple"),this.disabled=p(this.el,"disabled"),this.create()}o.prototype.create=function(){this.el.style.opacity="0",this.el.style.width="0",this.el.style.padding="0",this.el.style.height="0",this.el.style.fontSize="0",this.data?this.processData(this.data):this.extractData(),this.renderDropdown(),this.bindEvent()};o.prototype.processData=function(e){var t=[];e.forEach(i=>{t.push({data:i,attributes:{selected:!!i.selected,disabled:!!i.disabled,optgroup:i.value=="optgroup"}})}),this.options=t};o.prototype.extractData=function(){var e=this.el.querySelectorAll("option,optgroup"),t=[],i=[],n=[];e.forEach(s=>{if(s.tagName=="OPTGROUP")var a={text:s.label,value:"optgroup"};else{let l=s.innerText;s.dataset.display!=null&&(l=s.dataset.display);var a={text:l,value:s.value,extra:s.dataset.extra,selected:s.getAttribute("selected")!=null,disabled:s.getAttribute("disabled")!=null}}var u={selected:s.getAttribute("selected")!=null,disabled:s.getAttribute("disabled")!=null,optgroup:s.tagName=="OPTGROUP"};t.push(a),i.push({data:a,attributes:u})}),this.data=t,this.options=i,this.options.forEach(s=>{s.attributes.selected&&n.push(s)}),this.selectedOptions=n};o.prototype.renderDropdown=function(){var e=["nice-select",p(this.el,"class")||"",this.disabled?"disabled":"",this.multiple?"has-multiple":""];let t='<div class="nice-select-search-box">';t+=`<input type="text" class="nice-select-search" placeholder="${this.searchtext}..." title="search"/>`,t+="</div>";var i=`<div class="${e.join(" ")}" tabindex="${this.disabled?null:0}">`;i+=`<span class="${this.multiple?"multiple-options":"current"}"></span>`,i+='<div class="nice-select-dropdown">',i+=`${this.config.searchable?t:""}`,i+='<ul class="list"></ul>',i+="</div>",i+="</div>",this.el.insertAdjacentHTML("afterend",i),this.dropdown=this.el.nextElementSibling,this._renderSelectedItems(),this._renderItems()};o.prototype._renderSelectedItems=function(){if(this.multiple){var e="";this.config.showSelectedItems||this.config.showSelectedItems||window.getComputedStyle(this.dropdown).width=="auto"||this.selectedOptions.length<2?(this.selectedOptions.forEach(function(i){e+=`<span class="current">${i.data.text}</span>`}),e=e==""?this.placeholder:e):e=this.selectedOptions.length+" "+this.selectedtext,this.dropdown.querySelector(".multiple-options").innerHTML=e}else{var t=this.selectedOptions.length>0?this.selectedOptions[0].data.text:this.placeholder;this.dropdown.querySelector(".current").innerHTML=t}};o.prototype._renderItems=function(){var e=this.dropdown.querySelector("ul");this.options.forEach(t=>{e.appendChild(this._renderItem(t))})};o.prototype._renderItem=function(e){var t=document.createElement("li");if(t.innerHTML=e.data.text,e.data.extra!=null&&t.appendChild(this._renderItemExtra(e.data.extra)),e.attributes.optgroup)d(t,"optgroup");else{t.setAttribute("data-value",e.data.value);var i=["option",e.attributes.selected?"selected":null,e.attributes.disabled?"disabled":null];t.addEventListener("click",this._onItemClicked.bind(this,e)),t.classList.add(...i)}return e.element=t,t};o.prototype._renderItemExtra=function(e){var t=document.createElement("span");return t.innerHTML=e,d(t,"extra"),t};o.prototype.update=function(){if(this.extractData(),this.dropdown){var e=c(this.dropdown,"open");this.dropdown.parentNode.removeChild(this.dropdown),this.create(),e&&v(this.dropdown)}p(this.el,"disabled")?this.disable():this.enable()};o.prototype.disable=function(){this.disabled||(this.disabled=!0,d(this.dropdown,"disabled"))};o.prototype.enable=function(){this.disabled&&(this.disabled=!1,r(this.dropdown,"disabled"))};o.prototype.clear=function(){this.resetSelectValue(),this.selectedOptions=[],this._renderSelectedItems(),this.update(),y(this.el)};o.prototype.destroy=function(){this.dropdown&&(this.dropdown.parentNode.removeChild(this.dropdown),this.el.style.display="")};o.prototype.bindEvent=function(){this.dropdown.addEventListener("click",this._onClicked.bind(this)),this.dropdown.addEventListener("keydown",this._onKeyPressed.bind(this)),this.dropdown.addEventListener("focusin",w.bind(this,this.el)),this.dropdown.addEventListener("focusout",E.bind(this,this.el)),this.el.addEventListener("invalid",L.bind(this,this.el,"invalid")),window.addEventListener("click",this._onClickedOutside.bind(this)),this.config.searchable&&this._bindSearchEvent()};o.prototype._bindSearchEvent=function(){var e=this.dropdown.querySelector(".nice-select-search");e&&e.addEventListener("click",function(t){return t.stopPropagation(),!1}),e.addEventListener("input",this._onSearchChanged.bind(this))};o.prototype._onClicked=function(e){if(e.preventDefault(),c(this.dropdown,"open")?this.multiple?e.target==this.dropdown.querySelector(".multiple-options")&&(r(this.dropdown,"open"),b(this.el)):(r(this.dropdown,"open"),b(this.el)):(d(this.dropdown,"open"),_(this.el)),c(this.dropdown,"open")){var t=this.dropdown.querySelector(".nice-select-search");t&&(t.value="",t.focus());var i=this.dropdown.querySelector(".focus");r(i,"focus"),i=this.dropdown.querySelector(".selected"),d(i,"focus"),this.dropdown.querySelectorAll("ul li").forEach(function(n){n.style.display=""})}else this.dropdown.focus()};o.prototype._onItemClicked=function(e,t){var i=t.target;if(!c(i,"disabled")){if(this.multiple)if(c(i,"selected")){r(i,"selected"),this.selectedOptions.splice(this.selectedOptions.indexOf(e),1);var n=this.el.querySelector(`option[value="${i.dataset.value}"]`);n.removeAttribute("selected"),n.selected=!1}else d(i,"selected"),this.selectedOptions.push(e);else this.options.forEach(function(s){r(s.element,"selected")}),this.selectedOptions.forEach(function(s){r(s.element,"selected")}),d(i,"selected"),this.selectedOptions=[e];this._renderSelectedItems(),this.updateSelectValue()}};o.prototype.setValue=function(e){var t=this.el,i=!0,n;if(t.multiple)for(var s=0;s<e.length;s++)e[s]=String(e[s]);for(var a of t.options)t.multiple?e.indexOf(a.value)>-1?n=a.value:n=null:n=e,a.value==n&&!a.disabled?(i&&(t.value=n,i=!1),a.setAttribute("selected",!0),a.selected=!0):(a.removeAttribute("selected"),delete a.selected);i&&!t.multiple&&(t.options[0].setAttribute("selected",!0),t.options[0].selected=!0,t.value=t.options[0].value),this.update()};o.prototype.getValue=function(){var e=this.el;if(!e.multiple)return e.value;var t=[];for(var i of e.options)i.selected&&t.push(i.value);return t};o.prototype.updateSelectValue=function(){if(this.multiple){var e=this.el;this.selectedOptions.forEach(function(t){var i=e.querySelector(`option[value="${t.data.value}"]`);i?i.setAttribute("selected",!0):console.error("Option not found, does it have a value?")})}else this.selectedOptions.length>0&&(this.el.value=this.selectedOptions[0].data.value);y(this.el)};o.prototype.resetSelectValue=function(){if(this.multiple){var e=this.el;this.selectedOptions.forEach(function(t){var i=e.querySelector(`option[value="${t.data.value}"]`);i&&(i.removeAttribute("selected"),delete i.selected)})}else this.selectedOptions.length>0&&(this.el.selectedIndex=-1);y(this.el)};o.prototype._onClickedOutside=function(e){this.dropdown.contains(e.target)||(r(this.dropdown,"open"),b(this.el))};o.prototype._onKeyPressed=function(e){var t=this.dropdown.querySelector(".focus"),i=c(this.dropdown,"open");if(e.keyCode==13)v(i?t:this.dropdown);else if(e.keyCode==40){if(!i)v(this.dropdown);else{var n=this._findNext(t);if(n){var s=this.dropdown.querySelector(".focus");r(s,"focus"),d(n,"focus")}}e.preventDefault()}else if(e.keyCode==38){if(!i)v(this.dropdown);else{var a=this._findPrev(t);if(a){var s=this.dropdown.querySelector(".focus");r(s,"focus"),d(a,"focus")}}e.preventDefault()}else if(e.keyCode==27&&i)v(this.dropdown);else if(e.keyCode===32&&i)return!1;return!1};o.prototype._findNext=function(e){for(e?e=e.nextElementSibling:e=this.dropdown.querySelector(".list .option");e;){if(!c(e,"disabled")&&e.style.display!="none")return e;e=e.nextElementSibling}return null};o.prototype._findPrev=function(e){for(e?e=e.previousElementSibling:e=this.dropdown.querySelector(".list .option:last-child");e;){if(!c(e,"disabled")&&e.style.display!="none")return e;e=e.previousElementSibling}return null};o.prototype._onSearchChanged=function(e){var t=c(this.dropdown,"open"),i=e.target.value;if(i=i.toLowerCase(),i=="")this.options.forEach(function(a){a.element.style.display=""});else if(t){var n=new RegExp(i);this.options.forEach(function(a){var u=a.data.text.toLowerCase(),l=n.test(u);a.element.style.display=l?"":"none"})}this.dropdown.querySelectorAll(".focus").forEach(function(a){r(a,"focus")});var s=this._findNext(null);d(s,"focus")};const O=new URLSearchParams(window.location.search);var S;const g=O.get("zip")||((S=document.querySelector('input[name="zip"]'))==null?void 0:S.value);g&&q(g);document.addEventListener("DOMContentLoaded",()=>{new D});async function q(e){try{const i=await(await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${e}`)).json();if(!i.results)return;const n=i.results[0],s=n.address1,a=n.address2,u=n.address3.replace(/(\d.*丁目?)$/,""),l=document.querySelector(".js-pref-display"),f=document.querySelector(".js-city-display"),h=document.querySelector(".js-town-display");l&&(l.value=s),f&&(f.value=a),h&&(h.value=u),A(),document.querySelectorAll(".js-pref, .js-city, .js-town, .js-chome").forEach(m=>{m&&!m.hasAttribute("data-nice-select")&&(o.bind(m),m.setAttribute("data-nice-select","true"))})}catch(t){console.error("住所取得エラー:",t)}}function A(e=20){const t=document.querySelector(".js-chome");if(t){t.innerHTML='<option value="">選択してください</option>';for(let i=1;i<=e;i++)t.insertAdjacentHTML("beforeend",`<option value="${i}">${i}丁目</option>`)}}class D{constructor(){var t;this.currentStep=1,this.totalSteps=3,this.propertyType=((t=document.getElementById("propertyType"))==null?void 0:t.value)||"mansion-unit",this.init()}init(){this.bindEvents(),this.updateUI()}bindEvents(){const t=document.getElementById("nextBtn"),i=document.getElementById("prevBtn"),n=document.getElementById("detailForm");t&&t.addEventListener("click",()=>this.nextStep()),i&&i.addEventListener("click",()=>this.prevStep()),n&&n.addEventListener("submit",s=>this.handleSubmit(s))}nextStep(){this.validateCurrentStep()&&this.currentStep<this.totalSteps&&(this.currentStep++,this.updateUI(),this.currentStep===2&&this.generatePropertyDetails())}prevStep(){this.currentStep>1&&(this.currentStep--,this.updateUI())}validateCurrentStep(){const t=document.querySelector(`.step-content[data-step="${this.currentStep}"]`);if(!t)return!0;const i=t.querySelectorAll("[required]");for(let n of i)if(!n.value.trim())return n.focus(),alert("必須項目を入力してください"),!1;return!0}updateUI(){document.querySelectorAll(".step-content").forEach(l=>{l.classList.remove("active")});const t=document.querySelector(`.step-content[data-step="${this.currentStep}"]`);t&&t.classList.add("active"),document.querySelectorAll(".step-indicator").forEach((l,f)=>{const h=f+1;l.classList.remove("active","completed"),h===this.currentStep?l.classList.add("active"):h<this.currentStep&&l.classList.add("completed")});const i=this.currentStep/this.totalSteps*100,n=document.getElementById("progressFill");n&&(n.style.width=`${i}%`);const s=document.getElementById("prevBtn"),a=document.getElementById("nextBtn"),u=document.getElementById("submitBtn");s&&(s.style.display=this.currentStep===1?"none":"block"),a&&(a.style.display=this.currentStep===this.totalSteps?"none":"block"),u&&(u.style.display=this.currentStep===this.totalSteps?"block":"none")}generatePropertyDetails(){const t=document.getElementById("propertyDetails");if(!t)return;const i=this.propertyType;let n="";switch(i){case"mansion-unit":n=this.generateMansionForm();break;case"house":n=this.generateHouseForm();break;case"land":n=this.generateLandForm();break;case"mansion-building":case"building":case"apartment-building":n=this.generateBuildingForm();break;case"other":n=this.generateOtherForm();break;default:n=this.generateMansionForm()}t.innerHTML=n,this.bindAreaUnitEvents()}generateMansionForm(){return`
      <div class="form-row">
        <div class="form-group">
          <label>間取り</label>
          <div class="layout-input">
            <div class="layout-rooms">
              <select name="layout_rooms">
                <option value="">部屋数を選択</option>
                ${Array.from({length:9},(t,i)=>`<option value="${i+1}">${i+1}</option>`).join("")}
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
            ${Array.from({length:31},(t,i)=>`<option value="${i}">${i}年</option>`).join("")}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `}generateHouseForm(){return`
      <div class="form-row">
        <div class="form-group">
          <label>間取り</label>
          <div class="layout-input">
            <div class="layout-rooms">
              <select name="layout_rooms">
                <option value="">部屋数を選択</option>
                ${Array.from({length:9},(t,i)=>`<option value="${i+1}">${i+1}</option>`).join("")}
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
            ${Array.from({length:31},(t,i)=>`<option value="${i}">${i}年</option>`).join("")}
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
          <label>築年数（経過年数）</label>
          <select name="age">
            <option value="">築年数を選択</option>
            ${Array.from({length:31},(t,i)=>`<option value="${i}">${i}年</option>`).join("")}
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
            ${Array.from({length:31},(t,i)=>`<option value="${i}">${i}年</option>`).join("")}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `}bindAreaUnitEvents(){document.querySelectorAll('input[name$="_unit"]').forEach(i=>{i.addEventListener("change",n=>{const s=n.target.closest(".form-group").querySelector(".area-unit");s&&(s.textContent=n.target.value)})}),document.querySelectorAll("#propertyDetails select:not([data-nice-select])").forEach(i=>{try{o.bind(i),i.setAttribute("data-nice-select","true")}catch(n){console.warn("NiceSelect binding failed:",n)}})}handleSubmit(t){t.preventDefault(),this.validateCurrentStep()&&t.target.submit()}}
