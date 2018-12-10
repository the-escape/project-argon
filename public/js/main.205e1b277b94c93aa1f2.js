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

/***/ "./resources/assets/js/src/index.js":
/*!********************************************************!*\
  !*** ./resources/assets/js/src/index.js + 180 modules ***!
  \********************************************************/
/*! no exports provided */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/choices.js/assets/scripts/dist/choices.min.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/dragula/dragula.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/flatpickr/dist/flatpickr.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/lodash/debounce.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/moment/moment.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/rxjs/_esm5/index.js */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/rxjs/_esm5/operators/index.js */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/sortablejs/Sortable.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vue-resource/dist/vue-resource.esm.js */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vue/dist/vue.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vuex/dist/vuex.esm.js */
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

      while (nodes[++i] && nodes[i] !== node) {
        ;
      }

      return !!nodes[i];
    };
  }(Element.prototype); // closest polyfill

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
      }; // The length property of the from method is 1.


      return function from(arrayLike
      /*, mapFn, thisArg */
      ) {
        // 1. Let C be the this value.
        var C = this; // 2. Let items be ToObject(arrayLike).

        var items = Object(arrayLike); // 3. ReturnIfAbrupt(items).

        if (arrayLike == null) {
          throw new TypeError('Array.from requires an array-like object - not null or undefined');
        } // 4. If mapfn is undefined, then let mapping be false.


        var mapFn = arguments.length > 1 ? arguments[1] : void undefined;
        var T;

        if (typeof mapFn !== 'undefined') {
          // 5. else
          // 5. a If IsCallable(mapfn) is false, throw a TypeError exception.
          if (!isCallable(mapFn)) {
            throw new TypeError('Array.from: when provided, the second argument must be a function');
          } // 5. b. If thisArg was supplied, let T be thisArg; else let T be undefined.


          if (arguments.length > 2) {
            T = arguments[2];
          }
        } // 10. Let lenValue be Get(items, "length").
        // 11. Let len be ToLength(lenValue).


        var len = toLength(items.length); // 13. If IsConstructor(C) is true, then
        // 13. a. Let A be the result of calling the [[Construct]] internal method
        // of C with an argument list containing the single item len.
        // 14. a. Else, Let A be ArrayCreate(len).

        var A = isCallable(C) ? Object(new C(len)) : new Array(len); // 16. Let k be 0.

        var k = 0; // 17. Repeat, while k < len… (also steps a - h)

        var kValue;

        while (k < len) {
          kValue = items[k];

          if (mapFn) {
            A[k] = typeof T === 'undefined' ? mapFn(kValue, k) : mapFn.call(T, kValue, k);
          } else {
            A[k] = kValue;
          }

          k += 1;
        } // 18. Let putStatus be Put(A, "length", len, true).


        A.length = len; // 20. Return A.

        return A;
      };
    }();
  }
}
// CONCATENATED MODULE: ./resources/assets/js/src/util/ajax.js
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

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

    if (_typeof(data) === 'object') {
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
// CONCATENATED MODULE: ./resources/assets/js/src/util/deepCopy.js
function deepClone(obj) {
  return JSON.parse(JSON.stringify(obj));
}
// CONCATENATED MODULE: ./resources/assets/js/src/util/index.js





// EXTERNAL MODULE: ./node_modules/rxjs/_esm5/index.js + 18 modules
var _esm5 = __webpack_require__("./node_modules/rxjs/_esm5/index.js");

// EXTERNAL MODULE: ./node_modules/rxjs/_esm5/operators/index.js + 99 modules
var operators = __webpack_require__("./node_modules/rxjs/_esm5/operators/index.js");

// CONCATENATED MODULE: ./resources/assets/js/src/ui/accordion.js


var accordions;
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
function jump_typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { jump_typeof = function _typeof(obj) { return typeof obj; }; } else { jump_typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return jump_typeof(obj); }


var maxDuration, minDuration, maxDurHeight, wheelEventName, jmpTmpMaxDuration, jmpTmpMinDuration, optionsUser, jump_element, start, stop, jump_offset, easing, durationEasing, a11y, distance, duration, timeStart, timeElapsed, nextScroll, callback, animationID;

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

  switch (jump_typeof(target)) {
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


var scrollAnimations, scrollAnimationKeys, activeClass, onloadAnimations, baseOffset;
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
  var element;

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

var pageUrl;

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
var videos;
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
  var latLng = {
    lat: +lat || 51.2352025,
    lng: +lng || -1.119185
  };
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


var sidebar;
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
    _this.onSucccessEvent.next({
      data: data,
      formData: formData
    });
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

  this.errorMessageEl.innerHTML = "<p>".concat(data.msg, "</p>");
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
          return template("\n                    <div class=\"".concat(classNames.containerInner, "\">\n                        <div class=\"choices__btn\">\n                            <svg><use xlink:href=\"/argon/images/svgicons.svg#select\"></use></svg>\n                        </div>\n                    </div>\n                "));
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

  var _this$el$dataset = this.el.dataset,
      color = _this$el$dataset.color,
      path = _this$el$dataset.path;
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
      item.innerHTML = "<svg><use xlink:href=\"".concat(_this.svgPath + value, "\"></use></svg>");
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
    this.btn.innerHTML = "<svg><use xlink:href=\"".concat(this.svgPath + value, "\"></use></svg>");
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
  contentCss: '',
  // iframe styles
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
  } // for (let i in cke) {
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

      drag_select_removeItem.call(_this, el.dataset.value);
      addItem.call(_this, el.dataset.value, _siblingValue);
    }

    if (target === _this.inactiveColumn) {
      drag_select_removeItem.call(_this, el.dataset.value);
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

function drag_select_removeItem(value) {
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
    var item = _this3.inactiveColumn.querySelector("[data-value=\"".concat(activeValue, "\"]"));

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
  this.url = input.querySelector('[data-input-item-name=url]'); // this.filepath = input.querySelector('.js-media-input-filepath')

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
  } // else {
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
      var mediaValueObj; // data.values

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
function multi_typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { multi_typeof = function _typeof(obj) { return typeof obj; }; } else { multi_typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return multi_typeof(obj); }







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
    resolve('resolved value');
    ƒ;
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

  if (multi_typeof(value) === 'object') {
    var dataNames = Object.keys(value);

    if (dataNames.length) {
      dataNames.forEach(function (dataName) {
        newItem.querySelector("[data-name=\"".concat(dataName, "\"]")).value = value[dataName];
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
  confirm_btns_confirm(comfirmBtns, multi_duplicateItem.call(this, item), multi_removeItem.call(this, item));
  return initialiseFormElementsForNewElement(item);
}

function multi_duplicateItem(item) {
  var _this4 = this;

  return function () {
    var inputs = item.querySelectorAll('input, textarea');
    var inputValues;

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

    return "<option value=\"".concat(key, "\"").concat(selected, ">").concat(value, "</option>");
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
    hash = "[".concat(hash, "]");
  }

  data.latInputName = data.inputName + "".concat(hash, "[latitude]");
  data.lngInputName = data.inputName + "".concat(hash, "[longitude]");
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
    hash = "[".concat(hash, "]");
  }

  data.input = templates.button;
  data.labelInputName = data.inputName + "".concat(hash, "[label]");
  data.urlInputName = data.inputName + "".concat(hash, "[url]");
  data.classInputName = data.inputName + "".concat(hash, "[class]");
  data.idInputName = data.inputName + "".concat(hash, "[id]");
  data.targetInputName = data.inputName + "".concat(hash, "[target]");
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
    editorSettings += "data-".concat(key, "=\"").concat(val, "\" ");
  });
  data.inlineProperties = editorSettings;

  if (data.multiple) {
    data.multi = true;
    data.multiTop = templates.multiTop;
    data.multiBot = templates.multiBot;
  } else {
    var hash = createUniqueHash();
    data.inputName += "[".concat(hash, "]");
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
    hash = "[".concat(hash, "]");
  }

  data.idInputName = data.inputName + "".concat(hash, "[id]");
  data.widthInputName = data.inputName + "".concat(hash, "[width]");
  data.heightInputName = data.inputName + "".concat(hash, "[height]");
  data.altInputName = data.inputName + "".concat(hash, "[alt]");
  data.urlInputName = data.inputName + "".concat(hash, "[url]");
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
} // ==================
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
    inputName: "fields[".concat(field.id, "]"),
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
    data.inputName = comboInputName + "[".concat(field.id, "]");
  }

  if (comboValues) {
    data.values = comboValues;

    if (!data.multiple) {
      data.value = comboValues[0];
    }
  }

  data.label = "<label for=\"".concat(data.inputName, "\">").concat(data.name, "</label>");
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
    return "{".concat(str, "}");
  }).join('|'), 'gm'); // add input to html before parsing rest

  var parsedHtml = html.replace(/{input}/g, function () {
    return data.input;
  });

  if (data.message) {
    parsedHtml = templates.description.replace(/{content}/g, data.message) + parsedHtml;
  }

  if (data.messageAfter) {
    parsedHtml += templates.description.replace(/{content}/g, data.messageAfter);
  } // skip for combo to handle data parse step


  if (skipDataParse) {
    return parsedHtml;
  }

  parsedHtml = parsedHtml.replace(dataRegex, function (match) {
    return data[match.substr(1, match.length - 2)];
  });
  return parsedHtml;
}
function slugify(str, id) {
  return str.toLowerCase().replace(/\s/g, '-') + "".concat(id);
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/templates/combo.js
function combo_typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { combo_typeof = function _typeof(obj) { return typeof obj; }; } else { combo_typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return combo_typeof(obj); }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }











var Combo = {
  el: null,
  templates: null,
  track: null,
  id: null,
  data: null,
  orderNum: null,
  // part of the name combo[${orderNum}]
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

  var html;
  var hash = createUniqueHash();
  html = this.data.fields.reduce(function (acc, field) {
    var fieldValue;

    if (values) {
      fieldValue = values[field.id];
    }

    var templateData = setInputTypeData(field, _this5.templates, fieldValue, "combo[".concat(_this5.id, "][").concat(hash, "][fields]")); // templateData.inputName = templateData.inputName.replace(/field/g,'')

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
    var values;

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
          return _toConsumableArray(inputAcc).concat(_toConsumableArray(value));
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
    value = _toConsumableArray(input.options).filter(function (option) {
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

    var group = newComboItem.querySelector("[data-input-id=\"".concat(field.id, "\"]"));
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
function table_toConsumableArray(arr) { return table_arrayWithoutHoles(arr) || table_iterableToArray(arr) || table_nonIterableSpread(); }

function table_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function table_iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function table_arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }



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

    var dataEls = table_toConsumableArray(rowDataEls).concat(table_toConsumableArray(actionEls));

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
      setFieldTemplate.call(_this, index); // this.data[index].fields.forEach((el, comboIndex) => {
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
  var data;

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

      var multiEl = _this2.el.querySelector("[data-input-id=".concat(dataName, "]"));

      el.multi = createMultiple(multiEl, el.data.values, el.data);
    }

    if (el.options.typeKey === 'combo') {
      var _dataName = el.data.dataName;

      var comboEl = _this2.el.querySelector("[data-input-id=".concat(_dataName, "]"));

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
          submenu: this.typesSubMenu // action: this.addItem

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
      if (!_iteratorNormalCompletion && _iterator.return != null) {
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
// EXTERNAL MODULE: ./node_modules/vue/dist/vue.js
var vue = __webpack_require__("./node_modules/vue/dist/vue.js");
var vue_default = /*#__PURE__*/__webpack_require__.n(vue);

// EXTERNAL MODULE: ./node_modules/vuex/dist/vuex.esm.js
var vuex_esm = __webpack_require__("./node_modules/vuex/dist/vuex.esm.js");

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/App.vue?vue&type=template&id=5255ee68&
var Appvue_type_template_id_5255ee68_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-form l-container" },
    [
      _vm._l(_vm.fields, function(field) {
        return _c("types", { key: field.id, attrs: { field: field } })
      }),
      _vm._v(" "),
      _c("pre", [_vm._v(_vm._s(_vm.fields))])
    ],
    2
  )
}
var staticRenderFns = []
Appvue_type_template_id_5255ee68_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/App.vue?vue&type=template&id=5255ee68&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/App.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
/* harmony default export */ var Appvue_type_script_lang_js_ = ({
  computed: {
    fields: function fields() {
      return this.$store.state.fields;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/App.vue?vue&type=script&lang=js&
 /* harmony default export */ var fields_Appvue_type_script_lang_js_ = (Appvue_type_script_lang_js_); 
// EXTERNAL MODULE: ./node_modules/vue-loader/lib/runtime/componentNormalizer.js
var componentNormalizer = __webpack_require__("./node_modules/vue-loader/lib/runtime/componentNormalizer.js");

// CONCATENATED MODULE: ./resources/assets/js/src/fields/App.vue





/* normalize component */

var component = Object(componentNormalizer["default"])(
  fields_Appvue_type_script_lang_js_,
  Appvue_type_template_id_5255ee68_render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/src/fields/App.vue"
/* harmony default export */ var App = (component.exports);
// EXTERNAL MODULE: ./node_modules/sortablejs/Sortable.js
var Sortable = __webpack_require__("./node_modules/sortablejs/Sortable.js");
var Sortable_default = /*#__PURE__*/__webpack_require__.n(Sortable);

// CONCATENATED MODULE: ./resources/assets/js/vendor/vuedraggable.js


var _extends = Object.assign || function (target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i];

    for (var key in source) {
      if (Object.prototype.hasOwnProperty.call(source, key)) {
        target[key] = source[key];
      }
    }
  }

  return target;
};

function vuedraggable_toConsumableArray(arr) {
  if (Array.isArray(arr)) {
    for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) {
      arr2[i] = arr[i];
    }

    return arr2;
  } else {
    return Array.from(arr);
  }
}

if (!Array.from) {
  Array.from = function (object) {
    return [].slice.call(object);
  };
}

function buildAttribute(object, propName, value) {
  if (value == undefined) {
    return object;
  }

  object = object == null ? {} : object;
  object[propName] = value;
  return object;
}

function buildDraggable(Sortable) {
  function removeNode(node) {
    node.parentElement.removeChild(node);
  }

  function insertNodeAt(fatherNode, node, position) {
    var refNode = position === 0 ? fatherNode.children[0] : fatherNode.children[position - 1].nextSibling;
    fatherNode.insertBefore(node, refNode);
  }

  function computeVmIndex(vnodes, element) {
    return vnodes.map(function (elt) {
      return elt.elm;
    }).indexOf(element);
  }

  function _computeIndexes(slots, children, isTransition) {
    if (!slots) {
      return [];
    }

    var elmFromNodes = slots.map(function (elt) {
      return elt.elm;
    });
    var rawIndexes = [].concat(vuedraggable_toConsumableArray(children)).map(function (elt) {
      return elmFromNodes.indexOf(elt);
    });
    return isTransition ? rawIndexes.filter(function (ind) {
      return ind !== -1;
    }) : rawIndexes;
  }

  function emit(evtName, evtData) {
    var _this = this;

    this.$nextTick(function () {
      return _this.$emit(evtName.toLowerCase(), evtData);
    });
  }

  function delegateAndEmit(evtName) {
    var _this2 = this;

    return function (evtData) {
      if (_this2.realList !== null) {
        _this2['onDrag' + evtName](evtData);
      }

      emit.call(_this2, evtName, evtData);
    };
  }

  var eventsListened = ['Start', 'Add', 'Remove', 'Update', 'End'];
  var eventsToEmit = ['Choose', 'Sort', 'Filter', 'Clone'];
  var readonlyProperties = ['Move'].concat(eventsListened, eventsToEmit).map(function (evt) {
    return 'on' + evt;
  });
  var draggingElement = null;
  var props = {
    options: Object,
    list: {
      type: Array,
      required: false,
      default: null
    },
    value: {
      type: Array,
      required: false,
      default: null
    },
    noTransitionOnDrag: {
      type: Boolean,
      default: false
    },
    clone: {
      type: Function,
      default: function _default(original) {
        return original;
      }
    },
    element: {
      type: String,
      default: 'div'
    },
    move: {
      type: Function,
      default: null
    },
    componentData: {
      type: Object,
      required: false,
      default: null
    }
  };
  var draggableComponent = {
    name: 'draggable',
    props: props,
    data: function data() {
      return {
        transitionMode: false,
        noneFunctionalComponentMode: false,
        init: false
      };
    },
    render: function render(h) {
      var slots = this.$slots.default;

      if (slots && slots.length === 1) {
        var child = slots[0];

        if (child.componentOptions && child.componentOptions.tag === 'transition-group') {
          this.transitionMode = true;
        }
      }

      var children = slots;
      var footer = this.$slots.footer;

      if (footer) {
        children = slots ? [].concat(vuedraggable_toConsumableArray(slots), vuedraggable_toConsumableArray(footer)) : [].concat(vuedraggable_toConsumableArray(footer));
      }

      var attributes = null;

      var update = function update(name, value) {
        attributes = buildAttribute(attributes, name, value);
      };

      update('attrs', this.$attrs);

      if (this.componentData) {
        var _componentData = this.componentData,
            on = _componentData.on,
            _props = _componentData.props;
        update('on', on);
        update('props', _props);
      }

      return h(this.element, attributes, children);
    },
    mounted: function mounted() {
      var _this3 = this;

      this.noneFunctionalComponentMode = this.element.toLowerCase() !== this.$el.nodeName.toLowerCase();

      if (this.noneFunctionalComponentMode && this.transitionMode) {
        throw new Error('Transition-group inside component is not supported. Please alter element value or remove transition-group. Current element value: ' + this.element);
      }

      var optionsAdded = {};
      eventsListened.forEach(function (elt) {
        optionsAdded['on' + elt] = delegateAndEmit.call(_this3, elt);
      });
      eventsToEmit.forEach(function (elt) {
        optionsAdded['on' + elt] = emit.bind(_this3, elt);
      });

      var options = _extends({}, this.options, optionsAdded, {
        onMove: function onMove(evt, originalEvent) {
          return _this3.onDragMove(evt, originalEvent);
        }
      });

      !('draggable' in options) && (options.draggable = '>*');
      this._sortable = new Sortable(this.rootContainer, options);
      this.computeIndexes();
    },
    beforeDestroy: function beforeDestroy() {
      this._sortable.destroy();
    },
    computed: {
      rootContainer: function rootContainer() {
        return this.transitionMode ? this.$el.children[0] : this.$el;
      },
      isCloning: function isCloning() {
        return !!this.options && !!this.options.group && this.options.group.pull === 'clone';
      },
      realList: function realList() {
        return this.list ? this.list : this.value;
      }
    },
    watch: {
      options: {
        handler: function handler(newOptionValue) {
          for (var property in newOptionValue) {
            if (readonlyProperties.indexOf(property) == -1) {
              this._sortable.option(property, newOptionValue[property]);
            }
          }
        },
        deep: true
      },
      realList: function realList() {
        this.computeIndexes();
      }
    },
    methods: {
      getChildrenNodes: function getChildrenNodes() {
        if (!this.init) {
          this.noneFunctionalComponentMode = this.noneFunctionalComponentMode && this.$children.length == 1;
          this.init = true;
        }

        if (this.noneFunctionalComponentMode) {
          return this.$children[0].$slots.default;
        }

        var rawNodes = this.$slots.default;
        return this.transitionMode ? rawNodes[0].child.$slots.default : rawNodes;
      },
      computeIndexes: function computeIndexes() {
        var _this4 = this;

        this.$nextTick(function () {
          _this4.visibleIndexes = _computeIndexes(_this4.getChildrenNodes(), _this4.rootContainer.children, _this4.transitionMode);
        });
      },
      getUnderlyingVm: function getUnderlyingVm(htmlElt) {
        var index = computeVmIndex(this.getChildrenNodes() || [], htmlElt);

        if (index === -1) {
          // Edge case during move callback: related element might be
          // an element different from collection
          return null;
        }

        var element = this.realList[index];
        return {
          index: index,
          element: element
        };
      },
      getUnderlyingPotencialDraggableComponent: function getUnderlyingPotencialDraggableComponent(_ref) {
        var __vue__ = _ref.__vue__;

        if (!__vue__ || !__vue__.$options || __vue__.$options._componentTag !== 'transition-group') {
          return __vue__;
        }

        return __vue__.$parent;
      },
      emitChanges: function emitChanges(evt) {
        var _this5 = this;

        this.$nextTick(function () {
          _this5.$emit('change', evt);
        });
      },
      alterList: function alterList(onList) {
        if (this.list) {
          onList(this.list);
        } else {
          var newList = [].concat(vuedraggable_toConsumableArray(this.value));
          onList(newList);
          this.$emit('input', newList);
        }
      },
      spliceList: function spliceList() {
        var _arguments = arguments;

        var spliceList = function spliceList(list) {
          return list.splice.apply(list, _arguments);
        };

        this.alterList(spliceList);
      },
      updatePosition: function updatePosition(oldIndex, newIndex) {
        var updatePosition = function updatePosition(list) {
          return list.splice(newIndex, 0, list.splice(oldIndex, 1)[0]);
        };

        this.alterList(updatePosition);
      },
      getRelatedContextFromMoveEvent: function getRelatedContextFromMoveEvent(_ref2) {
        var to = _ref2.to,
            related = _ref2.related;
        var component = this.getUnderlyingPotencialDraggableComponent(to);

        if (!component) {
          return {
            component: component
          };
        }

        var list = component.realList;
        var context = {
          list: list,
          component: component
        };

        if (to !== related && list && component.getUnderlyingVm) {
          var destination = component.getUnderlyingVm(related);

          if (destination) {
            return _extends(destination, context);
          }
        }

        return context;
      },
      getVmIndex: function getVmIndex(domIndex) {
        var indexes = this.visibleIndexes;
        var numberIndexes = indexes.length;
        return domIndex > numberIndexes - 1 ? numberIndexes : indexes[domIndex];
      },
      getComponent: function getComponent() {
        return this.$slots.default[0].componentInstance;
      },
      resetTransitionData: function resetTransitionData(index) {
        if (!this.noTransitionOnDrag || !this.transitionMode) {
          return;
        }

        var nodes = this.getChildrenNodes();
        nodes[index].data = null;
        var transitionContainer = this.getComponent();
        transitionContainer.children = [];
        transitionContainer.kept = undefined;
      },
      onDragStart: function onDragStart(evt) {
        this.context = this.getUnderlyingVm(evt.item);
        evt.item._underlying_vm_ = this.clone(this.context.element);
        draggingElement = evt.item;
      },
      onDragAdd: function onDragAdd(evt) {
        var element = evt.item._underlying_vm_;

        if (element === undefined) {
          return;
        }

        removeNode(evt.item);
        var newIndex = this.getVmIndex(evt.newIndex);
        this.spliceList(newIndex, 0, element);
        this.computeIndexes();
        var added = {
          element: element,
          newIndex: newIndex
        };
        this.emitChanges({
          added: added
        });
      },
      onDragRemove: function onDragRemove(evt) {
        insertNodeAt(this.rootContainer, evt.item, evt.oldIndex);

        if (this.isCloning) {
          removeNode(evt.clone);
          return;
        }

        var oldIndex = this.context.index;
        this.spliceList(oldIndex, 1);
        var removed = {
          element: this.context.element,
          oldIndex: oldIndex
        };
        this.resetTransitionData(oldIndex);
        this.emitChanges({
          removed: removed
        });
      },
      onDragUpdate: function onDragUpdate(evt) {
        removeNode(evt.item);
        insertNodeAt(evt.from, evt.item, evt.oldIndex);
        var oldIndex = this.context.index;
        var newIndex = this.getVmIndex(evt.newIndex);
        this.updatePosition(oldIndex, newIndex);
        var moved = {
          element: this.context.element,
          oldIndex: oldIndex,
          newIndex: newIndex
        };
        this.emitChanges({
          moved: moved
        });
      },
      computeFutureIndex: function computeFutureIndex(relatedContext, evt) {
        if (!relatedContext.element) {
          return 0;
        }

        var domChildren = [].concat(vuedraggable_toConsumableArray(evt.to.children)).filter(function (el) {
          return el.style['display'] !== 'none';
        });
        var currentDOMIndex = domChildren.indexOf(evt.related);
        var currentIndex = relatedContext.component.getVmIndex(currentDOMIndex);
        var draggedInList = domChildren.indexOf(draggingElement) != -1;
        return draggedInList || !evt.willInsertAfter ? currentIndex : currentIndex + 1;
      },
      onDragMove: function onDragMove(evt, originalEvent) {
        var onMove = this.move;

        if (!onMove || !this.realList) {
          return true;
        }

        var relatedContext = this.getRelatedContextFromMoveEvent(evt);
        var draggedContext = this.context;
        var futureIndex = this.computeFutureIndex(relatedContext, evt);

        _extends(draggedContext, {
          futureIndex: futureIndex
        });

        _extends(evt, {
          relatedContext: relatedContext,
          draggedContext: draggedContext
        });

        return onMove(evt, originalEvent);
      },
      onDragEnd: function onDragEnd(evt) {
        this.computeIndexes();
        draggingElement = null;
      }
    }
  };
  return draggableComponent;
}

var out = buildDraggable(Sortable_default.a);
/* harmony default export */ var vuedraggable = (out);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/types.vue?vue&type=template&id=c5a3b86c&
var typesvue_type_template_id_c5a3b86c_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(_vm.type, {
    tag: "component",
    attrs: {
      "field-id": _vm.field.id,
      "combo-id": _vm.comboId,
      "combo-item-id": _vm.comboItemId
    }
  })
}
var typesvue_type_template_id_c5a3b86c_staticRenderFns = []
typesvue_type_template_id_c5a3b86c_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/types.vue?vue&type=template&id=c5a3b86c&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/text.vue?vue&type=template&id=c246de28&
var textvue_type_template_id_c246de28_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(_vm.type, {
    tag: "component",
    attrs: {
      "field-id": _vm.fieldId,
      "combo-id": _vm.comboId,
      "combo-item-id": _vm.comboItemId,
      icons: _vm.icons,
      type: "text"
    }
  })
}
var textvue_type_template_id_c246de28_staticRenderFns = []
textvue_type_template_id_c246de28_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/text.vue?vue&type=template&id=c246de28&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/base.vue?vue&type=template&id=7412e090&
var basevue_type_template_id_7412e090_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-form__group" },
    [
      _c(
        "validation",
        { attrs: { "status-error": _vm.errors, "input-name": _vm.inputName } },
        [
          _c("label", { attrs: { for: _vm.inputName } }, [
            _vm._v(_vm._s(_vm.name))
          ]),
          _vm._v(" "),
          _c("multi", {
            attrs: {
              "field-id": _vm.fieldId,
              "combo-id": _vm.comboId,
              "combo-item-id": _vm.comboItemId,
              "input-name": _vm.inputName
            },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(ref) {
                  var valueObj = ref.valueObj
                  return [
                    _c(
                      "input-icon",
                      {
                        attrs: {
                          "pre-icon": _vm.icons.preIcon,
                          "post-icon": _vm.icons.postIcon
                        }
                      },
                      [
                        _c("input", {
                          attrs: {
                            type: _vm.type,
                            id: _vm.inputName,
                            name: _vm.inputName
                          },
                          domProps: { value: valueObj.value },
                          on: {
                            keyup: function($event) {
                              $event.stopPropagation()
                              _vm.updateValue(valueObj, $event.target.value)
                            }
                          }
                        })
                      ]
                    )
                  ]
                }
              }
            ])
          })
        ],
        1
      ),
      _vm._v(" "),
      _vm.field.helpText
        ? _c("div", {
            staticClass: "o-form__help-text l-full",
            domProps: { innerHTML: _vm._s(_vm.field.helpText) }
          })
        : _vm._e()
    ],
    1
  )
}
var basevue_type_template_id_7412e090_staticRenderFns = []
basevue_type_template_id_7412e090_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/base.vue?vue&type=template&id=7412e090&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/util/input-icon.vue?vue&type=template&id=bae39e4c&
var input_iconvue_type_template_id_bae39e4c_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-form-icon" },
    [
      _vm.preIcon
        ? _c("div", { staticClass: "o-form-icon__icon" }, [
            _vm.preIcon && _vm.preIcon.svg
              ? _c("svg", { attrs: { xmlns: "http://www.w3.org/2000/svg" } }, [
                  _c("use", {
                    attrs: {
                      "xlink:href":
                        "/argon/images/svgicons.svg#" + _vm.preIcon.svg
                    }
                  })
                ])
              : _vm._e(),
            _vm._v(" "),
            _vm.preIcon && _vm.preIcon.text
              ? _c("span", [_vm._v(_vm._s(_vm.preIcon.text))])
              : _vm._e()
          ])
        : _vm._e(),
      _vm._v(" "),
      _vm._t("default"),
      _vm._v(" "),
      _vm.postIcon
        ? _c("div", { staticClass: "o-form-icon__icon" }, [
            _vm.postIcon && _vm.postIcon.svg
              ? _c("svg", { attrs: { xmlns: "http://www.w3.org/2000/svg" } }, [
                  _c("use", {
                    attrs: {
                      "xlink:href":
                        "/argon/images/svgicons.svg#" + _vm.postIcon.svg
                    }
                  })
                ])
              : _vm._e(),
            _vm._v(" "),
            _vm.postIcon && _vm.postIcon.text
              ? _c("span", [_vm._v(_vm._s(_vm.postIcon.text))])
              : _vm._e()
          ])
        : _vm._e()
    ],
    2
  )
}
var input_iconvue_type_template_id_bae39e4c_staticRenderFns = []
input_iconvue_type_template_id_bae39e4c_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/input-icon.vue?vue&type=template&id=bae39e4c&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/util/input-icon.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ var input_iconvue_type_script_lang_js_ = ({
  props: ['preIcon', 'postIcon']
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/input-icon.vue?vue&type=script&lang=js&
 /* harmony default export */ var util_input_iconvue_type_script_lang_js_ = (input_iconvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/input-icon.vue





/* normalize component */

var input_icon_component = Object(componentNormalizer["default"])(
  util_input_iconvue_type_script_lang_js_,
  input_iconvue_type_template_id_bae39e4c_render,
  input_iconvue_type_template_id_bae39e4c_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var input_icon_api; }
input_icon_component.options.__file = "resources/assets/js/src/fields/types/util/input-icon.vue"
/* harmony default export */ var input_icon = (input_icon_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/util/validation.vue?vue&type=template&id=720cee37&
var validationvue_type_template_id_720cee37_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "o-form-status",
      class: { "has-error": _vm.hasError, "has-success": _vm.success }
    },
    [
      _c(
        "div",
        { staticClass: "o-form-status__input" },
        [_vm._t("default")],
        2
      ),
      _vm._v(" "),
      _c("div", { staticClass: "o-form-status__message" }, [
        _c("div", { staticClass: "o-form-status__icon" }, [
          _vm.hasError
            ? _c("div", { staticClass: "o-form-status__icon--error" }, [
                _c("svg", [
                  _c("use", {
                    attrs: { "xlink:href": "/argon/images/svgicons.svg#alert" }
                  })
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.success
            ? _c("div", { staticClass: "o-form-status__icon--success" }, [
                _c("svg", [
                  _c("use", {
                    attrs: {
                      "xlink:href": "/argon/images/svgicons.svg#success"
                    }
                  })
                ])
              ])
            : _vm._e()
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "o-form-status__message-bar" }, [
          _c("label", { attrs: { for: _vm.inputName } }, [
            _vm._v(_vm._s(_vm.errorMsg))
          ])
        ])
      ])
    ]
  )
}
var validationvue_type_template_id_720cee37_staticRenderFns = []
validationvue_type_template_id_720cee37_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/validation.vue?vue&type=template&id=720cee37&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/util/validation.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ var validationvue_type_script_lang_js_ = ({
  props: ['statusError', 'inputName'],
  data: function data() {
    return {
      success: false
    };
  },
  computed: {
    hasError: function hasError() {
      return this.statusError.length;
    },
    errorMsg: function errorMsg() {
      return this.statusError[0];
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/validation.vue?vue&type=script&lang=js&
 /* harmony default export */ var util_validationvue_type_script_lang_js_ = (validationvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/validation.vue





/* normalize component */

var validation_component = Object(componentNormalizer["default"])(
  util_validationvue_type_script_lang_js_,
  validationvue_type_template_id_720cee37_render,
  validationvue_type_template_id_720cee37_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var validation_api; }
validation_component.options.__file = "resources/assets/js/src/fields/types/util/validation.vue"
/* harmony default export */ var validation = (validation_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/util/multi.vue?vue&type=template&id=0c69bbeb&
var multivue_type_template_id_0c69bbeb_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _vm.isMultiple
        ? _c("div", { staticClass: "o-multi" }, [
            _c(
              "div",
              { staticClass: "o-multi__track" },
              [
                _c(
                  "draggable",
                  {
                    attrs: {
                      options: {
                        group: { pull: true, put: true },
                        animation: 150,
                        handle: ".js-multi-drag"
                      }
                    },
                    on: { end: _vm.onMove },
                    model: {
                      value: _vm.values,
                      callback: function($$v) {
                        _vm.values = $$v
                      },
                      expression: "values"
                    }
                  },
                  _vm._l(_vm.values, function(value) {
                    return _c(
                      "div",
                      { key: value.id, staticClass: "o-multi__item" },
                      [
                        _c(
                          "div",
                          { staticClass: "o-multi__item-wrap" },
                          [
                            _c(
                              "button",
                              {
                                staticClass:
                                  "o-multi__drag-handle js-multi-drag"
                              },
                              [
                                _c(
                                  "div",
                                  { staticClass: "o-multi__drag-wrap" },
                                  [
                                    _c("svg", [
                                      _c("use", {
                                        attrs: {
                                          "xlink:href":
                                            "/argon/images/svgicons.svg#reorder"
                                        }
                                      })
                                    ])
                                  ]
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _vm._t("default", null, { valueObj: value }),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "o-multi__actions" },
                              [
                                _c("confirm-btn", {
                                  on: {
                                    delete: function($event) {
                                      _vm.deleteValue(value.id)
                                    },
                                    duplicate: function($event) {
                                      _vm.duplicateValue(value.id)
                                    }
                                  }
                                })
                              ],
                              1
                            )
                          ],
                          2
                        )
                      ]
                    )
                  })
                )
              ],
              1
            ),
            _vm._v(" "),
            _c("div", { staticClass: "o-multi__foot" }, [
              _c(
                "button",
                {
                  staticClass: "o-btn o-btn--sm",
                  on: { click: _vm.addEmptyValue }
                },
                [_vm._v("Add")]
              )
            ])
          ])
        : _vm._e(),
      _vm._v(" "),
      !_vm.isMultiple
        ? [_vm._t("default", null, { valueObj: _vm.singleValue })]
        : _vm._e()
    ],
    2
  )
}
var multivue_type_template_id_0c69bbeb_staticRenderFns = []
multivue_type_template_id_0c69bbeb_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/multi.vue?vue&type=template&id=0c69bbeb&

// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/bus.js

var EventBus = new vue_default.a();
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/util/confirm-btn.vue?vue&type=template&id=5cfdca01&
var confirm_btnvue_type_template_id_5cfdca01_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "o-confirm-btn__container",
      class: { "is-active": _vm.confirmDelete }
    },
    [
      _c("div", { staticClass: "o-confirm-btn__questions" }, [
        _c(
          "button",
          {
            staticClass: "o-confirm-btn",
            attrs: { title: "Duplicate" },
            on: { click: _vm.duplicate }
          },
          [
            _c("svg", [
              _c("use", {
                attrs: { "xlink:href": "/argon/images/svgicons.svg#duplicate" }
              })
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "o-confirm-btn",
            attrs: { title: "Delete" },
            on: { click: _vm.toggleConfirmDelete }
          },
          [
            _c("svg", [
              _c("use", {
                attrs: { "xlink:href": "/argon/images/svgicons.svg#delete" }
              })
            ])
          ]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "o-confirm-btn__decline" }, [
        _c(
          "button",
          {
            staticClass: "o-confirm-btn o-confirm-btn--danger",
            on: { click: _vm.toggleConfirmDelete }
          },
          [
            _c("svg", [
              _c("use", {
                attrs: { "xlink:href": "/argon/images/svgicons.svg#cross" }
              })
            ])
          ]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "o-confirm-btn__accept" }, [
        _c(
          "button",
          {
            staticClass: "o-confirm-btn o-confirm-btn--success",
            on: { click: _vm.deleteConfirm }
          },
          [
            _c("svg", [
              _c("use", {
                attrs: { "xlink:href": "/argon/images/svgicons.svg#tick" }
              })
            ])
          ]
        )
      ])
    ]
  )
}
var confirm_btnvue_type_template_id_5cfdca01_staticRenderFns = []
confirm_btnvue_type_template_id_5cfdca01_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/confirm-btn.vue?vue&type=template&id=5cfdca01&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/util/confirm-btn.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ var confirm_btnvue_type_script_lang_js_ = ({
  data: function data() {
    return {
      confirmDelete: false
    };
  },
  methods: {
    toggleConfirmDelete: function toggleConfirmDelete() {
      this.confirmDelete = !this.confirmDelete;
    },
    duplicate: function duplicate() {
      this.$emit('duplicate');
    },
    deleteConfirm: function deleteConfirm() {
      this.$emit('delete');
      this.confirmDelete = false;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/confirm-btn.vue?vue&type=script&lang=js&
 /* harmony default export */ var util_confirm_btnvue_type_script_lang_js_ = (confirm_btnvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/confirm-btn.vue





/* normalize component */

var confirm_btn_component = Object(componentNormalizer["default"])(
  util_confirm_btnvue_type_script_lang_js_,
  confirm_btnvue_type_template_id_5cfdca01_render,
  confirm_btnvue_type_template_id_5cfdca01_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var confirm_btn_api; }
confirm_btn_component.options.__file = "resources/assets/js/src/fields/types/util/confirm-btn.vue"
/* harmony default export */ var confirm_btn = (confirm_btn_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/util/multi.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ var multivue_type_script_lang_js_ = ({
  name: 'multi',
  components: {
    'confirm-btn': confirm_btn
  },
  props: ['inputName', 'fieldId', 'comboId', 'comboItemId'],
  methods: {
    onMove: function onMove() {
      var name = 'move-' + this.fieldId;

      if (this.comboId) {
        name = 'move-' + this.fieldId + '-' + this.comboId + '-' + this.comboItemId;
      }

      EventBus.$emit(name);
    },
    addEmptyValue: function addEmptyValue() {
      if (this.comboId) {
        var field = this.$store.getters.getComboField(this.comboId, this.fieldId);
        var newEmptyValue = deepClone(field.emptyValue);
        this.$store.commit('addComboFieldValue', {
          fieldID: this.fieldId,
          comboID: this.comboId,
          comboItemId: this.comboItemId,
          valueObj: newEmptyValue
        });
      } else {
        var _field = this.$store.getters.getField(this.fieldId);

        var _newEmptyValue = deepClone(_field.emptyValue);

        this.$store.commit('addValue', {
          fieldID: this.fieldId,
          valueObj: _newEmptyValue
        });
      }
    },
    deleteValue: function deleteValue(valueID) {
      if (this.comboId) {
        this.$store.commit('removeComboFieldValue', {
          fieldID: this.fieldId,
          comboID: this.comboId,
          comboItemId: this.comboItemId,
          valueID: valueID
        });
      } else {
        this.$store.commit('removeValue', {
          fieldID: this.fieldId,
          valueID: valueID
        });
      }
    },
    duplicateValue: function duplicateValue(valueID) {
      var val = this.values.filter(function (value) {
        return value.id === valueID;
      });
      var duplicateVal = {};

      if (val.length) {
        duplicateVal = Object.assign({}, val[0]);
      }

      if (this.comboId) {
        this.$store.commit('addComboFieldValue', {
          fieldID: this.fieldId,
          comboID: this.comboId,
          comboItemId: this.comboItemId,
          valueObj: duplicateVal
        });
      } else {
        this.$store.commit('addValue', {
          fieldID: this.fieldId,
          valueObj: duplicateVal
        });
      }
    }
  },
  computed: {
    isMultiple: function isMultiple() {
      var field;

      if (this.comboId) {
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);
      } else {
        field = this.$store.getters.getField(this.fieldId);
      }

      return field.options.settings.multiple;
    },
    singleValue: function singleValue() {
      var _this = this;

      if (this.comboId) {
        var comboField = this.$store.getters.getField(this.comboId);

        if (comboField && comboField.values.length) {
          var values = comboField.values.filter(function (value) {
            return value.id === _this.comboItemId;
          });

          if (values.length && values[0][this.fieldId] && values[0][this.fieldId][0]) {
            return values[0][this.fieldId][0];
          }
        }
      }

      var field = this.$store.getters.getField(this.fieldId);

      if (field && field.values[0]) {
        return field.values[0];
      }

      return '';
    },
    values: {
      get: function get() {
        var _this2 = this;

        if (this.comboId) {
          var comboField = this.$store.getters.getField(this.comboId);

          if (comboField && comboField.values.length) {
            var values = comboField.values.filter(function (value) {
              return value.id === _this2.comboItemId;
            });

            if (values.length && values[0][this.fieldId]) {
              return values[0][this.fieldId];
            }
          }
        }

        var field = this.$store.getters.getField(this.fieldId);

        if (field) {
          return field.values;
        }

        return [];
      },
      set: function set(values) {
        if (this.comboId) {
          this.$store.commit('updateComboFieldValues', {
            fieldID: this.fieldId,
            comboID: this.comboId,
            comboItemId: this.comboItemId,
            newValues: values
          });
        } else {
          this.$store.commit('updateValues', {
            fieldID: this.fieldId,
            comboID: this.comboId,
            comboItemId: this.comboItemId,
            newValues: values
          });
        }
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/multi.vue?vue&type=script&lang=js&
 /* harmony default export */ var util_multivue_type_script_lang_js_ = (multivue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/util/multi.vue





/* normalize component */

var multi_component = Object(componentNormalizer["default"])(
  util_multivue_type_script_lang_js_,
  multivue_type_template_id_0c69bbeb_render,
  multivue_type_template_id_0c69bbeb_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var multi_api; }
multi_component.options.__file = "resources/assets/js/src/fields/types/util/multi.vue"
/* harmony default export */ var multi = (multi_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/mixins/field-values.vue?vue&type=script&lang=js&
/* harmony default export */ var field_valuesvue_type_script_lang_js_ = ({
  computed: {
    field: function field() {
      if (this.comboId) {
        return this.$store.getters.getComboField(this.comboId, this.fieldId);
      }

      return this.$store.getters.getField(this.fieldId);
    },
    inputName: function inputName() {
      var field;

      if (this.comboId) {
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);
        return "combo[".concat(this.comboId, "][").concat(this.comboItemId, "][fields][").concat(this.fieldId, "][]");
      } else {
        field = this.$store.getters.getField(this.fieldId);
        return "fields[".concat(field.id, "][]");
      }
    },
    name: function name() {
      var field;

      if (this.comboId) {
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);
      } else {
        field = this.$store.getters.getField(this.fieldId);
      }

      if (field) {
        return field.options.name;
      }
    },
    errors: function errors() {
      var _this = this;

      if (this.comboId) {
        var comboItem = this.$store.getters.getField(this.comboId);

        if (comboItem.errors.length) {
          var errors = comboItem.errors.filter(function (errorsObj) {
            return errorsObj.id === _this.comboItemId;
          });

          if (errors.length && errors[0][this.fieldId]) {
            return errors[0][this.fieldId];
          }
        }

        return [];
      }

      var field = this.$store.getters.getField(this.fieldId);
      return field.errors;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/mixins/field-values.vue?vue&type=script&lang=js&
 /* harmony default export */ var mixins_field_valuesvue_type_script_lang_js_ = (field_valuesvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/mixins/field-values.vue
var field_values_render, field_values_staticRenderFns




/* normalize component */

var field_values_component = Object(componentNormalizer["default"])(
  mixins_field_valuesvue_type_script_lang_js_,
  field_values_render,
  field_values_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var field_values_api; }
field_values_component.options.__file = "resources/assets/js/src/fields/types/mixins/field-values.vue"
/* harmony default export */ var field_values = (field_values_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/base.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var basevue_type_script_lang_js_ = ({
  props: ['fieldId', 'icons', 'type', 'comboId', 'comboItemId'],
  mixins: [field_values],
  components: {
    'input-icon': input_icon,
    'validation': validation,
    'multi': multi
  },
  methods: {
    updateValue: function updateValue(valueObj, newValue) {
      valueObj.value = newValue;

      if (this.comboId) {
        this.$store.commit('updateComboFieldValue', {
          fieldID: this.fieldId,
          comboID: this.comboId,
          comboItemId: this.comboItemId,
          newValue: valueObj
        });
      } else {
        this.$store.commit('updateValue', {
          fieldID: this.fieldId,
          newValue: valueObj
        });
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/base.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_basevue_type_script_lang_js_ = (basevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/base.vue





/* normalize component */

var base_component = Object(componentNormalizer["default"])(
  types_basevue_type_script_lang_js_,
  basevue_type_template_id_7412e090_render,
  basevue_type_template_id_7412e090_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var base_api; }
base_component.options.__file = "resources/assets/js/src/fields/types/base.vue"
/* harmony default export */ var base = (base_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/textarea.vue?vue&type=template&id=e433ee0e&
var textareavue_type_template_id_e433ee0e_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-form__group" },
    [
      _c(
        "validation",
        { attrs: { "status-error": _vm.errors, "input-name": _vm.inputName } },
        [
          _c("label", { attrs: { for: _vm.inputName } }, [
            _vm._v(_vm._s(_vm.name))
          ]),
          _vm._v(" "),
          _c("multi", {
            attrs: {
              "field-id": _vm.fieldId,
              "combo-id": _vm.comboId,
              "combo-item-id": _vm.comboItemId,
              "input-name": _vm.inputName
            },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(ref) {
                  var valueObj = ref.valueObj
                  return [
                    _c(
                      "textarea",
                      {
                        attrs: { id: _vm.inputName, name: _vm.inputName },
                        on: {
                          keyup: function($event) {
                            $event.stopPropagation()
                            _vm.updateValue(valueObj, $event.target.value)
                          }
                        }
                      },
                      [_vm._v(_vm._s(valueObj.value))]
                    )
                  ]
                }
              }
            ])
          })
        ],
        1
      ),
      _vm._v(" "),
      _vm.field.helpText
        ? _c("div", {
            staticClass: "o-form__help-text l-full",
            domProps: { innerHTML: _vm._s(_vm.field.helpText) }
          })
        : _vm._e()
    ],
    1
  )
}
var textareavue_type_template_id_e433ee0e_staticRenderFns = []
textareavue_type_template_id_e433ee0e_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/textarea.vue?vue&type=template&id=e433ee0e&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/textarea.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ var textareavue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  components: {
    'validation': validation,
    'multi': multi
  },
  mixins: [field_values],
  methods: {
    updateValue: function updateValue(valueObj, newValue) {
      valueObj.value = newValue;

      if (this.comboId) {
        this.$store.commit('updateComboFieldValue', {
          fieldID: this.fieldId,
          comboID: this.comboId,
          comboItemId: this.comboItemId,
          newValue: valueObj
        });
      } else {
        this.$store.commit('updateValue', {
          fieldID: this.fieldId,
          newValue: valueObj
        });
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/textarea.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_textareavue_type_script_lang_js_ = (textareavue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/textarea.vue





/* normalize component */

var textarea_component = Object(componentNormalizer["default"])(
  types_textareavue_type_script_lang_js_,
  textareavue_type_template_id_e433ee0e_render,
  textareavue_type_template_id_e433ee0e_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var textarea_api; }
textarea_component.options.__file = "resources/assets/js/src/fields/types/textarea.vue"
/* harmony default export */ var types_textarea = (textarea_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/text.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var textvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  components: {
    'base-input': base,
    'textarea-input': types_textarea
  },
  computed: {
    type: function type() {
      var field;

      if (this.comboId) {
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);
      } else {
        field = this.$store.getters.getField(this.fieldId);
      }

      if (field.options.settings.multiline) {
        return 'textarea-input';
      }

      return 'base-input';
    },
    icons: function icons() {
      var field;

      if (this.comboId) {
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);
      } else {
        field = this.$store.getters.getField(this.fieldId);
      }

      return {
        preIcon: field && field.options.preIcon || false,
        postIcon: field && field.options.postIcon || false
      };
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/text.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_textvue_type_script_lang_js_ = (textvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/text.vue





/* normalize component */

var text_component = Object(componentNormalizer["default"])(
  types_textvue_type_script_lang_js_,
  textvue_type_template_id_c246de28_render,
  textvue_type_template_id_c246de28_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var text_api; }
text_component.options.__file = "resources/assets/js/src/fields/types/text.vue"
/* harmony default export */ var types_text = (text_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/email.vue?vue&type=template&id=08de6526&
var emailvue_type_template_id_08de6526_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("base-input", {
    attrs: {
      "field-id": _vm.fieldId,
      "combo-id": _vm.comboId,
      "combo-item-id": _vm.comboItemId,
      icons: _vm.icons,
      type: "email"
    }
  })
}
var emailvue_type_template_id_08de6526_staticRenderFns = []
emailvue_type_template_id_08de6526_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/email.vue?vue&type=template&id=08de6526&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/email.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var emailvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  components: {
    'base-input': base
  },
  computed: {
    icons: function icons() {
      var field;

      if (this.comboId) {
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);
      } else {
        field = this.$store.getters.getField(this.fieldId);
      }

      return {
        preIcon: field && field.options.preIcon || {
          svg: 'email'
        },
        postIcon: field && field.options.postIcon || false
      };
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/email.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_emailvue_type_script_lang_js_ = (emailvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/email.vue





/* normalize component */

var email_component = Object(componentNormalizer["default"])(
  types_emailvue_type_script_lang_js_,
  emailvue_type_template_id_08de6526_render,
  emailvue_type_template_id_08de6526_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var email_api; }
email_component.options.__file = "resources/assets/js/src/fields/types/email.vue"
/* harmony default export */ var email = (email_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/phone.vue?vue&type=template&id=3fd8863f&
var phonevue_type_template_id_3fd8863f_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("base-input", {
    attrs: {
      "field-id": _vm.fieldId,
      "combo-id": _vm.comboId,
      "combo-item-id": _vm.comboItemId,
      icons: _vm.icons,
      type: "tel"
    }
  })
}
var phonevue_type_template_id_3fd8863f_staticRenderFns = []
phonevue_type_template_id_3fd8863f_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/phone.vue?vue&type=template&id=3fd8863f&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/phone.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var phonevue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  components: {
    'base-input': base
  },
  computed: {
    icons: function icons() {
      var field;

      if (this.comboId) {
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);
      } else {
        field = this.$store.getters.getField(this.fieldId);
      }

      return {
        preIcon: field && field.options.preIcon || {
          svg: 'phone'
        },
        postIcon: field && field.options.postIcon || false
      };
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/phone.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_phonevue_type_script_lang_js_ = (phonevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/phone.vue





/* normalize component */

var phone_component = Object(componentNormalizer["default"])(
  types_phonevue_type_script_lang_js_,
  phonevue_type_template_id_3fd8863f_render,
  phonevue_type_template_id_3fd8863f_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var phone_api; }
phone_component.options.__file = "resources/assets/js/src/fields/types/phone.vue"
/* harmony default export */ var phone = (phone_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/combo.vue?vue&type=template&id=11cd6a5f&
var combovue_type_template_id_11cd6a5f_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "o-combo o-form__group l-full" }, [
    _c("div", { staticClass: "o-combo__head" }, [
      _c("div", { staticClass: "o-combo__label" }, [
        _vm._v(_vm._s(_vm.comboField.options.name))
      ]),
      _vm._v(" "),
      _vm.isMultiple
        ? _c(
            "button",
            {
              staticClass: "o-btn o-btn--sm o-btn--primary",
              on: {
                click: function($event) {
                  _vm.addEmptyItem()
                }
              }
            },
            [_vm._v("Add " + _vm._s(_vm.comboField.options.comboAddName))]
          )
        : _vm._e()
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "o-combo__track" },
      [
        _c(
          "draggable",
          {
            attrs: {
              options: {
                group: { pull: true, put: true },
                animation: 150,
                handle: ".js-combo-drag"
              }
            },
            model: {
              value: _vm.items,
              callback: function($$v) {
                _vm.items = $$v
              },
              expression: "items"
            }
          },
          _vm._l(_vm.items, function(item) {
            return _c(
              "div",
              {
                key: item.id,
                staticClass: "o-combo__item",
                attrs: { id: "combo-" + item.id }
              },
              [
                _c("div", { staticClass: "o-combo__header" }, [
                  _vm.isMultiple
                    ? _c(
                        "button",
                        {
                          staticClass: "o-combo__drag-handle js-combo-drag",
                          on: {
                            click: function($event) {
                              _vm.toggleBodyHide(item.id)
                            }
                          }
                        },
                        [
                          _c("div", { staticClass: "o-combo__drag-wrap" }, [
                            _c("svg", [
                              _c("use", {
                                attrs: {
                                  "xlink:href":
                                    "/argon/images/svgicons.svg#reorder"
                                }
                              })
                            ])
                          ])
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.isMultiple
                    ? _c(
                        "div",
                        { staticClass: "o-combo__title js-combo-title" },
                        [_vm._v("Item " + _vm._s(item.id + 1))]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.isMultiple
                    ? _c(
                        "div",
                        { staticClass: "o-combo__actions" },
                        [
                          _c("confirm-btn", {
                            on: {
                              delete: function($event) {
                                _vm.deleteItem(item.id)
                              },
                              duplicate: function($event) {
                                _vm.duplicateItem(item.id)
                              }
                            }
                          })
                        ],
                        1
                      )
                    : _vm._e()
                ]),
                _vm._v(" "),
                !_vm.isHidingBody
                  ? _c("div", { staticClass: "o-combo__body" }, [
                      _c(
                        "div",
                        { staticClass: "o-combo__form" },
                        _vm._l(_vm.comboFields, function(field) {
                          return _c("types", {
                            key: field.id,
                            attrs: {
                              field: field,
                              "combo-id": _vm.fieldId,
                              "combo-item-id": item.id
                            }
                          })
                        })
                      )
                    ])
                  : _vm._e()
              ]
            )
          })
        )
      ],
      1
    ),
    _vm._v(" "),
    _c("div", { staticClass: "o-combo__foot" }, [
      _vm.isMultiple
        ? _c(
            "button",
            {
              staticClass: "o-btn o-btn--sm o-btn--primary",
              on: {
                click: function($event) {
                  _vm.addEmptyItem()
                }
              }
            },
            [_vm._v("Add " + _vm._s(_vm.comboField.options.comboAddName))]
          )
        : _vm._e()
    ])
  ])
}
var combovue_type_template_id_11cd6a5f_staticRenderFns = []
combovue_type_template_id_11cd6a5f_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/combo.vue?vue&type=template&id=11cd6a5f&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/combo.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ var combovue_type_script_lang_js_ = ({
  name: 'combo',
  props: ['fieldId'],
  data: function data() {
    return {
      isHidingBody: false
    };
  },
  components: {
    'confirm-btn': confirm_btn
  },
  created: function created() {
    if (!this.items.length) {
      this.addEmptyItem();
    }
  },
  methods: {
    toggleBodyHide: function toggleBodyHide(scrollID) {
      this.isHidingBody = !this.isHidingBody;
      setTimeout(function () {
        requestAnimationFrame(function () {
          ui_jump.jump('#combo-' + scrollID);
        });
      }, 0);
    },
    deleteItem: function deleteItem(comboItemID) {
      this.$store.commit('removeComboItem', {
        comboID: this.fieldId,
        comboItemID: comboItemID
      });
    },
    duplicateItem: function duplicateItem(comboItemID) {
      var comboField = this.$store.getters.getField(this.fieldId);
      var val = comboField.values.filter(function (comboValueObj) {
        return comboValueObj.id === comboItemID;
      });

      if (!val.length) {
        console.warn('could not find value to duplicate');
        return;
      }

      var duplicate = deepClone(val[0]);
      this.$store.commit('addComboItemValue', {
        comboID: this.fieldId,
        newValueObj: duplicate
      });
    },
    addEmptyItem: function addEmptyItem() {
      var comboField = this.$store.getters.getField(this.fieldId);
      var emptyValue = deepClone(comboField.emptyValue);
      this.$store.commit('addComboItemValue', {
        comboID: this.fieldId,
        newValueObj: emptyValue
      });
    }
  },
  computed: {
    comboField: function comboField() {
      return this.$store.getters.getField(this.fieldId);
    },
    comboFields: function comboFields() {
      var comboField = this.$store.getters.getField(this.fieldId);
      return comboField.fields;
    },
    isMultiple: function isMultiple() {
      var comboField = this.$store.getters.getField(this.fieldId);
      return comboField.options.settings.multiple;
    },
    items: {
      get: function get() {
        var comboField = this.$store.getters.getField(this.fieldId);
        return comboField.values;
      },
      set: function set(values) {
        this.$store.commit('updateComboItemValues', {
          comboID: this.fieldId,
          newValues: values
        });
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/combo.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_combovue_type_script_lang_js_ = (combovue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/combo.vue





/* normalize component */

var combo_component = Object(componentNormalizer["default"])(
  types_combovue_type_script_lang_js_,
  combovue_type_template_id_11cd6a5f_render,
  combovue_type_template_id_11cd6a5f_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var combo_api; }
combo_component.options.__file = "resources/assets/js/src/fields/types/combo.vue"
/* harmony default export */ var types_combo = (combo_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/select.vue?vue&type=template&id=7048990a&
var selectvue_type_template_id_7048990a_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(_vm.type, {
    tag: "component",
    attrs: {
      "field-id": _vm.fieldId,
      "combo-id": _vm.comboId,
      "combo-item-id": _vm.comboItemId
    }
  })
}
var selectvue_type_template_id_7048990a_staticRenderFns = []
selectvue_type_template_id_7048990a_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/select.vue?vue&type=template&id=7048990a&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/single-select.vue?vue&type=template&id=98beaf1c&
var single_selectvue_type_template_id_98beaf1c_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-form__group" },
    [
      _c(
        "validation",
        { attrs: { "status-error": _vm.errors, "input-name": _vm.inputName } },
        [
          _c("label", { attrs: { for: _vm.inputName } }, [
            _vm._v(_vm._s(_vm.name))
          ]),
          _vm._v(" "),
          _c(
            "select",
            { attrs: { name: _vm.inputName, id: _vm.inputName } },
            [
              _c("option", { attrs: { value: " " } }, [_vm._v(" ")]),
              _vm._v(" "),
              _vm._l(_vm.options, function(option, index) {
                return _c(
                  "option",
                  { key: index, domProps: { value: option.value } },
                  [_vm._v(_vm._s(option.label))]
                )
              })
            ],
            2
          )
        ]
      )
    ],
    1
  )
}
var single_selectvue_type_template_id_98beaf1c_staticRenderFns = []
single_selectvue_type_template_id_98beaf1c_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/single-select.vue?vue&type=template&id=98beaf1c&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/mixins/select-values.vue?vue&type=script&lang=js&
/* harmony default export */ var select_valuesvue_type_script_lang_js_ = ({
  computed: {
    options: function options() {
      var field;

      if (this.comboId) {
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);
      } else {
        field = this.$store.getters.getField(this.fieldId);
      }

      var options = field.options.settings.options;
      return options.reduce(function (acc, opt) {
        for (var key in opt) {
          acc.push({
            value: key,
            label: opt[key]
          });
        }

        return acc;
      }, []);
    },
    values: {
      get: function get() {
        var _this = this;

        var field;

        if (this.comboId) {
          var combo = this.$store.getters.getField(this.comboId);

          var _field = this.$store.getters.getComboField(this.comboId, this.fieldId);

          if (combo && combo.values.length) {
            var values = combo.values.filter(function (value) {
              return value.id === _this.comboItemId;
            });

            if (values.length && values[0][this.fieldId]) {
              if (_field.options.settings.multiple) {
                return values[0][this.fieldId].map(function (value) {
                  return value.value;
                });
              } else if (values[0][this.fieldId][0]) {
                return values[0][this.fieldId][0].value;
              }
            }

            if (_field.options.settings.multiple) {
              return [];
            }
          }
        } else {
          field = this.$store.getters.getField(this.fieldId);

          if (field.options.settings.multiple) {
            return field.values.map(function (value) {
              return value.value;
            });
          }

          if (field.values.length) {
            return field.values.map(function (value) {
              return value.value;
            })[0];
          }
        }

        return '';
      },
      set: function set(values) {
        if (!Array.isArray(values)) {
          values = [values];
        }

        var valueObjs = values.map(function (value, id) {
          return {
            value: value,
            id: id
          };
        });

        if (this.comboId) {
          this.$store.commit('updateComboFieldValues', {
            fieldID: this.fieldId,
            comboID: this.comboId,
            comboItemId: this.comboItemId,
            newValues: valueObjs
          });
        } else {
          this.$store.commit('updateValues', {
            fieldID: this.fieldId,
            newValues: valueObjs
          });
        }
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/mixins/select-values.vue?vue&type=script&lang=js&
 /* harmony default export */ var mixins_select_valuesvue_type_script_lang_js_ = (select_valuesvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/mixins/select-values.vue
var select_values_render, select_values_staticRenderFns




/* normalize component */

var select_values_component = Object(componentNormalizer["default"])(
  mixins_select_valuesvue_type_script_lang_js_,
  select_values_render,
  select_values_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var select_values_api; }
select_values_component.options.__file = "resources/assets/js/src/fields/types/mixins/select-values.vue"
/* harmony default export */ var select_values = (select_values_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/single-select.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var single_selectvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  mixins: [field_values, select_values],
  components: {
    'validation': validation
  },
  data: function data() {
    return {
      selectInstance: null,
      selectElement: null,
      choicesOptions: {
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
              return template("\n                            <div class=\"".concat(classNames.containerInner, "\">\n                                <div class=\"choices__btn\">\n                                    <svg><use xlink:href=\"/argon/images/svgicons.svg#select\"></use></svg>\n                                </div>\n                            </div>\n                        "));
            }
          };
        }
      }
    };
  },
  methods: {
    selectChange: function selectChange() {
      this.values = this.selectInstance.getValue(true);
    }
  },
  mounted: function mounted() {
    var select = this.$el.querySelector('select');
    this.selectElement = select;
    this.selectInstance = new choices_min_default.a(select, this.choicesOptions);
    this.selectInstance.setValueByChoice(this.values);
    this.selectElement.addEventListener('change', this.selectChange.bind(this));
  },
  destroyed: function destroyed() {
    this.selectElement.removeEventListener('change', this.selectChange.bind(this));
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/single-select.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_single_selectvue_type_script_lang_js_ = (single_selectvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/single-select.vue





/* normalize component */

var single_select_component = Object(componentNormalizer["default"])(
  types_single_selectvue_type_script_lang_js_,
  single_selectvue_type_template_id_98beaf1c_render,
  single_selectvue_type_template_id_98beaf1c_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var single_select_api; }
single_select_component.options.__file = "resources/assets/js/src/fields/types/single-select.vue"
/* harmony default export */ var single_select = (single_select_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/multi-select.vue?vue&type=template&id=53c89962&
var multi_selectvue_type_template_id_53c89962_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-form__group" },
    [
      _c(
        "validation",
        { attrs: { "status-error": _vm.errors, "input-name": _vm.inputName } },
        [
          _c("label", { attrs: { for: _vm.inputName } }, [
            _vm._v(_vm._s(_vm.name))
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "o-drag-select js-drag" },
            [
              _vm._l(_vm.values, function(value, index) {
                return _c("input", {
                  key: index,
                  attrs: { type: "hidden", name: _vm.inputName },
                  domProps: { value: value }
                })
              }),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "o-drag-select__column-wrap" },
                [
                  _c("div", { staticClass: "o-drag-select__title" }, [
                    _vm._v(" ")
                  ]),
                  _vm._v(" "),
                  _c(
                    "draggable",
                    {
                      staticClass:
                        "o-drag-select__column o-drag-select__column--inactive",
                      attrs: {
                        options: {
                          group: {
                            name: "multiselect-" + _vm.inputName,
                            pull: true,
                            put: true
                          },
                          animation: 150
                        }
                      },
                      model: {
                        value: _vm.filteredOptions,
                        callback: function($$v) {
                          _vm.filteredOptions = $$v
                        },
                        expression: "filteredOptions"
                      }
                    },
                    _vm._l(_vm.filteredOptions, function(option) {
                      return _c(
                        "div",
                        {
                          key: option.value,
                          staticClass: "o-drag-select__item"
                        },
                        [
                          _c(
                            "div",
                            { staticClass: "o-drag-select__item-wrap" },
                            [
                              _c("span", [_vm._v(_vm._s(option.label))]),
                              _vm._v(" "),
                              _c("svg", [
                                _c("use", {
                                  attrs: {
                                    "xlink:href":
                                      "/argon/images/svgicons.svg#move"
                                  }
                                })
                              ])
                            ]
                          )
                        ]
                      )
                    })
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c("div", { staticClass: "o-drag-select__arrow" }, [
                _c("svg", [
                  _c("use", {
                    attrs: {
                      "xlink:href": "/argon/images/svgicons.svg#arrow-right"
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "o-drag-select__column-wrap" },
                [
                  _c("div", { staticClass: "o-drag-select__title" }, [
                    _vm._v("Selected")
                  ]),
                  _vm._v(" "),
                  _c(
                    "draggable",
                    {
                      staticClass:
                        "o-drag-select__column o-drag-select__column--active",
                      attrs: {
                        options: {
                          group: {
                            name: "multiselect-" + _vm.inputName,
                            pull: true,
                            put: true
                          },
                          animation: 150
                        }
                      },
                      model: {
                        value: _vm.valueOptions,
                        callback: function($$v) {
                          _vm.valueOptions = $$v
                        },
                        expression: "valueOptions"
                      }
                    },
                    _vm._l(_vm.valueOptions, function(option) {
                      return _c(
                        "div",
                        {
                          key: option.value,
                          staticClass: "o-drag-select__item"
                        },
                        [
                          _c(
                            "div",
                            { staticClass: "o-drag-select__item-wrap" },
                            [
                              _c("span", [_vm._v(_vm._s(option.label))]),
                              _vm._v(" "),
                              _c("svg", [
                                _c("use", {
                                  attrs: {
                                    "xlink:href":
                                      "/argon/images/svgicons.svg#move"
                                  }
                                })
                              ])
                            ]
                          )
                        ]
                      )
                    })
                  )
                ],
                1
              )
            ],
            2
          )
        ]
      )
    ],
    1
  )
}
var multi_selectvue_type_template_id_53c89962_staticRenderFns = []
multi_selectvue_type_template_id_53c89962_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/multi-select.vue?vue&type=template&id=53c89962&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/multi-select.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ var multi_selectvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  mixins: [field_values, select_values],
  components: {
    'validation': validation
  },
  data: function data() {
    return {
      tmpFiltered: [],
      tmpValues: []
    };
  },
  created: function created() {
    var _this = this;

    this.tmpFiltered = this.options.filter(function (option) {
      return !~_this.values.findIndex(function (value) {
        return value === option.value;
      });
    });
    this.tmpValues = this.options.filter(function (option) {
      return ~_this.values.findIndex(function (value) {
        return value === option.value;
      });
    });
  },
  computed: {
    filteredOptions: {
      get: function get() {
        return this.tmpFiltered;
      },
      set: function set(values) {
        this.tmpFiltered = values;
      }
    },
    valueOptions: {
      get: function get() {
        return this.tmpValues;
      },
      set: function set(values) {
        this.tmpValues = values;
        this.values = this.tmpValues.map(function (value) {
          return value.value;
        });
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/multi-select.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_multi_selectvue_type_script_lang_js_ = (multi_selectvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/multi-select.vue





/* normalize component */

var multi_select_component = Object(componentNormalizer["default"])(
  types_multi_selectvue_type_script_lang_js_,
  multi_selectvue_type_template_id_53c89962_render,
  multi_selectvue_type_template_id_53c89962_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var multi_select_api; }
multi_select_component.options.__file = "resources/assets/js/src/fields/types/multi-select.vue"
/* harmony default export */ var multi_select = (multi_select_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/select.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//


/* harmony default export */ var selectvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  components: {
    'single': single_select,
    'multi': multi_select
  },
  computed: {
    type: function type() {
      var field;

      if (this.comboId) {
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);
      } else {
        field = this.$store.getters.getField(this.fieldId);
      }

      if (field.options.settings.multiple) {
        return 'multi';
      }

      return 'single';
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/select.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_selectvue_type_script_lang_js_ = (selectvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/select.vue





/* normalize component */

var select_component = Object(componentNormalizer["default"])(
  types_selectvue_type_script_lang_js_,
  selectvue_type_template_id_7048990a_render,
  selectvue_type_template_id_7048990a_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var select_api; }
select_component.options.__file = "resources/assets/js/src/fields/types/select.vue"
/* harmony default export */ var types_select = (select_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/location.vue?vue&type=template&id=01933bf4&
var locationvue_type_template_id_01933bf4_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-form__group" },
    [
      _c(
        "validation",
        { attrs: { "status-error": _vm.errors, "input-name": _vm.inputName } },
        [
          _c("label", { attrs: { for: _vm.inputName + "[latitude]" } }, [
            _vm._v(_vm._s(_vm.name))
          ]),
          _vm._v(" "),
          _c("multi", {
            attrs: {
              "field-id": _vm.fieldId,
              "combo-id": _vm.comboId,
              "combo-item-id": _vm.comboItemId,
              "input-name": _vm.inputName
            },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(ref) {
                  var valueObj = ref.valueObj
                  return [
                    _c(
                      "div",
                      { staticClass: "o-form__vertical-list" },
                      [
                        _c(
                          "input-icon",
                          {
                            attrs: {
                              "pre-icon": _vm.latIcon.preIcon,
                              "post-icon": _vm.latIcon.postIcon
                            }
                          },
                          [
                            _c("input", {
                              attrs: {
                                type: "text",
                                id: _vm.inputName + "[latitude]",
                                name: _vm.inputName + "[latitude]"
                              },
                              domProps: {
                                value: valueObj.value && valueObj.value.latitude
                              },
                              on: {
                                keyup: function($event) {
                                  $event.stopPropagation()
                                  _vm.updateValue(
                                    valueObj,
                                    $event.target.value,
                                    "latitude"
                                  )
                                }
                              }
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "input-icon",
                          {
                            attrs: {
                              "pre-icon": _vm.lngIcon.preIcon,
                              "post-icon": _vm.lngIcon.postIcon
                            }
                          },
                          [
                            _c("input", {
                              attrs: {
                                type: "text",
                                id: _vm.inputName + "[longitude]",
                                name: _vm.inputName + "[longitude]"
                              },
                              domProps: {
                                value:
                                  valueObj.value && valueObj.value.longitude
                              },
                              on: {
                                keyup: function($event) {
                                  $event.stopPropagation()
                                  _vm.updateValue(
                                    valueObj,
                                    $event.target.value,
                                    "longitude"
                                  )
                                }
                              }
                            })
                          ]
                        )
                      ],
                      1
                    )
                  ]
                }
              }
            ])
          })
        ],
        1
      ),
      _vm._v(" "),
      _vm.field.helpText
        ? _c("div", {
            staticClass: "o-form__help-text l-full",
            domProps: { innerHTML: _vm._s(_vm.field.helpText) }
          })
        : _vm._e()
    ],
    1
  )
}
var locationvue_type_template_id_01933bf4_staticRenderFns = []
locationvue_type_template_id_01933bf4_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/location.vue?vue&type=template&id=01933bf4&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/location.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var locationvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  mixins: [field_values],
  data: function data() {
    return {
      latIcon: {
        preIcon: {
          text: 'Lat'
        },
        postIcon: false
      },
      lngIcon: {
        preIcon: {
          text: 'Lng'
        },
        postIcon: false
      }
    };
  },
  components: {
    'input-icon': input_icon,
    'validation': validation,
    'multi': multi
  },
  methods: {
    updateValue: function updateValue(valueObj, newValue, prop) {
      valueObj.value[prop] = newValue;

      if (this.comboId) {
        this.$store.commit('updateComboFieldValue', {
          fieldID: this.fieldId,
          comboID: this.comboId,
          comboItemId: this.comboItemId,
          newValue: valueObj
        });
      } else {
        this.$store.commit('updateValue', {
          fieldID: this.fieldId,
          newValue: valueObj
        });
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/location.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_locationvue_type_script_lang_js_ = (locationvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/location.vue





/* normalize component */

var location_component = Object(componentNormalizer["default"])(
  types_locationvue_type_script_lang_js_,
  locationvue_type_template_id_01933bf4_render,
  locationvue_type_template_id_01933bf4_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var location_api; }
location_component.options.__file = "resources/assets/js/src/fields/types/location.vue"
/* harmony default export */ var types_location = (location_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/wysiwyg.vue?vue&type=template&id=77d57d1e&
var wysiwygvue_type_template_id_77d57d1e_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-form__group" },
    [
      _c(
        "validation",
        { attrs: { "status-error": _vm.errors, "input-name": _vm.inputName } },
        [
          _c("label", { attrs: { for: _vm.inputName } }, [
            _vm._v(_vm._s(_vm.name))
          ]),
          _vm._v(" "),
          _c("multi", {
            attrs: {
              "field-id": _vm.fieldId,
              "combo-id": _vm.comboId,
              "combo-item-id": _vm.comboItemId,
              "input-name": _vm.inputName
            },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(ref) {
                  var valueObj = ref.valueObj
                  return [
                    _c("single-wysiwyg", {
                      attrs: {
                        "field-id": _vm.fieldId,
                        "combo-id": _vm.comboId,
                        "combo-item-id": _vm.comboItemId,
                        name: _vm.inputName,
                        "value-obj": valueObj
                      },
                      on: {
                        update: function($event) {
                          _vm.updateValue(valueObj, $event)
                        }
                      }
                    })
                  ]
                }
              }
            ])
          })
        ],
        1
      ),
      _vm._v(" "),
      _vm.field.helpText
        ? _c("div", {
            staticClass: "o-form__help-text l-full",
            domProps: { innerHTML: _vm._s(_vm.field.helpText) }
          })
        : _vm._e()
    ],
    1
  )
}
var wysiwygvue_type_template_id_77d57d1e_staticRenderFns = []
wysiwygvue_type_template_id_77d57d1e_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/wysiwyg.vue?vue&type=template&id=77d57d1e&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/single-wysiwyg.vue?vue&type=template&id=04af2707&
var single_wysiwygvue_type_template_id_04af2707_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("textarea", {
    style: { height: _vm.totalHeight + "px" },
    attrs: { id: _vm.inputName, name: _vm.inputName }
  })
}
var single_wysiwygvue_type_template_id_04af2707_staticRenderFns = []
single_wysiwygvue_type_template_id_04af2707_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/single-wysiwyg.vue?vue&type=template&id=04af2707&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/single-wysiwyg.vue?vue&type=script&lang=js&
//
//
//
//

/* harmony default export */ var single_wysiwygvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId', 'name', 'valueObj'],
  data: function data() {
    return {
      textareaElement: null,
      wysiwygInstance: null,
      totalHeight: 150,
      defaultConfig: {
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
        contentCss: '',
        // iframe styles
        stylesSet: [],
        extraPlugins: 'stylesheetparser'
      }
    };
  },
  computed: {
    config: function config() {
      var field;

      if (this.comboId) {
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);
      } else {
        field = this.$store.getters.getField(this.fieldId);
      }

      var fieldConfig = field.options.settings['editor_options'];
      var config = {};

      if (fieldConfig['format-tags']) {
        config.format_tags = fieldConfig['format-tags'];
      }

      if (fieldConfig['height']) {
        config.height = fieldConfig['height'];
      }

      if (fieldConfig['toolbar']) {
        config.toolbar = [fieldConfig['toolbar'].split(',')];
      }

      if (fieldConfig['extra-allowed-content']) {
        config.extraAllowedContent = fieldConfig['extra-allowed-content'];
      }

      if (fieldConfig['typography-styles']) {
        config.contentsCss = fieldConfig['typography-styles'];
      }

      config = Object.assign({}, this.defaultConfig, config);
      return config;
    },
    inputName: function inputName() {
      return this.name.replace('[]', "[".concat(this.valueObj.id, "]"));
    }
  },
  methods: {
    updateValue: function updateValue(newValue) {
      this.$emit('update', newValue);
    }
  },
  mounted: function mounted() {
    var name = 'move-' + this.fieldId;

    if (this.comboId) {
      name = 'move-' + this.fieldId + '-' + this.comboId + '-' + this.comboItemId;
    }

    EventBus.$on(name, function () {
      updateEditorHeight.call(this);
      destoryEditor.call(this);
      mountEditor.call(this);
    }.bind(this));
    mountEditor.call(this);
  },
  beforeDestroy: function beforeDestroy() {
    destoryEditor.call(this);
  }
});

function updateEditorHeight() {
  this.totalHeight = this.textareaElement.nextElementSibling.offsetHeight;
}

function mountEditor() {
  var _this = this;

  var textarea = this.$el;
  this.textareaElement = textarea;
  CKEDITOR.replace(this.textareaElement, this.config);
  this.wysiwygInstance = this.textareaElement.name;
  CKEDITOR.instances[this.wysiwygInstance].setData(this.valueObj.value);
  CKEDITOR.instances[this.wysiwygInstance].on('change', function () {
    _this.updateValue(CKEDITOR.instances[_this.wysiwygInstance].getData());
  });
}

function destoryEditor() {
  CKEDITOR.instances[this.wysiwygInstance].destroy(true);
}
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/single-wysiwyg.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_single_wysiwygvue_type_script_lang_js_ = (single_wysiwygvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/single-wysiwyg.vue





/* normalize component */

var single_wysiwyg_component = Object(componentNormalizer["default"])(
  types_single_wysiwygvue_type_script_lang_js_,
  single_wysiwygvue_type_template_id_04af2707_render,
  single_wysiwygvue_type_template_id_04af2707_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var single_wysiwyg_api; }
single_wysiwyg_component.options.__file = "resources/assets/js/src/fields/types/single-wysiwyg.vue"
/* harmony default export */ var single_wysiwyg = (single_wysiwyg_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/wysiwyg.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var wysiwygvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  components: {
    'validation': validation,
    'multi': multi,
    'single-wysiwyg': single_wysiwyg
  },
  mixins: [field_values],
  methods: {
    updateValue: function updateValue(valueObj, newValue) {
      valueObj.value = newValue;

      if (this.comboId) {
        this.$store.commit('updateComboFieldValue', {
          fieldID: this.fieldId,
          comboID: this.comboId,
          comboItemId: this.comboItemId,
          newValue: valueObj
        });
      } else {
        this.$store.commit('updateValue', {
          fieldID: this.fieldId,
          newValue: valueObj
        });
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/wysiwyg.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_wysiwygvue_type_script_lang_js_ = (wysiwygvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/wysiwyg.vue





/* normalize component */

var wysiwyg_component = Object(componentNormalizer["default"])(
  types_wysiwygvue_type_script_lang_js_,
  wysiwygvue_type_template_id_77d57d1e_render,
  wysiwygvue_type_template_id_77d57d1e_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var wysiwyg_api; }
wysiwyg_component.options.__file = "resources/assets/js/src/fields/types/wysiwyg.vue"
/* harmony default export */ var types_wysiwyg = (wysiwyg_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/button.vue?vue&type=template&id=3fee9ab1&
var buttonvue_type_template_id_3fee9ab1_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-form__group" },
    [
      _c(
        "validation",
        { attrs: { "status-error": _vm.errors, "input-name": _vm.inputName } },
        [
          _c("label", { attrs: { for: _vm.inputName + "[label]" } }, [
            _vm._v(_vm._s(_vm.name))
          ]),
          _vm._v(" "),
          _c("multi", {
            attrs: {
              "field-id": _vm.fieldId,
              "combo-id": _vm.comboId,
              "combo-item-id": _vm.comboItemId,
              "input-name": _vm.inputName
            },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(ref) {
                  var valueObj = ref.valueObj
                  return [
                    _c(
                      "div",
                      { staticClass: "o-form__vertical-list" },
                      [
                        _c(
                          "input-icon",
                          {
                            attrs: {
                              "pre-icon": _vm.labelIcon.preIcon,
                              "post-icon": _vm.labelIcon.postIcon
                            }
                          },
                          [
                            _c("input", {
                              attrs: {
                                type: "text",
                                id: _vm.inputName + "[label]",
                                name: _vm.inputName + "[label]"
                              },
                              domProps: {
                                value: valueObj.value && valueObj.value.label
                              },
                              on: {
                                keyup: function($event) {
                                  $event.stopPropagation()
                                  _vm.updateValue(
                                    valueObj,
                                    $event.target.value,
                                    "label"
                                  )
                                }
                              }
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "input-icon",
                          {
                            attrs: {
                              "pre-icon": _vm.urlIcon.preIcon,
                              "post-icon": _vm.urlIcon.postIcon
                            }
                          },
                          [
                            _c("input", {
                              attrs: {
                                type: "text",
                                id: _vm.inputName + "[url]",
                                name: _vm.inputName + "[url]"
                              },
                              domProps: {
                                value: valueObj.value && valueObj.value.url
                              },
                              on: {
                                keyup: function($event) {
                                  $event.stopPropagation()
                                  _vm.updateValue(
                                    valueObj,
                                    $event.target.value,
                                    "url"
                                  )
                                }
                              }
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "input-icon",
                          {
                            attrs: {
                              "pre-icon": _vm.classIcon.preIcon,
                              "post-icon": _vm.classIcon.postIcon
                            }
                          },
                          [
                            _c("input", {
                              attrs: {
                                type: "text",
                                id: _vm.inputName + "[class]",
                                name: _vm.inputName + "[class]"
                              },
                              domProps: {
                                value: valueObj.value && valueObj.value.class
                              },
                              on: {
                                keyup: function($event) {
                                  $event.stopPropagation()
                                  _vm.updateValue(
                                    valueObj,
                                    $event.target.value,
                                    "class"
                                  )
                                }
                              }
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "input-icon",
                          {
                            attrs: {
                              "pre-icon": _vm.idIcon.preIcon,
                              "post-icon": _vm.idIcon.postIcon
                            }
                          },
                          [
                            _c("input", {
                              attrs: {
                                type: "text",
                                id: _vm.inputName + "[id]",
                                name: _vm.inputName + "[id]"
                              },
                              domProps: {
                                value: valueObj.value && valueObj.value.id
                              },
                              on: {
                                keyup: function($event) {
                                  $event.stopPropagation()
                                  _vm.updateValue(
                                    valueObj,
                                    $event.target.value,
                                    "id"
                                  )
                                }
                              }
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "input-icon",
                          {
                            attrs: {
                              "pre-icon": _vm.targetIcon.preIcon,
                              "post-icon": _vm.targetIcon.postIcon
                            }
                          },
                          [
                            _c("input", {
                              attrs: {
                                type: "text",
                                id: _vm.inputName + "[target]",
                                name: _vm.inputName + "[target]"
                              },
                              domProps: {
                                value: valueObj.value && valueObj.value.target
                              },
                              on: {
                                keyup: function($event) {
                                  $event.stopPropagation()
                                  _vm.updateValue(
                                    valueObj,
                                    $event.target.value,
                                    "target"
                                  )
                                }
                              }
                            })
                          ]
                        )
                      ],
                      1
                    )
                  ]
                }
              }
            ])
          })
        ],
        1
      ),
      _vm._v(" "),
      _vm.field.helpText
        ? _c("div", {
            staticClass: "o-form__help-text l-full",
            domProps: { innerHTML: _vm._s(_vm.field.helpText) }
          })
        : _vm._e()
    ],
    1
  )
}
var buttonvue_type_template_id_3fee9ab1_staticRenderFns = []
buttonvue_type_template_id_3fee9ab1_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/button.vue?vue&type=template&id=3fee9ab1&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/button.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var buttonvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  mixins: [field_values],
  data: function data() {
    return {
      labelIcon: {
        preIcon: {
          text: 'Label'
        },
        postIcon: false
      },
      urlIcon: {
        preIcon: {
          text: 'Url'
        },
        postIcon: false
      },
      classIcon: {
        preIcon: {
          text: 'Class'
        },
        postIcon: false
      },
      idIcon: {
        preIcon: {
          text: 'ID'
        },
        postIcon: false
      },
      targetIcon: {
        preIcon: {
          text: 'Target'
        },
        postIcon: false
      }
    };
  },
  components: {
    'input-icon': input_icon,
    'validation': validation,
    'multi': multi
  },
  methods: {
    updateValue: function updateValue(valueObj, newValue, prop) {
      valueObj.value[prop] = newValue;

      if (this.comboId) {
        this.$store.commit('updateComboFieldValue', {
          fieldID: this.fieldId,
          comboID: this.comboId,
          comboItemId: this.comboItemId,
          newValue: valueObj
        });
      } else {
        this.$store.commit('updateValue', {
          fieldID: this.fieldId,
          newValue: valueObj
        });
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/button.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_buttonvue_type_script_lang_js_ = (buttonvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/button.vue





/* normalize component */

var button_component = Object(componentNormalizer["default"])(
  types_buttonvue_type_script_lang_js_,
  buttonvue_type_template_id_3fee9ab1_render,
  buttonvue_type_template_id_3fee9ab1_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var button_api; }
button_component.options.__file = "resources/assets/js/src/fields/types/button.vue"
/* harmony default export */ var types_button = (button_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/boolean.vue?vue&type=template&id=87f7448e&
var booleanvue_type_template_id_87f7448e_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-form__group" },
    [
      _c(
        "validation",
        { attrs: { "status-error": _vm.errors, "input-name": _vm.inputName } },
        [
          _c("div", { staticClass: "o-form__list" }, [
            _c("div", { staticClass: "o-switch" }, [
              _c("label", [
                _c("input", {
                  attrs: { type: "hidden", name: _vm.inputName },
                  domProps: { value: _vm.checked }
                }),
                _vm._v(" "),
                _c("input", {
                  attrs: { type: "checkbox", id: _vm.inputName },
                  domProps: { checked: _vm.checked },
                  on: {
                    change: function($event) {
                      _vm.onChange(_vm.valueObj, _vm.checked)
                    }
                  }
                }),
                _vm._v(" "),
                _c("label", [
                  _c("div", {
                    staticClass: "o-switch__text",
                    attrs: { "data-yes": "on", "data-no": "off" }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("label", { attrs: { for: _vm.inputName } }, [
                _vm._v(_vm._s(_vm.name))
              ])
            ])
          ])
        ]
      )
    ],
    1
  )
}
var booleanvue_type_template_id_87f7448e_staticRenderFns = []
booleanvue_type_template_id_87f7448e_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/boolean.vue?vue&type=template&id=87f7448e&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/boolean.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var booleanvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  mixins: [field_values],
  components: {
    'validation': validation
  },
  computed: {
    valueObj: function valueObj() {
      var _this = this;

      var value;
      var field;

      if (this.comboId) {
        var combo = this.$store.getters.getField(this.comboId);
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);

        if (combo && combo.values.length) {
          var values = combo.values.filter(function (value) {
            return value.id === _this.comboItemId;
          });

          if (values.length && values[0][this.fieldId]) {
            return values[0][this.fieldId][0];
          }
        }
      } else {
        field = this.$store.getters.getField(this.fieldId);

        if (field.values.length) {
          return field.values[0];
        }
      }
    },
    checked: function checked() {
      var _this2 = this;

      var value;
      var field;

      if (this.comboId) {
        var combo = this.$store.getters.getField(this.comboId);
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);

        if (combo && combo.values.length) {
          var values = combo.values.filter(function (value) {
            return value.id === _this2.comboItemId;
          });

          if (values.length && values[0][this.fieldId]) {
            value = values[0][this.fieldId][0].value;
          }
        }
      } else {
        field = this.$store.getters.getField(this.fieldId);

        if (field.values.length) {
          value = field.values.map(function (value) {
            return value.value;
          })[0];
        }
      }

      if (value === '') {
        return +field.options.settings.initial_value;
      } else {
        return value || 0;
      }
    }
  },
  methods: {
    onChange: function onChange(valueObj, newValue) {
      valueObj.value = !newValue ? 1 : 0;

      if (this.comboId) {
        this.$store.commit('updateComboFieldValue', {
          fieldID: this.fieldId,
          comboID: this.comboId,
          comboItemId: this.comboItemId,
          newValue: valueObj
        });
      } else {
        this.$store.commit('updateValue', {
          fieldID: this.fieldId,
          newValue: valueObj
        });
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/boolean.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_booleanvue_type_script_lang_js_ = (booleanvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/boolean.vue





/* normalize component */

var boolean_component = Object(componentNormalizer["default"])(
  types_booleanvue_type_script_lang_js_,
  booleanvue_type_template_id_87f7448e_render,
  booleanvue_type_template_id_87f7448e_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var boolean_api; }
boolean_component.options.__file = "resources/assets/js/src/fields/types/boolean.vue"
/* harmony default export */ var types_boolean = (boolean_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/fields/types/types.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//









var typeMap = {
  'text': 'text-input',
  'email': 'email-input',
  'phone': 'phone-input',
  'combo': 'combo',
  'select': 'select-input',
  'location': 'location-input',
  'wysiwyg': 'wysiwyg-input',
  'button': 'button-input',
  'boolean': 'boolean-input'
};
/* harmony default export */ var typesvue_type_script_lang_js_ = ({
  name: 'types',
  props: ['field', 'comboId', 'comboItemId'],
  components: {
    'text-input': types_text,
    'email-input': email,
    'phone-input': phone,
    combo: types_combo,
    'select-input': types_select,
    'location-input': types_location,
    'wysiwyg-input': types_wysiwyg,
    'button-input': types_button,
    'boolean-input': types_boolean
  },
  computed: {
    type: function type() {
      var type = typeMap[this.field.options.typeKey];
      return type || 'text-input';
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/types.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_typesvue_type_script_lang_js_ = (typesvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/fields/types/types.vue





/* normalize component */

var types_component = Object(componentNormalizer["default"])(
  types_typesvue_type_script_lang_js_,
  typesvue_type_template_id_c5a3b86c_render,
  typesvue_type_template_id_c5a3b86c_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var types_api; }
types_component.options.__file = "resources/assets/js/src/fields/types/types.vue"
/* harmony default export */ var types_types = (types_component.exports);
// CONCATENATED MODULE: ./resources/assets/js/src/fields/store/index.js


function getStore() {
  return new vuex_esm["default"].Store({
    state: {
      fields: []
    },
    getters: {
      getField: function getField(state) {
        return function (id) {
          var field = state.fields.filter(function (field) {
            return field.id === id;
          });

          if (field.length) {
            return field[0];
          }
        };
      },
      getComboField: function getComboField(state) {
        return function (comboID, fieldID) {
          var comboItem = state.fields.filter(function (field) {
            return field.id === comboID;
          });

          if (comboItem.length) {
            var field = comboItem[0].fields.filter(function (field) {
              return field.id === fieldID;
            });

            if (field.length) {
              return field[0];
            }
          }
        };
      }
    },
    mutations: {
      setFields: function setFields(state, _ref) {
        var fields = _ref.fields;
        state.fields = fields;
      },
      // Field Mutations
      updateValue: function updateValue(state, _ref2) {
        var fieldID = _ref2.fieldID,
            newValue = _ref2.newValue;
        state.fields = state.fields.map(function (field) {
          if (field.id !== fieldID) {
            return field;
          }

          field.values = field.values.map(function (value) {
            if (value.id !== newValue.id) {
              return value;
            }

            value = Object.assign(value, newValue);
            return value;
          });
          return field;
        });
      },
      updateValues: function updateValues(state, _ref3) {
        var fieldID = _ref3.fieldID,
            newValues = _ref3.newValues;
        state.fields = state.fields.map(function (field) {
          if (field.id !== fieldID) {
            return field;
          }

          field.values = newValues;
          return field;
        });
      },
      addValue: function addValue(state, _ref4) {
        var fieldID = _ref4.fieldID,
            valueObj = _ref4.valueObj;
        state.fields = state.fields.map(function (field) {
          if (field.id !== fieldID) {
            return field;
          }

          field.values.push(Object.assign(valueObj, {
            id: createUniqueHash()
          }));
          return field;
        });
      },
      removeValue: function removeValue(state, _ref5) {
        var fieldID = _ref5.fieldID,
            valueID = _ref5.valueID;
        state.fields = state.fields.map(function (field) {
          if (field.id !== fieldID) {
            return field;
          }

          field.values = field.values.filter(function (value) {
            return value.id !== valueID;
          });
          return field;
        });
      },
      // Combo Item Mutations
      updateComboItemValues: function updateComboItemValues(state, _ref6) {
        var comboID = _ref6.comboID,
            newValues = _ref6.newValues;
        state.fields = state.fields.map(function (field) {
          if (field.id !== comboID) {
            return field;
          }

          field.values = newValues;
          return field;
        });
      },
      addComboItemValue: function addComboItemValue(state, _ref7) {
        var comboID = _ref7.comboID,
            newValueObj = _ref7.newValueObj;
        state.fields = state.fields.map(function (field) {
          if (field.id !== comboID) {
            return field;
          }

          newValueObj = Object.keys(newValueObj).reduce(function (acc, fieldID) {
            if (fieldID === 'id') {
              return acc;
            }

            acc[fieldID] = newValueObj[fieldID].map(function (value) {
              return Object.assign(value, {
                id: createUniqueHash()
              });
            });
            return acc;
          }, {});
          field.values.push(Object.assign(newValueObj, {
            id: field.values.length
          }));
          return field;
        });
      },
      removeComboItem: function removeComboItem(state, _ref8) {
        var comboID = _ref8.comboID,
            comboItemID = _ref8.comboItemID;
        state.fields = state.fields.map(function (field) {
          if (field.id !== comboID) {
            return field;
          }

          field.values = field.values.filter(function (valueObj) {
            return valueObj.id !== comboItemID;
          });
          return field;
        });
      },
      // Combo Field Mutations
      updateComboFieldValue: function updateComboFieldValue(state, _ref9) {
        var fieldID = _ref9.fieldID,
            comboID = _ref9.comboID,
            comboItemId = _ref9.comboItemId,
            newValue = _ref9.newValue;
        state.fields = state.fields.map(function (field) {
          if (field.id !== comboID) {
            return field;
          }

          field.values = field.values.map(function (valuesObj) {
            if (valuesObj.id !== comboItemId) {
              return valuesObj;
            }

            valuesObj[fieldID] = valuesObj[fieldID].map(function (value) {
              if (value.id !== newValue.id) {
                return value;
              }

              value = Object.assign(value, newValue);
              return value;
            });
            return valuesObj;
          });
          return field;
        });
      },
      updateComboFieldValues: function updateComboFieldValues(state, _ref10) {
        var fieldID = _ref10.fieldID,
            comboID = _ref10.comboID,
            comboItemId = _ref10.comboItemId,
            newValues = _ref10.newValues;
        state.fields = state.fields.map(function (field) {
          if (field.id !== comboID) {
            return field;
          }

          field.values.map(function (valuesObj) {
            if (valuesObj.id !== comboItemId) {
              return valuesObj;
            }

            valuesObj[fieldID] = newValues;
            return valuesObj;
          });
          return field;
        });
      },
      addComboFieldValue: function addComboFieldValue(state, _ref11) {
        var fieldID = _ref11.fieldID,
            comboID = _ref11.comboID,
            comboItemId = _ref11.comboItemId,
            valueObj = _ref11.valueObj;
        state.fields = state.fields.map(function (field) {
          if (field.id !== comboID) {
            return field;
          }

          field.values = field.values.map(function (valuesObj) {
            if (valuesObj.id !== comboItemId) {
              return valuesObj;
            }

            valuesObj[fieldID].push(Object.assign(valueObj, {
              id: createUniqueHash()
            }));
            return valuesObj;
          });
          return field;
        });
      },
      removeComboFieldValue: function removeComboFieldValue(state, _ref12) {
        var fieldID = _ref12.fieldID,
            comboID = _ref12.comboID,
            comboItemId = _ref12.comboItemId,
            valueID = _ref12.valueID;
        state.fields = state.fields.map(function (field) {
          if (field.id !== comboID) {
            return field;
          }

          field.values = field.values.map(function (valuesObj) {
            if (valuesObj.id !== comboItemId) {
              return valuesObj;
            }

            valuesObj[fieldID] = valuesObj[fieldID].filter(function (value) {
              return value.id !== valueID;
            });
            return valuesObj;
          });
          return field;
        });
      }
    }
  });
}
// CONCATENATED MODULE: ./resources/assets/js/src/fields/index.js







vue_default.a.config.productionTip = false;
vue_default.a.component('draggable', vuedraggable);
vue_default.a.component('types', types_types);
vue_default.a.use(vuex_esm["default"]);
function Fields() {
  var fieldEls = document.querySelectorAll('.js-fields');
  var fields = Array.from(fieldEls);
  return fields.map(function (el) {
    var name = el.dataset.name;
    var store = getStore();
    var fieldGroups = window.fieldGroups[name];
    fieldGroups = processFields(fieldGroups);
    store.commit('setFields', {
      fields: fieldGroups
    });
    return new vue_default.a({
      store: store,
      render: function render(h) {
        return h(App);
      }
    }).$mount(el);
  });
}

function processFields(fields) {
  return fields.map(function (field) {
    if (field.options.typeKey === 'combo') {
      field = processCombo(field);
    } else {
      field.values = processValues(field.values);
      field.emptyValue = createEmptyValueObj(field);

      if (!field.values.length) {
        var newValue = deepClone(field.emptyValue);
        newValue.id = 0;
        field.values.push(newValue);
      }
    }

    return field;
  });
}

function processValues(values) {
  return values.map(function (value, id) {
    return {
      value: value,
      id: id
    };
  });
}

function createEmptyValueObj(field) {
  var emptyValue;

  switch (field.options.typeKey) {
    case 'checkbox':
      emptyValue = 0;
      break;

    case 'location':
      emptyValue = {
        latitude: '',
        longitude: ''
      };
      break;

    case 'button':
      emptyValue = {
        label: '',
        url: '',
        class: '',
        id: '',
        target: ''
      };
      break;

    default:
      emptyValue = '';
      break;
  }

  return {
    value: emptyValue
  };
}

function processCombo(combo) {
  combo.values = combo.values.map(function (comboItemValues, index) {
    var fieldIds = Object.keys(comboItemValues);
    var values = fieldIds.reduce(function (acc, fieldID) {
      acc[fieldID] = processValues(comboItemValues[fieldID]);
      return acc;
    }, {});
    values.id = index;
    return values;
  });
  combo.errors = combo.errors.map(function (comboItemErrors, index) {
    comboItemErrors.id = index;
    return comboItemErrors;
  });
  combo.fields = combo.fields.map(function (field) {
    field.emptyValue = createEmptyValueObj(field);
    return field;
  });
  combo.emptyValue = combo.fields.reduce(function (acc, field) {
    acc[field.id] = [field.emptyValue];
    return acc;
  }, {});
  return combo;
}
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/medialib/components/Media.vue?vue&type=template&id=27b52f8c&
var Mediavue_type_template_id_27b52f8c_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "mlapp" }, [
    _c("div", { staticClass: "ml" }, [
      _c("div", { staticClass: "ml__options o-form l-flexcols" }, [
        _c("div", { staticClass: "ml__options-layout l-flexcols-1" }, [
          _c("div", { staticClass: "layout " }, [
            _c(
              "button",
              {
                staticClass: "o-btn o-btn--xs",
                class: { "o-btn--active": _vm.layout === "tiles" },
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    _vm.setLayout("tiles")
                  }
                }
              },
              [_vm._v("Tiles")]
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "o-btn o-btn--xs",
                class: { "o-btn--active": _vm.layout === "list" },
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    _vm.setLayout("list")
                  }
                }
              },
              [_vm._v("List")]
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "l-flexcols-2" }, [
          _c(
            "div",
            {
              staticClass: "search",
              class: { "search--loading": _vm.search.isLoading() }
            },
            [
              _c("div", { staticClass: "search__inp" }, [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.keywords,
                      expression: "keywords"
                    }
                  ],
                  staticClass: "inp",
                  attrs: { type: "text", placeholder: "Search for..." },
                  domProps: { value: _vm.keywords },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.keywords = $event.target.value
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "search__btn" }, [
                _c(
                  "button",
                  {
                    staticClass: "o-btn o-btn--xs",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        _vm.searchReset()
                      }
                    }
                  },
                  [_vm._v("Clear")]
                )
              ])
            ]
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "ml__view l-flexcols" }, [
        _c("div", { staticClass: "ml__tree l-flexcols-1" }, [
          _c("div", { staticClass: "ml__heading" }, [
            _vm._v("\n                    Folders Tree\n                ")
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "ml__body" }, [_c("DirectoryTree")], 1)
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "ml__preview l-flexcols-2" },
          [
            _vm.search.hasKeywords()
              ? [
                  _c("div", { staticClass: "ml__heading" }, [
                    _vm._v(
                      "\n                        Found " +
                        _vm._s(_vm.search.getResultsCount()) +
                        " results for `" +
                        _vm._s(_vm.search.keywords) +
                        "`\n                    "
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "ml__body" }, [
                    _vm.search.hasResults()
                      ? _c(
                          "div",
                          { staticClass: "search-results" },
                          [
                            _c("Content", {
                              attrs: {
                                items: _vm.search.getResults(),
                                folders: {}
                              }
                            })
                          ],
                          1
                        )
                      : _c("div", { staticClass: "search-results" }, [
                          _c("p", [_vm._v("No results found.")])
                        ])
                  ])
                ]
              : [
                  _c("div", { staticClass: "ml__heading" }, [
                    _vm.active.isSet()
                      ? _c(
                          "div",
                          { staticClass: "breadcrumbs" },
                          [
                            _c(
                              "span",
                              {
                                staticClass: "btn-skip o-btn",
                                class: { "o-btn--disabled": !_vm.back.isSet() },
                                attrs: {
                                  title:
                                    "Skip between current and previous folder"
                                },
                                on: {
                                  click: function($event) {
                                    _vm.folderSelected(_vm.back)
                                  }
                                }
                              },
                              [_vm._v("⇄")]
                            ),
                            _vm._v(" "),
                            _vm._l(_vm.active.breadcrumbs(), function(folder) {
                              return [
                                folder.parent
                                  ? _c(
                                      "span",
                                      { staticClass: "breadcrumbs__separator" },
                                      [_vm._v(">")]
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                _c(
                                  "span",
                                  {
                                    staticClass: "breadcrumbs__piece",
                                    class: {
                                      breadcrumbs__child: folder.parent
                                    },
                                    on: {
                                      click: function($event) {
                                        _vm.folderSelected(folder)
                                      }
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(folder.name) +
                                        "\n                                "
                                    )
                                  ]
                                )
                              ]
                            })
                          ],
                          2
                        )
                      : _vm._e()
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "ml__body" },
                    [
                      _c("div", { staticClass: "folder__act" }, [
                        _c(
                          "button",
                          {
                            staticClass: "o-btn o-btn--xs",
                            on: {
                              click: function($event) {
                                _vm.createFolder(_vm.active)
                              }
                            }
                          },
                          [_vm._v("Add folder")]
                        ),
                        _vm._v(" "),
                        !_vm.active.isRoot()
                          ? _c(
                              "button",
                              {
                                staticClass: "o-btn o-btn--xs",
                                on: {
                                  click: function($event) {
                                    _vm.editFolder(_vm.active)
                                  }
                                }
                              },
                              [_vm._v("Edit folder")]
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        !_vm.active.isRoot()
                          ? _c(
                              "button",
                              {
                                staticClass: "o-btn o-btn--xs",
                                on: {
                                  click: function($event) {
                                    _vm.removeFolder(_vm.active)
                                  }
                                }
                              },
                              [_vm._v("Remove folder")]
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "o-btn o-btn--xs",
                            on: { click: _vm.onUploadClick }
                          },
                          [_vm._v(_vm._s(_vm.upload.getLabel()))]
                        ),
                        _vm._v(" "),
                        _vm.upload.isInitialised()
                          ? _c("div", { staticClass: "ml-upload" }, [
                              _c("div", { staticClass: "ml-upload__field" }, [
                                _c("input", {
                                  ref: "fileInput",
                                  staticStyle: { display: "none" },
                                  attrs: {
                                    type: "file",
                                    multiple: "",
                                    accept: "*/*"
                                  },
                                  on: { change: _vm.onFileSelected }
                                }),
                                _vm._v(" "),
                                _c(
                                  "button",
                                  {
                                    staticClass: "o-btn o-btn--xs",
                                    on: {
                                      click: function($event) {
                                        _vm.$refs.fileInput.click()
                                      }
                                    }
                                  },
                                  [_vm._v("Select file(s)")]
                                ),
                                _vm._v(" "),
                                _vm.upload.hasFiles()
                                  ? _c(
                                      "button",
                                      {
                                        staticClass: "o-btn o-btn--xs",
                                        on: {
                                          click: function($event) {
                                            _vm.onUpload()
                                          }
                                        }
                                      },
                                      [_vm._v("Upload")]
                                    )
                                  : _vm._e()
                              ]),
                              _vm._v(" "),
                              _vm.upload.hasFiles()
                                ? _c(
                                    "div",
                                    { staticClass: "ml-upload__output" },
                                    [
                                      _c(
                                        "ul",
                                        _vm._l(_vm.upload.getFiles(), function(
                                          u
                                        ) {
                                          return _c("li", [
                                            _vm._v(_vm._s(u.name))
                                          ])
                                        })
                                      )
                                    ]
                                  )
                                : _vm._e()
                            ])
                          : _vm._e()
                      ]),
                      _vm._v(" "),
                      _c("Folder")
                    ],
                    1
                  )
                ]
          ],
          2
        )
      ])
    ]),
    _vm._v(" "),
    _vm.modal.isSet()
      ? _c(
          "div",
          {
            staticClass: "m-details modal fade",
            attrs: {
              id: "myModal",
              tabindex: "-1",
              role: "dialog",
              "aria-labelledby": "myModalLabel"
            }
          },
          [
            _c(
              "div",
              { staticClass: "modal-dialog", attrs: { role: "document" } },
              [
                _c("div", { staticClass: "modal-content" }, [
                  _c("div", { staticClass: "modal-header" }, [
                    _vm._m(0),
                    _vm._v(" "),
                    _c(
                      "h4",
                      {
                        staticClass: "modal-title",
                        attrs: { id: "myModalLabel" }
                      },
                      [_vm._v(_vm._s(_vm.modal.item.filename))]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "modal-body" }, [
                    _c("div", { staticClass: "m-details__content" }, [
                      _c("div", { staticClass: "m-details__preview" }, [
                        _c("img", {
                          attrs: {
                            src:
                              "/media/" +
                              _vm.modal.item.id +
                              "/" +
                              _vm.modal.item.slug +
                              "." +
                              _vm.modal.item.extension,
                            alt: _vm.modal.item.filename
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _c("dl", { staticClass: "m-details__info" }, [
                        _c("dt", [_vm._v(_vm._s(_vm.modal.item.filename))]),
                        _vm._v(" "),
                        _c("dd", [
                          _c("small", [_vm._v("File type:")]),
                          _vm._v(" " + _vm._s(_vm.modal.item.extension))
                        ]),
                        _vm._v(" "),
                        _c("dd", [
                          _c("small", [_vm._v("Uploaded at:")]),
                          _vm._v(" " + _vm._s(_vm.modal.item.updated_at))
                        ]),
                        _vm._v(" "),
                        _c("dd", [
                          _c("small", [_vm._v("Dimensions:")]),
                          _vm._v(
                            " " +
                              _vm._s(JSON.parse(_vm.modal.item.meta).width) +
                              " x " +
                              _vm._s(JSON.parse(_vm.modal.item.meta).height)
                          )
                        ]),
                        _vm._v(" "),
                        _c("dd", [
                          _c("small", [_vm._v("File Size:")]),
                          _vm._v(" " + _vm._s(_vm.modal.item.filesize))
                        ]),
                        _vm._v(" "),
                        _c("dd", [
                          _c("small", [_vm._v("Uploaded by:")]),
                          _vm._v(" " + _vm._s(_vm.modal.item.uploaded_by))
                        ])
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _vm._m(1)
                ])
              ]
            )
          ]
        )
      : _vm._e()
  ])
}
var Mediavue_type_template_id_27b52f8c_staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "close",
        attrs: {
          type: "button",
          "data-dismiss": "modal",
          "aria-label": "Close"
        }
      },
      [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-footer" }, [
      _c(
        "button",
        {
          staticClass: "btn btn-default",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [_vm._v("Close")]
      ),
      _vm._v(" "),
      _c(
        "button",
        { staticClass: "btn btn-primary", attrs: { type: "button" } },
        [_vm._v("Save changes")]
      )
    ])
  }
]
Mediavue_type_template_id_27b52f8c_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/Media.vue?vue&type=template&id=27b52f8c&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/medialib/components/DirectoryTree.vue?vue&type=template&id=4f977bd3&
var DirectoryTreevue_type_template_id_4f977bd3_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "root--tree" }, [
    _c("ul", { staticClass: "media-tree" }, [
      _c(
        "li",
        {
          class: { "media-tree--active": _vm.folder.active },
          on: {
            click: function($event) {
              $event.stopPropagation()
              return _vm.folderSelected($event)
            }
          }
        },
        [
          _c("div", { staticClass: "media-tree__item" }, [
            _c(
              "svg",
              {
                attrs: {
                  xmlns: "http://www.w3.org/2000/svg",
                  viewBox: "0 0 85.04 56.69"
                }
              },
              [
                _c("path", {
                  attrs: {
                    d:
                      "M79.3 9.77H42.2a5.41 5.41 0 0 1-3.56-1.33L29.88.76a3.1 3.1 0 0 0-2-.76H3.54A3.49 3.49 0 0 0 0 3.42v47.73a5.66 5.66 0 0 0 5.74 5.54H79.3a5.64 5.64 0 0 0 5.7-5.54V15.32a5.64 5.64 0 0 0-5.7-5.55z"
                  }
                })
              ]
            ),
            _vm._v(" "),
            _c("span", [_vm._v(_vm._s(_vm.folder.name))])
          ]),
          _vm._v(" "),
          _vm.folder.children && _vm.folder.children.length
            ? _c(
                "ul",
                { staticClass: "media-tree__items" },
                _vm._l(_vm.folder.children, function(child) {
                  return _c("MediaTreeItem", {
                    key: child.id,
                    attrs: { folder: child }
                  })
                })
              )
            : _vm._e()
        ]
      )
    ])
  ])
}
var DirectoryTreevue_type_template_id_4f977bd3_staticRenderFns = []
DirectoryTreevue_type_template_id_4f977bd3_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/DirectoryTree.vue?vue&type=template&id=4f977bd3&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/medialib/components/MediaTreeItem.vue?vue&type=template&id=1eb062fd&
var MediaTreeItemvue_type_template_id_1eb062fd_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "li",
    {
      class: { "media-tree--active": _vm.folder.active },
      on: {
        click: function($event) {
          $event.stopPropagation()
          _vm.folderSelected(_vm.folder)
        }
      }
    },
    [
      _c("div", { staticClass: "media-tree__item" }, [
        _c(
          "svg",
          {
            attrs: {
              xmlns: "http://www.w3.org/2000/svg",
              viewBox: "0 0 85.04 56.69"
            }
          },
          [
            _c("path", {
              attrs: {
                d:
                  "M79.3 9.77H42.2a5.41 5.41 0 0 1-3.56-1.33L29.88.76a3.1 3.1 0 0 0-2-.76H3.54A3.49 3.49 0 0 0 0 3.42v47.73a5.66 5.66 0 0 0 5.74 5.54H79.3a5.64 5.64 0 0 0 5.7-5.54V15.32a5.64 5.64 0 0 0-5.7-5.55z"
              }
            })
          ]
        ),
        _vm._v(" "),
        _c("span", [_vm._v(_vm._s(_vm.folder.name))])
      ]),
      _vm._v(" "),
      _vm.folder.children && _vm.folder.children.length
        ? _c(
            "ul",
            { staticClass: "media-tree__items" },
            _vm._l(_vm.folder.children, function(child) {
              return _c("MediaTreeItem", {
                key: child.id,
                attrs: { folder: child }
              })
            })
          )
        : _vm._e()
    ]
  )
}
var MediaTreeItemvue_type_template_id_1eb062fd_staticRenderFns = []
MediaTreeItemvue_type_template_id_1eb062fd_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/MediaTreeItem.vue?vue&type=template&id=1eb062fd&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/medialib/components/MediaTreeItem.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ var MediaTreeItemvue_type_script_lang_js_ = ({
  name: 'MediaTreeItem',
  props: ['folder'],
  methods: {
    folderSelected: function folderSelected(folder) {
      this.$store.dispatch('folderSelected', folder);
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/MediaTreeItem.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_MediaTreeItemvue_type_script_lang_js_ = (MediaTreeItemvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/MediaTreeItem.vue





/* normalize component */

var MediaTreeItem_component = Object(componentNormalizer["default"])(
  components_MediaTreeItemvue_type_script_lang_js_,
  MediaTreeItemvue_type_template_id_1eb062fd_render,
  MediaTreeItemvue_type_template_id_1eb062fd_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var MediaTreeItem_api; }
MediaTreeItem_component.options.__file = "resources/assets/js/src/medialib/components/MediaTreeItem.vue"
/* harmony default export */ var MediaTreeItem = (MediaTreeItem_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/medialib/components/DirectoryTree.vue?vue&type=script&lang=js&
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var DirectoryTreevue_type_script_lang_js_ = ({
  components: {
    MediaTreeItem: MediaTreeItem
  },
  computed: _objectSpread({}, Object(vuex_esm["mapState"])(['folder'])),
  methods: {
    folderSelected: function folderSelected() {
      this.$store.dispatch('folderSelected', this.folder);
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/DirectoryTree.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_DirectoryTreevue_type_script_lang_js_ = (DirectoryTreevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/DirectoryTree.vue





/* normalize component */

var DirectoryTree_component = Object(componentNormalizer["default"])(
  components_DirectoryTreevue_type_script_lang_js_,
  DirectoryTreevue_type_template_id_4f977bd3_render,
  DirectoryTreevue_type_template_id_4f977bd3_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var DirectoryTree_api; }
DirectoryTree_component.options.__file = "resources/assets/js/src/medialib/components/DirectoryTree.vue"
/* harmony default export */ var DirectoryTree = (DirectoryTree_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/medialib/components/Folder.vue?vue&type=template&id=2c962af6&
var Foldervue_type_template_id_2c962af6_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _vm.active.hasContent()
      ? _c(
          "div",
          [
            _c("Content", {
              attrs: { items: _vm.active.items, folders: _vm.active.children }
            })
          ],
          1
        )
      : _c("h3", [_vm._v("No content")])
  ])
}
var Foldervue_type_template_id_2c962af6_staticRenderFns = []
Foldervue_type_template_id_2c962af6_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/Folder.vue?vue&type=template&id=2c962af6&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/medialib/components/Content.vue?vue&type=template&id=4b031da1&
var Contentvue_type_template_id_4b031da1_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { class: "folder folder--" + _vm.layout },
    [
      _vm._l(_vm.folders, function(child) {
        return _c(
          "div",
          { key: child.id, staticClass: "folder__item folder__item--folder" },
          [
            _c(
              "div",
              {
                staticClass: "folder__icon",
                on: {
                  click: function($event) {
                    $event.stopPropagation()
                    _vm.folderSelected(child)
                  }
                }
              },
              [
                _c(
                  "svg",
                  {
                    attrs: {
                      xmlns: "http://www.w3.org/2000/svg",
                      viewBox: "0 0 85.04 56.69"
                    }
                  },
                  [
                    _c("path", {
                      attrs: {
                        d:
                          "M79.3 9.77H42.2a5.41 5.41 0 0 1-3.56-1.33L29.88.76a3.1 3.1 0 0 0-2-.76H3.54A3.49 3.49 0 0 0 0 3.42v47.73a5.66 5.66 0 0 0 5.74 5.54H79.3a5.64 5.64 0 0 0 5.7-5.54V15.32a5.64 5.64 0 0 0-5.7-5.55z"
                      }
                    })
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _c("dl", { staticClass: "folder__info" }, [
              _c("dt", [_vm._v(_vm._s(child.name))]),
              _vm._v(" "),
              _c("dd", [
                _c("small", [_vm._v("Subfolders: ")]),
                _vm._v(" " + _vm._s(child.children.length))
              ]),
              _vm._v(" "),
              _c("dd", [
                _c("small", [_vm._v("Items: ")]),
                _vm._v(" " + _vm._s((child.items && child.items.length) || 0))
              ])
            ])
          ]
        )
      }),
      _vm._v(" "),
      _vm._l(_vm.items, function(item) {
        return _c(
          "div",
          {
            key: "item-" + item.id,
            class: "folder__item folder__item--" + item.extension
          },
          [
            _c("div", { staticClass: "folder__preview" }, [
              _c(
                "div",
                {
                  staticClass: "folder__image",
                  on: {
                    click: function($event) {
                      _vm.modal(item)
                    }
                  }
                },
                [
                  _c("img", {
                    attrs: {
                      src:
                        "/media/" +
                        item.id +
                        "/" +
                        item.slug +
                        "." +
                        item.extension,
                      alt: item.filename
                    }
                  })
                ]
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "folder__details" }, [
              _c("dl", { staticClass: "folder__info" }, [
                _c("dt", [_vm._v(_vm._s(item.filename))]),
                _vm._v(" "),
                _c("dd", [
                  _c("small", [_vm._v("Dimensions:")]),
                  _vm._v(
                    " " +
                      _vm._s(JSON.parse(item.meta).width) +
                      " x " +
                      _vm._s(JSON.parse(item.meta).height)
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "folder__options" }, [
                _vm._m(0, true),
                _vm._v(" "),
                _c("div", { staticClass: "folder__options-list" }, [
                  _c(
                    "a",
                    {
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          _vm.onChange("edit", item)
                        }
                      }
                    },
                    [_vm._v("Edit")]
                  ),
                  _vm._v(" "),
                  _c(
                    "a",
                    {
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          _vm.onChange("remove", item)
                        }
                      }
                    },
                    [_vm._v("Remove")]
                  )
                ])
              ])
            ])
          ]
        )
      })
    ],
    2
  )
}
var Contentvue_type_template_id_4b031da1_staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "folder__options-title" }, [
      _vm._v("Actions: "),
      _c("span", { staticClass: "chevron--bottom" })
    ])
  }
]
Contentvue_type_template_id_4b031da1_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/Content.vue?vue&type=template&id=4b031da1&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/medialib/components/Content.vue?vue&type=script&lang=js&
function Contentvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { Contentvue_type_script_lang_js_defineProperty(target, key, source[key]); }); } return target; }

function Contentvue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var Contentvue_type_script_lang_js_ = ({
  data: function data() {
    return {
      key: ""
    };
  },
  props: ['items', 'folders'],
  computed: Contentvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])(['layout'])),
  methods: {
    folderSelected: function folderSelected(folder) {
      this.$store.dispatch('folderSelected', folder);
    },
    modal: function modal(item) {
      // TODO: promise with modal callback
      this.$store.dispatch('modal', item);
      $('#myModal').modal();
    },
    onChange: function onChange(event, item) {
      var c = false;

      switch (event) {
        case 'edit':
          c = confirm("Are you sure?");

          if (c === true) {
            console.log("Requested edit of item %d", item.id);
          }

          break;

        case 'remove':
          c = confirm("Are you sure?");

          if (c === true) {
            this.$store.dispatch('removeItem', item);
          }

          break;
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/Content.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Contentvue_type_script_lang_js_ = (Contentvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/Content.vue





/* normalize component */

var Content_component = Object(componentNormalizer["default"])(
  components_Contentvue_type_script_lang_js_,
  Contentvue_type_template_id_4b031da1_render,
  Contentvue_type_template_id_4b031da1_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Content_api; }
Content_component.options.__file = "resources/assets/js/src/medialib/components/Content.vue"
/* harmony default export */ var Content = (Content_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/medialib/components/Folder.vue?vue&type=script&lang=js&
function Foldervue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { Foldervue_type_script_lang_js_defineProperty(target, key, source[key]); }); } return target; }

function Foldervue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var Foldervue_type_script_lang_js_ = ({
  computed: Foldervue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])(['active'])),
  components: {
    Content: Content
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/Folder.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Foldervue_type_script_lang_js_ = (Foldervue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/Folder.vue





/* normalize component */

var Folder_component = Object(componentNormalizer["default"])(
  components_Foldervue_type_script_lang_js_,
  Foldervue_type_template_id_2c962af6_render,
  Foldervue_type_template_id_2c962af6_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Folder_api; }
Folder_component.options.__file = "resources/assets/js/src/medialib/components/Folder.vue"
/* harmony default export */ var Folder = (Folder_component.exports);
// EXTERNAL MODULE: ./node_modules/lodash/debounce.js
var debounce = __webpack_require__("./node_modules/lodash/debounce.js");
var debounce_default = /*#__PURE__*/__webpack_require__.n(debounce);

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/medialib/components/Media.vue?vue&type=script&lang=js&
function Mediavue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { Mediavue_type_script_lang_js_defineProperty(target, key, source[key]); }); } return target; }

function Mediavue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//





/* harmony default export */ var Mediavue_type_script_lang_js_ = ({
  created: function created() {
    this.$store.dispatch('loadLibrary');
  },
  data: function data() {
    return {};
  },
  watch: {
    keywords: function keywords() {
      this.searchItems();
    }
  },
  computed: Mediavue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])(['active', 'back', 'search', 'modal', 'layout', 'upload']), {
    keywords: {
      set: function set(keywords) {
        this.$store.dispatch('search', keywords);
      },
      get: function get() {
        return this.search.keywords;
      }
    }
  }),
  components: {
    Content: Content,
    Folder: Folder,
    DirectoryTree: DirectoryTree
  },
  methods: {
    searchReset: function searchReset() {
      this.search.reset();
    },
    searchItems: debounce_default()(function () {
      this.$store.dispatch('search', this.keywords);
    }, 700),
    folderSelected: function folderSelected(folder) {
      this.$store.dispatch('folderSelected', folder);
    },
    setLayout: function setLayout(layout) {
      this.$store.dispatch('setLayout', layout);
    },
    createFolder: function createFolder(parent) {
      var fn = prompt("Please enter the folder name:", "New Folder");

      if (fn) {
        var payload = {
          name: fn,
          parent: parent
        };
        this.$store.dispatch('createFolder', payload);
      }
    },
    editFolder: function editFolder(folder) {
      var fn = prompt("Please edit the folder name:", folder.name);

      if (fn) {
        var payload = {
          name: fn,
          folder: folder
        };
        this.$store.dispatch('editFolder', payload);
      }
    },
    removeFolder: function removeFolder(active) {
      var c = confirm("Are you sure?");

      if (c === true) {
        this.$store.dispatch('removeFolder', active);
      }
    },
    onFileSelected: function onFileSelected(e) {
      this.upload.files = e.target.files;
    },
    onUpload: function onUpload() {
      var _this = this;

      if (!this.upload.hasFiles()) {
        return alert("Nothing to upload.\nPlease select files to upload and continue...");
      }

      var fd = new FormData();
      fd.append('folder', this.active.id);
      Array.from(Array(this.upload.getFiles().length).keys()).map(function (x) {
        fd.append('files[]', _this.upload.files[x], _this.upload.files[x].name);
      });
      this.$store.dispatch('uploadItems', fd);
    },
    onUploadClick: function onUploadClick() {
      if (this.upload.isInitialised()) {
        return this.upload.reset();
      }

      return this.upload.init();
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/Media.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Mediavue_type_script_lang_js_ = (Mediavue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/components/Media.vue





/* normalize component */

var Media_component = Object(componentNormalizer["default"])(
  components_Mediavue_type_script_lang_js_,
  Mediavue_type_template_id_27b52f8c_render,
  Mediavue_type_template_id_27b52f8c_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Media_api; }
Media_component.options.__file = "resources/assets/js/src/medialib/components/Media.vue"
/* harmony default export */ var Media = (Media_component.exports);
// EXTERNAL MODULE: ./node_modules/vue-resource/dist/vue-resource.esm.js
var vue_resource_esm = __webpack_require__("./node_modules/vue-resource/dist/vue-resource.esm.js");

// CONCATENATED MODULE: ./resources/assets/js/src/medialib/api/media.js

function getFolders(folderId, cb) {
  vue_default.a.http.get('/admin/media/api/folders/' + encodeURIComponent(folderId)).then(function (response) {
    cb(response.body);
  });
}
function getFoldersData(cb) {
  vue_default.a.http.get('/admin/media/api/folders').then(function (response) {
    cb(response.body);
  });
}
function media_search(keywords, cb) {
  vue_default.a.http.get('/admin/media/api/search/' + encodeURIComponent(keywords)).then(function (response) {
    cb(response.body);
  });
}
function addFolder(name, parent, cb) {
  vue_default.a.http.post('/admin/media/api/folders/add', {
    name: name,
    parent: parent
  }).then(function (response) {
    cb(response);
  }).catch(function (e) {
    cb(e);
  });
}
function media_editFolder(name, folderId, cb) {
  vue_default.a.http.post('/admin/media/api/folders/edit', {
    name: name,
    folder: folderId
  }).then(function (response) {
    cb(response);
  }).catch(function (e) {
    cb(e);
  });
}
function media_removeFolder(id, cb) {
  vue_default.a.http.post('/admin/media/api/folders/remove', {
    id: id
  }).then(function (response) {
    cb(response);
  }).catch(function (e) {
    cb(e);
  });
}
function uploadMedia(data, cb) {
  vue_default.a.http.post('/admin/media/api/upload', data).then(function (response) {
    cb(response);
  }).catch(function (e) {
    cb(e);
  });
}
function media_removeItem(id, cb) {
  vue_default.a.http.post('/admin/media/api/items/remove', {
    id: id
  }).then(function (response) {
    cb(response);
  }).catch(function (e) {
    cb(e);
  });
} // min and max included

function randomIntFromRange(min, max) {
  return Math.floor(Math.random() * (max - min + 1) + min);
} // export function storeFolder (parentId, name, done, error) {
//     Vue.http.post('/admin/media/folders/store', { parent_id: parentId, name: name }).then(response => {
//         done(response.data.data)
//     }, response => {
//         error(response.data.data)
//     })
// }
//
// export function getItems (folder, cb) {
//     Vue.http.get('/admin/media/' + folder.id + '/items').then(response => {
//         cb(response.data.data)
//     })
// }
//
// export function searchItems (searchQuery, cb) {
//     Vue.http.post('/admin/media/search', { searchQuery: searchQuery }).then(response => {
//         cb(response.data.data)
//     })
// }
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/store/folder.js
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var folder_Folder =
/*#__PURE__*/
function () {
  function Folder(id, name) {
    var items = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : [];
    var children = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : [];
    var parent = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : null;
    var active = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : false;

    _classCallCheck(this, Folder);

    this.id = id;
    this.name = name;
    this.items = items;
    this.children = children;
    this.setChildren(children);
    this.parent = parent;
    this.active = active;
  }

  _createClass(Folder, [{
    key: "setChildren",
    value: function setChildren(children) {
      var c = [];
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = children[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var child = _step.value;
          var childF = new Folder(child.id, child.name, child.items, child.children, this);
          c.push(childF);
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return != null) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      this.children = c;
    }
  }, {
    key: "setChildrenItems",
    value: function setChildrenItems(children) {
      var _iteratorNormalCompletion2 = true;
      var _didIteratorError2 = false;
      var _iteratorError2 = undefined;

      try {
        for (var _iterator2 = this.children[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
          var child = _step2.value;
          var _iteratorNormalCompletion3 = true;
          var _didIteratorError3 = false;
          var _iteratorError3 = undefined;

          try {
            for (var _iterator3 = children[Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
              var c = _step3.value;

              if (child.id === c.id) {
                child.items = c.items;
                break;
              }
            }
          } catch (err) {
            _didIteratorError3 = true;
            _iteratorError3 = err;
          } finally {
            try {
              if (!_iteratorNormalCompletion3 && _iterator3.return != null) {
                _iterator3.return();
              }
            } finally {
              if (_didIteratorError3) {
                throw _iteratorError3;
              }
            }
          }
        }
      } catch (err) {
        _didIteratorError2 = true;
        _iteratorError2 = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion2 && _iterator2.return != null) {
            _iterator2.return();
          }
        } finally {
          if (_didIteratorError2) {
            throw _iteratorError2;
          }
        }
      }
    }
  }, {
    key: "isRoot",
    value: function isRoot() {
      return this.id === 1;
    }
  }, {
    key: "isSet",
    value: function isSet() {
      if (this.id) {
        return true;
      }

      return false;
    }
  }, {
    key: "hasContent",
    value: function hasContent() {
      if (this.children.length) {
        return true;
      }

      if (this.items.length) {
        return true;
      }

      return false;
    }
  }, {
    key: "breadcrumbs",
    value: function breadcrumbs(folder) {
      var pieces = [];

      if (!folder) {
        return pieces.concat(this.breadcrumbs(this)).reverse();
      }

      pieces.push(folder);

      if (folder.parent) {
        pieces = pieces.concat(this.breadcrumbs(folder.parent));
      }

      return pieces;
    }
  }]);

  return Folder;
}(); // export function children(items, parent=null) {
//     let t = []
//
//     for (let item of items) {
//         if (parent === item.parent) {
//             let f = new Folder(item.id, item.name, item.items, children(items, item.id), parents(items, item.parent))
//             t.push(f)
//         }
//     }
//     return t
// }

function children(items) {
  var parent = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
  var t = [];

  var _arr = Object.entries(items);

  for (var _i = 0; _i < _arr.length; _i++) {
    var _arr$_i = _slicedToArray(_arr[_i], 2),
        id = _arr$_i[0],
        item = _arr$_i[1];

    if (parent === item.parent) {
      var f = new folder_Folder(item.id, item.name, item.items, children(items, item.id), item.parent);
      t.push(f);
    }
  }

  return t;
}
function parents(items) {
  var id = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

  if (id === null) {
    return null;
  }

  var p = items[id];
  return new folder_Folder(p.id, p.name, p.items, p.children, parents(items, p.parent));
}
var Item =
/*#__PURE__*/
function () {
  function Item(item) {
    _classCallCheck(this, Item);

    this.item = item;
  }

  _createClass(Item, [{
    key: "isSet",
    value: function isSet() {
      if (this.item) {
        return true;
      }

      return false;
    }
  }]);

  return Item;
}();
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/store/search.js
function search_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function search_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function search_createClass(Constructor, protoProps, staticProps) { if (protoProps) search_defineProperties(Constructor.prototype, protoProps); if (staticProps) search_defineProperties(Constructor, staticProps); return Constructor; }

var Search =
/*#__PURE__*/
function () {
  function Search() {
    var keywords = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
    var results = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    search_classCallCheck(this, Search);

    this.keywords = keywords;
    this.results = results;
    this.loading = false;
  }

  search_createClass(Search, [{
    key: "hasResults",
    value: function hasResults() {
      return Object.keys(this.results).length !== 0;
    }
  }, {
    key: "getResults",
    value: function getResults() {
      return this.results;
    }
  }, {
    key: "setResults",
    value: function setResults(results) {
      this.results = results;
    }
  }, {
    key: "getResultsCount",
    value: function getResultsCount() {
      return Object.keys(this.results).length;
    }
  }, {
    key: "isLoading",
    value: function isLoading() {
      return this.loading;
    }
  }, {
    key: "hasKeywords",
    value: function hasKeywords() {
      return this.keywords.length !== 0;
    }
  }, {
    key: "reset",
    value: function reset() {
      this.results = {};
      this.keywords = '';
    }
  }]);

  return Search;
}();
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/store/upload.js
function upload_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function upload_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function upload_createClass(Constructor, protoProps, staticProps) { if (protoProps) upload_defineProperties(Constructor.prototype, protoProps); if (staticProps) upload_defineProperties(Constructor, staticProps); return Constructor; }

var Upload =
/*#__PURE__*/
function () {
  function Upload() {
    upload_classCallCheck(this, Upload);

    this.files = []; // needs length attribute just as FileList for seamless operations

    this.initialised = false;
    this.progress = false;
    this.label = 'Upload';
    this.ouputMessages = [];
  }

  upload_createClass(Upload, [{
    key: "inProgress",
    value: function inProgress() {
      return this.progress;
    }
  }, {
    key: "getLabel",
    value: function getLabel() {
      return this.label;
    }
  }, {
    key: "hasFiles",
    value: function hasFiles() {
      return this.files.length !== 0;
    }
  }, {
    key: "getFiles",
    value: function getFiles() {
      return this.files;
    }
  }, {
    key: "getOutputMessages",
    value: function getOutputMessages() {
      return this.ouputMessages;
    }
  }, {
    key: "isInitialised",
    value: function isInitialised() {
      return this.initialised;
    }
  }, {
    key: "init",
    value: function init() {
      this.initialised = true;
      this.label = 'Cancel upload';
    }
  }, {
    key: "reset",
    value: function reset() {
      this.files = [];
      this.initialised = false;
      this.progress = false;
      this.label = 'Upload';
    }
  }]);

  return Upload;
}();
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/store/store.js






vue_default.a.use(vuex_esm["default"]);
/* harmony default export */ var store_store = (new vuex_esm["default"].Store({
  state: {
    folder: new folder_Folder(),
    active: new folder_Folder(),
    back: new folder_Folder(),
    data: [],
    search: new Search(),
    modal: new Item(),
    layout: 'tiles',
    upload: new Upload()
  },
  // getters : {},
  mutations: {
    loadFolders: function loadFolders(state, folder) {
      getFolders(folder.id, function (f) {
        state.folder.active = false;
        state.active.active = false;
        state.back = state.active;
        folder.items = f.items;
        folder.setChildrenItems(f.children);
        folder.active = true;
        state.active = folder;
        state.search.reset();
      });
    },
    folders: function folders(state) {
      getFoldersData(function (data) {
        state.data = data.reduce(function (a, v) {
          a[v.id] = v;
          return a;
        }, {});
        var folders = children(state.data);
        state.folder = new folder_Folder(folders[0].id, folders[0].name, folders[0].items, folders[0].children, folders[0].parent, true);
        state.active = state.folder;
        getFolders(state.folder.id, function (f) {
          state.active.items = f.items;
          state.active.setChildrenItems(f.children);
        });
      });
    },
    search: function search(state, keywords) {
      state.search.loading = true;

      if (keywords === '') {
        state.search = new Search();
        return;
      }

      media_search(keywords, function (data) {
        state.search = new Search(keywords, data);
      });
    },
    modal: function modal(state, item) {
      state.modal = new Item(item);
    },
    setLayout: function setLayout(state, layout) {
      state.layout = layout;
    },
    createFolder: function createFolder(state, payload) {
      addFolder(payload.name, payload.parent.id, function (r) {
        if (r.status !== 200) {
          return alert(r.body.error);
        }

        var child = new folder_Folder(r.body.id, r.body.name, [], [], payload.parent);
        state.active.children.push(child);
      });
    },
    editFolder: function editFolder(state, payload) {
      media_editFolder(payload.name, payload.folder.id, function (r) {
        if (r.status !== 200) {
          return alert(r.body.error);
        } // TODO: finish here


        console.log(r);
        state.active.name = r.body.name;
      });
    },
    removeFolder: function removeFolder(state, folder) {
      media_removeFolder(folder.id, function (r) {
        if (r.status !== 204) {
          return alert(r.body.error);
        }

        alert("Folder removed.\nSwitching directory to parent folder...");
        var parent = folder.parent;
        parent.active = true;
        parent.children = parent.children.filter(function (child) {
          return child.id !== folder.id;
        });
        state.back = new folder_Folder();
        state.active = parent;
      });
    },
    uploadItems: function uploadItems(state, payload) {
      uploadMedia(payload, function (r) {
        console.log(r);

        if (r.status >= 400) {
          return alert(r.body.error);
        }

        var msg = r.body.messages;

        if (Array.isArray(msg)) {
          msg = r.body.messages.join('\n');
        }

        getFolders(state.active.id, function (f) {
          state.active.items = f.items;
        });
        state.upload.reset();

        if (msg) {
          alert(msg);
        }
      });
    },
    removeItem: function removeItem(state, item) {
      media_removeItem(item.id, function (r) {
        if (r.status >= 400) {
          return alert(r.body.error);
        }

        alert("Item removed.\nRefreshing directory...");
        getFolders(item.folder, function (f) {
          state.active.items = f.items;
          console.log("Refreshed folder content.");
        });
      });
    }
  },
  actions: {
    loadFolders: function loadFolders(_ref) {
      var commit = _ref.commit;
      commit('loadFolders', 1);
    },
    folderSelected: function folderSelected(_ref2, folder) {
      var commit = _ref2.commit;
      commit('loadFolders', folder);
    },
    loadLibrary: function loadLibrary(_ref3) {
      var commit = _ref3.commit;
      commit('folders'); // commit('loadLibrary')
    },
    search: function search(_ref4, keywords) {
      var commit = _ref4.commit;
      commit('search', keywords);
    },
    modal: function modal(_ref5, item) {
      var commit = _ref5.commit;
      commit('modal', item);
    },
    setLayout: function setLayout(_ref6, layout) {
      var commit = _ref6.commit;
      commit('setLayout', layout);
    },
    createFolder: function createFolder(_ref7, payload) {
      var commit = _ref7.commit;
      commit('createFolder', payload);
    },
    editFolder: function editFolder(_ref8, payload) {
      var commit = _ref8.commit;
      commit('editFolder', payload);
    },
    removeFolder: function removeFolder(_ref9, active) {
      var commit = _ref9.commit;
      commit('removeFolder', active);
    },
    uploadItems: function uploadItems(_ref10, payload) {
      var commit = _ref10.commit;
      commit('uploadItems', payload);
    },
    removeItem: function removeItem(_ref11, item) {
      var commit = _ref11.commit;
      commit('removeItem', item);
    }
  }
}));
// CONCATENATED MODULE: ./resources/assets/js/src/medialib/app.js




vue_default.a.use(vue_resource_esm["default"]);
vue_default.a.http.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;
function Medialib() {
  return new vue_default.a({
    el: '#medialibapp',
    store: store_store,
    render: function render(h) {
      return h(Media);
    }
  });
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
  trees(); // combos()

  tables();
  createTemplateForms(); // initialiseFormElements()

  registerFormSaveEvents();
  reset_form_init();
  Fields();
  Medialib();
}

if (document.readyState !== 'loading') {
  src_init();
} else {
  document.addEventListener('DOMContentLoaded', src_init);
}

/***/ }),

/***/ 0:
/*!*********************!*\
  !*** got (ignored) ***!
  \*********************/
/*! no static exports found */
/*! ModuleConcatenation bailout: Module is not an ECMAScript module */
/***/ (function(module, exports) {

/* (ignored) */

/***/ })

/******/ });
//# sourceMappingURL=main.205e1b277b94c93aa1f2.js.map