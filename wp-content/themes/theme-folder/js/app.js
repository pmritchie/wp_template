(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app"],{

/***/ "./resources/scripts/app.js":
/*!**********************************!*\
  !*** ./resources/scripts/app.js ***!
  \**********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var lozad__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lozad */ "./node_modules/lozad/dist/lozad.min.js");
/* harmony import */ var lozad__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lozad__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var retinajs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! retinajs */ "./node_modules/retinajs/dist/retina.min.js");
/* harmony import */ var retinajs__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(retinajs__WEBPACK_IMPORTED_MODULE_1__);
/**
 * External Dependencies
 */
__webpack_require__(/*! intersection-observer */ "./node_modules/intersection-observer/intersection-observer.js");



var targets = document.querySelectorAll(".lozad");

var lazyLoad = function lazyLoad(target) {
  var io = new IntersectionObserver(function (entries, observer) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        var img = entry.target;
        var src = img.getAttribute("data-src");
        img.setAttribute("src", src);
        observer.disconnect();
      }
    });
  });
  io.observe(target);
};

$(window).scroll(function () {
  if ($(document).scrollTop() == 0) {
    $("#main-header").removeClass("is-sticky");
  } else {
    $("#main-header").addClass("is-sticky");
  }
}); // $(document).ready(function() {
//   // Bootstrap dropdown
//   $(window).resize(function() {
//     if ($(window).width() < 768) {
//       $(".dropdown-toggle").attr("data-toggle", "dropdown");
//     } else {
//       $(".dropdown-toggle").removeAttr("data-toggle dropdown");
//     }
//   });
// });
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "jquery")))

/***/ }),

/***/ "./resources/styles/main.scss":
/*!************************************!*\
  !*** ./resources/styles/main.scss ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*********************************************************************!*\
  !*** multi ./resources/scripts/app.js ./resources/styles/main.scss ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/patrickritchie/Desktop/Dev/libertycommittee/wp-content/themes/libertycommittee/resources/scripts/app.js */"./resources/scripts/app.js");
module.exports = __webpack_require__(/*! /Users/patrickritchie/Desktop/Dev/libertycommittee/wp-content/themes/libertycommittee/resources/styles/main.scss */"./resources/styles/main.scss");


/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["jQuery"]; }());

/***/ })

},[[0,"/dist/js/manifest","/dist/js/vendor"]]]);
//# sourceMappingURL=app.js.map