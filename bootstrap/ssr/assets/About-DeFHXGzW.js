import { defineComponent, unref, withCtx, createVNode, resolveDynamicComponent, createTextVNode, createBlock, openBlock, Fragment, renderList, toDisplayString, createCommentVNode, useSSRContext } from "vue";
import { ssrRenderComponent, ssrRenderList, ssrRenderVNode, ssrInterpolate } from "vue/server-renderer";
import { h as head_default } from "../ssr.js";
import { _ as _sfc_main$1 } from "./AppLayout-B7Gogr1C.js";
import { CheckCircle, Shield, Clock, Activity, Zap, Lock, Search, Database, Smartphone, Download, Users, Phone, Mail, MapPin } from "lucide-vue-next";
import "@vue/server-renderer";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "About",
  __ssrInlineRender: true,
  setup(__props) {
    const heroBadges = [
      { icon: CheckCircle, text: "নিরাপদ যাচাইকরণ" },
      { icon: Shield, text: "গ্রাহক সুরক্ষা" },
      { icon: Clock, text: "২৪/৭ মনিটরিং" },
      { icon: Activity, text: "রিয়েল-টাইম ডাটা" }
    ];
    const missionFeatures = [
      { icon: Zap, title: "রিয়েল-টাইম যাচাইকরণ", desc: "কুরিয়ার সত্যতা এবং ডেলিভারি স্ট্যাটাসের তাৎক্ষণিক যাচাই" },
      { icon: Shield, title: "ফ্রড প্রতিরোধ", desc: "প্রতারণামূলক কার্যকলাপ সনাক্ত এবং প্রতিরোধের জন্য উন্নত অ্যালগোরিদম" },
      { icon: Lock, title: "গ্রাহক নিরাপত্তা", desc: "সমস্ত কুরিয়ার লেনদেনের জন্য ব্যাপক সুরক্ষা" }
    ];
    const whyChooseUs = [
      { icon: Search, title: "উন্নত অনুসন্ধান", desc: "কুরিয়ার তথ্য তাৎক্ষণিকভাবে যাচাই করার শক্তিশালী অনুসন্ধান ক্ষমতা" },
      { icon: Database, title: "বিস্তৃত ডাটাবেস", desc: "যাচাইকৃত কুরিয়ার সেবা এবং ডেলিভারি কর্মীদের বিস্তৃত ডাটাবেস" },
      { icon: Smartphone, title: "মোবাইল অ্যাপ", desc: "চলাফেরার সময় কুরিয়ার যাচাইকরণের জন্য আমাদের মোবাইল অ্যাপ ডাউনলোড করুন" }
    ];
    const teamMembers = [
      { icon: Shield, title: "নিরাপত্তা দল", desc: "প্ল্যাটফর্মের নিরাপত্তা নিশ্চিত করতে দক্ষ সাইবার নিরাপত্তা পেশাদাররা" },
      { icon: Users, title: "ডেভেলপমেন্ট দল", desc: "উদ্ভাবনী যাচাইকরণ সমাধান তৈরিতে দক্ষ ডেভেলপাররা" },
      { icon: Phone, title: "সাপোর্ট দল", desc: "যেকোনো যাচাইকরণ প্রয়োজনে সহায়তার জন্য ২৪/৭ গ্রাহক সেবা" }
    ];
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(head_default), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title${_scopeId}>About Us - FraudShield</title><meta name="description" content="FraudShield - বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম"${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, "About Us - FraudShield"),
              createVNode("meta", {
                name: "description",
                content: "FraudShield - বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম"
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$1, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 py-16 md:py-24"${_scopeId}><div class="absolute inset-0 opacity-10"${_scopeId}><div class="absolute top-0 left-1/4 w-72 h-72 bg-indigo-500 rounded-full blur-3xl"${_scopeId}></div><div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full blur-3xl"${_scopeId}></div></div><div class="container mx-auto px-4 relative z-10"${_scopeId}><div class="text-center max-w-4xl mx-auto"${_scopeId}><h1 class="text-3xl md:text-5xl font-bold text-white mb-4 leading-tight"${_scopeId}> FraudShield <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400"${_scopeId}>সম্পর্কে জানুন</span></h1><p class="text-lg md:text-xl text-slate-300 leading-relaxed mb-8"${_scopeId}> বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম - আপনার ব্যবসাকে নিরাপদ রাখতে আমরা প্রতিশ্রুতিবদ্ধ </p><div class="flex flex-wrap justify-center gap-3 md:gap-4"${_scopeId}><!--[-->`);
            ssrRenderList(heroBadges, (badge) => {
              _push2(`<div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 rounded-full"${_scopeId}>`);
              ssrRenderVNode(_push2, createVNode(resolveDynamicComponent(badge.icon), { class: "w-4 h-4 text-indigo-400" }, null), _parent2, _scopeId);
              _push2(`<span class="text-white text-sm font-medium"${_scopeId}>${ssrInterpolate(badge.text)}</span></div>`);
            });
            _push2(`<!--]--></div></div></div></section><section class="py-16 bg-white dark:bg-slate-900"${_scopeId}><div class="container mx-auto px-4"${_scopeId}><div class="text-center max-w-3xl mx-auto mb-12"${_scopeId}><span class="text-indigo-500 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide"${_scopeId}>আমাদের লক্ষ্য</span><p class="text-slate-600 dark:text-slate-400 mt-4 leading-relaxed"${_scopeId}> আমরা অনলাইন বাণিজ্যের জন্য একটি নিরাপদ পরিবেশ তৈরি করতে প্রতিশ্রুতিবদ্ধ যেখানে বিস্তৃত কুরিয়ার যাচাইকরণ সেবা প্রদান করা হয়। আমাদের লক্ষ্য হল ফ্রড নির্মূল করা এবং গ্রাহক ও কুরিয়ার সেবার মধ্যে বিশ্বাস তৈরি করা। </p></div><div class="grid md:grid-cols-3 gap-6"${_scopeId}><!--[-->`);
            ssrRenderList(missionFeatures, (feature) => {
              _push2(`<div class="group p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-all duration-300 text-center"${_scopeId}><div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-indigo-500 group-hover:scale-110 transition-all duration-300"${_scopeId}>`);
              ssrRenderVNode(_push2, createVNode(resolveDynamicComponent(feature.icon), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" }, null), _parent2, _scopeId);
              _push2(`</div><h3 class="font-bold text-lg text-slate-900 dark:text-white mb-2"${_scopeId}>${ssrInterpolate(feature.title)}</h3><p class="text-slate-500 dark:text-slate-400 text-sm"${_scopeId}>${ssrInterpolate(feature.desc)}</p></div>`);
            });
            _push2(`<!--]--></div></div></section><section class="py-16 bg-gradient-to-r from-indigo-600 to-purple-600"${_scopeId}><div class="container mx-auto px-4"${_scopeId}><div class="text-center max-w-3xl mx-auto mb-10"${_scopeId}><h2 class="text-2xl md:text-3xl font-bold text-white mb-3"${_scopeId}>হাজারো ব্যবহারকারীর বিশ্বাস</h2><p class="text-indigo-100"${_scopeId}> নিরাপদ কুরিয়ার যাচাইকরণের জন্য আমাদের প্ল্যাটফর্মে বিশ্বাস রাখেন হাজার হাজার সন্তুষ্ট গ্রাহক </p></div><div class="grid grid-cols-2 gap-6 max-w-2xl mx-auto"${_scopeId}><div class="text-center p-8 bg-white/10 backdrop-blur-sm rounded-2xl"${_scopeId}><div class="text-4xl md:text-5xl font-bold text-white mb-2"${_scopeId}>৩৯,১০১</div><p class="text-indigo-200"${_scopeId}>মোট যাচাইকরণ</p></div><div class="text-center p-8 bg-white/10 backdrop-blur-sm rounded-2xl"${_scopeId}><div class="text-4xl md:text-5xl font-bold text-white mb-2"${_scopeId}>৯৯.৯%</div><p class="text-indigo-200"${_scopeId}>নিরাপত্তার হার</p></div></div></div></section><section class="py-16 bg-slate-50 dark:bg-slate-800/50"${_scopeId}><div class="container mx-auto px-4"${_scopeId}><div class="text-center mb-12"${_scopeId}><span class="text-indigo-500 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide"${_scopeId}>আমাদের সুবিধা</span><h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mt-2 mb-3"${_scopeId}> কেন আমাদের বেছে নিবেন? </h2><p class="text-slate-600 dark:text-slate-400"${_scopeId}> কুরিয়ার ফ্রড থেকে আপনাকে রক্ষা করতে আমরা ব্যাপক নিরাপত্তা সমাধান প্রদান করি </p></div><div class="grid md:grid-cols-3 gap-6"${_scopeId}><!--[-->`);
            ssrRenderList(whyChooseUs, (item) => {
              _push2(`<div class="group p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300"${_scopeId}><div class="w-14 h-14 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-indigo-500 transition-all duration-300"${_scopeId}>`);
              ssrRenderVNode(_push2, createVNode(resolveDynamicComponent(item.icon), { class: "w-7 h-7 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" }, null), _parent2, _scopeId);
              _push2(`</div><h3 class="font-bold text-lg text-slate-900 dark:text-white mb-2"${_scopeId}>${ssrInterpolate(item.title)}</h3><p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed"${_scopeId}>${ssrInterpolate(item.desc)}</p>`);
              if (item.title === "মোবাইল অ্যাপ") {
                _push2(`<a href="#" class="inline-flex items-center gap-2 mt-4 text-indigo-600 dark:text-indigo-400 font-medium text-sm hover:underline"${_scopeId}>`);
                _push2(ssrRenderComponent(unref(Download), { class: "w-4 h-4" }, null, _parent2, _scopeId));
                _push2(` অ্যাপ ডাউনলোড করুন </a>`);
              } else {
                _push2(`<!---->`);
              }
              _push2(`</div>`);
            });
            _push2(`<!--]--></div></div></section><section class="py-16 bg-white dark:bg-slate-900"${_scopeId}><div class="container mx-auto px-4"${_scopeId}><div class="text-center mb-12"${_scopeId}><span class="text-indigo-500 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide"${_scopeId}>আমাদের দল</span><h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mt-2 mb-3"${_scopeId}> নিবেদিতপ্রাণ পেশাদাররা </h2><p class="text-slate-600 dark:text-slate-400"${_scopeId}> সবার জন্য কুরিয়ার সেবা নিরাপদ করতে কাজ করে যাওয়া নিবেদিতপ্রাণ পেশাদাররা </p></div><div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto"${_scopeId}><!--[-->`);
            ssrRenderList(teamMembers, (member) => {
              _push2(`<div class="group text-center p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-all duration-300"${_scopeId}><div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center mb-4 group-hover:bg-indigo-500 transition-all duration-300"${_scopeId}>`);
              ssrRenderVNode(_push2, createVNode(resolveDynamicComponent(member.icon), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" }, null), _parent2, _scopeId);
              _push2(`</div><h3 class="font-bold text-lg text-slate-900 dark:text-white mb-2"${_scopeId}>${ssrInterpolate(member.title)}</h3><p class="text-slate-500 dark:text-slate-400 text-sm"${_scopeId}>${ssrInterpolate(member.desc)}</p></div>`);
            });
            _push2(`<!--]--></div></div></section><section class="py-16 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900"${_scopeId}><div class="container mx-auto px-4"${_scopeId}><div class="text-center mb-10"${_scopeId}><span class="text-indigo-400 font-semibold text-sm uppercase tracking-wide"${_scopeId}>যোগাযোগ করুন</span><h2 class="text-2xl md:text-3xl font-bold text-white mt-2 mb-3"${_scopeId}> আমাদের সাথে যোগাযোগ করুন </h2><p class="text-slate-400"${_scopeId}> আমাদের সেবা সম্পর্কে প্রশ্ন আছে? আপনাকে নিরাপদ রাখতে আমরা এখানে আছি </p></div><div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto"${_scopeId}><div class="group text-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 transition-all duration-300"${_scopeId}><div class="w-14 h-14 mx-auto bg-green-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-500 transition-all"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(Mail), { class: "w-6 h-6 text-green-400 group-hover:text-white transition-colors" }, null, _parent2, _scopeId));
            _push2(`</div><h3 class="font-bold text-white mb-1"${_scopeId}>ইমেইল সাপোর্ট</h3><p class="text-slate-500 text-sm mb-2"${_scopeId}>ইমেইলের মাধ্যমে সহায়তা পান</p><p class="text-indigo-400"${_scopeId}>info@fraudshield.com</p></div><div class="group text-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 transition-all duration-300"${_scopeId}><div class="w-14 h-14 mx-auto bg-indigo-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-indigo-500 transition-all"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(Phone), { class: "w-6 h-6 text-indigo-400 group-hover:text-white transition-colors" }, null, _parent2, _scopeId));
            _push2(`</div><h3 class="font-bold text-white mb-1"${_scopeId}>ফোন সাপোর্ট</h3><p class="text-slate-500 text-sm mb-2"${_scopeId}>যেকোনো সময় আমাদের কল করুন</p><p class="text-indigo-400"${_scopeId}>+৮৮০ ১৩০৯-০৯২৭৪৮</p></div><div class="group text-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 transition-all duration-300"${_scopeId}><div class="w-14 h-14 mx-auto bg-purple-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-purple-500 transition-all"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(MapPin), { class: "w-6 h-6 text-purple-400 group-hover:text-white transition-colors" }, null, _parent2, _scopeId));
            _push2(`</div><h3 class="font-bold text-white mb-1"${_scopeId}>অফিসের ঠিকানা</h3><p class="text-slate-500 text-sm mb-2"${_scopeId}>আমাদের অফিসে আসুন</p><p class="text-indigo-400"${_scopeId}>চট্টগ্রাম, বাংলাদেশ</p></div></div></div></section>`);
          } else {
            return [
              createVNode("section", { class: "relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 py-16 md:py-24" }, [
                createVNode("div", { class: "absolute inset-0 opacity-10" }, [
                  createVNode("div", { class: "absolute top-0 left-1/4 w-72 h-72 bg-indigo-500 rounded-full blur-3xl" }),
                  createVNode("div", { class: "absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full blur-3xl" })
                ]),
                createVNode("div", { class: "container mx-auto px-4 relative z-10" }, [
                  createVNode("div", { class: "text-center max-w-4xl mx-auto" }, [
                    createVNode("h1", { class: "text-3xl md:text-5xl font-bold text-white mb-4 leading-tight" }, [
                      createTextVNode(" FraudShield "),
                      createVNode("span", { class: "text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400" }, "সম্পর্কে জানুন")
                    ]),
                    createVNode("p", { class: "text-lg md:text-xl text-slate-300 leading-relaxed mb-8" }, " বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম - আপনার ব্যবসাকে নিরাপদ রাখতে আমরা প্রতিশ্রুতিবদ্ধ "),
                    createVNode("div", { class: "flex flex-wrap justify-center gap-3 md:gap-4" }, [
                      (openBlock(), createBlock(Fragment, null, renderList(heroBadges, (badge) => {
                        return createVNode("div", {
                          key: badge.text,
                          class: "flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 rounded-full"
                        }, [
                          (openBlock(), createBlock(resolveDynamicComponent(badge.icon), { class: "w-4 h-4 text-indigo-400" })),
                          createVNode("span", { class: "text-white text-sm font-medium" }, toDisplayString(badge.text), 1)
                        ]);
                      }), 64))
                    ])
                  ])
                ])
              ]),
              createVNode("section", { class: "py-16 bg-white dark:bg-slate-900" }, [
                createVNode("div", { class: "container mx-auto px-4" }, [
                  createVNode("div", { class: "text-center max-w-3xl mx-auto mb-12" }, [
                    createVNode("span", { class: "text-indigo-500 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide" }, "আমাদের লক্ষ্য"),
                    createVNode("p", { class: "text-slate-600 dark:text-slate-400 mt-4 leading-relaxed" }, " আমরা অনলাইন বাণিজ্যের জন্য একটি নিরাপদ পরিবেশ তৈরি করতে প্রতিশ্রুতিবদ্ধ যেখানে বিস্তৃত কুরিয়ার যাচাইকরণ সেবা প্রদান করা হয়। আমাদের লক্ষ্য হল ফ্রড নির্মূল করা এবং গ্রাহক ও কুরিয়ার সেবার মধ্যে বিশ্বাস তৈরি করা। ")
                  ]),
                  createVNode("div", { class: "grid md:grid-cols-3 gap-6" }, [
                    (openBlock(), createBlock(Fragment, null, renderList(missionFeatures, (feature) => {
                      return createVNode("div", {
                        key: feature.title,
                        class: "group p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-all duration-300 text-center"
                      }, [
                        createVNode("div", { class: "w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-indigo-500 group-hover:scale-110 transition-all duration-300" }, [
                          (openBlock(), createBlock(resolveDynamicComponent(feature.icon), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" }))
                        ]),
                        createVNode("h3", { class: "font-bold text-lg text-slate-900 dark:text-white mb-2" }, toDisplayString(feature.title), 1),
                        createVNode("p", { class: "text-slate-500 dark:text-slate-400 text-sm" }, toDisplayString(feature.desc), 1)
                      ]);
                    }), 64))
                  ])
                ])
              ]),
              createVNode("section", { class: "py-16 bg-gradient-to-r from-indigo-600 to-purple-600" }, [
                createVNode("div", { class: "container mx-auto px-4" }, [
                  createVNode("div", { class: "text-center max-w-3xl mx-auto mb-10" }, [
                    createVNode("h2", { class: "text-2xl md:text-3xl font-bold text-white mb-3" }, "হাজারো ব্যবহারকারীর বিশ্বাস"),
                    createVNode("p", { class: "text-indigo-100" }, " নিরাপদ কুরিয়ার যাচাইকরণের জন্য আমাদের প্ল্যাটফর্মে বিশ্বাস রাখেন হাজার হাজার সন্তুষ্ট গ্রাহক ")
                  ]),
                  createVNode("div", { class: "grid grid-cols-2 gap-6 max-w-2xl mx-auto" }, [
                    createVNode("div", { class: "text-center p-8 bg-white/10 backdrop-blur-sm rounded-2xl" }, [
                      createVNode("div", { class: "text-4xl md:text-5xl font-bold text-white mb-2" }, "৩৯,১০১"),
                      createVNode("p", { class: "text-indigo-200" }, "মোট যাচাইকরণ")
                    ]),
                    createVNode("div", { class: "text-center p-8 bg-white/10 backdrop-blur-sm rounded-2xl" }, [
                      createVNode("div", { class: "text-4xl md:text-5xl font-bold text-white mb-2" }, "৯৯.৯%"),
                      createVNode("p", { class: "text-indigo-200" }, "নিরাপত্তার হার")
                    ])
                  ])
                ])
              ]),
              createVNode("section", { class: "py-16 bg-slate-50 dark:bg-slate-800/50" }, [
                createVNode("div", { class: "container mx-auto px-4" }, [
                  createVNode("div", { class: "text-center mb-12" }, [
                    createVNode("span", { class: "text-indigo-500 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide" }, "আমাদের সুবিধা"),
                    createVNode("h2", { class: "text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mt-2 mb-3" }, " কেন আমাদের বেছে নিবেন? "),
                    createVNode("p", { class: "text-slate-600 dark:text-slate-400" }, " কুরিয়ার ফ্রড থেকে আপনাকে রক্ষা করতে আমরা ব্যাপক নিরাপত্তা সমাধান প্রদান করি ")
                  ]),
                  createVNode("div", { class: "grid md:grid-cols-3 gap-6" }, [
                    (openBlock(), createBlock(Fragment, null, renderList(whyChooseUs, (item) => {
                      return createVNode("div", {
                        key: item.title,
                        class: "group p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300"
                      }, [
                        createVNode("div", { class: "w-14 h-14 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-indigo-500 transition-all duration-300" }, [
                          (openBlock(), createBlock(resolveDynamicComponent(item.icon), { class: "w-7 h-7 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" }))
                        ]),
                        createVNode("h3", { class: "font-bold text-lg text-slate-900 dark:text-white mb-2" }, toDisplayString(item.title), 1),
                        createVNode("p", { class: "text-slate-500 dark:text-slate-400 text-sm leading-relaxed" }, toDisplayString(item.desc), 1),
                        item.title === "মোবাইল অ্যাপ" ? (openBlock(), createBlock("a", {
                          key: 0,
                          href: "#",
                          class: "inline-flex items-center gap-2 mt-4 text-indigo-600 dark:text-indigo-400 font-medium text-sm hover:underline"
                        }, [
                          createVNode(unref(Download), { class: "w-4 h-4" }),
                          createTextVNode(" অ্যাপ ডাউনলোড করুন ")
                        ])) : createCommentVNode("", true)
                      ]);
                    }), 64))
                  ])
                ])
              ]),
              createVNode("section", { class: "py-16 bg-white dark:bg-slate-900" }, [
                createVNode("div", { class: "container mx-auto px-4" }, [
                  createVNode("div", { class: "text-center mb-12" }, [
                    createVNode("span", { class: "text-indigo-500 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide" }, "আমাদের দল"),
                    createVNode("h2", { class: "text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mt-2 mb-3" }, " নিবেদিতপ্রাণ পেশাদাররা "),
                    createVNode("p", { class: "text-slate-600 dark:text-slate-400" }, " সবার জন্য কুরিয়ার সেবা নিরাপদ করতে কাজ করে যাওয়া নিবেদিতপ্রাণ পেশাদাররা ")
                  ]),
                  createVNode("div", { class: "grid md:grid-cols-3 gap-6 max-w-4xl mx-auto" }, [
                    (openBlock(), createBlock(Fragment, null, renderList(teamMembers, (member) => {
                      return createVNode("div", {
                        key: member.title,
                        class: "group text-center p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-950/30 transition-all duration-300"
                      }, [
                        createVNode("div", { class: "w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center mb-4 group-hover:bg-indigo-500 transition-all duration-300" }, [
                          (openBlock(), createBlock(resolveDynamicComponent(member.icon), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" }))
                        ]),
                        createVNode("h3", { class: "font-bold text-lg text-slate-900 dark:text-white mb-2" }, toDisplayString(member.title), 1),
                        createVNode("p", { class: "text-slate-500 dark:text-slate-400 text-sm" }, toDisplayString(member.desc), 1)
                      ]);
                    }), 64))
                  ])
                ])
              ]),
              createVNode("section", { class: "py-16 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900" }, [
                createVNode("div", { class: "container mx-auto px-4" }, [
                  createVNode("div", { class: "text-center mb-10" }, [
                    createVNode("span", { class: "text-indigo-400 font-semibold text-sm uppercase tracking-wide" }, "যোগাযোগ করুন"),
                    createVNode("h2", { class: "text-2xl md:text-3xl font-bold text-white mt-2 mb-3" }, " আমাদের সাথে যোগাযোগ করুন "),
                    createVNode("p", { class: "text-slate-400" }, " আমাদের সেবা সম্পর্কে প্রশ্ন আছে? আপনাকে নিরাপদ রাখতে আমরা এখানে আছি ")
                  ]),
                  createVNode("div", { class: "grid md:grid-cols-3 gap-6 max-w-4xl mx-auto" }, [
                    createVNode("div", { class: "group text-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 transition-all duration-300" }, [
                      createVNode("div", { class: "w-14 h-14 mx-auto bg-green-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-500 transition-all" }, [
                        createVNode(unref(Mail), { class: "w-6 h-6 text-green-400 group-hover:text-white transition-colors" })
                      ]),
                      createVNode("h3", { class: "font-bold text-white mb-1" }, "ইমেইল সাপোর্ট"),
                      createVNode("p", { class: "text-slate-500 text-sm mb-2" }, "ইমেইলের মাধ্যমে সহায়তা পান"),
                      createVNode("p", { class: "text-indigo-400" }, "info@fraudshield.com")
                    ]),
                    createVNode("div", { class: "group text-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 transition-all duration-300" }, [
                      createVNode("div", { class: "w-14 h-14 mx-auto bg-indigo-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-indigo-500 transition-all" }, [
                        createVNode(unref(Phone), { class: "w-6 h-6 text-indigo-400 group-hover:text-white transition-colors" })
                      ]),
                      createVNode("h3", { class: "font-bold text-white mb-1" }, "ফোন সাপোর্ট"),
                      createVNode("p", { class: "text-slate-500 text-sm mb-2" }, "যেকোনো সময় আমাদের কল করুন"),
                      createVNode("p", { class: "text-indigo-400" }, "+৮৮০ ১৩০৯-০৯২৭৪৮")
                    ]),
                    createVNode("div", { class: "group text-center p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl hover:bg-white/10 transition-all duration-300" }, [
                      createVNode("div", { class: "w-14 h-14 mx-auto bg-purple-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-purple-500 transition-all" }, [
                        createVNode(unref(MapPin), { class: "w-6 h-6 text-purple-400 group-hover:text-white transition-colors" })
                      ]),
                      createVNode("h3", { class: "font-bold text-white mb-1" }, "অফিসের ঠিকানা"),
                      createVNode("p", { class: "text-slate-500 text-sm mb-2" }, "আমাদের অফিসে আসুন"),
                      createVNode("p", { class: "text-indigo-400" }, "চট্টগ্রাম, বাংলাদেশ")
                    ])
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
