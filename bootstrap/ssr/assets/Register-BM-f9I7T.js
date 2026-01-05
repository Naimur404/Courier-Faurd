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
  __name: "Register",
  __ssrInlineRender: true,
  props: {
    errors: {}
  },
  setup(__props) {
    const form = useForm({
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      terms: false
    });
    const submit = () => {
      form.post("/register", {
        onFinish: () => form.reset("password", "password_confirmation")
      });
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(head_default), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title${_scopeId}>Register - FraudShield BD</title><meta name="description" content="Create your FraudShield BD account"${_scopeId}><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, "Register - FraudShield BD"),
              createVNode("meta", {
                name: "description",
                content: "Create your FraudShield BD account"
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
            _push2(`<div class="mx-auto h-16 w-16 bg-primary rounded-lg flex items-center justify-center mb-6 hover:opacity-90 transition-opacity"${_scopeId}><i class="fas fa-user-plus text-2xl text-white"${_scopeId}></i></div>`);
          } else {
            return [
              createVNode("div", { class: "mx-auto h-16 w-16 bg-primary rounded-lg flex items-center justify-center mb-6 hover:opacity-90 transition-opacity" }, [
                createVNode("i", { class: "fas fa-user-plus text-2xl text-white" })
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2"> অ্যাকাউন্ট তৈরি করুন </h2><p class="text-sm text-gray-600 dark:text-gray-400"> FraudShield BD তে যোগ দিন </p></div>`);
      _push(ssrRenderComponent(_sfc_main$1, { class: "bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<form class="space-y-6"${_scopeId}><div${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$2, {
              for: "name",
              class: "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(` পূর্ণ নাম `);
                } else {
                  return [
                    createTextVNode(" পূর্ণ নাম ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$3, {
              id: "name",
              modelValue: unref(form).name,
              "onUpdate:modelValue": ($event) => unref(form).name = $event,
              type: "text",
              autocomplete: "name",
              required: "",
              error: unref(form).errors.name,
              placeholder: "আপনার পূর্ণ নাম দিন"
            }, null, _parent2, _scopeId));
            if (unref(form).errors.name) {
              _push2(`<p class="mt-1 text-sm text-red-600 dark:text-red-400"${_scopeId}>${ssrInterpolate(unref(form).errors.name)}</p>`);
            } else {
              _push2(`<!---->`);
            }
            _push2(`</div><div${_scopeId}>`);
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
              autocomplete: "new-password",
              required: "",
              error: unref(form).errors.password,
              placeholder: "আপনার পাসওয়ার্ড দিন"
            }, null, _parent2, _scopeId));
            if (unref(form).errors.password) {
              _push2(`<p class="mt-1 text-sm text-red-600 dark:text-red-400"${_scopeId}>${ssrInterpolate(unref(form).errors.password)}</p>`);
            } else {
              _push2(`<!---->`);
            }
            _push2(`</div><div${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$2, {
              for: "password_confirmation",
              class: "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(` পাসওয়ার্ড নিশ্চিত করুন `);
                } else {
                  return [
                    createTextVNode(" পাসওয়ার্ড নিশ্চিত করুন ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$3, {
              id: "password_confirmation",
              modelValue: unref(form).password_confirmation,
              "onUpdate:modelValue": ($event) => unref(form).password_confirmation = $event,
              type: "password",
              autocomplete: "new-password",
              required: "",
              placeholder: "পাসওয়ার্ড আবার দিন"
            }, null, _parent2, _scopeId));
            _push2(`</div><div class="flex items-start"${_scopeId}><input id="terms"${ssrIncludeBooleanAttr(Array.isArray(unref(form).terms) ? ssrLooseContain(unref(form).terms, null) : unref(form).terms) ? " checked" : ""} type="checkbox" required class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded mt-1"${_scopeId}><label for="terms" class="ml-2 block text-sm text-gray-700 dark:text-gray-300"${_scopeId}> আমি <a href="#" class="text-primary hover:opacity-80"${_scopeId}>সেবার শর্তাবলী</a> এবং <a href="#" class="text-primary hover:opacity-80"${_scopeId}>গোপনীয়তা নীতি</a> তে সম্মত </label></div><div${_scopeId}>`);
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
                  _push3(` অ্যাকাউন্ট তৈরি করুন `);
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
                    createTextVNode(" অ্যাকাউন্ট তৈরি করুন ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div><div class="text-center pt-4 border-t border-gray-200 dark:border-gray-600"${_scopeId}><p class="text-sm text-gray-600 dark:text-gray-400"${_scopeId}> ইতিমধ্যে অ্যাকাউন্ট আছে? `);
            _push2(ssrRenderComponent(unref(link_default), {
              href: "/login",
              class: "font-medium text-primary hover:opacity-80"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(` সাইন ইন করুন `);
                } else {
                  return [
                    createTextVNode(" সাইন ইন করুন ")
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
                    for: "name",
                    class: "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                  }, {
                    default: withCtx(() => [
                      createTextVNode(" পূর্ণ নাম ")
                    ]),
                    _: 1
                  }),
                  createVNode(_sfc_main$3, {
                    id: "name",
                    modelValue: unref(form).name,
                    "onUpdate:modelValue": ($event) => unref(form).name = $event,
                    type: "text",
                    autocomplete: "name",
                    required: "",
                    error: unref(form).errors.name,
                    placeholder: "আপনার পূর্ণ নাম দিন"
                  }, null, 8, ["modelValue", "onUpdate:modelValue", "error"]),
                  unref(form).errors.name ? (openBlock(), createBlock("p", {
                    key: 0,
                    class: "mt-1 text-sm text-red-600 dark:text-red-400"
                  }, toDisplayString(unref(form).errors.name), 1)) : createCommentVNode("", true)
                ]),
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
                    autocomplete: "new-password",
                    required: "",
                    error: unref(form).errors.password,
                    placeholder: "আপনার পাসওয়ার্ড দিন"
                  }, null, 8, ["modelValue", "onUpdate:modelValue", "error"]),
                  unref(form).errors.password ? (openBlock(), createBlock("p", {
                    key: 0,
                    class: "mt-1 text-sm text-red-600 dark:text-red-400"
                  }, toDisplayString(unref(form).errors.password), 1)) : createCommentVNode("", true)
                ]),
                createVNode("div", null, [
                  createVNode(_sfc_main$2, {
                    for: "password_confirmation",
                    class: "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                  }, {
                    default: withCtx(() => [
                      createTextVNode(" পাসওয়ার্ড নিশ্চিত করুন ")
                    ]),
                    _: 1
                  }),
                  createVNode(_sfc_main$3, {
                    id: "password_confirmation",
                    modelValue: unref(form).password_confirmation,
                    "onUpdate:modelValue": ($event) => unref(form).password_confirmation = $event,
                    type: "password",
                    autocomplete: "new-password",
                    required: "",
                    placeholder: "পাসওয়ার্ড আবার দিন"
                  }, null, 8, ["modelValue", "onUpdate:modelValue"])
                ]),
                createVNode("div", { class: "flex items-start" }, [
                  withDirectives(createVNode("input", {
                    id: "terms",
                    "onUpdate:modelValue": ($event) => unref(form).terms = $event,
                    type: "checkbox",
                    required: "",
                    class: "h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded mt-1"
                  }, null, 8, ["onUpdate:modelValue"]), [
                    [vModelCheckbox, unref(form).terms]
                  ]),
                  createVNode("label", {
                    for: "terms",
                    class: "ml-2 block text-sm text-gray-700 dark:text-gray-300"
                  }, [
                    createTextVNode(" আমি "),
                    createVNode("a", {
                      href: "#",
                      class: "text-primary hover:opacity-80"
                    }, "সেবার শর্তাবলী"),
                    createTextVNode(" এবং "),
                    createVNode("a", {
                      href: "#",
                      class: "text-primary hover:opacity-80"
                    }, "গোপনীয়তা নীতি"),
                    createTextVNode(" তে সম্মত ")
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
                      createTextVNode(" অ্যাকাউন্ট তৈরি করুন ")
                    ]),
                    _: 1
                  }, 8, ["disabled"])
                ]),
                createVNode("div", { class: "text-center pt-4 border-t border-gray-200 dark:border-gray-600" }, [
                  createVNode("p", { class: "text-sm text-gray-600 dark:text-gray-400" }, [
                    createTextVNode(" ইতিমধ্যে অ্যাকাউন্ট আছে? "),
                    createVNode(unref(link_default), {
                      href: "/login",
                      class: "font-medium text-primary hover:opacity-80"
                    }, {
                      default: withCtx(() => [
                        createTextVNode(" সাইন ইন করুন ")
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Auth/Register.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
