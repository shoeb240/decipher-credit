/**
* jQuery Maxlength plugin
* @version		$Id: jquery.maxlength.js 18 2009-05-16 15:37:08Z emil@anon-design.se $
* @package		jQuery maxlength 1.0.5
* @copyright	Copyright (C) 2009 Emil Stjerneman / http://www.anon-design.se
* @license		GNU/GPL, see LICENSE.txt
*/
/**
* jQuery Maxlength plugin
* @version		$Id: jquery.maxlength.js 18 2009-05-16 15:37:08Z emil@anon-design.se $
* @package		jQuery maxlength 1.0.5
* @copyright	Copyright (C) 2009 Emil Stjerneman / http://www.anon-design.se
* @license		GNU/GPL, see LICENSE.txt
*/
(function (e) { e.fn.maxlength = function (t) { var n = jQuery.extend({ events: [], maxCharacters: 10, status: true, statusClass: "status", statusText: "character left", notificationClass: "notification", showAlert: false, alertText: "You have typed too many characters.", slider: false }, t); e.merge(n.events, ["keyup"]); return this.each(function () { function i() { var e = n.maxCharacters - r; if (e < 0) { e = 0 } t.next("div").html(e + " " + n.statusText) } function s() { var e = true; if (r >= n.maxCharacters) { e = false; t.addClass(n.notificationClass); t.val(t.val().substr(0, n.maxCharacters)); o() } else { if (t.hasClass(n.notificationClass)) { t.removeClass(n.notificationClass) } } if (n.status) { i() } } function o() { if (n.showAlert) { alert(n.alertText) } } function u() { var e = false; if (t.is("textarea")) { e = true } else { if (t.filter("input[type=text]")) { e = true } else { if (t.filter("input[type=password]")) { e = true } } } return e } var t = e(this); var r = e(this).val().length; if (!u()) { return false } e.each(n.events, function (e, n) { t.bind(n, function (e) { r = t.val().length; s() }) }); if (n.status) { if (t.next("div." + n.statusClass).length > 0) { t.next("div." + n.statusClass).remove() } t.after(e("<div/>").addClass(n.statusClass).html("-")); i() } if (!n.status) { var a = t.next("div." + n.statusClass); if (a) { a.remove() } } if (n.slider) { t.next().hide(); t.focus(function () { t.next().slideDown("fast") }); t.blur(function () { t.next().slideUp("fast") }) } }) } })(jQuery)