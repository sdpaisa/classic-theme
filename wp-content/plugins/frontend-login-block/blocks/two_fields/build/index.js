(()=>{"use strict";var e={n:t=>{var n=t&&t.__esModule?()=>t.default:()=>t;return e.d(n,{a:n}),n},d:(t,n)=>{for(var a in n)e.o(n,a)&&!e.o(t,a)&&Object.defineProperty(t,a,{enumerable:!0,get:n[a]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const t=window.React,n=window.wp.blocks,a=window.wp.blockEditor,o=window.wp.components,l=window.wp.serverSideRender;var r=e.n(l);(0,n.registerBlockType)("recetas/basic",{title:"Propiedades de la receta",description:"Agregar timepo y Cantidad de personas",icon:"info",category:"layout",attributes:{content:{type:"string",default:"00 min"},content2:{type:"string",default:"0-0 Personas"}},edit:e=>{const{attributes:{content:n,content2:l},setAttributes:c,className:i,isSelected:s}=e;return(0,t.createElement)(t.Fragment,null,(0,t.createElement)(a.InspectorControls,null,(0,t.createElement)(o.PanelBody,{title:"Cuanto tiempo toma la receta",initialOpen:!1},(0,t.createElement)(o.PanelRow,null,(0,t.createElement)(o.TextControl,{label:"Complete el campo",value:n,onChange:e=>{c({content:e})}}))),(0,t.createElement)(o.PanelBody,{title:"Para cuantas personas es",initialOpen:!1},(0,t.createElement)(o.PanelRow,null,(0,t.createElement)(o.TextControl,{label:"Complete el campo",value:l,onChange:e=>{c({content2:e})}})))),(0,t.createElement)(r(),{block:"recetas/basic",attributes:e.attributes}))},save:()=>null})})();