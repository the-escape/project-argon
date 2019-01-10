loadjs=function(){var l=function(){},c={},f={},u={};function s(e,n){if(e){var t=u[e];if(f[e]=n,t)for(;t.length;)t[0](e,n),t.splice(0,1)}}function o(e,n){e.call&&(e={success:e}),n.length?(e.error||l)(n):(e.success||l)(e)}function h(t,r,i,c){var s,o,e=document,n=i.async,f=(i.numRetries||0)+1,u=i.before||l,a=t.replace(/^(css|img)!/,"");c=c||0,/(^css!|\.css$)/.test(t)?(s=!0,(o=e.createElement("link")).rel="stylesheet",o.href=a):/(^img!|\.(png|gif|jpg|svg)$)/.test(t)?(o=e.createElement("img")).src=a:((o=e.createElement("script")).src=t,o.async=void 0===n||n),!(o.onload=o.onerror=o.onbeforeload=function(e){var n=e.type[0];if(s&&"hideFocus"in o)try{o.sheet.cssText.length||(n="e")}catch(e){n="e"}if("e"==n&&(c+=1)<f)return h(t,r,i,c);r(t,n,e.defaultPrevented)})!==u(t,o)&&e.head.appendChild(o)}function t(e,n,t){var r,i;if(n&&n.trim&&(r=n),i=(r?t:n)||{},r){if(r in c)throw"LoadJS";c[r]=!0}!function(e,r,n){var t,i,c=(e=e.push?e:[e]).length,s=c,o=[];for(t=function(e,n,t){if("e"==n&&o.push(e),"b"==n){if(!t)return;o.push(e)}--c||r(o)},i=0;i<s;i++)h(e[i],t,n)}(e,function(e){o(i,e),s(r,e)},i)}return t.ready=function(e,n){return function(e,t){e=e.push?e:[e];var n,r,i,c=[],s=e.length,o=s;for(n=function(e,n){n.length&&c.push(e),--o||t(c)};s--;)r=e[s],(i=f[r])?n(r,i):(u[r]=u[r]||[]).push(n)}(e,function(e){o(n,e)}),t},t.done=function(e){s(e,[])},t.reset=function(){c={},f={},u={}},t.isDefined=function(e){return e in c},t}();
!function(a,b){"function"==typeof define&&define.amd?define([],function(){return a.svg4everybody=b()}):"object"==typeof module&&module.exports?module.exports=b():a.svg4everybody=b()}(this,function(){function a(a,b,c){if(c){var d=document.createDocumentFragment(),e=!b.hasAttribute("viewBox")&&c.getAttribute("viewBox");e&&b.setAttribute("viewBox",e);for(var f=c.cloneNode(!0);f.childNodes.length;)d.appendChild(f.firstChild);a.appendChild(d)}}function b(b){b.onreadystatechange=function(){if(4===b.readyState){var c=b._cachedDocument;c||(c=b._cachedDocument=document.implementation.createHTMLDocument(""),c.body.innerHTML=b.responseText,b._cachedTarget={}),b._embeds.splice(0).map(function(d){var e=b._cachedTarget[d.id];e||(e=b._cachedTarget[d.id]=c.getElementById(d.id)),a(d.parent,d.svg,e)})}},b.onreadystatechange()}function c(c){function e(){for(var c=0;c<o.length;){var h=o[c],i=h.parentNode,j=d(i),k=h.getAttribute("xlink:href")||h.getAttribute("href");if(!k&&g.attributeName&&(k=h.getAttribute(g.attributeName)),j&&k){if(f)if(!g.validate||g.validate(k,j,h)){i.removeChild(h);var l=k.split("#"),q=l.shift(),r=l.join("#");if(q.length){var s=m[q];s||(s=m[q]=new XMLHttpRequest,s.open("GET",q),s.send(),s._embeds=[]),s._embeds.push({parent:i,svg:j,id:r}),b(s)}else a(i,j,document.getElementById(r))}else++c,++p}else++c}(!o.length||o.length-p>0)&&n(e,67)}var f,g=Object(c),h=/\bTrident\/[567]\b|\bMSIE (?:9|10)\.0\b/,i=/\bAppleWebKit\/(\d+)\b/,j=/\bEdge\/12\.(\d+)\b/,k=/\bEdge\/.(\d+)\b/,l=window.top!==window.self;f="polyfill"in g?g.polyfill:h.test(navigator.userAgent)||(navigator.userAgent.match(j)||[])[1]<10547||(navigator.userAgent.match(i)||[])[1]<537||k.test(navigator.userAgent)&&l;var m={},n=window.requestAnimationFrame||setTimeout,o=document.getElementsByTagName("use"),p=0;f&&e()}function d(a){for(var b=a;"svg"!==b.nodeName.toLowerCase()&&(b=b.parentNode););return b}return c});
closest()
assign()
remove()
arrayFrom()
findIndex()
stringIncludes()

function closest () {
    // matches polyfill
    window.Element &&
        (function (ElementPrototype) {
            ElementPrototype.matches =
                ElementPrototype.matches ||
                ElementPrototype.matchesSelector ||
                ElementPrototype.webkitMatchesSelector ||
                ElementPrototype.msMatchesSelector ||
                function (selector) {
                    var node = this
                    var nodes = (
                        node.parentNode || node.document
                    ).querySelectorAll(selector)
                    var i = -1
                    while (nodes[++i] && nodes[i] !== node);
                    return !!nodes[i]
                }
        })(Element.prototype)

    // closest polyfill
    window.Element &&
        (function (ElementPrototype) {
            ElementPrototype.closest =
                ElementPrototype.closest ||
                function (selector) {
                    var el = this
                    while (el.matches && !el.matches(selector)) {
                        el = el.parentNode
                    }
                    return el.matches ? el : null
                }
        })(Element.prototype)
}

function assign () {
    if (typeof Object.assign !== 'function') {
        // Must be writable: true, enumerable: false, configurable: true
        Object.defineProperty(Object, 'assign', {
            value: function assign (target, varArgs) {
                // .length of function is 2
                'use strict'
                if (target == null) {
                    // TypeError if undefined or null
                    throw new TypeError(
                        'Cannot convert undefined or null to object'
                    )
                }

                var to = Object(target)

                for (var index = 1; index < arguments.length; index++) {
                    var nextSource = arguments[index]

                    if (nextSource != null) {
                        // Skip over if undefined or null
                        for (var nextKey in nextSource) {
                            // Avoid bugs when hasOwnProperty is shadowed
                            if (
                                Object.prototype.hasOwnProperty.call(
                                    nextSource,
                                    nextKey
                                )
                            ) {
                                to[nextKey] = nextSource[nextKey]
                            }
                        }
                    }
                }
                return to
            },
            writable: true,
            configurable: true
        })
    }
}

function remove () {
    // from:https://github.com/jserz/js_piece/blob/master/DOM/ChildNode/remove()/remove().md
    window.Element &&
        (function (arr) {
            arr.forEach(function (item) {
                if (item.hasOwnProperty('remove')) {
                    return
                }

                Object.defineProperty(item, 'remove', {
                    configurable: true,
                    enumerable: true,
                    writable: true,
                    value: function remove () {
                        if (this.parentNode !== null) {
                            this.parentNode.removeChild(this)
                        }
                    }
                })
            })
        })([Element.prototype, CharacterData.prototype, DocumentType.prototype])
}

function arrayFrom () {
    // Production steps of ECMA-262, Edition 6, 22.1.2.1
    if (!Array.from) {
        Array.from = (function () {
            var toStr = Object.prototype.toString
            var isCallable = function (fn) {
                return (
                    typeof fn === 'function' ||
                    toStr.call(fn) === '[object Function]'
                )
            }
            var toInteger = function (value) {
                var number = Number(value)
                if (isNaN(number)) {
                    return 0
                }
                if (number === 0 || !isFinite(number)) {
                    return number
                }
                return (number > 0 ? 1 : -1) * Math.floor(Math.abs(number))
            }
            var maxSafeInteger = Math.pow(2, 53) - 1
            var toLength = function (value) {
                var len = toInteger(value)
                return Math.min(Math.max(len, 0), maxSafeInteger)
            }

            // The length property of the from method is 1.
            return function from (arrayLike /*, mapFn, thisArg */) {
                // 1. Let C be the this value.
                var C = this

                // 2. Let items be ToObject(arrayLike).
                var items = Object(arrayLike)

                // 3. ReturnIfAbrupt(items).
                if (arrayLike == null) {
                    throw new TypeError(
                        'Array.from requires an array-like object - not null or undefined'
                    )
                }

                // 4. If mapfn is undefined, then let mapping be false.
                var mapFn = arguments.length > 1 ? arguments[1] : void undefined
                var T
                if (typeof mapFn !== 'undefined') {
                    // 5. else
                    // 5. a If IsCallable(mapfn) is false, throw a TypeError exception.
                    if (!isCallable(mapFn)) {
                        throw new TypeError(
                            'Array.from: when provided, the second argument must be a function'
                        )
                    }

                    // 5. b. If thisArg was supplied, let T be thisArg; else let T be undefined.
                    if (arguments.length > 2) {
                        T = arguments[2]
                    }
                }

                // 10. Let lenValue be Get(items, "length").
                // 11. Let len be ToLength(lenValue).
                var len = toLength(items.length)

                // 13. If IsConstructor(C) is true, then
                // 13. a. Let A be the result of calling the [[Construct]] internal method
                // of C with an argument list containing the single item len.
                // 14. a. Else, Let A be ArrayCreate(len).
                var A = isCallable(C) ? Object(new C(len)) : new Array(len)

                // 16. Let k be 0.
                var k = 0
                // 17. Repeat, while k < len… (also steps a - h)
                var kValue
                while (k < len) {
                    kValue = items[k]
                    if (mapFn) {
                        A[k] =
                            typeof T === 'undefined'
                                ? mapFn(kValue, k)
                                : mapFn.call(T, kValue, k)
                    } else {
                        A[k] = kValue
                    }
                    k += 1
                }
                // 18. Let putStatus be Put(A, "length", len, true).
                A.length = len
                // 20. Return A.
                return A
            }
        })()
    }
}

function findIndex () {
    // https://tc39.github.io/ecma262/#sec-array.prototype.findindex
    if (!Array.prototype.findIndex) {
        Object.defineProperty(Array.prototype, 'findIndex', {
            value: function (predicate) {
                // 1. Let O be ? ToObject(this value).
                if (this == null) {
                    throw new TypeError('"this" is null or not defined')
                }

                var o = Object(this)

                // 2. Let len be ? ToLength(? Get(O, "length")).
                var len = o.length >>> 0

                // 3. If IsCallable(predicate) is false, throw a TypeError exception.
                if (typeof predicate !== 'function') {
                    throw new TypeError('predicate must be a function')
                }

                // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.
                var thisArg = arguments[1]

                // 5. Let k be 0.
                var k = 0

                // 6. Repeat, while k < len
                while (k < len) {
                    // a. Let Pk be ! ToString(k).
                    // b. Let kValue be ? Get(O, Pk).
                    // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
                    // d. If testResult is true, return k.
                    var kValue = o[k]
                    if (predicate.call(thisArg, kValue, k, o)) {
                        return k
                    }
                    // e. Increase k by 1.
                    k++
                }

                // 7. Return -1.
                return -1
            },
            configurable: true,
            writable: true
        })
    }
}

function stringIncludes () {
    if (!String.prototype.includes) {
        Object.defineProperty(String.prototype, 'includes', {
            value: function (search, start) {
                if (typeof start !== 'number') {
                    start = 0
                }

                if (start + search.length > this.length) {
                    return false
                } else {
                    return this.indexOf(search, start) !== -1
                }
            }
        })
    }
}
