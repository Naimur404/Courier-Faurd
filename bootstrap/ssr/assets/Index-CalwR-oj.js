import { defineComponent, computed, unref, withCtx, createVNode, createTextVNode, createBlock, createCommentVNode, openBlock, toDisplayString, Fragment, renderList, useSSRContext } from "vue";
import { ssrRenderComponent, ssrRenderList, ssrRenderClass, ssrInterpolate } from "vue/server-renderer";
import { a as usePage, h as head_default, l as link_default } from "../ssr.js";
import { _ as _sfc_main$1 } from "./AppLayout-BWjM9ngr.js";
import { _ as _sfc_main$2 } from "./Card-DfyUDDxC.js";
import { _ as _sfc_main$3 } from "./Button-Dm3W5gAW.js";
import "@vue/server-renderer";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
import "lucide-vue-next";
import "./utils-DvCvi0aN.js";
import "clsx";
import "tailwind-merge";
import "class-variance-authority";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Index",
  __ssrInlineRender: true,
  props: {
    plans: {}
  },
  setup(__props) {
    const page = usePage();
    const user = computed(() => {
      var _a;
      return (_a = page.props.auth) == null ? void 0 : _a.user;
    });
    const hasActiveSubscription = computed(() => {
      var _a;
      return ((_a = page.props.auth) == null ? void 0 : _a.hasActiveSubscription) ?? false;
    });
    const faqs = [
      {
        icon: "clock",
        iconColor: "blue",
        title: "How long does verification take?",
        answer: "Payment verification typically takes 2-24 hours during business hours. You'll receive an email confirmation once activated."
      },
      {
        icon: "arrow-up",
        iconColor: "green",
        title: "Can I upgrade my plan?",
        answer: "Yes, you can upgrade to a higher plan at any time. Contact support for assistance with plan changes and pro-rated billing."
      },
      {
        icon: "gift",
        iconColor: "purple",
        title: "Is there a free trial?",
        answer: "We offer a limited trial for new users with 100 free API calls. Contact our support team to request trial access."
      },
      {
        icon: "exclamation-triangle",
        iconColor: "orange",
        title: "What happens if I exceed my limit?",
        answer: "API requests will be rate-limited once you reach your daily quota. Consider upgrading for higher limits and priority support."
      }
    ];
    const copyToClipboard = (text) => {
      navigator.clipboard.writeText(text).then(() => {
        const toast = document.createElement("div");
        toast.className = "fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300";
        toast.innerHTML = '<i class="fas fa-check mr-2"></i>Number copied to clipboard!';
        document.body.appendChild(toast);
        setTimeout(() => {
          toast.classList.remove("translate-x-full");
        }, 100);
        setTimeout(() => {
          toast.classList.add("translate-x-full");
          setTimeout(() => {
            document.body.removeChild(toast);
          }, 300);
        }, 3e3);
      });
    };
    const getPlanGradient = (index) => {
      const gradients = [
        "from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700",
        "from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700",
        "from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700"
      ];
      return gradients[index] || gradients[0];
    };
    const getPlanIconGradient = (index) => {
      const gradients = [
        "from-green-400 to-emerald-500",
        "from-blue-500 to-indigo-600",
        "from-purple-500 to-pink-600"
      ];
      return gradients[index] || gradients[0];
    };
    const getPlanIcon = (index) => {
      const icons = ["fa-rocket", "fa-crown", "fa-gem"];
      return icons[index] || icons[0];
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(head_default), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title${_scopeId}>Pricing Plans - Courier Fraud</title><meta name="description" content="Choose the perfect plan for your business needs. All plans include comprehensive courier tracking API with real-time updates and 24/7 support."${_scopeId}><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, "Pricing Plans - Courier Fraud"),
              createVNode("meta", {
                name: "description",
                content: "Choose the perfect plan for your business needs. All plans include comprehensive courier tracking API with real-time updates and 24/7 support."
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
      _push(ssrRenderComponent(_sfc_main$1, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-12 sm:py-16"${_scopeId}><div class="container mx-auto px-4 sm:px-6 lg:px-8"${_scopeId}><div class="text-center mb-16"${_scopeId}><div class="inline-flex items-center justify-center p-2 bg-blue-100 rounded-full mb-6"${_scopeId}><i class="fas fa-crown text-blue-600 text-2xl"${_scopeId}></i></div><h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6"${_scopeId}> Choose Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600"${_scopeId}>Plan</span></h1><p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed"${_scopeId}> Select the perfect plan for your business needs. All plans include our comprehensive courier tracking API with real-time updates and 24/7 support. </p></div><div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-7xl mx-auto mb-16"${_scopeId}><!--[-->`);
            ssrRenderList(__props.plans, (plan, index) => {
              _push2(ssrRenderComponent(_sfc_main$2, {
                key: plan.id,
                class: [
                  "relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2",
                  index === 1 ? "ring-4 ring-blue-500 transform scale-105 lg:scale-110" : ""
                ]
              }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    if (index === 1) {
                      _push3(`<div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-center py-3"${_scopeId2}><span class="text-sm font-semibold"${_scopeId2}><i class="fas fa-star mr-1"${_scopeId2}></i>Most Popular </span></div>`);
                    } else {
                      _push3(`<!---->`);
                    }
                    _push3(`<div class="p-8"${_scopeId2}><div class="text-center"${_scopeId2}><div class="${ssrRenderClass(["inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r rounded-xl mb-6", getPlanIconGradient(index)])}"${_scopeId2}><i class="${ssrRenderClass(["fas text-white text-2xl", getPlanIcon(index)])}"${_scopeId2}></i></div><h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2"${_scopeId2}>${ssrInterpolate(plan.name)}</h3><p class="text-gray-600 dark:text-gray-300 mb-6"${_scopeId2}>${ssrInterpolate(plan.description)}</p><div class="mb-8"${_scopeId2}><span class="text-5xl font-bold text-gray-900 dark:text-white"${_scopeId2}>${ssrInterpolate(plan.formatted_price)}</span><span class="text-gray-500 text-lg"${_scopeId2}>/ ${ssrInterpolate(plan.duration_text)}</span></div></div><ul class="space-y-4 mb-8"${_scopeId2}><!--[-->`);
                    ssrRenderList(plan.features, (feature) => {
                      _push3(`<li class="flex items-start"${_scopeId2}><div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 mt-0.5"${_scopeId2}><i class="fas fa-check text-green-600 text-sm"${_scopeId2}></i></div><span class="text-gray-700 dark:text-gray-300 leading-relaxed"${_scopeId2}>${ssrInterpolate(feature)}</span></li>`);
                    });
                    _push3(`<!--]--></ul><div class="pt-4"${_scopeId2}>`);
                    if (user.value) {
                      _push3(`<!--[-->`);
                      if (hasActiveSubscription.value) {
                        _push3(`<button disabled class="w-full bg-gray-100 text-gray-500 py-4 px-6 rounded-xl font-semibold cursor-not-allowed border border-gray-200"${_scopeId2}><i class="fas fa-check-circle mr-2"${_scopeId2}></i>Already Subscribed </button>`);
                      } else {
                        _push3(ssrRenderComponent(unref(link_default), {
                          href: `/pricing/subscribe/${plan.id}`,
                          class: ["w-full bg-gradient-to-r text-white py-4 px-6 rounded-xl font-semibold block text-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1", getPlanGradient(index)]
                        }, {
                          default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                            if (_push4) {
                              _push4(`<i class="fas fa-arrow-right mr-2"${_scopeId3}></i>Subscribe Now `);
                            } else {
                              return [
                                createVNode("i", { class: "fas fa-arrow-right mr-2" }),
                                createTextVNode("Subscribe Now ")
                              ];
                            }
                          }),
                          _: 2
                        }, _parent3, _scopeId2));
                      }
                      _push3(`<!--]-->`);
                    } else {
                      _push3(ssrRenderComponent(unref(link_default), {
                        href: "/login",
                        class: ["w-full bg-gradient-to-r text-white py-4 px-6 rounded-xl font-semibold block text-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1", getPlanGradient(index)]
                      }, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            _push4(`<i class="fas fa-rocket mr-2"${_scopeId3}></i>Get Started `);
                          } else {
                            return [
                              createVNode("i", { class: "fas fa-rocket mr-2" }),
                              createTextVNode("Get Started ")
                            ];
                          }
                        }),
                        _: 2
                      }, _parent3, _scopeId2));
                    }
                    _push3(`</div></div>`);
                  } else {
                    return [
                      index === 1 ? (openBlock(), createBlock("div", {
                        key: 0,
                        class: "bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-center py-3"
                      }, [
                        createVNode("span", { class: "text-sm font-semibold" }, [
                          createVNode("i", { class: "fas fa-star mr-1" }),
                          createTextVNode("Most Popular ")
                        ])
                      ])) : createCommentVNode("", true),
                      createVNode("div", { class: "p-8" }, [
                        createVNode("div", { class: "text-center" }, [
                          createVNode("div", {
                            class: ["inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r rounded-xl mb-6", getPlanIconGradient(index)]
                          }, [
                            createVNode("i", {
                              class: ["fas text-white text-2xl", getPlanIcon(index)]
                            }, null, 2)
                          ], 2),
                          createVNode("h3", { class: "text-2xl font-bold text-gray-900 dark:text-white mb-2" }, toDisplayString(plan.name), 1),
                          createVNode("p", { class: "text-gray-600 dark:text-gray-300 mb-6" }, toDisplayString(plan.description), 1),
                          createVNode("div", { class: "mb-8" }, [
                            createVNode("span", { class: "text-5xl font-bold text-gray-900 dark:text-white" }, toDisplayString(plan.formatted_price), 1),
                            createVNode("span", { class: "text-gray-500 text-lg" }, "/ " + toDisplayString(plan.duration_text), 1)
                          ])
                        ]),
                        createVNode("ul", { class: "space-y-4 mb-8" }, [
                          (openBlock(true), createBlock(Fragment, null, renderList(plan.features, (feature) => {
                            return openBlock(), createBlock("li", {
                              key: feature,
                              class: "flex items-start"
                            }, [
                              createVNode("div", { class: "flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 mt-0.5" }, [
                                createVNode("i", { class: "fas fa-check text-green-600 text-sm" })
                              ]),
                              createVNode("span", { class: "text-gray-700 dark:text-gray-300 leading-relaxed" }, toDisplayString(feature), 1)
                            ]);
                          }), 128))
                        ]),
                        createVNode("div", { class: "pt-4" }, [
                          user.value ? (openBlock(), createBlock(Fragment, { key: 0 }, [
                            hasActiveSubscription.value ? (openBlock(), createBlock("button", {
                              key: 0,
                              disabled: "",
                              class: "w-full bg-gray-100 text-gray-500 py-4 px-6 rounded-xl font-semibold cursor-not-allowed border border-gray-200"
                            }, [
                              createVNode("i", { class: "fas fa-check-circle mr-2" }),
                              createTextVNode("Already Subscribed ")
                            ])) : (openBlock(), createBlock(unref(link_default), {
                              key: 1,
                              href: `/pricing/subscribe/${plan.id}`,
                              class: ["w-full bg-gradient-to-r text-white py-4 px-6 rounded-xl font-semibold block text-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1", getPlanGradient(index)]
                            }, {
                              default: withCtx(() => [
                                createVNode("i", { class: "fas fa-arrow-right mr-2" }),
                                createTextVNode("Subscribe Now ")
                              ]),
                              _: 1
                            }, 8, ["href", "class"]))
                          ], 64)) : (openBlock(), createBlock(unref(link_default), {
                            key: 1,
                            href: "/login",
                            class: ["w-full bg-gradient-to-r text-white py-4 px-6 rounded-xl font-semibold block text-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1", getPlanGradient(index)]
                          }, {
                            default: withCtx(() => [
                              createVNode("i", { class: "fas fa-rocket mr-2" }),
                              createTextVNode("Get Started ")
                            ]),
                            _: 1
                          }, 8, ["class"]))
                        ])
                      ])
                    ];
                  }
                }),
                _: 2
              }, _parent2, _scopeId));
            });
            _push2(`<!--]--></div>`);
            _push2(ssrRenderComponent(_sfc_main$2, { class: "p-8 sm:p-12 max-w-6xl mx-auto mb-16" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<div class="text-center mb-12"${_scopeId2}><div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-pink-500 to-rose-500 rounded-xl mb-4"${_scopeId2}><i class="fas fa-credit-card text-white text-2xl"${_scopeId2}></i></div><h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4"${_scopeId2}>Payment Information</h2><p class="text-gray-600 dark:text-gray-300"${_scopeId2}>Simple and secure payment process with instant activation</p></div><div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12"${_scopeId2}><div${_scopeId2}><h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center"${_scopeId2}><div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3"${_scopeId2}><i class="fas fa-mobile-alt text-pink-600"${_scopeId2}></i></div> Bkash Payment </h3><div class="bg-gradient-to-r from-pink-50 to-rose-50 border-2 border-pink-200 rounded-xl p-6"${_scopeId2}><div class="text-center"${_scopeId2}><p class="text-gray-700 mb-3 font-medium"${_scopeId2}>Send money to:</p><div class="bg-white rounded-lg p-4 mb-4 shadow-sm"${_scopeId2}><p class="text-3xl font-bold text-pink-600 mb-2"${_scopeId2}>01309092748</p><button class="text-sm text-pink-600 hover:text-pink-700 font-medium"${_scopeId2}><i class="fas fa-copy mr-1"${_scopeId2}></i>Copy Number </button></div><div class="bg-pink-100 rounded-lg p-4"${_scopeId2}><p class="text-sm text-pink-800 font-medium"${_scopeId2}><i class="fas fa-info-circle mr-2"${_scopeId2}></i> Send money and provide the transaction ID during subscription. </p></div></div></div></div><div${_scopeId2}><h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center"${_scopeId2}><div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3"${_scopeId2}><i class="fas fa-clock text-blue-600"${_scopeId2}></i></div> Process Timeline </h3><div class="space-y-4"${_scopeId2}><div class="flex items-start"${_scopeId2}><div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4"${_scopeId2}> 1 </div><div class="pt-1"${_scopeId2}><p class="text-gray-900 dark:text-white font-medium"${_scopeId2}>Choose Plan &amp; Payment</p><p class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId2}>Select your plan and complete Bkash payment</p></div></div><div class="flex items-start"${_scopeId2}><div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4"${_scopeId2}> 2 </div><div class="pt-1"${_scopeId2}><p class="text-gray-900 dark:text-white font-medium"${_scopeId2}>Submit Transaction ID</p><p class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId2}>Provide your Bkash transaction ID</p></div></div><div class="flex items-start"${_scopeId2}><div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4"${_scopeId2}> 3 </div><div class="pt-1"${_scopeId2}><p class="text-gray-900 dark:text-white font-medium"${_scopeId2}>Payment Verification</p><p class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId2}>We verify within 2-24 hours</p></div></div><div class="flex items-start"${_scopeId2}><div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4"${_scopeId2}><i class="fas fa-check text-sm"${_scopeId2}></i></div><div class="pt-1"${_scopeId2}><p class="text-gray-900 dark:text-white font-medium"${_scopeId2}>Subscription Active</p><p class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId2}>Start using API immediately</p></div></div></div></div></div>`);
                } else {
                  return [
                    createVNode("div", { class: "text-center mb-12" }, [
                      createVNode("div", { class: "inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-pink-500 to-rose-500 rounded-xl mb-4" }, [
                        createVNode("i", { class: "fas fa-credit-card text-white text-2xl" })
                      ]),
                      createVNode("h2", { class: "text-3xl font-bold text-gray-900 dark:text-white mb-4" }, "Payment Information"),
                      createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "Simple and secure payment process with instant activation")
                    ]),
                    createVNode("div", { class: "grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12" }, [
                      createVNode("div", null, [
                        createVNode("h3", { class: "text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center" }, [
                          createVNode("div", { class: "w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3" }, [
                            createVNode("i", { class: "fas fa-mobile-alt text-pink-600" })
                          ]),
                          createTextVNode(" Bkash Payment ")
                        ]),
                        createVNode("div", { class: "bg-gradient-to-r from-pink-50 to-rose-50 border-2 border-pink-200 rounded-xl p-6" }, [
                          createVNode("div", { class: "text-center" }, [
                            createVNode("p", { class: "text-gray-700 mb-3 font-medium" }, "Send money to:"),
                            createVNode("div", { class: "bg-white rounded-lg p-4 mb-4 shadow-sm" }, [
                              createVNode("p", { class: "text-3xl font-bold text-pink-600 mb-2" }, "01309092748"),
                              createVNode("button", {
                                onClick: ($event) => copyToClipboard("01309092748"),
                                class: "text-sm text-pink-600 hover:text-pink-700 font-medium"
                              }, [
                                createVNode("i", { class: "fas fa-copy mr-1" }),
                                createTextVNode("Copy Number ")
                              ], 8, ["onClick"])
                            ]),
                            createVNode("div", { class: "bg-pink-100 rounded-lg p-4" }, [
                              createVNode("p", { class: "text-sm text-pink-800 font-medium" }, [
                                createVNode("i", { class: "fas fa-info-circle mr-2" }),
                                createTextVNode(" Send money and provide the transaction ID during subscription. ")
                              ])
                            ])
                          ])
                        ])
                      ]),
                      createVNode("div", null, [
                        createVNode("h3", { class: "text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center" }, [
                          createVNode("div", { class: "w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3" }, [
                            createVNode("i", { class: "fas fa-clock text-blue-600" })
                          ]),
                          createTextVNode(" Process Timeline ")
                        ]),
                        createVNode("div", { class: "space-y-4" }, [
                          createVNode("div", { class: "flex items-start" }, [
                            createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4" }, " 1 "),
                            createVNode("div", { class: "pt-1" }, [
                              createVNode("p", { class: "text-gray-900 dark:text-white font-medium" }, "Choose Plan & Payment"),
                              createVNode("p", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "Select your plan and complete Bkash payment")
                            ])
                          ]),
                          createVNode("div", { class: "flex items-start" }, [
                            createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4" }, " 2 "),
                            createVNode("div", { class: "pt-1" }, [
                              createVNode("p", { class: "text-gray-900 dark:text-white font-medium" }, "Submit Transaction ID"),
                              createVNode("p", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "Provide your Bkash transaction ID")
                            ])
                          ]),
                          createVNode("div", { class: "flex items-start" }, [
                            createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4" }, " 3 "),
                            createVNode("div", { class: "pt-1" }, [
                              createVNode("p", { class: "text-gray-900 dark:text-white font-medium" }, "Payment Verification"),
                              createVNode("p", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "We verify within 2-24 hours")
                            ])
                          ]),
                          createVNode("div", { class: "flex items-start" }, [
                            createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4" }, [
                              createVNode("i", { class: "fas fa-check text-sm" })
                            ]),
                            createVNode("div", { class: "pt-1" }, [
                              createVNode("p", { class: "text-gray-900 dark:text-white font-medium" }, "Subscription Active"),
                              createVNode("p", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "Start using API immediately")
                            ])
                          ])
                        ])
                      ])
                    ])
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`<div class="max-w-6xl mx-auto"${_scopeId}><div class="text-center mb-12"${_scopeId}><div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl mb-4"${_scopeId}><i class="fas fa-question-circle text-white text-2xl"${_scopeId}></i></div><h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4"${_scopeId}>Frequently Asked Questions</h2><p class="text-gray-600 dark:text-gray-300"${_scopeId}>Everything you need to know about our plans and services</p></div><div class="grid grid-cols-1 lg:grid-cols-2 gap-8"${_scopeId}><!--[-->`);
            ssrRenderList(faqs, (faq) => {
              _push2(ssrRenderComponent(_sfc_main$2, {
                key: faq.title,
                class: "p-8 hover:shadow-xl transition-shadow duration-300"
              }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`<div class="flex items-start"${_scopeId2}><div class="${ssrRenderClass(["flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center mr-4", `bg-${faq.iconColor}-100`])}"${_scopeId2}><i class="${ssrRenderClass(["fas", `fa-${faq.icon}`, `text-${faq.iconColor}-600`])}"${_scopeId2}></i></div><div${_scopeId2}><h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3"${_scopeId2}>${ssrInterpolate(faq.title)}</h3><p class="text-gray-600 dark:text-gray-300 leading-relaxed"${_scopeId2}>${ssrInterpolate(faq.answer)}</p></div></div>`);
                  } else {
                    return [
                      createVNode("div", { class: "flex items-start" }, [
                        createVNode("div", {
                          class: ["flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center mr-4", `bg-${faq.iconColor}-100`]
                        }, [
                          createVNode("i", {
                            class: ["fas", `fa-${faq.icon}`, `text-${faq.iconColor}-600`]
                          }, null, 2)
                        ], 2),
                        createVNode("div", null, [
                          createVNode("h3", { class: "text-lg font-semibold text-gray-900 dark:text-white mb-3" }, toDisplayString(faq.title), 1),
                          createVNode("p", { class: "text-gray-600 dark:text-gray-300 leading-relaxed" }, toDisplayString(faq.answer), 1)
                        ])
                      ])
                    ];
                  }
                }),
                _: 2
              }, _parent2, _scopeId));
            });
            _push2(`<!--]--></div></div><div class="text-center mt-12"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(link_default), { href: "/" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(ssrRenderComponent(_sfc_main$3, {
                    variant: "outline",
                    class: "px-6 py-3"
                  }, {
                    default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                      if (_push4) {
                        _push4(`<i class="fas fa-arrow-left mr-2"${_scopeId3}></i>Back to Home `);
                      } else {
                        return [
                          createVNode("i", { class: "fas fa-arrow-left mr-2" }),
                          createTextVNode("Back to Home ")
                        ];
                      }
                    }),
                    _: 1
                  }, _parent3, _scopeId2));
                } else {
                  return [
                    createVNode(_sfc_main$3, {
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
            }, _parent2, _scopeId));
            _push2(`</div></div></div>`);
          } else {
            return [
              createVNode("div", { class: "min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-12 sm:py-16" }, [
                createVNode("div", { class: "container mx-auto px-4 sm:px-6 lg:px-8" }, [
                  createVNode("div", { class: "text-center mb-16" }, [
                    createVNode("div", { class: "inline-flex items-center justify-center p-2 bg-blue-100 rounded-full mb-6" }, [
                      createVNode("i", { class: "fas fa-crown text-blue-600 text-2xl" })
                    ]),
                    createVNode("h1", { class: "text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6" }, [
                      createTextVNode(" Choose Your "),
                      createVNode("span", { class: "text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600" }, "Plan")
                    ]),
                    createVNode("p", { class: "text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed" }, " Select the perfect plan for your business needs. All plans include our comprehensive courier tracking API with real-time updates and 24/7 support. ")
                  ]),
                  createVNode("div", { class: "grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-7xl mx-auto mb-16" }, [
                    (openBlock(true), createBlock(Fragment, null, renderList(__props.plans, (plan, index) => {
                      return openBlock(), createBlock(_sfc_main$2, {
                        key: plan.id,
                        class: [
                          "relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2",
                          index === 1 ? "ring-4 ring-blue-500 transform scale-105 lg:scale-110" : ""
                        ]
                      }, {
                        default: withCtx(() => [
                          index === 1 ? (openBlock(), createBlock("div", {
                            key: 0,
                            class: "bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-center py-3"
                          }, [
                            createVNode("span", { class: "text-sm font-semibold" }, [
                              createVNode("i", { class: "fas fa-star mr-1" }),
                              createTextVNode("Most Popular ")
                            ])
                          ])) : createCommentVNode("", true),
                          createVNode("div", { class: "p-8" }, [
                            createVNode("div", { class: "text-center" }, [
                              createVNode("div", {
                                class: ["inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r rounded-xl mb-6", getPlanIconGradient(index)]
                              }, [
                                createVNode("i", {
                                  class: ["fas text-white text-2xl", getPlanIcon(index)]
                                }, null, 2)
                              ], 2),
                              createVNode("h3", { class: "text-2xl font-bold text-gray-900 dark:text-white mb-2" }, toDisplayString(plan.name), 1),
                              createVNode("p", { class: "text-gray-600 dark:text-gray-300 mb-6" }, toDisplayString(plan.description), 1),
                              createVNode("div", { class: "mb-8" }, [
                                createVNode("span", { class: "text-5xl font-bold text-gray-900 dark:text-white" }, toDisplayString(plan.formatted_price), 1),
                                createVNode("span", { class: "text-gray-500 text-lg" }, "/ " + toDisplayString(plan.duration_text), 1)
                              ])
                            ]),
                            createVNode("ul", { class: "space-y-4 mb-8" }, [
                              (openBlock(true), createBlock(Fragment, null, renderList(plan.features, (feature) => {
                                return openBlock(), createBlock("li", {
                                  key: feature,
                                  class: "flex items-start"
                                }, [
                                  createVNode("div", { class: "flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 mt-0.5" }, [
                                    createVNode("i", { class: "fas fa-check text-green-600 text-sm" })
                                  ]),
                                  createVNode("span", { class: "text-gray-700 dark:text-gray-300 leading-relaxed" }, toDisplayString(feature), 1)
                                ]);
                              }), 128))
                            ]),
                            createVNode("div", { class: "pt-4" }, [
                              user.value ? (openBlock(), createBlock(Fragment, { key: 0 }, [
                                hasActiveSubscription.value ? (openBlock(), createBlock("button", {
                                  key: 0,
                                  disabled: "",
                                  class: "w-full bg-gray-100 text-gray-500 py-4 px-6 rounded-xl font-semibold cursor-not-allowed border border-gray-200"
                                }, [
                                  createVNode("i", { class: "fas fa-check-circle mr-2" }),
                                  createTextVNode("Already Subscribed ")
                                ])) : (openBlock(), createBlock(unref(link_default), {
                                  key: 1,
                                  href: `/pricing/subscribe/${plan.id}`,
                                  class: ["w-full bg-gradient-to-r text-white py-4 px-6 rounded-xl font-semibold block text-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1", getPlanGradient(index)]
                                }, {
                                  default: withCtx(() => [
                                    createVNode("i", { class: "fas fa-arrow-right mr-2" }),
                                    createTextVNode("Subscribe Now ")
                                  ]),
                                  _: 1
                                }, 8, ["href", "class"]))
                              ], 64)) : (openBlock(), createBlock(unref(link_default), {
                                key: 1,
                                href: "/login",
                                class: ["w-full bg-gradient-to-r text-white py-4 px-6 rounded-xl font-semibold block text-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1", getPlanGradient(index)]
                              }, {
                                default: withCtx(() => [
                                  createVNode("i", { class: "fas fa-rocket mr-2" }),
                                  createTextVNode("Get Started ")
                                ]),
                                _: 1
                              }, 8, ["class"]))
                            ])
                          ])
                        ]),
                        _: 2
                      }, 1032, ["class"]);
                    }), 128))
                  ]),
                  createVNode(_sfc_main$2, { class: "p-8 sm:p-12 max-w-6xl mx-auto mb-16" }, {
                    default: withCtx(() => [
                      createVNode("div", { class: "text-center mb-12" }, [
                        createVNode("div", { class: "inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-pink-500 to-rose-500 rounded-xl mb-4" }, [
                          createVNode("i", { class: "fas fa-credit-card text-white text-2xl" })
                        ]),
                        createVNode("h2", { class: "text-3xl font-bold text-gray-900 dark:text-white mb-4" }, "Payment Information"),
                        createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "Simple and secure payment process with instant activation")
                      ]),
                      createVNode("div", { class: "grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12" }, [
                        createVNode("div", null, [
                          createVNode("h3", { class: "text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center" }, [
                            createVNode("div", { class: "w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3" }, [
                              createVNode("i", { class: "fas fa-mobile-alt text-pink-600" })
                            ]),
                            createTextVNode(" Bkash Payment ")
                          ]),
                          createVNode("div", { class: "bg-gradient-to-r from-pink-50 to-rose-50 border-2 border-pink-200 rounded-xl p-6" }, [
                            createVNode("div", { class: "text-center" }, [
                              createVNode("p", { class: "text-gray-700 mb-3 font-medium" }, "Send money to:"),
                              createVNode("div", { class: "bg-white rounded-lg p-4 mb-4 shadow-sm" }, [
                                createVNode("p", { class: "text-3xl font-bold text-pink-600 mb-2" }, "01309092748"),
                                createVNode("button", {
                                  onClick: ($event) => copyToClipboard("01309092748"),
                                  class: "text-sm text-pink-600 hover:text-pink-700 font-medium"
                                }, [
                                  createVNode("i", { class: "fas fa-copy mr-1" }),
                                  createTextVNode("Copy Number ")
                                ], 8, ["onClick"])
                              ]),
                              createVNode("div", { class: "bg-pink-100 rounded-lg p-4" }, [
                                createVNode("p", { class: "text-sm text-pink-800 font-medium" }, [
                                  createVNode("i", { class: "fas fa-info-circle mr-2" }),
                                  createTextVNode(" Send money and provide the transaction ID during subscription. ")
                                ])
                              ])
                            ])
                          ])
                        ]),
                        createVNode("div", null, [
                          createVNode("h3", { class: "text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center" }, [
                            createVNode("div", { class: "w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3" }, [
                              createVNode("i", { class: "fas fa-clock text-blue-600" })
                            ]),
                            createTextVNode(" Process Timeline ")
                          ]),
                          createVNode("div", { class: "space-y-4" }, [
                            createVNode("div", { class: "flex items-start" }, [
                              createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4" }, " 1 "),
                              createVNode("div", { class: "pt-1" }, [
                                createVNode("p", { class: "text-gray-900 dark:text-white font-medium" }, "Choose Plan & Payment"),
                                createVNode("p", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "Select your plan and complete Bkash payment")
                              ])
                            ]),
                            createVNode("div", { class: "flex items-start" }, [
                              createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4" }, " 2 "),
                              createVNode("div", { class: "pt-1" }, [
                                createVNode("p", { class: "text-gray-900 dark:text-white font-medium" }, "Submit Transaction ID"),
                                createVNode("p", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "Provide your Bkash transaction ID")
                              ])
                            ]),
                            createVNode("div", { class: "flex items-start" }, [
                              createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4" }, " 3 "),
                              createVNode("div", { class: "pt-1" }, [
                                createVNode("p", { class: "text-gray-900 dark:text-white font-medium" }, "Payment Verification"),
                                createVNode("p", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "We verify within 2-24 hours")
                              ])
                            ]),
                            createVNode("div", { class: "flex items-start" }, [
                              createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4" }, [
                                createVNode("i", { class: "fas fa-check text-sm" })
                              ]),
                              createVNode("div", { class: "pt-1" }, [
                                createVNode("p", { class: "text-gray-900 dark:text-white font-medium" }, "Subscription Active"),
                                createVNode("p", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "Start using API immediately")
                              ])
                            ])
                          ])
                        ])
                      ])
                    ]),
                    _: 1
                  }),
                  createVNode("div", { class: "max-w-6xl mx-auto" }, [
                    createVNode("div", { class: "text-center mb-12" }, [
                      createVNode("div", { class: "inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl mb-4" }, [
                        createVNode("i", { class: "fas fa-question-circle text-white text-2xl" })
                      ]),
                      createVNode("h2", { class: "text-3xl font-bold text-gray-900 dark:text-white mb-4" }, "Frequently Asked Questions"),
                      createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "Everything you need to know about our plans and services")
                    ]),
                    createVNode("div", { class: "grid grid-cols-1 lg:grid-cols-2 gap-8" }, [
                      (openBlock(), createBlock(Fragment, null, renderList(faqs, (faq) => {
                        return createVNode(_sfc_main$2, {
                          key: faq.title,
                          class: "p-8 hover:shadow-xl transition-shadow duration-300"
                        }, {
                          default: withCtx(() => [
                            createVNode("div", { class: "flex items-start" }, [
                              createVNode("div", {
                                class: ["flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center mr-4", `bg-${faq.iconColor}-100`]
                              }, [
                                createVNode("i", {
                                  class: ["fas", `fa-${faq.icon}`, `text-${faq.iconColor}-600`]
                                }, null, 2)
                              ], 2),
                              createVNode("div", null, [
                                createVNode("h3", { class: "text-lg font-semibold text-gray-900 dark:text-white mb-3" }, toDisplayString(faq.title), 1),
                                createVNode("p", { class: "text-gray-600 dark:text-gray-300 leading-relaxed" }, toDisplayString(faq.answer), 1)
                              ])
                            ])
                          ]),
                          _: 2
                        }, 1024);
                      }), 64))
                    ])
                  ]),
                  createVNode("div", { class: "text-center mt-12" }, [
                    createVNode(unref(link_default), { href: "/" }, {
                      default: withCtx(() => [
                        createVNode(_sfc_main$3, {
                          variant: "outline",
                          class: "px-6 py-3"
                        }, {
                          default: withCtx(() => [
                            createVNode("i", { class: "fas fa-arrow-left mr-2" }),
                            createTextVNode("Back to Home ")
                          ]),
                          _: 1
                        })
                      ]),
                      _: 1
                    })
                  ])
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<!--]-->`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Pricing/Index.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
