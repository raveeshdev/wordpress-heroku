!function(n){var e={};function t(r){if(e[r])return e[r].exports;var o=e[r]={i:r,l:!1,exports:{}};return n[r].call(o.exports,o,o.exports,t),o.l=!0,o.exports}t.m=n,t.c=e,t.d=function(n,e,r){t.o(n,e)||Object.defineProperty(n,e,{enumerable:!0,get:r})},t.r=function(n){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(n,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(n,"__esModule",{value:!0})},t.t=function(n,e){if(1&e&&(n=t(n)),8&e)return n;if(4&e&&"object"===typeof n&&n&&n.__esModule)return n;var r=Object.create(null);if(t.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:n}),2&e&&"string"!=typeof n)for(var o in n)t.d(r,o,function(e){return n[e]}.bind(null,o));return r},t.n=function(n){var e=n&&n.__esModule?function(){return n.default}:function(){return n};return t.d(e,"a",e),e},t.o=function(n,e){return Object.prototype.hasOwnProperty.call(n,e)},t.p="",t(t.s=384)}({25:function(n,e){n.exports=jQuery},384:function(n,e,t){n.exports=t(385)},385:function(n,e,t){"use strict";t.r(e);var r=t(25),o=t.n(r);t(386);o()(document).ready(function(n){n(".woocommerce-services__connect-jetpack").one("click",function(e){e.preventDefault();var t=n(this);t.addClass("disabled"),function(){if("uninstalled"===wcs_nux_notice.initial_install_status)return n.when().then(function(){return t.html(wp.updates.l10n.installing),wp.updates.installPlugin({slug:"jetpack"})});return n.Deferred().resolve()}().then(function(){if("installed"===wcs_nux_notice.initial_install_status||"uninstalled"===wcs_nux_notice.initial_install_status)return n.when().then(function(){return t.html(wcs_nux_notice.translations.activating),n.post(ajaxurl,{action:"woocommerce_services_activate_jetpack",_ajax_nonce:wcs_nux_notice.nonce})}).then(function(e){if("success"!==e)return n.Deferred().reject(e)});return n.Deferred().resolve()}).then(function(){return n.when().then(function(){return t.html(wcs_nux_notice.translations.connecting),n.post(ajaxurl,{action:"woocommerce_services_get_jetpack_connect_url",_ajax_nonce:wcs_nux_notice.nonce,redirect_url:wcs_nux_notice.redirect_url})}).then(function(n){window.location.href=n})}).fail(function(e){var r=e;e||(r=wcs_nux_notice.translations.defaultError),e&&e.install&&"plugin"===e.install&&(r=wcs_nux_notice.translations.installError),n("<p/>",{class:"woocommerce-services__jetpack-install-error-message",text:r}).insertAfter(t),t.remove()})})})},386:function(n,e,t){}});