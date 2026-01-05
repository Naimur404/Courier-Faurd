import { defineComponent, mergeProps, unref, useSSRContext, ref, withCtx, createVNode, toDisplayString, createTextVNode, createBlock, openBlock, Fragment, renderList, withModifiers, withDirectives, vModelSelect, createCommentVNode, vModelCheckbox, Teleport, Transition } from "vue";
import { ssrRenderAttrs, ssrRenderSlot, ssrRenderComponent, ssrInterpolate, ssrRenderTeleport, ssrRenderClass, ssrRenderList, ssrIncludeBooleanAttr, ssrLooseContain, ssrLooseEqual } from "vue/server-renderer";
import { u as useForm, h as head_default, l as link_default } from "../ssr.js";
import { _ as _sfc_main$7 } from "./AppLayout-B7Gogr1C.js";
import { c as cn } from "./utils-DvCvi0aN.js";
import { _ as _sfc_main$9 } from "./Input-pArGf6iX.js";
import { _ as _sfc_main$8 } from "./Label-Cl3p6AAe.js";
import "@vue/server-renderer";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
import "lucide-vue-next";
import "clsx";
import "tailwind-merge";
const _sfc_main$6 = /* @__PURE__ */ defineComponent({
  __name: "Card",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({
        class: unref(cn)("rounded-xl border border-border bg-card text-card-foreground shadow-sm", props.class)
      }, _attrs))}>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</div>`);
    };
  }
});
const _sfc_setup$6 = _sfc_main$6.setup;
_sfc_main$6.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/card/Card.vue");
  return _sfc_setup$6 ? _sfc_setup$6(props, ctx) : void 0;
};
const _sfc_main$5 = /* @__PURE__ */ defineComponent({
  __name: "CardHeader",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({
        class: unref(cn)("flex flex-col space-y-1.5 p-6", props.class)
      }, _attrs))}>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</div>`);
    };
  }
});
const _sfc_setup$5 = _sfc_main$5.setup;
_sfc_main$5.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/card/CardHeader.vue");
  return _sfc_setup$5 ? _sfc_setup$5(props, ctx) : void 0;
};
const _sfc_main$4 = /* @__PURE__ */ defineComponent({
  __name: "CardTitle",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<h3${ssrRenderAttrs(mergeProps({
        class: unref(cn)("text-2xl font-semibold leading-none tracking-tight", props.class)
      }, _attrs))}>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</h3>`);
    };
  }
});
const _sfc_setup$4 = _sfc_main$4.setup;
_sfc_main$4.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/card/CardTitle.vue");
  return _sfc_setup$4 ? _sfc_setup$4(props, ctx) : void 0;
};
const _sfc_main$3 = /* @__PURE__ */ defineComponent({
  __name: "CardDescription",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<p${ssrRenderAttrs(mergeProps({
        class: unref(cn)("text-sm text-muted-foreground", props.class)
      }, _attrs))}>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</p>`);
    };
  }
});
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/card/CardDescription.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const _sfc_main$2 = /* @__PURE__ */ defineComponent({
  __name: "CardContent",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({
        class: unref(cn)("p-6 pt-0", props.class)
      }, _attrs))}>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</div>`);
    };
  }
});
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/card/CardContent.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const _sfc_main$1 = /* @__PURE__ */ defineComponent({
  __name: "CardFooter",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({
        class: unref(cn)("flex items-center p-6 pt-0", props.class)
      }, _attrs))}>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</div>`);
    };
  }
});
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/card/CardFooter.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Subscribe",
  __ssrInlineRender: true,
  props: {
    plan: {}
  },
  setup(__props) {
    const props = __props;
    const form = useForm({
      payment_method: "bkash",
      transaction_id: "",
      terms: false
    });
    const notification = ref({
      show: false,
      message: "",
      type: "success"
    });
    function showNotification(message, type = "success") {
      notification.value = { show: true, message, type };
      setTimeout(() => {
        notification.value.show = false;
      }, 3e3);
    }
    function copyNumber() {
      const number = "01309092748";
      navigator.clipboard.writeText(number).then(() => {
        showNotification("Number copied to clipboard!", "success");
      }).catch(() => {
        const textArea = document.createElement("textarea");
        textArea.value = number;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("copy");
        document.body.removeChild(textArea);
        showNotification("Number copied to clipboard!", "success");
      });
    }
    function submit() {
      if (!form.terms) {
        showNotification("Please confirm the payment and agree to terms", "error");
        return;
      }
      form.post(`/pricing/subscribe/${props.plan.id}`);
    }
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(head_default), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title${_scopeId}>Subscribe to ${ssrInterpolate(__props.plan.name)} - Courier Fraud</title><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, "Subscribe to " + toDisplayString(__props.plan.name) + " - Courier Fraud", 1),
              createVNode("link", {
                rel: "stylesheet",
                href: "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$7, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            ssrRenderTeleport(_push2, (_push3) => {
              if (notification.value.show) {
                _push3(`<div class="${ssrRenderClass([
                  "fixed top-4 right-4 z-50 px-4 py-3 rounded-xl shadow-lg text-white",
                  notification.value.type === "success" ? "bg-green-500" : "bg-red-500"
                ])}"${_scopeId}><i class="${ssrRenderClass(notification.value.type === "success" ? "fas fa-check mr-2" : "fas fa-exclamation-circle mr-2")}"${_scopeId}></i> ${ssrInterpolate(notification.value.message)}</div>`);
              } else {
                _push3(`<!---->`);
              }
            }, "body", false, _parent2);
            _push2(`<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8 sm:py-12"${_scopeId}><div class="container mx-auto px-4 sm:px-6 lg:px-8"${_scopeId}><div class="max-w-4xl mx-auto"${_scopeId}><div class="text-center mb-8"${_scopeId}><div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl mb-4"${_scopeId}><i class="fas fa-credit-card text-white text-lg"${_scopeId}></i></div><h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2"${_scopeId}> Subscribe to <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600"${_scopeId}>${ssrInterpolate(__props.plan.name)}</span></h1><p class="text-sm text-gray-600 dark:text-gray-400 max-w-xl mx-auto"${_scopeId}> Complete your subscription with secure manual payment verification </p></div><div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6"${_scopeId}><div class="lg:col-span-1"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(_sfc_main$6), { class: "overflow-hidden" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-4"${_scopeId2}><div class="text-center"${_scopeId2}><div class="inline-flex items-center justify-center w-10 h-10 bg-white/20 rounded-lg mb-3"${_scopeId2}><i class="fas fa-crown text-white"${_scopeId2}></i></div><h2 class="text-lg font-bold mb-1"${_scopeId2}>${ssrInterpolate(__props.plan.name)}</h2><p class="text-blue-100 text-xs"${_scopeId2}>${ssrInterpolate(__props.plan.description)}</p></div></div><div class="p-4"${_scopeId2}><div class="text-center mb-4"${_scopeId2}><div class="text-3xl font-bold text-gray-900 dark:text-white"${_scopeId2}>${ssrInterpolate(__props.plan.formatted_price)}</div><div class="text-sm text-gray-500 dark:text-gray-400"${_scopeId2}>for ${ssrInterpolate(__props.plan.duration_text)}</div></div><div${_scopeId2}><h3 class="font-medium text-gray-900 dark:text-white mb-3 flex items-center text-sm"${_scopeId2}><i class="fas fa-check-circle text-green-500 mr-2"${_scopeId2}></i> What&#39;s included: </h3><ul class="space-y-2"${_scopeId2}><!--[-->`);
                  ssrRenderList(__props.plan.features, (feature) => {
                    _push3(`<li class="flex items-start text-gray-700 dark:text-gray-300"${_scopeId2}><div class="flex-shrink-0 w-4 h-4 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-2 mt-0.5"${_scopeId2}><i class="fas fa-check text-green-600 dark:text-green-400 text-[8px]"${_scopeId2}></i></div><span class="text-xs leading-relaxed"${_scopeId2}>${ssrInterpolate(feature)}</span></li>`);
                  });
                  _push3(`<!--]--></ul></div></div>`);
                } else {
                  return [
                    createVNode("div", { class: "bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-4" }, [
                      createVNode("div", { class: "text-center" }, [
                        createVNode("div", { class: "inline-flex items-center justify-center w-10 h-10 bg-white/20 rounded-lg mb-3" }, [
                          createVNode("i", { class: "fas fa-crown text-white" })
                        ]),
                        createVNode("h2", { class: "text-lg font-bold mb-1" }, toDisplayString(__props.plan.name), 1),
                        createVNode("p", { class: "text-blue-100 text-xs" }, toDisplayString(__props.plan.description), 1)
                      ])
                    ]),
                    createVNode("div", { class: "p-4" }, [
                      createVNode("div", { class: "text-center mb-4" }, [
                        createVNode("div", { class: "text-3xl font-bold text-gray-900 dark:text-white" }, toDisplayString(__props.plan.formatted_price), 1),
                        createVNode("div", { class: "text-sm text-gray-500 dark:text-gray-400" }, "for " + toDisplayString(__props.plan.duration_text), 1)
                      ]),
                      createVNode("div", null, [
                        createVNode("h3", { class: "font-medium text-gray-900 dark:text-white mb-3 flex items-center text-sm" }, [
                          createVNode("i", { class: "fas fa-check-circle text-green-500 mr-2" }),
                          createTextVNode(" What's included: ")
                        ]),
                        createVNode("ul", { class: "space-y-2" }, [
                          (openBlock(true), createBlock(Fragment, null, renderList(__props.plan.features, (feature) => {
                            return openBlock(), createBlock("li", {
                              key: feature,
                              class: "flex items-start text-gray-700 dark:text-gray-300"
                            }, [
                              createVNode("div", { class: "flex-shrink-0 w-4 h-4 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-2 mt-0.5" }, [
                                createVNode("i", { class: "fas fa-check text-green-600 dark:text-green-400 text-[8px]" })
                              ]),
                              createVNode("span", { class: "text-xs leading-relaxed" }, toDisplayString(feature), 1)
                            ]);
                          }), 128))
                        ])
                      ])
                    ])
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div><div class="lg:col-span-2"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(_sfc_main$6), { class: "overflow-hidden" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<div class="bg-gradient-to-r from-pink-50 to-rose-50 dark:from-pink-900/20 dark:to-rose-900/20 p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700"${_scopeId2}><h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center"${_scopeId2}><div class="w-8 h-8 bg-pink-100 dark:bg-pink-800 rounded-lg flex items-center justify-center mr-2"${_scopeId2}><i class="fas fa-mobile-alt text-pink-600 dark:text-pink-400 text-sm"${_scopeId2}></i></div> Payment Instructions </h3><div class="grid grid-cols-2 gap-4"${_scopeId2}><div class="bg-white dark:bg-gray-800 border-2 border-pink-200 dark:border-pink-700 rounded-xl p-4 text-center"${_scopeId2}><div class="inline-flex items-center justify-center w-8 h-8 bg-pink-100 dark:bg-pink-800 rounded-lg mb-2"${_scopeId2}><i class="fas fa-money-bill-wave text-pink-600 dark:text-pink-400 text-sm"${_scopeId2}></i></div><p class="text-xs text-gray-600 dark:text-gray-400 mb-1"${_scopeId2}>Send exactly</p><div class="text-xl font-bold text-pink-600 dark:text-pink-400"${_scopeId2}>${ssrInterpolate(__props.plan.formatted_price)}</div><p class="text-xs text-gray-500 dark:text-gray-400"${_scopeId2}>via Bkash</p></div><div class="bg-white dark:bg-gray-800 border-2 border-pink-200 dark:border-pink-700 rounded-xl p-4 text-center"${_scopeId2}><div class="inline-flex items-center justify-center w-8 h-8 bg-pink-100 dark:bg-pink-800 rounded-lg mb-2"${_scopeId2}><i class="fas fa-phone text-pink-600 dark:text-pink-400 text-sm"${_scopeId2}></i></div><p class="text-xs text-gray-600 dark:text-gray-400 mb-1"${_scopeId2}>Send to</p><div class="text-lg font-bold text-pink-600 dark:text-pink-400"${_scopeId2}>01309092748</div><button class="text-xs text-pink-600 dark:text-pink-400 hover:text-pink-700 font-medium"${_scopeId2}><i class="fas fa-copy mr-1"${_scopeId2}></i>Copy </button></div></div><div class="mt-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-3"${_scopeId2}><div class="flex items-start"${_scopeId2}><div class="flex-shrink-0 w-6 h-6 bg-yellow-100 dark:bg-yellow-800 rounded flex items-center justify-center mr-2"${_scopeId2}><i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 text-xs"${_scopeId2}></i></div><p class="text-xs text-yellow-700 dark:text-yellow-300"${_scopeId2}> After sending the payment, enter the transaction ID below to complete your subscription. </p></div></div></div><form class="p-4 sm:p-6"${_scopeId2}><div class="space-y-4"${_scopeId2}><div${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(_sfc_main$8), { class: "text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center" }, {
                    default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                      if (_push4) {
                        _push4(`<i class="fas fa-credit-card text-blue-500 mr-2 text-xs"${_scopeId3}></i> Payment Method `);
                      } else {
                        return [
                          createVNode("i", { class: "fas fa-credit-card text-blue-500 mr-2 text-xs" }),
                          createTextVNode(" Payment Method ")
                        ];
                      }
                    }),
                    _: 1
                  }, _parent3, _scopeId2));
                  _push3(`<select class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 dark:bg-gray-700 dark:text-white text-sm"${_scopeId2}><option value="bkash"${ssrIncludeBooleanAttr(Array.isArray(unref(form).payment_method) ? ssrLooseContain(unref(form).payment_method, "bkash") : ssrLooseEqual(unref(form).payment_method, "bkash")) ? " selected" : ""}${_scopeId2}>🏦 Bkash Mobile Banking</option></select></div><div${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(_sfc_main$8), { class: "text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center" }, {
                    default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                      if (_push4) {
                        _push4(`<i class="fas fa-receipt text-green-500 mr-2 text-xs"${_scopeId3}></i> Transaction ID `);
                      } else {
                        return [
                          createVNode("i", { class: "fas fa-receipt text-green-500 mr-2 text-xs" }),
                          createTextVNode(" Transaction ID ")
                        ];
                      }
                    }),
                    _: 1
                  }, _parent3, _scopeId2));
                  _push3(ssrRenderComponent(unref(_sfc_main$9), {
                    modelValue: unref(form).transaction_id,
                    "onUpdate:modelValue": ($event) => unref(form).transaction_id = $event,
                    type: "text",
                    required: "",
                    placeholder: "Enter your Bkash transaction ID",
                    error: unref(form).errors.transaction_id
                  }, null, _parent3, _scopeId2));
                  if (unref(form).errors.transaction_id) {
                    _push3(`<p class="mt-1 text-xs text-red-600 dark:text-red-400"${_scopeId2}>${ssrInterpolate(unref(form).errors.transaction_id)}</p>`);
                  } else {
                    _push3(`<!---->`);
                  }
                  _push3(`<p class="mt-1 text-xs text-gray-500 dark:text-gray-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded p-2"${_scopeId2}><i class="fas fa-info-circle text-blue-500 mr-1"${_scopeId2}></i> You&#39;ll receive this ID after completing the Bkash payment </p></div><div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-3"${_scopeId2}><div class="flex items-start"${_scopeId2}><input id="terms"${ssrIncludeBooleanAttr(Array.isArray(unref(form).terms) ? ssrLooseContain(unref(form).terms, null) : unref(form).terms) ? " checked" : ""} type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-0.5 flex-shrink-0"${_scopeId2}><label for="terms" class="ml-2 block text-xs text-gray-700 dark:text-gray-300 leading-relaxed"${_scopeId2}><span class="font-medium"${_scopeId2}>I confirm that:</span><ul class="mt-1 space-y-0.5 text-gray-600 dark:text-gray-400"${_scopeId2}><li${_scopeId2}>• I have completed the payment of <strong class="text-gray-900 dark:text-white"${_scopeId2}>${ssrInterpolate(__props.plan.formatted_price)}</strong></li><li${_scopeId2}>• I agree to the Terms of Service and Privacy Policy</li></ul></label></div></div></div><div class="mt-6 flex flex-col sm:flex-row gap-3"${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(link_default), {
                    href: "/pricing",
                    class: "flex-1 bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 text-gray-700 dark:text-white py-2.5 px-4 rounded-lg text-center font-medium transition-all text-sm"
                  }, {
                    default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                      if (_push4) {
                        _push4(`<i class="fas fa-arrow-left mr-2"${_scopeId3}></i>Back `);
                      } else {
                        return [
                          createVNode("i", { class: "fas fa-arrow-left mr-2" }),
                          createTextVNode("Back ")
                        ];
                      }
                    }),
                    _: 1
                  }, _parent3, _scopeId2));
                  _push3(`<button type="submit"${ssrIncludeBooleanAttr(unref(form).processing) ? " disabled" : ""} class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white py-2.5 px-4 rounded-lg font-medium transition-all text-sm shadow-md disabled:opacity-50"${_scopeId2}>`);
                  if (unref(form).processing) {
                    _push3(`<i class="fas fa-spinner fa-spin mr-2"${_scopeId2}></i>`);
                  } else {
                    _push3(`<i class="fas fa-check-circle mr-2"${_scopeId2}></i>`);
                  }
                  _push3(` Complete Subscription </button></div></form>`);
                } else {
                  return [
                    createVNode("div", { class: "bg-gradient-to-r from-pink-50 to-rose-50 dark:from-pink-900/20 dark:to-rose-900/20 p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700" }, [
                      createVNode("h3", { class: "text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center" }, [
                        createVNode("div", { class: "w-8 h-8 bg-pink-100 dark:bg-pink-800 rounded-lg flex items-center justify-center mr-2" }, [
                          createVNode("i", { class: "fas fa-mobile-alt text-pink-600 dark:text-pink-400 text-sm" })
                        ]),
                        createTextVNode(" Payment Instructions ")
                      ]),
                      createVNode("div", { class: "grid grid-cols-2 gap-4" }, [
                        createVNode("div", { class: "bg-white dark:bg-gray-800 border-2 border-pink-200 dark:border-pink-700 rounded-xl p-4 text-center" }, [
                          createVNode("div", { class: "inline-flex items-center justify-center w-8 h-8 bg-pink-100 dark:bg-pink-800 rounded-lg mb-2" }, [
                            createVNode("i", { class: "fas fa-money-bill-wave text-pink-600 dark:text-pink-400 text-sm" })
                          ]),
                          createVNode("p", { class: "text-xs text-gray-600 dark:text-gray-400 mb-1" }, "Send exactly"),
                          createVNode("div", { class: "text-xl font-bold text-pink-600 dark:text-pink-400" }, toDisplayString(__props.plan.formatted_price), 1),
                          createVNode("p", { class: "text-xs text-gray-500 dark:text-gray-400" }, "via Bkash")
                        ]),
                        createVNode("div", { class: "bg-white dark:bg-gray-800 border-2 border-pink-200 dark:border-pink-700 rounded-xl p-4 text-center" }, [
                          createVNode("div", { class: "inline-flex items-center justify-center w-8 h-8 bg-pink-100 dark:bg-pink-800 rounded-lg mb-2" }, [
                            createVNode("i", { class: "fas fa-phone text-pink-600 dark:text-pink-400 text-sm" })
                          ]),
                          createVNode("p", { class: "text-xs text-gray-600 dark:text-gray-400 mb-1" }, "Send to"),
                          createVNode("div", { class: "text-lg font-bold text-pink-600 dark:text-pink-400" }, "01309092748"),
                          createVNode("button", {
                            onClick: copyNumber,
                            class: "text-xs text-pink-600 dark:text-pink-400 hover:text-pink-700 font-medium"
                          }, [
                            createVNode("i", { class: "fas fa-copy mr-1" }),
                            createTextVNode("Copy ")
                          ])
                        ])
                      ]),
                      createVNode("div", { class: "mt-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-3" }, [
                        createVNode("div", { class: "flex items-start" }, [
                          createVNode("div", { class: "flex-shrink-0 w-6 h-6 bg-yellow-100 dark:bg-yellow-800 rounded flex items-center justify-center mr-2" }, [
                            createVNode("i", { class: "fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 text-xs" })
                          ]),
                          createVNode("p", { class: "text-xs text-yellow-700 dark:text-yellow-300" }, " After sending the payment, enter the transaction ID below to complete your subscription. ")
                        ])
                      ])
                    ]),
                    createVNode("form", {
                      onSubmit: withModifiers(submit, ["prevent"]),
                      class: "p-4 sm:p-6"
                    }, [
                      createVNode("div", { class: "space-y-4" }, [
                        createVNode("div", null, [
                          createVNode(unref(_sfc_main$8), { class: "text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center" }, {
                            default: withCtx(() => [
                              createVNode("i", { class: "fas fa-credit-card text-blue-500 mr-2 text-xs" }),
                              createTextVNode(" Payment Method ")
                            ]),
                            _: 1
                          }),
                          withDirectives(createVNode("select", {
                            "onUpdate:modelValue": ($event) => unref(form).payment_method = $event,
                            class: "w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 dark:bg-gray-700 dark:text-white text-sm"
                          }, [
                            createVNode("option", { value: "bkash" }, "🏦 Bkash Mobile Banking")
                          ], 8, ["onUpdate:modelValue"]), [
                            [vModelSelect, unref(form).payment_method]
                          ])
                        ]),
                        createVNode("div", null, [
                          createVNode(unref(_sfc_main$8), { class: "text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center" }, {
                            default: withCtx(() => [
                              createVNode("i", { class: "fas fa-receipt text-green-500 mr-2 text-xs" }),
                              createTextVNode(" Transaction ID ")
                            ]),
                            _: 1
                          }),
                          createVNode(unref(_sfc_main$9), {
                            modelValue: unref(form).transaction_id,
                            "onUpdate:modelValue": ($event) => unref(form).transaction_id = $event,
                            type: "text",
                            required: "",
                            placeholder: "Enter your Bkash transaction ID",
                            error: unref(form).errors.transaction_id
                          }, null, 8, ["modelValue", "onUpdate:modelValue", "error"]),
                          unref(form).errors.transaction_id ? (openBlock(), createBlock("p", {
                            key: 0,
                            class: "mt-1 text-xs text-red-600 dark:text-red-400"
                          }, toDisplayString(unref(form).errors.transaction_id), 1)) : createCommentVNode("", true),
                          createVNode("p", { class: "mt-1 text-xs text-gray-500 dark:text-gray-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded p-2" }, [
                            createVNode("i", { class: "fas fa-info-circle text-blue-500 mr-1" }),
                            createTextVNode(" You'll receive this ID after completing the Bkash payment ")
                          ])
                        ]),
                        createVNode("div", { class: "bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-3" }, [
                          createVNode("div", { class: "flex items-start" }, [
                            withDirectives(createVNode("input", {
                              id: "terms",
                              "onUpdate:modelValue": ($event) => unref(form).terms = $event,
                              type: "checkbox",
                              class: "h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-0.5 flex-shrink-0"
                            }, null, 8, ["onUpdate:modelValue"]), [
                              [vModelCheckbox, unref(form).terms]
                            ]),
                            createVNode("label", {
                              for: "terms",
                              class: "ml-2 block text-xs text-gray-700 dark:text-gray-300 leading-relaxed"
                            }, [
                              createVNode("span", { class: "font-medium" }, "I confirm that:"),
                              createVNode("ul", { class: "mt-1 space-y-0.5 text-gray-600 dark:text-gray-400" }, [
                                createVNode("li", null, [
                                  createTextVNode("• I have completed the payment of "),
                                  createVNode("strong", { class: "text-gray-900 dark:text-white" }, toDisplayString(__props.plan.formatted_price), 1)
                                ]),
                                createVNode("li", null, "• I agree to the Terms of Service and Privacy Policy")
                              ])
                            ])
                          ])
                        ])
                      ]),
                      createVNode("div", { class: "mt-6 flex flex-col sm:flex-row gap-3" }, [
                        createVNode(unref(link_default), {
                          href: "/pricing",
                          class: "flex-1 bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 text-gray-700 dark:text-white py-2.5 px-4 rounded-lg text-center font-medium transition-all text-sm"
                        }, {
                          default: withCtx(() => [
                            createVNode("i", { class: "fas fa-arrow-left mr-2" }),
                            createTextVNode("Back ")
                          ]),
                          _: 1
                        }),
                        createVNode("button", {
                          type: "submit",
                          disabled: unref(form).processing,
                          class: "flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white py-2.5 px-4 rounded-lg font-medium transition-all text-sm shadow-md disabled:opacity-50"
                        }, [
                          unref(form).processing ? (openBlock(), createBlock("i", {
                            key: 0,
                            class: "fas fa-spinner fa-spin mr-2"
                          })) : (openBlock(), createBlock("i", {
                            key: 1,
                            class: "fas fa-check-circle mr-2"
                          })),
                          createTextVNode(" Complete Subscription ")
                        ], 8, ["disabled"])
                      ])
                    ], 32)
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div></div>`);
            _push2(ssrRenderComponent(unref(_sfc_main$6), { class: "p-4 sm:p-6" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<div class="text-center mb-6"${_scopeId2}><div class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg mb-3"${_scopeId2}><i class="fas fa-clock text-white"${_scopeId2}></i></div><h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1"${_scopeId2}>What happens next?</h3><p class="text-sm text-gray-600 dark:text-gray-400"${_scopeId2}>Your subscription journey</p></div><div class="grid grid-cols-1 sm:grid-cols-3 gap-4"${_scopeId2}><div class="flex items-center sm:flex-col sm:text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg"${_scopeId2}><div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3 sm:mr-0 sm:mb-2"${_scopeId2}> 1 </div><div${_scopeId2}><h4 class="font-medium text-gray-900 dark:text-white text-sm"${_scopeId2}>Submit Form</h4><p class="text-xs text-gray-600 dark:text-gray-400"${_scopeId2}>Submit with transaction ID</p></div></div><div class="flex items-center sm:flex-col sm:text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg"${_scopeId2}><div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3 sm:mr-0 sm:mb-2"${_scopeId2}> 2 </div><div${_scopeId2}><h4 class="font-medium text-gray-900 dark:text-white text-sm"${_scopeId2}>Verification</h4><p class="text-xs text-gray-600 dark:text-gray-400"${_scopeId2}>Verified within 2-24 hours</p></div></div><div class="flex items-center sm:flex-col sm:text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg"${_scopeId2}><div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full flex items-center justify-center mr-3 sm:mr-0 sm:mb-2"${_scopeId2}><i class="fas fa-check text-sm"${_scopeId2}></i></div><div${_scopeId2}><h4 class="font-medium text-gray-900 dark:text-white text-sm"${_scopeId2}>Active!</h4><p class="text-xs text-gray-600 dark:text-gray-400"${_scopeId2}>Start using the API</p></div></div></div><div class="mt-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-3 text-center"${_scopeId2}><i class="fas fa-headset text-blue-600 dark:text-blue-400 mr-2"${_scopeId2}></i><span class="text-xs text-blue-800 dark:text-blue-300"${_scopeId2}> Need help? Contact <a href="mailto:support@fraudshield.com" class="underline"${_scopeId2}>support@fraudshield.com</a></span></div>`);
                } else {
                  return [
                    createVNode("div", { class: "text-center mb-6" }, [
                      createVNode("div", { class: "inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg mb-3" }, [
                        createVNode("i", { class: "fas fa-clock text-white" })
                      ]),
                      createVNode("h3", { class: "text-lg font-bold text-gray-900 dark:text-white mb-1" }, "What happens next?"),
                      createVNode("p", { class: "text-sm text-gray-600 dark:text-gray-400" }, "Your subscription journey")
                    ]),
                    createVNode("div", { class: "grid grid-cols-1 sm:grid-cols-3 gap-4" }, [
                      createVNode("div", { class: "flex items-center sm:flex-col sm:text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg" }, [
                        createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3 sm:mr-0 sm:mb-2" }, " 1 "),
                        createVNode("div", null, [
                          createVNode("h4", { class: "font-medium text-gray-900 dark:text-white text-sm" }, "Submit Form"),
                          createVNode("p", { class: "text-xs text-gray-600 dark:text-gray-400" }, "Submit with transaction ID")
                        ])
                      ]),
                      createVNode("div", { class: "flex items-center sm:flex-col sm:text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg" }, [
                        createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3 sm:mr-0 sm:mb-2" }, " 2 "),
                        createVNode("div", null, [
                          createVNode("h4", { class: "font-medium text-gray-900 dark:text-white text-sm" }, "Verification"),
                          createVNode("p", { class: "text-xs text-gray-600 dark:text-gray-400" }, "Verified within 2-24 hours")
                        ])
                      ]),
                      createVNode("div", { class: "flex items-center sm:flex-col sm:text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg" }, [
                        createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full flex items-center justify-center mr-3 sm:mr-0 sm:mb-2" }, [
                          createVNode("i", { class: "fas fa-check text-sm" })
                        ]),
                        createVNode("div", null, [
                          createVNode("h4", { class: "font-medium text-gray-900 dark:text-white text-sm" }, "Active!"),
                          createVNode("p", { class: "text-xs text-gray-600 dark:text-gray-400" }, "Start using the API")
                        ])
                      ])
                    ]),
                    createVNode("div", { class: "mt-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-3 text-center" }, [
                      createVNode("i", { class: "fas fa-headset text-blue-600 dark:text-blue-400 mr-2" }),
                      createVNode("span", { class: "text-xs text-blue-800 dark:text-blue-300" }, [
                        createTextVNode(" Need help? Contact "),
                        createVNode("a", {
                          href: "mailto:support@fraudshield.com",
                          class: "underline"
                        }, "support@fraudshield.com")
                      ])
                    ])
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div></div></div>`);
          } else {
            return [
              (openBlock(), createBlock(Teleport, { to: "body" }, [
                createVNode(Transition, {
                  "enter-active-class": "transition ease-out duration-300",
                  "enter-from-class": "translate-x-full opacity-0",
                  "enter-to-class": "translate-x-0 opacity-100",
                  "leave-active-class": "transition ease-in duration-200",
                  "leave-from-class": "translate-x-0 opacity-100",
                  "leave-to-class": "translate-x-full opacity-0"
                }, {
                  default: withCtx(() => [
                    notification.value.show ? (openBlock(), createBlock("div", {
                      key: 0,
                      class: [
                        "fixed top-4 right-4 z-50 px-4 py-3 rounded-xl shadow-lg text-white",
                        notification.value.type === "success" ? "bg-green-500" : "bg-red-500"
                      ]
                    }, [
                      createVNode("i", {
                        class: notification.value.type === "success" ? "fas fa-check mr-2" : "fas fa-exclamation-circle mr-2"
                      }, null, 2),
                      createTextVNode(" " + toDisplayString(notification.value.message), 1)
                    ], 2)) : createCommentVNode("", true)
                  ]),
                  _: 1
                })
              ])),
              createVNode("div", { class: "min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8 sm:py-12" }, [
                createVNode("div", { class: "container mx-auto px-4 sm:px-6 lg:px-8" }, [
                  createVNode("div", { class: "max-w-4xl mx-auto" }, [
                    createVNode("div", { class: "text-center mb-8" }, [
                      createVNode("div", { class: "inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl mb-4" }, [
                        createVNode("i", { class: "fas fa-credit-card text-white text-lg" })
                      ]),
                      createVNode("h1", { class: "text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2" }, [
                        createTextVNode(" Subscribe to "),
                        createVNode("span", { class: "text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600" }, toDisplayString(__props.plan.name), 1)
                      ]),
                      createVNode("p", { class: "text-sm text-gray-600 dark:text-gray-400 max-w-xl mx-auto" }, " Complete your subscription with secure manual payment verification ")
                    ]),
                    createVNode("div", { class: "grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6" }, [
                      createVNode("div", { class: "lg:col-span-1" }, [
                        createVNode(unref(_sfc_main$6), { class: "overflow-hidden" }, {
                          default: withCtx(() => [
                            createVNode("div", { class: "bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-4" }, [
                              createVNode("div", { class: "text-center" }, [
                                createVNode("div", { class: "inline-flex items-center justify-center w-10 h-10 bg-white/20 rounded-lg mb-3" }, [
                                  createVNode("i", { class: "fas fa-crown text-white" })
                                ]),
                                createVNode("h2", { class: "text-lg font-bold mb-1" }, toDisplayString(__props.plan.name), 1),
                                createVNode("p", { class: "text-blue-100 text-xs" }, toDisplayString(__props.plan.description), 1)
                              ])
                            ]),
                            createVNode("div", { class: "p-4" }, [
                              createVNode("div", { class: "text-center mb-4" }, [
                                createVNode("div", { class: "text-3xl font-bold text-gray-900 dark:text-white" }, toDisplayString(__props.plan.formatted_price), 1),
                                createVNode("div", { class: "text-sm text-gray-500 dark:text-gray-400" }, "for " + toDisplayString(__props.plan.duration_text), 1)
                              ]),
                              createVNode("div", null, [
                                createVNode("h3", { class: "font-medium text-gray-900 dark:text-white mb-3 flex items-center text-sm" }, [
                                  createVNode("i", { class: "fas fa-check-circle text-green-500 mr-2" }),
                                  createTextVNode(" What's included: ")
                                ]),
                                createVNode("ul", { class: "space-y-2" }, [
                                  (openBlock(true), createBlock(Fragment, null, renderList(__props.plan.features, (feature) => {
                                    return openBlock(), createBlock("li", {
                                      key: feature,
                                      class: "flex items-start text-gray-700 dark:text-gray-300"
                                    }, [
                                      createVNode("div", { class: "flex-shrink-0 w-4 h-4 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-2 mt-0.5" }, [
                                        createVNode("i", { class: "fas fa-check text-green-600 dark:text-green-400 text-[8px]" })
                                      ]),
                                      createVNode("span", { class: "text-xs leading-relaxed" }, toDisplayString(feature), 1)
                                    ]);
                                  }), 128))
                                ])
                              ])
                            ])
                          ]),
                          _: 1
                        })
                      ]),
                      createVNode("div", { class: "lg:col-span-2" }, [
                        createVNode(unref(_sfc_main$6), { class: "overflow-hidden" }, {
                          default: withCtx(() => [
                            createVNode("div", { class: "bg-gradient-to-r from-pink-50 to-rose-50 dark:from-pink-900/20 dark:to-rose-900/20 p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700" }, [
                              createVNode("h3", { class: "text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center" }, [
                                createVNode("div", { class: "w-8 h-8 bg-pink-100 dark:bg-pink-800 rounded-lg flex items-center justify-center mr-2" }, [
                                  createVNode("i", { class: "fas fa-mobile-alt text-pink-600 dark:text-pink-400 text-sm" })
                                ]),
                                createTextVNode(" Payment Instructions ")
                              ]),
                              createVNode("div", { class: "grid grid-cols-2 gap-4" }, [
                                createVNode("div", { class: "bg-white dark:bg-gray-800 border-2 border-pink-200 dark:border-pink-700 rounded-xl p-4 text-center" }, [
                                  createVNode("div", { class: "inline-flex items-center justify-center w-8 h-8 bg-pink-100 dark:bg-pink-800 rounded-lg mb-2" }, [
                                    createVNode("i", { class: "fas fa-money-bill-wave text-pink-600 dark:text-pink-400 text-sm" })
                                  ]),
                                  createVNode("p", { class: "text-xs text-gray-600 dark:text-gray-400 mb-1" }, "Send exactly"),
                                  createVNode("div", { class: "text-xl font-bold text-pink-600 dark:text-pink-400" }, toDisplayString(__props.plan.formatted_price), 1),
                                  createVNode("p", { class: "text-xs text-gray-500 dark:text-gray-400" }, "via Bkash")
                                ]),
                                createVNode("div", { class: "bg-white dark:bg-gray-800 border-2 border-pink-200 dark:border-pink-700 rounded-xl p-4 text-center" }, [
                                  createVNode("div", { class: "inline-flex items-center justify-center w-8 h-8 bg-pink-100 dark:bg-pink-800 rounded-lg mb-2" }, [
                                    createVNode("i", { class: "fas fa-phone text-pink-600 dark:text-pink-400 text-sm" })
                                  ]),
                                  createVNode("p", { class: "text-xs text-gray-600 dark:text-gray-400 mb-1" }, "Send to"),
                                  createVNode("div", { class: "text-lg font-bold text-pink-600 dark:text-pink-400" }, "01309092748"),
                                  createVNode("button", {
                                    onClick: copyNumber,
                                    class: "text-xs text-pink-600 dark:text-pink-400 hover:text-pink-700 font-medium"
                                  }, [
                                    createVNode("i", { class: "fas fa-copy mr-1" }),
                                    createTextVNode("Copy ")
                                  ])
                                ])
                              ]),
                              createVNode("div", { class: "mt-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-3" }, [
                                createVNode("div", { class: "flex items-start" }, [
                                  createVNode("div", { class: "flex-shrink-0 w-6 h-6 bg-yellow-100 dark:bg-yellow-800 rounded flex items-center justify-center mr-2" }, [
                                    createVNode("i", { class: "fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 text-xs" })
                                  ]),
                                  createVNode("p", { class: "text-xs text-yellow-700 dark:text-yellow-300" }, " After sending the payment, enter the transaction ID below to complete your subscription. ")
                                ])
                              ])
                            ]),
                            createVNode("form", {
                              onSubmit: withModifiers(submit, ["prevent"]),
                              class: "p-4 sm:p-6"
                            }, [
                              createVNode("div", { class: "space-y-4" }, [
                                createVNode("div", null, [
                                  createVNode(unref(_sfc_main$8), { class: "text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center" }, {
                                    default: withCtx(() => [
                                      createVNode("i", { class: "fas fa-credit-card text-blue-500 mr-2 text-xs" }),
                                      createTextVNode(" Payment Method ")
                                    ]),
                                    _: 1
                                  }),
                                  withDirectives(createVNode("select", {
                                    "onUpdate:modelValue": ($event) => unref(form).payment_method = $event,
                                    class: "w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 dark:bg-gray-700 dark:text-white text-sm"
                                  }, [
                                    createVNode("option", { value: "bkash" }, "🏦 Bkash Mobile Banking")
                                  ], 8, ["onUpdate:modelValue"]), [
                                    [vModelSelect, unref(form).payment_method]
                                  ])
                                ]),
                                createVNode("div", null, [
                                  createVNode(unref(_sfc_main$8), { class: "text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center" }, {
                                    default: withCtx(() => [
                                      createVNode("i", { class: "fas fa-receipt text-green-500 mr-2 text-xs" }),
                                      createTextVNode(" Transaction ID ")
                                    ]),
                                    _: 1
                                  }),
                                  createVNode(unref(_sfc_main$9), {
                                    modelValue: unref(form).transaction_id,
                                    "onUpdate:modelValue": ($event) => unref(form).transaction_id = $event,
                                    type: "text",
                                    required: "",
                                    placeholder: "Enter your Bkash transaction ID",
                                    error: unref(form).errors.transaction_id
                                  }, null, 8, ["modelValue", "onUpdate:modelValue", "error"]),
                                  unref(form).errors.transaction_id ? (openBlock(), createBlock("p", {
                                    key: 0,
                                    class: "mt-1 text-xs text-red-600 dark:text-red-400"
                                  }, toDisplayString(unref(form).errors.transaction_id), 1)) : createCommentVNode("", true),
                                  createVNode("p", { class: "mt-1 text-xs text-gray-500 dark:text-gray-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded p-2" }, [
                                    createVNode("i", { class: "fas fa-info-circle text-blue-500 mr-1" }),
                                    createTextVNode(" You'll receive this ID after completing the Bkash payment ")
                                  ])
                                ]),
                                createVNode("div", { class: "bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-3" }, [
                                  createVNode("div", { class: "flex items-start" }, [
                                    withDirectives(createVNode("input", {
                                      id: "terms",
                                      "onUpdate:modelValue": ($event) => unref(form).terms = $event,
                                      type: "checkbox",
                                      class: "h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-0.5 flex-shrink-0"
                                    }, null, 8, ["onUpdate:modelValue"]), [
                                      [vModelCheckbox, unref(form).terms]
                                    ]),
                                    createVNode("label", {
                                      for: "terms",
                                      class: "ml-2 block text-xs text-gray-700 dark:text-gray-300 leading-relaxed"
                                    }, [
                                      createVNode("span", { class: "font-medium" }, "I confirm that:"),
                                      createVNode("ul", { class: "mt-1 space-y-0.5 text-gray-600 dark:text-gray-400" }, [
                                        createVNode("li", null, [
                                          createTextVNode("• I have completed the payment of "),
                                          createVNode("strong", { class: "text-gray-900 dark:text-white" }, toDisplayString(__props.plan.formatted_price), 1)
                                        ]),
                                        createVNode("li", null, "• I agree to the Terms of Service and Privacy Policy")
                                      ])
                                    ])
                                  ])
                                ])
                              ]),
                              createVNode("div", { class: "mt-6 flex flex-col sm:flex-row gap-3" }, [
                                createVNode(unref(link_default), {
                                  href: "/pricing",
                                  class: "flex-1 bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 text-gray-700 dark:text-white py-2.5 px-4 rounded-lg text-center font-medium transition-all text-sm"
                                }, {
                                  default: withCtx(() => [
                                    createVNode("i", { class: "fas fa-arrow-left mr-2" }),
                                    createTextVNode("Back ")
                                  ]),
                                  _: 1
                                }),
                                createVNode("button", {
                                  type: "submit",
                                  disabled: unref(form).processing,
                                  class: "flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white py-2.5 px-4 rounded-lg font-medium transition-all text-sm shadow-md disabled:opacity-50"
                                }, [
                                  unref(form).processing ? (openBlock(), createBlock("i", {
                                    key: 0,
                                    class: "fas fa-spinner fa-spin mr-2"
                                  })) : (openBlock(), createBlock("i", {
                                    key: 1,
                                    class: "fas fa-check-circle mr-2"
                                  })),
                                  createTextVNode(" Complete Subscription ")
                                ], 8, ["disabled"])
                              ])
                            ], 32)
                          ]),
                          _: 1
                        })
                      ])
                    ]),
                    createVNode(unref(_sfc_main$6), { class: "p-4 sm:p-6" }, {
                      default: withCtx(() => [
                        createVNode("div", { class: "text-center mb-6" }, [
                          createVNode("div", { class: "inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg mb-3" }, [
                            createVNode("i", { class: "fas fa-clock text-white" })
                          ]),
                          createVNode("h3", { class: "text-lg font-bold text-gray-900 dark:text-white mb-1" }, "What happens next?"),
                          createVNode("p", { class: "text-sm text-gray-600 dark:text-gray-400" }, "Your subscription journey")
                        ]),
                        createVNode("div", { class: "grid grid-cols-1 sm:grid-cols-3 gap-4" }, [
                          createVNode("div", { class: "flex items-center sm:flex-col sm:text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg" }, [
                            createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3 sm:mr-0 sm:mb-2" }, " 1 "),
                            createVNode("div", null, [
                              createVNode("h4", { class: "font-medium text-gray-900 dark:text-white text-sm" }, "Submit Form"),
                              createVNode("p", { class: "text-xs text-gray-600 dark:text-gray-400" }, "Submit with transaction ID")
                            ])
                          ]),
                          createVNode("div", { class: "flex items-center sm:flex-col sm:text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg" }, [
                            createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3 sm:mr-0 sm:mb-2" }, " 2 "),
                            createVNode("div", null, [
                              createVNode("h4", { class: "font-medium text-gray-900 dark:text-white text-sm" }, "Verification"),
                              createVNode("p", { class: "text-xs text-gray-600 dark:text-gray-400" }, "Verified within 2-24 hours")
                            ])
                          ]),
                          createVNode("div", { class: "flex items-center sm:flex-col sm:text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg" }, [
                            createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full flex items-center justify-center mr-3 sm:mr-0 sm:mb-2" }, [
                              createVNode("i", { class: "fas fa-check text-sm" })
                            ]),
                            createVNode("div", null, [
                              createVNode("h4", { class: "font-medium text-gray-900 dark:text-white text-sm" }, "Active!"),
                              createVNode("p", { class: "text-xs text-gray-600 dark:text-gray-400" }, "Start using the API")
                            ])
                          ])
                        ]),
                        createVNode("div", { class: "mt-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-3 text-center" }, [
                          createVNode("i", { class: "fas fa-headset text-blue-600 dark:text-blue-400 mr-2" }),
                          createVNode("span", { class: "text-xs text-blue-800 dark:text-blue-300" }, [
                            createTextVNode(" Need help? Contact "),
                            createVNode("a", {
                              href: "mailto:support@fraudshield.com",
                              class: "underline"
                            }, "support@fraudshield.com")
                          ])
                        ])
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Pricing/Subscribe.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
