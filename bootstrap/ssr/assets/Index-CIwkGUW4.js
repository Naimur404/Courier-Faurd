import { defineComponent, ref, computed, unref, withCtx, createVNode, createTextVNode, resolveDynamicComponent, createBlock, createCommentVNode, openBlock, Teleport, Transition, toDisplayString, Fragment, renderList, withModifiers, useSSRContext } from "vue";
import { ssrRenderComponent, ssrRenderTeleport, ssrRenderClass, ssrInterpolate, ssrRenderList, ssrRenderVNode, ssrIncludeBooleanAttr } from "vue/server-renderer";
import { a as usePage, h as head_default, l as link_default } from "../ssr.js";
import { _ as _sfc_main$1 } from "./AppLayout-B7Gogr1C.js";
import { _ as _sfc_main$3 } from "./Input-pArGf6iX.js";
import { _ as _sfc_main$2 } from "./Label-Cl3p6AAe.js";
import { CheckCircle, AlertCircle, Info, X, Sparkles, Infinity, Star, Shield, Clock, Crown, Check, CreditCard, ArrowRight, Zap, Copy } from "lucide-vue-next";
import "@vue/server-renderer";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
import "./utils-DvCvi0aN.js";
import "clsx";
import "tailwind-merge";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Index",
  __ssrInlineRender: true,
  props: {
    plans: {},
    activeSubscription: {}
  },
  setup(__props) {
    const props = __props;
    const page = usePage();
    const showModal = ref(false);
    const selectedPlan = ref(null);
    const selectedPlanDetails = ref(null);
    const transactionId = ref("");
    const isSubmitting = ref(false);
    const copied = ref(false);
    const notification = ref({
      show: false,
      title: "",
      message: "",
      type: "info"
    });
    const isAuthenticated = computed(() => {
      var _a;
      return ((_a = page.props.auth) == null ? void 0 : _a.user) !== null;
    });
    function showNotification(title, message, type = "info") {
      notification.value = { show: true, title, message, type };
      setTimeout(() => {
        notification.value.show = false;
      }, 5e3);
    }
    function closeNotification() {
      notification.value.show = false;
    }
    function copyNumber() {
      const number = "01309092748";
      navigator.clipboard.writeText(number).then(() => {
        copied.value = true;
        setTimeout(() => copied.value = false, 2e3);
        showNotification("নম্বর কপি হয়েছে!", "bKash নম্বর ক্লিপবোর্ডে কপি হয়েছে", "success");
      }).catch(() => {
        const textArea = document.createElement("textarea");
        textArea.value = number;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("copy");
        document.body.removeChild(textArea);
        copied.value = true;
        setTimeout(() => copied.value = false, 2e3);
        showNotification("নম্বর কপি হয়েছে!", "bKash নম্বর ক্লিপবোর্ডে কপি হয়েছে", "success");
      });
    }
    function subscribeToPlan(planType) {
      selectedPlan.value = planType;
      selectedPlanDetails.value = props.plans[planType];
      showModal.value = true;
    }
    function closeModal() {
      showModal.value = false;
      selectedPlan.value = null;
      selectedPlanDetails.value = null;
      transactionId.value = "";
    }
    async function handleSubmit() {
      var _a;
      if (!transactionId.value.trim()) {
        showNotification("ট্রানজেকশন আইডি প্রয়োজন", "অনুগ্রহ করে bKash ট্রানজেকশন আইডি প্রদান করুন", "error");
        return;
      }
      isSubmitting.value = true;
      try {
        const response = await fetch(`/website-subscriptions/subscribe/${selectedPlan.value}`, {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": ((_a = document.querySelector('meta[name="csrf-token"]')) == null ? void 0 : _a.content) || "",
            "Content-Type": "application/json",
            "Accept": "application/json"
          },
          body: JSON.stringify({
            payment_method: "bkash",
            transaction_id: transactionId.value
          })
        });
        const result = await response.json();
        if (result.success) {
          showNotification("সাবস্ক্রিপশন সফল!", "আপনার সাবস্ক্রিপশন সফলভাবে সক্রিয় হয়েছে। অ্যাডমিনের অনুমোদনের অপেক্ষায় রয়েছে।", "success");
          closeModal();
          setTimeout(() => {
            window.location.reload();
          }, 2e3);
        } else {
          showNotification("সাবস্ক্রিপশন ব্যর্থ", result.message || "সাবস্ক্রিপশন প্রক্রিয়ায় সমস্যা হয়েছে।", "error");
        }
      } catch (error) {
        showNotification("নেটওয়ার্ক ত্রুটি", "সাবস্ক্রিপশন প্রক্রিয়ায় সমস্যা হয়েছে। আবার চেষ্টা করুন।", "error");
      } finally {
        isSubmitting.value = false;
      }
    }
    function formatDate(dateStr) {
      return new Date(dateStr).toLocaleDateString("bn-BD", {
        day: "numeric",
        month: "short",
        year: "numeric",
        hour: "numeric",
        minute: "2-digit"
      });
    }
    const features = [
      { icon: Infinity, title: "সীমাহীন সার্চ", desc: "দৈনিক সীমা ছাড়াই যতবার খুশি কুরিয়ার ভেরিফাই করুন", color: "indigo" },
      { icon: Shield, title: "নির্ভরযোগ্য ডেটা", desc: "১০০% সঠিক এবং আপডেটেড কুরিয়ার তথ্য", color: "green" },
      { icon: Zap, title: "তাৎক্ষণিক ফলাফল", desc: "কোন অপেক্ষা ছাড়াই তুরন্ত ফলাফল পান", color: "blue" }
    ];
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(head_default), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title${_scopeId}>ওয়েবসাইট সাবস্ক্রিপশন - সীমাহীন সার্চ | Courier Fraud</title><meta name="description" content="আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন। দৈনিক ২০ টাকা বা ১৫ দিনের জন্য ৫০ টাকা।"${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, "ওয়েবসাইট সাবস্ক্রিপশন - সীমাহীন সার্চ | Courier Fraud"),
              createVNode("meta", {
                name: "description",
                content: "আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন। দৈনিক ২০ টাকা বা ১৫ দিনের জন্য ৫০ টাকা।"
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$1, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          var _a, _b;
          if (_push2) {
            ssrRenderTeleport(_push2, (_push3) => {
              if (notification.value.show) {
                _push3(`<div class="fixed top-5 right-5 z-[1000] min-w-[320px] max-w-[420px] rounded-2xl shadow-2xl overflow-hidden"${_scopeId}><div class="${ssrRenderClass([
                  "p-4 flex items-start gap-3",
                  notification.value.type === "success" ? "bg-gradient-to-r from-emerald-500 to-green-600" : "",
                  notification.value.type === "error" ? "bg-gradient-to-r from-red-500 to-rose-600" : "",
                  notification.value.type === "info" ? "bg-gradient-to-r from-blue-500 to-indigo-600" : ""
                ])}"${_scopeId}><div class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center"${_scopeId}>`);
                if (notification.value.type === "success") {
                  _push3(ssrRenderComponent(unref(CheckCircle), { class: "w-5 h-5 text-white" }, null, _parent2, _scopeId));
                } else if (notification.value.type === "error") {
                  _push3(ssrRenderComponent(unref(AlertCircle), { class: "w-5 h-5 text-white" }, null, _parent2, _scopeId));
                } else {
                  _push3(ssrRenderComponent(unref(Info), { class: "w-5 h-5 text-white" }, null, _parent2, _scopeId));
                }
                _push3(`</div><div class="flex-1 text-white"${_scopeId}><h4 class="font-bold text-sm"${_scopeId}>${ssrInterpolate(notification.value.title)}</h4><p class="text-sm text-white/90 mt-0.5"${_scopeId}>${ssrInterpolate(notification.value.message)}</p></div><button class="text-white/70 hover:text-white transition"${_scopeId}>`);
                _push3(ssrRenderComponent(unref(X), { class: "w-5 h-5" }, null, _parent2, _scopeId));
                _push3(`</button></div></div>`);
              } else {
                _push3(`<!---->`);
              }
            }, "body", false, _parent2);
            _push2(`<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-950 py-20 md:py-28"${_scopeId}><div class="absolute inset-0 overflow-hidden"${_scopeId}><div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl"${_scopeId}></div><div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl"${_scopeId}></div><div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-full blur-3xl"${_scopeId}></div></div><div class="container mx-auto px-4 relative z-10"${_scopeId}><div class="text-center max-w-4xl mx-auto"${_scopeId}><div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 rounded-full mb-6"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(Sparkles), { class: "w-4 h-4 text-yellow-400" }, null, _parent2, _scopeId));
            _push2(`<span class="text-white/90 text-sm font-medium"${_scopeId}>প্রিমিয়াম ফিচার আনলক করুন</span></div><h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight"${_scopeId}> সীমাহীন সার্চ <span class="block text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400"${_scopeId}> প্ল্যান </span></h1><p class="text-lg md:text-xl text-slate-300 leading-relaxed max-w-2xl mx-auto"${_scopeId}> আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন এবং আপনার ব্যবসাকে নিরাপদ রাখুন </p></div></div></section>`);
            if (__props.activeSubscription) {
              _push2(`<div class="relative -mt-8 z-20 container mx-auto px-4"${_scopeId}><div class="max-w-4xl mx-auto"${_scopeId}><div class="bg-gradient-to-r from-emerald-500 to-green-600 rounded-2xl p-6 shadow-xl shadow-green-500/20"${_scopeId}><div class="flex flex-col md:flex-row items-center justify-between gap-4"${_scopeId}><div class="flex items-center gap-4"${_scopeId}><div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center"${_scopeId}>`);
              _push2(ssrRenderComponent(unref(CheckCircle), { class: "w-7 h-7 text-white" }, null, _parent2, _scopeId));
              _push2(`</div><div class="text-white"${_scopeId}><h3 class="text-xl font-bold"${_scopeId}>সক্রিয় সাবস্ক্রিপশন</h3><p class="text-white/80"${_scopeId}>${ssrInterpolate((_a = __props.plans[__props.activeSubscription.plan_type]) == null ? void 0 : _a.name)} | মেয়াদ শেষ: ${ssrInterpolate(formatDate(__props.activeSubscription.expires_at))}</p></div></div><div class="text-center md:text-right"${_scopeId}><div class="flex items-center gap-2 text-white"${_scopeId}>`);
              _push2(ssrRenderComponent(unref(Infinity), { class: "w-5 h-5" }, null, _parent2, _scopeId));
              _push2(`<span class="text-sm"${_scopeId}>সীমাহীন সার্চ সুবিধা সক্রিয়</span></div><div class="text-2xl font-bold text-white mt-1"${_scopeId}>${ssrInterpolate(__props.activeSubscription.days_remaining)} দিন বাকি</div></div></div></div></div></div>`);
            } else {
              _push2(`<!---->`);
            }
            _push2(`<section class="py-10 md:py-20 bg-slate-50 dark:bg-slate-900"${_scopeId}><div class="container mx-auto px-4"${_scopeId}><div class="text-center mb-8 md:mb-14"${_scopeId}><span class="text-indigo-600 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide"${_scopeId}>মূল্য তালিকা</span><h2 class="text-2xl md:text-4xl font-bold text-slate-900 dark:text-white mt-2 mb-3 md:mb-4"${_scopeId}> আপনার প্রয়োজন অনুযায়ী প্ল্যান বেছে নিন </h2><p class="text-sm md:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto"${_scopeId}> সাশ্রয়ী মূল্যে সীমাহীন সার্চ সুবিধা নিন এবং আপনার ব্যবসাকে ফ্রড থেকে রক্ষা করুন </p></div><div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto"${_scopeId}><!--[-->`);
            ssrRenderList(__props.plans, (plan, planType) => {
              _push2(`<div class="${ssrRenderClass([
                "group relative bg-white dark:bg-slate-800 rounded-3xl overflow-hidden transition-all duration-500 hover:shadow-2xl",
                planType === "weekly" ? "ring-2 ring-indigo-500 shadow-xl shadow-indigo-500/10" : "shadow-lg hover:shadow-xl"
              ])}"${_scopeId}>`);
              if (planType === "weekly") {
                _push2(`<div class="absolute top-0 right-0"${_scopeId}><div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-xs font-bold px-4 py-2 rounded-bl-2xl flex items-center gap-1"${_scopeId}>`);
                _push2(ssrRenderComponent(unref(Star), { class: "w-3 h-3 fill-current" }, null, _parent2, _scopeId));
                _push2(` জনপ্রিয় </div></div>`);
              } else {
                _push2(`<!---->`);
              }
              _push2(`<div class="p-8"${_scopeId}><div class="mb-8"${_scopeId}><h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2"${_scopeId}>${ssrInterpolate(plan.name)}</h3><p class="text-slate-500 dark:text-slate-400 text-sm"${_scopeId}>${ssrInterpolate(plan.description)}</p></div><div class="mb-8"${_scopeId}><div class="flex items-baseline gap-1"${_scopeId}><span class="text-5xl font-bold text-slate-900 dark:text-white"${_scopeId}>৳${ssrInterpolate(plan.price)}</span><span class="text-slate-500 dark:text-slate-400"${_scopeId}>/${ssrInterpolate(plan.duration)}</span></div></div><div class="space-y-4 mb-8"${_scopeId}><div class="flex items-center gap-3"${_scopeId}><div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center"${_scopeId}>`);
              _push2(ssrRenderComponent(unref(Infinity), { class: "w-4 h-4 text-indigo-600 dark:text-indigo-400" }, null, _parent2, _scopeId));
              _push2(`</div><span class="text-slate-700 dark:text-slate-300"${_scopeId}>সীমাহীন সার্চ</span></div><div class="flex items-center gap-3"${_scopeId}><div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center"${_scopeId}>`);
              _push2(ssrRenderComponent(unref(Shield), { class: "w-4 h-4 text-green-600 dark:text-green-400" }, null, _parent2, _scopeId));
              _push2(`</div><span class="text-slate-700 dark:text-slate-300"${_scopeId}>ভেরিফাইড ডেটা</span></div><div class="flex items-center gap-3"${_scopeId}><div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center"${_scopeId}>`);
              _push2(ssrRenderComponent(unref(Clock), { class: "w-4 h-4 text-blue-600 dark:text-blue-400" }, null, _parent2, _scopeId));
              _push2(`</div><span class="text-slate-700 dark:text-slate-300"${_scopeId}>তাৎক্ষণিক ফলাফল</span></div>`);
              if (planType === "weekly") {
                _push2(`<div class="flex items-center gap-3"${_scopeId}><div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/50 rounded-lg flex items-center justify-center"${_scopeId}>`);
                _push2(ssrRenderComponent(unref(Crown), { class: "w-4 h-4 text-yellow-600 dark:text-yellow-400" }, null, _parent2, _scopeId));
                _push2(`</div><span class="text-slate-700 dark:text-slate-300"${_scopeId}>সাশ্রয়ী মূল্য</span></div>`);
              } else {
                _push2(`<!---->`);
              }
              _push2(`</div>`);
              if (isAuthenticated.value) {
                _push2(`<!--[-->`);
                if (__props.activeSubscription) {
                  _push2(`<button disabled class="w-full py-4 px-6 rounded-xl font-bold bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 cursor-not-allowed flex items-center justify-center gap-2"${_scopeId}>`);
                  _push2(ssrRenderComponent(unref(Check), { class: "w-5 h-5" }, null, _parent2, _scopeId));
                  _push2(` ইতিমধ্যে সাবস্ক্রাইব করা আছে </button>`);
                } else {
                  _push2(`<button class="${ssrRenderClass([
                    "w-full py-4 px-6 rounded-xl font-bold transition-all duration-300 flex items-center justify-center gap-2 group-hover:gap-3",
                    planType === "weekly" ? "bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white shadow-lg shadow-indigo-500/30" : "bg-slate-900 dark:bg-white text-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-slate-100"
                  ])}"${_scopeId}>`);
                  _push2(ssrRenderComponent(unref(CreditCard), { class: "w-5 h-5" }, null, _parent2, _scopeId));
                  _push2(` এখনই সাবস্ক্রাইব করুন `);
                  _push2(ssrRenderComponent(unref(ArrowRight), { class: "w-4 h-4 transition-transform group-hover:translate-x-1" }, null, _parent2, _scopeId));
                  _push2(`</button>`);
                }
                _push2(`<!--]-->`);
              } else {
                _push2(ssrRenderComponent(unref(link_default), {
                  href: "/login",
                  class: [
                    "w-full py-4 px-6 rounded-xl font-bold transition-all duration-300 flex items-center justify-center gap-2",
                    planType === "weekly" ? "bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white shadow-lg shadow-indigo-500/30" : "bg-slate-900 dark:bg-white text-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-slate-100"
                  ]
                }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(` লগইন করে সাবস্ক্রাইব করুন `);
                      _push3(ssrRenderComponent(unref(ArrowRight), { class: "w-4 h-4" }, null, _parent3, _scopeId2));
                    } else {
                      return [
                        createTextVNode(" লগইন করে সাবস্ক্রাইব করুন "),
                        createVNode(unref(ArrowRight), { class: "w-4 h-4" })
                      ];
                    }
                  }),
                  _: 2
                }, _parent2, _scopeId));
              }
              _push2(`</div></div>`);
            });
            _push2(`<!--]--></div></div></section><section class="py-10 md:py-20 bg-white dark:bg-slate-800/50"${_scopeId}><div class="container mx-auto px-4"${_scopeId}><div class="text-center mb-8 md:mb-14"${_scopeId}><span class="text-indigo-600 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide"${_scopeId}>সুবিধাসমূহ</span><h2 class="text-2xl md:text-4xl font-bold text-slate-900 dark:text-white mt-2 mb-3 md:mb-4"${_scopeId}> সাবস্ক্রিপশনের সুবিধা </h2><p class="text-sm md:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto"${_scopeId}> আমাদের সাবস্ক্রিপশন নিয়ে পান এই সব বিশেষ সুবিধা </p></div><div class="grid md:grid-cols-3 gap-4 md:gap-8 max-w-5xl mx-auto"${_scopeId}><!--[-->`);
            ssrRenderList(features, (feature) => {
              _push2(`<div class="group text-center p-5 md:p-8 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:bg-gradient-to-br hover:from-indigo-50 hover:to-purple-50 dark:hover:from-indigo-950/30 dark:hover:to-purple-950/30 transition-all duration-300"${_scopeId}><div class="${ssrRenderClass([
                "w-12 h-12 md:w-16 md:h-16 mx-auto rounded-2xl flex items-center justify-center mb-3 md:mb-5 transition-all duration-300 group-hover:scale-110",
                feature.color === "indigo" ? "bg-indigo-100 dark:bg-indigo-900/50" : "",
                feature.color === "green" ? "bg-green-100 dark:bg-green-900/50" : "",
                feature.color === "blue" ? "bg-blue-100 dark:bg-blue-900/50" : ""
              ])}"${_scopeId}>`);
              ssrRenderVNode(_push2, createVNode(resolveDynamicComponent(feature.icon), {
                class: [
                  "w-6 h-6 md:w-8 md:h-8",
                  feature.color === "indigo" ? "text-indigo-600 dark:text-indigo-400" : "",
                  feature.color === "green" ? "text-green-600 dark:text-green-400" : "",
                  feature.color === "blue" ? "text-blue-600 dark:text-blue-400" : ""
                ]
              }, null), _parent2, _scopeId);
              _push2(`</div><h3 class="text-lg md:text-xl font-bold text-slate-900 dark:text-white mb-2 md:mb-3"${_scopeId}>${ssrInterpolate(feature.title)}</h3><p class="text-sm text-slate-600 dark:text-slate-400"${_scopeId}>${ssrInterpolate(feature.desc)}</p></div>`);
            });
            _push2(`<!--]--></div></div></section>`);
            ssrRenderTeleport(_push2, (_push3) => {
              var _a2, _b2;
              if (showModal.value) {
                _push3(`<div class="fixed inset-0 z-50 flex items-center justify-center p-4"${_scopeId}><div class="absolute inset-0 bg-black/60 backdrop-blur-sm"${_scopeId}></div>`);
                if (showModal.value) {
                  _push3(`<div class="relative bg-white dark:bg-slate-800 rounded-3xl p-8 max-w-md w-full shadow-2xl"${_scopeId}><button class="absolute top-4 right-4 w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition"${_scopeId}>`);
                  _push3(ssrRenderComponent(unref(X), { class: "w-5 h-5" }, null, _parent2, _scopeId));
                  _push3(`</button><div class="text-center mb-6"${_scopeId}><div class="w-16 h-16 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4"${_scopeId}>`);
                  _push3(ssrRenderComponent(unref(CreditCard), { class: "w-8 h-8 text-white" }, null, _parent2, _scopeId));
                  _push3(`</div><h3 class="text-2xl font-bold text-slate-900 dark:text-white"${_scopeId}>${ssrInterpolate((_a2 = selectedPlanDetails.value) == null ? void 0 : _a2.name)}</h3><p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mt-2"${_scopeId}> ৳${ssrInterpolate((_b2 = selectedPlanDetails.value) == null ? void 0 : _b2.price)}</p></div><form${_scopeId}><div class="mb-6"${_scopeId}>`);
                  _push3(ssrRenderComponent(unref(_sfc_main$2), { class: "block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3" }, {
                    default: withCtx((_2, _push4, _parent3, _scopeId2) => {
                      if (_push4) {
                        _push4(`পেমেন্ট মেথড`);
                      } else {
                        return [
                          createTextVNode("পেমেন্ট মেথড")
                        ];
                      }
                    }),
                    _: 1
                  }, _parent2, _scopeId));
                  _push3(`<div class="bg-gradient-to-br from-pink-50 to-rose-50 dark:from-pink-950/30 dark:to-rose-950/30 border border-pink-200 dark:border-pink-800/50 rounded-2xl p-5"${_scopeId}><div class="flex items-center gap-3 mb-4"${_scopeId}><div class="bg-pink-600 text-white font-bold px-3 py-1 rounded-lg text-sm"${_scopeId}>bKash</div><span class="text-slate-700 dark:text-slate-300 font-medium"${_scopeId}>পেমেন্ট করুন</span></div><div class="bg-white dark:bg-slate-700 rounded-xl p-4 mb-4 flex items-center justify-between"${_scopeId}><span class="font-mono text-xl font-bold text-slate-900 dark:text-white"${_scopeId}>01309092748</span><button type="button" class="${ssrRenderClass([
                    "flex items-center gap-2 px-4 py-2 rounded-lg font-medium text-sm transition-all",
                    copied.value ? "bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300" : "bg-pink-100 hover:bg-pink-200 text-pink-700 dark:bg-pink-900/50 dark:hover:bg-pink-800 dark:text-pink-300"
                  ])}"${_scopeId}>`);
                  if (copied.value) {
                    _push3(ssrRenderComponent(unref(Check), { class: "w-4 h-4" }, null, _parent2, _scopeId));
                  } else {
                    _push3(ssrRenderComponent(unref(Copy), { class: "w-4 h-4" }, null, _parent2, _scopeId));
                  }
                  _push3(` ${ssrInterpolate(copied.value ? "কপি হয়েছে" : "কপি")}</button></div><div class="text-sm text-slate-600 dark:text-slate-400"${_scopeId}><p class="font-semibold mb-2"${_scopeId}>পেমেন্ট প্রক্রিয়া:</p><ol class="space-y-1.5"${_scopeId}><li class="flex items-start gap-2"${_scopeId}><span class="w-5 h-5 bg-pink-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"${_scopeId}>১</span><span${_scopeId}>উপরের নম্বরে bKash Send Money করুন</span></li><li class="flex items-start gap-2"${_scopeId}><span class="w-5 h-5 bg-pink-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"${_scopeId}>২</span><span${_scopeId}>ট্রানজেকশন আইডি নিচে লিখুন</span></li><li class="flex items-start gap-2"${_scopeId}><span class="w-5 h-5 bg-pink-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"${_scopeId}>৩</span><span${_scopeId}>সাবস্ক্রাইব বাটনে ক্লিক করুন</span></li></ol></div></div></div><div class="mb-6"${_scopeId}>`);
                  _push3(ssrRenderComponent(unref(_sfc_main$2), { class: "block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2" }, {
                    default: withCtx((_2, _push4, _parent3, _scopeId2) => {
                      if (_push4) {
                        _push4(`ট্রানজেকশন আইডি *`);
                      } else {
                        return [
                          createTextVNode("ট্রানজেকশন আইডি *")
                        ];
                      }
                    }),
                    _: 1
                  }, _parent2, _scopeId));
                  _push3(ssrRenderComponent(unref(_sfc_main$3), {
                    modelValue: transactionId.value,
                    "onUpdate:modelValue": ($event) => transactionId.value = $event,
                    type: "text",
                    placeholder: "bKash ট্রানজেকশন আইডি লিখুন",
                    class: "h-12 rounded-xl",
                    required: ""
                  }, null, _parent2, _scopeId));
                  _push3(`<p class="text-xs text-slate-500 dark:text-slate-400 mt-2"${_scopeId}>পেমেন্ট সম্পন্ন হওয়ার পর যে আইডি পাবেন তা এখানে লিখুন</p></div><div class="flex gap-3"${_scopeId}><button type="button" class="flex-1 py-3 px-4 rounded-xl font-semibold bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 transition"${_scopeId}> বাতিল </button><button type="submit"${ssrIncludeBooleanAttr(isSubmitting.value) ? " disabled" : ""} class="flex-1 py-3 px-4 rounded-xl font-semibold bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"${_scopeId}>`);
                  if (isSubmitting.value) {
                    _push3(`<svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"${_scopeId}><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"${_scopeId}></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"${_scopeId}></path></svg>`);
                  } else {
                    _push3(`<!---->`);
                  }
                  _push3(` সাবস্ক্রাইব করুন </button></div></form></div>`);
                } else {
                  _push3(`<!---->`);
                }
                _push3(`</div>`);
              } else {
                _push3(`<!---->`);
              }
            }, "body", false, _parent2);
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
                      class: "fixed top-5 right-5 z-[1000] min-w-[320px] max-w-[420px] rounded-2xl shadow-2xl overflow-hidden"
                    }, [
                      createVNode("div", {
                        class: [
                          "p-4 flex items-start gap-3",
                          notification.value.type === "success" ? "bg-gradient-to-r from-emerald-500 to-green-600" : "",
                          notification.value.type === "error" ? "bg-gradient-to-r from-red-500 to-rose-600" : "",
                          notification.value.type === "info" ? "bg-gradient-to-r from-blue-500 to-indigo-600" : ""
                        ]
                      }, [
                        createVNode("div", { class: "flex-shrink-0 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center" }, [
                          notification.value.type === "success" ? (openBlock(), createBlock(unref(CheckCircle), {
                            key: 0,
                            class: "w-5 h-5 text-white"
                          })) : notification.value.type === "error" ? (openBlock(), createBlock(unref(AlertCircle), {
                            key: 1,
                            class: "w-5 h-5 text-white"
                          })) : (openBlock(), createBlock(unref(Info), {
                            key: 2,
                            class: "w-5 h-5 text-white"
                          }))
                        ]),
                        createVNode("div", { class: "flex-1 text-white" }, [
                          createVNode("h4", { class: "font-bold text-sm" }, toDisplayString(notification.value.title), 1),
                          createVNode("p", { class: "text-sm text-white/90 mt-0.5" }, toDisplayString(notification.value.message), 1)
                        ]),
                        createVNode("button", {
                          onClick: closeNotification,
                          class: "text-white/70 hover:text-white transition"
                        }, [
                          createVNode(unref(X), { class: "w-5 h-5" })
                        ])
                      ], 2)
                    ])) : createCommentVNode("", true)
                  ]),
                  _: 1
                })
              ])),
              createVNode("section", { class: "relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-950 py-20 md:py-28" }, [
                createVNode("div", { class: "absolute inset-0 overflow-hidden" }, [
                  createVNode("div", { class: "absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl" }),
                  createVNode("div", { class: "absolute bottom-1/4 right-1/4 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl" }),
                  createVNode("div", { class: "absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-full blur-3xl" })
                ]),
                createVNode("div", { class: "container mx-auto px-4 relative z-10" }, [
                  createVNode("div", { class: "text-center max-w-4xl mx-auto" }, [
                    createVNode("div", { class: "inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 rounded-full mb-6" }, [
                      createVNode(unref(Sparkles), { class: "w-4 h-4 text-yellow-400" }),
                      createVNode("span", { class: "text-white/90 text-sm font-medium" }, "প্রিমিয়াম ফিচার আনলক করুন")
                    ]),
                    createVNode("h1", { class: "text-4xl md:text-6xl font-bold text-white mb-6 leading-tight" }, [
                      createTextVNode(" সীমাহীন সার্চ "),
                      createVNode("span", { class: "block text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400" }, " প্ল্যান ")
                    ]),
                    createVNode("p", { class: "text-lg md:text-xl text-slate-300 leading-relaxed max-w-2xl mx-auto" }, " আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন এবং আপনার ব্যবসাকে নিরাপদ রাখুন ")
                  ])
                ])
              ]),
              __props.activeSubscription ? (openBlock(), createBlock("div", {
                key: 0,
                class: "relative -mt-8 z-20 container mx-auto px-4"
              }, [
                createVNode("div", { class: "max-w-4xl mx-auto" }, [
                  createVNode("div", { class: "bg-gradient-to-r from-emerald-500 to-green-600 rounded-2xl p-6 shadow-xl shadow-green-500/20" }, [
                    createVNode("div", { class: "flex flex-col md:flex-row items-center justify-between gap-4" }, [
                      createVNode("div", { class: "flex items-center gap-4" }, [
                        createVNode("div", { class: "w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center" }, [
                          createVNode(unref(CheckCircle), { class: "w-7 h-7 text-white" })
                        ]),
                        createVNode("div", { class: "text-white" }, [
                          createVNode("h3", { class: "text-xl font-bold" }, "সক্রিয় সাবস্ক্রিপশন"),
                          createVNode("p", { class: "text-white/80" }, toDisplayString((_b = __props.plans[__props.activeSubscription.plan_type]) == null ? void 0 : _b.name) + " | মেয়াদ শেষ: " + toDisplayString(formatDate(__props.activeSubscription.expires_at)), 1)
                        ])
                      ]),
                      createVNode("div", { class: "text-center md:text-right" }, [
                        createVNode("div", { class: "flex items-center gap-2 text-white" }, [
                          createVNode(unref(Infinity), { class: "w-5 h-5" }),
                          createVNode("span", { class: "text-sm" }, "সীমাহীন সার্চ সুবিধা সক্রিয়")
                        ]),
                        createVNode("div", { class: "text-2xl font-bold text-white mt-1" }, toDisplayString(__props.activeSubscription.days_remaining) + " দিন বাকি", 1)
                      ])
                    ])
                  ])
                ])
              ])) : createCommentVNode("", true),
              createVNode("section", { class: "py-10 md:py-20 bg-slate-50 dark:bg-slate-900" }, [
                createVNode("div", { class: "container mx-auto px-4" }, [
                  createVNode("div", { class: "text-center mb-8 md:mb-14" }, [
                    createVNode("span", { class: "text-indigo-600 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide" }, "মূল্য তালিকা"),
                    createVNode("h2", { class: "text-2xl md:text-4xl font-bold text-slate-900 dark:text-white mt-2 mb-3 md:mb-4" }, " আপনার প্রয়োজন অনুযায়ী প্ল্যান বেছে নিন "),
                    createVNode("p", { class: "text-sm md:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto" }, " সাশ্রয়ী মূল্যে সীমাহীন সার্চ সুবিধা নিন এবং আপনার ব্যবসাকে ফ্রড থেকে রক্ষা করুন ")
                  ]),
                  createVNode("div", { class: "grid md:grid-cols-2 gap-8 max-w-4xl mx-auto" }, [
                    (openBlock(true), createBlock(Fragment, null, renderList(__props.plans, (plan, planType) => {
                      return openBlock(), createBlock("div", {
                        key: planType,
                        class: [
                          "group relative bg-white dark:bg-slate-800 rounded-3xl overflow-hidden transition-all duration-500 hover:shadow-2xl",
                          planType === "weekly" ? "ring-2 ring-indigo-500 shadow-xl shadow-indigo-500/10" : "shadow-lg hover:shadow-xl"
                        ]
                      }, [
                        planType === "weekly" ? (openBlock(), createBlock("div", {
                          key: 0,
                          class: "absolute top-0 right-0"
                        }, [
                          createVNode("div", { class: "bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-xs font-bold px-4 py-2 rounded-bl-2xl flex items-center gap-1" }, [
                            createVNode(unref(Star), { class: "w-3 h-3 fill-current" }),
                            createTextVNode(" জনপ্রিয় ")
                          ])
                        ])) : createCommentVNode("", true),
                        createVNode("div", { class: "p-8" }, [
                          createVNode("div", { class: "mb-8" }, [
                            createVNode("h3", { class: "text-xl font-bold text-slate-900 dark:text-white mb-2" }, toDisplayString(plan.name), 1),
                            createVNode("p", { class: "text-slate-500 dark:text-slate-400 text-sm" }, toDisplayString(plan.description), 1)
                          ]),
                          createVNode("div", { class: "mb-8" }, [
                            createVNode("div", { class: "flex items-baseline gap-1" }, [
                              createVNode("span", { class: "text-5xl font-bold text-slate-900 dark:text-white" }, "৳" + toDisplayString(plan.price), 1),
                              createVNode("span", { class: "text-slate-500 dark:text-slate-400" }, "/" + toDisplayString(plan.duration), 1)
                            ])
                          ]),
                          createVNode("div", { class: "space-y-4 mb-8" }, [
                            createVNode("div", { class: "flex items-center gap-3" }, [
                              createVNode("div", { class: "w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center" }, [
                                createVNode(unref(Infinity), { class: "w-4 h-4 text-indigo-600 dark:text-indigo-400" })
                              ]),
                              createVNode("span", { class: "text-slate-700 dark:text-slate-300" }, "সীমাহীন সার্চ")
                            ]),
                            createVNode("div", { class: "flex items-center gap-3" }, [
                              createVNode("div", { class: "w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center" }, [
                                createVNode(unref(Shield), { class: "w-4 h-4 text-green-600 dark:text-green-400" })
                              ]),
                              createVNode("span", { class: "text-slate-700 dark:text-slate-300" }, "ভেরিফাইড ডেটা")
                            ]),
                            createVNode("div", { class: "flex items-center gap-3" }, [
                              createVNode("div", { class: "w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center" }, [
                                createVNode(unref(Clock), { class: "w-4 h-4 text-blue-600 dark:text-blue-400" })
                              ]),
                              createVNode("span", { class: "text-slate-700 dark:text-slate-300" }, "তাৎক্ষণিক ফলাফল")
                            ]),
                            planType === "weekly" ? (openBlock(), createBlock("div", {
                              key: 0,
                              class: "flex items-center gap-3"
                            }, [
                              createVNode("div", { class: "w-8 h-8 bg-yellow-100 dark:bg-yellow-900/50 rounded-lg flex items-center justify-center" }, [
                                createVNode(unref(Crown), { class: "w-4 h-4 text-yellow-600 dark:text-yellow-400" })
                              ]),
                              createVNode("span", { class: "text-slate-700 dark:text-slate-300" }, "সাশ্রয়ী মূল্য")
                            ])) : createCommentVNode("", true)
                          ]),
                          isAuthenticated.value ? (openBlock(), createBlock(Fragment, { key: 0 }, [
                            __props.activeSubscription ? (openBlock(), createBlock("button", {
                              key: 0,
                              disabled: "",
                              class: "w-full py-4 px-6 rounded-xl font-bold bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 cursor-not-allowed flex items-center justify-center gap-2"
                            }, [
                              createVNode(unref(Check), { class: "w-5 h-5" }),
                              createTextVNode(" ইতিমধ্যে সাবস্ক্রাইব করা আছে ")
                            ])) : (openBlock(), createBlock("button", {
                              key: 1,
                              onClick: ($event) => subscribeToPlan(planType),
                              class: [
                                "w-full py-4 px-6 rounded-xl font-bold transition-all duration-300 flex items-center justify-center gap-2 group-hover:gap-3",
                                planType === "weekly" ? "bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white shadow-lg shadow-indigo-500/30" : "bg-slate-900 dark:bg-white text-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-slate-100"
                              ]
                            }, [
                              createVNode(unref(CreditCard), { class: "w-5 h-5" }),
                              createTextVNode(" এখনই সাবস্ক্রাইব করুন "),
                              createVNode(unref(ArrowRight), { class: "w-4 h-4 transition-transform group-hover:translate-x-1" })
                            ], 10, ["onClick"]))
                          ], 64)) : (openBlock(), createBlock(unref(link_default), {
                            key: 1,
                            href: "/login",
                            class: [
                              "w-full py-4 px-6 rounded-xl font-bold transition-all duration-300 flex items-center justify-center gap-2",
                              planType === "weekly" ? "bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white shadow-lg shadow-indigo-500/30" : "bg-slate-900 dark:bg-white text-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-slate-100"
                            ]
                          }, {
                            default: withCtx(() => [
                              createTextVNode(" লগইন করে সাবস্ক্রাইব করুন "),
                              createVNode(unref(ArrowRight), { class: "w-4 h-4" })
                            ]),
                            _: 1
                          }, 8, ["class"]))
                        ])
                      ], 2);
                    }), 128))
                  ])
                ])
              ]),
              createVNode("section", { class: "py-10 md:py-20 bg-white dark:bg-slate-800/50" }, [
                createVNode("div", { class: "container mx-auto px-4" }, [
                  createVNode("div", { class: "text-center mb-8 md:mb-14" }, [
                    createVNode("span", { class: "text-indigo-600 dark:text-indigo-400 font-semibold text-sm uppercase tracking-wide" }, "সুবিধাসমূহ"),
                    createVNode("h2", { class: "text-2xl md:text-4xl font-bold text-slate-900 dark:text-white mt-2 mb-3 md:mb-4" }, " সাবস্ক্রিপশনের সুবিধা "),
                    createVNode("p", { class: "text-sm md:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto" }, " আমাদের সাবস্ক্রিপশন নিয়ে পান এই সব বিশেষ সুবিধা ")
                  ]),
                  createVNode("div", { class: "grid md:grid-cols-3 gap-4 md:gap-8 max-w-5xl mx-auto" }, [
                    (openBlock(), createBlock(Fragment, null, renderList(features, (feature) => {
                      return createVNode("div", {
                        key: feature.title,
                        class: "group text-center p-5 md:p-8 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:bg-gradient-to-br hover:from-indigo-50 hover:to-purple-50 dark:hover:from-indigo-950/30 dark:hover:to-purple-950/30 transition-all duration-300"
                      }, [
                        createVNode("div", {
                          class: [
                            "w-12 h-12 md:w-16 md:h-16 mx-auto rounded-2xl flex items-center justify-center mb-3 md:mb-5 transition-all duration-300 group-hover:scale-110",
                            feature.color === "indigo" ? "bg-indigo-100 dark:bg-indigo-900/50" : "",
                            feature.color === "green" ? "bg-green-100 dark:bg-green-900/50" : "",
                            feature.color === "blue" ? "bg-blue-100 dark:bg-blue-900/50" : ""
                          ]
                        }, [
                          (openBlock(), createBlock(resolveDynamicComponent(feature.icon), {
                            class: [
                              "w-6 h-6 md:w-8 md:h-8",
                              feature.color === "indigo" ? "text-indigo-600 dark:text-indigo-400" : "",
                              feature.color === "green" ? "text-green-600 dark:text-green-400" : "",
                              feature.color === "blue" ? "text-blue-600 dark:text-blue-400" : ""
                            ]
                          }, null, 8, ["class"]))
                        ], 2),
                        createVNode("h3", { class: "text-lg md:text-xl font-bold text-slate-900 dark:text-white mb-2 md:mb-3" }, toDisplayString(feature.title), 1),
                        createVNode("p", { class: "text-sm text-slate-600 dark:text-slate-400" }, toDisplayString(feature.desc), 1)
                      ]);
                    }), 64))
                  ])
                ])
              ]),
              (openBlock(), createBlock(Teleport, { to: "body" }, [
                createVNode(Transition, {
                  "enter-active-class": "transition ease-out duration-200",
                  "enter-from-class": "opacity-0",
                  "enter-to-class": "opacity-100",
                  "leave-active-class": "transition ease-in duration-150",
                  "leave-from-class": "opacity-100",
                  "leave-to-class": "opacity-0"
                }, {
                  default: withCtx(() => [
                    showModal.value ? (openBlock(), createBlock("div", {
                      key: 0,
                      class: "fixed inset-0 z-50 flex items-center justify-center p-4"
                    }, [
                      createVNode("div", {
                        class: "absolute inset-0 bg-black/60 backdrop-blur-sm",
                        onClick: closeModal
                      }),
                      createVNode(Transition, {
                        "enter-active-class": "transition ease-out duration-300",
                        "enter-from-class": "opacity-0 scale-95 translate-y-4",
                        "enter-to-class": "opacity-100 scale-100 translate-y-0",
                        "leave-active-class": "transition ease-in duration-200",
                        "leave-from-class": "opacity-100 scale-100",
                        "leave-to-class": "opacity-0 scale-95"
                      }, {
                        default: withCtx(() => {
                          var _a2, _b2;
                          return [
                            showModal.value ? (openBlock(), createBlock("div", {
                              key: 0,
                              class: "relative bg-white dark:bg-slate-800 rounded-3xl p-8 max-w-md w-full shadow-2xl"
                            }, [
                              createVNode("button", {
                                onClick: closeModal,
                                class: "absolute top-4 right-4 w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition"
                              }, [
                                createVNode(unref(X), { class: "w-5 h-5" })
                              ]),
                              createVNode("div", { class: "text-center mb-6" }, [
                                createVNode("div", { class: "w-16 h-16 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4" }, [
                                  createVNode(unref(CreditCard), { class: "w-8 h-8 text-white" })
                                ]),
                                createVNode("h3", { class: "text-2xl font-bold text-slate-900 dark:text-white" }, toDisplayString((_a2 = selectedPlanDetails.value) == null ? void 0 : _a2.name), 1),
                                createVNode("p", { class: "text-3xl font-bold text-indigo-600 dark:text-indigo-400 mt-2" }, " ৳" + toDisplayString((_b2 = selectedPlanDetails.value) == null ? void 0 : _b2.price), 1)
                              ]),
                              createVNode("form", {
                                onSubmit: withModifiers(handleSubmit, ["prevent"])
                              }, [
                                createVNode("div", { class: "mb-6" }, [
                                  createVNode(unref(_sfc_main$2), { class: "block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3" }, {
                                    default: withCtx(() => [
                                      createTextVNode("পেমেন্ট মেথড")
                                    ]),
                                    _: 1
                                  }),
                                  createVNode("div", { class: "bg-gradient-to-br from-pink-50 to-rose-50 dark:from-pink-950/30 dark:to-rose-950/30 border border-pink-200 dark:border-pink-800/50 rounded-2xl p-5" }, [
                                    createVNode("div", { class: "flex items-center gap-3 mb-4" }, [
                                      createVNode("div", { class: "bg-pink-600 text-white font-bold px-3 py-1 rounded-lg text-sm" }, "bKash"),
                                      createVNode("span", { class: "text-slate-700 dark:text-slate-300 font-medium" }, "পেমেন্ট করুন")
                                    ]),
                                    createVNode("div", { class: "bg-white dark:bg-slate-700 rounded-xl p-4 mb-4 flex items-center justify-between" }, [
                                      createVNode("span", { class: "font-mono text-xl font-bold text-slate-900 dark:text-white" }, "01309092748"),
                                      createVNode("button", {
                                        type: "button",
                                        onClick: copyNumber,
                                        class: [
                                          "flex items-center gap-2 px-4 py-2 rounded-lg font-medium text-sm transition-all",
                                          copied.value ? "bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300" : "bg-pink-100 hover:bg-pink-200 text-pink-700 dark:bg-pink-900/50 dark:hover:bg-pink-800 dark:text-pink-300"
                                        ]
                                      }, [
                                        copied.value ? (openBlock(), createBlock(unref(Check), {
                                          key: 0,
                                          class: "w-4 h-4"
                                        })) : (openBlock(), createBlock(unref(Copy), {
                                          key: 1,
                                          class: "w-4 h-4"
                                        })),
                                        createTextVNode(" " + toDisplayString(copied.value ? "কপি হয়েছে" : "কপি"), 1)
                                      ], 2)
                                    ]),
                                    createVNode("div", { class: "text-sm text-slate-600 dark:text-slate-400" }, [
                                      createVNode("p", { class: "font-semibold mb-2" }, "পেমেন্ট প্রক্রিয়া:"),
                                      createVNode("ol", { class: "space-y-1.5" }, [
                                        createVNode("li", { class: "flex items-start gap-2" }, [
                                          createVNode("span", { class: "w-5 h-5 bg-pink-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0" }, "১"),
                                          createVNode("span", null, "উপরের নম্বরে bKash Send Money করুন")
                                        ]),
                                        createVNode("li", { class: "flex items-start gap-2" }, [
                                          createVNode("span", { class: "w-5 h-5 bg-pink-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0" }, "২"),
                                          createVNode("span", null, "ট্রানজেকশন আইডি নিচে লিখুন")
                                        ]),
                                        createVNode("li", { class: "flex items-start gap-2" }, [
                                          createVNode("span", { class: "w-5 h-5 bg-pink-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0" }, "৩"),
                                          createVNode("span", null, "সাবস্ক্রাইব বাটনে ক্লিক করুন")
                                        ])
                                      ])
                                    ])
                                  ])
                                ]),
                                createVNode("div", { class: "mb-6" }, [
                                  createVNode(unref(_sfc_main$2), { class: "block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2" }, {
                                    default: withCtx(() => [
                                      createTextVNode("ট্রানজেকশন আইডি *")
                                    ]),
                                    _: 1
                                  }),
                                  createVNode(unref(_sfc_main$3), {
                                    modelValue: transactionId.value,
                                    "onUpdate:modelValue": ($event) => transactionId.value = $event,
                                    type: "text",
                                    placeholder: "bKash ট্রানজেকশন আইডি লিখুন",
                                    class: "h-12 rounded-xl",
                                    required: ""
                                  }, null, 8, ["modelValue", "onUpdate:modelValue"]),
                                  createVNode("p", { class: "text-xs text-slate-500 dark:text-slate-400 mt-2" }, "পেমেন্ট সম্পন্ন হওয়ার পর যে আইডি পাবেন তা এখানে লিখুন")
                                ]),
                                createVNode("div", { class: "flex gap-3" }, [
                                  createVNode("button", {
                                    type: "button",
                                    onClick: closeModal,
                                    class: "flex-1 py-3 px-4 rounded-xl font-semibold bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 transition"
                                  }, " বাতিল "),
                                  createVNode("button", {
                                    type: "submit",
                                    disabled: isSubmitting.value,
                                    class: "flex-1 py-3 px-4 rounded-xl font-semibold bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                                  }, [
                                    isSubmitting.value ? (openBlock(), createBlock("svg", {
                                      key: 0,
                                      class: "animate-spin w-5 h-5",
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
                                    createTextVNode(" সাবস্ক্রাইব করুন ")
                                  ], 8, ["disabled"])
                                ])
                              ], 32)
                            ])) : createCommentVNode("", true)
                          ];
                        }),
                        _: 1
                      })
                    ])) : createCommentVNode("", true)
                  ]),
                  _: 1
                })
              ]))
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/WebsiteSubscriptions/Index.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
