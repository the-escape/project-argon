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
/******/ 			if(Object.prototype.hasOwnProperty.call(installedChunks, chunkId) && installedChunks[chunkId]) {
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
/******/
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
	"./en-SG": "./node_modules/moment/locale/en-SG.js",
	"./en-SG.js": "./node_modules/moment/locale/en-SG.js",
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
	"./ga": "./node_modules/moment/locale/ga.js",
	"./ga.js": "./node_modules/moment/locale/ga.js",
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
	"./it-ch": "./node_modules/moment/locale/it-ch.js",
	"./it-ch.js": "./node_modules/moment/locale/it-ch.js",
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
	"./ku": "./node_modules/moment/locale/ku.js",
	"./ku.js": "./node_modules/moment/locale/ku.js",
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
	if(!__webpack_require__.o(map, req)) {
		var e = new Error("Cannot find module '" + req + "'");
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	}
	return map[req];
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
  !*** ./resources/assets/js/src/index.js + 383 modules ***!
  \********************************************************/
/*! no exports provided */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/choices.js/assets/scripts/dist/choices.min.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/cropperjs/dist/cropper.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/dragula/dragula.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/flatpickr/dist/flatpickr.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/moment/moment.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/noty/lib/noty.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/rxjs/_esm5/index.js */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/rxjs/_esm5/operators/index.js */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/sl-vue-tree/dist/sl-vue-tree.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/timers-browserify/main.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vue-drag-drop/dist/vue-drag-drop.common.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vue-flatpickr-component/dist/vue-flatpickr.min.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vue-resource/dist/vue-resource.esm.js */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vue/dist/vue.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vuebar/vuebar.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vuedraggable/dist/vuedraggable.common.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vuex/dist/vuex.esm.js (<- Module uses injected variables (global)) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/uppy/index.mjs */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vue-loader/lib/runtime/componentNormalizer.js */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);

// CONCATENATED MODULE: ./resources/assets/js/src/util/polyfills.js
function init() {
  if (typeof window.svg4everybody !== 'undefined') {
    window.svg4everybody();
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





// EXTERNAL MODULE: ./node_modules/rxjs/_esm5/index.js + 19 modules
var _esm5 = __webpack_require__("./node_modules/rxjs/_esm5/index.js");

// EXTERNAL MODULE: ./node_modules/rxjs/_esm5/operators/index.js + 97 modules
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


var maxDuration, minDuration, maxDurHeight, wheelEventName, jmpTmpMaxDuration, jmpTmpMinDuration, optionsUser, jump_element, jump_start, stop, jump_offset, easing, durationEasing, a11y, jump_distance, jump_duration, timeStart, timeElapsed, jump_nextScroll, callback, animationID;

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
  return element.getBoundingClientRect().top + jump_start;
}

function jump_location() {
  return window.scrollY || window.pageYOffset;
}

function loop(timeCurrent) {
  if (!timeStart) {
    timeStart = timeCurrent;
  }

  timeElapsed = timeCurrent - timeStart;
  jump_nextScroll = easing(timeElapsed, jump_start, jump_distance, jump_duration);
  window.scrollTo(0, jump_nextScroll);

  if (timeElapsed < jump_duration) {
    animationID = requestAnimationFrame(loop);
  } else {
    done();
  }
}

function done() {
  window.scrollTo(0, jump_start + jump_distance);

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

  jump_start = jump_location();
  callback = cb;
  offset = offset || 0;

  switch (jump_typeof(target)) {
    case 'number':
      jump_element = false;
      a11y = false;
      stop = jump_start + target;
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

  jump_distance = stop - jump_start + offset;
  var durDistance = Math.abs(jump_distance);
  var distanceChange = durDistance / maxDurHeight;

  if (durDistance >= maxDurHeight) {
    distanceChange = 1;
  }

  var durationChangeRate = durationEasing(distanceChange, 0, 1, 1);
  jump_duration = maxDuration * durationChangeRate + minDuration;
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
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }



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

    var dataEls = [].concat(_toConsumableArray(rowDataEls), _toConsumableArray(actionEls));
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
// CONCATENATED MODULE: ./resources/assets/js/src/ui/file-upload.js
// import * as FilePond from 'filepond/dist/filepond'
// import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
function file_upload_fileUpload() {// const el = document.querySelector('.js-file-pond')
  // const token = document.querySelector('meta[name=csrf-token]')
  // if (!el && !token) {
  //     return
  // }
  // FilePond.registerPlugin(FilePondPluginImagePreview)
  // FilePond.setOptions({
  //     server: {
  //         url: '/admin/users/upload-profile-image',
  //         process: {
  //             headers: {
  //                 'X-CSRF-TOKEN': token.content
  //             }
  //         }
  //     }
  // })
  // const pond = FilePond.create(el)
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/tabs.js


var TabsObj = {
  el: null,
  navContainer: null,
  navTemplate: null,
  nav: null,
  panels: null,
  currentTab: null
};
var tabs;
var tabInitMap = {};
var tabActions;
function Tabs(actions) {
  var tabEl = document.querySelector('.js-tabs');
  tabs = createTabs(tabEl);
  tabActions = actions;
  var tabUrlParamRegex = /[?&]tab(=([^&#]*)|&|#|$)/;
  var titleUrlParamRegex = /[?&]title(=([^&#]*)|&|#|$)/;
  var tab = tabUrlParamRegex.exec(window.location.search);
  var title = titleUrlParamRegex.exec(window.location.search);

  if (tab && tab[2]) {
    changeTab(tab[2], title[2]);
  }

  window.addEventListener('popstate', function (evt) {
    if (evt.state && evt.state.tab) {
      changeTab(evt.state.tab, evt.state.title, false);
    }
  });
  Object(_esm5["fromEvent"])(document, 'click').pipe(Object(operators["filter"])(function (evt) {
    return evt.target.classList.contains('js-tab-btn');
  }), Object(operators["map"])(function (evt) {
    evt.preventDefault();
    return evt.target.dataset.tab;
  })).subscribe(changeTab);
  return tabs;
}
function addTabInit(tabName, cb) {
  tabInitMap[tabName] = cb;
}

function createTabs(el) {
  var Obj = Object.create(TabsObj);
  tabs_init.call(Obj, el);
  return Obj;
}

function tabs_init(el) {
  if (!el) {
    return;
  }

  this.el = el;
  this.navContainer = el.querySelector('.js-tabs-nav');
  this.nav = Array.from(this.navContainer.querySelectorAll('[data-tab]'));
  this.navTemplate = setupTemplate(this.nav[0].parentNode.innerHTML);
  this.nav = this.nav.reduce(function (acc, panel) {
    acc[panel.dataset.tab] = panel;
    return acc;
  }, {});
  this.panels = el.querySelector('.js-tabs-list');
  this.panels = Array.from(this.panels.children);
  this.panels = this.panels.reduce(function (acc, panel) {
    acc[panel.dataset.tab] = panel;
    return acc;
  }, {});
  var activeNav = this.navContainer.querySelector('.active');

  if (activeNav) {
    this.currentTab = activeNav.dataset.tab;
  }

  Object(_esm5["fromEvent"])(this.navContainer, 'click').pipe(Object(operators["filter"])(function (evt) {
    return evt.target.dataset.tab;
  }), Object(operators["map"])(function (evt) {
    evt.preventDefault();
    return evt.target.dataset.tab;
  })).subscribe(changeTab);
}

function setupTemplate(html) {
  return function (tab, title) {
    var div = document.createElement('li');
    div.innerHTML = html;
    div.firstElementChild.classList.add('to-remove');
    div.firstElementChild.classList.add('active');
    div.firstElementChild.dataset.tab = tab;
    div.querySelector('span').innerText = title;
    return div;
  };
}

function changeTab(tabName) {
  var title = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
  var pushstate = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;

  if (!tabs.panels || !tabs.panels[tabName] || tabName === tabs.currentTab) {
    return;
  }

  tabs.panels[tabs.currentTab].classList.remove('active');

  if (tabs.nav[tabs.currentTab]) {
    if (tabs.nav[tabs.currentTab].classList.contains('to-remove')) {
      tabs.nav[tabs.currentTab].parentNode.remove();
      tabs.nav[tabs.currentTab] = null;
    } else {
      tabs.nav[tabs.currentTab].classList.remove('active');
    }
  }

  tabs.panels[tabName].classList.add('active');
  tabInitMap[tabName] && tabInitMap[tabName]();

  if (!tabs.nav[tabName]) {
    var newTabNav = tabs.navTemplate(tabName, title);
    var insertBeforeEl = tabs.navContainer.firstElementChild.children[1];
    tabs.navContainer.firstElementChild.insertBefore(newTabNav, insertBeforeEl);
    tabs.nav[tabName] = newTabNav.firstElementChild;
  } else {
    tabs.nav[tabName].classList.add('active');
  }

  if (!title) {
    title = tabs.nav[tabName].querySelector('span').innerText;
  }

  tabs.currentTab = tabName;
  tabActions(tabName);

  if (pushstate) {
    history.pushState({
      tab: tabName,
      title: title
    }, tabName, "?tab=".concat(tabName, "&title=").concat(title));
  }
}
// EXTERNAL MODULE: ./node_modules/noty/lib/noty.js
var noty = __webpack_require__("./node_modules/noty/lib/noty.js");
var noty_default = /*#__PURE__*/__webpack_require__.n(noty);

// CONCATENATED MODULE: ./resources/assets/js/src/ui/notifications.js

function Notifications() {
  if (!window.notifications || !window.notifications.length) {
    return;
  }

  return window.notifications.map(function (notif) {
    return new noty_default.a({
      layout: 'topCenter',
      text: notif.text,
      type: notif.success ? 'success' : 'error',
      timeout: 3500
    }).show();
  });
}
// EXTERNAL MODULE: ./node_modules/cropperjs/dist/cropper.js
var cropper = __webpack_require__("./node_modules/cropperjs/dist/cropper.js");
var cropper_default = /*#__PURE__*/__webpack_require__.n(cropper);

// CONCATENATED MODULE: ./resources/assets/js/src/ui/cropper.js



var cropper_el;
var cropper_container;
var canvas;
var cropper_input;
var preview;
var rotate;
var currentRotation = 0;
var moveRatation = 0;
var cropper_cropper;
function CreateCropper() {
  cropper_el = document.querySelector('.js-cropper');

  if (!cropper_el) {
    return;
  }

  cropper_container = cropper_el.querySelector('.js-cropper-container');
  canvas = document.createElement('canvas');
  cropper_container.appendChild(canvas);
  cropper_input = cropper_el.querySelector('.js-cropper-int');
  preview = cropper_el.querySelector('.js-cropper-out-preview');
  rotate = cropper_el.querySelector('.js-cropper-rotate');
  cropper_cropper = new cropper_default.a(canvas, {
    preview: preview
  });
  cropper_input.addEventListener('change', imageSet);
  Object(_esm5["fromEvent"])(cropper_el, 'click').pipe(Object(operators["filter"])(function (evt) {
    return evt.target.dataset.task;
  }), Object(operators["map"])(function (evt) {
    return {
      task: evt.target.dataset.task,
      element: evt.target
    };
  })).subscribe(runTask);
  dragRotate();
}

function dragRotate() {
  var down = Object(_esm5["merge"])(Object(_esm5["fromEvent"])(rotate, 'mousedown'), Object(_esm5["fromEvent"])(rotate, 'touchstart'));
  var move = Object(_esm5["merge"])(Object(_esm5["fromEvent"])(document, 'mousemove'), Object(_esm5["fromEvent"])(document, 'touchmove'));
  var up = Object(_esm5["merge"])(Object(_esm5["fromEvent"])(document, 'mouseup'), Object(_esm5["fromEvent"])(document, 'touchend'));
  down.pipe(Object(operators["mergeMap"])(function (downEvents) {
    var startPos = getPositionFromEvent(downEvents);
    return move.pipe(Object(operators["map"])(function (moveEvents) {
      moveEvents.preventDefault();
      var movePos = getPositionFromEvent(moveEvents);
      return {
        x: movePos.x - startPos.x
      };
    }), Object(operators["takeUntil"])(up));
  })).subscribe(function (move) {
    moveRatation = move.x * 0.3;
    cropper_cropper.rotateTo(currentRotation + moveRatation);
  });
  up.subscribe(function () {
    console.log('up');
    currentRotation += moveRatation;
  });
}

function getPositionFromEvent(evt) {
  if (evt.touches) {
    evt = evt.touches[0];
  }

  return {
    x: evt.clientX
  };
}

function runTask(_ref) {
  var task = _ref.task,
      element = _ref.element;

  switch (task) {
    case 'zoom-in':
      cropper_cropper.zoom(0.1);
      break;

    case 'zoom-out':
      cropper_cropper.zoom(-0.1);
      break;

    case 'drag-image':
      cropper_cropper.setDragMode('move');
      break;

    case 'drag-crop':
      cropper_cropper.setDragMode('crop');
      break;

    case 'set-ratio':
      var ratio = element.dataset.ratio;
      ratio = ratio.split(':');
      ratio = ratio[0] / ratio[1];
      console.log(ratio);
      cropper_cropper.setAspectRatio(ratio);
      break;

    case 'set-rotate':
      var _rotate = element.dataset.rotate;
      currentRotation = 0;
      cropper_cropper.rotateTo(_rotate);
      break;
  }
}

function imageSet(evt) {
  var file = evt.target.files[0];
  var reader = new FileReader();

  reader.onload = function (evt) {
    cropper_cropper.replace(evt.target.result);
  };

  reader.readAsDataURL(file);
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/prevent-leave.js
var hasChanged = false;
function setupPageLeave() {
  window.onbeforeunload = function () {
    if (hasChanged) {
      return 'Changes have been made may not be saved';
    }
  };
}
function preventPageLeave() {
  hasChanged = true;
}
function allowPageLeave() {
  hasChanged = false;
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/basic-confirm-btns.js


function BasicConfirmBtns() {
  var basicConfirmEls = document.querySelectorAll('.js-basic-confirm');
  var basicConfirms = Array.from(basicConfirmEls);
  return basicConfirms.map(function (el) {
    return createBasicConfirm(el);
  });
}
var BasicConfirm = {
  el: null
};

function createBasicConfirm(el) {
  var Obj = Object.create(BasicConfirm);
  basic_confirm_btns_init.call(Obj, el);
  return Obj;
}

function basic_confirm_btns_init(el) {
  var _this = this;

  if (!el) {
    return;
  }

  this.el = el;
  var click = Object(_esm5["fromEvent"])(this.el, 'click');
  click.pipe(Object(operators["filter"])(function (evt) {
    return evt.target.dataset.question;
  }), Object(operators["map"])(function (evt) {
    return evt.preventDefault(), evt;
  }), Object(operators["map"])(function (evt) {
    return evt.target.dataset.question;
  })).subscribe(function (question) {
    if (question === 'delete') {
      _this.el.classList.add('is-active');
    }
  });
  click.pipe(Object(operators["filter"])(function (evt) {
    return evt.target.classList.contains('js-confirm-decline');
  })).subscribe(function (_) {
    _this.el.classList.remove('is-active');
  });
}
// CONCATENATED MODULE: ./resources/assets/js/src/ui/index.js



















// CONCATENATED MODULE: ./resources/assets/js/src/form/file-input.js
function createFileInputs() {
  var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
  var fileInputEls = context.querySelectorAll('.js-file');
  var fileInputs = Array.from(fileInputEls);
  fileInputs.forEach(function (input) {
    return createFileInput(input);
  });
}
function createFileInput(wrapper) {
  var input = wrapper.querySelector('.o-file__input');
  var label = wrapper.querySelector('.o-file__name');
  var preview = wrapper.querySelector('.o-file__image-preview');
  var labelVal = label.innerHTML;
  input.addEventListener('change', function (evt) {
    var fileName = '';

    if (evt.target.files && evt.target.files[0]) {
      var file = evt.target.files[0];

      if (preview && !file.type.match(/image.*/)) {
        label.innerHTML = "<span class='h-text--danger'>You can upload only images.</span>";
        input.type = '';
        input.value = '';
        input.type = 'file';
        return;
      }

      fileName = evt.target.value.split('\\').pop(); // let reader = new FileReader()
      //
      // if (preview && file.type.match(/image.*/)) {
      //
      //     reader.onload = function(readerEvent) {
      //         let image = new Image()
      //
      //         image.onload = function(imageEvent) {
      //             let canvas = document.createElement('canvas'),
      //                 max_size = 200,
      //                 width = image.width,
      //                 height = image.height
      //
      //             if (width > height) {
      //                 if (width > max_size) {
      //                     height += max_size /width
      //                     width = max_size
      //                 }
      //             } else {
      //                 if (height > max_size) {
      //                     width += max_size / height
      //                     height = max_size
      //                 }
      //             }
      //
      //             canvas.width = width
      //             canvas.height = height
      //             canvas.getContext('2d').drawImage(image, 0, 0, width, height)
      //             let dataUrl = canvas.toDataURL('image/jpeg')
      //             let resizedImage = dataURLToBlob(dataUrl)
      //
      //             // input.value = resizedImage
      //             preview.src = dataUrl
      //         }
      //         image.src = readerEvent.target.result
      //     }
      // reader.readAsDataURL(file)
      // reader.onloadend = function() {
      //     preview.src = reader.result
      // }
      // }
      // if (file) {
      //     reader.readAsDataURL(file)
      // }
    }

    if (fileName) {
      label.innerHTML = fileName;
    } else {
      label.innerHTML = labelVal;
    }
  });
} // function dataURLToBlob(dataURL) {
//     const BASE64_MARKER = ';base64,'
//     let parts
//     let contentType
//     let raw
//     if (dataURL.indexOf(BASE64_MARKER) == -1) {
//         parts = dataURL.split(',')
//         contentType = parts[0].split(':')[1]
//         raw = parts[1]
//
//         return new Blob([raw], {type: contentType})
//     }
//
//     parts = dataURL.split(BASE64_MARKER)
//     contentType = parts[0].split(':')[1]
//     raw = window.atob(parts[1])
//     let rawLength = raw.length
//
//     let uInt8Array = new Uint8Array(rawLength)
//
//     for (let i = 0; i < rawLength; ++i) {
//         uInt8Array[i] = raw.charCodeAt(i)
//     }
//
//     return new Blob([uInt8Array], {type: contentType})
// }
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
function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function select_toConsumableArray(arr) { return select_arrayWithoutHoles(arr) || select_iterableToArray(arr) || select_nonIterableSpread(); }

function select_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function select_iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function select_arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }


var select_options = {
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
};
function createSelects() {
  var context = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
  var selectHtmlList = context.querySelectorAll('.js-select');
  var selectList = Array.from(selectHtmlList);
  selectList = selectList.map(function (el) {
    return createSelect(el);
  });
  var plainSelectHtmlList = context.querySelectorAll('.js-plain-submit-select');
  var plainSelectList = Array.from(plainSelectHtmlList);
  plainSelectList = plainSelectList.map(function (el) {
    return createPlainSelect(el);
  });
  return [].concat(select_toConsumableArray(selectList), select_toConsumableArray(plainSelectList));
}
function createSelect(el) {
  var value = el.dataset.value;
  var items = [];

  if (value) {
    items = JSON.parse(value);
  }

  var select = new choices_min_default.a(el, _extends({}, select_options));
  el.choices = select;
  select.setValueByChoice(items);
  return select;
}
function createPlainSelect(el) {
  var value = el.dataset.value;
  var items = [];

  if (value) {
    items = JSON.parse(value);
  }

  var plainOptions = _extends({}, select_options, {
    classNames: {
      containerOuter: 'choices choices--plain'
    }
  });

  var select = new choices_min_default.a(el, plainOptions);
  el.choices = select;
  select.setValueByChoice(items);
  el.addEventListener('change', function () {
    el.closest('form').submit();
  });
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
function wysiwyg_extends() { wysiwyg_extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return wysiwyg_extends.apply(this, arguments); }


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

  config = wysiwyg_extends(config, elConfig);

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
  return wysiwyg_extends(CKEDITOR_CONFIG, config);
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
// EXTERNAL MODULE: ./node_modules/dragula/dragula.js
var dragula = __webpack_require__("./node_modules/dragula/dragula.js");
var dragula_default = /*#__PURE__*/__webpack_require__.n(dragula);

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

    drag_select_updateValues.call(_this);
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

function drag_select_updateValues() {
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
  drag_select_updateValues.call(this);
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
  return new Promise(function (resolve) {
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

        resolve(mediaValueObj);
      });
    });
    $('#medialib').modal();
  });
}
// CONCATENATED MODULE: ./resources/assets/js/src/form/index.js












function registerFormSaveEvents() {
  var savePublishBtn = document.querySelector('.js-save');

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
  var fileInputs = createFileInputs();
  return {
    selects: selects,
    itemPickers: itemPickers,
    dates: dates,
    editors: editors,
    times: times,
    dragSelects: dragSelects,
    mediaItems: mediaItems,
    fileInputs: fileInputs
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


// EXTERNAL MODULE: ./node_modules/vue/dist/vue.js
var vue = __webpack_require__("./node_modules/vue/dist/vue.js");
var vue_default = /*#__PURE__*/__webpack_require__.n(vue);

// EXTERNAL MODULE: ./node_modules/vuex/dist/vuex.esm.js
var vuex_esm = __webpack_require__("./node_modules/vuex/dist/vuex.esm.js");

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/App.vue?vue&type=template&id=6cdc7617&
var Appvue_type_template_id_6cdc7617_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _vm.showActions
        ? [
            _c("div", { staticClass: "c-actions__container" }, [
              _c(
                "div",
                {
                  staticClass:
                    "c-actions__content c-tab-panel__inner-container l-full"
                },
                [
                  _c("h2", [
                    _vm._v("Editing: "),
                    _c("span", { staticClass: "h-text--primary" }, [
                      _vm._v(_vm._s(_vm.header))
                    ])
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "o-form l-accordion-container" },
                    _vm._l(_vm.fields, function(field) {
                      return _c("types", {
                        key: field.id,
                        attrs: { field: field }
                      })
                    }),
                    1
                  )
                ]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "c-actions" }, [
                _c("div", { staticClass: "c-actions__group" }, [
                  _c(
                    "button",
                    {
                      staticClass: "o-btn o-btn--primary",
                      attrs: { type: "submit" },
                      on: {
                        click: function($event) {
                          return _vm.apply($event)
                        }
                      }
                    },
                    [_vm._v("Apply")]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "o-btn",
                      attrs: { type: "submit" },
                      on: {
                        click: function($event) {
                          return _vm.cancel($event)
                        }
                      }
                    },
                    [_vm._v("Cancel")]
                  )
                ])
              ])
            ])
          ]
        : [
            _c("h3", [_vm._v(_vm._s(_vm.header))]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "o-form l-accordion-container" },
              _vm._l(_vm.fields, function(field) {
                return _c("types", { key: field.id, attrs: { field: field } })
              }),
              1
            )
          ]
    ],
    2
  )
}
var staticRenderFns = []
Appvue_type_template_id_6cdc7617_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/App.vue?vue&type=template&id=6cdc7617&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/App.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var Appvue_type_script_lang_js_ = ({
  created: function created() {
    this.$store.commit('setOldState');
  },
  methods: {
    apply: function apply(evt) {
      evt.preventDefault();
      this.$store.commit('setOldState');
      changeTab('page-content');
    },
    cancel: function cancel(evt) {
      evt.preventDefault();
      this.$store.commit('restoreOldState');
      changeTab('page-content');
    },
    toggleDraggables: function toggleDraggables(tabName) {
      this.$store.commit('toggleDraggables', {
        tabName: tabName
      });
    }
  },
  computed: {
    fields: function fields() {
      return this.$store.state.fields;
    },
    header: function header() {
      return this.$store.state.header;
    },
    showActions: function showActions() {
      return this.$store.state.showActions;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/App.vue?vue&type=script&lang=js&
 /* harmony default export */ var fields_Appvue_type_script_lang_js_ = (Appvue_type_script_lang_js_); 
// EXTERNAL MODULE: ./node_modules/vue-loader/lib/runtime/componentNormalizer.js
var componentNormalizer = __webpack_require__("./node_modules/vue-loader/lib/runtime/componentNormalizer.js");

// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/App.vue





/* normalize component */

var component = Object(componentNormalizer["default"])(
  fields_Appvue_type_script_lang_js_,
  Appvue_type_template_id_6cdc7617_render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/src/components/fields/App.vue"
/* harmony default export */ var App = (component.exports);
// EXTERNAL MODULE: ./node_modules/vuedraggable/dist/vuedraggable.common.js
var vuedraggable_common = __webpack_require__("./node_modules/vuedraggable/dist/vuedraggable.common.js");
var vuedraggable_common_default = /*#__PURE__*/__webpack_require__.n(vuedraggable_common);

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/types.vue?vue&type=template&id=43058c79&
var typesvue_type_template_id_43058c79_render = function() {
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
var typesvue_type_template_id_43058c79_staticRenderFns = []
typesvue_type_template_id_43058c79_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/types.vue?vue&type=template&id=43058c79&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/text.vue?vue&type=template&id=f9a45346&
var textvue_type_template_id_f9a45346_render = function() {
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
var textvue_type_template_id_f9a45346_staticRenderFns = []
textvue_type_template_id_f9a45346_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/text.vue?vue&type=template&id=f9a45346&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/base/index.vue?vue&type=template&id=1a3b3078&
var basevue_type_template_id_1a3b3078_render = function() {
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
                    _c("field-base", {
                      attrs: {
                        icons: _vm.icons,
                        type: _vm.type,
                        "value-obj": valueObj,
                        "input-name": _vm.inputName
                      },
                      on: {
                        change: function($event) {
                          return _vm.updateValue(valueObj, $event)
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
var basevue_type_template_id_1a3b3078_staticRenderFns = []
basevue_type_template_id_1a3b3078_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/base/index.vue?vue&type=template&id=1a3b3078&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/util/validation.vue?vue&type=template&id=afceefb4&
var validationvue_type_template_id_afceefb4_render = function() {
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
var validationvue_type_template_id_afceefb4_staticRenderFns = []
validationvue_type_template_id_afceefb4_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/util/validation.vue?vue&type=template&id=afceefb4&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/util/validation.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
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
      return this.statusError && this.statusError.length;
    },
    errorMsg: function errorMsg() {
      return this.statusError && this.statusError[0];
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/util/validation.vue?vue&type=script&lang=js&
 /* harmony default export */ var util_validationvue_type_script_lang_js_ = (validationvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/util/validation.vue





/* normalize component */

var validation_component = Object(componentNormalizer["default"])(
  util_validationvue_type_script_lang_js_,
  validationvue_type_template_id_afceefb4_render,
  validationvue_type_template_id_afceefb4_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var validation_api; }
validation_component.options.__file = "resources/assets/js/src/components/fields/types/util/validation.vue"
/* harmony default export */ var validation = (validation_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/util/multi.vue?vue&type=template&id=1793689c&
var multivue_type_template_id_1793689c_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _vm.isMultiple
        ? _c("div", { staticClass: "o-multi" }, [
            _vm.showDraggables
              ? _c(
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
                                      "o-multi__drag-handle js-multi-drag",
                                    on: {
                                      click: function($event) {
                                        return _vm.preventDefault($event)
                                      }
                                    }
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
                                          return _vm.deleteValue(value.id)
                                        },
                                        duplicate: function($event) {
                                          return _vm.duplicateValue(value.id)
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
                      }),
                      0
                    )
                  ],
                  1
                )
              : _vm._e(),
            _vm._v(" "),
            _c("div", { staticClass: "o-multi__foot" }, [
              _c(
                "button",
                {
                  staticClass: "o-btn o-btn--sm",
                  on: {
                    click: function($event) {
                      return _vm.addEmptyValue($event)
                    }
                  }
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
var multivue_type_template_id_1793689c_staticRenderFns = []
multivue_type_template_id_1793689c_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/util/multi.vue?vue&type=template&id=1793689c&

// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/util/bus.js

var EventBus = new vue_default.a();
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/commonComponents/confirm-btn.vue?vue&type=template&id=73a6f08d&
var confirm_btnvue_type_template_id_73a6f08d_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "o-confirm-btn__container",
      class: {
        "is-active": _vm.confirmDelete,
        "o-confirm-btn--block": _vm.isBlock
      }
    },
    [
      _c(
        "div",
        { staticClass: "o-confirm-btn__questions" },
        [
          _vm.hideDuplicate && !_vm.showAdd
            ? _c("div", { staticClass: "o-confirm-btn" })
            : _vm._e(),
          _vm._v(" "),
          !_vm.hideDuplicate
            ? _c(
                "button",
                {
                  staticClass: "o-confirm-btn",
                  attrs: {
                    "data-balloon": "Duplicate" + _vm.tooltipPostfixValue,
                    title: "Duplicate"
                  },
                  on: {
                    click: function($event) {
                      return _vm.duplicate($event)
                    }
                  }
                },
                [
                  _c("svg", [
                    _c("use", {
                      attrs: {
                        "xlink:href": "/argon/images/svgicons.svg#duplicate"
                      }
                    })
                  ])
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "o-confirm-btn",
              class: { "o-confirm-btn--fade": _vm.fadeDelete },
              attrs: {
                "data-balloon": _vm.fadeDelete
                  ? false
                  : "Delete" + _vm.tooltipPostfixValue,
                title: "Delete"
              },
              on: {
                click: function($event) {
                  return _vm.toggleConfirmDelete($event)
                }
              }
            },
            [
              _c("svg", [
                _c("use", {
                  attrs: { "xlink:href": "/argon/images/svgicons.svg#delete" }
                })
              ])
            ]
          ),
          _vm._v(" "),
          _vm.showAdd
            ? _c(
                "button",
                {
                  staticClass: "o-confirm-btn js-add-btn",
                  attrs: {
                    "data-balloon": "Add" + _vm.tooltipPostfixValue,
                    title: "Add"
                  },
                  on: {
                    click: function($event) {
                      return _vm.add($event)
                    }
                  }
                },
                [
                  _c("svg", [
                    _c("use", {
                      attrs: { "xlink:href": "/argon/images/svgicons.svg#add" }
                    })
                  ])
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          _vm.showView
            ? _c(
                "a",
                {
                  staticClass: "o-confirm-btn",
                  class: { "o-confirm-btn--fade": !_vm.viewUrl },
                  attrs: {
                    href: _vm.viewUrl,
                    target: "_blank",
                    "data-balloon": "View" + _vm.tooltipPostfixValue,
                    title: "view"
                  },
                  on: {
                    click: function($event) {
                      return _vm.view($event)
                    }
                  }
                },
                [
                  _c("svg", [
                    _c("use", {
                      attrs: { "xlink:href": "/argon/images/svgicons.svg#see" }
                    })
                  ])
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          _vm._l(_vm.extraActions, function(extraAction, index) {
            return _c(
              "a",
              {
                key: index,
                staticClass: "o-confirm-btn",
                attrs: {
                  href: extraAction.url,
                  "data-balloon": extraAction.label,
                  title: extraAction.label,
                  target: extraAction.target
                }
              },
              [
                _c("svg", [
                  _c("use", { attrs: { "xlink:href": extraAction.icon } })
                ])
              ]
            )
          })
        ],
        2
      ),
      _vm._v(" "),
      _c("div", { staticClass: "o-confirm-btn__decline" }, [
        _c(
          "button",
          {
            staticClass: "o-confirm-btn o-confirm-btn--danger",
            on: {
              click: function($event) {
                return _vm.toggleConfirmDelete($event)
              }
            }
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
            on: {
              click: function($event) {
                return _vm.deleteConfirm($event)
              }
            }
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
var confirm_btnvue_type_template_id_73a6f08d_staticRenderFns = []
confirm_btnvue_type_template_id_73a6f08d_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/commonComponents/confirm-btn.vue?vue&type=template&id=73a6f08d&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/commonComponents/confirm-btn.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'comfirm-btn',
  props: ['hideDuplicate', 'fadeDelete', 'isBlock', 'showAdd', 'viewUrl', 'showView', 'tooltipPostfix', 'extraActions'],
  data: function data() {
    return {
      confirmDelete: false,
      tooltipPostfixValue: ''
    };
  },
  created: function created() {
    this.tooltipPostfixValue = this.tooltipPostfix || this.tooltipPostfixValue;
  },
  methods: {
    toggleConfirmDelete: function toggleConfirmDelete(evt) {
      evt.preventDefault();

      if (this.fadeDelete) {
        this.$emit('delete');
      } else {
        this.confirmDelete = !this.confirmDelete;
      }
    },
    duplicate: function duplicate(evt) {
      evt.preventDefault();
      this.$emit('duplicate');
    },
    add: function add(evt) {
      evt.preventDefault();
      this.$emit('add');
    },
    view: function view(evt) {
      if (!this.viewUrl) {
        evt.preventDefault();
        this.$emit('view');
      }
    },
    deleteConfirm: function deleteConfirm(evt) {
      evt.preventDefault();
      this.$emit('delete');
      this.confirmDelete = false;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/commonComponents/confirm-btn.vue?vue&type=script&lang=js&
 /* harmony default export */ var commonComponents_confirm_btnvue_type_script_lang_js_ = (confirm_btnvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/commonComponents/confirm-btn.vue





/* normalize component */

var confirm_btn_component = Object(componentNormalizer["default"])(
  commonComponents_confirm_btnvue_type_script_lang_js_,
  confirm_btnvue_type_template_id_73a6f08d_render,
  confirm_btnvue_type_template_id_73a6f08d_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var confirm_btn_api; }
confirm_btn_component.options.__file = "resources/assets/js/src/components/commonComponents/confirm-btn.vue"
/* harmony default export */ var confirm_btn = (confirm_btn_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/mixins/value-objs.vue?vue&type=script&lang=js&
/* harmony default export */ var value_objsvue_type_script_lang_js_ = ({
  computed: {
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
          } else {
            return {
              id: 0
            };
          }
        }
      }

      var field = this.$store.getters.getField(this.fieldId);

      if (field && field.values[0]) {
        return field.values[0];
      }
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
            } else {
              return [{
                id: 0
              }];
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/mixins/value-objs.vue?vue&type=script&lang=js&
 /* harmony default export */ var mixins_value_objsvue_type_script_lang_js_ = (value_objsvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/mixins/value-objs.vue
var value_objs_render, value_objs_staticRenderFns




/* normalize component */

var value_objs_component = Object(componentNormalizer["default"])(
  mixins_value_objsvue_type_script_lang_js_,
  value_objs_render,
  value_objs_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var value_objs_api; }
value_objs_component.options.__file = "resources/assets/js/src/components/fields/types/mixins/value-objs.vue"
/* harmony default export */ var value_objs = (value_objs_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/util/multi.vue?vue&type=script&lang=js&
function multivue_type_script_lang_js_extends() { multivue_type_script_lang_js_extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return multivue_type_script_lang_js_extends.apply(this, arguments); }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  mixins: [value_objs],
  methods: {
    preventDefault: function preventDefault(evt) {
      evt.preventDefault();
    },
    onMove: function onMove() {
      var name = 'move-' + this.fieldId;

      if (this.comboId) {
        name = 'move-' + this.fieldId + '-' + this.comboId + '-' + this.comboItemId;
      }

      EventBus.$emit(name);
    },
    addEmptyValue: function addEmptyValue(evt) {
      evt.preventDefault();

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
        duplicateVal = multivue_type_script_lang_js_extends({}, val[0]);
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
    showDraggables: function showDraggables() {
      return this.$store.state.showDraggables;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/util/multi.vue?vue&type=script&lang=js&
 /* harmony default export */ var util_multivue_type_script_lang_js_ = (multivue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/util/multi.vue





/* normalize component */

var multi_component = Object(componentNormalizer["default"])(
  util_multivue_type_script_lang_js_,
  multivue_type_template_id_1793689c_render,
  multivue_type_template_id_1793689c_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var multi_api; }
multi_component.options.__file = "resources/assets/js/src/components/fields/types/util/multi.vue"
/* harmony default export */ var multi = (multi_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/mixins/field-values.vue?vue&type=script&lang=js&
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
    inputNameMultiValue: function inputNameMultiValue() {
      var field;

      if (this.comboId) {
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);
        return "combo[".concat(this.comboId, "][").concat(this.comboItemId, "][fields][").concat(this.fieldId, "]");
      } else {
        field = this.$store.getters.getField(this.fieldId);
        return "fields[".concat(field.id, "]");
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/mixins/field-values.vue?vue&type=script&lang=js&
 /* harmony default export */ var mixins_field_valuesvue_type_script_lang_js_ = (field_valuesvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/mixins/field-values.vue
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
field_values_component.options.__file = "resources/assets/js/src/components/fields/types/mixins/field-values.vue"
/* harmony default export */ var field_values = (field_values_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/base/base.vue?vue&type=template&id=db9adf62&
var basevue_type_template_id_db9adf62_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "input-icon",
    {
      attrs: { "pre-icon": _vm.icons.preIcon, "post-icon": _vm.icons.postIcon }
    },
    [
      _vm.type === "checkbox"
        ? _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.value,
                expression: "value"
              }
            ],
            attrs: { id: _vm.inputName, name: _vm.inputName, type: "checkbox" },
            domProps: {
              checked: Array.isArray(_vm.value)
                ? _vm._i(_vm.value, null) > -1
                : _vm.value
            },
            on: {
              change: function($event) {
                var $$a = _vm.value,
                  $$el = $event.target,
                  $$c = $$el.checked ? true : false
                if (Array.isArray($$a)) {
                  var $$v = null,
                    $$i = _vm._i($$a, $$v)
                  if ($$el.checked) {
                    $$i < 0 && (_vm.value = $$a.concat([$$v]))
                  } else {
                    $$i > -1 &&
                      (_vm.value = $$a.slice(0, $$i).concat($$a.slice($$i + 1)))
                  }
                } else {
                  _vm.value = $$c
                }
              }
            }
          })
        : _vm.type === "radio"
        ? _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.value,
                expression: "value"
              }
            ],
            attrs: { id: _vm.inputName, name: _vm.inputName, type: "radio" },
            domProps: { checked: _vm._q(_vm.value, null) },
            on: {
              change: function($event) {
                _vm.value = null
              }
            }
          })
        : _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.value,
                expression: "value"
              }
            ],
            attrs: { id: _vm.inputName, name: _vm.inputName, type: _vm.type },
            domProps: { value: _vm.value },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.value = $event.target.value
              }
            }
          })
    ]
  )
}
var basevue_type_template_id_db9adf62_staticRenderFns = []
basevue_type_template_id_db9adf62_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/base/base.vue?vue&type=template&id=db9adf62&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/util/input-icon.vue?vue&type=template&id=4ecc6a6e&
var input_iconvue_type_template_id_4ecc6a6e_render = function() {
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
var input_iconvue_type_template_id_4ecc6a6e_staticRenderFns = []
input_iconvue_type_template_id_4ecc6a6e_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/util/input-icon.vue?vue&type=template&id=4ecc6a6e&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/util/input-icon.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/util/input-icon.vue?vue&type=script&lang=js&
 /* harmony default export */ var util_input_iconvue_type_script_lang_js_ = (input_iconvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/util/input-icon.vue





/* normalize component */

var input_icon_component = Object(componentNormalizer["default"])(
  util_input_iconvue_type_script_lang_js_,
  input_iconvue_type_template_id_4ecc6a6e_render,
  input_iconvue_type_template_id_4ecc6a6e_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var input_icon_api; }
input_icon_component.options.__file = "resources/assets/js/src/components/fields/types/util/input-icon.vue"
/* harmony default export */ var input_icon = (input_icon_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/base/base.vue?vue&type=script&lang=js&
//
//
//
//
//
//

/* harmony default export */ var basevue_type_script_lang_js_ = ({
  props: ['icons', 'type', 'valueObj', 'inputName'],
  components: {
    'input-icon': input_icon
  },
  data: function data() {
    return {
      loading: true,
      value: ''
    };
  },
  mounted: function mounted() {
    this.value = this.valueObj.value;
    this.loading = false;
  },
  watch: {
    value: function value(newValue) {
      if (this.loading) {
        return;
      }

      this.$emit('change', newValue);
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/base/base.vue?vue&type=script&lang=js&
 /* harmony default export */ var base_basevue_type_script_lang_js_ = (basevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/base/base.vue





/* normalize component */

var base_component = Object(componentNormalizer["default"])(
  base_basevue_type_script_lang_js_,
  basevue_type_template_id_db9adf62_render,
  basevue_type_template_id_db9adf62_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var base_api; }
base_component.options.__file = "resources/assets/js/src/components/fields/types/base/base.vue"
/* harmony default export */ var base = (base_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/base/index.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var types_basevue_type_script_lang_js_ = ({
  props: ['fieldId', 'icons', 'type', 'comboId', 'comboItemId'],
  mixins: [field_values],
  components: {
    'field-base': base,
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/base/index.vue?vue&type=script&lang=js&
 /* harmony default export */ var fields_types_basevue_type_script_lang_js_ = (types_basevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/base/index.vue





/* normalize component */

var types_base_component = Object(componentNormalizer["default"])(
  fields_types_basevue_type_script_lang_js_,
  basevue_type_template_id_1a3b3078_render,
  basevue_type_template_id_1a3b3078_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var types_base_api; }
types_base_component.options.__file = "resources/assets/js/src/components/fields/types/base/index.vue"
/* harmony default export */ var types_base = (types_base_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/textarea/index.vue?vue&type=template&id=d9a3c626&
var textareavue_type_template_id_d9a3c626_render = function() {
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
                    _c("textarea", {
                      attrs: { id: _vm.inputName, name: _vm.inputName },
                      domProps: { value: valueObj.value },
                      on: {
                        keyup: function($event) {
                          $event.stopPropagation()
                          return _vm.updateValue(valueObj, $event.target.value)
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
var textareavue_type_template_id_d9a3c626_staticRenderFns = []
textareavue_type_template_id_d9a3c626_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/textarea/index.vue?vue&type=template&id=d9a3c626&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/textarea/index.vue?vue&type=script&lang=js&
//
//
//
//
//
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/textarea/index.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_textareavue_type_script_lang_js_ = (textareavue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/textarea/index.vue





/* normalize component */

var textarea_component = Object(componentNormalizer["default"])(
  types_textareavue_type_script_lang_js_,
  textareavue_type_template_id_d9a3c626_render,
  textareavue_type_template_id_d9a3c626_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var textarea_api; }
textarea_component.options.__file = "resources/assets/js/src/components/fields/types/textarea/index.vue"
/* harmony default export */ var types_textarea = (textarea_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/text.vue?vue&type=script&lang=js&
//
//
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
    'base-input': types_base,
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/text.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_textvue_type_script_lang_js_ = (textvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/text.vue





/* normalize component */

var text_component = Object(componentNormalizer["default"])(
  types_textvue_type_script_lang_js_,
  textvue_type_template_id_f9a45346_render,
  textvue_type_template_id_f9a45346_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var text_api; }
text_component.options.__file = "resources/assets/js/src/components/fields/types/text.vue"
/* harmony default export */ var types_text = (text_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/email.vue?vue&type=template&id=bd2f93c8&
var emailvue_type_template_id_bd2f93c8_render = function() {
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
var emailvue_type_template_id_bd2f93c8_staticRenderFns = []
emailvue_type_template_id_bd2f93c8_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/email.vue?vue&type=template&id=bd2f93c8&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/email.vue?vue&type=script&lang=js&
//
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
    'base-input': types_base
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/email.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_emailvue_type_script_lang_js_ = (emailvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/email.vue





/* normalize component */

var email_component = Object(componentNormalizer["default"])(
  types_emailvue_type_script_lang_js_,
  emailvue_type_template_id_bd2f93c8_render,
  emailvue_type_template_id_bd2f93c8_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var email_api; }
email_component.options.__file = "resources/assets/js/src/components/fields/types/email.vue"
/* harmony default export */ var email = (email_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/phone.vue?vue&type=template&id=34a02224&
var phonevue_type_template_id_34a02224_render = function() {
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
var phonevue_type_template_id_34a02224_staticRenderFns = []
phonevue_type_template_id_34a02224_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/phone.vue?vue&type=template&id=34a02224&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/phone.vue?vue&type=script&lang=js&
//
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
    'base-input': types_base
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/phone.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_phonevue_type_script_lang_js_ = (phonevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/phone.vue





/* normalize component */

var phone_component = Object(componentNormalizer["default"])(
  types_phonevue_type_script_lang_js_,
  phonevue_type_template_id_34a02224_render,
  phonevue_type_template_id_34a02224_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var phone_api; }
phone_component.options.__file = "resources/assets/js/src/components/fields/types/phone.vue"
/* harmony default export */ var phone = (phone_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/combo.vue?vue&type=template&id=90b659e4&
var combovue_type_template_id_90b659e4_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "o-combo o-form__group" }, [
    _c("div", { staticClass: "o-combo__head" }, [
      _c("div", { staticClass: "o-combo__label" }, [
        _vm._v(_vm._s(_vm.comboField.options.name))
      ])
    ]),
    _vm._v(" "),
    _vm.showDraggables
      ? _c(
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
                                  return _vm.toggleBodyHide($event, item.id)
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
                                    return _vm.deleteItem(item.id)
                                  },
                                  duplicate: function($event) {
                                    return _vm.duplicateItem(item.id)
                                  }
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass: "o-combo__body",
                        style: { display: _vm.isHidingBody ? "none" : "block" }
                      },
                      [
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
                          }),
                          1
                        )
                      ]
                    )
                  ]
                )
              }),
              0
            )
          ],
          1
        )
      : _vm._e(),
    _vm._v(" "),
    _c("div", { staticClass: "o-combo__foot" }, [
      _vm.isMultiple
        ? _c(
            "button",
            {
              staticClass: "o-btn o-btn--sm",
              on: {
                click: function($event) {
                  return _vm.addEmptyItem($event)
                }
              }
            },
            [_vm._v("Add " + _vm._s(_vm.comboField.options.comboAddName))]
          )
        : _vm._e()
    ])
  ])
}
var combovue_type_template_id_90b659e4_staticRenderFns = []
combovue_type_template_id_90b659e4_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/combo.vue?vue&type=template&id=90b659e4&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/combo.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  watch: {
    items: function items() {
      if (!this.items.length) {
        this.addEmptyItem();
      }
    }
  },
  methods: {
    toggleBodyHide: function toggleBodyHide(evt, scrollID) {
      evt.preventDefault();
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
    addEmptyItem: function addEmptyItem(evt) {
      evt && evt.preventDefault();
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
    },
    showDraggables: function showDraggables() {
      return this.$store.state.showDraggables;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/combo.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_combovue_type_script_lang_js_ = (combovue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/combo.vue





/* normalize component */

var combo_component = Object(componentNormalizer["default"])(
  types_combovue_type_script_lang_js_,
  combovue_type_template_id_90b659e4_render,
  combovue_type_template_id_90b659e4_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var combo_api; }
combo_component.options.__file = "resources/assets/js/src/components/fields/types/combo.vue"
/* harmony default export */ var combo = (combo_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/select.vue?vue&type=template&id=461d3ea8&
var selectvue_type_template_id_461d3ea8_render = function() {
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
var selectvue_type_template_id_461d3ea8_staticRenderFns = []
selectvue_type_template_id_461d3ea8_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/select.vue?vue&type=template&id=461d3ea8&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/single-select.vue?vue&type=template&id=8b501bbe&
var single_selectvue_type_template_id_8b501bbe_render = function() {
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
var single_selectvue_type_template_id_8b501bbe_staticRenderFns = []
single_selectvue_type_template_id_8b501bbe_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/single-select.vue?vue&type=template&id=8b501bbe&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/mixins/select-values.vue?vue&type=script&lang=js&
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

          var isMultiple = _field.options.settings.multiple || _field.options.settings.multiple_instances;

          if (combo && combo.values.length) {
            var values = combo.values.filter(function (value) {
              return value.id === _this.comboItemId;
            });

            if (values.length && values[0][this.fieldId]) {
              if (isMultiple) {
                return values[0][this.fieldId].map(function (value) {
                  return value.value;
                });
              } else if (values[0][this.fieldId][0]) {
                return values[0][this.fieldId][0].value;
              }
            }

            if (isMultiple) {
              return [];
            }
          }
        } else {
          field = this.$store.getters.getField(this.fieldId);

          var _isMultiple = field.options.settings.multiple || field.options.settings.multiple_instances;

          if (_isMultiple) {
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/mixins/select-values.vue?vue&type=script&lang=js&
 /* harmony default export */ var mixins_select_valuesvue_type_script_lang_js_ = (select_valuesvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/mixins/select-values.vue
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
select_values_component.options.__file = "resources/assets/js/src/components/fields/types/mixins/select-values.vue"
/* harmony default export */ var select_values = (select_values_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/single-select.vue?vue&type=script&lang=js&
//
//
//
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
  watch: {
    values: function values() {
      if (this.values === '') {
        this.selectInstance.highlightAll();
        this.selectInstance.removeHighlightedItems();
      } else {
        this.selectInstance.setValueByChoice(this.values);
      }
    }
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/single-select.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_single_selectvue_type_script_lang_js_ = (single_selectvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/single-select.vue





/* normalize component */

var single_select_component = Object(componentNormalizer["default"])(
  types_single_selectvue_type_script_lang_js_,
  single_selectvue_type_template_id_8b501bbe_render,
  single_selectvue_type_template_id_8b501bbe_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var single_select_api; }
single_select_component.options.__file = "resources/assets/js/src/components/fields/types/single-select.vue"
/* harmony default export */ var single_select = (single_select_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/multi-select.vue?vue&type=template&id=84e61080&
var multi_selectvue_type_template_id_84e61080_render = function() {
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
              _vm._l(_vm.valueOptions, function(option, index) {
                return _c("input", {
                  key: index,
                  attrs: { type: "hidden", name: _vm.inputName },
                  domProps: { value: option.value }
                })
              }),
              _vm._v(" "),
              _vm.showDraggables
                ? _c(
                    "div",
                    { staticClass: "o-drag-select__column-wrap" },
                    [
                      _c("div", { staticClass: "o-drag-select__title" }, [
                        _c("div", { staticClass: "o-drag-select__search" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.search,
                                expression: "search"
                              }
                            ],
                            attrs: { type: "text", placeholder: "Search.." },
                            domProps: { value: _vm.search },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.search = $event.target.value
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c("button", {
                            staticClass: "o-drag-select__search-close",
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.clearSearch($event)
                              }
                            }
                          })
                        ])
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
                              animation: 75
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
                        }),
                        0
                      )
                    ],
                    1
                  )
                : _vm._e(),
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
              _vm.showDraggables
                ? _c(
                    "div",
                    { staticClass: "o-drag-select__column-wrap" },
                    [
                      _c("div", { staticClass: "o-drag-select__title" }, [
                        _c("span", [_vm._v("Selected")])
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
                              animation: 75
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
                        }),
                        0
                      )
                    ],
                    1
                  )
                : _vm._e()
            ],
            2
          )
        ]
      )
    ],
    1
  )
}
var multi_selectvue_type_template_id_84e61080_staticRenderFns = []
multi_selectvue_type_template_id_84e61080_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/multi-select.vue?vue&type=template&id=84e61080&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/multi-select.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      search: '',
      tmpFiltered: [],
      tmpValues: []
    };
  },
  watch: {
    values: function values() {
      this.filterOptions();
    }
  },
  created: function created() {
    this.filterOptions();
  },
  computed: {
    filteredOptions: {
      get: function get() {
        var _this = this;

        if (this.search) {
          return this.tmpFiltered.filter(function (el) {
            return el.label.match(new RegExp(_this.search));
          });
        }

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
    },
    showDraggables: function showDraggables() {
      return this.$store.state.showDraggables;
    }
  },
  methods: {
    filterOptions: function filterOptions() {
      var _this2 = this;

      this.tmpFiltered = this.options.filter(function (option) {
        return !~_this2.values.findIndex(function (value) {
          return value === option.value;
        });
      });
      this.tmpValues = this.values.reduce(function (acc, value) {
        if (!value) {
          return acc;
        }

        var option = _this2.options.find(function (opt) {
          return opt.value === value;
        });

        if (!option) {
          return acc;
        }

        acc.push(option);
        return acc;
      }, []);
    },
    clearSearch: function clearSearch() {
      this.search = '';
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/multi-select.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_multi_selectvue_type_script_lang_js_ = (multi_selectvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/multi-select.vue





/* normalize component */

var multi_select_component = Object(componentNormalizer["default"])(
  types_multi_selectvue_type_script_lang_js_,
  multi_selectvue_type_template_id_84e61080_render,
  multi_selectvue_type_template_id_84e61080_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var multi_select_api; }
multi_select_component.options.__file = "resources/assets/js/src/components/fields/types/multi-select.vue"
/* harmony default export */ var multi_select = (multi_select_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/select.vue?vue&type=script&lang=js&
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

      if (field.options.settings.multiple || field.options.settings.multiple_instances) {
        return 'multi';
      }

      return 'single';
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/select.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_selectvue_type_script_lang_js_ = (selectvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/select.vue





/* normalize component */

var select_component = Object(componentNormalizer["default"])(
  types_selectvue_type_script_lang_js_,
  selectvue_type_template_id_461d3ea8_render,
  selectvue_type_template_id_461d3ea8_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var select_api; }
select_component.options.__file = "resources/assets/js/src/components/fields/types/select.vue"
/* harmony default export */ var types_select = (select_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/location/index.vue?vue&type=template&id=b32c30b0&
var locationvue_type_template_id_b32c30b0_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-form__group" },
    [
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
                _c("field-location", {
                  attrs: {
                    "field-id": _vm.fieldId,
                    "combo-id": _vm.comboId,
                    "combo-item-id": _vm.comboItemId,
                    "value-obj": valueObj
                  }
                })
              ]
            }
          }
        ])
      }),
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
var locationvue_type_template_id_b32c30b0_staticRenderFns = []
locationvue_type_template_id_b32c30b0_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/location/index.vue?vue&type=template&id=b32c30b0&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/location/location.vue?vue&type=template&id=abfa8c62&
var locationvue_type_template_id_abfa8c62_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "o-form__set" }, [
    _c("div", { staticClass: "o-form__set-title" }, [
      _c(
        "label",
        {
          attrs: {
            for: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][latitude]"
          }
        },
        [_vm._v(_vm._s(_vm.name))]
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "o-form__set-container" }, [
      _c(
        "div",
        { staticClass: "o-form__group" },
        [
          _c(
            "validation",
            {
              attrs: {
                "status-error": _vm.errors && _vm.errors.latitude,
                "input-name":
                  _vm.inputNameMultiValue +
                  "[" +
                  _vm.valueObj.id +
                  "][latitude]"
              }
            },
            [
              _c(
                "label",
                {
                  attrs: {
                    for:
                      _vm.inputNameMultiValue +
                      "[" +
                      _vm.valueObj.id +
                      "][latitude]"
                  }
                },
                [_vm._v("Latitude")]
              ),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.latitude,
                    expression: "latitude"
                  }
                ],
                attrs: {
                  type: "text",
                  id:
                    _vm.inputNameMultiValue +
                    "[" +
                    _vm.valueObj.id +
                    "][latitude]",
                  name:
                    _vm.inputNameMultiValue +
                    "[" +
                    _vm.valueObj.id +
                    "][latitude]"
                },
                domProps: { value: _vm.latitude },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.latitude = $event.target.value
                  }
                }
              })
            ]
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "o-form__group" },
        [
          _c(
            "validation",
            {
              attrs: {
                "status-error": _vm.errors && _vm.errors.longitude,
                "input-name":
                  _vm.inputNameMultiValue +
                  "[" +
                  _vm.valueObj.id +
                  "][longitude]"
              }
            },
            [
              _c(
                "label",
                {
                  attrs: {
                    for:
                      _vm.inputNameMultiValue +
                      "[" +
                      _vm.valueObj.id +
                      "][longitude]"
                  }
                },
                [_vm._v("Longitude")]
              ),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.longitude,
                    expression: "longitude"
                  }
                ],
                attrs: {
                  type: "text",
                  id:
                    _vm.inputNameMultiValue +
                    "[" +
                    _vm.valueObj.id +
                    "][longitude]",
                  name:
                    _vm.inputNameMultiValue +
                    "[" +
                    _vm.valueObj.id +
                    "][longitude]"
                },
                domProps: { value: _vm.longitude },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.longitude = $event.target.value
                  }
                }
              })
            ]
          )
        ],
        1
      )
    ])
  ])
}
var locationvue_type_template_id_abfa8c62_staticRenderFns = []
locationvue_type_template_id_abfa8c62_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/location/location.vue?vue&type=template&id=abfa8c62&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/location/location.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['fieldId', 'comboId', 'comboItemId', 'valueObj'],
  mixins: [field_values],
  data: function data() {
    return {
      loading: true,
      latitude: '',
      longitude: ''
    };
  },
  mounted: function mounted() {
    if (this.valueObj.value) {
      this.latitude = this.valueObj.value.latitude;
      this.longitude = this.valueObj.value.longitude;
    }

    this.loading = false;
  },
  watch: {
    latitude: function latitude(newValue) {
      if (this.loading) {
        return;
      }

      this.updateValue(newValue, 'latitude');
    },
    longitude: function longitude(newValue) {
      if (this.loading) {
        return;
      }

      this.updateValue(newValue, 'longitude');
    }
  },
  components: {
    'validation': validation
  },
  methods: {
    updateValue: function updateValue(newValue, prop) {
      if (!this.valueObj.value) {
        this.valueObj.value = {};
      }

      this.valueObj.value[prop] = newValue;

      if (this.comboId) {
        this.$store.commit('updateComboFieldValue', {
          fieldID: this.fieldId,
          comboID: this.comboId,
          comboItemId: this.comboItemId,
          newValue: this.valueObj
        });
      } else {
        this.$store.commit('updateValue', {
          fieldID: this.fieldId,
          newValue: this.valueObj
        });
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/location/location.vue?vue&type=script&lang=js&
 /* harmony default export */ var location_locationvue_type_script_lang_js_ = (locationvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/location/location.vue





/* normalize component */

var location_component = Object(componentNormalizer["default"])(
  location_locationvue_type_script_lang_js_,
  locationvue_type_template_id_abfa8c62_render,
  locationvue_type_template_id_abfa8c62_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var location_api; }
location_component.options.__file = "resources/assets/js/src/components/fields/types/location/location.vue"
/* harmony default export */ var location_location = (location_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/location/index.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var types_locationvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  mixins: [field_values],
  components: {
    'validation': validation,
    'multi': multi,
    'field-location': location_location
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/location/index.vue?vue&type=script&lang=js&
 /* harmony default export */ var fields_types_locationvue_type_script_lang_js_ = (types_locationvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/location/index.vue





/* normalize component */

var types_location_component = Object(componentNormalizer["default"])(
  fields_types_locationvue_type_script_lang_js_,
  locationvue_type_template_id_b32c30b0_render,
  locationvue_type_template_id_b32c30b0_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var types_location_api; }
types_location_component.options.__file = "resources/assets/js/src/components/fields/types/location/index.vue"
/* harmony default export */ var types_location = (types_location_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/wysiwyg.vue?vue&type=template&id=0575760d&
var wysiwygvue_type_template_id_0575760d_render = function() {
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
                          return _vm.updateValue(valueObj, $event)
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
var wysiwygvue_type_template_id_0575760d_staticRenderFns = []
wysiwygvue_type_template_id_0575760d_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/wysiwyg.vue?vue&type=template&id=0575760d&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/single-wysiwyg.vue?vue&type=template&id=563dd990&
var single_wysiwygvue_type_template_id_563dd990_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("textarea", {
    style: { height: _vm.totalHeight + "px" },
    attrs: { id: _vm.inputName, name: _vm.inputName }
  })
}
var single_wysiwygvue_type_template_id_563dd990_staticRenderFns = []
single_wysiwygvue_type_template_id_563dd990_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/single-wysiwyg.vue?vue&type=template&id=563dd990&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/single-wysiwyg.vue?vue&type=script&lang=js&
function single_wysiwygvue_type_script_lang_js_extends() { single_wysiwygvue_type_script_lang_js_extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return single_wysiwygvue_type_script_lang_js_extends.apply(this, arguments); }

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
        extraPlugins: 'stylesheetparser',
        forcePasteAsPlainText: true,
        pasteFromWordRemoveStyles: true,
        pasteFromWordRemoveFontStyles: true,
        removePlugins: 'pastefromword'
      }
    };
  },
  watch: {
    valueObj: function valueObj() {
      CKEDITOR.instances[this.wysiwygInstance].setData(this.valueObj.value);
    }
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
        config.format_tags = 'p;' + fieldConfig['format-tags'];
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

      config = single_wysiwygvue_type_script_lang_js_extends({}, this.defaultConfig, config);
      return config;
    },
    inputName: function inputName() {
      return this.name;
    }
  },
  methods: {
    updateValue: function updateValue(newValue) {
      this.$emit('update', newValue);
    }
  },
  mounted: function mounted() {
    var _this = this;

    var name = 'move-' + this.fieldId;

    if (this.comboId) {
      name = 'move-' + this.fieldId + '-' + this.comboId + '-' + this.comboItemId;
    }

    EventBus.$on(name, function () {
      updateEditorHeight.call(_this);
      destoryEditor.call(_this);
      mountEditor.call(_this);
    });
    mountEditor.call(this);
  },
  beforeDestroy: function beforeDestroy() {
    destoryEditor.call(this);
  }
});

function updateEditorHeight() {
  this.totalHeight = this.textareaElement.nextElementSibling.offsetHeight;
} // TODO: fix multi wysiwyg instances, as it appears as a single ckeditor instance and adding a unique hash to the name breaks the backend


function mountEditor() {
  var _this2 = this;

  var textarea = this.$el;
  this.textareaElement = textarea;
  CKEDITOR.replace(this.textareaElement, this.config);
  this.wysiwygInstance = this.textareaElement.name;
  CKEDITOR.instances[this.wysiwygInstance].setData(this.valueObj.value);
  this.$el.value = this.valueObj.value;
  CKEDITOR.instances[this.wysiwygInstance].on('change', function () {
    var data = CKEDITOR.instances[_this2.wysiwygInstance].getData();

    _this2.updateValue(data);

    _this2.$el.value = data;
  });
}

function destoryEditor() {
  CKEDITOR.instances[this.wysiwygInstance] && CKEDITOR.instances[this.wysiwygInstance].destroy(true);
}
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/single-wysiwyg.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_single_wysiwygvue_type_script_lang_js_ = (single_wysiwygvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/single-wysiwyg.vue





/* normalize component */

var single_wysiwyg_component = Object(componentNormalizer["default"])(
  types_single_wysiwygvue_type_script_lang_js_,
  single_wysiwygvue_type_template_id_563dd990_render,
  single_wysiwygvue_type_template_id_563dd990_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var single_wysiwyg_api; }
single_wysiwyg_component.options.__file = "resources/assets/js/src/components/fields/types/single-wysiwyg.vue"
/* harmony default export */ var single_wysiwyg = (single_wysiwyg_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/wysiwyg.vue?vue&type=script&lang=js&
//
//
//
//
//
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/wysiwyg.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_wysiwygvue_type_script_lang_js_ = (wysiwygvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/wysiwyg.vue





/* normalize component */

var wysiwyg_component = Object(componentNormalizer["default"])(
  types_wysiwygvue_type_script_lang_js_,
  wysiwygvue_type_template_id_0575760d_render,
  wysiwygvue_type_template_id_0575760d_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var wysiwyg_api; }
wysiwyg_component.options.__file = "resources/assets/js/src/components/fields/types/wysiwyg.vue"
/* harmony default export */ var wysiwyg = (wysiwyg_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/button/index.vue?vue&type=template&id=237fdce5&
var buttonvue_type_template_id_237fdce5_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-form__group" },
    [
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
                _c("field-button", {
                  attrs: {
                    "value-obj": valueObj,
                    "field-id": _vm.fieldId,
                    "combo-id": _vm.comboId,
                    "combo-item-id": _vm.comboItemId
                  }
                })
              ]
            }
          }
        ])
      }),
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
var buttonvue_type_template_id_237fdce5_staticRenderFns = []
buttonvue_type_template_id_237fdce5_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/button/index.vue?vue&type=template&id=237fdce5&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/button/button.vue?vue&type=template&id=37f285af&
var buttonvue_type_template_id_37f285af_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "o-form__set" }, [
    _c("div", { staticClass: "o-form__set-title" }, [
      _c(
        "label",
        {
          attrs: {
            for: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][label]"
          }
        },
        [_vm._v(_vm._s(_vm.name))]
      )
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "o-form__set-container" },
      [
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.btnclass,
              expression: "btnclass"
            }
          ],
          attrs: {
            type: "hidden",
            name: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][class]"
          },
          domProps: { value: _vm.btnclass },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.btnclass = $event.target.value
            }
          }
        }),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.id,
              expression: "id"
            }
          ],
          attrs: {
            type: "hidden",
            name: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][id]"
          },
          domProps: { value: _vm.id },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.id = $event.target.value
            }
          }
        }),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.target,
              expression: "target"
            }
          ],
          attrs: {
            type: "hidden",
            name: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][target]"
          },
          domProps: { value: _vm.target },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.target = $event.target.value
            }
          }
        }),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "o-form__group" },
          [
            _c(
              "validation",
              {
                attrs: {
                  "status-error": _vm.errors && _vm.errors.label,
                  "input-name":
                    _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][label]"
                }
              },
              [
                _c(
                  "label",
                  {
                    attrs: {
                      for:
                        _vm.inputNameMultiValue +
                        "[" +
                        _vm.valueObj.id +
                        "][label]"
                    }
                  },
                  [_vm._v("Label")]
                ),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.label,
                      expression: "label"
                    }
                  ],
                  attrs: {
                    type: "text",
                    id:
                      _vm.inputNameMultiValue +
                      "[" +
                      _vm.valueObj.id +
                      "][label]",
                    name:
                      _vm.inputNameMultiValue +
                      "[" +
                      _vm.valueObj.id +
                      "][label]"
                  },
                  domProps: { value: _vm.label },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.label = $event.target.value
                    }
                  }
                })
              ]
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "o-form__group" },
          [
            _c(
              "validation",
              {
                attrs: {
                  "status-error": _vm.errors && _vm.errors.url,
                  "input-name":
                    _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][url]"
                }
              },
              [
                _c(
                  "label",
                  {
                    attrs: {
                      for:
                        _vm.inputNameMultiValue +
                        "[" +
                        _vm.valueObj.id +
                        "][url]"
                    }
                  },
                  [_vm._v("Url")]
                ),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.url,
                      expression: "url"
                    }
                  ],
                  attrs: {
                    type: "text",
                    id:
                      _vm.inputNameMultiValue +
                      "[" +
                      _vm.valueObj.id +
                      "][url]",
                    name:
                      _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][url]"
                  },
                  domProps: { value: _vm.url },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.url = $event.target.value
                    }
                  }
                })
              ]
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "transition",
          {
            attrs: {
              "enter-active-class": "collapsing",
              "leave-active-class": "collapsing"
            },
            on: {
              enter: _vm.enter,
              afterEnter: _vm.afterEnter,
              leave: _vm.leave,
              afterLeave: _vm.afterLeave
            }
          },
          [
            _vm.show
              ? _c("div", { staticClass: "o-form__set-accordion" }, [
                  _c(
                    "div",
                    { staticClass: "o-form__group" },
                    [
                      _c(
                        "validation",
                        {
                          attrs: {
                            "status-error": _vm.errors && _vm.errors.class,
                            "input-name":
                              _vm.inputNameMultiValue +
                              "[" +
                              _vm.valueObj.id +
                              "][class]"
                          }
                        },
                        [
                          _c(
                            "label",
                            {
                              attrs: {
                                for:
                                  _vm.inputNameMultiValue +
                                  "[" +
                                  _vm.valueObj.id +
                                  "][class]"
                              }
                            },
                            [_vm._v("Class")]
                          ),
                          _vm._v(" "),
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.btnclass,
                                expression: "btnclass"
                              }
                            ],
                            attrs: {
                              type: "text",
                              id:
                                _vm.inputNameMultiValue +
                                "[" +
                                _vm.valueObj.id +
                                "][class]"
                            },
                            domProps: { value: _vm.btnclass },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.btnclass = $event.target.value
                              }
                            }
                          })
                        ]
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "o-form__group" },
                    [
                      _c(
                        "validation",
                        {
                          attrs: {
                            "status-error": _vm.errors && _vm.errors.id,
                            "input-name":
                              _vm.inputNameMultiValue +
                              "[" +
                              _vm.valueObj.id +
                              "][id]"
                          }
                        },
                        [
                          _c(
                            "label",
                            {
                              attrs: {
                                for:
                                  _vm.inputNameMultiValue +
                                  "[" +
                                  _vm.valueObj.id +
                                  "][id]"
                              }
                            },
                            [_vm._v("ID")]
                          ),
                          _vm._v(" "),
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.id,
                                expression: "id"
                              }
                            ],
                            attrs: {
                              type: "text",
                              id:
                                _vm.inputNameMultiValue +
                                "[" +
                                _vm.valueObj.id +
                                "][id]"
                            },
                            domProps: { value: _vm.id },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.id = $event.target.value
                              }
                            }
                          })
                        ]
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "o-form__group" },
                    [
                      _c(
                        "validation",
                        {
                          attrs: {
                            "status-error": _vm.errors && _vm.errors.target,
                            "input-name":
                              _vm.inputNameMultiValue +
                              "[" +
                              _vm.valueObj.id +
                              "][target]"
                          }
                        },
                        [
                          _c(
                            "label",
                            {
                              attrs: {
                                for:
                                  _vm.inputNameMultiValue +
                                  "[" +
                                  _vm.valueObj.id +
                                  "][target]"
                              }
                            },
                            [_vm._v("Target")]
                          ),
                          _vm._v(" "),
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.target,
                                expression: "target"
                              }
                            ],
                            attrs: {
                              type: "text",
                              id:
                                _vm.inputNameMultiValue +
                                "[" +
                                _vm.valueObj.id +
                                "][target]"
                            },
                            domProps: { value: _vm.target },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.target = $event.target.value
                              }
                            }
                          })
                        ]
                      )
                    ],
                    1
                  )
                ])
              : _vm._e()
          ]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "o-btn o-btn--sm",
            on: {
              click: function($event) {
                return _vm.toggle($event)
              }
            }
          },
          [_vm._v(_vm._s(_vm.show ? "less" : "more") + " options")]
        )
      ],
      1
    )
  ])
}
var buttonvue_type_template_id_37f285af_staticRenderFns = []
buttonvue_type_template_id_37f285af_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/button/button.vue?vue&type=template&id=37f285af&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/button/button.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['fieldId', 'comboId', 'comboItemId', 'valueObj'],
  components: {
    'input-icon': input_icon,
    'validation': validation
  },
  mixins: [field_values],
  data: function data() {
    return {
      show: false,
      transitioning: false,
      loading: true,
      label: '',
      url: '',
      btnclass: '',
      id: '',
      target: ''
    };
  },
  mounted: function mounted() {
    if (this.valueObj.value) {
      this.label = this.valueObj.value.label;
      this.url = this.valueObj.value.url;
      this.btnclass = this.valueObj.value.class;
      this.id = this.valueObj.value.id;
      this.target = this.valueObj.value.target;
    }

    this.loading = false;
  },
  watch: {
    label: function label(newValue) {
      if (this.loading) {
        return;
      }

      this.updateValue(newValue, 'label');
    },
    url: function url(newValue) {
      if (this.loading) {
        return;
      }

      this.updateValue(newValue, 'url');
    },
    btnclass: function btnclass(newValue) {
      if (this.loading) {
        return;
      }

      this.updateValue(newValue, 'class');
    },
    id: function id(newValue) {
      if (this.loading) {
        return;
      }

      this.updateValue(newValue, 'id');
    },
    target: function target(newValue) {
      if (this.loading) {
        return;
      }

      this.updateValue(newValue, 'target');
    }
  },
  methods: {
    updateValue: function updateValue(newValue, prop) {
      var _this = this;

      if (!this.valueObj.value) {
        this.valueObj.value = {};
      }

      this.valueObj.value[prop] = newValue;
      this.$nextTick(function () {
        if (_this.comboId) {
          _this.$store.commit('updateComboFieldValue', {
            fieldID: _this.fieldId,
            comboID: _this.comboId,
            comboItemId: _this.comboItemId,
            newValue: _this.valueObj
          });
        } else {
          _this.$store.commit('updateValue', {
            fieldID: _this.fieldId,
            newValue: _this.valueObj
          });
        }
      });
    },
    toggle: function toggle(evt) {
      evt.preventDefault();
      this.show = !this.show;
    },
    enter: function enter(el) {
      el.style.height = 0;
      el.offsetHeight;
      el.style.height = el.scrollHeight + 'px';
      this.transitioning = true;
    },
    afterEnter: function afterEnter(el) {
      el.style.height = null;
      this.transitioning = false;
    },
    leave: function leave(el) {
      el.style.height = 'auto';
      el.style.display = 'block';

      var _el$getBoundingClient = el.getBoundingClientRect(),
          height = _el$getBoundingClient.height;

      el.style.height = height + 'px';
      el.offsetHeight;
      this.transitioning = true;
      el.style.height = 0;
    },
    afterLeave: function afterLeave(el) {
      el.style.height = null;
      this.transitioning = false;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/button/button.vue?vue&type=script&lang=js&
 /* harmony default export */ var button_buttonvue_type_script_lang_js_ = (buttonvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/button/button.vue





/* normalize component */

var button_component = Object(componentNormalizer["default"])(
  button_buttonvue_type_script_lang_js_,
  buttonvue_type_template_id_37f285af_render,
  buttonvue_type_template_id_37f285af_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var button_api; }
button_component.options.__file = "resources/assets/js/src/components/fields/types/button/button.vue"
/* harmony default export */ var button_button = (button_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/button/index.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ var types_buttonvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  mixins: [field_values],
  components: {
    'multi': multi,
    'field-button': button_button
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/button/index.vue?vue&type=script&lang=js&
 /* harmony default export */ var fields_types_buttonvue_type_script_lang_js_ = (types_buttonvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/button/index.vue





/* normalize component */

var types_button_component = Object(componentNormalizer["default"])(
  fields_types_buttonvue_type_script_lang_js_,
  buttonvue_type_template_id_237fdce5_render,
  buttonvue_type_template_id_237fdce5_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var types_button_api; }
types_button_component.options.__file = "resources/assets/js/src/components/fields/types/button/index.vue"
/* harmony default export */ var types_button = (types_button_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/boolean.vue?vue&type=template&id=49a456a8&
var booleanvue_type_template_id_49a456a8_render = function() {
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
                      return _vm.onChange(_vm.valueObj, _vm.checked)
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
var booleanvue_type_template_id_49a456a8_staticRenderFns = []
booleanvue_type_template_id_49a456a8_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/boolean.vue?vue&type=template&id=49a456a8&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/boolean.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
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
  mixins: [field_values, value_objs],
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

          if (values.length && values[0][this.fieldId].length) {
            return values[0][this.fieldId][0];
          } else {
            return {
              id: 0,
              value: ''
            };
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

          if (values.length && values[0][this.fieldId].length) {
            value = values[0][this.fieldId][0].value;
          } else {
            value = field.options.settings.initial_value;
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
        return +value || 0;
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/boolean.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_booleanvue_type_script_lang_js_ = (booleanvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/boolean.vue





/* normalize component */

var boolean_component = Object(componentNormalizer["default"])(
  types_booleanvue_type_script_lang_js_,
  booleanvue_type_template_id_49a456a8_render,
  booleanvue_type_template_id_49a456a8_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var boolean_api; }
boolean_component.options.__file = "resources/assets/js/src/components/fields/types/boolean.vue"
/* harmony default export */ var types_boolean = (boolean_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/datetime.vue?vue&type=template&id=4bed29ab&
var datetimevue_type_template_id_4bed29ab_render = function() {
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
          _c("flat-pickr", {
            attrs: {
              config: _vm.config,
              name: _vm.inputName,
              id: _vm.inputName,
              value: _vm.singleValue.value
            },
            on: { "on-change": _vm.onChange }
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
var datetimevue_type_template_id_4bed29ab_staticRenderFns = []
datetimevue_type_template_id_4bed29ab_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/datetime.vue?vue&type=template&id=4bed29ab&

// EXTERNAL MODULE: ./node_modules/vue-flatpickr-component/dist/vue-flatpickr.min.js
var vue_flatpickr_min = __webpack_require__("./node_modules/vue-flatpickr-component/dist/vue-flatpickr.min.js");
var vue_flatpickr_min_default = /*#__PURE__*/__webpack_require__.n(vue_flatpickr_min);

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/datetime.vue?vue&type=script&lang=js&
function datetimevue_type_script_lang_js_extends() { datetimevue_type_script_lang_js_extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return datetimevue_type_script_lang_js_extends.apply(this, arguments); }

//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var datetimevue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  mixins: [field_values, value_objs],
  components: {
    'validation': validation,
    flatPickr: vue_flatpickr_min_default.a
  },
  data: function data() {
    return {
      defaultConfig: {
        altFormat: 'd F, Y',
        defaultDate: null,
        default: false,
        mode: 'single',
        dateFormat: 'Y-m-d H:i:S',
        altInput: true,
        enableTime: false
      }
    };
  },
  watch: {
    singleValue: function singleValue() {
      if (this.singleValue.value === '' && this.config.default) {
        this.updateValue(this.singleValue, new Date());
      }
    }
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
    },
    onChange: function onChange(_, strDate) {
      this.updateValue(this.singleValue, strDate);
    }
  },
  computed: {
    config: function config() {
      var config = {};
      var field;

      if (this.comboId) {
        field = this.$store.getters.getComboField(this.comboId, this.fieldId);
      } else {
        field = this.$store.getters.getField(this.fieldId);
      }

      var fieldSettings = field.options.settings;

      if (fieldSettings.time) {
        config.enableTime = true;
        config.altFormat = 'd F, Y h:i K';
      }

      config.default = fieldSettings.default;

      if (fieldSettings.default) {
        config.defaultDate = new Date();
      }

      return datetimevue_type_script_lang_js_extends(this.defaultConfig, config);
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/datetime.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_datetimevue_type_script_lang_js_ = (datetimevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/datetime.vue





/* normalize component */

var datetime_component = Object(componentNormalizer["default"])(
  types_datetimevue_type_script_lang_js_,
  datetimevue_type_template_id_4bed29ab_render,
  datetimevue_type_template_id_4bed29ab_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var datetime_api; }
datetime_component.options.__file = "resources/assets/js/src/components/fields/types/datetime.vue"
/* harmony default export */ var datetime = (datetime_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/image/index.vue?vue&type=template&id=b2a79ac4&
var imagevue_type_template_id_b2a79ac4_render = function() {
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
          _c("label", { attrs: { for: _vm.inputName + "[alt]" } }, [
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
                    _c("field-image", {
                      attrs: {
                        "field-id": _vm.fieldId,
                        "combo-id": _vm.comboId,
                        "combo-item-id": _vm.comboItemId,
                        "value-obj": valueObj
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
var imagevue_type_template_id_b2a79ac4_staticRenderFns = []
imagevue_type_template_id_b2a79ac4_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/image/index.vue?vue&type=template&id=b2a79ac4&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/image/image.vue?vue&type=template&id=bb1372b2&
var imagevue_type_template_id_bb1372b2_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "o-file" }, [
    _c("div", { staticClass: "o-file__preview" }, [
      _c("div", { staticClass: "o-file__preview-wrap" }, [
        _c("img", { attrs: { src: _vm.valueObj.value.url || "" } })
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "o-file__help-text" }, [
      _c("div", { staticClass: "o-form-icon" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.alt,
              expression: "alt"
            }
          ],
          attrs: {
            type: "text",
            id: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][alt]",
            name: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][alt]"
          },
          domProps: { value: _vm.alt },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.alt = $event.target.value
            }
          }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: {
            type: "hidden",
            id: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][width]",
            name: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][width]"
          },
          domProps: { value: _vm.valueObj.value && _vm.valueObj.value.width }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: {
            type: "hidden",
            id: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][height]",
            name: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][height]"
          },
          domProps: { value: _vm.valueObj.value && _vm.valueObj.value.height }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: {
            type: "hidden",
            id: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][url]",
            name: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][url]"
          },
          domProps: { value: _vm.valueObj.value && _vm.valueObj.value.url }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: {
            type: "hidden",
            id: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][id]",
            name: _vm.inputNameMultiValue + "[" + _vm.valueObj.id + "][id]"
          },
          domProps: { value: _vm.valueObj.value && _vm.valueObj.value.id }
        })
      ]),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "o-btn o-btn--sm o-file__btn",
          on: {
            click: function($event) {
              $event.preventDefault()
              return _vm.selectImage($event)
            }
          }
        },
        [_vm._v("select")]
      )
    ]),
    _vm._v(" "),
    !_vm.field.options.settings.multiple
      ? _c(
          "button",
          {
            staticClass: "o-confirm-btn",
            attrs: { "data-balloon": "Delete", title: "Delete" },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.clearValue($event)
              }
            }
          },
          [
            _c("svg", [
              _c("use", {
                attrs: { "xlink:href": "/argon/images/svgicons.svg#delete" }
              })
            ])
          ]
        )
      : _vm._e()
  ])
}
var imagevue_type_template_id_bb1372b2_staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "o-form-icon__icon" }, [
      _c("span", [_vm._v("Alt")])
    ])
  }
]
imagevue_type_template_id_bb1372b2_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/image/image.vue?vue&type=template&id=bb1372b2&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/App.vue?vue&type=template&id=639a027f&
var Appvue_type_template_id_639a027f_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("transition", { attrs: { name: "fade" } }, [
        _vm.isPicker && _vm.isOpen
          ? _c("div", { staticClass: "c-media-library__picker" }, [
              _c("div", {
                staticClass: "c-media-library__picker-bg",
                on: { click: _vm.closePicker }
              }),
              _vm._v(" "),
              _c("div", { staticClass: "c-media-library__picker-btn" }, [
                _c(
                  "button",
                  {
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.closePicker($event)
                      }
                    }
                  },
                  [
                    _c("svg", [
                      _c("use", {
                        attrs: {
                          "xlink:href":
                            "/argon/images/svgicons.svg#cross-circle"
                        }
                      })
                    ])
                  ]
                )
              ]),
              _vm._v(" "),
              _c(
                "main",
                { staticClass: "c-container c-container--main" },
                [_c("media-library")],
                1
              )
            ])
          : _vm._e()
      ]),
      _vm._v(" "),
      !_vm.isPicker ? _c("media-library") : _vm._e()
    ],
    1
  )
}
var Appvue_type_template_id_639a027f_staticRenderFns = []
Appvue_type_template_id_639a027f_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/App.vue?vue&type=template&id=639a027f&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/MediaLibrary.vue?vue&type=template&id=a08506a4&
var MediaLibraryvue_type_template_id_a08506a4_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "c-media-library" },
    [
      _c("action-bar"),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "c-media-library__body" },
        [
          _c("tree"),
          _vm._v(" "),
          _vm.recentUploads.show
            ? _c("recent-uploads")
            : _vm.search.hasKeywords()
            ? _c("search-results")
            : _c("directory-view"),
          _vm._v(" "),
          _vm.editItem.isSet() ? _c("edit") : _vm._e(),
          _vm._v(" "),
          _vm.uploadIsOpen ? _c("upload") : _vm._e()
        ],
        1
      )
    ],
    1
  )
}
var MediaLibraryvue_type_template_id_a08506a4_staticRenderFns = []
MediaLibraryvue_type_template_id_a08506a4_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/MediaLibrary.vue?vue&type=template&id=a08506a4&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/Tree.vue?vue&type=template&id=57304f95&
var Treevue_type_template_id_57304f95_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      directives: [{ name: "bar", rawName: "v-bar" }],
      staticClass: "c-media-library__directory-tree"
    },
    [
      _c("div", [
        _c("div", { staticClass: "c-media-library__scroller" }, [
          _c(
            "ul",
            { staticClass: "c-directory-tree" },
            [
              _c("li", [
                _c(
                  "div",
                  {
                    staticClass: "c-directory-tree__content",
                    class: { "is-active": _vm.recentUploads.show }
                  },
                  [
                    _c("button", { on: { click: _vm.openRecentUploads } }, [
                      _c("svg", [
                        _c("use", {
                          attrs: {
                            "xlink:href": "/argon/images/svgicons.svg#folder"
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _c("span", [_vm._v("Recent uploads")])
                    ])
                  ]
                )
              ]),
              _vm._v(" "),
              _c("tree-item", {
                attrs: {
                  folder: _vm.folder,
                  "recent-uploads-show": _vm.recentUploads.show
                }
              })
            ],
            1
          )
        ])
      ])
    ]
  )
}
var Treevue_type_template_id_57304f95_staticRenderFns = []
Treevue_type_template_id_57304f95_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/Tree.vue?vue&type=template&id=57304f95&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/TreeItem.vue?vue&type=template&id=10d1a6c8&
var TreeItemvue_type_template_id_10d1a6c8_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return !_vm.folder.hide
    ? _c(
        "li",
        [
          _c(
            "drop",
            {
              on: {
                dragover: function($event) {
                  return _vm.dragOver(_vm.folder)
                },
                dragleave: function($event) {
                  return _vm.dragLeave(_vm.folder)
                },
                dragend: function($event) {
                  return _vm.dragLeave(_vm.folder)
                },
                drop: function($event) {
                  var i = arguments.length,
                    argsArray = Array(i)
                  while (i--) argsArray[i] = arguments[i]
                  return _vm.handleDrop.apply(
                    void 0,
                    [_vm.folder].concat(argsArray)
                  )
                }
              }
            },
            [
              _c(
                "div",
                {
                  staticClass: "c-directory-tree__content",
                  class: {
                    "is-active": _vm.folder.active && !_vm.recentUploadsShow,
                    "is-open": _vm.folder.treeActive,
                    "is-dragover": _vm.folder.treeDragOver
                  }
                },
                [
                  _c(
                    "button",
                    {
                      on: {
                        click: function($event) {
                          return _vm.folderSelected(_vm.folder)
                        }
                      }
                    },
                    [
                      _c("svg", [
                        _c("use", {
                          attrs: {
                            "xlink:href": "/argon/images/svgicons.svg#folder"
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _c("span", [_vm._v(_vm._s(_vm.folder.name))])
                    ]
                  ),
                  _vm._v(" "),
                  _vm.folder.children && _vm.folder.children.length
                    ? _c(
                        "button",
                        {
                          staticClass: "c-directory-tree__accordion-icon",
                          on: {
                            click: function($event) {
                              return _vm.toggleChildren(_vm.folder)
                            }
                          }
                        },
                        [
                          _c("svg", [
                            _c("use", {
                              attrs: {
                                "xlink:href":
                                  "/argon/images/svgicons.svg#arrow-down"
                              }
                            })
                          ])
                        ]
                      )
                    : _vm._e()
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "transition",
            {
              attrs: {
                "enter-active-class": "collapsing",
                "leave-active-class": "collapsing"
              },
              on: {
                enter: _vm.enter,
                afterEnter: _vm.afterEnter,
                leave: _vm.leave,
                afterLeave: _vm.afterLeave
              }
            },
            [
              _vm.folder.children &&
              _vm.folder.children.length &&
              _vm.folder.treeActive
                ? _c(
                    "ul",
                    _vm._l(_vm.folder.children, function(child) {
                      return _c("tree-item", {
                        key: child.id,
                        attrs: {
                          folder: child,
                          "recent-uploads-show": _vm.recentUploadsShow
                        }
                      })
                    }),
                    1
                  )
                : _vm._e()
            ]
          )
        ],
        1
      )
    : _vm._e()
}
var TreeItemvue_type_template_id_10d1a6c8_staticRenderFns = []
TreeItemvue_type_template_id_10d1a6c8_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/TreeItem.vue?vue&type=template&id=10d1a6c8&

// EXTERNAL MODULE: ./node_modules/vue-drag-drop/dist/vue-drag-drop.common.js
var vue_drag_drop_common = __webpack_require__("./node_modules/vue-drag-drop/dist/vue-drag-drop.common.js");
var vue_drag_drop_common_default = /*#__PURE__*/__webpack_require__.n(vue_drag_drop_common);

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/TreeItem.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var TreeItemvue_type_script_lang_js_ = ({
  name: 'TreeItem',
  props: ['folder', 'recentUploadsShow'],
  components: {
    Drop: vue_drag_drop_common["Drop"]
  },
  methods: {
    folderSelected: function folderSelected(folder) {
      folder.treeActive = true;
      this.$store.dispatch('folderSelected', {
        folder: folder
      });
    },
    toggleChildren: function toggleChildren(folder) {
      folder.treeActive = !folder.treeActive;
    },
    handleDrop: function handleDrop(destinationFolder, _ref) {
      var _ref$highlighted = _ref.highlighted,
          items = _ref$highlighted.items,
          folders = _ref$highlighted.folders,
          item = _ref.item,
          folder = _ref.folder;
      destinationFolder.treeDragOver = false;

      if (!items.length && item) {
        items = [item];
      }

      if (!folders.length && folder) {
        folders = [folder];
      }

      folders = folders.filter(function (folder) {
        return folder.id !== destinationFolder.id;
      });
      this.$store.dispatch('move', {
        destinationFolder: destinationFolder,
        items: items,
        folders: folders
      });
    },
    enter: function enter(el) {
      el.style.height = 0;
      el.style.height = el.scrollHeight + 'px';
    },
    afterEnter: function afterEnter(el) {
      el.style.height = null;
    },
    leave: function leave(el) {
      el.style.height = 'auto';
      el.style.display = 'block';

      var _el$getBoundingClient = el.getBoundingClientRect(),
          height = _el$getBoundingClient.height;

      el.style.height = height + 'px';
      el.style.height = 0;
    },
    afterLeave: function afterLeave(el) {
      el.style.height = null;
    },
    dragOver: function dragOver(folder) {
      folder.treeDragOver = true;
    },
    dragLeave: function dragLeave(folder) {
      folder.treeDragOver = false;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/TreeItem.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_TreeItemvue_type_script_lang_js_ = (TreeItemvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/TreeItem.vue





/* normalize component */

var TreeItem_component = Object(componentNormalizer["default"])(
  components_TreeItemvue_type_script_lang_js_,
  TreeItemvue_type_template_id_10d1a6c8_render,
  TreeItemvue_type_template_id_10d1a6c8_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var TreeItem_api; }
TreeItem_component.options.__file = "resources/assets/js/src/components/medialib/components/TreeItem.vue"
/* harmony default export */ var TreeItem = (TreeItem_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/Tree.vue?vue&type=script&lang=js&
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

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
//


/* harmony default export */ var Treevue_type_script_lang_js_ = ({
  components: {
    TreeItem: TreeItem
  },
  computed: _objectSpread({}, Object(vuex_esm["mapState"])(['folder', 'recentUploads'])),
  methods: {
    openRecentUploads: function openRecentUploads() {
      this.$store.dispatch('recentUploads');
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/Tree.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Treevue_type_script_lang_js_ = (Treevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/Tree.vue





/* normalize component */

var Tree_component = Object(componentNormalizer["default"])(
  components_Treevue_type_script_lang_js_,
  Treevue_type_template_id_57304f95_render,
  Treevue_type_template_id_57304f95_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Tree_api; }
Tree_component.options.__file = "resources/assets/js/src/components/medialib/components/Tree.vue"
/* harmony default export */ var Tree = (Tree_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/ActionBar.vue?vue&type=template&id=99500dd4&
var ActionBarvue_type_template_id_99500dd4_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "c-media-library__header" }, [
    _c("div", { staticClass: "c-media-library__button-group" }, [
      _c(
        "button",
        {
          staticClass: "c-media-library__btn",
          attrs: { "data-balloon": "Back" },
          on: { click: _vm.back }
        },
        [
          _c("svg", [
            _c("use", {
              attrs: { "xlink:href": "/argon/images/svgicons.svg#arrow-left" }
            })
          ])
        ]
      ),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "c-media-library__btn",
          attrs: { "data-balloon": "Forwards" },
          on: { click: _vm.forwards }
        },
        [
          _c("svg", [
            _c("use", {
              attrs: { "xlink:href": "/argon/images/svgicons.svg#arrow-right" }
            })
          ])
        ]
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "c-media-library__button-group" }, [
      _c(
        "button",
        {
          staticClass: "c-media-library__btn",
          class: { "is-active": _vm.layout === "tiles" },
          attrs: { "data-balloon": "Tile View" },
          on: {
            click: function($event) {
              return _vm.setLayout("tiles")
            }
          }
        },
        [
          _c("svg", [
            _c("use", {
              attrs: { "xlink:href": "/argon/images/svgicons.svg#blocks" }
            })
          ])
        ]
      ),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "c-media-library__btn",
          class: { "is-active": _vm.layout === "list" },
          attrs: { "data-balloon": "List View" },
          on: {
            click: function($event) {
              return _vm.setLayout("list")
            }
          }
        },
        [
          _c("svg", [
            _c("use", {
              attrs: { "xlink:href": "/argon/images/svgicons.svg#list" }
            })
          ])
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "c-media-library__search",
          class: { "hide-icon": _vm.keywords.length || _vm.isSearchFocussed }
        },
        [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.keywords,
                expression: "keywords"
              }
            ],
            attrs: { type: "text" },
            domProps: { value: _vm.keywords },
            on: {
              focus: function($event) {
                return _vm.setSearchFocus(true)
              },
              blur: function($event) {
                return _vm.setSearchFocus(false)
              },
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.keywords = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("div", { staticClass: "c-media-library__search-icon" }, [
            _c("svg", [
              _c("use", {
                attrs: { "xlink:href": "/argon/images/svgicons.svg#search" }
              })
            ])
          ])
        ]
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "c-media-library__button-group" }, [
      _c(
        "button",
        {
          staticClass: "o-btn o-btn--sm",
          on: {
            click: function($event) {
              return _vm.createFolder(_vm.active)
            }
          }
        },
        [_vm._v("Add folder")]
      ),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "o-btn o-btn--primary o-btn--sm",
          on: {
            click: function($event) {
              $event.preventDefault()
              return _vm.toggleUpload($event)
            }
          }
        },
        [_vm._v(_vm._s(_vm.uploadIsOpen ? "Close uploads" : "Upload media"))]
      )
    ])
  ])
}
var ActionBarvue_type_template_id_99500dd4_staticRenderFns = []
ActionBarvue_type_template_id_99500dd4_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/ActionBar.vue?vue&type=template&id=99500dd4&

// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/util/bus.js

var bus_EventBus = new vue_default.a();
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/ActionBar.vue?vue&type=script&lang=js&
function ActionBarvue_type_script_lang_js_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function ActionBarvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ActionBarvue_type_script_lang_js_ownKeys(source, true).forEach(function (key) { ActionBarvue_type_script_lang_js_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ActionBarvue_type_script_lang_js_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function ActionBarvue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var ActionBarvue_type_script_lang_js_ = ({
  data: function data() {
    return {
      isSearchFocussed: false
    };
  },
  computed: ActionBarvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])(['layout', 'search', 'active', 'uploadIsOpen']), {
    keywords: {
      set: function set(keywords) {
        if (!keywords.length) {
          this.search.reset();
        } else {
          this.$store.dispatch('search', keywords);
        }
      },
      get: function get() {
        return this.search.keywords;
      }
    }
  }),
  methods: {
    setSearchFocus: function setSearchFocus() {
      var isFocused = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
      this.isSearchFocussed = isFocused;
    },
    setLayout: function setLayout(layout) {
      this.$store.dispatch('setLayout', layout);
    },
    searchReset: function searchReset() {
      this.search.reset();
    },
    searchItems: function searchItems() {
      this.$store.dispatch('search', this.keywords);
    },
    createFolder: function createFolder(parent) {
      bus_EventBus.$emit('addFolder');
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
    toggleUpload: function toggleUpload() {
      this.$store.dispatch('toggleUploads');
    },
    back: function back() {
      history.back();
    },
    forwards: function forwards() {
      history.forward();
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/ActionBar.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_ActionBarvue_type_script_lang_js_ = (ActionBarvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/ActionBar.vue





/* normalize component */

var ActionBar_component = Object(componentNormalizer["default"])(
  components_ActionBarvue_type_script_lang_js_,
  ActionBarvue_type_template_id_99500dd4_render,
  ActionBarvue_type_template_id_99500dd4_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var ActionBar_api; }
ActionBar_component.options.__file = "resources/assets/js/src/components/medialib/components/ActionBar.vue"
/* harmony default export */ var ActionBar = (ActionBar_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/SearchResults.vue?vue&type=template&id=a0f50172&
var SearchResultsvue_type_template_id_a0f50172_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      directives: [{ name: "bar", rawName: "v-bar" }],
      staticClass: "c-media-library__directory-view"
    },
    [
      _c("div", [
        _c("div", { staticClass: "c-media-library__breadcrumbs" }, [
          _c("p", [
            _vm._v(
              "Found " +
                _vm._s(_vm.search.getResultsCount()) +
                " results for `" +
                _vm._s(_vm.search.keywords) +
                "`"
            )
          ])
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "c-media-library__grid-wrap" },
          [
            _vm.search.hasResults()
              ? _c("file-list", { attrs: { items: _vm.search.getResults() } })
              : _c("h3", [_vm._v("No results found.")])
          ],
          1
        )
      ])
    ]
  )
}
var SearchResultsvue_type_template_id_a0f50172_staticRenderFns = []
SearchResultsvue_type_template_id_a0f50172_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/SearchResults.vue?vue&type=template&id=a0f50172&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/FileList.vue?vue&type=template&id=2117e2b1&
var FileListvue_type_template_id_2117e2b1_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { class: "c-file-list c-file-list--" + _vm.layout },
    [
      _vm._l(_vm.folders, function(folderItem) {
        return [
          !folderItem.hide
            ? _c(
                "drop",
                {
                  key: folderItem.id,
                  ref: "folder-" + folderItem.id,
                  refInFor: true,
                  on: {
                    dragover: function($event) {
                      return _vm.dragOver(folderItem)
                    },
                    dragleave: function($event) {
                      return _vm.dragLeave(folderItem)
                    },
                    drop: function($event) {
                      var i = arguments.length,
                        argsArray = Array(i)
                      while (i--) argsArray[i] = arguments[i]
                      return _vm.handleDrop.apply(
                        void 0,
                        [folderItem].concat(argsArray)
                      )
                    },
                    dragend: function($event) {
                      return _vm.dragLeave(folderItem)
                    }
                  }
                },
                [
                  _c(
                    "drag",
                    {
                      attrs: {
                        "effect-allowed": "move",
                        "drop-effect": "move",
                        "transfer-data": {
                          highlighted: _vm.highlighted,
                          folder: folderItem
                        },
                        "image-x-offset": _vm.dragOffset,
                        "image-y-offset": _vm.dragOffset
                      },
                      on: {
                        dragstart: function($event) {
                          return _vm.dragStart(folderItem)
                        },
                        dragend: function($event) {
                          return _vm.dragEnd(folderItem)
                        }
                      }
                    },
                    [
                      _c(
                        "div",
                        {
                          staticClass: "c-file-list__drag-view",
                          attrs: { slot: "image" },
                          slot: "image"
                        },
                        [
                          _c("div", { staticClass: "c-file-list__image" }, [
                            _c("svg", [
                              _c("use", {
                                attrs: {
                                  "xlink:href":
                                    "/argon/images/svgicons.svg#folder"
                                }
                              })
                            ])
                          ])
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass:
                            "c-file-list__item c-file-list__item--folder",
                          class: {
                            "is-highlighted": folderItem.highlight,
                            "is-dragover": folderItem.dragOver
                          }
                        },
                        [
                          _c(
                            "button",
                            {
                              staticClass: "c-file-list__btn",
                              on: {
                                click: function($event) {
                                  return _vm.highlightItem($event, folderItem)
                                },
                                dblclick: function($event) {
                                  return _vm.folderSelected(folderItem)
                                }
                              }
                            },
                            [
                              _c("div", { staticClass: "c-file-list__image" }, [
                                _c("svg", [
                                  _c("use", {
                                    attrs: {
                                      "xlink:href":
                                        "/argon/images/svgicons.svg#folder"
                                    }
                                  })
                                ])
                              ])
                            ]
                          ),
                          _vm._v(" "),
                          !folderItem.editing
                            ? _c(
                                "button",
                                {
                                  staticClass: "c-file-list__edit",
                                  on: {
                                    click: function($event) {
                                      return _vm.highlightItem(
                                        $event,
                                        folderItem
                                      )
                                    },
                                    dblclick: function($event) {
                                      return _vm.editFolder(folderItem)
                                    }
                                  }
                                },
                                [
                                  _c(
                                    "div",
                                    { staticClass: "c-file-list__label" },
                                    [
                                      _c("span", [
                                        _vm._v(_vm._s(folderItem.name))
                                      ])
                                    ]
                                  )
                                ]
                              )
                            : _c(
                                "div",
                                {
                                  staticClass:
                                    "c-file-list__edit c-file-list__edit--editing"
                                },
                                [
                                  _c(
                                    "div",
                                    { staticClass: "c-file-list__label" },
                                    [
                                      _c("input", {
                                        directives: [
                                          {
                                            name: "model",
                                            rawName: "v-model",
                                            value: folderItem.name,
                                            expression: "folderItem.name"
                                          }
                                        ],
                                        ref: "folderEdit-" + folderItem.id,
                                        refInFor: true,
                                        attrs: { type: "text" },
                                        domProps: { value: folderItem.name },
                                        on: {
                                          keydown: [
                                            function($event) {
                                              if (
                                                !$event.type.indexOf("key") &&
                                                _vm._k(
                                                  $event.keyCode,
                                                  "enter",
                                                  13,
                                                  $event.key,
                                                  "Enter"
                                                )
                                              ) {
                                                return null
                                              }
                                              return _vm.comfirmEditFolder(
                                                folderItem
                                              )
                                            },
                                            function($event) {
                                              if (
                                                !$event.type.indexOf("key") &&
                                                _vm._k(
                                                  $event.keyCode,
                                                  "escape",
                                                  undefined,
                                                  $event.key,
                                                  undefined
                                                )
                                              ) {
                                                return null
                                              }
                                              return _vm.closeEditFolder(
                                                folderItem
                                              )
                                            }
                                          ],
                                          input: function($event) {
                                            if ($event.target.composing) {
                                              return
                                            }
                                            _vm.$set(
                                              folderItem,
                                              "name",
                                              $event.target.value
                                            )
                                          }
                                        }
                                      }),
                                      _vm._v(" "),
                                      _c(
                                        "button",
                                        {
                                          staticClass:
                                            "c-file-list__edit-confirm",
                                          on: {
                                            click: function($event) {
                                              return _vm.comfirmEditFolder(
                                                folderItem
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c("svg", [
                                            _c("use", {
                                              attrs: {
                                                "xlink:href":
                                                  "/argon/images/svgicons.svg#tick"
                                              }
                                            })
                                          ])
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "button",
                                        {
                                          staticClass:
                                            "c-file-list__edit-close",
                                          on: {
                                            click: function($event) {
                                              return _vm.closeEditFolder(
                                                folderItem
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c("svg", [
                                            _c("use", {
                                              attrs: {
                                                "xlink:href":
                                                  "/argon/images/svgicons.svg#cross"
                                              }
                                            })
                                          ])
                                        ]
                                      )
                                    ]
                                  )
                                ]
                              ),
                          _vm._v(" "),
                          _vm.layout === "list"
                            ? _c("confirm-btn", {
                                attrs: { hideDuplicate: "true" },
                                on: {
                                  delete: function($event) {
                                    return _vm.deleteFolder(folderItem)
                                  }
                                }
                              })
                            : _vm._e()
                        ],
                        1
                      )
                    ]
                  )
                ],
                1
              )
            : _vm._e()
        ]
      }),
      _vm._v(" "),
      _vm.showAddFolder
        ? _c(
            "div",
            {
              ref: "newFolder",
              staticClass:
                "c-file-list__item c-file-list__item--folder c-file-list__item--empty-folder",
              class: { "is-editing": _vm.editingNewFolder }
            },
            [
              _c(
                "button",
                {
                  staticClass: "c-file-list__btn",
                  on: { click: _vm.newFolder }
                },
                [
                  _c("div", { staticClass: "c-file-list__image" }, [
                    _c("svg", [
                      _c("use", {
                        attrs: {
                          "xlink:href": "/argon/images/svgicons.svg#folder-add"
                        }
                      })
                    ])
                  ])
                ]
              ),
              _vm._v(" "),
              !_vm.editingNewFolder
                ? _c(
                    "button",
                    {
                      staticClass: "c-file-list__edit",
                      on: { click: _vm.newFolder }
                    },
                    [_vm._m(0)]
                  )
                : _c(
                    "div",
                    {
                      staticClass:
                        "c-file-list__edit c-file-list__edit--editing"
                    },
                    [
                      _c("div", { staticClass: "c-file-list__label" }, [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.newFolderName,
                              expression: "newFolderName"
                            }
                          ],
                          ref: "newFolder",
                          attrs: { type: "text" },
                          domProps: { value: _vm.newFolderName },
                          on: {
                            keydown: [
                              function($event) {
                                if (
                                  !$event.type.indexOf("key") &&
                                  _vm._k(
                                    $event.keyCode,
                                    "escape",
                                    undefined,
                                    $event.key,
                                    undefined
                                  )
                                ) {
                                  return null
                                }
                                return _vm.closeNewFolder($event)
                              },
                              function($event) {
                                if (
                                  !$event.type.indexOf("key") &&
                                  _vm._k(
                                    $event.keyCode,
                                    "enter",
                                    13,
                                    $event.key,
                                    "Enter"
                                  )
                                ) {
                                  return null
                                }
                                return _vm.comfirmNewFolder($event)
                              }
                            ],
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.newFolderName = $event.target.value
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "c-file-list__edit-confirm",
                            on: {
                              click: function($event) {
                                return _vm.comfirmNewFolder()
                              }
                            }
                          },
                          [
                            _c("svg", [
                              _c("use", {
                                attrs: {
                                  "xlink:href":
                                    "/argon/images/svgicons.svg#tick"
                                }
                              })
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "c-file-list__edit-close",
                            on: { click: _vm.closeNewFolder }
                          },
                          [
                            _c("svg", [
                              _c("use", {
                                attrs: {
                                  "xlink:href":
                                    "/argon/images/svgicons.svg#cross"
                                }
                              })
                            ])
                          ]
                        )
                      ])
                    ]
                  )
            ]
          )
        : _vm._e(),
      _vm._v(" "),
      _vm._l(_vm.items, function(item) {
        return [
          !item.hide
            ? _c(
                "drag",
                {
                  key: "item-" + item.item.id,
                  ref: "item-" + item.item.id,
                  refInFor: true,
                  attrs: {
                    "effect-allowed": "move",
                    "drop-effect": "move",
                    "transfer-data": {
                      highlighted: _vm.highlighted,
                      item: item
                    },
                    "image-x-offset": _vm.dragOffset,
                    "image-y-offset": _vm.dragOffset
                  },
                  on: {
                    dragstart: function($event) {
                      return _vm.dragStart(item)
                    },
                    dragend: function($event) {
                      return _vm.dragEnd(item)
                    }
                  }
                },
                [
                  _c(
                    "div",
                    {
                      staticClass: "c-file-list__drag-view",
                      attrs: { slot: "image" },
                      slot: "image"
                    },
                    [
                      _c("div", { staticClass: "c-file-list__image" }, [
                        _c("img", {
                          attrs: { src: item.getUrl(), alt: "item.getName()" }
                        })
                      ])
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass: "c-file-list__item",
                      class: {
                        "is-highlighted": item.highlight,
                        "is-dragging": item.dragging
                      }
                    },
                    [
                      _c(
                        "button",
                        {
                          staticClass: "c-file-list__btn",
                          on: {
                            dblclick: function($event) {
                              return _vm.editItem(item)
                            },
                            click: function($event) {
                              return _vm.highlightItem($event, item)
                            }
                          }
                        },
                        [
                          _c("div", { staticClass: "c-file-list__image" }, [
                            _c("div", { staticClass: "c-file-list__image-bg" }),
                            _vm._v(" "),
                            _c("img", {
                              attrs: {
                                src: item.getUrl(),
                                alt: "item.getName()"
                              }
                            })
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "c-file-list__label" }, [
                            _c("span", [_vm._v(_vm._s(item.getName()))])
                          ])
                        ]
                      ),
                      _vm._v(" "),
                      _vm.layout === "list"
                        ? _c("confirm-btn", {
                            attrs: { hideDuplicate: "true" },
                            on: {
                              delete: function($event) {
                                return _vm.deleteItem(item)
                              }
                            }
                          })
                        : _vm._e()
                    ],
                    1
                  )
                ]
              )
            : _vm._e()
        ]
      })
    ],
    2
  )
}
var FileListvue_type_template_id_2117e2b1_staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "c-file-list__label" }, [
      _c("span", [_vm._v("Add new folder")])
    ])
  }
]
FileListvue_type_template_id_2117e2b1_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/FileList.vue?vue&type=template&id=2117e2b1&

// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/util/scrollTo.js

var scrollTo_maxDuration = 600;
var scrollTo_minDuration = 250;
var minHeightForMaxDuration = 2500;
function scrollTo(context, element, cb) {
  var startingY = context.scrollTop;
  var elementY = element.offsetTop;
  var distance = elementY - startingY;
  var duration = cacluateDuration(context.scrollHeight, distance);
  var start;

  function step(timeStamp) {
    if (!start) {
      start = timeStamp;
    }

    var time = timeStamp - start;
    var nextScroll = easeOutQuad(time, startingY, distance, duration);
    context.scrollTo(0, nextScroll);

    if (time < duration) {
      requestAnimationFrame(step);
    } else {
      cb && cb();
    }
  }

  requestAnimationFrame(step);
}

function cacluateDuration(scrollHeight, distance) {
  var maxHeight = scrollHeight > minHeightForMaxDuration ? minHeightForMaxDuration : scrollHeight;
  var alteredMaxDuration = scrollTo_maxDuration * Math.min(scrollHeight / minHeightForMaxDuration, 1);
  distance = Math.abs(distance) > maxHeight ? maxHeight : Math.abs(distance);
  var percent = Math.min(maxHeight / distance, 1);
  return (alteredMaxDuration - scrollTo_minDuration) * percent + scrollTo_minDuration;
}
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/api/media.js

function pickImage(imageId, cb) {
  vue_default.a.http.get('/admin/media/items/' + encodeURIComponent(imageId)).then(function (response) {
    var _response$body = response.body,
        id = _response$body.id,
        url = _response$body.url,
        filename = _response$body.filename,
        _response$body$meta = _response$body.meta,
        width = _response$body$meta.width,
        height = _response$body$meta.height;
    var mediaObj = {
      id: id,
      url: url,
      filename: filename,
      width: width,
      height: height
    };
    cb(mediaObj);
  });
}
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
function media_removeItem(id, cb) {
  vue_default.a.http.post('/admin/media/api/items/remove', {
    id: id
  }).then(function (response) {
    cb(response);
  }).catch(function (e) {
    cb(e);
  });
}
function media_move(data, cb) {
  vue_default.a.http.post('/admin/media/api/move', data).then(function (response) {
    cb(response);
  }).catch(function (e) {
    cb(e);
  });
}
function media_recentUploads(cb) {
  vue_default.a.http.get('/admin/media/api/recent').then(function (response) {
    cb(response);
  }).catch(function (e) {
    cb(e);
  });
}
function media_remove(data, cb) {
  vue_default.a.http.post('/admin/media/api/delete', data).then(function (response) {
    cb(response.body);
  }).catch(function (e) {
    cb(e);
  });
}
function update(_ref) {
  var id = _ref.id,
      file = _ref.file,
      name = _ref.name;
  var formData = new FormData();
  formData.append('file', file);
  formData.append('mediaID', id);
  formData.append('name', name);
  return vue_default.a.http.post('/admin/media/api/update', formData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  }).then(function (response) {
    return response.body;
  });
}
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/FileList.vue?vue&type=script&lang=js&
function FileListvue_type_script_lang_js_toConsumableArray(arr) { return FileListvue_type_script_lang_js_arrayWithoutHoles(arr) || FileListvue_type_script_lang_js_iterableToArray(arr) || FileListvue_type_script_lang_js_nonIterableSpread(); }

function FileListvue_type_script_lang_js_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function FileListvue_type_script_lang_js_iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function FileListvue_type_script_lang_js_arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function FileListvue_type_script_lang_js_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function FileListvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { FileListvue_type_script_lang_js_ownKeys(source, true).forEach(function (key) { FileListvue_type_script_lang_js_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { FileListvue_type_script_lang_js_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function FileListvue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//







/* harmony default export */ var FileListvue_type_script_lang_js_ = ({
  data: function data() {
    return {
      key: "",
      lastHighlightIndex: false,
      editingNewFolder: false,
      newFolderName: ''
    };
  },
  props: {
    items: {
      type: Array,
      default: function _default() {
        return [];
      }
    },
    folders: {
      type: Array,
      default: function _default() {
        return [];
      }
    },
    showAddFolder: {
      type: Boolean,
      default: function _default() {
        return true;
      }
    }
  },
  computed: FileListvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])(['layout', 'data', 'search', 'layout', 'active', 'folder', 'newUploadIds']), {
    dragOffset: function dragOffset() {
      return 'list' ? 15 : undefined;
    },
    combinedItems: function combinedItems() {
      return [].concat(FileListvue_type_script_lang_js_toConsumableArray(this.folders), FileListvue_type_script_lang_js_toConsumableArray(this.items)).map(function (item, index) {
        item.index = index;
        return item;
      });
    },
    highlighted: function highlighted() {
      return {
        items: this.items.filter(function (el) {
          return el.highlight;
        }),
        folders: this.folders.filter(function (el) {
          return el.highlight;
        })
      };
    }
  }),
  components: {
    Drag: vue_drag_drop_common["Drag"],
    Drop: vue_drag_drop_common["Drop"]
  },
  created: function created() {
    Object(_esm5["fromEvent"])(document, 'click').pipe(Object(operators["filter"])(function (evt) {
      var contains = evt.target.classList.contains('c-file-list__btn') || evt.target.classList.contains('c-file-list__edit');
      return !contains;
    })).subscribe(this.unhighlightItems.bind(this));
    bus_EventBus.$on('addFolder', this.newFolder.bind(this));
  },
  watch: {
    items: function items() {
      this.$nextTick(function () {
        var _this = this;

        if (this.newUploadIds.length) {
          var element = this.$refs["item-".concat(this.newUploadIds[0])];

          if (element.length) {
            element = element && element[0] && element[0].$el;
            var container = element.closest('.vb-content');
            scrollTo(container, element, function () {
              _this.$store.dispatch('clearNewUploadIDs');
            });
          }
        }
      });
    }
  },
  methods: {
    folderSelected: function folderSelected(folder) {
      this.$store.dispatch('folderSelected', {
        folder: folder
      });
    },
    editItem: function editItem(item) {
      var _this2 = this;

      if (this.$store.state.isPicker) {
        pickImage(item.item.id, function (mediaObj) {
          _this2.$root.$emit('pick', mediaObj);
        });
      } else {
        this.$store.dispatch('editItem', item);
      }
    },
    highlightItem: function highlightItem(evt, item) {
      var _this3 = this;

      if (!evt.ctrlKey && !evt.shiftKey) {
        this.unhighlightItems();
      }

      item.highlight = true;

      if (evt.shiftKey && ~this.lastHighlightIndex) {
        var currentIndex = item.index;
        this.combinedItems.forEach(function (item, index) {
          item.highlight = index >= _this3.lastHighlightIndex && index <= currentIndex;
        });
      }

      this.lastHighlightIndex = item.index;
    },
    unhighlightItems: function unhighlightItems() {
      this.combinedItems.forEach(function (item) {
        return item.highlight = false;
      });
    },
    dragStart: function dragStart(item) {
      item.dragging = true;
      item.highlight = true;
    },
    dragEnd: function dragEnd(item) {
      item.dragging = false;
      item.highlight = false;
    },
    dragOver: function dragOver(folderItem) {
      folderItem.dragOver = true;
    },
    dragLeave: function dragLeave(folderItem) {
      folderItem.dragOver = false;
    },
    handleDrop: function handleDrop(destinationFolder, _ref) {
      var _ref$highlighted = _ref.highlighted,
          items = _ref$highlighted.items,
          folders = _ref$highlighted.folders,
          item = _ref.item,
          folder = _ref.folder;
      destinationFolder.dragOver = false;

      if (!items.length && item) {
        items = [item];
      }

      if (!folders.length && folder) {
        folders = [folder];
      }

      folders = folders.filter(function (folder) {
        return folder.id !== destinationFolder.id;
      });
      this.$store.dispatch('move', {
        destinationFolder: destinationFolder,
        items: items,
        folders: folders
      });
    },
    deleteFolder: function deleteFolder(folder) {
      this.$store.dispatch('removeFolder', folder);
    },
    deleteItem: function deleteItem(item) {
      this.$store.dispatch('removeItem', item);
    },
    editFolder: function editFolder(folder) {
      folder.editing = true;
      folder.originalName = folder.name;
      this.$nextTick(function () {
        var element = this.$refs["folderEdit-".concat(folder.id)];
        element = this.$refs["folderEdit-".concat(folder.id)] && this.$refs["folderEdit-".concat(folder.id)][0];

        if (element) {
          element.focus();
        }
      });
    },
    comfirmEditFolder: function comfirmEditFolder(folder) {
      folder.editing = false;
      this.$store.dispatch('editFolder', folder);
    },
    closeEditFolder: function closeEditFolder(folder) {
      folder.editing = false;
    },
    newFolder: function newFolder() {
      this.editingNewFolder = true;
      this.$nextTick(function () {
        var element = this.$refs['newFolder'];

        if (!element) {
          return;
        }

        var container = element.closest('.vb-content');
        scrollTo(container, element, function () {
          element.focus();
        });
      });
    },
    comfirmNewFolder: function comfirmNewFolder() {
      this.editingNewFolder = false;
      this.$store.dispatch('createFolder', {
        name: this.newFolderName,
        parent: this.active
      });
      this.newFolderName = '';
    },
    closeNewFolder: function closeNewFolder() {
      this.editingNewFolder = false;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/FileList.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_FileListvue_type_script_lang_js_ = (FileListvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/FileList.vue





/* normalize component */

var FileList_component = Object(componentNormalizer["default"])(
  components_FileListvue_type_script_lang_js_,
  FileListvue_type_template_id_2117e2b1_render,
  FileListvue_type_template_id_2117e2b1_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var FileList_api; }
FileList_component.options.__file = "resources/assets/js/src/components/medialib/components/FileList.vue"
/* harmony default export */ var FileList = (FileList_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/SearchResults.vue?vue&type=script&lang=js&
function SearchResultsvue_type_script_lang_js_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function SearchResultsvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { SearchResultsvue_type_script_lang_js_ownKeys(source, true).forEach(function (key) { SearchResultsvue_type_script_lang_js_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { SearchResultsvue_type_script_lang_js_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function SearchResultsvue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var SearchResultsvue_type_script_lang_js_ = ({
  computed: SearchResultsvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])(['search'])),
  components: {
    FileList: FileList
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/SearchResults.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_SearchResultsvue_type_script_lang_js_ = (SearchResultsvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/SearchResults.vue





/* normalize component */

var SearchResults_component = Object(componentNormalizer["default"])(
  components_SearchResultsvue_type_script_lang_js_,
  SearchResultsvue_type_template_id_a0f50172_render,
  SearchResultsvue_type_template_id_a0f50172_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var SearchResults_api; }
SearchResults_component.options.__file = "resources/assets/js/src/components/medialib/components/SearchResults.vue"
/* harmony default export */ var SearchResults = (SearchResults_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/DirectoryView.vue?vue&type=template&id=6b3caa6a&
var DirectoryViewvue_type_template_id_6b3caa6a_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      directives: [{ name: "bar", rawName: "v-bar" }],
      staticClass: "c-media-library__directory-view"
    },
    [
      _c("div", [
        _vm.active.isSet()
          ? _c(
              "div",
              { staticClass: "c-media-library__breadcrumbs" },
              _vm._l(_vm.active.breadcrumbs(), function(folder) {
                return _c(
                  "drop",
                  {
                    key: folder.id,
                    on: {
                      dragover: function($event) {
                        return _vm.crumbDragOver(folder)
                      },
                      dragleave: function($event) {
                        return _vm.crumbDragLeave(folder)
                      },
                      drop: function($event) {
                        var i = arguments.length,
                          argsArray = Array(i)
                        while (i--) argsArray[i] = arguments[i]
                        return _vm.crumbHandleDrop.apply(
                          void 0,
                          [folder].concat(argsArray)
                        )
                      },
                      dragend: function($event) {
                        return _vm.crumbDragLeave(folder)
                      }
                    }
                  },
                  [
                    _c(
                      "button",
                      {
                        class: { "drag-over": folder.dragOver },
                        on: {
                          click: function($event) {
                            return _vm.folderSelected(folder)
                          }
                        }
                      },
                      [
                        _vm._v(
                          "\n                    " +
                            _vm._s(folder.name) +
                            "\n                "
                        )
                      ]
                    )
                  ]
                )
              }),
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _c("div", { staticClass: "c-media-library__info" }, [
          _c(
            "div",
            {
              staticClass: "o-info",
              attrs: {
                "data-balloon-length": "large",
                "data-balloon":
                  "ctrl click or shift to select multiple items. double click on folder names to edit them.",
                "data-balloon-pos": "left"
              }
            },
            [
              _c("svg", [
                _c("use", {
                  attrs: { "xlink:href": "/argon/images/svgicons.svg#info" }
                })
              ])
            ]
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "c-media-library__grid-wrap" },
          [
            _c("file-list", {
              ref: "fileList",
              attrs: { items: _vm.active.items, folders: _vm.active.children }
            }),
            _vm._v(" "),
            _c(
              "drop",
              {
                on: {
                  dragover: _vm.dragOver,
                  dragleave: _vm.dragLeave,
                  drop: function($event) {
                    return _vm.handleDrop.apply(void 0, arguments)
                  },
                  dragend: _vm.dragLeave
                }
              },
              [
                _c(
                  "div",
                  {
                    staticClass: "c-media-library__delete-container",
                    attrs: {
                      "data-balloon-pos": "left",
                      "data-balloon": "To delete items, drag them over"
                    }
                  },
                  [
                    _c(
                      "div",
                      {
                        staticClass: "c-media-library__delete",
                        class: { "is-dragged-over": _vm.deleteHover }
                      },
                      [
                        _c("svg", [
                          _c("use", {
                            attrs: {
                              "xlink:href": "/argon/images/svgicons.svg#delete"
                            }
                          })
                        ])
                      ]
                    )
                  ]
                )
              ]
            )
          ],
          1
        )
      ])
    ]
  )
}
var DirectoryViewvue_type_template_id_6b3caa6a_staticRenderFns = []
DirectoryViewvue_type_template_id_6b3caa6a_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/DirectoryView.vue?vue&type=template&id=6b3caa6a&

// EXTERNAL MODULE: ./node_modules/timers-browserify/main.js
var main = __webpack_require__("./node_modules/timers-browserify/main.js");

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/DirectoryView.vue?vue&type=script&lang=js&
function DirectoryViewvue_type_script_lang_js_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function DirectoryViewvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { DirectoryViewvue_type_script_lang_js_ownKeys(source, true).forEach(function (key) { DirectoryViewvue_type_script_lang_js_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { DirectoryViewvue_type_script_lang_js_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function DirectoryViewvue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ var DirectoryViewvue_type_script_lang_js_ = ({
  data: function data() {
    return {
      deleteHover: false
    };
  },
  components: {
    FileList: FileList
  },
  computed: DirectoryViewvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])(['active', 'back'])),
  methods: {
    folderSelected: function folderSelected(folder) {
      this.$store.dispatch('folderSelected', {
        folder: folder
      });
    },
    dragOver: function dragOver() {
      this.deleteHover = true;
    },
    dragLeave: function dragLeave() {
      this.deleteHover = false;
    },
    handleDrop: function handleDrop(_ref) {
      var _ref$highlighted = _ref.highlighted,
          items = _ref$highlighted.items,
          folders = _ref$highlighted.folders,
          item = _ref.item,
          folder = _ref.folder;
      this.deleteHover = false;

      if (!items.length && item) {
        items = [item];
      }

      if (!folders.length && folder) {
        folders = [folder];
      }

      this.$store.dispatch('remove', {
        items: items,
        folders: folders
      });
      this.$refs.fileList.unhighlightItems();
    },
    crumbDragOver: function crumbDragOver(folderItem) {
      folderItem.dragOver = true;
    },
    crumbDragLeave: function crumbDragLeave(folderItem) {
      folderItem.dragOver = false;
    },
    crumbHandleDrop: function crumbHandleDrop(destinationFolder, _ref2) {
      var _ref2$highlighted = _ref2.highlighted,
          items = _ref2$highlighted.items,
          folders = _ref2$highlighted.folders,
          item = _ref2.item,
          folder = _ref2.folder;
      destinationFolder.dragOver = false;

      if (!items.length && item) {
        items = [item];
      }

      if (!folders.length && folder) {
        folders = [folder];
      }

      folders = folders.filter(function (folder) {
        return folder.id !== destinationFolder.id;
      });
      this.$store.dispatch('move', {
        destinationFolder: destinationFolder,
        items: items,
        folders: folders
      });
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/DirectoryView.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_DirectoryViewvue_type_script_lang_js_ = (DirectoryViewvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/DirectoryView.vue





/* normalize component */

var DirectoryView_component = Object(componentNormalizer["default"])(
  components_DirectoryViewvue_type_script_lang_js_,
  DirectoryViewvue_type_template_id_6b3caa6a_render,
  DirectoryViewvue_type_template_id_6b3caa6a_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var DirectoryView_api; }
DirectoryView_component.options.__file = "resources/assets/js/src/components/medialib/components/DirectoryView.vue"
/* harmony default export */ var DirectoryView = (DirectoryView_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/Edit.vue?vue&type=template&id=640e3401&
var Editvue_type_template_id_640e3401_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("dialog", { staticClass: "c-edit" }, [
    _c("header", { staticClass: "c-edit__header" }, [
      _c("h3", { staticClass: "c-edit__title" }, [
        _vm._v("Image Details "),
        _vm.isEditing ? _c("span", [_vm._v("- To be saved")]) : _vm._e()
      ])
    ]),
    _vm._v(" "),
    _c("main", { staticClass: "c-edit__body" }, [
      _c("div", { staticClass: "c-edit__preview" }, [
        _c("div", { staticClass: "c-edit__image" }, [
          _c("img", { attrs: { src: _vm.url, alt: _vm.name } })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "c-edit__replace-image" }, [
          _c("input", {
            ref: "editImageInput",
            attrs: { type: "file", hidden: "", id: "editImage" },
            on: { change: _vm.chooseNewImage }
          }),
          _vm._v(" "),
          _c("span", [_vm._v("Overwrite existing asset?")]),
          _vm._v(" "),
          _c(
            "label",
            { staticClass: "o-btn o-btn--xs", attrs: { for: "editImage" } },
            [_vm._v("choose file")]
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "c-edit__details" }, [
        _c("div", { staticClass: "o-form" }, [
          _c("div", { staticClass: "o-form__group" }, [
            _c("label", { attrs: { for: "name" } }, [_vm._v("File name")]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.name,
                  expression: "name"
                }
              ],
              attrs: { type: "text", id: "name" },
              domProps: { value: _vm.name },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.name = $event.target.value
                }
              }
            })
          ])
        ]),
        _vm._v(" "),
        _c("dl", [
          _c("dt", [_vm._v("File type:")]),
          _vm._v(" "),
          _c("dd", [
            _c("a", { attrs: { href: _vm.cleanUrl, target: "_blank" } }, [
              _vm._v(_vm._s(_vm.cleanUrl))
            ])
          ]),
          _vm._v(" "),
          _c("dt", [_vm._v("File type:")]),
          _vm._v(" "),
          _c("dd", [_vm._v(_vm._s(_vm.extension))]),
          _vm._v(" "),
          _c("dt", [_vm._v("Uploaded at:")]),
          _vm._v(" "),
          _c("dd", [_vm._v(_vm._s(_vm.uploadedDate))]),
          _vm._v(" "),
          _c("dt", [_vm._v("Dimensions:")]),
          _vm._v(" "),
          _c("dd", [_vm._v(_vm._s(_vm.dimensions))]),
          _vm._v(" "),
          _c("dt", [_vm._v("File Size:")]),
          _vm._v(" "),
          _c("dd", [_vm._v(_vm._s(_vm.fileSize))]),
          _vm._v(" "),
          _c("dt", [_vm._v("Uploaded by:")]),
          _vm._v(" "),
          !_vm.isEditing
            ? _c("dd", [
                _c("div", { staticClass: "c-edit__author" }, [
                  _vm.authorImage
                    ? _c("div", {
                        staticClass: "c-edit__author-img",
                        style: {
                          "background-image": "url(" + _vm.authorImage + ")"
                        }
                      })
                    : _vm._e(),
                  _vm._v(" "),
                  _c("span", [_vm._v(_vm._s(_vm.authorName))])
                ])
              ])
            : _vm._e()
        ])
      ])
    ]),
    _vm._v(" "),
    _c("footer", { staticClass: "c-edit__footer" }, [
      _c(
        "button",
        { staticClass: "o-btn o-btn--sm", on: { click: _vm.closeEdit } },
        [_vm._v("cancel")]
      ),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "o-btn o-btn--sm o-btn--primary",
          on: { click: _vm.updateMediaItem }
        },
        [_vm._v("save")]
      )
    ])
  ])
}
var Editvue_type_template_id_640e3401_staticRenderFns = []
Editvue_type_template_id_640e3401_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/Edit.vue?vue&type=template&id=640e3401&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/Edit.vue?vue&type=script&lang=js&
function Editvue_type_script_lang_js_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function Editvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { Editvue_type_script_lang_js_ownKeys(source, true).forEach(function (key) { Editvue_type_script_lang_js_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { Editvue_type_script_lang_js_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function Editvue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var Editvue_type_script_lang_js_ = ({
  computed: Editvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])(['editItem'])),
  data: function data() {
    return {
      isEditing: false,
      name: '',
      url: '',
      extension: '',
      uploadedDate: '',
      dimensions: '',
      fileSize: '',
      authorName: '',
      authorImage: '',
      cleanUrl: ''
    };
  },
  mounted: function mounted() {
    this.resetCurrentItem();
  },
  methods: {
    resetCurrentItem: function resetCurrentItem() {
      var _this$editItem$item = this.editItem.item,
          extension = _this$editItem$item.extension,
          uploadedDate = _this$editItem$item.uploadedDate,
          filesize_formatted = _this$editItem$item.filesize_formatted,
          authorName = _this$editItem$item.authorName,
          authorImage = _this$editItem$item.authorImage;
      this.name = this.editItem.getName();
      this.url = this.editItem.getUrl();
      this.extension = extension;
      this.uploadedDate = uploadedDate;
      this.dimensions = this.editItem.getDimensions();
      this.fileSize = filesize_formatted;
      this.authorName = authorName;
      this.authorImage = authorImage;
      this.cleanUrl = this.editItem.getCleanUrl();
    },
    chooseNewImage: function chooseNewImage() {
      var _this = this;

      if (!this.$refs.editImageInput.files.length) {
        return;
      }

      var file = this.$refs.editImageInput.files[0];

      if (!file.type.match('image.*')) {
        return;
      }

      var reader = new FileReader();

      reader.onload = function (readerEvt) {
        var image = new Image();
        image.src = readerEvt.target.result;

        image.onload = function (imgEvt) {
          _this.isEditing = true;
          _this.url = readerEvt.target.result;
          _this.name = file.name;
          _this.extension = file.name.split('.')[1];
          _this.uploadedDate = 'To be saved';
          _this.dimensions = "".concat(imgEvt.target.width, " x ").concat(imgEvt.target.height, "px");
          _this.fileSize = fileSize(file.size);
        };
      };

      reader.readAsDataURL(file);
    },
    closeEdit: function closeEdit() {
      this.$store.dispatch('editItem');
    },
    updateMediaItem: function updateMediaItem() {
      var data = {
        item: this.editItem,
        file: this.$refs.editImageInput.files[0],
        name: this.name.replace('.' + this.extension, '')
      };
      this.$store.dispatch('updateMediaItem', data);
      this.$refs.editImageInput.value = '';
      this.closeEdit();
    }
  }
});

function fileSize(bytes) {
  var exp = Math.log(bytes) / Math.log(1024) | 0;
  var result = (bytes / Math.pow(1024, exp)).toFixed(2);
  return result + ' ' + (exp == 0 ? 'bytes' : 'KMGTPEZY'[exp - 1] + 'B');
}
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/Edit.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Editvue_type_script_lang_js_ = (Editvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/Edit.vue





/* normalize component */

var Edit_component = Object(componentNormalizer["default"])(
  components_Editvue_type_script_lang_js_,
  Editvue_type_template_id_640e3401_render,
  Editvue_type_template_id_640e3401_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Edit_api; }
Edit_component.options.__file = "resources/assets/js/src/components/medialib/components/Edit.vue"
/* harmony default export */ var Edit = (Edit_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/Upload.vue?vue&type=template&id=562b64b8&
var Uploadvue_type_template_id_562b64b8_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "c-media-library__upload" }, [
    _c("div", { ref: "uppy", staticClass: "c-media-library__upload-container" })
  ])
}
var Uploadvue_type_template_id_562b64b8_staticRenderFns = []
Uploadvue_type_template_id_562b64b8_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/Upload.vue?vue&type=template&id=562b64b8&

// EXTERNAL MODULE: ./node_modules/uppy/index.mjs
var node_modules_uppy = __webpack_require__("./node_modules/uppy/index.mjs");

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/Upload.vue?vue&type=script&lang=js&
function Uploadvue_type_script_lang_js_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function Uploadvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { Uploadvue_type_script_lang_js_ownKeys(source, true).forEach(function (key) { Uploadvue_type_script_lang_js_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { Uploadvue_type_script_lang_js_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function Uploadvue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//


/* harmony default export */ var Uploadvue_type_script_lang_js_ = ({
  data: function data() {
    return {
      uppyInstance: null
    };
  },
  computed: Uploadvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])(['active'])),
  mounted: function mounted() {
    var metaToken = document.head.querySelector('meta[name="csrf-token"]');
    metaToken = metaToken && metaToken.content;
    this.uppyInstance = Object(node_modules_uppy["Core"])().use(node_modules_uppy["Dashboard"], {
      target: this.$refs.uppy,
      inline: true,
      width: '100%',
      height: '100%'
    }).use(node_modules_uppy["XHRUpload"], {
      endpoint: '/admin/media/api/upload',
      headers: {
        'X-CSRF-TOKEN': metaToken
      },
      metaFields: ['folder']
    });
    this.uppyInstance.on('file-added', this.addFolderToFile.bind(this));
    this.uppyInstance.on('complete', this.successfulUpload.bind(this));
  },
  destroyed: function destroyed() {
    this.uppyInstance.off('file-added', this.addFolderToFile.bind(this));
    this.uppyInstance.off('complete', this.successfulUpload.bind(this));
  },
  methods: {
    successfulUpload: function successfulUpload(evt) {
      this.$store.dispatch('uploadResult', evt);
    },
    addFolderToFile: function addFolderToFile(file) {
      this.uppyInstance.setFileMeta(file.id, {
        folder: this.active.id
      });
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/Upload.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Uploadvue_type_script_lang_js_ = (Uploadvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/Upload.vue





/* normalize component */

var Upload_component = Object(componentNormalizer["default"])(
  components_Uploadvue_type_script_lang_js_,
  Uploadvue_type_template_id_562b64b8_render,
  Uploadvue_type_template_id_562b64b8_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Upload_api; }
Upload_component.options.__file = "resources/assets/js/src/components/medialib/components/Upload.vue"
/* harmony default export */ var Upload = (Upload_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/RecentUploads.vue?vue&type=template&id=d47bed60&
var RecentUploadsvue_type_template_id_d47bed60_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      directives: [{ name: "bar", rawName: "v-bar" }],
      staticClass: "c-media-library__directory-view"
    },
    [
      _c("div", [
        _vm._m(0),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "c-media-library__grid-wrap" },
          [
            _vm.recentUploads.items.length
              ? _c("file-list", {
                  attrs: {
                    items: _vm.recentUploads.items,
                    "show-add-folder": false
                  }
                })
              : _c("h3", [_vm._v("No content")])
          ],
          1
        )
      ])
    ]
  )
}
var RecentUploadsvue_type_template_id_d47bed60_staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "c-media-library__breadcrumbs" }, [
      _c("p", [_vm._v("Recent Uploads")])
    ])
  }
]
RecentUploadsvue_type_template_id_d47bed60_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/RecentUploads.vue?vue&type=template&id=d47bed60&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/RecentUploads.vue?vue&type=script&lang=js&
function RecentUploadsvue_type_script_lang_js_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function RecentUploadsvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { RecentUploadsvue_type_script_lang_js_ownKeys(source, true).forEach(function (key) { RecentUploadsvue_type_script_lang_js_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { RecentUploadsvue_type_script_lang_js_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function RecentUploadsvue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var RecentUploadsvue_type_script_lang_js_ = ({
  components: {
    FileList: FileList
  },
  computed: RecentUploadsvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])(['recentUploads']))
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/RecentUploads.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_RecentUploadsvue_type_script_lang_js_ = (RecentUploadsvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/RecentUploads.vue





/* normalize component */

var RecentUploads_component = Object(componentNormalizer["default"])(
  components_RecentUploadsvue_type_script_lang_js_,
  RecentUploadsvue_type_template_id_d47bed60_render,
  RecentUploadsvue_type_template_id_d47bed60_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var RecentUploads_api; }
RecentUploads_component.options.__file = "resources/assets/js/src/components/medialib/components/RecentUploads.vue"
/* harmony default export */ var RecentUploads = (RecentUploads_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/components/MediaLibrary.vue?vue&type=script&lang=js&
function MediaLibraryvue_type_script_lang_js_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function MediaLibraryvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { MediaLibraryvue_type_script_lang_js_ownKeys(source, true).forEach(function (key) { MediaLibraryvue_type_script_lang_js_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { MediaLibraryvue_type_script_lang_js_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function MediaLibraryvue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//








/* harmony default export */ var MediaLibraryvue_type_script_lang_js_ = ({
  computed: MediaLibraryvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])(['search', 'editItem', 'uploadIsOpen', 'recentUploads'])),
  components: {
    Tree: Tree,
    ActionBar: ActionBar,
    SearchResults: SearchResults,
    DirectoryView: DirectoryView,
    Edit: Edit,
    Upload: Upload,
    RecentUploads: RecentUploads
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/MediaLibrary.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_MediaLibraryvue_type_script_lang_js_ = (MediaLibraryvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/components/MediaLibrary.vue





/* normalize component */

var MediaLibrary_component = Object(componentNormalizer["default"])(
  components_MediaLibraryvue_type_script_lang_js_,
  MediaLibraryvue_type_template_id_a08506a4_render,
  MediaLibraryvue_type_template_id_a08506a4_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var MediaLibrary_api; }
MediaLibrary_component.options.__file = "resources/assets/js/src/components/medialib/components/MediaLibrary.vue"
/* harmony default export */ var MediaLibrary = (MediaLibrary_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/medialib/App.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var medialib_Appvue_type_script_lang_js_ = ({
  created: function created() {
    var _this = this;

    var folderUrlRegex = /[?&]folderID(=([^&#]*)|&|#|$)/;
    var folderID = folderUrlRegex.exec(window.location.search);
    folderID = folderID && folderID[2] || 1;
    this.$store.dispatch('loadLibrary', folderID);
    window.addEventListener('popstate', function (evt) {
      if (evt.state && evt.state.folderID) {
        _this.$store.dispatch('folderSelectByID', evt.state.folderID);
      }
    });
    window.addEventListener('keydown', function (evt) {
      if (evt.key === "Escape") {
        _this.closePicker();
      }
    });
    this.$store.state.isPicker = this.$root.$data.isPicker;
    this.$root.$on('open', function () {
      _this.isOpen = true;
    });
    this.$root.$on('pick', function () {
      _this.isOpen = false;
    });
  },
  data: function data() {
    return {
      isOpen: false
    };
  },
  computed: {
    isPicker: function isPicker() {
      return this.$store.state.isPicker;
    },
    showMediaLib: function showMediaLib() {
      if (!this.isPicker) {
        return true;
      }

      return this.isPicker && this.isOpen;
    }
  },
  components: {
    MediaLibrary: MediaLibrary
  },
  methods: {
    closePicker: function closePicker() {
      this.isOpen = false;
      this.$root.$emit('pick', null);
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/App.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_medialib_Appvue_type_script_lang_js_ = (medialib_Appvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/App.vue





/* normalize component */

var App_component = Object(componentNormalizer["default"])(
  components_medialib_Appvue_type_script_lang_js_,
  Appvue_type_template_id_639a027f_render,
  Appvue_type_template_id_639a027f_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var App_api; }
App_component.options.__file = "resources/assets/js/src/components/medialib/App.vue"
/* harmony default export */ var medialib_App = (App_component.exports);
// EXTERNAL MODULE: ./node_modules/vue-resource/dist/vue-resource.esm.js
var vue_resource_esm = __webpack_require__("./node_modules/vue-resource/dist/vue-resource.esm.js");

// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/store/folder.js
function folder_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function folder_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { folder_ownKeys(source, true).forEach(function (key) { folder_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { folder_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function folder_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }


var Folder =
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
    this.setItems(items);
    this.setChildren(children);
    this.parent = parent;
    this.active = active;
    this.highlight = false;
    this.treeActive = false;
    this.treeDragOver = false;
    this.dragOver = false;
    this.hide = false;
    this.editing = false;
    this.originalName = name;

    if (id === 1) {
      this.treeActive = true;
    }
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
      this.sortChildFolders();
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
                if (!c.items) {
                  child.items = [];
                  break;
                }

                child.items = c.items.reduce(function (a, v) {
                  a.push(new folder_Item(v));
                  return a;
                }, []);
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
    key: "sortChildFolders",
    value: function sortChildFolders() {
      var compareFnc;

      if (window.Intl && window.Intl.Collator) {
        compareFnc = new Intl.Collator(undefined, {
          numeric: true,
          sensitivity: 'base'
        });
      }

      this.children.sort(function (a, b) {
        if (compareFnc) {
          return compareFnc.compare(a.name, b.name);
        }

        if (a.name === b.name) {
          return 0;
        }

        return a.name > b.name ? 1 : -1;
      });
    }
  }, {
    key: "addNewFolder",
    value: function addNewFolder(folder) {
      this.children.push(folder);
      this.sortChildFolders();
    }
  }, {
    key: "setItems",
    value: function setItems(items) {
      this.items = items.reduce(function (a, v) {
        a.push(new folder_Item(v));
        return a;
      }, []);
      var compareFnc;

      if (window.Intl && window.Intl.Collator) {
        compareFnc = new Intl.Collator(undefined, {
          numeric: true,
          sensitivity: 'base'
        });
      }

      this.items.sort(function (a, b) {
        if (compareFnc) {
          return compareFnc.compare(a.item.filename, b.item.filename);
        }

        if (a.item.filename === b.item.filename) {
          return 0;
        }

        return a.item.filename > b.item.filename ? 1 : -1;
      });
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
}();
function children(folders) {
  var parent = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
  var folderMap = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
  var newFolders = folders.reduce(function (a, folder) {
    if (parent === folder.parent) {
      var childFolders = children(folders, folder.id, folderMap);
      folderMap = folder_objectSpread({}, folderMap, {}, childFolders.folderMap);
      var newFolder = new Folder(folder.id, folder.name, folder.items, childFolders.newItems, folder.parent);
      folderMap[newFolder.id] = newFolder;
      a.push(newFolder);
    }

    return a;
  }, []);
  return {
    newFolders: newFolders,
    folderMap: folderMap
  };
}
function parents(folder) {
  var id = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

  if (id === null) {
    return null;
  }

  if (folder.id === id) {
    return folder;
  }

  var _iteratorNormalCompletion4 = true;
  var _didIteratorError4 = false;
  var _iteratorError4 = undefined;

  try {
    for (var _iterator4 = folder.children[Symbol.iterator](), _step4; !(_iteratorNormalCompletion4 = (_step4 = _iterator4.next()).done); _iteratorNormalCompletion4 = true) {
      var child = _step4.value;

      if (child.id === id) {
        return child;
      }

      var f = parents(child, id);

      if (f) {
        return f;
      }
    }
  } catch (err) {
    _didIteratorError4 = true;
    _iteratorError4 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion4 && _iterator4.return != null) {
        _iterator4.return();
      }
    } finally {
      if (_didIteratorError4) {
        throw _iteratorError4;
      }
    }
  }
}
var folder_Item =
/*#__PURE__*/
function () {
  function Item(item) {
    _classCallCheck(this, Item);

    this.highlight = false;
    this.dragging = false;
    this.hide = false;
    this.item = item;
    this.cacheBuster = Math.random() // to cache bust images on reload
    .toString(36).substr(2, 9);

    if (item) {
      var date = moment_default()(this.item.updated_at);
      this.item.uploadedDate = "".concat(date.format('DD MMM YYYY'), " at ").concat(date.format('HH:mm:ss'));
    }
  }

  _createClass(Item, [{
    key: "updateCacheBuster",
    value: function updateCacheBuster() {
      this.cacheBuster = Math.random() // to cache bust images on reload
      .toString(36).substr(2, 9);
    }
  }, {
    key: "getName",
    value: function getName() {
      return "".concat(this.item.filename, ".").concat(this.item.extension);
    }
  }, {
    key: "getUrl",
    value: function getUrl() {
      return "/media/".concat(this.item.id, "/").concat(this.item.slug, ".").concat(this.item.extension, "?").concat(this.cacheBuster);
    }
  }, {
    key: "getCleanUrl",
    value: function getCleanUrl() {
      return "/media/".concat(this.item.id, "/").concat(this.item.slug, ".").concat(this.item.extension);
    }
  }, {
    key: "getWidth",
    value: function getWidth() {
      var suffix = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
      return JSON.parse(this.item.meta).width + suffix;
    }
  }, {
    key: "getHeight",
    value: function getHeight() {
      var suffix = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
      return JSON.parse(this.item.meta).height + suffix;
    }
  }, {
    key: "getDimensions",
    value: function getDimensions() {
      var suffix = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
      return "".concat(this.getWidth(suffix), " x ").concat(this.getHeight(suffix), "px");
    }
  }, {
    key: "isSet",
    value: function isSet() {
      if (this.item) {
        return true;
      }

      return false;
    }
  }, {
    key: "getBreadcrumbs",
    value: function getBreadcrumbs(folderData) {
      var f = parents(folderData, this.item.folder);
      return f.breadcrumbs();
    }
  }, {
    key: "getFormattedBreadcrumbs",
    value: function getFormattedBreadcrumbs(folderData) {
      var glue = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : ' > ';
      var breadcrumbs = this.getBreadcrumbs(folderData);
      var trail = breadcrumbs.reduce(function (a, folder) {
        a.push(folder.name);
        return a;
      }, []);
      return trail.join(glue);
    }
  }]);

  return Item;
}();
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/store/search.js
function search_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function search_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function search_createClass(Constructor, protoProps, staticProps) { if (protoProps) search_defineProperties(Constructor.prototype, protoProps); if (staticProps) search_defineProperties(Constructor, staticProps); return Constructor; }


var search_Search =
/*#__PURE__*/
function () {
  function Search() {
    var keywords = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
    var results = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];

    search_classCallCheck(this, Search);

    this.keywords = keywords;
    this.setResults(results);
    this.loading = false;
  }

  search_createClass(Search, [{
    key: "hasResults",
    value: function hasResults() {
      return this.results.length !== 0;
    }
  }, {
    key: "getResults",
    value: function getResults() {
      return this.results;
    }
  }, {
    key: "setResults",
    value: function setResults(results) {
      this.results = results.reduce(function (a, v) {
        a.push(new folder_Item(v));
        return a;
      }, []);
    }
  }, {
    key: "getResultsCount",
    value: function getResultsCount() {
      return this.results.length;
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
      this.results = [];
      this.keywords = '';
    }
  }]);

  return Search;
}();
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/store/upload.js
function upload_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function upload_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function upload_createClass(Constructor, protoProps, staticProps) { if (protoProps) upload_defineProperties(Constructor.prototype, protoProps); if (staticProps) upload_defineProperties(Constructor, staticProps); return Constructor; }

var upload_Upload =
/*#__PURE__*/
function () {
  function Upload() {
    upload_classCallCheck(this, Upload);

    this.files = []; // needs length attribute just as FileList for seamless operations

    this.initialised = false;
    this.progress = false;
    this.label = 'Upload';
    this.ouputMessages = [];
    this.isOpen = false;
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
      this.isOpen = false;
    }
  }]);

  return Upload;
}();
// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/store/store.js
function store_toConsumableArray(arr) { return store_arrayWithoutHoles(arr) || store_iterableToArray(arr) || store_nonIterableSpread(); }

function store_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function store_iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function store_arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function store_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function store_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { store_ownKeys(source, true).forEach(function (key) { store_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { store_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function store_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }








vue_default.a.use(vuex_esm["default"]);
/* harmony default export */ var store_store = (function () {
  return new vuex_esm["default"].Store({
    state: {
      isPicker: false,
      folder: new Folder(),
      folderMap: {},
      active: new Folder(),
      back: new Folder(),
      data: [],
      search: new search_Search(),
      editItem: new folder_Item(),
      layout: 'tiles',
      upload: new upload_Upload(),
      uploadIsOpen: false,
      recentUploads: {
        show: false,
        items: []
      },
      newUploadIds: []
    },
    mutations: {
      loadFolders: function loadFolders(state, _ref) {
        var folder = _ref.folder,
            pushState = _ref.pushState;

        if (pushState) {
          history.pushState({
            folderID: folder.id
          }, folder.name, "?folder=".concat(folder.name, "&folderID=").concat(folder.id));
        }

        state.recentUploads.show = false;
        getFolders(folder.id, function (f) {
          state.folder.active = false;
          state.active.active = false;
          state.back = state.active;
          folder.setItems(f.items);
          folder.setChildren(f.children);
          folder.active = true;
          state.active = folder;
          state.search.reset();
          state.folderMap = store_objectSpread({}, state.folderMap, {}, folder.children.reduce(function (acc, folder) {
            acc[folder.id] = folder;
            return acc;
          }, {}));
        });
      },
      loadFoldersByID: function loadFoldersByID(state, id) {
        _loadFoldersByID(state, id);
      },
      loadLibrary: function loadLibrary(state, id) {
        getFoldersData(function (data) {
          state.data = data;

          var _children = children(state.data),
              newFolders = _children.newFolders,
              folderMap = _children.folderMap;

          state.folderMap = folderMap;
          state.folder = new Folder(newFolders[0].id, newFolders[0].name, newFolders[0].items, newFolders[0].children, newFolders[0].parent, true);
          state.active = state.folder;
          history.pushState({
            folderID: state.folder.id
          }, state.folder.name, "?folder=".concat(state.folder.name, "&folderID=").concat(state.folder.id));
          getFolders(state.folder.id, function (f) {
            state.active.setItems(f.items);
            state.active.setChildren(f.children);
          });
        });

        media_recentUploads(function (response) {
          state.recentUploads.items = response.body.data.map(function (item) {
            return new folder_Item(item);
          });
        });
      },
      search: function search(state, keywords) {
        state.search.loading = true;

        if (keywords === '') {
          state.search = new search_Search();
          return;
        }

        media_search(keywords, function (data) {
          state.search = new search_Search(keywords, data);
        });
      },
      recentUploads: function recentUploads(state) {
        state.recentUploads.show = true;

        media_recentUploads(function (response) {
          state.recentUploads.items = response.body.data.map(function (item) {
            return new folder_Item(item);
          });
        });
      },
      editItem: function editItem(state, item) {
        if (!item) {
          state.editItem = new folder_Item();
        } else {
          state.editItem = item;
        }
      },
      setLayout: function setLayout(state, layout) {
        state.layout = layout;
      },
      createFolder: function createFolder(state, payload) {
        addFolder(payload.name, payload.parent.id, function (r) {
          if (r.status !== 200) {
            new noty_default.a({
              layout: 'topCenter',
              text: r.body.error,
              type: 'error',
              timeout: 3500
            }).show();
            return;
          }

          var child = new Folder(r.body.id, r.body.name, [], [], payload.parent);
          state.active.addNewFolder(child);
        });
      },
      editFolder: function editFolder(state, folder) {
        media_editFolder(folder.name, folder.id, function (r) {
          if (r.status !== 200) {
            new noty_default.a({
              layout: 'topCenter',
              text: r.body.error,
              type: 'error',
              timeout: 3500
            }).show();
            folder.name = folder.originalName;
          } else {
            folder.parent.sortChildFolders();
          }
        });
      },
      removeFolder: function removeFolder(state, folder) {
        media_removeFolder(folder.id, function (r) {
          if (r.status !== 204) {
            new noty_default.a({
              layout: 'topCenter',
              text: r.body.error,
              type: 'error',
              timeout: 3500
            }).show();
            return;
          }

          var parent = folder.parent;
          parent.active = true;
          parent.children = parent.children.filter(function (child) {
            return child.id !== folder.id;
          });
          state.back = new Folder();
          state.active = parent;
          new noty_default.a({
            layout: 'topCenter',
            text: "".concat(folder.name, " was removed"),
            type: 'success',
            timeout: 3500
          }).show();
        });
      },
      uploadResult: function uploadResult(state, payload) {
        if (!payload.successful.length) {
          return;
        }

        var newFileIds = payload.successful.reduce(function (acc, el) {
          var newFileIDs = el.response.body.fileIDs;
          acc = [].concat(store_toConsumableArray(acc), store_toConsumableArray(newFileIDs));
          return acc;
        }, []);
        state.newUploadIds = newFileIds;
        getFolders(state.active.id, function (f) {
          state.active.setItems(f.items);
        });
        state.uploadIsOpen = false;
        var maxLen = 3;
        var isOverMax = payload.successful.length > maxLen;
        var len = isOverMax ? maxLen : payload.successful.length;
        var fileNames = [];

        for (var i = 0; i < len; i++) {
          fileNames.push(payload.successful[i].name);
        }

        var msg = fileNames.join(', ');

        if (isOverMax) {
          msg += '...';
        }

        msg += ' uploaded';
        new noty_default.a({
          layout: 'topCenter',
          text: msg,
          type: 'success',
          timeout: 3500
        }).show();
      },
      clearNewUploadIDs: function clearNewUploadIDs(state) {
        state.newUploadIds = [];
      },
      removeItem: function removeItem(state, item) {
        media_removeItem(item.item.id, function (r) {
          if (r.status >= 400) {
            new noty_default.a({
              layout: 'topCenter',
              text: r.body.error,
              type: 'error',
              timeout: 3500
            }).show();
            return;
          }

          item.hide = true;
          new noty_default.a({
            layout: 'topCenter',
            text: "".concat(item.getName(), " was removed"),
            type: 'success',
            timeout: 3500
          }).show();
        });
      },
      move: function move(state, _ref2) {
        var destinationFolder = _ref2.destinationFolder,
            items = _ref2.items,
            folders = _ref2.folders;
        var data = {
          items: items.map(function (item) {
            return item.item.id;
          }),
          folders: folders.map(function (folder) {
            return folder.id;
          }),
          destinationFolder: destinationFolder.id
        };
        items.forEach(function (item) {
          item.hide = true;
        });
        folders.forEach(function (folder) {
          folder.hide = true;
        });

        media_move(data, function (r) {
          if (r.status >= 400) {
            items.forEach(function (item) {
              item.hide = false;
            });
            folders.forEach(function (folder) {
              folder.hide = false;
            });
            new noty_default.a({
              layout: 'topCenter',
              text: r.body.error,
              type: 'error',
              timeout: 3500
            }).show();
            return;
          }

          new noty_default.a({
            layout: 'topCenter',
            text: "".concat(items.length + folders.length, " items were moved"),
            type: 'success',
            timeout: 3500
          }).show();
        });
      },
      toggleUploads: function toggleUploads(state) {
        state.uploadIsOpen = !state.uploadIsOpen;
      },
      remove: function remove(state, _ref3) {
        var items = _ref3.items,
            folders = _ref3.folders;
        var data = {
          items: items.map(function (item) {
            return item.item.id;
          }),
          folders: folders.map(function (folder) {
            return folder.id;
          })
        };
        items.forEach(function (item) {
          item.hide = true;
        });
        folders.forEach(function (folder) {
          folder.hide = true;
        });

        media_remove(data, function (r) {
          if (r.items.length || r.folders.length) {
            var nonDeleteNames = [];

            if (r.items.length) {
              items.forEach(function (item) {
                if (~r.items.indexOf(item.item.id)) {
                  item.hide = false;
                  nonDeleteNames.push(item.getName());
                }
              });
            }

            if (r.folders.length) {
              folders.forEach(function (folder) {
                if (~r.folders.indexOf(folder.id)) {
                  folder.hide = false;
                  nonDeleteNames.push(folder.name);
                }
              });
            }

            new noty_default.a({
              layout: 'topCenter',
              text: nonDeleteNames.slice(0, 3).join(', ') + ' Were unable to be deleted, folders must be empty before deleting',
              type: 'error',
              timeout: 3500
            }).show();
            return;
          }

          var successMsg = "".concat(items.length + folders.length, " ");

          if (items.length && folders.length) {
            successMsg += 'items/folders ';
          } else if (items.length) {
            successMsg += 'item(s) ';
          } else if (folders.length) {
            successMsg += 'folder(s) ';
          }

          successMsg += 'were deleted';
          new noty_default.a({
            layout: 'topCenter',
            text: successMsg,
            type: 'success',
            timeout: 3500
          }).show();
        });
      },
      updateMediaItem: function updateMediaItem(state, _ref4) {
        var item = _ref4.item,
            file = _ref4.file,
            name = _ref4.name;
        update({
          id: item.item.id,
          file: file,
          name: name
        }).then(function (data) {
          new noty_default.a({
            layout: 'topCenter',
            text: data.messages,
            type: 'success',
            timeout: 3500
          }).show();

          _loadFoldersByID(state, item.item.folder);

          item.updateCacheBuster();
        }).catch(function (e) {
          new noty_default.a({
            layout: 'topCenter',
            text: e.body.errors,
            type: 'error',
            timeout: 3500
          }).show();
        });
      }
    },
    actions: {
      folderSelected: function folderSelected(_ref5, _ref6) {
        var commit = _ref5.commit;
        var folder = _ref6.folder,
            _ref6$pushState = _ref6.pushState,
            pushState = _ref6$pushState === void 0 ? true : _ref6$pushState;
        commit('loadFolders', {
          folder: folder,
          pushState: pushState
        });
      },
      loadLibrary: function loadLibrary(_ref7, folderID) {
        var commit = _ref7.commit;
        commit('loadLibrary', folderID);
      },
      search: function search(_ref8, keywords) {
        var commit = _ref8.commit;
        commit('search', keywords);
      },
      editItem: function editItem(_ref9, item) {
        var commit = _ref9.commit;
        commit('editItem', item);
      },
      setLayout: function setLayout(_ref10, layout) {
        var commit = _ref10.commit;
        commit('setLayout', layout);
      },
      createFolder: function createFolder(_ref11, payload) {
        var commit = _ref11.commit;
        commit('createFolder', payload);
      },
      editFolder: function editFolder(_ref12, payload) {
        var commit = _ref12.commit;
        commit('editFolder', payload);
      },
      removeFolder: function removeFolder(_ref13, active) {
        var commit = _ref13.commit;
        commit('removeFolder', active);
      },
      removeItem: function removeItem(_ref14, item) {
        var commit = _ref14.commit;
        commit('removeItem', item);
      },
      move: function move(_ref15, payload) {
        var commit = _ref15.commit;
        commit('move', payload);
      },
      folderSelectByID: function folderSelectByID(_ref16, id) {
        var commit = _ref16.commit;
        commit('loadFoldersByID', id);
      },
      toggleUploads: function toggleUploads(_ref17) {
        var commit = _ref17.commit;
        commit('toggleUploads');
      },
      uploadResult: function uploadResult(_ref18, payload) {
        var commit = _ref18.commit;
        commit('uploadResult', payload);
      },
      recentUploads: function recentUploads(_ref19) {
        var commit = _ref19.commit;
        commit('recentUploads');
      },
      remove: function remove(_ref20, payload) {
        var commit = _ref20.commit;
        commit('remove', payload);
      },
      clearNewUploadIDs: function clearNewUploadIDs(_ref21) {
        var commit = _ref21.commit;
        commit('clearNewUploadIDs');
      },
      updateMediaItem: function updateMediaItem(_ref22, payload) {
        var commit = _ref22.commit;
        commit('updateMediaItem', payload);
      }
    }
  });
});

function _loadFoldersByID(state, id) {
  var folder = state.folderMap[id];

  if (!folder) {
    return;
  }

  getFolders(folder.id, function (f) {
    state.folder.active = false;
    state.active.active = false;
    state.back = state.active;
    folder.setItems(f.items);
    folder.setChildren(f.children);
    folder.active = true;
    state.active = folder;
    state.search.reset();
    state.folderMap = store_objectSpread({}, state.folderMap, {}, folder.children.reduce(function (acc, folder) {
      acc[folder.id] = folder;
      return acc;
    }, {}));
  });
}
// EXTERNAL MODULE: ./node_modules/vuebar/vuebar.js
var vuebar = __webpack_require__("./node_modules/vuebar/vuebar.js");
var vuebar_default = /*#__PURE__*/__webpack_require__.n(vuebar);

// CONCATENATED MODULE: ./resources/assets/js/src/components/medialib/index.js







vue_default.a.use(vue_resource_esm["default"]);
vue_default.a.use(vue_drag_drop_common_default.a);
vue_default.a.use(vuebar_default.a);
vue_default.a.component('confirm-btn', confirm_btn);
var medialib_metaToken = document.head.querySelector('meta[name="csrf-token"]');
medialib_metaToken = medialib_metaToken && medialib_metaToken.content;
vue_default.a.http.headers.common['X-CSRF-TOKEN'] = medialib_metaToken;
var hasSetupPicker = false;
function Medialib() {
  var mediaLibEl = document.querySelector('#medialibapp');

  if (!mediaLibEl) {
    return;
  }

  return new vue_default.a({
    data: {
      isPicker: false
    },
    el: mediaLibEl,
    store: store_store(),
    render: function render(h) {
      return h(medialib_App);
    }
  });
}
var mediaLibPicker;
function setupMedialibPicker() {
  if (hasSetupPicker) {
    return;
  }

  var mediaLibEl = document.createElement('div');
  document.body.appendChild(mediaLibEl);
  requestAnimationFrame(function () {
    mediaLibPicker = new vue_default.a({
      data: {
        isPicker: true
      },
      store: store_store(),
      render: function render(h) {
        return h(medialib_App);
      }
    }).$mount(mediaLibEl);
  });
  hasSetupPicker = true;
}
function PickMedia() {
  return new Promise(function (resolve) {
    mediaLibPicker.$emit('open');
    mediaLibPicker.$on('pick', resolve);
  });
}
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/image/image.vue?vue&type=script&lang=js&
function imagevue_type_script_lang_js_extends() { imagevue_type_script_lang_js_extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return imagevue_type_script_lang_js_extends.apply(this, arguments); }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var imagevue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId', 'valueObj'],
  mixins: [field_values],
  data: function data() {
    return {
      loading: true,
      alt: ''
    };
  },
  created: function created() {
    setupMedialibPicker();
  },
  mounted: function mounted() {
    if (this.valueObj.value) {
      this.alt = this.valueObj.value.alt;
    }

    this.loading = false;
  },
  watch: {
    alt: function alt(newValue) {
      if (this.loading) {
        return;
      }

      newValue = imagevue_type_script_lang_js_extends({}, this.valueObj.value, {
        alt: newValue
      });
      this.updateValue(newValue);
    }
  },
  methods: {
    updateValue: function updateValue(newValue) {
      this.valueObj.value = newValue;

      if (this.comboId) {
        this.$store.commit('updateComboFieldValue', {
          fieldID: this.fieldId,
          comboID: this.comboId,
          comboItemId: this.comboItemId,
          newValue: this.valueObj
        });
      } else {
        this.$store.commit('updateValue', {
          fieldID: this.fieldId,
          newValue: this.valueObj
        });
      }
    },
    clearValue: function clearValue() {
      this.updateValue({
        id: '',
        alt: '',
        url: ''
      });
      this.alt = '';
    },
    selectImage: function selectImage() {
      var _this = this;

      PickMedia().then(function (value) {
        var newValue = imagevue_type_script_lang_js_extends({}, _this.valueObj.value, value);

        _this.updateValue(newValue);
      });
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/image/image.vue?vue&type=script&lang=js&
 /* harmony default export */ var image_imagevue_type_script_lang_js_ = (imagevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/image/image.vue





/* normalize component */

var image_component = Object(componentNormalizer["default"])(
  image_imagevue_type_script_lang_js_,
  imagevue_type_template_id_bb1372b2_render,
  imagevue_type_template_id_bb1372b2_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var image_api; }
image_component.options.__file = "resources/assets/js/src/components/fields/types/image/image.vue"
/* harmony default export */ var image_image = (image_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/image/index.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var types_imagevue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  mixins: [field_values],
  components: {
    'validation': validation,
    'multi': multi,
    'field-image': image_image
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/image/index.vue?vue&type=script&lang=js&
 /* harmony default export */ var fields_types_imagevue_type_script_lang_js_ = (types_imagevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/image/index.vue





/* normalize component */

var types_image_component = Object(componentNormalizer["default"])(
  fields_types_imagevue_type_script_lang_js_,
  imagevue_type_template_id_b2a79ac4_render,
  imagevue_type_template_id_b2a79ac4_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var types_image_api; }
types_image_component.options.__file = "resources/assets/js/src/components/fields/types/image/index.vue"
/* harmony default export */ var types_image = (types_image_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/file.vue?vue&type=template&id=d9ae71a8&
var filevue_type_template_id_d9ae71a8_render = function() {
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
          _c("label", { attrs: { for: _vm.inputName + "[alt]" } }, [
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
                    _c("div", { staticClass: "o-file" }, [
                      _c("div", { staticClass: "o-file__preview" }, [
                        _c("div", { staticClass: "o-file__preview-wrap" }, [
                          _c("svg", [
                            _c("use", {
                              attrs: {
                                "xlink:href": "/argon/images/svgicons.svg#files"
                              }
                            })
                          ])
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "o-file__help-text" }, [
                        _c("div", { staticClass: "o-form-icon" }, [
                          _c("div", { staticClass: "o-form-icon__icon" }, [
                            _c("span", [_vm._v("Url")])
                          ]),
                          _vm._v(" "),
                          _c("input", {
                            attrs: { type: "text", disabled: "" },
                            domProps: {
                              value: valueObj.value && valueObj.value.url
                            }
                          }),
                          _vm._v(" "),
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              id: _vm.inputName,
                              name: _vm.inputName
                            },
                            domProps: {
                              value: valueObj.value && valueObj.value.id
                            }
                          })
                        ]),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "o-btn o-btn--sm o-file__btn",
                            on: {
                              click: function($event) {
                                return _vm.selectFile($event, valueObj)
                              }
                            }
                          },
                          [_vm._v("select")]
                        )
                      ]),
                      _vm._v(" "),
                      !_vm.field.options.settings.multiple
                        ? _c(
                            "button",
                            {
                              staticClass: "o-confirm-btn",
                              attrs: {
                                "data-balloon": "Delete",
                                title: "Delete"
                              },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  return _vm.clearValue(valueObj)
                                }
                              }
                            },
                            [
                              _c("svg", [
                                _c("use", {
                                  attrs: {
                                    "xlink:href":
                                      "/argon/images/svgicons.svg#delete"
                                  }
                                })
                              ])
                            ]
                          )
                        : _vm._e()
                    ])
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
var filevue_type_template_id_d9ae71a8_staticRenderFns = []
filevue_type_template_id_d9ae71a8_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/file.vue?vue&type=template&id=d9ae71a8&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/file.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var filevue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  mixins: [field_values],
  components: {
    'validation': validation,
    'multi': multi
  },
  created: function created() {
    setupMedialibPicker();
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
    },
    clearValue: function clearValue(valueObj) {
      this.updateValue(valueObj, {
        id: '',
        alt: '',
        url: ''
      });
    },
    selectFile: function selectFile(evt, valueObj) {
      var _this = this;

      evt.preventDefault();
      PickMedia().then(function (value) {
        _this.updateValue(valueObj, value);
      });
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/file.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_filevue_type_script_lang_js_ = (filevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/file.vue





/* normalize component */

var file_component = Object(componentNormalizer["default"])(
  types_filevue_type_script_lang_js_,
  filevue_type_template_id_d9ae71a8_render,
  filevue_type_template_id_d9ae71a8_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var file_api; }
file_component.options.__file = "resources/assets/js/src/components/fields/types/file.vue"
/* harmony default export */ var types_file = (file_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/icon/index.vue?vue&type=template&id=1a3cab6c&
var iconvue_type_template_id_1a3cab6c_render = function() {
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
                    _c("field-icon", {
                      attrs: {
                        "value-obj": valueObj,
                        "field-id": _vm.fieldId,
                        "combo-id": _vm.comboId,
                        "combo-item-id": _vm.comboItemId
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
var iconvue_type_template_id_1a3cab6c_staticRenderFns = []
iconvue_type_template_id_1a3cab6c_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/icon/index.vue?vue&type=template&id=1a3cab6c&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/icon/icon.vue?vue&type=template&id=b6654d62&
var iconvue_type_template_id_b6654d62_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "o-item-picker o-item-picker--no-edit o-item-picker--label",
      class: { "is-open": _vm.pickerOpen }
    },
    [
      _c(
        "button",
        {
          staticClass: "o-item-picker__btn",
          on: {
            click: function($event) {
              $event.preventDefault()
              return _vm.togglePicker($event)
            }
          }
        },
        [
          _c("svg", [
            _c("use", {
              attrs: { "xlink:href": _vm.svgPath + _vm.value.value }
            })
          ])
        ]
      ),
      _vm._v(" "),
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.value.value,
            expression: "value.value"
          }
        ],
        attrs: { type: "hidden", name: _vm.inputName, id: _vm.inputName },
        domProps: { value: _vm.value.value },
        on: {
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.$set(_vm.value, "value", $event.target.value)
          }
        }
      }),
      _vm._v(" "),
      _c(
        "output",
        {
          staticClass: "o-item-picker__output",
          on: {
            click: function($event) {
              $event.preventDefault()
              return _vm.launchPicker($event)
            }
          }
        },
        [_vm._v(_vm._s(_vm.value.name))]
      ),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "o-item-picker__dropdown-btn",
          on: {
            click: function($event) {
              $event.preventDefault()
              return _vm.togglePicker($event)
            }
          }
        },
        [
          _c("svg", [
            _c("use", {
              attrs: { "xlink:href": "/argon/images/svgicons.svg#select" }
            })
          ])
        ]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "o-item-picker__window" }, [
        _c("button", {
          staticClass: "o-item-picker__close",
          on: {
            click: function($event) {
              $event.preventDefault()
              return _vm.closePicker($event)
            }
          }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "o-item-picker__vignette" }),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "o-item-picker__list" },
          [
            _c("div", { staticClass: "o-item-picker__search" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.search,
                    expression: "search"
                  }
                ],
                attrs: { type: "text", placeholder: "search..." },
                domProps: { value: _vm.search },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.search = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("button", {
                staticClass: "o-item-picker__search-close",
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    return _vm.clearSearch($event)
                  }
                }
              })
            ]),
            _vm._v(" "),
            _vm._l(_vm.filteredOptions, function(option, index) {
              return _c(
                "button",
                {
                  key: index,
                  staticClass: "o-item-picker__item",
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.setValue(option)
                    }
                  }
                },
                [
                  _c("div", { staticClass: "o-item-picker__icon" }, [
                    _c("svg", [
                      _c("use", {
                        attrs: { "xlink:href": _vm.svgPath + option.value }
                      })
                    ])
                  ]),
                  _vm._v(" "),
                  _c("span", { staticClass: "o-item-picker__label" }, [
                    _vm._v(_vm._s(option.name))
                  ])
                ]
              )
            })
          ],
          2
        )
      ])
    ]
  )
}
var iconvue_type_template_id_b6654d62_staticRenderFns = []
iconvue_type_template_id_b6654d62_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/icon/icon.vue?vue&type=template&id=b6654d62&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/icon/icon.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var iconvue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId', 'valueObj'],
  mixins: [field_values],
  data: function data() {
    return {
      search: '',
      value: {
        name: '',
        value: ''
      },
      pickerOpen: false,
      svgPath: '/images/svgicons.svg#',
      options: []
    };
  },
  created: function created() {
    var _this = this;

    this.options = [];

    if (this.field.options.settings.svg_pat) {
      this.svgPath = this.field.options.settings.svg_path + '#';
    }

    if (this.field.options.settings.meta_path) {
      fetch(this.field.options.settings.meta_path).then(function (res) {
        return res.json();
      }).then(function (_ref) {
        var svgicons = _ref.svgicons;
        _this.options = svgicons.map(function (el) {
          return {
            name: el,
            value: el
          };
        });

        _this.$emit('optionsSet');
      });
    }
  },
  mounted: function mounted() {
    var _this2 = this;

    this.loading = false;
    this.$on('optionsSet', function () {
      _this2.value = _this2.options.find(function (option) {
        return option.value === _this2.valueObj.value;
      }) || _this2.value;
    });
  },
  computed: {
    filteredOptions: function filteredOptions() {
      var _this3 = this;

      if (this.search) {
        return this.options.filter(function (el) {
          return el.name.match(new RegExp(_this3.search));
        });
      }

      return this.options;
    }
  },
  methods: {
    updateValue: function updateValue() {
      this.valueObj.value = this.value.value;

      if (this.comboId) {
        this.$store.commit('updateComboFieldValue', {
          fieldID: this.fieldId,
          comboID: this.comboId,
          comboItemId: this.comboItemId,
          newValue: this.valueObj
        });
      } else {
        this.$store.commit('updateValue', {
          fieldID: this.fieldId,
          newValue: this.valueObj
        });
      }
    },
    launchPicker: function launchPicker() {
      this.pickerOpen = true;
    },
    closePicker: function closePicker() {
      this.pickerOpen = false;
    },
    togglePicker: function togglePicker() {
      this.pickerOpen = !this.pickerOpen;
    },
    setValue: function setValue(newValue) {
      this.value = newValue;
      this.updateValue();
      this.closePicker();
    },
    clearSearch: function clearSearch() {
      this.search = '';
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/icon/icon.vue?vue&type=script&lang=js&
 /* harmony default export */ var icon_iconvue_type_script_lang_js_ = (iconvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/icon/icon.vue





/* normalize component */

var icon_component = Object(componentNormalizer["default"])(
  icon_iconvue_type_script_lang_js_,
  iconvue_type_template_id_b6654d62_render,
  iconvue_type_template_id_b6654d62_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var icon_api; }
icon_component.options.__file = "resources/assets/js/src/components/fields/types/icon/icon.vue"
/* harmony default export */ var icon = (icon_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/icon/index.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var types_iconvue_type_script_lang_js_ = ({
  props: ['fieldId', 'icons', 'type', 'comboId', 'comboItemId'],
  mixins: [field_values],
  components: {
    'field-icon': icon,
    'validation': validation,
    'multi': multi
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/icon/index.vue?vue&type=script&lang=js&
 /* harmony default export */ var fields_types_iconvue_type_script_lang_js_ = (types_iconvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/icon/index.vue





/* normalize component */

var types_icon_component = Object(componentNormalizer["default"])(
  fields_types_iconvue_type_script_lang_js_,
  iconvue_type_template_id_1a3cab6c_render,
  iconvue_type_template_id_1a3cab6c_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var types_icon_api; }
types_icon_component.options.__file = "resources/assets/js/src/components/fields/types/icon/index.vue"
/* harmony default export */ var types_icon = (types_icon_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/types.vue?vue&type=script&lang=js&
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
  'boolean': 'boolean-input',
  'item': 'select-input',
  'menu': 'select-input',
  'datetime': 'datetime-input',
  'image': 'image-input',
  'file': 'file-input',
  'icon': 'icon-input'
};
/* harmony default export */ var typesvue_type_script_lang_js_ = ({
  name: 'types',
  props: ['field', 'comboId', 'comboItemId'],
  components: {
    'text-input': types_text,
    'email-input': email,
    'phone-input': phone,
    combo: combo,
    'select-input': types_select,
    'location-input': types_location,
    'wysiwyg-input': wysiwyg,
    'button-input': types_button,
    'boolean-input': types_boolean,
    'datetime-input': datetime,
    'image-input': types_image,
    'file-input': types_file,
    'icon-input': types_icon
  },
  computed: {
    type: function type() {
      var type = typeMap[this.field.options.typeKey];
      return type || 'text-input';
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/types.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_typesvue_type_script_lang_js_ = (typesvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/types.vue





/* normalize component */

var types_component = Object(componentNormalizer["default"])(
  types_typesvue_type_script_lang_js_,
  typesvue_type_template_id_43058c79_render,
  typesvue_type_template_id_43058c79_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var types_api; }
types_component.options.__file = "resources/assets/js/src/components/fields/types/types.vue"
/* harmony default export */ var types_types = (types_component.exports);
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/store/index.js
function store_extends() { store_extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return store_extends.apply(this, arguments); }




function getStore() {
  return new vuex_esm["default"].Store({
    state: {
      fields: [],
      oldState: [],
      header: '',
      showActions: true,
      showDraggables: true,
      tabName: ''
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
      setDataTabName: function setDataTabName(state, _ref) {
        var tabName = _ref.tabName;
        state.tabName = tabName;
      },
      toggleDraggables: function toggleDraggables(state, _ref2) {
        var tabName = _ref2.tabName;

        if (state.tabName === tabName) {
          state.showDraggables = true;
        } else {
          state.showDraggables = false;
        }
      },
      setFields: function setFields(state, _ref3) {
        var fields = _ref3.fields;
        state.fields = fields;
      },
      setShowActions: function setShowActions(state, _ref4) {
        var actions = _ref4.actions;
        state.showActions = actions;
      },
      setOldState: function setOldState(state) {
        state.oldState = deepClone(state.fields);
      },
      restoreOldState: function restoreOldState(state) {
        state.fields = deepClone(state.oldState);
      },
      setHeader: function setHeader(state, _ref5) {
        var header = _ref5.header;
        state.header = header;
      },
      // Field Mutations
      updateValue: function updateValue(state, _ref6) {
        var fieldID = _ref6.fieldID,
            newValue = _ref6.newValue;
        state.fields = state.fields.map(function (field) {
          if (field.id !== fieldID) {
            return field;
          }

          field.values = field.values.map(function (value) {
            if (value.id !== newValue.id) {
              return value;
            }

            value = store_extends(value, newValue);
            return value;
          });
          return field;
        });
        preventPageLeave();
      },
      updateValues: function updateValues(state, _ref7) {
        var fieldID = _ref7.fieldID,
            newValues = _ref7.newValues;
        state.fields = state.fields.map(function (field) {
          if (field.id !== fieldID) {
            return field;
          }

          field.values = newValues;
          return field;
        });
        preventPageLeave();
      },
      addValue: function addValue(state, _ref8) {
        var fieldID = _ref8.fieldID,
            valueObj = _ref8.valueObj;
        state.fields = state.fields.map(function (field) {
          if (field.id !== fieldID) {
            return field;
          }

          field.values.push(store_extends(valueObj, {
            id: createUniqueHash()
          }));
          return field;
        });
        preventPageLeave();
      },
      removeValue: function removeValue(state, _ref9) {
        var fieldID = _ref9.fieldID,
            valueID = _ref9.valueID;
        state.fields = state.fields.map(function (field) {
          if (field.id !== fieldID) {
            return field;
          }

          field.values = field.values.filter(function (value) {
            return value.id !== valueID;
          });
          return field;
        });
        preventPageLeave();
      },
      // Combo Item Mutations
      updateComboItemValues: function updateComboItemValues(state, _ref10) {
        var comboID = _ref10.comboID,
            newValues = _ref10.newValues;
        state.fields = state.fields.map(function (field) {
          if (field.id !== comboID) {
            return field;
          }

          field.values = newValues;
          return field;
        });
        preventPageLeave();
      },
      addComboItemValue: function addComboItemValue(state, _ref11) {
        var comboID = _ref11.comboID,
            newValueObj = _ref11.newValueObj;
        state.fields = state.fields.map(function (field) {
          if (field.id !== comboID) {
            return field;
          }

          newValueObj = Object.keys(newValueObj).reduce(function (acc, fieldID) {
            if (fieldID === 'id') {
              return acc;
            }

            acc[fieldID] = newValueObj[fieldID].map(function (value) {
              return store_extends(value, {
                id: createUniqueHash()
              });
            });
            return acc;
          }, {});
          field.values.push(store_extends(newValueObj, {
            id: field.values.length
          }));
          return field;
        });
        preventPageLeave();
      },
      removeComboItem: function removeComboItem(state, _ref12) {
        var comboID = _ref12.comboID,
            comboItemID = _ref12.comboItemID;
        state.fields = state.fields.map(function (field) {
          if (field.id !== comboID) {
            return field;
          }

          field.values = field.values.filter(function (valueObj) {
            return valueObj.id !== comboItemID;
          });
          return field;
        });
        preventPageLeave();
      },
      // Combo Field Mutations
      updateComboFieldValue: function updateComboFieldValue(state, _ref13) {
        var fieldID = _ref13.fieldID,
            comboID = _ref13.comboID,
            comboItemId = _ref13.comboItemId,
            newValue = _ref13.newValue;
        state.fields = state.fields.map(function (field) {
          if (field.id !== comboID) {
            return field;
          }

          field.values = field.values.map(function (valuesObj) {
            if (valuesObj.id !== comboItemId) {
              return valuesObj;
            }

            if (valuesObj[fieldID].length) {
              valuesObj[fieldID] = valuesObj[fieldID].map(function (value) {
                if (value.id !== newValue.id) {
                  return value;
                }

                value = store_extends(value, newValue);
                return value;
              });
            } else {
              valuesObj[fieldID].push(newValue);
            }

            return valuesObj;
          });
          return field;
        });
        preventPageLeave();
      },
      updateComboFieldValues: function updateComboFieldValues(state, _ref14) {
        var fieldID = _ref14.fieldID,
            comboID = _ref14.comboID,
            comboItemId = _ref14.comboItemId,
            newValues = _ref14.newValues;
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
        preventPageLeave();
      },
      addComboFieldValue: function addComboFieldValue(state, _ref15) {
        var fieldID = _ref15.fieldID,
            comboID = _ref15.comboID,
            comboItemId = _ref15.comboItemId,
            valueObj = _ref15.valueObj;
        state.fields = state.fields.map(function (field) {
          if (field.id !== comboID) {
            return field;
          }

          field.values = field.values.map(function (valuesObj) {
            if (valuesObj.id !== comboItemId) {
              return valuesObj;
            }

            valuesObj[fieldID].push(store_extends(valueObj, {
              id: createUniqueHash()
            }));
            return valuesObj;
          });
          return field;
        });
        preventPageLeave();
      },
      removeComboFieldValue: function removeComboFieldValue(state, _ref16) {
        var fieldID = _ref16.fieldID,
            comboID = _ref16.comboID,
            comboItemId = _ref16.comboItemId,
            valueID = _ref16.valueID;
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
        preventPageLeave();
      }
    }
  });
}
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/index.js








vue_default.a.config.productionTip = false;
vue_default.a.component('draggable', vuedraggable_common_default.a);
vue_default.a.component('types', types_types);
vue_default.a.use(vuex_esm["default"]);
function Fields() {
  var fieldEls = document.querySelectorAll('.js-fields');
  var fields = Array.from(fieldEls);
  return fields.map(function (el) {
    // const tabPanel = el.closest('[data-tab]')
    // const tabName = tabPanel.dataset.tab
    var name = el.dataset.name;
    var store = getStore();
    var _window$fieldGroups$n = window.fieldGroups[name],
        fields = _window$fieldGroups$n.fields,
        header = _window$fieldGroups$n.header,
        _window$fieldGroups$n2 = _window$fieldGroups$n.actions,
        actions = _window$fieldGroups$n2 === void 0 ? true : _window$fieldGroups$n2;
    fields = processFields(fields);
    store.commit('setFields', {
      fields: fields
    });
    store.commit('setHeader', {
      header: header
    });
    store.commit('setShowActions', {
      actions: actions
    });
    var tabName = el.closest('[data-tab]').dataset.tab;
    store.commit('setDataTabName', {
      tabName: tabName
    });
    return new vue_default.a({
      store: store,
      render: function render(h) {
        return h(App);
      }
    }).$mount(el); // addTabInit(tabName, () => {
    // })
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
  if (!Array.isArray(values)) {
    values = [values];
  }

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
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/page-edit/App.vue?vue&type=template&id=146287be&
var Appvue_type_template_id_146287be_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "l-halves c-tab-panel__inner",
      class: { "is-dragging": _vm.isDragging }
    },
    [
      _c("div", { staticClass: "c-block-list__wrap" }, [
        _c("div", { staticClass: "typography l-space" }, [
          _c("h3", [_vm._v("Active blocks")]),
          _vm._v(" "),
          _c("input", {
            attrs: { type: "hidden", name: "group_order" },
            domProps: { value: _vm.renderOrder }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "c-block-list" }, [
          _c("div", { staticClass: "c-block-list__search o-form" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.renderSearch,
                  expression: "renderSearch"
                }
              ],
              attrs: {
                type: "text",
                id: "search",
                name: "search",
                placeholder: "Search blocks"
              },
              domProps: { value: _vm.renderSearch },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.renderSearch = $event.target.value
                }
              }
            }),
            _vm._v(" "),
            _c("div", { staticClass: "c-block-list__search-icon" }, [
              _c("svg", [
                _c("use", {
                  attrs: { "xlink:href": "/argon/images/svgicons.svg#search" }
                })
              ])
            ])
          ]),
          _vm._v(" "),
          _vm.canDrag
            ? _c(
                "div",
                { staticClass: "c-block-list__container" },
                [
                  _c(
                    "div",
                    {
                      staticClass:
                        "c-block-list__inner-list c-block-list__inner-list--no-grow"
                    },
                    _vm._l(_vm.filteredRenderNonSortList, function(block) {
                      return _c("block-item", {
                        key: block.id,
                        attrs: { block: block },
                        on: { edit: _vm.editBlock }
                      })
                    }),
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "draggable",
                    {
                      staticClass: "c-block-list__inner-list",
                      attrs: { options: _vm.dragOptions },
                      on: { start: _vm.startDragging, end: _vm.endDragging },
                      model: {
                        value: _vm.renderingDragGroup,
                        callback: function($$v) {
                          _vm.renderingDragGroup = $$v
                        },
                        expression: "renderingDragGroup"
                      }
                    },
                    _vm._l(_vm.filteredRenderList, function(block) {
                      return _c("block-item", {
                        key: block.id,
                        attrs: { block: block },
                        on: { delete: _vm.removeItem, edit: _vm.editBlock }
                      })
                    }),
                    1
                  )
                ],
                1
              )
            : _vm._e()
        ])
      ]),
      _vm._v(" "),
      _vm.hasRenderable
        ? _c("div", { staticClass: "c-block-list__wrap" }, [
            _vm._m(0),
            _vm._v(" "),
            _c("div", { staticClass: "c-block-list" }, [
              _c("div", { staticClass: "c-block-list__search o-form" }, [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.blockSearch,
                      expression: "blockSearch"
                    }
                  ],
                  attrs: {
                    type: "text",
                    id: "search",
                    name: "search",
                    placeholder: "Search blocks"
                  },
                  domProps: { value: _vm.blockSearch },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.blockSearch = $event.target.value
                    }
                  }
                }),
                _vm._v(" "),
                _c("div", { staticClass: "c-block-list__search-icon" }, [
                  _c("svg", [
                    _c("use", {
                      attrs: {
                        "xlink:href": "/argon/images/svgicons.svg#search"
                      }
                    })
                  ])
                ])
              ]),
              _vm._v(" "),
              _vm.canDrag
                ? _c(
                    "div",
                    { staticClass: "c-block-list__container" },
                    [
                      _c(
                        "draggable",
                        {
                          staticClass: "c-block-list__inner-list",
                          attrs: { options: _vm.dragOptions },
                          on: {
                            start: _vm.startDragging,
                            end: _vm.endDragging
                          },
                          model: {
                            value: _vm.blockDragList,
                            callback: function($$v) {
                              _vm.blockDragList = $$v
                            },
                            expression: "blockDragList"
                          }
                        },
                        _vm._l(_vm.filteredBlockList, function(block) {
                          return _c("block-item", {
                            key: block.id,
                            attrs: { block: block },
                            on: { add: _vm.addItem }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  )
                : _vm._e()
            ])
          ])
        : _vm._e()
    ]
  )
}
var Appvue_type_template_id_146287be_staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "typography l-space" }, [
      _c("h3", [_vm._v("Inactive blocks")])
    ])
  }
]
Appvue_type_template_id_146287be_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/App.vue?vue&type=template&id=146287be&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/page-edit/components/Block.vue?vue&type=template&id=671e8547&
var Blockvue_type_template_id_671e8547_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(_vm.type, {
    tag: "component",
    attrs: { block: _vm.block },
    on: { add: _vm.addItem, delete: _vm.deleteItem, edit: _vm.editBlock }
  })
}
var Blockvue_type_template_id_671e8547_staticRenderFns = []
Blockvue_type_template_id_671e8547_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/components/Block.vue?vue&type=template&id=671e8547&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/page-edit/components/BlockAdd.vue?vue&type=template&id=33dff4ec&
var BlockAddvue_type_template_id_33dff4ec_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "c-block" }, [
    _c("input", {
      attrs: { type: "hidden", name: _vm.renderInputName, value: "0" }
    }),
    _vm._v(" "),
    _c("input", {
      attrs: {
        type: "checkbox",
        checked: "",
        hidden: "",
        name: _vm.renderInputName,
        value: "0"
      }
    }),
    _vm._v(" "),
    _c("div", { staticClass: "c-block__image" }, [
      _vm.block.image
        ? _c("img", { attrs: { src: _vm.block.image, alt: _vm.block.name } })
        : _vm._e(),
      _vm._v(" "),
      !_vm.block.image
        ? _c("div", { staticClass: "c-block__empty-image" }, [
            _c("svg", [
              _c("use", {
                attrs: { "xlink:href": "/argon/images/svgicons.svg#file-input" }
              })
            ])
          ])
        : _vm._e()
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "c-block__title" }, [
      _c("span", [_vm._v(_vm._s(_vm.block.name))])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "c-block__action-list" }, [
      _c(
        "button",
        {
          staticClass: "c-block__action",
          on: {
            click: function($event) {
              return _vm.addBlock($event)
            }
          }
        },
        [
          _c("div", { staticClass: "c-block__icon" }, [
            _c("svg", [
              _c("use", {
                attrs: { "xlink:href": "/argon/images/svgicons.svg#arrow-left" }
              })
            ])
          ])
        ]
      )
    ])
  ])
}
var BlockAddvue_type_template_id_33dff4ec_staticRenderFns = []
BlockAddvue_type_template_id_33dff4ec_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/components/BlockAdd.vue?vue&type=template&id=33dff4ec&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/page-edit/mixins/BlockValues.vue?vue&type=script&lang=js&
/* harmony default export */ var BlockValuesvue_type_script_lang_js_ = ({
  computed: {
    renderInputName: function renderInputName() {
      return "group_render[".concat(this.block.id, "]");
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/mixins/BlockValues.vue?vue&type=script&lang=js&
 /* harmony default export */ var mixins_BlockValuesvue_type_script_lang_js_ = (BlockValuesvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/mixins/BlockValues.vue
var BlockValues_render, BlockValues_staticRenderFns




/* normalize component */

var BlockValues_component = Object(componentNormalizer["default"])(
  mixins_BlockValuesvue_type_script_lang_js_,
  BlockValues_render,
  BlockValues_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var BlockValues_api; }
BlockValues_component.options.__file = "resources/assets/js/src/components/page-edit/mixins/BlockValues.vue"
/* harmony default export */ var BlockValues = (BlockValues_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/page-edit/components/BlockAdd.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var BlockAddvue_type_script_lang_js_ = ({
  props: ['block'],
  mixins: [BlockValues],
  methods: {
    addBlock: function addBlock(evt) {
      evt.preventDefault();
      this.$emit('add', this.block.id);
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/components/BlockAdd.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_BlockAddvue_type_script_lang_js_ = (BlockAddvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/components/BlockAdd.vue





/* normalize component */

var BlockAdd_component = Object(componentNormalizer["default"])(
  components_BlockAddvue_type_script_lang_js_,
  BlockAddvue_type_template_id_33dff4ec_render,
  BlockAddvue_type_template_id_33dff4ec_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var BlockAdd_api; }
BlockAdd_component.options.__file = "resources/assets/js/src/components/page-edit/components/BlockAdd.vue"
/* harmony default export */ var BlockAdd = (BlockAdd_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/page-edit/components/BlockEdit.vue?vue&type=template&id=f0915a1e&
var BlockEditvue_type_template_id_f0915a1e_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "c-block" }, [
    _c("input", {
      attrs: { type: "hidden", name: _vm.renderInputName, value: "1" }
    }),
    _vm._v(" "),
    _c("input", {
      attrs: {
        type: "checkbox",
        checked: "",
        hidden: "",
        name: _vm.renderInputName,
        value: "1"
      }
    }),
    _vm._v(" "),
    _c("div", { staticClass: "c-block__edit" }, [
      _c(
        "div",
        {
          staticClass: "c-block__edit-btn",
          on: {
            click: function($event) {
              return _vm.editBlock($event)
            }
          }
        },
        [_c("span", [_vm._v("Edit block content")])]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "c-block__image" }, [
        _vm.block.image
          ? _c("img", { attrs: { src: _vm.block.image, alt: _vm.block.name } })
          : _vm._e(),
        _vm._v(" "),
        !_vm.block.image
          ? _c("div", { staticClass: "c-block__empty-image" }, [
              _c("svg", [
                _c("use", {
                  attrs: {
                    "xlink:href": "/argon/images/svgicons.svg#file-input"
                  }
                })
              ])
            ])
          : _vm._e()
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "c-block__title" }, [
        _c("span", [_vm._v(_vm._s(_vm.block.name))])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "c-block__action-list" }, [
      _vm.block.isRenderable && _vm.block.isSortable
        ? _c(
            "button",
            {
              staticClass: "c-block__action",
              on: {
                click: function($event) {
                  return _vm.deleteBlock($event)
                }
              }
            },
            [
              _c("div", { staticClass: "c-block__icon" }, [
                _c("svg", [
                  _c("use", {
                    attrs: {
                      "xlink:href": "/argon/images/svgicons.svg#arrow-right"
                    }
                  })
                ])
              ])
            ]
          )
        : _vm._e(),
      _vm._v(" "),
      !_vm.block.isRenderable && !_vm.block.isSortable
        ? _c(
            "div",
            { staticClass: "c-block__action c-block__action--no-hover" },
            [
              _c("div", { staticClass: "c-block__icon" }, [
                _c("svg", [
                  _c("use", {
                    attrs: { "xlink:href": "/argon/images/svgicons.svg#lock" }
                  })
                ])
              ])
            ]
          )
        : _vm._e()
    ])
  ])
}
var BlockEditvue_type_template_id_f0915a1e_staticRenderFns = []
BlockEditvue_type_template_id_f0915a1e_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/components/BlockEdit.vue?vue&type=template&id=f0915a1e&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/page-edit/components/BlockEdit.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var BlockEditvue_type_script_lang_js_ = ({
  props: ['block'],
  mixins: [BlockValues],
  methods: {
    deleteBlock: function deleteBlock(evt) {
      evt.preventDefault();
      this.$emit('delete', this.block.id);
    },
    editBlock: function editBlock(evt) {
      evt.preventDefault();
      this.$emit('edit', this.block.id, this.block.name);
    },
    preventDefault: function preventDefault(evt) {
      evt.preventDefault();
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/components/BlockEdit.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_BlockEditvue_type_script_lang_js_ = (BlockEditvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/components/BlockEdit.vue





/* normalize component */

var BlockEdit_component = Object(componentNormalizer["default"])(
  components_BlockEditvue_type_script_lang_js_,
  BlockEditvue_type_template_id_f0915a1e_render,
  BlockEditvue_type_template_id_f0915a1e_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var BlockEdit_api; }
BlockEdit_component.options.__file = "resources/assets/js/src/components/page-edit/components/BlockEdit.vue"
/* harmony default export */ var BlockEdit = (BlockEdit_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/page-edit/components/Block.vue?vue&type=script&lang=js&
//
//
//
//


/* harmony default export */ var Blockvue_type_script_lang_js_ = ({
  props: ['block'],
  components: {
    BlockAdd: BlockAdd,
    BlockEdit: BlockEdit
  },
  computed: {
    type: function type() {
      if (!this.block.isRenderable || this.block.isRendering) {
        return 'block-edit';
      }

      return 'block-add';
    }
  },
  methods: {
    addItem: function addItem(id) {
      this.$emit('add', id);
    },
    deleteItem: function deleteItem(id) {
      this.$emit('delete', id);
    },
    editBlock: function editBlock(id, name) {
      this.$emit('edit', id, name);
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/components/Block.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Blockvue_type_script_lang_js_ = (Blockvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/components/Block.vue





/* normalize component */

var Block_component = Object(componentNormalizer["default"])(
  components_Blockvue_type_script_lang_js_,
  Blockvue_type_template_id_671e8547_render,
  Blockvue_type_template_id_671e8547_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Block_api; }
Block_component.options.__file = "resources/assets/js/src/components/page-edit/components/Block.vue"
/* harmony default export */ var Block = (Block_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/page-edit/App.vue?vue&type=script&lang=js&
function Appvue_type_script_lang_js_toConsumableArray(arr) { return Appvue_type_script_lang_js_arrayWithoutHoles(arr) || Appvue_type_script_lang_js_iterableToArray(arr) || Appvue_type_script_lang_js_nonIterableSpread(); }

function Appvue_type_script_lang_js_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function Appvue_type_script_lang_js_iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function Appvue_type_script_lang_js_arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ var page_edit_Appvue_type_script_lang_js_ = ({
  components: {
    'block-item': Block
  },
  data: function data() {
    return {
      canDrag: true,
      nonSortableRenderingGroups: [],
      renderingGroups: [],
      blockList: [],
      hasRenderable: false,
      isDragging: false,
      dragOptions: {
        group: {
          name: 'groupEdit',
          pull: true,
          put: true
        },
        animation: 75
      },
      renderSearch: '',
      blockSearch: ''
    };
  },
  created: function created() {
    this.nonSortableRenderingGroups = window.groups.filter(function (el) {
      return (!el.isRenderable || el.isRendering) && !el.isSortable && !el.isTab;
    });
    this.renderingGroups = window.groups.filter(function (el) {
      return (!el.isRenderable || el.isRendering) && el.isSortable && !el.isTab;
    });
    this.blockList = window.groups.filter(function (el) {
      return el.isRenderable && !el.isRendering;
    });
    this.hasRenderable = !!window.groups.find(function (group) {
      return group.isRenderable;
    });
  },
  computed: {
    renderingDragGroup: {
      get: function get() {
        return this.renderingGroups;
      },
      set: function set(values) {
        preventPageLeave();
        this.renderingGroups = values.map(function (el) {
          el.isRendering = true;
          return el;
        });
      }
    },
    blockDragList: {
      get: function get() {
        return this.blockList;
      },
      set: function set(values) {
        preventPageLeave();
        this.blockList = values.map(function (el) {
          el.isRendering = false;
          return el;
        });
      }
    },
    filteredBlockList: function filteredBlockList() {
      var _this = this;

      return this.blockList.filter(function (block) {
        return block.name.toLowerCase().includes(_this.blockSearch);
      });
    },
    filteredRenderList: function filteredRenderList() {
      var _this2 = this;

      return this.renderingGroups.filter(function (block) {
        return block.name.toLowerCase().includes(_this2.renderSearch);
      });
    },
    filteredRenderNonSortList: function filteredRenderNonSortList() {
      var _this3 = this;

      return this.nonSortableRenderingGroups.filter(function (block) {
        return block.name.toLowerCase().includes(_this3.renderSearch);
      });
    },
    renderOrder: function renderOrder() {
      return this.renderingGroups.map(function (block) {
        return block.id;
      }).join(',');
    }
  },
  methods: {
    addItem: function addItem(id) {
      var item = this.blockList.find(function (el) {
        return el.id === id;
      });

      if (!item) {
        return;
      }

      this.blockList = this.blockList.filter(function (el) {
        return el.id !== id;
      });
      this.renderingDragGroup = [].concat(Appvue_type_script_lang_js_toConsumableArray(this.renderingGroups), [item]);
    },
    removeItem: function removeItem(id) {
      var item = this.renderingGroups.find(function (el) {
        return el.id === id;
      });

      if (!item) {
        return;
      }

      this.renderingGroups = this.renderingGroups.filter(function (el) {
        return el.id !== id;
      });
      this.blockDragList = [].concat(Appvue_type_script_lang_js_toConsumableArray(this.blockList), [item]);
    },
    editBlock: function editBlock(id, title) {
      changeTab("group-".concat(id), title);
    },
    startDragging: function startDragging() {
      this.isDragging = true;
    },
    endDragging: function endDragging() {
      this.isDragging = false;
    },
    disableDragging: function disableDragging() {
      this.canDrag = false;
    },
    enableDragging: function enableDragging() {
      this.canDrag = true;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/App.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_page_edit_Appvue_type_script_lang_js_ = (page_edit_Appvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/App.vue





/* normalize component */

var page_edit_App_component = Object(componentNormalizer["default"])(
  components_page_edit_Appvue_type_script_lang_js_,
  Appvue_type_template_id_146287be_render,
  Appvue_type_template_id_146287be_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var page_edit_App_api; }
page_edit_App_component.options.__file = "resources/assets/js/src/components/page-edit/App.vue"
/* harmony default export */ var page_edit_App = (page_edit_App_component.exports);
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/index.js



vue_default.a.config.productionTip = false;
vue_default.a.component('draggable', vuedraggable_common_default.a);
function PageEdit() {
  var pageEdit = document.querySelector('.js-page-edit');

  if (!pageEdit) {
    return;
  }

  return new vue_default.a({
    render: function render(h) {
      return h(page_edit_App);
    }
  }).$mount(pageEdit);
}
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/cropper/App.vue?vue&type=template&id=2454e87a&
var Appvue_type_template_id_2454e87a_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.image
    ? _c("cropper-editor", {
        attrs: {
          image: _vm.image,
          "use-rotator": _vm.useRotator,
          ratio: _vm.ratio
        },
        on: { crop: _vm.cropImage }
      })
    : _vm._e()
}
var Appvue_type_template_id_2454e87a_staticRenderFns = []
Appvue_type_template_id_2454e87a_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/App.vue?vue&type=template&id=2454e87a&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/cropper/components/Cropper.vue?vue&type=template&id=761e1e22&
var Croppervue_type_template_id_761e1e22_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "c-cropper" }, [
    _c("div", { staticClass: "c-cropper__container" }, [
      _c("img", { ref: "img", attrs: { src: _vm.image.path } })
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "c-cropper__toolbar" }, [
      _c("div", { staticClass: "c-cropper__tool-group" }, [
        _c(
          "button",
          {
            staticClass: "o-btn o-btn--sm",
            on: {
              click: function($event) {
                return _vm.cancel($event)
              }
            }
          },
          [_vm._v("cancel")]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "c-cropper__tool-group" }, [
        _c(
          "button",
          {
            staticClass: "c-cropper__btn",
            on: {
              click: function($event) {
                return _vm.rotateNeg45($event)
              }
            }
          },
          [
            _c("div", { staticClass: "c-cropper__icon" }, [
              _c("svg", [
                _c("use", {
                  attrs: {
                    "xlink:href": "/argon/images/svgicons.svg#rotate-alt"
                  }
                })
              ])
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "c-cropper__btn",
            on: {
              click: function($event) {
                return _vm.rotate45($event)
              }
            }
          },
          [
            _c("div", { staticClass: "c-cropper__icon" }, [
              _c("svg", [
                _c("use", {
                  attrs: { "xlink:href": "/argon/images/svgicons.svg#rotate" }
                })
              ])
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "c-cropper__btn",
            on: {
              click: function($event) {
                return _vm.mirrorHorizontal($event)
              }
            }
          },
          [
            _c("div", { staticClass: "c-cropper__icon" }, [
              _c("svg", [
                _c("use", {
                  attrs: { "xlink:href": "/argon/images/svgicons.svg#flip" }
                })
              ])
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "c-cropper__btn",
            on: {
              click: function($event) {
                return _vm.mirrorVertical($event)
              }
            }
          },
          [
            _c("div", { staticClass: "c-cropper__icon" }, [
              _c("svg", [
                _c("use", {
                  attrs: { "xlink:href": "/argon/images/svgicons.svg#flip-alt" }
                })
              ])
            ])
          ]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "c-cropper__tool-group" }, [
        _c(
          "button",
          {
            staticClass: "c-cropper__btn",
            on: {
              click: function($event) {
                return _vm.zoomIn($event)
              }
            }
          },
          [
            _c("div", { staticClass: "c-cropper__icon" }, [
              _c("svg", [
                _c("use", {
                  attrs: { "xlink:href": "/argon/images/svgicons.svg#zoom-in" }
                })
              ])
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "c-cropper__btn",
            on: {
              click: function($event) {
                return _vm.zoomOut($event)
              }
            }
          },
          [
            _c("div", { staticClass: "c-cropper__icon" }, [
              _c("svg", [
                _c("use", {
                  attrs: { "xlink:href": "/argon/images/svgicons.svg#zoom-out" }
                })
              ])
            ])
          ]
        )
      ]),
      _vm._v(" "),
      _vm.useRotator
        ? _c(
            "div",
            {
              staticClass: "c-cropper__tool-group c-cropper__tool-group--center"
            },
            [
              _c("rotater-input", {
                model: {
                  value: _vm.rotation,
                  callback: function($$v) {
                    _vm.rotation = $$v
                  },
                  expression: "rotation"
                }
              })
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "c-cropper__tool-group c-cropper__tool-group--end",
          on: {
            click: function($event) {
              return _vm.crop($event)
            }
          }
        },
        [
          _c("button", { staticClass: "o-btn o-btn--sm o-btn--success" }, [
            _vm._v("done")
          ])
        ]
      )
    ]),
    _vm._v(" "),
    _c("pre", [_vm._v(_vm._s(_vm.image))])
  ])
}
var Croppervue_type_template_id_761e1e22_staticRenderFns = []
Croppervue_type_template_id_761e1e22_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/components/Cropper.vue?vue&type=template&id=761e1e22&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/cropper/components/range-rotater.vue?vue&type=template&id=113800dc&
var range_rotatervue_type_template_id_113800dc_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "c-cropper__range-rotate" }, [
    _c("div", {
      ref: "handle",
      staticClass: "c-cropper__range-handle",
      style: { transform: "translateX(" + (_vm.handlePos - _vm.offset) + "px)" }
    }),
    _vm._v(" "),
    _c("div", { ref: "line", staticClass: "c-cropper__range-line" })
  ])
}
var range_rotatervue_type_template_id_113800dc_staticRenderFns = []
range_rotatervue_type_template_id_113800dc_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/components/range-rotater.vue?vue&type=template&id=113800dc&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/cropper/components/range-rotater.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//


/* harmony default export */ var range_rotatervue_type_script_lang_js_ = ({
  props: ['value'],
  data: function data() {
    return {
      handleStartPos: 0,
      handlePos: 0,
      offset: 19,
      max: 90,
      min: -90,
      moveRotation: 0,
      currentRotation: 0,
      oneDegreeToPixel: 0
    };
  },
  watch: {
    value: function value(_value) {
      this.updateValue(_value);
    }
  },
  mounted: function mounted() {
    var _this = this;

    this.updateValue(this.value);
    this.handleStartPos = this.$refs.line.offsetWidth / 2;
    this.handlePos = this.handleStartPos;
    this.oneDegreeToPixel = this.$refs.line.offsetWidth / 180;
    var down = Object(_esm5["fromEvent"])(this.$refs.handle, 'mousedown');
    var move = Object(_esm5["fromEvent"])(document, 'mousemove');
    var up = Object(_esm5["fromEvent"])(document, 'mouseup');
    down.pipe(Object(operators["mergeMap"])(function (downEvent) {
      var startPos = range_rotatervue_type_script_lang_js_getPositionFromEvent(downEvent);
      return move.pipe(Object(operators["map"])(function (moveEvent) {
        moveEvent.preventDefault();
        var movePos = range_rotatervue_type_script_lang_js_getPositionFromEvent(moveEvent);
        return {
          x: movePos.x - startPos.x
        };
      }), Object(operators["takeUntil"])(up));
    })).subscribe(function (_ref) {
      var x = _ref.x;
      _this.moveRotation = x;
      var moveChange = _this.currentRotation + _this.moveRotation;
      moveChange = Math.max(Math.min(moveChange, _this.max * _this.oneDegreeToPixel), _this.min * _this.oneDegreeToPixel);

      _this.updateRotation(moveChange);
    });
    up.subscribe(function () {
      _this.currentRotation += _this.moveRotation;
      _this.currentRotation = Math.max(Math.min(_this.currentRotation, _this.max * _this.oneDegreeToPixel), _this.min * _this.oneDegreeToPixel);
    });
  },
  methods: {
    updateRotation: function updateRotation(value) {
      var rotation = value / this.oneDegreeToPixel;
      rotation = Math.max(Math.min(rotation, this.max), this.min);
      this.handlePos = this.handleStartPos + value;
      this.$emit('input', rotation);
    },
    updateValue: function updateValue(value) {
      var rotation = Math.max(Math.min(value, this.max), this.min);
      var posMove = rotation * this.oneDegreeToPixel;
      this.handlePos = this.handleStartPos + posMove;
    }
  }
});

function range_rotatervue_type_script_lang_js_getPositionFromEvent(evt) {
  if (evt.touches) {
    evt = evt.touches[0];
  }

  return {
    x: evt.clientX
  };
}
// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/components/range-rotater.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_range_rotatervue_type_script_lang_js_ = (range_rotatervue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/components/range-rotater.vue





/* normalize component */

var range_rotater_component = Object(componentNormalizer["default"])(
  components_range_rotatervue_type_script_lang_js_,
  range_rotatervue_type_template_id_113800dc_render,
  range_rotatervue_type_template_id_113800dc_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var range_rotater_api; }
range_rotater_component.options.__file = "resources/assets/js/src/components/cropper/components/range-rotater.vue"
/* harmony default export */ var range_rotater = (range_rotater_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/cropper/components/Cropper.vue?vue&type=script&lang=js&
function Croppervue_type_script_lang_js_extends() { Croppervue_type_script_lang_js_extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return Croppervue_type_script_lang_js_extends.apply(this, arguments); }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var Croppervue_type_script_lang_js_ = ({
  props: ['image', 'useRotator', 'ratio'],
  components: {
    'rotater-input': range_rotater
  },
  data: function data() {
    return {
      cropper: null,
      rotationValue: 0,
      defaultOptions: {
        background: false,
        dragMode: 'move'
      }
    };
  },
  mounted: function mounted() {
    var _this = this;

    this.cropper = new cropper_default.a(this.$refs.img, this.options);
    this.$refs.img.addEventListener('ready', function () {
      _this.cropper.zoomTo(1);
    });
  },
  computed: {
    options: function options() {
      var ratio = NaN;

      if (this.ratio) {
        ratio = this.ratio.split(':');
        ratio = ratio[0] / ratio[1];
      }

      var customOptions = {
        aspectRatio: ratio
      };
      return Croppervue_type_script_lang_js_extends(this.defaultOptions, customOptions);
    },
    rotation: {
      get: function get() {
        return this.rotationValue;
      },
      set: function set(value) {
        this.rotationValue = Math.max(Math.min(value, 90), -90);
        this.cropper.rotateTo(this.rotationValue);
      }
    }
  },
  methods: {
    zoomIn: function zoomIn(evt) {
      evt.preventDefault();
      this.cropper.zoom(0.1);
    },
    zoomOut: function zoomOut(evt) {
      evt.preventDefault();
      this.cropper.zoom(-0.1);
    },
    crop: function crop(evt) {
      this.$emit('crop', this.cropper.getCroppedCanvas().toDataURL());
    },
    cancel: function cancel(evt) {
      this.$emit('crop');
    },
    rotateNeg45: function rotateNeg45() {
      this.rotation = this.rotation - 45;
    },
    rotate45: function rotate45() {
      this.rotation = this.rotation + 45;
    },
    mirrorHorizontal: function mirrorHorizontal() {
      if (this.cropper.imageData.scaleY === -1) {
        this.cropper.scaleY(1);
      } else {
        this.cropper.scaleY(-1);
      }
    },
    mirrorVertical: function mirrorVertical() {
      if (this.cropper.imageData.scaleX === -1) {
        this.cropper.scaleX(1);
      } else {
        this.cropper.scaleX(-1);
      }
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/components/Cropper.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Croppervue_type_script_lang_js_ = (Croppervue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/components/Cropper.vue





/* normalize component */

var Cropper_component = Object(componentNormalizer["default"])(
  components_Croppervue_type_script_lang_js_,
  Croppervue_type_template_id_761e1e22_render,
  Croppervue_type_template_id_761e1e22_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Cropper_api; }
Cropper_component.options.__file = "resources/assets/js/src/components/cropper/components/Cropper.vue"
/* harmony default export */ var Cropper = (Cropper_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/cropper/App.vue?vue&type=script&lang=js&
//
//
//
//


/* harmony default export */ var cropper_Appvue_type_script_lang_js_ = ({
  components: {
    'cropper-editor': Cropper
  },
  data: function data() {
    return {
      image: false,
      useRotator: true,
      ratio: false
    };
  },
  mounted: function mounted() {
    var _this = this;

    this.$root.$on('setOptions', function (options) {
      if (!options.hasOwnProperty('image')) {
        new noty_default.a({
          layout: 'topCenter',
          text: 'No Image was passed to the cropper!',
          type: 'error',
          timeout: 3500
        }).show();
        return;
      }

      _this.image = options.image;

      if (options.hasOwnProperty('rotator')) {
        _this.useRotator = options.rotator;
      }

      if (options.hasOwnProperty('ratio')) {
        _this.ratio = options.ratio;
      }
    });
  },
  methods: {
    cropImage: function cropImage(croppedImage) {
      this.$root.$emit('cropImage', croppedImage);
      this.image = false;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/App.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_cropper_Appvue_type_script_lang_js_ = (cropper_Appvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/App.vue





/* normalize component */

var cropper_App_component = Object(componentNormalizer["default"])(
  components_cropper_Appvue_type_script_lang_js_,
  Appvue_type_template_id_2454e87a_render,
  Appvue_type_template_id_2454e87a_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var cropper_App_api; }
cropper_App_component.options.__file = "resources/assets/js/src/components/cropper/App.vue"
/* harmony default export */ var cropper_App = (cropper_App_component.exports);
// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/index.js


var components_cropper_cropper;
function cropper_Cropper() {
  var cropperEl = document.createElement('div');
  cropperEl.classList.add('.c-cropper__wrapper');
  document.body.appendChild(cropperEl);
  components_cropper_cropper = new vue_default.a({
    render: function render(h) {
      return h(cropper_App);
    }
  }).$mount(cropperEl);
}
function setCropperImage(options) {
  return new Promise(function (resolve) {
    components_cropper_cropper.$emit('setOptions', options);
    components_cropper_cropper.$on('cropImage', resolve);
  });
}
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/site-tree/App.vue?vue&type=template&id=8c54b0cc&
var Appvue_type_template_id_8c54b0cc_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass:
        "o-table o-table--tree o-table--tree-2 l-full c-sitetree-overlay__container"
    },
    [
      _vm._m(0),
      _vm._v(" "),
      _vm._l(_vm.rootNodes, function(rootNode, index) {
        return _c(
          "root-row",
          { key: index, attrs: { node: rootNode } },
          [
            rootNode.children.length
              ? _c("tree", {
                  ref: "tree",
                  refInFor: true,
                  on: { drop: _vm.drop, toggle: _vm.toggle },
                  scopedSlots: _vm._u(
                    [
                      {
                        key: "toggle",
                        fn: function(ref) {
                          var node = ref.node
                          return [
                            node.children && node.children.length
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "o-table__child-btn o-table__child-btn--tree",
                                    class: { "is-active": node.isExpanded }
                                  },
                                  [
                                    _c("svg", [
                                      _c("use", {
                                        attrs: {
                                          "xlink:href":
                                            "/argon/images/svgicons.svg#select"
                                        }
                                      })
                                    ])
                                  ]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            !node.children || !node.children.length
                              ? _c("div")
                              : _vm._e()
                          ]
                        }
                      },
                      {
                        key: "title",
                        fn: function(ref) {
                          var node = ref.node
                          return [
                            _c("row", {
                              attrs: {
                                node: node,
                                "tree-index": index,
                                "is-highlight":
                                  _vm.highlightedNodes[node.pathStr],
                                "is-error": _vm.errorNodes[node.pathStr]
                              }
                            })
                          ]
                        }
                      }
                    ],
                    null,
                    true
                  ),
                  model: {
                    value: rootNode.children,
                    callback: function($$v) {
                      _vm.$set(rootNode, "children", $$v)
                    },
                    expression: "rootNode.children"
                  }
                })
              : _vm._e()
          ],
          1
        )
      }),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "c-sitetree-overlay",
          class: { "is-active": _vm.overlayActive }
        },
        [
          _c("div", { staticClass: "c-sitetree-overlay__message typography" }, [
            _c("h1", [_vm._v("Please wait")]),
            _vm._v(" "),
            _c("p", { attrs: { "v:if": "overlayText" } }, [
              _vm._v(_vm._s(_vm.overlayText))
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "c-sitetree-overlay__spinner" }, [
            _c(
              "svg",
              {
                attrs: {
                  xmlns: "http://www.w3.org/2000/svg",
                  width: "64",
                  height: "64",
                  viewBox: "0 0 64 64"
                }
              },
              [
                _c(
                  "g",
                  {
                    attrs: {
                      "stroke-linecap": "square",
                      "stroke-width": "2",
                      fill: "none",
                      stroke: "currentColor",
                      "stroke-miterlimit": "10"
                    }
                  },
                  [
                    _c("circle", {
                      attrs: { cx: "32", cy: "32", r: "30", opacity: ".4" }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d: "M32 2a30 30 0 0 1 30 30",
                        "data-color": "color-2",
                        "stroke-linecap": "butt"
                      }
                    })
                  ]
                )
              ]
            )
          ])
        ]
      ),
      _vm._v(" "),
      _c("ConfirmModal", { attrs: { options: _vm.confirmOptions } })
    ],
    2
  )
}
var Appvue_type_template_id_8c54b0cc_staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "o-table__headers" }, [
      _c("div", { staticClass: "o-table__header" }, [_vm._v("Title")]),
      _vm._v(" "),
      _c("div", { staticClass: "o-table__header o-table--center" }, [
        _vm._v("Status")
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "o-table__header" }, [_vm._v("Actions")]),
      _vm._v(" "),
      _c("div", { staticClass: "o-table__header" })
    ])
  }
]
Appvue_type_template_id_8c54b0cc_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/App.vue?vue&type=template&id=8c54b0cc&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/site-tree/components/RootRow.vue?vue&type=template&id=5870ccf6&
var RootRowvue_type_template_id_5870ccf6_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-table__row" },
    [
      _vm.node.children.length
        ? _c(
            "button",
            {
              staticClass: "o-table__child-btn",
              class: { "is-active": _vm.isOpen },
              on: { click: _vm.toggleOpen }
            },
            [
              _c("svg", [
                _c("use", {
                  attrs: { "xlink:href": "/argon/images/svgicons.svg#select" }
                })
              ])
            ]
          )
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "o-table__data", on: { dblclick: _vm.edit } }, [
        _vm._v(_vm._s(_vm.node.title))
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "o-table__data o-table--center" }, [
        _c("div", {
          staticClass: "o-status",
          class: {
            "o-status--active": _vm.node.data.status,
            "o-status--inactive": !_vm.node.data.status
          }
        })
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "o-table__data o-table--end" },
        [
          _c("comfirm-btn", {
            attrs: {
              hideDuplicate: true,
              showAdd: true,
              showView: true,
              viewUrl: _vm.viewUrl,
              "fade-delete": _vm.preventDelete,
              tooltipPostfix: " Page",
              extraActions: _vm.node.data.extraActions
            },
            on: {
              add: _vm.toggleAddForm,
              delete: _vm.deleteItem,
              view: _vm.viewError
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "o-table__data" }, [
        _c(
          "a",
          { staticClass: "o-btn o-btn--xs", attrs: { href: _vm.editUrl } },
          [_vm._v("Edit")]
        )
      ]),
      _vm._v(" "),
      _vm.addFormOpen
        ? _c("add-form", {
            attrs: { "input-name": _vm.node.data.id },
            on: { add: _vm.addItem }
          })
        : _vm._e(),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "o-table__children" },
        [_vm.isOpen ? _vm._t("default") : _vm._e()],
        2
      )
    ],
    1
  )
}
var RootRowvue_type_template_id_5870ccf6_staticRenderFns = []
RootRowvue_type_template_id_5870ccf6_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/components/RootRow.vue?vue&type=template&id=5870ccf6&

// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/util/bus.js

var Bus = new vue_default.a();
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/site-tree/mixins/row.vue?vue&type=script&lang=js&



/* harmony default export */ var rowvue_type_script_lang_js_ = ({
  mounted: function mounted() {
    Bus.$on('closeAddForm', this.closeAddForm.bind(this));
  },
  methods: {
    toggleAddForm: function toggleAddForm() {
      this.addFormOpen = !this.addFormOpen;
    },
    addItem: function addItem(typeid) {
      window.location.href = argon.root() + '/pages/' + this.node.data.id + '/addchild/' + typeid;
    },
    duplicateItem: function duplicateItem() {
      var _this = this;

      var app = this.$root.$children[0];
      app.overlayText = 'We are cloning your page';
      app.overlayActive = true;
      var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      var pageName = this.node.title;
      post(argon.root() + '/pages/' + this.node.data.id + '/clone', {
        _token: token,
        _method: 'POST'
      }).then(function (data) {
        return JSON.parse(data);
      }).then(function (data) {
        if (data.success && data.entity) {
          new noty_default.a({
            layout: 'topCenter',
            text: 'Successfully cloned page ' + pageName,
            type: 'success',
            timeout: 3500
          }).show();
          var tree = app.$refs.tree[0];
          tree.insert({
            node: _this.node,
            placement: 'after'
          }, data.entity);
          var newPath = _this.node.path;
          newPath[newPath.length - 1] += 1;

          _this.$nextTick(function () {
            app.highlightNode(newPath, true);
          });
        } else {
          new noty_default.a({
            layout: 'topCenter',
            text: 'An error occured when cloning: ' + pageName,
            type: 'error',
            timeout: 3500
          }).show();
        }

        _this.$nextTick(function () {
          app.overlayActive = false;
        });
      }).catch(function (error) {
        return console.log(error);
      });
    },
    deleteItem: function deleteItem() {
      var _this2 = this;

      if (this.preventDelete) {
        if (typeof this.node.level === 'undefined') {
          new noty_default.a({
            layout: 'topCenter',
            text: "You can't delete the home page",
            type: 'error',
            timeout: 3500
          }).show();
        } else {
          new noty_default.a({
            layout: 'topCenter',
            text: "Before you delete this page, move or remove it's child pages",
            type: 'error',
            timeout: 3500
          }).show();
        }

        return;
      }

      var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      var pageName = this.node.title;

      if (confirm('Are you sure you want to delete this page?')) {
        post(argon.root() + '/pages/' + this.node.data.id, {
          _token: token,
          _method: 'DELETE'
        }).then(function (data) {
          return JSON.parse(data);
        }).then(function (data) {
          if (data.success) {
            new noty_default.a({
              layout: 'topCenter',
              text: 'Successfully removed ' + pageName,
              type: 'success',
              timeout: 3500
            }).show();

            _this2.$root.$children[0].removeNode(_this2.treeIndex, _this2.node.path);
          } else {
            new noty_default.a({
              layout: 'topCenter',
              text: 'An error occured removing: ' + pageName,
              type: 'error',
              timeout: 3500
            }).show();
          }
        }).catch(function (error) {
          return console.log(error);
        });
      }
    },
    viewError: function viewError() {
      new noty_default.a({
        layout: 'topCenter',
        text: "The Page needs to be published before you can view it",
        type: 'error',
        timeout: 3500
      }).show();
    },
    edit: function edit() {
      window.location.href = this.editUrl;
    },
    closeAddForm: function closeAddForm() {
      this.addFormOpen = false;
    }
  },
  computed: {
    viewUrl: function viewUrl() {
      if (this.node.data.status) {
        return argon.root() + '/pages/' + this.node.data.id + '/preview';
      }
    },
    preventDelete: function preventDelete() {
      return this.node.children.length || !this.node.level;
    },
    editUrl: function editUrl() {
      return argon.root() + '/pages/' + this.node.data.id + '/edit';
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/mixins/row.vue?vue&type=script&lang=js&
 /* harmony default export */ var mixins_rowvue_type_script_lang_js_ = (rowvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/mixins/row.vue
var row_render, row_staticRenderFns




/* normalize component */

var row_component = Object(componentNormalizer["default"])(
  mixins_rowvue_type_script_lang_js_,
  row_render,
  row_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var row_api; }
row_component.options.__file = "resources/assets/js/src/components/site-tree/mixins/row.vue"
/* harmony default export */ var mixins_row = (row_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/site-tree/components/addForm.vue?vue&type=template&id=e8222bfa&
var addFormvue_type_template_id_e8222bfa_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "o-table__dropdown is-active" }, [
    _c("div", { staticClass: "o-table__dropdown-wrap" }, [
      _c("div", { staticClass: "o-form" }, [
        _c("div", { staticClass: "o-form__inline choices--page-list" }, [
          _c("label", { attrs: { for: "add" + _vm.inputName } }, [
            _vm._v("Page Type")
          ]),
          _vm._v(" "),
          _c(
            "select",
            { attrs: { id: "add" + _vm.inputName } },
            _vm._l(_vm.options, function(option, index) {
              return _c(
                "option",
                { key: index, domProps: { value: option.id } },
                [_vm._v(_vm._s(option.name))]
              )
            }),
            0
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "o-btn o-btn--xs",
              on: {
                click: function($event) {
                  return _vm.add($event)
                }
              }
            },
            [_vm._v("Add")]
          )
        ])
      ])
    ])
  ])
}
var addFormvue_type_template_id_e8222bfa_staticRenderFns = []
addFormvue_type_template_id_e8222bfa_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/components/addForm.vue?vue&type=template&id=e8222bfa&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/site-tree/components/addForm.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var addFormvue_type_script_lang_js_ = ({
  props: ['inputName'],
  data: function data() {
    return {
      options: [],
      selectedOption: null,
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
  created: function created() {
    this.options = window.types;
  },
  mounted: function mounted() {
    var select = this.$el.querySelector('select');
    this.selectElement = select;
    this.selectInstance = new choices_min_default.a(select, this.choicesOptions);
    this.selectInstance.setValueByChoice(this.value);
    this.selectElement.addEventListener('change', this.selectChange.bind(this));
    this.selectedOption = this.selectInstance.getValue(true);
  },
  destroyed: function destroyed() {
    this.selectElement.removeEventListener('change', this.selectChange.bind(this));
  },
  methods: {
    selectChange: function selectChange() {
      this.selectedOption = this.selectInstance.getValue(true);
    },
    add: function add(evt) {
      evt.preventDefault();
      this.$emit('add', this.selectedOption);
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/components/addForm.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_addFormvue_type_script_lang_js_ = (addFormvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/components/addForm.vue





/* normalize component */

var addForm_component = Object(componentNormalizer["default"])(
  components_addFormvue_type_script_lang_js_,
  addFormvue_type_template_id_e8222bfa_render,
  addFormvue_type_template_id_e8222bfa_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var addForm_api; }
addForm_component.options.__file = "resources/assets/js/src/components/site-tree/components/addForm.vue"
/* harmony default export */ var addForm = (addForm_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/site-tree/components/RootRow.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ var RootRowvue_type_script_lang_js_ = ({
  name: 'root-row',
  props: ['node'],
  components: {
    ComfirmBtn: confirm_btn,
    AddForm: addForm
  },
  mixins: [mixins_row],
  data: function data() {
    return {
      isOpen: true,
      addFormOpen: false
    };
  },
  methods: {
    toggleOpen: function toggleOpen() {
      this.isOpen = !this.isOpen;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/components/RootRow.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_RootRowvue_type_script_lang_js_ = (RootRowvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/components/RootRow.vue





/* normalize component */

var RootRow_component = Object(componentNormalizer["default"])(
  components_RootRowvue_type_script_lang_js_,
  RootRowvue_type_template_id_5870ccf6_render,
  RootRowvue_type_template_id_5870ccf6_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var RootRow_api; }
RootRow_component.options.__file = "resources/assets/js/src/components/site-tree/components/RootRow.vue"
/* harmony default export */ var RootRow = (RootRow_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/site-tree/components/Row.vue?vue&type=template&id=6f236b38&
var Rowvue_type_template_id_6f236b38_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "o-table__row",
      class: {
        "o-table__row--children": _vm.node.children.length,
        "is-highlighted": _vm.isHighlight,
        "is-error": _vm.isError
      },
      on: { mouseover: _vm.mouseOver, mouseout: _vm.mouseOut }
    },
    [
      _c("div", { staticClass: "o-table__data", on: { dblclick: _vm.edit } }, [
        _vm._v(_vm._s(_vm.node.title))
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "o-table__data o-table--center" }, [
        _c("div", {
          staticClass: "o-status",
          class: {
            "o-status--active": _vm.node.data.status,
            "o-status--inactive": !_vm.node.data.status
          }
        })
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "o-table__data o-table--end" },
        [
          _c("comfirm-btn", {
            attrs: {
              hideDuplicate: false,
              showAdd: true,
              showView: true,
              viewUrl: _vm.viewUrl,
              "fade-delete": _vm.preventDelete,
              tooltipPostfix: " Page",
              extraActions: _vm.node.data.extraActions
            },
            on: {
              add: _vm.toggleAddForm,
              delete: _vm.deleteItem,
              duplicate: _vm.duplicateItem,
              view: _vm.viewError
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "o-table__data" }, [
        _c(
          "a",
          { staticClass: "o-btn o-btn--xs", attrs: { href: _vm.editUrl } },
          [_vm._v("Edit")]
        )
      ]),
      _vm._v(" "),
      _vm.addFormOpen
        ? _c("add-form", {
            attrs: { "input-name": _vm.node.data.id },
            on: { add: _vm.addItem }
          })
        : _vm._e()
    ],
    1
  )
}
var Rowvue_type_template_id_6f236b38_staticRenderFns = []
Rowvue_type_template_id_6f236b38_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/components/Row.vue?vue&type=template&id=6f236b38&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/site-tree/components/Row.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var Rowvue_type_script_lang_js_ = ({
  name: 'Row',
  props: ['node', 'treeIndex', 'isDragging', 'isError', 'isHighlight'],
  components: {
    ComfirmBtn: confirm_btn,
    AddForm: addForm
  },
  data: function data() {
    return {
      addFormOpen: false,
      isHovering: true
    };
  },
  mixins: [mixins_row],
  methods: {
    mouseOver: function mouseOver() {
      var _this = this;

      var dragging = this.$root.$children[0].$refs.tree.reduce(function (acc, tree) {
        if (acc) {
          return acc;
        }

        return tree.isDragging;
      }, false);

      if (!dragging) {
        return;
      }

      if (!this.isHovering) {
        this.isHovering = true;
        Object(main["setTimeout"])(function () {
          if (!_this.node.isExpanded && _this.isHovering) {
            _this.$set(_this.node, 'isExpanded', true);
          }
        }, 300);
      }
    },
    mouseOut: function mouseOut() {
      this.isHovering = false;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/components/Row.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Rowvue_type_script_lang_js_ = (Rowvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/components/Row.vue





/* normalize component */

var Row_component = Object(componentNormalizer["default"])(
  components_Rowvue_type_script_lang_js_,
  Rowvue_type_template_id_6f236b38_render,
  Rowvue_type_template_id_6f236b38_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Row_api; }
Row_component.options.__file = "resources/assets/js/src/components/site-tree/components/Row.vue"
/* harmony default export */ var Row = (Row_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/site-tree/components/confirmModal.vue?vue&type=template&id=8d1f0282&
var confirmModalvue_type_template_id_8d1f0282_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "o-modal__container",
      class: { active: _vm.options.isOpen },
      on: {
        click: function($event) {
          $event.preventDefault()
          return _vm.close($event)
        }
      }
    },
    [
      _c(
        "div",
        {
          staticClass: "o-modal",
          class: { active: _vm.options.isOpen },
          on: {
            click: function($event) {
              $event.stopPropagation()
            }
          }
        },
        [
          _c(
            "div",
            { staticClass: "o-modal__content typography h-text--centre" },
            [
              _c("h1", [_vm._v(_vm._s(_vm.options.title))]),
              _vm._v(" "),
              _c("p", [_vm._v(_vm._s(_vm.options.message))]),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "o-btn o-btn--primary",
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.accept($event)
                    }
                  }
                },
                [_c("span", [_vm._v("Accept")])]
              ),
              _vm._v("\n              \n            "),
              _c(
                "button",
                {
                  staticClass: "o-btn",
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.close($event)
                    }
                  }
                },
                [_c("span", [_vm._v("Close")])]
              )
            ]
          )
        ]
      )
    ]
  )
}
var confirmModalvue_type_template_id_8d1f0282_staticRenderFns = []
confirmModalvue_type_template_id_8d1f0282_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/components/confirmModal.vue?vue&type=template&id=8d1f0282&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/site-tree/components/confirmModal.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ var confirmModalvue_type_script_lang_js_ = ({
  props: ['options'],
  methods: {
    accept: function accept() {
      this.options.res();
    },
    close: function close() {
      this.options.rej();
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/components/confirmModal.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_confirmModalvue_type_script_lang_js_ = (confirmModalvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/components/confirmModal.vue





/* normalize component */

var confirmModal_component = Object(componentNormalizer["default"])(
  components_confirmModalvue_type_script_lang_js_,
  confirmModalvue_type_template_id_8d1f0282_render,
  confirmModalvue_type_template_id_8d1f0282_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var confirmModal_api; }
confirmModal_component.options.__file = "resources/assets/js/src/components/site-tree/components/confirmModal.vue"
/* harmony default export */ var confirmModal = (confirmModal_component.exports);
// EXTERNAL MODULE: ./node_modules/path-browserify/index.js
var path_browserify = __webpack_require__("./node_modules/path-browserify/index.js");

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/site-tree/App.vue?vue&type=script&lang=js&
function site_tree_Appvue_type_script_lang_js_toConsumableArray(arr) { return site_tree_Appvue_type_script_lang_js_arrayWithoutHoles(arr) || site_tree_Appvue_type_script_lang_js_iterableToArray(arr) || site_tree_Appvue_type_script_lang_js_nonIterableSpread(); }

function site_tree_Appvue_type_script_lang_js_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function site_tree_Appvue_type_script_lang_js_arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function Appvue_type_script_lang_js_typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { Appvue_type_script_lang_js_typeof = function _typeof(obj) { return typeof obj; }; } else { Appvue_type_script_lang_js_typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return Appvue_type_script_lang_js_typeof(obj); }

function _toArray(arr) { return _arrayWithHoles(arr) || site_tree_Appvue_type_script_lang_js_iterableToArray(arr) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function site_tree_Appvue_type_script_lang_js_iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//










/* harmony default export */ var site_tree_Appvue_type_script_lang_js_ = ({
  components: {
    RootRow: RootRow,
    Row: Row,
    ConfirmModal: confirmModal
  },
  data: function data() {
    return {
      rootNodes: [],
      highlightedNodes: {},
      errorNodes: {},
      cloneNodes: [],
      isDragging: false,
      overlayText: 'We are moving your page(s)',
      overlayActive: false,
      confirmOptions: {
        isOpen: false,
        title: '',
        message: '',
        rej: function rej(_) {},
        res: function res(_) {}
      }
    };
  },
  created: function created() {
    this.rootNodes = window.sitemap;
    breadthFirstSearch(this.rootNodes, function (childNode) {
      childNode.isExpanded = false;
      childNode.data.isHighlighted = false;
      childNode.data.isError = false;
    });
    this.cloneNodes = JSON.parse(JSON.stringify(this.rootNodes));
    Object(_esm5["fromEvent"])(document, 'click').pipe(Object(operators["filter"])(function (evt) {
      if (evt.target.classList.contains('js-add-btn')) {
        return false;
      }

      var hasParentDropdown = evt.target.closest('.o-table__dropdown-wrap');

      if (!hasParentDropdown) {
        return true;
      }
    })).subscribe(function () {
      Bus.$emit('closeAddForm');
    });
  },
  methods: {
    closeConfirm: function closeConfirm() {
      this.confirmOptions.isOpen = false;
      this.confirmOptions.title = '';
      this.confirmOptions.message = '';

      this.confirmOptions.rej = function (_) {};

      this.confirmOptions.res = function (_) {};
    },
    confirm: function confirm(title, message) {
      var _this = this;

      return new Promise(function (res, rej) {
        _this.confirmOptions.isOpen = true;
        _this.confirmOptions.title = title;
        _this.confirmOptions.message = message;

        _this.confirmOptions.rej = function () {
          rej();

          _this.closeConfirm();
        };

        _this.confirmOptions.res = function () {
          res();

          _this.closeConfirm();
        };
      });
    },
    toggle: function toggle() {
      this.cloneNodes = JSON.parse(JSON.stringify(this.rootNodes));
    },
    drop: function drop(node, position) {
      var _this2 = this;

      this.overlayText = 'We are moving your page(s)';
      this.overlayActive = true;
      var pageId = node[0].data.id;
      var otherId = position.node.data.id;
      var relation = position.placement;
      var newPath = position.node.path;
      var nodePath = node[0].path;
      var posPath = position.node.path;

      if (nodePath.length === posPath.length && nodePath[nodePath.length - 1] < posPath[posPath.length - 1]) {
        newPath[newPath.length - 1] -= 1;
      }

      if (relation === 'inside') {
        newPath.push(0);
      } else if (nodePath.length < posPath.length && nodePath[nodePath.length - 1] < posPath[nodePath.length - 1]) {
        newPath[nodePath.length - 1] -= 1;
      }

      if (relation === 'after') {
        newPath[newPath.length - 1] += 1;
      }

      var isMovingParent = nodePath[nodePath.length - 2] !== posPath[posPath.length - 2];
      var isMovingDepth = nodePath.length !== posPath.length;
      var hasChildren = node[0].children.length;
      var showConfirm = (!isMovingDepth && isMovingParent || isMovingDepth) && hasChildren;

      var commitChange = function commitChange() {
        var pageName = node[0].title;
        var url = '/pages/' + pageId + '/move/' + otherId + '/' + relation;
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        post(argon.root() + url, {
          _token: token,
          _method: 'GET'
        }).then(function (data) {
          return JSON.parse(data);
        }).then(function (data) {
          if (data.success) {
            new noty_default.a({
              layout: 'topCenter',
              text: 'Successfully moved ' + pageName,
              type: 'success',
              timeout: 3500
            }).show();

            _this2.highlightNode(newPath, true);
          } else {
            new noty_default.a({
              layout: 'topCenter',
              text: 'An error occured when moving: ' + pageName,
              type: 'error',
              timeout: 3500
            }).show();
            _this2.rootNodes = _this2.cloneNodes;

            _this2.highlightNode(nodePath, false);
          }

          _this2.$nextTick(function () {
            _this2.overlayActive = false;
            _this2.cloneNodes = JSON.parse(JSON.stringify(_this2.rootNodes));
          });
        }).catch(function (error) {
          return console.log(error);
        });
      };

      if (showConfirm) {
        this.confirm('Warning', 'This change might take a while to complete and is potentially dangerous, do you want to continue?').then(function () {
          commitChange();
        }).catch(function () {
          _this2.rootNodes = _this2.cloneNodes;

          _this2.highlightNode(nodePath, false);

          _this2.$nextTick(function () {
            _this2.overlayActive = false;
            _this2.cloneNodes = JSON.parse(JSON.stringify(_this2.rootNodes));
          });
        });
      } else {
        commitChange();
      }
    },
    removeNode: function removeNode(treeIndex, paths) {
      if (!paths.length) {
        return;
      }

      var transverse = this.rootNodes[treeIndex];

      for (var i = 0; i < paths.length - 1; i++) {
        transverse = transverse.children[paths[i]];
      }

      transverse.children.splice(paths[paths.length - 1], 1);
    },
    highlightNode: function highlightNode(path, isSuccess) {
      var _this3 = this;

      var timeout = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1500;

      var exspandParents = function exspandParents(node, _ref) {
        var _ref2 = _toArray(_ref),
            nextIndex = _ref2[0],
            indexes = _ref2.slice(1);

        if (!indexes.length) {
          return;
        }

        var nextNode = node.children[nextIndex];
        nextNode.isExpanded = true;
        exspandParents(nextNode, indexes, isSuccess);
      };

      var pathName = "[".concat(path, "]");
      this.$nextTick(function () {
        exspandParents(_this3.rootNodes[0], path);

        if (isSuccess) {
          _this3.highlightedNodes[pathName] = true;
        } else {
          _this3.errorNodes[pathName] = true;
        }
      });
      Object(main["setTimeout"])(function () {
        _this3.$nextTick(function () {
          _this3.highlightedNodes[pathName] = false;
          _this3.errorNodes[pathName] = false;
        });
      }, timeout);
    }
  }
});

function breadthFirstSearch(obj, handler) {
  var childrenKey = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'children';
  var reverse = arguments.length > 3 ? arguments[3] : undefined;
  var rootChildren = Array.isArray(obj) ? obj : [obj];
  var stack = rootChildren.map(function (v, i) {
    return {
      item: v,
      index: i
    };
  });

  if (reverse) {
    stack.reverse();
  }

  var _loop = function _loop() {
    var _stack$shift = stack.shift(),
        item = _stack$shift.item,
        index = _stack$shift.index,
        parent = _stack$shift.parent;

    var r = handler(item, index, parent);

    if (r === false) {
      // stop
      return {
        v: void 0
      };
    } else if (r === 'skip children') {
      return "continue";
    } else if (r === 'skip siblings') {
      stack = stack.filter(function (v) {
        return v.parent !== parent;
      });
    }

    if (item.children) {
      var _stack;

      var children = item.children;

      if (reverse) {
        children = children.slice();
        children.reverse();
      }

      var pushStack = children.map(function (v, i) {
        return {
          item: v,
          index: i,
          parent: item
        };
      });

      (_stack = stack).push.apply(_stack, site_tree_Appvue_type_script_lang_js_toConsumableArray(pushStack));
    }
  };

  while (stack.length) {
    var _ret = _loop();

    switch (_ret) {
      case "continue":
        continue;

      default:
        if (Appvue_type_script_lang_js_typeof(_ret) === "object") return _ret.v;
    }
  }
}
// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/App.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_site_tree_Appvue_type_script_lang_js_ = (site_tree_Appvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/App.vue





/* normalize component */

var site_tree_App_component = Object(componentNormalizer["default"])(
  components_site_tree_Appvue_type_script_lang_js_,
  Appvue_type_template_id_8c54b0cc_render,
  Appvue_type_template_id_8c54b0cc_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var site_tree_App_api; }
site_tree_App_component.options.__file = "resources/assets/js/src/components/site-tree/App.vue"
/* harmony default export */ var site_tree_App = (site_tree_App_component.exports);
// EXTERNAL MODULE: ./node_modules/sl-vue-tree/dist/sl-vue-tree.js
var sl_vue_tree = __webpack_require__("./node_modules/sl-vue-tree/dist/sl-vue-tree.js");
var sl_vue_tree_default = /*#__PURE__*/__webpack_require__.n(sl_vue_tree);

// CONCATENATED MODULE: ./resources/assets/js/src/components/site-tree/index.js

 // import { DraggableTree } from 'vue-draggable-nested-tree'


vue_default.a.config.productionTip = false;
vue_default.a.component('tree', sl_vue_tree_default.a);
function SiteTree() {
  var siteTree = document.querySelector('.js-site-tree');

  if (!siteTree) {
    return;
  }

  return new vue_default.a({
    render: function render(h) {
      return h(site_tree_App);
    }
  }).$mount(siteTree);
}
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/menu-edit/App.vue?vue&type=template&id=3b88e6ee&
var Appvue_type_template_id_3b88e6ee_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "o-table o-table--tree o-table--tree-1 l-full" },
    [
      _vm._m(0),
      _vm._v(" "),
      _vm.nodes && _vm.nodes.length
        ? _c("tree", {
            ref: "tree",
            on: { input: _vm.valueChange },
            scopedSlots: _vm._u(
              [
                {
                  key: "toggle",
                  fn: function(ref) {
                    var node = ref.node
                    return [
                      node.children && node.children.length
                        ? _c(
                            "div",
                            {
                              staticClass:
                                "o-table__child-btn o-table__child-btn--tree",
                              class: { "is-active": node && node.isExpanded }
                            },
                            [
                              _c("svg", [
                                _c("use", {
                                  attrs: {
                                    "xlink:href":
                                      "/argon/images/svgicons.svg#select"
                                  }
                                })
                              ])
                            ]
                          )
                        : _vm._e()
                    ]
                  }
                },
                {
                  key: "title",
                  fn: function(ref) {
                    var node = ref.node
                    return [_c("row", { attrs: { node: node } })]
                  }
                }
              ],
              null,
              false,
              149211458
            ),
            model: {
              value: _vm.nodes,
              callback: function($$v) {
                _vm.nodes = $$v
              },
              expression: "nodes"
            }
          })
        : _vm._e()
    ],
    1
  )
}
var Appvue_type_template_id_3b88e6ee_staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "o-table__headers" }, [
      _c("div", { staticClass: "o-table__header" }, [_vm._v("Title")]),
      _vm._v(" "),
      _c("div", { staticClass: "o-table__header" }, [_vm._v("Actions")]),
      _vm._v(" "),
      _c("div", { staticClass: "o-table__header" })
    ])
  }
]
Appvue_type_template_id_3b88e6ee_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/App.vue?vue&type=template&id=3b88e6ee&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/menu-edit/components/Row.vue?vue&type=template&id=2d8d0f64&
var Rowvue_type_template_id_2d8d0f64_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "o-table__row",
      class: { "o-table__row--children": _vm.node.children.length },
      on: { mouseover: _vm.mouseOver, mouseout: _vm.mouseOut }
    },
    [
      _c("div", { staticClass: "o-table__data" }, [
        _vm._v(_vm._s(_vm.node.data.label))
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "o-table__data o-table--end" },
        [
          _c("row-actions", {
            attrs: {
              viewUrl: _vm.viewUrl,
              "fade-delete": _vm.preventDelete,
              tooltipPostfix: " menu item"
            },
            on: { add: _vm.toggleAddForm, delete: _vm.deleteItem }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "o-table__data" }, [
        _c("span", { attrs: { "data-balloon": "Edit menu item" } }, [
          _c(
            "button",
            {
              staticClass: "js-edit-btn o-btn o-btn--xs",
              on: {
                click: function($event) {
                  return _vm.toggleEditForm($event)
                }
              }
            },
            [_vm._v("Edit")]
          )
        ])
      ]),
      _vm._v(" "),
      _vm.addFormOpen
        ? _c("edit-form", { on: { add: _vm.addItem } })
        : _vm._e(),
      _vm._v(" "),
      _vm.editFormOpen
        ? _c("edit-form", {
            attrs: { node: _vm.node },
            on: { edit: _vm.editItem }
          })
        : _vm._e()
    ],
    1
  )
}
var Rowvue_type_template_id_2d8d0f64_staticRenderFns = []
Rowvue_type_template_id_2d8d0f64_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/components/Row.vue?vue&type=template&id=2d8d0f64&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/menu-edit/components/rowActions.vue?vue&type=template&id=d84612ee&
var rowActionsvue_type_template_id_d84612ee_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "o-confirm-btn__container",
      class: {
        "is-active": _vm.confirmDelete,
        "o-confirm-btn--block": _vm.isBlock
      }
    },
    [
      _c("div", { staticClass: "o-confirm-btn__questions" }, [
        _c(
          "button",
          {
            staticClass: "o-confirm-btn",
            class: { "o-confirm-btn--fade": _vm.fadeDelete },
            attrs: {
              "data-balloon": _vm.fadeDelete ? false : "Delete menu item",
              title: "Delete"
            },
            on: {
              click: function($event) {
                return _vm.toggleConfirmDelete($event)
              }
            }
          },
          [
            _c("svg", [
              _c("use", {
                attrs: { "xlink:href": "/argon/images/svgicons.svg#delete" }
              })
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "o-confirm-btn js-add-btn",
            attrs: { "data-balloon": "Add child menu item", title: "Add" },
            on: {
              click: function($event) {
                return _vm.add($event)
              }
            }
          },
          [
            _c("svg", [
              _c("use", {
                attrs: { "xlink:href": "/argon/images/svgicons.svg#add" }
              })
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "a",
          {
            staticClass: "o-confirm-btn",
            class: { "o-confirm-btn--fade": !_vm.viewUrl },
            attrs: {
              href: _vm.viewUrl,
              target: "_blank",
              "data-balloon": "Preview url",
              title: "view"
            }
          },
          [
            _c("svg", [
              _c("use", {
                attrs: { "xlink:href": "/argon/images/svgicons.svg#see" }
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
            on: {
              click: function($event) {
                return _vm.toggleConfirmDelete($event)
              }
            }
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
            on: {
              click: function($event) {
                return _vm.deleteConfirm($event)
              }
            }
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
var rowActionsvue_type_template_id_d84612ee_staticRenderFns = []
rowActionsvue_type_template_id_d84612ee_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/components/rowActions.vue?vue&type=template&id=d84612ee&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/menu-edit/components/rowActions.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ var rowActionsvue_type_script_lang_js_ = ({
  name: 'comfirm-btn',
  props: ['hideDuplicate', 'fadeDelete', 'isBlock', 'showAdd', 'viewUrl', 'showView', 'tooltipPostfix', 'extraAction'],
  data: function data() {
    return {
      confirmDelete: false,
      tooltipPostfixValue: ''
    };
  },
  created: function created() {
    this.tooltipPostfixValue = this.tooltipPostfix || this.tooltipPostfixValue;
  },
  methods: {
    toggleConfirmDelete: function toggleConfirmDelete(evt) {
      evt.preventDefault();

      if (this.fadeDelete) {
        this.$emit('delete');
      } else {
        this.confirmDelete = !this.confirmDelete;
      }
    },
    add: function add(evt) {
      evt.preventDefault();
      this.$emit('add');
    },
    view: function view(evt) {
      if (!this.viewUrl) {
        evt.preventDefault();
        this.$emit('view');
      }
    },
    deleteConfirm: function deleteConfirm(evt) {
      evt.preventDefault();
      this.$emit('delete');
      this.confirmDelete = false;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/components/rowActions.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_rowActionsvue_type_script_lang_js_ = (rowActionsvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/components/rowActions.vue





/* normalize component */

var rowActions_component = Object(componentNormalizer["default"])(
  components_rowActionsvue_type_script_lang_js_,
  rowActionsvue_type_template_id_d84612ee_render,
  rowActionsvue_type_template_id_d84612ee_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var rowActions_api; }
rowActions_component.options.__file = "resources/assets/js/src/components/menu-edit/components/rowActions.vue"
/* harmony default export */ var rowActions = (rowActions_component.exports);
// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/util/bus.js

var bus_Bus = new vue_default.a();
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/menu-edit/mixins/row.vue?vue&type=script&lang=js&



/* harmony default export */ var menu_edit_mixins_rowvue_type_script_lang_js_ = ({
  mounted: function mounted() {
    bus_Bus.$on('closeAddForm', this.closeAddForm.bind(this));
    bus_Bus.$on('closeEditForm', this.closeEditForm.bind(this));
  },
  methods: {
    toggleAddForm: function toggleAddForm() {
      this.addFormOpen = !this.addFormOpen;
    },
    toggleEditForm: function toggleEditForm(evt) {
      evt.preventDefault();
      this.editFormOpen = !this.editFormOpen;
    },
    addItem: function addItem(item) {
      var tree = this.$root.$children[0].$refs.tree;
      tree.insert({
        node: this.node,
        placement: 'inside'
      }, {
        title: item.label,
        data: item
      });
      this.closeAddForm();
    },
    deleteItem: function deleteItem() {
      if (this.preventDelete) {
        new noty_default.a({
          layout: 'topCenter',
          text: "Before you delete this item, move or remove it's child items",
          type: 'error',
          timeout: 3500
        }).show();
        return;
      }

      var tree = this.$root.$children[0].$refs.tree;
      console.log(tree.nodes.length);

      if (tree.nodes.length === 1 && tree.nodes[0].children.length === 0) {
        new noty_default.a({
          layout: 'topCenter',
          text: "You cannot delete the last item in the tree",
          type: 'error',
          timeout: 3500
        }).show();
        return;
      }

      tree.remove([this.node.path]);
    },
    editItem: function editItem(item) {
      var tree = this.$root.$children[0].$refs.tree;
      tree.updateNode(this.node.path, {
        data: item
      });
      this.closeEditForm();
    },
    closeAddForm: function closeAddForm() {
      this.addFormOpen = false;
    },
    closeEditForm: function closeEditForm() {
      this.editFormOpen = false;
    }
  },
  computed: {
    viewUrl: function viewUrl() {
      if (+this.node.data.page) {
        return '/admin/pages/' + this.node.data.page + '/preview';
      } else if (this.node.data.url && this.node.data.url !== '') {
        return this.node.data.url;
      }

      return false;
    },
    preventDelete: function preventDelete() {
      return this.node.children.length || !this.node.level;
    },
    editUrl: function editUrl() {
      return argon.root() + '/pages/' + this.node.data.id + '/edit';
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/mixins/row.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_menu_edit_mixins_rowvue_type_script_lang_js_ = (menu_edit_mixins_rowvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/mixins/row.vue
var mixins_row_render, mixins_row_staticRenderFns




/* normalize component */

var mixins_row_component = Object(componentNormalizer["default"])(
  components_menu_edit_mixins_rowvue_type_script_lang_js_,
  mixins_row_render,
  mixins_row_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var mixins_row_api; }
mixins_row_component.options.__file = "resources/assets/js/src/components/menu-edit/mixins/row.vue"
/* harmony default export */ var menu_edit_mixins_row = (mixins_row_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/menu-edit/components/editForm.vue?vue&type=template&id=459e98b4&
var editFormvue_type_template_id_459e98b4_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "o-table__dropdown is-active",
      class: { "c-menu-edit__add-wrap": !_vm.node }
    },
    [
      !_vm.node
        ? _c("div", { staticClass: "c-menu-edit__tree-gap" })
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "o-table__dropdown-wrap" }, [
        _c("div", { staticClass: "o-form c-menu-edit__form" }, [
          _c("div", { staticClass: "l-halves" }, [
            _c("div", [
              _c("div", { staticClass: "o-form__group" }, [
                _c("label", { attrs: { for: "label" } }, [_vm._v("Label")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.item.label,
                      expression: "item.label"
                    }
                  ],
                  attrs: { type: "text", id: "label", placeholder: "Label" },
                  domProps: { value: _vm.item.label },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.item, "label", $event.target.value)
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "o-form__group" }, [
                _c("label", { attrs: { for: "page" } }, [_vm._v("Page")]),
                _vm._v(" "),
                _c(
                  "select",
                  { attrs: { id: "page" } },
                  [
                    _c("option", { attrs: { value: "0" } }, [
                      _vm._v("-- select page or add custom URL below --")
                    ]),
                    _vm._v(" "),
                    _vm._l(_vm.options, function(option, index) {
                      return _c(
                        "option",
                        {
                          key: index,
                          domProps: {
                            value: index,
                            selected: _vm.item.page == index
                          }
                        },
                        [_vm._v(_vm._s(option))]
                      )
                    })
                  ],
                  2
                )
              ]),
              _vm._v(" "),
              !+this.item.page
                ? _c("div", { staticClass: "o-form__group" }, [
                    _c("label", { attrs: { for: "url" } }, [_vm._v("URL")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.item.url,
                          expression: "item.url"
                        }
                      ],
                      attrs: { type: "text", id: "url", placeholder: "URL" },
                      domProps: { value: _vm.item.url },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.item, "url", $event.target.value)
                        }
                      }
                    })
                  ])
                : _vm._e()
            ]),
            _vm._v(" "),
            _c("div", [
              _c("div", { staticClass: "o-form__group" }, [
                _c("label", { attrs: { for: "class" } }, [_vm._v("Class(es)")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.item.class,
                      expression: "item.class"
                    }
                  ],
                  attrs: {
                    type: "text",
                    id: "class",
                    placeholder: "Class(es)"
                  },
                  domProps: { value: _vm.item.class },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.item, "class", $event.target.value)
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "o-form__group" }, [
                _c("label", { attrs: { for: "id" } }, [_vm._v("ID")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.item.id,
                      expression: "item.id"
                    }
                  ],
                  attrs: { type: "text", id: "id", placeholder: "ID" },
                  domProps: { value: _vm.item.id },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.item, "id", $event.target.value)
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "o-form__group" }, [
                _c("label", { attrs: { for: "target" } }, [_vm._v("Target")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.item.target,
                      expression: "item.target"
                    }
                  ],
                  attrs: { type: "text", id: "target", placeholder: "Target" },
                  domProps: { value: _vm.item.target },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.item, "target", $event.target.value)
                    }
                  }
                })
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "choices--page-list" }, [
            !_vm.node
              ? _c(
                  "button",
                  {
                    staticClass: "o-btn o-btn--xs",
                    class: { "o-btn--primary": _vm.itemChanged },
                    on: {
                      click: function($event) {
                        return _vm.add($event)
                      }
                    }
                  },
                  [_vm._v("Add child")]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.node
              ? _c(
                  "button",
                  {
                    staticClass: "o-btn o-btn--xs",
                    class: { "o-btn--primary": _vm.itemChanged },
                    on: {
                      click: function($event) {
                        return _vm.edit($event)
                      }
                    }
                  },
                  [_vm._v("Save")]
                )
              : _vm._e()
          ])
        ])
      ])
    ]
  )
}
var editFormvue_type_template_id_459e98b4_staticRenderFns = []
editFormvue_type_template_id_459e98b4_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/components/editForm.vue?vue&type=template&id=459e98b4&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/menu-edit/components/editForm.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var editFormvue_type_script_lang_js_ = ({
  props: ['node'],
  data: function data() {
    return {
      item: {
        label: '',
        page: '0',
        url: '',
        class: '',
        id: '',
        target: ''
      },
      initialItem: {},
      options: [],
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
  created: function created() {
    this.options = window.pagesJson;
    this.setInitialItem();
  },
  mounted: function mounted() {
    var select = this.$el.querySelector('select');
    this.selectElement = select;
    this.selectInstance = new choices_min_default.a(select, this.choicesOptions);
    this.selectInstance.setValueByChoice(this.value);
    this.selectElement.addEventListener('change', this.selectChange.bind(this));
    this.selectedOption = this.selectInstance.getValue(true);
    this.setInitialItem();
  },
  destroyed: function destroyed() {
    this.selectElement.removeEventListener('change', this.selectChange.bind(this));
  },
  methods: {
    selectChange: function selectChange() {
      this.item.page = this.selectInstance.getValue(true);
    },
    edit: function edit(evt) {
      evt.preventDefault();
      this.$emit('edit', this.item);
    },
    add: function add(evt) {
      evt.preventDefault();
      this.$emit('add', this.item);
    },
    setInitialItem: function setInitialItem() {
      if (this.node) {
        this.item = this.node.data;
      } else {
        this.item = {
          label: '',
          page: '0',
          url: '',
          class: '',
          id: '',
          target: ''
        };
      }

      this.initialItem = JSON.parse(JSON.stringify(this.item));
    }
  },
  watch: {
    node: function node() {// this.setInitialItem()
    }
  },
  computed: {
    itemChanged: function itemChanged() {
      return JSON.stringify(this.item) != JSON.stringify(this.initialItem);
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/components/editForm.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_editFormvue_type_script_lang_js_ = (editFormvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/components/editForm.vue





/* normalize component */

var editForm_component = Object(componentNormalizer["default"])(
  components_editFormvue_type_script_lang_js_,
  editFormvue_type_template_id_459e98b4_render,
  editFormvue_type_template_id_459e98b4_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var editForm_api; }
editForm_component.options.__file = "resources/assets/js/src/components/menu-edit/components/editForm.vue"
/* harmony default export */ var editForm = (editForm_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/menu-edit/components/Row.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ var menu_edit_components_Rowvue_type_script_lang_js_ = ({
  name: 'Row',
  props: ['node', 'treeIndex', 'isDragging'],
  components: {
    RowActions: rowActions,
    EditForm: editForm
  },
  data: function data() {
    return {
      addFormOpen: false,
      editFormOpen: false,
      isHovering: true
    };
  },
  mixins: [menu_edit_mixins_row],
  methods: {
    mouseOver: function mouseOver() {
      var _this = this;

      var dragging = this.$root.$children[0].$refs.tree.isDragging;

      if (!dragging) {
        return;
      }

      if (!this.isHovering) {
        this.isHovering = true;
        setTimeout(function () {
          if (!_this.node.isExpanded && _this.isHovering) {
            _this.$set(_this.node, 'isExpanded', true);
          }
        }, 300);
      }
    },
    mouseOut: function mouseOut() {
      this.isHovering = false;
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/components/Row.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_menu_edit_components_Rowvue_type_script_lang_js_ = (menu_edit_components_Rowvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/components/Row.vue





/* normalize component */

var components_Row_component = Object(componentNormalizer["default"])(
  components_menu_edit_components_Rowvue_type_script_lang_js_,
  Rowvue_type_template_id_2d8d0f64_render,
  Rowvue_type_template_id_2d8d0f64_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var components_Row_api; }
components_Row_component.options.__file = "resources/assets/js/src/components/menu-edit/components/Row.vue"
/* harmony default export */ var components_Row = (components_Row_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/menu-edit/App.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ var menu_edit_Appvue_type_script_lang_js_ = ({
  components: {
    Row: components_Row
  },
  data: function data() {
    return {
      nodes: [],
      isDragging: false
    };
  },
  created: function created() {
    this.nodes = window.menuJson;
    Object(_esm5["fromEvent"])(document, 'click').pipe(Object(operators["filter"])(function (evt) {
      if (evt.target.classList.contains('js-add-btn')) {
        return false;
      }

      var hasParentDropdown = evt.target.closest('.o-table__dropdown-wrap');

      if (!hasParentDropdown) {
        return true;
      }
    })).subscribe(function () {
      bus_Bus.$emit('closeAddForm');
    });
    Object(_esm5["fromEvent"])(document, 'click').pipe(Object(operators["filter"])(function (evt) {
      if (evt.target.classList.contains('js-edit-btn')) {
        return false;
      }

      var hasParentDropdown = evt.target.closest('.o-table__dropdown-wrap');

      if (!hasParentDropdown) {
        return true;
      }
    })).subscribe(function () {
      bus_Bus.$emit('closeEditForm');
    });
  },
  methods: {
    valueChange: function valueChange(nodes) {
      var menuInputEl = document.querySelector('.js-menu-json');
      menuInputEl.value = JSON.stringify(nodes);
    },
    removeNode: function removeNode(treeIndex, paths) {
      if (!paths.length) {
        return;
      }

      var transverse = this.nodes[treeIndex];

      for (var i = 0; i < paths.length - 1; i++) {
        transverse = transverse.children[paths[i]];
      }

      transverse.children.splice(paths[paths.length - 1], 1);
    },
    mouseOver: function mouseOver(treeIndex) {
      console.log('mouseover');
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/App.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_menu_edit_Appvue_type_script_lang_js_ = (menu_edit_Appvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/App.vue





/* normalize component */

var menu_edit_App_component = Object(componentNormalizer["default"])(
  components_menu_edit_Appvue_type_script_lang_js_,
  Appvue_type_template_id_3b88e6ee_render,
  Appvue_type_template_id_3b88e6ee_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var menu_edit_App_api; }
menu_edit_App_component.options.__file = "resources/assets/js/src/components/menu-edit/App.vue"
/* harmony default export */ var menu_edit_App = (menu_edit_App_component.exports);
// CONCATENATED MODULE: ./resources/assets/js/src/components/menu-edit/index.js

 // import { DraggableTree } from 'vue-draggable-nested-tree'


vue_default.a.config.productionTip = false;
vue_default.a.component('tree', sl_vue_tree_default.a);
function MenuEdit() {
  var menuEdit = document.querySelector('.js-menu-edit');

  if (!menuEdit) {
    return;
  }

  return new vue_default.a({
    render: function render(h) {
      return h(menu_edit_App);
    }
  }).$mount(menuEdit);
}
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/import-field-groups/App.vue?vue&type=template&id=c56b9336&
var Appvue_type_template_id_c56b9336_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "c-actions__container" }, [
    _c(
      "div",
      { staticClass: "c-actions__content c-tab-panel__inner-container l-full" },
      [
        _c(
          "div",
          { staticClass: "o-form" },
          [
            _c("editor"),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "l-halves l-internal-columns c-import-field-groups"
              },
              [_c("local-blocks"), _vm._v(" "), _c("blocks-library")],
              1
            )
          ],
          1
        )
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "c-actions c-actions--no-space" }, [
      _c("div", { staticClass: "c-actions__group" }, [
        _c("input", {
          staticClass: "o-btn o-btn--sm o-btn--primary js-import",
          attrs: { type: "submit", value: "Import" },
          on: {
            click: function($event) {
              $event.preventDefault()
              return _vm.submit($event)
            }
          }
        }),
        _vm._v(" "),
        _c("a", { staticClass: "o-btn o-btn--sm", on: { click: _vm.cancel } }, [
          _vm._v("Cancel")
        ])
      ])
    ])
  ])
}
var Appvue_type_template_id_c56b9336_staticRenderFns = []
Appvue_type_template_id_c56b9336_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/App.vue?vue&type=template&id=c56b9336&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/import-field-groups/components/Editor.vue?vue&type=template&id=023f68ec&
var Editorvue_type_template_id_023f68ec_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "div",
      {
        staticClass: "json-editor-wrapper c-json-editor",
        class: { expanded: _vm.isEditorExpanded }
      },
      [
        _c("div", {
          staticClass:
            "loading-overlay c-json-editor__loading-overlay js-loading-block",
          class: { show: _vm.isLoading }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "editor-tools c-json-editor__editor-tools" }, [
          _c("span", {
            staticClass: "settings fa fa-cog",
            on: { click: _vm.expandConfig }
          }),
          _vm._v(" "),
          _c("span", {
            staticClass: "expand fa fa-expand",
            on: {
              click: function($event) {
                return _vm.expandEditor(true)
              }
            }
          }),
          _vm._v(" "),
          _c("span", {
            staticClass: "collapse fa fa-compress",
            on: {
              click: function($event) {
                return _vm.expandEditor(false)
              }
            }
          })
        ]),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "c-library-tools library-tools js-library-tools",
            class: { show: _vm.selectedBlock }
          },
          [
            _c("span", {
              staticClass:
                "c-library-tools__button c-library-tools__create create fa fa-plus",
              on: { click: _vm.createNewBlock }
            }),
            _vm._v(" "),
            _c("span", {
              staticClass:
                "c-library-tools__button c-library-tools__save save fa fa-save",
              on: { click: _vm.saveBlock }
            }),
            _vm._v(" "),
            _c(
              "span",
              { staticClass: "c-library-tools__button c-library-tools__input" },
              [
                _c("input", {
                  attrs: {
                    type: "text",
                    placeholder: "Block name",
                    name: "lib_block_name"
                  },
                  domProps: {
                    value: _vm.selectedBlock && _vm.selectedBlock.name
                  },
                  on: {
                    keyup: function($event) {
                      return _vm.updateName($event)
                    }
                  }
                })
              ]
            ),
            _vm._v(" "),
            _vm.selectedBlock && _vm.selectedBlock.image
              ? [
                  _c(
                    "label",
                    {
                      staticClass: "js-select-image selected",
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.unselectImage($event)
                        }
                      }
                    },
                    [
                      _c("span", {
                        staticClass:
                          "c-library-tools__button c-library-tools__image image fa fa-image"
                      }),
                      _vm._v(" "),
                      _c("input", {
                        staticStyle: { display: "none" },
                        attrs: { type: "file", name: "lib_block_image_tmp" }
                      }),
                      _vm._v(" "),
                      _c("input", {
                        attrs: { type: "hidden", name: "lib_block_image" },
                        domProps: {
                          value: _vm.selectedBlock && _vm.selectedBlock.image
                        }
                      })
                    ]
                  )
                ]
              : [
                  _c("label", { staticClass: "js-select-image" }, [
                    _c("span", {
                      staticClass:
                        "c-library-tools__button c-library-tools__image image fa fa-image"
                    }),
                    _vm._v(" "),
                    _c("input", {
                      staticStyle: { display: "none" },
                      attrs: { type: "file", name: "lib_block_image_tmp" },
                      on: {
                        change: function($event) {
                          return _vm.selectImage($event)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("input", {
                      attrs: {
                        type: "hidden",
                        name: "lib_block_image",
                        value: ""
                      }
                    })
                  ])
                ],
            _vm._v(" "),
            _c(
              "span",
              {
                staticClass:
                  "c-library-tools__button c-library-tools__toggle toggle toggle-json",
                class: { active: _vm.editorMode === "json" },
                on: {
                  click: function($event) {
                    return _vm.changeMode("json")
                  }
                }
              },
              [_vm._v("json")]
            ),
            _vm._v(" "),
            _c(
              "span",
              {
                staticClass:
                  "c-library-tools__button c-library-tools__toggle toggle toggle-blade",
                class: { active: _vm.editorMode === "blade" },
                on: {
                  click: function($event) {
                    return _vm.changeMode("blade")
                  }
                }
              },
              [_vm._v("blade")]
            ),
            _vm._v(" "),
            _c(
              "span",
              {
                staticClass:
                  "c-library-tools__button c-library-tools__toggle toggle toggle-mappers",
                class: { active: _vm.editorMode === "mappers" },
                on: {
                  click: function($event) {
                    return _vm.changeMode("mappers")
                  }
                }
              },
              [_vm._v("php")]
            ),
            _vm._v(" "),
            _vm.selectedBlock && _vm.selectedBlock.id
              ? [
                  _c("span", {
                    staticClass:
                      "c-library-tools__button c-library-tools__delete delete fa fa-trash",
                    on: { click: _vm.deleteBlock }
                  })
                ]
              : _vm._e(),
            _vm._v(" "),
            _c("span", {
              staticClass:
                "c-library-tools__button c-library-tools__close  js-library-close-block fa fa-close",
              on: { click: _vm.unselectBlock }
            })
          ],
          2
        ),
        _vm._v(" "),
        _c(
          "textarea",
          {
            staticClass: "form-control hidden js-block-lib-data",
            attrs: { id: "json-textarea", name: "json" }
          },
          [_vm._v(_vm._s(_vm.contentJson))]
        ),
        _vm._v(" "),
        _c(
          "textarea",
          {
            staticClass: "form-control hidden js-block-lib-data",
            attrs: { id: "blade-textarea", name: "blade" }
          },
          [_vm._v(_vm._s(_vm.contentBlade))]
        ),
        _vm._v(" "),
        _c(
          "textarea",
          {
            staticClass: "form-control hidden js-block-lib-data",
            attrs: { id: "mappers-textarea", name: "mappers" }
          },
          [_vm._v(_vm._s(_vm.contentMappers))]
        ),
        _vm._v(" "),
        _c("div", {
          staticClass: "c-json-editor__editor",
          attrs: { id: "json-editor" }
        })
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "c-blocks-library__settings-wrapper js-settings-wrapper",
        class: { expanded: _vm.isConfigExpanded }
      },
      [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "o-form__group" }, [
          _c("div", { staticClass: "o-form-status" }, [
            _c("div", { staticClass: "o-form__list" }, [
              _c(
                "div",
                {
                  staticClass: "o-checkbox",
                  on: {
                    click: function($event) {
                      $event.stopPropagation()
                      return _vm.toggleSmartImport($event)
                    }
                  }
                },
                [
                  _c("input", {
                    staticClass: "js-toggle-value",
                    attrs: { type: "hidden", name: "smart_import", value: "0" }
                  }),
                  _vm._v(" "),
                  _c("label", [
                    _c("input", {
                      staticClass: "js-toggle-input",
                      attrs: {
                        type: "checkbox",
                        value: "1",
                        name: "",
                        id: "smart_import"
                      },
                      domProps: { checked: _vm.smartImport }
                    }),
                    _vm._v(" "),
                    _c("span", [
                      _c("svg", [
                        _c("use", {
                          attrs: {
                            "xlink:href": "/argon/images/svgicons.svg#tick"
                          }
                        })
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("label", { attrs: { for: "smart_import" } }, [
                    _vm._v("Smart Import")
                  ])
                ]
              )
            ])
          ]),
          _vm._v(" "),
          _vm._m(1)
        ])
      ]
    )
  ])
}
var Editorvue_type_template_id_023f68ec_staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "typography l-space" }, [
      _c("h3", [_vm._v("Import settings")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "o-form__help-text l-full" }, [
      _c("p", [
        _vm._v(
          "If the fields already exist append number at the end of the field name and carry on with the import"
        )
      ])
    ])
  }
]
Editorvue_type_template_id_023f68ec_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/components/Editor.vue?vue&type=template&id=023f68ec&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/import-field-groups/components/Editor.vue?vue&type=script&lang=js&
function Editorvue_type_script_lang_js_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function Editorvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { Editorvue_type_script_lang_js_ownKeys(source, true).forEach(function (key) { Editorvue_type_script_lang_js_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { Editorvue_type_script_lang_js_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function Editorvue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var Editorvue_type_script_lang_js_ = ({
  name: 'Editor',
  data: function data() {
    return {
      editor: null,
      modes: {}
    };
  },
  mounted: function mounted() {
    this.editor = ace.edit("json-editor");
    this.editor.setTheme("ace/theme/twilight");
    this.modes.json = ace.require("ace/mode/json").Mode;
    this.modes.php = ace.require("ace/mode/php").Mode;
    this.editor.getSession().on('change', this.changeContent);
    this.changeMode('json');
    this.setSmartImport(window.smartImport);
  },
  methods: {
    setMode: function setMode() {
      if (this.editorMode === 'mappers') {
        this.editor.session.setMode(new this.modes.php());
        this.editor.getSession().setValue(this.editorContent.mappers);
      } else if (this.editorMode === 'blade') {
        this.editor.session.setMode(new this.modes.php());
        this.editor.getSession().setValue(this.editorContent.blade);
      } else {
        this.editor.session.setMode(new this.modes.json());
        this.editor.getSession().setValue(this.editorContent.json);
      }
    },
    setSmartImport: function setSmartImport(value) {
      this.$store.commit('setSmartImport', value);
    },
    toggleSmartImport: function toggleSmartImport(event) {
      if (!event.target.classList.contains('js-toggle-input')) {
        return;
      }

      var value = event.target.checked;
      this.$store.commit('setSmartImport', value);
    },
    changeMode: function changeMode(mode) {
      this.$store.commit('changeEditorMode', mode);
    },
    changeContent: function changeContent() {
      var newContent = this.editor.getSession().getValue();

      switch (this.editorMode) {
        case 'blade':
          this.$store.commit('setContentBlade', newContent);
          break;

        case 'mappers':
          this.$store.commit('setContentMappers', newContent);
          break;

        case 'json':
        default:
          this.$store.commit('setContentJson', newContent);
          break;
      }
    },
    expandEditor: function expandEditor(bool) {
      var _this = this;

      this.$store.commit('expandEditor', bool);
      setTimeout(function () {
        return _this.editor.resize();
      }, 100);
    },
    expandConfig: function expandConfig(bool) {
      this.$store.commit('expandConfig', !this.isConfigExpanded);
    },
    updateName: function updateName(evt) {
      this.$store.commit('setBlockName', evt.target.value);
    },
    createNewBlock: function createNewBlock() {
      this.$store.commit('createNewBlock');
    },
    saveBlock: function saveBlock() {
      this.$store.commit('saveBlockToLibrary');
    },
    deleteBlock: function deleteBlock() {
      this.$store.commit('deleteBlockFromLibrary');
    },
    unselectBlock: function unselectBlock() {
      this.changeMode('json');
      this.$store.commit('setSelectedBlock', null);
    },
    unselectImage: function unselectImage() {
      this.$store.commit('setBlockImage', '');
    },
    selectImage: function selectImage(evt) {
      var _this2 = this;

      var file = evt.target.files[0];
      var reader = new FileReader();

      reader.onloadend = function () {
        _this2.$store.commit('setBlockImage', reader.result);
      };

      reader.readAsDataURL(file);
    }
  },
  watch: {
    editorContent: function editorContent() {
      this.setMode();
    },
    editorMode: function editorMode() {
      this.setMode();
    }
  },
  computed: Editorvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])({
    editorMode: 'editorMode',
    editorContent: 'content',
    selectedBlock: 'block',
    isLoading: 'isLoading',
    isEditorExpanded: 'isEditorExpanded',
    isConfigExpanded: 'isConfigExpanded',
    smartImport: 'smartImport'
  }), {
    contentJson: function contentJson() {
      return this.$store.state.content.json;
    },
    contentBlade: function contentBlade() {
      return this.$store.state.content.blade;
    },
    contentMappers: function contentMappers() {
      return this.$store.state.content.mappers;
    }
  })
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/components/Editor.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_Editorvue_type_script_lang_js_ = (Editorvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/components/Editor.vue





/* normalize component */

var Editor_component = Object(componentNormalizer["default"])(
  components_Editorvue_type_script_lang_js_,
  Editorvue_type_template_id_023f68ec_render,
  Editorvue_type_template_id_023f68ec_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var Editor_api; }
Editor_component.options.__file = "resources/assets/js/src/components/import-field-groups/components/Editor.vue"
/* harmony default export */ var Editor = (Editor_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/import-field-groups/components/BlocksLibrary.vue?vue&type=template&id=253a76c8&
var BlocksLibraryvue_type_template_id_253a76c8_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "c-block-list__wrap" }, [
    _vm._m(0),
    _vm._v(" "),
    _c("div", { staticClass: "c-block-list" }, [
      _c("div", { staticClass: "c-block-list__search o-form" }, [
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.search,
              expression: "search"
            }
          ],
          attrs: {
            type: "text",
            id: "search",
            name: "search",
            placeholder: "Search blocks"
          },
          domProps: { value: _vm.search },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.search = $event.target.value
            }
          }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "c-block-list__search-icon" }, [
          _c("svg", [
            _c("use", {
              attrs: { "xlink:href": "/argon/images/svgicons.svg#search" }
            })
          ])
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "c-block-list__container" }, [
        _c(
          "div",
          { staticClass: "c-block-list__inner-list" },
          [
            _vm._l(_vm.filteredBlocks, function(block) {
              return _c("block", { key: block.id, attrs: { block: block } })
            }),
            _vm._v(" "),
            !_vm.filteredBlocks.length
              ? _c(
                  "div",
                  { staticClass: "c-blocks-library__no-blocks-message" },
                  [_vm._v("No blocks found.")]
                )
              : _vm._e()
          ],
          2
        )
      ])
    ])
  ])
}
var BlocksLibraryvue_type_template_id_253a76c8_staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "typography l-space" }, [
      _c("h3", [_vm._v("Blocks Library")]),
      _vm._v(" "),
      _c("p", [_vm._v("Import blocks stored in the cloud.")])
    ])
  }
]
BlocksLibraryvue_type_template_id_253a76c8_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/components/BlocksLibrary.vue?vue&type=template&id=253a76c8&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/import-field-groups/components/Block.vue?vue&type=template&id=375fc400&
var Blockvue_type_template_id_375fc400_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "c-block c-block-library",
      class: { editing: _vm.isEdited },
      attrs: { "data-block-id": _vm.block.id }
    },
    [
      _c("div", { staticClass: "c-block__edit" }, [
        _c(
          "div",
          { staticClass: "c-block__edit-btn", on: { click: _vm.getBlock } },
          [_c("span", [_vm._v("Load block schema")])]
        ),
        _vm._v(" "),
        _c("div", { staticClass: "c-block__image" }, [
          _vm.block.image
            ? _c("img", {
                attrs: { src: _vm.block.image, alt: _vm.block.name }
              })
            : _vm._e(),
          _vm._v(" "),
          !_vm.block.image
            ? _c("div", { staticClass: "c-block__empty-image" }, [
                _c("svg", [
                  _c("use", {
                    attrs: {
                      "xlink:href": "/argon/images/svgicons.svg#file-input"
                    }
                  })
                ])
              ])
            : _vm._e()
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "c-block__title" }, [
          _c("span", [_vm._v(_vm._s(_vm.block.name))])
        ])
      ])
    ]
  )
}
var Blockvue_type_template_id_375fc400_staticRenderFns = []
Blockvue_type_template_id_375fc400_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/components/Block.vue?vue&type=template&id=375fc400&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/import-field-groups/components/Block.vue?vue&type=script&lang=js&
function Blockvue_type_script_lang_js_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function Blockvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { Blockvue_type_script_lang_js_ownKeys(source, true).forEach(function (key) { Blockvue_type_script_lang_js_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { Blockvue_type_script_lang_js_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function Blockvue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var import_field_groups_components_Blockvue_type_script_lang_js_ = ({
  name: 'Block',
  props: ['block'],
  methods: Blockvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapMutations"])(['getBlockFromLibrary']), {
    getBlock: function getBlock() {
      this.getBlockFromLibrary(this.block);
    }
  }),
  computed: Blockvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])({
    selectedBlock: 'block'
  }), {
    isEdited: function isEdited() {
      return this.selectedBlock && this.selectedBlock.id === this.block.id;
    },
    bgImage: function bgImage() {
      return 'background-image: url(' + this.block.image + ')';
    }
  })
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/components/Block.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_import_field_groups_components_Blockvue_type_script_lang_js_ = (import_field_groups_components_Blockvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/components/Block.vue





/* normalize component */

var components_Block_component = Object(componentNormalizer["default"])(
  components_import_field_groups_components_Blockvue_type_script_lang_js_,
  Blockvue_type_template_id_375fc400_render,
  Blockvue_type_template_id_375fc400_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var components_Block_api; }
components_Block_component.options.__file = "resources/assets/js/src/components/import-field-groups/components/Block.vue"
/* harmony default export */ var components_Block = (components_Block_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/import-field-groups/components/BlocksLibrary.vue?vue&type=script&lang=js&
function BlocksLibraryvue_type_script_lang_js_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function BlocksLibraryvue_type_script_lang_js_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { BlocksLibraryvue_type_script_lang_js_ownKeys(source, true).forEach(function (key) { BlocksLibraryvue_type_script_lang_js_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { BlocksLibraryvue_type_script_lang_js_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function BlocksLibraryvue_type_script_lang_js_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var BlocksLibraryvue_type_script_lang_js_ = ({
  components: {
    Block: components_Block
  },
  data: function data() {
    return {
      search: ''
    };
  },
  name: 'BlocksLibrary',
  computed: BlocksLibraryvue_type_script_lang_js_objectSpread({}, Object(vuex_esm["mapState"])(['blocks', 'block']), {
    filteredBlocks: function filteredBlocks() {
      var _this = this;

      return this.blocks.filter(function (block) {
        return block.name.toLowerCase().includes(_this.search);
      });
    }
  })
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/components/BlocksLibrary.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_BlocksLibraryvue_type_script_lang_js_ = (BlocksLibraryvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/components/BlocksLibrary.vue





/* normalize component */

var BlocksLibrary_component = Object(componentNormalizer["default"])(
  components_BlocksLibraryvue_type_script_lang_js_,
  BlocksLibraryvue_type_template_id_253a76c8_render,
  BlocksLibraryvue_type_template_id_253a76c8_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var BlocksLibrary_api; }
BlocksLibrary_component.options.__file = "resources/assets/js/src/components/import-field-groups/components/BlocksLibrary.vue"
/* harmony default export */ var BlocksLibrary = (BlocksLibrary_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/import-field-groups/components/LocalBlocks.vue?vue&type=template&id=11c90404&
var LocalBlocksvue_type_template_id_11c90404_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "c-block-list__wrap" }, [
    _vm._m(0),
    _vm._v(" "),
    _c("div", { staticClass: "c-block-list" }, [
      _c("div", { staticClass: "c-block-list__search o-form" }, [
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.search,
              expression: "search"
            }
          ],
          attrs: {
            type: "text",
            id: "search",
            name: "search",
            placeholder: "Search blocks"
          },
          domProps: { value: _vm.search },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.search = $event.target.value
            }
          }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "c-block-list__search-icon" }, [
          _c("svg", [
            _c("use", {
              attrs: { "xlink:href": "/argon/images/svgicons.svg#search" }
            })
          ])
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "c-block-list__container" }, [
        _c(
          "div",
          { staticClass: "c-block-list__inner-list" },
          [
            _vm._l(_vm.blocks, function(block) {
              return _c("block", { key: block.id, attrs: { block: block } })
            }),
            _vm._v(" "),
            _c("div", { staticClass: "c-blocks-library__no-blocks-message" }, [
              _vm._v("No blocks found.")
            ])
          ],
          2
        )
      ])
    ])
  ])
}
var LocalBlocksvue_type_template_id_11c90404_staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "typography l-space" }, [
      _c("h3", [_vm._v("Local blocks")]),
      _vm._v(" "),
      _c("p", [_vm._v("Import blocks from existing templates.")])
    ])
  }
]
LocalBlocksvue_type_template_id_11c90404_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/components/LocalBlocks.vue?vue&type=template&id=11c90404&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/import-field-groups/components/LocalBlocks.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ var LocalBlocksvue_type_script_lang_js_ = ({
  components: {
    Block: components_Block
  },
  data: function data() {
    return {
      search: ''
    };
  },
  name: 'LocalBlocks',
  computed: {
    blocks: function blocks() {
      var _this = this;

      var types = this.$store.state.types;
      var blocks = types.map(function (type) {
        return type.groups.map(function (group) {
          return {
            isLocal: true,
            id: group.id,
            type: type.id,
            name: group.name + ' [' + type.name + ']',
            image: group.settings.image
          };
        });
      }).reduce(function (l, n) {
        return l.concat(n);
      }, []);
      return blocks.filter(function (block) {
        return block.name.toLowerCase().includes(_this.search);
      });
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/components/LocalBlocks.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_LocalBlocksvue_type_script_lang_js_ = (LocalBlocksvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/components/LocalBlocks.vue





/* normalize component */

var LocalBlocks_component = Object(componentNormalizer["default"])(
  components_LocalBlocksvue_type_script_lang_js_,
  LocalBlocksvue_type_template_id_11c90404_render,
  LocalBlocksvue_type_template_id_11c90404_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var LocalBlocks_api; }
LocalBlocks_component.options.__file = "resources/assets/js/src/components/import-field-groups/components/LocalBlocks.vue"
/* harmony default export */ var LocalBlocks = (LocalBlocks_component.exports);
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/import-field-groups/App.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//





/* harmony default export */ var import_field_groups_Appvue_type_script_lang_js_ = ({
  components: {
    Editor: Editor,
    BlocksLibrary: BlocksLibrary,
    LocalBlocks: LocalBlocks
  },
  mounted: function mounted() {},
  methods: {
    submit: function submit(evt) {
      this.$store.commit('importBlock', null);
    },
    cancel: function cancel() {
      return window.location.href = '/admin/types/' + this.$store.state.type.id + '/edit';
    }
  },
  computed: {}
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/App.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_import_field_groups_Appvue_type_script_lang_js_ = (import_field_groups_Appvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/App.vue





/* normalize component */

var import_field_groups_App_component = Object(componentNormalizer["default"])(
  components_import_field_groups_Appvue_type_script_lang_js_,
  Appvue_type_template_id_c56b9336_render,
  Appvue_type_template_id_c56b9336_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var import_field_groups_App_api; }
import_field_groups_App_component.options.__file = "resources/assets/js/src/components/import-field-groups/App.vue"
/* harmony default export */ var import_field_groups_App = (import_field_groups_App_component.exports);
// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/store/index.js
function import_field_groups_store_toConsumableArray(arr) { return import_field_groups_store_arrayWithoutHoles(arr) || import_field_groups_store_iterableToArray(arr) || import_field_groups_store_nonIterableSpread(); }

function import_field_groups_store_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function import_field_groups_store_iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function import_field_groups_store_arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function import_field_groups_store_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function import_field_groups_store_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { import_field_groups_store_ownKeys(source, true).forEach(function (key) { import_field_groups_store_defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { import_field_groups_store_ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function import_field_groups_store_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }




function store_getStore() {
  return new vuex_esm["default"].Store({
    state: {
      type: null,
      types: [],
      blocks: [],
      editorMode: 'json',
      content: {
        json: '',
        blade: '',
        mappers: ''
      },
      smartImport: 0,
      isLoading: false,
      isEditorExpanded: false,
      isConfigExpanded: false,
      block: null
    },
    getters: {},
    mutations: {
      setType: function setType(state, _ref) {
        var type = _ref.type;
        state.type = type;
      },
      setTypes: function setTypes(state, _ref2) {
        var types = _ref2.types;
        state.types = types;
      },
      setBlocks: function setBlocks(state, _ref3) {
        var blocks = _ref3.blocks;
        state.blocks = blocks;
      },
      changeEditorMode: function changeEditorMode(state, mode) {
        state.editorMode = mode;
      },
      setContent: function setContent(state, content) {
        state.content = content;
        state.editorMode = 'json';
      },
      setContentJson: function setContentJson(state, json) {
        state.content.json = json;
      },
      setContentBlade: function setContentBlade(state, blade) {
        state.content.blade = blade;
      },
      setContentMappers: function setContentMappers(state, mappers) {
        state.content.mappers = mappers;
      },
      setSelectedBlock: function setSelectedBlock(state, block) {
        state.block = block;
      },
      showLoading: function showLoading(state, bool) {
        state.isLoading = bool;
      },
      expandEditor: function expandEditor(state, bool) {
        state.isEditorExpanded = bool;
      },
      expandConfig: function expandConfig(state, bool) {
        state.isConfigExpanded = bool;
      },
      setBlockName: function setBlockName(state, name) {
        state.block.name = name;
      },
      setBlockImage: function setBlockImage(state, image) {
        state.block.image = image;
      },
      setSmartImport: function setSmartImport(state, value) {
        state.smartImport = value;
      },
      createNewBlock: function createNewBlock(state) {
        state.block = import_field_groups_store_objectSpread({
          id: null,
          name: null,
          image: null
        }, state.content);
      },
      addBlockToLibraryPanel: function addBlockToLibraryPanel(state) {
        state.blocks.push(state.block);
      },
      saveBlockToLibrary: function saveBlockToLibrary(state) {
        var url = '/admin/blockslibrary';

        if (!state.block.name) {
          new noty_default.a({
            layout: 'topCenter',
            text: 'Please provide block name',
            type: 'error',
            timeout: 3500
          }).show();
          return;
        }

        if (!state.content.json) {
          new noty_default.a({
            layout: 'topCenter',
            text: 'Please provide json schema',
            type: 'error',
            timeout: 3500
          }).show();
          return;
        }

        if (state.block.id) {
          url += '/' + state.block.id;
        }

        state.block.json = state.content.json;
        state.block.blade = state.content.blade;
        state.block.mappers = state.content.mappers;
        vue_default.a.http.post(url, state.block).then(function (response) {
          if (response.body && response.body.success) {
            if (response.body.block && response.body.block.id) {
              state.block.id = response.body.block.id;
              state.blocks = [state.block].concat(import_field_groups_store_toConsumableArray(state.blocks));
              new noty_default.a({
                layout: 'topCenter',
                text: 'Block has been saved in the Blocks Library',
                type: 'success',
                timeout: 3500
              }).show();
            } else {
              state.blocks = state.blocks.map(function (block) {
                if (block.id !== state.block.id) {
                  return block;
                }

                return import_field_groups_store_objectSpread({}, state.block);
              });
              new noty_default.a({
                layout: 'topCenter',
                text: 'Changes to the block have been saved',
                type: 'success',
                timeout: 3500
              }).show();
            }
          } else {
            new noty_default.a({
              layout: 'topCenter',
              text: 'There was an error while saving the block',
              type: 'error',
              timeout: 3500
            }).show();
          }
        });
      },
      deleteBlockFromLibrary: function deleteBlockFromLibrary(state) {
        var url = '/admin/blockslibrary/delete/' + state.block.id;
        vue_default.a.http.post(url).then(function (response) {
          if (response.body && response.body.success) {
            state.blocks = state.blocks.filter(function (block) {
              return block.id !== state.block.id;
            });
            state.block = null;
            state.editorMode = 'json';
            new noty_default.a({
              layout: 'topCenter',
              text: 'Block has been removed from the Blocks Library',
              type: 'success',
              timeout: 3500
            }).show();
          }
        });
      },
      getBlockFromLibrary: function getBlockFromLibrary(state, block) {
        state.isLoading = true;

        if (block.isLocal) {
          var url = '/admin/types/' + encodeURIComponent(block.type) + '/groups/' + encodeURIComponent(block.id) + '/export';
          vue_default.a.http.get(url, {
            params: {
              json: true
            }
          }).then(function (response) {
            state.content = {
              json: JSON.stringify(response.body, null, 4),
              blade: '',
              mappers: ''
            };
            state.block = null;
            state.isLoading = false;
          });
        } else {
          var _url = '/admin/blockslibrary/' + encodeURIComponent(block.id);

          vue_default.a.http.get(_url).then(function (response) {
            var content = {
              json: JSON.stringify(response.body.json, null, 4),
              mappers: response.body.mappers,
              blade: response.body.blade
            };
            state.content = content;
            state.editorMode = 'json';
            state.block = response.body;
            state.isLoading = false;
          });
        }
      },
      importBlock: function importBlock(state) {
        var url = '/admin/types/' + state.type.id + '/groups/import';

        if (!state.content.json) {
          new noty_default.a({
            layout: 'topCenter',
            text: 'Please provide json schema',
            type: 'error',
            timeout: 3500
          }).show();
          return;
        }

        vue_default.a.http.post(url, {
          json: state.content.json,
          smart_import: state.smartImport
        }).then(function (response) {
          if (response.body && response.body.success) {
            new noty_default.a({
              layout: 'topCenter',
              text: response.body.msg || 'New block has imported',
              type: 'success',
              timeout: 3500
            }).show();
          } else {
            // todo print actual error message
            new noty_default.a({
              layout: 'topCenter',
              text: response.body.error && response.body.error.json || 'Block could not be imported',
              type: 'error',
              timeout: 3500
            }).show();
          }
        });
      }
    }
  });
}
// CONCATENATED MODULE: ./resources/assets/js/src/components/import-field-groups/index.js




vue_default.a.config.productionTip = false;
vue_default.a.use(vuex_esm["default"]);
function ImportFieldGroups() {
  var importFieldGroups = document.querySelector('.js-import-field-groups');

  if (!importFieldGroups) {
    return;
  }

  var store = store_getStore();
  store.commit('setType', {
    type: type
  });
  store.commit('setTypes', {
    types: types
  });
  store.commit('setBlocks', {
    blocks: blocks
  });
  return new vue_default.a({
    store: store,
    render: function render(h) {
      return h(import_field_groups_App);
    }
  }).$mount(importFieldGroups);
}
// CONCATENATED MODULE: ./resources/assets/js/src/components/index.js








// CONCATENATED MODULE: ./resources/assets/js/src/dashboard/feedback-form/index.js



var feedback_form_form;
var feedback_form_input;
var feedback_form_msg;
function feedbackForm() {
  feedback_form_input = document.querySelector('.js-feedback-form-input');
  feedback_form_msg = document.querySelector('.js-feedback-form-message');
  var formEL = document.querySelector('.js-feedback-form');

  if (!formEL) {
    return;
  }

  feedback_form_form = createController(formEL, onSubmit);
  Object(_esm5["fromEvent"])(document, 'click').subscribe(function (evt) {
    if (evt.target.classList.contains('js-feedback-form-input') && document.activeElement.classList.contains('js-feedback-form-input')) {
      feedback_form_form.el.classList.add('active');
    } else if (!evt.target.classList.contains('js-feedback-form-btn')) {
      feedback_form_form.el.classList.remove('active');
    }
  });
}

function onSubmit(data) {
  if (data.data.success) {
    // form.el.classList.add('submitted')
    feedback_form_form.el.classList.remove('active');
    feedback_form_form.el.reset();
    new noty_default.a({
      layout: 'topCenter',
      text: 'Your feedback has been sent successfully.',
      type: 'success',
      timeout: 3500
    }).show(); // setTimeout(function() {
    //     form.el.classList.remove('submitted')
    // }, 2000)
  } else {
    var error = 'Form could not be submitted right now, please try again later.';

    if (data.data.fields.feedback.length) {
      error = data.data.fields.feedback;
    } else if (data.data.msg) {
      error = data.data.msg;
    }

    new noty_default.a({
      layout: 'topCenter',
      text: error,
      type: 'error',
      timeout: 1000
    }).show();
  }
}
// CONCATENATED MODULE: ./resources/assets/js/src/dashboard/index.js



vue_default.a.config.productionTip = false;
vue_default.a.use(vuebar_default.a);
function Dashboard() {
  activityLog();
  feedbackForm();
}

function activityLog() {
  var widget = document.querySelector('.c-activity-widget');

  if (!widget) {
    return;
  }

  new vue_default.a().$mount(widget);
}
// CONCATENATED MODULE: ./resources/assets/js/src/index.js






 // import resetForm from './form/reset-form'


var pageEditApp;
var fieldsApps;

function src_init() {
  init();
  ui_jump.init(650, 150);
  ImportFieldGroups();
  sidebar_init();
  Notifications();
  accordion_init();
  video_init();
  map_init();
  setupModals();
  scroll_anim_init(); // add c-grid-anim | c-line-anim | c-scroll-anim--fade-up with js-scroll-anim to animate a component on scroll

  tables();
  initialiseFormElements();
  registerFormSaveEvents(); // resetForm()

  fieldsApps = Fields();
  Medialib();
  Dashboard();
  pageEditApp = PageEdit();
  Tabs(tabAction);
  MenuEdit();
  cropperTest();
  formSubmits();
  SiteTree();
  BasicConfirmBtns(); // testUppy()
}

function tabAction(tabName) {
  if (tabName === 'page-content') {
    pageEditApp.$children[0].enableDragging();
  } else {
    pageEditApp.$children[0].disableDragging();
  }

  fieldsApps.forEach(function (app) {
    app.$children[0].toggleDraggables(tabName);
  });
}

function testUppy() {
  var metaToken = document.head.querySelector('meta[name="csrf-token"]');
  metaToken = metaToken && metaToken.content;
  var uppy = Object(node_modules_uppy["Core"])().use(node_modules_uppy["Dashboard"], {
    target: '.js-uppy',
    inline: true,
    width: '100%',
    height: '100%'
  }).use(node_modules_uppy["XHRUpload"], {
    endpoint: '/admin/media/api/upload',
    headers: {
      'X-CSRF-TOKEN': metaToken
    }
  }).use(node_modules_uppy["DragDrop"], {
    target: '.js-drag-drop'
  });
  uppy.on('complete', console.log);
}

function formSubmits() {
  setupPageLeave();
  Object(_esm5["fromEvent"])(document, 'click').pipe(Object(operators["filter"])(function (evt) {
    return evt.target.dataset && evt.target.dataset.formAction;
  })).subscribe(function (evt) {
    evt.preventDefault();
    var form = evt.target.closest('form');
    form.action = evt.target.dataset.formAction;
    form.submit();
  });
  var formEls = document.querySelectorAll('form.js-prevent-leave');
  var forms = Array.from(formEls);
  forms.forEach(function (form) {
    form.addEventListener('submit', function (evt) {
      allowPageLeave();
      var submitBtnsEls = document.querySelectorAll('[type=submit]');
      var submitBtns = Array.from(submitBtnsEls);
      submitBtns.forEach(function (btn) {
        btn.disabled = true;
      });
      return true;
    });
  });
}

function cropperTest() {
  cropper_Cropper();
  var btn = document.querySelector('.js-spawn-cropper');

  if (!btn) {
    return;
  }

  btn.addEventListener('click', function () {
    setCropperImage({
      image: {
        path: 'https://picsum.photos/800/600/?random'
      },
      rotator: true,
      ratio: '16:9'
    }).then(console.log);
  });
}

if (document.readyState !== 'loading') {
  src_init();
} else {
  document.addEventListener('DOMContentLoaded', src_init);
}

/***/ }),

/***/ 0:
/*!********************!*\
  !*** ws (ignored) ***!
  \********************/
/*! no static exports found */
/*! ModuleConcatenation bailout: Module is not an ECMAScript module */
/***/ (function(module, exports) {

/* (ignored) */

/***/ }),

/***/ 1:
/*!*********************!*\
  !*** got (ignored) ***!
  \*********************/
/*! no static exports found */
/*! ModuleConcatenation bailout: Module is not an ECMAScript module */
/***/ (function(module, exports) {

/* (ignored) */

/***/ })

/******/ });
//# sourceMappingURL=main.e138949a033845646686.js.map