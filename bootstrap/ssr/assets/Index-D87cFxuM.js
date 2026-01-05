import { defineComponent, computed, unref, withCtx, createVNode, createTextVNode, toDisplayString, createBlock, createCommentVNode, openBlock, Fragment, renderList, useSSRContext } from "vue";
import { ssrRenderComponent, ssrInterpolate, ssrRenderList, ssrRenderClass } from "vue/server-renderer";
import { a as usePage, h as head_default, l as link_default } from "../ssr.js";
import { _ as _sfc_main$5 } from "./Card-BKxb1AUA.js";
import { _ as _sfc_main$1 } from "./Button-AaQimkH7.js";
import { _ as _sfc_main$2, a as _sfc_main$3, b as _sfc_main$4, c as _sfc_main$6, d as _sfc_main$7 } from "./AlertDescription-CA6uqSiP.js";
import "@vue/server-renderer";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
import "clsx";
import "tailwind-merge";
import "class-variance-authority";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Index",
  __ssrInlineRender: true,
  props: {
    apiKeys: {},
    todayUsage: {},
    monthlyUsage: {},
    activeSubscription: {},
    activeWebsiteSubscription: {},
    flash: {}
  },
  setup(__props) {
    const props = __props;
    const page = usePage();
    const user = computed(() => {
      var _a;
      return (_a = page.props.auth) == null ? void 0 : _a.user;
    });
    const copyToClipboard = (text) => {
      navigator.clipboard.writeText(text).then(() => {
        const toast = document.createElement("div");
        toast.className = "fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300";
        toast.innerHTML = '<i class="fas fa-check mr-2"></i>Copied to clipboard!';
        document.body.appendChild(toast);
        setTimeout(() => toast.classList.remove("translate-x-full"), 100);
        setTimeout(() => {
          toast.classList.add("translate-x-full");
          setTimeout(() => document.body.removeChild(toast), 300);
        }, 3e3);
      });
    };
    const usagePercentage = computed(() => {
      if (!props.activeSubscription) return 0;
      return Math.min(100, props.todayUsage / props.activeSubscription.plan.request_limit * 100);
    });
    const usageColor = computed(() => {
      if (usagePercentage.value > 90) return "destructive";
      if (usagePercentage.value > 70) return "warning";
      return "success";
    });
    const stats = computed(() => {
      var _a, _b, _c;
      return [
        {
          icon: "key",
          gradient: "from-blue-500 to-indigo-600",
          label: "API Keys",
          value: props.apiKeys.length,
          subtext: `${props.apiKeys.filter((k) => k.is_active).length} active`
        },
        {
          icon: "chart-line",
          gradient: "from-green-500 to-emerald-600",
          label: "Today's Usage",
          value: props.todayUsage.toLocaleString(),
          subtext: "requests made"
        },
        {
          icon: "calendar",
          gradient: "from-purple-500 to-pink-600",
          label: "Monthly Usage",
          value: props.monthlyUsage.toLocaleString(),
          subtext: "this month"
        },
        {
          icon: "crown",
          gradient: "from-orange-500 to-yellow-500",
          label: "API Plan",
          value: ((_a = props.activeSubscription) == null ? void 0 : _a.plan.name) || "No Plan",
          subtext: props.activeSubscription ? `${props.activeSubscription.days_remaining} days left` : "Inactive"
        },
        {
          icon: "infinity",
          gradient: "from-indigo-500 to-purple-600",
          label: "Website Plan",
          value: props.activeWebsiteSubscription ? `${props.activeWebsiteSubscription.plan_type.charAt(0).toUpperCase()}${props.activeWebsiteSubscription.plan_type.slice(1)}` : "No Plan",
          subtext: ((_b = props.activeWebsiteSubscription) == null ? void 0 : _b.verification_status) === "verified" ? `${props.activeWebsiteSubscription.days_remaining} days left` : ((_c = props.activeWebsiteSubscription) == null ? void 0 : _c.verification_status) === "pending" ? "Pending approval" : "Limited"
        }
      ];
    });
    return (_ctx, _push, _parent, _attrs) => {
      var _a, _b, _c, _d;
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(head_default), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title${_scopeId}>Dashboard - FraudShield API</title><meta name="description" content="Manage your FraudShield API keys and subscriptions"${_scopeId}><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, "Dashboard - FraudShield API"),
              createVNode("meta", {
                name: "description",
                content: "Manage your FraudShield API keys and subscriptions"
              }),
              createVNode("link", {
                rel: "stylesheet",
                href: "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8"><div class="container mx-auto px-4"><div class="mb-8"><div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0"><div><h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Dashboard</h1><p class="text-gray-600 dark:text-gray-300 mt-1">Welcome back, ${ssrInterpolate((_a = user.value) == null ? void 0 : _a.name)}!</p></div><div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-3">`);
      _push(ssrRenderComponent(unref(link_default), {
        href: "/api/documentation",
        target: "_blank"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(ssrRenderComponent(_sfc_main$1, { class: "bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors w-full sm:w-auto" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<i class="fas fa-book mr-2"${_scopeId2}></i>API Documentation `);
                } else {
                  return [
                    createVNode("i", { class: "fas fa-book mr-2" }),
                    createTextVNode("API Documentation ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
          } else {
            return [
              createVNode(_sfc_main$1, { class: "bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors w-full sm:w-auto" }, {
                default: withCtx(() => [
                  createVNode("i", { class: "fas fa-book mr-2" }),
                  createTextVNode("API Documentation ")
                ]),
                _: 1
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(unref(link_default), { href: "/pricing" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(ssrRenderComponent(_sfc_main$1, {
              variant: "outline",
              class: "bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors w-full sm:w-auto"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<i class="fas fa-crown mr-2"${_scopeId2}></i>Upgrade Plan `);
                } else {
                  return [
                    createVNode("i", { class: "fas fa-crown mr-2" }),
                    createTextVNode("Upgrade Plan ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
          } else {
            return [
              createVNode(_sfc_main$1, {
                variant: "outline",
                class: "bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors w-full sm:w-auto"
              }, {
                default: withCtx(() => [
                  createVNode("i", { class: "fas fa-crown mr-2" }),
                  createTextVNode("Upgrade Plan ")
                ]),
                _: 1
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div></div></div>`);
      if ((_b = __props.flash) == null ? void 0 : _b.success) {
        _push(ssrRenderComponent(_sfc_main$2, { class: "mb-6 bg-green-100 border-l-4 border-green-500 text-green-700" }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`<i class="fas fa-check-circle mr-3 text-green-500"${_scopeId}></i>`);
              _push2(ssrRenderComponent(_sfc_main$3, null, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`${ssrInterpolate(__props.flash.success)}`);
                  } else {
                    return [
                      createTextVNode(toDisplayString(__props.flash.success), 1)
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
            } else {
              return [
                createVNode("i", { class: "fas fa-check-circle mr-3 text-green-500" }),
                createVNode(_sfc_main$3, null, {
                  default: withCtx(() => [
                    createTextVNode(toDisplayString(__props.flash.success), 1)
                  ]),
                  _: 1
                })
              ];
            }
          }),
          _: 1
        }, _parent));
      } else {
        _push(`<!---->`);
      }
      if ((_c = __props.flash) == null ? void 0 : _c.error) {
        _push(ssrRenderComponent(_sfc_main$2, { class: "mb-6 bg-red-100 border-l-4 border-red-500 text-red-700" }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`<i class="fas fa-exclamation-circle mr-3 text-red-500"${_scopeId}></i>`);
              _push2(ssrRenderComponent(_sfc_main$3, null, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`${ssrInterpolate(__props.flash.error)}`);
                  } else {
                    return [
                      createTextVNode(toDisplayString(__props.flash.error), 1)
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
            } else {
              return [
                createVNode("i", { class: "fas fa-exclamation-circle mr-3 text-red-500" }),
                createVNode(_sfc_main$3, null, {
                  default: withCtx(() => [
                    createTextVNode(toDisplayString(__props.flash.error), 1)
                  ]),
                  _: 1
                })
              ];
            }
          }),
          _: 1
        }, _parent));
      } else {
        _push(`<!---->`);
      }
      if ((_d = __props.flash) == null ? void 0 : _d.new_api_key) {
        _push(ssrRenderComponent(_sfc_main$2, { class: "mb-6 bg-blue-50 border border-blue-200 text-blue-800 p-6" }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`<div class="flex items-start"${_scopeId}><i class="fas fa-key text-blue-500 mr-3 mt-1"${_scopeId}></i><div class="flex-1"${_scopeId}>`);
              _push2(ssrRenderComponent(_sfc_main$4, { class: "font-bold text-lg mb-2" }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`Your new API credentials`);
                  } else {
                    return [
                      createTextVNode("Your new API credentials")
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
              _push2(ssrRenderComponent(_sfc_main$3, { class: "text-sm mb-4 text-blue-700" }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`Save these credentials securely. They won&#39;t be shown again!`);
                  } else {
                    return [
                      createTextVNode("Save these credentials securely. They won't be shown again!")
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
              _push2(`<div class="space-y-3"${_scopeId}><div${_scopeId}><label class="block text-sm font-medium text-blue-800 mb-1"${_scopeId}>API Key:</label><div class="flex items-center space-x-2"${_scopeId}><code class="bg-blue-100 px-3 py-2 rounded flex-1 font-mono text-sm"${_scopeId}>${ssrInterpolate(__props.flash.new_api_key)}</code>`);
              _push2(ssrRenderComponent(_sfc_main$1, {
                onClick: ($event) => copyToClipboard(__props.flash.new_api_key),
                class: "bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm transition-colors"
              }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`<i class="fas fa-copy"${_scopeId2}></i>`);
                  } else {
                    return [
                      createVNode("i", { class: "fas fa-copy" })
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
              _push2(`</div></div>`);
              if (__props.flash.new_api_secret) {
                _push2(`<div${_scopeId}><label class="block text-sm font-medium text-blue-800 mb-1"${_scopeId}>API Secret:</label><div class="flex items-center space-x-2"${_scopeId}><code class="bg-blue-100 px-3 py-2 rounded flex-1 font-mono text-sm"${_scopeId}>${ssrInterpolate(__props.flash.new_api_secret)}</code>`);
                _push2(ssrRenderComponent(_sfc_main$1, {
                  onClick: ($event) => copyToClipboard(__props.flash.new_api_secret),
                  class: "bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm transition-colors"
                }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(`<i class="fas fa-copy"${_scopeId2}></i>`);
                    } else {
                      return [
                        createVNode("i", { class: "fas fa-copy" })
                      ];
                    }
                  }),
                  _: 1
                }, _parent2, _scopeId));
                _push2(`</div></div>`);
              } else {
                _push2(`<!---->`);
              }
              _push2(`</div><div class="mt-4 p-3 bg-blue-100 rounded"${_scopeId}><p class="text-sm text-blue-800"${_scopeId}><i class="fas fa-info-circle mr-1"${_scopeId}></i><strong${_scopeId}>Important:</strong> Store these credentials securely. Use the API key for authentication and refer to our documentation for implementation details. </p></div></div></div>`);
            } else {
              return [
                createVNode("div", { class: "flex items-start" }, [
                  createVNode("i", { class: "fas fa-key text-blue-500 mr-3 mt-1" }),
                  createVNode("div", { class: "flex-1" }, [
                    createVNode(_sfc_main$4, { class: "font-bold text-lg mb-2" }, {
                      default: withCtx(() => [
                        createTextVNode("Your new API credentials")
                      ]),
                      _: 1
                    }),
                    createVNode(_sfc_main$3, { class: "text-sm mb-4 text-blue-700" }, {
                      default: withCtx(() => [
                        createTextVNode("Save these credentials securely. They won't be shown again!")
                      ]),
                      _: 1
                    }),
                    createVNode("div", { class: "space-y-3" }, [
                      createVNode("div", null, [
                        createVNode("label", { class: "block text-sm font-medium text-blue-800 mb-1" }, "API Key:"),
                        createVNode("div", { class: "flex items-center space-x-2" }, [
                          createVNode("code", { class: "bg-blue-100 px-3 py-2 rounded flex-1 font-mono text-sm" }, toDisplayString(__props.flash.new_api_key), 1),
                          createVNode(_sfc_main$1, {
                            onClick: ($event) => copyToClipboard(__props.flash.new_api_key),
                            class: "bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm transition-colors"
                          }, {
                            default: withCtx(() => [
                              createVNode("i", { class: "fas fa-copy" })
                            ]),
                            _: 1
                          }, 8, ["onClick"])
                        ])
                      ]),
                      __props.flash.new_api_secret ? (openBlock(), createBlock("div", { key: 0 }, [
                        createVNode("label", { class: "block text-sm font-medium text-blue-800 mb-1" }, "API Secret:"),
                        createVNode("div", { class: "flex items-center space-x-2" }, [
                          createVNode("code", { class: "bg-blue-100 px-3 py-2 rounded flex-1 font-mono text-sm" }, toDisplayString(__props.flash.new_api_secret), 1),
                          createVNode(_sfc_main$1, {
                            onClick: ($event) => copyToClipboard(__props.flash.new_api_secret),
                            class: "bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm transition-colors"
                          }, {
                            default: withCtx(() => [
                              createVNode("i", { class: "fas fa-copy" })
                            ]),
                            _: 1
                          }, 8, ["onClick"])
                        ])
                      ])) : createCommentVNode("", true)
                    ]),
                    createVNode("div", { class: "mt-4 p-3 bg-blue-100 rounded" }, [
                      createVNode("p", { class: "text-sm text-blue-800" }, [
                        createVNode("i", { class: "fas fa-info-circle mr-1" }),
                        createVNode("strong", null, "Important:"),
                        createTextVNode(" Store these credentials securely. Use the API key for authentication and refer to our documentation for implementation details. ")
                      ])
                    ])
                  ])
                ])
              ];
            }
          }),
          _: 1
        }, _parent));
      } else {
        _push(`<!---->`);
      }
      _push(`<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6 mb-8"><!--[-->`);
      ssrRenderList(stats.value, (stat) => {
        _push(ssrRenderComponent(_sfc_main$5, {
          key: stat.label,
          class: "p-6 border border-gray-100 dark:border-gray-700"
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`<div class="flex items-center"${_scopeId}><div class="${ssrRenderClass(["p-3 rounded-full bg-gradient-to-r", stat.gradient])}"${_scopeId}><i class="${ssrRenderClass(["fas text-white text-xl", `fa-${stat.icon}`])}"${_scopeId}></i></div><div class="ml-4 min-w-0 flex-1"${_scopeId}><p class="text-sm font-medium text-gray-600 dark:text-gray-400 truncate"${_scopeId}>${ssrInterpolate(stat.label)}</p><p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white"${_scopeId}>${ssrInterpolate(stat.value)}</p><p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate"${_scopeId}>${ssrInterpolate(stat.subtext)}</p></div></div>`);
            } else {
              return [
                createVNode("div", { class: "flex items-center" }, [
                  createVNode("div", {
                    class: ["p-3 rounded-full bg-gradient-to-r", stat.gradient]
                  }, [
                    createVNode("i", {
                      class: ["fas text-white text-xl", `fa-${stat.icon}`]
                    }, null, 2)
                  ], 2),
                  createVNode("div", { class: "ml-4 min-w-0 flex-1" }, [
                    createVNode("p", { class: "text-sm font-medium text-gray-600 dark:text-gray-400 truncate" }, toDisplayString(stat.label), 1),
                    createVNode("p", { class: "text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white" }, toDisplayString(stat.value), 1),
                    createVNode("p", { class: "text-xs text-gray-500 dark:text-gray-400 mt-1 truncate" }, toDisplayString(stat.subtext), 1)
                  ])
                ])
              ];
            }
          }),
          _: 2
        }, _parent));
      });
      _push(`<!--]--></div><div class="grid grid-cols-1 xl:grid-cols-2 gap-6 lg:gap-8">`);
      _push(ssrRenderComponent(_sfc_main$5, { class: "border border-gray-100 dark:border-gray-700" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700"${_scopeId}><div class="flex justify-between items-center"${_scopeId}><div${_scopeId}><h2 class="text-xl font-semibold text-gray-900 dark:text-white"${_scopeId}>API Keys</h2><p class="text-sm text-gray-500 dark:text-gray-400 mt-1"${_scopeId}>Your API authentication keys</p></div></div></div><div class="p-6"${_scopeId}>`);
            if (__props.apiKeys.length > 0) {
              _push2(`<div class="space-y-4"${_scopeId}><!--[-->`);
              ssrRenderList(__props.apiKeys, (apiKey) => {
                _push2(`<div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors"${_scopeId}><div class="flex flex-col space-y-3 sm:flex-row sm:justify-between sm:items-start sm:space-y-0"${_scopeId}><div class="flex-1 min-w-0"${_scopeId}><div class="flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-3 mb-2"${_scopeId}><h3 class="font-medium text-gray-900 dark:text-white truncate"${_scopeId}>${ssrInterpolate(apiKey.name)}</h3>`);
                _push2(ssrRenderComponent(_sfc_main$6, {
                  variant: apiKey.is_active ? "success" : "destructive",
                  class: "w-fit"
                }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(`${ssrInterpolate(apiKey.is_active ? "Active" : "Inactive")}`);
                    } else {
                      return [
                        createTextVNode(toDisplayString(apiKey.is_active ? "Active" : "Inactive"), 1)
                      ];
                    }
                  }),
                  _: 2
                }, _parent2, _scopeId));
                _push2(`</div><div class="flex items-center space-x-2 mb-2"${_scopeId}><code class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded text-sm font-mono flex-1 min-w-0 truncate"${_scopeId}>${ssrInterpolate(apiKey.masked_key)}</code>`);
                _push2(ssrRenderComponent(_sfc_main$1, {
                  onClick: ($event) => copyToClipboard(apiKey.key),
                  class: "bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 px-2 py-1 rounded text-xs transition-colors flex-shrink-0"
                }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(`<i class="fas fa-copy"${_scopeId2}></i>`);
                    } else {
                      return [
                        createVNode("i", { class: "fas fa-copy" })
                      ];
                    }
                  }),
                  _: 2
                }, _parent2, _scopeId));
                _push2(`</div><div class="flex flex-col space-y-1 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4 text-xs text-gray-500 dark:text-gray-400"${_scopeId}><span class="flex items-center"${_scopeId}><i class="fas fa-calendar mr-1"${_scopeId}></i>Created: ${ssrInterpolate(new Date(apiKey.created_at).toLocaleDateString())}</span>`);
                if (apiKey.last_used_at) {
                  _push2(`<span class="flex items-center"${_scopeId}><i class="fas fa-clock mr-1"${_scopeId}></i>Last used: ${ssrInterpolate(new Date(apiKey.last_used_at).toLocaleDateString())}</span>`);
                } else {
                  _push2(`<span class="flex items-center"${_scopeId}><i class="fas fa-clock mr-1"${_scopeId}></i>Never used</span>`);
                }
                _push2(`<span class="flex items-center"${_scopeId}><i class="fas fa-chart-bar mr-1"${_scopeId}></i>${ssrInterpolate(apiKey.usage_count.toLocaleString())} uses</span></div></div></div></div>`);
              });
              _push2(`<!--]--></div>`);
            } else {
              _push2(`<div class="text-center py-8"${_scopeId}><div class="mb-4"${_scopeId}><i class="fas fa-key text-gray-400 dark:text-gray-500 text-4xl"${_scopeId}></i></div><h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2"${_scopeId}>No API keys available</h3><p class="text-gray-500 dark:text-gray-400 mb-4"${_scopeId}>Contact administrator to get your API keys.</p></div>`);
            }
            _push2(`<div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700"${_scopeId}><div class="flex flex-wrap gap-3"${_scopeId}><span class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400"${_scopeId}><i class="fas fa-info-circle mr-2"${_scopeId}></i>Use these API keys to authenticate your requests </span></div></div></div>`);
          } else {
            return [
              createVNode("div", { class: "px-6 py-4 border-b border-gray-200 dark:border-gray-700" }, [
                createVNode("div", { class: "flex justify-between items-center" }, [
                  createVNode("div", null, [
                    createVNode("h2", { class: "text-xl font-semibold text-gray-900 dark:text-white" }, "API Keys"),
                    createVNode("p", { class: "text-sm text-gray-500 dark:text-gray-400 mt-1" }, "Your API authentication keys")
                  ])
                ])
              ]),
              createVNode("div", { class: "p-6" }, [
                __props.apiKeys.length > 0 ? (openBlock(), createBlock("div", {
                  key: 0,
                  class: "space-y-4"
                }, [
                  (openBlock(true), createBlock(Fragment, null, renderList(__props.apiKeys, (apiKey) => {
                    return openBlock(), createBlock("div", {
                      key: apiKey.id,
                      class: "border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors"
                    }, [
                      createVNode("div", { class: "flex flex-col space-y-3 sm:flex-row sm:justify-between sm:items-start sm:space-y-0" }, [
                        createVNode("div", { class: "flex-1 min-w-0" }, [
                          createVNode("div", { class: "flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-3 mb-2" }, [
                            createVNode("h3", { class: "font-medium text-gray-900 dark:text-white truncate" }, toDisplayString(apiKey.name), 1),
                            createVNode(_sfc_main$6, {
                              variant: apiKey.is_active ? "success" : "destructive",
                              class: "w-fit"
                            }, {
                              default: withCtx(() => [
                                createTextVNode(toDisplayString(apiKey.is_active ? "Active" : "Inactive"), 1)
                              ]),
                              _: 2
                            }, 1032, ["variant"])
                          ]),
                          createVNode("div", { class: "flex items-center space-x-2 mb-2" }, [
                            createVNode("code", { class: "bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded text-sm font-mono flex-1 min-w-0 truncate" }, toDisplayString(apiKey.masked_key), 1),
                            createVNode(_sfc_main$1, {
                              onClick: ($event) => copyToClipboard(apiKey.key),
                              class: "bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 px-2 py-1 rounded text-xs transition-colors flex-shrink-0"
                            }, {
                              default: withCtx(() => [
                                createVNode("i", { class: "fas fa-copy" })
                              ]),
                              _: 1
                            }, 8, ["onClick"])
                          ]),
                          createVNode("div", { class: "flex flex-col space-y-1 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4 text-xs text-gray-500 dark:text-gray-400" }, [
                            createVNode("span", { class: "flex items-center" }, [
                              createVNode("i", { class: "fas fa-calendar mr-1" }),
                              createTextVNode("Created: " + toDisplayString(new Date(apiKey.created_at).toLocaleDateString()), 1)
                            ]),
                            apiKey.last_used_at ? (openBlock(), createBlock("span", {
                              key: 0,
                              class: "flex items-center"
                            }, [
                              createVNode("i", { class: "fas fa-clock mr-1" }),
                              createTextVNode("Last used: " + toDisplayString(new Date(apiKey.last_used_at).toLocaleDateString()), 1)
                            ])) : (openBlock(), createBlock("span", {
                              key: 1,
                              class: "flex items-center"
                            }, [
                              createVNode("i", { class: "fas fa-clock mr-1" }),
                              createTextVNode("Never used")
                            ])),
                            createVNode("span", { class: "flex items-center" }, [
                              createVNode("i", { class: "fas fa-chart-bar mr-1" }),
                              createTextVNode(toDisplayString(apiKey.usage_count.toLocaleString()) + " uses", 1)
                            ])
                          ])
                        ])
                      ])
                    ]);
                  }), 128))
                ])) : (openBlock(), createBlock("div", {
                  key: 1,
                  class: "text-center py-8"
                }, [
                  createVNode("div", { class: "mb-4" }, [
                    createVNode("i", { class: "fas fa-key text-gray-400 dark:text-gray-500 text-4xl" })
                  ]),
                  createVNode("h3", { class: "text-lg font-medium text-gray-900 dark:text-white mb-2" }, "No API keys available"),
                  createVNode("p", { class: "text-gray-500 dark:text-gray-400 mb-4" }, "Contact administrator to get your API keys.")
                ])),
                createVNode("div", { class: "mt-6 pt-6 border-t border-gray-200 dark:border-gray-700" }, [
                  createVNode("div", { class: "flex flex-wrap gap-3" }, [
                    createVNode("span", { class: "inline-flex items-center text-sm text-gray-500 dark:text-gray-400" }, [
                      createVNode("i", { class: "fas fa-info-circle mr-2" }),
                      createTextVNode("Use these API keys to authenticate your requests ")
                    ])
                  ])
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$5, { class: "border border-gray-100 dark:border-gray-700" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700"${_scopeId}><div class="flex justify-between items-center"${_scopeId}><div${_scopeId}><h2 class="text-xl font-semibold text-gray-900 dark:text-white"${_scopeId}>Subscription Status</h2><p class="text-sm text-gray-500 dark:text-gray-400 mt-1"${_scopeId}>Your API and website subscription plans</p></div>`);
            if (__props.activeSubscription || __props.activeWebsiteSubscription) {
              _push2(ssrRenderComponent(_sfc_main$6, { variant: "success" }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`${ssrInterpolate(__props.activeSubscription && __props.activeWebsiteSubscription ? "Both Active" : "Active")}`);
                  } else {
                    return [
                      createTextVNode(toDisplayString(__props.activeSubscription && __props.activeWebsiteSubscription ? "Both Active" : "Active"), 1)
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
            } else {
              _push2(`<!---->`);
            }
            _push2(`</div></div><div class="p-6 space-y-6"${_scopeId}><div${_scopeId}><h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center"${_scopeId}><i class="fas fa-crown text-orange-500 mr-2"${_scopeId}></i> API Subscription </h3>`);
            if (__props.activeSubscription) {
              _push2(`<div class="bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 rounded-lg p-4"${_scopeId}><div class="flex items-center justify-between mb-3"${_scopeId}><h4 class="text-lg font-semibold text-gray-900 dark:text-white"${_scopeId}>${ssrInterpolate(__props.activeSubscription.plan.name)}</h4>`);
              _push2(ssrRenderComponent(_sfc_main$6, { variant: "warning" }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`Active`);
                  } else {
                    return [
                      createTextVNode("Active")
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
              _push2(`</div><p class="text-gray-600 dark:text-gray-300 text-sm mb-3"${_scopeId}>${ssrInterpolate(__props.activeSubscription.plan.description)}</p><div class="grid grid-cols-1 lg:grid-cols-2 gap-3 text-sm mb-4"${_scopeId}><div class="flex items-center"${_scopeId}><i class="fas fa-tachometer-alt text-orange-500 mr-2 flex-shrink-0"${_scopeId}></i><span class="text-gray-600 dark:text-gray-400 mr-1"${_scopeId}>Daily Limit:</span><span class="font-semibold text-gray-900 dark:text-white"${_scopeId}>${ssrInterpolate(__props.activeSubscription.plan.request_limit.toLocaleString())} requests</span></div><div class="flex items-center"${_scopeId}><i class="fas fa-calendar-alt text-orange-500 mr-2 flex-shrink-0"${_scopeId}></i><span class="text-gray-600 dark:text-gray-400 mr-1"${_scopeId}>Expires:</span><span class="font-semibold text-gray-900 dark:text-white"${_scopeId}>${ssrInterpolate(__props.activeSubscription.expires_at ? new Date(__props.activeSubscription.expires_at).toLocaleDateString() : "Never")}</span></div><div class="flex items-center"${_scopeId}><i class="fas fa-clock text-orange-500 mr-2 flex-shrink-0"${_scopeId}></i><span class="text-gray-600 dark:text-gray-400 mr-1"${_scopeId}>Days Remaining:</span><span class="font-semibold text-gray-900 dark:text-white"${_scopeId}>${ssrInterpolate(__props.activeSubscription.days_remaining)}</span></div><div class="flex items-center"${_scopeId}><i class="fas fa-chart-pie text-orange-500 mr-2 flex-shrink-0"${_scopeId}></i><span class="text-gray-600 dark:text-gray-400 mr-1"${_scopeId}>Usage Today:</span><span class="font-semibold text-gray-900 dark:text-white"${_scopeId}>${ssrInterpolate(__props.todayUsage.toLocaleString())} / ${ssrInterpolate(__props.activeSubscription.plan.request_limit.toLocaleString())}</span></div></div>`);
              if (__props.activeSubscription.days_remaining < 7 && __props.activeSubscription.days_remaining > 0) {
                _push2(ssrRenderComponent(_sfc_main$2, { class: "bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-200 px-3 py-2 rounded-lg mb-3" }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(`<i class="fas fa-exclamation-triangle mr-2 text-yellow-500"${_scopeId2}></i>`);
                      _push3(ssrRenderComponent(_sfc_main$3, { class: "text-sm" }, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            _push4(`API subscription expires in ${ssrInterpolate(__props.activeSubscription.days_remaining)} days`);
                          } else {
                            return [
                              createTextVNode("API subscription expires in " + toDisplayString(__props.activeSubscription.days_remaining) + " days", 1)
                            ];
                          }
                        }),
                        _: 1
                      }, _parent3, _scopeId2));
                    } else {
                      return [
                        createVNode("i", { class: "fas fa-exclamation-triangle mr-2 text-yellow-500" }),
                        createVNode(_sfc_main$3, { class: "text-sm" }, {
                          default: withCtx(() => [
                            createTextVNode("API subscription expires in " + toDisplayString(__props.activeSubscription.days_remaining) + " days", 1)
                          ]),
                          _: 1
                        })
                      ];
                    }
                  }),
                  _: 1
                }, _parent2, _scopeId));
              } else {
                _push2(`<!---->`);
              }
              _push2(`<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 mb-3"${_scopeId}><div class="flex justify-between items-center mb-2"${_scopeId}><span class="text-sm font-medium text-gray-700 dark:text-gray-300"${_scopeId}>Today&#39;s API Usage</span><span class="text-sm text-gray-500 dark:text-gray-400"${_scopeId}>${ssrInterpolate(__props.todayUsage.toLocaleString())} / ${ssrInterpolate(__props.activeSubscription.plan.request_limit.toLocaleString())}</span></div>`);
              _push2(ssrRenderComponent(_sfc_main$7, {
                value: usagePercentage.value,
                max: 100,
                variant: usageColor.value
              }, null, _parent2, _scopeId));
              _push2(`</div></div>`);
            } else {
              _push2(`<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4"${_scopeId}><div class="text-center"${_scopeId}><i class="fas fa-exclamation-circle text-orange-400 dark:text-orange-500 text-2xl mb-2"${_scopeId}></i><h4 class="font-medium text-gray-900 dark:text-white mb-1"${_scopeId}>No API Subscription</h4><p class="text-gray-600 dark:text-gray-400 text-sm"${_scopeId}>Subscribe to access API services</p>`);
              _push2(ssrRenderComponent(unref(link_default), {
                href: "/pricing",
                class: "mt-3 inline-block"
              }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(ssrRenderComponent(_sfc_main$1, { class: "bg-orange-500 hover:bg-orange-600 text-white" }, {
                      default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                        if (_push4) {
                          _push4(`<i class="fas fa-crown mr-2"${_scopeId3}></i>View Plans `);
                        } else {
                          return [
                            createVNode("i", { class: "fas fa-crown mr-2" }),
                            createTextVNode("View Plans ")
                          ];
                        }
                      }),
                      _: 1
                    }, _parent3, _scopeId2));
                  } else {
                    return [
                      createVNode(_sfc_main$1, { class: "bg-orange-500 hover:bg-orange-600 text-white" }, {
                        default: withCtx(() => [
                          createVNode("i", { class: "fas fa-crown mr-2" }),
                          createTextVNode("View Plans ")
                        ]),
                        _: 1
                      })
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
              _push2(`</div></div>`);
            }
            _push2(`</div><div class="border-t border-gray-200 dark:border-gray-700 pt-6"${_scopeId}><h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center"${_scopeId}><i class="fas fa-infinity text-indigo-500 mr-2"${_scopeId}></i> Website Unlimited Search </h3>`);
            if (__props.activeWebsiteSubscription) {
              _push2(`<div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg p-4"${_scopeId}><div class="flex items-center justify-between mb-3"${_scopeId}><h4 class="text-lg font-semibold text-gray-900 dark:text-white"${_scopeId}>${ssrInterpolate(__props.activeWebsiteSubscription.plan_type.charAt(0).toUpperCase() + __props.activeWebsiteSubscription.plan_type.slice(1))} Plan <span class="text-sm font-normal text-gray-600 dark:text-gray-400"${_scopeId}>(${ssrInterpolate(__props.activeWebsiteSubscription.formatted_amount)})</span></h4>`);
              _push2(ssrRenderComponent(_sfc_main$6, {
                variant: __props.activeWebsiteSubscription.verification_status === "verified" ? "success" : __props.activeWebsiteSubscription.verification_status === "pending" ? "warning" : "destructive"
              }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`${ssrInterpolate(__props.activeWebsiteSubscription.verification_status === "verified" ? "Verified" : __props.activeWebsiteSubscription.verification_status === "pending" ? "Pending" : "Rejected")}`);
                  } else {
                    return [
                      createTextVNode(toDisplayString(__props.activeWebsiteSubscription.verification_status === "verified" ? "Verified" : __props.activeWebsiteSubscription.verification_status === "pending" ? "Pending" : "Rejected"), 1)
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
              _push2(`</div>`);
              if (__props.activeWebsiteSubscription.verification_status === "pending") {
                _push2(ssrRenderComponent(_sfc_main$2, { class: "bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-200 px-3 py-2 rounded-lg mb-3" }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(`<i class="fas fa-clock mr-2 text-yellow-500"${_scopeId2}></i><div${_scopeId2}>`);
                      _push3(ssrRenderComponent(_sfc_main$4, { class: "text-sm font-medium" }, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            _push4(`অ্যাডমিনের অনুমোদনের অপেক্ষায়`);
                          } else {
                            return [
                              createTextVNode("অ্যাডমিনের অনুমোদনের অপেক্ষায়")
                            ];
                          }
                        }),
                        _: 1
                      }, _parent3, _scopeId2));
                      _push3(ssrRenderComponent(_sfc_main$3, { class: "text-xs" }, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            _push4(`আপনার সাবস্ক্রিপশন যাচাইকরণের পর আনলিমিটেড সার্চ সুবিধা পাবেন।`);
                          } else {
                            return [
                              createTextVNode("আপনার সাবস্ক্রিপশন যাচাইকরণের পর আনলিমিটেড সার্চ সুবিধা পাবেন।")
                            ];
                          }
                        }),
                        _: 1
                      }, _parent3, _scopeId2));
                      _push3(`</div>`);
                    } else {
                      return [
                        createVNode("i", { class: "fas fa-clock mr-2 text-yellow-500" }),
                        createVNode("div", null, [
                          createVNode(_sfc_main$4, { class: "text-sm font-medium" }, {
                            default: withCtx(() => [
                              createTextVNode("অ্যাডমিনের অনুমোদনের অপেক্ষায়")
                            ]),
                            _: 1
                          }),
                          createVNode(_sfc_main$3, { class: "text-xs" }, {
                            default: withCtx(() => [
                              createTextVNode("আপনার সাবস্ক্রিপশন যাচাইকরণের পর আনলিমিটেড সার্চ সুবিধা পাবেন।")
                            ]),
                            _: 1
                          })
                        ])
                      ];
                    }
                  }),
                  _: 1
                }, _parent2, _scopeId));
              } else {
                _push2(`<!---->`);
              }
              if (__props.activeWebsiteSubscription.verification_status === "rejected") {
                _push2(ssrRenderComponent(_sfc_main$2, { class: "bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-3 py-2 rounded-lg mb-3" }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(`<i class="fas fa-times-circle mr-2 text-red-500"${_scopeId2}></i><div${_scopeId2}>`);
                      _push3(ssrRenderComponent(_sfc_main$4, { class: "text-sm font-medium" }, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            _push4(`সাবস্ক্রিপশন প্রত্যাখ্যাত`);
                          } else {
                            return [
                              createTextVNode("সাবস্ক্রিপশন প্রত্যাখ্যাত")
                            ];
                          }
                        }),
                        _: 1
                      }, _parent3, _scopeId2));
                      if (__props.activeWebsiteSubscription.admin_notes) {
                        _push3(ssrRenderComponent(_sfc_main$3, { class: "text-xs" }, {
                          default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                            if (_push4) {
                              _push4(`কারণ: ${ssrInterpolate(__props.activeWebsiteSubscription.admin_notes)}`);
                            } else {
                              return [
                                createTextVNode("কারণ: " + toDisplayString(__props.activeWebsiteSubscription.admin_notes), 1)
                              ];
                            }
                          }),
                          _: 1
                        }, _parent3, _scopeId2));
                      } else {
                        _push3(`<!---->`);
                      }
                      _push3(`</div>`);
                    } else {
                      return [
                        createVNode("i", { class: "fas fa-times-circle mr-2 text-red-500" }),
                        createVNode("div", null, [
                          createVNode(_sfc_main$4, { class: "text-sm font-medium" }, {
                            default: withCtx(() => [
                              createTextVNode("সাবস্ক্রিপশন প্রত্যাখ্যাত")
                            ]),
                            _: 1
                          }),
                          __props.activeWebsiteSubscription.admin_notes ? (openBlock(), createBlock(_sfc_main$3, {
                            key: 0,
                            class: "text-xs"
                          }, {
                            default: withCtx(() => [
                              createTextVNode("কারণ: " + toDisplayString(__props.activeWebsiteSubscription.admin_notes), 1)
                            ]),
                            _: 1
                          })) : createCommentVNode("", true)
                        ])
                      ];
                    }
                  }),
                  _: 1
                }, _parent2, _scopeId));
              } else {
                _push2(`<!---->`);
              }
              _push2(`<div class="grid grid-cols-1 lg:grid-cols-2 gap-3 text-sm"${_scopeId}><div class="flex items-center"${_scopeId}><i class="fas fa-infinity text-indigo-500 mr-2 flex-shrink-0"${_scopeId}></i><span class="text-gray-600 dark:text-gray-400 mr-1"${_scopeId}>Website Searches:</span><span class="font-semibold text-gray-900 dark:text-white"${_scopeId}>${ssrInterpolate(__props.activeWebsiteSubscription.verification_status === "verified" ? "Unlimited" : "Pending Approval")}</span></div>`);
              if (__props.activeWebsiteSubscription.verification_status === "verified") {
                _push2(`<div class="flex items-center"${_scopeId}><i class="fas fa-calendar-alt text-indigo-500 mr-2 flex-shrink-0"${_scopeId}></i><span class="text-gray-600 dark:text-gray-400 mr-1"${_scopeId}>Expires:</span><span class="font-semibold text-gray-900 dark:text-white"${_scopeId}>${ssrInterpolate(__props.activeWebsiteSubscription.expires_at ? new Date(__props.activeWebsiteSubscription.expires_at).toLocaleDateString() : "Never")}</span></div>`);
              } else {
                _push2(`<!---->`);
              }
              _push2(`</div></div>`);
            } else {
              _push2(`<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4"${_scopeId}><div class="text-center"${_scopeId}><i class="fas fa-infinity text-indigo-400 dark:text-indigo-500 text-2xl mb-2"${_scopeId}></i><h4 class="font-medium text-gray-900 dark:text-white mb-1"${_scopeId}>Limited Website Access</h4><p class="text-gray-600 dark:text-gray-400 text-sm"${_scopeId}>Subscribe for unlimited website searches</p></div></div>`);
            }
            _push2(`</div></div>`);
          } else {
            return [
              createVNode("div", { class: "px-6 py-4 border-b border-gray-200 dark:border-gray-700" }, [
                createVNode("div", { class: "flex justify-between items-center" }, [
                  createVNode("div", null, [
                    createVNode("h2", { class: "text-xl font-semibold text-gray-900 dark:text-white" }, "Subscription Status"),
                    createVNode("p", { class: "text-sm text-gray-500 dark:text-gray-400 mt-1" }, "Your API and website subscription plans")
                  ]),
                  __props.activeSubscription || __props.activeWebsiteSubscription ? (openBlock(), createBlock(_sfc_main$6, {
                    key: 0,
                    variant: "success"
                  }, {
                    default: withCtx(() => [
                      createTextVNode(toDisplayString(__props.activeSubscription && __props.activeWebsiteSubscription ? "Both Active" : "Active"), 1)
                    ]),
                    _: 1
                  })) : createCommentVNode("", true)
                ])
              ]),
              createVNode("div", { class: "p-6 space-y-6" }, [
                createVNode("div", null, [
                  createVNode("h3", { class: "text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center" }, [
                    createVNode("i", { class: "fas fa-crown text-orange-500 mr-2" }),
                    createTextVNode(" API Subscription ")
                  ]),
                  __props.activeSubscription ? (openBlock(), createBlock("div", {
                    key: 0,
                    class: "bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 rounded-lg p-4"
                  }, [
                    createVNode("div", { class: "flex items-center justify-between mb-3" }, [
                      createVNode("h4", { class: "text-lg font-semibold text-gray-900 dark:text-white" }, toDisplayString(__props.activeSubscription.plan.name), 1),
                      createVNode(_sfc_main$6, { variant: "warning" }, {
                        default: withCtx(() => [
                          createTextVNode("Active")
                        ]),
                        _: 1
                      })
                    ]),
                    createVNode("p", { class: "text-gray-600 dark:text-gray-300 text-sm mb-3" }, toDisplayString(__props.activeSubscription.plan.description), 1),
                    createVNode("div", { class: "grid grid-cols-1 lg:grid-cols-2 gap-3 text-sm mb-4" }, [
                      createVNode("div", { class: "flex items-center" }, [
                        createVNode("i", { class: "fas fa-tachometer-alt text-orange-500 mr-2 flex-shrink-0" }),
                        createVNode("span", { class: "text-gray-600 dark:text-gray-400 mr-1" }, "Daily Limit:"),
                        createVNode("span", { class: "font-semibold text-gray-900 dark:text-white" }, toDisplayString(__props.activeSubscription.plan.request_limit.toLocaleString()) + " requests", 1)
                      ]),
                      createVNode("div", { class: "flex items-center" }, [
                        createVNode("i", { class: "fas fa-calendar-alt text-orange-500 mr-2 flex-shrink-0" }),
                        createVNode("span", { class: "text-gray-600 dark:text-gray-400 mr-1" }, "Expires:"),
                        createVNode("span", { class: "font-semibold text-gray-900 dark:text-white" }, toDisplayString(__props.activeSubscription.expires_at ? new Date(__props.activeSubscription.expires_at).toLocaleDateString() : "Never"), 1)
                      ]),
                      createVNode("div", { class: "flex items-center" }, [
                        createVNode("i", { class: "fas fa-clock text-orange-500 mr-2 flex-shrink-0" }),
                        createVNode("span", { class: "text-gray-600 dark:text-gray-400 mr-1" }, "Days Remaining:"),
                        createVNode("span", { class: "font-semibold text-gray-900 dark:text-white" }, toDisplayString(__props.activeSubscription.days_remaining), 1)
                      ]),
                      createVNode("div", { class: "flex items-center" }, [
                        createVNode("i", { class: "fas fa-chart-pie text-orange-500 mr-2 flex-shrink-0" }),
                        createVNode("span", { class: "text-gray-600 dark:text-gray-400 mr-1" }, "Usage Today:"),
                        createVNode("span", { class: "font-semibold text-gray-900 dark:text-white" }, toDisplayString(__props.todayUsage.toLocaleString()) + " / " + toDisplayString(__props.activeSubscription.plan.request_limit.toLocaleString()), 1)
                      ])
                    ]),
                    __props.activeSubscription.days_remaining < 7 && __props.activeSubscription.days_remaining > 0 ? (openBlock(), createBlock(_sfc_main$2, {
                      key: 0,
                      class: "bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-200 px-3 py-2 rounded-lg mb-3"
                    }, {
                      default: withCtx(() => [
                        createVNode("i", { class: "fas fa-exclamation-triangle mr-2 text-yellow-500" }),
                        createVNode(_sfc_main$3, { class: "text-sm" }, {
                          default: withCtx(() => [
                            createTextVNode("API subscription expires in " + toDisplayString(__props.activeSubscription.days_remaining) + " days", 1)
                          ]),
                          _: 1
                        })
                      ]),
                      _: 1
                    })) : createCommentVNode("", true),
                    createVNode("div", { class: "bg-gray-50 dark:bg-gray-700 rounded-lg p-3 mb-3" }, [
                      createVNode("div", { class: "flex justify-between items-center mb-2" }, [
                        createVNode("span", { class: "text-sm font-medium text-gray-700 dark:text-gray-300" }, "Today's API Usage"),
                        createVNode("span", { class: "text-sm text-gray-500 dark:text-gray-400" }, toDisplayString(__props.todayUsage.toLocaleString()) + " / " + toDisplayString(__props.activeSubscription.plan.request_limit.toLocaleString()), 1)
                      ]),
                      createVNode(_sfc_main$7, {
                        value: usagePercentage.value,
                        max: 100,
                        variant: usageColor.value
                      }, null, 8, ["value", "variant"])
                    ])
                  ])) : (openBlock(), createBlock("div", {
                    key: 1,
                    class: "bg-gray-50 dark:bg-gray-700 rounded-lg p-4"
                  }, [
                    createVNode("div", { class: "text-center" }, [
                      createVNode("i", { class: "fas fa-exclamation-circle text-orange-400 dark:text-orange-500 text-2xl mb-2" }),
                      createVNode("h4", { class: "font-medium text-gray-900 dark:text-white mb-1" }, "No API Subscription"),
                      createVNode("p", { class: "text-gray-600 dark:text-gray-400 text-sm" }, "Subscribe to access API services"),
                      createVNode(unref(link_default), {
                        href: "/pricing",
                        class: "mt-3 inline-block"
                      }, {
                        default: withCtx(() => [
                          createVNode(_sfc_main$1, { class: "bg-orange-500 hover:bg-orange-600 text-white" }, {
                            default: withCtx(() => [
                              createVNode("i", { class: "fas fa-crown mr-2" }),
                              createTextVNode("View Plans ")
                            ]),
                            _: 1
                          })
                        ]),
                        _: 1
                      })
                    ])
                  ]))
                ]),
                createVNode("div", { class: "border-t border-gray-200 dark:border-gray-700 pt-6" }, [
                  createVNode("h3", { class: "text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center" }, [
                    createVNode("i", { class: "fas fa-infinity text-indigo-500 mr-2" }),
                    createTextVNode(" Website Unlimited Search ")
                  ]),
                  __props.activeWebsiteSubscription ? (openBlock(), createBlock("div", {
                    key: 0,
                    class: "bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg p-4"
                  }, [
                    createVNode("div", { class: "flex items-center justify-between mb-3" }, [
                      createVNode("h4", { class: "text-lg font-semibold text-gray-900 dark:text-white" }, [
                        createTextVNode(toDisplayString(__props.activeWebsiteSubscription.plan_type.charAt(0).toUpperCase() + __props.activeWebsiteSubscription.plan_type.slice(1)) + " Plan ", 1),
                        createVNode("span", { class: "text-sm font-normal text-gray-600 dark:text-gray-400" }, "(" + toDisplayString(__props.activeWebsiteSubscription.formatted_amount) + ")", 1)
                      ]),
                      createVNode(_sfc_main$6, {
                        variant: __props.activeWebsiteSubscription.verification_status === "verified" ? "success" : __props.activeWebsiteSubscription.verification_status === "pending" ? "warning" : "destructive"
                      }, {
                        default: withCtx(() => [
                          createTextVNode(toDisplayString(__props.activeWebsiteSubscription.verification_status === "verified" ? "Verified" : __props.activeWebsiteSubscription.verification_status === "pending" ? "Pending" : "Rejected"), 1)
                        ]),
                        _: 1
                      }, 8, ["variant"])
                    ]),
                    __props.activeWebsiteSubscription.verification_status === "pending" ? (openBlock(), createBlock(_sfc_main$2, {
                      key: 0,
                      class: "bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-200 px-3 py-2 rounded-lg mb-3"
                    }, {
                      default: withCtx(() => [
                        createVNode("i", { class: "fas fa-clock mr-2 text-yellow-500" }),
                        createVNode("div", null, [
                          createVNode(_sfc_main$4, { class: "text-sm font-medium" }, {
                            default: withCtx(() => [
                              createTextVNode("অ্যাডমিনের অনুমোদনের অপেক্ষায়")
                            ]),
                            _: 1
                          }),
                          createVNode(_sfc_main$3, { class: "text-xs" }, {
                            default: withCtx(() => [
                              createTextVNode("আপনার সাবস্ক্রিপশন যাচাইকরণের পর আনলিমিটেড সার্চ সুবিধা পাবেন।")
                            ]),
                            _: 1
                          })
                        ])
                      ]),
                      _: 1
                    })) : createCommentVNode("", true),
                    __props.activeWebsiteSubscription.verification_status === "rejected" ? (openBlock(), createBlock(_sfc_main$2, {
                      key: 1,
                      class: "bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-3 py-2 rounded-lg mb-3"
                    }, {
                      default: withCtx(() => [
                        createVNode("i", { class: "fas fa-times-circle mr-2 text-red-500" }),
                        createVNode("div", null, [
                          createVNode(_sfc_main$4, { class: "text-sm font-medium" }, {
                            default: withCtx(() => [
                              createTextVNode("সাবস্ক্রিপশন প্রত্যাখ্যাত")
                            ]),
                            _: 1
                          }),
                          __props.activeWebsiteSubscription.admin_notes ? (openBlock(), createBlock(_sfc_main$3, {
                            key: 0,
                            class: "text-xs"
                          }, {
                            default: withCtx(() => [
                              createTextVNode("কারণ: " + toDisplayString(__props.activeWebsiteSubscription.admin_notes), 1)
                            ]),
                            _: 1
                          })) : createCommentVNode("", true)
                        ])
                      ]),
                      _: 1
                    })) : createCommentVNode("", true),
                    createVNode("div", { class: "grid grid-cols-1 lg:grid-cols-2 gap-3 text-sm" }, [
                      createVNode("div", { class: "flex items-center" }, [
                        createVNode("i", { class: "fas fa-infinity text-indigo-500 mr-2 flex-shrink-0" }),
                        createVNode("span", { class: "text-gray-600 dark:text-gray-400 mr-1" }, "Website Searches:"),
                        createVNode("span", { class: "font-semibold text-gray-900 dark:text-white" }, toDisplayString(__props.activeWebsiteSubscription.verification_status === "verified" ? "Unlimited" : "Pending Approval"), 1)
                      ]),
                      __props.activeWebsiteSubscription.verification_status === "verified" ? (openBlock(), createBlock("div", {
                        key: 0,
                        class: "flex items-center"
                      }, [
                        createVNode("i", { class: "fas fa-calendar-alt text-indigo-500 mr-2 flex-shrink-0" }),
                        createVNode("span", { class: "text-gray-600 dark:text-gray-400 mr-1" }, "Expires:"),
                        createVNode("span", { class: "font-semibold text-gray-900 dark:text-white" }, toDisplayString(__props.activeWebsiteSubscription.expires_at ? new Date(__props.activeWebsiteSubscription.expires_at).toLocaleDateString() : "Never"), 1)
                      ])) : createCommentVNode("", true)
                    ])
                  ])) : (openBlock(), createBlock("div", {
                    key: 1,
                    class: "bg-gray-50 dark:bg-gray-700 rounded-lg p-4"
                  }, [
                    createVNode("div", { class: "text-center" }, [
                      createVNode("i", { class: "fas fa-infinity text-indigo-400 dark:text-indigo-500 text-2xl mb-2" }),
                      createVNode("h4", { class: "font-medium text-gray-900 dark:text-white mb-1" }, "Limited Website Access"),
                      createVNode("p", { class: "text-gray-600 dark:text-gray-400 text-sm" }, "Subscribe for unlimited website searches")
                    ])
                  ]))
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div><div class="text-center mt-12">`);
      _push(ssrRenderComponent(unref(link_default), { href: "/" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(ssrRenderComponent(_sfc_main$1, {
              variant: "outline",
              class: "px-6 py-3"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<i class="fas fa-arrow-left mr-2"${_scopeId2}></i>Back to Home `);
                } else {
                  return [
                    createVNode("i", { class: "fas fa-arrow-left mr-2" }),
                    createTextVNode("Back to Home ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
          } else {
            return [
              createVNode(_sfc_main$1, {
                variant: "outline",
                class: "px-6 py-3"
              }, {
                default: withCtx(() => [
                  createVNode("i", { class: "fas fa-arrow-left mr-2" }),
                  createTextVNode("Back to Home ")
                ]),
                _: 1
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div></div></div><!--]-->`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Dashboard/Index.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
