(window.webpackJsonp=window.webpackJsonp||[]).push([[5],{"+Awk":function(e,t,n){"use strict";n.d(t,"a",(function(){return l}));var s=n("lwsE"),i=n.n(s),r=n("W8MJ"),o=n.n(r),a=n("rywy"),l=function(){function e(t){i()(this,e),this.uri=t}return o()(e,[{key:"list",value:function(e){return Object(a.a)({url:"/"+this.uri,method:"get",params:e})}},{key:"get",value:function(e){return Object(a.a)({url:"/"+this.uri+"/"+e,method:"get"})}},{key:"store",value:function(e){return Object(a.a)({url:"/"+this.uri,method:"post",data:e})}},{key:"update",value:function(e,t){return Object(a.a)({url:"/"+this.uri+"/"+e,method:"put",data:t})}},{key:"destroy",value:function(e){return Object(a.a)({url:"/"+this.uri+"/"+e,method:"delete"})}}]),e}()},"5MDy":function(e,t,n){(t=n("JPst")(!1)).push([e.i,".permissions-container[data-v-f3df8956] {\n  -webkit-box-flex: 1;\n      -ms-flex: 1;\n          flex: 1;\n  -webkit-box-pack: justify;\n      -ms-flex-pack: justify;\n          justify-content: space-between;\n  font-size: 14px;\n  padding-right: 8px;\n}\n.permissions-container .block[data-v-f3df8956] {\n  float: left;\n  min-width: 250px;\n}\n.permissions-container .clear-left[data-v-f3df8956] {\n  clear: left;\n}\n",""]),e.exports=t},"7W2i":function(e,t,n){var s=n("SksO");e.exports=function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&s(e,t)}},"7sWw":function(e,t,n){var s=n("VyIk");"string"==typeof s&&(s=[[e.i,s,""]]);var i={hmr:!0,transform:void 0,insertInto:void 0};n("aET+")(s,i);s.locals&&(e.exports=s.locals)},"9Bhp":function(e,t,n){"use strict";n.r(t);var s=n("o0o1"),i=n.n(s),r=n("yXPU"),o=n.n(r),a=n("+Awk"),l=n("lwsE"),c=n.n(l),u=n("W8MJ"),f=n.n(u),d=n("7W2i"),m=n.n(d),p=n("a1gu"),h=n.n(p),v=n("Nsbk"),b=n.n(v),g=n("rywy");function y(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,s=b()(e);if(t){var i=b()(this).constructor;n=Reflect.construct(s,arguments,i)}else n=s.apply(this,arguments);return h()(this,n)}}var w=function(e){m()(n,e);var t=y(n);function n(){return c()(this,n),t.call(this,"roles")}return f()(n,[{key:"permissions",value:function(e){return Object(g.a)({url:"/"+this.uri+"/"+e+"/permissions",method:"get"})}}]),n}(a.a),k=n("HF+U"),P=n("GczY"),x=n("OuqF"),_=new w,O=new a.a("permissions"),E={name:"RoleList",directives:{waves:k.a,permission:P.a},data:function(){return{currentRoleId:1,list:[],loading:!0,dialogLoading:!1,dialogVisible:!1,permissions:[],menuPermissions:[],otherPermissions:[],permissionProps:{children:"children",label:"name",disabled:"disabled"}}},computed:{currentRole:function(){var e=this,t=this.list.find((function(t){return t.id===e.currentRoleId}));return void 0===t?{name:"",permissions:[]}:t},rolePermissions:function(){return this.classifyPermissions(this.currentRole.permissions).all},roleMenuPermissions:function(){return this.classifyPermissions(this.currentRole.permissions).menu},roleOtherPermissions:function(){return this.classifyPermissions(this.currentRole.permissions).other}},created:function(){this.getRoles(),this.getPermissions()},methods:{checkPermission:x.a,getRoles:function(){var e=this;return o()(i.a.mark((function t(){var n,s;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.loading=!0,t.next=3,_.list({});case 3:n=t.sent,s=n.data,e.list=s,e.list.forEach((function(t,n){t.index=n+1,t.description=e.$t("roles.description."+t.name)})),e.loading=!1;case 8:case"end":return t.stop()}}),t)})))()},getPermissions:function(){var e=this;return o()(i.a.mark((function t(){var n,s,r,o,a,l;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,O.list({});case 2:n=t.sent,s=n.data,r=e.classifyPermissions(s),o=r.all,a=r.menu,l=r.other,e.permissions=o,e.menuPermissions=a,e.otherPermissions=l;case 8:case"end":return t.stop()}}),t)})))()},classifyPermissions:function(e){var t=this,n=[],s=[],i=[];return e.forEach((function(e){var r=e.name;n.push(e),r.startsWith("view menu")?s.push(t.normalizeMenuPermission(e)):i.push(t.normalizePermission(e))})),{all:n,menu:s,other:i}},normalizeMenuPermission:function(e){return{id:e.id,name:this.$options.filters.uppercaseFirst(e.name.substring(10))}},normalizePermission:function(e){return{id:e.id,name:this.$options.filters.uppercaseFirst(e.name),disabled:"manage permission"===e.name}},permissionKeys:function(e){return e.map((function(e){return e.id}))},handleEditPermissions:function(e){var t=this;this.dialogVisible=!0,this.currentRoleId=e,this.$nextTick((function(){t.$refs.menuPermissions.setCheckedKeys(t.permissionKeys(t.roleMenuPermissions)),t.$refs.otherPermissions.setCheckedKeys(t.permissionKeys(t.roleOtherPermissions))}))},confirmPermission:function(){var e=this,t=this.$refs.menuPermissions.getCheckedKeys(),n=this.$refs.otherPermissions.getCheckedKeys(),s=t.concat(n);this.dialogLoading=!0,_.update(this.currentRole.id,{permissions:s}).then((function(t){e.$message({message:"Permissions has been updated successfully",type:"success",duration:5e3}),e.dialogLoading=!1,e.dialogVisible=!1,e.getRoles()}))}}},R=(n("vwKG"),n("KHd+")),j=Object(R.a)(E,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"app-container"},[n("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticStyle:{width:"100%"},attrs:{data:e.list,border:"",fit:"","highlight-current-row":""}},[n("el-table-column",{attrs:{align:"center",label:"ID",width:"80"},scopedSlots:e._u([{key:"default",fn:function(t){return[n("span",[e._v(e._s(t.row.index))])]}}])}),e._v(" "),n("el-table-column",{attrs:{width:"150",align:"center",label:e.$t("table.name")},scopedSlots:e._u([{key:"default",fn:function(t){return[n("span",[e._v(e._s(e._f("uppercaseFirst")(t.row.name)))])]}}])}),e._v(" "),n("el-table-column",{attrs:{align:"left",label:e.$t("table.description")},scopedSlots:e._u([{key:"default",fn:function(t){return[n("span",[e._v(e._s(t.row.description))])]}}])}),e._v(" "),e.checkPermission(["manage permission"])?n("el-table-column",{attrs:{align:"center",label:"Actions",width:"200"},scopedSlots:e._u([{key:"default",fn:function(t){return["admin"!==t.row.name?n("el-button",{directives:[{name:"permission",rawName:"v-permission",value:["manage permission"],expression:"['manage permission']"}],attrs:{type:"primary",size:"small",icon:"el-icon-edit"},on:{click:function(n){return e.handleEditPermissions(t.row.id)}}},[e._v("\n          "+e._s(e.$t("permission.editPermission"))+"\n        ")]):e._e()]}}],null,!1,1525188536)}):e._e()],1),e._v(" "),n("el-dialog",{attrs:{visible:e.dialogVisible,title:"Edit Permissions - "+e.currentRole.name},on:{"update:visible":function(t){e.dialogVisible=t}}},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:e.dialogLoading,expression:"dialogLoading"}],staticClass:"form-container"},[n("div",{staticClass:"permissions-container"},[n("div",{staticClass:"block"},[n("el-form",{attrs:{model:e.currentRole,"label-width":"80px","label-position":"top"}},[n("el-form-item",{attrs:{label:"Menus"}},[n("el-tree",{ref:"menuPermissions",staticClass:"permission-tree",attrs:{data:e.menuPermissions,"default-checked-keys":e.permissionKeys(e.roleMenuPermissions),props:e.permissionProps,"show-checkbox":"","node-key":"id"}})],1)],1)],1),e._v(" "),n("div",{staticClass:"block"},[n("el-form",{attrs:{model:e.currentRole,"label-width":"80px","label-position":"top"}},[n("el-form-item",{attrs:{label:"Permissions"}},[n("el-tree",{ref:"otherPermissions",staticClass:"permission-tree",attrs:{data:e.otherPermissions,"default-checked-keys":e.permissionKeys(e.roleOtherPermissions),props:e.permissionProps,"show-checkbox":"","node-key":"id"}})],1)],1)],1),e._v(" "),n("div",{staticClass:"clear-left"})]),e._v(" "),n("div",{staticStyle:{"text-align":"right"}},[n("el-button",{attrs:{type:"danger"},on:{click:function(t){e.dialogVisible=!1}}},[e._v("\n          "+e._s(e.$t("permission.cancel"))+"\n        ")]),e._v(" "),n("el-button",{attrs:{type:"primary"},on:{click:e.confirmPermission}},[e._v("\n          "+e._s(e.$t("permission.confirm"))+"\n        ")])],1)])])],1)}),[],!1,null,"f3df8956",null);t.default=j.exports},GczY:function(e,t,n){"use strict";var s=n("g6NE"),i={inserted:function(e,t,n){var i=t.value,r=s.a.getters&&s.a.getters.permissions;if(!(i&&i instanceof Array&&i.length>0))throw new Error("Permissions are required! Example: v-permission=\"['manage user','manage permission']\"");var o=i;r.some((function(e){return o.includes(e)}))||e.parentNode&&e.parentNode.removeChild(e)}},r=function(e){e.directive("permission",i)};window.Vue&&(window.permission=i,Vue.use(r)),i.install=r;t.a=i},"HF+U":function(e,t,n){"use strict";n("7sWw");var s="@@wavesContext";function i(e,t){function n(n){var s=Object.assign({},t.value),i=Object.assign({ele:e,type:"hit",color:"rgba(0, 0, 0, 0.15)"},s),r=i.ele;if(r){r.style.position="relative",r.style.overflow="hidden";var o=r.getBoundingClientRect(),a=r.querySelector(".waves-ripple");switch(a?a.className="waves-ripple":((a=document.createElement("span")).className="waves-ripple",a.style.height=a.style.width=Math.max(o.width,o.height)+"px",r.appendChild(a)),i.type){case"center":a.style.top=o.height/2-a.offsetHeight/2+"px",a.style.left=o.width/2-a.offsetWidth/2+"px";break;default:a.style.top=(n.pageY-o.top-a.offsetHeight/2-document.documentElement.scrollTop||document.body.scrollTop)+"px",a.style.left=(n.pageX-o.left-a.offsetWidth/2-document.documentElement.scrollLeft||document.body.scrollLeft)+"px"}return a.style.backgroundColor=i.color,a.className="waves-ripple z-active",!1}}return e[s]?e[s].removeHandle=n:e[s]={removeHandle:n},n}var r={bind:function(e,t){e.addEventListener("click",i(e,t),!1)},update:function(e,t){e.removeEventListener("click",e[s].removeHandle,!0),e.addEventListener("click",i(e,t),!1)},unbind:function(e){e.removeEventListener("click",e[s].removeHandle,!1),e[s]=null,delete e[s]}},o=function(e){e.directive("waves",r)};window.Vue&&(window.waves=r,Vue.use(o)),r.install=o;t.a=r},Ivaw:function(e,t,n){var s=n("5MDy");"string"==typeof s&&(s=[[e.i,s,""]]);var i={hmr:!0,transform:void 0,insertInto:void 0};n("aET+")(s,i);s.locals&&(e.exports=s.locals)},Nsbk:function(e,t){function n(t){return e.exports=n=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)},n(t)}e.exports=n},OuqF:function(e,t,n){"use strict";n.d(t,"a",(function(){return i}));var s=n("g6NE");function i(e){if(e&&e instanceof Array&&e.length>0){var t=s.a.getters&&s.a.getters.permissions,n=e;return t.some((function(e){return n.includes(e)}))}return console.error("Need permissions! Like v-permission=\"['manage permission','edit article']\""),!1}},PJYZ:function(e,t){e.exports=function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}},SksO:function(e,t){function n(t,s){return e.exports=n=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e},n(t,s)}e.exports=n},VyIk:function(e,t,n){(t=n("JPst")(!1)).push([e.i,".waves-ripple {\r\n    position: absolute;\r\n    border-radius: 100%;\r\n    background-color: rgba(0, 0, 0, 0.15);\r\n    background-clip: padding-box;\r\n    pointer-events: none;\r\n    -webkit-user-select: none;\r\n    -moz-user-select: none;\r\n    -ms-user-select: none;\r\n    user-select: none;\r\n    -webkit-transform: scale(0);\r\n    transform: scale(0);\r\n    opacity: 1;\r\n}\r\n\r\n.waves-ripple.z-active {\r\n    opacity: 0;\r\n    -webkit-transform: scale(2);\r\n    transform: scale(2);\r\n    -webkit-transition: opacity 1.2s ease-out, -webkit-transform 0.6s ease-out;\r\n    transition: opacity 1.2s ease-out, -webkit-transform 0.6s ease-out;\r\n    transition: opacity 1.2s ease-out, transform 0.6s ease-out;\r\n    transition: opacity 1.2s ease-out, transform 0.6s ease-out, -webkit-transform 0.6s ease-out;\r\n}",""]),e.exports=t},W8MJ:function(e,t){function n(e,t){for(var n=0;n<t.length;n++){var s=t[n];s.enumerable=s.enumerable||!1,s.configurable=!0,"value"in s&&(s.writable=!0),Object.defineProperty(e,s.key,s)}}e.exports=function(e,t,s){return t&&n(e.prototype,t),s&&n(e,s),e}},a1gu:function(e,t,n){var s=n("cDf5"),i=n("PJYZ");e.exports=function(e,t){return!t||"object"!==s(t)&&"function"!=typeof t?i(e):t}},lwsE:function(e,t){e.exports=function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}},vwKG:function(e,t,n){"use strict";var s=n("Ivaw");n.n(s).a}}]);