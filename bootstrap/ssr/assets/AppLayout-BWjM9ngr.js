import { defineComponent, ref, onMounted, useSSRContext, computed, mergeProps, unref, withCtx, createVNode, resolveDynamicComponent, createBlock, createTextVNode, openBlock, toDisplayString } from "vue";
import { ssrRenderTeleport, ssrRenderList, ssrRenderClass, ssrInterpolate, ssrRenderAttrs, ssrRenderComponent, ssrRenderVNode, ssrRenderSlot } from "vue/server-renderer";
import { a as usePage, l as link_default } from "../ssr.js";
import { Shield, Home, Info, Tag, Infinity, Settings, LayoutDashboard, User, ChevronDown, LogOut, LogIn, UserPlus, Moon, Sun, Menu, X, Download } from "lucide-vue-next";
const _sfc_main$1 = /* @__PURE__ */ defineComponent({
  __name: "Toast",
  __ssrInlineRender: true,
  setup(__props, { expose: __expose }) {
    const toasts = ref([]);
    let toastId = 0;
    const addToast = (options) => {
      const id = ++toastId;
      const toast = {
        id,
        message: options.message,
        type: options.type || "info",
        duration: options.duration || 3e3
      };
      toasts.value.push(toast);
      setTimeout(() => {
        removeToast(id);
      }, toast.duration);
    };
    const removeToast = (id) => {
      const index = toasts.value.findIndex((t) => t.id === id);
      if (index > -1) {
        toasts.value.splice(index, 1);
      }
    };
    const getToastClasses = (type) => {
      const baseClasses = "p-4 rounded-lg shadow-lg flex items-center space-x-3 transition-all duration-300";
      const typeClasses = {
        success: "bg-gradient-to-r from-green-500 to-green-600 text-white",
        error: "bg-gradient-to-r from-red-500 to-red-600 text-white",
        warning: "bg-gradient-to-r from-yellow-500 to-yellow-600 text-white",
        info: "bg-gradient-to-r from-blue-500 to-blue-600 text-white"
      };
      return `${baseClasses} ${typeClasses[type] || typeClasses.info}`;
    };
    __expose({ addToast });
    onMounted(() => {
      window.$toast = addToast;
    });
    return (_ctx, _push, _parent, _attrs) => {
      ssrRenderTeleport(_push, (_push2) => {
        _push2(`<div class="fixed top-4 right-4 z-50 space-y-2"><!--[-->`);
        ssrRenderList(toasts.value, (toast) => {
          _push2(`<div class="${ssrRenderClass(getToastClasses(toast.type || "info"))}"><span>${ssrInterpolate(toast.message)}</span><button class="ml-2 hover:opacity-70"> ✕ </button></div>`);
        });
        _push2(`<!--]--></div>`);
      }, "body", false, _parent);
    };
  }
});
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/Toast.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "AppLayout",
  __ssrInlineRender: true,
  setup(__props) {
    const page = usePage();
    const isDark = ref(false);
    const isMobileMenuOpen = ref(false);
    const isUserDropdownOpen = ref(false);
    const user = computed(() => {
      var _a;
      return (_a = page.props.auth) == null ? void 0 : _a.user;
    });
    const isAdmin = computed(() => {
      var _a;
      return ((_a = user.value) == null ? void 0 : _a.role) === "admin";
    });
    onMounted(() => {
      const savedTheme = localStorage.getItem("theme");
      const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
      if (savedTheme === "dark" || !savedTheme && prefersDark) {
        isDark.value = true;
        document.documentElement.classList.add("dark");
      }
    });
    const navLinks = [
      { name: "হোম", href: "/", icon: Home },
      { name: "আমাদের সম্পর্কে", href: "/about", icon: Info },
      { name: "প্রাইসিং", href: "/pricing", icon: Tag },
      { name: "সীমাহীন সার্চ", href: "/website-subscriptions", icon: Infinity }
    ];
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300" }, _attrs))}>`);
      _push(ssrRenderComponent(_sfc_main$1, null, null, _parent));
      _push(`<header class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg shadow-lg py-4 sticky top-0 z-50 border-b border-gray-200 dark:border-gray-700"><div class="container mx-auto px-4"><div class="flex justify-between items-center">`);
      _push(ssrRenderComponent(unref(link_default), {
        href: "/",
        class: "flex items-center group"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white w-10 h-10 rounded-xl flex items-center justify-center mr-3 shadow-lg group-hover:shadow-xl transition-shadow"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(Shield), { class: "w-5 h-5" }, null, _parent2, _scopeId));
            _push2(`</div><div class="text-xl font-bold"${_scopeId}><span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"${_scopeId}>Fraud</span><span class="text-gray-800 dark:text-white"${_scopeId}>Shield</span></div>`);
          } else {
            return [
              createVNode("div", { class: "bg-gradient-to-r from-indigo-600 to-purple-600 text-white w-10 h-10 rounded-xl flex items-center justify-center mr-3 shadow-lg group-hover:shadow-xl transition-shadow" }, [
                createVNode(unref(Shield), { class: "w-5 h-5" })
              ]),
              createVNode("div", { class: "text-xl font-bold" }, [
                createVNode("span", { class: "bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent" }, "Fraud"),
                createVNode("span", { class: "text-gray-800 dark:text-white" }, "Shield")
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<nav class="hidden md:flex items-center gap-1"><!--[-->`);
      ssrRenderList(navLinks, (link) => {
        _push(ssrRenderComponent(unref(link_default), {
          key: link.href,
          href: link.href,
          class: "flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              ssrRenderVNode(_push2, createVNode(resolveDynamicComponent(link.icon), { class: "w-4 h-4" }, null), _parent2, _scopeId);
              _push2(` ${ssrInterpolate(link.name)}`);
            } else {
              return [
                (openBlock(), createBlock(resolveDynamicComponent(link.icon), { class: "w-4 h-4" })),
                createTextVNode(" " + toDisplayString(link.name), 1)
              ];
            }
          }),
          _: 2
        }, _parent));
      });
      _push(`<!--]-->`);
      if (user.value) {
        _push(`<!--[-->`);
        if (isAdmin.value) {
          _push(ssrRenderComponent(unref(link_default), {
            href: "/admin",
            class: "flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(ssrRenderComponent(unref(Settings), { class: "w-4 h-4" }, null, _parent2, _scopeId));
                _push2(` Admin `);
              } else {
                return [
                  createVNode(unref(Settings), { class: "w-4 h-4" }),
                  createTextVNode(" Admin ")
                ];
              }
            }),
            _: 1
          }, _parent));
        } else {
          _push(ssrRenderComponent(unref(link_default), {
            href: "/dashboard",
            class: "flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(ssrRenderComponent(unref(LayoutDashboard), { class: "w-4 h-4" }, null, _parent2, _scopeId));
                _push2(` Dashboard `);
              } else {
                return [
                  createVNode(unref(LayoutDashboard), { class: "w-4 h-4" }),
                  createTextVNode(" Dashboard ")
                ];
              }
            }),
            _: 1
          }, _parent));
        }
        _push(`<div class="relative"><button class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all">`);
        _push(ssrRenderComponent(unref(User), { class: "w-4 h-4" }, null, _parent));
        _push(` ${ssrInterpolate(user.value.name)} `);
        _push(ssrRenderComponent(unref(ChevronDown), {
          class: ["w-3 h-3 transition-transform", { "rotate-180": isUserDropdownOpen.value }]
        }, null, _parent));
        _push(`</button>`);
        if (isUserDropdownOpen.value) {
          _push(`<div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg py-2 z-50 border border-gray-200 dark:border-gray-700">`);
          _push(ssrRenderComponent(unref(link_default), {
            href: "/dashboard",
            class: "flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(ssrRenderComponent(unref(LayoutDashboard), { class: "w-4 h-4" }, null, _parent2, _scopeId));
                _push2(` Dashboard `);
              } else {
                return [
                  createVNode(unref(LayoutDashboard), { class: "w-4 h-4" }),
                  createTextVNode(" Dashboard ")
                ];
              }
            }),
            _: 1
          }, _parent));
          _push(`<hr class="my-1 border-gray-200 dark:border-gray-700">`);
          _push(ssrRenderComponent(unref(link_default), {
            href: "/logout",
            method: "post",
            as: "button",
            class: "flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700"
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(ssrRenderComponent(unref(LogOut), { class: "w-4 h-4" }, null, _parent2, _scopeId));
                _push2(` Logout `);
              } else {
                return [
                  createVNode(unref(LogOut), { class: "w-4 h-4" }),
                  createTextVNode(" Logout ")
                ];
              }
            }),
            _: 1
          }, _parent));
          _push(`</div>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div><!--]-->`);
      } else {
        _push(`<!--[-->`);
        _push(ssrRenderComponent(unref(link_default), {
          href: "/login",
          class: "flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all"
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(ssrRenderComponent(unref(LogIn), { class: "w-4 h-4" }, null, _parent2, _scopeId));
              _push2(` Login `);
            } else {
              return [
                createVNode(unref(LogIn), { class: "w-4 h-4" }),
                createTextVNode(" Login ")
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(ssrRenderComponent(unref(link_default), {
          href: "/register",
          class: "flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:opacity-90 transition-opacity"
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(ssrRenderComponent(unref(UserPlus), { class: "w-4 h-4" }, null, _parent2, _scopeId));
              _push2(` Register `);
            } else {
              return [
                createVNode(unref(UserPlus), { class: "w-4 h-4" }),
                createTextVNode(" Register ")
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(`<!--]-->`);
      }
      _push(`<button class="p-2.5 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-gray-700 dark:text-gray-200">`);
      if (!isDark.value) {
        _push(ssrRenderComponent(unref(Moon), { class: "w-5 h-5" }, null, _parent));
      } else {
        _push(ssrRenderComponent(unref(Sun), { class: "w-5 h-5" }, null, _parent));
      }
      _push(`</button></nav><div class="md:hidden flex items-center gap-2"><button class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">`);
      if (!isDark.value) {
        _push(ssrRenderComponent(unref(Moon), { class: "w-5 h-5 text-gray-700" }, null, _parent));
      } else {
        _push(ssrRenderComponent(unref(Sun), { class: "w-5 h-5 text-gray-200" }, null, _parent));
      }
      _push(`</button><button class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">`);
      if (!isMobileMenuOpen.value) {
        _push(ssrRenderComponent(unref(Menu), { class: "w-6 h-6" }, null, _parent));
      } else {
        _push(ssrRenderComponent(unref(X), { class: "w-6 h-6" }, null, _parent));
      }
      _push(`</button></div></div>`);
      if (isMobileMenuOpen.value) {
        _push(`<nav class="md:hidden mt-4 pb-4 border-t border-gray-200 dark:border-gray-700 pt-4 space-y-1"><!--[-->`);
        ssrRenderList(navLinks, (link) => {
          _push(ssrRenderComponent(unref(link_default), {
            key: link.href,
            href: link.href,
            class: "flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all",
            onClick: ($event) => isMobileMenuOpen.value = false
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                ssrRenderVNode(_push2, createVNode(resolveDynamicComponent(link.icon), { class: "w-4 h-4" }, null), _parent2, _scopeId);
                _push2(` ${ssrInterpolate(link.name)}`);
              } else {
                return [
                  (openBlock(), createBlock(resolveDynamicComponent(link.icon), { class: "w-4 h-4" })),
                  createTextVNode(" " + toDisplayString(link.name), 1)
                ];
              }
            }),
            _: 2
          }, _parent));
        });
        _push(`<!--]-->`);
        _push(ssrRenderComponent(unref(link_default), {
          href: "/download",
          class: "flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all",
          onClick: ($event) => isMobileMenuOpen.value = false
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(ssrRenderComponent(unref(Download), { class: "w-4 h-4" }, null, _parent2, _scopeId));
              _push2(` অ্যাপ ডাউনলোড `);
            } else {
              return [
                createVNode(unref(Download), { class: "w-4 h-4" }),
                createTextVNode(" অ্যাপ ডাউনলোড ")
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(`<div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2 space-y-1">`);
        if (user.value) {
          _push(`<!--[-->`);
          _push(ssrRenderComponent(unref(link_default), {
            href: "/dashboard",
            class: "flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all",
            onClick: ($event) => isMobileMenuOpen.value = false
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(ssrRenderComponent(unref(LayoutDashboard), { class: "w-4 h-4" }, null, _parent2, _scopeId));
                _push2(` Dashboard `);
              } else {
                return [
                  createVNode(unref(LayoutDashboard), { class: "w-4 h-4" }),
                  createTextVNode(" Dashboard ")
                ];
              }
            }),
            _: 1
          }, _parent));
          _push(ssrRenderComponent(unref(link_default), {
            href: "/logout",
            method: "post",
            as: "button",
            class: "flex items-center gap-2 w-full px-3 py-2 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(ssrRenderComponent(unref(LogOut), { class: "w-4 h-4" }, null, _parent2, _scopeId));
                _push2(` Logout `);
              } else {
                return [
                  createVNode(unref(LogOut), { class: "w-4 h-4" }),
                  createTextVNode(" Logout ")
                ];
              }
            }),
            _: 1
          }, _parent));
          _push(`<!--]-->`);
        } else {
          _push(`<!--[-->`);
          _push(ssrRenderComponent(unref(link_default), {
            href: "/login",
            class: "flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all",
            onClick: ($event) => isMobileMenuOpen.value = false
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(ssrRenderComponent(unref(LogIn), { class: "w-4 h-4" }, null, _parent2, _scopeId));
                _push2(` Login `);
              } else {
                return [
                  createVNode(unref(LogIn), { class: "w-4 h-4" }),
                  createTextVNode(" Login ")
                ];
              }
            }),
            _: 1
          }, _parent));
          _push(ssrRenderComponent(unref(link_default), {
            href: "/register",
            class: "flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all",
            onClick: ($event) => isMobileMenuOpen.value = false
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(ssrRenderComponent(unref(UserPlus), { class: "w-4 h-4" }, null, _parent2, _scopeId));
                _push2(` Register `);
              } else {
                return [
                  createVNode(unref(UserPlus), { class: "w-4 h-4" }),
                  createTextVNode(" Register ")
                ];
              }
            }),
            _: 1
          }, _parent));
          _push(`<!--]-->`);
        }
        _push(`</div></nav>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></header><main class="flex-1">`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</main><footer class="bg-gradient-to-r from-indigo-900 to-purple-900 text-white py-12 mt-auto"><div class="container mx-auto px-4"><div class="grid grid-cols-1 md:grid-cols-4 gap-8"><div><div class="flex items-center mb-4"><div class="bg-white text-indigo-600 w-10 h-10 rounded-xl flex items-center justify-center mr-3 shadow-lg">`);
      _push(ssrRenderComponent(unref(Shield), { class: "w-5 h-5" }, null, _parent));
      _push(`</div><div class="text-xl font-bold"><span class="text-white">Fraud</span><span class="text-yellow-400">Shield</span></div></div><p class="text-sm text-indigo-200 mb-4"> উন্নত ফ্রড ডিটেকশন সিস্টেম কুরিয়ার সেবার জন্য। আপনার ব্যবসাকে সম্ভাব্য ফ্রড থেকে রক্ষা করুন। </p></div><div><h3 class="text-lg font-semibold mb-4">দ্রুত লিংক</h3><ul class="space-y-2"><li>`);
      _push(ssrRenderComponent(unref(link_default), {
        href: "/",
        class: "text-indigo-200 hover:text-white transition"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`হোম`);
          } else {
            return [
              createTextVNode("হোম")
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</li><li>`);
      _push(ssrRenderComponent(unref(link_default), {
        href: "/about",
        class: "text-indigo-200 hover:text-white transition"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`আমাদের সম্পর্কে`);
          } else {
            return [
              createTextVNode("আমাদের সম্পর্কে")
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</li><li>`);
      _push(ssrRenderComponent(unref(link_default), {
        href: "/download",
        class: "text-indigo-200 hover:text-white transition"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`অ্যাপ ডাউনলোড`);
          } else {
            return [
              createTextVNode("অ্যাপ ডাউনলোড")
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</li><li>`);
      _push(ssrRenderComponent(unref(link_default), {
        href: "/pricing",
        class: "text-indigo-200 hover:text-white transition"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`প্রাইসিং`);
          } else {
            return [
              createTextVNode("প্রাইসিং")
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</li></ul></div><div><h3 class="text-lg font-semibold mb-4">রিসোর্স</h3><ul class="space-y-2"><li>`);
      _push(ssrRenderComponent(unref(link_default), {
        href: "/api/documentation",
        class: "text-indigo-200 hover:text-white transition"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`API ডকুমেন্টেশন`);
          } else {
            return [
              createTextVNode("API ডকুমেন্টেশন")
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</li><li><a href="#" class="text-indigo-200 hover:text-white transition">সাহায্য</a></li><li><a href="#" class="text-indigo-200 hover:text-white transition">ব্লগ</a></li></ul></div><div><h3 class="text-lg font-semibold mb-4">যোগাযোগ</h3><ul class="space-y-2 text-indigo-200"><li>ঢাকা, বাংলাদেশ</li><li>info@fraudshieldbd.site</li></ul></div></div><div class="border-t border-indigo-800 mt-8 pt-8 text-center text-sm text-indigo-300"><p>© ${ssrInterpolate((/* @__PURE__ */ new Date()).getFullYear())} FraudShield. All rights reserved.</p><p class="mt-1">Powered by <a href="https://tyrodevs.com" class="text-yellow-400 hover:text-yellow-300 transition">Tyrodevs</a></p></div></div></footer></div>`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Layouts/AppLayout.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as _
};
