!function(){var t={881:function(){},84:function(t,e,r){var i=r(881);i.__esModule&&(i=i.default),"string"==typeof i&&(i=[[t.id,i,""]]),i.locals&&(t.exports=i.locals),(0,r(673).Z)("81d37080",i,!0,{})},673:function(t,e,r){"use strict";function i(t,e){for(var r=[],i={},n=0;n<e.length;n++){var s=e[n],a=s[0],o={id:t+":"+n,css:s[1],media:s[2],sourceMap:s[3]};i[a]?i[a].parts.push(o):r.push(i[a]={id:a,parts:[o]})}return r}r.d(e,{Z:function(){return m}});var n="undefined"!=typeof document;if("undefined"!=typeof DEBUG&&DEBUG&&!n)throw new Error("vue-style-loader cannot be used in a non-browser environment. Use { target: 'node' } in your Webpack config to indicate a server-rendering environment.");var s={},a=n&&(document.head||document.getElementsByTagName("head")[0]),o=null,h=0,l=!1,c=function(){},u=null,d="data-vue-ssr-id",p="undefined"!=typeof navigator&&/msie [6-9]\b/.test(navigator.userAgent.toLowerCase());function m(t,e,r,n){l=r,u=n||{};var a=i(t,e);return g(a),function(e){for(var r=[],n=0;n<a.length;n++){var o=a[n];(h=s[o.id]).refs--,r.push(h)}for(e?g(a=i(t,e)):a=[],n=0;n<r.length;n++){var h;if(0===(h=r[n]).refs){for(var l=0;l<h.parts.length;l++)h.parts[l]();delete s[h.id]}}}}function g(t){for(var e=0;e<t.length;e++){var r=t[e],i=s[r.id];if(i){i.refs++;for(var n=0;n<i.parts.length;n++)i.parts[n](r.parts[n]);for(;n<r.parts.length;n++)i.parts.push(v(r.parts[n]));i.parts.length>r.parts.length&&(i.parts.length=r.parts.length)}else{var a=[];for(n=0;n<r.parts.length;n++)a.push(v(r.parts[n]));s[r.id]={id:r.id,refs:1,parts:a}}}}function f(){var t=document.createElement("style");return t.type="text/css",a.appendChild(t),t}function v(t){var e,r,i=document.querySelector("style["+d+'~="'+t.id+'"]');if(i){if(l)return c;i.parentNode.removeChild(i)}if(p){var n=h++;i=o||(o=f()),e=C.bind(null,i,n,!1),r=C.bind(null,i,n,!0)}else i=f(),e=y.bind(null,i),r=function(){i.parentNode.removeChild(i)};return e(t),function(i){if(i){if(i.css===t.css&&i.media===t.media&&i.sourceMap===t.sourceMap)return;e(t=i)}else r()}}var $,b=($=[],function(t,e){return $[t]=e,$.filter(Boolean).join("\n")});function C(t,e,r,i){var n=r?"":i.css;if(t.styleSheet)t.styleSheet.cssText=b(e,n);else{var s=document.createTextNode(n),a=t.childNodes;a[e]&&t.removeChild(a[e]),a.length?t.insertBefore(s,a[e]):t.appendChild(s)}}function y(t,e){var r=e.css,i=e.media,n=e.sourceMap;if(i&&t.setAttribute("media",i),u.ssrId&&t.setAttribute(d,e.id),n&&(r+="\n/*# sourceURL="+n.sources[0]+" */",r+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(n))))+" */"),t.styleSheet)t.styleSheet.cssText=r;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(r))}}}},e={};function r(i){var n=e[i];if(void 0!==n)return n.exports;var s=e[i]={id:i,exports:{}};return t[i](s,s.exports,r),s.exports}r.d=function(t,e){for(var i in e)r.o(e,i)&&!r.o(t,i)&&Object.defineProperty(t,i,{enumerable:!0,get:e[i]})},r.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},r.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})};var i={};!function(){"use strict";r.r(i),r.d(i,{AuthenticationChainHandler:function(){return e},AuthenticationStep:function(){return n},AuthenticatorCodeStep:function(){return h},EmailCodeStep:function(){return a},LoginForm:function(){return t},PasswordStep:function(){return o},VerificationCode:function(){return s},WebAuthnStep:function(){return l}}),r(84);class t{constructor(){this.disabled=!1,Craft.AuthenticationChainHandler=new e(this,(()=>({rememberMe:this.$rememberMe.find("input").prop("checked")}))),this.$pendingSpinner.length&&this.$loginForm.trigger("submit")}get $loginForm(){return $("#login-form")}get $errors(){return $("#login-errors")}get $messages(){return $("#login-messages")}get $spinner(){return $("#spinner")}get $pendingSpinner(){return $("#spinner-pending")}get $submit(){return $("#submit")}get $rememberMe(){return $("#remember-me-container")}get $username(){return $("#username-field input")}get $cancelRecover(){return $("#cancel-recover")}get $recoverAccount(){return $("#recover-account")}get canRememberUser(){return this.$loginForm.data("can-remember")}showError(t){this.clearErrors(),$('<p style="display: none;">'+t+"</p>").appendTo(this.$errors).velocity("fadeIn")}showMessage(t){this.clearMessages(),$('<p style="display: none;">'+t+"</p>").appendTo(this.$messages).velocity("fadeIn")}clearErrors(){this.$errors.empty()}clearMessages(){this.$messages.empty()}enableForm(){this.$submit.addClass("active"),this.$spinner.addClass("hidden"),this.$loginForm.fadeTo(100,1),this.disabled=!1}disableForm(){this.$submit.removeClass("active"),this.$spinner.removeClass("hidden"),this.$loginForm.fadeTo(100,.2),this.disabled=!0}isDisabled(){return this.disabled}showRememberMe(){this.canRememberUser&&(this.$loginForm.addClass("remember-me"),this.$rememberMe.removeClass("hidden"))}hideRememberMe(){this.$loginForm.removeClass("remember-me"),this.$rememberMe.addClass("hidden")}showSubmitButton(){this.$submit.removeClass("hidden")}hideSubmitButton(){this.$submit.addClass("hidden")}}class e{constructor(t,e){this.performAuthenticationEndpoint="authentication/perform-authentication",this.startAuthenticationEndpoint="authentication/start-authentication",this.recoverAccountEndpoint="users/send-password-reset-email",this.recoverAccount=!1,this.authenticationSteps={},this.loginForm=t,this.loginForm.$loginForm.on("submit",(r=>{let i=e?e():{};this.isExistingChain()||(i.loginName=t.$username.val()),this.clearErrors(),this.handleFormSubmit(r,i),r.preventDefault()})),this.prepareForm()}get $alternatives(){return $("#alternative-types")}get $authenticationStep(){return $("#authentication-step")}get $restartAuthentication(){return $("#restart-authentication")}get $usernameField(){return $("#username-field")}get $recoveryButtons(){return $("#recover-account, #cancel-recover")}get $authenticationGreeting(){return $("#authentication-greeting")}get $recoveryMessage(){return $("#recovery-message")}prepareForm(){this.$alternatives.on("click","li",(t=>{this.switchStep($(t.target).attr("rel"))})),this.loginForm.canRememberUser&&(this.isExistingChain()?this.loginForm.hideRememberMe():this.loginForm.showRememberMe()),this.$restartAuthentication.on("click",this.restartAuthentication.bind(this)),this.$recoveryButtons.on("click",this.toggleRecoverAccountForm.bind(this))}resetAuthenticationControls(){this.$authenticationStep.empty().attr("rel",""),this.$authenticationGreeting.remove(),this.$usernameField.removeClass("hidden"),this.$recoveryMessage.addClass("hidden"),this.loginForm.showSubmitButton(),this.loginForm.showRememberMe(),this.hideAlternatives(),this.clearErrors(),this.recoverAccount&&(this.$recoveryButtons.toggleClass("hidden"),this.recoverAccount=!1)}registerAuthenticationStep(t,e){this.authenticationSteps[t]=e}restartAuthentication(t){this.resetAuthenticationControls(),Craft.postActionRequest(this.startAuthenticationEndpoint,{}),t&&t.preventDefault()}toggleRecoverAccountForm(){if(this.recoverAccount=!this.recoverAccount,this.$recoveryButtons.toggleClass("hidden"),this.recoverAccount?this.$recoveryMessage.removeClass("hidden"):this.$recoveryMessage.addClass("hidden"),!this.isExistingChain())return;let t;this.$authenticationStep.attr("rel").length>0&&(t=this.authenticationSteps[this.$authenticationStep.attr("rel")]),this.recoverAccount?(this.$usernameField.removeClass("hidden"),this.$authenticationStep.addClass("hidden"),this.$alternatives.addClass("hidden"),null==t||t.cleanup()):(this.$usernameField.addClass("hidden"),this.$authenticationStep.removeClass("hidden"),this.$authenticationStep.attr("rel"),this.$alternatives.removeClass("hidden"),null==t||t.init())}performStep(t,e){Craft.postActionRequest(t,e,this.processResponse.bind(this))}switchStep(t){this.loginForm.isDisabled()||(this.loginForm.disableForm(),this.clearErrors(),this.updateCurrentStepType(),Craft.postActionRequest(this.performAuthenticationEndpoint,{alternateStep:t},this.processResponse.bind(this)))}updateCurrentStepType(){this.currentStep=this.authenticationSteps[this.$authenticationStep.attr("rel")]}processResponse(t,e){var r,i,n;if("success"==e){if(t.success&&(null===(r=t.returnUrl)||void 0===r?void 0:r.length))return void(window.location.href=t.returnUrl);{t.error&&(this.loginForm.showError(t.error),Garnish.shake(this.loginForm.$loginForm)),t.message&&this.loginForm.showMessage(t.message),t.passwordReset&&(t.error||(this.toggleRecoverAccountForm(),this.restartAuthentication())),t.alternatives&&Object.keys(t.alternatives).length>0?this.showAlternatives(t.alternatives):this.hideAlternatives(),t.stepType&&this.$authenticationStep.attr("rel",t.stepType),t.footHtml&&function(t){const e=t.match(/([^"']+\.js)/gm),r=Array.from(document.scripts).map((t=>t.getAttribute("src"))).filter((t=>t&&t.length>0));if(e){for(const t of e)if(!r.includes(t)){let e=document.createElement("script");e.setAttribute("src",t),document.body.appendChild(e)}}else Craft.appendFootHtml(t)}(t.footHtml);const e=t=>{this.authenticationSteps[t]&&this.authenticationSteps[t].init()};t.html&&(null===(i=this.currentStep)||void 0===i||i.cleanup(),this.$authenticationStep.html(t.html),e(t.stepType)),t.loginFormHtml&&(null===(n=this.currentStep)||void 0===n||n.cleanup(),this.loginForm.$loginForm.html(t.loginFormHtml),this.prepareForm(),e(t.stepType)),t.stepComplete&&this.loginForm.hideRememberMe()}}this.loginForm.enableForm()}showAlternatives(t){this.$alternatives.removeClass("hidden");const e=this.$alternatives.find("ul").empty();for(const[r,i]of Object.entries(t))e.append($(`<li rel="${r}">${i}</li>`))}hideAlternatives(){this.$alternatives.addClass("hidden"),this.$alternatives.find("ul").empty()}handleFormSubmit(t,e){this.invokeStepHandler(t,e)}async invokeStepHandler(t,e){try{let t;if(this.isExistingChain()?(this.updateCurrentStepType(),t=Object.assign(Object.assign({},await this.currentStep.prepareData()),e)):t=e,this.loginForm.isDisabled())return;this.loginForm.disableForm();const r=this.recoverAccount?this.recoverAccountEndpoint:this.isExistingChain()?this.performAuthenticationEndpoint:this.startAuthenticationEndpoint;this.performStep(r,t)}catch(t){this.loginForm.showError(t),this.loginForm.enableForm()}}isExistingChain(){return this.$authenticationStep.attr("rel").length>0}clearErrors(){this.loginForm.clearErrors()}}class n{constructor(t){this.validateOnInput=!1,this.stepType=t,Craft.AuthenticationChainHandler.registerAuthenticationStep(t,this),this.doInit()}get $loginForm(){return Craft.AuthenticationChainHandler.loginForm.$loginForm}get $submit(){return Craft.AuthenticationChainHandler.loginForm.$submit}doInit(){this.cleanup(),this.init()}onInput(t){this.validateOnInput&&!0===this.validate()&&Craft.AuthenticationChainHandler.clearErrors()}async prepareData(){const t=this.validate();if(!0!==t)throw this.validateOnInput=!0,t;this.validateOnInput=!1;let e=await this.returnFormData();return e.stepType=this.stepType,e}}class s extends n{constructor(t){super(t)}get $verificationCode(){return $("#verificationCode")}init(){this.$verificationCode.on("input",this.onInput.bind(this))}cleanup(){this.$verificationCode.off("input",this.onInput.bind(this))}validate(){return 0!==this.$verificationCode.val().length||Craft.t("app","Please enter a verification code")}returnFormData(){return{"verification-code":this.$verificationCode.val()}}}class a extends s{constructor(){super("craft\\authentication\\type\\EmailCode")}}class o extends n{constructor(){super("craft\\authentication\\type\\Password"),this.passwordSelector="#password"}get $passwordField(){return $(this.passwordSelector)}init(){this.passwordInput=new Craft.PasswordInput(this.passwordSelector,{onToggleInput:t=>{this.$passwordField.off("input"),this.$passwordField.replaceWith(t),this.$passwordField.on("input",this.onInput.bind(this))}}),this.$passwordField.on("input",this.onInput.bind(this))}cleanup(){delete this.passwordInput,delete this.passwordInput,this.$passwordField.off("input",this.onInput.bind(this))}validate(){const t=this.$passwordField.val().length;return t<window.minPasswordLength?Craft.t("yii","{attribute} should contain at least {min, number} {min, plural, one{character} other{characters}}.",{attribute:Craft.t("app","Password"),min:window.minPasswordLength}):!(t>window.maxPasswordLength)||Craft.t("yii","{attribute} should contain at most {max, number} {max, plural, one{character} other{characters}}.",{attribute:Craft.t("app","Password"),max:window.maxPasswordLength})}returnFormData(){return{password:this.$passwordField.val()}}}class h extends s{constructor(){super("craft\\authentication\\type\\AuthenticatorCode")}}class l extends n{constructor(){super("craft\\authentication\\type\\WebAuthn")}get $button(){return $("#verify-webauthn")}validate(){return this.$button.addClass("hidden"),!0}init(){this.$button.on("click",this.onButtonClick.bind(this)),this.$submit.addClass("hidden")}cleanup(){this.$button.off("click",this.onButtonClick.bind(this)),this.$submit.removeClass("hidden")}onButtonClick(){this.$loginForm.trigger("submit")}async returnFormData(){const t=this.$button.data("request-options"),e=Object.assign({},t);if(!t)return{};t.allowCredentials&&(e.allowCredentials=[...t.allowCredentials]),e.challenge=atob(e.challenge.replace(/-/g,"+").replace(/_/g,"/")),e.challenge=Uint8Array.from(e.challenge,(t=>t.charCodeAt(0)));for(const t in e.allowCredentials){let r=e.allowCredentials[t];e.allowCredentials[t]={id:Uint8Array.from(atob(r.id.replace(/-/g,"+").replace(/_/g,"/")),(t=>t.charCodeAt(0))),type:r.type}}let r;try{r=await navigator.credentials.get({publicKey:e})}catch(t){throw this.$button.removeClass("hidden"),Craft.t("app","Failed to authenticate")}const i=r.response;return{credentialResponse:{id:r.id,rawId:r.id,response:{authenticatorData:btoa(String.fromCharCode(...new Uint8Array(i.authenticatorData))),clientDataJSON:btoa(String.fromCharCode(...new Uint8Array(i.clientDataJSON))),signature:btoa(String.fromCharCode(...new Uint8Array(i.signature))),userHandle:i.userHandle?btoa(String.fromCharCode(...new Uint8Array(i.userHandle))):null},type:r.type}}}}}();var n=Craft="undefined"==typeof Craft?{}:Craft;for(var s in i)n[s]=i[s];i.__esModule&&Object.defineProperty(n,"__esModule",{value:!0})}();
//# sourceMappingURL=Login.js.map