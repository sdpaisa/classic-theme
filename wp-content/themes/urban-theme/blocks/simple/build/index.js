(()=>{"use strict";var e={n:t=>{var o=t&&t.__esModule?()=>t.default:()=>t;return e.d(o,{a:o}),o},d:(t,o)=>{for(var n in o)e.o(o,n)&&!e.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:o[n]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const t=window.React,o=window.wp.blocks,n=window.wp.blockEditor,r=window.wp.components,l=window.wp.serverSideRender;var a=e.n(l);(0,o.registerBlockType)("pg/basic",{title:"Basic Block",description:"Este es nuestro primer bloque",icon:"smiley",category:"layout",keywords:["wordpress","gutenberg","platzigift"],attributes:{content:{type:"string",default:"Hello world"}},edit:e=>{const{attributes:{content:o},setAttributes:l,className:i,isSelected:s}=e;return(0,t.createElement)(t.Fragment,null,(0,t.createElement)(n.InspectorControls,null,(0,t.createElement)(r.PanelBody,{title:"Modificar texto del Bloque Básico",initialOpen:!1},(0,t.createElement)(r.PanelRow,null,(0,t.createElement)(r.TextControl,{label:"Complete el campo",value:o,onChange:e=>{l({content:e})}})))),(0,t.createElement)(a(),{block:"pg/basic",attributes:e.attributes}))},save:()=>null})})();