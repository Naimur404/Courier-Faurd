import { defineComponent, withCtx, unref, createVNode, createTextVNode, useSSRContext } from "vue";
import { ssrRenderComponent } from "vue/server-renderer";
import { WifiOff, RefreshCw } from "lucide-vue-next";
import { _ as _sfc_main$1 } from "./AppLayout-B7Gogr1C.js";
import "../ssr.js";
import "@vue/server-renderer";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Offline",
  __ssrInlineRender: true,
  setup(__props) {
    const refreshPage = () => {
      window.location.reload();
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(_sfc_main$1, _attrs, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="min-h-[60vh] flex items-center justify-center px-4"${_scopeId}><div class="text-center"${_scopeId}><div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(WifiOff), { class: "w-12 h-12 text-gray-400 dark:text-gray-500" }, null, _parent2, _scopeId));
            _push2(`</div><h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3"${_scopeId}> আপনি অফলাইনে আছেন </h1><p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto"${_scopeId}> দুঃখিত, বর্তমানে ইন্টারনেট সংযোগ পাওয়া যাচ্ছে না। অনুগ্রহ করে আপনার ইন্টারনেট সংযোগ পরীক্ষা করুন এবং আবার চেষ্টা করুন। </p><button class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(RefreshCw), { class: "w-5 h-5" }, null, _parent2, _scopeId));
            _push2(` আবার চেষ্টা করুন </button></div></div>`);
          } else {
            return [
              createVNode("div", { class: "min-h-[60vh] flex items-center justify-center px-4" }, [
                createVNode("div", { class: "text-center" }, [
                  createVNode("div", { class: "mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6" }, [
                    createVNode(unref(WifiOff), { class: "w-12 h-12 text-gray-400 dark:text-gray-500" })
                  ]),
                  createVNode("h1", { class: "text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3" }, " আপনি অফলাইনে আছেন "),
                  createVNode("p", { class: "text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto" }, " দুঃখিত, বর্তমানে ইন্টারনেট সংযোগ পাওয়া যাচ্ছে না। অনুগ্রহ করে আপনার ইন্টারনেট সংযোগ পরীক্ষা করুন এবং আবার চেষ্টা করুন। "),
                  createVNode("button", {
                    onClick: refreshPage,
                    class: "inline-flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors"
                  }, [
                    createVNode(unref(RefreshCw), { class: "w-5 h-5" }),
                    createTextVNode(" আবার চেষ্টা করুন ")
                  ])
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Offline.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
