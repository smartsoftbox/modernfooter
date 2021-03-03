/**
 * jQuery Scoped CSS plugin
 * This adds support for the CSS scoped attribute to limit a block of style declarations
 * to a specific area of the HTML. You can also use @import and media filters in scoped blocks
 * http://www.w3.org/TR/html5/semantics.html#the-style-element
 *
 * Copyright (c) Simon Madine, 1 February 2011
 *
 * Use:
 * Include this plugin file (minified, ideally) and call $.scoped() on load
 *
 * Limitations:
 * - If you're using multiple nested declarations, Webkit might apply different inheritance
 * specificity rules from the other engines. I don't know who's right.
 * - Sometimes there are delays parsing externally loaded stylesheets (via @import) and they
 * might get skipped. Not often but it happens.
 *
 * Notes:
 * - If the browser natively supports <style scoped>, this will return without doing anything
 * - Style elements really shouldn't have classes added to them. This functionality should
 * probably use some kind of data attribute.
 * - Currently, getElementStyles is hand-rolled and probably wrong.
 *
 * v0.6 2013-04-08
 * Removed $.browser requirement and refactored a bit so it runs slightly faster and works with
 * jQuery 1.9. Also checks for native scoped style support and exits early if available.
 *
 * v0.5 2011-01-30
 * Sibling blocks work, most nested blocks work but some oddness in Webkit means that some
 * styles don't inherit correctly when there are multiple nested declarations.
 *
 * v0.4 2011-01-29
 * First jQuery plugin version. Works for most cases but gets confused when there are
 * multiple scoped blocks affecting the same context (siblings).
 *
 */

!function(a){"use strict";a.scoped=function(){function d(b){return void 0!==a(b).attr("scoped")}function e(){a("style").each(function(b,c){if(d(c)){var e=a(c);e.data("original-style",e.html())}})}function f(b){a("style").each(function(c,e){if(d(e)&&!b.hasClass("depends_on_"+c))try{e.innerHTML=""}catch(b){a(e).attr("disabled","disabled")}})}function g(){a("style").each(function(b,c){var e=a(c);if(d(c))try{c.innerHTML=e.data("original-style")}catch(b){a(this).removeAttr("disabled")}})}function h(a){var b,c,d,e;if(a.currentStyle)return k(50),a.currentStyle;b=document.defaultView.getComputedStyle(a,null),c="";for(d in b)parseInt(d,10)&&(e=j(b[d]),void 0!==b[e]&&(c+=b[d]+":"+b[e]+";\n"));return c}function i(){var b=a("style");b.each(function(b,c){var d=a(c),e=a(this).parent(),f=e.find("*");if(f.add(e).each(function(){var b=a(this);"STYLE"!==this.nodeName&&b.data("scopedprocessed")&&(b.attr("style",b.data("originalInline")||""),b.data("scopedprocessed",!0))}),void 0!==d.attr("scoped")){try{d.data("scopedprocessed")&&(this.innerHTML=d.data("original-style"))}catch(a){d.removeAttr("disabled")}d.data("scopedprocessed",!0)}})}function j(a){return a.replace(/-+(.)?/g,function(a,b){return b?b.toUpperCase():""})}function k(b){var c=new Date;for(c.setTime(c.getTime()+b);(new Date).getTime()<c.getTime();)a.noop()}if(!("scoped"in document.createElement("style"))){var b=!0;try{document.createElement("div").style.setProperty("opacity",0,"")}catch(a){b=!1}i(),e();var c=a("style");c.each(function(b){var c=a(this);d(c)&&(c.addClass("this_is_"+b),c.parent().find("style").each(function(){a(this).addClass("depends_on_"+b)}))}),c.each(function(){var c=a(this);if(d(c)){f(c);var e=[],i=c.parent(),j=i.find("*");j.add(i).each(function(){a(this).css("cssText",""),"STYLE"!==this.nodeName&&e.push(h(this))}),j.add(i).each(function(){var c,d;if("STYLE"!==this.nodeName)if(a(this).data("originalInline")||a(this).data("originalInline",a(this).attr("style")),c=e.shift(),"string"==typeof c)a(this).css("cssText",c);else if(b){for(d in c)if("content"!==d||"none"!==c[d])try{this.style.setProperty(d,c[d])}catch(a){}}else for(d in c)try{this&&this.style&&d&&c[d]&&""!==d&&""!==c[d]&&(this.style[d]=c[d])}catch(a){}}),g()}}),a("style").each(function(b,c){if(d(c))try{c.innerHTML=""}catch(b){a(c).attr("disabled","disabled")}})}}}(jQuery);
