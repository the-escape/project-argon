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
  !*** ./resources/assets/js/src/index.js + 208 modules ***!
  \********************************************************/
/*! no exports provided */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/choices.js/assets/scripts/dist/choices.min.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/cropperjs/dist/cropper.esm.js */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/dragula/dragula.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/flatpickr/dist/flatpickr.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/moment/moment.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/noty/lib/noty.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/rxjs/_esm5/index.js */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/rxjs/_esm5/operators/index.js */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vue-flatpickr-component/dist/vue-flatpickr.min.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vue/dist/vue.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vuebar/vuebar.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vuedraggable/dist/vuedraggable.js (<- Module is not an ECMAScript module) */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vuex/dist/vuex.esm.js */
/*! ModuleConcatenation bailout: Cannot concat with ./node_modules/vue-loader/lib/runtime/componentNormalizer.js */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";

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

    var dataEls = _toConsumableArray(rowDataEls).concat(_toConsumableArray(actionEls));

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
  nav: null,
  panels: null,
  currentTab: null
};
var tabs;
function Tabs() {
  var tabEl = document.querySelector('.js-tabs');
  tabs = createTabs(tabEl);
  var tabUrlParamRegex = /[?&]tab(=([^&#]*)|&|#|$)/;
  var tab = tabUrlParamRegex.exec(window.location.search);

  if (tab && tab[2]) {
    changeTab(tab[2]);
  }

  window.onpopstate = function (evt) {
    if (evt.state && evt.state.tab) {
      changeTab(evt.state.tab, false);
    }
  };

  Object(_esm5["fromEvent"])(document, 'click').pipe(Object(operators["filter"])(function (evt) {
    return evt.target.classList.contains('js-tab-btn');
  }), Object(operators["map"])(function (evt) {
    evt.preventDefault();
    return evt.target.dataset.tab;
  })).subscribe(changeTab);
  return tabs;
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

function changeTab(tabName) {
  var pushstate = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

  if (!tabs.panels || !tabs.panels[tabName]) {
    return;
  }

  tabs.panels[tabs.currentTab].classList.remove('active');
  tabs.nav[tabs.currentTab] && tabs.nav[tabs.currentTab].classList.remove('active');
  tabs.panels[tabName].classList.add('active');
  tabs.nav[tabName] && tabs.nav[tabName].classList.add('active');
  tabs.currentTab = tabName;

  if (pushstate) {
    history.pushState({
      tab: tabName
    }, tabName, "?tab=".concat(tabName));
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
      text: notif.text,
      type: notif.success ? 'success' : 'error'
    }).show();
  });
}
// EXTERNAL MODULE: ./node_modules/cropperjs/dist/cropper.esm.js
var cropper_esm = __webpack_require__("./node_modules/cropperjs/dist/cropper.esm.js");

// CONCATENATED MODULE: ./resources/assets/js/src/ui/cropper.js



var cropper_el;
var cropper_container;
var canvas;
var cropper_input;
var preview;
var rotate;
var currentRotation = 0;
var moveRatation = 0;
var cropper;
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
  cropper = new cropper_esm["default"](canvas, {
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
    cropper.rotateTo(currentRotation + moveRatation);
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
      cropper.zoom(0.1);
      break;

    case 'zoom-out':
      cropper.zoom(-0.1);
      break;

    case 'drag-image':
      cropper.setDragMode('move');
      break;

    case 'drag-crop':
      cropper.setDragMode('crop');
      break;

    case 'set-ratio':
      var ratio = element.dataset.ratio;
      ratio = ratio.split(':');
      ratio = ratio[0] / ratio[1];
      console.log(ratio);
      cropper.setAspectRatio(ratio);
      break;

    case 'set-rotate':
      var _rotate = element.dataset.rotate;
      currentRotation = 0;
      cropper.rotateTo(_rotate);
      break;
  }
}

function imageSet(evt) {
  var file = evt.target.files[0];
  var reader = new FileReader();

  reader.onload = function (evt) {
    cropper.replace(evt.target.result);
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
  return select_toConsumableArray(selectList).concat(select_toConsumableArray(plainSelectList));
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

      removeItem.call(_this, el.dataset.value);
      addItem.call(_this, el.dataset.value, _siblingValue);
    }

    if (target === _this.inactiveColumn) {
      removeItem.call(_this, el.dataset.value);
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

function removeItem(value) {
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
  deleteItem: function deleteItem(_) {},
  editItemNewTab: function editItemNewTab(_) {}
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
  this.editItemNewTab = editItemNewTab.bind(this);
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
  this.tree.on('select_node.jstree', function (_, data) {
    if (data.event.altKey) {
      editItemNewTab(data.node);
    }
  });
}

function editItem(data) {
  var obj = this.tree.jstree(true).get_node(data.reference);
  var id = argon.helpers.getIdFromNodeIdString(obj.id);
  console.log(obj, 'edit page');
  window.location.href = argon.root() + '/pages/' + id + '/edit';
}

function editItemNewTab(node) {
  var id = argon.helpers.getIdFromNodeIdString(node.id);
  console.log(node, 'edit page New Window');
  window.open(argon.root() + '/pages/' + id + '/edit');
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
      _token: token,
      _method: 'DELETE'
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
  var _this2 = this;

  var typesList = JSON.parse(this.el.dataset.types);
  var typeListKeys = Object.keys(typesList);
  return typeListKeys.reduce(function (acc, key) {
    var type = typesList[key];
    acc[type.id] = {
      _disabled: false,
      label: type.name,
      title: 'Create new page of type ' + type.name,
      icon: 'o-tree__icon o-tree__icon--add',
      action: _this2.addItem(type.id)
    };
    return acc;
  }, {});
}

function tree_setupEvents() {
  var _this3 = this;

  Object(_esm5["fromEvent"])(this.input, 'input').pipe(Object(operators["debounceTime"])(100)).subscribe(function () {
    _this3.tree.jstree(true).search(_this3.input.value);
  });
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
    { staticClass: "o-form l-accordion-container" },
    _vm._l(_vm.fields, function(field) {
      return _c("types", { key: field.id, attrs: { field: field } })
    })
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
/* harmony default export */ var Appvue_type_script_lang_js_ = ({
  computed: {
    fields: function fields() {
      return this.$store.state.fields;
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
// EXTERNAL MODULE: ./node_modules/vuedraggable/dist/vuedraggable.js
var vuedraggable = __webpack_require__("./node_modules/vuedraggable/dist/vuedraggable.js");
var vuedraggable_default = /*#__PURE__*/__webpack_require__.n(vuedraggable);

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

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/base.vue?vue&type=template&id=58642601&
var basevue_type_template_id_58642601_render = function() {
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
var basevue_type_template_id_58642601_staticRenderFns = []
basevue_type_template_id_58642601_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/base.vue?vue&type=template&id=58642601&

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
                                  "o-multi__drag-handle js-multi-drag",
                                on: {
                                  click: function($event) {
                                    _vm.preventDefault($event)
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
                  on: {
                    click: function($event) {
                      _vm.addEmptyValue($event)
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
      _c("div", { staticClass: "o-confirm-btn__questions" }, [
        _vm.hideDuplicate
          ? _c("div", { staticClass: "o-confirm-btn" })
          : _vm._e(),
        _vm._v(" "),
        !_vm.hideDuplicate
          ? _c(
              "button",
              {
                staticClass: "o-confirm-btn",
                attrs: { title: "Duplicate" },
                on: {
                  click: function($event) {
                    _vm.duplicate($event)
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
            attrs: { title: "Delete" },
            on: {
              click: function($event) {
                _vm.toggleConfirmDelete($event)
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
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "o-confirm-btn__decline" }, [
        _c(
          "button",
          {
            staticClass: "o-confirm-btn o-confirm-btn--danger",
            on: {
              click: function($event) {
                _vm.toggleConfirmDelete($event)
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
                _vm.deleteConfirm($event)
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
/* harmony default export */ var confirm_btnvue_type_script_lang_js_ = ({
  props: ['hideDuplicate', 'isBlock'],
  data: function data() {
    return {
      confirmDelete: false
    };
  },
  methods: {
    toggleConfirmDelete: function toggleConfirmDelete(evt) {
      evt.preventDefault();
      this.confirmDelete = !this.confirmDelete;
    },
    duplicate: function duplicate(evt) {
      evt.preventDefault();
      this.$emit('duplicate');
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
// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/base.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/base.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_basevue_type_script_lang_js_ = (basevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/base.vue





/* normalize component */

var base_component = Object(componentNormalizer["default"])(
  types_basevue_type_script_lang_js_,
  basevue_type_template_id_58642601_render,
  basevue_type_template_id_58642601_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var base_api; }
base_component.options.__file = "resources/assets/js/src/components/fields/types/base.vue"
/* harmony default export */ var base = (base_component.exports);
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/textarea.vue?vue&type=template&id=9775a42c&
var textareavue_type_template_id_9775a42c_render = function() {
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
var textareavue_type_template_id_9775a42c_staticRenderFns = []
textareavue_type_template_id_9775a42c_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/textarea.vue?vue&type=template&id=9775a42c&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/textarea.vue?vue&type=script&lang=js&
//
//
//
//
//
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/textarea.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_textareavue_type_script_lang_js_ = (textareavue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/textarea.vue





/* normalize component */

var textarea_component = Object(componentNormalizer["default"])(
  types_textareavue_type_script_lang_js_,
  textareavue_type_template_id_9775a42c_render,
  textareavue_type_template_id_9775a42c_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var textarea_api; }
textarea_component.options.__file = "resources/assets/js/src/components/fields/types/textarea.vue"
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
      ]),
      _vm._v(" "),
      _vm.isMultiple
        ? _c(
            "button",
            {
              staticClass: "o-btn o-btn--sm o-btn--primary",
              on: {
                click: function($event) {
                  _vm.addEmptyItem($event)
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
                              _vm.toggleBodyHide($event, item.id)
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
                  _vm.addEmptyItem($event)
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
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/location.vue?vue&type=template&id=27f260e5&
var locationvue_type_template_id_27f260e5_render = function() {
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
                _c("div", { staticClass: "o-form__set" }, [
                  _c("div", { staticClass: "o-form__set-title" }, [
                    _c(
                      "label",
                      {
                        attrs: {
                          for:
                            _vm.inputNameMultiValue +
                            "[" +
                            valueObj.id +
                            "][latitude]"
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
                                valueObj.id +
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
                                    valueObj.id +
                                    "][latitude]"
                                }
                              },
                              [_vm._v("Latitude")]
                            ),
                            _vm._v(" "),
                            _c("input", {
                              attrs: {
                                type: "text",
                                id:
                                  _vm.inputNameMultiValue +
                                  "[" +
                                  valueObj.id +
                                  "][latitude]",
                                name:
                                  _vm.inputNameMultiValue +
                                  "[" +
                                  valueObj.id +
                                  "][latitude]"
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
                              "status-error":
                                _vm.errors && _vm.errors.longitude,
                              "input-name":
                                _vm.inputNameMultiValue +
                                "[" +
                                valueObj.id +
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
                                    valueObj.id +
                                    "][longitude]"
                                }
                              },
                              [_vm._v("Longitude")]
                            ),
                            _vm._v(" "),
                            _c("input", {
                              attrs: {
                                type: "text",
                                id:
                                  _vm.inputNameMultiValue +
                                  "[" +
                                  valueObj.id +
                                  "][longitude]",
                                name:
                                  _vm.inputNameMultiValue +
                                  "[" +
                                  valueObj.id +
                                  "][longitude]"
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
                  ])
                ])
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
var locationvue_type_template_id_27f260e5_staticRenderFns = []
locationvue_type_template_id_27f260e5_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/location.vue?vue&type=template&id=27f260e5&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/location.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/location.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_locationvue_type_script_lang_js_ = (locationvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/location.vue





/* normalize component */

var location_component = Object(componentNormalizer["default"])(
  types_locationvue_type_script_lang_js_,
  locationvue_type_template_id_27f260e5_render,
  locationvue_type_template_id_27f260e5_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var location_api; }
location_component.options.__file = "resources/assets/js/src/components/fields/types/location.vue"
/* harmony default export */ var types_location = (location_component.exports);
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

      config = single_wysiwygvue_type_script_lang_js_extends({}, this.defaultConfig, config);
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
}

function mountEditor() {
  var _this2 = this;

  var textarea = this.$el;
  this.textareaElement = textarea;
  CKEDITOR.replace(this.textareaElement, this.config);
  this.wysiwygInstance = this.textareaElement.name;
  CKEDITOR.instances[this.wysiwygInstance].setData(this.valueObj.value);
  CKEDITOR.instances[this.wysiwygInstance].on('change', function () {
    _this2.updateValue(CKEDITOR.instances[_this2.wysiwygInstance].getData());
  });
}

function destoryEditor() {
  CKEDITOR.instances[this.wysiwygInstance].destroy(true);
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
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/button.vue?vue&type=template&id=550447e2&
var buttonvue_type_template_id_550447e2_render = function() {
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
                _c("div", { staticClass: "o-form__set" }, [
                  _c("div", { staticClass: "o-form__set-title" }, [
                    _c(
                      "label",
                      {
                        attrs: {
                          for:
                            _vm.inputNameMultiValue +
                            "[" +
                            valueObj.id +
                            "][label]"
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
                                  _vm.inputNameMultiValue +
                                  "[" +
                                  valueObj.id +
                                  "][label]"
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
                                      valueObj.id +
                                      "][label]"
                                  }
                                },
                                [_vm._v("Label")]
                              ),
                              _vm._v(" "),
                              _c("input", {
                                attrs: {
                                  type: "text",
                                  id:
                                    _vm.inputNameMultiValue +
                                    "[" +
                                    valueObj.id +
                                    "][label]",
                                  name:
                                    _vm.inputNameMultiValue +
                                    "[" +
                                    valueObj.id +
                                    "][label]"
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
                                  _vm.inputNameMultiValue +
                                  "[" +
                                  valueObj.id +
                                  "][url]"
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
                                      valueObj.id +
                                      "][url]"
                                  }
                                },
                                [_vm._v("Url")]
                              ),
                              _vm._v(" "),
                              _c("input", {
                                attrs: {
                                  type: "text",
                                  id:
                                    _vm.inputNameMultiValue +
                                    "[" +
                                    valueObj.id +
                                    "][url]",
                                  name:
                                    _vm.inputNameMultiValue +
                                    "[" +
                                    valueObj.id +
                                    "][url]"
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
                            ? _c(
                                "div",
                                { staticClass: "o-form__set-accordion" },
                                [
                                  _c(
                                    "div",
                                    { staticClass: "o-form__group" },
                                    [
                                      _c(
                                        "validation",
                                        {
                                          attrs: {
                                            "status-error":
                                              _vm.errors && _vm.errors.class,
                                            "input-name":
                                              _vm.inputNameMultiValue +
                                              "[" +
                                              valueObj.id +
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
                                                  valueObj.id +
                                                  "][class]"
                                              }
                                            },
                                            [_vm._v("Class")]
                                          ),
                                          _vm._v(" "),
                                          _c("input", {
                                            attrs: {
                                              type: "text",
                                              id:
                                                _vm.inputNameMultiValue +
                                                "[" +
                                                valueObj.id +
                                                "][class]",
                                              name:
                                                _vm.inputNameMultiValue +
                                                "[" +
                                                valueObj.id +
                                                "][class]"
                                            },
                                            domProps: {
                                              value:
                                                valueObj.value &&
                                                valueObj.value.class
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
                                            "status-error":
                                              _vm.errors && _vm.errors.id,
                                            "input-name":
                                              _vm.inputNameMultiValue +
                                              "[" +
                                              valueObj.id +
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
                                                  valueObj.id +
                                                  "][id]"
                                              }
                                            },
                                            [_vm._v("ID")]
                                          ),
                                          _vm._v(" "),
                                          _c("input", {
                                            attrs: {
                                              type: "text",
                                              id:
                                                _vm.inputNameMultiValue +
                                                "[" +
                                                valueObj.id +
                                                "][id]",
                                              name:
                                                _vm.inputNameMultiValue +
                                                "[" +
                                                valueObj.id +
                                                "][id]"
                                            },
                                            domProps: {
                                              value:
                                                valueObj.value &&
                                                valueObj.value.id
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
                                            "status-error":
                                              _vm.errors && _vm.errors.target,
                                            "input-name":
                                              _vm.inputNameMultiValue +
                                              "[" +
                                              valueObj.id +
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
                                                  valueObj.id +
                                                  "][target]"
                                              }
                                            },
                                            [_vm._v("Target")]
                                          ),
                                          _vm._v(" "),
                                          _c("input", {
                                            attrs: {
                                              type: "text",
                                              id:
                                                _vm.inputNameMultiValue +
                                                "[" +
                                                valueObj.id +
                                                "][target]",
                                              name:
                                                _vm.inputNameMultiValue +
                                                "[" +
                                                valueObj.id +
                                                "][target]"
                                            },
                                            domProps: {
                                              value:
                                                valueObj.value &&
                                                valueObj.value.target
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
                              )
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
                              _vm.toggle($event)
                            }
                          }
                        },
                        [_vm._v("less options")]
                      )
                    ],
                    1
                  )
                ])
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
var buttonvue_type_template_id_550447e2_staticRenderFns = []
buttonvue_type_template_id_550447e2_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/button.vue?vue&type=template&id=550447e2&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/button.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      show: false,
      transitioning: false
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
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/button.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_buttonvue_type_script_lang_js_ = (buttonvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/button.vue





/* normalize component */

var button_component = Object(componentNormalizer["default"])(
  types_buttonvue_type_script_lang_js_,
  buttonvue_type_template_id_550447e2_render,
  buttonvue_type_template_id_550447e2_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var button_api; }
button_component.options.__file = "resources/assets/js/src/components/fields/types/button.vue"
/* harmony default export */ var types_button = (button_component.exports);
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
        mode: 'single',
        dateFormat: 'Y-m-d H:i:S',
        altInput: true,
        enableTime: false
      }
    };
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
      console.log(strDate);
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
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/image.vue?vue&type=template&id=22a4c74a&
var imagevue_type_template_id_22a4c74a_render = function() {
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
                          _c("img", {
                            attrs: { src: valueObj.value.url || "" }
                          })
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "o-file__help-text" }, [
                        _c("div", { staticClass: "o-form-icon" }, [
                          _c("div", { staticClass: "o-form-icon__icon" }, [
                            _c("span", [_vm._v("Alt")])
                          ]),
                          _vm._v(" "),
                          _c("input", {
                            attrs: {
                              type: "text",
                              id:
                                _vm.inputNameMultiValue +
                                "[" +
                                valueObj.id +
                                "][alt]",
                              name:
                                _vm.inputNameMultiValue +
                                "[" +
                                valueObj.id +
                                "][alt]"
                            },
                            domProps: {
                              value: valueObj.value && valueObj.value.alt
                            },
                            on: {
                              keyup: function($event) {
                                $event.stopPropagation()
                                _vm.updateAlt(valueObj, $event.target.value)
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              id:
                                _vm.inputNameMultiValue +
                                "[" +
                                valueObj.id +
                                "][width]",
                              name:
                                _vm.inputNameMultiValue +
                                "[" +
                                valueObj.id +
                                "][width]"
                            },
                            domProps: {
                              value: valueObj.value && valueObj.value.width
                            }
                          }),
                          _vm._v(" "),
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              id:
                                _vm.inputNameMultiValue +
                                "[" +
                                valueObj.id +
                                "][height]",
                              name:
                                _vm.inputNameMultiValue +
                                "[" +
                                valueObj.id +
                                "][height]"
                            },
                            domProps: {
                              value: valueObj.value && valueObj.value.height
                            }
                          }),
                          _vm._v(" "),
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              id:
                                _vm.inputNameMultiValue +
                                "[" +
                                valueObj.id +
                                "][url]",
                              name:
                                _vm.inputNameMultiValue +
                                "[" +
                                valueObj.id +
                                "][url]"
                            },
                            domProps: {
                              value: valueObj.value && valueObj.value.url
                            }
                          }),
                          _vm._v(" "),
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              id:
                                _vm.inputNameMultiValue +
                                "[" +
                                valueObj.id +
                                "][id]",
                              name:
                                _vm.inputNameMultiValue +
                                "[" +
                                valueObj.id +
                                "][id]"
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
                                _vm.selectImage($event, valueObj)
                              }
                            }
                          },
                          [_vm._v("select")]
                        )
                      ])
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
var imagevue_type_template_id_22a4c74a_staticRenderFns = []
imagevue_type_template_id_22a4c74a_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/image.vue?vue&type=template&id=22a4c74a&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/fields/types/image.vue?vue&type=script&lang=js&
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
  props: ['fieldId', 'comboId', 'comboItemId'],
  mixins: [field_values],
  components: {
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
    },
    updateAlt: function updateAlt(valueObj, newAlt) {
      var newValue = imagevue_type_script_lang_js_extends({}, valueObj.value, {
        alt: newAlt
      });

      this.updateValue(valueObj, newValue);
    },
    selectImage: function selectImage(evt, valueObj) {
      var _this = this;

      evt.preventDefault();
      spawnMediaLib().then(function (value) {
        _this.updateValue(valueObj, value);
      });
    }
  }
});

function spawnMediaLib() {
  return new Promise(function (resolve) {
    $('#medialib').off('hidden.bs.modal');
    $('#medialib').on('hidden.bs.modal', function () {
      var id = $(this).data('mlselect');
      var mediaValueObj;
      $.ajax(argon.root() + '/media/items/' + id).done(function (r) {
        mediaValueObj = {
          id: r.id,
          url: r.url,
          width: r.meta.width,
          height: r.meta.height
        };
        resolve(mediaValueObj);
      });
    });
    $('#medialib').modal();
  });
}
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/image.vue?vue&type=script&lang=js&
 /* harmony default export */ var types_imagevue_type_script_lang_js_ = (imagevue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/types/image.vue





/* normalize component */

var image_component = Object(componentNormalizer["default"])(
  types_imagevue_type_script_lang_js_,
  imagevue_type_template_id_22a4c74a_render,
  imagevue_type_template_id_22a4c74a_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var image_api; }
image_component.options.__file = "resources/assets/js/src/components/fields/types/image.vue"
/* harmony default export */ var types_image = (image_component.exports);
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
                                _vm.selectFile($event, valueObj)
                              }
                            }
                          },
                          [_vm._v("select")]
                        )
                      ])
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



/* harmony default export */ var filevue_type_script_lang_js_ = ({
  props: ['fieldId', 'comboId', 'comboItemId'],
  mixins: [field_values],
  components: {
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
    },
    selectFile: function selectFile(evt, valueObj) {
      var _this = this;

      evt.preventDefault();
      filevue_type_script_lang_js_spawnMediaLib().then(function (value) {
        _this.updateValue(valueObj, value);
      });
    }
  }
});

function filevue_type_script_lang_js_spawnMediaLib() {
  return new Promise(function (resolve) {
    $('#medialib').off('hidden.bs.modal');
    $('#medialib').on('hidden.bs.modal', function () {
      var id = $(this).data('mlselect');
      var mediaValueObj;
      $.ajax(argon.root() + '/media/items/' + id).done(function (r) {
        mediaValueObj = {
          id: r.id,
          url: r.url
        };
        resolve(mediaValueObj);
      });
    });
    $('#medialib').modal();
  });
}
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
/* harmony default export */ var file = (file_component.exports);
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
  'file': 'file-input'
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
    'file-input': file
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

            value = store_extends(value, newValue);
            return value;
          });
          return field;
        });
        preventPageLeave();
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
        preventPageLeave();
      },
      addValue: function addValue(state, _ref4) {
        var fieldID = _ref4.fieldID,
            valueObj = _ref4.valueObj;
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
        preventPageLeave();
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
        preventPageLeave();
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
        preventPageLeave();
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

              value = store_extends(value, newValue);
              return value;
            });
            return valuesObj;
          });
          return field;
        });
        preventPageLeave();
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
        preventPageLeave();
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

            valuesObj[fieldID].push(store_extends(valueObj, {
              id: createUniqueHash()
            }));
            return valuesObj;
          });
          return field;
        });
        preventPageLeave();
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
        preventPageLeave();
      }
    }
  });
}
// CONCATENATED MODULE: ./resources/assets/js/src/components/fields/index.js







vue_default.a.config.productionTip = false;
vue_default.a.component('draggable', vuedraggable_default.a);
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
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/page-edit/App.vue?vue&type=template&id=146287be&
var Appvue_type_template_id_146287be_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "l-halves c-tab-panel__inner" }, [
    _c("div", { staticClass: "c-block-list__wrap" }, [
      _c("div", { staticClass: "typography l-space" }, [
        _c("h3", [_vm._v("Page blocks")]),
        _vm._v(" "),
        _c("p", [_vm._v("Here you can edit, remove and re-order content")]),
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
        _c(
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
              })
            ),
            _vm._v(" "),
            _c(
              "draggable",
              {
                staticClass: "c-block-list__inner-list",
                attrs: { options: _vm.dragOptions },
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
              })
            )
          ],
          1
        )
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
                    attrs: { "xlink:href": "/argon/images/svgicons.svg#search" }
                  })
                ])
              ])
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "c-block-list__container" },
              [
                _c(
                  "draggable",
                  {
                    staticClass: "c-block-list__inner-list",
                    attrs: { options: _vm.dragOptions },
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
                  })
                )
              ],
              1
            )
          ])
        ])
      : _vm._e()
  ])
}
var Appvue_type_template_id_146287be_staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "typography l-space" }, [
      _c("h3", [_vm._v("Unused blocks")]),
      _vm._v(" "),
      _c("p", [_vm._v("Add blocks to create you own custom page layout")])
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
              _vm.addBlock($event)
            }
          }
        },
        [
          _c("div", { staticClass: "c-block__icon" }, [
            _c("svg", [
              _c("use", {
                attrs: { "xlink:href": "/argon/images/svgicons.svg#add" }
              })
            ])
          ])
        ]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "c-block__drag-handle" }, [
        _c("div", { staticClass: "c-block__icon" }, [
          _c("svg", [
            _c("use", {
              attrs: { "xlink:href": "/argon/images/svgicons.svg#hamburger" }
            })
          ])
        ])
      ])
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
        "button",
        {
          staticClass: "c-block__edit-btn",
          on: {
            click: function($event) {
              _vm.editBlock($event)
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
    _c(
      "div",
      { staticClass: "c-block__action-list" },
      [
        _vm.block.isRenderable && _vm.block.isSortable
          ? _c("confirm-btns", {
              attrs: { "hide-duplicate": true, "is-block": "true" },
              on: { delete: _vm.deleteBlock }
            })
          : _vm._e(),
        _vm._v(" "),
        _vm.block.isSortable
          ? _c(
              "div",
              {
                staticClass: "c-block__drag-handle",
                on: {
                  click: function($event) {
                    _vm.preventDefault($event)
                  }
                }
              },
              [
                _c("div", { staticClass: "c-block__icon" }, [
                  _c("svg", [
                    _c("use", {
                      attrs: {
                        "xlink:href": "/argon/images/svgicons.svg#hamburger"
                      }
                    })
                  ])
                ])
              ]
            )
          : _vm._e()
      ],
      1
    )
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


/* harmony default export */ var BlockEditvue_type_script_lang_js_ = ({
  props: ['block'],
  mixins: [BlockValues],
  components: {
    ConfirmBtns: confirm_btn
  },
  methods: {
    deleteBlock: function deleteBlock() {
      this.$emit('delete', this.block.id);
    },
    editBlock: function editBlock(evt) {
      evt.preventDefault();
      this.$emit('edit', this.block.id);
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
    editBlock: function editBlock(id) {
      this.$emit('edit', id);
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
//
//



/* harmony default export */ var page_edit_Appvue_type_script_lang_js_ = ({
  components: {
    'block-item': Block
  },
  data: function data() {
    return {
      nonSortableRenderingGroups: [],
      renderingGroups: [],
      blockList: [],
      hasRenderable: false,
      dragOptions: {
        group: {
          name: 'groupEdit',
          pull: true,
          put: true
        },
        animation: 75,
        handle: '.c-block__drag-handle'
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
      this.renderingDragGroup = Appvue_type_script_lang_js_toConsumableArray(this.renderingGroups).concat([item]);
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
      this.blockDragList = Appvue_type_script_lang_js_toConsumableArray(this.blockList).concat([item]);
    },
    editBlock: function editBlock(id) {
      changeTab("group-".concat(id));
    }
  }
});
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/App.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_page_edit_Appvue_type_script_lang_js_ = (page_edit_Appvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/App.vue





/* normalize component */

var App_component = Object(componentNormalizer["default"])(
  components_page_edit_Appvue_type_script_lang_js_,
  Appvue_type_template_id_146287be_render,
  Appvue_type_template_id_146287be_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var App_api; }
App_component.options.__file = "resources/assets/js/src/components/page-edit/App.vue"
/* harmony default export */ var page_edit_App = (App_component.exports);
// CONCATENATED MODULE: ./resources/assets/js/src/components/page-edit/index.js



vue_default.a.config.productionTip = false;
vue_default.a.component('draggable', vuedraggable_default.a);
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
      _c("img", { ref: "img", attrs: { src: _vm.image.path } }),
      _vm._v(" "),
      _c("div", { staticClass: "c-cropper__toolbar" }, [
        _c("div", { staticClass: "c-cropper__toolbar-left" }, [
          _c(
            "button",
            {
              staticClass: "c-cropper__btn",
              on: {
                click: function($event) {
                  _vm.dragImage($event)
                }
              }
            },
            [
              _c("div", { staticClass: "c-cropper__icon" }, [
                _c("svg", [
                  _c("use", {
                    attrs: { "xlink:href": "/argon/images/svgicons.svg#move" }
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
                  _vm.dragCrop($event)
                }
              }
            },
            [
              _c("div", { staticClass: "c-cropper__icon" }, [
                _c("svg", [
                  _c("use", {
                    attrs: { "xlink:href": "/argon/images/svgicons.svg#crop" }
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
                  _vm.zoomIn($event)
                }
              }
            },
            [
              _c("div", { staticClass: "c-cropper__icon" }, [
                _c("svg", [
                  _c("use", {
                    attrs: {
                      "xlink:href": "/argon/images/svgicons.svg#zoom-in"
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
                  _vm.zoomOut($event)
                }
              }
            },
            [
              _c("div", { staticClass: "c-cropper__icon" }, [
                _c("svg", [
                  _c("use", {
                    attrs: {
                      "xlink:href": "/argon/images/svgicons.svg#zoom-out"
                    }
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
              { staticClass: "c-cropper__toolbar-mid" },
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
            staticClass: "c-cropper__toolbar-right",
            on: {
              click: function($event) {
                _vm.crop($event)
              }
            }
          },
          [
            _c("button", { staticClass: "o-btn o-btn--xs o-btn--success" }, [
              _vm._v("done")
            ])
          ]
        )
      ])
    ]),
    _vm._v(" "),
    _c("pre", [_vm._v(_vm._s(_vm.image))])
  ])
}
var Croppervue_type_template_id_761e1e22_staticRenderFns = []
Croppervue_type_template_id_761e1e22_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/components/Cropper.vue?vue&type=template&id=761e1e22&

// CONCATENATED MODULE: ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/cropper/components/rotater.vue?vue&type=template&id=dc07d9a8&
var rotatervue_type_template_id_dc07d9a8_render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "c-cropper__rotater" }, [
    _c("div", { ref: "rotater", staticClass: "c-cropper__rotater-wrap" }, [
      _c(
        "div",
        {
          ref: "track",
          staticClass: "c-cropper__rotater-track",
          style: { transform: "translateX(" + _vm.trackPosition + "px)" }
        },
        [
          _c("svg", { attrs: { viewBox: "0 0 1120 48" } }, [
            _c(
              "g",
              { attrs: { fill: "currentColor" } },
              [
                _vm._l(_vm.rotatorPoints.lines, function(line) {
                  return _c("rect", {
                    key: "line-" + line.x,
                    attrs: {
                      x: line.x,
                      y: "0",
                      width: "2",
                      height: line.height
                    }
                  })
                }),
                _vm._v(" "),
                _vm._l(_vm.rotatorPoints.text, function(text) {
                  return _c(
                    "text",
                    {
                      key: "text-" + text.x,
                      attrs: { x: text.x, y: "38", "text-anchor": "middle" }
                    },
                    [_vm._v(_vm._s(text.text))]
                  )
                })
              ],
              2
            )
          ])
        ]
      )
    ])
  ])
}
var rotatervue_type_template_id_dc07d9a8_staticRenderFns = []
rotatervue_type_template_id_dc07d9a8_render._withStripped = true


// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/components/rotater.vue?vue&type=template&id=dc07d9a8&

// CONCATENATED MODULE: ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/src/components/cropper/components/rotater.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var rotatervue_type_script_lang_js_ = ({
  props: ['value'],
  data: function data() {
    return {
      currentRotation: 0,
      moveRotation: 0,
      trackPosition: 0,
      trackPositionStart: 0,
      oneDegreeToPixel: 6,
      maxRotation: 90,
      minRotation: -90
    };
  },
  computed: {
    rotatorPoints: function rotatorPoints() {
      var points = new Array(19).fill().map(function (el, index) {
        return index * 10 - 90;
      });
      var offset = 20;
      var space = 12;
      var currentX = offset;
      points = points.reduce(function (acc, el) {
        acc.lines.push({
          x: currentX,
          height: 18
        });
        acc.text.push({
          x: currentX,
          text: el + '°'
        });

        if (el < 90) {
          for (var i = 0; i < 4; i++) {
            currentX += space;
            acc.lines.push({
              x: currentX,
              height: 10
            });
          }
        }

        currentX += space;
        return acc;
      }, {
        lines: [],
        text: []
      });
      return points;
    }
  },
  mounted: function mounted() {
    rotatervue_type_script_lang_js_dragRotate.call(this);
    this.trackPositionStart = -this.$refs.track.offsetWidth / 2;
    this.trackPosition = this.trackPositionStart;
  },
  methods: {
    updateRotation: function updateRotation(value) {
      var rotation = value / this.oneDegreeToPixel;
      rotation = Math.max(Math.min(rotation, this.maxRotation), this.minRotation);
      this.trackPosition = this.trackPositionStart + value;
      this.$emit('input', rotation);
    }
  }
});

function rotatervue_type_script_lang_js_dragRotate() {
  var self = this;
  var down = Object(_esm5["merge"])(Object(_esm5["fromEvent"])(self.$refs.rotater, 'mousedown'), Object(_esm5["fromEvent"])(self.$refs.rotater, 'touchstart'));
  var move = Object(_esm5["merge"])(Object(_esm5["fromEvent"])(document, 'mousemove'), Object(_esm5["fromEvent"])(document, 'touchmove'));
  var up = Object(_esm5["merge"])(Object(_esm5["fromEvent"])(document, 'mouseup'), Object(_esm5["fromEvent"])(document, 'touchend'));
  down.pipe(Object(operators["mergeMap"])(function (downEvents) {
    var startPos = rotatervue_type_script_lang_js_getPositionFromEvent(downEvents);
    return move.pipe(Object(operators["map"])(function (moveEvents) {
      moveEvents.preventDefault();
      var movePos = rotatervue_type_script_lang_js_getPositionFromEvent(moveEvents);
      return {
        x: movePos.x - startPos.x
      };
    }), Object(operators["takeUntil"])(up));
  })).subscribe(function (move) {
    self.moveRatation = move.x * 0.3;
    var moveChange = self.currentRotation + self.moveRatation;
    moveChange = Math.max(Math.min(moveChange, self.maxRotation * self.oneDegreeToPixel), self.minRotation * self.oneDegreeToPixel);
    self.updateRotation(moveChange);
  });
  up.subscribe(function () {
    self.currentRotation += self.moveRatation;
    self.currentRotation = Math.max(Math.min(self.currentRotation, self.maxRotation * self.oneDegreeToPixel), self.minRotation * self.oneDegreeToPixel);
  });
}

function rotatervue_type_script_lang_js_getPositionFromEvent(evt) {
  if (evt.touches) {
    evt = evt.touches[0];
  }

  return {
    x: evt.clientX
  };
}
// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/components/rotater.vue?vue&type=script&lang=js&
 /* harmony default export */ var components_rotatervue_type_script_lang_js_ = (rotatervue_type_script_lang_js_); 
// CONCATENATED MODULE: ./resources/assets/js/src/components/cropper/components/rotater.vue





/* normalize component */

var rotater_component = Object(componentNormalizer["default"])(
  components_rotatervue_type_script_lang_js_,
  rotatervue_type_template_id_dc07d9a8_render,
  rotatervue_type_template_id_dc07d9a8_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var rotater_api; }
rotater_component.options.__file = "resources/assets/js/src/components/cropper/components/rotater.vue"
/* harmony default export */ var rotater = (rotater_component.exports);
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


/* harmony default export */ var Croppervue_type_script_lang_js_ = ({
  props: ['image', 'useRotator', 'ratio'],
  components: {
    'rotater-input': rotater
  },
  data: function data() {
    return {
      cropper: null,
      rotationValue: 0,
      defaultOptions: {
        background: false
      }
    };
  },
  mounted: function mounted() {
    this.cropper = new cropper_esm["default"](this.$refs.img, this.options);
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
        this.rotationValue = value;
        this.cropper.rotateTo(this.rotationValue);
      }
    }
  },
  methods: {
    dragImage: function dragImage(evt) {
      evt.preventDefault();
      this.cropper.setDragMode('move');
    },
    dragCrop: function dragCrop(evt) {
      evt.preventDefault();
      this.cropper.setDragMode('crop');
    },
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
          text: 'No Image was passed to the cropper!',
          type: 'error'
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


var cropper_cropper;
function cropper_Cropper() {
  var cropperEl = document.createElement('div');
  cropperEl.classList.add('.c-cropper__wrapper');
  document.body.appendChild(cropperEl);
  cropper_cropper = new vue_default.a({
    render: function render(h) {
      return h(cropper_App);
    }
  }).$mount(cropperEl);
}
function setCropperImage(options) {
  return new Promise(function (resolve) {
    cropper_cropper.$emit('setOptions', options);
    cropper_cropper.$on('cropImage', resolve);
  });
}
// CONCATENATED MODULE: ./resources/assets/js/src/components/index.js




// EXTERNAL MODULE: ./node_modules/vuebar/vuebar.js
var vuebar = __webpack_require__("./node_modules/vuebar/vuebar.js");
var vuebar_default = /*#__PURE__*/__webpack_require__.n(vuebar);

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

function feedbackForm() {// controller('.js-feedback-form')
}
// CONCATENATED MODULE: ./resources/assets/js/src/index.js








function src_init() {
  init();
  ui_jump.init(650, 150);
  sidebar_init();
  Notifications();
  accordion_init();
  video_init();
  map_init();
  setupModals();
  scroll_anim_init(); // add c-grid-anim | c-line-anim | c-scroll-anim--fade-up with js-scroll-anim to animate a component on scroll

  trees();
  tables();
  initialiseFormElements();
  registerFormSaveEvents(); // resetForm()

  Fields();
  Dashboard();
  Tabs();
  PageEdit();
  cropperTest();
  formSubmits();
}

function formSubmits() {
  setupPageLeave();
  var formEls = document.querySelectorAll('form.o-form');
  var forms = Array.from(formEls);
  forms.forEach(function (form) {
    form.addEventListener('submit', function () {
      allowPageLeave();
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
        path: 'https://picsum.photos/1920/1080/?random'
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

/***/ })

/******/ });
//# sourceMappingURL=main.4b7843b120ed2b5c9def.js.map