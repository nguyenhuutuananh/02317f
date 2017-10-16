//jquery form
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery"],e):e("undefined"!=typeof jQuery?jQuery:window.Zepto)}(function(e){"use strict";function t(t){var r=t.data;t.isDefaultPrevented()||(t.preventDefault(),e(t.target).ajaxSubmit(r))}function r(t){var r=t.target,a=e(r);if(!a.is("[type=submit],[type=image]")){var n=a.closest("[type=submit]");if(0===n.length)return;r=n[0]}var i=this;if(i.clk=r,"image"==r.type)if(void 0!==t.offsetX)i.clk_x=t.offsetX,i.clk_y=t.offsetY;else if("function"==typeof e.fn.offset){var o=a.offset();i.clk_x=t.pageX-o.left,i.clk_y=t.pageY-o.top}else i.clk_x=t.pageX-r.offsetLeft,i.clk_y=t.pageY-r.offsetTop;setTimeout(function(){i.clk=i.clk_x=i.clk_y=null},100)}function a(){if(e.fn.ajaxSubmit.debug){var t="[jquery.form] "+Array.prototype.join.call(arguments,"");window.console&&window.console.log?window.console.log(t):window.opera&&window.opera.postError&&window.opera.postError(t)}}var n={};n.fileapi=void 0!==e("<input type='file'/>").get(0).files,n.formdata=void 0!==window.FormData;var i=!!e.fn.prop;e.fn.attr2=function(){if(!i)return this.attr.apply(this,arguments);var e=this.prop.apply(this,arguments);return e&&e.jquery||"string"==typeof e?e:this.attr.apply(this,arguments)},e.fn.ajaxSubmit=function(t){function r(r){var a,n,i=e.param(r,t.traditional).split("&"),o=i.length,s=[];for(a=0;o>a;a++)i[a]=i[a].replace(/\+/g," "),n=i[a].split("="),s.push([decodeURIComponent(n[0]),decodeURIComponent(n[1])]);return s}function o(a){for(var n=new FormData,i=0;i<a.length;i++)n.append(a[i].name,a[i].value);if(t.extraData){var o=r(t.extraData);for(i=0;i<o.length;i++)o[i]&&n.append(o[i][0],o[i][1])}t.data=null;var s=e.extend(!0,{},e.ajaxSettings,t,{contentType:!1,processData:!1,cache:!1,type:u||"POST"});t.uploadProgress&&(s.xhr=function(){var r=e.ajaxSettings.xhr();return r.upload&&r.upload.addEventListener("progress",function(e){var r=0,a=e.loaded||e.position,n=e.total;e.lengthComputable&&(r=Math.ceil(a/n*100)),t.uploadProgress(e,a,n,r)},!1),r}),s.data=null;var c=s.beforeSend;return s.beforeSend=function(e,r){r.data=t.formData?t.formData:n,c&&c.call(this,e,r)},e.ajax(s)}function s(r){function n(e){var t=null;try{e.contentWindow&&(t=e.contentWindow.document)}catch(r){a("cannot get iframe.contentWindow document: "+r)}if(t)return t;try{t=e.contentDocument?e.contentDocument:e.document}catch(r){a("cannot get iframe.contentDocument: "+r),t=e.document}return t}function o(){function t(){try{var e=n(g).readyState;a("state = "+e),e&&"uninitialized"==e.toLowerCase()&&setTimeout(t,50)}catch(r){a("Server abort: ",r," (",r.name,")"),s(k),j&&clearTimeout(j),j=void 0}}var r=f.attr2("target"),i=f.attr2("action"),o="multipart/form-data",c=f.attr("enctype")||f.attr("encoding")||o;w.setAttribute("target",p),(!u||/post/i.test(u))&&w.setAttribute("method","POST"),i!=m.url&&w.setAttribute("action",m.url),m.skipEncodingOverride||u&&!/post/i.test(u)||f.attr({encoding:"multipart/form-data",enctype:"multipart/form-data"}),m.timeout&&(j=setTimeout(function(){T=!0,s(D)},m.timeout));var l=[];try{if(m.extraData)for(var d in m.extraData)m.extraData.hasOwnProperty(d)&&l.push(e.isPlainObject(m.extraData[d])&&m.extraData[d].hasOwnProperty("name")&&m.extraData[d].hasOwnProperty("value")?e('<input type="hidden" name="'+m.extraData[d].name+'">').val(m.extraData[d].value).appendTo(w)[0]:e('<input type="hidden" name="'+d+'">').val(m.extraData[d]).appendTo(w)[0]);m.iframeTarget||v.appendTo("body"),g.attachEvent?g.attachEvent("onload",s):g.addEventListener("load",s,!1),setTimeout(t,15);try{w.submit()}catch(h){var x=document.createElement("form").submit;x.apply(w)}}finally{w.setAttribute("action",i),w.setAttribute("enctype",c),r?w.setAttribute("target",r):f.removeAttr("target"),e(l).remove()}}function s(t){if(!x.aborted&&!F){if(M=n(g),M||(a("cannot access response document"),t=k),t===D&&x)return x.abort("timeout"),void S.reject(x,"timeout");if(t==k&&x)return x.abort("server abort"),void S.reject(x,"error","server abort");if(M&&M.location.href!=m.iframeSrc||T){g.detachEvent?g.detachEvent("onload",s):g.removeEventListener("load",s,!1);var r,i="success";try{if(T)throw"timeout";var o="xml"==m.dataType||M.XMLDocument||e.isXMLDoc(M);if(a("isXml="+o),!o&&window.opera&&(null===M.body||!M.body.innerHTML)&&--O)return a("requeing onLoad callback, DOM not available"),void setTimeout(s,250);var u=M.body?M.body:M.documentElement;x.responseText=u?u.innerHTML:null,x.responseXML=M.XMLDocument?M.XMLDocument:M,o&&(m.dataType="xml"),x.getResponseHeader=function(e){var t={"content-type":m.dataType};return t[e.toLowerCase()]},u&&(x.status=Number(u.getAttribute("status"))||x.status,x.statusText=u.getAttribute("statusText")||x.statusText);var c=(m.dataType||"").toLowerCase(),l=/(json|script|text)/.test(c);if(l||m.textarea){var f=M.getElementsByTagName("textarea")[0];if(f)x.responseText=f.value,x.status=Number(f.getAttribute("status"))||x.status,x.statusText=f.getAttribute("statusText")||x.statusText;else if(l){var p=M.getElementsByTagName("pre")[0],h=M.getElementsByTagName("body")[0];p?x.responseText=p.textContent?p.textContent:p.innerText:h&&(x.responseText=h.textContent?h.textContent:h.innerText)}}else"xml"==c&&!x.responseXML&&x.responseText&&(x.responseXML=X(x.responseText));try{E=_(x,c,m)}catch(y){i="parsererror",x.error=r=y||i}}catch(y){a("error caught: ",y),i="error",x.error=r=y||i}x.aborted&&(a("upload aborted"),i=null),x.status&&(i=x.status>=200&&x.status<300||304===x.status?"success":"error"),"success"===i?(m.success&&m.success.call(m.context,E,"success",x),S.resolve(x.responseText,"success",x),d&&e.event.trigger("ajaxSuccess",[x,m])):i&&(void 0===r&&(r=x.statusText),m.error&&m.error.call(m.context,x,i,r),S.reject(x,"error",r),d&&e.event.trigger("ajaxError",[x,m,r])),d&&e.event.trigger("ajaxComplete",[x,m]),d&&!--e.active&&e.event.trigger("ajaxStop"),m.complete&&m.complete.call(m.context,x,i),F=!0,m.timeout&&clearTimeout(j),setTimeout(function(){m.iframeTarget?v.attr("src",m.iframeSrc):v.remove(),x.responseXML=null},100)}}}var c,l,m,d,p,v,g,x,y,b,T,j,w=f[0],S=e.Deferred();if(S.abort=function(e){x.abort(e)},r)for(l=0;l<h.length;l++)c=e(h[l]),i?c.prop("disabled",!1):c.removeAttr("disabled");if(m=e.extend(!0,{},e.ajaxSettings,t),m.context=m.context||m,p="jqFormIO"+(new Date).getTime(),m.iframeTarget?(v=e(m.iframeTarget),b=v.attr2("name"),b?p=b:v.attr2("name",p)):(v=e('<iframe name="'+p+'" src="'+m.iframeSrc+'" />'),v.css({position:"absolute",top:"-1000px",left:"-1000px"})),g=v[0],x={aborted:0,responseText:null,responseXML:null,status:0,statusText:"n/a",getAllResponseHeaders:function(){},getResponseHeader:function(){},setRequestHeader:function(){},abort:function(t){var r="timeout"===t?"timeout":"aborted";a("aborting upload... "+r),this.aborted=1;try{g.contentWindow.document.execCommand&&g.contentWindow.document.execCommand("Stop")}catch(n){}v.attr("src",m.iframeSrc),x.error=r,m.error&&m.error.call(m.context,x,r,t),d&&e.event.trigger("ajaxError",[x,m,r]),m.complete&&m.complete.call(m.context,x,r)}},d=m.global,d&&0===e.active++&&e.event.trigger("ajaxStart"),d&&e.event.trigger("ajaxSend",[x,m]),m.beforeSend&&m.beforeSend.call(m.context,x,m)===!1)return m.global&&e.active--,S.reject(),S;if(x.aborted)return S.reject(),S;y=w.clk,y&&(b=y.name,b&&!y.disabled&&(m.extraData=m.extraData||{},m.extraData[b]=y.value,"image"==y.type&&(m.extraData[b+".x"]=w.clk_x,m.extraData[b+".y"]=w.clk_y)));var D=1,k=2,A=e("meta[name=csrf-token]").attr("content"),L=e("meta[name=csrf-param]").attr("content");L&&A&&(m.extraData=m.extraData||{},m.extraData[L]=A),m.forceSync?o():setTimeout(o,10);var E,M,F,O=50,X=e.parseXML||function(e,t){return window.ActiveXObject?(t=new ActiveXObject("Microsoft.XMLDOM"),t.async="false",t.loadXML(e)):t=(new DOMParser).parseFromString(e,"text/xml"),t&&t.documentElement&&"parsererror"!=t.documentElement.nodeName?t:null},C=e.parseJSON||function(e){return window.eval("("+e+")")},_=function(t,r,a){var n=t.getResponseHeader("content-type")||"",i="xml"===r||!r&&n.indexOf("xml")>=0,o=i?t.responseXML:t.responseText;return i&&"parsererror"===o.documentElement.nodeName&&e.error&&e.error("parsererror"),a&&a.dataFilter&&(o=a.dataFilter(o,r)),"string"==typeof o&&("json"===r||!r&&n.indexOf("json")>=0?o=C(o):("script"===r||!r&&n.indexOf("javascript")>=0)&&e.globalEval(o)),o};return S}if(!this.length)return a("ajaxSubmit: skipping submit process - no element selected"),this;var u,c,l,f=this;"function"==typeof t?t={success:t}:void 0===t&&(t={}),u=t.type||this.attr2("method"),c=t.url||this.attr2("action"),l="string"==typeof c?e.trim(c):"",l=l||window.location.href||"",l&&(l=(l.match(/^([^#]+)/)||[])[1]),t=e.extend(!0,{url:l,success:e.ajaxSettings.success,type:u||e.ajaxSettings.type,iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank"},t);var m={};if(this.trigger("form-pre-serialize",[this,t,m]),m.veto)return a("ajaxSubmit: submit vetoed via form-pre-serialize trigger"),this;if(t.beforeSerialize&&t.beforeSerialize(this,t)===!1)return a("ajaxSubmit: submit aborted via beforeSerialize callback"),this;var d=t.traditional;void 0===d&&(d=e.ajaxSettings.traditional);var p,h=[],v=this.formToArray(t.semantic,h);if(t.data&&(t.extraData=t.data,p=e.param(t.data,d)),t.beforeSubmit&&t.beforeSubmit(v,this,t)===!1)return a("ajaxSubmit: submit aborted via beforeSubmit callback"),this;if(this.trigger("form-submit-validate",[v,this,t,m]),m.veto)return a("ajaxSubmit: submit vetoed via form-submit-validate trigger"),this;var g=e.param(v,d);p&&(g=g?g+"&"+p:p),"GET"==t.type.toUpperCase()?(t.url+=(t.url.indexOf("?")>=0?"&":"?")+g,t.data=null):t.data=g;var x=[];if(t.resetForm&&x.push(function(){f.resetForm()}),t.clearForm&&x.push(function(){f.clearForm(t.includeHidden)}),!t.dataType&&t.target){var y=t.success||function(){};x.push(function(r){var a=t.replaceTarget?"replaceWith":"html";e(t.target)[a](r).each(y,arguments)})}else t.success&&x.push(t.success);if(t.success=function(e,r,a){for(var n=t.context||this,i=0,o=x.length;o>i;i++)x[i].apply(n,[e,r,a||f,f])},t.error){var b=t.error;t.error=function(e,r,a){var n=t.context||this;b.apply(n,[e,r,a,f])}}if(t.complete){var T=t.complete;t.complete=function(e,r){var a=t.context||this;T.apply(a,[e,r,f])}}var j=e("input[type=file]:enabled",this).filter(function(){return""!==e(this).val()}),w=j.length>0,S="multipart/form-data",D=f.attr("enctype")==S||f.attr("encoding")==S,k=n.fileapi&&n.formdata;a("fileAPI :"+k);var A,L=(w||D)&&!k;t.iframe!==!1&&(t.iframe||L)?t.closeKeepAlive?e.get(t.closeKeepAlive,function(){A=s(v)}):A=s(v):A=(w||D)&&k?o(v):e.ajax(t),f.removeData("jqxhr").data("jqxhr",A);for(var E=0;E<h.length;E++)h[E]=null;return this.trigger("form-submit-notify",[this,t]),this},e.fn.ajaxForm=function(n){if(n=n||{},n.delegation=n.delegation&&e.isFunction(e.fn.on),!n.delegation&&0===this.length){var i={s:this.selector,c:this.context};return!e.isReady&&i.s?(a("DOM not ready, queuing ajaxForm"),e(function(){e(i.s,i.c).ajaxForm(n)}),this):(a("terminating; zero elements found by selector"+(e.isReady?"":" (DOM not ready)")),this)}return n.delegation?(e(document).off("submit.form-plugin",this.selector,t).off("click.form-plugin",this.selector,r).on("submit.form-plugin",this.selector,n,t).on("click.form-plugin",this.selector,n,r),this):this.ajaxFormUnbind().bind("submit.form-plugin",n,t).bind("click.form-plugin",n,r)},e.fn.ajaxFormUnbind=function(){return this.unbind("submit.form-plugin click.form-plugin")},e.fn.formToArray=function(t,r){var a=[];if(0===this.length)return a;var i,o=this[0],s=this.attr("id"),u=t?o.getElementsByTagName("*"):o.elements;if(u&&!/MSIE [678]/.test(navigator.userAgent)&&(u=e(u).get()),s&&(i=e(':input[form="'+s+'"]').get(),i.length&&(u=(u||[]).concat(i))),!u||!u.length)return a;var c,l,f,m,d,p,h;for(c=0,p=u.length;p>c;c++)if(d=u[c],f=d.name,f&&!d.disabled)if(t&&o.clk&&"image"==d.type)o.clk==d&&(a.push({name:f,value:e(d).val(),type:d.type}),a.push({name:f+".x",value:o.clk_x},{name:f+".y",value:o.clk_y}));else if(m=e.fieldValue(d,!0),m&&m.constructor==Array)for(r&&r.push(d),l=0,h=m.length;h>l;l++)a.push({name:f,value:m[l]});else if(n.fileapi&&"file"==d.type){r&&r.push(d);var v=d.files;if(v.length)for(l=0;l<v.length;l++)a.push({name:f,value:v[l],type:d.type});else a.push({name:f,value:"",type:d.type})}else null!==m&&"undefined"!=typeof m&&(r&&r.push(d),a.push({name:f,value:m,type:d.type,required:d.required}));if(!t&&o.clk){var g=e(o.clk),x=g[0];f=x.name,f&&!x.disabled&&"image"==x.type&&(a.push({name:f,value:g.val()}),a.push({name:f+".x",value:o.clk_x},{name:f+".y",value:o.clk_y}))}return a},e.fn.formSerialize=function(t){return e.param(this.formToArray(t))},e.fn.fieldSerialize=function(t){var r=[];return this.each(function(){var a=this.name;if(a){var n=e.fieldValue(this,t);if(n&&n.constructor==Array)for(var i=0,o=n.length;o>i;i++)r.push({name:a,value:n[i]});else null!==n&&"undefined"!=typeof n&&r.push({name:this.name,value:n})}}),e.param(r)},e.fn.fieldValue=function(t){for(var r=[],a=0,n=this.length;n>a;a++){var i=this[a],o=e.fieldValue(i,t);null===o||"undefined"==typeof o||o.constructor==Array&&!o.length||(o.constructor==Array?e.merge(r,o):r.push(o))}return r},e.fieldValue=function(t,r){var a=t.name,n=t.type,i=t.tagName.toLowerCase();if(void 0===r&&(r=!0),r&&(!a||t.disabled||"reset"==n||"button"==n||("checkbox"==n||"radio"==n)&&!t.checked||("submit"==n||"image"==n)&&t.form&&t.form.clk!=t||"select"==i&&-1==t.selectedIndex))return null;if("select"==i){var o=t.selectedIndex;if(0>o)return null;for(var s=[],u=t.options,c="select-one"==n,l=c?o+1:u.length,f=c?o:0;l>f;f++){var m=u[f];if(m.selected){var d=m.value;if(d||(d=m.attributes&&m.attributes.value&&!m.attributes.value.specified?m.text:m.value),c)return d;s.push(d)}}return s}return e(t).val()},e.fn.clearForm=function(t){return this.each(function(){e("input,select,textarea",this).clearFields(t)})},e.fn.clearFields=e.fn.clearInputs=function(t){var r=/^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;return this.each(function(){var a=this.type,n=this.tagName.toLowerCase();r.test(a)||"textarea"==n?this.value="":"checkbox"==a||"radio"==a?this.checked=!1:"select"==n?this.selectedIndex=-1:"file"==a?/MSIE/.test(navigator.userAgent)?e(this).replaceWith(e(this).clone(!0)):e(this).val(""):t&&(t===!0&&/hidden/.test(a)||"string"==typeof t&&e(this).is(t))&&(this.value="")})},e.fn.resetForm=function(){return this.each(function(){("function"==typeof this.reset||"object"==typeof this.reset&&!this.reset.nodeType)&&this.reset()})},e.fn.enable=function(e){return void 0===e&&(e=!0),this.each(function(){this.disabled=!e})},e.fn.selected=function(t){return void 0===t&&(t=!0),this.each(function(){var r=this.type;if("checkbox"==r||"radio"==r)this.checked=t;else if("option"==this.tagName.toLowerCase()){var a=e(this).parent("select");t&&a[0]&&"select-one"==a[0].type&&a.find("option").selected(!1),this.selected=t}})},e.fn.ajaxSubmit.debug=!1});


window.chat_checking = false;
window.lastchecktime = "";
window.chatLastNotificationCount = 0;
function messagingSetCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function messagingGetCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function messaging_slugify(string) {
return string
        .toString()
        .trim()
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]+/g, "")
        .replace(/\-\-+/g, "-")
        .replace(/^-+/, "")
        .replace(/-+$/, "");
}
function messaging_show_chat_list(t) {
    var c = $("#chat-list-container");
    var opener = $(t);
    var openerI = opener.find('i');
    var count = $(".chat-list-opener .count");
    if (c.css('display') == 'none') {
        c.show();
        chat_check_new_event();
        openerI.removeClass('fa-comments');
        openerI.addClass("fa-times");
        count.hide();
        $(".chat-box").fadeIn(); //show all boxes opened
        messagingSetCookie("messaging_chat_list_opened", "1");
    } else {
        c.hide();
        openerI.removeClass('fa-times');
        openerI.addClass("fa-comments");
         $(".chat-box").fadeOut(); //hide all boxes opened
        count.show();
        messagingSetCookie("messaging_chat_list_opened", "");
    }
    return false;
}
function close_messaging_chat_list() {
    messaging_show_chat_list($("#chat-list-opener-btn"))
    return false;
}
function messaging_scroll_bottom(div) {
    $(div).animate({ scrollTop: $(div).prop("scrollHeight")}, 1000);
}
function chat_check_new_event() {
    if (window.chat_checking == true) return false;
    window.chat_checking = true;
    var openCid = MessagingChat.getOpenCids();
    //alert(openCid);
    $.ajax({
        url : site_url + "messaging/check",
        data : {cids : openCid,last_time : window.lastchecktime},
        success: function(data) {
            window.chat_checking = false;
            var json = jQuery.parseJSON(data);
            window.lastchecktime = json.lastcheck;
            $("#chat-list-staff").html(json.staffs);
            $("#chat-list-contacts").html(json.contacts)
            $("#group-chat-list").html(json.groups);
            var notify = false;
            if (json.unread_messages != '0') {
                if (json.unread_messages != window.chatLastNotificationCount) notify = true;
                window.chatLastNotificationCount = json.unread_messages;
                $("#chat-notification-count").html(json.unread_messages)
                $("#chat-notification-count").show();
            } else {
                $("#chat-notification-count").hide();
            }
            $(".chat-online-count").html(json.online_count);
            var loop = $.each(json.chat_boxes, function(k, v) {

                $(".chat-box").each(function() {
                    if ($(this).data('cid') == k) {
                        notify = true;
                        $(this).find('.messages-container').append(v);
                        messaging_scroll_bottom($(this).find('.messages-container'));
                    }
                })
            });
            if (notify) {
                    var audio = document.getElementById('messaging-sound');
                                audio.load();
                                audio.play();
              }
        }
    })
}
function messaging_toggle(id) {
    var c = $(id);
    if (c.css('display') == 'none') {
        c.fadeIn();
    } else {
        c.fadeOut();
    }
    return false;
}

function messaging_open_photo_viewer(im) {
    var container = $("#messaging-photo-viewer");
    var img = container.find('img');
    img.attr('src', im);
    container.fadeIn();
    container.click(function(){
        container.fadeOut();
    })
    return false;
}
function messaging_close_photo_viewer() {
    var container = $("#messaging-photo-viewer");
    container.fadeOut();
    return false;
}

function messaging_open_file(elemId) {
    $("#"+elemId).click();
 }
var MessagingChat = {
    boxes : [],
    right :0,
    getOpenCids: function() {
        var cids = "";

        $(".chat-box").each(function() {
            if  ($(this).data('cid') != undefined && $(this).data('cid') != '') {
                cids +=(cids == "") ? $(this).data('cid') : ","+$(this).data('cid');
            }
        });
        this.saveCids(false);
        return cids;
    },
    saveCids : function(saveEmpty) {
        var cookieCids = "";
        $(".chat-box").each(function() {
            var coData = ""+ $(this).data('cid') + '|'+$(this).data('title') + "|"+$(this).data('type')+'|'+$(this).data('user_type')+'|'+$(this).data('can_delete') + '|' + $(this).data('uid');
            cookieCids += (cookieCids == "") ? coData  : "||" + coData;
        });


        if (cookieCids == '' && !saveEmpty) return false;
        messagingSetCookie("messaging_open_chat", cookieCids);
    },
    open : function(title,cid,uid,type,user_type, can_delete, hideIt) {
        var id = "chat-box-" + messaging_slugify(title);

        if (this.isOpened(id)) return false;
        //alert(id);
        this.saveCids(true);
        this.boxes.push(id);

        var hide = (hideIt != undefined && hideIt == false) ? "box-hide" : '';

        var chat = $("<div  data-title='"+title+"' data-uid='"+uid+"'  data-type='"+type+"'  data-user_type='"+user_type+"'  data-can_delete='"+can_delete+"' data-cid='"+cid+"' class='chat-box "+hide+"' id='"+id+"'></div>");
        var chatHead = $("<div class='head clearfix' style='background-color:"+chatHeadColor+";'></div>");
        chatHead.append("<div class='pull-left'>" + title + "</div>");
        var headRight = $("<div class='pull-right'></a>");
        if (type != 'single') {
            headRight.append("<a class='add-more-staff' data-cid='"+cid+"' href=''><i class='fa fa-plus'></i></a>");
            if (can_delete != undefined && can_delete) {
            headRight.append("<a title='Delete group' class='messaging-delete-group' data-cid='"+cid+"' href=''><i class='fa fa-trash-o'></i></a>");
            }
        }
        headRight.append("<a class='remove' href=''><i class='fa fa-times-circle-o'></i></a>");
        chatHead.append(headRight);
        //chatHead.append("<a href=''><i class='fa fa-cog'></i></a></div>");
        chat.append(chatHead);

        var m = $("<div class='messages-container'></div>");
        m.append("<a class='chat-load-more' href='' style='display:block;padding:2px;text-align:center;font-size:15px;color:#BABABA;'><i class='fa fa-ellipsis-h'></i></a>")
        m.append("<div class='main-messages-container'></div>");
        chat.append(m);
        var chatForm = $("<form enctype='multipart/form-data' data-id='"+id+"' action='' method='post'></form>");
        chatForm.append("<input type='hidden' name='uid' value='"+uid+"'/><input type='hidden' name='cid' value='"+cid+"'/><input type='hidden' name='user_type' value='"+user_type+"'/>")
        chatForm.append("<textarea data-id='"+id+"' placeholder='"+type_a_message_str+"' name='message'></textarea>");

        chatForm.append("<input data-id='"+id+"' id='"+id+"-file-file' style='position:fixed;top:-1000;visibility:hidden' type='file' name='file'/><input data-id='"+id+"' style='visibility:hidden;position:fixed;top:-1000' id='"+id+"-photo-file' type='file' name='photo'/><div class='chat-form-icons'><a class='message-open-file' data-ref='"+id+"-photo-file' href=''><i class='fa fa-picture-o'></i></a><a href='' class='message-open-file' data-ref='"+id+"-file-file'><i class='fa fa-file-o'></i></a> <a class='emoticon' href=''><i class='fa fa-smile-o'></i></a> <a data-id='"+id+"' class='like pull-right' href=''><i class='fa fa-thumbs-up'></i></a></div>")
        chat.append(chatForm);

        chat.append("<div class='messaging-emoticons' data-target='"+id+"'></div>");
        chat.click(function() {
            $('.messaging-emoticons').hide();
        });
        chat.find('.messaging-delete-group').click(function() {
            var c = confirm("Are you sure?");
            if (c == true) {
                $.ajax({
                    url : site_url + 'messaging/deletegroup',
                    data : {cid : cid},
                    success : function(r) {
                        chat.fadeOut();
                        var thisId = chat.prop('id');
                        MessagingChat.removeBox(thisId);
                        chat.remove();
                    }
                })
            }
            return false;
        });

        chat.find('.chat-load-more').click(function() {
            var offset = (chat.data('offset') == undefined) ? 0 : chat.data('offset');
            //alert(offset)
            var cid = chat.data('cid');
            if (cid == '') return false;
            $.ajax({
                url : site_url + 'messaging/load_more_messages',
                data : {cid: cid, offset : offset},
                success : function(d) {
                    var json = jQuery.parseJSON(d);
                    chat.data('offset', json.offset);
                    chat.prop('data-offset', json.offset);
                    chat.find('.main-messages-container').prepend(json.result);
                }
            })
            return false;
        });
        $("body").append(chat);
        chat.draggable();
        chatForm.find('#'+id+'-photo-file').on('change', function() {
            MessagingChat.submit($(this).data('id'));
        });
        chatForm.find('#'+id+'-file-file').on('change', function() {
                    MessagingChat.submit($(this).data('id'));
                });
        chatForm.find('.like').on('click', function(e) {
            var f = $("#" + $(this).data('id')).find('form');
            f.append('<input type="hidden" name="like" id="like-it-input" value="1"/>');
            MessagingChat.submit($(this).data('id'));
            return false;
        });
        chatForm.find('.emoticon').on('click', function() {
            var c = chat.find('.messaging-emoticons');
            if (c.css('display') == 'none') {
                c.fadeIn();
                if (c.html() == '') {
                    $.ajax({
                        url: site_url + 'messaging/loademoticons',
                        success: function(d) {
                            c.html(d);
                        }
                    })
                }
            } else {
                c.hide();
            }
            return false;
        });
        $(document).on('click','.messaging-emoticons a', function() {
            var s = $(this).data('symbol');
            //alert($(this).parent().data('target'));
            var p = $("#" + $(this).parent().data('target'));
            //alert(chatForm.find('.textarea').val());
            p.find('textarea').val(p.find('textarea').val() + ' '+ s + ' ');
            p.find('textarea').focus();
            return false;
        });
        chatForm.find('textarea').on("keypress", function(e) {
            if (e.keyCode == 13) {
                if ($(this).val() != '') {
                    MessagingChat.submit($(this).data('id'));
                }
                return false;
            }
            e.stopPropagation();
        });

        this.reCalculate();
        this.saveCids(true);//to safely store opened chats
        //preload the chat message
        chat.find('.remove').on('click', function() {
            chat.fadeOut();
            var thisId = chat.prop('id');
            chat.remove();
            MessagingChat.removeBox(thisId);
            return false;
        });
        $.ajax({
            url : site_url + 'messaging/preload',
            data : {cid:cid,uid:uid,user_type},
            success : function(r) {
                var box = $("#"+id);
                var json = jQuery.parseJSON(r);
                box.find('.main-messages-container').prepend(json.result);
                box.data('cid', json.cid);
                messaging_scroll_bottom(box.find('.messages-container'));
            }
        })

        return false;
    },
    openMessage : function(title,cid,uid,type,user_type, can_delete) {
        var box = $('.single-message-box');
        $("#main-messages-right").html('');
        $.ajax({
            url : site_url + "messaging/load_message",
            data :{title:title,cid:cid,uid:uid,type:type,user_type:user_type,can_delete:can_delete},
            success : function(data) {
                $("#main-messages-right").html(data);
                //alert(box.find('.messages-container'));
                setTimeout(function(){
                messaging_scroll_bottom($('#single-message-box .messages-container'));
                }, 200);
                var url = site_url + 'messaging/messages?cid=' + cid;
                window.history.pushState({}, 'New URL:' + url, url);
            }
        });
    },
    isOpened : function(id) {
        this.prepareForNextBox();
        if ($("#"+id).length > 0) return true;
        return false;
    },

    prepareForNextBox: function() {
        var windowWidth = $(window).width();
        var openedBoxes = this.boxes.length;
        var possibleBoxes = (windowWidth < 700) ? 1 : Math.round(windowWidth / 270) - 1;
        //alert(possibleBoxes);
        if (openedBoxes < possibleBoxes) {

        } else {
            //remove the first opened boxes
           var firstChat = $("#" + this.boxes[0]);
           this.boxes.shift();
           firstChat.remove();

        }
    },

    removeBox : function(theId) {
        var newBoxes = [];
        for(i=0;i<=this.boxes.length;i++) {
            id = this.boxes[i];
            if (id != theId & id != undefined) newBoxes.push(id);
        }
        this.boxes = newBoxes;
        this.reCalculate();
        this.saveCids(true);//to resave opened chats
    },

    reCalculate: function() {

        this.right = 0;
        if ($(window).width() < 700) return;
        for(i=this.boxes.length;i >= 1;i--) {
            id = this.boxes[i - 1];

            if (this.right != 0) this.right +=40;
            this.right += 240;

            var chat = $("#"+id);
           // alert(this.right);
            chat.attr("style", "right:" + this.right + "px !important");
        }
    },

    submit : function(id) {

        var box = $("#"+id);
        var f = box.find('form');

        f.ajaxSubmit({
            url : site_url + "messaging/send",
            type : 'POST',
            beforeSend : function() {
                f.css('opacity', '0.4');
                f.find('textarea').val(f.find('textarea').val());
                f.find('textarea').blur();

            },
            success : function(result) {
                var json = jQuery.parseJSON(result);
                 box.find('.main-messages-container').append(json.message);
                 box.data('cid', json.cid);
                 f.find('textarea').val('');
                 f.find('#'+id+'-photo-file').val('');
                 f.find('#'+id+'-file-file').val('');
                 $('#like-it-input').remove();
                 messaging_scroll_bottom(box.find('.main-messages-container'));
                 f.css('opacity', '1');
                 f.find('textarea').focus();
            }
        })
    },
    submitMessage: function(f) {
        var box = $(".single-message-box")
        f.ajaxSubmit({
            url : site_url + "messaging/send",
            type : 'POST',
            beforeSend : function() {
                f.css('opacity', '0.4');
                f.find('textarea').val(f.find('textarea').val());
                f.find('textarea').blur();

            },
            success : function(result) {
                var json = jQuery.parseJSON(result);
                 box.find('.messages-container').append(json.message);
                 box.data('cid', json.cid);
                 f.find('textarea').val('');
                 f.find('#main-message-photo-file').val('');
                 f.find('#main-message-file-file').val('');
                 $('#like-it-input').remove();
                 messaging_scroll_bottom(box.find('.messages-container'));
                 f.css('opacity', '1');
                 f.find('textarea').focus();
            }
        })
    }
};
$(function() {
    chat_check_new_event();
    setInterval(function() {
        chat_check_new_event();
    }, 10000);

    $(document).on("click", ".message-open-file", function(e) {
        var ref = $(this).data('ref');
        messaging_open_file(ref);
        e.stopPropagation();
        return false;
    })

    $(document).on("submit", '#new-chat-group-form', function() {
        var f = $(this);
        f.css('opacity', '0.5');
        f.ajaxSubmit({
            url : site_url + 'messaging/add_group',
            success : function(r) {
                $("#group-chat-list").html(r);
                f.hide();
                f.css('opacity', '1');
            }
        })
        return false;
    });

    //$(".navbar-right").append("");
    if ($("#customer-chat-notification").length > 0) {
        var c = $("#customer-chat-notification").html();
        $("#customer-chat-notification").html('');
        $('.navbar-right').prepend(c);
    }

    $(document).on('click','#messaging-icon-trigger', function() {
        $.ajax({
            url : site_url + 'messaging/dropdown',
            success : function(d) {
                $('.messaging-dropdown-list').html(d);
            }
        })
    });

    $(document).on('click', '.add-more-staff', function() {
        $("#messaging-group-addstaff-modal").modal("show");
        $("#messaging-add-staff-form").find('.cid').val($(this).data('cid'));
        return false;
    });

    $(document).on('submit', '#messaging-add-staff-form', function() {
        var f = $(this);
        f.css('opacity', '0.4');
        f.ajaxSubmit({
            url : site_url + "messaging/addstaff",
            success : function(r) {
                 $("#messaging-group-addstaff-modal").modal("hide");
                 f.css('opacity', '1');
            }
        });
        return false;
    });

    var openedChats = messagingGetCookie('messaging_open_chat');
    var chatListOpened = messagingGetCookie("messaging_chat_list_opened");
    var autoShow = (chatListOpened != "") ? true : false;
    if (autoShow) {
        messaging_show_chat_list($("#chat-list-opener-btn"));
    }
    //alert(openedChats);
    if (openedChats != "") {
        chats = openedChats.split("||");
        $.each(chats, function(k, chat) {
            var details = chat.split('|');
            var coData = ""+ $(this).data('cid') + '|'+$(this).data('title') + "|"+$(this).data('type')+'|'+$(this).data('user_type')+'|'+$(this).data('can_delete');
            MessagingChat.open(details[1],details[0],details[5],details[2],details[3], details[4], autoShow);
        });
    }

    if ($("#settings-form").length > 0) {
        $('.panel-body > ul').append("<li><a href='"+site_url+"messaging/settings'>"+message_settings_str+"</a></li>")
    }

    if ($("#side-menu").length > 0) {
        var a = ($("#main-messages").length > 0) ? 'active' : '';
        $('<li class="menu-item-messages '+a+'"><a href="'+site_url+'messaging/messages" aria-expanded="false"><i class="fa fa-commenting-o menu-icon"></i>'+messagesStr+'</a></li>').insertAfter(".menu-item-dashboard")
    }

    if ($("#main-messages").length > 0) {
        $('body').css('overflow-y', 'hidden !important')
    }

    $(document).on('submit', '#main-message-form', function() {
        var f = $(this);
        MessagingChat.submitMessage(f);
        return false;
    });

    $(document).on('click', '#chat-load-more', function() {
        var chat = $('.single-message-box');
        var offset = (chat.data('offset') == undefined) ? 0 : chat.data('offset');
            //alert(offset)
            var cid = chat.data('cid');
            if (cid == '') return false;
            $.ajax({
                url : site_url + 'messaging/load_more_messages',
                data : {cid: cid, offset : offset},
                success : function(d) {
                    var json = jQuery.parseJSON(d);
                    chat.data('offset', json.offset);
                    chat.prop('data-offset', json.offset);
                    chat.find('.messages-container').prepend(json.result);
                }
            })
            return false;
    });

    $(document).on('click','.messaging-emoticons a', function() {
                var s = $(this).data('symbol');
                //alert($(this).parent().data('target'));
                var p = $("#" + $(this).parent().data('target'));
                //alert(chatForm.find('.textarea').val());
                p.find('textarea').val(p.find('textarea').val() + ' '+ s + ' ');
                p.find('textarea').focus();
                $('.messaging-emoticons').hide();
                return false;
            });
            $(document).on("keypress", ".single-message-box textarea", function(e) {
                if (e.keyCode == 13) {
                    if ($(this).val() != '') {
                        var f = $('.single-message-box form');
                        MessagingChat.submitMessage(f);
                    }
                    return false;
                }
                e.stopPropagation();
            });

    $(document).on('change', '#main-message-photo-file', function() {
            var f = $('.single-message-box form');
            MessagingChat.submitMessage(f);
        });
        $(document).on('change', '#main-message-file-file', function() {
            var f = $('.single-message-box form');
            MessagingChat.submitMessage(f);

                });
        $(document).on('click', '.single-message-box .like', function(e) {
            var f = $('.single-message-box form');
            f.append('<input type="hidden" name="like" id="like-it-input" value="1"/>');
            MessagingChat.submitMessage(f);
            return false;
        });
        $(document).on('click', '.single-message-box .emoticon', function(e) {
            var chat = $('.single-message-box')
            var c = chat.find('.messaging-emoticons');
            if (c.css('display') == 'none') {
                c.fadeIn();
                if (c.html() == '') {
                    $.ajax({
                        url: site_url + 'messaging/loademoticons',
                        success: function(d) {
                            c.html(d);
                        }
                    })
                }
            } else {
                c.hide();
            }
            return false;
        });

        $(document).on('click', '.single-message-box', function() {
            $(this).find('.messaging-emoticons').hide();
        })

        $(document).on("submit", "#new-message-form", function() {
            var f = $(this);
            f.css('opacity', '0.3')
            f.ajaxSubmit({
                url : site_url + 'messaging/send_new_message',
                success : function(data) {
                    $("#messaging-send-modal").modal('hide');
                    f.css('opacity', '1')
                    f.find('textarea').val('');
                    f.find('input').val('')
                    var data = jQuery.parseJSON(data);
                    alert(data.message);
                    window.location = data.link;
                }
            })
            return false;
        });

        if ($("#open-message").length > 0) {
            var c = $("#open-message");
            MessagingChat.openMessage(c.data('title'), c.data('cid'), '', c.data('type'), c.data('is-contact'))
        }
});