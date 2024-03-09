(()=>{"use strict";const e=window.wp.blocks,a=window.React,t=window.wp.element,l=window.wp.blockEditor,n=window.wp.components;(0,e.registerBlockType)("plz/register",{title:"Register",category:"widgets",icon:"admin-users",attributes:{title:{source:"html",selector:"h1",default:"Register"},nameLabel:{type:"string",default:"Name"},emailLabel:{type:"string",default:"Email"},passLabel:{type:"string",default:"Password"},text:{source:"html",selector:"p"}},styles:[{name:"light",label:"Light Mode",isDefault:!0},{name:"dark",label:"Dark Mode"}],edit:e=>{const{className:s,attributes:m,setAttributes:i}=e,{title:r,nameLabel:c,emailLabel:o,passwordLabel:p,text:d}=m,[u,E]=(0,t.useState)(d);return(0,a.createElement)(a.Fragment,null,(0,a.createElement)(l.InspectorControls,null,(0,a.createElement)(n.Panel,null,(0,a.createElement)(n.PanelBody,{title:"Labels",initialOpen:!0},(0,a.createElement)(n.TextControl,{label:"Name Label",value:c,onChange:e=>i({nameLabel:e})}),(0,a.createElement)(n.TextControl,{label:"Email Label",value:o,onChange:e=>i({emailLabel:e})}),(0,a.createElement)(n.TextControl,{label:"Pass Label",value:p,onChange:e=>i({passwordLabel:e})})))),(0,a.createElement)(l.BlockControls,{controls:[{icon:"text",title:"Add text",isActive:d||u,onClick:()=>E(!u)}]}),(0,a.createElement)("div",{className:s},(0,a.createElement)("div",{className:"signin__container"},(0,a.createElement)(l.RichText,{tagName:"h1",placeholder:"Escribí un título",className:"sigin__titulo",value:r,onChange:e=>i({title:e})}),(d||u)&&(0,a.createElement)(l.RichText,{tagName:"p",placeholder:"Escribí un párrafo",value:d,onChange:e=>i({text:e})}),(0,a.createElement)("form",{className:"signin__form",id:"signup"},(0,a.createElement)("div",{className:"signin__name name--campo"},(0,a.createElement)("label",{for:"Name"},c),(0,a.createElement)("input",{name:"name",type:"text",id:"Name"})),(0,a.createElement)("div",{className:"signin__email name--campo"},(0,a.createElement)("label",{for:"email"},o),(0,a.createElement)("input",{name:"email",type:"email",id:"email"})),(0,a.createElement)("div",{className:"signin__pass name--campo"},(0,a.createElement)("label",{for:"password"},p),(0,a.createElement)("input",{name:"password",type:"password",id:"password"})),(0,a.createElement)("div",{className:"signin__submit"},(0,a.createElement)("input",{type:"submit",value:"Create"})),(0,a.createElement)("div",{className:"msg"})))))},save:e=>{const{className:t,attributes:n}=e,{title:s,nameLabel:m,emailLabel:i,passwordLabel:r,text:c}=n;return(0,a.createElement)("div",{className:t},(0,a.createElement)("div",{className:"signin__container"},(0,a.createElement)(l.RichText.Content,{tagName:"h1",className:"sigin__titulo",value:s}),c&&(0,a.createElement)(l.RichText.Content,{tagName:"p",value:c}),(0,a.createElement)("form",{className:"signin__form",id:"signup"},(0,a.createElement)("div",{className:"signin__name name--campo"},(0,a.createElement)("label",{for:"Name"},m),(0,a.createElement)("input",{name:"name",type:"text",id:"Name"})),(0,a.createElement)("div",{className:"signin__email name--campo"},(0,a.createElement)("label",{for:"email"},i),(0,a.createElement)("input",{name:"email",type:"email",id:"email"})),(0,a.createElement)("div",{className:"signin__pass name--campo"},(0,a.createElement)("label",{for:"password"},r),(0,a.createElement)("input",{name:"password",type:"password",id:"password"})),(0,a.createElement)("div",{className:"signin__submit"},(0,a.createElement)("input",{type:"submit",value:"Create"})),(0,a.createElement)("div",{className:"msg"}))))}})})();