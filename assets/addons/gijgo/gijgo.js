var gj = {};
(gj.widget = function () {
    var a = this;
    (a.xhr = null),
        (a.generateGUID = function () {
            function a() {
                return Math.floor(65536 * (1 + Math.random()))
                    .toString(16)
                    .substring(1);
            }
            return a() + a() + "-" + a() + "-" + a() + "-" + a() + "-" + a() + a() + a();
        }),
        (a.mouseX = function (a) {
            if (a) {
                if (a.pageX) return a.pageX;
                if (a.clientX) return a.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
                if (a.touches && a.touches.length) return a.touches[0].pageX;
                if (a.changedTouches && a.changedTouches.length) return a.changedTouches[0].pageX;
                if (a.originalEvent && a.originalEvent.touches && a.originalEvent.touches.length) return a.originalEvent.touches[0].pageX;
                if (a.originalEvent && a.originalEvent.changedTouches && a.originalEvent.changedTouches.length) return a.originalEvent.touches[0].pageX;
            }
            return null;
        }),
        (a.mouseY = function (a) {
            if (a) {
                if (a.pageY) return a.pageY;
                if (a.clientY) return a.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
                if (a.touches && a.touches.length) return a.touches[0].pageY;
                if (a.changedTouches && a.changedTouches.length) return a.changedTouches[0].pageY;
                if (a.originalEvent && a.originalEvent.touches && a.originalEvent.touches.length) return a.originalEvent.touches[0].pageY;
                if (a.originalEvent && a.originalEvent.changedTouches && a.originalEvent.changedTouches.length) return a.originalEvent.touches[0].pageY;
            }
            return null;
        });
}),
    (gj.widget.prototype.init = function (a, b) {
        var c, d, e;
        this.attr("data-type", b), (d = $.extend(!0, {}, this.getHTMLConfig() || {})), $.extend(!0, d, a || {}), (e = this.getConfig(d, b)), this.attr("data-guid", e.guid), this.data(e);
        for (c in e) gj[b].events.hasOwnProperty(c) && (this.on(c, e[c]), delete e[c]);
        for (plugin in gj[b].plugins) gj[b].plugins.hasOwnProperty(plugin) && gj[b].plugins[plugin].configure(this, e, d);
        return this;
    }),
    (gj.widget.prototype.getConfig = function (a, b) {
        var c, d, e, f;
        (c = $.extend(!0, {}, gj[b].config.base)),
            (d = a.hasOwnProperty("uiLibrary") ? a.uiLibrary : c.uiLibrary),
            gj[b].config[d] && $.extend(!0, c, gj[b].config[d]),
            (e = a.hasOwnProperty("iconsLibrary") ? a.iconsLibrary : c.iconsLibrary),
            gj[b].config[e] && $.extend(!0, c, gj[b].config[e]);
        for (f in gj[b].plugins)
            gj[b].plugins.hasOwnProperty(f) &&
                ($.extend(!0, c, gj[b].plugins[f].config.base), gj[b].plugins[f].config[d] && $.extend(!0, c, gj[b].plugins[f].config[d]), gj[b].plugins[f].config[e] && $.extend(!0, c, gj[b].plugins[f].config[e]));
        return $.extend(!0, c, a), c.guid || (c.guid = this.generateGUID()), c;
    }),
    (gj.widget.prototype.getHTMLConfig = function () {
        var a = this.data(),
            b = this[0].attributes;
        return b.width && (a.width = b.width.value), b.height && (a.height = b.height.value), b.value && (a.value = b.value.value), b.align && (a.align = b.align.value), a && a.source && ((a.dataSource = a.source), delete a.source), a;
    }),
    (gj.widget.prototype.createDoneHandler = function () {
        var a = this;
        return function (b) {
            "string" == typeof b && JSON && (b = JSON.parse(b)), gj[a.data("type")].methods.render(a, b);
        };
    }),
    (gj.widget.prototype.createErrorHandler = function () {
        return function (a) {
            a && a.statusText && "abort" !== a.statusText && alert(a.statusText);
        };
    }),
    (gj.widget.prototype.reload = function (a) {
        var b,
            c,
            d = this.data(),
            e = this.data("type");
        return (
            void 0 === d.dataSource && gj[e].methods.useHtmlDataSource(this, d),
            $.extend(d.params, a),
            $.isArray(d.dataSource)
                ? ((c = gj[e].methods.filter(this)), gj[e].methods.render(this, c))
                : "string" == typeof d.dataSource
                ? ((b = { url: d.dataSource, data: d.params }), this.xhr && this.xhr.abort(), (this.xhr = $.ajax(b).done(this.createDoneHandler()).fail(this.createErrorHandler())))
                : "object" == typeof d.dataSource &&
                  (d.dataSource.data || (d.dataSource.data = {}),
                  $.extend(d.dataSource.data, d.params),
                  (b = $.extend(!0, {}, d.dataSource)),
                  "json" === b.dataType && "object" == typeof b.data && (b.data = JSON.stringify(b.data)),
                  b.success || (b.success = this.createDoneHandler()),
                  b.error || (b.error = this.createErrorHandler()),
                  this.xhr && this.xhr.abort(),
                  (this.xhr = $.ajax(b))),
            this
        );
    }),
    (gj.documentManager = {
        events: {},
        subscribeForEvent: function (a, b, c) {
            if (gj.documentManager.events[a] && 0 !== gj.documentManager.events[a].length) {
                if (gj.documentManager.events[a][b]) throw "Event " + a + ' for widget with guid="' + b + '" is already attached.';
                gj.documentManager.events[a].push({ widgetId: b, callback: c });
            } else (gj.documentManager.events[a] = [{ widgetId: b, callback: c }]), $(document).on(a, gj.documentManager.executeCallbacks);
        },
        executeCallbacks: function (a) {
            var b = gj.documentManager.events[a.type];
            if (b) for (var c = 0; c < b.length; c++) b[c].callback(a);
        },
        unsubscribeForEvent: function (a, b) {
            var c = !1,
                d = gj.documentManager.events[a];
            if (d) for (var e = 0; e < d.length; e++) d[e].widgetId === b && (d.splice(e, 1), (c = !0), 0 === d.length && ($(document).off(a), delete gj.documentManager.events[a]));
            if (!c) throw 'The "' + a + '" for widget with guid="' + b + "\" can't be removed.";
        },
    }),
    (gj.core = {
        messages: {
            "en-us": {
                monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                monthShortNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                weekDaysMin: ["S", "M", "T", "W", "T", "F", "S"],
                weekDaysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                weekDays: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                am: "AM",
                pm: "PM",
                ok: "Ok",
                cancel: "Cancel",
                titleFormat: "mmmm yyyy",
            },
        },
        parseDate: function (a, b, c) {
            var d,
                e,
                f,
                g,
                h = 0,
                i = 0,
                j = 1,
                k = 0,
                l = 0;
            if (a && "string" == typeof a) {
                if (/^\d+$/.test(a)) g = new Date(a);
                else if (a.indexOf("/Date(") > -1) g = new Date(parseInt(a.substr(6), 10));
                else if (a) {
                    for (f = b.split(/[\s,-\.\/\/\:]+/), e = a.split(/[\s]+/), e.length != f.length && (e = a.split(/[\s,-\.\/\/\:]+/)), d = 0; d < f.length; d++)
                        ["d", "dd"].indexOf(f[d]) > -1
                            ? (j = parseInt(e[d], 10))
                            : ["m", "mm"].indexOf(f[d]) > -1
                            ? (i = parseInt(e[d], 10) - 1)
                            : "mmm" === f[d]
                            ? (i = gj.core.messages[c || "en-us"].monthShortNames.indexOf(e[d]))
                            : "mmmm" === f[d]
                            ? (i = gj.core.messages[c || "en-us"].monthNames.indexOf(e[d]))
                            : ["yy", "yyyy"].indexOf(f[d]) > -1
                            ? ((h = parseInt(e[d], 10)), "yy" === f[d] && (h += 2e3))
                            : ["h", "hh", "H", "HH"].indexOf(f[d]) > -1
                            ? (k = parseInt(e[d], 10))
                            : ["M", "MM"].indexOf(f[d]) > -1 && (l = parseInt(e[d], 10));
                    g = new Date(h, i, j, k, l);
                }
            } else "number" == typeof a ? (g = new Date(a)) : a instanceof Date && (g = a);
            return g;
        },
        formatDate: function (a, b, c) {
            var d,
                e,
                f = "",
                g = b.split(/[\s,-\.\/\/\:]+/),
                h = b.split(/s+|M+|H+|h+|t+|T+|d+|m+|y+/);
            for (h = h.splice(1, h.length - 2), i = 0; i < g.length; i++)
                switch (((d = h[i] || ""), g[i])) {
                    case "s":
                        f += a.getSeconds() + d;
                        break;
                    case "ss":
                        f += gj.core.pad(a.getSeconds()) + d;
                        break;
                    case "M":
                        f += a.getMinutes() + d;
                        break;
                    case "MM":
                        f += gj.core.pad(a.getMinutes()) + d;
                        break;
                    case "H":
                        f += a.getHours() + d;
                        break;
                    case "HH":
                        f += gj.core.pad(a.getHours()) + d;
                        break;
                    case "h":
                        (e = a.getHours() > 12 ? a.getHours() % 12 : a.getHours()), (f += e + d);
                        break;
                    case "hh":
                        (e = a.getHours() > 12 ? a.getHours() % 12 : a.getHours()), (f += gj.core.pad(e) + d);
                        break;
                    case "tt":
                        f += (a.getHours() >= 12 ? "pm" : "am") + d;
                        break;
                    case "TT":
                        f += (a.getHours() >= 12 ? "PM" : "AM") + d;
                        break;
                    case "d":
                        f += a.getDate() + d;
                        break;
                    case "dd":
                        f += gj.core.pad(a.getDate()) + d;
                        break;
                    case "ddd":
                        f += gj.core.messages[c || "en-us"].weekDaysShort[a.getDay()] + d;
                        break;
                    case "dddd":
                        f += gj.core.messages[c || "en-us"].weekDays[a.getDay()] + d;
                        break;
                    case "m":
                        f += a.getMonth() + 1 + d;
                        break;
                    case "mm":
                        f += gj.core.pad(a.getMonth() + 1) + d;
                        break;
                    case "mmm":
                        f += gj.core.messages[c || "en-us"].monthShortNames[a.getMonth()] + d;
                        break;
                    case "mmmm":
                        f += gj.core.messages[c || "en-us"].monthNames[a.getMonth()] + d;
                        break;
                    case "yy":
                        f += a.getFullYear().toString().substr(2) + d;
                        break;
                    case "yyyy":
                        f += a.getFullYear() + d;
                }
            return f;
        },
        pad: function (a, b) {
            for (a = String(a), b = b || 2; a.length < b; ) a = "0" + a;
            return a;
        },
        center: function (a) {
            var b = $(window).width() / 2 - a.width() / 2,
                c = $(window).height() / 2 - a.height() / 2;
            a.css("position", "absolute"), a.css("left", b > 0 ? b : 0), a.css("top", c > 0 ? c : 0);
        },
        isIE: function () {
            return !!navigator.userAgent.match(/Trident/g) || !!navigator.userAgent.match(/MSIE/g);
        },
        setChildPosition: function (a, b) {
            var c = a.getBoundingClientRect(),
                d = gj.core.height(a, !0),
                e = gj.core.height(b, !0),
                f = gj.core.width(a, !0),
                g = gj.core.width(b, !0),
                h = window.scrollY || window.pageYOffset || 0,
                i = window.scrollX || window.pageXOffset || 0;
            c.top + d + e > window.innerHeight && c.top > e ? (b.style.top = Math.round(c.top + h - e - 3) + "px") : (b.style.top = Math.round(c.top + h + d + 3) + "px"),
                c.left + g > document.body.clientWidth ? (b.style.left = Math.round(c.left + i + f - g) + "px") : (b.style.left = Math.round(c.left + i) + "px");
        },
        height: function (a, b) {
            var c,
                d = window.getComputedStyle(a);
            return (
                "border-box" === d.boxSizing
                    ? ((c = parseInt(d.height, 10)), gj.core.isIE() && ((c += parseInt(d.paddingTop || 0, 10) + parseInt(d.paddingBottom || 0, 10)), (c += parseInt(d.borderTopWidth || 0, 10) + parseInt(d.borderBottomWidth || 0, 10))))
                    : ((c = parseInt(d.height, 10)), (c += parseInt(d.paddingTop || 0, 10) + parseInt(d.paddingBottom || 0, 10)), (c += parseInt(d.borderTopWidth || 0, 10) + parseInt(d.borderBottomWidth || 0, 10))),
                b && (c += parseInt(d.marginTop || 0, 10) + parseInt(d.marginBottom || 0, 10)),
                c
            );
        },
        width: function (a, b) {
            var c,
                d = window.getComputedStyle(a);
            return (
                "border-box" === d.boxSizing
                    ? (c = parseInt(d.width, 10))
                    : ((c = parseInt(d.width, 10)), (c += parseInt(d.paddingLeft || 0, 10) + parseInt(d.paddingRight || 0, 10)), (c += parseInt(d.borderLeftWidth || 0, 10) + parseInt(d.borderRightWidth || 0, 10))),
                b && (c += parseInt(d.marginLeft || 0, 10) + parseInt(d.marginRight || 0, 10)),
                c
            );
        },
        addClasses: function (a, b) {
            var c, d;
            if (b) for (d = b.split(" "), c = 0; c < d.length; c++) a.classList.add(d[c]);
        },
        position: function (a) {
            for (var b, c, d = 0, e = 0, f = gj.core.height(a), g = gj.core.width(a); a; )
                "BODY" == a.tagName
                    ? ((b = a.scrollLeft || document.documentElement.scrollLeft), (c = a.scrollTop || document.documentElement.scrollTop), (d += a.offsetLeft - b), (e += a.offsetTop - c))
                    : ((d += a.offsetLeft - a.scrollLeft), (e += a.offsetTop - a.scrollTop)),
                    (a = a.offsetParent);
            return { top: e, left: d, bottom: e + f, right: d + g };
        },
        setCaretAtEnd: function (a) {
            var b;
            if (a)
                if (((b = a.value.length), document.selection)) {
                    a.focus();
                    var c = document.selection.createRange();
                    c.moveStart("character", -b), c.moveStart("character", b), c.moveEnd("character", 0), c.select();
                } else (a.selectionStart || "0" == a.selectionStart) && ((a.selectionStart = b), (a.selectionEnd = b), a.focus());
        },
        getScrollParent: function (a) {
            return null == a ? null : a.scrollHeight > a.clientHeight ? a : gj.core.getScrollParent(a.parentNode);
        },
    }),
    (gj.picker = { messages: { "en-us": {} } }),
    (gj.picker.methods = {
        initialize: function (a, b, c) {
            var d,
                e = c.createPicker(a, b),
                f = a.parent('div[role="wrapper"]');
            (d =
                "bootstrap" === b.uiLibrary
                    ? $('<span class="input-group-addon">' + b.icons.rightIcon + "</span>")
                    : "bootstrap4" === b.uiLibrary
                    ? $('<span class="input-group-append"><button class="btn btn-outline-secondary border-left-0" type="button">' + b.icons.rightIcon + "</button></span>")
                    : $(b.icons.rightIcon)),
                d.attr("role", "right-icon"),
                0 === f.length ? ((f = $('<div role="wrapper" />').addClass(b.style.wrapper)), a.wrap(f)) : f.addClass(b.style.wrapper),
                (f = a.parent('div[role="wrapper"]')),
                b.width && f.css("width", b.width),
                a.val(b.value).addClass(b.style.input).attr("role", "input"),
                b.fontSize && a.css("font-size", b.fontSize),
                "bootstrap" === b.uiLibrary || "bootstrap4" === b.uiLibrary
                    ? "small" === b.size
                        ? (f.addClass("input-group-sm"), a.addClass("form-control-sm"))
                        : "large" === b.size && (f.addClass("input-group-lg"), a.addClass("form-control-lg"))
                    : "small" === b.size
                    ? f.addClass("small")
                    : "large" === b.size && f.addClass("large"),
                d.on("click", function (b) {
                    e.is(":visible") ? a.close() : a.open();
                }),
                f.append(d),
                !0 !== b.footer &&
                    (a.on("blur", function () {
                        a.timeout = setTimeout(function () {
                            a.close();
                        }, 500);
                    }),
                    e.mousedown(function () {
                        return clearTimeout(a.timeout), a.focus(), !1;
                    }),
                    e.on("click", function () {
                        clearTimeout(a.timeout), a.focus();
                    }));
        },
    }),
    (gj.picker.widget = function (a, b) {
        var c = this,
            d = gj.picker.methods;
        return (
            (c.destroy = function () {
                return d.destroy(this);
            }),
            a
        );
    }),
    (gj.picker.widget.prototype = new gj.widget()),
    (gj.picker.widget.constructor = gj.picker.widget),
    (gj.picker.widget.prototype.init = function (a, b, c) {
        return gj.widget.prototype.init.call(this, a, b), this.attr("data-" + b, "true"), gj.picker.methods.initialize(this, this.data(), gj[b].methods), this;
    }),
    (gj.picker.widget.prototype.open = function (a) {
        var b = this.data(),
            c = $("body").find('[role="picker"][guid="' + this.attr("data-guid") + '"]');
        return c.show(), c.closest('div[role="modal"]').show(), b.modal ? gj.core.center(c) : (gj.core.setChildPosition(this[0], c[0]), this.focus()), clearTimeout(this.timeout), gj[a].events.open(this), this;
    }),
    (gj.picker.widget.prototype.close = function (a) {
        var b = $("body").find('[role="picker"][guid="' + this.attr("data-guid") + '"]');
        return b.hide(), b.closest('div[role="modal"]').hide(), gj[a].events.close(this), this;
    }),
    (gj.picker.widget.prototype.destroy = function (a) {
        var b = this.data(),
            c = this.parent(),
            d = $("body").find('[role="picker"][guid="' + this.attr("data-guid") + '"]');
        return (
            b &&
                (this.off(),
                d.parent('[role="modal"]').length > 0 && d.unwrap(),
                d.remove(),
                this.removeData(),
                this.removeAttr("data-type")
                    .removeAttr("data-guid")
                    .removeAttr("data-" + a),
                this.removeClass(),
                c.children('[role="right-icon"]').remove(),
                this.unwrap()),
            this
        );
    }),
    (gj.dialog = { plugins: {}, messages: {} }),
    (gj.dialog.config = {
        base: {
            autoOpen: !0,
            closeButtonInHeader: !0,
            closeOnEscape: !0,
            draggable: !0,
            height: "auto",
            locale: "en-us",
            maxHeight: void 0,
            maxWidth: void 0,
            minHeight: void 0,
            minWidth: void 0,
            modal: !1,
            resizable: !1,
            scrollable: !1,
            title: void 0,
            uiLibrary: void 0,
            width: 300,
            style: {
                modal: "gj-modal",
                content: "gj-dialog-md",
                header: "gj-dialog-md-header gj-unselectable",
                headerTitle: "gj-dialog-md-title",
                headerCloseButton: "gj-dialog-md-close",
                body: "gj-dialog-md-body",
                footer: "gj-dialog-footer gj-dialog-md-footer",
            },
        },
        bootstrap: { style: { modal: "modal", content: "modal-content gj-dialog-bootstrap", header: "modal-header", headerTitle: "modal-title", headerCloseButton: "close", body: "modal-body", footer: "gj-dialog-footer modal-footer" } },
        bootstrap4: { style: { modal: "modal", content: "modal-content gj-dialog-bootstrap4", header: "modal-header", headerTitle: "modal-title", headerCloseButton: "close", body: "modal-body", footer: "gj-dialog-footer modal-footer" } },
    }),
    (gj.dialog.events = {
        initialized: function (a) {
            a.trigger("initialized");
        },
        opening: function (a) {
            a.trigger("opening");
        },
        opened: function (a) {
            a.trigger("opened");
        },
        closing: function (a) {
            a.trigger("closing");
        },
        closed: function (a) {
            a.trigger("closed");
        },
        drag: function (a) {
            a.trigger("drag");
        },
        dragStart: function (a) {
            a.trigger("dragStart");
        },
        dragStop: function (a) {
            a.trigger("dragStop");
        },
        resize: function (a) {
            a.trigger("resize");
        },
        resizeStart: function (a) {
            a.trigger("resizeStart");
        },
        resizeStop: function (a) {
            a.trigger("resizeStop");
        },
    }),
    (gj.dialog.methods = {
        init: function (a) {
            return gj.widget.prototype.init.call(this, a, "dialog"), gj.dialog.methods.localization(this), gj.dialog.methods.initialize(this), gj.dialog.events.initialized(this), this;
        },
        localization: function (a) {
            var b = a.data();
            void 0 === b.title && (b.title = gj.dialog.messages[b.locale].DefaultTitle);
        },
        getHTMLConfig: function () {
            var a = gj.widget.prototype.getHTMLConfig.call(this),
                b = this[0].attributes;
            return b.title && (a.title = b.title.value), a;
        },
        initialize: function (a) {
            var b,
                c,
                d,
                e = a.data();
            a.addClass(e.style.content),
                gj.dialog.methods.setSize(a),
                e.closeOnEscape &&
                    $(document).keyup(function (b) {
                        27 === b.keyCode && a.close();
                    }),
                (c = a.children('div[data-role="body"]')),
                0 === c.length ? ((c = $('<div data-role="body"/>').addClass(e.style.body)), a.wrapInner(c)) : c.addClass(e.style.body),
                (b = gj.dialog.methods.renderHeader(a)),
                (d = a.children('div[data-role="footer"]').addClass(e.style.footer)),
                a.find('[data-role="close"]').on("click", function () {
                    a.close();
                }),
                gj.draggable && (e.draggable && gj.dialog.methods.draggable(a, b), e.resizable && gj.dialog.methods.resizable(a)),
                e.scrollable &&
                    e.height &&
                    (a.addClass("gj-dialog-scrollable"),
                    a.on("opened", function () {
                        a.children('div[data-role="body"]').css("height", e.height - b.outerHeight() - (d.length ? d.outerHeight() : 0));
                    })),
                gj.core.center(a),
                e.modal && a.wrapAll('<div data-role="modal" class="' + e.style.modal + '"/>'),
                e.autoOpen && a.open();
        },
        setSize: function (a) {
            var b = a.data();
            b.width && a.css("width", b.width), b.height && a.css("height", b.height);
        },
        renderHeader: function (a) {
            var b,
                c,
                d,
                e = a.data();
            return (
                (b = a.children('div[data-role="header"]')),
                0 === b.length && ((b = $('<div data-role="header" />')), a.prepend(b)),
                b.addClass(e.style.header),
                (c = b.find('[data-role="title"]')),
                0 === c.length && ((c = $('<h4 data-role="title">' + e.title + "</h4>")), b.append(c)),
                c.addClass(e.style.headerTitle),
                (d = b.find('[data-role="close"]')),
                0 === d.length && e.closeButtonInHeader
                    ? ((d = $('<button type="button" data-role="close" title="' + gj.dialog.messages[e.locale].Close + '"><span>×</span></button>')), d.addClass(e.style.headerCloseButton), b.append(d))
                    : d.length > 0 && !1 === e.closeButtonInHeader
                    ? d.hide()
                    : d.addClass(e.style.headerCloseButton),
                b
            );
        },
        draggable: function (a, b) {
            a.appendTo("body"),
                b.addClass("gj-draggable"),
                a.draggable({
                    handle: b,
                    start: function () {
                        a.addClass("gj-unselectable"), gj.dialog.events.dragStart(a);
                    },
                    stop: function () {
                        a.removeClass("gj-unselectable"), gj.dialog.events.dragStop(a);
                    },
                });
        },
        resizable: function (a) {
            var b = {
                drag: gj.dialog.methods.resize,
                start: function () {
                    a.addClass("gj-unselectable"), gj.dialog.events.resizeStart(a);
                },
                stop: function () {
                    this.removeAttribute("style"), a.removeClass("gj-unselectable"), gj.dialog.events.resizeStop(a);
                },
            };
            a.append($('<div class="gj-resizable-handle gj-resizable-n"></div>').draggable($.extend(!0, { horizontal: !1 }, b))),
                a.append($('<div class="gj-resizable-handle gj-resizable-e"></div>').draggable($.extend(!0, { vertical: !1 }, b))),
                a.append($('<div class="gj-resizable-handle gj-resizable-s"></div>').draggable($.extend(!0, { horizontal: !1 }, b))),
                a.append($('<div class="gj-resizable-handle gj-resizable-w"></div>').draggable($.extend(!0, { vertical: !1 }, b))),
                a.append($('<div class="gj-resizable-handle gj-resizable-ne"></div>').draggable($.extend(!0, {}, b))),
                a.append($('<div class="gj-resizable-handle gj-resizable-nw"></div>').draggable($.extend(!0, {}, b))),
                a.append($('<div class="gj-resizable-handle gj-resizable-sw"></div>').draggable($.extend(!0, {}, b))),
                a.append($('<div class="gj-resizable-handle gj-resizable-se"></div>').draggable($.extend(!0, {}, b)));
        },
        resize: function (a, b) {
            var c,
                d,
                e,
                f,
                g,
                h,
                i,
                j,
                k = !1;
            return (
                (c = $(this)),
                (d = c.parent()),
                (e = gj.core.position(this)),
                (offset = { top: b.top - e.top, left: b.left - e.left }),
                (f = d.data()),
                c.hasClass("gj-resizable-n")
                    ? ((g = d.height() - offset.top), (i = d.offset().top + offset.top))
                    : c.hasClass("gj-resizable-e")
                    ? (h = d.width() + offset.left)
                    : c.hasClass("gj-resizable-s")
                    ? (g = d.height() + offset.top)
                    : c.hasClass("gj-resizable-w")
                    ? ((h = d.width() - offset.left), (j = d.offset().left + offset.left))
                    : c.hasClass("gj-resizable-ne")
                    ? ((g = d.height() - offset.top), (i = d.offset().top + offset.top), (h = d.width() + offset.left))
                    : c.hasClass("gj-resizable-nw")
                    ? ((g = d.height() - offset.top), (i = d.offset().top + offset.top), (h = d.width() - offset.left), (j = d.offset().left + offset.left))
                    : c.hasClass("gj-resizable-se")
                    ? ((g = d.height() + offset.top), (h = d.width() + offset.left))
                    : c.hasClass("gj-resizable-sw") && ((g = d.height() + offset.top), (h = d.width() - offset.left), (j = d.offset().left + offset.left)),
                g && (!f.minHeight || g >= f.minHeight) && (!f.maxHeight || g <= f.maxHeight) && (d.height(g), i && d.css("top", i), (k = !0)),
                h && (!f.minWidth || h >= f.minWidth) && (!f.maxWidth || h <= f.maxWidth) && (d.width(h), j && d.css("left", j), (k = !0)),
                k && gj.dialog.events.resize(d),
                k
            );
        },
        open: function (a, b) {
            var c;
            return (
                gj.dialog.events.opening(a),
                a.css("display", "block"),
                a.closest('div[data-role="modal"]').css("display", "block"),
                (c = a.children('div[data-role="footer"]')),
                c.length && c.outerHeight() && a.children('div[data-role="body"]').css("margin-bottom", c.outerHeight()),
                void 0 !== b && a.find('[data-role="title"]').html(b),
                gj.dialog.events.opened(a),
                a
            );
        },
        close: function (a) {
            return a.is(":visible") && (gj.dialog.events.closing(a), a.css("display", "none"), a.closest('div[data-role="modal"]').css("display", "none"), gj.dialog.events.closed(a)), a;
        },
        isOpen: function (a) {
            return a.is(":visible");
        },
        content: function (a, b) {
            var c = a.children('div[data-role="body"]');
            return void 0 === b ? c.html() : c.html(b);
        },
        destroy: function (a, b) {
            var c = a.data();
            return (
                c &&
                    (!1 === b
                        ? a.remove()
                        : (a.close(),
                          a.off(),
                          a.removeData(),
                          a.removeAttr("data-type"),
                          a.removeClass(c.style.content),
                          a.find('[data-role="header"]').removeClass(c.style.header),
                          a.find('[data-role="title"]').removeClass(c.style.headerTitle),
                          a.find('[data-role="close"]').remove(),
                          a.find('[data-role="body"]').removeClass(c.style.body),
                          a.find('[data-role="footer"]').removeClass(c.style.footer))),
                a
            );
        },
    }),
    (gj.dialog.widget = function (a, b) {
        var c = this,
            d = gj.dialog.methods;
        return (
            (c.open = function (a) {
                return d.open(this, a);
            }),
            (c.close = function () {
                return d.close(this);
            }),
            (c.isOpen = function () {
                return d.isOpen(this);
            }),
            (c.content = function (a) {
                return d.content(this, a);
            }),
            (c.destroy = function (a) {
                return d.destroy(this, a);
            }),
            $.extend(a, c),
            "dialog" !== a.attr("data-type") && d.init.call(a, b),
            a
        );
    }),
    (gj.dialog.widget.prototype = new gj.widget()),
    (gj.dialog.widget.constructor = gj.dialog.widget),
    (gj.dialog.widget.prototype.getHTMLConfig = gj.dialog.methods.getHTMLConfig),
    (function (a) {
        a.fn.dialog = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.dialog.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.dialog.widget(this, a);
            }
        };
    })(jQuery),
    (gj.dialog.messages["en-us"] = { Close: "Close", DefaultTitle: "Dialog" }),
    (gj.draggable = { plugins: {} }),
    (gj.draggable.config = { base: { handle: void 0, vertical: !0, horizontal: !0, containment: void 0 } }),
    (gj.draggable.methods = {
        init: function (a) {
            var b,
                c,
                d = this;
            return (
                gj.widget.prototype.init.call(this, a, "draggable"),
                (c = this.data()),
                d.attr("data-draggable", "true"),
                (b = gj.draggable.methods.getHandleElement(d)),
                b.on("touchstart mousedown", function (a) {
                    var e = gj.core.position(d[0]);
                    (d[0].style.top = e.top + "px"),
                        (d[0].style.left = e.left + "px"),
                        (d[0].style.position = "fixed"),
                        d.attr("draggable-dragging", !0),
                        d.removeAttr("draggable-x").removeAttr("draggable-y"),
                        gj.documentManager.subscribeForEvent("touchmove", d.data("guid"), gj.draggable.methods.createMoveHandler(d, b, c)),
                        gj.documentManager.subscribeForEvent("mousemove", d.data("guid"), gj.draggable.methods.createMoveHandler(d, b, c));
                }),
                gj.documentManager.subscribeForEvent("mouseup", d.data("guid"), gj.draggable.methods.createUpHandler(d)),
                gj.documentManager.subscribeForEvent("touchend", d.data("guid"), gj.draggable.methods.createUpHandler(d)),
                gj.documentManager.subscribeForEvent("touchcancel", d.data("guid"), gj.draggable.methods.createUpHandler(d)),
                d
            );
        },
        getHandleElement: function (a) {
            var b = a.data("handle");
            return b && b.length ? b : a;
        },
        createUpHandler: function (a) {
            return function (b) {
                "true" === a.attr("draggable-dragging") &&
                    (a.attr("draggable-dragging", !1),
                    gj.documentManager.unsubscribeForEvent("mousemove", a.data("guid")),
                    gj.documentManager.unsubscribeForEvent("touchmove", a.data("guid")),
                    gj.draggable.events.stop(a, { x: a.mouseX(b), y: a.mouseY(b) }));
            };
        },
        createMoveHandler: function (a, b, c) {
            return function (b) {
                var d, e, f, g, h, i;
                "true" === a.attr("draggable-dragging") &&
                    ((d = Math.round(a.mouseX(b))),
                    (e = Math.round(a.mouseY(b))),
                    (h = a.attr("draggable-x")),
                    (i = a.attr("draggable-y")),
                    h && i ? ((f = c.horizontal ? d - parseInt(h, 10) : 0), (g = c.vertical ? e - parseInt(i, 10) : 0), gj.draggable.methods.move(a[0], c, f, g, d, e)) : gj.draggable.events.start(a, d, e),
                    a.attr("draggable-x", d),
                    a.attr("draggable-y", e));
            };
        },
        move: function (a, b, c, d, e, f) {
            var g,
                h,
                i,
                j = gj.core.position(a),
                k = j.top + d,
                l = j.left + c;
            b.containment &&
                ((g = gj.core.position(b.containment)),
                (h = g.top + gj.core.height(b.containment) - gj.core.height(a)),
                (i = g.left + gj.core.width(b.containment) - gj.core.width(a)),
                k > g.top && k < h ? (g.top >= f || g.bottom <= f) && (k = j.top) : (k = k <= g.top ? g.top + 1 : h - 1),
                l > g.left && l < i ? (g.left >= e || g.right <= e) && (l = j.left) : (l = l <= g.left ? g.left + 1 : i - 1)),
                !1 !== gj.draggable.events.drag($(a), l, k, e, f) && ((a.style.top = k + "px"), (a.style.left = l + "px"));
        },
        destroy: function (a) {
            return (
                "true" === a.attr("data-draggable") &&
                    (gj.documentManager.unsubscribeForEvent("mouseup", a.data("guid")),
                    a.removeData(),
                    a.removeAttr("data-guid").removeAttr("data-type").removeAttr("data-draggable"),
                    a.removeAttr("draggable-x").removeAttr("draggable-y").removeAttr("draggable-dragging"),
                    (a[0].style.top = ""),
                    (a[0].style.left = ""),
                    (a[0].style.position = ""),
                    a.off("drag").off("start").off("stop"),
                    gj.draggable.methods.getHandleElement(a).off("mousedown")),
                a
            );
        },
    }),
    (gj.draggable.events = {
        drag: function (a, b, c, d, e) {
            return a.triggerHandler("drag", [
                { left: b, top: c },
                { x: d, y: e },
            ]);
        },
        start: function (a, b, c) {
            a.triggerHandler("start", [{ x: b, y: c }]);
        },
        stop: function (a, b) {
            a.triggerHandler("stop", [b]);
        },
    }),
    (gj.draggable.widget = function (a, b) {
        var c = this,
            d = gj.draggable.methods;
        return (
            a.destroy ||
                (c.destroy = function () {
                    return d.destroy(this);
                }),
            $.extend(a, c),
            "true" !== a.attr("data-draggable") && d.init.call(a, b),
            a
        );
    }),
    (gj.draggable.widget.prototype = new gj.widget()),
    (gj.draggable.widget.constructor = gj.draggable.widget),
    (function (a) {
        a.fn.draggable = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.draggable.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.draggable.widget(this, a);
            }
        };
    })(jQuery),
    (gj.droppable = { plugins: {} }),
    (gj.droppable.config = { hoverClass: void 0 }),
    (gj.droppable.methods = {
        init: function (a) {
            var b = this;
            return (
                gj.widget.prototype.init.call(this, a, "droppable"),
                b.attr("data-droppable", "true"),
                gj.documentManager.subscribeForEvent("mousedown", b.data("guid"), gj.droppable.methods.createMouseDownHandler(b)),
                gj.documentManager.subscribeForEvent("mousemove", b.data("guid"), gj.droppable.methods.createMouseMoveHandler(b)),
                gj.documentManager.subscribeForEvent("mouseup", b.data("guid"), gj.droppable.methods.createMouseUpHandler(b)),
                b
            );
        },
        createMouseDownHandler: function (a) {
            return function (b) {
                a.isDragging = !0;
            };
        },
        createMouseMoveHandler: function (a) {
            return function (b) {
                if (a.isDragging) {
                    var c = a.data("hoverClass"),
                        d = { x: a.mouseX(b), y: a.mouseY(b) },
                        e = gj.droppable.methods.isOver(a, d);
                    e != a.isOver && (e ? (c && a.addClass(c), gj.droppable.events.over(a, d)) : (c && a.removeClass(c), gj.droppable.events.out(a))), (a.isOver = e);
                }
            };
        },
        createMouseUpHandler: function (a) {
            return function (b) {
                var c = { left: a.mouseX(b), top: a.mouseY(b) };
                (a.isDragging = !1), gj.droppable.methods.isOver(a, c) && gj.droppable.events.drop(a);
            };
        },
        isOver: function (a, b) {
            var c = a.offset().top,
                d = a.offset().left;
            return b.x > d && b.x < d + a.outerWidth(!0) && b.y > c && b.y < c + a.outerHeight(!0);
        },
        destroy: function (a) {
            return (
                "true" === a.attr("data-droppable") &&
                    (gj.documentManager.unsubscribeForEvent("mousedown", a.data("guid")),
                    gj.documentManager.unsubscribeForEvent("mousemove", a.data("guid")),
                    gj.documentManager.unsubscribeForEvent("mouseup", a.data("guid")),
                    a.removeData(),
                    a.removeAttr("data-guid"),
                    a.removeAttr("data-droppable"),
                    a.off("drop").off("over").off("out")),
                a
            );
        },
    }),
    (gj.droppable.events = {
        drop: function (a, b, c) {
            a.trigger("drop", [{ top: c, left: b }]);
        },
        over: function (a, b) {
            a.trigger("over", [b]);
        },
        out: function (a) {
            a.trigger("out");
        },
    }),
    (gj.droppable.widget = function (a, b) {
        var c = this,
            d = gj.droppable.methods;
        return (
            (c.isOver = !1),
            (c.isDragging = !1),
            (c.destroy = function () {
                return d.destroy(this);
            }),
            (c.isOver = function (a) {
                return d.isOver(this, a);
            }),
            $.extend(a, c),
            "true" !== a.attr("data-droppable") && d.init.call(a, b),
            a
        );
    }),
    (gj.droppable.widget.prototype = new gj.widget()),
    (gj.droppable.widget.constructor = gj.droppable.widget),
    (function (a) {
        a.fn.droppable = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.droppable.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.droppable.widget(this, a);
            }
        };
    })(jQuery),
    (gj.grid = { plugins: {}, messages: {} }),
    (gj.grid.config = {
        base: {
            dataSource: void 0,
            columns: [],
            autoGenerateColumns: !1,
            defaultColumnSettings: {
                hidden: !1,
                width: void 0,
                sortable: !1,
                type: "text",
                title: void 0,
                field: void 0,
                align: void 0,
                cssClass: void 0,
                headerCssClass: void 0,
                tooltip: void 0,
                icon: void 0,
                events: void 0,
                format: "mm/dd/yyyy",
                decimalDigits: void 0,
                tmpl: void 0,
                stopPropagation: !1,
                renderer: void 0,
                filter: void 0,
            },
            mapping: { dataField: "records", totalRecordsField: "total" },
            params: {},
            paramNames: { sortBy: "sortBy", direction: "direction" },
            uiLibrary: "materialdesign",
            iconsLibrary: "materialicons",
            selectionType: "single",
            selectionMethod: "basic",
            autoLoad: !0,
            notFoundText: void 0,
            width: void 0,
            minWidth: void 0,
            headerRowHeight: "fixed",
            bodyRowHeight: "autogrow",
            fontSize: void 0,
            primaryKey: void 0,
            locale: "en-us",
            defaultIconColumnWidth: 70,
            defaultCheckBoxColumnWidth: 70,
            style: {
                wrapper: "gj-grid-wrapper",
                table: "gj-grid gj-grid-md",
                loadingCover: "gj-grid-loading-cover",
                loadingText: "gj-grid-loading-text",
                header: { cell: void 0, sortable: "gj-cursor-pointer gj-unselectable" },
                content: { rowSelected: "gj-grid-md-select" },
            },
            icons: { asc: "▲", desc: "▼" },
        },
        bootstrap: {
            style: { wrapper: "gj-grid-wrapper", table: "gj-grid gj-grid-bootstrap gj-grid-bootstrap-3 table table-bordered table-hover", content: { rowSelected: "active" } },
            iconsLibrary: "glyphicons",
            defaultIconColumnWidth: 34,
            defaultCheckBoxColumnWidth: 36,
        },
        bootstrap4: {
            style: { wrapper: "gj-grid-wrapper", table: "gj-grid gj-grid-bootstrap gj-grid-bootstrap-4 table table-bordered table-hover", content: { rowSelected: "active" } },
            defaultIconColumnWidth: 42,
            defaultCheckBoxColumnWidth: 44,
        },
        materialicons: { icons: { asc: '<i class="gj-icon arrow-upward" />', desc: '<i class="gj-icon arrow-downward" />' } },
        fontawesome: { icons: { asc: '<i class="fa fa-sort-amount-asc" aria-hidden="true"></i>', desc: '<i class="fa fa-sort-amount-desc" aria-hidden="true"></i>' } },
        glyphicons: { icons: { asc: '<span class="glyphicon glyphicon-sort-by-alphabet" />', desc: '<span class="glyphicon glyphicon-sort-by-alphabet-alt" />' } },
    }),
    (gj.grid.events = {
        beforeEmptyRowInsert: function (a, b) {
            return a.triggerHandler("beforeEmptyRowInsert", [b]);
        },
        dataBinding: function (a, b) {
            return a.triggerHandler("dataBinding", [b]);
        },
        dataBound: function (a, b, c) {
            return a.triggerHandler("dataBound", [b, c]);
        },
        rowDataBound: function (a, b, c, d) {
            return a.triggerHandler("rowDataBound", [b, c, d]);
        },
        cellDataBound: function (a, b, c, d, e) {
            return a.triggerHandler("cellDataBound", [b, c, d, e]);
        },
        rowSelect: function (a, b, c, d) {
            return a.triggerHandler("rowSelect", [b, c, d]);
        },
        rowUnselect: function (a, b, c, d) {
            return a.triggerHandler("rowUnselect", [b, c, d]);
        },
        rowRemoving: function (a, b, c, d) {
            return a.triggerHandler("rowRemoving", [b, c, d]);
        },
        destroying: function (a) {
            return a.triggerHandler("destroying");
        },
        columnHide: function (a, b) {
            return a.triggerHandler("columnHide", [b]);
        },
        columnShow: function (a, b) {
            return a.triggerHandler("columnShow", [b]);
        },
        initialized: function (a) {
            return a.triggerHandler("initialized");
        },
        dataFiltered: function (a, b) {
            return a.triggerHandler("dataFiltered", [b]);
        },
    }),
    (gj.grid.methods = {
        init: function (a) {
            return gj.widget.prototype.init.call(this, a, "grid"), gj.grid.methods.initialize(this), this.data("autoLoad") && this.reload(), this;
        },
        getConfig: function (a, b) {
            var c = gj.widget.prototype.getConfig.call(this, a, b);
            return gj.grid.methods.setDefaultColumnConfig(c.columns, c.defaultColumnSettings), c;
        },
        setDefaultColumnConfig: function (a, b) {
            var c, d;
            if (a && a.length) for (d = 0; d < a.length; d++) (c = $.extend(!0, {}, b)), $.extend(!0, c, a[d]), (a[d] = c);
        },
        getHTMLConfig: function () {
            var a = gj.widget.prototype.getHTMLConfig.call(this);
            return (
                (a.columns = []),
                this.find("thead > tr > th").each(function () {
                    var b = $(this),
                        c = b.text(),
                        d = gj.widget.prototype.getHTMLConfig.call(b);
                    (d.title = c), d.field || (d.field = c), d.events && (d.events = gj.grid.methods.eventsParser(d.events)), a.columns.push(d);
                }),
                a
            );
        },
        eventsParser: function (events) {
            var result = {},
                list,
                i,
                key,
                func,
                position;
            for (list = events.split(","), i = 0; i < list.length; i++)
                (position = list[i].indexOf(":")) > 0 && ((key = $.trim(list[i].substr(0, position))), (func = $.trim(list[i].substr(position + 1, list[i].length))), (result[key] = eval("window." + func)));
            return result;
        },
        initialize: function (a) {
            var b = a.data(),
                c = a.parent('div[data-role="wrapper"]');
            gj.grid.methods.localization(b),
                0 === c.length ? ((c = $('<div data-role="wrapper" />').addClass(b.style.wrapper)), a.wrap(c)) : c.addClass(b.style.wrapper),
                b.width && a.parent().css("width", b.width),
                b.minWidth && a.css("min-width", b.minWidth),
                b.fontSize && a.css("font-size", b.fontSize),
                "autogrow" === b.headerRowHeight && a.addClass("autogrow-header-row"),
                "fixed" === b.bodyRowHeight && a.addClass("fixed-body-rows"),
                a.addClass(b.style.table),
                "checkbox" === b.selectionMethod &&
                    b.columns.splice(gj.grid.methods.getColumnPositionNotInRole(a), 0, {
                        title: "",
                        width: b.defaultCheckBoxColumnWidth,
                        align: "center",
                        type: "checkbox",
                        role: "selectRow",
                        events: {
                            click: function (b) {
                                gj.grid.methods.setSelected(a, b.data.id, $(this).closest("tr"));
                            },
                        },
                        headerCssClass: "gj-grid-select-all",
                        stopPropagation: !0,
                    }),
                0 === a.children("tbody").length && a.append($("<tbody/>")),
                gj.grid.methods.renderHeader(a),
                gj.grid.methods.appendEmptyRow(a, "&nbsp;"),
                gj.grid.events.initialized(a);
        },
        localization: function (a) {
            a.notFoundText || (a.notFoundText = gj.grid.messages[a.locale].NoRecordsFound);
        },
        renderHeader: function (a) {
            var b, c, d, e, f, g, h, i, j;
            for (b = a.data(), c = b.columns, d = b.style.header, e = a.children("thead"), 0 === e.length && ((e = $("<thead />")), a.prepend(e)), f = $('<tr data-role="caption" />'), i = 0; i < c.length; i += 1)
                (g = $('<th data-field="' + (c[i].field || "") + '" />')),
                    c[i].width ? g.attr("width", c[i].width) : "checkbox" === c[i].type && g.attr("width", b.defaultIconColumnWidth),
                    g.addClass(d.cell),
                    c[i].headerCssClass && g.addClass(c[i].headerCssClass),
                    g.css("text-align", c[i].align || "left"),
                    "checkbox" === b.selectionMethod && "multiple" === b.selectionType && "checkbox" === c[i].type && "selectRow" === c[i].role
                        ? ((j = g.find('input[data-role="selectAll"]')),
                          0 === j.length && ((j = $('<input type="checkbox" data-role="selectAll" />')), g.append(j), j.checkbox({ uiLibrary: b.uiLibrary })),
                          j.off("click").on("click", function () {
                              this.checked ? a.selectAll() : a.unSelectAll();
                          }))
                        : ((h = $('<div data-role="title"/>').html(void 0 === c[i].title ? c[i].field : c[i].title)), g.append(h), c[i].sortable && (h.addClass(d.sortable), h.on("click", gj.grid.methods.createSortHandler(a, c[i])))),
                    c[i].hidden && g.hide(),
                    f.append(g);
            e.empty().append(f);
        },
        createSortHandler: function (a, b) {
            return function () {
                var c,
                    d = {};
                a.count() > 0 && ((c = a.data()), (d[c.paramNames.sortBy] = b.field), (b.direction = "asc" === b.direction ? "desc" : "asc"), (d[c.paramNames.direction] = b.direction), a.reload(d));
            };
        },
        updateHeader: function (a) {
            var b,
                c,
                d = a.data(),
                e = d.params[d.paramNames.sortBy],
                f = d.params[d.paramNames.direction];
            a.find('thead tr th [data-role="sorticon"]').remove(),
                e &&
                    ((position = gj.grid.methods.getColumnPosition(a.data("columns"), e)),
                    position > -1 && ((c = a.find("thead tr th:eq(" + position + ') div[data-role="title"]')), (b = $('<div data-role="sorticon" class="gj-unselectable" />').append("desc" === f ? d.icons.desc : d.icons.asc)), c.after(b)));
        },
        useHtmlDataSource: function (a, b) {
            var c,
                d,
                e,
                f,
                g = [],
                h = a.find('tbody tr[data-role != "empty"]');
            for (c = 0; c < h.length; c++) {
                for (e = $(h[c]).find("td"), f = {}, d = 0; d < e.length; d++) f[b.columns[d].field] = $(e[d]).html();
                g.push(f);
            }
            b.dataSource = g;
        },
        startLoading: function (a) {
            var b, c, d, e, f, g, h;
            gj.grid.methods.stopLoading(a),
                (h = a.data()),
                0 !== a.outerHeight() &&
                    ((b = a.children("tbody")),
                    (e = b.outerWidth(!1)),
                    (f = b.outerHeight(!1)),
                    (g = Math.abs(a.parent().offset().top - b.offset().top)),
                    (c = $('<div data-role="loading-cover" />').addClass(h.style.loadingCover).css({ width: e, height: f, top: g })),
                    (d = $('<div data-role="loading-text">' + gj.grid.messages[h.locale].Loading + "</div>").addClass(h.style.loadingText)),
                    d.insertAfter(a),
                    c.insertAfter(a),
                    d.css({ top: g + f / 2 - d.outerHeight(!1) / 2, left: e / 2 - d.outerWidth(!1) / 2 }));
        },
        stopLoading: function (a) {
            a.parent().find('div[data-role="loading-cover"]').remove(), a.parent().find('div[data-role="loading-text"]').remove();
        },
        appendEmptyRow: function (a, b) {
            var c, d, e, f;
            (c = a.data()),
                (d = $('<tr data-role="empty"/>')),
                (e = $("<td/>").css({ width: "100%", "text-align": "center" })),
                e.attr("colspan", gj.grid.methods.countVisibleColumns(a)),
                (f = $("<div />").html(b || c.notFoundText)),
                e.append(f),
                d.append(e),
                gj.grid.events.beforeEmptyRowInsert(a, d),
                a.append(d);
        },
        autoGenerateColumns: function (a, b) {
            var c,
                d,
                e,
                f,
                g = a.data();
            if (((g.columns = []), b.length > 0)) {
                for (c = Object.getOwnPropertyNames(b[0]), f = 0; f < c.length; f++)
                    (d = b[0][c[f]]), (e = "text"), d && ("number" == typeof d ? (e = "number") : d.indexOf("/Date(") > -1 && (e = "date")), g.columns.push({ field: c[f], type: e });
                gj.grid.methods.setDefaultColumnConfig(g.columns, g.defaultColumnSettings);
            }
            gj.grid.methods.renderHeader(a);
        },
        loadData: function (a) {
            var b, c, d, e, f, g, h, i;
            for (
                b = a.data(),
                    c = a.getAll(),
                    gj.grid.events.dataBinding(a, c),
                    e = c.length,
                    gj.grid.methods.stopLoading(a),
                    b.autoGenerateColumns && gj.grid.methods.autoGenerateColumns(a, c),
                    g = a.children("tbody"),
                    "checkbox" === b.selectionMethod && "multiple" === b.selectionType && a.find('thead input[data-role="selectAll"]').prop("checked", !1),
                    g.children("tr").not('[data-role="row"]').remove(),
                    0 === e && (g.empty(), gj.grid.methods.appendEmptyRow(a)),
                    h = g.children("tr"),
                    f = h.length,
                    d = 0;
                d < f;
                d++
            ) {
                if (!(d < e)) {
                    g.find('tr[data-role="row"]:gt(' + (d - 1) + ")").remove();
                    break;
                }
                (i = h.eq(d)), gj.grid.methods.renderRow(a, i, c[d], d);
            }
            for (d = f; d < e; d++) gj.grid.methods.renderRow(a, null, c[d], d);
            gj.grid.events.dataBound(a, c, b.totalRecords);
        },
        getId: function (a, b, c) {
            return b && a[b] ? a[b] : c;
        },
        renderRow: function (a, b, c, d) {
            var e, f, g, h, i;
            for (
                h = a.data(),
                    b && 0 !== b.length ? ((i = "update"), b.removeClass(h.style.content.rowSelected).removeAttr("data-selected").off("click")) : ((i = "create"), (b = $('<tr data-role="row"/>')), a.children("tbody").append(b)),
                    e = gj.grid.methods.getId(c, h.primaryKey, d + 1),
                    b.attr("data-position", d + 1),
                    "checkbox" !== h.selectionMethod && b.on("click", gj.grid.methods.createRowClickHandler(a, e)),
                    g = 0;
                g < h.columns.length;
                g++
            )
                "update" === i ? ((f = b.find("td:eq(" + g + ")")), gj.grid.methods.renderCell(a, f, h.columns[g], c, e)) : ((f = gj.grid.methods.renderCell(a, null, h.columns[g], c, e)), b.append(f));
            gj.grid.events.rowDataBound(a, b, e, c);
        },
        renderCell: function (a, b, c, d, e, f) {
            var g, h;
            if (
                (b && 0 !== b.length
                    ? ((g = b.find('div[data-role="display"]')), (f = "update"))
                    : ((b = $("<td/>")), (g = $('<div data-role="display" />')), c.align && b.css("text-align", c.align), c.cssClass && b.addClass(c.cssClass), b.append(g), (f = "create")),
                gj.grid.methods.renderDisplayElement(a, g, c, d, e, f),
                "update" === f && (b.off(), g.off()),
                c.events)
            )
                for (h in c.events) c.events.hasOwnProperty(h) && b.on(h, { id: e, field: c.field, record: d }, gj.grid.methods.createCellEventHandler(c, c.events[h]));
            return c.hidden && b.hide(), gj.grid.events.cellDataBound(a, g, e, c, d), b;
        },
        createCellEventHandler: function (a, b) {
            return function (c) {
                a.stopPropagation && c.stopPropagation(), b.call(this, c);
            };
        },
        renderDisplayElement: function (a, b, c, d, e, f) {
            var g, h;
            "checkbox" === c.type && gj.checkbox
                ? "create" === f
                    ? ((h = $('<input type="checkbox" />').val(e).prop("checked", !!d[c.field])),
                      c.role && h.attr("data-role", c.role),
                      b.append(h),
                      h.checkbox({ uiLibrary: a.data("uiLibrary") }),
                      "selectRow" === c.role
                          ? h.on("click", function () {
                                return !1;
                            })
                          : h.prop("disabled", !0))
                    : b.find('input[type="checkbox"]').val(e).prop("checked", !!d[c.field])
                : "icon" === c.type
                ? "create" === f && (b.append($("<span/>").addClass(c.icon).css({ cursor: "pointer" })), "bootstrap" === a.data().uiLibrary && b.children("span").addClass("glyphicon"), (c.stopPropagation = !0))
                : c.tmpl
                ? ((g = c.tmpl),
                  c.tmpl.replace(/\{(.+?)\}/g, function (a, b) {
                      g = g.replace(a, gj.grid.methods.formatText(d[b], c));
                  }),
                  b.html(g))
                : c.renderer && "function" == typeof c.renderer
                ? (g = c.renderer(d[c.field], d, b.parent(), b, e, a)) && b.html(g)
                : ((d[c.field] = gj.grid.methods.formatText(d[c.field], c)), !c.tooltip && d[c.field] && b.attr("title", d[c.field]), b.html(d[c.field])),
                c.tooltip && "create" === f && b.attr("title", c.tooltip);
        },
        formatText: function (a, b) {
            return (
                (a = a && ["date", "time", "datetime"].indexOf(b.type) > -1 ? gj.core.formatDate(gj.core.parseDate(a, b.format), b.format) : void 0 === a || null === a ? "" : a.toString()),
                b.decimalDigits && a && (a = parseFloat(a).toFixed(b.decimalDigits)),
                a
            );
        },
        setRecordsData: function (a, b) {
            var c = [],
                d = 0,
                e = a.data();
            return (
                $.isArray(b) ? ((c = b), (d = b.length)) : e && e.mapping && $.isArray(b[e.mapping.dataField]) && ((c = b[e.mapping.dataField]), ((d = b[e.mapping.totalRecordsField]) && !isNaN(d)) || (d = 0)),
                a.data("records", c),
                a.data("totalRecords", d),
                c
            );
        },
        createRowClickHandler: function (a, b) {
            return function () {
                gj.grid.methods.setSelected(a, b, $(this));
            };
        },
        selectRow: function (a, b, c, d) {
            var e;
            return (
                c.addClass(b.style.content.rowSelected),
                c.attr("data-selected", "true"),
                "checkbox" === b.selectionMethod &&
                    ((e = c.find('input[type="checkbox"][data-role="selectRow"]')),
                    e.length && !e.prop("checked") && e.prop("checked", !0),
                    "multiple" === b.selectionType && a.getSelections().length === a.count(!1) && a.find('thead input[data-role="selectAll"]').prop("checked", !0)),
                gj.grid.events.rowSelect(a, c, d, a.getById(d))
            );
        },
        unselectRow: function (a, b, c, d) {
            var e;
            if ("true" === c.attr("data-selected"))
                return (
                    c.removeClass(b.style.content.rowSelected),
                    "checkbox" === b.selectionMethod &&
                        ((e = c.find('td input[type="checkbox"][data-role="selectRow"]')),
                        e.length && e.prop("checked") && e.prop("checked", !1),
                        "multiple" === b.selectionType && a.find('thead input[data-role="selectAll"]').prop("checked", !1)),
                    c.removeAttr("data-selected"),
                    gj.grid.events.rowUnselect(a, c, d, a.getById(d))
                );
        },
        setSelected: function (a, b, c) {
            var d = a.data();
            return (
                (c && c.length) || (c = gj.grid.methods.getRowById(a, b)),
                c &&
                    ("true" === c.attr("data-selected")
                        ? gj.grid.methods.unselectRow(a, d, c, b)
                        : ("single" === d.selectionType &&
                              c.siblings('[data-selected="true"]').each(function () {
                                  var b = $(this),
                                      c = gj.grid.methods.getId(b, d.primaryKey, b.data("position"));
                                  gj.grid.methods.unselectRow(a, d, b, c);
                              }),
                          gj.grid.methods.selectRow(a, d, c, b))),
                a
            );
        },
        selectAll: function (a) {
            var b = a.data();
            return (
                a.find('tbody tr[data-role="row"]').each(function () {
                    var c = $(this),
                        d = c.data("position"),
                        e = a.get(d),
                        f = gj.grid.methods.getId(e, b.primaryKey, d);
                    gj.grid.methods.selectRow(a, b, c, f);
                }),
                a.find('thead input[data-role="selectAll"]').prop("checked", !0),
                a
            );
        },
        unSelectAll: function (a) {
            var b = a.data();
            return (
                a.find("tbody tr").each(function () {
                    var c = $(this),
                        d = c.data("position"),
                        e = a.get(d),
                        f = gj.grid.methods.getId(e, b.primaryKey, d);
                    gj.grid.methods.unselectRow(a, b, c, f), c.find('input[type="checkbox"][data-role="selectRow"]').prop("checked", !1);
                }),
                a.find('thead input[data-role="selectAll"]').prop("checked", !1),
                a
            );
        },
        getSelected: function (a) {
            var b,
                c,
                d,
                e = null;
            return (b = a.find('tbody>tr[data-selected="true"]')), b.length > 0 && ((d = $(b[0]).data("position")), (c = a.get(d)), (e = gj.grid.methods.getId(c, a.data().primaryKey, d))), e;
        },
        getSelectedRows: function (a) {
            a.data();
            return a.find('tbody>tr[data-selected="true"]');
        },
        getSelections: function (a) {
            var b,
                c,
                d = [],
                e = a.data(),
                f = gj.grid.methods.getSelectedRows(a);
            return (
                0 < f.length &&
                    f.each(function () {
                        (b = $(this).data("position")), (c = a.get(b)), d.push(gj.grid.methods.getId(c, e.primaryKey, b));
                    }),
                d
            );
        },
        getById: function (a, b) {
            var c,
                d = null,
                e = a.data("primaryKey"),
                f = a.data("records");
            if (e) {
                for (c = 0; c < f.length; c++)
                    if (f[c][e] == b) {
                        d = f[c];
                        break;
                    }
            } else d = a.get(b);
            return d;
        },
        getRecVPosById: function (a, b) {
            var c,
                d = b,
                e = a.data();
            if (e.primaryKey)
                for (c = 0; c < e.dataSource.length; c++)
                    if (e.dataSource[c][e.primaryKey] == b) {
                        d = c;
                        break;
                    }
            return d;
        },
        getRowById: function (a, b) {
            var c,
                d,
                e = a.getAll(!1),
                f = a.data("primaryKey"),
                g = void 0;
            if (f) {
                for (d = 0; d < e.length; d++)
                    if (e[d][f] == b) {
                        c = d + 1;
                        break;
                    }
            } else c = b;
            return c && (g = a.children("tbody").children('tr[data-position="' + c + '"]')), g;
        },
        getByPosition: function (a, b) {
            return a.getAll(!1)[b - 1];
        },
        getColumnPosition: function (a, b) {
            var c,
                d = -1;
            for (c = 0; c < a.length; c++)
                if (a[c].field === b) {
                    d = c;
                    break;
                }
            return d;
        },
        getColumnInfo: function (a, b) {
            var c,
                d = {},
                e = a.data();
            for (c = 0; c < e.columns.length; c += 1)
                if (e.columns[c].field === b) {
                    d = e.columns[c];
                    break;
                }
            return d;
        },
        getCell: function (a, b, c) {
            var d,
                e,
                f = null;
            return (d = gj.grid.methods.getColumnPosition(a.data("columns"), c)), d > -1 && ((e = gj.grid.methods.getRowById(a, b)), (f = e.find("td:eq(" + d + ') div[data-role="display"]'))), f;
        },
        setCellContent: function (a, b, c, d) {
            var e,
                f = gj.grid.methods.getCell(a, b, c);
            f && (f.empty(), "object" == typeof d ? f.append(d) : ((e = gj.grid.methods.getColumnInfo(a, c)), gj.grid.methods.renderDisplayElement(a, f, e, a.getById(b), b, "update")));
        },
        clone: function (a) {
            var b = [];
            return (
                $.each(a, function () {
                    b.push(this.clone());
                }),
                b
            );
        },
        getAll: function (a) {
            return a.data("records");
        },
        countVisibleColumns: function (a) {
            var b, c, d;
            for (b = a.data().columns, c = 0, d = 0; d < b.length; d++) !0 !== b[d].hidden && c++;
            return c;
        },
        clear: function (a, b) {
            var c = a.data();
            return a.xhr && a.xhr.abort(), a.children("tbody").empty(), (c.records = []), gj.grid.methods.stopLoading(a), gj.grid.methods.appendEmptyRow(a, b ? c.notFoundText : "&nbsp;"), gj.grid.events.dataBound(a, [], 0), a;
        },
        render: function (a, b) {
            return b && (gj.grid.methods.setRecordsData(a, b), gj.grid.methods.updateHeader(a), gj.grid.methods.loadData(a)), a;
        },
        filter: function (a) {
            var b,
                c,
                d = a.data(),
                e = d.dataSource.slice();
            d.params[d.paramNames.sortBy] && ((c = gj.grid.methods.getColumnInfo(a, d.params[d.paramNames.sortBy])), e.sort(c.sortable.sorter ? c.sortable.sorter(c.direction, c) : gj.grid.methods.createDefaultSorter(c.direction, c.field)));
            for (b in d.params)
                d.params[b] &&
                    !d.paramNames[b] &&
                    ((c = gj.grid.methods.getColumnInfo(a, b)),
                    (e = $.grep(e, function (a) {
                        var e = a[b] || "",
                            f = d.params[b] || "";
                        return c && "function" == typeof c.filter ? c.filter(e, f) : e.toUpperCase().indexOf(f.toUpperCase()) > -1;
                    })));
            return gj.grid.events.dataFiltered(a, e), e;
        },
        createDefaultSorter: function (a, b) {
            return function (c, d) {
                var e = (c[b] || "").toString(),
                    f = (d[b] || "").toString();
                return "asc" === a ? e.localeCompare(f) : f.localeCompare(e);
            };
        },
        destroy: function (a, b, c) {
            return (
                a.data() &&
                    (gj.grid.events.destroying(a),
                    gj.grid.methods.stopLoading(a),
                    a.xhr && a.xhr.abort(),
                    a.off(),
                    !1 === c && a.parent('div[data-role="wrapper"]').length > 0 && a.unwrap(),
                    a.removeData(),
                    !1 === b ? a.remove() : a.removeClass().empty(),
                    a.removeAttr("data-type")),
                a
            );
        },
        showColumn: function (a, b) {
            var c,
                d = a.data(),
                e = gj.grid.methods.getColumnPosition(d.columns, b);
            return (
                e > -1 &&
                    (a.find("thead>tr").each(function () {
                        $(this).children("th").eq(e).show();
                    }),
                    $.each(a.find("tbody>tr"), function () {
                        $(this).children("td").eq(e).show();
                    }),
                    (d.columns[e].hidden = !1),
                    (c = a.find('tbody > tr[data-role="empty"] > td')),
                    c && c.length && c.attr("colspan", gj.grid.methods.countVisibleColumns(a)),
                    gj.grid.events.columnShow(a, d.columns[e])),
                a
            );
        },
        hideColumn: function (a, b) {
            var c,
                d = a.data(),
                e = gj.grid.methods.getColumnPosition(d.columns, b);
            return (
                e > -1 &&
                    (a.find("thead>tr").each(function () {
                        $(this).children("th").eq(e).hide();
                    }),
                    $.each(a.find("tbody>tr"), function () {
                        $(this).children("td").eq(e).hide();
                    }),
                    (d.columns[e].hidden = !0),
                    (c = a.find('tbody > tr[data-role="empty"] > td')),
                    c && c.length && c.attr("colspan", gj.grid.methods.countVisibleColumns(a)),
                    gj.grid.events.columnHide(a, d.columns[e])),
                a
            );
        },
        isLastRecordVisible: function () {
            return !0;
        },
        addRow: function (a, b) {
            var c = a.data();
            return (
                (c.totalRecords = a.data("totalRecords") + 1),
                gj.grid.events.dataBinding(a, [b]),
                c.records.push(b),
                $.isArray(c.dataSource) && c.dataSource.push(b),
                1 === c.totalRecords && a.children("tbody").empty(),
                gj.grid.methods.isLastRecordVisible(a) && gj.grid.methods.renderRow(a, null, b, a.count() - 1),
                gj.grid.events.dataBound(a, [b], c.totalRecords),
                a
            );
        },
        updateRow: function (a, b, c) {
            var d,
                e = gj.grid.methods.getRowById(a, b),
                f = a.data();
            return (f.records[e.data("position") - 1] = c), $.isArray(f.dataSource) && ((d = gj.grid.methods.getRecVPosById(a, b)), (f.dataSource[d] = c)), gj.grid.methods.renderRow(a, e, c, e.index()), a;
        },
        removeRow: function (a, b) {
            var c,
                d = a.data(),
                e = gj.grid.methods.getRowById(a, b);
            return gj.grid.events.rowRemoving(a, e, b, a.getById(b)), $.isArray(d.dataSource) && ((c = gj.grid.methods.getRecVPosById(a, b)), d.dataSource.splice(c, 1)), a.reload(), a;
        },
        count: function (a, b) {
            return b ? a.data().totalRecords : a.getAll().length;
        },
        getColumnPositionByRole: function (a, b) {
            var c,
                d,
                e = a.data("columns");
            for (c = 0; c < e.length; c++)
                if (e[c].role === b) {
                    d = c;
                    break;
                }
            return d;
        },
        getColumnPositionNotInRole: function (a) {
            var b,
                c = 0,
                d = a.data("columns");
            for (b = 0; b < d.length; b++)
                if (!d[b].role) {
                    c = b;
                    break;
                }
            return c;
        },
    }),
    (gj.grid.widget = function (a, b) {
        var c = this,
            d = gj.grid.methods;
        return (
            (c.reload = function (a) {
                return d.startLoading(this), gj.widget.prototype.reload.call(this, a);
            }),
            (c.clear = function (a) {
                return d.clear(this, a);
            }),
            (c.count = function (a) {
                return d.count(this, a);
            }),
            (c.render = function (b) {
                return d.render(a, b);
            }),
            (c.destroy = function (a, b) {
                return d.destroy(this, a, b);
            }),
            (c.setSelected = function (a) {
                return d.setSelected(this, a);
            }),
            (c.getSelected = function () {
                return d.getSelected(this);
            }),
            (c.getSelections = function () {
                return d.getSelections(this);
            }),
            (c.selectAll = function () {
                return d.selectAll(this);
            }),
            (c.unSelectAll = function () {
                return d.unSelectAll(this);
            }),
            (c.getById = function (a) {
                return d.getById(this, a);
            }),
            (c.get = function (a) {
                return d.getByPosition(this, a);
            }),
            (c.getAll = function (a) {
                return d.getAll(this, a);
            }),
            (c.showColumn = function (a) {
                return d.showColumn(this, a);
            }),
            (c.hideColumn = function (a) {
                return d.hideColumn(this, a);
            }),
            (c.addRow = function (a) {
                return d.addRow(this, a);
            }),
            (c.updateRow = function (a, b) {
                return d.updateRow(this, a, b);
            }),
            (c.setCellContent = function (a, b, c) {
                d.setCellContent(this, a, b, c);
            }),
            (c.removeRow = function (a) {
                return d.removeRow(this, a);
            }),
            $.extend(a, c),
            "grid" !== a.attr("data-type") && d.init.call(a, b),
            a
        );
    }),
    (gj.grid.widget.prototype = new gj.widget()),
    (gj.grid.widget.constructor = gj.grid.widget),
    (gj.grid.widget.prototype.getConfig = gj.grid.methods.getConfig),
    (gj.grid.widget.prototype.getHTMLConfig = gj.grid.methods.getHTMLConfig),
    (function (a) {
        a.fn.grid = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.grid.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.grid.widget(this, a);
            }
        };
    })(jQuery),
    (gj.grid.plugins.fixedHeader = {
        config: { base: { fixedHeader: !1, height: 300 } },
        private: {
            init: function (a) {
                var b = a.data(),
                    c = a.children("tbody"),
                    d = a.children("thead"),
                    e = b.height - d.outerHeight() - (a.children("tfoot").outerHeight() || 0);
                a.addClass("gj-grid-scrollable"), c.css("width", d.outerWidth()), c.height(e);
            },
            refresh: function (a) {
                var b,
                    c,
                    d = (a.data(), a.children("tbody")),
                    e = a.children("thead"),
                    f = a.find('tbody tr[data-role="row"] td'),
                    g = a.find('thead tr[data-role="caption"] th');
                for (
                    a.children("tbody").height() < gj.grid.plugins.fixedHeader.private.getRowsHeight(a)
                        ? d.css("width", e.outerWidth() + gj.grid.plugins.fixedHeader.private.getScrollBarWidth() + (navigator.userAgent.toLowerCase().indexOf("firefox") > -1 ? 1 : 0))
                        : d.css("width", e.outerWidth()),
                        b = 0;
                    b < g.length;
                    b++
                )
                    (c = $(g[b]).outerWidth()), 0 === b && gj.core.isIE() && (c -= 1), $(f[b]).attr("width", c);
            },
            getRowsHeight: function (a) {
                var b = 0;
                return (
                    a.find("tbody tr").each(function () {
                        b += $(this).height();
                    }),
                    b
                );
            },
            getScrollBarWidth: function () {
                var a = document.createElement("p");
                (a.style.width = "100%"), (a.style.height = "200px");
                var b = document.createElement("div");
                (b.style.position = "absolute"),
                    (b.style.top = "0px"),
                    (b.style.left = "0px"),
                    (b.style.visibility = "hidden"),
                    (b.style.width = "200px"),
                    (b.style.height = "150px"),
                    (b.style.overflow = "hidden"),
                    b.appendChild(a),
                    document.body.appendChild(b);
                var c = a.offsetWidth;
                b.style.overflow = "scroll";
                var d = a.offsetWidth;
                return c == d && (d = b.clientWidth), document.body.removeChild(b), c - d;
            },
        },
        public: {},
        events: {},
        configure: function (a, b, c) {
            $.extend(!0, a, gj.grid.plugins.fixedHeader.public);
            a.data();
            c.fixedHeader &&
                (a.on("initialized", function () {
                    gj.grid.plugins.fixedHeader.private.init(a);
                }),
                a.on("dataBound", function () {
                    gj.grid.plugins.fixedHeader.private.refresh(a);
                }),
                a.on("resize", function () {
                    gj.grid.plugins.fixedHeader.private.refresh(a);
                }));
        },
    }),
    (gj.grid.plugins.expandCollapseRows = {
        config: {
            base: { detailTemplate: void 0, keepExpandedRows: !0, expandedRows: [], icons: { expandRow: '<i class="gj-icon chevron-right" />', collapseRow: '<i class="gj-icon chevron-down" />' } },
            fontawesome: { icons: { expandRow: '<i class="fa fa-angle-right" aria-hidden="true"></i>', collapseRow: '<i class="fa fa-angle-down" aria-hidden="true"></i>' } },
            glyphicons: { icons: { expandRow: '<span class="glyphicon glyphicon-chevron-right" />', collapseRow: '<span class="glyphicon glyphicon-chevron-down" />' } },
        },
        private: {
            expandDetail: function (a, b, c) {
                var d = b.closest("tr"),
                    e = $('<tr data-role="details" />'),
                    f = $('<td colspan="' + gj.grid.methods.countVisibleColumns(a) + '" />'),
                    g = $('<div data-role="display" />'),
                    h = a.data(),
                    i = d.data("position"),
                    j = a.get(i),
                    k = gj.grid.plugins.expandCollapseRows;
                void 0 === typeof c && (c = gj.grid.methods.getId(j, h.primaryKey, j)),
                    e.append(f.append(g.append(d.data("details")))),
                    e.insertAfter(d),
                    b.children('div[data-role="display"]').empty().append(h.icons.collapseRow),
                    a.updateDetails(d),
                    k.private.keepSelection(a, c),
                    k.events.detailExpand(a, e.find("td>div"), c);
            },
            collapseDetail: function (a, b, c) {
                var d = b.closest("tr"),
                    e = d.next('tr[data-role="details"]'),
                    f = a.data(),
                    g = gj.grid.plugins.expandCollapseRows;
                void 0 === typeof c && (c = gj.grid.methods.getId(record, f.primaryKey, record)),
                    e.remove(),
                    b.children('div[data-role="display"]').empty().append(f.icons.expandRow),
                    g.private.removeSelection(a, c),
                    g.events.detailCollapse(a, e.find("td>div"), c);
            },
            keepSelection: function (a, b) {
                var c = a.data();
                c.keepExpandedRows && ($.isArray(c.expandedRows) ? -1 == c.expandedRows.indexOf(b) && c.expandedRows.push(b) : (c.expandedRows = [b]));
            },
            removeSelection: function (a, b) {
                var c = a.data();
                c.keepExpandedRows && $.isArray(c.expandedRows) && c.expandedRows.indexOf(b) > -1 && c.expandedRows.splice(c.expandedRows.indexOf(b), 1);
            },
            updateDetailsColSpan: function (a) {
                var b = a.find('tbody > tr[data-role="details"] > td');
                b && b.length && b.attr("colspan", gj.grid.methods.countVisibleColumns(a));
            },
        },
        public: {
            collapseAll: function () {
                var a,
                    b = this,
                    c = b.data();
                return (
                    void 0 !== c.detailTemplate &&
                        ((a = gj.grid.methods.getColumnPositionByRole(b, "expander")),
                        b.find('tbody tr[data-role="row"]').each(function () {
                            gj.grid.plugins.expandCollapseRows.private.collapseDetail(b, $(this).find("td:eq(" + a + ")"));
                        })),
                    void 0 !== c.grouping &&
                        b.find('tbody tr[role="group"]').each(function () {
                            gj.grid.plugins.grouping.private.collapseGroup(c, $(this).find("td:eq(0)"));
                        }),
                    b
                );
            },
            expandAll: function () {
                var a,
                    b = this,
                    c = b.data();
                return (
                    void 0 !== c.detailTemplate &&
                        ((a = gj.grid.methods.getColumnPositionByRole(b, "expander")),
                        b.find('tbody tr[data-role="row"]').each(function () {
                            gj.grid.plugins.expandCollapseRows.private.expandDetail(b, $(this).find("td:eq(" + a + ")"));
                        })),
                    void 0 !== c.grouping &&
                        b.find('tbody tr[role="group"]').each(function () {
                            gj.grid.plugins.grouping.private.expandGroup(c, $(this).find("td:eq(0)"));
                        }),
                    b
                );
            },
            updateDetails: function (a) {
                var b = this,
                    c = a.data("details"),
                    d = c.html(),
                    e = b.get(a.data("position"));
                return (
                    e &&
                        d &&
                        (c.html().replace(/\{(.+?)\}/g, function (a, c) {
                            var f = gj.grid.methods.getColumnInfo(b, c);
                            d = d.replace(a, gj.grid.methods.formatText(e[c], f));
                        }),
                        c.html(d)),
                    b
                );
            },
        },
        events: {
            detailExpand: function (a, b, c) {
                a.triggerHandler("detailExpand", [b, c]);
            },
            detailCollapse: function (a, b, c) {
                a.triggerHandler("detailCollapse", [b, c]);
            },
        },
        configure: function (a) {
            var b,
                c = a.data();
            $.extend(!0, a, gj.grid.plugins.expandCollapseRows.public),
                void 0 !== c.detailTemplate &&
                    ((b = {
                        title: "",
                        width: c.defaultIconColumnWidth,
                        align: "center",
                        stopPropagation: !0,
                        cssClass: "gj-cursor-pointer gj-unselectable",
                        tmpl: c.icons.expandRow,
                        role: "expander",
                        events: {
                            click: function (b) {
                                var c = $(this),
                                    d = gj.grid.plugins.expandCollapseRows.private;
                                "details" === c.closest("tr").next().attr("data-role") ? d.collapseDetail(a, c, b.data.id) : d.expandDetail(a, $(this), b.data.id);
                            },
                        },
                    }),
                    (c.columns = [b].concat(c.columns)),
                    a.on("rowDataBound", function (a, b, d, e) {
                        b.data("details", $(c.detailTemplate));
                    }),
                    a.on("columnShow", function (b, c) {
                        gj.grid.plugins.expandCollapseRows.private.updateDetailsColSpan(a);
                    }),
                    a.on("columnHide", function (b, c) {
                        gj.grid.plugins.expandCollapseRows.private.updateDetailsColSpan(a);
                    }),
                    a.on("rowRemoving", function (b, c, d, e) {
                        gj.grid.plugins.expandCollapseRows.private.collapseDetail(a, c.children("td").first(), d);
                    }),
                    a.on("dataBinding", function () {
                        a.collapseAll();
                    }),
                    a.on("pageChanging", function () {
                        a.collapseAll();
                    }),
                    a.on("dataBound", function () {
                        var b,
                            c,
                            d,
                            e,
                            f = a.data();
                        if (f.keepExpandedRows && $.isArray(f.expandedRows))
                            for (b = 0; b < f.expandedRows.length; b++)
                                (d = gj.grid.methods.getRowById(a, f.expandedRows[b])) &&
                                    d.length &&
                                    ((e = gj.grid.methods.getColumnPositionByRole(a, "expander")), (c = d.children("td:eq(" + e + ")")) && c.length && gj.grid.plugins.expandCollapseRows.private.expandDetail(a, c));
                    }));
        },
    }),
    (gj.grid.plugins.inlineEditing = {
        renderers: {
            editManager: function (a, b, c, d, e, f) {
                var g = f.data(),
                    h = $(g.inlineEditing.editButton).attr("key", e),
                    i = $(g.inlineEditing.deleteButton).attr("key", e),
                    j = $(g.inlineEditing.updateButton).attr("key", e).hide(),
                    k = $(g.inlineEditing.cancelButton).attr("key", e).hide();
                h.on("click", function (a) {
                    f.edit($(this).attr("key"));
                }),
                    i.on("click", function (a) {
                        f.removeRow($(this).attr("key"));
                    }),
                    j.on("click", function (a) {
                        f.update($(this).attr("key"));
                    }),
                    k.on("click", function (a) {
                        f.cancel($(this).attr("key"));
                    }),
                    d.empty().append(h).append(i).append(j).append(k);
            },
        },
    }),
    (gj.grid.plugins.inlineEditing.config = {
        base: {
            defaultColumnSettings: { editor: void 0, editField: void 0, mode: "readEdit" },
            inlineEditing: {
                mode: "click",
                managementColumn: !0,
                managementColumnConfig: { width: 300, role: "managementColumn", align: "center", renderer: gj.grid.plugins.inlineEditing.renderers.editManager, cssClass: "gj-grid-management-column" },
            },
        },
        bootstrap: { inlineEditing: { managementColumnConfig: { width: 200, role: "managementColumn", align: "center", renderer: gj.grid.plugins.inlineEditing.renderers.editManager, cssClass: "gj-grid-management-column" } } },
        bootstrap4: { inlineEditing: { managementColumnConfig: { width: 280, role: "managementColumn", align: "center", renderer: gj.grid.plugins.inlineEditing.renderers.editManager, cssClass: "gj-grid-management-column" } } },
    }),
    (gj.grid.plugins.inlineEditing.private = {
        localization: function (a) {
            "bootstrap" === a.uiLibrary
                ? ((a.inlineEditing.editButton = '<button role="edit" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ' + gj.grid.messages[a.locale].Edit + "</button>"),
                  (a.inlineEditing.deleteButton =
                      '<button role="delete" class="btn btn-default btn-sm gj-margin-left-10"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ' + gj.grid.messages[a.locale].Delete + "</button>"),
                  (a.inlineEditing.updateButton = '<button role="update" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ' + gj.grid.messages[a.locale].Update + "</button>"),
                  (a.inlineEditing.cancelButton =
                      '<button role="cancel" class="btn btn-default btn-sm gj-margin-left-10"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> ' + gj.grid.messages[a.locale].Cancel + "</button>"))
                : ((a.inlineEditing.editButton = '<button role="edit" class="gj-button-md"><i class="gj-icon pencil" /> ' + gj.grid.messages[a.locale].Edit.toUpperCase() + "</button>"),
                  (a.inlineEditing.deleteButton = '<button role="delete" class="gj-button-md"><i class="gj-icon delete" /> ' + gj.grid.messages[a.locale].Delete.toUpperCase() + "</button>"),
                  (a.inlineEditing.updateButton = '<button role="update" class="gj-button-md"><i class="gj-icon check-circle" /> ' + gj.grid.messages[a.locale].Update.toUpperCase() + "</button>"),
                  (a.inlineEditing.cancelButton = '<button role="cancel" class="gj-button-md"><i class="gj-icon cancel" /> ' + gj.grid.messages[a.locale].Cancel.toUpperCase() + "</button>"));
        },
        editMode: function (a, b, c, d) {
            var e,
                f,
                g,
                h,
                i,
                j = a.data();
            if ("edit" !== b.attr("data-mode"))
                if (c.editor) {
                    if (
                        (gj.grid.plugins.inlineEditing.private.updateOtherCells(a, c.mode),
                        (e = b.find('div[data-role="display"]').hide()),
                        (f = b.find('div[data-role="edit"]').show()),
                        0 === f.length && ((f = $('<div data-role="edit" />')), b.append(f)),
                        (h = d[c.editField || c.field]),
                        (g = f.find("input, select, textarea").first()),
                        g.length)
                    )
                        switch (c.type) {
                            case "checkbox":
                                g.prop("checked", h);
                                break;
                            case "dropdown":
                                g = g.dropdown("value", h);
                                break;
                            default:
                                g.val(h);
                        }
                    else {
                        if ("function" == typeof c.editor) c.editor(f, h, d), (g = f.find("input, select, textarea").first());
                        else if (
                            ((i = "object" == typeof c.editor ? c.editor : {}), (i.uiLibrary = j.uiLibrary), (i.iconsLibrary = j.iconsLibrary), (i.fontSize = a.css("font-size")), (i.showOnFocus = !1), "checkbox" === c.type && gj.checkbox)
                        )
                            (g = $('<input type="checkbox" />').prop("checked", h)), f.append(g), g.checkbox(i);
                        else if (("date" === c.type && gj.datepicker) || ("time" === c.type && gj.timepicker) || ("datetime" === c.type && gj.datetimepicker)) {
                            switch (((g = $('<input type="text" width="100%"/>')), f.append(g), c.format && (i.format = c.format), c.type)) {
                                case "date":
                                    g = g.datepicker(i);
                                    break;
                                case "time":
                                    g = g.timepicker(i);
                                    break;
                                case "datetime":
                                    g = g.datetimepicker(i);
                            }
                            g.value && g.value(e.html());
                        } else
                            "dropdown" === c.type && gj.dropdown
                                ? ((g = $('<select type="text" width="100%"/>')),
                                  f.append(g),
                                  (i.dataBound = function (a) {
                                      var b = $(this).dropdown();
                                      c.editField ? b.value(d[c.editField]) : b.value(d[c.field]);
                                  }),
                                  (g = g.dropdown(i)))
                                : ((g = $('<input type="text" value="' + h + '" class="gj-width-full"/>')), "materialdesign" === j.uiLibrary && g.addClass("gj-textbox-md").css("font-size", a.css("font-size")), f.append(g));
                        "command" !== j.inlineEditing.mode &&
                            "editOnly" !== c.mode &&
                            ((g = f.find("input, select, textarea").first()),
                            g.on("keyup", function (d) {
                                (13 !== d.keyCode && 27 !== d.keyCode) || gj.grid.plugins.inlineEditing.private.displayMode(a, b, c);
                            }));
                    }
                    "INPUT" === g.prop("tagName").toUpperCase() && "TEXT" === g.prop("type").toUpperCase() ? gj.core.setCaretAtEnd(g[0]) : g.focus(), b.attr("data-mode", "edit");
                } else "managementColumn" === c.role && (b.find('[role="edit"]').hide(), b.find('[role="delete"]').hide(), b.find('[role="update"]').show(), b.find('[role="cancel"]').show());
        },
        displayMode: function (a, b, c, d) {
            var e, f, g, h, i, j, k;
            "editOnly" !== c.mode &&
                ("edit" === b.attr("data-mode") &&
                    ((e = b.find('div[data-role="edit"]')),
                    (f = b.find('div[data-role="display"]')),
                    (g = e.find("input, select, textarea").first()),
                    "SELECT" === g[0].tagName.toUpperCase() && g[0].selectedIndex > -1
                        ? ((h = g[0].options[g[0].selectedIndex].innerHTML), (i = g[0].value))
                        : (h = "INPUT" === g[0].tagName.toUpperCase() && "CHECKBOX" === g[0].type.toUpperCase() ? g[0].checked : g.val()),
                    (k = b.parent().data("position")),
                    (j = a.get(k)),
                    !0 !== d &&
                        h !== j[c.field] &&
                        ((j[c.field] = "date" === c.type ? gj.core.parseDate(h, c.format) : h),
                        c.editField && (j[c.editField] = i || h),
                        "editOnly" !== c.mode &&
                            (gj.grid.methods.renderDisplayElement(a, f, c, j, gj.grid.methods.getId(j, a.data("primaryKey"), k), "update"), 0 === b.find("span.gj-dirty").length && b.prepend($('<span class="gj-dirty" />'))),
                        gj.grid.plugins.inlineEditing.events.cellDataChanged(a, b, c, j, h),
                        gj.grid.plugins.inlineEditing.private.updateChanges(a, c, j, h)),
                    e.hide(),
                    f.show(),
                    b.attr("data-mode", "display")),
                "managementColumn" === c.role && (b.find('[role="update"]').hide(), b.find('[role="cancel"]').hide(), b.find('[role="edit"]').show(), b.find('[role="delete"]').show()));
        },
        updateOtherCells: function (a, b) {
            var c = a.data();
            "command" !== c.inlineEditing.mode &&
                "editOnly" !== b &&
                a
                    .find('div[data-role="edit"]:visible')
                    .parent("td")
                    .each(function () {
                        var b = $(this),
                            d = c.columns[b.index()];
                        gj.grid.plugins.inlineEditing.private.displayMode(a, b, d);
                    });
        },
        updateChanges: function (a, b, c, d) {
            var e,
                f,
                g,
                h = a.data();
            h.guid || (h.guid = gj.grid.plugins.inlineEditing.private.generateGUID()),
                h.primaryKey &&
                    ((e = JSON.parse(sessionStorage.getItem("gj.grid." + h.guid))),
                    e
                        ? (f = e.filter(function (a) {
                              return a[h.primaryKey] === c[h.primaryKey];
                          }))
                        : (e = []),
                    f && 1 === f.length ? (f[0][b.field] = d) : ((g = {}), (g[h.primaryKey] = c[h.primaryKey]), h.primaryKey !== b.field && (g[b.field] = d), e.push(g)),
                    sessionStorage.setItem("gj.grid." + h.guid, JSON.stringify(e)));
        },
        generateGUID: function () {
            function a() {
                return Math.floor(65536 * (1 + Math.random()))
                    .toString(16)
                    .substring(1);
            }
            return a() + a() + "-" + a() + "-" + a() + "-" + a() + "-" + a() + a() + a();
        },
    }),
    (gj.grid.plugins.inlineEditing.public = {
        getChanges: function () {
            return JSON.parse(sessionStorage.getItem("gj.grid." + this.data().guid));
        },
        edit: function (a) {
            var b,
                c = this.getById(a),
                d = gj.grid.methods.getRowById(this, a).children("td"),
                e = this.data("columns");
            for (b = 0; b < d.length; b++) gj.grid.plugins.inlineEditing.private.editMode(this, $(d[b]), e[b], c);
            return this;
        },
        update: function (a) {
            var b,
                c = this.getById(a),
                d = gj.grid.methods.getRowById(this, a).children("td"),
                e = this.data("columns");
            for (b = 0; b < d.length; b++) gj.grid.plugins.inlineEditing.private.displayMode(this, $(d[b]), e[b], !1);
            return gj.grid.plugins.inlineEditing.events.rowDataChanged(this, a, c), this;
        },
        cancel: function (a) {
            var b,
                c = (this.getById(a), gj.grid.methods.getRowById(this, a).children("td")),
                d = this.data("columns");
            for (b = 0; b < c.length; b++) gj.grid.plugins.inlineEditing.private.displayMode(this, $(c[b]), d[b], !0);
            return this;
        },
    }),
    (gj.grid.plugins.inlineEditing.events = {
        cellDataChanged: function (a, b, c, d, e, f) {
            a.triggerHandler("cellDataChanged", [b, c, d, e, f]);
        },
        rowDataChanged: function (a, b, c) {
            a.triggerHandler("rowDataChanged", [b, c]);
        },
    }),
    (gj.grid.plugins.inlineEditing.configure = function (a, b, c) {
        var d = a.data();
        $.extend(!0, a, gj.grid.plugins.inlineEditing.public),
            c.inlineEditing &&
                (a.on("dataBound", function () {
                    a.find("span.gj-dirty").remove();
                }),
                a.on("rowDataBound", function (b, c, d, e) {
                    a.cancel(d);
                })),
            "command" === d.inlineEditing.mode
                ? (gj.grid.plugins.inlineEditing.private.localization(d), b.inlineEditing.managementColumn && d.columns.push(b.inlineEditing.managementColumnConfig))
                : a.on("cellDataBound", function (b, c, e, f, g) {
                      f.editor &&
                          ("editOnly" === f.mode
                              ? gj.grid.plugins.inlineEditing.private.editMode(a, c.parent(), f, g)
                              : c.parent("td").on("dblclick" === d.inlineEditing.mode ? "dblclick" : "click", function () {
                                    gj.grid.plugins.inlineEditing.private.editMode(a, c.parent(), f, g);
                                }));
                  });
    }),
    (gj.grid.plugins.optimisticPersistence = {
        config: { base: { optimisticPersistence: { localStorage: void 0, sessionStorage: void 0 } } },
        private: {
            applyParams: function (a) {
                var b,
                    c = a.data(),
                    d = {};
                (b = JSON.parse(sessionStorage.getItem("gj.grid." + c.guid))),
                    b && b.optimisticPersistence && $.extend(d, b.optimisticPersistence),
                    (b = JSON.parse(localStorage.getItem("gj.grid." + c.guid))),
                    b && b.optimisticPersistence && $.extend(d, b.optimisticPersistence),
                    $.extend(c.params, d);
            },
            saveParams: function (a) {
                var b,
                    c,
                    d = a.data(),
                    e = { optimisticPersistence: {} };
                if (d.optimisticPersistence.sessionStorage) {
                    for (b = 0; b < d.optimisticPersistence.sessionStorage.length; b++) (c = d.optimisticPersistence.sessionStorage[b]), (e.optimisticPersistence[c] = d.params[c]);
                    (e = $.extend(!0, JSON.parse(sessionStorage.getItem("gj.grid." + d.guid)), e)), sessionStorage.setItem("gj.grid." + d.guid, JSON.stringify(e));
                }
                if (d.optimisticPersistence.localStorage) {
                    for (e = { optimisticPersistence: {} }, b = 0; b < d.optimisticPersistence.localStorage.length; b++) (c = d.optimisticPersistence.localStorage[b]), (e.optimisticPersistence[c] = d.params[c]);
                    (e = $.extend(!0, JSON.parse(localStorage.getItem("gj.grid." + d.guid)), e)), localStorage.setItem("gj.grid." + d.guid, JSON.stringify(e));
                }
            },
        },
        configure: function (a, b, c) {
            b.guid &&
                (b.optimisticPersistence.localStorage || b.optimisticPersistence.sessionStorage) &&
                (gj.grid.plugins.optimisticPersistence.private.applyParams(a),
                a.on("dataBound", function (b) {
                    gj.grid.plugins.optimisticPersistence.private.saveParams(a);
                }));
        },
    }),
    (gj.grid.plugins.pagination = {
        config: {
            base: { style: { pager: { panel: "", stateDisabled: "", activeButton: "" } }, paramNames: { page: "page", limit: "limit" }, pager: { limit: 10, sizes: [5, 10, 20, 100], leftControls: void 0, rightControls: void 0 } },
            bootstrap: { style: { pager: { panel: "", stateDisabled: "" } } },
            bootstrap4: { style: { pager: { panel: "btn-toolbar", stateDisabled: "" } } },
            glyphicons: {
                icons: {
                    first: '<span class="glyphicon glyphicon-step-backward"></span>',
                    previous: '<span class="glyphicon glyphicon-backward"></span>',
                    next: '<span class="glyphicon glyphicon-forward"></span>',
                    last: '<span class="glyphicon glyphicon-step-forward"></span>',
                    refresh: '<span class="glyphicon glyphicon-refresh"></span>',
                },
            },
            materialicons: {
                icons: {
                    first: '<i class="gj-icon first-page" />',
                    previous: '<i class="gj-icon chevron-left" />',
                    next: '<i class="gj-icon chevron-right" />',
                    last: '<i class="gj-icon last-page" />',
                    refresh: '<i class="gj-icon refresh" />',
                },
            },
            fontawesome: {
                icons: {
                    first: '<i class="fa fa-fast-backward" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-backward" aria-hidden="true"></i>',
                    next: '<i class="fa fa-forward" aria-hidden="true"></i>',
                    last: '<i class="fa fa-fast-forward" aria-hidden="true"></i>',
                    refresh: '<i class="fa fa-refresh" aria-hidden="true"></i>',
                },
            },
        },
        private: {
            init: function (a) {
                var b, c, d, e, f, g, h, i, j, k;
                if (((d = a.data()), d.pager))
                    for (
                        d.params[d.paramNames.page] || (d.params[d.paramNames.page] = 1),
                            d.params[d.paramNames.limit] || (d.params[d.paramNames.limit] = d.pager.limit),
                            gj.grid.plugins.pagination.private.localization(d),
                            b = $('<tr data-role="pager"/>'),
                            c = $("<th/>"),
                            b.append(c),
                            f = $('<div data-role="display" />').addClass(d.style.pager.panel).css({ float: "left" }),
                            g = $('<div data-role="display" />').addClass(d.style.pager.panel).css({ float: "right" }),
                            c.append(f).append(g),
                            h = $("<tfoot />").append(b),
                            a.append(h),
                            gj.grid.plugins.pagination.private.updatePagerColSpan(a),
                            i = gj.grid.methods.clone(d.pager.leftControls),
                            $.each(i, function () {
                                f.append(this);
                            }),
                            j = gj.grid.methods.clone(d.pager.rightControls),
                            $.each(j, function () {
                                g.append(this);
                            }),
                            e = a.find("tfoot [data-role]"),
                            k = 0;
                        k < e.length;
                        k++
                    )
                        gj.grid.plugins.pagination.private.initPagerControl($(e[k]), a);
            },
            localization: function (a) {
                "bootstrap" === a.uiLibrary
                    ? gj.grid.plugins.pagination.private.localizationBootstrap(a)
                    : "bootstrap4" === a.uiLibrary
                    ? gj.grid.plugins.pagination.private.localizationBootstrap4(a)
                    : gj.grid.plugins.pagination.private.localizationMaterialDesign(a);
            },
            localizationBootstrap: function (a) {
                var b = gj.grid.messages[a.locale];
                void 0 === a.pager.leftControls &&
                    (a.pager.leftControls = [
                        $('<button type="button" class="btn btn-default btn-sm">' + (a.icons.first || b.First) + "</button>")
                            .attr("title", b.FirstPageTooltip)
                            .attr("data-role", "page-first"),
                        $('<button type="button" class="btn btn-default btn-sm">' + (a.icons.previous || b.Previous) + "</button>")
                            .attr("title", b.PreviousPageTooltip)
                            .attr("data-role", "page-previous"),
                        $("<div>" + b.Page + "</div>"),
                        $('<input data-role="page-number" class="form-control input-sm" type="text" value="0">'),
                        $("<div>" + b.Of + "</div>"),
                        $('<div data-role="page-label-last">0</div>'),
                        $('<button type="button" class="btn btn-default btn-sm">' + (a.icons.next || b.Next) + "</button>")
                            .attr("title", b.NextPageTooltip)
                            .attr("data-role", "page-next"),
                        $('<button type="button" class="btn btn-default btn-sm">' + (a.icons.last || b.Last) + "</button>")
                            .attr("title", b.LastPageTooltip)
                            .attr("data-role", "page-last"),
                        $('<button type="button" class="btn btn-default btn-sm">' + (a.icons.refresh || b.Refresh) + "</button>")
                            .attr("title", b.Refresh)
                            .attr("data-role", "page-refresh"),
                        $('<select data-role="page-size" class="form-control input-sm" width="60"></select>'),
                    ]),
                    void 0 === a.pager.rightControls &&
                        (a.pager.rightControls = [
                            $("<div>" + b.DisplayingRecords + "</div>"),
                            $('<div data-role="record-first">0</div>'),
                            $("<div>-</div>"),
                            $('<div data-role="record-last">0</div>'),
                            $("<div>" + b.Of + "</div>"),
                            $('<div data-role="record-total">0</div>'),
                        ]);
            },
            localizationBootstrap4: function (a) {
                var b = gj.grid.messages[a.locale];
                void 0 === a.pager.leftControls &&
                    (a.pager.leftControls = [
                        $('<button class="btn btn-default btn-sm gj-cursor-pointer">' + (a.icons.first || b.First) + "</button>")
                            .attr("title", b.FirstPageTooltip)
                            .attr("data-role", "page-first"),
                        $('<button class="btn btn-default btn-sm gj-cursor-pointer">' + (a.icons.previous || b.Previous) + "</button>")
                            .attr("title", b.PreviousPageTooltip)
                            .attr("data-role", "page-previous"),
                        $("<div>" + b.Page + "</div>"),
                        $('<div class="input-group"><input data-role="page-number" class="form-control form-control-sm" type="text" value="0"></div>'),
                        $("<div>" + b.Of + "</div>"),
                        $('<div data-role="page-label-last">0</div>'),
                        $('<button class="btn btn-default btn-sm gj-cursor-pointer">' + (a.icons.next || b.Next) + "</button>")
                            .attr("title", b.NextPageTooltip)
                            .attr("data-role", "page-next"),
                        $('<button class="btn btn-default btn-sm gj-cursor-pointer">' + (a.icons.last || b.Last) + "</button>")
                            .attr("title", b.LastPageTooltip)
                            .attr("data-role", "page-last"),
                        $('<button class="btn btn-default btn-sm gj-cursor-pointer">' + (a.icons.refresh || b.Refresh) + "</button>")
                            .attr("title", b.Refresh)
                            .attr("data-role", "page-refresh"),
                        $('<select data-role="page-size" class="form-control input-sm" width="60"></select>'),
                    ]),
                    void 0 === a.pager.rightControls &&
                        (a.pager.rightControls = [
                            $("<div>" + b.DisplayingRecords + "&nbsp;</div>"),
                            $('<div data-role="record-first">0</div>'),
                            $("<div>-</div>"),
                            $('<div data-role="record-last">0</div>'),
                            $("<div>" + b.Of + "</div>"),
                            $('<div data-role="record-total">0</div>'),
                        ]);
            },
            localizationMaterialDesign: function (a) {
                var b = gj.grid.messages[a.locale];
                void 0 === a.pager.leftControls && (a.pager.leftControls = []),
                    void 0 === a.pager.rightControls &&
                        (a.pager.rightControls = [
                            $('<span class="">' + b.RowsPerPage + "</span>"),
                            $('<select data-role="page-size" class="gj-grid-md-limit-select" width="52"></select></div>'),
                            $('<span class="gj-md-spacer-32">&nbsp;</span>'),
                            $('<span data-role="record-first" class="">0</span>'),
                            $('<span class="">-</span>'),
                            $('<span data-role="record-last" class="">0</span>'),
                            $('<span class="gj-grid-mdl-pager-label">' + b.Of + "</span>"),
                            $('<span data-role="record-total" class="">0</span>'),
                            $('<span class="gj-md-spacer-32">&nbsp;</span>'),
                            $('<button class="gj-button-md">' + (a.icons.previous || b.Previous) + "</button>")
                                .attr("title", b.PreviousPageTooltip)
                                .attr("data-role", "page-previous")
                                .addClass(a.icons.first ? "gj-button-md-icon" : ""),
                            $('<span class="gj-md-spacer-24">&nbsp;</span>'),
                            $('<button class="gj-button-md">' + (a.icons.next || b.Next) + "</button>")
                                .attr("title", b.NextPageTooltip)
                                .attr("data-role", "page-next")
                                .addClass(a.icons.first ? "gj-button-md-icon" : ""),
                        ]);
            },
            initPagerControl: function (a, b) {
                var c = b.data();
                switch (a.data("role")) {
                    case "page-size":
                        c.pager.sizes && 0 < c.pager.sizes.length
                            ? (a.show(),
                              $.each(c.pager.sizes, function () {
                                  a.append($("<option/>").attr("value", this.toString()).text(this.toString()));
                              }),
                              a.change(function () {
                                  var a = parseInt(this.value, 10);
                                  (c.params[c.paramNames.limit] = a), gj.grid.plugins.pagination.private.changePage(b, 1), gj.grid.plugins.pagination.events.pageSizeChange(b, a);
                              }),
                              a.val(c.params[c.paramNames.limit]),
                              gj.dropdown && a.dropdown({ uiLibrary: c.uiLibrary, iconsLibrary: c.iconsLibrary, fontSize: a.css("font-size"), style: { presenter: "btn btn-default btn-sm" } }))
                            : a.hide();
                        break;
                    case "page-refresh":
                        a.on("click", function () {
                            b.reload();
                        });
                }
            },
            reloadPager: function (a, b) {
                var c, d, e, f, g, h, i, j;
                if (((h = a.data()), h.pager)) {
                    for (
                        c = 0 === b ? 0 : parseInt(h.params[h.paramNames.page], 10),
                            d = parseInt(h.params[h.paramNames.limit], 10),
                            e = Math.ceil(b / d),
                            f = 0 === c ? 0 : d * (c - 1) + 1,
                            g = f + d > b ? b : f + d - 1,
                            i = a.find("TFOOT [data-role]"),
                            j = 0;
                        j < i.length;
                        j++
                    )
                        gj.grid.plugins.pagination.private.reloadPagerControl($(i[j]), a, c, e, f, g, b);
                    gj.grid.plugins.pagination.private.updatePagerColSpan(a);
                }
            },
            reloadPagerControl: function (a, b, c, d, e, f, g) {
                var h;
                switch (a.data("role")) {
                    case "page-first":
                        gj.grid.plugins.pagination.private.assignPageHandler(b, a, 1, c < 2);
                        break;
                    case "page-previous":
                        gj.grid.plugins.pagination.private.assignPageHandler(b, a, c - 1, c < 2);
                        break;
                    case "page-number":
                        a.val(c).off("change").on("change", gj.grid.plugins.pagination.private.createChangePageHandler(b, c));
                        break;
                    case "page-label-last":
                        a.text(d);
                        break;
                    case "page-next":
                        gj.grid.plugins.pagination.private.assignPageHandler(b, a, c + 1, d === c);
                        break;
                    case "page-last":
                        gj.grid.plugins.pagination.private.assignPageHandler(b, a, d, d === c);
                        break;
                    case "page-button-one":
                        (h = 1 === c ? 1 : c == d ? c - 2 : c - 1), gj.grid.plugins.pagination.private.assignButtonHandler(b, a, c, h, d);
                        break;
                    case "page-button-two":
                        (h = 1 === c ? 2 : c == d ? d - 1 : c), gj.grid.plugins.pagination.private.assignButtonHandler(b, a, c, h, d);
                        break;
                    case "page-button-three":
                        (h = 1 === c ? c + 2 : c == d ? c : c + 1), gj.grid.plugins.pagination.private.assignButtonHandler(b, a, c, h, d);
                        break;
                    case "record-first":
                        a.text(e);
                        break;
                    case "record-last":
                        a.text(f);
                        break;
                    case "record-total":
                        a.text(g);
                }
            },
            assignPageHandler: function (a, b, c, d) {
                var e = a.data().style.pager;
                d
                    ? b.addClass(e.stateDisabled).prop("disabled", !0).off("click")
                    : b
                          .removeClass(e.stateDisabled)
                          .prop("disabled", !1)
                          .off("click")
                          .on("click", function () {
                              gj.grid.plugins.pagination.private.changePage(a, c);
                          });
            },
            assignButtonHandler: function (a, b, c, d, e) {
                var f = a.data().style.pager;
                d < 1 || d > e
                    ? b.hide()
                    : (b.show().off("click").text(d),
                      d === c
                          ? b.addClass(f.activeButton)
                          : b.removeClass(f.activeButton).on("click", function () {
                                gj.grid.plugins.pagination.private.changePage(a, d);
                            }));
            },
            createChangePageHandler: function (a, b) {
                return function () {
                    var b = (a.data(), parseInt(this.value, 10));
                    gj.grid.plugins.pagination.private.changePage(a, b);
                };
            },
            changePage: function (a, b) {
                var c = a.data();
                !1 === gj.grid.plugins.pagination.events.pageChanging(a, b) || isNaN(b) || (a.find('TFOOT [data-role="page-number"]').val(b), (c.params[c.paramNames.page] = b)), a.reload();
            },
            updatePagerColSpan: function (a) {
                var b = a.find('tfoot > tr[data-role="pager"] > th');
                b && b.length && b.attr("colspan", gj.grid.methods.countVisibleColumns(a));
            },
            isLastRecordVisible: function (a) {
                var b = !0,
                    c = a.data(),
                    d = parseInt(c.params[c.paramNames.limit], 10),
                    e = parseInt(c.params[c.paramNames.page], 10),
                    f = a.count();
                return d && e && (b = (e - 1) * d + f === c.totalRecords), b;
            },
        },
        public: {
            getAll: function (a) {
                var b,
                    c,
                    d,
                    e = this.data();
                return $.isArray(e.dataSource)
                    ? a
                        ? e.dataSource
                        : e.params[e.paramNames.limit] && e.params[e.paramNames.page]
                        ? ((b = parseInt(e.params[e.paramNames.limit], 10)), (c = parseInt(e.params[e.paramNames.page], 10)), (d = (c - 1) * b), e.records.slice(d, d + b))
                        : e.records
                    : e.records;
            },
        },
        events: {
            pageSizeChange: function (a, b) {
                a.triggerHandler("pageSizeChange", [b]);
            },
            pageChanging: function (a, b) {
                a.triggerHandler("pageChanging", [b]);
            },
        },
        configure: function (a, b, c) {
            $.extend(!0, a, gj.grid.plugins.pagination.public);
            a.data();
            c.pager &&
                ((gj.grid.methods.isLastRecordVisible = gj.grid.plugins.pagination.private.isLastRecordVisible),
                a.on("initialized", function () {
                    gj.grid.plugins.pagination.private.init(a);
                }),
                a.on("dataBound", function (b, c, d) {
                    gj.grid.plugins.pagination.private.reloadPager(a, d);
                }),
                a.on("columnShow", function () {
                    gj.grid.plugins.pagination.private.updatePagerColSpan(a);
                }),
                a.on("columnHide", function () {
                    gj.grid.plugins.pagination.private.updatePagerColSpan(a);
                }));
        },
    }),
    (gj.grid.plugins.responsiveDesign = {
        config: { base: { resizeCheckInterval: 500, responsive: !1, showHiddenColumnsAsDetails: !1, defaultColumn: { priority: void 0, minWidth: 250 }, style: { rowDetailItem: "" } }, bootstrap: { style: { rowDetailItem: "col-lg-4" } } },
        private: {
            orderColumns: function (a) {
                var b = [];
                if (a.columns && a.columns.length) {
                    for (i = 0; i < a.columns.length; i++) b.push({ position: i, field: a.columns[i].field, minWidth: a.columns[i].width || a.columns[i].minWidth || a.defaultColumn.minWidth, priority: a.columns[i].priority || 0 });
                    b.sort(function (a, b) {
                        var c = 0;
                        return a.priority < b.priority ? (c = -1) : a.priority > b.priority && (c = 1), c;
                    });
                }
                return b;
            },
            updateDetails: function (a) {
                var b, c, d, e, f, g, h, i, j;
                for (b = a.find('tbody > tr[data-role="row"]'), c = a.data(), d = 0; d < b.length; d++) {
                    for (f = $(b[d]), g = f.data("details"), e = 0; e < c.columns.length; e++)
                        (i = c.columns[e]),
                            (h = g && g.find('div[data-id="' + i.field + '"]')),
                            c.columns[e].hidden
                                ? ((j = "<b>" + (i.title || i.field) + "</b>: {" + i.field + "}"),
                                  h && h.length ? h.empty().html(j) : ((h = $('<div data-id="' + i.field + '"/>').html(j)), h.addClass(c.style.rowDetailItem), (g && g.length) || (g = $('<div class="row"/>')), g.append(h)))
                                : h && h.length && h.remove();
                    a.updateDetails(f);
                }
            },
        },
        public: {
            oldWidth: void 0,
            resizeCheckIntervalId: void 0,
            makeResponsive: function () {
                var a,
                    b,
                    c = 0,
                    d = this.data(),
                    e = gj.grid.plugins.responsiveDesign.private.orderColumns(d);
                for (a = 0; a < e.length; a++) (b = this.find("thead>tr>th:eq(" + e[a].position + ")")), b.is(":visible") && e[a].minWidth < b.width() && (c += b.width() - e[a].minWidth);
                if (c) for (a = 0; a < e.length; a++) (b = this.find("thead>tr>th:eq(" + e[a].position + ")")), !b.is(":visible") && e[a].minWidth <= c && (this.showColumn(e[a].field), (c -= b.width()));
                for (a = e.length - 1; a >= 0; a--) (b = this.find("thead>tr>th:eq(" + e[a].position + ")")), b.is(":visible") && e[a].priority && e[a].minWidth > b.outerWidth() && this.hideColumn(e[a].field);
                return this;
            },
        },
        events: {
            resize: function (a, b, c) {
                a.triggerHandler("resize", [b, c]);
            },
        },
        configure: function (a, b, c) {
            $.extend(!0, a, gj.grid.plugins.responsiveDesign.public),
                b.responsive &&
                    (a.on("initialized", function () {
                        a.makeResponsive(),
                            (a.oldWidth = a.width()),
                            (a.resizeCheckIntervalId = setInterval(function () {
                                var b = a.width();
                                b !== a.oldWidth && gj.grid.plugins.responsiveDesign.events.resize(a, b, a.oldWidth), (a.oldWidth = b);
                            }, b.resizeCheckInterval));
                    }),
                    a.on("destroy", function () {
                        a.resizeCheckIntervalId && clearInterval(a.resizeCheckIntervalId);
                    }),
                    a.on("resize", function () {
                        a.makeResponsive();
                    })),
                b.showHiddenColumnsAsDetails &&
                    gj.grid.plugins.expandCollapseRows &&
                    (a.on("dataBound", function () {
                        gj.grid.plugins.responsiveDesign.private.updateDetails(a);
                    }),
                    a.on("columnHide", function () {
                        gj.grid.plugins.responsiveDesign.private.updateDetails(a);
                    }),
                    a.on("columnShow", function () {
                        gj.grid.plugins.responsiveDesign.private.updateDetails(a);
                    }),
                    a.on("rowDataBound", function () {
                        gj.grid.plugins.responsiveDesign.private.updateDetails(a);
                    }));
        },
    }),
    (gj.grid.plugins.toolbar = {
        config: {
            base: { toolbarTemplate: void 0, title: void 0, style: { toolbar: "gj-grid-md-toolbar" } },
            bootstrap: { style: { toolbar: "gj-grid-bootstrap-toolbar" } },
            bootstrap4: { style: { toolbar: "gj-grid-bootstrap-4-toolbar" } },
        },
        private: {
            init: function (a) {
                var b, c, d;
                (b = a.data()),
                    (c = a.prev('div[data-role="toolbar"]')),
                    (void 0 !== b.toolbarTemplate || void 0 !== b.title || c.length > 0) &&
                        (0 === c.length && ((c = $('<div data-role="toolbar"></div>')), a.before(c)),
                        c.addClass(b.style.toolbar),
                        0 === c.children().length && b.toolbarTemplate && c.append(b.toolbarTemplate),
                        (d = c.find('[data-role="title"]')),
                        0 === d.length && ((d = $('<div data-role="title"/>')), c.prepend(d)),
                        b.title && d.text(b.title),
                        b.minWidth && c.css("min-width", b.minWidth));
            },
        },
        public: {
            title: function (a) {
                var b = this.parent().find('div[data-role="toolbar"] [data-role="title"]');
                return void 0 !== a ? (b.text(a), this) : b.text();
            },
        },
        configure: function (a) {
            $.extend(!0, a, gj.grid.plugins.toolbar.public),
                a.on("initialized", function () {
                    gj.grid.plugins.toolbar.private.init(a);
                }),
                a.on("destroying", function () {
                    a.prev('[data-role="toolbar"]').remove();
                });
        },
    }),
    (gj.grid.plugins.resizableColumns = {
        config: { base: { resizableColumns: !1 } },
        private: {
            init: function (a, b) {
                var c, d, e, f, g, h;
                if (((c = a.find('thead tr[data-role="caption"] th')), c.length)) {
                    for (e = 0; e < c.length - 1; e++)
                        (d = $(c[e])),
                            (f = $('<div class="gj-grid-column-resizer-wrapper" />')),
                            (h = parseInt(d.css("padding-right"), 10) + 3),
                            (g = $('<span class="gj-grid-column-resizer" />').css("margin-right", "-" + h + "px")),
                            g.draggable({
                                start: function () {
                                    a.addClass("gj-unselectable"), a.addClass("gj-grid-resize-cursor");
                                },
                                stop: function () {
                                    a.removeClass("gj-unselectable"), a.removeClass("gj-grid-resize-cursor"), this.style.removeProperty("top"), this.style.removeProperty("left"), this.style.removeProperty("position");
                                },
                                drag: gj.grid.plugins.resizableColumns.private.createResizeHandle(a, d, b.columns[e]),
                            }),
                            d.append(f.append(g));
                    for (e = 0; e < c.length; e++) (d = $(c[e])), d.attr("width") || d.attr("width", d.outerWidth());
                }
            },
            createResizeHandle: function (a, b, c) {
                var d = a.data();
                return function (e, f) {
                    var g,
                        h,
                        i,
                        j,
                        k,
                        l,
                        m = parseInt(b.attr("width"), 10),
                        n = gj.core.position(this),
                        o = { top: f.top - n.top, left: f.left - n.left };
                    if (
                        (m || (m = b.outerWidth()),
                        o.left &&
                            ((k = m + o.left),
                            (c.width = k),
                            b.attr("width", k),
                            (h = b[0].cellIndex),
                            (j = b[0].parentElement.children[h + 1]),
                            (l = parseInt($(j).attr("width"), 10) - o.left),
                            j.setAttribute("width", l),
                            d.resizableColumns))
                    )
                        for (i = a[0].tBodies[0].children, g = 0; g < i.length; g++) i[g].cells[h].setAttribute("width", k), (j = i[g].cells[h + 1]), j.setAttribute("width", l);
                };
            },
        },
        public: {},
        configure: function (a, b, c) {
            $.extend(!0, a, gj.grid.plugins.resizableColumns.public),
                b.resizableColumns &&
                    gj.draggable &&
                    a.on("initialized", function () {
                        gj.grid.plugins.resizableColumns.private.init(a, b);
                    });
        },
    }),
    (gj.grid.plugins.rowReorder = {
        config: { base: { rowReorder: !1, rowReorderColumn: void 0, orderNumberField: void 0, style: { targetRowIndicatorTop: "gj-grid-row-reorder-indicator-top", targetRowIndicatorBottom: "gj-grid-row-reorder-indicator-bottom" } } },
        private: {
            init: function (a) {
                var b,
                    c,
                    d,
                    e = a.find('tbody tr[data-role="row"]');
                for (a.data("rowReorderColumn") && (c = gj.grid.methods.getColumnPosition(a.data("columns"), a.data("rowReorderColumn"))), b = 0; b < e.length; b++)
                    (d = $(e[b])),
                        void 0 !== c ? d.find("td:eq(" + c + ")").on("mousedown", gj.grid.plugins.rowReorder.private.createRowMouseDownHandler(a, d)) : d.on("mousedown", gj.grid.plugins.rowReorder.private.createRowMouseDownHandler(a, d));
            },
            createRowMouseDownHandler: function (a, b) {
                return function (c) {
                    var d,
                        e,
                        f = a.clone(),
                        g = a.data("columns");
                    for (
                        a.addClass("gj-unselectable"),
                            $("body").append(f),
                            f.attr("data-role", "draggable-clone").css("cursor", "move"),
                            f.children("thead").remove().children("tfoot").remove(),
                            f.find('tbody tr:not([data-position="' + b.data("position") + '"])').remove(),
                            e = f.find("tbody tr td"),
                            d = 0;
                        d < e.length;
                        d++
                    )
                        g[d].width && e[d].setAttribute("width", g[d].width);
                    f.draggable({ stop: gj.grid.plugins.rowReorder.private.createDragStopHandler(a, b) }),
                        f.css({ position: "absolute", top: b.offset().top, left: b.offset().left, width: b.width(), zIndex: 1 }),
                        "true" === b.attr("data-droppable") && b.droppable("destroy"),
                        b.siblings('tr[data-role="row"]').each(function () {
                            var a = $(this);
                            "true" === a.attr("data-droppable") && a.droppable("destroy"), a.droppable({ over: gj.grid.plugins.rowReorder.private.createDroppableOverHandler(b), out: gj.grid.plugins.rowReorder.private.droppableOut });
                        }),
                        f.trigger("mousedown");
                };
            },
            createDragStopHandler: function (a, b) {
                return function (c, d) {
                    $('table[data-role="draggable-clone"]').draggable("destroy").remove(),
                        a.removeClass("gj-unselectable"),
                        b.siblings('tr[data-role="row"]').each(function () {
                            var c,
                                e,
                                f,
                                g,
                                h,
                                i = $(this),
                                j = i.data("position"),
                                k = b.data("position"),
                                l = a.data();
                            if (i.droppable("isOver", d)) {
                                for (j < k ? i.before(b) : i.after(b), l.records.splice(j - 1, 0, l.records.splice(k - 1, 1)[0]), c = i.parent().find('tr[data-role="row"]'), f = 0; f < c.length; f++) $(c[f]).attr("data-position", f + 1);
                                if (l.orderNumberField) {
                                    for (f = 0; f < l.records.length; f++) l.records[f][l.orderNumberField] = f + 1;
                                    for (f = 0; f < c.length; f++)
                                        (e = $(c[f])),
                                            (h = gj.grid.methods.getId(e, l.primaryKey, e.attr("data-position"))),
                                            (g = gj.grid.methods.getByPosition(a, e.attr("data-position"))),
                                            a.setCellContent(h, l.orderNumberField, g[l.orderNumberField]);
                                }
                            }
                            i.removeClass("gj-grid-top-border"), i.removeClass("gj-grid-bottom-border"), i.droppable("destroy");
                        });
                };
            },
            createDroppableOverHandler: function (a) {
                return function (b) {
                    var c = $(this);
                    c.data("position") < a.data("position") ? c.addClass("gj-grid-top-border") : c.addClass("gj-grid-bottom-border");
                };
            },
            droppableOut: function () {
                $(this).removeClass("gj-grid-top-border"), $(this).removeClass("gj-grid-bottom-border");
            },
        },
        public: {},
        configure: function (a, b, c) {
            $.extend(!0, a, gj.grid.plugins.rowReorder.public),
                b.rowReorder &&
                    gj.draggable &&
                    gj.droppable &&
                    a.on("dataBound", function () {
                        gj.grid.plugins.rowReorder.private.init(a);
                    });
        },
    }),
    (gj.grid.plugins.export = {
        config: { base: {} },
        public: {
            getCSV: function (a) {
                var b,
                    c,
                    d = "",
                    e = "",
                    f = this.data().columns,
                    g = this.getAll(a);
                if (g.length) {
                    for (b = 0; b < f.length; b++) gj.grid.plugins.export.public.isColumnApplicable(f[b]) && (d += '"' + (f[b].title || f[b].field).replace(/<[^>]+>/g, " ") + '",');
                    for (e += d.slice(0, d.length - 1) + "\r\n", b = 0; b < g.length; b++) {
                        for (d = "", c = 0; c < f.length; c++) gj.grid.plugins.export.public.isColumnApplicable(f[c]) && (d += '"' + g[b][f[c].field] + '",');
                        e += d.slice(0, d.length - 1) + "\r\n";
                    }
                }
                return e;
            },
            downloadCSV: function (a, b) {
                var c = document.createElement("a");
                return (
                    document.body.appendChild(c),
                    (c.download = a || "griddata.csv"),
                    window.navigator.userAgent.indexOf("Edge") > -1 ? (c.href = URL.createObjectURL(new Blob([this.getCSV(b)], { type: "text/csv;charset=utf-8;" }))) : (c.href = "data:text/csv;charset=utf-8," + escape(this.getCSV(b))),
                    c.click(),
                    document.body.removeChild(c),
                    this
                );
            },
            isColumnApplicable: function (a) {
                return !0 !== a.hidden && !a.role;
            },
        },
        configure: function (a) {
            $.extend(!0, a, gj.grid.plugins.export.public);
        },
    }),
    (gj.grid.plugins.columnReorder = {
        config: { base: { columnReorder: !1, dragReady: !1, style: { targetRowIndicatorTop: "gj-grid-row-reorder-indicator-top", targetRowIndicatorBottom: "gj-grid-row-reorder-indicator-bottom" } } },
        private: {
            init: function (a) {
                var b,
                    c,
                    d = a.find("thead tr th");
                for (b = 0; b < d.length; b++)
                    (c = $(d[b])),
                        c.on("mousedown", gj.grid.plugins.columnReorder.private.createMouseDownHandler(a, c)),
                        c.on("mousemove", gj.grid.plugins.columnReorder.private.createMouseMoveHandler(a, c)),
                        c.on("mouseup", gj.grid.plugins.columnReorder.private.createMouseUpHandler(a, c));
            },
            createMouseDownHandler: function (a) {
                return function (b) {
                    a.timeout = setTimeout(function () {
                        a.data("dragReady", !0);
                    }, 100);
                };
            },
            createMouseUpHandler: function (a) {
                return function (b) {
                    clearTimeout(a.timeout), a.data("dragReady", !1);
                };
            },
            createMouseMoveHandler: function (a, b) {
                return function (c) {
                    var d, e;
                    a.data("dragReady") &&
                        (a.data("dragReady", !1),
                        (d = a.clone()),
                        (e = b.index()),
                        a.addClass("gj-unselectable"),
                        $("body").append(d),
                        d.attr("data-role", "draggable-clone").css("cursor", "move"),
                        d
                            .find("thead tr th:eq(" + e + ")")
                            .siblings()
                            .remove(),
                        d.find('tbody tr[data-role != "row"]').remove(),
                        d
                            .find("tbody tr td:nth-child(" + (e + 1) + ")")
                            .siblings()
                            .remove(),
                        d.find("tfoot").remove(),
                        d.draggable({ stop: gj.grid.plugins.columnReorder.private.createDragStopHandler(a, b) }),
                        d.css({ position: "absolute", top: b.offset().top, left: b.offset().left, width: b.width(), zIndex: 1 }),
                        "true" === b.attr("data-droppable") && b.droppable("destroy"),
                        b.siblings("th").each(function () {
                            var c = $(this);
                            "true" === c.attr("data-droppable") && c.droppable("destroy"),
                                c.droppable({ over: gj.grid.plugins.columnReorder.private.createDroppableOverHandler(a, b), out: gj.grid.plugins.columnReorder.private.droppableOut });
                        }),
                        d.trigger("mousedown"));
                };
            },
            createDragStopHandler: function (a, b) {
                return function (c, d) {
                    $('table[data-role="draggable-clone"]').draggable("destroy").remove(),
                        a.removeClass("gj-unselectable"),
                        b.siblings("th").each(function () {
                            var c = $(this),
                                e = a.data(),
                                f = gj.grid.methods.getColumnPosition(e.columns, c.data("field")),
                                g = gj.grid.methods.getColumnPosition(e.columns, b.data("field"));
                            c.removeClass("gj-grid-left-border").removeClass("gj-grid-right-border"),
                                c
                                    .closest("table")
                                    .find('tbody tr[data-role="row"] td:nth-child(' + (c.index() + 1) + ")")
                                    .removeClass("gj-grid-left-border")
                                    .removeClass("gj-grid-right-border"),
                                c.droppable("isOver", d) && (f < g ? c.before(b) : c.after(b), gj.grid.plugins.columnReorder.private.moveRowCells(a, g, f), e.columns.splice(f, 0, e.columns.splice(g, 1)[0])),
                                c.droppable("destroy");
                        });
                };
            },
            moveRowCells: function (a, b, c) {
                var d,
                    e,
                    f = a.find('tbody tr[data-role="row"]');
                for (d = 0; d < f.length; d++) (e = $(f[d])), c < b ? e.find("td:eq(" + c + ")").before(e.find("td:eq(" + b + ")")) : e.find("td:eq(" + c + ")").after(e.find("td:eq(" + b + ")"));
            },
            createDroppableOverHandler: function (a, b) {
                return function (c) {
                    var d = $(this),
                        e = a.data();
                    gj.grid.methods.getColumnPosition(e.columns, d.data("field")) < gj.grid.methods.getColumnPosition(e.columns, b.data("field"))
                        ? (d.addClass("gj-grid-left-border"), a.find('tbody tr[data-role="row"] td:nth-child(' + (d.index() + 1) + ")").addClass("gj-grid-left-border"))
                        : (d.addClass("gj-grid-right-border"), a.find('tbody tr[data-role="row"] td:nth-child(' + (d.index() + 1) + ")").addClass("gj-grid-right-border"));
                };
            },
            droppableOut: function () {
                var a = $(this);
                a.removeClass("gj-grid-left-border").removeClass("gj-grid-right-border"),
                    a
                        .closest("table")
                        .find('tbody tr[data-role="row"] td:nth-child(' + (a.index() + 1) + ")")
                        .removeClass("gj-grid-left-border")
                        .removeClass("gj-grid-right-border");
            },
        },
        public: {},
        configure: function (a, b, c) {
            $.extend(!0, a, gj.grid.plugins.columnReorder.public),
                b.columnReorder &&
                    a.on("initialized", function () {
                        gj.grid.plugins.columnReorder.private.init(a);
                    });
        },
    }),
    (gj.grid.plugins.headerFilter = {
        config: { base: { defaultColumnSettings: { filterable: !0 }, headerFilter: { type: "onenterkeypress" } } },
        private: {
            init: function (a) {
                var b,
                    c,
                    d,
                    e = a.data(),
                    f = $('<tr data-role="filter"/>');
                for (b = 0; b < e.columns.length; b++)
                    (c = $("<th/>")),
                        e.columns[b].filterable &&
                            ((d = $('<input data-field="' + e.columns[b].field + '" class="gj-width-full" />')),
                            "onchange" === e.headerFilter.type
                                ? d.on("input propertychange", function (b) {
                                      gj.grid.plugins.headerFilter.private.reload(a, $(this));
                                  })
                                : (d.on("keypress", function (b) {
                                      13 == b.which && gj.grid.plugins.headerFilter.private.reload(a, $(this));
                                  }),
                                  d.on("blur", function (b) {
                                      gj.grid.plugins.headerFilter.private.reload(a, $(this));
                                  })),
                            c.append(d)),
                        e.columns[b].hidden && c.hide(),
                        f.append(c);
                a.children("thead").append(f);
            },
            reload: function (a, b) {
                var c = {};
                (c[b.data("field")] = b.val()), a.reload(c);
            },
        },
        public: {},
        events: {},
        configure: function (a, b, c) {
            $.extend(!0, a, gj.grid.plugins.headerFilter.public);
            a.data();
            c.headerFilter &&
                a.on("initialized", function () {
                    gj.grid.plugins.headerFilter.private.init(a);
                });
        },
    }),
    (gj.grid.plugins.grouping = {
        config: {
            base: {
                paramNames: { groupBy: "groupBy", groupByDirection: "groupByDirection" },
                grouping: { groupBy: void 0, direction: "asc" },
                icons: { expandGroup: '<i class="gj-icon plus" />', collapseGroup: '<i class="gj-icon minus" />' },
            },
            fontawesome: { icons: { expandGroup: '<i class="fa fa-plus" aria-hidden="true"></i>', collapseGroup: '<i class="fa fa-minus" aria-hidden="true"></i>' } },
            glyphicons: { icons: { expandGroup: '<span class="glyphicon glyphicon-plus" />', collapseGroup: '<span class="glyphicon glyphicon-minus" />' } },
        },
        private: {
            init: function (a) {
                var b,
                    c = a.data();
                (b = void 0),
                    a.on("rowDataBound", function (d, e, f, g) {
                        if (b !== g[c.grouping.groupBy] || 1 === e[0].rowIndex) {
                            var h = gj.grid.methods.countVisibleColumns(a) - 1,
                                i = $('<tr role="group" />'),
                                j = $('<td class="gj-text-align-center gj-unselectable gj-cursor-pointer" />');
                            j.append('<div data-role="display">' + c.icons.collapseGroup + "</div>"),
                                j.on("click", gj.grid.plugins.grouping.private.createExpandCollapseHandler(c)),
                                i.append(j),
                                i.append('<td colspan="' + h + '"><div data-role="display">' + c.grouping.groupBy + ": " + g[c.grouping.groupBy] + "</div></td>"),
                                i.insertBefore(e),
                                (b = g[c.grouping.groupBy]);
                        }
                        e.show();
                    }),
                    (c.params[c.paramNames.groupBy] = c.grouping.groupBy),
                    (c.params[c.paramNames.groupByDirection] = c.grouping.direction);
            },
            grouping: function (a, b) {
                var c = a.data();
                b.sort(gj.grid.methods.createDefaultSorter(c.grouping.direction, c.grouping.groupBy));
            },
            createExpandCollapseHandler: function (a) {
                return function (b) {
                    var c = $(this),
                        d = gj.grid.plugins.grouping.private;
                    "row" === c.closest("tr").next(":visible").data("role") ? d.collapseGroup(a, c) : d.expandGroup(a, c);
                };
            },
            collapseGroup: function (a, b) {
                var c = b.children('div[data-role="display"]');
                b.closest("tr").nextUntil('[role="group"]').hide(), c.empty().append(a.icons.expandGroup);
            },
            expandGroup: function (a, b) {
                var c = b.children('div[data-role="display"]');
                b.closest("tr").nextUntil('[role="group"]').show(), c.empty().append(a.icons.collapseGroup);
            },
        },
        public: {},
        configure: function (a) {
            var b,
                c = a.data();
            $.extend(!0, a, gj.grid.plugins.grouping.public),
                c.grouping &&
                    c.grouping.groupBy &&
                    ((b = { title: "", width: c.defaultIconColumnWidth, align: "center", stopPropagation: !0, cssClass: "gj-cursor-pointer gj-unselectable" }),
                    (c.columns = [b].concat(c.columns)),
                    a.on("initialized", function () {
                        gj.grid.plugins.grouping.private.init(a);
                    }),
                    a.on("dataFiltered", function (b, c) {
                        gj.grid.plugins.grouping.private.grouping(a, c);
                    }));
        },
    }),
    (gj.grid.messages["en-us"] = {
        First: "First",
        Previous: "Previous",
        Next: "Next",
        Last: "Last",
        Page: "Page",
        FirstPageTooltip: "First Page",
        PreviousPageTooltip: "Previous Page",
        NextPageTooltip: "Next Page",
        LastPageTooltip: "Last Page",
        Refresh: "Refresh",
        Of: "of",
        DisplayingRecords: "Displaying records",
        RowsPerPage: "Rows per page:",
        Edit: "Edit",
        Delete: "Delete",
        Update: "Update",
        Cancel: "Cancel",
        NoRecordsFound: "No records found.",
        Loading: "Loading...",
    }),
    (gj.tree = { plugins: {} }),
    (gj.tree.config = {
        base: {
            params: {},
            autoLoad: !0,
            selectionType: "single",
            cascadeSelection: !1,
            dataSource: void 0,
            primaryKey: void 0,
            textField: "text",
            childrenField: "children",
            hasChildrenField: "hasChildren",
            imageCssClassField: "imageCssClass",
            imageUrlField: "imageUrl",
            imageHtmlField: "imageHtml",
            disabledField: "disabled",
            width: void 0,
            border: !1,
            uiLibrary: "materialdesign",
            iconsLibrary: "materialicons",
            autoGenId: 1,
            autoGenFieldName: "autoId_b5497cc5-7ef3-49f5-a7dc-4a932e1aee4a",
            indentation: 24,
            style: { wrapper: "gj-unselectable", list: "gj-list gj-list-md", item: void 0, active: "gj-list-md-active", leafIcon: void 0, border: "gj-tree-md-border" },
            icons: { expand: '<i class="gj-icon chevron-right" />', collapse: '<i class="gj-icon chevron-down" />' },
        },
        bootstrap: { style: { wrapper: "gj-unselectable gj-tree-bootstrap-3", list: "gj-list gj-list-bootstrap list-group", item: "list-group-item", active: "active", border: "gj-tree-bootstrap-border" }, iconsLibrary: "glyphicons" },
        bootstrap4: {
            style: { wrapper: "gj-unselectable gj-tree-bootstrap-4", list: "gj-list gj-list-bootstrap", item: "list-group-item", active: "active", border: "gj-tree-bootstrap-border" },
            icons: { expand: '<i class="gj-icon plus" />', collapse: '<i class="gj-icon minus" />' },
        },
        materialicons: { style: { expander: "gj-tree-material-icons-expander" } },
        fontawesome: { style: { expander: "gj-tree-font-awesome-expander" }, icons: { expand: '<i class="fa fa-plus" aria-hidden="true"></i>', collapse: '<i class="fa fa-minus" aria-hidden="true"></i>' } },
        glyphicons: { style: { expander: "gj-tree-glyphicons-expander" }, icons: { expand: '<span class="glyphicon glyphicon-plus" />', collapse: '<span class="glyphicon glyphicon-minus" />' } },
    }),
    (gj.tree.events = {
        initialized: function (a) {
            a.triggerHandler("initialized");
        },
        dataBinding: function (a) {
            a.triggerHandler("dataBinding");
        },
        dataBound: function (a) {
            a.triggerHandler("dataBound");
        },
        select: function (a, b, c) {
            return a.triggerHandler("select", [b, c]);
        },
        unselect: function (a, b, c) {
            return a.triggerHandler("unselect", [b, c]);
        },
        expand: function (a, b, c) {
            return a.triggerHandler("expand", [b, c]);
        },
        collapse: function (a, b, c) {
            return a.triggerHandler("collapse", [b, c]);
        },
        enable: function (a, b) {
            return a.triggerHandler("enable", [b]);
        },
        disable: function (a, b) {
            return a.triggerHandler("disable", [b]);
        },
        destroying: function (a) {
            return a.triggerHandler("destroying");
        },
        nodeDataBound: function (a, b, c, d) {
            return a.triggerHandler("nodeDataBound", [b, c, d]);
        },
    }),
    (gj.tree.methods = {
        init: function (a) {
            return gj.widget.prototype.init.call(this, a, "tree"), gj.tree.methods.initialize.call(this), this.data("autoLoad") && this.reload(), this;
        },
        initialize: function () {
            var a = this.data(),
                b = $('<ul class="' + a.style.list + '"/>');
            this.empty().addClass(a.style.wrapper).append(b), a.width && this.width(a.width), a.border && this.addClass(a.style.border), gj.tree.events.initialized(this);
        },
        useHtmlDataSource: function (a, b) {
            b.dataSource = [];
        },
        render: function (a, b) {
            var c;
            return b && ("string" == typeof b && JSON && (b = JSON.parse(b)), (c = a.data()), (c.records = b), c.primaryKey || gj.tree.methods.genAutoId(c, c.records), gj.tree.methods.loadData(a)), a;
        },
        filter: function (a) {
            return a.data().dataSource;
        },
        genAutoId: function (a, b) {
            var c;
            for (c = 0; c < b.length; c++) (b[c][a.autoGenFieldName] = a.autoGenId++), b[c][a.childrenField] && b[c][a.childrenField].length && gj.tree.methods.genAutoId(a, b[c][a.childrenField]);
        },
        loadData: function (a) {
            var b,
                c = a.data("records"),
                d = a.children("ul");
            for (gj.tree.events.dataBinding(a), d.off().empty(), b = 0; b < c.length; b++) gj.tree.methods.appendNode(a, d, c[b], 1);
            gj.tree.events.dataBound(a);
        },
        appendNode: function (a, b, c, d, e) {
            var f,
                g,
                h,
                i,
                j,
                k = a.data(),
                l = k.primaryKey ? c[k.primaryKey] : c[k.autoGenFieldName];
            if (
                ((g = $('<li data-id="' + l + '" data-role="node" />').addClass(k.style.item)),
                ($wrapper = $('<div data-role="wrapper" />')),
                ($expander = $('<span data-role="expander" data-mode="close"></span>').addClass(k.style.expander)),
                ($display = $('<span data-role="display">' + c[k.textField] + "</span>")),
                (hasChildren = void 0 !== c[k.hasChildrenField] && "true" === c[k.hasChildrenField].toString().toLowerCase()),
                (disabled = void 0 !== c[k.disabledField] && "true" === c[k.disabledField].toString().toLowerCase()),
                k.indentation && $wrapper.append('<span data-role="spacer" style="width: ' + k.indentation * (d - 1) + 'px;"></span>'),
                disabled ? gj.tree.methods.disableNode(a, g) : ($expander.on("click", gj.tree.methods.expanderClickHandler(a)), $display.on("click", gj.tree.methods.displayClickHandler(a))),
                $wrapper.append($expander),
                $wrapper.append($display),
                g.append($wrapper),
                e ? b.find("li:eq(" + (e - 1) + ")").before(g) : b.append(g),
                k.imageCssClassField && c[k.imageCssClassField]
                    ? ((i = $('<span data-role="image"><span class="' + c[k.imageCssClassField] + '"></span></span>')), i.insertBefore($display))
                    : k.imageUrlField && c[k.imageUrlField]
                    ? ((i = $('<span data-role="image"></span>')), i.insertBefore($display), (j = $('<img src="' + c[k.imageUrlField] + '"></img>')), j.attr("width", i.width()).attr("height", i.height()), i.append(j))
                    : k.imageHtmlField && c[k.imageHtmlField] && ((i = $('<span data-role="image">' + c[k.imageHtmlField] + "</span>")), i.insertBefore($display)),
                (c[k.childrenField] && c[k.childrenField].length) || hasChildren)
            ) {
                if (($expander.empty().append(k.icons.expand), (h = $("<ul />").addClass(k.style.list).addClass("gj-hidden")), g.append(h), c[k.childrenField] && c[k.childrenField].length))
                    for (f = 0; f < c[k.childrenField].length; f++) gj.tree.methods.appendNode(a, h, c[k.childrenField][f], d + 1);
            } else k.style.leafIcon ? $expander.addClass(k.style.leafIcon) : $expander.html("&nbsp;");
            gj.tree.events.nodeDataBound(a, g, c.id, c);
        },
        expanderClickHandler: function (a) {
            return function (b) {
                var c = $(this),
                    d = c.closest("li");
                "close" === c.attr("data-mode") ? a.expand(d) : a.collapse(d);
            };
        },
        expand: function (a, b, c) {
            var d,
                e,
                f = b.find('>[data-role="wrapper"]>[data-role="expander"]'),
                g = a.data(),
                h = b.attr("data-id"),
                i = b.children("ul");
            if (!1 !== gj.tree.events.expand(a, b, h) && i && i.length && (i.show(), f.attr("data-mode", "open"), f.empty().append(g.icons.collapse), c))
                for (d = b.find("ul>li"), e = 0; e < d.length; e++) gj.tree.methods.expand(a, $(d[e]), c);
            return a;
        },
        collapse: function (a, b, c) {
            var d,
                e,
                f = b.find('>[data-role="wrapper"]>[data-role="expander"]'),
                g = a.data(),
                h = b.attr("data-id"),
                i = b.children("ul");
            if (!1 !== gj.tree.events.collapse(a, b, h) && i && i.length && (i.hide(), f.attr("data-mode", "close"), f.empty().append(g.icons.expand), c))
                for (d = b.find("ul>li"), e = 0; e < d.length; e++) gj.tree.methods.collapse(a, $(d[e]), c);
            return a;
        },
        expandAll: function (a) {
            var b,
                c = a.find("ul>li");
            for (b = 0; b < c.length; b++) gj.tree.methods.expand(a, $(c[b]), !0);
            return a;
        },
        collapseAll: function (a) {
            var b,
                c = a.find("ul>li");
            for (b = 0; b < c.length; b++) gj.tree.methods.collapse(a, $(c[b]), !0);
            return a;
        },
        displayClickHandler: function (a) {
            return function (b) {
                var c = $(this),
                    d = c.closest("li"),
                    e = a.data().cascadeSelection;
                "true" === d.attr("data-selected") ? gj.tree.methods.unselect(a, d, e) : ("single" === a.data("selectionType") && gj.tree.methods.unselectAll(a), gj.tree.methods.select(a, d, e));
            };
        },
        selectAll: function (a) {
            var b,
                c = a.find("ul>li");
            for (b = 0; b < c.length; b++) gj.tree.methods.select(a, $(c[b]), !0);
            return a;
        },
        select: function (a, b, c) {
            var d,
                e,
                f = a.data();
            if ("true" !== b.attr("data-selected") && !1 !== gj.tree.events.select(a, b, b.attr("data-id")) && (b.addClass(f.style.active).attr("data-selected", "true"), c))
                for (e = b.find("ul>li"), d = 0; d < e.length; d++) gj.tree.methods.select(a, $(e[d]), c);
        },
        unselectAll: function (a) {
            var b,
                c = a.find("ul>li");
            for (b = 0; b < c.length; b++) gj.tree.methods.unselect(a, $(c[b]), !0);
            return a;
        },
        unselect: function (a, b, c) {
            var d, e;
            a.data();
            if ("true" === b.attr("data-selected") && !1 !== gj.tree.events.unselect(a, b, b.attr("data-id")) && (b.removeClass(a.data().style.active).removeAttr("data-selected"), c))
                for (e = b.find("ul>li"), d = 0; d < e.length; d++) gj.tree.methods.unselect(a, $(e[d]), c);
        },
        getSelections: function (a) {
            var b,
                c,
                d,
                e = [],
                f = a.children("li");
            if (f && f.length)
                for (b = 0; b < f.length; b++) (c = $(f[b])), "true" === c.attr("data-selected") ? e.push(c.attr("data-id")) : c.has("ul") && ((d = gj.tree.methods.getSelections(c.children("ul"))), d.length && (e = e.concat(d)));
            return e;
        },
        getDataById: function (a, b, c) {
            var d,
                e = a.data(),
                f = void 0;
            for (d = 0; d < c.length; d++) {
                if (e.primaryKey && c[d][e.primaryKey] == b) {
                    f = c[d];
                    break;
                }
                if (c[d][e.autoGenFieldName] == b) {
                    f = c[d];
                    break;
                }
                if (c[d][e.childrenField] && c[d][e.childrenField].length && (f = gj.tree.methods.getDataById(a, b, c[d][e.childrenField]))) break;
            }
            return f;
        },
        getDataByText: function (a, b, c) {
            var d,
                e = void 0,
                f = a.data();
            for (d = 0; d < c.length; d++) {
                if (b === c[d][f.textField]) {
                    e = c[d];
                    break;
                }
                if (c[d][f.childrenField] && c[d][f.childrenField].length && (e = gj.tree.methods.getDataByText(a, b, c[d][f.childrenField]))) break;
            }
            return e;
        },
        getNodeById: function (a, b) {
            var c,
                d,
                e = void 0,
                f = a.children("li");
            if (f && f.length)
                for (c = 0; c < f.length; c++) {
                    if (((d = $(f[c])), b == d.attr("data-id"))) {
                        e = d;
                        break;
                    }
                    if (d.has("ul") && (e = gj.tree.methods.getNodeById(d.children("ul"), b))) break;
                }
            return e;
        },
        getNodeByText: function (a, b) {
            var c,
                d,
                e = void 0,
                f = a.children("li");
            if (f && f.length)
                for (c = 0; c < f.length; c++) {
                    if (((d = $(f[c])), b === d.find('>[data-role="wrapper"]>[data-role="display"]').text())) {
                        e = d;
                        break;
                    }
                    if (d.has("ul") && (e = gj.tree.methods.getNodeByText(d.children("ul"), b))) break;
                }
            return e;
        },
        addNode: function (a, b, c, d) {
            var e,
                f,
                g = a.data();
            return (
                c && c.length
                    ? ("li" === c[0].tagName.toLowerCase() && (0 === c.children("ul").length && (c.find('[data-role="expander"]').empty().append(g.icons.collapse), c.append($("<ul />").addClass(g.style.list))), (c = c.children("ul"))),
                      (f = a.getDataById(c.parent().data("id"))),
                      f[g.childrenField] || (f[g.childrenField] = []),
                      f[g.childrenField].push(b))
                    : ((c = a.children("ul")), a.data("records").push(b)),
                (e = c.parentsUntil('[data-type="tree"]', "ul").length + 1),
                g.primaryKey || gj.tree.methods.genAutoId(g, [b]),
                gj.tree.methods.appendNode(a, c, b, e, d),
                a
            );
        },
        remove: function (a, b) {
            return gj.tree.methods.removeDataById(a, b.attr("data-id"), a.data("records")), b.remove(), a;
        },
        removeDataById: function (a, b, c) {
            var d,
                e = a.data();
            for (d = 0; d < c.length; d++) {
                if (e.primaryKey && c[d][e.primaryKey] == b) {
                    c.splice(d, 1);
                    break;
                }
                if (c[d][e.autoGenFieldName] == b) {
                    c.splice(d, 1);
                    break;
                }
                c[d][e.childrenField] && c[d][e.childrenField].length && gj.tree.methods.removeDataById(a, b, c[d][e.childrenField]);
            }
        },
        update: function (a, b, c) {
            var d = a.data(),
                e = a.getNodeById(b);
            a.getDataById(b);
            return c, e.find('>[data-role="wrapper"]>[data-role="display"]').html(c[d.textField]), gj.tree.events.nodeDataBound(a, e, b, c), a;
        },
        getChildren: function (a, b, c) {
            var d,
                e,
                f = [],
                c = void 0 === c || c;
            for (e = c ? b.find("ul li") : b.find(">ul>li"), d = 0; d < e.length; d++) f.push($(e[d]).data("id"));
            return f;
        },
        enableAll: function (a) {
            var b,
                c = a.find("ul>li");
            for (b = 0; b < c.length; b++) gj.tree.methods.enableNode(a, $(c[b]), !0);
            return a;
        },
        enableNode: function (a, b, c) {
            var d,
                e,
                f = b.find('>[data-role="wrapper"]>[data-role="expander"]'),
                g = b.find('>[data-role="wrapper"]>[data-role="display"]'),
                c = void 0 === c || c;
            if ((b.removeClass("disabled"), f.on("click", gj.tree.methods.expanderClickHandler(a)), g.on("click", gj.tree.methods.displayClickHandler(a)), gj.tree.events.enable(a, b), c))
                for (e = b.find("ul>li"), d = 0; d < e.length; d++) gj.tree.methods.enableNode(a, $(e[d]), c);
        },
        disableAll: function (a) {
            var b,
                c = a.find("ul>li");
            for (b = 0; b < c.length; b++) gj.tree.methods.disableNode(a, $(c[b]), !0);
            return a;
        },
        disableNode: function (a, b, c) {
            var d,
                e,
                f = b.find('>[data-role="wrapper"]>[data-role="expander"]'),
                g = b.find('>[data-role="wrapper"]>[data-role="display"]'),
                c = void 0 === c || c;
            if ((b.addClass("disabled"), f.off("click"), g.off("click"), gj.tree.events.disable(a, b), c)) for (e = b.find("ul>li"), d = 0; d < e.length; d++) gj.tree.methods.disableNode(a, $(e[d]), c);
        },
        destroy: function (a) {
            return a.data() && (gj.tree.events.destroying(a), a.xhr && a.xhr.abort(), a.off(), a.removeData(), a.removeAttr("data-type"), a.removeClass().empty()), a;
        },
        pathFinder: function (a, b, c, d) {
            var e,
                f = !1;
            for (e = 0; e < b.length; e++) {
                if (b[e].id == c) {
                    f = !0;
                    break;
                }
                if (gj.tree.methods.pathFinder(a, b[e][a.childrenField], c, d)) {
                    d.push(b[e].data[a.textField]), (f = !0);
                    break;
                }
            }
            return f;
        },
    }),
    (gj.tree.widget = function (a, b) {
        var c = this,
            d = gj.tree.methods;
        return (
            (c.reload = function (a) {
                return gj.widget.prototype.reload.call(this, a);
            }),
            (c.render = function (a) {
                return d.render(this, a);
            }),
            (c.addNode = function (a, b, c) {
                return d.addNode(this, a, b, c);
            }),
            (c.removeNode = function (a) {
                return d.remove(this, a);
            }),
            (c.updateNode = function (a, b) {
                return d.update(this, a, b);
            }),
            (c.destroy = function () {
                return d.destroy(this);
            }),
            (c.expand = function (a, b) {
                return d.expand(this, a, b);
            }),
            (c.collapse = function (a, b) {
                return d.collapse(this, a, b);
            }),
            (c.expandAll = function () {
                return d.expandAll(this);
            }),
            (c.collapseAll = function () {
                return d.collapseAll(this);
            }),
            (c.getDataById = function (a) {
                return d.getDataById(this, a, this.data("records"));
            }),
            (c.getDataByText = function (a) {
                return d.getDataByText(this, a, this.data("records"));
            }),
            (c.getNodeById = function (a) {
                return d.getNodeById(this.children("ul"), a);
            }),
            (c.getNodeByText = function (a) {
                return d.getNodeByText(this.children("ul"), a);
            }),
            (c.getAll = function () {
                return this.data("records");
            }),
            (c.select = function (a) {
                return d.select(this, a);
            }),
            (c.unselect = function (a) {
                return d.unselect(this, a);
            }),
            (c.selectAll = function () {
                return d.selectAll(this);
            }),
            (c.unselectAll = function () {
                return d.unselectAll(this);
            }),
            (c.getSelections = function () {
                return d.getSelections(this.children("ul"));
            }),
            (c.getChildren = function (a, b) {
                return d.getChildren(this, a, b);
            }),
            (c.parents = function (a) {
                var b = [],
                    c = this.data();
                return d.pathFinder(c, c.records, a, b), b.reverse();
            }),
            (c.enable = function (a, b) {
                return d.enableNode(this, a, b);
            }),
            (c.enableAll = function () {
                return d.enableAll(this);
            }),
            (c.disable = function (a, b) {
                return d.disableNode(this, a, b);
            }),
            (c.disableAll = function () {
                return d.disableAll(this);
            }),
            $.extend(a, c),
            "tree" !== a.attr("data-type") && d.init.call(a, b),
            a
        );
    }),
    (gj.tree.widget.prototype = new gj.widget()),
    (gj.tree.widget.constructor = gj.tree.widget),
    (function (a) {
        a.fn.tree = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.tree.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.tree.widget(this, a);
            }
        };
    })(jQuery),
    (gj.tree.plugins.checkboxes = {
        config: { base: { checkboxes: void 0, checkedField: "checked", cascadeCheck: !0 } },
        private: {
            dataBound: function (a) {
                var b;
                a.data("cascadeCheck") &&
                    ((b = a.find('li[data-role="node"]')),
                    $.each(b, function () {
                        var a = $(this),
                            b = a.find('[data-role="checkbox"] input[type="checkbox"]').checkbox("state");
                        "checked" === b && (gj.tree.plugins.checkboxes.private.updateChildrenState(a, b), gj.tree.plugins.checkboxes.private.updateParentState(a, b));
                    }));
            },
            nodeDataBound: function (a, b, c, d) {
                var e, f, g, h, i;
                0 === b.find('> [data-role="wrapper"] > [data-role="checkbox"]').length &&
                    ((e = a.data()),
                    (f = b.find('> [data-role="wrapper"] > [data-role="expander"]')),
                    (g = $('<input type="checkbox"/>')),
                    (h = $('<span data-role="checkbox"></span>').append(g)),
                    (i = void 0 !== d[e.disabledField] && "true" === d[e.disabledField].toString().toLowerCase()),
                    (g = g.checkbox({
                        uiLibrary: e.uiLibrary,
                        iconsLibrary: e.iconsLibrary,
                        change: function (c, e) {
                            gj.tree.plugins.checkboxes.events.checkboxChange(a, b, d, g.state());
                        },
                    })),
                    i && g.prop("disabled", !0),
                    d[e.checkedField] && g.state("checked"),
                    g.on("click", function (a) {
                        var b = g.closest("li"),
                            c = g.state();
                        e.cascadeCheck && (gj.tree.plugins.checkboxes.private.updateChildrenState(b, c), gj.tree.plugins.checkboxes.private.updateParentState(b, c));
                    }),
                    f.after(h));
            },
            updateParentState: function (a, b) {
                var c, d, e, f, g, h;
                (c = a.parent("ul").parent("li")),
                    1 === c.length &&
                        ((d = a.parent("ul").parent("li").find('> [data-role="wrapper"] > [data-role="checkbox"] input[type="checkbox"]')),
                        (e = a.siblings().find('> [data-role="wrapper"] > span[data-role="checkbox"] input[type="checkbox"]')),
                        (f = "checked" === b),
                        (g = "unchecked" === b),
                        (h = "indeterminate"),
                        $.each(e, function () {
                            var a = $(this).checkbox("state");
                            f && "checked" !== a && (f = !1), g && "unchecked" !== a && (g = !1);
                        }),
                        f && !g && (h = "checked"),
                        !f && g && (h = "unchecked"),
                        d.checkbox("state", h),
                        gj.tree.plugins.checkboxes.private.updateParentState(c, d.checkbox("state")));
            },
            updateChildrenState: function (a, b) {
                var c = a.find('ul li [data-role="wrapper"] [data-role="checkbox"] input[type="checkbox"]');
                c.length > 0 &&
                    $.each(c, function () {
                        $(this).checkbox("state", b);
                    });
            },
            update: function (a, b, c) {
                var d = b.find('[data-role="checkbox"] input[type="checkbox"]').first();
                $(d).checkbox("state", c), a.data().cascadeCheck && (gj.tree.plugins.checkboxes.private.updateChildrenState(b, c), gj.tree.plugins.checkboxes.private.updateParentState(b, c));
            },
        },
        public: {
            getCheckedNodes: function () {
                var a = [],
                    b = this.find('li [data-role="checkbox"] input[type="checkbox"]');
                return (
                    $.each(b, function () {
                        var b = $(this);
                        "checked" === b.checkbox("state") && a.push(b.closest("li").data("id"));
                    }),
                    a
                );
            },
            checkAll: function () {
                var a = this.find('li [data-role="checkbox"] input[type="checkbox"]');
                return (
                    $.each(a, function () {
                        $(this).checkbox("state", "checked");
                    }),
                    this
                );
            },
            uncheckAll: function () {
                var a = this.find('li [data-role="checkbox"] input[type="checkbox"]');
                return (
                    $.each(a, function () {
                        $(this).checkbox("state", "unchecked");
                    }),
                    this
                );
            },
            check: function (a) {
                return gj.tree.plugins.checkboxes.private.update(this, a, "checked"), this;
            },
            uncheck: function (a) {
                return gj.tree.plugins.checkboxes.private.update(this, a, "unchecked"), this;
            },
        },
        events: {
            checkboxChange: function (a, b, c, d) {
                return a.triggerHandler("checkboxChange", [b, c, d]);
            },
        },
        configure: function (a) {
            a.data("checkboxes") &&
                gj.checkbox &&
                ($.extend(!0, a, gj.tree.plugins.checkboxes.public),
                a.on("nodeDataBound", function (b, c, d, e) {
                    gj.tree.plugins.checkboxes.private.nodeDataBound(a, c, d, e);
                }),
                a.on("dataBound", function () {
                    gj.tree.plugins.checkboxes.private.dataBound(a);
                }),
                a.on("enable", function (a, b) {
                    b.find('>[data-role="wrapper"]>[data-role="checkbox"] input[type="checkbox"]').prop("disabled", !1);
                }),
                a.on("disable", function (a, b) {
                    b.find('>[data-role="wrapper"]>[data-role="checkbox"] input[type="checkbox"]').prop("disabled", !0);
                }));
        },
    }),
    (gj.tree.plugins.dragAndDrop = {
        config: {
            base: { dragAndDrop: void 0, style: { dragEl: "gj-tree-drag-el gj-tree-md-drag-el", dropAsChildIcon: "gj-cursor-pointer gj-icon plus", dropAbove: "gj-tree-drop-above", dropBelow: "gj-tree-drop-below" } },
            bootstrap: { style: { dragEl: "gj-tree-drag-el gj-tree-bootstrap-drag-el", dropAsChildIcon: "glyphicon glyphicon-plus", dropAbove: "drop-above", dropBelow: "drop-below" } },
            bootstrap4: { style: { dragEl: "gj-tree-drag-el gj-tree-bootstrap-drag-el", dropAsChildIcon: "gj-cursor-pointer gj-icon plus", dropAbove: "drop-above", dropBelow: "drop-below" } },
        },
        private: {
            nodeDataBound: function (a, b) {
                var c = b.children('[data-role="wrapper"]'),
                    d = b.find('>[data-role="wrapper"]>[data-role="display"]');
                c.length &&
                    d.length &&
                    (d.on("mousedown", gj.tree.plugins.dragAndDrop.private.createNodeMouseDownHandler(a)),
                    d.on("mousemove", gj.tree.plugins.dragAndDrop.private.createNodeMouseMoveHandler(a, b, d)),
                    d.on("mouseup", gj.tree.plugins.dragAndDrop.private.createNodeMouseUpHandler(a)));
            },
            createNodeMouseDownHandler: function (a) {
                return function (b) {
                    a.data("dragReady", !0);
                };
            },
            createNodeMouseUpHandler: function (a) {
                return function (b) {
                    a.data("dragReady", !1);
                };
            },
            createNodeMouseMoveHandler: function (a, b, c) {
                return function (d) {
                    if (a.data("dragReady")) {
                        var e,
                            f,
                            g,
                            h,
                            i = a.data();
                        a.data("dragReady", !1),
                            (e = c
                                .clone()
                                .wrap('<div data-role="wrapper"/>')
                                .closest("div")
                                .wrap('<li class="' + i.style.item + '" />')
                                .closest("li")
                                .wrap('<ul class="' + i.style.list + '" />')
                                .closest("ul")),
                            $("body").append(e),
                            e.attr("data-role", "draggable-clone").addClass("gj-unselectable").addClass(i.style.dragEl),
                            e.find('[data-role="wrapper"]').prepend('<span data-role="indicator" />'),
                            e.draggable({ drag: gj.tree.plugins.dragAndDrop.private.createDragHandler(a, b, c), stop: gj.tree.plugins.dragAndDrop.private.createDragStopHandler(a, b, c) }),
                            (f = c.parent()),
                            (g = c.offset().top),
                            (g -= parseInt(f.css("border-top-width")) + parseInt(f.css("margin-top")) + parseInt(f.css("padding-top"))),
                            (h = c.offset().left),
                            (h -= parseInt(f.css("border-left-width")) + parseInt(f.css("margin-left")) + parseInt(f.css("padding-left"))),
                            (h -= e.find('[data-role="indicator"]').outerWidth(!0)),
                            e.css({ position: "absolute", top: g, left: h, width: c.outerWidth(!0) }),
                            "true" === c.attr("data-droppable") && c.droppable("destroy"),
                            gj.tree.plugins.dragAndDrop.private.getTargetDisplays(a, b, c).each(function () {
                                var a = $(this);
                                "true" === a.attr("data-droppable") && a.droppable("destroy"), a.droppable();
                            }),
                            gj.tree.plugins.dragAndDrop.private.getTargetDisplays(a, b).each(function () {
                                var a = $(this);
                                "true" === a.attr("data-droppable") && a.droppable("destroy"), a.droppable();
                            }),
                            e.trigger("mousedown");
                    }
                };
            },
            getTargetDisplays: function (a, b, c) {
                return a.find('[data-role="display"]').not(c).not(b.find('[data-role="display"]'));
            },
            getTargetWrappers: function (a, b) {
                return a.find('[data-role="wrapper"]').not(b.find('[data-role="wrapper"]'));
            },
            createDragHandler: function (a, b, c) {
                var d = gj.tree.plugins.dragAndDrop.private.getTargetDisplays(a, b, c),
                    e = gj.tree.plugins.dragAndDrop.private.getTargetWrappers(a, b),
                    f = a.data();
                return function (a, b, c) {
                    var g = $(this),
                        h = !1;
                    d.each(function () {
                        var a,
                            b = $(this);
                        if (b.droppable("isOver", c)) return (a = g.find('[data-role="indicator"]')), f.style.dropAsChildIcon ? a.addClass(f.style.dropAsChildIcon) : a.text("+"), (h = !0), !1;
                        g.find('[data-role="indicator"]').removeClass(f.style.dropAsChildIcon).empty();
                    }),
                        e.each(function () {
                            var a,
                                b = $(this);
                            !h && b.droppable("isOver", c)
                                ? ((a = b.position().top + b.outerHeight() / 2), c.y < a ? b.addClass(f.style.dropAbove).removeClass(f.style.dropBelow) : b.addClass(f.style.dropBelow).removeClass(f.style.dropAbove))
                                : b.removeClass(f.style.dropAbove).removeClass(f.style.dropBelow);
                        });
                };
            },
            createDragStopHandler: function (a, b, c) {
                var d = gj.tree.plugins.dragAndDrop.private.getTargetDisplays(a, b, c),
                    e = gj.tree.plugins.dragAndDrop.private.getTargetWrappers(a, b),
                    f = a.data();
                return function (c, g) {
                    var h,
                        i,
                        j,
                        k,
                        l = !1;
                    $(this).draggable("destroy").remove(),
                        d.each(function () {
                            var c,
                                d = $(this);
                            if (d.droppable("isOver", g))
                                return (
                                    (i = d.closest("li")),
                                    (j = b.parent("ul").parent("li")),
                                    (c = i.children("ul")),
                                    0 === c.length && ((c = $("<ul />").addClass(f.style.list)), i.append(c)),
                                    !1 !== gj.tree.plugins.dragAndDrop.events.nodeDrop(a, b.data("id"), i.data("id"), c.children("li").length + 1) &&
                                        (c.append(b),
                                        (h = a.getDataById(b.data("id"))),
                                        gj.tree.methods.removeDataById(a, b.data("id"), f.records),
                                        (k = a.getDataById(c.parent().data("id"))),
                                        void 0 === k[f.childrenField] && (k[f.childrenField] = []),
                                        k[f.childrenField].push(h),
                                        gj.tree.plugins.dragAndDrop.private.refresh(a, b, i, j)),
                                    (l = !0),
                                    !1
                                );
                            d.droppable("destroy");
                        }),
                        l ||
                            e.each(function () {
                                var c,
                                    d,
                                    e,
                                    k = $(this);
                                if (k.droppable("isOver", g))
                                    return (
                                        (i = k.closest("li")),
                                        (j = b.parent("ul").parent("li")),
                                        (c = g.y < k.position().top + k.outerHeight() / 2),
                                        (e = b.data("id")),
                                        (d = i.prevAll('li:not([data-id="' + e + '"])').length + (c ? 1 : 2)),
                                        !1 !== gj.tree.plugins.dragAndDrop.events.nodeDrop(a, e, i.parent("ul").parent("li").data("id"), d) &&
                                            ((h = a.getDataById(b.data("id"))),
                                            gj.tree.methods.removeDataById(a, b.data("id"), f.records),
                                            a.getDataById(i.parent().data("id"))[f.childrenField].splice(i.index() + (c ? 0 : 1), 0, h),
                                            c ? b.insertBefore(i) : b.insertAfter(i),
                                            gj.tree.plugins.dragAndDrop.private.refresh(a, b, i, j)),
                                        !1
                                    );
                                k.droppable("destroy");
                            });
                };
            },
            refresh: function (a, b, c, d) {
                var e = a.data();
                gj.tree.plugins.dragAndDrop.private.refreshNode(a, c),
                    gj.tree.plugins.dragAndDrop.private.refreshNode(a, d),
                    gj.tree.plugins.dragAndDrop.private.refreshNode(a, b),
                    b.find('li[data-role="node"]').each(function () {
                        gj.tree.plugins.dragAndDrop.private.refreshNode(a, $(this));
                    }),
                    c.children('[data-role="wrapper"]').removeClass(e.style.dropAbove).removeClass(e.style.dropBelow);
            },
            refreshNode: function (a, b) {
                var c = b.children('[data-role="wrapper"]'),
                    d = c.children('[data-role="expander"]'),
                    e = c.children('[data-role="spacer"]'),
                    f = b.children("ul"),
                    g = a.data(),
                    h = b.parentsUntil('[data-type="tree"]', "ul").length;
                f.length && f.children().length ? (f.is(":visible") ? d.empty().append(g.icons.collapse) : d.empty().append(g.icons.expand)) : d.empty(),
                    c.removeClass(g.style.dropAbove).removeClass(g.style.dropBelow),
                    e.css("width", g.indentation * (h - 1));
            },
        },
        public: {},
        events: {
            nodeDrop: function (a, b, c, d) {
                return a.triggerHandler("nodeDrop", [b, c, d]);
            },
        },
        configure: function (a) {
            $.extend(!0, a, gj.tree.plugins.dragAndDrop.public),
                a.data("dragAndDrop") &&
                    gj.draggable &&
                    gj.droppable &&
                    a.on("nodeDataBound", function (b, c) {
                        gj.tree.plugins.dragAndDrop.private.nodeDataBound(a, c);
                    });
        },
    }),
    (gj.tree.plugins.lazyLoading = {
        config: { base: { paramNames: { parentId: "parentId" }, lazyLoading: !1 } },
        private: {
            nodeDataBound: function (a, b, c, d) {
                var e = a.data(),
                    f = b.find('> [data-role="wrapper"] > [data-role="expander"]');
                d.hasChildren && f.empty().append(e.icons.expand);
            },
            createDoneHandler: function (a, b) {
                return function (c) {
                    var d,
                        e,
                        f,
                        g = a.data();
                    if (("string" == typeof c && JSON && (c = JSON.parse(c)), c && c.length)) {
                        for (f = b.children("ul"), 0 === f.length && ((f = $("<ul />").addClass(g.style.list)), b.append(f)), d = 0; d < c.length; d++) a.addNode(c[d], f);
                        (e = b.find('>[data-role="wrapper"]>[data-role="expander"]')), e.attr("data-mode", "open"), e.empty().append(g.icons.collapse), gj.tree.events.dataBound(a);
                    }
                };
            },
            expand: function (a, b, c) {
                var d,
                    e = a.data(),
                    f = {},
                    g = b.find(">ul>li");
                (g && g.length) ||
                    ("string" == typeof e.dataSource &&
                        ((f[e.paramNames.parentId] = c), (d = { url: e.dataSource, data: f }), a.xhr && a.xhr.abort(), (a.xhr = $.ajax(d).done(gj.tree.plugins.lazyLoading.private.createDoneHandler(a, b)).fail(a.createErrorHandler()))));
            },
        },
        public: {},
        events: {},
        configure: function (a, b, c) {
            c.lazyLoading &&
                (a.on("nodeDataBound", function (b, c, d, e) {
                    gj.tree.plugins.lazyLoading.private.nodeDataBound(a, c, d, e);
                }),
                a.on("expand", function (b, c, d) {
                    gj.tree.plugins.lazyLoading.private.expand(a, c, d);
                }));
        },
    }),
    (gj.checkbox = { plugins: {} }),
    (gj.checkbox.config = {
        base: { uiLibrary: "materialdesign", iconsLibrary: "materialicons", style: { wrapperCssClass: "gj-checkbox-md", spanCssClass: void 0 } },
        bootstrap: { style: { wrapperCssClass: "gj-checkbox-bootstrap" }, iconsLibrary: "glyphicons" },
        bootstrap4: { style: { wrapperCssClass: "gj-checkbox-bootstrap gj-checkbox-bootstrap-4" }, iconsLibrary: "materialicons" },
        materialicons: { style: { iconsCssClass: "gj-checkbox-material-icons", spanCssClass: "gj-icon" } },
        glyphicons: { style: { iconsCssClass: "gj-checkbox-glyphicons", spanCssClass: "" } },
        fontawesome: { style: { iconsCssClass: "gj-checkbox-fontawesome", spanCssClass: "fa" } },
    }),
    (gj.checkbox.methods = {
        init: function (a) {
            var b = this;
            return gj.widget.prototype.init.call(this, a, "checkbox"), b.attr("data-checkbox", "true"), gj.checkbox.methods.initialize(b), b;
        },
        initialize: function (a) {
            var b,
                c,
                d = a.data();
            d.style.wrapperCssClass &&
                ((b = $('<label class="' + d.style.wrapperCssClass + " " + d.style.iconsCssClass + '"></label>')),
                a.attr("id") && b.attr("for", a.attr("id")),
                a.wrap(b),
                (c = $("<span />")),
                d.style.spanCssClass && c.addClass(d.style.spanCssClass),
                a.parent().append(c));
        },
        state: function (a, b) {
            return b
                ? ("checked" === b
                      ? (a.prop("indeterminate", !1), a.prop("checked", !0))
                      : "unchecked" === b
                      ? (a.prop("indeterminate", !1), a.prop("checked", !1))
                      : "indeterminate" === b && (a.prop("checked", !0), a.prop("indeterminate", !0)),
                  gj.checkbox.events.change(a, b),
                  a)
                : (b = a.prop("indeterminate") ? "indeterminate" : a.prop("checked") ? "checked" : "unchecked");
        },
        toggle: function (a) {
            return "checked" == a.state() ? a.state("unchecked") : a.state("checked"), a;
        },
        destroy: function (a) {
            return "true" === a.attr("data-checkbox") && (a.removeData(), a.removeAttr("data-guid"), a.removeAttr("data-checkbox"), a.off(), a.next("span").remove(), a.unwrap()), a;
        },
    }),
    (gj.checkbox.events = {
        change: function (a, b) {
            return a.triggerHandler("change", [b]);
        },
    }),
    (gj.checkbox.widget = function (a, b) {
        var c = this,
            d = gj.checkbox.methods;
        return (
            (c.toggle = function () {
                return d.toggle(this);
            }),
            (c.state = function (a) {
                return d.state(this, a);
            }),
            (c.destroy = function () {
                return d.destroy(this);
            }),
            $.extend(a, c),
            "true" !== a.attr("data-checkbox") && d.init.call(a, b),
            a
        );
    }),
    (gj.checkbox.widget.prototype = new gj.widget()),
    (gj.checkbox.widget.constructor = gj.checkbox.widget),
    (function (a) {
        a.fn.checkbox = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.checkbox.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.checkbox.widget(this, a);
            }
        };
    })(jQuery),
    (gj.editor = { plugins: {}, messages: {} }),
    (gj.editor.config = {
        base: {
            height: 300,
            width: void 0,
            uiLibrary: "materialdesign",
            iconsLibrary: "materialicons",
            locale: "en-us",
            buttons: void 0,
            style: { wrapper: "gj-editor gj-editor-md", buttonsGroup: "gj-button-md-group", button: "gj-button-md", buttonActive: "active" },
        },
        bootstrap: { style: { wrapper: "gj-editor gj-editor-bootstrap", buttonsGroup: "btn-group", button: "btn btn-default gj-cursor-pointer", buttonActive: "active" } },
        bootstrap4: { style: { wrapper: "gj-editor gj-editor-bootstrap", buttonsGroup: "btn-group", button: "btn btn-outline-secondary gj-cursor-pointer", buttonActive: "active" } },
        materialicons: {
            icons: {
                bold: '<i class="gj-icon bold" />',
                italic: '<i class="gj-icon italic" />',
                strikethrough: '<i class="gj-icon strikethrough" />',
                underline: '<i class="gj-icon underlined" />',
                listBulleted: '<i class="gj-icon list-bulleted" />',
                listNumbered: '<i class="gj-icon list-numbered" />',
                indentDecrease: '<i class="gj-icon indent-decrease" />',
                indentIncrease: '<i class="gj-icon indent-increase" />',
                alignLeft: '<i class="gj-icon align-left" />',
                alignCenter: '<i class="gj-icon align-center" />',
                alignRight: '<i class="gj-icon align-right" />',
                alignJustify: '<i class="gj-icon align-justify" />',
                undo: '<i class="gj-icon undo" />',
                redo: '<i class="gj-icon redo" />',
            },
        },
        fontawesome: {
            icons: {
                bold: '<i class="fa fa-bold" aria-hidden="true"></i>',
                italic: '<i class="fa fa-italic" aria-hidden="true"></i>',
                strikethrough: '<i class="fa fa-strikethrough" aria-hidden="true"></i>',
                underline: '<i class="fa fa-underline" aria-hidden="true"></i>',
                listBulleted: '<i class="fa fa-list-ul" aria-hidden="true"></i>',
                listNumbered: '<i class="fa fa-list-ol" aria-hidden="true"></i>',
                indentDecrease: '<i class="fa fa-indent" aria-hidden="true"></i>',
                indentIncrease: '<i class="fa fa-outdent" aria-hidden="true"></i>',
                alignLeft: '<i class="fa fa-align-left" aria-hidden="true"></i>',
                alignCenter: '<i class="fa fa-align-center" aria-hidden="true"></i>',
                alignRight: '<i class="fa fa-align-right" aria-hidden="true"></i>',
                alignJustify: '<i class="fa fa-align-justify" aria-hidden="true"></i>',
                undo: '<i class="fa fa-undo" aria-hidden="true"></i>',
                redo: '<i class="fa fa-repeat" aria-hidden="true"></i>',
            },
        },
    }),
    (gj.editor.methods = {
        init: function (a) {
            return gj.widget.prototype.init.call(this, a, "editor"), this.attr("data-editor", "true"), gj.editor.methods.initialize(this), this;
        },
        initialize: function (a) {
            var b,
                c,
                d,
                e,
                f,
                g = this,
                h = a.data();
            if (
                (a.hide(),
                "wrapper" !== a[0].parentElement.attributes.role && ((d = document.createElement("div")), d.setAttribute("role", "wrapper"), a[0].parentNode.insertBefore(d, a[0]), d.appendChild(a[0])),
                gj.editor.methods.localization(h),
                $(d).addClass(h.style.wrapper),
                h.width && $(d).width(h.width),
                (e = $(d).children('div[role="body"]')),
                0 === e.length && ((e = $('<div role="body"></div>')), $(d).append(e), a[0].innerText && (e[0].innerHTML = a[0].innerText)),
                e.attr("contenteditable", !0),
                e.on("keydown", function (b) {
                    var c = event.keyCode || event.charCode;
                    !1 === gj.editor.events.changing(a) && 8 !== c && 46 !== c && b.preventDefault();
                }),
                e.on("mouseup keyup mouseout cut paste", function (b) {
                    g.updateToolbar(a, f), gj.editor.events.changed(a), a.html(e.html());
                }),
                (f = $(d).children('div[role="toolbar"]')),
                0 === f.length)
            ) {
                (f = $('<div role="toolbar"></div>')), e.before(f);
                for (var i in h.buttons) {
                    b = $("<div />").addClass(h.style.buttonsGroup);
                    for (var j in h.buttons[i])
                        (c = $(h.buttons[i][j])),
                            c.on("click", function () {
                                gj.editor.methods.executeCmd(a, e, f, $(this));
                            }),
                            b.append(c);
                    f.append(b);
                }
            }
            e.height(h.height - gj.core.height(f[0], !0));
        },
        localization: function (a) {
            var b = gj.editor.messages[a.locale];
            void 0 === a.buttons &&
                (a.buttons = [
                    [
                        '<button type="button" class="' + a.style.button + '" title="' + b.bold + '" role="bold">' + a.icons.bold + "</button>",
                        '<button type="button" class="' + a.style.button + '" title="' + b.italic + '" role="italic">' + a.icons.italic + "</button>",
                        '<button type="button" class="' + a.style.button + '" title="' + b.strikethrough + '" role="strikethrough">' + a.icons.strikethrough + "</button>",
                        '<button type="button" class="' + a.style.button + '" title="' + b.underline + '" role="underline">' + a.icons.underline + "</button>",
                    ],
                    [
                        '<button type="button" class="' + a.style.button + '" title="' + b.listBulleted + '" role="insertunorderedlist">' + a.icons.listBulleted + "</button>",
                        '<button type="button" class="' + a.style.button + '" title="' + b.listNumbered + '" role="insertorderedlist">' + a.icons.listNumbered + "</button>",
                        '<button type="button" class="' + a.style.button + '" title="' + b.indentDecrease + '" role="outdent">' + a.icons.indentDecrease + "</button>",
                        '<button type="button" class="' + a.style.button + '" title="' + b.indentIncrease + '" role="indent">' + a.icons.indentIncrease + "</button>",
                    ],
                    [
                        '<button type="button" class="' + a.style.button + '" title="' + b.alignLeft + '" role="justifyleft">' + a.icons.alignLeft + "</button>",
                        '<button type="button" class="' + a.style.button + '" title="' + b.alignCenter + '" role="justifycenter">' + a.icons.alignCenter + "</button>",
                        '<button type="button" class="' + a.style.button + '" title="' + b.alignRight + '" role="justifyright">' + a.icons.alignRight + "</button>",
                        '<button type="button" class="' + a.style.button + '" title="' + b.alignJustify + '" role="justifyfull">' + a.icons.alignJustify + "</button>",
                    ],
                    [
                        '<button type="button" class="' + a.style.button + '" title="' + b.undo + '" role="undo">' + a.icons.undo + "</button>",
                        '<button type="button" class="' + a.style.button + '" title="' + b.redo + '" role="redo">' + a.icons.redo + "</button>",
                    ],
                ]);
        },
        updateToolbar: function (a, b) {
            var c = a.data();
            $buttons = b.find("[role]").each(function () {
                var a = $(this),
                    b = a.attr("role");
                b && document.queryCommandEnabled(b) && "true" === document.queryCommandValue(b) ? a.addClass(c.style.buttonActive) : a.removeClass(c.style.buttonActive);
            });
        },
        executeCmd: function (a, b, c, d) {
            b.focus(), document.execCommand(d.attr("role"), !1), gj.editor.methods.updateToolbar(a, c);
        },
        content: function (a, b) {
            var c = a.parent().children('div[role="body"]');
            return void 0 === b ? c.html() : c.html(b);
        },
        destroy: function (a) {
            var b;
            return (
                "true" === a.attr("data-editor") &&
                    ((b = a.parent()), b.children('div[role="body"]').remove(), b.children('div[role="toolbar"]').remove(), a.unwrap(), a.removeData(), a.removeAttr("data-guid"), a.removeAttr("data-editor"), a.off(), a.show()),
                a
            );
        },
    }),
    (gj.editor.events = {
        changing: function (a) {
            return a.triggerHandler("changing");
        },
        changed: function (a) {
            return a.triggerHandler("changed");
        },
    }),
    (gj.editor.widget = function (a, b) {
        var c = this,
            d = gj.editor.methods;
        return (
            (c.content = function (a) {
                return d.content(this, a);
            }),
            (c.destroy = function () {
                return d.destroy(this);
            }),
            $.extend(a, c),
            "true" !== a.attr("data-editor") && d.init.call(a, b),
            a
        );
    }),
    (gj.editor.widget.prototype = new gj.widget()),
    (gj.editor.widget.constructor = gj.editor.widget),
    (function (a) {
        a.fn.editor = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.editor.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.editor.widget(this, a);
            }
        };
    })(jQuery),
    (gj.editor.messages["en-us"] = {
        bold: "Bold",
        italic: "Italic",
        strikethrough: "Strikethrough",
        underline: "Underline",
        listBulleted: "List Bulleted",
        listNumbered: "List Numbered",
        indentDecrease: "Indent Decrease",
        indentIncrease: "Indent Increase",
        alignLeft: "Align Left",
        alignCenter: "Align Center",
        alignRight: "Align Right",
        alignJustify: "Align Justify",
        undo: "Undo",
        redo: "Redo",
    }),
    (gj.dropdown = { plugins: {} }),
    (gj.dropdown.config = {
        base: {
            dataSource: void 0,
            textField: "text",
            valueField: "value",
            selectedField: "selected",
            width: void 0,
            maxHeight: "auto",
            placeholder: void 0,
            fontSize: void 0,
            uiLibrary: "materialdesign",
            iconsLibrary: "materialicons",
            icons: { dropdown: '<i class="gj-icon arrow-dropdown" />', dropup: '<i class="gj-icon arrow-dropup" />' },
            style: { wrapper: "gj-dropdown gj-dropdown-md gj-unselectable", list: "gj-list gj-list-md gj-dropdown-list-md", active: "gj-list-md-active" },
        },
        bootstrap: {
            style: {
                wrapper: "gj-dropdown gj-dropdown-bootstrap gj-dropdown-bootstrap-3 gj-unselectable",
                presenter: "btn btn-default",
                list: "gj-list gj-list-bootstrap gj-dropdown-list-bootstrap list-group",
                item: "list-group-item",
                active: "active",
            },
            iconsLibrary: "glyphicons",
        },
        bootstrap4: {
            style: {
                wrapper: "gj-dropdown gj-dropdown-bootstrap gj-dropdown-bootstrap-4 gj-unselectable",
                presenter: "btn btn-outline-secondary",
                list: "gj-list gj-list-bootstrap gj-dropdown-list-bootstrap list-group",
                item: "list-group-item",
                active: "active",
            },
        },
        materialicons: { style: { expander: "gj-dropdown-expander-mi" } },
        fontawesome: { icons: { dropdown: '<i class="fa fa-caret-down" aria-hidden="true"></i>', dropup: '<i class="fa fa-caret-up" aria-hidden="true"></i>' }, style: { expander: "gj-dropdown-expander-fa" } },
        glyphicons: { icons: { dropdown: '<span class="caret"></span>', dropup: '<span class="dropup"><span class="caret" ></span></span>' }, style: { expander: "gj-dropdown-expander-glyphicons" } },
    }),
    (gj.dropdown.methods = {
        init: function (a) {
            return gj.widget.prototype.init.call(this, a, "dropdown"), this.attr("data-dropdown", "true"), gj.dropdown.methods.initialize(this), this;
        },
        getHTMLConfig: function () {
            var a = gj.widget.prototype.getHTMLConfig.call(this),
                b = this[0].attributes;
            return b.placeholder && (a.placeholder = b.placeholder.value), a;
        },
        initialize: function (a) {
            var b = a.data(),
                c = a.parent('div[role="wrapper"]'),
                d = $('<span role="display"></span>'),
                e = $('<span role="expander">' + b.icons.dropdown + "</span>").addClass(b.style.expander),
                f = $('<button role="presenter" type="button"></button>').addClass(b.style.presenter),
                g = $('<ul role="list" class="' + b.style.list + '"></ul>').attr("guid", a.attr("data-guid"));
            0 === c.length ? ((c = $('<div role="wrapper" />').addClass(b.style.wrapper)), a.wrap(c)) : c.addClass(b.style.wrapper),
                b.fontSize && f.css("font-size", b.fontSize),
                f.on("click", function (b) {
                    g.is(":visible") ? gj.dropdown.methods.close(a, g) : gj.dropdown.methods.open(a, g);
                }),
                f.on("blur", function (b) {
                    setTimeout(function () {
                        gj.dropdown.methods.close(a, g);
                    }, 500);
                }),
                f.append(d).append(e),
                a.hide(),
                a.after(f),
                $("body").append(g),
                g.hide(),
                a.reload();
        },
        setListPosition: function (a, b, c) {
            var d,
                e,
                f,
                g,
                h = a.getBoundingClientRect(),
                i = window.scrollY || window.pageYOffset || 0;
            window.scrollX || window.pageXOffset;
            (b.style.overflow = ""),
                (b.style.overflowX = ""),
                (b.style.height = ""),
                gj.core.setChildPosition(a, b),
                (d = gj.core.height(b, !0)),
                (g = b.getBoundingClientRect()),
                (e = gj.core.height(a, !0)),
                "auto" === c.maxHeight
                    ? h.top < g.top
                        ? h.top + d + e > window.innerHeight && (f = window.innerHeight - h.top - e - 3)
                        : h.top - d - 3 > 0
                        ? (b.style.top = Math.round(h.top + i - d - 3) + "px")
                        : ((b.style.top = i + "px"), (f = h.top - 3))
                    : !isNaN(c.maxHeight) && c.maxHeight < d && (f = c.maxHeight),
                f && ((b.style.overflow = "scroll"), (b.style.overflowX = "hidden"), (b.style.height = f + "px"));
        },
        useHtmlDataSource: function (a, b) {
            var c,
                d,
                e = [],
                f = a.find("option");
            for (c = 0; c < f.length; c++) (d = {}), (d[b.valueField] = f[c].value), (d[b.textField] = f[c].innerHTML), (d[b.selectedField] = a[0].value === f[c].value), e.push(d);
            b.dataSource = e;
        },
        filter: function (a) {
            var b,
                c,
                d = a.data();
            if (d.dataSource) {
                if ("string" == typeof d.dataSource[0]) for (b = 0; b < d.dataSource.length; b++) (c = {}), (c[d.valueField] = d.dataSource[b]), (c[d.textField] = d.dataSource[b]), (d.dataSource[b] = c);
            } else d.dataSource = [];
            return d.dataSource;
        },
        render: function (a, b) {
            var c = [],
                d = a.data(),
                e = a.parent(),
                f = $("body").children('[role="list"][guid="' + a.attr("data-guid") + '"]'),
                g = e.children('[role="presenter"]'),
                h = (g.children('[role="expander"]'), g.children('[role="display"]'));
            if ((a.data("records", b), a.empty(), f.empty(), b && b.length))
                if (
                    ($.each(b, function () {
                        var b,
                            e = this[d.valueField],
                            g = this[d.textField],
                            h = this[d.selectedField] && "true" === this[d.selectedField].toString().toLowerCase();
                        (b = $('<li value="' + e + '"><div data-role="wrapper"><span data-role="display">' + g + "</span></div></li>")),
                            b.addClass(d.style.item),
                            b.on("click", function (b) {
                                gj.dropdown.methods.select(a, e);
                            }),
                            f.append(b),
                            a.append('<option value="' + e + '">' + g + "</option>"),
                            h && c.push(e);
                    }),
                    0 === c.length)
                )
                    a.prepend('<option value=""></option>'), (a[0].selectedIndex = 0), d.placeholder && (h[0].innerHTML = '<span class="placeholder">' + d.placeholder + "</span>");
                else for (i = 0; i < c.length; i++) gj.dropdown.methods.select(a, c[i]);
            return d.width && (e.css("width", d.width), g.css("width", d.width)), d.fontSize && f.children("li").css("font-size", d.fontSize), gj.dropdown.events.dataBound(a), a;
        },
        open: function (a, b) {
            var c = a.data(),
                d = a.parent().find('[role="expander"]'),
                e = a.parent().find('[role="presenter"]'),
                f = gj.core.getScrollParent(a[0]);
            b.css("width", gj.core.width(e[0])),
                b.show(),
                gj.dropdown.methods.setListPosition(e[0], b[0], c),
                d.html(c.icons.dropup),
                f &&
                    ((c.parentScrollHandler = function () {
                        gj.dropdown.methods.setListPosition(e[0], b[0], c);
                    }),
                    gj.dropdown.methods.addParentsScrollListener(f, c.parentScrollHandler));
        },
        close: function (a, b) {
            var c = a.data(),
                d = a.parent().find('[role="expander"]'),
                e = gj.core.getScrollParent(a[0]);
            d.html(c.icons.dropdown), e && c.parentScrollHandler && gj.dropdown.methods.removeParentsScrollListener(e, c.parentScrollHandler), b.hide();
        },
        addParentsScrollListener: function (a, b) {
            var c = gj.core.getScrollParent(a.parentNode);
            a.addEventListener("scroll", b), c && gj.dropdown.methods.addParentsScrollListener(c, b);
        },
        removeParentsScrollListener: function (a, b) {
            var c = gj.core.getScrollParent(a.parentNode);
            a.removeEventListener("scroll", b), c && gj.dropdown.methods.removeParentsScrollListener(c, b);
        },
        select: function (a, b) {
            var c = a.data(),
                d = $("body").children('[role="list"][guid="' + a.attr("data-guid") + '"]'),
                e = d.children('li[value="' + b + '"]'),
                f = a.next('[role="presenter"]').find('[role="display"]'),
                g = gj.dropdown.methods.getRecordByValue(a, b);
            return (
                d.children("li").removeClass(c.style.active),
                g ? (e.addClass(c.style.active), (a[0].value = b), (f[0].innerHTML = g[c.textField])) : (c.placeholder && (f[0].innerHTML = '<span class="placeholder">' + c.placeholder + "</span>"), (a[0].value = "")),
                gj.dropdown.events.change(a),
                gj.dropdown.methods.close(a, d),
                a
            );
        },
        getRecordByValue: function (a, b) {
            var c,
                d = a.data(),
                e = void 0;
            for (c = 0; c < d.records.length; c++)
                if (d.records[c][d.valueField] === b) {
                    e = d.records[c];
                    break;
                }
            return e;
        },
        value: function (a, b) {
            return void 0 === b ? a.val() : (gj.dropdown.methods.select(a, b), a);
        },
        destroy: function (a) {
            var b = a.data(),
                c = a.parent('div[role="wrapper"]');
            return (
                b &&
                    (a.xhr && a.xhr.abort(),
                    a.off(),
                    a.removeData(),
                    a.removeAttr("data-type").removeAttr("data-guid").removeAttr("data-dropdown"),
                    a.removeClass(),
                    c.length > 0 && (c.children('[role="presenter"]').remove(), c.children('[role="list"]').remove(), a.unwrap()),
                    a.show()),
                a
            );
        },
    }),
    (gj.dropdown.events = {
        change: function (a) {
            return a.triggerHandler("change");
        },
        dataBound: function (a) {
            return a.triggerHandler("dataBound");
        },
    }),
    (gj.dropdown.widget = function (a, b) {
        var c = this,
            d = gj.dropdown.methods;
        return (
            (c.value = function (a) {
                return d.value(this, a);
            }),
            (c.enable = function () {
                return d.enable(this);
            }),
            (c.disable = function () {
                return d.disable(this);
            }),
            (c.destroy = function () {
                return d.destroy(this);
            }),
            $.extend(a, c),
            "true" !== a.attr("data-dropdown") && d.init.call(a, b),
            a
        );
    }),
    (gj.dropdown.widget.prototype = new gj.widget()),
    (gj.dropdown.widget.constructor = gj.dropdown.widget),
    (gj.dropdown.widget.prototype.getHTMLConfig = gj.dropdown.methods.getHTMLConfig),
    (function (a) {
        a.fn.dropdown = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.dropdown.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.dropdown.widget(this, a);
            }
        };
    })(jQuery),
    (gj.datepicker = { plugins: {} }),
    (gj.datepicker.config = {
        base: {
            showOtherMonths: !1,
            selectOtherMonths: !0,
            width: void 0,
            minDate: void 0,
            maxDate: void 0,
            format: "mm/dd/yyyy",
            uiLibrary: "materialdesign",
            iconsLibrary: "materialicons",
            value: void 0,
            weekStartDay: 0,
            disableDates: void 0,
            disableDaysOfWeek: void 0,
            calendarWeeks: !1,
            keyboardNavigation: !0,
            locale: "en-us",
            icons: { rightIcon: '<i class="gj-icon">event</i>', previousMonth: '<i class="gj-icon chevron-left"></i>', nextMonth: '<i class="gj-icon chevron-right"></i>' },
            fontSize: void 0,
            size: "default",
            modal: !1,
            header: !1,
            footer: !1,
            showOnFocus: !0,
            showRightIcon: !0,
            style: { modal: "gj-modal", wrapper: "gj-datepicker gj-datepicker-md gj-unselectable", input: "gj-textbox-md", calendar: "gj-picker gj-picker-md datepicker gj-unselectable", footer: "", button: "gj-button-md" },
        },
        bootstrap: {
            style: {
                wrapper: "gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group",
                input: "form-control",
                calendar: "gj-picker gj-picker-bootstrap datepicker gj-unselectable",
                footer: "modal-footer",
                button: "btn btn-default",
            },
            iconsLibrary: "glyphicons",
            showOtherMonths: !0,
        },
        bootstrap4: {
            style: {
                wrapper: "gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group",
                input: "form-control",
                calendar: "gj-picker gj-picker-bootstrap datepicker gj-unselectable",
                footer: "modal-footer",
                button: "btn btn-default",
            },
            showOtherMonths: !0,
        },
        fontawesome: { icons: { rightIcon: '<i class="fa fa-calendar" aria-hidden="true"></i>', previousMonth: '<i class="fa fa-chevron-left" aria-hidden="true"></i>', nextMonth: '<i class="fa fa-chevron-right" aria-hidden="true"></i>' } },
        glyphicons: {
            icons: { rightIcon: '<span class="glyphicon glyphicon-calendar"></span>', previousMonth: '<span class="glyphicon glyphicon-chevron-left"></span>', nextMonth: '<span class="glyphicon glyphicon-chevron-right"></span>' },
        },
    }),
    (gj.datepicker.methods = {
        init: function (a) {
            return gj.widget.prototype.init.call(this, a, "datepicker"), this.attr("data-datepicker", "true"), gj.datepicker.methods.initialize(this, this.data()), this;
        },
        initialize: function (a, b) {
            var c,
                d,
                e = a.parent('div[role="wrapper"]');
            0 === e.length ? ((e = $('<div role="wrapper" />').addClass(b.style.wrapper)), a.wrap(e)) : e.addClass(b.style.wrapper),
                (e = a.parent('div[role="wrapper"]')),
                b.width && e.css("width", b.width),
                a.val(b.value).addClass(b.style.input).attr("role", "input"),
                b.fontSize && a.css("font-size", b.fontSize),
                "bootstrap" === b.uiLibrary || "bootstrap4" === b.uiLibrary
                    ? "small" === b.size
                        ? (e.addClass("input-group-sm"), a.addClass("form-control-sm"))
                        : "large" === b.size && (e.addClass("input-group-lg"), a.addClass("form-control-lg"))
                    : "small" === b.size
                    ? e.addClass("small")
                    : "large" === b.size && e.addClass("large"),
                b.showRightIcon &&
                    ((d =
                        "bootstrap" === b.uiLibrary
                            ? $('<span class="input-group-addon">' + b.icons.rightIcon + "</span>")
                            : "bootstrap4" === b.uiLibrary
                            ? $('<span class="input-group-append"><button class="btn btn-outline-secondary border-left-0" type="button">' + b.icons.rightIcon + "</button></span>")
                            : $(b.icons.rightIcon)),
                    d.attr("role", "right-icon"),
                    d.on("click", function (c) {
                        $("body")
                            .find('[role="calendar"][guid="' + a.attr("data-guid") + '"]')
                            .is(":visible")
                            ? gj.datepicker.methods.close(a)
                            : gj.datepicker.methods.open(a, b);
                    }),
                    e.append(d)),
                b.showOnFocus &&
                    a.on("focus", function () {
                        gj.datepicker.methods.open(a, b);
                    }),
                (c = gj.datepicker.methods.createCalendar(a, b)),
                !0 !== b.footer &&
                    (a.on("blur", function () {
                        a.timeout = setTimeout(function () {
                            gj.datepicker.methods.close(a);
                        }, 500);
                    }),
                    c.mousedown(function () {
                        return clearTimeout(a.timeout), document.activeElement !== a[0] && a.focus(), !1;
                    }),
                    c.on("click", function () {
                        clearTimeout(a.timeout), document.activeElement !== a[0] && a.focus();
                    })),
                b.keyboardNavigation && $(document).on("keydown", gj.datepicker.methods.createKeyDownHandler(a, c, b));
        },
        createCalendar: function (a, b) {
            var c,
                d,
                e,
                f,
                g,
                h = $('<div role="calendar" type="month"/>').addClass(b.style.calendar).attr("guid", a.attr("data-guid"));
            return (
                b.fontSize && h.css("font-size", b.fontSize),
                (c = gj.core.parseDate(b.value, b.format, b.locale)),
                !c || isNaN(c.getTime()) ? (c = new Date()) : a.attr("day", c.getFullYear() + "-" + c.getMonth() + "-" + c.getDate()),
                h.attr("month", c.getMonth()),
                h.attr("year", c.getFullYear()),
                gj.datepicker.methods.renderHeader(a, h, b, c),
                (d = $('<div role="body" />')),
                h.append(d),
                b.footer &&
                    ((e = $('<div role="footer" class="' + b.style.footer + '" />')),
                    (f = $('<button class="' + b.style.button + '">' + gj.core.messages[b.locale].cancel + "</button>")),
                    f.on("click", function () {
                        a.close();
                    }),
                    e.append(f),
                    (g = $('<button class="' + b.style.button + '">' + gj.core.messages[b.locale].ok + "</button>")),
                    g.on("click", function () {
                        var c,
                            d,
                            e = h.attr("selectedDay");
                        e ? ((d = e.split("-")), (c = new Date(d[0], d[1], d[2], h.attr("hour") || 0, h.attr("minute") || 0)), gj.datepicker.methods.change(a, h, b, c)) : a.close();
                    }),
                    e.append(g),
                    h.append(e)),
                h.hide(),
                $("body").append(h),
                b.modal && (h.wrapAll('<div role="modal" class="' + b.style.modal + '"/>'), gj.core.center(h)),
                h
            );
        },
        renderHeader: function (a, b, c, d) {
            var e, f, g;
            c.header &&
                ((e = $('<div role="header" />')),
                (g = $('<div role="year" />').on("click", function () {
                    gj.datepicker.methods.renderDecade(a, b, c), g.addClass("selected"), f.removeClass("selected");
                })),
                g.html(gj.core.formatDate(d, "yyyy", c.locale)),
                e.append(g),
                (f = $('<div role="date" class="selected" />').on("click", function () {
                    gj.datepicker.methods.renderMonth(a, b, c), f.addClass("selected"), g.removeClass("selected");
                })),
                f.html(gj.core.formatDate(d, "ddd, mmm dd", c.locale)),
                e.append(f),
                b.append(e));
        },
        updateHeader: function (a, b, c) {
            a.find('[role="header"] [role="year"]').removeClass("selected").html(gj.core.formatDate(c, "yyyy", b.locale)),
                a.find('[role="header"] [role="date"]').addClass("selected").html(gj.core.formatDate(c, "ddd, mmm dd", b.locale)),
                a.find('[role="header"] [role="hour"]').removeClass("selected").html(gj.core.formatDate(c, "HH", b.locale)),
                a.find('[role="header"] [role="minute"]').removeClass("selected").html(gj.core.formatDate(c, "MM", b.locale));
        },
        createNavigation: function (a, b, c, d) {
            var e,
                f,
                g = $("<thead/>");
            for (
                f = $('<div role="navigator" />'),
                    f.append($("<div>" + d.icons.previousMonth + "</div>").on("click", gj.datepicker.methods.prev(a, d))),
                    f.append($('<div role="period"></div>').on("click", gj.datepicker.methods.changePeriod(a, d))),
                    f.append($("<div>" + d.icons.nextMonth + "</div>").on("click", gj.datepicker.methods.next(a, d))),
                    b.append(f),
                    e = $('<tr role="week-days" />'),
                    d.calendarWeeks && e.append("<th><div>&nbsp;</div></th>"),
                    i = d.weekStartDay;
                i < gj.core.messages[d.locale].weekDaysMin.length;
                i++
            )
                e.append("<th><div>" + gj.core.messages[d.locale].weekDaysMin[i] + "</div></th>");
            for (i = 0; i < d.weekStartDay; i++) e.append("<th><div>" + gj.core.messages[d.locale].weekDaysMin[i] + "</div></th>");
            g.append(e), c.append(g);
        },
        renderMonth: function (a, b, c) {
            var d,
                e,
                f,
                g,
                h,
                i,
                j,
                k,
                l,
                m,
                n,
                o,
                p,
                q,
                r,
                s = b.children('[role="body"]'),
                t = $("<table/>"),
                u = $("<tbody/>"),
                v = gj.core.messages[c.locale].titleFormat;
            for (
                s.off().empty(),
                    gj.datepicker.methods.createNavigation(a, s, t, c),
                    g = parseInt(b.attr("month"), 10),
                    h = parseInt(b.attr("year"), 10),
                    b.attr("type", "month"),
                    v = v.replace("mmmm", gj.core.messages[c.locale].monthNames[g]).replace("yyyy", h),
                    b.find('div[role="period"]').text(v),
                    i = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31),
                    h % 4 == 0 && 1900 != h && (i[1] = 29),
                    j = i[g],
                    k = (new Date(h, g, 1).getDay() + 7 - c.weekStartDay) % 7,
                    d = 0,
                    $row = $("<tr />"),
                    n = gj.datepicker.methods.getPrevMonth(g, h),
                    l = 1;
                l <= k;
                l++
            )
                (f = i[n.month] - k + l),
                    (r = new Date(n.year, n.month, f)),
                    c.calendarWeeks && 1 === l && $row.append('<td class="calendar-week"><div>' + gj.datepicker.methods.getWeekNumber(r) + "</div></td>"),
                    (p = $('<td class="other-month" />')),
                    c.showOtherMonths &&
                        ((q = $("<div>" + f + "</div>")),
                        p.append(q),
                        c.selectOtherMonths && gj.datepicker.methods.isSelectable(c, r)
                            ? (p.addClass("gj-cursor-pointer").attr("day", f).attr("month", n.month).attr("year", n.year),
                              q.on("click", gj.datepicker.methods.dayClickHandler(a, b, c, r)),
                              q.on("mousedown", function (a) {
                                  a.stopPropagation();
                              }))
                            : p.addClass("disabled")),
                    $row.append(p),
                    d++;
            for (l > 1 && u.append($row), m = new Date(), l = 1; l <= j; l++)
                (r = new Date(h, g, l)),
                    0 == d && (($row = $("<tr>")), c.calendarWeeks && $row.append('<td class="calendar-week"><div>' + gj.datepicker.methods.getWeekNumber(r) + "</div></td>")),
                    (p = $('<td day="' + l + '" month="' + g + '" year="' + h + '" />')),
                    h === m.getFullYear() && g === m.getMonth() && l === m.getDate() ? p.addClass("today") : p.addClass("current-month"),
                    (q = $("<div>" + l + "</div>")),
                    gj.datepicker.methods.isSelectable(c, r)
                        ? (p.addClass("gj-cursor-pointer"),
                          q.on("click", gj.datepicker.methods.dayClickHandler(a, b, c, r)),
                          q.on("mousedown", function (a) {
                              a.stopPropagation();
                          }))
                        : p.addClass("disabled"),
                    p.append(q),
                    $row.append(p),
                    7 == ++d && (u.append($row), (d = 0));
            for (o = gj.datepicker.methods.getNextMonth(g, h), l = 1; 0 != d; l++)
                (r = new Date(o.year, o.month, l)),
                    (p = $('<td class="other-month" />')),
                    c.showOtherMonths &&
                        ((q = $("<div>" + l + "</div>")),
                        c.selectOtherMonths && gj.datepicker.methods.isSelectable(c, r)
                            ? (p.addClass("gj-cursor-pointer").attr("day", l).attr("month", o.month).attr("year", o.year),
                              q.on("click", gj.datepicker.methods.dayClickHandler(a, b, c, r)),
                              q.on("mousedown", function (a) {
                                  a.stopPropagation();
                              }))
                            : p.addClass("disabled"),
                        p.append(q)),
                    $row.append(p),
                    7 == ++d && (u.append($row), (d = 0));
            t.append(u),
                s.append(t),
                b.attr("selectedDay") &&
                    ((e = b.attr("selectedDay").split("-")),
                    (r = new Date(e[0], e[1], e[2], b.attr("hour") || 0, b.attr("minute") || 0)),
                    b.find('tbody td[day="' + e[2] + '"][month="' + e[1] + '"]').addClass("selected"),
                    gj.datepicker.methods.updateHeader(b, c, r));
        },
        renderYear: function (a, b, c) {
            var d,
                e,
                f,
                g,
                h = b.find('>[role="body"]>table'),
                i = h.children("tbody");
            for (h.children("thead").hide(), d = parseInt(b.attr("year"), 10), b.attr("type", "year"), b.find('div[role="period"]').text(d), i.empty(), e = 0; e < 3; e++) {
                for ($row = $("<tr />"), f = 4 * e; f <= 4 * e + 3; f++)
                    (g = $("<div>" + gj.core.messages[c.locale].monthShortNames[f] + "</div>")), g.on("click", gj.datepicker.methods.selectMonth(a, b, c, f)), ($cell = $("<td></td>").append(g)), $row.append($cell);
                i.append($row);
            }
        },
        renderDecade: function (a, b, c) {
            var d,
                e,
                f,
                g,
                h,
                i = b.find('>[role="body"]>table'),
                j = i.children("tbody");
            for (i.children("thead").hide(), d = parseInt(b.attr("year"), 10), e = d - (d % 10), b.attr("type", "decade"), b.find('div[role="period"]').text(e + " - " + (e + 9)), j.empty(), f = e - 1; f <= e + 10; f += 4) {
                for ($row = $("<tr />"), g = f; g <= f + 3; g++) (h = $("<div>" + g + "</div>")), h.on("click", gj.datepicker.methods.selectYear(a, b, c, g)), ($cell = $("<td></td>").append(h)), $row.append($cell);
                j.append($row);
            }
        },
        renderCentury: function (a, b, c) {
            var d,
                e,
                f,
                g,
                h,
                i = b.find('>[role="body"]>table'),
                j = i.children("tbody");
            for (i.children("thead").hide(), d = parseInt(b.attr("year"), 10), e = d - (d % 100), b.attr("type", "century"), b.find('div[role="period"]').text(e + " - " + (e + 99)), j.empty(), f = e - 10; f < e + 100; f += 40) {
                for ($row = $("<tr />"), g = f; g <= f + 30; g += 10) (h = $("<div>" + g + "</div>")), h.on("click", gj.datepicker.methods.selectDecade(a, b, c, g)), ($cell = $("<td></td>").append(h)), $row.append($cell);
                j.append($row);
            }
        },
        getWeekNumber: function (a) {
            var b = new Date(a.valueOf());
            b.setDate(b.getDate() + 6), (b = new Date(Date.UTC(b.getFullYear(), b.getMonth(), b.getDate()))), b.setUTCDate(b.getUTCDate() + 4 - (b.getUTCDay() || 7));
            var c = new Date(Date.UTC(b.getUTCFullYear(), 0, 1));
            return Math.ceil(((b - c) / 864e5 + 1) / 7);
        },
        getMinDate: function (a) {
            var b;
            return (
                a.minDate &&
                    ("string" == typeof a.minDate
                        ? (b = gj.core.parseDate(a.minDate, a.format, a.locale))
                        : "function" == typeof a.minDate
                        ? "string" == typeof (b = a.minDate()) && (b = gj.core.parseDate(b, a.format, a.locale))
                        : "function" == typeof a.minDate.getMonth && (b = a.minDate)),
                b
            );
        },
        getMaxDate: function (a) {
            var b;
            return (
                a.maxDate &&
                    ("string" == typeof a.maxDate
                        ? (b = gj.core.parseDate(a.maxDate, a.format, a.locale))
                        : "function" == typeof a.maxDate
                        ? "string" == typeof (b = a.maxDate()) && (b = gj.core.parseDate(b, a.format, a.locale))
                        : "function" == typeof a.maxDate.getMonth && (b = a.maxDate)),
                b
            );
        },
        isSelectable: function (a, b) {
            var c,
                d = !0,
                e = gj.datepicker.methods.getMinDate(a),
                f = gj.datepicker.methods.getMaxDate(a);
            if ((e && b < e ? (d = !1) : f && b > f && (d = !1), d)) {
                if (a.disableDates)
                    if ($.isArray(a.disableDates))
                        for (c = 0; c < a.disableDates.length; c++)
                            a.disableDates[c] instanceof Date && a.disableDates[c].getTime() === b.getTime()
                                ? (d = !1)
                                : "string" == typeof a.disableDates[c] && gj.core.parseDate(a.disableDates[c], a.format, a.locale).getTime() === b.getTime() && (d = !1);
                    else a.disableDates instanceof Function && (d = a.disableDates(b));
                $.isArray(a.disableDaysOfWeek) && a.disableDaysOfWeek.indexOf(b.getDay()) > -1 && (d = !1);
            }
            return d;
        },
        getPrevMonth: function (a, b) {
            return (date = new Date(b, a, 1)), date.setMonth(date.getMonth() - 1), { month: date.getMonth(), year: date.getFullYear() };
        },
        getNextMonth: function (a, b) {
            return (date = new Date(b, a, 1)), date.setMonth(date.getMonth() + 1), { month: date.getMonth(), year: date.getFullYear() };
        },
        prev: function (a, b) {
            return function () {
                var c,
                    d,
                    e,
                    f,
                    g,
                    h = $("body").find('[role="calendar"][guid="' + a.attr("data-guid") + '"]');
                switch (((e = parseInt(h.attr("year"), 10)), h.attr("type"))) {
                    case "month":
                        (d = parseInt(h.attr("month"), 10)), (c = gj.datepicker.methods.getPrevMonth(d, e)), h.attr("month", c.month), h.attr("year", c.year), gj.datepicker.methods.renderMonth(a, h, b);
                        break;
                    case "year":
                        h.attr("year", e - 1), gj.datepicker.methods.renderYear(a, h, b);
                        break;
                    case "decade":
                        (f = e - (e % 10)), h.attr("year", f - 10), gj.datepicker.methods.renderDecade(a, h, b);
                        break;
                    case "century":
                        (g = e - (e % 100)), h.attr("year", g - 100), gj.datepicker.methods.renderCentury(a, h, b);
                }
            };
        },
        next: function (a, b) {
            return function () {
                var c,
                    d,
                    e,
                    f,
                    g,
                    h = $("body").find('[role="calendar"][guid="' + a.attr("data-guid") + '"]');
                switch (((e = parseInt(h.attr("year"), 10)), h.attr("type"))) {
                    case "month":
                        (d = parseInt(h.attr("month"), 10)), (c = gj.datepicker.methods.getNextMonth(d, e)), h.attr("month", c.month), h.attr("year", c.year), gj.datepicker.methods.renderMonth(a, h, b);
                        break;
                    case "year":
                        h.attr("year", e + 1), gj.datepicker.methods.renderYear(a, h, b);
                        break;
                    case "decade":
                        (f = e - (e % 10)), h.attr("year", f + 10), gj.datepicker.methods.renderDecade(a, h, b);
                        break;
                    case "century":
                        (g = e - (e % 100)), h.attr("year", g + 100), gj.datepicker.methods.renderCentury(a, h, b);
                }
            };
        },
        changePeriod: function (a, b) {
            return function (c) {
                var d = $("body").find('[role="calendar"][guid="' + a.attr("data-guid") + '"]');
                switch (d.attr("type")) {
                    case "month":
                        gj.datepicker.methods.renderYear(a, d, b);
                        break;
                    case "year":
                        gj.datepicker.methods.renderDecade(a, d, b);
                        break;
                    case "decade":
                        gj.datepicker.methods.renderCentury(a, d, b);
                }
            };
        },
        dayClickHandler: function (a, b, c, d) {
            return function (e) {
                return e && e.stopPropagation(), gj.datepicker.methods.selectDay(a, b, c, d), !0 !== c.footer && !1 !== c.autoClose && gj.datepicker.methods.change(a, b, c, d), a;
            };
        },
        change: function (a, b, c, d) {
            var e = (d.getDate(), d.getMonth()),
                f = d.getFullYear(),
                g = gj.core.formatDate(d, c.format, c.locale);
            b.attr("month", e), b.attr("year", f), a.val(g), gj.datepicker.events.change(a), "none" !== window.getComputedStyle(b[0]).display && gj.datepicker.methods.close(a);
        },
        selectDay: function (a, b, c, d) {
            var e = d.getDate(),
                f = d.getMonth(),
                g = d.getFullYear();
            b.attr("selectedDay", g + "-" + f + "-" + e),
                b.find("tbody td").removeClass("selected"),
                b.find('tbody td[day="' + e + '"][month="' + f + '"]').addClass("selected"),
                gj.datepicker.methods.updateHeader(b, c, d),
                gj.datepicker.events.select(a, "day");
        },
        selectMonth: function (a, b, c, d) {
            return function (e) {
                b.attr("month", d), gj.datepicker.methods.renderMonth(a, b, c), gj.datepicker.events.select(a, "month");
            };
        },
        selectYear: function (a, b, c, d) {
            return function (e) {
                b.attr("year", d), gj.datepicker.methods.renderYear(a, b, c), gj.datepicker.events.select(a, "year");
            };
        },
        selectDecade: function (a, b, c, d) {
            return function (e) {
                b.attr("year", d), gj.datepicker.methods.renderDecade(a, b, c), gj.datepicker.events.select(a, "decade");
            };
        },
        open: function (a, b) {
            var c,
                d = $("body").find('[role="calendar"][guid="' + a.attr("data-guid") + '"]');
            switch ((a.val() ? a.value(a.val()) : ((c = new Date()), d.attr("month", c.getMonth()), d.attr("year", c.getFullYear())), d.attr("type"))) {
                case "month":
                    gj.datepicker.methods.renderMonth(a, d, b);
                    break;
                case "year":
                    gj.datepicker.methods.renderYear(a, d, b);
                    break;
                case "decade":
                    gj.datepicker.methods.renderDecade(a, d, b);
                    break;
                case "century":
                    gj.datepicker.methods.renderCentury(a, d, b);
            }
            d.show(), d.closest('div[role="modal"]').show(), b.modal ? gj.core.center(d) : (gj.core.setChildPosition(a[0], d[0]), document.activeElement !== a[0] && a.focus()), clearTimeout(a.timeout), gj.datepicker.events.open(a);
        },
        close: function (a) {
            var b = $("body").find('[role="calendar"][guid="' + a.attr("data-guid") + '"]');
            b.hide(), b.closest('div[role="modal"]').hide(), gj.datepicker.events.close(a);
        },
        createKeyDownHandler: function (a, b, c) {
            return function (d) {
                var e,
                    f,
                    g,
                    h,
                    i,
                    j,
                    d = d || window.event;
                "none" !== window.getComputedStyle(b[0]).display &&
                    ((j = gj.datepicker.methods.getActiveCell(b)),
                    "38" == d.keyCode
                        ? ((h = j.index()),
                          (i = j
                              .closest("tr")
                              .prev("tr")
                              .find("td:eq(" + h + ")")),
                          i.is("[day]") ||
                              (gj.datepicker.methods.prev(a, c)(),
                              (i = b
                                  .find("tbody tr")
                                  .last()
                                  .find("td:eq(" + h + ")")),
                              i.is(":empty") &&
                                  (i = b
                                      .find("tbody tr")
                                      .last()
                                      .prev()
                                      .find("td:eq(" + h + ")"))),
                          i.is("[day]") && (i.addClass("focused"), j.removeClass("focused")))
                        : "40" == d.keyCode
                        ? ((h = j.index()),
                          (i = j
                              .closest("tr")
                              .next("tr")
                              .find("td:eq(" + h + ")")),
                          i.is("[day]") ||
                              (gj.datepicker.methods.next(a, c)(),
                              (i = b
                                  .find("tbody tr")
                                  .first()
                                  .find("td:eq(" + h + ")")),
                              i.is("[day]") || (i = b.find("tbody tr:eq(1)").find("td:eq(" + h + ")"))),
                          i.is("[day]") && (i.addClass("focused"), j.removeClass("focused")))
                        : "37" == d.keyCode
                        ? ((i = j.prev("td[day]:not(.disabled)")),
                          0 === i.length && (i = j.closest("tr").prev("tr").find("td[day]").last()),
                          0 === i.length && (gj.datepicker.methods.prev(a, c)(), (i = b.find("tbody tr").last().find("td[day]").last())),
                          i.length > 0 && (i.addClass("focused"), j.removeClass("focused")))
                        : "39" == d.keyCode
                        ? ((i = j.next("[day]:not(.disabled)")),
                          0 === i.length && (i = j.closest("tr").next("tr").find("td[day]").first()),
                          0 === i.length && (gj.datepicker.methods.next(a, c)(), (i = b.find("tbody tr").first().find("td[day]").first())),
                          i.length > 0 && (i.addClass("focused"), j.removeClass("focused")))
                        : "13" == d.keyCode
                        ? ((g = parseInt(j.attr("day"), 10)), (e = parseInt(j.attr("month"), 10)), (f = parseInt(j.attr("year"), 10)), gj.datepicker.methods.dayClickHandler(a, b, c, new Date(f, e, g))())
                        : "27" == d.keyCode && a.close());
            };
        },
        getActiveCell: function (a) {
            var b = a.find("td[day].focused");
            return 0 === b.length && ((b = a.find("td[day].selected")), 0 === b.length && ((b = a.find("td[day].today")), 0 === b.length && (b = a.find("td[day]:not(.disabled)").first()))), b;
        },
        value: function (a, b) {
            var c,
                d,
                e = a.data();
            return void 0 === b
                ? a.val()
                : ((d = gj.core.parseDate(b, e.format, e.locale)), d && d.getTime() ? ((c = $("body").find('[role="calendar"][guid="' + a.attr("data-guid") + '"]')), gj.datepicker.methods.dayClickHandler(a, c, e, d)()) : a.val(""), a);
        },
        destroy: function (a) {
            var b = a.data(),
                c = a.parent(),
                d = $("body").find('[role="calendar"][guid="' + a.attr("data-guid") + '"]');
            return (
                b &&
                    (a.off(),
                    d.parent('[role="modal"]').length > 0 && d.unwrap(),
                    d.remove(),
                    a.removeData(),
                    a.removeAttr("data-type").removeAttr("data-guid").removeAttr("data-datepicker"),
                    a.removeClass(),
                    c.children('[role="right-icon"]').remove(),
                    a.unwrap()),
                a
            );
        },
    }),
    (gj.datepicker.events = {
        change: function (a) {
            return a.triggerHandler("change");
        },
        select: function (a, b) {
            return a.triggerHandler("select", [b]);
        },
        open: function (a) {
            return a.triggerHandler("open");
        },
        close: function (a) {
            return a.triggerHandler("close");
        },
    }),
    (gj.datepicker.widget = function (a, b) {
        var c = this,
            d = gj.datepicker.methods;
        return (
            (c.value = function (a) {
                return d.value(this, a);
            }),
            (c.destroy = function () {
                return d.destroy(this);
            }),
            (c.open = function () {
                return d.open(this, this.data());
            }),
            (c.close = function () {
                return d.close(this);
            }),
            $.extend(a, c),
            "true" !== a.attr("data-datepicker") && d.init.call(a, b),
            a
        );
    }),
    (gj.datepicker.widget.prototype = new gj.widget()),
    (gj.datepicker.widget.constructor = gj.datepicker.widget),
    (function (a) {
        a.fn.datepicker = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.datepicker.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.datepicker.widget(this, a);
            }
        };
    })(jQuery),
    (gj.timepicker = { plugins: {} }),
    (gj.timepicker.config = {
        base: {
            width: void 0,
            modal: !0,
            header: !0,
            footer: !0,
            format: "HH:MM",
            uiLibrary: "materialdesign",
            value: void 0,
            mode: "ampm",
            locale: "en-us",
            size: "default",
            icons: { rightIcon: '<i class="gj-icon clock" />' },
            style: { modal: "gj-modal", wrapper: "gj-timepicker gj-timepicker-md gj-unselectable", input: "gj-textbox-md", clock: "gj-picker gj-picker-md timepicker", footer: "", button: "gj-button-md" },
        },
        bootstrap: {
            style: { wrapper: "gj-timepicker gj-timepicker-bootstrap gj-unselectable input-group", input: "form-control", clock: "gj-picker gj-picker-bootstrap timepicker", footer: "modal-footer", button: "btn btn-default" },
            iconsLibrary: "glyphicons",
        },
        bootstrap4: {
            style: { wrapper: "gj-timepicker gj-timepicker-bootstrap gj-unselectable input-group", input: "form-control border", clock: "gj-picker gj-picker-bootstrap timepicker", footer: "modal-footer", button: "btn btn-default" },
        },
    }),
    (gj.timepicker.methods = {
        init: function (a) {
            return gj.picker.widget.prototype.init.call(this, a, "timepicker"), this;
        },
        initialize: function () {},
        initMouse: function (a, b, c, d) {
            a.off(), a.on("mousedown", gj.timepicker.methods.mouseDownHandler(b, c)), a.on("mousemove", gj.timepicker.methods.mouseMoveHandler(b, c, d)), a.on("mouseup", gj.timepicker.methods.mouseUpHandler(b, c, d));
        },
        createPicker: function (a) {
            var b,
                c = a.data(),
                d = $('<div role="picker" />').addClass(c.style.clock).attr("guid", a.attr("data-guid")),
                e = $('<div role="hour" />'),
                f = $('<div role="minute" />'),
                g = $('<div role="header" />'),
                h = $('<div role="mode" />'),
                i = $('<div role="body" />'),
                j = $('<button class="' + c.style.button + '">' + gj.core.messages[c.locale].ok + "</button>"),
                k = $('<button class="' + c.style.button + '">' + gj.core.messages[c.locale].cancel + "</button>"),
                l = $('<div role="footer" class="' + c.style.footer + '" />');
            return (
                (b = gj.core.parseDate(c.value, c.format, c.locale)),
                !b || isNaN(b.getTime()) ? (b = new Date()) : a.attr("hours", b.getHours()),
                gj.timepicker.methods.initMouse(i, a, d, c),
                c.header &&
                    (e.on("click", function () {
                        gj.timepicker.methods.renderHours(a, d, c);
                    }),
                    f.on("click", function () {
                        gj.timepicker.methods.renderMinutes(a, d, c);
                    }),
                    g.append(e).append(":").append(f),
                    "ampm" === c.mode &&
                        (h.append(
                            $('<span role="am">' + gj.core.messages[c.locale].am + "</span>").on("click", function () {
                                var b = gj.timepicker.methods.getHour(d);
                                d.attr("mode", "am"), $(this).addClass("selected"), $(this).parent().children('[role="pm"]').removeClass("selected"), b >= 12 && d.attr("hour", b - 12), c.modal || (clearTimeout(a.timeout), a.focus());
                            })
                        ),
                        h.append("<br />"),
                        h.append(
                            $('<span role="pm">' + gj.core.messages[c.locale].pm + "</span>").on("click", function () {
                                var b = gj.timepicker.methods.getHour(d);
                                d.attr("mode", "pm"), $(this).addClass("selected"), $(this).parent().children('[role="am"]').removeClass("selected"), b < 12 && d.attr("hour", b + 12), c.modal || (clearTimeout(a.timeout), a.focus());
                            })
                        ),
                        g.append(h)),
                    d.append(g)),
                d.append(i),
                c.footer &&
                    (k.on("click", function () {
                        a.close();
                    }),
                    l.append(k),
                    j.on("click", gj.timepicker.methods.setTime(a, d)),
                    l.append(j),
                    d.append(l)),
                d.hide(),
                $("body").append(d),
                c.modal && (d.wrapAll('<div role="modal" class="' + c.style.modal + '"/>'), gj.core.center(d)),
                d
            );
        },
        getHour: function (a) {
            return parseInt(a.attr("hour"), 10) || 0;
        },
        getMinute: function (a) {
            return parseInt(a.attr("minute"), 10) || 0;
        },
        setTime: function (a, b) {
            return function () {
                var c = gj.timepicker.methods.getHour(b),
                    d = gj.timepicker.methods.getMinute(b),
                    e = b.attr("mode"),
                    f = new Date(0, 0, 0, 12 === c && "am" === e ? 0 : c, d),
                    g = a.data(),
                    h = gj.core.formatDate(f, g.format, g.locale);
                a.value(h), a.close();
            };
        },
        getPointerValue: function (a, b, c) {
            var d,
                e,
                f = 256,
                g = (Math.atan2(f / 2 - a, f / 2 - b) / Math.PI) * 180;
            switch ((g < 0 && (g = 360 + g), c)) {
                case "ampm":
                    return (d = 12 - Math.round((12 * g) / 360)), 0 === d ? 12 : d;
                case "24hr":
                    return (e = Math.sqrt(Math.pow(f / 2 - a, 2) + Math.pow(f / 2 - b, 2))), (d = 12 - Math.round((12 * g) / 360)), 0 === d && (d = 12), e < f / 2 - 32 && (d = 12 === d ? 0 : d + 12), d;
                case "minutes":
                    return (d = Math.round(60 - (60 * g) / 360)), 60 === d ? 0 : d;
            }
        },
        updateArrow: function (a, b, c, d) {
            var e,
                f,
                g = b.mouseX(a),
                h = b.mouseY(a),
                i = window.scrollY || window.pageYOffset || 0,
                j = window.scrollX || window.pageXOffset || 0;
            (e = a.target.getBoundingClientRect()),
                "hours" == d.dialMode
                    ? ((f = gj.timepicker.methods.getPointerValue(g - j - e.left, h - i - e.top, d.mode)), c.attr("hour", "ampm" === d.mode && "pm" === c.attr("mode") && f < 12 ? f + 12 : f))
                    : "minutes" == d.dialMode && ((f = gj.timepicker.methods.getPointerValue(g - j - e.left, h - i - e.top, "minutes")), c.attr("minute", f)),
                gj.timepicker.methods.update(b, c, d);
        },
        update: function (a, b, c) {
            var d, e, f, g, h, i;
            (d = gj.timepicker.methods.getHour(b)),
                (e = gj.timepicker.methods.getMinute(b)),
                (f = b.find('[role="arrow"]')),
                "hours" == c.dialMode && (0 == d || d > 12) && "24hr" === c.mode ? f.css("width", "calc(50% - 52px)") : f.css("width", "calc(50% - 20px)"),
                "hours" == c.dialMode ? f.css("transform", "rotate(" + (30 * d - 90).toString() + "deg)") : f.css("transform", "rotate(" + (6 * e - 90).toString() + "deg)"),
                f.show(),
                (g = "ampm" === c.mode && d > 12 ? d - 12 : 0 == d ? 12 : d),
                (i = b.find('[role="body"] span')),
                i.removeClass("selected"),
                i
                    .filter(function (a) {
                        return "hours" == c.dialMode ? parseInt($(this).text(), 10) == g : parseInt($(this).text(), 10) == e;
                    })
                    .addClass("selected"),
                c.header &&
                    ((h = b.find('[role="header"]')),
                    h.find('[role="hour"]').text(g),
                    h.find('[role="minute"]').text(gj.core.pad(e)),
                    "ampm" === c.mode && (d >= 12 ? (h.find('[role="pm"]').addClass("selected"), h.find('[role="am"]').removeClass("selected")) : (h.find('[role="am"]').addClass("selected"), h.find('[role="pm"]').removeClass("selected"))));
        },
        mouseDownHandler: function (a, b) {
            return function (b) {
                a.mouseMove = !0;
            };
        },
        mouseMoveHandler: function (a, b, c) {
            return function (d) {
                a.mouseMove && gj.timepicker.methods.updateArrow(d, a, b, c);
            };
        },
        mouseUpHandler: function (a, b, c) {
            return function (d) {
                gj.timepicker.methods.updateArrow(d, a, b, c),
                    (a.mouseMove = !1),
                    c.modal || (clearTimeout(a.timeout), a.focus()),
                    "hours" == c.dialMode
                        ? setTimeout(function () {
                              gj.timepicker.events.select(a, "hour"), gj.timepicker.methods.renderMinutes(a, b, c);
                          }, 1e3)
                        : "minutes" == c.dialMode && (!0 !== c.footer && !1 !== c.autoClose && gj.timepicker.methods.setTime(a, b)(), gj.timepicker.events.select(a, "minute"));
            };
        },
        renderHours: function (a, b, c) {
            var d,
                e = b.find('[role="body"]');
            clearTimeout(a.timeout),
                e.empty(),
                (d = $('<div role="dial"></div>')),
                d.append('<div role="arrow" style="transform: rotate(-90deg); display: none;"><div class="arrow-begin"></div><div class="arrow-end"></div></div>'),
                d.append('<span role="hour" style="transform: translate(54px, -93.5307px);">1</span>'),
                d.append('<span role="hour" style="transform: translate(93.5307px, -54px);">2</span>'),
                d.append('<span role="hour" style="transform: translate(108px, 0px);">3</span>'),
                d.append('<span role="hour" style="transform: translate(93.5307px, 54px);">4</span>'),
                d.append('<span role="hour" style="transform: translate(54px, 93.5307px);">5</span>'),
                d.append('<span role="hour" style="transform: translate(6.61309e-15px, 108px);">6</span>'),
                d.append('<span role="hour" style="transform: translate(-54px, 93.5307px);">7</span>'),
                d.append('<span role="hour" style="transform: translate(-93.5307px, 54px);">8</span>'),
                d.append('<span role="hour" style="transform: translate(-108px, 1.32262e-14px);">9</span>'),
                d.append('<span role="hour" style="transform: translate(-93.5307px, -54px);">10</span>'),
                d.append('<span role="hour" style="transform: translate(-54px, -93.5307px);">11</span>'),
                d.append('<span role="hour" style="transform: translate(-1.98393e-14px, -108px);">12</span>'),
                "24hr" === c.mode &&
                    (d.append('<span role="hour" style="transform: translate(38px, -65.8179px);">13</span>'),
                    d.append('<span role="hour" style="transform: translate(65.8179px, -38px);">14</span>'),
                    d.append('<span role="hour" style="transform: translate(76px, 0px);">15</span>'),
                    d.append('<span role="hour" style="transform: translate(65.8179px, 38px);">16</span>'),
                    d.append('<span role="hour" style="transform: translate(38px, 65.8179px);">17</span>'),
                    d.append('<span role="hour" style="transform: translate(4.65366e-15px, 76px);">18</span>'),
                    d.append('<span role="hour" style="transform: translate(-38px, 65.8179px);">19</span>'),
                    d.append('<span role="hour" style="transform: translate(-65.8179px, 38px);">20</span>'),
                    d.append('<span role="hour" style="transform: translate(-76px, 9.30732e-15px);">21</span>'),
                    d.append('<span role="hour" style="transform: translate(-65.8179px, -38px);">22</span>'),
                    d.append('<span role="hour" style="transform: translate(-38px, -65.8179px);">23</span>'),
                    d.append('<span role="hour" style="transform: translate(-1.3961e-14px, -76px);">00</span>')),
                e.append(d),
                b.find('[role="header"] [role="hour"]').addClass("selected"),
                b.find('[role="header"] [role="minute"]').removeClass("selected"),
                (c.dialMode = "hours"),
                gj.timepicker.methods.update(a, b, c);
        },
        renderMinutes: function (a, b, c) {
            var d = b.find('[role="body"]');
            clearTimeout(a.timeout),
                d.empty(),
                ($dial = $('<div role="dial"></div>')),
                $dial.append('<div role="arrow" style="transform: rotate(-90deg); display: none;"><div class="arrow-begin"></div><div class="arrow-end"></div></div>'),
                $dial.append('<span role="hour" style="transform: translate(54px, -93.5307px);">5</span>'),
                $dial.append('<span role="hour" style="transform: translate(93.5307px, -54px);">10</span>'),
                $dial.append('<span role="hour" style="transform: translate(108px, 0px);">15</span>'),
                $dial.append('<span role="hour" style="transform: translate(93.5307px, 54px);">20</span>'),
                $dial.append('<span role="hour" style="transform: translate(54px, 93.5307px);">25</span>'),
                $dial.append('<span role="hour" style="transform: translate(6.61309e-15px, 108px);">30</span>'),
                $dial.append('<span role="hour" style="transform: translate(-54px, 93.5307px);">35</span>'),
                $dial.append('<span role="hour" style="transform: translate(-93.5307px, 54px);">40</span>'),
                $dial.append('<span role="hour" style="transform: translate(-108px, 1.32262e-14px);">45</span>'),
                $dial.append('<span role="hour" style="transform: translate(-93.5307px, -54px);">50</span>'),
                $dial.append('<span role="hour" style="transform: translate(-54px, -93.5307px);">55</span>'),
                $dial.append('<span role="hour" style="transform: translate(-1.98393e-14px, -108px);">00</span>'),
                d.append($dial),
                b.find('[role="header"] [role="hour"]').removeClass("selected"),
                b.find('[role="header"] [role="minute"]').addClass("selected"),
                (c.dialMode = "minutes"),
                gj.timepicker.methods.update(a, b, c);
        },
        open: function (a) {
            var b,
                c,
                d = a.data(),
                e = $("body").find('[role="picker"][guid="' + a.attr("data-guid") + '"]');
            return (
                (b = a.value() ? gj.core.parseDate(a.value(), d.format, d.locale) : new Date()),
                (c = b.getHours()),
                "ampm" === d.mode && e.attr("mode", c > 12 ? "pm" : "am"),
                e.attr("hour", c),
                e.attr("minute", b.getMinutes()),
                gj.timepicker.methods.renderHours(a, e, d),
                gj.picker.widget.prototype.open.call(a, "timepicker"),
                a
            );
        },
        value: function (a, b) {
            a.data();
            return void 0 === b ? a.val() : (a.val(b), gj.timepicker.events.change(a), a);
        },
    }),
    (gj.timepicker.events = {
        change: function (a) {
            return a.triggerHandler("change");
        },
        select: function (a, b) {
            return a.triggerHandler("select", [b]);
        },
        open: function (a) {
            return a.triggerHandler("open");
        },
        close: function (a) {
            return a.triggerHandler("close");
        },
    }),
    (gj.timepicker.widget = function (a, b) {
        var c = this,
            d = gj.timepicker.methods;
        return (
            (c.mouseMove = !1),
            (c.value = function (a) {
                return d.value(this, a);
            }),
            (c.destroy = function () {
                return gj.picker.widget.prototype.destroy.call(this, "timepicker");
            }),
            (c.open = function () {
                return gj.timepicker.methods.open(this);
            }),
            (c.close = function () {
                return gj.picker.widget.prototype.close.call(this, "timepicker");
            }),
            $.extend(a, c),
            "true" !== a.attr("data-timepicker") && d.init.call(a, b),
            a
        );
    }),
    (gj.timepicker.widget.prototype = new gj.picker.widget()),
    (gj.timepicker.widget.constructor = gj.timepicker.widget),
    (function (a) {
        a.fn.timepicker = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.timepicker.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.timepicker.widget(this, a);
            }
        };
    })(jQuery),
    (gj.datetimepicker = { plugins: {}, messages: { "en-us": {} } }),
    (gj.datetimepicker.config = {
        base: {
            datepicker: gj.datepicker.config.base,
            timepicker: gj.timepicker.config.base,
            uiLibrary: "materialdesign",
            value: void 0,
            format: "HH:MM mm/dd/yyyy",
            width: void 0,
            modal: !1,
            footer: !1,
            size: "default",
            locale: "en-us",
            icons: {},
            style: { calendar: "gj-picker gj-picker-md datetimepicker gj-unselectable" },
        },
        bootstrap: { style: { calendar: "gj-picker gj-picker-bootstrap datetimepicker gj-unselectable" }, iconsLibrary: "glyphicons" },
        bootstrap4: { style: { calendar: "gj-picker gj-picker-bootstrap datetimepicker gj-unselectable" } },
    }),
    (gj.datetimepicker.methods = {
        init: function (a) {
            return gj.widget.prototype.init.call(this, a, "datetimepicker"), this.attr("data-datetimepicker", "true"), gj.datetimepicker.methods.initialize(this), this;
        },
        getConfig: function (a, b) {
            var c = gj.widget.prototype.getConfig.call(this, a, b);
            return (
                (uiLibrary = a.hasOwnProperty("uiLibrary") ? a.uiLibrary : c.uiLibrary),
                gj.datepicker.config[uiLibrary] && $.extend(!0, c.datepicker, gj.datepicker.config[uiLibrary]),
                gj.timepicker.config[uiLibrary] && $.extend(!0, c.timepicker, gj.timepicker.config[uiLibrary]),
                (iconsLibrary = a.hasOwnProperty("iconsLibrary") ? a.iconsLibrary : c.iconsLibrary),
                gj.datepicker.config[iconsLibrary] && $.extend(!0, c.datepicker, gj.datepicker.config[iconsLibrary]),
                gj.timepicker.config[iconsLibrary] && $.extend(!0, c.timepicker, gj.timepicker.config[iconsLibrary]),
                c
            );
        },
        initialize: function (a) {
            var b,
                c,
                d,
                e,
                f,
                g,
                h,
                i,
                j = a.data();
            (j.datepicker.uiLibrary = j.uiLibrary),
                (j.datepicker.iconsLibrary = j.iconsLibrary),
                (j.datepicker.width = j.width),
                (j.datepicker.format = j.format),
                (j.datepicker.locale = j.locale),
                (j.datepicker.modal = j.modal),
                (j.datepicker.footer = j.footer),
                (j.datepicker.style.calendar = j.style.calendar),
                (j.datepicker.value = j.value),
                (j.datepicker.size = j.size),
                (j.datepicker.autoClose = !1),
                gj.datepicker.methods.initialize(a, j.datepicker),
                a.on("select", function (c, d) {
                    var e, f;
                    "day" === d
                        ? gj.datetimepicker.methods.createShowHourHandler(a, b, j)()
                        : "minute" === d &&
                          b.attr("selectedDay") &&
                          !0 !== j.footer &&
                          ((selectedDay = b.attr("selectedDay").split("-")),
                          (e = new Date(selectedDay[0], selectedDay[1], selectedDay[2], b.attr("hour") || 0, b.attr("minute") || 0)),
                          (f = gj.core.formatDate(e, j.format, j.locale)),
                          a.val(f),
                          gj.datetimepicker.events.change(a),
                          gj.datetimepicker.methods.close(a));
                }),
                a.on("open", function () {
                    var a = b.children('[role="header"]');
                    a.find('[role="calendarMode"]').addClass("selected"), a.find('[role="clockMode"]').removeClass("selected");
                }),
                (b = $("body").find('[role="calendar"][guid="' + a.attr("data-guid") + '"]')),
                (f = j.value ? gj.core.parseDate(j.value, j.format, j.locale) : new Date()),
                b.attr("hour", f.getHours()),
                b.attr("minute", f.getMinutes()),
                (j.timepicker.uiLibrary = j.uiLibrary),
                (j.timepicker.iconsLibrary = j.iconsLibrary),
                (j.timepicker.format = j.format),
                (j.timepicker.locale = j.locale),
                (j.timepicker.header = !0),
                (j.timepicker.footer = j.footer),
                (j.timepicker.size = j.size),
                (j.timepicker.mode = "24hr"),
                (j.timepicker.autoClose = !1),
                (c = $('<div role="header" />')),
                (d = $('<div role="date" class="selected" />')),
                d.on("click", gj.datetimepicker.methods.createShowDateHandler(a, b, j)),
                d.html(gj.core.formatDate(new Date(), "ddd, mmm dd", j.locale)),
                c.append(d),
                (g = $('<div role="switch"></div>')),
                (h = $('<i class="gj-icon selected" role="calendarMode">event</i>')),
                h.on("click", gj.datetimepicker.methods.createShowDateHandler(a, b, j)),
                g.append(h),
                (e = $('<div role="time" />')),
                e.append($('<div role="hour" />').on("click", gj.datetimepicker.methods.createShowHourHandler(a, b, j)).html(gj.core.formatDate(new Date(), "HH", j.locale))),
                e.append(":"),
                e.append($('<div role="minute" />').on("click", gj.datetimepicker.methods.createShowMinuteHandler(a, b, j)).html(gj.core.formatDate(new Date(), "MM", j.locale))),
                g.append(e),
                (i = $('<i class="gj-icon" role="clockMode">clock</i>')),
                i.on("click", gj.datetimepicker.methods.createShowHourHandler(a, b, j)),
                g.append(i),
                c.append(g),
                b.prepend(c);
        },
        createShowDateHandler: function (a, b, c) {
            return function (d) {
                var e = b.children('[role="header"]');
                e.find('[role="calendarMode"]').addClass("selected"),
                    e.find('[role="date"]').addClass("selected"),
                    e.find('[role="clockMode"]').removeClass("selected"),
                    e.find('[role="hour"]').removeClass("selected"),
                    e.find('[role="minute"]').removeClass("selected"),
                    gj.datepicker.methods.renderMonth(a, b, c.datepicker);
            };
        },
        createShowHourHandler: function (a, b, c) {
            return function () {
                var d = b.children('[role="header"]');
                d.find('[role="calendarMode"]').removeClass("selected"),
                    d.find('[role="date"]').removeClass("selected"),
                    d.find('[role="clockMode"]').addClass("selected"),
                    d.find('[role="hour"]').addClass("selected"),
                    d.find('[role="minute"]').removeClass("selected"),
                    gj.timepicker.methods.initMouse(b.children('[role="body"]'), a, b, c.timepicker),
                    gj.timepicker.methods.renderHours(a, b, c.timepicker);
            };
        },
        createShowMinuteHandler: function (a, b, c) {
            return function () {
                var d = b.children('[role="header"]');
                d.find('[role="calendarMode"]').removeClass("selected"),
                    d.find('[role="date"]').removeClass("selected"),
                    d.find('[role="clockMode"]').addClass("selected"),
                    d.find('[role="hour"]').removeClass("selected"),
                    d.find('[role="minute"]').addClass("selected"),
                    gj.timepicker.methods.initMouse(b.children('[role="body"]'), a, b, c.timepicker),
                    gj.timepicker.methods.renderMinutes(a, b, c.timepicker);
            };
        },
        close: function (a) {
            var b = $("body").find('[role="calendar"][guid="' + a.attr("data-guid") + '"]');
            b.hide(), b.closest('div[role="modal"]').hide();
        },
        value: function (a, b) {
            var c,
                d,
                e,
                f = a.data();
            return void 0 === b
                ? a.val()
                : ((d = gj.core.parseDate(b, f.format, f.locale)),
                  d
                      ? ((c = $("body").find('[role="calendar"][guid="' + a.attr("data-guid") + '"]')),
                        gj.datepicker.methods.dayClickHandler(a, c, f, d)(),
                        (e = d.getHours()),
                        "ampm" === f.mode && c.attr("mode", e > 12 ? "pm" : "am"),
                        c.attr("hour", e),
                        c.attr("minute", d.getMinutes()),
                        a.val(b))
                      : a.val(""),
                  a);
        },
        destroy: function (a) {
            var b = a.data(),
                c = a.parent(),
                d = $("body").find('[role="calendar"][guid="' + a.attr("data-guid") + '"]');
            return (
                b &&
                    (a.off(),
                    d.parent('[role="modal"]').length > 0 && d.unwrap(),
                    d.remove(),
                    a.removeData(),
                    a.removeAttr("data-type").removeAttr("data-guid").removeAttr("data-datetimepicker"),
                    a.removeClass(),
                    c.children('[role="right-icon"]').remove(),
                    a.unwrap()),
                a
            );
        },
    }),
    (gj.datetimepicker.events = {
        change: function (a) {
            return a.triggerHandler("change");
        },
    }),
    (gj.datetimepicker.widget = function (a, b) {
        var c = this,
            d = gj.datetimepicker.methods;
        return (
            (c.mouseMove = !1),
            (c.value = function (a) {
                return d.value(this, a);
            }),
            (c.open = function () {
                gj.datepicker.methods.open(this, this.data().datepicker);
            }),
            (c.close = function () {
                gj.datepicker.methods.close(this);
            }),
            (c.destroy = function () {
                return d.destroy(this);
            }),
            $.extend(a, c),
            "true" !== a.attr("data-datetimepicker") && d.init.call(a, b),
            a
        );
    }),
    (gj.datetimepicker.widget.prototype = new gj.widget()),
    (gj.datetimepicker.widget.constructor = gj.datetimepicker.widget),
    (gj.datetimepicker.widget.prototype.getConfig = gj.datetimepicker.methods.getConfig),
    (function (a) {
        a.fn.datetimepicker = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.datetimepicker.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.datetimepicker.widget(this, a);
            }
        };
    })(jQuery),
    (gj.slider = { plugins: {}, messages: { "en-us": {} } }),
    (gj.slider.config = {
        base: { min: 0, max: 100, width: void 0, uiLibrary: "materialdesign", value: void 0, icons: {}, style: { wrapper: "gj-slider gj-slider-md", progress: void 0, track: void 0 } },
        bootstrap: { style: { wrapper: "gj-slider gj-slider-bootstrap gj-slider-bootstrap-3", progress: "progress-bar", track: "progress" } },
        bootstrap4: { style: { wrapper: "gj-slider gj-slider-bootstrap gj-slider-bootstrap-4", progress: "progress-bar", track: "progress" } },
    }),
    (gj.slider.methods = {
        init: function (a) {
            return gj.widget.prototype.init.call(this, a, "slider"), this.attr("data-slider", "true"), gj.slider.methods.initialize(this, this.data()), this;
        },
        initialize: function (a, b) {
            var c, d, e, f;
            (a[0].style.display = "none"),
                "wrapper" !== a[0].parentElement.attributes.role ? ((c = document.createElement("div")), c.setAttribute("role", "wrapper"), a[0].parentNode.insertBefore(c, a[0]), c.appendChild(a[0])) : (c = a[0].parentElement),
                b.width && (c.style.width = b.width + "px"),
                gj.core.addClasses(c, b.style.wrapper),
                (d = a[0].querySelector('[role="track"]')),
                null == d && ((d = document.createElement("div")), d.setAttribute("role", "track"), c.appendChild(d)),
                gj.core.addClasses(d, b.style.track),
                (e = a[0].querySelector('[role="handle"]')),
                null == e && ((e = document.createElement("div")), e.setAttribute("role", "handle"), c.appendChild(e)),
                (f = a[0].querySelector('[role="progress"]')),
                null == f && ((f = document.createElement("div")), f.setAttribute("role", "progress"), c.appendChild(f)),
                gj.core.addClasses(f, b.style.progress),
                b.value || (b.value = b.min),
                gj.slider.methods.value(a, b, b.value),
                gj.documentManager.subscribeForEvent("mouseup", a.data("guid"), gj.slider.methods.createMouseUpHandler(a, e, b)),
                e.addEventListener("mousedown", gj.slider.methods.createMouseDownHandler(e, b)),
                gj.documentManager.subscribeForEvent("mousemove", a.data("guid"), gj.slider.methods.createMouseMoveHandler(a, d, e, f, b)),
                e.addEventListener("click", function (a) {
                    a.stopPropagation();
                }),
                c.addEventListener("click", gj.slider.methods.createClickHandler(a, d, e, b));
        },
        createClickHandler: function (a, b, c, d) {
            return function (e) {
                var f, g, h, i, j;
                "true" !== c.getAttribute("drag") &&
                    ((f = gj.core.position(a[0].parentElement)),
                    (g = new gj.widget().mouseX(e) - f.left),
                    (h = gj.core.width(c) / 2),
                    (i = gj.core.width(b) / (d.max - d.min)),
                    (j = Math.round((g - h) / i) + d.min),
                    gj.slider.methods.value(a, d, j));
            };
        },
        createMouseUpHandler: function (a, b, c) {
            return function (c) {
                "true" === b.getAttribute("drag") && (b.setAttribute("drag", "false"), gj.slider.events.change(a));
            };
        },
        createMouseDownHandler: function (a, b) {
            return function (b) {
                a.setAttribute("drag", "true");
            };
        },
        createMouseMoveHandler: function (a, b, c, d, e) {
            return function (d) {
                var f, g, h, i, j, k, l;
                "true" === c.getAttribute("drag") &&
                    ((f = gj.core.position(a[0].parentElement)),
                    (g = new gj.widget().mouseX(d) - f.left),
                    (h = gj.core.width(b)),
                    (i = gj.core.width(c) / 2),
                    (j = h / (e.max - e.min)),
                    (k = (e.value - e.min) * j),
                    g >= i && g <= h + i && (g > k + j / 2 || g < k - j / 2) && ((l = Math.round((g - i) / j) + e.min), gj.slider.methods.value(a, e, l)));
            };
        },
        value: function (a, b, c) {
            var d, e, f, g;
            return void 0 === c
                ? a[0].value
                : (a[0].setAttribute("value", c),
                  (b.value = c),
                  (e = a.parent().children('[role="track"]')[0]),
                  (d = gj.core.width(e) / (b.max - b.min)),
                  (f = a.parent().children('[role="handle"]')[0]),
                  (f.style.left = (c - b.min) * d + "px"),
                  (g = a.parent().children('[role="progress"]')[0]),
                  (g.style.width = (c - b.min) * d + "px"),
                  gj.slider.events.slide(a, c),
                  a);
        },
        destroy: function (a) {
            var b = a.data(),
                c = a.parent();
            return (
                b &&
                    (c.children('[role="track"]').remove(),
                    c.children('[role="handle"]').remove(),
                    c.children('[role="progress"]').remove(),
                    a.unwrap(),
                    a.off(),
                    a.removeData(),
                    a.removeAttr("data-type").removeAttr("data-guid").removeAttr("data-slider"),
                    a.removeClass(),
                    a.show()),
                a
            );
        },
    }),
    (gj.slider.events = {
        change: function (a) {
            return a.triggerHandler("change");
        },
        slide: function (a, b) {
            return a.triggerHandler("slide", [b]);
        },
    }),
    (gj.slider.widget = function (a, b) {
        var c = this,
            d = gj.slider.methods;
        return (
            (c.value = function (a) {
                return d.value(this, this.data(), a);
            }),
            (c.destroy = function () {
                return d.destroy(this);
            }),
            $.extend(a, c),
            "true" !== a.attr("data-slider") && d.init.call(a, b),
            a
        );
    }),
    (gj.slider.widget.prototype = new gj.widget()),
    (gj.slider.widget.constructor = gj.slider.widget),
    (function (a) {
        a.fn.slider = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.slider.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.slider.widget(this, a);
            }
        };
    })(jQuery),
    (gj.colorpicker = { plugins: {}, messages: { "en-us": {} } }),
    (gj.colorpicker.config = {
        base: {
            uiLibrary: "materialdesign",
            value: void 0,
            icons: { rightIcon: '<i class="gj-icon">event</i>' },
            style: { modal: "gj-modal", wrapper: "gj-colorpicker gj-colorpicker-md gj-unselectable", input: "gj-textbox-md", picker: "gj-picker gj-picker-md colorpicker gj-unselectable", footer: "", button: "gj-button-md" },
        },
        bootstrap: { style: {} },
        bootstrap4: { style: {} },
    }),
    (gj.colorpicker.methods = {
        init: function (a) {
            return gj.picker.widget.prototype.init.call(this, a, "colorpicker"), gj.colorpicker.methods.initialize(this), this;
        },
        initialize: function (a) {},
        createPicker: function (a, b) {
            var c = $('<div role="picker" />').addClass(b.style.picker).attr("guid", a.attr("data-guid"));
            return c.html("test"), c.hide(), $("body").append(c), c;
        },
        open: function (a) {
            return a.val() && a.value(a.val()), gj.picker.widget.prototype.open.call(a, "colorpicker");
        },
    }),
    (gj.colorpicker.events = {
        change: function (a) {
            return a.triggerHandler("change");
        },
        select: function (a) {
            return a.triggerHandler("select");
        },
        open: function (a) {
            return a.triggerHandler("open");
        },
        close: function (a) {
            return a.triggerHandler("close");
        },
    }),
    (gj.colorpicker.widget = function (a, b) {
        var c = this,
            d = gj.colorpicker.methods;
        return (
            (c.value = function (a) {
                return d.value(this, a);
            }),
            (c.destroy = function () {
                return gj.picker.widget.prototype.destroy.call(this, "colorpicker");
            }),
            (c.open = function () {
                return d.open(this);
            }),
            (c.close = function () {
                return gj.picker.widget.prototype.close.call(this, "colorpicker");
            }),
            $.extend(a, c),
            "true" !== a.attr("data-colorpicker") && d.init.call(a, b),
            a
        );
    }),
    (gj.colorpicker.widget.prototype = new gj.picker.widget()),
    (gj.colorpicker.widget.constructor = gj.colorpicker.widget),
    (function (a) {
        a.fn.colorpicker = function (a) {
            var b;
            if (this && this.length) {
                if ("object" != typeof a && a) {
                    if (((b = new gj.colorpicker.widget(this, null)), b[a])) return b[a].apply(this, Array.prototype.slice.call(arguments, 1));
                    throw "Method " + a + " does not exist.";
                }
                return new gj.colorpicker.widget(this, a);
            }
        };
    })(jQuery);
