"use strict";function _classCallCheck(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}var _extends=Object.assign||function(t){for(var e=1;e<arguments.length;e++){var r=arguments[e];for(var n in r)Object.prototype.hasOwnProperty.call(r,n)&&(t[n]=r[n])}return t},VueW3CValid=function(){function t(e){_classCallCheck(this,t);this.options=_extends({},{autoRender:!0,dataSetRole:"vueRole",attrSetRole:"data-vue-role",patternAttrs:/^data-vue-(.*)$/g,patternDirective:/^data-v-(.*)$/g,toDots:"_"},e),this.options.autoRender&&this.render()}return t.prototype.render=function(){var t=document.querySelector(this.options.el);null===t&&console.log("Error! HTML Element wan`t found!"),this._renderNode(t)},t.prototype._renderNode=function(t){var e=t,r=!1,n=void 0,o=[];t.dataset[this.options.dataSetRole]&&(n=document.createElement(t.dataset[this.options.dataSetRole]),t.removeAttribute(this.options.attrSetRole),r=!0),this._replaceAttributes(t);for(var a=0;a<t.children.length;a++){var i=this._renderNode(t.children[a]);i!==t.children[a]&&o.push({old:t.children[a],new:i})}for(var s=0;s<o.length;s++)this._copyNode(o[s].old,o[s].new),t.insertBefore(o[s].new,o[s].old),t.removeChild(o[s].old);return r&&(e=n),e},t.prototype._replaceAttributes=function(t){for(var e=[],r=0;r<t.attributes.length;r++){var n=t.attributes[r].nodeName,o=t.attributes[r].value;if(this.options.patternAttrs.test(n)){var a=this._researchAttr(n);e.push({name:n,newName:a,value:o})}else if(this.options.patternDirective.test(n)){var i=this._researchDirective(n);e.push({name:n,newName:i,value:o})}}for(var s=0;s<e.length;s++)t.removeAttribute(e[s].name),t.setAttribute(e[s].newName,e[s].value)},t.prototype._researchAttr=function(t){return t.replace(this.options.patternAttrs,function(t,e){return e})},t.prototype._researchDirective=function(t){var e=this;return t.replace(this.options.patternDirective,function(t,r){return"v-"+r.replace(e.options.toDots,":")})},t.prototype._copyNode=function(t,e){e.innerHTML=t.innerHTML;for(var r=0;r<t.attributes.length;r++)e.setAttribute(t.attributes[r].nodeName,t.attributes[r].value)},t}();