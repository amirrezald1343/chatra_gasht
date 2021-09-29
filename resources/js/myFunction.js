window._ = {
    isEmpty: function (value) {
        if (typeof value == "undefined" || value == "undefined" || value == null || value == "") {
            return true;
        }
        for (var key in value) {
            if (hasOwnProperty.call(value, key)) {
                return false;
            }
        }
        return false;
    },
    isNumber: function (value, length = value.length) {
        this.decision()
        return !this.isEmpty(value) && !isNaN(value) && value.length === length;
    },
    stripTags: function (html) {
        var tmp = document.createElement("DIV");
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || "";
    },
    sepereteStr: function (string, minLength) {
        if (this.isEmpty(string)) return false;
        let arrStr = string.trim().split(/[\s,]+/);
        if (this.isEmpty(minLength)) return arrStr.join();
        let newarray = new Array();
        arrStr.forEach(function (value, index, array) {
            if (value.length >= minLength) newarray.push(value)
        });
        return newarray.join()
    },
    jsonp: function (url, callback) {
        var callbackName = 'jsonp_callback_' + Math.round(100000 * Math.random());
        window[callbackName] = function (data) {
            delete window[callbackName];
            document.body.removeChild(script);
            callback(data);
        };
        var script = document.createElement('script');
        script.src = url + (url.indexOf('?') >= 0 ? '&' : '?') + 'callback=' + callbackName;
        document.body.appendChild(script);
    },
    setCookie: function (name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    },
    getCookie: function (name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    },
    eraseCookie: function (name) {
        document.cookie = name + '=; Max-Age=-99999999;';
    },
    parents: function (el, selector, stopSelector) {
        let retval = null;
        if (this.isEmpty(selector)) return el.parentNode;
        while (el) {
            if (el.matches(selector)) {
                retval = el;
                break
            } else if (stopSelector && el.matches(stopSelector)) {
                break
            }
            el = el.parentElement;
        }
        return retval;
    },
    getOffsetLeft: function (elem) {
        let offsetLeft = 0;
        do {
            if (!isNaN(elem.offsetLeft)) {
                offsetLeft += elem.offsetLeft;
            }
        } while (elem = elem.offsetParent);
        return offsetLeft;
    },
    domParser: function (stringTag) {
        let el = document.createElement('div');
        el.innerHTML = stringTag;
        return el.firstChild;
    },
    rmAllDomClass: function (dom,className) {
        Array.from(dom).forEach((elem, index) => {
            elem.classList.remove(className);
        });
    },
    toItemScroll: function (parent,element,x_px) {
        let ele = document.querySelector(parent);
        if (ele.scrollHeight > ele.offsetHeight) {
            let elem = ele.querySelector(element);
            ele.scrollTop = elem.offsetTop + x_px;
        }
    },
    hasSelector: function (selector) {
        return !this.isEmpty(document.querySelector(selector));
    }
};