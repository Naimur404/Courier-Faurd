import { defineComponent, unref, withCtx, createVNode, createTextVNode, createBlock, createCommentVNode, openBlock, withModifiers, toDisplayString, withDirectives, vModelCheckbox, useSSRContext } from "vue";
import { ssrRenderComponent, ssrInterpolate, ssrIncludeBooleanAttr, ssrLooseContain } from "vue/server-renderer";
import { u as useForm, h as head_default, l as link_default } from "../ssr.js";
import { a as _sfc_main$1, _ as _sfc_main$4 } from "./Button-WwCvZvLI.js";
import { _ as _sfc_main$3 } from "./Input-DYYSdVaj.js";
import { _ as _sfc_main$2 } from "./Label-Cl3p6AAe.js";
import "@vue/server-renderer";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
import "./utils-DvCvi0aN.js";
import "clsx";
import "tailwind-merge";
import "class-variance-authority";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Login",
  __ssrInlineRender: true,
  props: {
    errors: {}
  },
  setup(__props) {
    const form = useForm({
      email: "",
      password: "",
      remember: false
    });
    const submit = () => {
      form.post("/login", {
        onFinish: () => form.reset("password")
      });
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(head_default), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title${_scopeId}>Login - FraudShield BD</title><meta name="description" content="Sign in to your FraudShield BD account"${_scopeId}><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, "Login - FraudShield BD"),
              createVNode("meta", {
                name: "description",
                content: "Sign in to your FraudShield BD account"
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
      _push(`<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8"><div class="max-w-md w-full space-y-8"><div class="text-center">`);
      _push(ssrRenderComponent(unref(link_default), { href: "/" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="mx-auto h-16 w-16 bg-primary rounded-lg flex items-center justify-center mb-6 hover:opacity-90 transition-opacity"${_scopeId}><i class="fas fa-shield-alt text-2xl text-white"${_scopeId}></i></div>`);
          } else {
            return [
              createVNode("div", { class: "mx-auto h-16 w-16 bg-primary rounded-lg flex items-center justify-center mb-6 hover:opacity-90 transition-opacity" }, [
                createVNode("i", { class: "fas fa-shield-alt text-2xl text-white" })
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2"> সাইন ইন করুন </h2><p class="text-sm text-gray-600 dark:text-gray-400"> আপনার অ্যাকাউন্টে লগ ইন করুন </p></div>`);
      _push(ssrRenderComponent(_sfc_main$1, { class: "bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<form class="space-y-6"${_scopeId}><div${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$2, {
              for: "email",
              class: "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(` ইমেইল ঠিকানা `);
                } else {
                  return [
                    createTextVNode(" ইমেইল ঠিকানা ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$3, {
              id: "email",
              modelValue: unref(form).email,
              "onUpdate:modelValue": ($event) => unref(form).email = $event,
              type: "email",
              autocomplete: "email",
              required: "",
              error: unref(form).errors.email,
              placeholder: "আপনার ইমেইল দিন"
            }, null, _parent2, _scopeId));
            if (unref(form).errors.email) {
              _push2(`<p class="mt-1 text-sm text-red-600 dark:text-red-400"${_scopeId}>${ssrInterpolate(unref(form).errors.email)}</p>`);
            } else {
              _push2(`<!---->`);
            }
            _push2(`</div><div${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$2, {
              for: "password",
              class: "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(` পাসওয়ার্ড `);
                } else {
                  return [
                    createTextVNode(" পাসওয়ার্ড ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$3, {
              id: "password",
              modelValue: unref(form).password,
              "onUpdate:modelValue": ($event) => unref(form).password = $event,
              type: "password",
              autocomplete: "current-password",
              required: "",
              error: unref(form).errors.password,
              placeholder: "আপনার পাসওয়ার্ড দিন"
            }, null, _parent2, _scopeId));
            if (unref(form).errors.password) {
              _push2(`<p class="mt-1 text-sm text-red-600 dark:text-red-400"${_scopeId}>${ssrInterpolate(unref(form).errors.password)}</p>`);
            } else {
              _push2(`<!---->`);
            }
            _push2(`</div><div class="flex items-center justify-between"${_scopeId}><div class="flex items-center"${_scopeId}><input id="remember"${ssrIncludeBooleanAttr(Array.isArray(unref(form).remember) ? ssrLooseContain(unref(form).remember, null) : unref(form).remember) ? " checked" : ""} type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded"${_scopeId}><label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300"${_scopeId}> আমাকে মনে রাখুন </label></div><div class="text-sm"${_scopeId}><a href="#" class="font-medium text-primary hover:opacity-80 dark:text-primary"${_scopeId}> পাসওয়ার্ড ভুলে গেছেন? </a></div></div><div${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$4, {
              type: "submit",
              disabled: unref(form).processing,
              class: "w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors disabled:opacity-70"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  if (unref(form).processing) {
                    _push3(`<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"${_scopeId2}><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"${_scopeId2}></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"${_scopeId2}></path></svg>`);
                  } else {
                    _push3(`<!---->`);
                  }
                  _push3(` সাইন ইন করুন `);
                } else {
                  return [
                    unref(form).processing ? (openBlock(), createBlock("svg", {
                      key: 0,
                      class: "animate-spin -ml-1 mr-3 h-5 w-5 text-white",
                      xmlns: "http://www.w3.org/2000/svg",
                      fill: "none",
                      viewBox: "0 0 24 24"
                    }, [
                      createVNode("circle", {
                        class: "opacity-25",
                        cx: "12",
                        cy: "12",
                        r: "10",
                        stroke: "currentColor",
                        "stroke-width": "4"
                      }),
                      createVNode("path", {
                        class: "opacity-75",
                        fill: "currentColor",
                        d: "M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                      })
                    ])) : createCommentVNode("", true),
                    createTextVNode(" সাইন ইন করুন ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div><div class="text-center pt-4 border-t border-gray-200 dark:border-gray-600"${_scopeId}><p class="text-sm text-gray-600 dark:text-gray-400"${_scopeId}> অ্যাকাউন্ট নেই? `);
            _push2(ssrRenderComponent(unref(link_default), {
              href: "/register",
              class: "font-medium text-primary hover:opacity-80"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(` নতুন অ্যাকাউন্ট তৈরি করুন `);
                } else {
                  return [
                    createTextVNode(" নতুন অ্যাকাউন্ট তৈরি করুন ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</p></div></form>`);
          } else {
            return [
              createVNode("form", {
                class: "space-y-6",
                onSubmit: withModifiers(submit, ["prevent"])
              }, [
                createVNode("div", null, [
                  createVNode(_sfc_main$2, {
                    for: "email",
                    class: "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                  }, {
                    default: withCtx(() => [
                      createTextVNode(" ইমেইল ঠিকানা ")
                    ]),
                    _: 1
                  }),
                  createVNode(_sfc_main$3, {
                    id: "email",
                    modelValue: unref(form).email,
                    "onUpdate:modelValue": ($event) => unref(form).email = $event,
                    type: "email",
                    autocomplete: "email",
                    required: "",
                    error: unref(form).errors.email,
                    placeholder: "আপনার ইমেইল দিন"
                  }, null, 8, ["modelValue", "onUpdate:modelValue", "error"]),
                  unref(form).errors.email ? (openBlock(), createBlock("p", {
                    key: 0,
                    class: "mt-1 text-sm text-red-600 dark:text-red-400"
                  }, toDisplayString(unref(form).errors.email), 1)) : createCommentVNode("", true)
                ]),
                createVNode("div", null, [
                  createVNode(_sfc_main$2, {
                    for: "password",
                    class: "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                  }, {
                    default: withCtx(() => [
                      createTextVNode(" পাসওয়ার্ড ")
                    ]),
                    _: 1
                  }),
                  createVNode(_sfc_main$3, {
                    id: "password",
                    modelValue: unref(form).password,
                    "onUpdate:modelValue": ($event) => unref(form).password = $event,
                    type: "password",
                    autocomplete: "current-password",
                    required: "",
                    error: unref(form).errors.password,
                    placeholder: "আপনার পাসওয়ার্ড দিন"
                  }, null, 8, ["modelValue", "onUpdate:modelValue", "error"]),
                  unref(form).errors.password ? (openBlock(), createBlock("p", {
                    key: 0,
                    class: "mt-1 text-sm text-red-600 dark:text-red-400"
                  }, toDisplayString(unref(form).errors.password), 1)) : createCommentVNode("", true)
                ]),
                createVNode("div", { class: "flex items-center justify-between" }, [
                  createVNode("div", { class: "flex items-center" }, [
                    withDirectives(createVNode("input", {
                      id: "remember",
                      "onUpdate:modelValue": ($event) => unref(form).remember = $event,
                      type: "checkbox",
                      class: "h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded"
                    }, null, 8, ["onUpdate:modelValue"]), [
                      [vModelCheckbox, unref(form).remember]
                    ]),
                    createVNode("label", {
                      for: "remember",
                      class: "ml-2 block text-sm text-gray-700 dark:text-gray-300"
                    }, " আমাকে মনে রাখুন ")
                  ]),
                  createVNode("div", { class: "text-sm" }, [
                    createVNode("a", {
                      href: "#",
                      class: "font-medium text-primary hover:opacity-80 dark:text-primary"
                    }, " পাসওয়ার্ড ভুলে গেছেন? ")
                  ])
                ]),
                createVNode("div", null, [
                  createVNode(_sfc_main$4, {
                    type: "submit",
                    disabled: unref(form).processing,
                    class: "w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors disabled:opacity-70"
                  }, {
                    default: withCtx(() => [
                      unref(form).processing ? (openBlock(), createBlock("svg", {
                        key: 0,
                        class: "animate-spin -ml-1 mr-3 h-5 w-5 text-white",
                        xmlns: "http://www.w3.org/2000/svg",
                        fill: "none",
                        viewBox: "0 0 24 24"
                      }, [
                        createVNode("circle", {
                          class: "opacity-25",
                          cx: "12",
                          cy: "12",
                          r: "10",
                          stroke: "currentColor",
                          "stroke-width": "4"
                        }),
                        createVNode("path", {
                          class: "opacity-75",
                          fill: "currentColor",
                          d: "M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        })
                      ])) : createCommentVNode("", true),
                      createTextVNode(" সাইন ইন করুন ")
                    ]),
                    _: 1
                  }, 8, ["disabled"])
                ]),
                createVNode("div", { class: "text-center pt-4 border-t border-gray-200 dark:border-gray-600" }, [
                  createVNode("p", { class: "text-sm text-gray-600 dark:text-gray-400" }, [
                    createTextVNode(" অ্যাকাউন্ট নেই? "),
                    createVNode(unref(link_default), {
                      href: "/register",
                      class: "font-medium text-primary hover:opacity-80"
                    }, {
                      default: withCtx(() => [
                        createTextVNode(" নতুন অ্যাকাউন্ট তৈরি করুন ")
                      ]),
                      _: 1
                    })
                  ])
                ])
              ], 32)
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div></div><!--]-->`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Auth/Login.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
