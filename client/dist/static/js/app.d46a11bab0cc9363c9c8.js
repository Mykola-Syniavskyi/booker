webpackJsonp([1],{"+Bu7":function(e,t){},"1uuo":function(e,t){},A0Y1:function(e,t){},BpSW:function(e,t){},CeXu:function(e,t){},NHnr:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var s=r("7+uW"),a={render:function(){var e=this.$createElement,t=this._self._c||e;return t("div",{attrs:{id:"app"}},[t("calendar")],1)},staticRenderFns:[]};var n=r("VU/8")({name:"App"},a,!1,function(e){r("vvrJ")},null,null).exports,o=r("/ocq"),i={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"hello"},[r("h1",[e._v(e._s(e.msg))]),e._v(" "),r("h2",[e._v("Essential Links")]),e._v(" "),e._m(0),e._v(" "),r("h2",[e._v("Ecosystem")]),e._v(" "),e._m(1)])},staticRenderFns:[function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("ul",[r("li",[r("a",{attrs:{href:"https://vuejs.org",target:"_blank"}},[e._v("\n        Core Docs\n      ")])]),e._v(" "),r("li",[r("a",{attrs:{href:"https://forum.vuejs.org",target:"_blank"}},[e._v("\n        Forum\n      ")])]),e._v(" "),r("li",[r("a",{attrs:{href:"https://chat.vuejs.org",target:"_blank"}},[e._v("\n        Community Chat\n      ")])]),e._v(" "),r("li",[r("a",{attrs:{href:"https://twitter.com/vuejs",target:"_blank"}},[e._v("\n        Twitter\n      ")])]),e._v(" "),r("br"),e._v(" "),r("li",[r("a",{attrs:{href:"http://vuejs-templates.github.io/webpack/",target:"_blank"}},[e._v("\n        Docs for This Template\n      ")])])])},function(){var e=this.$createElement,t=this._self._c||e;return t("ul",[t("li",[t("a",{attrs:{href:"http://router.vuejs.org/",target:"_blank"}},[this._v("\n        vue-router\n      ")])]),this._v(" "),t("li",[t("a",{attrs:{href:"http://vuex.vuejs.org/",target:"_blank"}},[this._v("\n        vuex\n      ")])]),this._v(" "),t("li",[t("a",{attrs:{href:"http://vue-loader.vuejs.org/",target:"_blank"}},[this._v("\n        vue-loader\n      ")])]),this._v(" "),t("li",[t("a",{attrs:{href:"https://github.com/vuejs/awesome-vue",target:"_blank"}},[this._v("\n        awesome-vue\n      ")])])])}]};var l=r("VU/8")({name:"HelloWorld",data:function(){return{msg:"Welcome to Your Vue.js App"}}},i,!1,function(e){r("1uuo")},"data-v-d8ec41bc",null).exports,u=r("pFYg"),c=r.n(u),d=r("fZjL"),m=r.n(d),_=r("7t+N"),v=r.n(_),p={name:"calendar",data:function(){return{picked:null,role:localStorage.getItem("role"),curent_user_name:localStorage.getItem("name"),filterDate:void 0,selectedDate:new Date,curentMon:this.mnn(),curentYear:this.yearnow(),day:(new Date).getDate(),currentMonthAndYear:this.getMonth(this.curentMon)+" "+this.curentYear,daysMon:["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],daysSun:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],startW:6,start:!1,currentRoom:1,visible:!1,selectedId:void 0,resultEvents:[],names:[],url:"http://tc.geeksforless.net/~user15/booker/client/api/booker/"}},methods:{Clear_storage:function(){localStorage.clear(),window.location.reload()},calcStartTime:function(){if(0!=m()(this.selectedEvent).length)return("0"+this.selectedEvent.start.getHours()).slice(-2)+":"+("0"+this.selectedEvent.start.getMinutes()).slice(-2)},calcEndTime:function(){if(0!=m()(this.selectedEvent).length)return("0"+this.selectedEvent.end.getHours()).slice(-2)+":"+("0"+this.selectedEvent.end.getMinutes()).slice(-2)},getNames:function(e){console.log(e),this.names.push(e)},Update_event:function(){v.a.ajax({url:this.url+"eventUpdate",type:"PUT",dataType:"html",data:v()("#booker_form_update").serialize(),success:function(e){var t=v.a.parseJSON(e);if(v()("#booker_form_update")[0].reset(),console.log(t),t.success?v()("#result_form_update").addClass("great").html(t.success):v()("#result_form_update").addClass("error").html(t.error),setTimeout(function(){window.location.reload()},3e3),t.error)return v()("#result_form_log").addClass("error").html(t.error),!1},error:function(e){v()("#result_form_log").html("Ошибка. Данные не отправлены."),v()(".booker_form_update_container").toggle()}})},selectRoom:function(e){return v()('form input[type="time"], form input[type="hidden"], form input[type="radio"], form textarea, form [name="created"] ').val(""),this.currentRoom=e},showEvent:function(e){this.selectedId=e,v()(".booker_form_update_container").toggle()},Cancel_Update:function(){v()(".booker_form_update_container").toggle()},Delete_event:function(){v.a.ajax({url:this.url+"eventDelete/"+this.selectedEvent.id+"/"+this.role+"/"+this.picked+"/"+this.curent_user_name,type:"DELETE",dataType:"html",success:function(e){var t=v.a.parseJSON(e);t.success?v()("#result_form_update").addClass("great").html(t.success):v()("#result_form_update").addClass("error").html(t.error),setTimeout(function(){window.location.reload()},3e3)},error:function(e){v()("#result_form_employee").html(e.error),v()(".booker_form_update_container").toggle()}})},getMonth:function(e){return["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Now","Dec"][e]},yearnow:function(){return this.curentYear=(new Date).getFullYear(),(new Date).getFullYear()},mnn:function(){return this.curentMon=(new Date).getMonth(),(new Date).getMonth()},previousMonth:function(){var e=this.selectedDate,t=e.getMonth()-1;this.selectedDate=new Date(e.setMonth(t)),this.selectedDate.setMonth(t),this.getEvents(this.selectedDate.getMonth(),this.currentRoom,this.selectedDate.getFullYear()),this.currentMonthAndYear=this.getMonth(this.selectedDate.getMonth())+" "+this.selectedDate.getFullYear()},nextMonth:function(){var e=this.selectedDate,t=e.getMonth()+1;this.selectedDate=new Date(e.setMonth(t)),this.getEvents(this.selectedDate.getMonth(),this.currentRoom,this.selectedDate.getFullYear()),this.currentMonthAndYear=this.getMonth(this.selectedDate.getMonth())+" "+this.selectedDate.getFullYear()},setDate:function(e){e==this.filterDate?this.filterDate=void 0:this.filterDate=e},isWeekend:function(e){return 0==e.d.getDay()||6==e.d.getDay()},getCalendar:function(e){this.getEvents(this.selectedDate.getMonth(),this.currentRoom,this.selectedDate.getFullYear());var t=[],r=new Date(e.getFullYear(),e.getMonth(),1),s=new Date(e.getFullYear(),e.getMonth()+1,0);1==this.start?this.startW=0:this.startW=6;var a=(r.getDay()+this.startW)%7,n=(s.getDay()+6)%7;r.setDate(r.getDate()-a),s.setDate(s.getDate()+(6-n));for(var o=[];r<=s;){var i=[],l=this.currentRoom;console.log(c()(this.resultEvents)),"object"==c()(this.resultEvents)&&null!==this.resultEvents.length?(this.resultEvents.forEach(function(e,t,s){e.start=new Date(Date.parse(e.start)),e.end=new Date(Date.parse(e.end));var a=e.start,n=r;a.getMonth()==n.getMonth()&&e.room_id==l&&a.getDate()==n.getDate()&&i.push(e)}),o.push({d:new Date(r),e:i})):o.push({d:new Date(r)}),7===o.length&&(t.push(o),o=[]),r.setDate(r.getDate()+1)}return t},getEvents:function(e,t,r){var s=this;v.a.ajax({url:this.url+"allEvents/"+(e+1)+"/"+t+"/"+r,async:!1,method:"GET",data:{},success:function(a){console.log("EVENTS",a,e,t,r),s.resultEvents=a||[]},error:function(e){},complete:function(){}})}},components:{Login:"my-login",Rooms:"my-room",Employee:"my-employee"},computed:{gridArray:function(){return this.getCalendar(this.selectedDate)},selectedEvent:function(){var e=this,t=this.resultEvents.filter(function(t){return t.id==e.selectedId})[0]||{};return"string"==typeof t.start&&(t.start=new Date(Date.parse(t.start))),"string"==typeof t.end&&(t.end=new Date(Date.parse(t.end))),t}}},h={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"container"},[r("div",{staticClass:"booker_form_update_container"},[r("div",{staticClass:"booker_form_update"},[r("div",{attrs:{id:"result_form_update"}}),e._v(" "),r("form",{attrs:{method:"PUT",id:"booker_form_update"}},[r("br"),e._v(" "),e.selectedId?r("table",[r("tr",[r("td",[e._v("Select Time Start:")]),r("td",[r("input",{staticClass:"form-control",attrs:{name:"startTime",type:"time",step:"900",min:"08:00",max:"19:45",required:""},domProps:{value:e.calcStartTime()}})])]),e._v(" "),r("tr",[r("td",[e._v("Select Time End:")]),r("td",[r("input",{staticClass:"form-control",attrs:{name:"endTime",type:"time",step:"900",min:"08:15",max:"20:00",required:""},domProps:{value:e.calcEndTime()}})])]),e._v(" "),"admin"==e.role?r("tr",[r("td",[e._v("Name:")]),r("td",[r("select",{attrs:{name:"name",id:""}},e._l(e.names[0],function(t,s){return r("option",{key:s,domProps:{value:t}},[e._v(e._s(t))])}),0)])]):e._e(),e._v(" "),r("tr",[r("td"),r("td",[r("input",{directives:[{name:"model",rawName:"v-model",value:e.curent_user_name,expression:"curent_user_name"}],staticClass:"form-control",attrs:{name:"curent_user_name",type:"hidden"},domProps:{value:e.curent_user_name},on:{input:function(t){t.target.composing||(e.curent_user_name=t.target.value)}}})])]),e._v(" "),r("tr",[r("td"),r("td",[r("input",{directives:[{name:"model",rawName:"v-model",value:e.selectedEvent.id,expression:"selectedEvent.id"}],staticClass:"form-control",attrs:{name:"event_id",type:"hidden"},domProps:{value:e.selectedEvent.id},on:{input:function(t){t.target.composing||e.$set(e.selectedEvent,"id",t.target.value)}}})])]),e._v(" "),r("tr",[r("td"),r("td",[r("input",{directives:[{name:"model",rawName:"v-model",value:e.selectedEvent.user_id,expression:"selectedEvent.user_id"}],staticClass:"form-control",attrs:{name:"user_id",type:"hidden"},domProps:{value:e.selectedEvent.user_id},on:{input:function(t){t.target.composing||e.$set(e.selectedEvent,"user_id",t.target.value)}}})])]),e._v(" "),r("tr",[r("td"),r("td",[r("input",{directives:[{name:"model",rawName:"v-model",value:e.role,expression:"role"}],staticClass:"form-control",attrs:{name:"role",type:"hidden"},domProps:{value:e.role},on:{input:function(t){t.target.composing||(e.role=t.target.value)}}})])]),e._v(" "),r("tr",[r("td",[e._v("Note: ")]),r("td",[r("textarea",{directives:[{name:"model",rawName:"v-model",value:e.selectedEvent.note,expression:"selectedEvent.note"}],staticClass:"form-control",attrs:{type:"text",name:"note"},domProps:{value:e.selectedEvent.note},on:{input:function(t){t.target.composing||e.$set(e.selectedEvent,"note",t.target.value)}}}),r("br")])]),e._v(" "),r("tr",[r("td",[e._v("submited:")]),e._v(" "),r("td",{attrs:{name:"created"}},[e._v(e._s(e.selectedEvent.created_data))])])]):e._e(),r("br"),e._v(" "),e.selectedEvent.recurent_id?r("table",[e._m(0),e._v(" "),e._m(1),e._v(" "),r("tr",[r("td",[e._v("no:")]),r("td",[r("input",{directives:[{name:"model",rawName:"v-model",value:e.picked,expression:"picked"}],attrs:{name:"recurent",type:"radio",value:"0"},domProps:{checked:e._q(e.picked,"0")},on:{change:function(t){e.picked="0"}}})])]),e._v(" "),r("tr",[r("td",[e._v("yes:")]),r("td",[r("input",{directives:[{name:"model",rawName:"v-model",value:e.picked,expression:"picked"}],attrs:{name:"recurent",type:"radio",value:"1"},domProps:{checked:e._q(e.picked,"1")},on:{change:function(t){e.picked="1"}}})])])]):e._e(),e._v(" "),r("button",{staticClass:"btn_book_add",attrs:{type:"button"},on:{click:e.Update_event}},[e._v("Update Event")]),e._v(" "),r("button",{staticClass:"btn_book_add",attrs:{type:"button"},on:{click:e.Delete_event}},[e._v("Delete Event")]),e._v(" "),r("button",{staticClass:"btn_book_add",attrs:{type:"button"},on:{click:e.Cancel_Update}},[e._v("Close")])])])]),e._v(" "),r("my-login",{directives:[{name:"show",rawName:"v-show",value:!this.curent_user_name,expression:"!this.curent_user_name"}]}),e._v(" "),r("div",{directives:[{name:"show",rawName:"v-show",value:this.curent_user_name,expression:"this.curent_user_name"}],staticClass:"col-md-4"},[e._m(2),e._v(" "),r("div",{staticClass:"log_out"},[r("h2",{staticClass:"h2"},[e._v("Hello :"),r("span",{staticClass:"span_for_name"},[e._v(" "+e._s(e.curent_user_name))]),e._v(" "),r("input",{staticClass:"btn_log_out",attrs:{type:"button",value:"LOG OUT"},on:{click:e.Clear_storage}})])]),e._v(" "),r("div",{staticClass:"form_rooms"},[r("my-rooms",{directives:[{name:"show",rawName:"v-show",value:this.curent_user_name,expression:"this.curent_user_name"}],attrs:{currentRoom:e.currentRoom},on:{selRoom:e.selectRoom}}),e._v(" "),"admin"==e.role?r("my-employee",{directives:[{name:"show",rawName:"v-show",value:this.curent_user_name,expression:"this.curent_user_name"}],on:{getNames:e.getNames}}):e._e(),e._v(" "),r("my-bookform",{directives:[{name:"show",rawName:"v-show",value:this.curent_user_name,expression:"this.curent_user_name"}]})],1)]),r("br"),e._v(" "),r("div",{directives:[{name:"show",rawName:"v-show",value:this.curent_user_name,expression:"this.curent_user_name"}],staticClass:"table-responsive"},[r("div",{staticClass:"swicher"},[e._v("\n            Week start"),r("input",{directives:[{name:"model",rawName:"v-model",value:e.start,expression:"start"}],attrs:{type:"checkbox",id:"button-swicher"},domProps:{checked:Array.isArray(e.start)?e._i(e.start,null)>-1:e.start},on:{change:function(t){var r=e.start,s=t.target,a=!!s.checked;if(Array.isArray(r)){var n=e._i(r,null);s.checked?n<0&&(e.start=r.concat([null])):n>-1&&(e.start=r.slice(0,n).concat(r.slice(n+1)))}else e.start=a}}})]),e._v(" "),r("div",{staticClass:"btn_room"}),e._v(" "),r("div",{staticClass:"activeRoom "},[e._v("Boardroom "+e._s(e.currentRoom))]),e._v(" "),r("table",{staticClass:"table table-bordered"},[r("thead",{staticClass:"thead-default"},[r("tr",[r("th",{attrs:{colspan:"1",height:"20px"}},[r("a",{staticClass:"prev",attrs:{href:"#"},on:{click:e.previousMonth}},[e._v("<")])]),e._v(" "),r("th",{staticClass:"center-title",attrs:{colspan:"5"}},[e._v("\n                      "+e._s(e.currentMonthAndYear)+"\n                  ")]),e._v(" "),r("th",{attrs:{colspan:"1"}},[r("a",{staticClass:"next",attrs:{href:"#"},on:{click:e.nextMonth}},[e._v(">")])])]),e._v(" "),6==e.startW?r("tr",e._l(e.daysMon,function(t,s){return r("th",{key:s},[e._v(e._s(t))])}),0):r("tr",e._l(e.daysSun,function(t,s){return r("th",{key:s},[e._v(e._s(t))])}),0)]),e._v(" "),r("tbody",{staticClass:"tbody-default",attrs:{"data-bind":"foreach:gridArray"}},e._l(e.gridArray,function(t,s){return r("tr",{key:s,staticClass:"tr_for_height"},e._l(t,function(t,s){return r("td",{key:s,staticClass:"td_calendar",class:{yellow:e.isWeekend(t)}},[t.d.getMonth()==e.selectedDate.getMonth()?r("span",{staticClass:"container_for_data"},[r("div",{staticClass:"div_for_date_month"},[e._v("\n                          "+e._s(t.d.getDate())),r("br")]),e._v(" "),e._l(t.e,function(t,s){return r("div",{key:s,staticClass:"js-c-event"},[r("a",{attrs:{href:"#"},on:{click:function(r){return e.showEvent(t.id)}}},[e._v("\n                            "+e._s(t.start.getHours())+":"+e._s(("0"+t.start.getMinutes()).slice(-2))+" - "+e._s(t.end.getHours())+":"+e._s(("0"+t.end.getMinutes()).slice(-2))),r("br")])])})],2):e._e(),e._v(" "),t.d.getMonth()!=e.selectedDate.getMonth()?r("span",{staticClass:"nocurrmonth"},[r("a",{attrs:{href:"#"}},[e._v("\n                        "+e._s(t.d.getDate())+"\n                    ")])]):e._e()])}),0)}),0)])]),e._v(" "),r("div")],1)},staticRenderFns:[function(){var e=this.$createElement,t=this._self._c||e;return t("tr",[t("td",[this._v("Is recurent?")]),t("td")])},function(){var e=this.$createElement,t=this._self._c||e;return t("tr",[t("td"),t("td")])},function(){var e=this.$createElement,t=this._self._c||e;return t("h1",[this._v("Room`s "),t("span",[this._v("booker")])])}]};var f=r("VU/8")(p,h,!1,function(e){r("CeXu")},null,null).exports,g={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"div_rooms"},[r("button",{class:["btn_room",1===e.currentRoom?"yellow":""],attrs:{type:"button",id:"js_btn1",name:"room1"},on:{click:function(t){return e.selectRoom(1)}}},[e._v("room1")]),e._v(" "),r("button",{class:["btn_room",2===e.currentRoom?"yellow":""],attrs:{type:"button",id:"js_btn2",name:"room2"},on:{click:function(t){return e.selectRoom(2)}}},[e._v("room2")]),e._v(" "),r("button",{class:["btn_room",3===e.currentRoom?"yellow":""],attrs:{type:"button",id:"js_btn3",name:"room3"},on:{click:function(t){return e.selectRoom(3)}}},[e._v("room3")])])},staticRenderFns:[]},y=r("VU/8")({props:["currentRoom"],methods:{selectRoom:function(e){this.$emit("selRoom",e)}}},g,!1,null,null,null).exports,b={name:"Login",data:function(){return{url:"http://tc.geeksforless.net/~user15/booker/client/api/booker/"}},methods:{sendPutAjax:function(){v.a.ajax({url:this.url+"log",type:"PUT",dataType:"html",data:v()("#log_form").serialize(),success:function(e){var t=v.a.parseJSON(e);if(v()("#log_form")[0].reset(),t.error)return v()("#result_form_log").addClass("error").html(t.error),!1;localStorage.setItem("id",t[0].id),localStorage.setItem("name",t[0].name),localStorage.setItem("password",t[0].password),localStorage.setItem("role",t[0].role),window.location.reload()},error:function(e){v()("#result_form_log").html("Ошибка. Данные не отправлены.")}})}}},w={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"div_for_log"},[r("h4",[e._v("login Form")]),e._v(" "),e._m(0),e._v(" "),r("form",{attrs:{method:"PUT",action:"",id:"log_form"}},[e._m(1),e._v(" "),e._m(2),e._v(" "),r("input",{staticClass:"btn btn-primary",attrs:{type:"button",id:"btn_log",value:"Log in"},on:{click:function(t){return e.sendPutAjax()}}})]),r("br")])},staticRenderFns:[function(){var e=this.$createElement,t=this._self._c||e;return t("div",{attrs:{id:"result_form_log"}},[t("br")])},function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"form-group"},[t("input",{staticClass:"form-control",attrs:{type:"email",id:"exampleInputEmail1",name:"email",placeholder:"Enter email"}})])},function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"form-group"},[t("input",{staticClass:"form-control",attrs:{type:"password",name:"passwd",id:"exampleInputPassword1",placeholder:"Password"}})])}]};var E=r("VU/8")(b,w,!1,function(e){r("+Bu7")},"data-v-557f8b83",null).exports,k={name:"my-bookform",data:function(){return{visible:!1,url:"http://tc.geeksforless.net/~user15/booker/client/api/booker/",user_id:localStorage.getItem("id"),day:(new Date).getDate(),month:((new Date).getMonth()+1)%12,year:(new Date).getFullYear()}},methods:{min_date:function(){if(this.month<10)var e=this.year+"-0"+this.month+"-"+this.day;else e=this.year+"-"+this.month+"-"+this.day;return e},show_book_form:function(){v()("#result_form_book").html(""),v()("#booker_form").toggle("slow")},addEvent:function(e,t,r){v()("#result_form_book").html(""),v.a.ajax({url:this.url+"addEvent",type:"POST",dataType:"html",data:v()("#booker_form").serialize(),success:function(e){var t=v.a.parseJSON(e);v()("#booker_form")[0].reset(),t.success?(v()("#result_form_book").addClass("great").html(t.success),setTimeout(function(){window.location.reload()},1e3)):v()("#result_form_book").addClass("error").html(t.error)},error:function(e){v()("#result_form_book").addClass("error").html(e.error)}})}}},D={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"booker_form_div"},[r("button",{staticClass:"show_book_form",attrs:{type:"button",id:"show_book_form",title:"show or close form"},on:{click:e.show_book_form}},[e._v("Book It")]),e._v(" "),r("div",{attrs:{id:"result_form_book"}}),e._v(" "),r("form",{staticClass:"form",attrs:{method:"POST",id:"booker_form"}},[r("br"),e._v(" "),r("table",[e._m(0),e._v(" "),r("tr",[r("td",[e._v("Select date:")]),r("td",[r("input",{staticClass:"form-control",attrs:{name:"startDay",type:"date",min:e.min_date(),required:"",value:""}})])]),e._v(" "),e._m(1),e._v(" "),e._m(2),e._v(" "),r("tr",[r("td"),r("td",[r("input",{directives:[{name:"model",rawName:"v-model",value:this.user_id,expression:"this.user_id"}],staticClass:"form-control",attrs:{name:"user_id",type:"hidden"},domProps:{value:this.user_id},on:{input:function(t){t.target.composing||e.$set(this,"user_id",t.target.value)}}})])]),e._v(" "),e._m(3),e._v(" "),e._m(4),e._v(" "),e._m(5),e._v(" "),r("tr",[r("td",[e._v("no:")]),r("td",[r("input",{directives:[{name:"model",rawName:"v-model",value:e.visible,expression:"visible"}],attrs:{name:"recurent",type:"radio",value:"0"},domProps:{checked:e._q(e.visible,"0")},on:{change:function(t){e.visible="0"}}})])]),e._v(" "),r("tr",[r("td",[e._v("yes:")]),r("td",[r("input",{directives:[{name:"model",rawName:"v-model",value:e.visible,expression:"visible"}],attrs:{name:"recurent",type:"radio",value:"1"},domProps:{checked:e._q(e.visible,"1")},on:{change:function(t){e.visible="1"}}})])])]),r("br"),e._v(" "),r("div",{directives:[{name:"show",rawName:"v-show",value:"1"==e.visible,expression:"visible == '1'"}],attrs:{id:"recurent"}},[e._m(6)]),r("br"),e._v(" "),r("button",{staticClass:"btn_book_add",attrs:{type:"button"},on:{click:e.addEvent}},[e._v("Add Event")])])])},staticRenderFns:[function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("tr",[r("td",[e._v("Select room:")]),e._v(" "),r("td",[r("select",{attrs:{name:"room"}},[r("option",{attrs:{disabled:"",selected:""}},[e._v("Choose room")]),e._v(" "),r("option",{attrs:{value:"1"}},[e._v("room1")]),e._v(" "),r("option",{attrs:{value:"2"}},[e._v("room2")]),e._v(" "),r("option",{attrs:{value:"3"}},[e._v("room3")])])])])},function(){var e=this.$createElement,t=this._self._c||e;return t("tr",[t("td",[this._v("Select Time Start:")]),t("td",[t("input",{staticClass:"form-control",attrs:{name:"startTime",type:"time",step:"900",min:"08:00",max:"19:45",required:"",value:""}})])])},function(){var e=this.$createElement,t=this._self._c||e;return t("tr",[t("td",[this._v("Select Time End:")]),t("td",[t("input",{staticClass:"form-control",attrs:{name:"endTime",type:"time",step:"900",min:"08:15",max:"20:00",required:"",value:""}})])])},function(){var e=this.$createElement,t=this._self._c||e;return t("tr",[t("td",[this._v("Note: ")]),t("td",[t("textarea",{staticClass:"form-control",attrs:{name:"note"}}),t("br")])])},function(){var e=this.$createElement,t=this._self._c||e;return t("tr",[t("td",[this._v("Is recurent?")]),t("td")])},function(){var e=this.$createElement,t=this._self._c||e;return t("tr",[t("td"),t("td")])},function(){var e=this.$createElement,t=this._self._c||e;return t("table",[t("tr",[t("td",[this._v("weekly:")]),t("td",[t("input",{attrs:{name:"times",type:"radio",value:"WEEKLY"}})])]),this._v(" "),t("tr",[t("td",[this._v(" 2-weekly:")]),t("td",[t("input",{attrs:{name:"times",type:"radio",value:"BI-WEEKLY"}})])]),this._v(" "),t("tr",[t("td",[this._v("monthly: ")]),t("td",[t("input",{attrs:{name:"times",type:"radio",value:"MONTHLY"}})])]),this._v(" "),t("tr",[t("td",[this._v("Repeat count:")]),t("td",[t("input",{staticClass:"form-control",attrs:{name:"duration",type:"number",min:"1",max:"4"}})])])])}]};var C=r("VU/8")(k,D,!1,function(e){r("A0Y1")},"data-v-07a056f2",null).exports;s.a.use(o.a);var x=new o.a({routes:[{path:"/",name:"HelloWorld",component:l},{path:"/",name:"Calendar",component:f},{path:"/",name:"Login",component:E},{path:"/",name:"Rooms",component:y},{path:"/book-form",name:"BookForm",component:C}]}),M={name:"my-employee",data:function(){return{url:"http://tc.geeksforless.net/~user15/booker/client/api/booker/",employeeList:[],userData:{},show_edit:!0,list:!1,id:"",names:[]}},mounted:function(){this.getEmployees()},methods:{getNamesEmpoyee:function(e){var t=[];e.forEach(function(e,r,s){t.push(e.name)}),this.names.push(t),console.log(this.names[0]),this.$emit("getNames",this.names[0])},getEmployees:function(){var e=this;v()("#div_ad_new_user").hide(),v.a.ajax({url:this.url+"allEmployee/",method:"GET",data:{},success:function(t){e.buildEmployeeList(t),e.getNamesEmpoyee(t)},error:function(e){},complete:function(){}})},buildEmployeeList:function(e){var t=this;e.forEach(function(r){t.employeeList.push(e)})},editEmployee:function(e){var t={user_id:e,name:this.userData.name,role:this.userData.role,email:this.userData.email,passwd:this.userData.passwd};v.a.ajax({url:this.url+"editEmployee",type:"PUT",dataType:"html",data:t,success:function(e){var t=v.a.parseJSON(e);t.success?(v()("#result_form_employee").addClass("great").html(t.success),v()('form input[type="text"], form input[type="password"], input[type="email"] ').val("")):(v()("#result_form_employee").addClass("error").html(t.error),v()('form input[type="text"], form input[type="password"], input[type="email"] ').val("")),setTimeout(function(){window.location.reload()},2e3)},error:function(e){v()("#result_form_employee").html(e.error)}})},removeEmployee:function(e){v.a.ajax({url:this.url+"Employee/"+e,type:"DELETE",dataType:"html",success:function(e){var t=v.a.parseJSON(e);t.success?v()("#result_form_employee").addClass("great").html(t.success):v()("#result_form_employee").addClass("error").html(t.error),setTimeout(function(){window.location.reload()},2e3)},error:function(e){v()("#result_form_employee").html(e.error)}})},getId:function(e){this.id=e},registration:function(e,t,r){v.a.ajax({url:this.url+"Reg",type:"POST",dataType:"html",data:v()("#registration_form").serialize(),success:function(e){var t=v.a.parseJSON(e);v()("#registration_form")[0].reset(),t.success?v()("#result_form_reg").addClass("great").html(t.success):v()("#result_form_reg").addClass("error").html(t.error)},error:function(e){v()("#result_form_reg").html(e.error)}})},show_add_new_user:function(){v()("#div_ad_new_user").toggle()}}},T={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"conteiner"},[r("h4",[e._v("employee list")]),e._v(" "),r("form",{attrs:{method:"GET",action:"",id:"employee_form"}},[r("input",{staticClass:"btn_show_employee",attrs:{type:"button",id:"btn_employee",value:"Employee list"},on:{click:function(t){e.list=!e.list,e.getEmployees()}}})]),r("br"),e._v(" "),r("div",{staticClass:"result_form_employee",attrs:{id:"result_form_employee"}}),e._v(" "),r("div",{directives:[{name:"show",rawName:"v-show",value:e.list,expression:"list"}],staticClass:"div_employee_list"},[r("ul",{attrs:{id:"example-2"}},e._l(e.employeeList[0],function(t,s){return r("li",{key:s},[r("a",{attrs:{href:"#"}},[e._v(" "+e._s(t.name)+" ")]),e._v(" "),r("input",{staticClass:"remove_employee",attrs:{type:"button",value:"REMOVE"},on:{click:function(r){return e.removeEmployee(t.id)}}}),e._v(" "),r("input",{attrs:{type:"button",value:"Edit"},on:{click:function(r){e.show_edit=!e.show_edit,e.getId(t.id)}}})])}),0),e._v(" "),r("div",{staticClass:"form",attrs:{id:"div_ad_new_user"}},[r("h4",[e._v("Adding new employee")]),e._v(" "),e._m(0),e._v(" "),r("form",{attrs:{method:"POST",id:"registration_form",action:""}},[r("input",{attrs:{type:"text",name:"name",placeholder:"name"}}),r("br"),e._v(" "),r("input",{attrs:{type:"text",name:"role",placeholder:"user/admin"}}),r("br"),e._v(" "),r("input",{attrs:{type:"email",name:"email",placeholder:"email"}}),r("br"),e._v(" "),r("input",{attrs:{type:"password",name:"passwd",placeholder:"passwd"}}),r("br"),e._v(" "),r("input",{attrs:{type:"password",name:"confirm_passwd",placeholder:"confirm passwd"}}),r("br"),e._v(" "),r("input",{staticClass:"btn_add",attrs:{type:"button",id:"btn_send",value:"Add"},on:{click:function(t){return e.registration()}}})]),r("br")]),e._v(" "),r("div",{staticClass:"add_user"},[r("input",{staticClass:"btn_book_add_user",attrs:{id:"btn_book_add_user",type:"button",value:"Add Employee"},on:{click:e.show_add_new_user}})])]),e._v(" "),r("div",{directives:[{name:"show",rawName:"v-show",value:!e.show_edit,expression:"!show_edit"}]},[r("form",{attrs:{action:"",id:"edit_employee"}},[r("input",{directives:[{name:"model",rawName:"v-model",value:e.userData.name,expression:"userData.name"}],attrs:{type:"text",placeholder:"name"},domProps:{value:e.userData.name},on:{input:function(t){t.target.composing||e.$set(e.userData,"name",t.target.value)}}}),r("br"),e._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:e.userData.role,expression:"userData.role"}],attrs:{type:"text",placeholder:"user/admin"},domProps:{value:e.userData.role},on:{input:function(t){t.target.composing||e.$set(e.userData,"role",t.target.value)}}}),r("br"),e._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:e.userData.email,expression:"userData.email"}],attrs:{type:"email",placeholder:"email"},domProps:{value:e.userData.email},on:{input:function(t){t.target.composing||e.$set(e.userData,"email",t.target.value)}}}),r("br"),e._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:e.userData.passwd,expression:"userData.passwd"}],attrs:{type:"password",value:"",placeholder:"passwd"},domProps:{value:e.userData.passwd},on:{input:function(t){t.target.composing||e.$set(e.userData,"passwd",t.target.value)}}}),r("br"),e._v(" "),r("input",{staticClass:"btn btn-primary",attrs:{type:"button",id:"btn_apply",value:"Apply"},on:{click:function(t){return e.editEmployee(e.id)}}}),e._v(" "),r("br")])])])},staticRenderFns:[function(){var e=this.$createElement,t=this._self._c||e;return t("div",{attrs:{id:"result_form_reg"}},[t("br")])}]};var N=r("VU/8")(M,T,!1,function(e){r("BpSW")},"data-v-2c68dc6c",null).exports,S=r("mtWM"),R=r.n(S);s.a.prototype.$http=R.a,s.a.component("calendar",f),s.a.component("my-login",E),s.a.component("my-rooms",y),s.a.component("my-bookform",C),s.a.component("my-employee",N),s.a.config.productionTip=!1,new s.a({el:"#app",router:x,components:{App:n},template:"<App/>"})},vvrJ:function(e,t){}},["NHnr"]);
//# sourceMappingURL=app.d46a11bab0cc9363c9c8.js.map