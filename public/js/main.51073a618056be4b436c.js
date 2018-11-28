/******/ (function(modules) { // webpackBootstrap
/******/ 	// install a JSONP callback for chunk loading
/******/ 	function webpackJsonpCallback(data) {
/******/ 		var chunkIds = data[0];
/******/ 		var moreModules = data[1];
/******/ 		var executeModules = data[2];
/******/
/******/ 		// add "moreModules" to the modules object,
/******/ 		// then flag all "chunkIds" as loaded and fire callback
/******/ 		var moduleId, chunkId, i = 0, resolves = [];
/******/ 		for(;i < chunkIds.length; i++) {
/******/ 			chunkId = chunkIds[i];
/******/ 			if(installedChunks[chunkId]) {
/******/ 				resolves.push(installedChunks[chunkId][0]);
/******/ 			}
/******/ 			installedChunks[chunkId] = 0;
/******/ 		}
/******/ 		for(moduleId in moreModules) {
/******/ 			if(Object.prototype.hasOwnProperty.call(moreModules, moduleId)) {
/******/ 				modules[moduleId] = moreModules[moduleId];
/******/ 			}
/******/ 		}
/******/ 		if(parentJsonpFunction) parentJsonpFunction(data);
/******/
/******/ 		while(resolves.length) {
/******/ 			resolves.shift()();
/******/ 		}
/******/
/******/ 		// add entry modules from loaded chunk to deferred list
/******/ 		deferredModules.push.apply(deferredModules, executeModules || []);
/******/
/******/ 		// run deferred modules when all chunks ready
/******/ 		return checkDeferredModules();
/******/ 	};
/******/ 	function checkDeferredModules() {
/******/ 		var result;
/******/ 		for(var i = 0; i < deferredModules.length; i++) {
/******/ 			var deferredModule = deferredModules[i];
/******/ 			var fulfilled = true;
/******/ 			for(var j = 1; j < deferredModule.length; j++) {
/******/ 				var depId = deferredModule[j];
/******/ 				if(installedChunks[depId] !== 0) fulfilled = false;
/******/ 			}
/******/ 			if(fulfilled) {
/******/ 				deferredModules.splice(i--, 1);
/******/ 				result = __webpack_require__(__webpack_require__.s = deferredModule[0]);
/******/ 			}
/******/ 		}
/******/ 		return result;
/******/ 	}
/******/
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// object to store loaded and loading chunks
/******/ 	// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 	// Promise = chunk loading, 0 = chunk loaded
/******/ 	var installedChunks = {
/******/ 		"main": 0
/******/ 	};
/******/
/******/ 	var deferredModules = [];
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/js/";
/******/
/******/ 	var jsonpArray = window["webpackJsonp"] = window["webpackJsonp"] || [];
/******/ 	var oldJsonpFunction = jsonpArray.push.bind(jsonpArray);
/******/ 	jsonpArray.push = webpackJsonpCallback;
/******/ 	jsonpArray = jsonpArray.slice();
/******/ 	for(var i = 0; i < jsonpArray.length; i++) webpackJsonpCallback(jsonpArray[i]);
/******/ 	var parentJsonpFunction = oldJsonpFunction;
/******/
/******/
/******/ 	// add entry module to deferred list
/******/ 	deferredModules.push(["./resources/assets/js/src/index.js","vendor"]);
/******/ 	// run deferred modules when ready
/******/ 	return checkDeferredModules();
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/src/fields/App.vue?vue&type=style&index=0&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/App.vue?vue&type=style&index=0&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/*! ModuleConcatenation bailout: Module is not an ECMAScript module */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.example {\n    color: red;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/moment/locale sync recursive ^\\.\\/.*$":
/*!**************************************************!*\
  !*** ./node_modules/moment/locale sync ^\.\/.*$ ***!
  \**************************************************/
/*! no static exports found */
/*! ModuleConcatenation bailout: Module is not an ECMAScript module */
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./af": "./node_modules/moment/locale/af.js",
	"./af.js": "./node_modules/moment/locale/af.js",
	"./ar": "./node_modules/moment/locale/ar.js",
	"./ar-dz": "./node_modules/moment/locale/ar-dz.js",
	"./ar-dz.js": "./node_modules/moment/locale/ar-dz.js",
	"./ar-kw": "./node_modules/moment/locale/ar-kw.js",
	"./ar-kw.js": "./node_modules/moment/locale/ar-kw.js",
	"./ar-ly": "./node_modules/moment/locale/ar-ly.js",
	"./ar-ly.js": "./node_modules/moment/locale/ar-ly.js",
	"./ar-ma": "./node_modules/moment/locale/ar-ma.js",
	"./ar-ma.js": "./node_modules/moment/locale/ar-ma.js",
	"./ar-sa": "./node_modules/moment/locale/ar-sa.js",
	"./ar-sa.js": "./node_modules/moment/locale/ar-sa.js",
	"./ar-tn": "./node_modules/moment/locale/ar-tn.js",
	"./ar-tn.js": "./node_modules/moment/locale/ar-tn.js",
	"./ar.js": "./node_modules/moment/locale/ar.js",
	"./az": "./node_modules/moment/locale/az.js",
	"./az.js": "./node_modules/moment/locale/az.js",
	"./be": "./node_modules/moment/locale/be.js",
	"./be.js": "./node_modules/moment/locale/be.js",
	"./bg": "./node_modules/moment/locale/bg.js",
	"./bg.js": "./node_modules/moment/locale/bg.js",
	"./bm": "./node_modules/moment/locale/bm.js",
	"./bm.js": "./node_modules/moment/locale/bm.js",
	"./bn": "./node_modules/moment/locale/bn.js",
	"./bn.js": "./node_modules/moment/locale/bn.js",
	"./bo": "./node_modules/moment/locale/bo.js",
	"./bo.js": "./node_modules/moment/locale/bo.js",
	"./br": "./node_modules/moment/locale/br.js",
	"./br.js": "./node_modules/moment/locale/br.js",
	"./bs": "./node_modules/moment/locale/bs.js",
	"./bs.js": "./node_modules/moment/locale/bs.js",
	"./ca": "./node_modules/moment/locale/ca.js",
	"./ca.js": "./node_modules/moment/locale/ca.js",
	"./cs": "./node_modules/moment/locale/cs.js",
	"./cs.js": "./node_modules/moment/locale/cs.js",
	"./cv": "./node_modules/moment/locale/cv.js",
	"./cv.js": "./node_modules/moment/locale/cv.js",
	"./cy": "./node_modules/moment/locale/cy.js",
	"./cy.js": "./node_modules/moment/locale/cy.js",
	"./da": "./node_modules/moment/locale/da.js",
	"./da.js": "./node_modules/moment/locale/da.js",
	"./de": "./node_modules/moment/locale/de.js",
	"./de-at": "./node_modules/moment/locale/de-at.js",
	"./de-at.js": "./node_modules/moment/locale/de-at.js",
	"./de-ch": "./node_modules/moment/locale/de-ch.js",
	"./de-ch.js": "./node_modules/moment/locale/de-ch.js",
	"./de.js": "./node_modules/moment/locale/de.js",
	"./dv": "./node_modules/moment/locale/dv.js",
	"./dv.js": "./node_modules/moment/locale/dv.js",
	"./el": "./node_modules/moment/locale/el.js",
	"./el.js": "./node_modules/moment/locale/el.js",
	"./en-au": "./node_modules/moment/locale/en-au.js",
	"./en-au.js": "./node_modules/moment/locale/en-au.js",
	"./en-ca": "./node_modules/moment/locale/en-ca.js",
	"./en-ca.js": "./node_modules/moment/locale/en-ca.js",
	"./en-gb": "./node_modules/moment/locale/en-gb.js",
	"./en-gb.js": "./node_modules/moment/locale/en-gb.js",
	"./en-ie": "./node_modules/moment/locale/en-ie.js",
	"./en-ie.js": "./node_modules/moment/locale/en-ie.js",
	"./en-il": "./node_modules/moment/locale/en-il.js",
	"./en-il.js": "./node_modules/moment/locale/en-il.js",
	"./en-nz": "./node_modules/moment/locale/en-nz.js",
	"./en-nz.js": "./node_modules/moment/locale/en-nz.js",
	"./eo": "./node_modules/moment/locale/eo.js",
	"./eo.js": "./node_modules/moment/locale/eo.js",
	"./es": "./node_modules/moment/locale/es.js",
	"./es-do": "./node_modules/moment/locale/es-do.js",
	"./es-do.js": "./node_modules/moment/locale/es-do.js",
	"./es-us": "./node_modules/moment/locale/es-us.js",
	"./es-us.js": "./node_modules/moment/locale/es-us.js",
	"./es.js": "./node_modules/moment/locale/es.js",
	"./et": "./node_modules/moment/locale/et.js",
	"./et.js": "./node_modules/moment/locale/et.js",
	"./eu": "./node_modules/moment/locale/eu.js",
	"./eu.js": "./node_modules/moment/locale/eu.js",
	"./fa": "./node_modules/moment/locale/fa.js",
	"./fa.js": "./node_modules/moment/locale/fa.js",
	"./fi": "./node_modules/moment/locale/fi.js",
	"./fi.js": "./node_modules/moment/locale/fi.js",
	"./fo": "./node_modules/moment/locale/fo.js",
	"./fo.js": "./node_modules/moment/locale/fo.js",
	"./fr": "./node_modules/moment/locale/fr.js",
	"./fr-ca": "./node_modules/moment/locale/fr-ca.js",
	"./fr-ca.js": "./node_modules/moment/locale/fr-ca.js",
	"./fr-ch": "./node_modules/moment/locale/fr-ch.js",
	"./fr-ch.js": "./node_modules/moment/locale/fr-ch.js",
	"./fr.js": "./node_modules/moment/locale/fr.js",
	"./fy": "./node_modules/moment/locale/fy.js",
	"./fy.js": "./node_modules/moment/locale/fy.js",
	"./gd": "./node_modules/moment/locale/gd.js",
	"./gd.js": "./node_modules/moment/locale/gd.js",
	"./gl": "./node_modules/moment/locale/gl.js",
	"./gl.js": "./node_modules/moment/locale/gl.js",
	"./gom-latn": "./node_modules/moment/locale/gom-latn.js",
	"./gom-latn.js": "./node_modules/moment/locale/gom-latn.js",
	"./gu": "./node_modules/moment/locale/gu.js",
	"./gu.js": "./node_modules/moment/locale/gu.js",
	"./he": "./node_modules/moment/locale/he.js",
	"./he.js": "./node_modules/moment/locale/he.js",
	"./hi": "./node_modules/moment/locale/hi.js",
	"./hi.js": "./node_modules/moment/locale/hi.js",
	"./hr": "./node_modules/moment/locale/hr.js",
	"./hr.js": "./node_modules/moment/locale/hr.js",
	"./hu": "./node_modules/moment/locale/hu.js",
	"./hu.js": "./node_modules/moment/locale/hu.js",
	"./hy-am": "./node_modules/moment/locale/hy-am.js",
	"./hy-am.js": "./node_modules/moment/locale/hy-am.js",
	"./id": "./node_modules/moment/locale/id.js",
	"./id.js": "./node_modules/moment/locale/id.js",
	"./is": "./node_modules/moment/locale/is.js",
	"./is.js": "./node_modules/moment/locale/is.js",
	"./it": "./node_modules/moment/locale/it.js",
	"./it.js": "./node_modules/moment/locale/it.js",
	"./ja": "./node_modules/moment/locale/ja.js",
	"./ja.js": "./node_modules/moment/locale/ja.js",
	"./jv": "./node_modules/moment/locale/jv.js",
	"./jv.js": "./node_modules/moment/locale/jv.js",
	"./ka": "./node_modules/moment/locale/ka.js",
	"./ka.js": "./node_modules/moment/locale/ka.js",
	"./kk": "./node_modules/moment/locale/kk.js",
	"./kk.js": "./node_modules/moment/locale/kk.js",
	"./km": "./node_modules/moment/locale/km.js",
	"./km.js": "./node_modules/moment/locale/km.js",
	"./kn": "./node_modules/moment/locale/kn.js",
	"./kn.js": "./node_modules/moment/locale/kn.js",
	"./ko": "./node_modules/moment/locale/ko.js",
	"./ko.js": "./node_modules/moment/locale/ko.js",
	"./ky": "./node_modules/moment/locale/ky.js",
	"./ky.js": "./node_modules/moment/locale/ky.js",
	"./lb": "./node_modules/moment/locale/lb.js",
	"./lb.js": "./node_modules/moment/locale/lb.js",
	"./lo": "./node_modules/moment/locale/lo.js",
	"./lo.js": "./node_modules/moment/locale/lo.js",
	"./lt": "./node_modules/moment/locale/lt.js",
	"./lt.js": "./node_modules/moment/locale/lt.js",
	"./lv": "./node_modules/moment/locale/lv.js",
	"./lv.js": "./node_modules/moment/locale/lv.js",
	"./me": "./node_modules/moment/locale/me.js",
	"./me.js": "./node_modules/moment/locale/me.js",
	"./mi": "./node_modules/moment/locale/mi.js",
	"./mi.js": "./node_modules/moment/locale/mi.js",
	"./mk": "./node_modules/moment/locale/mk.js",
	"./mk.js": "./node_modules/moment/locale/mk.js",
	"./ml": "./node_modules/moment/locale/ml.js",
	"./ml.js": "./node_modules/moment/locale/ml.js",
	"./mn": "./node_modules/moment/locale/mn.js",
	"./mn.js": "./node_modules/moment/locale/mn.js",
	"./mr": "./node_modules/moment/locale/mr.js",
	"./mr.js": "./node_modules/moment/locale/mr.js",
	"./ms": "./node_modules/moment/locale/ms.js",
	"./ms-my": "./node_modules/moment/locale/ms-my.js",
	"./ms-my.js": "./node_modules/moment/locale/ms-my.js",
	"./ms.js": "./node_modules/moment/locale/ms.js",
	"./mt": "./node_modules/moment/locale/mt.js",
	"./mt.js": "./node_modules/moment/locale/mt.js",
	"./my": "./node_modules/moment/locale/my.js",
	"./my.js": "./node_modules/moment/locale/my.js",
	"./nb": "./node_modules/moment/locale/nb.js",
	"./nb.js": "./node_modules/moment/locale/nb.js",
	"./ne": "./node_modules/moment/locale/ne.js",
	"./ne.js": "./node_modules/moment/locale/ne.js",
	"./nl": "./node_modules/moment/locale/nl.js",
	"./nl-be": "./node_modules/moment/locale/nl-be.js",
	"./nl-be.js": "./node_modules/moment/locale/nl-be.js",
	"./nl.js": "./node_modules/moment/locale/nl.js",
	"./nn": "./node_modules/moment/locale/nn.js",
	"./nn.js": "./node_modules/moment/locale/nn.js",
	"./pa-in": "./node_modules/moment/locale/pa-in.js",
	"./pa-in.js": "./node_modules/moment/locale/pa-in.js",
	"./pl": "./node_modules/moment/locale/pl.js",
	"./pl.js": "./node_modules/moment/locale/pl.js",
	"./pt": "./node_modules/moment/locale/pt.js",
	"./pt-br": "./node_modules/moment/locale/pt-br.js",
	"./pt-br.js": "./node_modules/moment/locale/pt-br.js",
	"./pt.js": "./node_modules/moment/locale/pt.js",
	"./ro": "./node_modules/moment/locale/ro.js",
	"./ro.js": "./node_modules/moment/locale/ro.js",
	"./ru": "./node_modules/moment/locale/ru.js",
	"./ru.js": "./node_modules/moment/locale/ru.js",
	"./sd": "./node_modules/moment/locale/sd.js",
	"./sd.js": "./node_modules/moment/locale/sd.js",
	"./se": "./node_modules/moment/locale/se.js",
	"./se.js": "./node_modules/moment/locale/se.js",
	"./si": "./node_modules/moment/locale/si.js",
	"./si.js": "./node_modules/moment/locale/si.js",
	"./sk": "./node_modules/moment/locale/sk.js",
	"./sk.js": "./node_modules/moment/locale/sk.js",
	"./sl": "./node_modules/moment/locale/sl.js",
	"./sl.js": "./node_modules/moment/locale/sl.js",
	"./sq": "./node_modules/moment/locale/sq.js",
	"./sq.js": "./node_modules/moment/locale/sq.js",
	"./sr": "./node_modules/moment/locale/sr.js",
	"./sr-cyrl": "./node_modules/moment/locale/sr-cyrl.js",
	"./sr-cyrl.js": "./node_modules/moment/locale/sr-cyrl.js",
	"./sr.js": "./node_modules/moment/locale/sr.js",
	"./ss": "./node_modules/moment/locale/ss.js",
	"./ss.js": "./node_modules/moment/locale/ss.js",
	"./sv": "./node_modules/moment/locale/sv.js",
	"./sv.js": "./node_modules/moment/locale/sv.js",
	"./sw": "./node_modules/moment/locale/sw.js",
	"./sw.js": "./node_modules/moment/locale/sw.js",
	"./ta": "./node_modules/moment/locale/ta.js",
	"./ta.js": "./node_modules/moment/locale/ta.js",
	"./te": "./node_modules/moment/locale/te.js",
	"./te.js": "./node_modules/moment/locale/te.js",
	"./tet": "./node_modules/moment/locale/tet.js",
	"./tet.js": "./node_modules/moment/locale/tet.js",
	"./tg": "./node_modules/moment/locale/tg.js",
	"./tg.js": "./node_modules/moment/locale/tg.js",
	"./th": "./node_modules/moment/locale/th.js",
	"./th.js": "./node_modules/moment/locale/th.js",
	"./tl-ph": "./node_modules/moment/locale/tl-ph.js",
	"./tl-ph.js": "./node_modules/moment/locale/tl-ph.js",
	"./tlh": "./node_modules/moment/locale/tlh.js",
	"./tlh.js": "./node_modules/moment/locale/tlh.js",
	"./tr": "./node_modules/moment/locale/tr.js",
	"./tr.js": "./node_modules/moment/locale/tr.js",
	"./tzl": "./node_modules/moment/locale/tzl.js",
	"./tzl.js": "./node_modules/moment/locale/tzl.js",
	"./tzm": "./node_modules/moment/locale/tzm.js",
	"./tzm-latn": "./node_modules/moment/locale/tzm-latn.js",
	"./tzm-latn.js": "./node_modules/moment/locale/tzm-latn.js",
	"./tzm.js": "./node_modules/moment/locale/tzm.js",
	"./ug-cn": "./node_modules/moment/locale/ug-cn.js",
	"./ug-cn.js": "./node_modules/moment/locale/ug-cn.js",
	"./uk": "./node_modules/moment/locale/uk.js",
	"./uk.js": "./node_modules/moment/locale/uk.js",
	"./ur": "./node_modules/moment/locale/ur.js",
	"./ur.js": "./node_modules/moment/locale/ur.js",
	"./uz": "./node_modules/moment/locale/uz.js",
	"./uz-latn": "./node_modules/moment/locale/uz-latn.js",
	"./uz-latn.js": "./node_modules/moment/locale/uz-latn.js",
	"./uz.js": "./node_modules/moment/locale/uz.js",
	"./vi": "./node_modules/moment/locale/vi.js",
	"./vi.js": "./node_modules/moment/locale/vi.js",
	"./x-pseudo": "./node_modules/moment/locale/x-pseudo.js",
	"./x-pseudo.js": "./node_modules/moment/locale/x-pseudo.js",
	"./yo": "./node_modules/moment/locale/yo.js",
	"./yo.js": "./node_modules/moment/locale/yo.js",
	"./zh-cn": "./node_modules/moment/locale/zh-cn.js",
	"./zh-cn.js": "./node_modules/moment/locale/zh-cn.js",
	"./zh-hk": "./node_modules/moment/locale/zh-hk.js",
	"./zh-hk.js": "./node_modules/moment/locale/zh-hk.js",
	"./zh-tw": "./node_modules/moment/locale/zh-tw.js",
	"./zh-tw.js": "./node_modules/moment/locale/zh-tw.js"
};


function webpackContext(req) {
	var id = webpackContextResolve(req);
	return __webpack_require__(id);
}
function webpackContextResolve(req) {
	var id = map[req];
	if(!(id + 1)) { // check for number or string
		var e = new Error("Cannot find module '" + req + "'");
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	}
	return id;
}
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = "./node_modules/moment/locale sync recursive ^\\.\\/.*$";

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/src/fields/App.vue?vue&type=style&index=0&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/App.vue?vue&type=style&index=0&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/*! ModuleConcatenation bailout: Module is not an ECMAScript module */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(/*! !../../../../../node_modules/css-loader!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/vue-loader/lib??vue-loader-options!./App.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/src/fields/App.vue?vue&type=style&index=0&lang=css&");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var add = __webpack_require__(/*! ../../../../../node_modules/vue-style-loader/lib/addStylesClient.js */ "./node_modules/vue-style-loader/lib/addStylesClient.js").default
var update = add("1be3242c", content, false, {});
// Hot Module Replacement
if(false) {}

/***/ }),

/***/ "./resources/assets/js/src/fields/App.vue?vue&type=style&index=0&lang=css&":
/*!*********************************************************************************!*\
  !*** ./resources/assets/js/src/fields/App.vue?vue&type=style&index=0&lang=css& ***!
  \*********************************************************************************/
/*! no static exports found */
/*! ModuleConcatenation bailout: Module exports are unknown */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-style-loader!../../../../../node_modules/css-loader!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/vue-loader/lib??vue-loader-options!./App.vue?vue&type=style&index=0&lang=css& */ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/src/fields/App.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_vue_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_vue_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_vue_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_vue_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_vue_loader_lib_index_js_vue_loader_options_App_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/assets/js/src/index.js":
/*!*******************************************************!*\
  !*** ./resources/assets/js/src/index.js + 49 modules ***!
  \*******************************************************/
/*! no exports provided */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/choices.js/assets/scripts/dist/choices.min.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/dragula/dragula.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/flatpickr/dist/flatpickr.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/moment/moment.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/rxjs/_esm5/index.js */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/rxjs/_esm5/operators/index.js */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vue/dist/vue.runtime.esm.js (<- Module uses injected variables (global, setImmediate)) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vue-loader/lib/runtime/componentNormalizer.js */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";

// CONCATENATED MODULE: ./resources/assets/js/src/util/polyfills.js
function init() {
    if (typeof window.svg4everybody !== 'undefined') {
        window.svg4everybody();
    }

    closest();
    polyfills_assign();
    remove();
    arrayFrom();
}

function closest() {
    // matches polyfill
    window.Element && function (ElementPrototype) {
        ElementPrototype.matches = ElementPrototype.matches || ElementPrototype.matchesSelector || ElementPrototype.webkitMatchesSelector || ElementPrototype.msMatchesSelector || function (selector) {
            var node = this;
            var nodes = (node.parentNode || node.document).querySelectorAll(selector);
            var i = -1;
            while (nodes[++i] && nodes[i] !== node) {}
            return !!nodes[i];
        };
    }(Element.prototype);

    // closest polyfill
    window.Element && function (ElementPrototype) {
        ElementPrototype.closest = ElementPrototype.closest || function (selector) {
            var el = this;
            while (el.matches && !el.matches(selector)) {
                el = el.parentNode;
            }
            return el.matches ? el : null;
        };
    }(Element.prototype);
}

function polyfills_assign() {
    if (typeof Object.assign !== 'function') {
        // Must be writable: true, enumerable: false, configurable: true
        Object.defineProperty(Object, 'assign', {
            value: function assign(target, varArgs) {
                // .length of function is 2
                'use strict';

                if (target == null) {
                    // TypeError if undefined or null
                    throw new TypeError('Cannot convert undefined or null to object');
                }

                var to = Object(target);

                for (var index = 1; index < arguments.length; index++) {
                    var nextSource = arguments[index];

                    if (nextSource != null) {
                        // Skip over if undefined or null
                        for (var nextKey in nextSource) {
                            // Avoid bugs when hasOwnProperty is shadowed
                            if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
                                to[nextKey] = nextSource[nextKey];
                            }
                        }
                    }
                }
                return to;
            },
            writable: true,
            configurable: true
        });
    }
}

function remove() {
    // from:https://github.com/jserz/js_piece/blob/master/DOM/ChildNode/remove()/remove().md
    window.Element && function (arr) {
        arr.forEach(function (item) {
            if (item.hasOwnProperty('remove')) {
                return;
            }

            Object.defineProperty(item, 'remove', {
                configurable: true,
                enumerable: true,
                writable: true,
                value: function remove() {
                    if (this.parentNode !== null) {
                        this.parentNode.removeChild(this);
                    }
                }
            });
        });
    }([Element.prototype, CharacterData.prototype, DocumentType.prototype]);
}

function arrayFrom() {
    // Production steps of ECMA-262, Edition 6, 22.1.2.1
    if (!Array.from) {
        Array.from = function () {
            var toStr = Object.prototype.toString;
            var isCallable = function isCallable(fn) {
                return typeof fn === 'function' || toStr.call(fn) === '[object Function]';
            };
            var toInteger = function toInteger(value) {
                var number = Number(value);
                if (isNaN(number)) {
                    return 0;
                }
                if (number === 0 || !isFinite(number)) {
                    return number;
                }
                return (number > 0 ? 1 : -1) * Math.floor(Math.abs(number));
            };
            var maxSafeInteger = Math.pow(2, 53) - 1;
            var toLength = function toLength(value) {
                var len = toInteger(value);
                return Math.min(Math.max(len, 0), maxSafeInteger);
            };

            // The length property of the from method is 1.
            return function from(arrayLike /*, mapFn, thisArg */) {
                // 1. Let C be the this value.
                var C = this;

                // 2. Let items be ToObject(arrayLike).
                var items = Object(arrayLike);

                // 3. ReturnIfAbrupt(items).
                if (arrayLike == null) {
                    throw new TypeError('Array.from requires an array-like object - not null or undefined');
                }

                // 4. If mapfn is undefined, then let mapping be false.
                var mapFn = arguments.length > 1 ? arguments[1] : void undefined;
                var T;
                if (typeof mapFn !== 'undefined') {
                    // 5. else
                    // 5. a If IsCallable(mapfn) is false, throw a TypeError exception.
                    if (!isCallable(mapFn)) {
                        throw new TypeError('Array.from: when provided, the second argument must be a function');
                    }

                    // 5. b. If thisArg was supplied, let T be thisArg; else let T be undefined.
                    if (arguments.length > 2) {
                        T = arguments[2];
                    }
                }

                // 10. Let lenValue be Get(items, "length").
                // 11. Let len be ToLength(lenValue).
                var len = toLength(items.length);

                // 13. If IsConstructor(C) is true, then
                // 13. a. Let A be the result of calling the [[Construct]] internal method
                // of C with an argument list containing the single item len.
                // 14. a. Else, Let A be ArrayCreate(len).
                var A = isCallable(C) ? Object(new C(len)) : new Array(len);

                // 16. Let k be 0.
                var k = 0;
                // 17. Repeat, while k < len… (also steps a - h)
                var kValue;
                while (k < len) {
                    kValue = items[k];
                    if (mapFn) {
                        A[k] = typeof T === 'undefined' ? mapFn(kValue, k) : mapFn.call(T, kValue, k);
                    } else {
                        A[k] = kValue;
                    }
                    k += 1;
                }
                // 18. Let putStatus be Put(A, "length", len, true).
                A.length = len;
                // 20. Return A.
                return A;
            };
        }();
    }
}
// CONCATENATED MODULE: ./resources/assets/js/src/util/ajax.js
var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var post = function post(url, data) {
    var contentType = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'application/json';
    return new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-type', contentType);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                resolve(xhr.responseText);
            } else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200) {
                reject(xhr.responseText);
            }
        };

        if ((typeof data === 'undefined' ? 'undefined' : _typeof(data)) === 'object') {
            data = JSON.stringify(data);
        }

        xhr.send(data);
    });
};
// CONCATENATED MODULE: ./resources/assets/js/src/util/hash.js
var hashes = [];

function createUniqueHash() {
    var newHash = createHash();
    while (~hashes.indexOf(newHash)) {
        newHash = createHash();
    }

    hashes.push(newHash);
    return newHash;
}

function createHash() {
    return Math.random().toString(36).substr(2, 9);
}
// CONCATENATED MODULE: ./resources/assets/js/src/util/index.js





// EXTERNAL MODULE: ./node_modules/rxjs/_esm5/index.js + 18 modules
var _esm5 = __webpack_require__("./node_modules/rxjs/_esm5/index.js");

// EXTERNAL MODULE: ./node_modules/rxjs/_esm5/operators/index.js + 99 modules
var operators = __webpack_require__("./node_modules/rxjs/_esm5/operators/index.js");

// CONCATENATED MODULE: ./resources/assets/js/src/ui/accordion.js



var accordions = void 0;

var classes = {
    active: 'active',
    container: 'o-accordion__container'
};

function accordion_init() {
    accordions = document.querySelectorAll('.js-accordion');
    if (!accordions.length) {
        return;
    }

    accordions = Array.prototype.slice.call(accordions);
    accordions.forEach(function (el) {
        setAccordionContentHeight(el);
        if (!el.classList.contains(classes.active)) {
            return;
        }
        var container = el.querySelector('.' + classes.container);
        var height = el.dataset.accordionHeight;
        container.style.height = Math.ceil(height) + 'px';
    });

    addEventListeners();
}

function setAccordionContentHeight(accordionElement) {
    var cleanUp = false;

    if (!accordionElement.classList.contains('active')) {
        accordionElement.classList.add('active');
        cleanUp = true;
    }

    var container = accordionElement.querySelector('.' + classes.container);

    var _container$getBoundin = container.getBoundingClientRect(),
        height = _container$getBoundin.height;

    accordionElement.dataset.accordionHeight = height;

    if (cleanUp) {
        accordionElement.classList.remove('active');
    }
}

function addEventListeners() {
    Object(_esm5["fromEvent"])(document, 'click').pipe(Object(operators["filter"])(function (e) {
        return e.target.classList.contains('.js-accordion') || e.target.closest('.js-accordion');
    }), Object(operators["map"])(function (e) {
        return e.target.closest('.js-accordion');
    })).subscribe(handleClick);
}

function handleClick(accordion) {
    var container = accordion.querySelector('.' + classes.container);

    if (accordion.classList.contains(classes.active)) {
        accordion.classList.remove(classes.active);
        container.style.height = 0;
        return;
    }

    var height = accordion.dataset.accordionHeight;
    container.style.height = Math.ceil(height) + 'px';
    accordion.classList.add(classes.active);
}
// CONCATENATED MODULE: ./resources/assets/js/src/animation/easing.js
// Robert Penner's easeInOutQuad

// find the rest of his easing functions here: http://robertpenner.com/easing/
// find them exported for ES6 consumption here: https://github.com/jaxgeller/ez.js

function easeInOutQuad(t, b, c, d) {
    t /= d / 2;
    if (t < 1) {
        return c / 2 * t * t + b;
    }
    t--;
    return -c / 2 * (t * (t - 2) - 1) + b;
}

function easeOutQuad(t, b, c, d) {
    return -c * (t /= d) * (t - 2) + b;
}
// CONCATENATED MODULE: ./resources/assets/js/src/animation/events.js


var transitionEndEventNames = ['webkitTransitionEnd', 'transitionend', 'msTransitionEnd', 'oTransitionEnd'];
var animationEndEventName = ['animationend', 'webkitAnimationEnd', 'MSAnimationEnd', 'oAnimationEnd'];

var events_mapEventsToObservable = function mapEventsToObservable(eventNames) {
    return function (el) {
        var events = eventNames.map(function (name) {
            return Object(_esm5["fromEvent"])(el, name);
        });
        return _esm5["merge"].apply(null, events);
    };
};

var transitionEnd = events_mapEventsToObservable(transitionEndEventNames);
var animationEnd = events_mapEventsToObservable(animationEndEventName);
// CONCATENATED MODULE: ./resources/assets/js/src/animation/index.js




// CONCATENATED MODULE: ./resources/assets/js/src/ui/jump.js
var jump_typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };



var maxDuration = void 0,
    minDuration = void 0,
    maxDurHeight = void 0,
    wheelEventName = void 0,
    jmpTmpMaxDuration = void 0,
    jmpTmpMinDuration = void 0,
    optionsUser = void 0,
    jump_element = void 0,
    start = void 0,
    stop = void 0,
    jump_offset = void 0,
    easing = void 0,
    durationEasing = void 0,
    a11y = void 0,
    distance = void 0,
    duration = void 0,
    timeStart = void 0,
    timeElapsed = void 0,
    nextScroll = void 0,
    callback = void 0,
    animationID = void 0;

function jump_init(mxDur, mnDur, mxDurHeight) {
    minDuration = mnDur || 750;
    maxDuration = (mxDur || 1500) - minDuration;
    maxDurHeight = mxDurHeight || 5000;

    var pageHeight = getDocumentHeight() - getViewportHeight() * 0.5;

    if (maxDurHeight > pageHeight) {
        maxDurHeight = pageHeight;
    }

    easing = easeInOutQuad;
    durationEasing = easeOutQuad;
    a11y = false;

    if ('onwheel' in document.createElement('div')) {
        wheelEventName = 'wheel';
    } else {
        wheelEventName = document.onmousewheel !== undefined ? 'mousewheel' : 'DOMMouseScroll';
    }

    jump_addEventListeners();
}

function jump_addEventListeners() {
    document.addEventListener(wheelEventName, cancelAnimation, false);
}

function cancelAnimation() {
    if (animationID !== undefined) {
        cancelAnimationFrame(animationID);
        animationID = undefined;
        timeStart = false;
    }
}

function getDocumentHeight() {
    var body = document.body;
    var html = document.documentElement;

    return Math.max(body.scrollHeight, body.offsetHeight, html.scrollHeight, html.offsetHeight);
}

function getViewportHeight() {
    return Math.max(document.documentElement.clientHeight, window.innerHeight);
}

function jump_top(element) {
    return element.getBoundingClientRect().top + start;
}

function jump_location() {
    return window.scrollY || window.pageYOffset;
}

function loop(timeCurrent) {
    if (!timeStart) {
        timeStart = timeCurrent;
    }

    timeElapsed = timeCurrent - timeStart;

    nextScroll = easing(timeElapsed, start, distance, duration);

    window.scrollTo(0, nextScroll);

    if (timeElapsed < duration) {
        animationID = requestAnimationFrame(loop);
    } else {
        done();
    }
}

function done() {
    window.scrollTo(0, start + distance);

    if (jump_element && a11y) {
        jump_element.setAttribute('tabindex', '-1');
        jump_element.focus();
    }

    if (typeof callback === 'function') {
        callback();
    }

    if (optionsUser) {
        maxDuration = jmpTmpMaxDuration;
        minDuration = jmpTmpMinDuration;
        optionsUser = false;
    }

    animationID = undefined;
    timeStart = false;
}

function jump(target, cb, offset, options) {
    if (!target) {
        return;
    }

    if (options) {
        optionsUser = true;
        jmpTmpMaxDuration = maxDuration;
        jmpTmpMinDuration = minDuration;

        minDuration = options.minDuration || minDuration;
        maxDuration = options.maxDuration ? options.maxDuration - minDuration : maxDuration;
    }

    start = jump_location();
    callback = cb;
    offset = offset || 0;

    switch (typeof target === 'undefined' ? 'undefined' : jump_typeof(target)) {
        case 'number':
            jump_element = false;
            a11y = false;
            stop = start + target;
            break;

        case 'object':
            jump_element = target;
            stop = jump_top(jump_element);
            break;

        case 'string':
            jump_element = document.querySelector(target);
            stop = jump_top(jump_element);
            break;
    }

    if (jump_element) {
        var dataOffset = +jump_element.getAttribute('data-offset');
        if (dataOffset) {
            offset = dataOffset;
        }
        var dataMinDuration = +jump_element.getAttribute('data-min-duration');
        var dataMaxDuration = +jump_element.getAttribute('data-max-duration');
        minDuration = dataMinDuration || minDuration;
        maxDuration = dataMaxDuration ? dataMaxDuration - minDuration : maxDuration;
    }

    distance = stop - start + offset;
    var durDistance = Math.abs(distance);

    var distanceChange = durDistance / maxDurHeight;
    if (durDistance >= maxDurHeight) {
        distanceChange = 1;
    }

    var durationChangeRate = durationEasing(distanceChange, 0, 1, 1);
    duration = maxDuration * durationChangeRate + minDuration;

    cancelAnimation();
    animationID = requestAnimationFrame(loop);
}

/* harmony default export */ var ui_jump = ({
    init: jump_init,
    jump: jump
});
// CONCATENATED MODULE: ./resources/assets/js/src/ui/scroll-anim.js



var scrollAnimations = void 0,
    scrollAnimationKeys = void 0,
    activeClass = void 0,
    onloadAnimations = void 0,
    baseOffset = void 0;

function scroll_anim_init() {
    activeClass = 'scroll-active';
    baseOffset = 0.1;

    setupScrollAnimation();

    Object(_esm5["fromEvent"])(window, 'scroll').pipe(Object(operators["map"])(function () {
        return getCurrentTop() + window.innerHeight;
    })).subscribe(handleScroll);

    handleScroll(getCurrentTop() + window.innerHeight);
}

function setupScrollAnimation() {
    var scrollAnimationElements = document.querySelectorAll('.js-scroll-anim');
    scrollAnimationElements = Array.from(scrollAnimationElements);

    var blockquoteAnimationElements = document.querySelectorAll('.typography blockquote');
    blockquoteAnimationElements = Array.from(blockquoteAnimationElements);

    onloadAnimations = [];

    scrollAnimations = scrollAnimationElements.concat(blockquoteAnimationElements).reduce(function (acc, el) {
        if (el.classList.contains('onload')) {
            onloadAnimations.push(el);
            return acc;
        }

        var _el$getBoundingClient = el.getBoundingClientRect(),
            top = _el$getBoundingClient.top;

        var offset = el.dataset.scrollOffset || baseOffset;
        top = Math.round(top) + getCurrentTop() + offset * window.innerHeight;
        top = Math.max(top, 0);
        if (typeof acc[top] === 'undefined') {
            acc[top] = [];
        }
        acc[top].push(el);
        return acc;
    }, {});

    scrollAnimationKeys = Object.keys(scrollAnimations);
    scrollAnimationKeys.sort();

    if (onloadAnimations.length) {
        onloadAnimations.map(function (els) {
            els.map(function (el) {
                el.classList.add(activeClass);
            });
        });
    }
}

function handleScroll(scroll) {
    for (var i = 0; i < scrollAnimationKeys.length; i++) {
        var animScroll = scrollAnimationKeys[i];
        if (scroll >= animScroll) {
            scrollAnimations[scrollAnimationKeys[i]].map(function (el) {
                el.classList.add(activeClass);
            });
        }
    }
}

function getCurrentTop() {
    return window.scrollY || window.pageYOffset;
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/modal.js



var modalController = {
    modalContainer: null,
    modals: {},
    currentOpenModal: null,
    template: null,
    openModal: openModal,
    closeModal: closeModal,
    addModal: addModal
};

function setupModals() {
    var container = document.querySelector('.js-modal-container');
    if (!container) {
        return;
    }

    modalController.openModal = modalController.openModal.bind(modalController);
    modalController.closeModal = modalController.closeModal.bind(modalController);
    modalController.addModal = modalController.addModal.bind(modalController);

    modalController.template = document.querySelector('.js-modal-template');
    if (!modalController.template) {
        return;
    }
    modalController.template = modalController.template.innerHTML;

    modalController.modalContainer = container;
    var modals = modalController.modalContainer.querySelectorAll('[data-modal-item-id]');
    modals = Array.from(modals);
    modals.forEach(function (el) {
        var key = el.dataset.modalItemId;
        modalController.addModal(key, el);
    });

    if (typeof window.modals !== 'undefined') {
        window.modals.forEach(function (el) {
            if (el.content) {
                modalController.addModal(el.id, el.content);
            }
            if (el.open) {
                modalController.openModal(el.id);
            }
        });
    }

    Object(_esm5["fromEvent"])(document, 'click').pipe(Object(operators["filter"])(function (el) {
        return !!el.target.dataset.modalId;
    }), Object(operators["map"])(function (el) {
        return el.target.dataset.modalId;
    })).subscribe(modalController.openModal);

    Object(_esm5["merge"])(Object(_esm5["fromEvent"])(document, 'click').pipe(Object(operators["filter"])(function (el) {
        return el.target.classList.contains('js-modal-close');
    })));

    Object(_esm5["fromEvent"])(modalController.modalContainer, 'click').subscribe(modalController.closeModal);
}

function openModal(modalID) {
    if (!this.modals[modalID]) {
        console.warn('No Modal find with id: ' + modalID);
        return;
    }

    if (!this.modalContainer.classList.contains('active')) {
        this.modalContainer.classList.add('active');
    }

    if (this.currentOpenModal) {
        if (this.currentOpenModal === this.modals[modalID]) {
            return;
        } else {
            this.currentOpenModal.classList.remove('active');
        }
    }

    this.currentOpenModal = this.modals[modalID];
    this.currentOpenModal.classList.add('active');
}

function closeModal() {
    this.modalContainer.classList.remove('active');
    this.currentOpenModal.classList.remove('active');
    this.currentOpenModal = null;
}

function addModal(key, content) {
    var element = void 0;
    if (typeof content === 'string') {
        element = createModal(key, content, modalController);
    } else {
        element = content;
    }

    modalController.modals[key] = element;

    var closeBtn = element.querySelector('.js-modal-close');
    if (closeBtn) {
        Object(_esm5["fromEvent"])(closeBtn, 'click').subscribe(modalController.closeModal);
    }

    element.addEventListener('click', function (evt) {
        evt.stopPropagation();
    });

    if (element.classList.contains('active')) {
        modalController.currentOpenModal = modalController.modals[key];
    }
}

function createModal(id, content, controller) {
    var html = controller.template.replace(/{id}/, id).replace(/{content}/, content);
    var div = document.createElement('div');
    div.innerHTML = html;
    controller.modalContainer.appendChild(div.firstElementChild);
    return controller.modalContainer.querySelector('[data-modal-item-id=' + id + ']');
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/smoothscroll.js


var pageUrl = void 0;

function smoothscroll_init() {
    ui_jump.init();

    pageUrl = location.hash ? stripHash(location.href) : location.href;
}

function onClick(e) {
    if (!isInPageLink(e.target)) {
        return;
    }

    e.stopPropagation();
    e.preventDefault();

    var offset = 0;
    var options = {};

    ui_jump.jump(e.target.hash, null, offset, options);
}

function isInPageLink(n) {
    if (!n.tagName) {
        return false;
    }
    return n.tagName.toLowerCase() === 'a' && n.hash.length > 0 && stripHash(n.href) === pageUrl;
}

function stripHash(url) {
    return url.slice(0, url.lastIndexOf('#'));
}

/* harmony default export */ var smoothscroll = ({
    init: smoothscroll_init,
    onClick: onClick
});
// CONCATENATED MODULE: ./resources/assets/js/src/ui/sticky-bars.js



function sticky_bars_init() {
    var selectors = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
    var requireAllToExist = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

    var stickyElements = setupStickElements(selectors);
    var scrollPositions = Object.keys(stickyElements).sort(function (a, b) {
        return a - b;
    });
    var elementCount = scrollPositions.reduce(function (acc, key) {
        return acc + stickyElements[key].length;
    }, 0);

    if (!elementCount || requireAllToExist && elementCount != selectors.length) {
        return;
    }

    scrollPositions.forEach(function (pos) {
        return stickyElements[pos].forEach(function (obj) {
            obj.el.classList.add('toBeSticky');
        });
    });

    var lastStickiedPos = 0;

    var testScroll = function testScroll(scroll) {
        scrollPositions.forEach(function (pos) {
            stickyElements[pos].forEach(function (obj) {
                if (+pos <= scroll) {
                    lastStickiedPos = pos;
                }

                if (+pos <= scroll && !obj.el.classList.contains('sticky')) {
                    obj.el.classList.add('sticky');
                    obj.el.parentNode.style.height = obj.cbr.height + 'px';
                    obj.stickiedCB && obj.stickiedCB(obj);
                } else if (+pos > scroll && obj.el.classList.contains('sticky')) {
                    obj.el.classList.remove('sticky');
                    obj.el.parentNode.style.height = '';
                    obj.unstickiedCB && obj.unstickiedCB(obj);
                }
            });
        });

        scrollPositions.forEach(function (pos) {
            stickyElements[pos].forEach(function (obj) {
                if (+pos < lastStickiedPos && !obj.el.classList.contains('old-sticky')) {
                    obj.el.classList.add('old-sticky');
                } else if (+pos >= lastStickiedPos && obj.el.classList.contains('old-sticky')) {
                    obj.el.classList.remove('old-sticky');
                }
            });
        });
    };

    Object(_esm5["fromEvent"])(window, 'scroll').pipe(Object(operators["map"])(function () {
        return currentScroll();
    })).subscribe(testScroll);

    testScroll(currentScroll());
}

function currentScroll() {
    return window.scrollY || window.pageYOffset;
}

function setupStickElements() {
    var selectors = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];

    return selectors.reduce(function (acc, selector) {
        if (typeof selector === 'string') {
            selector = [selector, null, null];
        }

        var element = document.querySelector(selector[0]);
        if (!element) {
            return acc;
        }

        var cbr = element.getBoundingClientRect();
        var elementPos = cbr.top + currentScroll();

        if (typeof acc[elementPos] === 'undefined') {
            acc[elementPos] = [];
        }

        acc[elementPos].push({
            el: element,
            cbr: cbr,
            stickiedCB: selector[1],
            unstickiedCB: selector[2]
        });
        return acc;
    }, {});
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/video.js
var videos = void 0;

function video_init() {
    var tag = document.createElement('script');
    tag.src = 'https://www.youtube.com/iframe_api';
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    videos = document.querySelectorAll('.js-video');
    videos = Array.prototype.slice.call(videos);
    videos = videos.map(function (el) {
        var videoContainer = el.querySelector('[data-youtube-id]');
        var videoID = videoContainer.dataset.youtubeId;
        var playBtn = el.querySelector('.js-video-btn');

        return {
            el: videoContainer,
            videoID: videoID,
            player: null,
            play: function play() {},
            playBtn: playBtn
        };
    });
}

function onYouTubeIframeAPIReady() {
    videos = videos.map(function (video) {
        video.player = new window.YT.Player(video.el, {
            height: 540,
            width: 360,
            videoId: video.videoID,
            playerVars: {
                modestbranding: 1,
                rel: 0,
                showinfo: 0,
                widget_referrer: window.location.href
            },
            events: {
                onReady: function onReady(evt) {
                    video.play = evt.target.playVideo.bind(evt.target);
                }
            }
        });

        if (video.playBtn) {
            video.playBtn.addEventListener('click', function () {
                if (!video.play) {
                    return;
                }

                video.playBtn.classList.add('is-active');
                video.play();
            });
        }

        return video;
    });
}
window.onYouTubeIframeAPIReady = onYouTubeIframeAPIReady;
// CONCATENATED MODULE: ./resources/assets/js/src/ui/map.js
var hasRenderedMap = false;

function map_init() {
    if (!hasRenderedMap) {
        setTimeout(function () {
            !hasRenderedMap && initMap();
        }, 1250);
    }
}

function initMap() {
    if (typeof window.google === 'undefined') {
        return;
    }

    var mapElements = document.querySelector('.js-map');
    if (!mapElements) {
        return;
    }

    var _mapElements$dataset = mapElements.dataset,
        lat = _mapElements$dataset.lat,
        lng = _mapElements$dataset.lng;
    var _window$google$maps = window.google.maps,
        Map = _window$google$maps.Map,
        Marker = _window$google$maps.Marker;

    var latLng = { lat: +lat || 51.2352025, lng: +lng || -1.119185 };
    var center = {
        lat: latLng.lat,
        lng: latLng.lng
    };
    if (window.innerWidth <= 786) {
        center = latLng;
    }
    var customIcon = {
        path: 'M7,0C3.1,0,0,3.1,0,7s7,13,7,13s7-9.1,7-13S10.9,0,7,0z M7,9.75C5.46,9.75,4.25,8.54,4.25,7S5.46,4.25,7,4.25S9.75,5.46,9.75,7S8.54,9.75,7,9.75z',
        anchor: new window.google.maps.Point(7, 20),
        fillColor: '#df1e24',
        fillOpacity: 1,
        scale: 2.5,
        strokeOpacity: 0
    };

    var map = new Map(mapElements, {
        zoom: 15,
        center: center,
        scrollwheel: false,
        gestureHandling: 'cooperative'
    });

    new Marker({
        position: latLng,
        map: map,
        title: 'Benyon Estate',
        icon: customIcon
    });

    hasRenderedMap = true;
}
window.initMap = initMap;
// CONCATENATED MODULE: ./resources/assets/js/src/ui/sidebar.js



var sidebar = void 0;

function sidebar_init() {
    sidebar = document.querySelector('.js-sidebar');
    if (!sidebar) {
        return;
    }

    Object(_esm5["fromEvent"])(sidebar, 'mouseenter').subscribe(openNav);
    Object(_esm5["fromEvent"])(sidebar, 'mouseleave').subscribe(closeNav);
}

function openNav() {
    sidebar.classList.add('active');
}

function closeNav() {
    sidebar.classList.remove('active');
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/confirm-btns.js



var Confirm = {
    el: null,
    duplicateCB: function duplicateCB(_) {},
    deleteCB: function deleteCB(_) {},
    currentQuestion: '',
    destroy: destroy,
    events: {}
};

function confirm_btns_confirm(el, duplicateCB, deleteCB) {
    var Obj = Object.create(Confirm);
    confirm_btns_init.call(Obj, el, duplicateCB, deleteCB);
    return Obj;
}

function confirm_btns_init(el, duplicateCB, deleteCB) {
    if (!el) {
        return;
    }

    this.el = el;
    this.duplicateCB = duplicateCB;
    this.deleteCB = deleteCB;
    this.destroy = this.destroy.bind(this);

    setupEvents.call(this);
}

function setupEvents() {
    var _this = this;

    var click = Object(_esm5["fromEvent"])(this.el, 'click');

    this.events.question = click.pipe(Object(operators["filter"])(function (evt) {
        return evt.target.dataset.question;
    }), Object(operators["map"])(function (evt) {
        return evt.preventDefault(), evt;
    }), Object(operators["map"])(function (evt) {
        return evt.target.dataset.question;
    })).subscribe(function (question) {
        _this.currentQuestion = question;
        if (_this.currentQuestion === 'duplicate') {
            _this.duplicateCB();
        } else {
            _this.el.classList.add('is-active');
        }
    });

    var accept = click.pipe(Object(operators["filter"])(function (evt) {
        return evt.target.classList.contains('js-confirm-accept');
    }), Object(operators["map"])(function (evt) {
        return evt.preventDefault(), evt;
    }), Object(operators["map"])(function (_) {
        return true;
    }));

    var decline = click.pipe(Object(operators["filter"])(function (evt) {
        return evt.target.classList.contains('js-confirm-decline');
    }), Object(operators["map"])(function (evt) {
        return evt.preventDefault(), evt;
    }), Object(operators["map"])(function (_) {
        return false;
    }));

    this.events.confirm = Object(_esm5["merge"])(accept, decline).subscribe(function (accept) {
        if (accept) {
            switchOnQuestion.call(_this);
        }
        _this.el.classList.remove('is-active');
    });
}

function switchOnQuestion() {
    switch (this.currentQuestion) {
        case 'duplicate':
            this.duplicateCB();
            break;
        case 'delete':
            this.deleteCB();
            break;
    }
}

function destroy() {
    this.events.question.unsubscribe();
    this.events.confirm.unsubscribe();
}
// EXTERNAL MODULE: ./node_modules/dragula/dragula.js
var dragula = __webpack_require__("./node_modules/dragula/dragula.js");
var dragula_default = /*#__PURE__*/__webpack_require__.n(dragula);

// CONCATENATED MODULE: ./resources/assets/js/src/form/file-input.js
function createFileInputs() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;

    var fileInputEls = context.querySelectorAll('.js-file');
    var fileInputs = Array.from(fileInputEls);
    fileInputs.forEach(function (input) {
        return createFileInput(input);
    });
}

function createFileInput(input) {
    var label = input.querySelector('.o-file-upload__name');
    var labelVal = label.innerHTML;

    input.addEventListener('change', function (evt) {
        var fileName = '';
        if (evt.target.files) {
            fileName = evt.target.value.split('\\').pop();
        }

        if (fileName) {
            label.innerHTML = fileName;
        } else {
            label.innerHTML = labelVal;
        }
    });
}
// CONCATENATED MODULE: ./resources/assets/js/src/form/controller.js






var Controller = {
    el: null,
    inputs: [],
    errorMessageEl: null,

    inputKeys: [],
    isFormDirty: false,
    action: '',

    onErrorEvent: null,
    onSucccessEvent: null,

    onError: null,
    onSucccess: null,

    init: controller_init,
    resetFormErrors: resetFormErrors
};

function createController(selector, onSucccess, onError) {
    var Obj = Object.create(Controller);
    Obj.init(selector, onSucccess, onError);
    return Obj;
}

function controller_init(selector, onSucccess, onError) {
    if (typeof selector === 'string') {
        this.el = document.querySelector(selector);
    } else {
        this.el = selector;
    }

    if (!this.el) {
        return;
    }

    this.errorMessageEl = this.el.querySelector('.js-form-errros');
    this.inputs = this.el.querySelectorAll('[name]');
    this.inputs = Array.from(this.inputs);
    this.inputs = this.inputs.reduce(function (acc, input) {
        if (acc[input.name]) {
            return acc;
        }

        acc[input.name] = input;
        return acc;
    }, {});

    this.inputKeys = Object.keys(this.inputs);
    this.action = this.el.action;

    this.onErrorEvent = new _esm5["Subject"]();
    this.onSucccessEvent = new _esm5["Subject"]();

    this.onError = onError || handleError;
    this.onSucccess = onSucccess || handleReturn;
    this.onError = this.onError.bind(this);
    this.onSucccess = this.onSucccess.bind(this);
    this.resetFormErrors = this.resetFormErrors.bind(this);

    this.onErrorEvent.subscribe(this.onError);
    this.onSucccessEvent.subscribe(this.onSucccess);

    this.el.addEventListener('submit', handleSubmit.bind(this));

    resetFormErrors.call(this);

    Object(_esm5["fromEvent"])(document, 'click').pipe(Object(operators["filter"])(function (el) {
        return el.target.classList.contains('js-form-reset');
    }), Object(operators["map"])(function (evt) {
        return evt.stopPropagation(), evt;
    })).subscribe(resetForm.bind(this));
}

function handleSubmit(evt) {
    var _this = this;

    evt.preventDefault();

    var formData = getFormValueObj.call(this);

    post(this.action, formData).then(function (data) {
        return JSON.parse(data);
    }).then(function (data) {
        _this.onSucccessEvent.next({ data: data, formData: formData });
    }).catch(function (err) {
        _this.onErrorEvent.next(err);
    });
}

function handleReturn(_ref) {
    var _this2 = this;

    var data = _ref.data;

    if (!data) {
        return;
    }

    if (data.success) {
        modalController.openModal('ThankYou');
        resetFormErrors.call(this);
        return;
    }

    this.errorMessageEl.innerHTML = '<p>' + data.msg + '</p>';
    this.errorMessageEl.classList.add('active');

    var errorKeys = Object.keys(data.fields);
    errorKeys.forEach(function (key) {
        if (!~_this2.inputKeys.indexOf(key)) {
            return;
        }

        var el = _this2.inputs[key];
        var formGroupEl = el.closest('.o-form__group');
        if (!formGroupEl) {
            return;
        }

        var message = formGroupEl.querySelector('.o-form__group-message label');
        if (message) {
            message.innerHTML = data.fields[key];
        }

        formGroupEl.classList.add('error');
    });
}

function handleError() {
    handleReturn.call({
        success: false,
        msg: 'There was an issue connecting to the server, please try again.',
        fields: {}
    });
}

function resetFormErrors() {
    var _this3 = this;

    this.isFormDirty = false;
    this.errorMessageEl.classList.remove('active');
    this.errorMessageEl.innerHTML = '';
    this.inputKeys.forEach(function (key) {
        var el = _this3.inputs[key];
        var formGroupEl = el.closest('.o-form__group');
        if (!formGroupEl) {
            return;
        }

        var message = formGroupEl.querySelector('.o-form__group-message label');
        if (message) {
            message.innerHTML = '';
        }

        formGroupEl.classList.remove('error');
    });
}

function resetForm() {
    this.el.reset();
}

function getFormValueObj() {
    var _this4 = this;

    return this.inputKeys.reduce(function (acc, key) {
        var value = '';
        var input = _this4.inputs[key];
        if (!input) {
            return;
        }

        if (input.type === 'checkbox') {
            value = input.checked;
        } else {
            value = input.value;
        }

        acc[key] = value;

        return acc;
    }, {});
}
// CONCATENATED MODULE: ./resources/assets/js/src/form/toggle.js



var toggleValueClass = '.js-toggle-value';
var toggleInputClass = 'js-toggle-input';

function toggle_init() {
    Object(_esm5["fromEvent"])(document, 'change').pipe(Object(operators["filter"])(function (evt) {
        return evt.target.classList.contains(toggleInputClass);
    })).subscribe(function (evt) {
        var isChecked = evt.target.checked;
        var valueInput = evt.target.parentNode.parentNode.querySelector(toggleValueClass);
        valueInput.value = isChecked ? 1 : 0;
    });
}
// EXTERNAL MODULE: ./node_modules/choices.js/assets/scripts/dist/choices.min.js
var choices_min = __webpack_require__("./node_modules/choices.js/assets/scripts/dist/choices.min.js");
var choices_min_default = /*#__PURE__*/__webpack_require__.n(choices_min);

// CONCATENATED MODULE: ./resources/assets/js/src/form/select.js


function createSelects() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;

    var selectHtmlList = context.querySelectorAll('.js-select');
    var selectList = Array.from(selectHtmlList);
    selectList = selectList.map(function (el) {
        return createSelect(el);
    });
    return selectList;
}

function createSelect(el) {
    var value = el.dataset.value;

    var items = [];

    if (value) {
        items = JSON.parse(value);
    }

    var select = new choices_min_default.a(el, {
        searchEnabled: false,
        searchChoices: false,
        paste: false,
        shouldSort: false,
        removeItemButton: true,
        placeholderValue: 'select',
        itemSelectText: '',
        callbackOnCreateTemplates: function callbackOnCreateTemplates(template) {
            var classNames = this.config.classNames;
            return {
                containerInner: function containerInner() {
                    return template('\n                    <div class="' + classNames.containerInner + '">\n                        <div class="choices__btn">\n                            <svg><use xlink:href="/argon/images/svgicons.svg#select"></use></svg>\n                        </div>\n                    </div>\n                ');
                }
            };
        }
    });

    el.choices = select;
    select.setValueByChoice(items);
    return select;
}
// CONCATENATED MODULE: ./resources/assets/js/src/form/item-picker.js



var item_picker_itemPickers = [];
var ItemPicker = {
    el: null,
    btn: null,
    input: null,
    window: null,
    list: null,
    output: null,

    isColor: false,
    svgPath: ''
};

function createItemPickers() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;

    var itemPickerEls = context.querySelectorAll('.js-item-picker');
    item_picker_itemPickers = Array.from(itemPickerEls);
    item_picker_itemPickers = item_picker_itemPickers.map(function (el) {
        return createItemPicker(el);
    });
    return item_picker_itemPickers;
}

function createItemPicker(el) {
    var Obj = Object.create(ItemPicker);
    item_picker_init.call(Obj, el);
    return Obj;
}

function item_picker_init(el) {
    if (typeof el === 'string') {
        this.el = document.querySelector(el);
    } else {
        this.el = el;
    }

    if (!this.el) {
        return;
    }

    var _el$dataset = this.el.dataset,
        color = _el$dataset.color,
        path = _el$dataset.path;


    this.btn = this.el.querySelector('.js-item-picker-btn');
    this.input = this.el.querySelector('.js-item-picker-input');
    this.window = this.el.querySelector('.js-item-picker-window');
    this.list = this.el.querySelector('.js-item-picker-list');
    this.output = this.el.querySelector('.js-item-picker-output');
    this.isColor = color === 'true';
    this.svgPath = path;

    if (this.isColor) {
        this.btn.style.backgroundColor = this.input.value;
    }

    if (this.output) {
        this.output.value = this.input.value;
    }

    setupItems.call(this);
    item_picker_setupEvents.call(this);
}

function setupItems() {
    var _this = this;

    if (!this.window) {
        return;
    }

    var items = Array.from(this.list.children);
    items.forEach(function (item) {
        var value = item.dataset.value;

        if (_this.isColor) {
            item.title = value;
            item.style.backgroundColor = value;
        } else if (_this.svgPath) {
            item.innerHTML = '<svg><use xlink:href="' + (_this.svgPath + value) + '"></use></svg>';
        }
    });
}

function item_picker_setupEvents() {
    var _this2 = this;

    Object(_esm5["merge"])(Object(_esm5["fromEvent"])(this.input, 'keyup'), Object(_esm5["fromEvent"])(this.input, 'change')).subscribe(function () {
        _this2.btn.style.backgroundColor = _this2.input.value;
    });

    if (this.window) {
        Object(_esm5["fromEvent"])(this.list, 'click').pipe(Object(operators["filter"])(function (evt) {
            return evt.target.dataset.value;
        }), Object(operators["map"])(function (evt) {
            return evt.target.dataset.value;
        })).subscribe(function (value) {
            setValue.call(_this2, value);
            closeWindow.call(_this2);
        });

        Object(_esm5["merge"])(Object(_esm5["fromEvent"])(this.btn, 'click'), Object(_esm5["fromEvent"])(this.el, 'click').pipe(Object(operators["filter"])(function (evt) {
            return evt.target.classList.contains('js-item-picker-drop-btn');
        }))).subscribe(toggleOpenWindow.bind(this));
        Object(_esm5["merge"])(Object(_esm5["fromEvent"])(this.input, 'click'), Object(_esm5["fromEvent"])(this.input, 'focus')).subscribe(openWindow.bind(this));
        if (this.output) {
            Object(_esm5["fromEvent"])(this.output, 'click').subscribe(openWindow.bind(this));
        }
        Object(_esm5["fromEvent"])(this.window, 'click').pipe(Object(operators["filter"])(function (evt) {
            return evt.target.classList.contains('js-item-picker-close');
        })).subscribe(closeWindow.bind(this));
    }
}

function setValue(value) {
    this.input.value = value;

    if (this.isColor) {
        this.btn.style.backgroundColor = value;
    } else if (this.svgPath) {
        this.btn.innerHTML = '<svg><use xlink:href="' + (this.svgPath + value) + '"></use></svg>';
    }

    if (this.output) {
        this.output.value = this.input.value;
    }
}

function toggleOpenWindow() {
    if (!this.window) {
        return;
    }

    if (this.el.classList.contains('is-open')) {
        closeWindow.call(this);
    } else {
        openWindow.call(this);
    }
}

function closeWindow() {
    if (!this.window) {
        return;
    }
    this.el.classList.remove('is-open');
}

function openWindow() {
    var _this3 = this;

    this.el.classList.add('is-open');

    item_picker_itemPickers.filter(function (el) {
        return el !== _this3;
    }).forEach(function (el) {
        closeWindow.call(el);
    });
}
// EXTERNAL MODULE: ./node_modules/flatpickr/dist/flatpickr.js
var flatpickr = __webpack_require__("./node_modules/flatpickr/dist/flatpickr.js");
var flatpickr_default = /*#__PURE__*/__webpack_require__.n(flatpickr);

// CONCATENATED MODULE: ./resources/assets/js/src/form/date.js


function createDates() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;

    var dateEls = context.querySelectorAll('.js-date');
    var dates = Array.from(dateEls);
    dates = dates.map(function (el) {
        return createDate(el);
    });
    return dates;
}

function createDate(el) {
    var _el$dataset = el.dataset,
        time = _el$dataset.time,
        defaultToday = _el$dataset.defaultToday,
        range = _el$dataset.range;

    var value = el.value;

    var altFormat = 'd F, Y';
    if (time === 'true') {
        altFormat = 'd F, Y h:i K';
    }

    var defaultDate = null;
    if (defaultToday && !value) {
        defaultDate = new Date();
    }

    var mode = 'single';
    if (range === 'true') {
        mode = 'range';
    }

    return flatpickr_default()(el, {
        enableTime: time === 'true',
        dateFormat: 'Y-m-d H:i:S',
        altInput: true,
        altFormat: altFormat,
        mode: mode,
        defaultDate: defaultDate
    });
}
// CONCATENATED MODULE: ./resources/assets/js/src/form/time.js


function createTimes() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;

    var timeEles = context.querySelectorAll('.js-time');
    var times = Array.from(timeEles);
    times = times.map(function (el) {
        return createTime(el);
    });
    return times;
}

function createTime(el) {
    var defaultNow = el.dataset.defaultNow;


    var defaultDate = null;
    if (defaultNow) {
        defaultDate = new Date();
    }

    return flatpickr_default()(el, {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i:S',
        altInput: true,
        altFormat: 'h:i K',
        defaultDate: defaultDate,
        mode: 'time'
    });
}

function cleanContainerTime(el) {
    el.querySelector('.cke').remove();
}
// CONCATENATED MODULE: ./resources/assets/js/src/form/wysiwyg.js


var CKEDITOR_CONFIG = {
    language: 'en-gb',
    customConfig: '',
    filebrowserBrowseUrl: '/admin/media/modal/all',
    toolbar: [['Format', 'Styles', 'TextColor', '-', 'Bold', 'Italic', 'RemoveFormat', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'Image', 'Blockquote', '-', 'Source', 'Maximize']],
    height: 150,
    format_tags: 'p;h1;h2;h3;h4',
    extraAllowedContent: 'iframe[*]',
    colorButton_colors: '',
    colorButton_enableAutomatic: false,
    colorButton_enableMore: false,
    contentCss: '', // iframe styles
    stylesSet: [],
    extraPlugins: 'stylesheetparser'
};

var textareas = [];

function createEditors() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;

    var textareaEls = context.querySelectorAll('.js-wysiwyg');

    var baseConfig = setupGlobalConfig();
    return Array.from(textareaEls).map(function (el) {
        return createEditor(el, baseConfig);
    });
}

function createEditor(el, baseConfig) {
    var config = getElementConfig(el, baseConfig);

    var editor = CKEDITOR.replace(el, config);
    textareas.push(editor);
    return editor;
}

function getElementConfig(el, config) {
    var elConfig = {};
    var _el$dataset = el.dataset,
        formatTags = _el$dataset.formatTags,
        colors = _el$dataset.colors,
        stylesSet = _el$dataset.stylesSet,
        extraAllowedContent = _el$dataset.extraAllowedContent,
        toolbar = _el$dataset.toolbar,
        height = _el$dataset.height;


    var removeToolbarItems = [];

    if (formatTags) {
        elConfig.format_tags = formatTags;
    }

    if (colors) {
        if (colors === 'false') {
            removeToolbarItems.push('TextColor');
        } else {
            elConfig.colorButton_colors = colors;
        }
    }

    if (stylesSet) {
        if (stylesSet === 'false') {
            removeToolbarItems.push('Styles');
        } else {
            elConfig.stylesSet = JSON.parse(stylesSet);
        }
    }

    if (extraAllowedContent) {
        elConfig.extraAllowedContent = extraAllowedContent;
    }

    if (height) {
        elConfig.height = height;
    }

    if (toolbar) {
        elConfig.toolbar = [toolbar.split(',')];
    }

    config = Object.assign(config, elConfig);
    if (removeToolbarItems.length) {
        config.toolbar[0] = config.toolbar[0].filter(function (item) {
            return !~removeToolbarItems.indexOf(item);
        });
    }

    return config;
}

function updateAllElements() {
    textareas.forEach(function (el) {
        el.updateElement();
    });
}

function setupGlobalConfig() {
    var config = window.wysiwygConfig || {};
    return Object.assign(CKEDITOR_CONFIG, config);
}

function removeEditor(el) {
    textareas = textareas.filter(function (editor) {
        return editor !== el;
    });
    el.destroy();
}

function processWysiwygEditors() {
    var cke = CKEDITOR.instances;
    for (var i in cke) {
        cke[i].updateElement();
        if (i.indexOf('[]') === -1) {
            var field = document.querySelector('[name="' + i + '"]');
            if (field) {
                field.name = field.name.replace(/[^\[]*(?:\]$)/, ']');
            }
        }
    }
    // for (let i in cke) {
    //     cke[i].updateElement()
    //     if (i.indexOf('wysiwyg-') !== -1){
    //         let field = document.querySelector('[name="' + i + '"]')
    //         if (field) {
    //             field.name = field.name.replace(/wysiwyg-[^\]]*/, '')
    //         }
    //     }
    // }
}
// CONCATENATED MODULE: ./resources/assets/js/src/form/drag-select.js


var DragSelect = {
    el: null,
    input: null,
    select: null,
    inactiveColumn: null,
    activeColumn: null,
    drag: null,
    values: null

};

function createDragSelects() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;

    var dragEls = context.querySelectorAll('.js-drag');
    var dragSelects = Array.from(dragEls);
    dragSelects = dragSelects.map(function (el) {
        return createDragSelect(el);
    });
    return dragSelects;
}

function createDragSelect(el) {
    var Obj = Object.create(DragSelect);
    drag_select_init.call(Obj, el);
    return Obj;
}

function drag_select_init(el) {
    if (typeof el === 'string') {
        this.el = document.querySelector(el);
    } else {
        this.el = el;
    }

    if (!this.el) {
        return;
    }

    this.input = this.el.querySelector('.js-drag-input');
    this.select = this.el.querySelector('.js-drag-select');
    this.inactiveColumn = this.el.querySelector('.js-drag-inactive');
    this.activeColumn = this.el.querySelector('.js-drag-active');
    this.values = [];

    setupIntialValues.call(this);
    setupDrag.call(this);
    drag_select_setupEvents.call(this);
}

function setupDrag() {
    this.drag = dragula_default()([this.inactiveColumn, this.activeColumn], {
        revertOnSpill: true,
        removeOnSpill: false,
        moves: function moves(el) {
            return el.dataset.value;
        }
    });
}

function drag_select_setupEvents() {
    var _this = this;

    this.drag.on('drop', function (el, target, source, sibling) {
        if (target === _this.activeColumn && source !== _this.activeColumn) {
            var siblingValue = sibling && sibling.dataset.value || false;
            addItem.call(_this, el.dataset.value, siblingValue);
        }

        if (source === _this.activeColumn) {
            var _siblingValue = sibling && sibling.dataset.value || false;
            removeItem.call(_this, el.dataset.value);
            addItem.call(_this, el.dataset.value, _siblingValue);
        }

        if (target === _this.inactiveColumn) {
            removeItem.call(_this, el.dataset.value);
        }

        updateValues.call(_this);
    });
}

function addItem(value, siblingValue) {
    if (siblingValue) {
        var index = this.values.indexOf(siblingValue);

        this.values.splice(index, 0, value);
    } else {
        this.values.push(value);
    }
}

function removeItem(value) {
    this.values = this.values.filter(function (el) {
        return el !== value;
    });
}

function updateValues() {
    var _this2 = this;

    var optionsLength = this.select.options.length;
    if (optionsLength) {
        for (var i = 0; i < optionsLength; i++) {
            this.select.remove(0);
        }
    }

    this.values.forEach(function (value) {
        _this2.select.add(new Option(value, value, true, true));
    });
}

function setupIntialValues() {
    var _this3 = this;

    if (!this.input.value) {
        return;
    }

    Array.from(this.activeColumn.children).forEach(function (el) {
        _this3.inactiveColumn.appendChild(el);
    });

    this.values = JSON.parse(this.input.value);
    this.values.forEach(function (activeValue) {
        var item = _this3.inactiveColumn.querySelector('[data-value="' + activeValue + '"]');
        if (!item) {
            return;
        }

        _this3.activeColumn.appendChild(item);
    });

    updateValues.call(this);
}
// CONCATENATED MODULE: ./resources/assets/js/src/form/media-input.js



var MediaInput = {
    el: null,
    type: null,
    thumb: null,
    // filepath: null,
    src: null,
    alt: null,
    width: null,
    height: null,
    selectBtn: null
};

function createMediaInputs() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;

    var mediaImageEls = context.querySelectorAll('.js-media-image');
    var mediaFileEls = context.querySelectorAll('.js-media-file');
    var mediaImages = Array.from(mediaImageEls);
    var mediaFiles = Array.from(mediaFileEls);
    mediaImages.forEach(function (input) {
        return createMediaInput(input, 'image');
    });
    mediaFiles.forEach(function (input) {
        return createMediaInput(input, 'file');
    });
}

function createMediaInput(input, type) {
    var Obj = Object.create(MediaInput);
    media_input_init.call(Obj, input, type);
    return Obj;
}

function media_input_init(input, type) {
    var _this = this;

    if (!input) {
        return;
    }

    this.id = input.querySelector('[data-input-item-name=id]');
    this.url = input.querySelector('[data-input-item-name=url]');
    // this.filepath = input.querySelector('.js-media-input-filepath')
    this.selectBtn = input.querySelector('.js-media-input-select');
    this.type = type;

    if (type === 'image') {
        this.thumb = input.querySelector('.js-media-input-preview');
        this.width = input.querySelector('[data-input-item-name=width]');
        this.height = input.querySelector('[data-input-item-name=height]');
        var alt = input.querySelector('[data-input-item-name=alt]').value;
    }

    updateThumb.call(this);

    Object(_esm5["fromEvent"])(this.selectBtn, 'click').pipe(Object(operators["map"])(function (evt) {
        evt.preventDefault();
        return evt;
    })).subscribe(function () {
        spawnMediaLibModal().then(setValues.bind(_this));
    });
}

function setValues(values) {
    this.id.value = values.id;
    this.url.value = values.url;

    if (this.type === 'image') {

        this.width.value = values.width;
        this.height.value = values.height;
    }

    updateThumb.call(this);
}

function updateThumb() {
    if (this.type === 'image') {
        this.thumb.src = this.url.value;
        this.thumb.alt = '';
    }
    // else {
    //     this.filepath.innerHTML = this.url.value
    // }
}

function spawnMediaLibModalForFile() {
    return spawnMediaLibModal('file');
}

function spawnMediaLibModalForImage() {
    return spawnMediaLibModal('image');
}

function spawnMediaLibModal(type) {
    return new Promise(function (res) {
        $('#medialib').off('hidden.bs.modal');
        $('#medialib').on('hidden.bs.modal', function () {
            var id = $(this).data('mlselect');
            var mediaValueObj = void 0;
            // data.values

            $.ajax(argon.root() + '/media/items/' + id).done(function (r) {

                if (type === 'image') {
                    mediaValueObj = {
                        id: r.id,
                        url: r.url,
                        width: r.meta.width,
                        height: r.meta.height,
                        alt: ''
                    };
                } else {
                    mediaValueObj = {
                        id: r.id,
                        url: r.url
                    };
                }

                res(mediaValueObj);
            });
        });

        $('#medialib').modal();
    });
}
// CONCATENATED MODULE: ./resources/assets/js/src/form/index.js












function registerFormSaveEvents() {
    var savePublishBtn = document.querySelector(".js-save");
    if (!savePublishBtn) {
        return;
    }

    Object(_esm5["fromEvent"])(savePublishBtn, 'click').subscribe(function (el) {
        processWysiwygEditors();
    });
}

function initialiseFormElements() {
    toggle_init();
    var selects = createSelects();
    var itemPickers = createItemPickers();
    var dates = createDates();
    var editors = createEditors();
    var times = createTimes();
    var dragSelects = createDragSelects();
    var mediaItems = createMediaInputs();

    return {
        selects: selects,
        itemPickers: itemPickers,
        dates: dates,
        editors: editors,
        times: times,
        dragSelects: dragSelects,
        mediaItems: mediaItems
    };
}

function initialiseFormElementsForNewElement(el) {
    var selects = createSelects(el);
    var itemPickers = createItemPickers(el);
    var dates = createDates(el);
    var editors = createEditors(el);
    var times = createTimes(el);
    var dragSelects = createDragSelects(el);
    var mediaItems = createMediaInputs();

    return {
        selects: selects,
        itemPickers: itemPickers,
        dates: dates,
        editors: editors,
        times: times,
        dragSelects: dragSelects,
        mediaItems: mediaItems
    };
}

function refreshFromElements(el, formElements) {
    if (!formElements) {
        return;
    }

    formElements.editors.forEach(function (el) {
        return removeEditor(el);
    });
    formElements.editors = createEditors(el);
}


// CONCATENATED MODULE: ./resources/assets/js/src/ui/templates/multi.js
var multi_typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };









var Multiple = {
    el: null,
    track: null,
    itemTemplate: null,
    addItemCB: null,
    data: null,

    items: null,
    drag: null
};

function exampleCB() {
    return new Promise(function (resolve) {
        // spawn modal
        resolve('resolved value');ƒ;
    });
}

function createMultiples() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;

    var multipleEls = context.querySelectorAll('.js-multi');
    var multiples = Array.from(multipleEls);
    multiples = multiples.map(function (el) {
        return createMultiple(el);
    });
    return multiples;
}

function createMultiple(el) {
    var values = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];
    var data = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

    var Obj = Object.create(Multiple);
    multi_init.call(Obj, el, values, data);
    return Obj;
}

function multi_init(el, values, data) {
    if (typeof el === 'string') {
        this.el = document.querySelector(el);
    } else {
        this.el = el;
    }

    if (!this.el) {
        return;
    }

    this.track = this.el.querySelector('.js-multi-track');
    this.itemTemplate = this.track.innerHTML;
    this.track.innerHTML = '';
    this.items = [];
    this.data = data;
    this.addItemCB = data.addItemCB;

    multi_setupEvents.call(this);
    multi_setupItems.call(this, values);
}

function multi_setupEvents() {
    var _this = this;

    Object(_esm5["fromEvent"])(this.el, 'click').pipe(Object(operators["filter"])(function (evt) {
        return evt.target.classList.contains('js-multi-add');
    }), Object(operators["map"])(function (evt) {
        evt.preventDefault();
        return evt;
    })).subscribe(function () {
        return addItemCB.call(_this, '');
    });

    this.drag = dragula_default()([this.track], {
        revertOnSpill: true,
        removeOnSpill: false,
        moves: function moves(el, container, handle) {
            return handle.classList.contains('js-multi-drag');
        }
    });

    this.drag.on('drop', function (el) {
        var formElements = getformElementsFromMultiEl.call(_this, el);
        refreshFromElements(el, formElements);
    });
}

function multi_setupItems(data) {
    var _this2 = this;

    data.forEach(function (values) {
        multi_addItem.call(_this2, values);
    });

    if (!data.length) {
        multi_addItem.call(this);
    }
}

function addItemCB() {
    var _this3 = this;

    var value = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';

    if (!this.addItemCB) {
        multi_addItem.call(this, value);
        return;
    }

    this.addItemCB().then(function (values) {
        var valueKeys = Object.keys(values);
        var dataName = _this3.data.dataName;
        return valueKeys.reduce(function (acc, key) {
            acc[dataName + '-' + key] = values[key];
            return acc;
        }, {});
    }).then(multi_addItem.bind(this));
}

function multi_addItem() {
    var value = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';

    var html = getTemplateHtml.call(this);
    var newItem = this.track.appendChild(html);

    if ((typeof value === 'undefined' ? 'undefined' : multi_typeof(value)) === 'object') {
        var dataNames = Object.keys(value);
        if (dataNames.length) {
            dataNames.forEach(function (dataName) {
                newItem.querySelector('[data-name="' + dataName + '"]').value = value[dataName];
            });
        }
    } else {
        newItem.querySelector('input, textarea').value = value;
    }

    newItem = initialiseItem.call(this, newItem);
    this.items.push(newItem);
}

function getTemplateHtml() {
    var div = document.createElement('div');
    var hash = createUniqueHash();
    var html = this.itemTemplate.replace(/{multiHash}/g, hash);
    div.innerHTML = html;

    var input = div.querySelector('input, textarea');
    if (input.dataset.class) {
        input.classList.add(input.dataset.class);
    }

    return div.firstElementChild;
}

function initialiseItem(item) {
    var comfirmBtns = item.querySelector('.js-confirm');
    confirm_btns_confirm(comfirmBtns, duplicateItem.call(this, item), multi_removeItem.call(this, item));
    return initialiseFormElementsForNewElement(item);
}

function duplicateItem(item) {
    var _this4 = this;

    return function () {
        var inputs = item.querySelectorAll('input, textarea');
        var inputValues = void 0;

        if (inputs.length === 1) {
            inputValues = inputs[0].value;
        } else {
            inputValues = Array.from(inputs).reduce(function (acc, input) {
                var name = input.dataset.name;
                acc[name] = input.value;
                return acc;
            }, {});
        }
        multi_addItem.call(_this4, inputValues);
    };
}

function multi_removeItem(item) {
    var _this5 = this;

    return function () {
        _this5.items = _this5.items.filter(function (multiItem) {
            return multiItem !== item;
        });
        item.remove();
    };
}

function getformElementsFromMultiEl(item) {
    var multiItem = this.items.filter(function (multiItem) {
        return multiItem.el === item;
    });
    if (!multiItem.length) {
        return;
    }

    return multiItem[0].formElements;
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/templates/templates.js
var areTemplatesSet = false;
var templates_templates = {
    combo: '.tp-combo',
    comboItemTop: '.tp-combo-item-top',
    comboItemBot: '.tp-combo-item-bot',
    multiTop: '.tp-multi-top',
    multiBot: '.tp-multi-bottom',
    group: '.tp-group',
    description: '.tp-description',
    text: '.tp-text',
    textarea: '.tp-textarea',
    select: '.tp-select',
    selectMultiple: '.tp-select-multiple',
    selectMultipleOption: '.tp-select-multiple-option',
    switch: '.tp-switch',
    datetime: '.tp-datetime',
    location: '.tp-location',
    wysiwyg: '.tp-wysiwyg',
    button: '.tp-button',
    file: '.tp-file',
    image: '.tp-image'
};

function setupTemplates() {
    if (areTemplatesSet) {
        return;
    }

    var templateKeys = Object.keys(templates_templates);
    templateKeys.forEach(function (key) {
        var templateEl = document.querySelector(templates_templates[key]);
        if (!templateEl) {
            console.warn('Cannot find template: ' + key);
            return;
        }
        templates_templates[key] = templateEl.innerHTML;
    });

    areTemplatesSet = true;
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/templates/template-input-types.js



// ==================
// Type Options
// ==================

function template_input_types_text(data, templates) {
    // TODO: sort out text icons
    // options to account for
    // url: 0,
    // integer: 0,
    // float: 0,
    // email: 0,
    // phone: 0

    data.inputIconBefore = '';
    data.inputIconAfter = '';

    if (data.multiline) {
        data.input = templates.textarea;
    } else {
        data.input = templates.text;
    }

    if (data.multiple) {
        data.multi = true;
        data.multiTop = templates.multiTop;
        data.multiBot = templates.multiBot;
    } else {
        data.inputName += '[]';
        data.value = data.values[0] || '';
    }

    return data;
}

function template_input_types_select(data, templates) {
    if (data.multiple) {
        data.label = '';
        data.input = templates.selectMultiple;
        data.options = data.options.reduce(function (acc, keyVal) {
            var keys = Object.keys(keyVal);
            keys.forEach(function (key) {
                acc += selectOption(data, key, keyVal[key], true, templates);
            });
            return acc;
        }, '');
        data.value = JSON.stringify(data.values);
    } else {
        data.isMultiple = '';
        data.inputName += '[]';
        data.input = templates.select;
        data.options = data.options.reduce(function (acc, keyVal) {
            var keys = Object.keys(keyVal);
            keys.forEach(function (key) {
                acc += selectOption(data, key, keyVal[key]);
            });
            return acc;
        }, '<option>&nbsp;</option>');
    }

    return data;
}

function selectOption(data, key, value) {
    var isMultiple = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;
    var templates = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : null;

    if (!isMultiple) {
        var selected = '';
        if (~data.values.indexOf(key)) {
            selected = ' selected';
        }
        return '<option value="' + key + '"' + selected + '>' + value + '</option>';
    }

    var optionHtml = templates.selectMultipleOption;
    return optionHtml.replace(/{key}|{value}/g, function (match) {
        if (match === '{key}') {
            return key;
        }

        if (match === '{value}') {
            return value;
        }
    });
}

function template_input_types_boolean(data, templates) {
    data.label = '';
    data.input = templates.switch;

    if (!data.values.length) {
        data.value = data['initial_value'];
    }

    data.value = parseInt(data.value);

    data.checked = '';
    if (data.value) {
        data.checked = 'checked';
    }
    return data;
}

function datetime(data, templates) {
    data.input = templates.datetime;
    data.time = data.time ? 'true' : 'false';
    data.default = data.default ? 'true' : 'false';
    data.range = data.range ? 'true' : 'false';

    data.value = data.values[0] || '';
    return data;
}

function template_input_types_item(data, templates) {
    if (data.multiple_instances) {
        data.inputName += '[]';
        data.label = '';
        data.input = templates.selectMultiple;
        data.options = data.options.reduce(function (acc, keyVal) {
            var keys = Object.keys(keyVal);
            keys.forEach(function (key) {
                acc += selectOption(data, key, keyVal[key], true, templates);
            });
            return acc;
        }, '');
        data.value = JSON.stringify(data.values);
        return data;
    }

    data.isMultiple = '';
    if (data.multiple) {
        data.isMultiple = 'multiple';
    } else {
        data.inputName += '[]';
    }

    data.input = templates.select;
    data.options = data.options.reduce(function (acc, keyVal) {
        var keys = Object.keys(keyVal);
        keys.forEach(function (key) {
            acc += selectOption(data, key, keyVal[key]);
        });
        return acc;
    }, '<option>&nbsp;</option>');

    return data;
}

function template_input_types_location(data, templates) {
    data.input = templates.location;

    var hash = '';

    if (!data.multiple) {
        hash = createUniqueHash();
        hash = '[' + hash + ']';
    }

    data.latInputName = data.inputName + (hash + '[latitude]');
    data.lngInputName = data.inputName + (hash + '[longitude]');
    data.latDataName = data.dataName + '-latitude';
    data.lngDataName = data.dataName + '-longitude';
    data.latValue = data.value && data.value.latitude ? data.value.latitude : '';
    data.lngValue = data.value && data.value.longitude ? data.value.longitude : '';

    if (data.multiple) {
        data.multi = true;
        data.multiTop = templates.multiTop;
        data.multiBot = templates.multiBot;
        data.values = data.values.reduce(function (acc, value) {
            var keys = Object.keys(value);
            var newValue = {};
            keys.forEach(function (key) {
                newValue[data.dataName + '-' + key] = value[key];
            });
            acc.push(newValue);
            return acc;
        }, []);
    }

    return data;
}

function template_input_types_button(data, templates) {

    var hash = '';

    if (!data.multiple) {
        hash = createUniqueHash();
        hash = '[' + hash + ']';
    }

    data.input = templates.button;
    data.labelInputName = data.inputName + (hash + '[label]');
    data.urlInputName = data.inputName + (hash + '[url]');
    data.classInputName = data.inputName + (hash + '[class]');
    data.idInputName = data.inputName + (hash + '[id]');
    data.targetInputName = data.inputName + (hash + '[target]');

    data.labelDataName = data.dataName + '-label';
    data.urlDataName = data.dataName + '-url';
    data.classDataName = data.dataName + '-class';
    data.idDataName = data.dataName + '-id';
    data.targetDataName = data.dataName + '-target';

    data.labelValue = data.value && data.value.label ? data.value.label : '';
    data.urlValue = data.value && data.value.url ? data.value.url : '';
    data.classValue = data.value && data.value.class ? data.value.class : '';
    data.idValue = data.value && data.value.id ? data.value.id : '';
    data.targetValue = data.value && data.value.target ? data.value.target : '';

    if (data.multiple) {
        data.multi = true;
        data.multiTop = templates.multiTop;
        data.multiBot = templates.multiBot;
        data.values = data.values.reduce(function (acc, value) {
            var keys = Object.keys(value);
            var newValue = {};
            keys.forEach(function (key) {
                newValue[data.dataName + '-' + key] = value[key];
            });
            acc.push(newValue);
            return acc;
        }, []);
    }

    return data;
}

function wysiwyg(data, templates, fieldSettings) {
    data.input = templates.wysiwyg;

    var editorSettings = '';

    Object.keys(fieldSettings.editor_options).forEach(function (key) {
        var val = fieldSettings.editor_options[key];
        editorSettings += 'data-' + key + '="' + val + '" ';
    });

    data.inlineProperties = editorSettings;

    if (data.multiple) {
        data.multi = true;
        data.multiTop = templates.multiTop;
        data.multiBot = templates.multiBot;
    } else {
        var hash = createUniqueHash();
        data.inputName += '[' + hash + ']';
        data.input = data.input.replace('data-class', 'class');
        data.value = data.values[0] || '';
    }

    return data;
}

function file(data, templates) {
    data.input = templates.file;

    data.addItemCB = spawnMediaLibModalForFile;

    data.idDataName = data.dataName + '-id';
    data.urlDataName = data.dataName + '-url';

    data.urlValue = data.value && data.value.url ? data.value.url : '';
    data.idValue = data.value && data.value.id ? data.value.id : '';

    if (data.multiple) {
        data.multi = true;
        data.multiTop = templates.multiTop;
        data.multiBot = templates.multiBot;
        data.values = data.values.reduce(function (acc, value) {
            var keys = Object.keys(value);
            var newValue = {};
            keys.forEach(function (key) {
                newValue[data.dataName + '-' + key] = value[key];
            });
            acc.push(newValue);
            return acc;
        }, []);
    } else {
        data.inputName += '[]';
    }

    return data;
}

function template_input_types_image(data, templates) {
    data.input = templates.image;

    var hash = '';

    if (!data.multiple) {
        hash = createUniqueHash();
        hash = '[' + hash + ']';
    }

    data.idInputName = data.inputName + (hash + '[id]');
    data.widthInputName = data.inputName + (hash + '[width]');
    data.heightInputName = data.inputName + (hash + '[height]');
    data.altInputName = data.inputName + (hash + '[alt]');
    data.urlInputName = data.inputName + (hash + '[url]');

    data.idDataName = data.dataName + '-id';
    data.widthDataName = data.dataName + '-width';
    data.heightDataName = data.dataName + '-height';
    data.altDataName = data.dataName + '-alt';
    data.urlDataName = data.dataName + '-url';

    data.urlValue = data.value && data.value.url ? data.value.url : '';
    data.idValue = data.value && data.value.id ? data.value.id : '';
    data.widthValue = data.value && data.value.width ? data.value.width : '';
    data.heightValue = data.value && data.value.height ? data.value.height : '';
    data.altValue = data.value && data.value.alt ? data.value.alt : '';

    if (data.multiple) {
        data.multi = true;
        data.multiTop = templates.multiTop;
        data.multiBot = templates.multiBot;
        data.values = data.values.reduce(function (acc, value) {
            var keys = Object.keys(value);
            var newValue = {};
            keys.forEach(function (key) {
                newValue[data.dataName + '-' + key] = value[key];
            });
            acc.push(newValue);
            return acc;
        }, []);
    }

    data.addItemCB = spawnMediaLibModalForImage;

    return data;
}

// ==================
// Common Template functions
// ==================

function setInputTypeData(field, templates) {
    var comboValues = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
    var comboInputName = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;

    if (!field.errors) {
        field.errors = [];
    }

    if (!field.values) {
        field.values = [];
    }

    var data = {
        statusClass: field.errors.length ? 'has-error' : '',
        inputName: 'fields[' + field.id + ']',
        name: field.options.name,
        dataName: slugify(field.options.name, field.id),
        helpText: field.helpText,
        errors: field.errors,
        multi: false,
        multiTop: '',
        multiBot: '',
        message: field.message,
        messageAfter: field.messageAfter,
        value: '',
        values: field.values,
        errorMessage: field.errors.length ? field.errors[0] : '',
        html: templates.group,
        comboAddName: field.options.comboAddName || 'Item'
    };

    if (comboInputName) {
        data.inputName = comboInputName + ('[' + field.id + ']');
    }

    if (comboValues) {
        data.values = comboValues;

        if (!data.multiple) {
            data.value = comboValues[0];
        }
    }

    data.label = '<label for="' + data.inputName + '">' + data.name + '</label>';

    data = Object.assign(data, field.options.settings);

    if (data.multiple) {
        if (~['image', 'location', 'button', 'wysiwyg'].indexOf(field.options.typeKey)) {
            data.inputName += '[{multiHash}]';
        } else {
            data.inputName += '[]';
        }
    } else {
        if (!comboValues) {
            data.value = field.values[0];
        }
    }

    switch (field.options.typeKey) {
        case 'text':
            data = template_input_types_text(data, templates);
            break;
        case 'description':
            data.html = templates.description;
            break;
        case 'combo':
            data.html = templates.combo;
            break;
        case 'select':
            data = template_input_types_select(data, templates);
            break;
        case 'boolean':
            data = template_input_types_boolean(data, templates);
            break;
        case 'datetime':
            data = datetime(data, templates);
            break;
        case 'item':
            data = template_input_types_item(data, templates);
            break;
        case 'location':
            data = template_input_types_location(data, templates);
            break;
        case 'wysiwyg':
            data = wysiwyg(data, templates, field.options.settings);
            break;
        case 'button':
            data = template_input_types_button(data, templates);
            break;
        case 'image':
            data = template_input_types_image(data, templates);
            break;
        case 'file':
            data = file(data, templates);
            break;
    }

    return data;
}

function parseTemplate(html, data, templates) {
    var skipDataParse = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;

    var dataKeys = Object.keys(data);
    var dataRegex = new RegExp(dataKeys.map(function (str) {
        return '{' + str + '}';
    }).join('|'), 'gm');

    // add input to html before parsing rest
    var parsedHtml = html.replace(/{input}/g, function () {
        return data.input;
    });

    if (data.message) {
        parsedHtml = templates.description.replace(/{content}/g, data.message) + parsedHtml;
    }

    if (data.messageAfter) {
        parsedHtml += templates.description.replace(/{content}/g, data.messageAfter);
    }

    // skip for combo to handle data parse step
    if (skipDataParse) {
        return parsedHtml;
    }

    parsedHtml = parsedHtml.replace(dataRegex, function (match) {
        return data[match.substr(1, match.length - 2)];
    });

    return parsedHtml;
}

function slugify(str, id) {
    return str.toLowerCase().replace(/\s/g, '-') + ('' + id);
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/templates/combo.js
var combo_typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }















var Combo = {
    el: null,
    templates: null,
    track: null,

    id: null,
    data: null,
    orderNum: null, // part of the name combo[${orderNum}]
    items: null,
    drag: null,
    moving: false,
    isMultiple: true,
    name: null,
    comboName: null
};

var comboCount = 0;

function combos() {
    var comboEls = document.querySelectorAll('.js-combo');
    var combos = Array.from(comboEls);
    combos = combos.map(function (el) {
        return combo(el);
    });
    return combos;
}

function combo(el) {
    var data = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    var template = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;

    var Obj = Object.create(Combo);
    if (!areTemplatesSet) {
        setupTemplates();
    }
    combo_init.call(Obj, el, comboCount, data, templates_templates);
    comboCount += 1;
    return Obj;
}

function combo_init(el, comboNumber) {
    var data = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
    var templates = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;

    if (!el) {
        return;
    }

    this.el = el;
    if (data) {
        this.id = data.id;
        this.data = data;
    } else {
        this.id = this.el.dataset.id;

        if (!window.combos || !window.combos[this.id]) {
            return;
        }

        this.data = window.combos[this.id];
    }

    this.name = this.data.options.name;
    this.comboName = this.data.options.comboAddName || 'Item';
    this.isMultiple = this.data.options.settings.multiple;
    this.templates = templates;
    this.track = this.el.querySelector('.js-combo-track');
    this.orderNum = comboNumber;
    this.items = [];

    if (this.el.classList.contains('o-combo--moving')) {
        this.moving = true;
    }

    combo_setupEvents.call(this);
    combo_setupItems.call(this);
}

function combo_setupEvents() {
    var _this = this;

    var click = Object(_esm5["fromEvent"])(this.el, 'click');

    click.pipe(Object(operators["filter"])(function (evt) {
        return evt.target.classList.contains('js-combo-add');
    }), Object(operators["map"])(function (evt) {
        evt.preventDefault();
        return evt;
    })).subscribe(function () {
        return combo_addItem.call(_this);
    });

    click.pipe(Object(operators["filter"])(function (evt) {
        return evt.target.classList.contains('js-combo-drag');
    }), Object(operators["map"])(function (evt) {
        evt.preventDefault();
        return evt;
    })).subscribe(function (evt) {
        if (_this.el.classList.contains('o-combo--moving')) {
            _this.el.classList.remove('o-combo--moving');
            _this.moving = false;
            scrollToComboItem(evt.target);
        } else {
            _this.el.classList.add('o-combo--moving');
            _this.moving = true;
        }
    });

    this.drag = dragula_default()([this.track], {
        revertOnSpill: true,
        removeOnSpill: false,
        moves: function moves(el, container, handle) {
            return handle.classList.contains('js-combo-drag') && _this.moving;
        }
    });

    this.drag.on('drop', function (el) {
        var formElements = getformElementsFromComboEl.call(_this, el);
        refreshFromElements(el, formElements);
    });
}

function combo_setupItems() {
    var _this2 = this;

    this.data.values.forEach(function (comboValues) {
        combo_addItem.call(_this2, comboValues);
    });
}

function combo_addItem(values) {
    var _getComboHtml$call = getComboHtml.call(this, values),
        el = _getComboHtml$call.el,
        hash = _getComboHtml$call.hash;

    var newComboItem = this.track.appendChild(el);
    newComboItem.querySelector('.js-combo-title').dataset.no = this.items.length + 1;
    var formElements = combo_initialiseItem.call(this, newComboItem, hash);
    setupMulti.call(this, newComboItem, values);
    this.items.push({
        el: newComboItem,
        hash: hash,
        formElements: formElements
    });
}

function combo_removeItem(combo) {
    var _this3 = this;

    return function () {
        _this3.items = _this3.items.filter(function (item) {
            return item !== combo;
        });
        combo.remove();
    };
}

function combo_duplicateItem(combo, hash) {
    var _this4 = this;

    return function () {
        var comboValues = getComboItemValues(combo);
        combo_addItem.call(_this4, comboValues);
    };
}

function combo_initialiseItem(item, hash) {
    var comfirmBtns = item.querySelector('.js-confirm');
    confirm_btns_confirm(comfirmBtns, combo_duplicateItem.call(this, item, hash), combo_removeItem.call(this, item));
    return initialiseFormElementsForNewElement(item);
}

function getComboHtml(values) {
    var _this5 = this;

    var html = void 0;
    var hash = createUniqueHash();

    html = this.data.fields.reduce(function (acc, field) {
        var fieldValue = void 0;
        if (values) {
            fieldValue = values[field.id];
        }

        var templateData = setInputTypeData(field, _this5.templates, fieldValue, 'combo[' + _this5.id + '][' + hash + '][fields]');

        // templateData.inputName = templateData.inputName.replace(/field/g,'')

        templateData.dataName = field.id;

        html = parseTemplate(templateData.html, templateData, _this5.templates);

        acc += html;
        return acc;
    }, '');

    html = this.templates.comboItemTop + html + this.templates.comboItemBot;

    var div = document.createElement('div');
    div.innerHTML = html;

    return {
        el: div.firstElementChild,
        hash: hash
    };
}

function getComboItemValues(comboEl) {
    var groupEls = comboEl.querySelectorAll('[data-input-id]');
    var groups = Array.from(groupEls);

    var values = groups.reduce(function (acc, group) {
        var inputID = group.dataset.inputId;
        var multiTrack = group.querySelector('.js-multi-track');
        var multiInputItems = group.querySelectorAll('[data-input-item-name]');
        var values = void 0;

        if (multiTrack) {
            values = getMultiTrackValues(multiTrack);
        } else if (multiInputItems.length) {
            var inputs = Array.from(multiInputItems);
            values = inputs.reduce(function (inputAcc, input) {
                var name = input.dataset.inputItemName;
                var value = parseInputValue(input);

                inputAcc[name] = value;
                return inputAcc;
            }, {});
            values = [values];
        } else {
            var inputEls = group.querySelectorAll('[data-name]');
            var _inputs = Array.from(inputEls);
            values = _inputs.reduce(function (inputAcc, el) {
                var value = parseInputValue(el);

                if (Array.isArray(value)) {
                    return [].concat(_toConsumableArray(inputAcc), _toConsumableArray(value));
                } else {
                    inputAcc.push(value);
                    return inputAcc;
                }
            }, []);
        }

        acc[inputID] = values;
        return acc;
    }, {});

    return values;
}

function getMultiTrackValues(track) {
    var items = Array.from(track.children);
    return items.reduce(function (acc, item) {
        var inputs = item.querySelectorAll('[data-name]');
        inputs = Array.from(inputs);

        if (inputs.length === 1) {
            acc.push(inputs[0].value);
            return acc;
        }

        var values = inputs.reduce(function (inputAcc, input) {
            var name = input.dataset.name;
            inputAcc[name] = input.value;
            return inputAcc;
        }, {});

        acc.push(values);
        return acc;
    }, []);
}

function parseInputValue(input) {
    var value = input.value;

    if (typeof input.dataset.jsonValue !== 'undefined') {
        value = JSON.parse(value);
    }

    if (input.tagName === 'SELECT') {
        value = [].concat(_toConsumableArray(input.options)).filter(function (option) {
            return option.selected;
        }).map(function (option) {
            return option.value;
        });
    }

    return value;
}

function getformElementsFromComboEl(combo) {
    var item = this.items.filter(function (item) {
        return item.el === combo;
    });
    if (!item.length) {
        return;
    }

    return item[0].formElements;
}

function scrollToComboItem(el) {
    requestAnimationFrame(function () {
        ui_jump.jump(el);
    });
}

function setupMulti(newComboItem, comboValues) {
    this.data.fields.forEach(function (field) {
        if (!field.options.settings.multiple) {
            return;
        }

        var group = newComboItem.querySelector('[data-input-id="' + field.id + '"]');
        var multiEl = group.querySelector('.js-multi');
        var values = [];
        if (comboValues && comboValues[field.id]) {
            values = comboValues[field.id];
            values = parseMultiValues(values, field);
        }
        createMultiple(multiEl, values, field);
    });
}

function parseMultiValues(values, field) {
    if (combo_typeof(values[0]) !== 'object') {
        return values;
    }

    var dataName = slugify(field.options.name, field.id) + '-';

    return values.map(function (value) {
        var keys = Object.keys(value);
        return keys.reduce(function (acc, key) {
            if (~key.indexOf(dataName)) {
                acc[key] = value[key];
            } else {
                acc[dataName + key] = value[key];
            }
            return acc;
        }, {});
    });
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/table-actions.js




var TableActions = {
    el: null,
    id: null,
    dropdown: null,
    confirm: null,
    delete: null,
    duplicate: null,
    dropdownToggle: null,
    destroy: table_actions_destroy,
    nameInput: null,
    submitEvent: null
};

function tableAction(actions, dropdown, duplicateCB, deleteCB) {
    var Obj = Object.create(TableActions);
    table_actions_init.call(Obj, actions, dropdown, duplicateCB, deleteCB);
    return Obj;
}

function table_actions_init(actions, dropdown, duplicateCB, deleteCB) {
    if (!actions) {
        return;
    }

    this.el = actions;
    var id = this.el.dataset.id;

    this.id = id;
    this.dropdown = dropdown;

    setDropdownHeight.call(this);

    this.delete = deleteCB.bind(this);
    this.duplicate = duplicateCB.bind(this);
    this.dropdownToggle = toggleDropdown.bind(this);
    this.destroy = this.destroy.bind(this);
    this.nameInput = this.el.querySelector('[name="name"]');

    this.confirm = confirm_btns_confirm(this.el, this.dropdownToggle, this.delete);

    Object(_esm5["fromEvent"])(this.el, 'click').pipe(Object(operators["filter"])(function (evt) {
        return evt.target.classList.contains();
    }));
}

function toggleDropdown() {
    if (!this.dropdown) {
        return;
    }

    if (this.dropdown.classList.contains('is-active')) {
        this.dropdown.classList.remove('is-active');
        this.dropdown.style.height = 0;
        return;
    }

    var height = this.dropdown.dataset.height;

    this.dropdown.style.height = height + 'px';
    this.dropdown.classList.add('is-active');
}

function setDropdownHeight() {
    var cleanUp = false;

    if (!this.dropdown.classList.contains('is-active')) {
        this.dropdown.classList.add('is-active');
        cleanUp = true;
    }

    var container = this.dropdown.firstElementChild;

    var _container$getBoundin = container.getBoundingClientRect(),
        height = _container$getBoundin.height;

    this.dropdown.dataset.height = height;

    if (cleanUp) {
        this.dropdown.classList.remove('is-active');
    }
    return height;
}

function table_actions_destroy() {
    this.confirm.destroy();
    delete this.confirm;
}
// EXTERNAL MODULE: ./node_modules/moment/moment.js
var moment = __webpack_require__("./node_modules/moment/moment.js");
var moment_default = /*#__PURE__*/__webpack_require__.n(moment);

// CONCATENATED MODULE: ./resources/assets/js/src/ui/table.js
function table_toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }




var Table = {
    el: null,
    container: null,
    classes: {
        header: 'o-table__header',
        data: 'o-table__data',
        tableSize: 'o-table--'
    },
    headerEls: [],
    events: [],
    defaultHeaders: ['Actions', ''],
    actionsTemplate: null,
    data: null,
    dataKeys: null
};

function tables() {
    var tableEls = document.querySelectorAll('.js-table');
    var tables = Array.from(tableEls);
    tables = tables.map(function (el) {
        return table(el);
    });
    return tables;
}

function table(el) {
    var Obj = Object.create(Table);
    table_init.call(Obj, el);
    return Obj;
}

function table_init(el) {
    if (!el) {
        return;
    }

    this.el = el;
    this.actionsTemplate = this.el.querySelector('.js-tale-action-template');
    this.actionsTemplate = createTemplate(this.actionsTemplate);
    this.container = this.el.querySelector('.js-table-container');

    this.data = getData.call(this);
    this.dataKeys = Object.keys(this.data.headers).filter(function (el) {
        return el !== 'id';
    });

    setTableSize.call(this);
    parseData.call(this);
    addHeaders.call(this);
    table_render.call(this);
    console.log(this);
}

function getData() {
    return window.tableData;
}

function createTemplate(templateEl) {
    var html = templateEl.innerHTML;
    return function () {
        var div = document.createElement('div');
        div.innerHTML = html;
        return Array.from(div.children);
    };
}

function setTableSize() {
    this.container.classList.add(this.classes.tableSize + this.dataKeys.length);
}

function addHeaders() {
    var _this = this;

    var createHeader = function createHeader(text) {
        var header = document.createElement('div');
        header.classList.add(_this.classes.header);
        header.innerHTML = text;
        _this.headerEls.push(header);
    };

    this.dataKeys.forEach(function (dataKey) {
        createHeader(_this.data.headers[dataKey]);
    });

    this.defaultHeaders.forEach(function (header) {
        createHeader(header);
    });
}

function parseData() {
    var _this2 = this;

    var types = getTypes(this.dataKeys, this.data.dataTypes);

    this.data.rows = this.data.rows.map(function (row) {
        var formattedRow = _this2.dataKeys.reduce(function (acc, key) {
            switch (types[key]) {
                case 'boolean':
                    if (typeof _this2.data.formats[key] !== 'undefined' && (row[key] === 1 || row[key] === 0)) {
                        acc[key] = _this2.data.formats[key][row[key]];
                    } else {
                        acc[key] = row[key];
                    }
                    return acc;
                case 'date':
                    if (typeof _this2.data.formats[key] !== 'undefined') {
                        row[key] = moment_default()(row[key]);
                        acc[key] = row[key].format(_this2.data.formats[key]);
                    }
                    return acc;
                default:
                    acc[key] = row[key];
                    return acc;
            }
        }, {});

        var rowDataEls = _this2.dataKeys.map(function (key) {
            var rowData = document.createElement('div');
            rowData.classList.add(_this2.classes.data);
            rowData.innerHTML = formattedRow[key];
            return rowData;
        });

        var actionEls = _this2.actionsTemplate();
        var dataEls = [].concat(table_toConsumableArray(rowDataEls), table_toConsumableArray(actionEls));

        return {
            id: row.id,
            row: row,
            formattedRow: formattedRow,
            dataEls: dataEls,
            delete: function _delete() {
                return console.log('delete', row.id);
            },
            duplicate: function duplicate(name) {
                return console.log('duplicate', row.id, name);
            }
        };
    });
}

function getTypes(keys, types) {
    return keys.reduce(function (acc, key) {
        if (typeof types[key] !== 'undefined') {
            acc[key] = types[key];
        } else {
            acc[key] = 'string';
        }
        return acc;
    }, {});
}

function table_render() {
    var _this3 = this;

    this.container.innerHTML = '';
    this.headerEls.forEach(function (el) {
        _this3.container.appendChild(el);
    });

    this.data.rows.forEach(function (row) {
        row.dataEls.forEach(function (el) {
            _this3.container.appendChild(el);
        });
    });

    addRowEvents.call(this);
}

function addRowEvents() {
    this.events = this.data.rows.map(function (row) {
        var action = row.dataEls[row.dataEls.length - 3].querySelector('.js-table-actions');
        var dropdown = row.dataEls[row.dataEls.length - 1];

        return tableAction(action, dropdown, row.duplicate, row.delete);
    });
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/templates/template-forms.js






var TemplateForms = {
    el: null,
    groupID: null,
    data: null,
    templates: null
};

function createTemplateForms() {
    var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;

    var templateFormEls = context.querySelectorAll('.js-temple-forms');
    var templateForms = Array.from(templateFormEls);
    setupTemplates();
    templateForms = templateForms.map(function (el) {
        return createTemplateForm(el);
    });
    return templateForms;
}

function createTemplateForm(el) {
    var Obj = Object.create(TemplateForms);
    if (!areTemplatesSet) {
        setupTemplates();
    }
    template_forms_init.call(Obj, el, templates_templates);
    return Obj;
}

function template_forms_init(el, templates) {
    if (!el) {
        return;
    }

    if (!window.fieldGroups) {
        return;
    }

    this.el = el;
    this.groupID = this.el.dataset.groupId;
    this.templates = templates;

    if (!window.fieldGroups[this.groupID]) {
        return;
    }

    this.data = window.fieldGroups[this.groupID];

    setTemplates.call(this);
    appendTemplates.call(this);
    setupMultiAndCombo.call(this);
}

function setTemplates() {
    var _this = this;

    this.data.forEach(function (el, index) {
        if (_this.data[index].options.typeKey !== 'combo') {
            setDataForTemplate.call(_this, index);
            setFieldTemplate.call(_this, index);
        } else {
            setDataForTemplate.call(_this, index);
            setFieldTemplate.call(_this, index);

            // this.data[index].fields.forEach((el, comboIndex) => {
            //     setDataForTemplate.call(this, index, comboIndex)
            //     setFieldTemplate.call(this, index, comboIndex)
            // })

            // this.data[index].fieldTemplates =
            //     this.templates.comboItemTop +
            //     this.data[index].fields.reduce((acc, el) => {
            //         acc += el.template
            //         return acc
            //     }, '') +
            //     this.templates.comboItemBot
        }
    });
}

function setDataForTemplate(index) {
    var comboIndex = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : -1;

    var field = this.data[index];
    if (~comboIndex) {
        field = this.data[index].fields[comboIndex];
    }

    var data = setInputTypeData(field, this.templates);

    if (~comboIndex) {
        this.data[index].fields[comboIndex].data = data;
    } else {
        this.data[index].data = data;
    }
}

function setFieldTemplate(index) {
    var comboIndex = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : -1;

    var html = '';
    var data = void 0;
    if (~comboIndex) {
        html = this.data[index].fields[comboIndex].data.html;
        data = this.data[index].fields[comboIndex].data;
    } else {
        html = this.data[index].data.html;
        data = this.data[index].data;
    }

    html = parseTemplate(html, data, this.templates, !!~comboIndex);

    if (~comboIndex) {
        this.data[index].fields[comboIndex].template = html;
        return;
    }

    this.data[index].template = html;
}

function appendTemplates() {
    var groupHtml = this.data.map(function (el) {
        return el.template;
    });
    groupHtml = '<div>' + groupHtml.join('') + '</div>';

    var newGroupHtml = this.el.appendChild(htmlStrToDom(groupHtml));
    initialiseFormElementsForNewElement(newGroupHtml);
}

function htmlStrToDom(str) {
    var div = document.createElement('div');
    div.innerHTML = str;
    return div.firstElementChild;
}

function setupMultiAndCombo() {
    var _this2 = this;

    this.data.forEach(function (el) {
        if (el.data.multi && el.options.typeKey !== 'combo') {
            var dataName = el.data.dataName;
            var multiEl = _this2.el.querySelector('[data-input-id=' + dataName + ']');
            el.multi = createMultiple(multiEl, el.data.values, el.data);
        }

        if (el.options.typeKey === 'combo') {
            var _dataName = el.data.dataName;
            var comboEl = _this2.el.querySelector('[data-input-id=' + _dataName + ']');
            combo(comboEl, el, _this2.templates);
        }
    });
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/index.js

















// CONCATENATED MODULE: ./resources/assets/js/src/form/reset-form.js



function reset_form_init() {
    Object(_esm5["fromEvent"])(document, 'click').pipe(Object(operators["filter"])(function (el) {
        return el.target.classList.contains('js-form-reset');
    }), Object(operators["map"])(function (evt) {
        return evt.preventDefault(), evt;
    })).subscribe(findAndReset);
}

function findAndReset(e) {
    var form = e.target.closest('.js-form'),
        inputs = form.querySelectorAll('[name]');

    Array.from(inputs).forEach(function (el) {
        if (el.classList.contains('js-select')) {
            var choices = el.choices;
            choices.setValueByChoice('');
        } else if (el.hasAttribute('checked')) {
            el.checked = false;
        } else {
            el.value = '';
        }
    });

    form.submit();
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/tree.js




var Tree = {
    el: null,
    input: null,
    treeContainer: null,
    tree: null,
    id: 0,
    viewItem: function viewItem(_) {},
    editItem: function editItem(_) {},
    addItem: function addItem(_) {},
    deleteItem: function deleteItem(_) {}
};

var count = 0;

function trees() {
    var treeEls = document.querySelectorAll('.js-tree');
    var trees = Array.from(treeEls);
    trees = trees.map(function (el) {
        return tree_tree(el);
    });
    return trees;
}

function tree_tree(el) {
    var Obj = Object.create(Tree);
    count++;
    tree_init.call(Obj, el, count);
    return Obj;
}

function tree_init(el, id) {
    if (!el) {
        return;
    }

    this.el = el;
    this.id = id;
    this.input = this.el.querySelector('.js-tree-search');
    this.treeContainer = this.el.querySelector('.js-tree-container');
    this.viewItem = viewItem.bind(this);
    this.editItem = editItem.bind(this);
    this.addItem = tree_addItem.bind(this);
    this.deleteItem = deleteItem.bind(this);
    this.typesSubMenu = setupTypesSubMenu.call(this);

    createTree.call(this);
    tree_setupEvents.call(this);
}

function createTree() {
    this.tree = $(this.treeContainer).jstree({
        plugins: ['contextmenu', 'dnd', 'search', 'state'],
        core: {
            check_callback: function check_callback(operation, _, nodeParent) {
                return !(operation === 'move_node' && nodeParent.parent === null);
            },
            themes: {
                stripes: true
            }
        },
        contextmenu: {
            items: {
                edit: {
                    _disabled: false,
                    label: 'Edit',
                    title: 'Edit Page',
                    separator_after: true,
                    icon: 'o-tree__icon o-tree__icon--edit',
                    action: this.editItem
                },
                view: {
                    _disabled: false,
                    label: 'View',
                    title: 'View Page',
                    icon: 'o-tree__icon o-tree__icon--view',
                    action: this.viewItem
                },
                add: {
                    _disabled: false,
                    label: 'Add new page',
                    title: 'Add new page beneath',
                    icon: 'o-tree__icon o-tree__icon--children',
                    submenu: this.typesSubMenu
                    // action: this.addItem
                },
                remove: {
                    _disabled: function _disabled(el) {
                        // TODO TomH please refactor :)
                        return !el.reference.parent()[0].dataset.deletable;
                    },
                    label: 'Delete',
                    title: 'Delete Page',
                    icon: 'o-tree__icon o-tree__icon--delete',
                    action: this.deleteItem,
                    separator_before: true
                }
            }
        },
        dnd: {
            copy: false,
            inside_pos: 'last'
        },
        state: {
            key: 'jstree-' + this.id
        }
    });
}

function editItem(data) {
    var obj = this.tree.jstree(true).get_node(data.reference);
    var id = argon.helpers.getIdFromNodeIdString(obj.id);
    console.log(obj, 'edit page');

    window.location.href = argon.root() + '/pages/' + id + '/edit';
}

function viewItem(data) {
    var obj = this.tree.jstree(true).get_node(data.reference);
    var id = argon.helpers.getIdFromNodeIdString(obj.id);
    console.log(obj, 'view page');

    window.open(argon.root() + '/pages/' + id + '/preview', '_blank').focus();
}

function tree_addItem(typeId) {
    var _this = this;

    return function (data) {
        var obj = _this.tree.jstree(true).get_node(data.reference);
        var id = argon.helpers.getIdFromNodeIdString(obj.id);
        console.log(obj, 'add page');

        window.location.href = argon.root() + '/pages/' + id + '/addchild/' + typeId;
    };
}

function deleteItem(data) {
    var tree = this.tree.jstree(true);
    var obj = tree.get_node(data.reference);
    var id = argon.helpers.getIdFromNodeIdString(obj.id);
    console.log(obj, 'delete page');

    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (confirm('Are you sure you want to delete this page?')) {
        post(argon.root() + '/pages/' + id, {
            '_token': token,
            '_method': 'DELETE'
        }).then(function (data) {
            return JSON.parse(data);
        }).then(function (data) {
            if (data.success) {
                tree.delete_node(obj);
            } else {
                alert('Page could not be deleted...');
            }
        }).catch(function (error) {
            return console.log(error);
        });
    }
}

function setupTypesSubMenu() {
    var typesList = JSON.parse(this.el.dataset.types);
    var types = {};

    var _iteratorNormalCompletion = true;
    var _didIteratorError = false;
    var _iteratorError = undefined;

    try {
        for (var _iterator = typesList[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
            var type = _step.value;

            types[type.id] = {
                _disabled: false,
                label: type.name,
                title: 'Create new page of type ' + type.name,
                icon: 'o-tree__icon o-tree__icon--add',
                action: this.addItem(type.id)
            };
        }
    } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
    } finally {
        try {
            if (!_iteratorNormalCompletion && _iterator.return) {
                _iterator.return();
            }
        } finally {
            if (_didIteratorError) {
                throw _iteratorError;
            }
        }
    }

    return types;
}

function tree_setupEvents() {
    var _this2 = this;

    Object(_esm5["fromEvent"])(this.input, 'input').pipe(Object(operators["debounceTime"])(100)).subscribe(function () {
        _this2.tree.jstree(true).search(_this2.input.value);
    });
}
// EXTERNAL MODULE: ./node_modules/vue/dist/vue.runtime.esm.js
var vue_runtime_esm = __webpack_require__("./node_modules/vue/dist/vue.runtime.esm.js");

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/App.vue?vue&type=template&id=5255ee68&
var Appvue_type_template_id_5255ee68_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("div", { staticClass: "example" }, [_vm._v(_vm._s(_vm.msg))]),
      _vm._v(" "),
      _c("child", { attrs: { "test-msg": "testing prop" } })
    ],
    1
  )
}
var staticRenderFns = []
Appvue_type_template_id_5255ee68_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/App.vue?vue&type=template&id=5255ee68&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/child.vue?vue&type=template&id=7d048443&
var childvue_type_template_id_7d048443_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("p", [_vm._v("test child - " + _vm._s(_vm.testData))]),
    _vm._v(" "),
    _c("p", [_vm._v("test prop - " + _vm._s(_vm.testMsg))])
  ])
}
var childvue_type_template_id_7d048443_staticRenderFns = []
childvue_type_template_id_7d048443_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/child.vue?vue&type=template&id=7d048443&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/child.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//

/* harmony default export */ var childvue_type_script_lang_js_ = ({
    props: ['testMsg'],
    data: function data() {
        return {
            testData: 'hello child'
        };
    }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/child.vue?vue&type=script&lang=js&
 /* harmony default export */ var fields_childvue_type_script_lang_js_ = (childvue_type_script_lang_js_); 
// EXTERNAL MODULE: ./node_modules/vue-loader/lib/runtime/componentNormalizer.js
var componentNormalizer = __webpack_require__("./node_modules/vue-loader/lib/runtime/componentNormalizer.js");

// CONCATENATED MODULE: ./resources/assets/js/src/fields/child.vue





/* normalize component */

var component = Object(componentNormalizer["default"])(
  fields_childvue_type_script_lang_js_,
  childvue_type_template_id_7d048443_render,
  childvue_type_template_id_7d048443_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/src/fields/child.vue"
/* harmony default export */ var child = (component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/App.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//



/* harmony default export */ var Appvue_type_script_lang_js_ = ({
    components: {
        child: child
    },
    data: function data() {
        return {
            msg: 'Hello world!'
        };
    }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/App.vue?vue&type=script&lang=js&
 /* harmony default export */ var fields_Appvue_type_script_lang_js_ = (Appvue_type_script_lang_js_); 
// EXTERNAL MODULE: ./resources/assets/js/src/fields/App.vue?vue&type=style&index=0&lang=css&
var Appvue_type_style_index_0_lang_css_ = __webpack_require__("./resources/assets/js/src/fields/App.vue?vue&type=style&index=0&lang=css&");

// CONCATENATED MODULE: ./resources/assets/js/src/fields/App.vue






/* normalize component */

var App_component = Object(componentNormalizer["default"])(
  fields_Appvue_type_script_lang_js_,
  Appvue_type_template_id_5255ee68_render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var App_api; }
App_component.options.__file = "resources/assets/js/src/fields/App.vue"
/* harmony default export */ var App = (App_component.exports);
// CONCATENATED MODULE: ./resources/assets/js/src/fields/index.js



vue_runtime_esm["default"].config.productionTip = false;

function Fields() {
    return new vue_runtime_esm["default"]({
        render: function render(h) {
            return h(App);
        }
    }).$mount('#app');
}
// CONCATENATED MODULE: ./resources/assets/js/src/index.js







function src_init() {
    init();
    ui_jump.init(650, 150);
    sidebar_init();
    accordion_init();
    video_init();
    map_init();
    setupModals();
    initialiseFormElements();
    scroll_anim_init(); // add c-grid-anim | c-line-anim | c-scroll-anim--fade-up with js-scroll-anim to animate a component on scroll
    var basicConfirm = document.querySelector('.js-confirm');
    confirm_btns_confirm(basicConfirm, function () {
        return console.log('dup');
    }, function () {
        return console.log('delete');
    });
    trees();
    // combos()
    tables();
    createTemplateForms();
    // initialiseFormElements()
    registerFormSaveEvents();
    reset_form_init();
    Fields();
}

if (document.readyState !== 'loading') {
    src_init();
} else {
    document.addEventListener('DOMContentLoaded', src_init);
}

/***/ })

/******/ });
//# sourceMappingURL=main.51073a618056be4b436c.js.map