(window.webpackJsonp=window.webpackJsonp||[]).push([[21],{"0v+Y":function(t,e,a){(e=a("JPst")(!1)).push([t.i,"\n.line[data-v-3348543a]{\r\n  text-align: center;\n}\r\n",""]),t.exports=e},"578K":function(t,e,a){var i=a("0v+Y");"string"==typeof i&&(i=[[t.i,i,""]]);var n={hmr:!0,transform:void 0,insertInto:void 0};a("aET+")(i,n);i.locals&&(t.exports=i.locals)},Xpi4:function(t,e,a){"use strict";a.r(e);var i=a("o0o1"),n=a.n(i),r=a("yXPU"),o=a.n(r),s=a("xCiW"),l=a("nzZ3"),c={data:function(){return{listLoading:!1,total:0,list:null,rules:{date:[{required:!0,message:"type is required",trigger:"change"}],personal_id:[{required:!0,message:"type is required",trigger:"change"}],client_id:[{required:!0,message:"type is required",trigger:"change"}],pet_id:[{required:!0,message:"type is required",trigger:"change"}],reason:[{required:!0,message:"type is required",trigger:"change"}]},optionsPersonal:[],optionsClient:[],optionsPet:[],optionsVaccine:[],optionsAntiparasitic:[],form:{id:void 0,date:"",personal_id:"",client_id:"",pet_id:"",reason:"",anamnesis:"",vaccine_id:"",vaccine_observation:"",antiparasitic_id:"",antiparasitic_observation:"",diagnostic:"",pathology:"",treatment:"",prescription:"",type:!0}}},watch:{$route:"getAppointment"},created:function(){var t=this.$route.params&&this.$route.params.id;this.getListClient(),this.getListPersonal(),this.getListPet(),this.getAppointment(t),this.getList(),this.getListVaccine(),this.getListAntiparasitic()},methods:{getList:function(){var t=this;return o()(n.a.mark((function e(){var a,i;return n.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.listLoading=!0,e.next=3,Object(l.b)();case 3:a=e.sent,i=a.data,t.list=i.items,t.listLoading=!1;case 7:case"end":return e.stop()}}),e)})))()},onSubmit:function(){var t=this;this.$refs.form.validate((function(e){if(e){t.form.id=t.list[t.list.length-1].id+1,t.form.status=1;var a=t.form.dateTime.toLocaleString().split(" "),i=a[0].split("/");t.form.date="".concat(i[2],"-").concat(i[1],"-").concat(i[0]," ").concat(a[1]),Object(l.a)(t.form).then((function(e){t.list.push(t.form),t.$notify({title:"Success",message:"Created successfully",type:"success",duration:2e3})}))}}))},onCancel:function(){this.$message({message:"cancel!",type:"warning"})},mostrarVacunas:function(){var t=document.getElementById("mostrar");"none"===t.style.display?t.style.display="block":t.style.display="none"},mostrarDesparasitacion:function(){var t=document.getElementById("mostrar1");"none"===t.style.display?t.style.display="block":t.style.display="none"},ocultarVacunas:function(){var t=document.getElementById("mostrar");"block"===t.style.display?t.style.display="none":t.style.display="block"},ocultarDesparasitacion:function(){var t=document.getElementById("mostrar1");"block"===t.style.display?t.style.display="none":t.style.display="block"},resetTemp:function(){this.form={id:void 0,date:"",personal_id:"",client_id:"",pet_id:"",reason:"",anamnesis:"",vaccine_id:"",vaccine_observation:"",antiparasitic_id:"",antiparasitic_observation:"",diagnostic:"",pathology:"",treatment:"",prescription:""}},getListPersonal:function(){var t=this;return o()(n.a.mark((function e(){var a,i,r;return n.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.listLoading=!0,e.next=3,Object(s.c)();case 3:for(r in a=e.sent,(i=a.data).items)t.optionsPersonal.push({value:i.items[r].id,label:i.items[r].first_name+" "+i.items[r].last_name});t.listLoading=!1;case 7:case"end":return e.stop()}}),e)})))()},getListClient:function(){var t=this;return o()(n.a.mark((function e(){var a,i,r;return n.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.listLoading=!0,e.next=3,Object(s.b)();case 3:for(r in a=e.sent,(i=a.data).items)t.optionsClient.push({value:i.items[r].id,label:i.items[r].first_name+" "+i.items[r].last_name});t.listLoading=!1;case 7:case"end":return e.stop()}}),e)})))()},getListPet:function(){var t=this;return o()(n.a.mark((function e(){var a,i,r;return n.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.listLoading=!0,e.next=3,Object(s.h)();case 3:for(r in a=e.sent,i=a.data,t.optionsPet=[],i.items)t.optionsPet.push({value:i.items[r].id,label:i.items[r].name});t.listLoading=!1;case 8:case"end":return e.stop()}}),e)})))()},getListVaccine:function(){var t=this;return o()(n.a.mark((function e(){var a,i,r;return n.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.listLoading=!0,e.next=3,Object(s.e)();case 3:for(r in a=e.sent,(i=a.data).items)t.optionsVaccine.push({value:i.items[r].id,label:i.items[r].name_vaccines});t.listLoading=!1;case 7:case"end":return e.stop()}}),e)})))()},getListAntiparasitic:function(){var t=this;return o()(n.a.mark((function e(){var a,i,r;return n.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.listLoading=!0,e.next=3,Object(s.a)();case 3:for(r in a=e.sent,(i=a.data).items)t.optionsAntiparasitic.push({value:i.items[r].id,label:i.items[r].name_antiparasitic});t.listLoading=!1;case 7:case"end":return e.stop()}}),e)})))()},getAppointment:function(t){var e=this;return o()(n.a.mark((function a(){var i,r;return n.a.wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return a.next=2,Object(s.j)(t);case 2:i=a.sent,r=i.data,e.form.client_id=r.items[0].client_id,e.form.pet_id=r.items[0].pet_id;case 6:case"end":return a.stop()}}),a)})))()}}},u=(a("q+Xe"),a("KHd+")),p=Object(u.a)(c,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"app-container"},[a("el-row",[a("el-card",{staticClass:"box-card"},[a("div",{staticClass:"clearfix",attrs:{slot:"header"},slot:"header"},[a("span",[t._v("Nueva Visita")])]),t._v(" "),a("div",{staticStyle:{padding:"25px 50px 0px 20px"}},[a("el-form",{ref:"form",attrs:{rules:t.rules,model:t.form,"label-width":"120px"}},[a("el-form-item",{attrs:{label:"Fecha"}},[a("el-date-picker",{attrs:{type:"datetime",placeholder:"ingrese fecha"},model:{value:t.form.dateTime,callback:function(e){t.$set(t.form,"dateTime",e)},expression:"form.dateTime"}})],1),t._v(" "),a("el-form-item",{attrs:{label:"Veterinario",prop:"personal_id"}},[a("el-select",{staticStyle:{width:"100%"},attrs:{placeholder:"Seleccione Veterinario..."},model:{value:t.form.personal_id,callback:function(e){t.$set(t.form,"personal_id",e)},expression:"form.personal_id"}},t._l(t.optionsPersonal,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],1),t._v(" "),a("el-form-item",{attrs:{label:"Propietario",prop:"client_id"}},[a("el-select",{staticStyle:{width:"100%"},attrs:{placeholder:"Seleccione Cliente...",disabled:""},model:{value:t.form.client_id,callback:function(e){t.$set(t.form,"client_id",e)},expression:"form.client_id"}},t._l(t.optionsClient,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],1),t._v(" "),a("el-form-item",{attrs:{label:"Paciente",prop:"pet_id"}},[a("el-select",{staticStyle:{width:"100%"},attrs:{placeholder:"Seleccione mascota...",disabled:""},model:{value:t.form.pet_id,callback:function(e){t.$set(t.form,"pet_id",e)},expression:"form.pet_id"}},t._l(t.optionsPet,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],1),t._v(" "),a("el-form-item",{attrs:{label:"Motivo de visita",prop:"reason"}},[a("el-input",{staticStyle:{width:"100%"},attrs:{type:"textarea"},model:{value:t.form.reason,callback:function(e){t.$set(t.form,"reason",e)},expression:"form.reason"}})],1),t._v(" "),a("el-form-item",{attrs:{label:"Anamnesis",prop:"anamnesis"}},[a("el-input",{staticStyle:{width:"100%"},attrs:{type:"textarea"},model:{value:t.form.anamnesis,callback:function(e){t.$set(t.form,"anamnesis",e)},expression:"form.anamnesis"}})],1),t._v(" "),a("div",[a("div",{staticStyle:{border:"1px solid #aeb6bf",width:"100%",padding:"30px","border-radius":"8px",background:"#eaf2f8"}},[[a("img",{attrs:{src:"images/vaccine.png",alt:"Vacuna"}}),t._v(" "),a("h4",{staticStyle:{display:"inline"}},[t._v("VACUNAS")]),t._v(" "),a("button",{staticClass:"el-button el-button--primary el-button--medium",staticStyle:{float:"right","margin-botton":"15px"},attrs:{"data-v-d3a7d412":"",type:"button"},on:{click:t.mostrarVacunas}},[a("i",{staticClass:"el-icon-plus"}),t._v(" "),a("span",[t._v("Añadir")])])]],2),t._v(" "),a("div",{staticStyle:{border:"1px solid #aeb6bf",width:"100%",padding:"30px 20px 50px 20px","border-radius":"0px 0px 8px 8px",display:"none"},attrs:{id:"mostrar"}},[a("el-form-item",{attrs:{label:"Tipo de vacuna",prop:"vaccine_id"}},[a("el-select",{staticStyle:{width:"90%"},attrs:{placeholder:"Tipo Vacuna"},model:{value:t.form.vaccine_id,callback:function(e){t.$set(t.form,"vaccine_id",e)},expression:"form.vaccine_id"}},t._l(t.optionsVaccine,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],1),t._v(" "),a("el-form-item",{attrs:{label:"Detalles adicionales"}},[a("el-input",{staticStyle:{width:"90%"},attrs:{type:"textarea"},model:{value:t.form.vaccine_observation,callback:function(e){t.$set(t.form,"vaccine_observation",e)},expression:"form.vaccine_observation"}})],1),t._v(" "),a("button",{staticClass:"el-button el-button--danger el-button--medium borrar",staticStyle:{float:"right","margin-left":"20px"},attrs:{"data-v-d3a7d412":"",type:"button"},on:{click:t.ocultarVacunas}},[a("i",{staticClass:"el-icon-delete"}),t._v(" "),a("span",[t._v("Borrar")])])],1)]),t._v(" "),a("br"),t._v(" "),a("div",[a("div",{staticStyle:{border:"1px solid #aeb6bf",width:"100%",padding:"30px","border-radius":"8px",background:"#eaf2f8"}},[[a("img",{attrs:{src:"images/medicamento.png",alt:"Vacuna"}}),t._v(" "),a("h4",{staticStyle:{display:"inline"}},[t._v(" ANTIPARASITARIOS")]),t._v(" "),a("button",{staticClass:"el-button el-button--primary el-button--medium",staticStyle:{float:"right","margin-botton":"15px"},attrs:{"data-v-d3a7d412":"",type:"button"},on:{click:t.mostrarDesparasitacion}},[a("i",{staticClass:"el-icon-plus"}),t._v(" "),a("span",[t._v("Añadir")])])]],2),t._v(" "),a("div",{staticStyle:{border:"1px solid #aeb6bf",width:"100%",padding:"30px 20px 50px 20px","border-radius":"0px 0px 8px 8px",display:"none"},attrs:{id:"mostrar1"}},[a("el-form-item",{attrs:{label:"Tipo de antiparasitario",prop:"antiparasitic_id"}},[a("el-select",{staticStyle:{width:"90%"},attrs:{placeholder:"Desparacitante"},model:{value:t.form.antiparasitic_id,callback:function(e){t.$set(t.form,"antiparasitic_id",e)},expression:"form.antiparasitic_id"}},t._l(t.optionsAntiparasitic,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],1),t._v(" "),a("el-form-item",{attrs:{label:"Detalles adicionales"}},[a("el-input",{staticStyle:{width:"90%"},attrs:{type:"textarea"},model:{value:t.form.antiparasitic_observation,callback:function(e){t.$set(t.form,"antiparasitic_observation",e)},expression:"form.antiparasitic_observation"}})],1),t._v(" "),a("button",{staticClass:"el-button el-button--danger el-button--medium borrar",staticStyle:{float:"right","margin-left":"20px"},attrs:{"data-v-d3a7d412":"",type:"button"},on:{click:t.ocultarDesparasitacion}},[a("i",{staticClass:"el-icon-delete"}),t._v(" "),a("span",[t._v("Borrar")])])],1)]),t._v(" "),a("br"),t._v(" "),a("div",[a("el-form-item",{attrs:{label:"Diagnostivo",prop:"diagnostic"}},[a("el-input",{attrs:{type:"textarea"},model:{value:t.form.diagnostic,callback:function(e){t.$set(t.form,"diagnostic",e)},expression:"form.diagnostic"}})],1),t._v(" "),a("el-form-item",{attrs:{label:"Patología",prop:"pathology"}},[a("el-input",{attrs:{type:"textarea"},model:{value:t.form.pathology,callback:function(e){t.$set(t.form,"pathology",e)},expression:"form.pathology"}})],1),t._v(" "),a("el-form-item",{attrs:{label:"Tratamiento",prop:"treatment"}},[a("el-input",{attrs:{type:"textarea"},model:{value:t.form.treatment,callback:function(e){t.$set(t.form,"treatment",e)},expression:"form.treatment"}})],1),t._v(" "),a("el-form-item",{attrs:{label:"Receta",prop:"prescription"}},[a("el-input",{attrs:{type:"textarea"},model:{value:t.form.prescription,callback:function(e){t.$set(t.form,"prescription",e)},expression:"form.prescription"}})],1),t._v(" "),a("el-form-item",{attrs:{label:""}},[a("el-checkbox-group",{model:{value:t.form.type,callback:function(e){t.$set(t.form,"type",e)},expression:"form.type"}},[a("el-checkbox",{attrs:{label:"¿Enviar receta al cliente por correo?",name:"type"}})],1)],1)],1),t._v(" "),a("br"),t._v(" "),a("el-form-item",[a("el-button",{attrs:{type:"primary"},on:{click:t.onSubmit}},[t._v("\n              Create\n            ")]),t._v(" "),a("el-button",{on:{click:t.onCancel}},[t._v("\n              Cancel\n            ")])],1)],1)],1)])],1)],1)}),[],!1,null,"3348543a",null);e.default=p.exports},nzZ3:function(t,e,a){"use strict";a.d(e,"b",(function(){return n})),a.d(e,"a",(function(){return r})),a.d(e,"e",(function(){return o})),a.d(e,"d",(function(){return s})),a.d(e,"c",(function(){return l}));var i=a("rywy");function n(t){return Object(i.a)({url:"/histories",method:"get",params:t})}function r(t){return Object(i.a)({url:"/history/create",method:"post",data:t})}function o(t){return Object(i.a)({url:"/history/update/"+t.id,method:"post",data:t})}function s(t){return Object(i.a)({url:"/peluquerias",method:"get",params:t})}function l(t){return Object(i.a)({url:"/peluqueria/create/"+t,method:"post",data:t})}},"q+Xe":function(t,e,a){"use strict";var i=a("578K");a.n(i).a},xCiW:function(t,e,a){"use strict";a.d(e,"g",(function(){return n})),a.d(e,"f",(function(){return r})),a.d(e,"k",(function(){return o})),a.d(e,"c",(function(){return s})),a.d(e,"b",(function(){return l})),a.d(e,"d",(function(){return c})),a.d(e,"e",(function(){return u})),a.d(e,"a",(function(){return p})),a.d(e,"i",(function(){return d})),a.d(e,"j",(function(){return m})),a.d(e,"h",(function(){return f}));var i=a("rywy");function n(t){return Object(i.a)({url:"/citas",method:"get",params:t})}function r(t){return Object(i.a)({url:"/cita/create",method:"post",data:t})}function o(t){return Object(i.a)({url:"/cita/update/"+t.id,method:"post",data:t})}function s(){return Object(i.a)({url:"/cita/personals",method:"get"})}function l(){return Object(i.a)({url:"/cita/client",method:"get"})}function c(t){return Object(i.a)({url:"/cita/pet",method:"get",params:t})}function u(){return Object(i.a)({url:"/cita/vaccine",method:"get"})}function p(){return Object(i.a)({url:"/cita/antiparasitic",method:"get"})}function d(t){return Object(i.a)({url:"/cita/consultar/"+t,method:"post",data:t})}function m(t){return Object(i.a)({url:"/cita/history/"+t,method:"post",data:t})}function f(){return Object(i.a)({url:"/cita/list/pet",method:"get"})}}}]);