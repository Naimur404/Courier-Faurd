import { defineComponent, useAttrs, computed, mergeProps, unref, useSSRContext, ref, withCtx, createVNode, createTextVNode, createBlock, createCommentVNode, openBlock, Teleport, Transition, toDisplayString, Fragment, renderList, withModifiers } from "vue";
import { ssrRenderAttrs, ssrRenderComponent, ssrRenderTeleport, ssrRenderClass, ssrInterpolate, ssrRenderList, ssrIncludeBooleanAttr } from "vue/server-renderer";
import { a as usePage, h as head_default, l as link_default } from "../ssr.js";
import { _ as _sfc_main$2 } from "./AppLayout-BWjM9ngr.js";
import { c as cn } from "./utils-DvCvi0aN.js";
import { _ as _sfc_main$3 } from "./Label-Cl3p6AAe.js";
import "@vue/server-renderer";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
import "lucide-vue-next";
import "clsx";
import "tailwind-merge";
const _sfc_main$1 = /* @__PURE__ */ defineComponent({
  __name: "Input",
  __ssrInlineRender: true,
  props: {
    class: {},
    defaultValue: {},
    modelValue: {}
  },
  emits: ["update:modelValue"],
  setup(__props, { emit: __emit }) {
    const props = __props;
    const attrs = useAttrs();
    const inputClasses = computed(() => cn(
      "flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm",
      props.class
    ));
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<input${ssrRenderAttrs(mergeProps({
        class: inputClasses.value,
        value: __props.modelValue
      }, unref(attrs), _attrs))}>`);
    };
  }
});
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/input/Input.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
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
        showNotification("নম্বর কপি হয়েছে!", "bKash নম্বর ক্লিপবোর্ডে কপি হয়েছে", "success");
      }).catch(() => {
        const textArea = document.createElement("textarea");
        textArea.value = number;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("copy");
        document.body.removeChild(textArea);
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
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(head_default), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title${_scopeId}>ওয়েবসাইট সাবস্ক্রিপশন - সীমাহীন সার্চ | Courier Fraud</title><meta name="description" content="আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন। দৈনিক ২০ টাকা বা ১৫ দিনের জন্য ৫০ টাকা।"${_scopeId}><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, "ওয়েবসাইট সাবস্ক্রিপশন - সীমাহীন সার্চ | Courier Fraud"),
              createVNode("meta", {
                name: "description",
                content: "আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন। দৈনিক ২০ টাকা বা ১৫ দিনের জন্য ৫০ টাকা।"
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
      _push(ssrRenderComponent(_sfc_main$2, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          var _a, _b;
          if (_push2) {
            ssrRenderTeleport(_push2, (_push3) => {
              if (notification.value.show) {
                _push3(`<div class="${ssrRenderClass([
                  "fixed top-5 right-5 z-[1000] min-w-[300px] max-w-[500px] rounded-xl p-4 shadow-lg backdrop-blur-sm",
                  notification.value.type === "success" ? "bg-gradient-to-r from-green-500 to-green-600 text-white border-l-4 border-green-700" : "",
                  notification.value.type === "error" ? "bg-gradient-to-r from-red-500 to-red-600 text-white border-l-4 border-red-700" : "",
                  notification.value.type === "info" ? "bg-gradient-to-r from-blue-500 to-blue-600 text-white border-l-4 border-blue-700" : ""
                ])}"${_scopeId}><div class="flex items-center"${_scopeId}><i class="${ssrRenderClass([
                  "mr-3 text-xl",
                  notification.value.type === "success" ? "fas fa-check-circle" : "",
                  notification.value.type === "error" ? "fas fa-exclamation-circle" : "",
                  notification.value.type === "info" ? "fas fa-info-circle" : ""
                ])}"${_scopeId}></i><div class="flex-1"${_scopeId}><div class="font-semibold mb-1"${_scopeId}>${ssrInterpolate(notification.value.title)}</div><div class="text-sm opacity-90"${_scopeId}>${ssrInterpolate(notification.value.message)}</div></div><button class="ml-3 opacity-70 hover:opacity-100 transition"${_scopeId}><i class="fas fa-times"${_scopeId}></i></button></div></div>`);
              } else {
                _push3(`<!---->`);
              }
            }, "body", false, _parent2);
            _push2(`<div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white py-16"${_scopeId}><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center"${_scopeId}><h1 class="text-4xl md:text-5xl font-bold mb-6"${_scopeId}><i class="fas fa-infinity mr-3"${_scopeId}></i> সীমাহীন সার্চ প্ল্যান </h1><p class="text-xl md:text-2xl text-indigo-100 max-w-3xl mx-auto"${_scopeId}> আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন </p></div></div>`);
            if (__props.activeSubscription) {
              _push2(`<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"${_scopeId}><div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 shadow-lg"${_scopeId}><div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4"${_scopeId}><div class="flex items-center"${_scopeId}><div class="bg-green-100 dark:bg-green-800 rounded-full p-3 mr-4"${_scopeId}><i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"${_scopeId}></i></div><div${_scopeId}><h3 class="text-lg font-bold text-green-800 dark:text-green-400"${_scopeId}>সক্রিয় সাবস্ক্রিপশন</h3><p class="text-green-600 dark:text-green-500"${_scopeId}> প্ল্যান: ${ssrInterpolate((_a = __props.plans[__props.activeSubscription.plan_type]) == null ? void 0 : _a.name)} | মেয়াদ শেষ: ${ssrInterpolate(formatDate(__props.activeSubscription.expires_at))}</p><p class="text-sm text-green-500 dark:text-green-600 mt-1"${_scopeId}><i class="fas fa-infinity mr-1"${_scopeId}></i> আপনার বর্তমানে সীমাহীন সার্চ সুবিধা আছে </p></div></div><div class="text-right"${_scopeId}><div class="text-2xl font-bold text-green-600 dark:text-green-400"${_scopeId}>${ssrInterpolate(__props.activeSubscription.formatted_amount)}</div><div class="text-sm text-green-500"${_scopeId}>${ssrInterpolate(__props.activeSubscription.days_remaining)} দিন বাকি</div></div></div></div></div>`);
            } else {
              _push2(`<!---->`);
            }
            _push2(`<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16"${_scopeId}><div class="text-center mb-12"${_scopeId}><h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4"${_scopeId}> সাবস্ক্রিপশন প্ল্যান </h2><p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto"${_scopeId}> আপনার প্রয়োজন অনুযায়ী উপযুক্ত প্ল্যান বেছে নিন এবং সীমাহীন সার্চ করুন </p></div><div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto"${_scopeId}><!--[-->`);
            ssrRenderList(__props.plans, (plan, planType) => {
              _push2(`<div class="${ssrRenderClass([
                "bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition duration-300",
                planType === "weekly" ? "ring-4 ring-indigo-500 ring-opacity-50" : ""
              ])}"${_scopeId}>`);
              if (planType === "weekly") {
                _push2(`<div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-center py-3"${_scopeId}><span class="font-bold text-sm uppercase tracking-wide"${_scopeId}><i class="fas fa-star mr-1"${_scopeId}></i> সবচেয়ে জনপ্রিয় </span></div>`);
              } else {
                _push2(`<!---->`);
              }
              _push2(`<div class="p-8"${_scopeId}><div class="text-center"${_scopeId}><h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2"${_scopeId}>${ssrInterpolate(plan.name)}</h3><div class="text-5xl font-bold text-indigo-600 mb-2"${_scopeId}> ৳${ssrInterpolate(plan.price.toLocaleString())}</div><p class="text-gray-500 dark:text-gray-400 mb-6"${_scopeId}>${ssrInterpolate(plan.duration)}</p><div class="text-gray-600 dark:text-gray-300 mb-8"${_scopeId}><p class="text-lg"${_scopeId}>${ssrInterpolate(plan.description)}</p></div><div class="space-y-4 mb-8"${_scopeId}><div class="flex items-center justify-center"${_scopeId}><i class="fas fa-infinity text-indigo-500 mr-2"${_scopeId}></i><span class="dark:text-gray-300"${_scopeId}>সীমাহীন সার্চ</span></div><div class="flex items-center justify-center"${_scopeId}><i class="fas fa-shield-check text-green-500 mr-2"${_scopeId}></i><span class="dark:text-gray-300"${_scopeId}>ভেরিফাইড ডেটা</span></div><div class="flex items-center justify-center"${_scopeId}><i class="fas fa-clock text-blue-500 mr-2"${_scopeId}></i><span class="dark:text-gray-300"${_scopeId}>তাৎক্ষণিক ফলাফল</span></div>`);
              if (planType === "weekly") {
                _push2(`<div class="flex items-center justify-center"${_scopeId}><i class="fas fa-crown text-yellow-500 mr-2"${_scopeId}></i><span class="dark:text-gray-300"${_scopeId}>সাশ্রয়ী মূল্য</span></div>`);
              } else {
                _push2(`<!---->`);
              }
              _push2(`</div>`);
              if (isAuthenticated.value) {
                _push2(`<!--[-->`);
                if (__props.activeSubscription) {
                  _push2(`<button disabled class="w-full bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 py-3 px-6 rounded-xl font-bold cursor-not-allowed"${_scopeId}><i class="fas fa-check mr-2"${_scopeId}></i> ইতিমধ্যে সাবস্ক্রাইব করা আছে </button>`);
                } else {
                  _push2(`<button class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 px-6 rounded-xl font-bold transform hover:scale-105 transition duration-200 shadow-lg"${_scopeId}><i class="fas fa-credit-card mr-2"${_scopeId}></i> এখনই সাবস্ক্রাইব করুন </button>`);
                }
                _push2(`<!--]-->`);
              } else {
                _push2(ssrRenderComponent(unref(link_default), {
                  href: "/login",
                  class: "block w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 px-6 rounded-xl font-bold text-center transform hover:scale-105 transition duration-200 shadow-lg"
                }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(`<i class="fas fa-sign-in-alt mr-2"${_scopeId2}></i> লগইন করে সাবস্ক্রাইব করুন `);
                    } else {
                      return [
                        createVNode("i", { class: "fas fa-sign-in-alt mr-2" }),
                        createTextVNode(" লগইন করে সাবস্ক্রাইব করুন ")
                      ];
                    }
                  }),
                  _: 2
                }, _parent2, _scopeId));
              }
              _push2(`</div></div></div>`);
            });
            _push2(`<!--]--></div></div><div class="bg-white dark:bg-gray-800 py-16"${_scopeId}><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"${_scopeId}><div class="text-center mb-12"${_scopeId}><h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4"${_scopeId}>সাবস্ক্রিপশনের সুবিধা</h2><p class="text-xl text-gray-600 dark:text-gray-400"${_scopeId}>আমাদের সাবস্ক্রিপশন নিয়ে পান এই সব বিশেষ সুবিধা</p></div><div class="grid grid-cols-1 md:grid-cols-3 gap-8"${_scopeId}><div class="text-center"${_scopeId}><div class="bg-indigo-100 dark:bg-indigo-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4"${_scopeId}><i class="fas fa-infinity text-indigo-600 dark:text-indigo-300 text-2xl"${_scopeId}></i></div><h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2"${_scopeId}>সীমাহীন সার্চ</h3><p class="text-gray-600 dark:text-gray-400"${_scopeId}>দৈনিক সীমা ছাড়াই যতবার খুশি কুরিয়ার ভেরিফাই করুন</p></div><div class="text-center"${_scopeId}><div class="bg-green-100 dark:bg-green-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4"${_scopeId}><i class="fas fa-shield-check text-green-600 dark:text-green-300 text-2xl"${_scopeId}></i></div><h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2"${_scopeId}>নির্ভরযোগ্য ডেটা</h3><p class="text-gray-600 dark:text-gray-400"${_scopeId}>১০০% সঠিক এবং আপডেটেড কুরিয়ার তথ্য</p></div><div class="text-center"${_scopeId}><div class="bg-blue-100 dark:bg-blue-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4"${_scopeId}><i class="fas fa-clock text-blue-600 dark:text-blue-300 text-2xl"${_scopeId}></i></div><h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2"${_scopeId}>তাৎক্ষণিক ফলাফল</h3><p class="text-gray-600 dark:text-gray-400"${_scopeId}>কোন অপেক্ষা ছাড়াই তুরন্ত ফলাফল পান</p></div></div></div></div>`);
            ssrRenderTeleport(_push2, (_push3) => {
              var _a2, _b2;
              if (showModal.value) {
                _push3(`<div class="fixed inset-0 z-50 flex items-center justify-center p-4"${_scopeId}><div class="absolute inset-0 bg-black/50"${_scopeId}></div><div class="relative bg-white dark:bg-gray-800 rounded-xl p-6 max-w-md w-full shadow-2xl"${_scopeId}><div class="text-center"${_scopeId}><div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-800 mb-4"${_scopeId}><i class="fas fa-credit-card text-indigo-600 dark:text-indigo-300 text-xl"${_scopeId}></i></div><h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4"${_scopeId}>${ssrInterpolate((_a2 = selectedPlanDetails.value) == null ? void 0 : _a2.name)} - ৳${ssrInterpolate((_b2 = selectedPlanDetails.value) == null ? void 0 : _b2.price)}</h3><form${_scopeId}><div class="mb-6"${_scopeId}>`);
                _push3(ssrRenderComponent(unref(_sfc_main$3), { class: "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left" }, {
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
                _push3(`<div class="bg-pink-50 dark:bg-pink-900/20 border border-pink-200 dark:border-pink-800 rounded-lg p-4"${_scopeId}><div class="flex items-center mb-3"${_scopeId}><div class="bg-pink-600 text-white rounded-lg px-3 py-1 text-sm font-bold mr-3"${_scopeId}>bKash</div><span class="text-gray-700 dark:text-gray-300 font-medium"${_scopeId}>পেমেন্ট নম্বর</span></div><div class="bg-white dark:bg-gray-700 border rounded-lg p-3 mb-3"${_scopeId}><div class="flex items-center justify-between"${_scopeId}><span class="font-mono text-lg font-bold text-gray-900 dark:text-white"${_scopeId}>01309092748</span><button type="button" class="bg-pink-100 hover:bg-pink-200 dark:bg-pink-800 dark:hover:bg-pink-700 text-pink-700 dark:text-pink-200 px-3 py-1 rounded text-sm font-medium transition-colors"${_scopeId}><i class="fas fa-copy mr-1"${_scopeId}></i> কপি </button></div></div><div class="text-sm text-gray-600 dark:text-gray-400 text-left"${_scopeId}><p class="mb-2"${_scopeId}><strong${_scopeId}>পেমেন্ট প্রক্রিয়া:</strong></p><ol class="list-decimal list-inside space-y-1 text-xs"${_scopeId}><li${_scopeId}>উপরের নম্বরে bKash Send Money করুন</li><li${_scopeId}>ট্রানজেকশন সম্পন্ন হলে ট্রানজেকশন আইডি নিচে লিখুন</li><li${_scopeId}>সাবস্ক্রাইব বাটনে ক্লিক করুন</li></ol></div></div></div><div class="mb-6 text-left"${_scopeId}>`);
                _push3(ssrRenderComponent(unref(_sfc_main$3), { class: "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" }, {
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
                _push3(ssrRenderComponent(unref(_sfc_main$1), {
                  modelValue: transactionId.value,
                  "onUpdate:modelValue": ($event) => transactionId.value = $event,
                  type: "text",
                  placeholder: "bKash ট্রানজেকশন আইডি লিখুন",
                  required: ""
                }, null, _parent2, _scopeId));
                _push3(`<p class="text-xs text-gray-500 dark:text-gray-400 mt-1"${_scopeId}>পেমেন্ট সম্পন্ন হওয়ার পর যে আইডি পাবেন তা এখানে লিখুন</p></div><div class="flex space-x-3"${_scopeId}><button type="button" class="flex-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white py-2 px-4 rounded-lg font-medium transition duration-200"${_scopeId}> বাতিল </button><button type="submit"${ssrIncludeBooleanAttr(isSubmitting.value) ? " disabled" : ""} class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200 disabled:opacity-50"${_scopeId}>`);
                if (isSubmitting.value) {
                  _push3(`<i class="fas fa-spinner fa-spin mr-2"${_scopeId}></i>`);
                } else {
                  _push3(`<!---->`);
                }
                _push3(` সাবস্ক্রাইব করুন </button></div></form></div></div></div>`);
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
                      class: [
                        "fixed top-5 right-5 z-[1000] min-w-[300px] max-w-[500px] rounded-xl p-4 shadow-lg backdrop-blur-sm",
                        notification.value.type === "success" ? "bg-gradient-to-r from-green-500 to-green-600 text-white border-l-4 border-green-700" : "",
                        notification.value.type === "error" ? "bg-gradient-to-r from-red-500 to-red-600 text-white border-l-4 border-red-700" : "",
                        notification.value.type === "info" ? "bg-gradient-to-r from-blue-500 to-blue-600 text-white border-l-4 border-blue-700" : ""
                      ]
                    }, [
                      createVNode("div", { class: "flex items-center" }, [
                        createVNode("i", {
                          class: [
                            "mr-3 text-xl",
                            notification.value.type === "success" ? "fas fa-check-circle" : "",
                            notification.value.type === "error" ? "fas fa-exclamation-circle" : "",
                            notification.value.type === "info" ? "fas fa-info-circle" : ""
                          ]
                        }, null, 2),
                        createVNode("div", { class: "flex-1" }, [
                          createVNode("div", { class: "font-semibold mb-1" }, toDisplayString(notification.value.title), 1),
                          createVNode("div", { class: "text-sm opacity-90" }, toDisplayString(notification.value.message), 1)
                        ]),
                        createVNode("button", {
                          onClick: closeNotification,
                          class: "ml-3 opacity-70 hover:opacity-100 transition"
                        }, [
                          createVNode("i", { class: "fas fa-times" })
                        ])
                      ])
                    ], 2)) : createCommentVNode("", true)
                  ]),
                  _: 1
                })
              ])),
              createVNode("div", { class: "bg-gradient-to-r from-indigo-600 to-purple-700 text-white py-16" }, [
                createVNode("div", { class: "max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" }, [
                  createVNode("h1", { class: "text-4xl md:text-5xl font-bold mb-6" }, [
                    createVNode("i", { class: "fas fa-infinity mr-3" }),
                    createTextVNode(" সীমাহীন সার্চ প্ল্যান ")
                  ]),
                  createVNode("p", { class: "text-xl md:text-2xl text-indigo-100 max-w-3xl mx-auto" }, " আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন ")
                ])
              ]),
              __props.activeSubscription ? (openBlock(), createBlock("div", {
                key: 0,
                class: "max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
              }, [
                createVNode("div", { class: "bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 shadow-lg" }, [
                  createVNode("div", { class: "flex flex-col md:flex-row items-start md:items-center justify-between gap-4" }, [
                    createVNode("div", { class: "flex items-center" }, [
                      createVNode("div", { class: "bg-green-100 dark:bg-green-800 rounded-full p-3 mr-4" }, [
                        createVNode("i", { class: "fas fa-check-circle text-green-600 dark:text-green-400 text-xl" })
                      ]),
                      createVNode("div", null, [
                        createVNode("h3", { class: "text-lg font-bold text-green-800 dark:text-green-400" }, "সক্রিয় সাবস্ক্রিপশন"),
                        createVNode("p", { class: "text-green-600 dark:text-green-500" }, " প্ল্যান: " + toDisplayString((_b = __props.plans[__props.activeSubscription.plan_type]) == null ? void 0 : _b.name) + " | মেয়াদ শেষ: " + toDisplayString(formatDate(__props.activeSubscription.expires_at)), 1),
                        createVNode("p", { class: "text-sm text-green-500 dark:text-green-600 mt-1" }, [
                          createVNode("i", { class: "fas fa-infinity mr-1" }),
                          createTextVNode(" আপনার বর্তমানে সীমাহীন সার্চ সুবিধা আছে ")
                        ])
                      ])
                    ]),
                    createVNode("div", { class: "text-right" }, [
                      createVNode("div", { class: "text-2xl font-bold text-green-600 dark:text-green-400" }, toDisplayString(__props.activeSubscription.formatted_amount), 1),
                      createVNode("div", { class: "text-sm text-green-500" }, toDisplayString(__props.activeSubscription.days_remaining) + " দিন বাকি", 1)
                    ])
                  ])
                ])
              ])) : createCommentVNode("", true),
              createVNode("div", { class: "max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" }, [
                createVNode("div", { class: "text-center mb-12" }, [
                  createVNode("h2", { class: "text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4" }, " সাবস্ক্রিপশন প্ল্যান "),
                  createVNode("p", { class: "text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto" }, " আপনার প্রয়োজন অনুযায়ী উপযুক্ত প্ল্যান বেছে নিন এবং সীমাহীন সার্চ করুন ")
                ]),
                createVNode("div", { class: "grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto" }, [
                  (openBlock(true), createBlock(Fragment, null, renderList(__props.plans, (plan, planType) => {
                    return openBlock(), createBlock("div", {
                      key: planType,
                      class: [
                        "bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition duration-300",
                        planType === "weekly" ? "ring-4 ring-indigo-500 ring-opacity-50" : ""
                      ]
                    }, [
                      planType === "weekly" ? (openBlock(), createBlock("div", {
                        key: 0,
                        class: "bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-center py-3"
                      }, [
                        createVNode("span", { class: "font-bold text-sm uppercase tracking-wide" }, [
                          createVNode("i", { class: "fas fa-star mr-1" }),
                          createTextVNode(" সবচেয়ে জনপ্রিয় ")
                        ])
                      ])) : createCommentVNode("", true),
                      createVNode("div", { class: "p-8" }, [
                        createVNode("div", { class: "text-center" }, [
                          createVNode("h3", { class: "text-2xl font-bold text-gray-900 dark:text-white mb-2" }, toDisplayString(plan.name), 1),
                          createVNode("div", { class: "text-5xl font-bold text-indigo-600 mb-2" }, " ৳" + toDisplayString(plan.price.toLocaleString()), 1),
                          createVNode("p", { class: "text-gray-500 dark:text-gray-400 mb-6" }, toDisplayString(plan.duration), 1),
                          createVNode("div", { class: "text-gray-600 dark:text-gray-300 mb-8" }, [
                            createVNode("p", { class: "text-lg" }, toDisplayString(plan.description), 1)
                          ]),
                          createVNode("div", { class: "space-y-4 mb-8" }, [
                            createVNode("div", { class: "flex items-center justify-center" }, [
                              createVNode("i", { class: "fas fa-infinity text-indigo-500 mr-2" }),
                              createVNode("span", { class: "dark:text-gray-300" }, "সীমাহীন সার্চ")
                            ]),
                            createVNode("div", { class: "flex items-center justify-center" }, [
                              createVNode("i", { class: "fas fa-shield-check text-green-500 mr-2" }),
                              createVNode("span", { class: "dark:text-gray-300" }, "ভেরিফাইড ডেটা")
                            ]),
                            createVNode("div", { class: "flex items-center justify-center" }, [
                              createVNode("i", { class: "fas fa-clock text-blue-500 mr-2" }),
                              createVNode("span", { class: "dark:text-gray-300" }, "তাৎক্ষণিক ফলাফল")
                            ]),
                            planType === "weekly" ? (openBlock(), createBlock("div", {
                              key: 0,
                              class: "flex items-center justify-center"
                            }, [
                              createVNode("i", { class: "fas fa-crown text-yellow-500 mr-2" }),
                              createVNode("span", { class: "dark:text-gray-300" }, "সাশ্রয়ী মূল্য")
                            ])) : createCommentVNode("", true)
                          ]),
                          isAuthenticated.value ? (openBlock(), createBlock(Fragment, { key: 0 }, [
                            __props.activeSubscription ? (openBlock(), createBlock("button", {
                              key: 0,
                              disabled: "",
                              class: "w-full bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 py-3 px-6 rounded-xl font-bold cursor-not-allowed"
                            }, [
                              createVNode("i", { class: "fas fa-check mr-2" }),
                              createTextVNode(" ইতিমধ্যে সাবস্ক্রাইব করা আছে ")
                            ])) : (openBlock(), createBlock("button", {
                              key: 1,
                              onClick: ($event) => subscribeToPlan(planType),
                              class: "w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 px-6 rounded-xl font-bold transform hover:scale-105 transition duration-200 shadow-lg"
                            }, [
                              createVNode("i", { class: "fas fa-credit-card mr-2" }),
                              createTextVNode(" এখনই সাবস্ক্রাইব করুন ")
                            ], 8, ["onClick"]))
                          ], 64)) : (openBlock(), createBlock(unref(link_default), {
                            key: 1,
                            href: "/login",
                            class: "block w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 px-6 rounded-xl font-bold text-center transform hover:scale-105 transition duration-200 shadow-lg"
                          }, {
                            default: withCtx(() => [
                              createVNode("i", { class: "fas fa-sign-in-alt mr-2" }),
                              createTextVNode(" লগইন করে সাবস্ক্রাইব করুন ")
                            ]),
                            _: 1
                          }))
                        ])
                      ])
                    ], 2);
                  }), 128))
                ])
              ]),
              createVNode("div", { class: "bg-white dark:bg-gray-800 py-16" }, [
                createVNode("div", { class: "max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" }, [
                  createVNode("div", { class: "text-center mb-12" }, [
                    createVNode("h2", { class: "text-3xl font-bold text-gray-900 dark:text-white mb-4" }, "সাবস্ক্রিপশনের সুবিধা"),
                    createVNode("p", { class: "text-xl text-gray-600 dark:text-gray-400" }, "আমাদের সাবস্ক্রিপশন নিয়ে পান এই সব বিশেষ সুবিধা")
                  ]),
                  createVNode("div", { class: "grid grid-cols-1 md:grid-cols-3 gap-8" }, [
                    createVNode("div", { class: "text-center" }, [
                      createVNode("div", { class: "bg-indigo-100 dark:bg-indigo-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4" }, [
                        createVNode("i", { class: "fas fa-infinity text-indigo-600 dark:text-indigo-300 text-2xl" })
                      ]),
                      createVNode("h3", { class: "text-xl font-bold text-gray-900 dark:text-white mb-2" }, "সীমাহীন সার্চ"),
                      createVNode("p", { class: "text-gray-600 dark:text-gray-400" }, "দৈনিক সীমা ছাড়াই যতবার খুশি কুরিয়ার ভেরিফাই করুন")
                    ]),
                    createVNode("div", { class: "text-center" }, [
                      createVNode("div", { class: "bg-green-100 dark:bg-green-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4" }, [
                        createVNode("i", { class: "fas fa-shield-check text-green-600 dark:text-green-300 text-2xl" })
                      ]),
                      createVNode("h3", { class: "text-xl font-bold text-gray-900 dark:text-white mb-2" }, "নির্ভরযোগ্য ডেটা"),
                      createVNode("p", { class: "text-gray-600 dark:text-gray-400" }, "১০০% সঠিক এবং আপডেটেড কুরিয়ার তথ্য")
                    ]),
                    createVNode("div", { class: "text-center" }, [
                      createVNode("div", { class: "bg-blue-100 dark:bg-blue-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4" }, [
                        createVNode("i", { class: "fas fa-clock text-blue-600 dark:text-blue-300 text-2xl" })
                      ]),
                      createVNode("h3", { class: "text-xl font-bold text-gray-900 dark:text-white mb-2" }, "তাৎক্ষণিক ফলাফল"),
                      createVNode("p", { class: "text-gray-600 dark:text-gray-400" }, "কোন অপেক্ষা ছাড়াই তুরন্ত ফলাফল পান")
                    ])
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
                  default: withCtx(() => {
                    var _a2, _b2;
                    return [
                      showModal.value ? (openBlock(), createBlock("div", {
                        key: 0,
                        class: "fixed inset-0 z-50 flex items-center justify-center p-4"
                      }, [
                        createVNode("div", {
                          class: "absolute inset-0 bg-black/50",
                          onClick: closeModal
                        }),
                        createVNode("div", { class: "relative bg-white dark:bg-gray-800 rounded-xl p-6 max-w-md w-full shadow-2xl" }, [
                          createVNode("div", { class: "text-center" }, [
                            createVNode("div", { class: "mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-800 mb-4" }, [
                              createVNode("i", { class: "fas fa-credit-card text-indigo-600 dark:text-indigo-300 text-xl" })
                            ]),
                            createVNode("h3", { class: "text-lg font-bold text-gray-900 dark:text-white mb-4" }, toDisplayString((_a2 = selectedPlanDetails.value) == null ? void 0 : _a2.name) + " - ৳" + toDisplayString((_b2 = selectedPlanDetails.value) == null ? void 0 : _b2.price), 1),
                            createVNode("form", {
                              onSubmit: withModifiers(handleSubmit, ["prevent"])
                            }, [
                              createVNode("div", { class: "mb-6" }, [
                                createVNode(unref(_sfc_main$3), { class: "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 text-left" }, {
                                  default: withCtx(() => [
                                    createTextVNode("পেমেন্ট মেথড")
                                  ]),
                                  _: 1
                                }),
                                createVNode("div", { class: "bg-pink-50 dark:bg-pink-900/20 border border-pink-200 dark:border-pink-800 rounded-lg p-4" }, [
                                  createVNode("div", { class: "flex items-center mb-3" }, [
                                    createVNode("div", { class: "bg-pink-600 text-white rounded-lg px-3 py-1 text-sm font-bold mr-3" }, "bKash"),
                                    createVNode("span", { class: "text-gray-700 dark:text-gray-300 font-medium" }, "পেমেন্ট নম্বর")
                                  ]),
                                  createVNode("div", { class: "bg-white dark:bg-gray-700 border rounded-lg p-3 mb-3" }, [
                                    createVNode("div", { class: "flex items-center justify-between" }, [
                                      createVNode("span", { class: "font-mono text-lg font-bold text-gray-900 dark:text-white" }, "01309092748"),
                                      createVNode("button", {
                                        type: "button",
                                        onClick: copyNumber,
                                        class: "bg-pink-100 hover:bg-pink-200 dark:bg-pink-800 dark:hover:bg-pink-700 text-pink-700 dark:text-pink-200 px-3 py-1 rounded text-sm font-medium transition-colors"
                                      }, [
                                        createVNode("i", { class: "fas fa-copy mr-1" }),
                                        createTextVNode(" কপি ")
                                      ])
                                    ])
                                  ]),
                                  createVNode("div", { class: "text-sm text-gray-600 dark:text-gray-400 text-left" }, [
                                    createVNode("p", { class: "mb-2" }, [
                                      createVNode("strong", null, "পেমেন্ট প্রক্রিয়া:")
                                    ]),
                                    createVNode("ol", { class: "list-decimal list-inside space-y-1 text-xs" }, [
                                      createVNode("li", null, "উপরের নম্বরে bKash Send Money করুন"),
                                      createVNode("li", null, "ট্রানজেকশন সম্পন্ন হলে ট্রানজেকশন আইডি নিচে লিখুন"),
                                      createVNode("li", null, "সাবস্ক্রাইব বাটনে ক্লিক করুন")
                                    ])
                                  ])
                                ])
                              ]),
                              createVNode("div", { class: "mb-6 text-left" }, [
                                createVNode(unref(_sfc_main$3), { class: "block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" }, {
                                  default: withCtx(() => [
                                    createTextVNode("ট্রানজেকশন আইডি *")
                                  ]),
                                  _: 1
                                }),
                                createVNode(unref(_sfc_main$1), {
                                  modelValue: transactionId.value,
                                  "onUpdate:modelValue": ($event) => transactionId.value = $event,
                                  type: "text",
                                  placeholder: "bKash ট্রানজেকশন আইডি লিখুন",
                                  required: ""
                                }, null, 8, ["modelValue", "onUpdate:modelValue"]),
                                createVNode("p", { class: "text-xs text-gray-500 dark:text-gray-400 mt-1" }, "পেমেন্ট সম্পন্ন হওয়ার পর যে আইডি পাবেন তা এখানে লিখুন")
                              ]),
                              createVNode("div", { class: "flex space-x-3" }, [
                                createVNode("button", {
                                  type: "button",
                                  onClick: closeModal,
                                  class: "flex-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white py-2 px-4 rounded-lg font-medium transition duration-200"
                                }, " বাতিল "),
                                createVNode("button", {
                                  type: "submit",
                                  disabled: isSubmitting.value,
                                  class: "flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200 disabled:opacity-50"
                                }, [
                                  isSubmitting.value ? (openBlock(), createBlock("i", {
                                    key: 0,
                                    class: "fas fa-spinner fa-spin mr-2"
                                  })) : createCommentVNode("", true),
                                  createTextVNode(" সাবস্ক্রাইব করুন ")
                                ], 8, ["disabled"])
                              ])
                            ], 32)
                          ])
                        ])
                      ])) : createCommentVNode("", true)
                    ];
                  }),
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
