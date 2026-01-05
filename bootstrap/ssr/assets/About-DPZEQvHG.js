import { defineComponent, unref, withCtx, createVNode, useSSRContext } from "vue";
import { ssrRenderComponent } from "vue/server-renderer";
import { h as head_default } from "../ssr.js";
import { _ as _sfc_main$1 } from "./AppLayout-BWjM9ngr.js";
import { _ as _sfc_main$2 } from "./Card-DfyUDDxC.js";
import { Shield, Users, Clock, TrendingUp, CheckCircle, Target, Eye, Award, Phone, Mail, MapPin } from "lucide-vue-next";
import "@vue/server-renderer";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
import "./utils-DvCvi0aN.js";
import "clsx";
import "tailwind-merge";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "About",
  __ssrInlineRender: true,
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(head_default), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title${_scopeId}>About Us - FraudShield বাংলাদেশী কুরিয়ার ফ্রড ডিটেকশন সিস্টেম</title><meta name="description" content="FraudShield সম্পর্কে জানুন - বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। আমাদের মিশন, দল এবং সেবা সম্পর্কে বিস্তারিত তথ্য।"${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, "About Us - FraudShield বাংলাদেশী কুরিয়ার ফ্রড ডিটেকশন সিস্টেম"),
              createVNode("meta", {
                name: "description",
                content: "FraudShield সম্পর্কে জানুন - বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। আমাদের মিশন, দল এবং সেবা সম্পর্কে বিস্তারিত তথ্য।"
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$1, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<section class="bg-gradient-to-r from-primary to-purple-600 text-white py-16"${_scopeId}><div class="container mx-auto px-4 text-center"${_scopeId}><h1 class="text-3xl md:text-5xl font-bold mb-6"${_scopeId}> FraudShield সম্পর্কে জানুন </h1><p class="text-xl md:text-2xl mb-8 max-w-4xl mx-auto opacity-90"${_scopeId}> বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম - আপনার ব্যবসাকে নিরাপদ রাখতে আমরা প্রতিশ্রুতিবদ্ধ </p><div class="flex justify-center flex-wrap gap-6 text-lg"${_scopeId}><div class="flex items-center"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(Shield), { class: "w-6 h-6 mr-2 text-yellow-400" }, null, _parent2, _scopeId));
            _push2(`<span${_scopeId}>নিরাপদ যাচাইকরণ</span></div><div class="flex items-center"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(Users), { class: "w-6 h-6 mr-2 text-yellow-400" }, null, _parent2, _scopeId));
            _push2(`<span${_scopeId}>গ্রাহক সুরক্ষা</span></div><div class="flex items-center"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(Clock), { class: "w-6 h-6 mr-2 text-yellow-400" }, null, _parent2, _scopeId));
            _push2(`<span${_scopeId}>২৪/৭ মনিটরিং</span></div><div class="flex items-center"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(TrendingUp), { class: "w-6 h-6 mr-2 text-yellow-400" }, null, _parent2, _scopeId));
            _push2(`<span${_scopeId}>রিয়েল-টাইম ডাটা</span></div></div></div></section><section class="py-16"${_scopeId}><div class="container mx-auto px-4"${_scopeId}><div class="grid md:grid-cols-2 gap-12 items-center"${_scopeId}><div${_scopeId}><h2 class="text-3xl md:text-4xl font-bold text-foreground mb-6"${_scopeId}> আমাদের লক্ষ্য </h2><p class="text-muted-foreground text-lg mb-6 leading-relaxed"${_scopeId}> আমরা অনলাইন বাণিজ্যের জন্য একটি নিরাপদ পরিবেশ তৈরি করতে প্রতিশ্রুতিবদ্ধ যেখানে বিস্তৃত কুরিয়ার যাচাইকরণ সেবা প্রদান করা হয়। আমাদের লক্ষ্য হল ফ্রড নির্মূল করা এবং গ্রাহক ও কুরিয়ার সেবার মধ্যে বিশ্বাস তৈরি করা। </p><div class="space-y-4"${_scopeId}><div class="flex items-start"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(CheckCircle), { class: "w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" }, null, _parent2, _scopeId));
            _push2(`<div${_scopeId}><h3 class="font-semibold text-foreground mb-1"${_scopeId}>রিয়েল-টাইম যাচাইকরণ</h3><p class="text-muted-foreground"${_scopeId}>কুরিয়ার সত্যতা এবং ডেলিভারি স্ট্যাটাসের তাৎক্ষণিক যাচাই</p></div></div><div class="flex items-start"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(CheckCircle), { class: "w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" }, null, _parent2, _scopeId));
            _push2(`<div${_scopeId}><h3 class="font-semibold text-foreground mb-1"${_scopeId}>বিস্তৃত ডাটাবেস</h3><p class="text-muted-foreground"${_scopeId}>বাংলাদেশের সকল প্রধান কুরিয়ার সার্ভিসের তথ্য</p></div></div><div class="flex items-start"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(CheckCircle), { class: "w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" }, null, _parent2, _scopeId));
            _push2(`<div${_scopeId}><h3 class="font-semibold text-foreground mb-1"${_scopeId}>AI-চালিত বিশ্লেষণ</h3><p class="text-muted-foreground"${_scopeId}>উন্নত মেশিন লার্নিং অ্যালগরিদম দ্বারা ফ্রড সনাক্তকরণ</p></div></div></div></div><div${_scopeId}><img src="/assets/banner.jpg" alt="FraudShield Mission" class="rounded-2xl shadow-2xl"${_scopeId}></div></div></div></section><section class="py-16 bg-muted/50"${_scopeId}><div class="container mx-auto px-4"${_scopeId}><div class="text-center mb-12"${_scopeId}><h2 class="text-3xl md:text-4xl font-bold text-foreground mb-4"${_scopeId}> আমাদের বৈশিষ্ট্যসমূহ </h2><p class="text-muted-foreground text-lg max-w-2xl mx-auto"${_scopeId}> আপনার ব্যবসাকে সুরক্ষিত রাখতে আমাদের অত্যাধুনিক প্রযুক্তি ও সেবাসমূহ </p></div><div class="grid md:grid-cols-3 gap-8"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$2, { class: "p-6 text-center hover:shadow-lg transition-shadow" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<div class="w-16 h-16 mx-auto bg-primary/10 rounded-full flex items-center justify-center mb-4"${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(Target), { class: "w-8 h-8 text-primary" }, null, _parent3, _scopeId2));
                  _push3(`</div><h3 class="text-xl font-semibold mb-2"${_scopeId2}>সঠিক তথ্য</h3><p class="text-muted-foreground"${_scopeId2}> সবচেয়ে নির্ভুল এবং আপডেটেড কুরিয়ার তথ্য প্রদান </p>`);
                } else {
                  return [
                    createVNode("div", { class: "w-16 h-16 mx-auto bg-primary/10 rounded-full flex items-center justify-center mb-4" }, [
                      createVNode(unref(Target), { class: "w-8 h-8 text-primary" })
                    ]),
                    createVNode("h3", { class: "text-xl font-semibold mb-2" }, "সঠিক তথ্য"),
                    createVNode("p", { class: "text-muted-foreground" }, " সবচেয়ে নির্ভুল এবং আপডেটেড কুরিয়ার তথ্য প্রদান ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$2, { class: "p-6 text-center hover:shadow-lg transition-shadow" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<div class="w-16 h-16 mx-auto bg-green-500/10 rounded-full flex items-center justify-center mb-4"${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(Eye), { class: "w-8 h-8 text-green-500" }, null, _parent3, _scopeId2));
                  _push3(`</div><h3 class="text-xl font-semibold mb-2"${_scopeId2}>স্বচ্ছতা</h3><p class="text-muted-foreground"${_scopeId2}> গ্রাহক ও বিক্রেতাদের মধ্যে বিশ্বাস তৈরি করা </p>`);
                } else {
                  return [
                    createVNode("div", { class: "w-16 h-16 mx-auto bg-green-500/10 rounded-full flex items-center justify-center mb-4" }, [
                      createVNode(unref(Eye), { class: "w-8 h-8 text-green-500" })
                    ]),
                    createVNode("h3", { class: "text-xl font-semibold mb-2" }, "স্বচ্ছতা"),
                    createVNode("p", { class: "text-muted-foreground" }, " গ্রাহক ও বিক্রেতাদের মধ্যে বিশ্বাস তৈরি করা ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$2, { class: "p-6 text-center hover:shadow-lg transition-shadow" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<div class="w-16 h-16 mx-auto bg-yellow-500/10 rounded-full flex items-center justify-center mb-4"${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(Award), { class: "w-8 h-8 text-yellow-500" }, null, _parent3, _scopeId2));
                  _push3(`</div><h3 class="text-xl font-semibold mb-2"${_scopeId2}>গুণমান</h3><p class="text-muted-foreground"${_scopeId2}> সর্বোচ্চ মানের সেবা নিশ্চিত করা </p>`);
                } else {
                  return [
                    createVNode("div", { class: "w-16 h-16 mx-auto bg-yellow-500/10 rounded-full flex items-center justify-center mb-4" }, [
                      createVNode(unref(Award), { class: "w-8 h-8 text-yellow-500" })
                    ]),
                    createVNode("h3", { class: "text-xl font-semibold mb-2" }, "গুণমান"),
                    createVNode("p", { class: "text-muted-foreground" }, " সর্বোচ্চ মানের সেবা নিশ্চিত করা ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div></div></section><section class="py-16"${_scopeId}><div class="container mx-auto px-4"${_scopeId}><div class="text-center mb-12"${_scopeId}><h2 class="text-3xl md:text-4xl font-bold text-foreground mb-4"${_scopeId}> যোগাযোগ করুন </h2><p class="text-muted-foreground text-lg"${_scopeId}> আমাদের সাথে যোগাযোগ করতে দ্বিধা করবেন না </p></div><div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$2, { class: "p-6 text-center" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(ssrRenderComponent(unref(Phone), { class: "w-10 h-10 mx-auto text-primary mb-4" }, null, _parent3, _scopeId2));
                  _push3(`<h3 class="font-semibold mb-2"${_scopeId2}>ফোন</h3><p class="text-muted-foreground"${_scopeId2}>+880 1309-092748</p>`);
                } else {
                  return [
                    createVNode(unref(Phone), { class: "w-10 h-10 mx-auto text-primary mb-4" }),
                    createVNode("h3", { class: "font-semibold mb-2" }, "ফোন"),
                    createVNode("p", { class: "text-muted-foreground" }, "+880 1309-092748")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$2, { class: "p-6 text-center" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(ssrRenderComponent(unref(Mail), { class: "w-10 h-10 mx-auto text-primary mb-4" }, null, _parent3, _scopeId2));
                  _push3(`<h3 class="font-semibold mb-2"${_scopeId2}>ইমেইল</h3><p class="text-muted-foreground"${_scopeId2}>support@fraudshieldbd.site</p>`);
                } else {
                  return [
                    createVNode(unref(Mail), { class: "w-10 h-10 mx-auto text-primary mb-4" }),
                    createVNode("h3", { class: "font-semibold mb-2" }, "ইমেইল"),
                    createVNode("p", { class: "text-muted-foreground" }, "support@fraudshieldbd.site")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$2, { class: "p-6 text-center" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(ssrRenderComponent(unref(MapPin), { class: "w-10 h-10 mx-auto text-primary mb-4" }, null, _parent3, _scopeId2));
                  _push3(`<h3 class="font-semibold mb-2"${_scopeId2}>ঠিকানা</h3><p class="text-muted-foreground"${_scopeId2}>চট্টগ্রাম, বাংলাদেশ</p>`);
                } else {
                  return [
                    createVNode(unref(MapPin), { class: "w-10 h-10 mx-auto text-primary mb-4" }),
                    createVNode("h3", { class: "font-semibold mb-2" }, "ঠিকানা"),
                    createVNode("p", { class: "text-muted-foreground" }, "চট্টগ্রাম, বাংলাদেশ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div></div></section>`);
          } else {
            return [
              createVNode("section", { class: "bg-gradient-to-r from-primary to-purple-600 text-white py-16" }, [
                createVNode("div", { class: "container mx-auto px-4 text-center" }, [
                  createVNode("h1", { class: "text-3xl md:text-5xl font-bold mb-6" }, " FraudShield সম্পর্কে জানুন "),
                  createVNode("p", { class: "text-xl md:text-2xl mb-8 max-w-4xl mx-auto opacity-90" }, " বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম - আপনার ব্যবসাকে নিরাপদ রাখতে আমরা প্রতিশ্রুতিবদ্ধ "),
                  createVNode("div", { class: "flex justify-center flex-wrap gap-6 text-lg" }, [
                    createVNode("div", { class: "flex items-center" }, [
                      createVNode(unref(Shield), { class: "w-6 h-6 mr-2 text-yellow-400" }),
                      createVNode("span", null, "নিরাপদ যাচাইকরণ")
                    ]),
                    createVNode("div", { class: "flex items-center" }, [
                      createVNode(unref(Users), { class: "w-6 h-6 mr-2 text-yellow-400" }),
                      createVNode("span", null, "গ্রাহক সুরক্ষা")
                    ]),
                    createVNode("div", { class: "flex items-center" }, [
                      createVNode(unref(Clock), { class: "w-6 h-6 mr-2 text-yellow-400" }),
                      createVNode("span", null, "২৪/৭ মনিটরিং")
                    ]),
                    createVNode("div", { class: "flex items-center" }, [
                      createVNode(unref(TrendingUp), { class: "w-6 h-6 mr-2 text-yellow-400" }),
                      createVNode("span", null, "রিয়েল-টাইম ডাটা")
                    ])
                  ])
                ])
              ]),
              createVNode("section", { class: "py-16" }, [
                createVNode("div", { class: "container mx-auto px-4" }, [
                  createVNode("div", { class: "grid md:grid-cols-2 gap-12 items-center" }, [
                    createVNode("div", null, [
                      createVNode("h2", { class: "text-3xl md:text-4xl font-bold text-foreground mb-6" }, " আমাদের লক্ষ্য "),
                      createVNode("p", { class: "text-muted-foreground text-lg mb-6 leading-relaxed" }, " আমরা অনলাইন বাণিজ্যের জন্য একটি নিরাপদ পরিবেশ তৈরি করতে প্রতিশ্রুতিবদ্ধ যেখানে বিস্তৃত কুরিয়ার যাচাইকরণ সেবা প্রদান করা হয়। আমাদের লক্ষ্য হল ফ্রড নির্মূল করা এবং গ্রাহক ও কুরিয়ার সেবার মধ্যে বিশ্বাস তৈরি করা। "),
                      createVNode("div", { class: "space-y-4" }, [
                        createVNode("div", { class: "flex items-start" }, [
                          createVNode(unref(CheckCircle), { class: "w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" }),
                          createVNode("div", null, [
                            createVNode("h3", { class: "font-semibold text-foreground mb-1" }, "রিয়েল-টাইম যাচাইকরণ"),
                            createVNode("p", { class: "text-muted-foreground" }, "কুরিয়ার সত্যতা এবং ডেলিভারি স্ট্যাটাসের তাৎক্ষণিক যাচাই")
                          ])
                        ]),
                        createVNode("div", { class: "flex items-start" }, [
                          createVNode(unref(CheckCircle), { class: "w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" }),
                          createVNode("div", null, [
                            createVNode("h3", { class: "font-semibold text-foreground mb-1" }, "বিস্তৃত ডাটাবেস"),
                            createVNode("p", { class: "text-muted-foreground" }, "বাংলাদেশের সকল প্রধান কুরিয়ার সার্ভিসের তথ্য")
                          ])
                        ]),
                        createVNode("div", { class: "flex items-start" }, [
                          createVNode(unref(CheckCircle), { class: "w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" }),
                          createVNode("div", null, [
                            createVNode("h3", { class: "font-semibold text-foreground mb-1" }, "AI-চালিত বিশ্লেষণ"),
                            createVNode("p", { class: "text-muted-foreground" }, "উন্নত মেশিন লার্নিং অ্যালগরিদম দ্বারা ফ্রড সনাক্তকরণ")
                          ])
                        ])
                      ])
                    ]),
                    createVNode("div", null, [
                      createVNode("img", {
                        src: "/assets/banner.jpg",
                        alt: "FraudShield Mission",
                        class: "rounded-2xl shadow-2xl"
                      })
                    ])
                  ])
                ])
              ]),
              createVNode("section", { class: "py-16 bg-muted/50" }, [
                createVNode("div", { class: "container mx-auto px-4" }, [
                  createVNode("div", { class: "text-center mb-12" }, [
                    createVNode("h2", { class: "text-3xl md:text-4xl font-bold text-foreground mb-4" }, " আমাদের বৈশিষ্ট্যসমূহ "),
                    createVNode("p", { class: "text-muted-foreground text-lg max-w-2xl mx-auto" }, " আপনার ব্যবসাকে সুরক্ষিত রাখতে আমাদের অত্যাধুনিক প্রযুক্তি ও সেবাসমূহ ")
                  ]),
                  createVNode("div", { class: "grid md:grid-cols-3 gap-8" }, [
                    createVNode(_sfc_main$2, { class: "p-6 text-center hover:shadow-lg transition-shadow" }, {
                      default: withCtx(() => [
                        createVNode("div", { class: "w-16 h-16 mx-auto bg-primary/10 rounded-full flex items-center justify-center mb-4" }, [
                          createVNode(unref(Target), { class: "w-8 h-8 text-primary" })
                        ]),
                        createVNode("h3", { class: "text-xl font-semibold mb-2" }, "সঠিক তথ্য"),
                        createVNode("p", { class: "text-muted-foreground" }, " সবচেয়ে নির্ভুল এবং আপডেটেড কুরিয়ার তথ্য প্রদান ")
                      ]),
                      _: 1
                    }),
                    createVNode(_sfc_main$2, { class: "p-6 text-center hover:shadow-lg transition-shadow" }, {
                      default: withCtx(() => [
                        createVNode("div", { class: "w-16 h-16 mx-auto bg-green-500/10 rounded-full flex items-center justify-center mb-4" }, [
                          createVNode(unref(Eye), { class: "w-8 h-8 text-green-500" })
                        ]),
                        createVNode("h3", { class: "text-xl font-semibold mb-2" }, "স্বচ্ছতা"),
                        createVNode("p", { class: "text-muted-foreground" }, " গ্রাহক ও বিক্রেতাদের মধ্যে বিশ্বাস তৈরি করা ")
                      ]),
                      _: 1
                    }),
                    createVNode(_sfc_main$2, { class: "p-6 text-center hover:shadow-lg transition-shadow" }, {
                      default: withCtx(() => [
                        createVNode("div", { class: "w-16 h-16 mx-auto bg-yellow-500/10 rounded-full flex items-center justify-center mb-4" }, [
                          createVNode(unref(Award), { class: "w-8 h-8 text-yellow-500" })
                        ]),
                        createVNode("h3", { class: "text-xl font-semibold mb-2" }, "গুণমান"),
                        createVNode("p", { class: "text-muted-foreground" }, " সর্বোচ্চ মানের সেবা নিশ্চিত করা ")
                      ]),
                      _: 1
                    })
                  ])
                ])
              ]),
              createVNode("section", { class: "py-16" }, [
                createVNode("div", { class: "container mx-auto px-4" }, [
                  createVNode("div", { class: "text-center mb-12" }, [
                    createVNode("h2", { class: "text-3xl md:text-4xl font-bold text-foreground mb-4" }, " যোগাযোগ করুন "),
                    createVNode("p", { class: "text-muted-foreground text-lg" }, " আমাদের সাথে যোগাযোগ করতে দ্বিধা করবেন না ")
                  ]),
                  createVNode("div", { class: "grid md:grid-cols-3 gap-8 max-w-4xl mx-auto" }, [
                    createVNode(_sfc_main$2, { class: "p-6 text-center" }, {
                      default: withCtx(() => [
                        createVNode(unref(Phone), { class: "w-10 h-10 mx-auto text-primary mb-4" }),
                        createVNode("h3", { class: "font-semibold mb-2" }, "ফোন"),
                        createVNode("p", { class: "text-muted-foreground" }, "+880 1309-092748")
                      ]),
                      _: 1
                    }),
                    createVNode(_sfc_main$2, { class: "p-6 text-center" }, {
                      default: withCtx(() => [
                        createVNode(unref(Mail), { class: "w-10 h-10 mx-auto text-primary mb-4" }),
                        createVNode("h3", { class: "font-semibold mb-2" }, "ইমেইল"),
                        createVNode("p", { class: "text-muted-foreground" }, "support@fraudshieldbd.site")
                      ]),
                      _: 1
                    }),
                    createVNode(_sfc_main$2, { class: "p-6 text-center" }, {
                      default: withCtx(() => [
                        createVNode(unref(MapPin), { class: "w-10 h-10 mx-auto text-primary mb-4" }),
                        createVNode("h3", { class: "font-semibold mb-2" }, "ঠিকানা"),
                        createVNode("p", { class: "text-muted-foreground" }, "চট্টগ্রাম, বাংলাদেশ")
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/About.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
