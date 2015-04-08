/**
 * BxSlider v4.1.2 - Fully loaded, responsive content slider
 * http://bxslider.com
 *
 * Copyright 2014, Steven Wanderski - http://stevenwanderski.com - http://bxcreative.com
 * Written while drinking Belgian ales and listening to jazz
 *
 * Released under the MIT license - http://opensource.org/licenses/MIT
 */
!function(t){var e={},s={mode:"horizontal",slideSelector:"",infiniteLoop:!0,hideControlOnEnd:!1,speed:500,easing:null,slideMargin:0,startSlide:0,randomStart:!1,captions:!1,ticker:!1,tickerHover:!1,adaptiveHeight:!1,adaptiveHeightSpeed:500,video:!1,useCSS:!0,preloadImages:"visible",responsive:!0,slideZIndex:50,touchEnabled:!0,swipeThreshold:50,oneToOneTouch:!0,preventDefaultSwipeX:!0,preventDefaultSwipeY:!1,pager:!0,pagerType:"full",pagerShortSeparator:" / ",pagerSelector:null,buildPager:null,pagerCustom:null,controls:!0,nextText:"Next",prevText:"Prev",nextSelector:null,prevSelector:null,autoControls:!1,startText:"Start",stopText:"Stop",autoControlsCombine:!1,autoControlsSelector:null,auto:!1,pause:4e3,autoStart:!0,autoDirection:"next",autoHover:!1,autoDelay:0,minSlides:1,maxSlides:1,moveSlides:0,slideWidth:0,onSliderLoad:function(){},onSlideBefore:function(){},onSlideAfter:function(){},onSlideNext:function(){},onSlidePrev:function(){},onSliderResize:function(){}};t.fn.bxSlider=function(n){if(0==this.length)return this;if(this.length>1)return this.each(function(){t(this).bxSlider(n)}),this;var o={},r=this;e.el=this;var a=t(window).width(),l=t(window).height(),d=function(){o.settings=t.extend({},s,n),o.settings.slideWidth=parseInt(o.settings.slideWidth),o.children=r.children(o.settings.slideSelector),o.children.length<o.settings.minSlides&&(o.settings.minSlides=o.children.length),o.children.length<o.settings.maxSlides&&(o.settings.maxSlides=o.children.length),o.settings.randomStart&&(o.settings.startSlide=Math.floor(Math.random()*o.children.length)),o.active={index:o.settings.startSlide},o.carousel=o.settings.minSlides>1||o.settings.maxSlides>1,o.carousel&&(o.settings.preloadImages="all"),o.minThreshold=o.settings.minSlides*o.settings.slideWidth+(o.settings.minSlides-1)*o.settings.slideMargin,o.maxThreshold=o.settings.maxSlides*o.settings.slideWidth+(o.settings.maxSlides-1)*o.settings.slideMargin,o.working=!1,o.controls={},o.interval=null,o.animProp="vertical"==o.settings.mode?"top":"left",o.usingCSS=o.settings.useCSS&&"fade"!=o.settings.mode&&function(){var t=document.createElement("div"),e=["WebkitPerspective","MozPerspective","OPerspective","msPerspective"];for(var i in e)if(void 0!==t.style[e[i]])return o.cssPrefix=e[i].replace("Perspective","").toLowerCase(),o.animProp="-"+o.cssPrefix+"-transform",!0;return!1}(),"vertical"==o.settings.mode&&(o.settings.maxSlides=o.settings.minSlides),r.data("origStyle",r.attr("style")),r.children(o.settings.slideSelector).each(function(){t(this).data("origStyle",t(this).attr("style"))}),c()},c=function(){r.wrap('<div class="bx-wrapper"><div class="bx-viewport"></div></div>'),o.viewport=r.parent(),o.loader=t('<div class="bx-loading" />'),o.viewport.prepend(o.loader),r.css({width:"horizontal"==o.settings.mode?100*o.children.length+215+"%":"auto",position:"relative"}),o.usingCSS&&o.settings.easing?r.css("-"+o.cssPrefix+"-transition-timing-function",o.settings.easing):o.settings.easing||(o.settings.easing="swing"),f(),o.viewport.css({width:"100%",overflow:"hidden",position:"relative"}),o.viewport.parent().css({maxWidth:p()}),o.settings.pager||o.viewport.parent().css({margin:"0 auto 0px"}),o.children.css({"float":"horizontal"==o.settings.mode?"left":"none",listStyle:"none",position:"relative"}),o.children.css("width",u()),"horizontal"==o.settings.mode&&o.settings.slideMargin>0&&o.children.css("marginRight",o.settings.slideMargin),"vertical"==o.settings.mode&&o.settings.slideMargin>0&&o.children.css("marginBottom",o.settings.slideMargin),"fade"==o.settings.mode&&(o.children.css({position:"absolute",zIndex:0,display:"none"}),o.children.eq(o.settings.startSlide).css({zIndex:o.settings.slideZIndex,display:"block"})),o.controls.el=t('<div class="bx-controls" />'),o.settings.captions&&P(),o.active.last=o.settings.startSlide==x()-1,o.settings.video&&r.fitVids();var e=o.children.eq(o.settings.startSlide);"all"==o.settings.preloadImages&&(e=o.children),o.settings.ticker?o.settings.pager=!1:(o.settings.pager&&T(),o.settings.controls&&C(),o.settings.auto&&o.settings.autoControls&&E(),(o.settings.controls||o.settings.autoControls||o.settings.pager)&&o.viewport.after(o.controls.el)),g(e,h)},g=function(e,i){var s=e.find("img, iframe").length;if(0==s)return i(),void 0;var n=0;e.find("img, iframe").each(function(){t(this).one("load",function(){++n==s&&i()}).each(function(){this.complete&&t(this).load()})})},h=function(){if(o.settings.infiniteLoop&&"fade"!=o.settings.mode&&!o.settings.ticker){var e="vertical"==o.settings.mode?o.settings.minSlides:o.settings.maxSlides,i=o.children.slice(0,e).clone().addClass("bx-clone"),s=o.children.slice(-e).clone().addClass("bx-clone");r.append(i).prepend(s)}o.loader.remove(),S(),"vertical"==o.settings.mode&&(o.settings.adaptiveHeight=!0),o.viewport.height(v()),r.redrawSlider(),o.settings.onSliderLoad(o.active.index),o.initialized=!0,o.settings.responsive&&t(window).bind("resize",Z),o.settings.auto&&o.settings.autoStart&&H(),o.settings.ticker&&L(),o.settings.pager&&q(o.settings.startSlide),o.settings.controls&&W(),o.settings.touchEnabled&&!o.settings.ticker&&O()},v=function(){var e=0,s=t();if("vertical"==o.settings.mode||o.settings.adaptiveHeight)if(o.carousel){var n=1==o.settings.moveSlides?o.active.index:o.active.index*m();for(s=o.children.eq(n),i=1;i<=o.settings.maxSlides-1;i++)s=n+i>=o.children.length?s.add(o.children.eq(i-1)):s.add(o.children.eq(n+i))}else s=o.children.eq(o.active.index);else s=o.children;return"vertical"==o.settings.mode?(s.each(function(){e+=t(this).outerHeight()}),o.settings.slideMargin>0&&(e+=o.settings.slideMargin*(o.settings.minSlides-1))):e=Math.max.apply(Math,s.map(function(){return t(this).outerHeight(!1)}).get()),e},p=function(){var t="100%";return o.settings.slideWidth>0&&(t="horizontal"==o.settings.mode?o.settings.maxSlides*o.settings.slideWidth+(o.settings.maxSlides-1)*o.settings.slideMargin:o.settings.slideWidth),t},u=function(){var t=o.settings.slideWidth,e=o.viewport.width();return 0==o.settings.slideWidth||o.settings.slideWidth>e&&!o.carousel||"vertical"==o.settings.mode?t=e:o.settings.maxSlides>1&&"horizontal"==o.settings.mode&&(e>o.maxThreshold||e<o.minThreshold&&(t=(e-o.settings.slideMargin*(o.settings.minSlides-1))/o.settings.minSlides)),t},f=function(){var t=1;if("horizontal"==o.settings.mode&&o.settings.slideWidth>0)if(o.viewport.width()<o.minThreshold)t=o.settings.minSlides;else if(o.viewport.width()>o.maxThreshold)t=o.settings.maxSlides;else{var e=o.children.first().width();t=Math.floor(o.viewport.width()/e)}else"vertical"==o.settings.mode&&(t=o.settings.minSlides);return t},x=function(){var t=0;if(o.settings.moveSlides>0)if(o.settings.infiniteLoop)t=o.children.length/m();else for(var e=0,i=0;e<o.children.length;)++t,e=i+f(),i+=o.settings.moveSlides<=f()?o.settings.moveSlides:f();else t=Math.ceil(o.children.length/f());return t},m=function(){return o.settings.moveSlides>0&&o.settings.moveSlides<=f()?o.settings.moveSlides:f()},S=function(){if(o.children.length>o.settings.maxSlides&&o.active.last&&!o.settings.infiniteLoop){if("horizontal"==o.settings.mode){var t=o.children.last(),e=t.position();b(-(e.left-(o.viewport.width()-t.width())),"reset",0)}else if("vertical"==o.settings.mode){var i=o.children.length-o.settings.minSlides,e=o.children.eq(i).position();b(-e.top,"reset",0)}}else{var e=o.children.eq(o.active.index*m()).position();o.active.index==x()-1&&(o.active.last=!0),void 0!=e&&("horizontal"==o.settings.mode?b(-e.left,"reset",0):"vertical"==o.settings.mode&&b(-e.top,"reset",0))}},b=function(t,e,i,s){if(o.usingCSS){var n="vertical"==o.settings.mode?"translate3d(0, "+t+"px, 0)":"translate3d("+t+"px, 0, 0)";r.css("-"+o.cssPrefix+"-transition-duration",i/1e3+"s"),"slide"==e?(r.css(o.animProp,n),r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),D()})):"reset"==e?r.css(o.animProp,n):"ticker"==e&&(r.css("-"+o.cssPrefix+"-transition-timing-function","linear"),r.css(o.animProp,n),r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),b(s.resetValue,"reset",0),N()}))}else{var a={};a[o.animProp]=t,"slide"==e?r.animate(a,i,o.settings.easing,function(){D()}):"reset"==e?r.css(o.animProp,t):"ticker"==e&&r.animate(a,speed,"linear",function(){b(s.resetValue,"reset",0),N()})}},w=function(){for(var e="",i=x(),s=0;i>s;s++){var n="";o.settings.buildPager&&t.isFunction(o.settings.buildPager)?(n=o.settings.buildPager(s),o.pagerEl.addClass("bx-custom-pager")):(n=s+1,o.pagerEl.addClass("bx-default-pager")),e+='<div class="bx-pager-item"><a href="" data-slide-index="'+s+'" class="bx-pager-link">'+n+"</a></div>"}o.pagerEl.html(e)},T=function(){o.settings.pagerCustom?o.pagerEl=t(o.settings.pagerCustom):(o.pagerEl=t('<div class="bx-pager" />'),o.settings.pagerSelector?t(o.settings.pagerSelector).html(o.pagerEl):o.controls.el.addClass("bx-has-pager").append(o.pagerEl),w()),o.pagerEl.on("click","a",I)},C=function(){o.controls.next=t('<a class="bx-next" href="">'+o.settings.nextText+"</a>"),o.controls.prev=t('<a class="bx-prev" href="">'+o.settings.prevText+"</a>"),o.controls.next.bind("click",y),o.controls.prev.bind("click",z),o.settings.nextSelector&&t(o.settings.nextSelector).append(o.controls.next),o.settings.prevSelector&&t(o.settings.prevSelector).append(o.controls.prev),o.settings.nextSelector||o.settings.prevSelector||(o.controls.directionEl=t('<div class="bx-controls-direction" />'),o.controls.directionEl.append(o.controls.prev).append(o.controls.next),o.controls.el.addClass("bx-has-controls-direction").append(o.controls.directionEl))},E=function(){o.controls.start=t('<div class="bx-controls-auto-item"><a class="bx-start" href="">'+o.settings.startText+"</a></div>"),o.controls.stop=t('<div class="bx-controls-auto-item"><a class="bx-stop" href="">'+o.settings.stopText+"</a></div>"),o.controls.autoEl=t('<div class="bx-controls-auto" />'),o.controls.autoEl.on("click",".bx-start",k),o.controls.autoEl.on("click",".bx-stop",M),o.settings.autoControlsCombine?o.controls.autoEl.append(o.controls.start):o.controls.autoEl.append(o.controls.start).append(o.controls.stop),o.settings.autoControlsSelector?t(o.settings.autoControlsSelector).html(o.controls.autoEl):o.controls.el.addClass("bx-has-controls-auto").append(o.controls.autoEl),A(o.settings.autoStart?"stop":"start")},P=function(){o.children.each(function(){var e=t(this).find("img:first").attr("title");void 0!=e&&(""+e).length&&t(this).append('<div class="bx-caption"><span>'+e+"</span></div>")})},y=function(t){o.settings.auto&&r.stopAuto(),r.goToNextSlide(),t.preventDefault()},z=function(t){o.settings.auto&&r.stopAuto(),r.goToPrevSlide(),t.preventDefault()},k=function(t){r.startAuto(),t.preventDefault()},M=function(t){r.stopAuto(),t.preventDefault()},I=function(e){o.settings.auto&&r.stopAuto();var i=t(e.currentTarget),s=parseInt(i.attr("data-slide-index"));s!=o.active.index&&r.goToSlide(s),e.preventDefault()},q=function(e){var i=o.children.length;return"short"==o.settings.pagerType?(o.settings.maxSlides>1&&(i=Math.ceil(o.children.length/o.settings.maxSlides)),o.pagerEl.html(e+1+o.settings.pagerShortSeparator+i),void 0):(o.pagerEl.find("a").removeClass("active"),o.pagerEl.each(function(i,s){t(s).find("a").eq(e).addClass("active")}),void 0)},D=function(){if(o.settings.infiniteLoop){var t="";0==o.active.index?t=o.children.eq(0).position():o.active.index==x()-1&&o.carousel?t=o.children.eq((x()-1)*m()).position():o.active.index==o.children.length-1&&(t=o.children.eq(o.children.length-1).position()),t&&("horizontal"==o.settings.mode?b(-t.left,"reset",0):"vertical"==o.settings.mode&&b(-t.top,"reset",0))}o.working=!1,o.settings.onSlideAfter(o.children.eq(o.active.index),o.oldIndex,o.active.index)},A=function(t){o.settings.autoControlsCombine?o.controls.autoEl.html(o.controls[t]):(o.controls.autoEl.find("a").removeClass("active"),o.controls.autoEl.find("a:not(.bx-"+t+")").addClass("active"))},W=function(){1==x()?(o.controls.prev.addClass("disabled"),o.controls.next.addClass("disabled")):!o.settings.infiniteLoop&&o.settings.hideControlOnEnd&&(0==o.active.index?(o.controls.prev.addClass("disabled"),o.controls.next.removeClass("disabled")):o.active.index==x()-1?(o.controls.next.addClass("disabled"),o.controls.prev.removeClass("disabled")):(o.controls.prev.removeClass("disabled"),o.controls.next.removeClass("disabled")))},H=function(){o.settings.autoDelay>0?setTimeout(r.startAuto,o.settings.autoDelay):r.startAuto(),o.settings.autoHover&&r.hover(function(){o.interval&&(r.stopAuto(!0),o.autoPaused=!0)},function(){o.autoPaused&&(r.startAuto(!0),o.autoPaused=null)})},L=function(){var e=0;if("next"==o.settings.autoDirection)r.append(o.children.clone().addClass("bx-clone"));else{r.prepend(o.children.clone().addClass("bx-clone"));var i=o.children.first().position();e="horizontal"==o.settings.mode?-i.left:-i.top}b(e,"reset",0),o.settings.pager=!1,o.settings.controls=!1,o.settings.autoControls=!1,o.settings.tickerHover&&!o.usingCSS&&o.viewport.hover(function(){r.stop()},function(){var e=0;o.children.each(function(){e+="horizontal"==o.settings.mode?t(this).outerWidth(!0):t(this).outerHeight(!0)});var i=o.settings.speed/e,s="horizontal"==o.settings.mode?"left":"top",n=i*(e-Math.abs(parseInt(r.css(s))));N(n)}),N()},N=function(t){speed=t?t:o.settings.speed;var e={left:0,top:0},i={left:0,top:0};"next"==o.settings.autoDirection?e=r.find(".bx-clone").first().position():i=o.children.first().position();var s="horizontal"==o.settings.mode?-e.left:-e.top,n="horizontal"==o.settings.mode?-i.left:-i.top,a={resetValue:n};b(s,"ticker",speed,a)},O=function(){o.touch={start:{x:0,y:0},end:{x:0,y:0}},o.viewport.bind("touchstart",X)},X=function(t){if(o.working)t.preventDefault();else{o.touch.originalPos=r.position();var e=t.originalEvent;o.touch.start.x=e.changedTouches[0].pageX,o.touch.start.y=e.changedTouches[0].pageY,o.viewport.bind("touchmove",Y),o.viewport.bind("touchend",V)}},Y=function(t){var e=t.originalEvent,i=Math.abs(e.changedTouches[0].pageX-o.touch.start.x),s=Math.abs(e.changedTouches[0].pageY-o.touch.start.y);if(3*i>s&&o.settings.preventDefaultSwipeX?t.preventDefault():3*s>i&&o.settings.preventDefaultSwipeY&&t.preventDefault(),"fade"!=o.settings.mode&&o.settings.oneToOneTouch){var n=0;if("horizontal"==o.settings.mode){var r=e.changedTouches[0].pageX-o.touch.start.x;n=o.touch.originalPos.left+r}else{var r=e.changedTouches[0].pageY-o.touch.start.y;n=o.touch.originalPos.top+r}b(n,"reset",0)}},V=function(t){o.viewport.unbind("touchmove",Y);var e=t.originalEvent,i=0;if(o.touch.end.x=e.changedTouches[0].pageX,o.touch.end.y=e.changedTouches[0].pageY,"fade"==o.settings.mode){var s=Math.abs(o.touch.start.x-o.touch.end.x);s>=o.settings.swipeThreshold&&(o.touch.start.x>o.touch.end.x?r.goToNextSlide():r.goToPrevSlide(),r.stopAuto())}else{var s=0;"horizontal"==o.settings.mode?(s=o.touch.end.x-o.touch.start.x,i=o.touch.originalPos.left):(s=o.touch.end.y-o.touch.start.y,i=o.touch.originalPos.top),!o.settings.infiniteLoop&&(0==o.active.index&&s>0||o.active.last&&0>s)?b(i,"reset",200):Math.abs(s)>=o.settings.swipeThreshold?(0>s?r.goToNextSlide():r.goToPrevSlide(),r.stopAuto()):b(i,"reset",200)}o.viewport.unbind("touchend",V)},Z=function(){var e=t(window).width(),i=t(window).height();(a!=e||l!=i)&&(a=e,l=i,r.redrawSlider(),o.settings.onSliderResize.call(r,o.active.index))};return r.goToSlide=function(e,i){if(!o.working&&o.active.index!=e)if(o.working=!0,o.oldIndex=o.active.index,o.active.index=0>e?x()-1:e>=x()?0:e,o.settings.onSlideBefore(o.children.eq(o.active.index),o.oldIndex,o.active.index),"next"==i?o.settings.onSlideNext(o.children.eq(o.active.index),o.oldIndex,o.active.index):"prev"==i&&o.settings.onSlidePrev(o.children.eq(o.active.index),o.oldIndex,o.active.index),o.active.last=o.active.index>=x()-1,o.settings.pager&&q(o.active.index),o.settings.controls&&W(),"fade"==o.settings.mode)o.settings.adaptiveHeight&&o.viewport.height()!=v()&&o.viewport.animate({height:v()},o.settings.adaptiveHeightSpeed),o.children.filter(":visible").fadeOut(o.settings.speed).css({zIndex:0}),o.children.eq(o.active.index).css("zIndex",o.settings.slideZIndex+1).fadeIn(o.settings.speed,function(){t(this).css("zIndex",o.settings.slideZIndex),D()});else{o.settings.adaptiveHeight&&o.viewport.height()!=v()&&o.viewport.animate({height:v()},o.settings.adaptiveHeightSpeed);var s=0,n={left:0,top:0};if(!o.settings.infiniteLoop&&o.carousel&&o.active.last)if("horizontal"==o.settings.mode){var a=o.children.eq(o.children.length-1);n=a.position(),s=o.viewport.width()-a.outerWidth()}else{var l=o.children.length-o.settings.minSlides;n=o.children.eq(l).position()}else if(o.carousel&&o.active.last&&"prev"==i){var d=1==o.settings.moveSlides?o.settings.maxSlides-m():(x()-1)*m()-(o.children.length-o.settings.maxSlides),a=r.children(".bx-clone").eq(d);n=a.position()}else if("next"==i&&0==o.active.index)n=r.find("> .bx-clone").eq(o.settings.maxSlides).position(),o.active.last=!1;else if(e>=0){var c=e*m();n=o.children.eq(c).position()}if("undefined"!=typeof n){var g="horizontal"==o.settings.mode?-(n.left-s):-n.top;b(g,"slide",o.settings.speed)}}},r.goToNextSlide=function(){if(o.settings.infiniteLoop||!o.active.last){var t=parseInt(o.active.index)+1;r.goToSlide(t,"next")}},r.goToPrevSlide=function(){if(o.settings.infiniteLoop||0!=o.active.index){var t=parseInt(o.active.index)-1;r.goToSlide(t,"prev")}},r.startAuto=function(t){o.interval||(o.interval=setInterval(function(){"next"==o.settings.autoDirection?r.goToNextSlide():r.goToPrevSlide()},o.settings.pause),o.settings.autoControls&&1!=t&&A("stop"))},r.stopAuto=function(t){o.interval&&(clearInterval(o.interval),o.interval=null,o.settings.autoControls&&1!=t&&A("start"))},r.getCurrentSlide=function(){return o.active.index},r.getCurrentSlideElement=function(){return o.children.eq(o.active.index)},r.getSlideCount=function(){return o.children.length},r.redrawSlider=function(){o.children.add(r.find(".bx-clone")).outerWidth(u()),o.viewport.css("height",v()),o.settings.ticker||S(),o.active.last&&(o.active.index=x()-1),o.active.index>=x()&&(o.active.last=!0),o.settings.pager&&!o.settings.pagerCustom&&(w(),q(o.active.index))},r.destroySlider=function(){o.initialized&&(o.initialized=!1,t(".bx-clone",this).remove(),o.children.each(function(){void 0!=t(this).data("origStyle")?t(this).attr("style",t(this).data("origStyle")):t(this).removeAttr("style")}),void 0!=t(this).data("origStyle")?this.attr("style",t(this).data("origStyle")):t(this).removeAttr("style"),t(this).unwrap().unwrap(),o.controls.el&&o.controls.el.remove(),o.controls.next&&o.controls.next.remove(),o.controls.prev&&o.controls.prev.remove(),o.pagerEl&&o.settings.controls&&o.pagerEl.remove(),t(".bx-caption",this).remove(),o.controls.autoEl&&o.controls.autoEl.remove(),clearInterval(o.interval),o.settings.responsive&&t(window).unbind("resize",Z))},r.reloadSlider=function(t){void 0!=t&&(n=t),r.destroySlider(),d()},d(),this}}(jQuery);
/**
 * GMaps v0.4.16
 * https://github.com/hpneo/gmaps
 */
(function(e,t){if(typeof exports==="object"){module.exports=t()}else if(typeof define==="function"&&define.amd){define("GMaps",[],t)}e.GMaps=t()})(this,function(){if(!(typeof window.google==="object"&&window.google.maps)){throw"Google Maps API is required. Please register the following JavaScript library http://maps.google.com/maps/api/js?sensor=true."}var t=function(e,t){var n;if(e===t){return e}for(n in t){e[n]=t[n]}return e};var n=function(e,t){var n;if(e===t){return e}for(n in t){if(e[n]!=undefined){e[n]=t[n]}}return e};var r=function(e,t){var n=Array.prototype.slice.call(arguments,2),r=[],i=e.length,s;if(Array.prototype.map&&e.map===Array.prototype.map){r=Array.prototype.map.call(e,function(e){callback_params=n;callback_params.splice(0,0,e);return t.apply(this,callback_params)})}else{for(s=0;s<i;s++){callback_params=n;callback_params.splice(0,0,e[s]);r.push(t.apply(this,callback_params))}}return r};var i=function(e){var t=[],n;for(n=0;n<e.length;n++){t=t.concat(e[n])}return t};var s=function(e,t){var n=e[0],r=e[1];if(t){n=e[1];r=e[0]}return new google.maps.LatLng(n,r)};var o=function(e,t){var n;for(n=0;n<e.length;n++){if(!(e[n]instanceof google.maps.LatLng)){if(e[n].length>0&&typeof e[n][0]=="object"){e[n]=o(e[n],t)}else{e[n]=s(e[n],t)}}}return e};var u=function(e,t){var n,e=e.replace("#","");if("jQuery"in this&&t){n=$("#"+e,t)[0]}else{n=document.getElementById(e)}return n};var a=function(e){var t=0,n=0;if(e.offsetParent){do{t+=e.offsetLeft;n+=e.offsetTop}while(e=e.offsetParent)}return[t,n]};var f=function(e){"use strict";var n=document;var r=function(e){if(!this)return new r(e);e.zoom=e.zoom||15;e.mapType=e.mapType||"roadmap";var i=this,s,o=["bounds_changed","center_changed","click","dblclick","drag","dragend","dragstart","idle","maptypeid_changed","projection_changed","resize","tilesloaded","zoom_changed"],f=["mousemove","mouseout","mouseover"],l=["el","lat","lng","mapType","width","height","markerClusterer","enableNewStyle"],c=e.el||e.div,h=e.markerClusterer,p=google.maps.MapTypeId[e.mapType.toUpperCase()],d=new google.maps.LatLng(e.lat,e.lng),v=e.zoomControl||true,m=e.zoomControlOpt||{style:"DEFAULT",position:"TOP_LEFT"},g=m.style||"DEFAULT",y=m.position||"TOP_LEFT",b=e.panControl||true,w=e.mapTypeControl||true,E=e.scaleControl||true,S=e.streetViewControl||true,x=x||true,T={},N={zoom:this.zoom,center:d,mapTypeId:p},C={panControl:b,zoomControl:v,zoomControlOptions:{style:google.maps.ZoomControlStyle[g],position:google.maps.ControlPosition[y]},mapTypeControl:w,scaleControl:E,streetViewControl:S,overviewMapControl:x};if(typeof e.el==="string"||typeof e.div==="string"){this.el=u(c,e.context)}else{this.el=c}if(typeof this.el==="undefined"||this.el===null){throw"No element defined."}window.context_menu=window.context_menu||{};window.context_menu[i.el.id]={};this.controls=[];this.overlays=[];this.layers=[];this.singleLayers={};this.markers=[];this.polylines=[];this.routes=[];this.polygons=[];this.infoWindow=null;this.overlay_el=null;this.zoom=e.zoom;this.registered_events={};this.el.style.width=e.width||this.el.scrollWidth||this.el.offsetWidth;this.el.style.height=e.height||this.el.scrollHeight||this.el.offsetHeight;google.maps.visualRefresh=e.enableNewStyle;for(s=0;s<l.length;s++){delete e[l[s]]}if(e.disableDefaultUI!=true){N=t(N,C)}T=t(N,e);for(s=0;s<o.length;s++){delete T[o[s]]}for(s=0;s<f.length;s++){delete T[f[s]]}this.map=new google.maps.Map(this.el,T);if(h){this.markerClusterer=h.apply(this,[this.map])}var k=function(e,t){var n="",r=window.context_menu[i.el.id][e];for(var s in r){if(r.hasOwnProperty(s)){var o=r[s];n+='<li><a id="'+e+"_"+s+'" href="#">'+o.title+"</a></li>"}}if(!u("gmaps_context_menu"))return;var f=u("gmaps_context_menu");f.innerHTML=n;var l=f.getElementsByTagName("a"),c=l.length,s;for(s=0;s<c;s++){var h=l[s];var p=function(n){n.preventDefault();r[this.id.replace(e+"_","")].action.apply(i,[t]);i.hideContextMenu()};google.maps.event.clearListeners(h,"click");google.maps.event.addDomListenerOnce(h,"click",p,false)}var d=a.apply(this,[i.el]),v=d[0]+t.pixel.x-15,m=d[1]+t.pixel.y-15;f.style.left=v+"px";f.style.top=m+"px";f.style.display="block"};this.buildContextMenu=function(e,t){if(e==="marker"){t.pixel={};var n=new google.maps.OverlayView;n.setMap(i.map);n.draw=function(){var r=n.getProjection(),i=t.marker.getPosition();t.pixel=r.fromLatLngToContainerPixel(i);k(e,t)}}else{k(e,t)}};this.setContextMenu=function(e){window.context_menu[i.el.id][e.control]={};var t,r=n.createElement("ul");for(t in e.options){if(e.options.hasOwnProperty(t)){var s=e.options[t];window.context_menu[i.el.id][e.control][s.name]={title:s.title,action:s.action}}}r.id="gmaps_context_menu";r.style.display="none";r.style.position="absolute";r.style.minWidth="100px";r.style.background="white";r.style.listStyle="none";r.style.padding="8px";r.style.boxShadow="2px 2px 6px #ccc";n.body.appendChild(r);var o=u("gmaps_context_menu");google.maps.event.addDomListener(o,"mouseout",function(e){if(!e.relatedTarget||!this.contains(e.relatedTarget)){window.setTimeout(function(){o.style.display="none"},400)}},false)};this.hideContextMenu=function(){var e=u("gmaps_context_menu");if(e){e.style.display="none"}};var L=function(t,n){google.maps.event.addListener(t,n,function(t){if(t==undefined){t=this}e[n].apply(this,[t]);i.hideContextMenu()})};google.maps.event.addListener(this.map,"zoom_changed",this.hideContextMenu);for(var A=0;A<o.length;A++){var O=o[A];if(O in e){L(this.map,O)}}for(var A=0;A<f.length;A++){var O=f[A];if(O in e){L(this.map,O)}}google.maps.event.addListener(this.map,"rightclick",function(t){if(e.rightclick){e.rightclick.apply(this,[t])}if(window.context_menu[i.el.id]["map"]!=undefined){i.buildContextMenu("map",t)}});this.refresh=function(){google.maps.event.trigger(this.map,"resize")};this.fitZoom=function(){var e=[],t=this.markers.length,n;for(n=0;n<t;n++){if(typeof this.markers[n].visible==="boolean"&&this.markers[n].visible){e.push(this.markers[n].getPosition())}}this.fitLatLngBounds(e)};this.fitLatLngBounds=function(e){var t=e.length;var n=new google.maps.LatLngBounds;for(var r=0;r<t;r++){n.extend(e[r])}this.map.fitBounds(n)};this.setCenter=function(e,t,n){this.map.panTo(new google.maps.LatLng(e,t));if(n){n()}};this.getElement=function(){return this.el};this.zoomIn=function(e){e=e||1;this.zoom=this.map.getZoom()+e;this.map.setZoom(this.zoom)};this.zoomOut=function(e){e=e||1;this.zoom=this.map.getZoom()-e;this.map.setZoom(this.zoom)};var M=[],_;for(_ in this.map){if(typeof this.map[_]=="function"&&!this[_]){M.push(_)}}for(s=0;s<M.length;s++){(function(e,t,n){e[n]=function(){return t[n].apply(t,arguments)}})(this,this.map,M[s])}};return r}(this);f.prototype.createControl=function(e){var t=document.createElement("div");t.style.cursor="pointer";if(e.disableDefaultStyles!==true){t.style.fontFamily="Roboto, Arial, sans-serif";t.style.fontSize="11px";t.style.boxShadow="rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px"}for(var n in e.style){t.style[n]=e.style[n]}if(e.id){t.id=e.id}if(e.classes){t.className=e.classes}if(e.content){if(typeof e.content==="string"){t.innerHTML=e.content}else if(e.content instanceof HTMLElement){t.appendChild(e.content)}}if(e.position){t.position=google.maps.ControlPosition[e.position.toUpperCase()]}for(var r in e.events){(function(t,n){google.maps.event.addDomListener(t,n,function(){e.events[n].apply(this,[this])})})(t,r)}t.index=1;return t};f.prototype.addControl=function(e){var t=this.createControl(e);this.controls.push(t);this.map.controls[t.position].push(t);return t};f.prototype.removeControl=function(e){var t=null;for(var n=0;n<this.controls.length;n++){if(this.controls[n]==e){t=this.controls[n].position;this.controls.splice(n,1)}}if(t){for(n=0;n<this.map.controls.length;n++){var r=this.map.controls[e.position];if(r.getAt(n)==e){r.removeAt(n);break}}}return e};f.prototype.createMarker=function(e){if(e.lat==undefined&&e.lng==undefined&&e.position==undefined){throw"No latitude or longitude defined."}var n=this,r=e.details,i=e.fences,s=e.outside,o={position:new google.maps.LatLng(e.lat,e.lng),map:null},u=t(o,e);delete u.lat;delete u.lng;delete u.fences;delete u.outside;var a=new google.maps.Marker(u);a.fences=i;if(e.infoWindow){a.infoWindow=new google.maps.InfoWindow(e.infoWindow);var f=["closeclick","content_changed","domready","position_changed","zindex_changed"];for(var l=0;l<f.length;l++){(function(t,n){if(e.infoWindow[n]){google.maps.event.addListener(t,n,function(t){e.infoWindow[n].apply(this,[t])})}})(a.infoWindow,f[l])}}var c=["animation_changed","clickable_changed","cursor_changed","draggable_changed","flat_changed","icon_changed","position_changed","shadow_changed","shape_changed","title_changed","visible_changed","zindex_changed"];var h=["dblclick","drag","dragend","dragstart","mousedown","mouseout","mouseover","mouseup"];for(var l=0;l<c.length;l++){(function(t,n){if(e[n]){google.maps.event.addListener(t,n,function(){e[n].apply(this,[this])})}})(a,c[l])}for(var l=0;l<h.length;l++){(function(t,n,r){if(e[r]){google.maps.event.addListener(n,r,function(n){if(!n.pixel){n.pixel=t.getProjection().fromLatLngToPoint(n.latLng)}e[r].apply(this,[n])})}})(this.map,a,h[l])}google.maps.event.addListener(a,"click",function(){this.details=r;if(e.click){e.click.apply(this,[this])}if(a.infoWindow){n.hideInfoWindows();a.infoWindow.open(n.map,a)}});google.maps.event.addListener(a,"rightclick",function(t){t.marker=this;if(e.rightclick){e.rightclick.apply(this,[t])}if(window.context_menu[n.el.id]["marker"]!=undefined){n.buildContextMenu("marker",t)}});if(a.fences){google.maps.event.addListener(a,"dragend",function(){n.checkMarkerGeofence(a,function(e,t){s(e,t)})})}return a};f.prototype.addMarker=function(e){var t;if(e.hasOwnProperty("gm_accessors_")){t=e}else{if(e.hasOwnProperty("lat")&&e.hasOwnProperty("lng")||e.position){t=this.createMarker(e)}else{throw"No latitude or longitude defined."}}t.setMap(this.map);if(this.markerClusterer){this.markerClusterer.addMarker(t)}this.markers.push(t);f.fire("marker_added",t,this);return t};f.prototype.addMarkers=function(e){for(var t=0,n;n=e[t];t++){this.addMarker(n)}return this.markers};f.prototype.hideInfoWindows=function(){for(var e=0,t;t=this.markers[e];e++){if(t.infoWindow){t.infoWindow.close()}}};f.prototype.removeMarker=function(e){for(var t=0;t<this.markers.length;t++){if(this.markers[t]===e){this.markers[t].setMap(null);this.markers.splice(t,1);if(this.markerClusterer){this.markerClusterer.removeMarker(e)}f.fire("marker_removed",e,this);break}}return e};f.prototype.removeMarkers=function(e){var t=[];if(typeof e=="undefined"){for(var n=0;n<this.markers.length;n++){var r=this.markers[n];r.setMap(null);if(this.markerClusterer){this.markerClusterer.removeMarker(r)}f.fire("marker_removed",r,this)}this.markers=t}else{for(var n=0;n<e.length;n++){var i=this.markers.indexOf(e[n]);if(i>-1){var r=this.markers[i];r.setMap(null);if(this.markerClusterer){this.markerClusterer.removeMarker(r)}f.fire("marker_removed",r,this)}}for(var n=0;n<this.markers.length;n++){var r=this.markers[n];if(r.getMap()!=null){t.push(r)}}this.markers=t}};f.prototype.drawOverlay=function(e){var t=new google.maps.OverlayView,n=true;t.setMap(this.map);if(e.auto_show!=null){n=e.auto_show}t.onAdd=function(){var n=document.createElement("div");n.style.borderStyle="none";n.style.borderWidth="0px";n.style.position="absolute";n.style.zIndex=100;n.innerHTML=e.content;t.el=n;if(!e.layer){e.layer="overlayLayer"}var r=this.getPanes(),i=r[e.layer],s=["contextmenu","DOMMouseScroll","dblclick","mousedown"];i.appendChild(n);for(var o=0;o<s.length;o++){(function(e,t){google.maps.event.addDomListener(e,t,function(e){if(navigator.userAgent.toLowerCase().indexOf("msie")!=-1&&document.all){e.cancelBubble=true;e.returnValue=false}else{e.stopPropagation()}})})(n,s[o])}if(e.click){r.overlayMouseTarget.appendChild(t.el);google.maps.event.addDomListener(t.el,"click",function(){e.click.apply(t,[t])})}google.maps.event.trigger(this,"ready")};t.draw=function(){var r=this.getProjection(),i=r.fromLatLngToDivPixel(new google.maps.LatLng(e.lat,e.lng));e.horizontalOffset=e.horizontalOffset||0;e.verticalOffset=e.verticalOffset||0;var s=t.el,o=s.children[0],u=o.clientHeight,a=o.clientWidth;switch(e.verticalAlign){case"top":s.style.top=i.y-u+e.verticalOffset+"px";break;default:case"middle":s.style.top=i.y-u/2+e.verticalOffset+"px";break;case"bottom":s.style.top=i.y+e.verticalOffset+"px";break}switch(e.horizontalAlign){case"left":s.style.left=i.x-a+e.horizontalOffset+"px";break;default:case"center":s.style.left=i.x-a/2+e.horizontalOffset+"px";break;case"right":s.style.left=i.x+e.horizontalOffset+"px";break}s.style.display=n?"block":"none";if(!n){e.show.apply(this,[s])}};t.onRemove=function(){var n=t.el;if(e.remove){e.remove.apply(this,[n])}else{t.el.parentNode.removeChild(t.el);t.el=null}};this.overlays.push(t);return t};f.prototype.removeOverlay=function(e){for(var t=0;t<this.overlays.length;t++){if(this.overlays[t]===e){this.overlays[t].setMap(null);this.overlays.splice(t,1);break}}};f.prototype.removeOverlays=function(){for(var e=0,t;t=this.overlays[e];e++){t.setMap(null)}this.overlays=[]};f.prototype.drawPolyline=function(e){var t=[],n=e.path;if(n.length){if(n[0][0]===undefined){t=n}else{for(var r=0,i;i=n[r];r++){t.push(new google.maps.LatLng(i[0],i[1]))}}}var s={map:this.map,path:t,strokeColor:e.strokeColor,strokeOpacity:e.strokeOpacity,strokeWeight:e.strokeWeight,geodesic:e.geodesic,clickable:true,editable:false,visible:true};if(e.hasOwnProperty("clickable")){s.clickable=e.clickable}if(e.hasOwnProperty("editable")){s.editable=e.editable}if(e.hasOwnProperty("icons")){s.icons=e.icons}if(e.hasOwnProperty("zIndex")){s.zIndex=e.zIndex}var o=new google.maps.Polyline(s);var u=["click","dblclick","mousedown","mousemove","mouseout","mouseover","mouseup","rightclick"];for(var a=0;a<u.length;a++){(function(t,n){if(e[n]){google.maps.event.addListener(t,n,function(t){e[n].apply(this,[t])})}})(o,u[a])}this.polylines.push(o);f.fire("polyline_added",o,this);return o};f.prototype.removePolyline=function(e){for(var t=0;t<this.polylines.length;t++){if(this.polylines[t]===e){this.polylines[t].setMap(null);this.polylines.splice(t,1);f.fire("polyline_removed",e,this);break}}};f.prototype.removePolylines=function(){for(var e=0,t;t=this.polylines[e];e++){t.setMap(null)}this.polylines=[]};f.prototype.drawCircle=function(e){e=t({map:this.map,center:new google.maps.LatLng(e.lat,e.lng)},e);delete e.lat;delete e.lng;var n=new google.maps.Circle(e),r=["click","dblclick","mousedown","mousemove","mouseout","mouseover","mouseup","rightclick"];for(var i=0;i<r.length;i++){(function(t,n){if(e[n]){google.maps.event.addListener(t,n,function(t){e[n].apply(this,[t])})}})(n,r[i])}this.polygons.push(n);return n};f.prototype.drawRectangle=function(e){e=t({map:this.map},e);var n=new google.maps.LatLngBounds(new google.maps.LatLng(e.bounds[0][0],e.bounds[0][1]),new google.maps.LatLng(e.bounds[1][0],e.bounds[1][1]));e.bounds=n;var r=new google.maps.Rectangle(e),i=["click","dblclick","mousedown","mousemove","mouseout","mouseover","mouseup","rightclick"];for(var s=0;s<i.length;s++){(function(t,n){if(e[n]){google.maps.event.addListener(t,n,function(t){e[n].apply(this,[t])})}})(r,i[s])}this.polygons.push(r);return r};f.prototype.drawPolygon=function(e){var n=false;if(e.hasOwnProperty("useGeoJSON")){n=e.useGeoJSON}delete e.useGeoJSON;e=t({map:this.map},e);if(n==false){e.paths=[e.paths.slice(0)]}if(e.paths.length>0){if(e.paths[0].length>0){e.paths=i(r(e.paths,o,n))}}var s=new google.maps.Polygon(e),u=["click","dblclick","mousedown","mousemove","mouseout","mouseover","mouseup","rightclick"];for(var a=0;a<u.length;a++){(function(t,n){if(e[n]){google.maps.event.addListener(t,n,function(t){e[n].apply(this,[t])})}})(s,u[a])}this.polygons.push(s);f.fire("polygon_added",s,this);return s};f.prototype.removePolygon=function(e){for(var t=0;t<this.polygons.length;t++){if(this.polygons[t]===e){this.polygons[t].setMap(null);this.polygons.splice(t,1);f.fire("polygon_removed",e,this);break}}};f.prototype.removePolygons=function(){for(var e=0,t;t=this.polygons[e];e++){t.setMap(null)}this.polygons=[]};f.prototype.getFromFusionTables=function(e){var t=e.events;delete e.events;var n=e,r=new google.maps.FusionTablesLayer(n);for(var i in t){(function(e,n){google.maps.event.addListener(e,n,function(e){t[n].apply(this,[e])})})(r,i)}this.layers.push(r);return r};f.prototype.loadFromFusionTables=function(e){var t=this.getFromFusionTables(e);t.setMap(this.map);return t};f.prototype.getFromKML=function(e){var t=e.url,n=e.events;delete e.url;delete e.events;var r=e,i=new google.maps.KmlLayer(t,r);for(var s in n){(function(e,t){google.maps.event.addListener(e,t,function(e){n[t].apply(this,[e])})})(i,s)}this.layers.push(i);return i};f.prototype.loadFromKML=function(e){var t=this.getFromKML(e);t.setMap(this.map);return t};f.prototype.addLayer=function(e,t){t=t||{};var n;switch(e){case"weather":this.singleLayers.weather=n=new google.maps.weather.WeatherLayer;break;case"clouds":this.singleLayers.clouds=n=new google.maps.weather.CloudLayer;break;case"traffic":this.singleLayers.traffic=n=new google.maps.TrafficLayer;break;case"transit":this.singleLayers.transit=n=new google.maps.TransitLayer;break;case"bicycling":this.singleLayers.bicycling=n=new google.maps.BicyclingLayer;break;case"panoramio":this.singleLayers.panoramio=n=new google.maps.panoramio.PanoramioLayer;n.setTag(t.filter);delete t.filter;if(t.click){google.maps.event.addListener(n,"click",function(e){t.click(e);delete t.click})}break;case"places":this.singleLayers.places=n=new google.maps.places.PlacesService(this.map);if(t.search||t.nearbySearch||t.radarSearch){var r={bounds:t.bounds||null,keyword:t.keyword||null,location:t.location||null,name:t.name||null,radius:t.radius||null,rankBy:t.rankBy||null,types:t.types||null};if(t.radarSearch){n.radarSearch(r,t.radarSearch)}if(t.search){n.search(r,t.search)}if(t.nearbySearch){n.nearbySearch(r,t.nearbySearch)}}if(t.textSearch){var i={bounds:t.bounds||null,location:t.location||null,query:t.query||null,radius:t.radius||null};n.textSearch(i,t.textSearch)}break}if(n!==undefined){if(typeof n.setOptions=="function"){n.setOptions(t)}if(typeof n.setMap=="function"){n.setMap(this.map)}return n}};f.prototype.removeLayer=function(e){if(typeof e=="string"&&this.singleLayers[e]!==undefined){this.singleLayers[e].setMap(null);delete this.singleLayers[e]}else{for(var t=0;t<this.layers.length;t++){if(this.layers[t]===e){this.layers[t].setMap(null);this.layers.splice(t,1);break}}}};var l,c;f.prototype.getRoutes=function(e){switch(e.travelMode){case"bicycling":l=google.maps.TravelMode.BICYCLING;break;case"transit":l=google.maps.TravelMode.TRANSIT;break;case"driving":l=google.maps.TravelMode.DRIVING;break;default:l=google.maps.TravelMode.WALKING;break}if(e.unitSystem==="imperial"){c=google.maps.UnitSystem.IMPERIAL}else{c=google.maps.UnitSystem.METRIC}var n={avoidHighways:false,avoidTolls:false,optimizeWaypoints:false,waypoints:[]},r=t(n,e);r.origin=/string/.test(typeof e.origin)?e.origin:new google.maps.LatLng(e.origin[0],e.origin[1]);r.destination=/string/.test(typeof e.destination)?e.destination:new google.maps.LatLng(e.destination[0],e.destination[1]);r.travelMode=l;r.unitSystem=c;delete r.callback;delete r.error;var i=this,s=new google.maps.DirectionsService;s.route(r,function(t,n){if(n===google.maps.DirectionsStatus.OK){for(var r in t.routes){if(t.routes.hasOwnProperty(r)){i.routes.push(t.routes[r])}}if(e.callback){e.callback(i.routes)}}else{if(e.error){e.error(t,n)}}})};f.prototype.removeRoutes=function(){this.routes=[]};f.prototype.getElevations=function(e){e=t({locations:[],path:false,samples:256},e);if(e.locations.length>0){if(e.locations[0].length>0){e.locations=i(r([e.locations],o,false))}}var n=e.callback;delete e.callback;var s=new google.maps.ElevationService;if(!e.path){delete e.path;delete e.samples;s.getElevationForLocations(e,function(e,t){if(n&&typeof n==="function"){n(e,t)}})}else{var u={path:e.locations,samples:e.samples};s.getElevationAlongPath(u,function(e,t){if(n&&typeof n==="function"){n(e,t)}})}};f.prototype.cleanRoute=f.prototype.removePolylines;f.prototype.drawRoute=function(e){var t=this;this.getRoutes({origin:e.origin,destination:e.destination,travelMode:e.travelMode,waypoints:e.waypoints,unitSystem:e.unitSystem,error:e.error,callback:function(n){if(n.length>0){t.drawPolyline({path:n[n.length-1].overview_path,strokeColor:e.strokeColor,strokeOpacity:e.strokeOpacity,strokeWeight:e.strokeWeight});if(e.callback){e.callback(n[n.length-1])}}}})};f.prototype.travelRoute=function(e){if(e.origin&&e.destination){this.getRoutes({origin:e.origin,destination:e.destination,travelMode:e.travelMode,waypoints:e.waypoints,unitSystem:e.unitSystem,error:e.error,callback:function(t){if(t.length>0&&e.start){e.start(t[t.length-1])}if(t.length>0&&e.step){var n=t[t.length-1];if(n.legs.length>0){var r=n.legs[0].steps;for(var i=0,s;s=r[i];i++){s.step_number=i;e.step(s,n.legs[0].steps.length-1)}}}if(t.length>0&&e.end){e.end(t[t.length-1])}}})}else if(e.route){if(e.route.legs.length>0){var t=e.route.legs[0].steps;for(var n=0,r;r=t[n];n++){r.step_number=n;e.step(r)}}}};f.prototype.drawSteppedRoute=function(e){var t=this;if(e.origin&&e.destination){this.getRoutes({origin:e.origin,destination:e.destination,travelMode:e.travelMode,waypoints:e.waypoints,error:e.error,callback:function(n){if(n.length>0&&e.start){e.start(n[n.length-1])}if(n.length>0&&e.step){var r=n[n.length-1];if(r.legs.length>0){var i=r.legs[0].steps;for(var s=0,o;o=i[s];s++){o.step_number=s;t.drawPolyline({path:o.path,strokeColor:e.strokeColor,strokeOpacity:e.strokeOpacity,strokeWeight:e.strokeWeight});e.step(o,r.legs[0].steps.length-1)}}}if(n.length>0&&e.end){e.end(n[n.length-1])}}})}else if(e.route){if(e.route.legs.length>0){var n=e.route.legs[0].steps;for(var r=0,i;i=n[r];r++){i.step_number=r;t.drawPolyline({path:i.path,strokeColor:e.strokeColor,strokeOpacity:e.strokeOpacity,strokeWeight:e.strokeWeight});e.step(i)}}}};f.Route=function(e){this.origin=e.origin;this.destination=e.destination;this.waypoints=e.waypoints;this.map=e.map;this.route=e.route;this.step_count=0;this.steps=this.route.legs[0].steps;this.steps_length=this.steps.length;this.polyline=this.map.drawPolyline({path:new google.maps.MVCArray,strokeColor:e.strokeColor,strokeOpacity:e.strokeOpacity,strokeWeight:e.strokeWeight}).getPath()};f.Route.prototype.getRoute=function(t){var n=this;this.map.getRoutes({origin:this.origin,destination:this.destination,travelMode:t.travelMode,waypoints:this.waypoints||[],error:t.error,callback:function(){n.route=e[0];if(t.callback){t.callback.call(n)}}})};f.Route.prototype.back=function(){if(this.step_count>0){this.step_count--;var e=this.route.legs[0].steps[this.step_count].path;for(var t in e){if(e.hasOwnProperty(t)){this.polyline.pop()}}}};f.Route.prototype.forward=function(){if(this.step_count<this.steps_length){var e=this.route.legs[0].steps[this.step_count].path;for(var t in e){if(e.hasOwnProperty(t)){this.polyline.push(e[t])}}this.step_count++}};f.prototype.checkGeofence=function(e,t,n){return n.containsLatLng(new google.maps.LatLng(e,t))};f.prototype.checkMarkerGeofence=function(e,t){if(e.fences){for(var n=0,r;r=e.fences[n];n++){var i=e.getPosition();if(!this.checkGeofence(i.lat(),i.lng(),r)){t(e,r)}}}};f.prototype.toImage=function(e){var e=e||{},t={};t["size"]=e["size"]||[this.el.clientWidth,this.el.clientHeight];t["lat"]=this.getCenter().lat();t["lng"]=this.getCenter().lng();if(this.markers.length>0){t["markers"]=[];for(var n=0;n<this.markers.length;n++){t["markers"].push({lat:this.markers[n].getPosition().lat(),lng:this.markers[n].getPosition().lng()})}}if(this.polylines.length>0){var r=this.polylines[0];t["polyline"]={};t["polyline"]["path"]=google.maps.geometry.encoding.encodePath(r.getPath());t["polyline"]["strokeColor"]=r.strokeColor;t["polyline"]["strokeOpacity"]=r.strokeOpacity;t["polyline"]["strokeWeight"]=r.strokeWeight}return f.staticMapURL(t)};f.staticMapURL=function(e){function b(e,t){if(e[0]==="#"){e=e.replace("#","0x");if(t){t=parseFloat(t);t=Math.min(1,Math.max(t,0));if(t===0){return"0x00000000"}t=(t*255).toString(16);if(t.length===1){t+=t}e=e.slice(0,8)+t}}return e}var t=[],n,r="http://maps.googleapis.com/maps/api/staticmap";if(e.url){r=e.url;delete e.url}r+="?";var i=e.markers;delete e.markers;if(!i&&e.marker){i=[e.marker];delete e.marker}var s=e.styles;delete e.styles;var o=e.polyline;delete e.polyline;if(e.center){t.push("center="+e.center);delete e.center}else if(e.address){t.push("center="+e.address);delete e.address}else if(e.lat){t.push(["center=",e.lat,",",e.lng].join(""));delete e.lat;delete e.lng}else if(e.visible){var u=encodeURI(e.visible.join("|"));t.push("visible="+u)}var a=e.size;if(a){if(a.join){a=a.join("x")}delete e.size}else{a="630x300"}t.push("size="+a);if(!e.zoom&&e.zoom!==false){e.zoom=15}var f=e.hasOwnProperty("sensor")?!!e.sensor:true;delete e.sensor;t.push("sensor="+f);for(var l in e){if(e.hasOwnProperty(l)){t.push(l+"="+e[l])}}if(i){var c,h;for(var p=0;n=i[p];p++){c=[];if(n.size&&n.size!=="normal"){c.push("size:"+n.size);delete n.size}else if(n.icon){c.push("icon:"+encodeURI(n.icon));delete n.icon}if(n.color){c.push("color:"+n.color.replace("#","0x"));delete n.color}if(n.label){c.push("label:"+n.label[0].toUpperCase());delete n.label}h=n.address?n.address:n.lat+","+n.lng;delete n.address;delete n.lat;delete n.lng;for(var l in n){if(n.hasOwnProperty(l)){c.push(l+":"+n[l])}}if(c.length||p===0){c.push(h);c=c.join("|");t.push("markers="+encodeURI(c))}else{c=t.pop()+encodeURI("|"+h);t.push(c)}}}if(s){for(var p=0;p<s.length;p++){var d=[];if(s[p].featureType){d.push("feature:"+s[p].featureType.toLowerCase())}if(s[p].elementType){d.push("element:"+s[p].elementType.toLowerCase())}for(var v=0;v<s[p].stylers.length;v++){for(var m in s[p].stylers[v]){var g=s[p].stylers[v][m];if(m=="hue"||m=="color"){g="0x"+g.substring(1)}d.push(m+":"+g)}}var y=d.join("|");if(y!=""){t.push("style="+y)}}}if(o){n=o;o=[];if(n.strokeWeight){o.push("weight:"+parseInt(n.strokeWeight,10))}if(n.strokeColor){var w=b(n.strokeColor,n.strokeOpacity);o.push("color:"+w)}if(n.fillColor){var E=b(n.fillColor,n.fillOpacity);o.push("fillcolor:"+E)}var S=n.path;if(S.join){for(var v=0,x;x=S[v];v++){o.push(x.join(","))}}else{o.push("enc:"+S)}o=o.join("|");t.push("path="+encodeURI(o))}var T=window.devicePixelRatio||1;t.push("scale="+T);t=t.join("&");return r+t};f.prototype.addMapType=function(e,t){if(t.hasOwnProperty("getTileUrl")&&typeof t["getTileUrl"]=="function"){t.tileSize=t.tileSize||new google.maps.Size(256,256);var n=new google.maps.ImageMapType(t);this.map.mapTypes.set(e,n)}else{throw"'getTileUrl' function required."}};f.prototype.addOverlayMapType=function(e){if(e.hasOwnProperty("getTile")&&typeof e["getTile"]=="function"){var t=e.index;delete e.index;this.map.overlayMapTypes.insertAt(t,e)}else{throw"'getTile' function required."}};f.prototype.removeOverlayMapType=function(e){this.map.overlayMapTypes.removeAt(e)};f.prototype.addStyle=function(e){var t=new google.maps.StyledMapType(e.styles,{name:e.styledMapName});this.map.mapTypes.set(e.mapTypeId,t)};f.prototype.setStyle=function(e){this.map.setMapTypeId(e)};f.prototype.createPanorama=function(e){if(!e.hasOwnProperty("lat")||!e.hasOwnProperty("lng")){e.lat=this.getCenter().lat();e.lng=this.getCenter().lng()}this.panorama=f.createPanorama(e);this.map.setStreetView(this.panorama);return this.panorama};f.createPanorama=function(e){var n=u(e.el,e.context);e.position=new google.maps.LatLng(e.lat,e.lng);delete e.el;delete e.context;delete e.lat;delete e.lng;var r=["closeclick","links_changed","pano_changed","position_changed","pov_changed","resize","visible_changed"],i=t({visible:true},e);for(var s=0;s<r.length;s++){delete i[r[s]]}var o=new google.maps.StreetViewPanorama(n,i);for(var s=0;s<r.length;s++){(function(t,n){if(e[n]){google.maps.event.addListener(t,n,function(){e[n].apply(this)})}})(o,r[s])}return o};f.prototype.on=function(e,t){return f.on(e,this,t)};f.prototype.off=function(e){f.off(e,this)};f.custom_events=["marker_added","marker_removed","polyline_added","polyline_removed","polygon_added","polygon_removed","geolocated","geolocation_failed"];f.on=function(e,t,n){if(f.custom_events.indexOf(e)==-1){if(t instanceof f)t=t.map;return google.maps.event.addListener(t,e,n)}else{var r={handler:n,eventName:e};t.registered_events[e]=t.registered_events[e]||[];t.registered_events[e].push(r);return r}};f.off=function(e,t){if(f.custom_events.indexOf(e)==-1){if(t instanceof f)t=t.map;google.maps.event.clearListeners(t,e)}else{t.registered_events[e]=[]}};f.fire=function(e,t,n){if(f.custom_events.indexOf(e)==-1){google.maps.event.trigger(t,e,Array.prototype.slice.apply(arguments).slice(2))}else{if(e in n.registered_events){var r=n.registered_events[e];for(var i=0;i<r.length;i++){(function(e,t,n){e.apply(t,[n])})(r[i]["handler"],n,t)}}}};f.geolocate=function(e){var t=e.always||e.complete;if(navigator.geolocation){navigator.geolocation.getCurrentPosition(function(n){e.success(n);if(t){t()}},function(n){e.error(n);if(t){t()}},e.options)}else{e.not_supported();if(t){t()}}};f.geocode=function(e){this.geocoder=new google.maps.Geocoder;var t=e.callback;if(e.hasOwnProperty("lat")&&e.hasOwnProperty("lng")){e.latLng=new google.maps.LatLng(e.lat,e.lng)}delete e.lat;delete e.lng;delete e.callback;this.geocoder.geocode(e,function(e,n){t(e,n)})};if(!google.maps.Polygon.prototype.getBounds){google.maps.Polygon.prototype.getBounds=function(e){var t=new google.maps.LatLngBounds;var n=this.getPaths();var r;for(var i=0;i<n.getLength();i++){r=n.getAt(i);for(var s=0;s<r.getLength();s++){t.extend(r.getAt(s))}}return t}}if(!google.maps.Polygon.prototype.containsLatLng){google.maps.Polygon.prototype.containsLatLng=function(e){var t=this.getBounds();if(t!==null&&!t.contains(e)){return false}var n=false;var r=this.getPaths().getLength();for(var i=0;i<r;i++){var s=this.getPaths().getAt(i);var o=s.getLength();var u=o-1;for(var a=0;a<o;a++){var f=s.getAt(a);var l=s.getAt(u);if(f.lng()<e.lng()&&l.lng()>=e.lng()||l.lng()<e.lng()&&f.lng()>=e.lng()){if(f.lat()+(e.lng()-f.lng())/(l.lng()-f.lng())*(l.lat()-f.lat())<e.lat()){n=!n}}u=a}}return n}}if(!google.maps.Circle.prototype.containsLatLng){google.maps.Circle.prototype.containsLatLng=function(e){if(google.maps.geometry){return google.maps.geometry.spherical.computeDistanceBetween(this.getCenter(),e)<=this.getRadius()}else{return true}}}google.maps.LatLngBounds.prototype.containsLatLng=function(e){return this.contains(e)};google.maps.Marker.prototype.setFences=function(e){this.fences=e};google.maps.Marker.prototype.addFence=function(e){this.fences.push(e)};google.maps.Marker.prototype.getId=function(){return this["__gm_id"]};if(!Array.prototype.indexOf){Array.prototype.indexOf=function(e){"use strict";if(this==null){throw new TypeError}var t=Object(this);var n=t.length>>>0;if(n===0){return-1}var r=0;if(arguments.length>1){r=Number(arguments[1]);if(r!=r){r=0}else if(r!=0&&r!=Infinity&&r!=-Infinity){r=(r>0||-1)*Math.floor(Math.abs(r))}}if(r>=n){return-1}var i=r>=0?r:Math.max(n-Math.abs(r),0);for(;i<n;i++){if(i in t&&t[i]===e){return i}}return-1}}return f});
/*!
 * numeral.js
 * version : 1.5.3
 * author : Adam Draper
 * license : MIT
 * http://adamwdraper.github.com/Numeral-js/
 */
(function(){function a(a){this._value=a}function b(a,b,c,d){var e,f,g=Math.pow(10,b);return f=(c(a*g)/g).toFixed(b),d&&(e=new RegExp("0{1,"+d+"}$"),f=f.replace(e,"")),f}function c(a,b,c){var d;return d=b.indexOf("$")>-1?e(a,b,c):b.indexOf("%")>-1?f(a,b,c):b.indexOf(":")>-1?g(a,b):i(a._value,b,c)}function d(a,b){var c,d,e,f,g,i=b,j=["KB","MB","GB","TB","PB","EB","ZB","YB"],k=!1;if(b.indexOf(":")>-1)a._value=h(b);else if(b===q)a._value=0;else{for("."!==o[p].delimiters.decimal&&(b=b.replace(/\./g,"").replace(o[p].delimiters.decimal,".")),c=new RegExp("[^a-zA-Z]"+o[p].abbreviations.thousand+"(?:\\)|(\\"+o[p].currency.symbol+")?(?:\\))?)?$"),d=new RegExp("[^a-zA-Z]"+o[p].abbreviations.million+"(?:\\)|(\\"+o[p].currency.symbol+")?(?:\\))?)?$"),e=new RegExp("[^a-zA-Z]"+o[p].abbreviations.billion+"(?:\\)|(\\"+o[p].currency.symbol+")?(?:\\))?)?$"),f=new RegExp("[^a-zA-Z]"+o[p].abbreviations.trillion+"(?:\\)|(\\"+o[p].currency.symbol+")?(?:\\))?)?$"),g=0;g<=j.length&&!(k=b.indexOf(j[g])>-1?Math.pow(1024,g+1):!1);g++);a._value=(k?k:1)*(i.match(c)?Math.pow(10,3):1)*(i.match(d)?Math.pow(10,6):1)*(i.match(e)?Math.pow(10,9):1)*(i.match(f)?Math.pow(10,12):1)*(b.indexOf("%")>-1?.01:1)*((b.split("-").length+Math.min(b.split("(").length-1,b.split(")").length-1))%2?1:-1)*Number(b.replace(/[^0-9\.]+/g,"")),a._value=k?Math.ceil(a._value):a._value}return a._value}function e(a,b,c){var d,e,f=b.indexOf("$"),g=b.indexOf("("),h=b.indexOf("-"),j="";return b.indexOf(" $")>-1?(j=" ",b=b.replace(" $","")):b.indexOf("$ ")>-1?(j=" ",b=b.replace("$ ","")):b=b.replace("$",""),e=i(a._value,b,c),1>=f?e.indexOf("(")>-1||e.indexOf("-")>-1?(e=e.split(""),d=1,(g>f||h>f)&&(d=0),e.splice(d,0,o[p].currency.symbol+j),e=e.join("")):e=o[p].currency.symbol+j+e:e.indexOf(")")>-1?(e=e.split(""),e.splice(-1,0,j+o[p].currency.symbol),e=e.join("")):e=e+j+o[p].currency.symbol,e}function f(a,b,c){var d,e="",f=100*a._value;return b.indexOf(" %")>-1?(e=" ",b=b.replace(" %","")):b=b.replace("%",""),d=i(f,b,c),d.indexOf(")")>-1?(d=d.split(""),d.splice(-1,0,e+"%"),d=d.join("")):d=d+e+"%",d}function g(a){var b=Math.floor(a._value/60/60),c=Math.floor((a._value-60*b*60)/60),d=Math.round(a._value-60*b*60-60*c);return b+":"+(10>c?"0"+c:c)+":"+(10>d?"0"+d:d)}function h(a){var b=a.split(":"),c=0;return 3===b.length?(c+=60*Number(b[0])*60,c+=60*Number(b[1]),c+=Number(b[2])):2===b.length&&(c+=60*Number(b[0]),c+=Number(b[1])),Number(c)}function i(a,c,d){var e,f,g,h,i,j,k=!1,l=!1,m=!1,n="",r=!1,s=!1,t=!1,u=!1,v=!1,w="",x="",y=Math.abs(a),z=["B","KB","MB","GB","TB","PB","EB","ZB","YB"],A="",B=!1;if(0===a&&null!==q)return q;if(c.indexOf("(")>-1?(k=!0,c=c.slice(1,-1)):c.indexOf("+")>-1&&(l=!0,c=c.replace(/\+/g,"")),c.indexOf("a")>-1&&(r=c.indexOf("aK")>=0,s=c.indexOf("aM")>=0,t=c.indexOf("aB")>=0,u=c.indexOf("aT")>=0,v=r||s||t||u,c.indexOf(" a")>-1?(n=" ",c=c.replace(" a","")):c=c.replace("a",""),y>=Math.pow(10,12)&&!v||u?(n+=o[p].abbreviations.trillion,a/=Math.pow(10,12)):y<Math.pow(10,12)&&y>=Math.pow(10,9)&&!v||t?(n+=o[p].abbreviations.billion,a/=Math.pow(10,9)):y<Math.pow(10,9)&&y>=Math.pow(10,6)&&!v||s?(n+=o[p].abbreviations.million,a/=Math.pow(10,6)):(y<Math.pow(10,6)&&y>=Math.pow(10,3)&&!v||r)&&(n+=o[p].abbreviations.thousand,a/=Math.pow(10,3))),c.indexOf("b")>-1)for(c.indexOf(" b")>-1?(w=" ",c=c.replace(" b","")):c=c.replace("b",""),g=0;g<=z.length;g++)if(e=Math.pow(1024,g),f=Math.pow(1024,g+1),a>=e&&f>a){w+=z[g],e>0&&(a/=e);break}return c.indexOf("o")>-1&&(c.indexOf(" o")>-1?(x=" ",c=c.replace(" o","")):c=c.replace("o",""),x+=o[p].ordinal(a)),c.indexOf("[.]")>-1&&(m=!0,c=c.replace("[.]",".")),h=a.toString().split(".")[0],i=c.split(".")[1],j=c.indexOf(","),i?(i.indexOf("[")>-1?(i=i.replace("]",""),i=i.split("["),A=b(a,i[0].length+i[1].length,d,i[1].length)):A=b(a,i.length,d),h=A.split(".")[0],A=A.split(".")[1].length?o[p].delimiters.decimal+A.split(".")[1]:"",m&&0===Number(A.slice(1))&&(A="")):h=b(a,null,d),h.indexOf("-")>-1&&(h=h.slice(1),B=!0),j>-1&&(h=h.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1"+o[p].delimiters.thousands)),0===c.indexOf(".")&&(h=""),(k&&B?"(":"")+(!k&&B?"-":"")+(!B&&l?"+":"")+h+A+(x?x:"")+(n?n:"")+(w?w:"")+(k&&B?")":"")}function j(a,b){o[a]=b}function k(a){var b=a.toString().split(".");return b.length<2?1:Math.pow(10,b[1].length)}function l(){var a=Array.prototype.slice.call(arguments);return a.reduce(function(a,b){var c=k(a),d=k(b);return c>d?c:d},-1/0)}var m,n="1.5.3",o={},p="en",q=null,r="0,0",s="undefined"!=typeof module&&module.exports;m=function(b){return m.isNumeral(b)?b=b.value():0===b||"undefined"==typeof b?b=0:Number(b)||(b=m.fn.unformat(b)),new a(Number(b))},m.version=n,m.isNumeral=function(b){return b instanceof a},m.language=function(a,b){if(!a)return p;if(a&&!b){if(!o[a])throw new Error("Unknown language : "+a);p=a}return(b||!o[a])&&j(a,b),m},m.languageData=function(a){if(!a)return o[p];if(!o[a])throw new Error("Unknown language : "+a);return o[a]},m.language("en",{delimiters:{thousands:",",decimal:"."},abbreviations:{thousand:"k",million:"m",billion:"b",trillion:"t"},ordinal:function(a){var b=a%10;return 1===~~(a%100/10)?"th":1===b?"st":2===b?"nd":3===b?"rd":"th"},currency:{symbol:"$"}}),m.zeroFormat=function(a){q="string"==typeof a?a:null},m.defaultFormat=function(a){r="string"==typeof a?a:"0.0"},"function"!=typeof Array.prototype.reduce&&(Array.prototype.reduce=function(a,b){"use strict";if(null===this||"undefined"==typeof this)throw new TypeError("Array.prototype.reduce called on null or undefined");if("function"!=typeof a)throw new TypeError(a+" is not a function");var c,d,e=this.length>>>0,f=!1;for(1<arguments.length&&(d=b,f=!0),c=0;e>c;++c)this.hasOwnProperty(c)&&(f?d=a(d,this[c],c,this):(d=this[c],f=!0));if(!f)throw new TypeError("Reduce of empty array with no initial value");return d}),m.fn=a.prototype={clone:function(){return m(this)},format:function(a,b){return c(this,a?a:r,void 0!==b?b:Math.round)},unformat:function(a){return"[object Number]"===Object.prototype.toString.call(a)?a:d(this,a?a:r)},value:function(){return this._value},valueOf:function(){return this._value},set:function(a){return this._value=Number(a),this},add:function(a){function b(a,b){return a+c*b}var c=l.call(null,this._value,a);return this._value=[this._value,a].reduce(b,0)/c,this},subtract:function(a){function b(a,b){return a-c*b}var c=l.call(null,this._value,a);return this._value=[a].reduce(b,this._value*c)/c,this},multiply:function(a){function b(a,b){var c=l(a,b);return a*c*b*c/(c*c)}return this._value=[this._value,a].reduce(b,1),this},divide:function(a){function b(a,b){var c=l(a,b);return a*c/(b*c)}return this._value=[this._value,a].reduce(b),this},difference:function(a){return Math.abs(m(this._value).subtract(a).value())}},s&&(module.exports=m),"undefined"==typeof ender&&(this.numeral=m),"function"==typeof define&&define.amd&&define([],function(){return m})}).call(this);
window.Base64 = {_keyStr:'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=',encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}};
/**
 * TODO
 *
 * Debounce filter firing.
 * Recenter map on window resize and debounce.
 */

;( function($, window) {
  'use strict';

  var GMaps = window.GMaps;

  var $scope = {
    ajaxUrl: window.ddpPropertiesObj.ajaxUrl,
    ajaxKey: window.ddpPropertiesObj.key,
    currentSlider: false
  };

  $scope.mapPins = {
    pin: 'M12.113 1C5.976 1 1 6 1 12.113c0 6.2 7.9 17 11.1 23.321c3.18-6.451 11.139-17.449 11.139-23.321 C23.227 6 18.3 1 12.1 1z M12.113 15.679c-1.834 0-3.321-1.487-3.321-3.321s1.487-3.321 3.321-3.321 s3.321 1.5 3.3 3.321S13.947 15.7 12.1 15.679z, M12.113 1c6.138 0 11.1 5 11.1 11.113c0 5.873-7.959 16.87-11.139 23.3 C8.875 29.1 1 18.3 1 12.113C1 6 6 1 12.1 1 M12.113 15.679c1.834 0 3.321-1.487 3.321-3.321 s-1.487-3.321-3.321-3.321s-3.321 1.487-3.321 3.321S10.279 15.7 12.1 15.7 M12.113 0C5.434 0 0 5.4 0 12.1 c0 4.7 4.1 11.5 7.7 17.579c1.354 2.3 2.6 4.4 3.5 6.193l0.904 1.788l0.886-1.797 c0.932-1.891 2.299-4.208 3.747-6.662c3.513-5.957 7.495-12.708 7.495-17.102C24.227 5.4 18.8 0 12.1 0L12.113 0z M12.113 14.679c-1.28 0-2.321-1.041-2.321-2.321s1.042-2.321 2.321-2.321c1.28 0 2.3 1 2.3 2.3 S13.394 14.7 12.1 14.679L12.113 14.679z',

    buy: '#d65b91',

    rent: '#369abd'
  };

  $scope.mask = $('<div style="background:white; display:block; opacity:.75 !important; width:100%; height:100%; position:absolute; top:0; left:0; z-index:99999;"></div>');

  $scope.Helpers = {
    exists: function(check) {
      if (check === null) {
        return false;
      }

      return true;
    },

    // Returns a function, that, as long as it continues to be invoked, will not
    // be triggered. The function will be called after it stops being called for
    // N milliseconds. If `immediate` is passed, trigger the function on the
    // leading edge, instead of the trailing.
    debounce: function(func, wait, immediate) {
      var timeout;
      return function() {
        var context = this, args = arguments;
        var later = function() {
          timeout = null;
          if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
      };
    },

    intBetween: function(test, min, max) {
      test = Number(test);
      if (test >= min && test <= max) {
        return true;
      }

      return false;
    }
  };

  var Model = function() {
    var $this = this;

    $this.getProperties = function(args) {
      args = $.extend({
        complete: false,
        filters: false
      }, args);

      var data = {
        action: 'ddpLiveGetProperties',
        key: $scope.ajaxKey,
        filters: args.filters
      };

      $.get($scope.ajaxUrl, data, function(response) {
        response = $.parseJSON(response);

        if ($scope.debug) {
          console.log('Properties ajax:');
          console.log(response);
        }

        if (args.complete) args.complete(response);
      });
    };

    return $this;
  };

  var View = function() {
    var $this = this;
    var _el = {};
    var _hoodRendered = false;
    $this.map = null;

    var init = function() {
      // Cache Elements
      _el.listingContainer = $('.js-ddp-live-listing-container');
      _el.listingContent = _el.listingContainer.find('.js-listing-content');
      $this.$listingContent = _el.listingContent;
    };

    $this.renderMap = function() {

      $this.map = new GMaps({
        div: '#map',
        lat: 42.331427,
        lng: -83.045754,
        scrollwheel: false,
        zoom: 14
      });

      $this.map.panBy(($(window).width() / 3) * (-1), 0);

      if (_hoodRendered === false) {
        // $this.addHoods();
      }
     };

    $this.addProperties = function(properties) {
      if (properties) {
        $this.map.removeMarkers();

        for (var i = 0; i < properties.length; i++) {
          if ($scope.Helpers.exists(properties[i].latitude) && $scope.Helpers.exists(properties[i].longitude)) {

            $this.map.addMarker({
              lat: properties[i].latitude,
              lng: properties[i].longitude,
              title: properties[i].title,
              animation: window.google.maps.Animation.DROP,
              icon: {
                path: $scope.mapPins.pin,
                fillColor: $scope.mapPins[properties[i].type],
                fillOpacity: 1,
                strokeColor: '#ffffff',
                strokeWeight: 1,
                scale: 1,
                anchor: {x: 24, y: 38}
              },
              infoWindow: {
                content: 'this.content'
              }
            });
          }
        }
      }
    };

    $this.listingDetail = function(atts) {
      atts = atts || {};
      atts = $.extend({
        propertyId: false,
        $container: false,
        onComplete: function() {}
      }, atts);

      if (! atts.$container) return false;
      if (! atts.propertyId) return false;
      var data = {
        action: 'ddpPropertyDetail',
        key: $scope.ajaxKey,
        propertyId: atts.propertyId
      };

      $.get($scope.ajaxUrl, data, function(response){
        response = $.parseJSON(response);
        var $html = $(window.Base64.decode(response.html));

        $html.prependTo(atts.$container);

        $scope.currentSlider = atts.$container.find('.js-listing-carousel').show().bxSlider({
          slideWidth   : '1080',
          auto         : true,
          useCSS       : false,
          pager        : false,
          prevText     : '<span class="io-icon-arrow-left"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="371px" height="317px" viewBox="0 0 371 317" enable-background="new 0 0 371 317" xml:space="preserve" version="1.1" id="Layer_1"><polygon fill="currentColor" points="156.438,317 212.272,317 75.079,178 371,178 371,138 76.065,138 212.273,0 156.438,0 0,158.5 "/></svg></span>',
          nextText     : '<span class="io-icon-arrow-right"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="371.256px" height="317px" viewBox="0 0 371.256 317" enable-background="new 0 0 371.256 317" xml:space="preserve" version="1.1" id="Layer_1"><polygon fill="currentColor" points="214.818,0 158.983,0 296.177,139 0,139 0,179 295.19,179 158.982,317 214.818,317 371.256,158.5 "/></svg></span>',
          onSliderLoad: function(){
            $('.slide').eq(1).addClass('current');
          },
          onSlideBefore: function(){
            $('.slide').removeClass('current');

          },
          onSlideAfter: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject){
            totalSlideQty = null;
            currentSlideNumber = null;
            $('.slide').eq(currentSlideHtmlObject+1).addClass('current');
          }
        });

        atts.onComplete($html, data.propertyId);
      });
    };

    // $this.addHoods = function() {
    //   console.log('called');

    //   // Load hoods file
    //   $.getJSON(window.ddpPropertiesObj.assetUri+'/data/hoods.json', function(data) {
    //     data = data.features;
    //     var i = 0;
    //     for (i; i < data.length; i++) {
    //       var item = data[i];

    //       if (item.properties.COUNTY.toLowerCase() === 'wayne') {
    //         var coords = [];
    //         $.each(item.geometry.coordinates[0], function(index, value) {
    //           coords.push(new window.gogle.maps.LatLng(value[1], value[0]));
    //         });

    //         $this.map.drawPolygon({
    //           paths: coords, // pre-defined polygon shape
    //           strokeColor: '#FF0000',
    //           strokeOpacity: 1,
    //           strokeWeight: 3,
    //           fillColor: '#FF0000',
    //           fillOpacity: 0.6
    //         });
    //       }
    //     }
    //   });

    //   _hoodRendered = true;
    // };

    $this.loadListings = function(atts) {
      atts = atts || {};
      atts = $.extend({
        properties: false,
        $mask: false,
        onComplete: function() {}
      }, atts);

      if (! atts.properties) return false;

      var data = {
        action: 'ddpPropertyListing',
        key: $scope.ajaxKey,
        properties: atts.properties
      };

      $.get($scope.ajaxUrl, data, function(response) {
        response = $.parseJSON(response);

        atts.$mask.animate({
          opacity: 1
        }, 600, function() {
          _el.listingContent.html(window.Base64.decode(response.html));

          atts.$mask.animate({
            opacity: 0
          }, 400, function() {
            atts.$mask.remove();
          });
        });

        atts.onComplete();
      });
    };

    $this.showListings = function() {
      _el.listingContainer.show();
    };

    $this.removeListings = function() {
      _el.listingContainer.hide();
    };

    init();
    return $this;
  };

  $scope.App = function (config) {
    var $this = this;
    var _Model = new Model();
    var _View = new View();
    var _properties = false;
    var _currentProperties = {};
    var _el = {};
    $this.filters = {};
    var _config = $.extend({
      debug: false,
      onUpdate: function() {},
      onFilter: function(){}
    }, config);

    $scope.debug = _config.debug;

    $this.init = function() {
      cacheElements();
      bindEvents();

      _Model.getProperties({
        complete: function(response) {

          _View.renderMap();

          if (response) {
            _properties = response;
            registerSliders();
            update();
          } else {
            View.noResults();
          }
        }
      });
    };

    var cacheElements = function() {
      _el.container = $('.js-live-here');
      _el.filters = _el.container.find('.js-live-here-filters');
      _el.sliders = _el.container.find('.js-range-slider');
      _el.triggers = _el.container.find('.js-ddp-live-trigger-update');
      _el.filterValues = _el.container.find('.js-ddp-live-filter-value');
      _el.showListingButton = _el.container.find('.js-show-listings');
      _el.getDetailButton = _el.container.find('.js-ddp-live-get-detail');
      _el.interactionContent = _el.container.find('.js-interaction-content');
      _el.closeDetailButton = _el.container.find('.js-close-detail');
    };

    var registerSliders = function() {
      _el.sliders.each(function() {
        var $el = $(this),
            type = $el.attr('data-type'),
            ranges = _properties.ranges,
            min = parseInt(ranges[type].min),
            max = parseInt(ranges[type].max);

        if (!min) min = 0;
        if (!max) max = 0;

        var updateValues = function(minVal, maxVal) {

          var $group = $el.parents('.js-range-group');

          $group.find('.js-min-value').val(minVal);
          $group.find('.js-max-value').val(maxVal);
          $group.find('.js-min-value-display').text(window.numeral(minVal).format('0,0'));
          $group.find('.js-max-value-display').text(window.numeral(maxVal).format('0,0'));
        };

        // Trigger initial ui update for values
        updateValues(min, max);

        $el.slider({
          range: true,
          min: min,
          max: max,
          values: [min, max],
          slide: function( event, ui ) {
            var values = ui.values;
            updateValues(values[0], values[1]);
          },
          stop: function() {
            update();
          }
        });
      });
    };

    var bindEvents = function() {
      _el.triggers.each(function() {
        var $el = $(this),
            type = $el.attr('type'),
            eType;

        switch(type) {
          case 'button':
            eType = 'click';
          break;

          case 'checkbox':
            eType = 'change';

          break;
        }

        $el.on(eType, function() {
          if (type === 'button') {
            $el.toggleClass('selected');
          }

          update();
        });
      });

      _el.closeDetailButton.live('click', function() {
        $scope.currentSlider.destroySlider();
        $('.js-listing-carousel').hide();
        $('.js-ddp-live-detail-container').remove();
      });

      _el.showListingButton.click(function() {
        var $el = $(this);
        var text = $el.find('.js-toggle-label');

        if (! $el.hasClass('active')) {
          _View.showListings();

          $el.addClass('active');
          text.text('Hide');
        } else {
          _View.removeListings();
          $el.removeClass('active');
          text.text('Show');
        }
      });

      _el.getDetailButton.live('click', function(event) {
        event.preventDefault();
        var $el = $(this);
        var id = $el.attr('data-ddp-live-id');

       _View.listingDetail({
          propertyId: id,
          $container: _el.interactionContent
       });
      });
    };

    var update = function() {
      if ($scope.debug) {
        console.log('Update triggered');
      }

      var $mask = $scope.mask;
      $mask.prependTo(_View.$listingContent);

      // var properties = filterProperties();
      // _config.onUpdate(properties);

      var properties = _properties.properties;
      _currentProperties = properties;

      _View.addProperties(properties);
      _View.loadListings({
        $mask: $mask,
        properties: _currentProperties
      });
    };

    // var filterProperties = function() {
    //   var properties = [];
    //   var filters = {};
    //   var types = [];
    //   var rooms = [];

    //   _el.filterValues.each(function() {
    //     var $el = $(this);
    //     var elType = $el.attr('type');
    //     var dataType = $el.attr('data-ddp-live-data-type');
    //     var value;

    //     if (elType === 'button') {
    //       value = $el.attr('data-ddp-live-button-value');

    //       if ($el.hasClass('selected')) {
    //         rooms.push(value);
    //       }
    //     } else {
    //       value = $el.val();
    //         if (dataType === 'type' && $el.is(':checked')) {
    //         types.push(value);
    //       } else {
    //         filters[dataType] = value;
    //       }
    //     }
    //   });

    //   filters.type = types;
    //   filters.rooms = rooms;

    //   if ($scope.debug) {
    //     console.log('Filters: ');
    //     console.log(filters);
    //   }

    //   for (var i = 0; i < _properties.properties.length; i++) {
    //     var prop = _properties.properties[i];

    //     if (filters.type.indexOf(prop.type) < 0 ) {
    //       continue;
    //     }

    //     if (! $scope.Helpers.intBetween(
    //       prop.price,
    //       filters['min-'+prop.type],
    //       filters['max-'+prop.type])) {
    //       continue;
    //     }

    //     if (! $scope.Helpers.intBetween(
    //       prop.sqFootage,
    //       filters['min-sq-ft'],
    //       filters['max-sq-ft'])) {
    //       continue;
    //     }

    //     if (filters.rooms.indexOf(prop.rooms) < 0 ) {
    //       var continueable = true;
    //       if (filters.rooms.indexOf('6') >= 0 && Number(prop.rooms) > 6) {
    //         continueable = false;
    //       }

    //       if (continueable) continue;
    //     }


    //     properties.push(_properties.properties[i]);
    //   }

    //   _config.onFilter(properties, filters);
    //   _currentProperties = properties;

    //   return properties;
    // };

    $this.init();

    return $this;
  };

  $scope.App({
    debug: false
  });

})(jQuery, window);