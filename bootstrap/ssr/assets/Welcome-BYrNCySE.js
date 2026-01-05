import { defineComponent, onMounted, onUnmounted, watch, unref, useSSRContext, ref, mergeProps, computed, withCtx, createVNode, toDisplayString, createTextVNode, withDirectives, withKeys, vModelText, resolveDynamicComponent, createBlock, openBlock, Fragment, createCommentVNode, renderList, Transition, withModifiers } from "vue";
import { ssrRenderTeleport, ssrRenderClass, ssrRenderComponent, ssrRenderSlot, ssrRenderAttrs, ssrRenderList, ssrIncludeBooleanAttr, ssrInterpolate, ssrRenderAttr, ssrRenderStyle, ssrRenderVNode } from "vue/server-renderer";
import { h as head_default } from "../ssr.js";
import { _ as _sfc_main$9 } from "./AppLayout-BWjM9ngr.js";
import { _ as _sfc_main$b } from "./Button-Dm3W5gAW.js";
import { _ as _sfc_main$a } from "./Card-DfyUDDxC.js";
import { c as cn, f as formatBengaliNumber, g as getColorForRatio, m as maskPhoneNumber, a as formatBengaliDate, b as convertToBengaliNumbers } from "./utils-DvCvi0aN.js";
import { X, Star, HelpCircle, CheckCircle, AlertCircle, XCircle, BarChart3, Clock, Calendar, Infinity, PhoneCall, RefreshCw, Phone, Search, Shield, PieChart, MessageSquare, Plus, TrendingUp, History, ChevronUp, ChevronDown, Download, Send } from "lucide-vue-next";
import { _ as _sfc_main$c, b as _sfc_main$d, a as _sfc_main$e, c as _sfc_main$f, d as _sfc_main$g } from "./AlertDescription-DsjVZstT.js";
import "@vue/server-renderer";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
import "class-variance-authority";
import "clsx";
import "tailwind-merge";
const _sfc_main$8 = /* @__PURE__ */ defineComponent({
  __name: "Modal",
  __ssrInlineRender: true,
  props: {
    open: { type: Boolean },
    class: {}
  },
  emits: ["update:open"],
  setup(__props, { emit: __emit }) {
    const props = __props;
    const emit = __emit;
    const close = () => {
      emit("update:open", false);
    };
    const handleEscape = (event) => {
      if (event.key === "Escape") {
        close();
      }
    };
    onMounted(() => {
      document.addEventListener("keydown", handleEscape);
    });
    onUnmounted(() => {
      document.removeEventListener("keydown", handleEscape);
    });
    watch(() => props.open, (newValue) => {
      if (newValue) {
        document.body.style.overflow = "hidden";
      } else {
        document.body.style.overflow = "";
      }
    });
    return (_ctx, _push, _parent, _attrs) => {
      ssrRenderTeleport(_push, (_push2) => {
        if (__props.open) {
          _push2(`<div class="modal-backdrop fixed inset-0 z-50 flex items-center justify-center p-4"><div class="absolute inset-0 bg-black/50"></div>`);
          if (__props.open) {
            _push2(`<div class="${ssrRenderClass(unref(cn)("relative bg-white dark:bg-gray-800 rounded-xl p-6 max-w-md w-full shadow-2xl", props.class))}"><button class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">`);
            _push2(ssrRenderComponent(unref(X), { class: "h-5 w-5" }, null, _parent));
            _push2(`</button>`);
            ssrRenderSlot(_ctx.$slots, "default", {}, null, _push2, _parent);
            _push2(`</div>`);
          } else {
            _push2(`<!---->`);
          }
          _push2(`</div>`);
        } else {
          _push2(`<!---->`);
        }
      }, "body", false, _parent);
    };
  }
});
const _sfc_setup$8 = _sfc_main$8.setup;
_sfc_main$8.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/Modal.vue");
  return _sfc_setup$8 ? _sfc_setup$8(props, ctx) : void 0;
};
const _sfc_main$7 = /* @__PURE__ */ defineComponent({
  __name: "StarRating",
  __ssrInlineRender: true,
  props: {
    modelValue: {},
    readonly: { type: Boolean, default: false },
    size: { default: "md" }
  },
  emits: ["update:modelValue"],
  setup(__props, { emit: __emit }) {
    const props = __props;
    const hoverRating = ref(0);
    const sizeClasses = {
      sm: "h-4 w-4",
      md: "h-6 w-6",
      lg: "h-8 w-8"
    };
    const getStarClass = (index) => {
      const rating = hoverRating.value || props.modelValue;
      return index <= rating ? "text-yellow-500 fill-yellow-500" : "text-gray-300 dark:text-gray-600";
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "flex space-x-1" }, _attrs))}><!--[-->`);
      ssrRenderList(5, (i) => {
        _push(`<button type="button"${ssrIncludeBooleanAttr(__props.readonly) ? " disabled" : ""} class="${ssrRenderClass(unref(cn)(
          "transition-all duration-150",
          !__props.readonly && "cursor-pointer hover:scale-110",
          __props.readonly && "cursor-default"
        ))}">`);
        _push(ssrRenderComponent(unref(Star), {
          class: unref(cn)(sizeClasses[__props.size], getStarClass(i), "transition-colors")
        }, null, _parent));
        _push(`</button>`);
      });
      _push(`<!--]--></div>`);
    };
  }
});
const _sfc_setup$7 = _sfc_main$7.setup;
_sfc_main$7.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/StarRating.vue");
  return _sfc_setup$7 ? _sfc_setup$7(props, ctx) : void 0;
};
const _sfc_main$6 = /* @__PURE__ */ defineComponent({
  __name: "Table",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({
        class: unref(cn)("w-full overflow-auto", props.class)
      }, _attrs))}><table class="${ssrRenderClass(unref(cn)("w-full caption-bottom text-sm"))}">`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</table></div>`);
    };
  }
});
const _sfc_setup$6 = _sfc_main$6.setup;
_sfc_main$6.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/table/Table.vue");
  return _sfc_setup$6 ? _sfc_setup$6(props, ctx) : void 0;
};
const _sfc_main$5 = /* @__PURE__ */ defineComponent({
  __name: "TableHeader",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<thead${ssrRenderAttrs(mergeProps({
        class: unref(cn)("[&_tr]:border-b", props.class)
      }, _attrs))}>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</thead>`);
    };
  }
});
const _sfc_setup$5 = _sfc_main$5.setup;
_sfc_main$5.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/table/TableHeader.vue");
  return _sfc_setup$5 ? _sfc_setup$5(props, ctx) : void 0;
};
const _sfc_main$4 = /* @__PURE__ */ defineComponent({
  __name: "TableBody",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<tbody${ssrRenderAttrs(mergeProps({
        class: unref(cn)("[&_tr:last-child]:border-0", props.class)
      }, _attrs))}>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</tbody>`);
    };
  }
});
const _sfc_setup$4 = _sfc_main$4.setup;
_sfc_main$4.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/table/TableBody.vue");
  return _sfc_setup$4 ? _sfc_setup$4(props, ctx) : void 0;
};
const _sfc_main$3 = /* @__PURE__ */ defineComponent({
  __name: "TableRow",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<tr${ssrRenderAttrs(mergeProps({
        class: unref(cn)("border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted", props.class)
      }, _attrs))}>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</tr>`);
    };
  }
});
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/table/TableRow.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const _sfc_main$2 = /* @__PURE__ */ defineComponent({
  __name: "TableHead",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<th${ssrRenderAttrs(mergeProps({
        class: unref(cn)("h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0", props.class)
      }, _attrs))}>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</th>`);
    };
  }
});
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/table/TableHead.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const _sfc_main$1 = /* @__PURE__ */ defineComponent({
  __name: "TableCell",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<td${ssrRenderAttrs(mergeProps({
        class: unref(cn)("p-4 align-middle [&:has([role=checkbox])]:pr-0", props.class)
      }, _attrs))}>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</td>`);
    };
  }
});
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/table/TableCell.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Welcome",
  __ssrInlineRender: true,
  props: {
    csrfToken: {}
  },
  setup(__props) {
    const props = __props;
    const phoneInput = ref("");
    const isSearching = ref(false);
    const searchResults = ref(null);
    const reviews = ref([]);
    const showRatingModal = ref(false);
    const showEmptyState = ref(true);
    const stats = ref({
      lastHour: 0,
      today: 0,
      allTime: 0,
      uniqueNumbers: 0
    });
    const lastUpdated = ref("লোড হচ্ছে...");
    let statsInterval = null;
    const reviewForm = ref({
      ownNumber: "",
      name: "",
      rating: 0,
      comment: ""
    });
    const isSubmittingReview = ref(false);
    const activeFaq = ref(null);
    const successRatio = computed(() => {
      var _a, _b;
      if (!((_b = (_a = searchResults.value) == null ? void 0 : _a.courierData) == null ? void 0 : _b.summary)) return 0;
      return searchResults.value.courierData.summary.success_ratio || 0;
    });
    const riskLevel = computed(() => {
      var _a, _b, _c;
      const ratio = successRatio.value;
      const total = ((_c = (_b = (_a = searchResults.value) == null ? void 0 : _a.courierData) == null ? void 0 : _b.summary) == null ? void 0 : _c.total_parcel) || 0;
      if (total === 0) return { level: "unknown", color: "gray", label: "No Data Available", icon: HelpCircle };
      if (ratio >= 90) return { level: "low", color: "green", label: "Low Risk", icon: CheckCircle };
      if (ratio >= 70) return { level: "medium", color: "yellow", label: "Medium Risk", icon: AlertCircle };
      return { level: "high", color: "red", label: "High Risk", icon: XCircle };
    });
    const ratingText = computed(() => {
      var _a, _b, _c;
      const ratio = successRatio.value;
      const total = ((_c = (_b = (_a = searchResults.value) == null ? void 0 : _a.courierData) == null ? void 0 : _b.summary) == null ? void 0 : _c.total_parcel) || 0;
      if (total === 0) return "New";
      if (ratio >= 90) return "Excellent";
      if (ratio >= 70) return "Good";
      return "Poor";
    });
    const courierList = computed(() => {
      var _a;
      if (!((_a = searchResults.value) == null ? void 0 : _a.courierData)) return [];
      return Object.entries(searchResults.value.courierData).filter(([key]) => key !== "summary").map(([courier, data]) => ({
        name: data.name || courier.charAt(0).toUpperCase() + courier.slice(1),
        logo: data.logo || "",
        totalParcel: data.total_parcel,
        successParcel: data.success_parcel,
        cancelledParcel: data.cancelled_parcel,
        successRatio: data.success_ratio
      }));
    });
    const loadStats = async () => {
      try {
        const response = await fetch("/api/search-stats");
        const result = await response.json();
        if (result.success) {
          stats.value = {
            lastHour: result.data.last_hour,
            today: result.data.today,
            allTime: result.data.all_time,
            uniqueNumbers: result.data.unique_numbers
          };
          if (result.data.bangladesh_time) {
            const bengaliMonths = [
              "জানুয়ারী",
              "ফেব্রুয়ারী",
              "মার্চ",
              "এপ্রিল",
              "মে",
              "জুন",
              "জুলাই",
              "আগস্ট",
              "সেপ্টেম্বর",
              "অক্টোবর",
              "নভেম্বর",
              "ডিসেম্বর"
            ];
            const date = new Date(result.data.bangladesh_time);
            const day = convertToBengaliNumbers(date.getDate());
            const month = bengaliMonths[date.getMonth()];
            const year = convertToBengaliNumbers(date.getFullYear());
            const hours = convertToBengaliNumbers(date.getHours().toString().padStart(2, "0"));
            const minutes = convertToBengaliNumbers(date.getMinutes().toString().padStart(2, "0"));
            lastUpdated.value = `${day} ${month} ${year}, ${hours}:${minutes} (বাংলাদেশ সময়)`;
          }
        }
      } catch (error) {
        console.error("Error loading stats:", error);
      }
    };
    const performSearch = async () => {
      var _a, _b, _c, _d;
      if (!phoneInput.value) {
        (_a = window.$toast) == null ? void 0 : _a.call(window, { message: "Please enter a phone number", type: "error" });
        return;
      }
      const phoneRegex = /^01[0-9]{9}$/;
      if (!phoneRegex.test(phoneInput.value)) {
        (_b = window.$toast) == null ? void 0 : _b.call(window, { message: "Please enter a valid Bangladesh mobile number (e.g. 01600000000)", type: "error" });
        return;
      }
      isSearching.value = true;
      showEmptyState.value = false;
      searchResults.value = null;
      try {
        const response = await fetch("/courier-check", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": props.csrfToken
          },
          body: JSON.stringify({ phone: phoneInput.value })
        });
        if (response.status === 429) {
          const rateLimitData = await response.json();
          (_c = window.$toast) == null ? void 0 : _c.call(window, {
            message: `দৈনিক সার্চ সীমা (${rateLimitData.limit} টি) অতিক্রম করা হয়েছে।`,
            type: "warning"
          });
          showEmptyState.value = true;
          return;
        }
        const data = await response.json();
        searchResults.value = data;
        await loadReviews();
        await loadStats();
      } catch (error) {
        console.error("Search error:", error);
        (_d = window.$toast) == null ? void 0 : _d.call(window, { message: "ডাটা লোড করতে সমস্যা হয়েছে", type: "error" });
        showEmptyState.value = true;
      } finally {
        isSearching.value = false;
      }
    };
    const loadReviews = async () => {
      try {
        const response = await fetch(`/customer-reviews/${phoneInput.value}`, {
          headers: {
            "X-CSRF-TOKEN": props.csrfToken
          }
        });
        const data = await response.json();
        reviews.value = data.data || [];
      } catch (error) {
        console.error("Error loading reviews:", error);
        reviews.value = [];
      }
    };
    const submitReview = async () => {
      var _a, _b, _c;
      if (!reviewForm.value.name || !reviewForm.value.comment || reviewForm.value.rating === 0) {
        (_a = window.$toast) == null ? void 0 : _a.call(window, { message: "সব তথ্য পূরণ করুন", type: "error" });
        return;
      }
      isSubmittingReview.value = true;
      try {
        const response = await fetch("/customer-review", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": props.csrfToken
          },
          body: JSON.stringify({
            phone: phoneInput.value,
            ownNumber: reviewForm.value.ownNumber,
            name: reviewForm.value.name,
            rating: reviewForm.value.rating,
            comment: reviewForm.value.comment
          })
        });
        const data = await response.json();
        if (data.data) {
          reviews.value.unshift(data.data);
        }
        showRatingModal.value = false;
        reviewForm.value = { ownNumber: "", name: "", rating: 0, comment: "" };
        (_b = window.$toast) == null ? void 0 : _b.call(window, { message: "আপনার রিভিউ সফলভাবে যোগ করা হয়েছে!", type: "success" });
      } catch (error) {
        console.error("Error submitting review:", error);
        (_c = window.$toast) == null ? void 0 : _c.call(window, { message: "কিছু ভুল হয়েছে। আবার চেষ্টা করুন।", type: "error" });
      } finally {
        isSubmittingReview.value = false;
      }
    };
    const toggleFaq = (index) => {
      activeFaq.value = activeFaq.value === index ? null : index;
    };
    const faqs = [
      {
        question: "FraudShield কীভাবে কাজ করে?",
        answer: "FraudShield বাংলাদেশের বিভিন্ন কুরিয়ার সার্ভিস থেকে ডাটা সংগ্রহ করে এবং ডেলিভারি সাফল্য, বাতিল হার এবং অন্যান্য ফ্যাক্টর ব্যবহার করে ফ্রড স্কোর তৈরি করে।"
      },
      {
        question: "FraudShield ব্যবহার করার খরচ কত?",
        answer: "FraudShield বর্তমানে বিনামূল্যে ব্যবহার করা যায়। ভবিষ্যতে আমরা প্রিমিয়াম প্ল্যান চালু করব যেখানে আরও উন্নত ফিচার থাকবে।"
      },
      {
        question: "FraudShield এর ডাটা কতটা নির্ভরযোগ্য?",
        answer: "আমরা বাংলাদেশের সকল প্রধান কুরিয়ার সার্ভিস থেকে রিয়েল-টাইম ডাটা সংগ্রহ করি এবং আমাদের এলগরিদম 95% এরও বেশি সঠিকতার সাথে ফ্রড সনাক্ত করতে পারে।"
      },
      {
        question: "আমি কীভাবে আমার ব্যবসার জন্য FraudShield ইন্টিগ্রেট করতে পারি?",
        answer: "আমাদের API ব্যবহার করে আপনি আপনার ওয়েবসাইট বা অ্যাপে FraudShield ইন্টিগ্রেট করতে পারেন। বিস্তারিত জানতে আমাদের সাথে যোগাযোগ করুন।"
      }
    ];
    onMounted(() => {
      loadStats();
      statsInterval = setInterval(loadStats, 3e4);
      document.addEventListener("visibilitychange", () => {
        if (document.hidden && statsInterval) {
          clearInterval(statsInterval);
        } else {
          loadStats();
          statsInterval = setInterval(loadStats, 3e4);
        }
      });
    });
    onUnmounted(() => {
      if (statsInterval) {
        clearInterval(statsInterval);
      }
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(head_default), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title${_scopeId}>FraudShield - বাংলাদেশী কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Courier Fraud Detection</title><meta name="description" content="বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।"${_scopeId}><meta name="keywords" content="courier fraud bangladesh, fraud detection system, bangladeshi courier check, courier ফ্রড, কুরিয়ার ফ্রড চেক"${_scopeId}><meta property="og:title" content="FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম"${_scopeId}><meta property="og:description" content="মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।"${_scopeId}><meta property="og:type" content="website"${_scopeId}><meta property="og:url" content="https://fraudshieldbd.site"${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, "FraudShield - বাংলাদেশী কুরিয়ার ফ্রড ডিটেকশন সিস্টেম | Courier Fraud Detection"),
              createVNode("meta", {
                name: "description",
                content: "বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।"
              }),
              createVNode("meta", {
                name: "keywords",
                content: "courier fraud bangladesh, fraud detection system, bangladeshi courier check, courier ফ্রড, কুরিয়ার ফ্রড চেক"
              }),
              createVNode("meta", {
                property: "og:title",
                content: "FraudShield - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম"
              }),
              createVNode("meta", {
                property: "og:description",
                content: "মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস দেখুন এবং বিশ্বাসযোগ্যতা যাচাই করুন।"
              }),
              createVNode("meta", {
                property: "og:type",
                content: "website"
              }),
              createVNode("meta", {
                property: "og:url",
                content: "https://fraudshieldbd.site"
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$9, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<section class="py-12 px-4 overflow-visible"${_scopeId}><div class="container mx-auto overflow-visible"${_scopeId}><div class="text-center mb-8"${_scopeId}><h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2 flex items-center justify-center gap-2"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(BarChart3), { class: "w-6 h-6 text-indigo-600 dark:text-indigo-400" }, null, _parent2, _scopeId));
            _push2(` সার্চ পরিসংখ্যান </h2><p class="text-gray-600 dark:text-gray-300"${_scopeId}>রিয়েল-টাইম সার্চ ডেটা এবং ব্যবহারকারীর কার্যক্রম</p></div><div class="grid grid-cols-2 lg:grid-cols-4 gap-4"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$a, { class: "p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/50 dark:to-blue-800/50 border-blue-200 dark:border-blue-700 hover:scale-[1.02] transition-transform text-center" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<div class="inline-flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-xl shadow-lg mb-3"${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(Clock), { class: "w-5 h-5" }, null, _parent3, _scopeId2));
                  _push3(`</div><div class="text-2xl font-bold text-blue-600 dark:text-blue-300 mb-1"${_scopeId2}>${ssrInterpolate(unref(formatBengaliNumber)(stats.value.lastHour))}</div><div class="text-sm text-blue-500 dark:text-blue-300 font-semibold mb-1"${_scopeId2}>শেষ ১ ঘন্টায়</div><p class="text-xs text-gray-500 dark:text-gray-400"${_scopeId2}>সর্বশেষ ৬০ মিনিটের সার্চ</p>`);
                } else {
                  return [
                    createVNode("div", { class: "inline-flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-xl shadow-lg mb-3" }, [
                      createVNode(unref(Clock), { class: "w-5 h-5" })
                    ]),
                    createVNode("div", { class: "text-2xl font-bold text-blue-600 dark:text-blue-300 mb-1" }, toDisplayString(unref(formatBengaliNumber)(stats.value.lastHour)), 1),
                    createVNode("div", { class: "text-sm text-blue-500 dark:text-blue-300 font-semibold mb-1" }, "শেষ ১ ঘন্টায়"),
                    createVNode("p", { class: "text-xs text-gray-500 dark:text-gray-400" }, "সর্বশেষ ৬০ মিনিটের সার্চ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$a, { class: "p-4 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/50 dark:to-green-800/50 border-green-200 dark:border-green-700 hover:scale-[1.02] transition-transform text-center" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<div class="inline-flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-xl shadow-lg mb-3"${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(Calendar), { class: "w-5 h-5" }, null, _parent3, _scopeId2));
                  _push3(`</div><div class="text-2xl font-bold text-green-600 dark:text-green-300 mb-1"${_scopeId2}>${ssrInterpolate(unref(formatBengaliNumber)(stats.value.today))}</div><div class="text-sm text-green-500 dark:text-green-300 font-semibold mb-1"${_scopeId2}>আজকের সার্চ</div><p class="text-xs text-gray-500 dark:text-gray-400"${_scopeId2}>আজ রাত ১২টা থেকে এখন পর্যন্ত</p>`);
                } else {
                  return [
                    createVNode("div", { class: "inline-flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-xl shadow-lg mb-3" }, [
                      createVNode(unref(Calendar), { class: "w-5 h-5" })
                    ]),
                    createVNode("div", { class: "text-2xl font-bold text-green-600 dark:text-green-300 mb-1" }, toDisplayString(unref(formatBengaliNumber)(stats.value.today)), 1),
                    createVNode("div", { class: "text-sm text-green-500 dark:text-green-300 font-semibold mb-1" }, "আজকের সার্চ"),
                    createVNode("p", { class: "text-xs text-gray-500 dark:text-gray-400" }, "আজ রাত ১২টা থেকে এখন পর্যন্ত")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$a, { class: "p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/50 dark:to-purple-800/50 border-purple-200 dark:border-purple-700 hover:scale-[1.02] transition-transform text-center" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<div class="inline-flex items-center justify-center w-10 h-10 bg-purple-500 text-white rounded-xl shadow-lg mb-3"${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(Infinity), { class: "w-5 h-5" }, null, _parent3, _scopeId2));
                  _push3(`</div><div class="text-2xl font-bold text-purple-600 dark:text-purple-300 mb-1"${_scopeId2}>${ssrInterpolate(unref(formatBengaliNumber)(stats.value.allTime))}</div><div class="text-sm text-purple-500 dark:text-purple-300 font-semibold mb-1"${_scopeId2}>সর্বমোট সার্চ</div><p class="text-xs text-gray-500 dark:text-gray-400"${_scopeId2}>সর্বকালের মোট সার্চ সংখ্যা</p>`);
                } else {
                  return [
                    createVNode("div", { class: "inline-flex items-center justify-center w-10 h-10 bg-purple-500 text-white rounded-xl shadow-lg mb-3" }, [
                      createVNode(unref(Infinity), { class: "w-5 h-5" })
                    ]),
                    createVNode("div", { class: "text-2xl font-bold text-purple-600 dark:text-purple-300 mb-1" }, toDisplayString(unref(formatBengaliNumber)(stats.value.allTime)), 1),
                    createVNode("div", { class: "text-sm text-purple-500 dark:text-purple-300 font-semibold mb-1" }, "সর্বমোট সার্চ"),
                    createVNode("p", { class: "text-xs text-gray-500 dark:text-gray-400" }, "সর্বকালের মোট সার্চ সংখ্যা")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$a, { class: "p-4 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/50 dark:to-orange-800/50 border-orange-200 dark:border-orange-700 hover:scale-[1.02] transition-transform text-center" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<div class="inline-flex items-center justify-center w-10 h-10 bg-orange-500 text-white rounded-xl shadow-lg mb-3"${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(PhoneCall), { class: "w-5 h-5" }, null, _parent3, _scopeId2));
                  _push3(`</div><div class="text-2xl font-bold text-orange-600 dark:text-orange-300 mb-1"${_scopeId2}>${ssrInterpolate(unref(formatBengaliNumber)(stats.value.uniqueNumbers))}</div><div class="text-sm text-orange-500 dark:text-orange-300 font-semibold mb-1"${_scopeId2}>ইউনিক নাম্বার</div><p class="text-xs text-gray-500 dark:text-gray-400"${_scopeId2}>চেক করা মোট নাম্বার সংখ্যা</p>`);
                } else {
                  return [
                    createVNode("div", { class: "inline-flex items-center justify-center w-10 h-10 bg-orange-500 text-white rounded-xl shadow-lg mb-3" }, [
                      createVNode(unref(PhoneCall), { class: "w-5 h-5" })
                    ]),
                    createVNode("div", { class: "text-2xl font-bold text-orange-600 dark:text-orange-300 mb-1" }, toDisplayString(unref(formatBengaliNumber)(stats.value.uniqueNumbers)), 1),
                    createVNode("div", { class: "text-sm text-orange-500 dark:text-orange-300 font-semibold mb-1" }, "ইউনিক নাম্বার"),
                    createVNode("p", { class: "text-xs text-gray-500 dark:text-gray-400" }, "চেক করা মোট নাম্বার সংখ্যা")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div><div class="text-center mt-6"${_scopeId}><p class="text-sm text-gray-500 dark:text-gray-400"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(RefreshCw), { class: "w-4 h-4 inline-block align-middle mr-1" }, null, _parent2, _scopeId));
            _push2(`<span class="align-middle"${_scopeId}>সর্বশেষ আপডেট: <span class="font-medium text-gray-700 dark:text-gray-300"${_scopeId}>${ssrInterpolate(lastUpdated.value)}</span></span></p></div></div></section><section class="container mx-auto px-4 py-4"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$a, { class: "p-4 mb-4 bg-gradient-to-r from-indigo-500/5 to-purple-500/5 dark:from-indigo-500/10 dark:to-purple-500/10 border-indigo-200 dark:border-indigo-800" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<div class="text-center mb-3"${_scopeId2}><h1 class="text-lg md:text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-1"${_scopeId2}> কুরিয়ার ফ্রড চেক করুন </h1><p class="text-sm text-gray-600 dark:text-gray-400"${_scopeId2}>মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস যাচাই করুন</p></div><div class="flex flex-col md:flex-row gap-3 max-w-xl mx-auto"${_scopeId2}><div class="relative flex-1"${_scopeId2}><div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(Phone), { class: "h-4 w-4 text-indigo-500" }, null, _parent3, _scopeId2));
                  _push3(`</div><input${ssrRenderAttr("value", phoneInput.value)} type="text" placeholder="মোবাইল নাম্বার লিখুন (যেমন: 01600000000)" class="w-full pl-10 p-3 border border-indigo-200 dark:border-indigo-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition duration-300 text-sm"${_scopeId2}></div>`);
                  _push3(ssrRenderComponent(_sfc_main$b, {
                    size: "default",
                    loading: isSearching.value,
                    onClick: performSearch,
                    class: "min-w-[140px] shadow-md"
                  }, {
                    default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                      if (_push4) {
                        _push4(ssrRenderComponent(unref(Search), { class: "w-4 h-4 mr-1" }, null, _parent4, _scopeId3));
                        _push4(` রিপোর্ট দেখুন `);
                      } else {
                        return [
                          createVNode(unref(Search), { class: "w-4 h-4 mr-1" }),
                          createTextVNode(" রিপোর্ট দেখুন ")
                        ];
                      }
                    }),
                    _: 1
                  }, _parent3, _scopeId2));
                  _push3(`</div>`);
                } else {
                  return [
                    createVNode("div", { class: "text-center mb-3" }, [
                      createVNode("h1", { class: "text-lg md:text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-1" }, " কুরিয়ার ফ্রড চেক করুন "),
                      createVNode("p", { class: "text-sm text-gray-600 dark:text-gray-400" }, "মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস যাচাই করুন")
                    ]),
                    createVNode("div", { class: "flex flex-col md:flex-row gap-3 max-w-xl mx-auto" }, [
                      createVNode("div", { class: "relative flex-1" }, [
                        createVNode("div", { class: "absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none" }, [
                          createVNode(unref(Phone), { class: "h-4 w-4 text-indigo-500" })
                        ]),
                        withDirectives(createVNode("input", {
                          "onUpdate:modelValue": ($event) => phoneInput.value = $event,
                          type: "text",
                          placeholder: "মোবাইল নাম্বার লিখুন (যেমন: 01600000000)",
                          class: "w-full pl-10 p-3 border border-indigo-200 dark:border-indigo-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition duration-300 text-sm",
                          onKeypress: withKeys(performSearch, ["enter"])
                        }, null, 40, ["onUpdate:modelValue"]), [
                          [vModelText, phoneInput.value]
                        ])
                      ]),
                      createVNode(_sfc_main$b, {
                        size: "default",
                        loading: isSearching.value,
                        onClick: performSearch,
                        class: "min-w-[140px] shadow-md"
                      }, {
                        default: withCtx(() => [
                          createVNode(unref(Search), { class: "w-4 h-4 mr-1" }),
                          createTextVNode(" রিপোর্ট দেখুন ")
                        ]),
                        _: 1
                      }, 8, ["loading"])
                    ])
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            if (isSearching.value) {
              _push2(`<div class="text-center py-16"${_scopeId}><div class="relative w-20 h-20 mx-auto mb-6"${_scopeId}><div class="absolute inset-0 rounded-full border-4 border-indigo-200 dark:border-indigo-800"${_scopeId}></div><div class="absolute inset-0 rounded-full border-4 border-indigo-600 border-t-transparent animate-spin"${_scopeId}></div>`);
              _push2(ssrRenderComponent(unref(Shield), { class: "absolute inset-0 m-auto w-8 h-8 text-indigo-600" }, null, _parent2, _scopeId));
              _push2(`</div><p class="text-gray-600 dark:text-gray-400 text-lg"${_scopeId}>ডেলিভারি ইতিহাস বিশ্লেষণ করা হচ্ছে...</p></div>`);
            } else {
              _push2(`<div class="grid grid-cols-1 lg:grid-cols-3 gap-4"${_scopeId}>`);
              _push2(ssrRenderComponent(_sfc_main$a, { class: "p-4 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 border border-gray-100 dark:border-gray-700" }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  var _a, _b, _c, _d, _e, _f, _g, _h, _i, _j, _k, _l;
                  if (_push3) {
                    _push3(`<h2 class="text-base font-bold mb-3 flex items-center gap-2 text-gray-800 dark:text-gray-100"${_scopeId2}><div class="p-1.5 bg-indigo-100 dark:bg-indigo-900 rounded-lg"${_scopeId2}>`);
                    _push3(ssrRenderComponent(unref(PieChart), { class: "w-4 h-4 text-indigo-600 dark:text-indigo-400" }, null, _parent3, _scopeId2));
                    _push3(`</div> Delivery Success Ratio </h2><div class="flex justify-center mb-3"${_scopeId2}><div class="relative w-28 h-28"${_scopeId2}><div class="absolute inset-0 rounded-full border-2 border-dashed border-gray-200 dark:border-gray-700 animate-spin" style="${ssrRenderStyle({ "animation-duration": "20s" })}"${_scopeId2}></div><div class="absolute inset-1 rounded-full bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 shadow-inner"${_scopeId2}></div><svg class="absolute inset-1 w-[calc(100%-8px)] h-[calc(100%-8px)] transform -rotate-90" viewBox="0 0 100 100"${_scopeId2}><circle class="text-gray-200 dark:text-gray-700 stroke-current" stroke-width="10" fill="transparent" r="40" cx="50" cy="50"${_scopeId2}></circle><circle class="stroke-current transition-all duration-1000 ease-out" style="${ssrRenderStyle({ color: searchResults.value ? unref(getColorForRatio)(successRatio.value) : "#6366f1" })}" stroke-width="10" stroke-linecap="round" fill="transparent" r="40" cx="50" cy="50"${ssrRenderAttr("stroke-dasharray", 251)}${ssrRenderAttr("stroke-dashoffset", searchResults.value ? 251 - 251 * successRatio.value / 100 : 251)}${_scopeId2}></circle></svg><div class="absolute inset-0 flex items-center justify-center flex-col"${_scopeId2}><span class="${ssrRenderClass([searchResults.value ? "" : "text-gray-400 dark:text-gray-500", "text-xl font-bold"])}"${_scopeId2}>${ssrInterpolate(searchResults.value ? successRatio.value.toFixed(0) : "0")}% </span><span class="${ssrRenderClass([{
                      "bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300": searchResults.value && ratingText.value === "Excellent",
                      "bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300": searchResults.value && ratingText.value === "Good",
                      "bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300": searchResults.value && ratingText.value === "Poor",
                      "bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400": !searchResults.value || ratingText.value === "New"
                    }, "text-xs font-medium px-2 py-0.5 rounded-full"])}"${_scopeId2}>${ssrInterpolate(searchResults.value ? ratingText.value : "N/A")}</span></div></div></div><div class="${ssrRenderClass([{
                      "bg-gray-100 dark:bg-gray-800": !searchResults.value,
                      "bg-green-50 dark:bg-green-900/30": searchResults.value && riskLevel.value.level === "low",
                      "bg-yellow-50 dark:bg-yellow-900/30": searchResults.value && riskLevel.value.level === "medium",
                      "bg-red-50 dark:bg-red-900/30": searchResults.value && riskLevel.value.level === "high"
                    }, "text-center mb-3 p-2 rounded-lg text-sm"])}"${_scopeId2}>`);
                    if (!searchResults.value) {
                      _push3(`<p class="text-gray-600 dark:text-gray-400 text-xs"${_scopeId2}>`);
                      _push3(ssrRenderComponent(unref(Phone), { class: "w-3 h-3 inline-block mr-1 -mt-0.5" }, null, _parent3, _scopeId2));
                      _push3(` মোবাইল নাম্বার দিয়ে সার্চ করুন </p>`);
                    } else {
                      _push3(`<p class="${ssrRenderClass([{
                        "text-green-700 dark:text-green-300": riskLevel.value.level === "low",
                        "text-yellow-700 dark:text-yellow-300": riskLevel.value.level === "medium",
                        "text-red-700 dark:text-red-300": riskLevel.value.level === "high",
                        "text-gray-600 dark:text-gray-400": riskLevel.value.level === "unknown"
                      }, "font-medium text-xs"])}"${_scopeId2}>${ssrInterpolate(riskLevel.value.level === "low" ? "এই গ্রাহক বিশ্বস্ত!" : riskLevel.value.level === "medium" ? "সতর্কতার সাথে এগিয়ে যান" : riskLevel.value.level === "high" ? "উচ্চ ঝুঁকিপূর্ণ গ্রাহক!" : "ডেলিভারি ইতিহাস নেই")}</p>`);
                    }
                    _push3(`</div><div class="${ssrRenderClass([{
                      "bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-md": searchResults.value && riskLevel.value.level === "low",
                      "bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-md": searchResults.value && riskLevel.value.level === "medium",
                      "bg-gradient-to-r from-red-500 to-rose-500 text-white shadow-md": searchResults.value && riskLevel.value.level === "high",
                      "bg-gradient-to-r from-gray-400 to-gray-500 text-white": !searchResults.value || riskLevel.value.level === "unknown"
                    }, "text-center py-2 px-3 rounded-lg flex items-center justify-center gap-2 font-medium text-sm transition-all duration-300"])}"${_scopeId2}>`);
                    ssrRenderVNode(_push3, createVNode(resolveDynamicComponent(searchResults.value ? riskLevel.value.icon : unref(HelpCircle)), { class: "w-4 h-4" }, null), _parent3, _scopeId2);
                    _push3(` ${ssrInterpolate(searchResults.value ? riskLevel.value.label : "Waiting")}</div><div class="mt-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700"${_scopeId2}><h3 class="font-medium text-xs mb-2 flex items-center gap-1.5 text-gray-800 dark:text-gray-100"${_scopeId2}>`);
                    _push3(ssrRenderComponent(unref(Shield), { class: "w-3 h-3 text-indigo-600 dark:text-indigo-400" }, null, _parent3, _scopeId2));
                    _push3(` Risk Factors </h3><ul class="space-y-1.5"${_scopeId2}><li class="${ssrRenderClass([searchResults.value && successRatio.value >= 90 ? "bg-green-50 dark:bg-green-900/20" : "bg-gray-50 dark:bg-gray-700/50", "flex items-center text-xs gap-2 p-1.5 rounded"])}"${_scopeId2}><div class="${ssrRenderClass([searchResults.value && successRatio.value >= 90 ? "bg-green-500" : "bg-gray-300 dark:bg-gray-600", "p-1 rounded-full"])}"${_scopeId2}>`);
                    _push3(ssrRenderComponent(unref(CheckCircle), { class: "w-2.5 h-2.5 text-white" }, null, _parent3, _scopeId2));
                    _push3(`</div><span class="${ssrRenderClass(searchResults.value && successRatio.value >= 90 ? "text-green-700 dark:text-green-300" : "text-gray-500 dark:text-gray-400")}"${_scopeId2}> High success rate </span></li><li class="${ssrRenderClass([searchResults.value && ((_b = (_a = searchResults.value.courierData) == null ? void 0 : _a.summary) == null ? void 0 : _b.cancelled_parcel) > 3 ? "bg-red-50 dark:bg-red-900/20" : "bg-gray-50 dark:bg-gray-700/50", "flex items-center text-xs gap-2 p-1.5 rounded"])}"${_scopeId2}><div class="${ssrRenderClass([searchResults.value && ((_d = (_c = searchResults.value.courierData) == null ? void 0 : _c.summary) == null ? void 0 : _d.cancelled_parcel) > 3 ? "bg-red-500" : "bg-gray-300 dark:bg-gray-600", "p-1 rounded-full"])}"${_scopeId2}>`);
                    _push3(ssrRenderComponent(unref(XCircle), { class: "w-2.5 h-2.5 text-white" }, null, _parent3, _scopeId2));
                    _push3(`</div><span class="${ssrRenderClass(searchResults.value && ((_f = (_e = searchResults.value.courierData) == null ? void 0 : _e.summary) == null ? void 0 : _f.cancelled_parcel) > 3 ? "text-red-700 dark:text-red-300" : "text-gray-500 dark:text-gray-400")}"${_scopeId2}> Multiple cancellations </span></li><li class="flex items-center text-xs gap-2 p-1.5 rounded bg-gray-50 dark:bg-gray-700/50"${_scopeId2}><div class="p-1 rounded-full bg-gray-300 dark:bg-gray-600"${_scopeId2}>`);
                    _push3(ssrRenderComponent(unref(AlertCircle), { class: "w-2.5 h-2.5 text-white" }, null, _parent3, _scopeId2));
                    _push3(`</div><span class="text-gray-500 dark:text-gray-400"${_scopeId2}>Inconsistent patterns</span></li></ul></div>`);
                  } else {
                    return [
                      createVNode("h2", { class: "text-base font-bold mb-3 flex items-center gap-2 text-gray-800 dark:text-gray-100" }, [
                        createVNode("div", { class: "p-1.5 bg-indigo-100 dark:bg-indigo-900 rounded-lg" }, [
                          createVNode(unref(PieChart), { class: "w-4 h-4 text-indigo-600 dark:text-indigo-400" })
                        ]),
                        createTextVNode(" Delivery Success Ratio ")
                      ]),
                      createVNode("div", { class: "flex justify-center mb-3" }, [
                        createVNode("div", { class: "relative w-28 h-28" }, [
                          createVNode("div", {
                            class: "absolute inset-0 rounded-full border-2 border-dashed border-gray-200 dark:border-gray-700 animate-spin",
                            style: { "animation-duration": "20s" }
                          }),
                          createVNode("div", { class: "absolute inset-1 rounded-full bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 shadow-inner" }),
                          (openBlock(), createBlock("svg", {
                            class: "absolute inset-1 w-[calc(100%-8px)] h-[calc(100%-8px)] transform -rotate-90",
                            viewBox: "0 0 100 100"
                          }, [
                            createVNode("circle", {
                              class: "text-gray-200 dark:text-gray-700 stroke-current",
                              "stroke-width": "10",
                              fill: "transparent",
                              r: "40",
                              cx: "50",
                              cy: "50"
                            }),
                            createVNode("circle", {
                              class: "stroke-current transition-all duration-1000 ease-out",
                              style: { color: searchResults.value ? unref(getColorForRatio)(successRatio.value) : "#6366f1" },
                              "stroke-width": "10",
                              "stroke-linecap": "round",
                              fill: "transparent",
                              r: "40",
                              cx: "50",
                              cy: "50",
                              "stroke-dasharray": 251,
                              "stroke-dashoffset": searchResults.value ? 251 - 251 * successRatio.value / 100 : 251
                            }, null, 12, ["stroke-dashoffset"])
                          ])),
                          createVNode("div", { class: "absolute inset-0 flex items-center justify-center flex-col" }, [
                            createVNode("span", {
                              class: ["text-xl font-bold", searchResults.value ? "" : "text-gray-400 dark:text-gray-500"]
                            }, toDisplayString(searchResults.value ? successRatio.value.toFixed(0) : "0") + "% ", 3),
                            createVNode("span", {
                              class: ["text-xs font-medium px-2 py-0.5 rounded-full", {
                                "bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300": searchResults.value && ratingText.value === "Excellent",
                                "bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300": searchResults.value && ratingText.value === "Good",
                                "bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300": searchResults.value && ratingText.value === "Poor",
                                "bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400": !searchResults.value || ratingText.value === "New"
                              }]
                            }, toDisplayString(searchResults.value ? ratingText.value : "N/A"), 3)
                          ])
                        ])
                      ]),
                      createVNode("div", {
                        class: ["text-center mb-3 p-2 rounded-lg text-sm", {
                          "bg-gray-100 dark:bg-gray-800": !searchResults.value,
                          "bg-green-50 dark:bg-green-900/30": searchResults.value && riskLevel.value.level === "low",
                          "bg-yellow-50 dark:bg-yellow-900/30": searchResults.value && riskLevel.value.level === "medium",
                          "bg-red-50 dark:bg-red-900/30": searchResults.value && riskLevel.value.level === "high"
                        }]
                      }, [
                        !searchResults.value ? (openBlock(), createBlock("p", {
                          key: 0,
                          class: "text-gray-600 dark:text-gray-400 text-xs"
                        }, [
                          createVNode(unref(Phone), { class: "w-3 h-3 inline-block mr-1 -mt-0.5" }),
                          createTextVNode(" মোবাইল নাম্বার দিয়ে সার্চ করুন ")
                        ])) : (openBlock(), createBlock("p", {
                          key: 1,
                          class: ["font-medium text-xs", {
                            "text-green-700 dark:text-green-300": riskLevel.value.level === "low",
                            "text-yellow-700 dark:text-yellow-300": riskLevel.value.level === "medium",
                            "text-red-700 dark:text-red-300": riskLevel.value.level === "high",
                            "text-gray-600 dark:text-gray-400": riskLevel.value.level === "unknown"
                          }]
                        }, toDisplayString(riskLevel.value.level === "low" ? "এই গ্রাহক বিশ্বস্ত!" : riskLevel.value.level === "medium" ? "সতর্কতার সাথে এগিয়ে যান" : riskLevel.value.level === "high" ? "উচ্চ ঝুঁকিপূর্ণ গ্রাহক!" : "ডেলিভারি ইতিহাস নেই"), 3))
                      ], 2),
                      createVNode("div", {
                        class: ["text-center py-2 px-3 rounded-lg flex items-center justify-center gap-2 font-medium text-sm transition-all duration-300", {
                          "bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-md": searchResults.value && riskLevel.value.level === "low",
                          "bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-md": searchResults.value && riskLevel.value.level === "medium",
                          "bg-gradient-to-r from-red-500 to-rose-500 text-white shadow-md": searchResults.value && riskLevel.value.level === "high",
                          "bg-gradient-to-r from-gray-400 to-gray-500 text-white": !searchResults.value || riskLevel.value.level === "unknown"
                        }]
                      }, [
                        (openBlock(), createBlock(resolveDynamicComponent(searchResults.value ? riskLevel.value.icon : unref(HelpCircle)), { class: "w-4 h-4" })),
                        createTextVNode(" " + toDisplayString(searchResults.value ? riskLevel.value.label : "Waiting"), 1)
                      ], 2),
                      createVNode("div", { class: "mt-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700" }, [
                        createVNode("h3", { class: "font-medium text-xs mb-2 flex items-center gap-1.5 text-gray-800 dark:text-gray-100" }, [
                          createVNode(unref(Shield), { class: "w-3 h-3 text-indigo-600 dark:text-indigo-400" }),
                          createTextVNode(" Risk Factors ")
                        ]),
                        createVNode("ul", { class: "space-y-1.5" }, [
                          createVNode("li", {
                            class: ["flex items-center text-xs gap-2 p-1.5 rounded", searchResults.value && successRatio.value >= 90 ? "bg-green-50 dark:bg-green-900/20" : "bg-gray-50 dark:bg-gray-700/50"]
                          }, [
                            createVNode("div", {
                              class: ["p-1 rounded-full", searchResults.value && successRatio.value >= 90 ? "bg-green-500" : "bg-gray-300 dark:bg-gray-600"]
                            }, [
                              createVNode(unref(CheckCircle), { class: "w-2.5 h-2.5 text-white" })
                            ], 2),
                            createVNode("span", {
                              class: searchResults.value && successRatio.value >= 90 ? "text-green-700 dark:text-green-300" : "text-gray-500 dark:text-gray-400"
                            }, " High success rate ", 2)
                          ], 2),
                          createVNode("li", {
                            class: ["flex items-center text-xs gap-2 p-1.5 rounded", searchResults.value && ((_h = (_g = searchResults.value.courierData) == null ? void 0 : _g.summary) == null ? void 0 : _h.cancelled_parcel) > 3 ? "bg-red-50 dark:bg-red-900/20" : "bg-gray-50 dark:bg-gray-700/50"]
                          }, [
                            createVNode("div", {
                              class: ["p-1 rounded-full", searchResults.value && ((_j = (_i = searchResults.value.courierData) == null ? void 0 : _i.summary) == null ? void 0 : _j.cancelled_parcel) > 3 ? "bg-red-500" : "bg-gray-300 dark:bg-gray-600"]
                            }, [
                              createVNode(unref(XCircle), { class: "w-2.5 h-2.5 text-white" })
                            ], 2),
                            createVNode("span", {
                              class: searchResults.value && ((_l = (_k = searchResults.value.courierData) == null ? void 0 : _k.summary) == null ? void 0 : _l.cancelled_parcel) > 3 ? "text-red-700 dark:text-red-300" : "text-gray-500 dark:text-gray-400"
                            }, " Multiple cancellations ", 2)
                          ], 2),
                          createVNode("li", { class: "flex items-center text-xs gap-2 p-1.5 rounded bg-gray-50 dark:bg-gray-700/50" }, [
                            createVNode("div", { class: "p-1 rounded-full bg-gray-300 dark:bg-gray-600" }, [
                              createVNode(unref(AlertCircle), { class: "w-2.5 h-2.5 text-white" })
                            ]),
                            createVNode("span", { class: "text-gray-500 dark:text-gray-400" }, "Inconsistent patterns")
                          ])
                        ])
                      ])
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
              _push2(`<div class="lg:col-span-2 space-y-6"${_scopeId}>`);
              if (searchResults.value) {
                _push2(`<!--[-->`);
                _push2(ssrRenderComponent(unref(_sfc_main$c), {
                  variant: riskLevel.value.level === "low" ? "success" : riskLevel.value.level === "medium" ? "warning" : riskLevel.value.level === "high" ? "destructive" : "default",
                  class: "border-l-4"
                }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      ssrRenderVNode(_push3, createVNode(resolveDynamicComponent(riskLevel.value.icon), { class: "h-5 w-5" }, null), _parent3, _scopeId2);
                      _push3(ssrRenderComponent(unref(_sfc_main$d), { class: "text-lg" }, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            _push4(`${ssrInterpolate(riskLevel.value.level === "low" ? "বিশ্বস্ত গ্রাহক" : riskLevel.value.level === "medium" ? "সতর্কতার সাথে এগিয়ে যান" : riskLevel.value.level === "high" ? "উচ্চ ঝুঁকি সতর্কতা" : "নতুন গ্রাহক")}`);
                          } else {
                            return [
                              createTextVNode(toDisplayString(riskLevel.value.level === "low" ? "বিশ্বস্ত গ্রাহক" : riskLevel.value.level === "medium" ? "সতর্কতার সাথে এগিয়ে যান" : riskLevel.value.level === "high" ? "উচ্চ ঝুঁকি সতর্কতা" : "নতুন গ্রাহক"), 1)
                            ];
                          }
                        }),
                        _: 1
                      }, _parent3, _scopeId2));
                      _push3(ssrRenderComponent(unref(_sfc_main$e), null, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            if (riskLevel.value.level === "low") {
                              _push4(`<!--[--> এই গ্রাহকের ${ssrInterpolate(successRatio.value.toFixed(1))}% সাফল্যের হার সহ চমৎকার ডেলিভারি ইতিহাস রয়েছে। <!--]-->`);
                            } else if (riskLevel.value.level === "medium") {
                              _push4(`<!--[-->${ssrInterpolate(successRatio.value.toFixed(1))}% সাফল্যের হার সহ সাধারণত ভালো ইতিহাস, তবে কিছু যাচাই করা উচিত। <!--]-->`);
                            } else if (riskLevel.value.level === "high") {
                              _push4(`<!--[--> মাত্র ${ssrInterpolate(successRatio.value.toFixed(1))}% সাফল্যের হার। অতিরিক্ত যাচাই দৃঢ়ভাবে সুপারিশ করা হয়। <!--]-->`);
                            } else {
                              _push4(`<!--[--> এই নম্বরের জন্য কোন ডেলিভারি ইতিহাস পাওয়া যায়নি। <!--]-->`);
                            }
                          } else {
                            return [
                              riskLevel.value.level === "low" ? (openBlock(), createBlock(Fragment, { key: 0 }, [
                                createTextVNode(" এই গ্রাহকের " + toDisplayString(successRatio.value.toFixed(1)) + "% সাফল্যের হার সহ চমৎকার ডেলিভারি ইতিহাস রয়েছে। ", 1)
                              ], 64)) : riskLevel.value.level === "medium" ? (openBlock(), createBlock(Fragment, { key: 1 }, [
                                createTextVNode(toDisplayString(successRatio.value.toFixed(1)) + "% সাফল্যের হার সহ সাধারণত ভালো ইতিহাস, তবে কিছু যাচাই করা উচিত। ", 1)
                              ], 64)) : riskLevel.value.level === "high" ? (openBlock(), createBlock(Fragment, { key: 2 }, [
                                createTextVNode(" মাত্র " + toDisplayString(successRatio.value.toFixed(1)) + "% সাফল্যের হার। অতিরিক্ত যাচাই দৃঢ়ভাবে সুপারিশ করা হয়। ", 1)
                              ], 64)) : (openBlock(), createBlock(Fragment, { key: 3 }, [
                                createTextVNode(" এই নম্বরের জন্য কোন ডেলিভারি ইতিহাস পাওয়া যায়নি। ")
                              ], 64))
                            ];
                          }
                        }),
                        _: 1
                      }, _parent3, _scopeId2));
                    } else {
                      return [
                        (openBlock(), createBlock(resolveDynamicComponent(riskLevel.value.icon), { class: "h-5 w-5" })),
                        createVNode(unref(_sfc_main$d), { class: "text-lg" }, {
                          default: withCtx(() => [
                            createTextVNode(toDisplayString(riskLevel.value.level === "low" ? "বিশ্বস্ত গ্রাহক" : riskLevel.value.level === "medium" ? "সতর্কতার সাথে এগিয়ে যান" : riskLevel.value.level === "high" ? "উচ্চ ঝুঁকি সতর্কতা" : "নতুন গ্রাহক"), 1)
                          ]),
                          _: 1
                        }),
                        createVNode(unref(_sfc_main$e), null, {
                          default: withCtx(() => [
                            riskLevel.value.level === "low" ? (openBlock(), createBlock(Fragment, { key: 0 }, [
                              createTextVNode(" এই গ্রাহকের " + toDisplayString(successRatio.value.toFixed(1)) + "% সাফল্যের হার সহ চমৎকার ডেলিভারি ইতিহাস রয়েছে। ", 1)
                            ], 64)) : riskLevel.value.level === "medium" ? (openBlock(), createBlock(Fragment, { key: 1 }, [
                              createTextVNode(toDisplayString(successRatio.value.toFixed(1)) + "% সাফল্যের হার সহ সাধারণত ভালো ইতিহাস, তবে কিছু যাচাই করা উচিত। ", 1)
                            ], 64)) : riskLevel.value.level === "high" ? (openBlock(), createBlock(Fragment, { key: 2 }, [
                              createTextVNode(" মাত্র " + toDisplayString(successRatio.value.toFixed(1)) + "% সাফল্যের হার। অতিরিক্ত যাচাই দৃঢ়ভাবে সুপারিশ করা হয়। ", 1)
                            ], 64)) : (openBlock(), createBlock(Fragment, { key: 3 }, [
                              createTextVNode(" এই নম্বরের জন্য কোন ডেলিভারি ইতিহাস পাওয়া যায়নি। ")
                            ], 64))
                          ]),
                          _: 1
                        })
                      ];
                    }
                  }),
                  _: 1
                }, _parent2, _scopeId));
                _push2(`<div class="grid grid-cols-3 gap-4"${_scopeId}>`);
                _push2(ssrRenderComponent(_sfc_main$a, { class: "p-5 text-center hover:shadow-lg transition-all" }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    var _a, _b, _c, _d;
                    if (_push3) {
                      _push3(`<div class="text-sm text-muted-foreground mb-2 font-medium"${_scopeId2}>মোট অর্ডার</div><div class="text-4xl font-bold text-primary mb-2"${_scopeId2}>${ssrInterpolate(((_b = (_a = searchResults.value.courierData) == null ? void 0 : _a.summary) == null ? void 0 : _b.total_parcel) || 0)}</div>`);
                      _push3(ssrRenderComponent(_sfc_main$f, {
                        variant: "outline",
                        class: "text-xs"
                      }, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            _push4(`Total Orders`);
                          } else {
                            return [
                              createTextVNode("Total Orders")
                            ];
                          }
                        }),
                        _: 1
                      }, _parent3, _scopeId2));
                    } else {
                      return [
                        createVNode("div", { class: "text-sm text-muted-foreground mb-2 font-medium" }, "মোট অর্ডার"),
                        createVNode("div", { class: "text-4xl font-bold text-primary mb-2" }, toDisplayString(((_d = (_c = searchResults.value.courierData) == null ? void 0 : _c.summary) == null ? void 0 : _d.total_parcel) || 0), 1),
                        createVNode(_sfc_main$f, {
                          variant: "outline",
                          class: "text-xs"
                        }, {
                          default: withCtx(() => [
                            createTextVNode("Total Orders")
                          ]),
                          _: 1
                        })
                      ];
                    }
                  }),
                  _: 1
                }, _parent2, _scopeId));
                _push2(ssrRenderComponent(_sfc_main$a, { class: "p-5 text-center hover:shadow-lg transition-all" }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    var _a, _b, _c, _d;
                    if (_push3) {
                      _push3(`<div class="text-sm text-muted-foreground mb-2 font-medium"${_scopeId2}>মোট ডেলিভারি</div><div class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2"${_scopeId2}>${ssrInterpolate(((_b = (_a = searchResults.value.courierData) == null ? void 0 : _a.summary) == null ? void 0 : _b.success_parcel) || 0)}</div>`);
                      _push3(ssrRenderComponent(_sfc_main$f, {
                        variant: "success",
                        class: "text-xs"
                      }, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            _push4(`Delivered`);
                          } else {
                            return [
                              createTextVNode("Delivered")
                            ];
                          }
                        }),
                        _: 1
                      }, _parent3, _scopeId2));
                    } else {
                      return [
                        createVNode("div", { class: "text-sm text-muted-foreground mb-2 font-medium" }, "মোট ডেলিভারি"),
                        createVNode("div", { class: "text-4xl font-bold text-green-600 dark:text-green-400 mb-2" }, toDisplayString(((_d = (_c = searchResults.value.courierData) == null ? void 0 : _c.summary) == null ? void 0 : _d.success_parcel) || 0), 1),
                        createVNode(_sfc_main$f, {
                          variant: "success",
                          class: "text-xs"
                        }, {
                          default: withCtx(() => [
                            createTextVNode("Delivered")
                          ]),
                          _: 1
                        })
                      ];
                    }
                  }),
                  _: 1
                }, _parent2, _scopeId));
                _push2(ssrRenderComponent(_sfc_main$a, { class: "p-5 text-center hover:shadow-lg transition-all" }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    var _a, _b, _c, _d;
                    if (_push3) {
                      _push3(`<div class="text-sm text-muted-foreground mb-2 font-medium"${_scopeId2}>মোট বাতিল</div><div class="text-4xl font-bold text-red-600 dark:text-red-400 mb-2"${_scopeId2}>${ssrInterpolate(((_b = (_a = searchResults.value.courierData) == null ? void 0 : _a.summary) == null ? void 0 : _b.cancelled_parcel) || 0)}</div>`);
                      _push3(ssrRenderComponent(_sfc_main$f, {
                        variant: "destructive",
                        class: "text-xs"
                      }, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            _push4(`Cancelled`);
                          } else {
                            return [
                              createTextVNode("Cancelled")
                            ];
                          }
                        }),
                        _: 1
                      }, _parent3, _scopeId2));
                    } else {
                      return [
                        createVNode("div", { class: "text-sm text-muted-foreground mb-2 font-medium" }, "মোট বাতিল"),
                        createVNode("div", { class: "text-4xl font-bold text-red-600 dark:text-red-400 mb-2" }, toDisplayString(((_d = (_c = searchResults.value.courierData) == null ? void 0 : _c.summary) == null ? void 0 : _d.cancelled_parcel) || 0), 1),
                        createVNode(_sfc_main$f, {
                          variant: "destructive",
                          class: "text-xs"
                        }, {
                          default: withCtx(() => [
                            createTextVNode("Cancelled")
                          ]),
                          _: 1
                        })
                      ];
                    }
                  }),
                  _: 1
                }, _parent2, _scopeId));
                _push2(`</div>`);
                _push2(ssrRenderComponent(_sfc_main$a, { class: "p-5" }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(`<div class="flex items-center justify-between mb-3"${_scopeId2}><span class="text-sm font-medium text-muted-foreground"${_scopeId2}>সাফল্যের হার</span>`);
                      _push3(ssrRenderComponent(_sfc_main$f, {
                        variant: successRatio.value >= 90 ? "success" : successRatio.value >= 70 ? "warning" : "destructive"
                      }, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            _push4(`${ssrInterpolate(successRatio.value.toFixed(1))}% `);
                          } else {
                            return [
                              createTextVNode(toDisplayString(successRatio.value.toFixed(1)) + "% ", 1)
                            ];
                          }
                        }),
                        _: 1
                      }, _parent3, _scopeId2));
                      _push3(`</div>`);
                      _push3(ssrRenderComponent(_sfc_main$g, {
                        "model-value": successRatio.value,
                        class: "h-3",
                        "indicator-class": successRatio.value >= 90 ? "bg-green-500" : successRatio.value >= 70 ? "bg-yellow-500" : "bg-red-500"
                      }, null, _parent3, _scopeId2));
                    } else {
                      return [
                        createVNode("div", { class: "flex items-center justify-between mb-3" }, [
                          createVNode("span", { class: "text-sm font-medium text-muted-foreground" }, "সাফল্যের হার"),
                          createVNode(_sfc_main$f, {
                            variant: successRatio.value >= 90 ? "success" : successRatio.value >= 70 ? "warning" : "destructive"
                          }, {
                            default: withCtx(() => [
                              createTextVNode(toDisplayString(successRatio.value.toFixed(1)) + "% ", 1)
                            ]),
                            _: 1
                          }, 8, ["variant"])
                        ]),
                        createVNode(_sfc_main$g, {
                          "model-value": successRatio.value,
                          class: "h-3",
                          "indicator-class": successRatio.value >= 90 ? "bg-green-500" : successRatio.value >= 70 ? "bg-yellow-500" : "bg-red-500"
                        }, null, 8, ["model-value", "indicator-class"])
                      ];
                    }
                  }),
                  _: 1
                }, _parent2, _scopeId));
                _push2(ssrRenderComponent(_sfc_main$a, { class: "p-6" }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(`<h3 class="text-lg font-bold mb-4 flex items-center gap-2"${_scopeId2}>`);
                      _push3(ssrRenderComponent(unref(BarChart3), { class: "w-5 h-5 text-primary" }, null, _parent3, _scopeId2));
                      _push3(` কুরিয়ার ডিটেইলস </h3>`);
                      _push3(ssrRenderComponent(unref(_sfc_main$6), null, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            _push4(ssrRenderComponent(unref(_sfc_main$5), null, {
                              default: withCtx((_4, _push5, _parent5, _scopeId4) => {
                                if (_push5) {
                                  _push5(ssrRenderComponent(unref(_sfc_main$3), null, {
                                    default: withCtx((_5, _push6, _parent6, _scopeId5) => {
                                      if (_push6) {
                                        _push6(ssrRenderComponent(unref(_sfc_main$2), { class: "w-[180px]" }, {
                                          default: withCtx((_6, _push7, _parent7, _scopeId6) => {
                                            if (_push7) {
                                              _push7(`Courier`);
                                            } else {
                                              return [
                                                createTextVNode("Courier")
                                              ];
                                            }
                                          }),
                                          _: 1
                                        }, _parent6, _scopeId5));
                                        _push6(ssrRenderComponent(unref(_sfc_main$2), null, {
                                          default: withCtx((_6, _push7, _parent7, _scopeId6) => {
                                            if (_push7) {
                                              _push7(`Orders`);
                                            } else {
                                              return [
                                                createTextVNode("Orders")
                                              ];
                                            }
                                          }),
                                          _: 1
                                        }, _parent6, _scopeId5));
                                        _push6(ssrRenderComponent(unref(_sfc_main$2), null, {
                                          default: withCtx((_6, _push7, _parent7, _scopeId6) => {
                                            if (_push7) {
                                              _push7(`Delivered`);
                                            } else {
                                              return [
                                                createTextVNode("Delivered")
                                              ];
                                            }
                                          }),
                                          _: 1
                                        }, _parent6, _scopeId5));
                                        _push6(ssrRenderComponent(unref(_sfc_main$2), null, {
                                          default: withCtx((_6, _push7, _parent7, _scopeId6) => {
                                            if (_push7) {
                                              _push7(`Cancelled`);
                                            } else {
                                              return [
                                                createTextVNode("Cancelled")
                                              ];
                                            }
                                          }),
                                          _: 1
                                        }, _parent6, _scopeId5));
                                        _push6(ssrRenderComponent(unref(_sfc_main$2), { class: "text-right" }, {
                                          default: withCtx((_6, _push7, _parent7, _scopeId6) => {
                                            if (_push7) {
                                              _push7(`Success Rate`);
                                            } else {
                                              return [
                                                createTextVNode("Success Rate")
                                              ];
                                            }
                                          }),
                                          _: 1
                                        }, _parent6, _scopeId5));
                                      } else {
                                        return [
                                          createVNode(unref(_sfc_main$2), { class: "w-[180px]" }, {
                                            default: withCtx(() => [
                                              createTextVNode("Courier")
                                            ]),
                                            _: 1
                                          }),
                                          createVNode(unref(_sfc_main$2), null, {
                                            default: withCtx(() => [
                                              createTextVNode("Orders")
                                            ]),
                                            _: 1
                                          }),
                                          createVNode(unref(_sfc_main$2), null, {
                                            default: withCtx(() => [
                                              createTextVNode("Delivered")
                                            ]),
                                            _: 1
                                          }),
                                          createVNode(unref(_sfc_main$2), null, {
                                            default: withCtx(() => [
                                              createTextVNode("Cancelled")
                                            ]),
                                            _: 1
                                          }),
                                          createVNode(unref(_sfc_main$2), { class: "text-right" }, {
                                            default: withCtx(() => [
                                              createTextVNode("Success Rate")
                                            ]),
                                            _: 1
                                          })
                                        ];
                                      }
                                    }),
                                    _: 1
                                  }, _parent5, _scopeId4));
                                } else {
                                  return [
                                    createVNode(unref(_sfc_main$3), null, {
                                      default: withCtx(() => [
                                        createVNode(unref(_sfc_main$2), { class: "w-[180px]" }, {
                                          default: withCtx(() => [
                                            createTextVNode("Courier")
                                          ]),
                                          _: 1
                                        }),
                                        createVNode(unref(_sfc_main$2), null, {
                                          default: withCtx(() => [
                                            createTextVNode("Orders")
                                          ]),
                                          _: 1
                                        }),
                                        createVNode(unref(_sfc_main$2), null, {
                                          default: withCtx(() => [
                                            createTextVNode("Delivered")
                                          ]),
                                          _: 1
                                        }),
                                        createVNode(unref(_sfc_main$2), null, {
                                          default: withCtx(() => [
                                            createTextVNode("Cancelled")
                                          ]),
                                          _: 1
                                        }),
                                        createVNode(unref(_sfc_main$2), { class: "text-right" }, {
                                          default: withCtx(() => [
                                            createTextVNode("Success Rate")
                                          ]),
                                          _: 1
                                        })
                                      ]),
                                      _: 1
                                    })
                                  ];
                                }
                              }),
                              _: 1
                            }, _parent4, _scopeId3));
                            _push4(ssrRenderComponent(unref(_sfc_main$4), null, {
                              default: withCtx((_4, _push5, _parent5, _scopeId4) => {
                                if (_push5) {
                                  _push5(`<!--[-->`);
                                  ssrRenderList(courierList.value, (courier) => {
                                    _push5(ssrRenderComponent(unref(_sfc_main$3), {
                                      key: courier.name
                                    }, {
                                      default: withCtx((_5, _push6, _parent6, _scopeId5) => {
                                        if (_push6) {
                                          _push6(ssrRenderComponent(unref(_sfc_main$1), { class: "font-medium" }, {
                                            default: withCtx((_6, _push7, _parent7, _scopeId6) => {
                                              if (_push7) {
                                                _push7(`<div class="flex items-center gap-2"${_scopeId6}>`);
                                                if (courier.logo) {
                                                  _push7(`<img${ssrRenderAttr("src", courier.logo)}${ssrRenderAttr("alt", courier.name)} class="w-6 h-6 object-contain rounded"${_scopeId6}>`);
                                                } else {
                                                  _push7(`<!---->`);
                                                }
                                                _push7(`<span${_scopeId6}>${ssrInterpolate(courier.name)}</span></div>`);
                                              } else {
                                                return [
                                                  createVNode("div", { class: "flex items-center gap-2" }, [
                                                    courier.logo ? (openBlock(), createBlock("img", {
                                                      key: 0,
                                                      src: courier.logo,
                                                      alt: courier.name,
                                                      class: "w-6 h-6 object-contain rounded"
                                                    }, null, 8, ["src", "alt"])) : createCommentVNode("", true),
                                                    createVNode("span", null, toDisplayString(courier.name), 1)
                                                  ])
                                                ];
                                              }
                                            }),
                                            _: 2
                                          }, _parent6, _scopeId5));
                                          _push6(ssrRenderComponent(unref(_sfc_main$1), null, {
                                            default: withCtx((_6, _push7, _parent7, _scopeId6) => {
                                              if (_push7) {
                                                _push7(ssrRenderComponent(_sfc_main$f, { variant: "outline" }, {
                                                  default: withCtx((_7, _push8, _parent8, _scopeId7) => {
                                                    if (_push8) {
                                                      _push8(`${ssrInterpolate(courier.totalParcel)}`);
                                                    } else {
                                                      return [
                                                        createTextVNode(toDisplayString(courier.totalParcel), 1)
                                                      ];
                                                    }
                                                  }),
                                                  _: 2
                                                }, _parent7, _scopeId6));
                                              } else {
                                                return [
                                                  createVNode(_sfc_main$f, { variant: "outline" }, {
                                                    default: withCtx(() => [
                                                      createTextVNode(toDisplayString(courier.totalParcel), 1)
                                                    ]),
                                                    _: 2
                                                  }, 1024)
                                                ];
                                              }
                                            }),
                                            _: 2
                                          }, _parent6, _scopeId5));
                                          _push6(ssrRenderComponent(unref(_sfc_main$1), null, {
                                            default: withCtx((_6, _push7, _parent7, _scopeId6) => {
                                              if (_push7) {
                                                _push7(ssrRenderComponent(_sfc_main$f, { variant: "success" }, {
                                                  default: withCtx((_7, _push8, _parent8, _scopeId7) => {
                                                    if (_push8) {
                                                      _push8(`${ssrInterpolate(courier.successParcel)}`);
                                                    } else {
                                                      return [
                                                        createTextVNode(toDisplayString(courier.successParcel), 1)
                                                      ];
                                                    }
                                                  }),
                                                  _: 2
                                                }, _parent7, _scopeId6));
                                              } else {
                                                return [
                                                  createVNode(_sfc_main$f, { variant: "success" }, {
                                                    default: withCtx(() => [
                                                      createTextVNode(toDisplayString(courier.successParcel), 1)
                                                    ]),
                                                    _: 2
                                                  }, 1024)
                                                ];
                                              }
                                            }),
                                            _: 2
                                          }, _parent6, _scopeId5));
                                          _push6(ssrRenderComponent(unref(_sfc_main$1), null, {
                                            default: withCtx((_6, _push7, _parent7, _scopeId6) => {
                                              if (_push7) {
                                                _push7(ssrRenderComponent(_sfc_main$f, { variant: "destructive" }, {
                                                  default: withCtx((_7, _push8, _parent8, _scopeId7) => {
                                                    if (_push8) {
                                                      _push8(`${ssrInterpolate(courier.cancelledParcel)}`);
                                                    } else {
                                                      return [
                                                        createTextVNode(toDisplayString(courier.cancelledParcel), 1)
                                                      ];
                                                    }
                                                  }),
                                                  _: 2
                                                }, _parent7, _scopeId6));
                                              } else {
                                                return [
                                                  createVNode(_sfc_main$f, { variant: "destructive" }, {
                                                    default: withCtx(() => [
                                                      createTextVNode(toDisplayString(courier.cancelledParcel), 1)
                                                    ]),
                                                    _: 2
                                                  }, 1024)
                                                ];
                                              }
                                            }),
                                            _: 2
                                          }, _parent6, _scopeId5));
                                          _push6(ssrRenderComponent(unref(_sfc_main$1), { class: "text-right" }, {
                                            default: withCtx((_6, _push7, _parent7, _scopeId6) => {
                                              if (_push7) {
                                                _push7(ssrRenderComponent(_sfc_main$f, {
                                                  class: [courier.successRatio >= 90 ? "bg-green-500 hover:bg-green-600" : courier.successRatio >= 70 ? "bg-yellow-500 hover:bg-yellow-600" : "bg-red-500 hover:bg-red-600", "text-white"]
                                                }, {
                                                  default: withCtx((_7, _push8, _parent8, _scopeId7) => {
                                                    if (_push8) {
                                                      _push8(`${ssrInterpolate(courier.successRatio.toFixed(1))}% `);
                                                    } else {
                                                      return [
                                                        createTextVNode(toDisplayString(courier.successRatio.toFixed(1)) + "% ", 1)
                                                      ];
                                                    }
                                                  }),
                                                  _: 2
                                                }, _parent7, _scopeId6));
                                              } else {
                                                return [
                                                  createVNode(_sfc_main$f, {
                                                    class: [courier.successRatio >= 90 ? "bg-green-500 hover:bg-green-600" : courier.successRatio >= 70 ? "bg-yellow-500 hover:bg-yellow-600" : "bg-red-500 hover:bg-red-600", "text-white"]
                                                  }, {
                                                    default: withCtx(() => [
                                                      createTextVNode(toDisplayString(courier.successRatio.toFixed(1)) + "% ", 1)
                                                    ]),
                                                    _: 2
                                                  }, 1032, ["class"])
                                                ];
                                              }
                                            }),
                                            _: 2
                                          }, _parent6, _scopeId5));
                                        } else {
                                          return [
                                            createVNode(unref(_sfc_main$1), { class: "font-medium" }, {
                                              default: withCtx(() => [
                                                createVNode("div", { class: "flex items-center gap-2" }, [
                                                  courier.logo ? (openBlock(), createBlock("img", {
                                                    key: 0,
                                                    src: courier.logo,
                                                    alt: courier.name,
                                                    class: "w-6 h-6 object-contain rounded"
                                                  }, null, 8, ["src", "alt"])) : createCommentVNode("", true),
                                                  createVNode("span", null, toDisplayString(courier.name), 1)
                                                ])
                                              ]),
                                              _: 2
                                            }, 1024),
                                            createVNode(unref(_sfc_main$1), null, {
                                              default: withCtx(() => [
                                                createVNode(_sfc_main$f, { variant: "outline" }, {
                                                  default: withCtx(() => [
                                                    createTextVNode(toDisplayString(courier.totalParcel), 1)
                                                  ]),
                                                  _: 2
                                                }, 1024)
                                              ]),
                                              _: 2
                                            }, 1024),
                                            createVNode(unref(_sfc_main$1), null, {
                                              default: withCtx(() => [
                                                createVNode(_sfc_main$f, { variant: "success" }, {
                                                  default: withCtx(() => [
                                                    createTextVNode(toDisplayString(courier.successParcel), 1)
                                                  ]),
                                                  _: 2
                                                }, 1024)
                                              ]),
                                              _: 2
                                            }, 1024),
                                            createVNode(unref(_sfc_main$1), null, {
                                              default: withCtx(() => [
                                                createVNode(_sfc_main$f, { variant: "destructive" }, {
                                                  default: withCtx(() => [
                                                    createTextVNode(toDisplayString(courier.cancelledParcel), 1)
                                                  ]),
                                                  _: 2
                                                }, 1024)
                                              ]),
                                              _: 2
                                            }, 1024),
                                            createVNode(unref(_sfc_main$1), { class: "text-right" }, {
                                              default: withCtx(() => [
                                                createVNode(_sfc_main$f, {
                                                  class: [courier.successRatio >= 90 ? "bg-green-500 hover:bg-green-600" : courier.successRatio >= 70 ? "bg-yellow-500 hover:bg-yellow-600" : "bg-red-500 hover:bg-red-600", "text-white"]
                                                }, {
                                                  default: withCtx(() => [
                                                    createTextVNode(toDisplayString(courier.successRatio.toFixed(1)) + "% ", 1)
                                                  ]),
                                                  _: 2
                                                }, 1032, ["class"])
                                              ]),
                                              _: 2
                                            }, 1024)
                                          ];
                                        }
                                      }),
                                      _: 2
                                    }, _parent5, _scopeId4));
                                  });
                                  _push5(`<!--]-->`);
                                } else {
                                  return [
                                    (openBlock(true), createBlock(Fragment, null, renderList(courierList.value, (courier) => {
                                      return openBlock(), createBlock(unref(_sfc_main$3), {
                                        key: courier.name
                                      }, {
                                        default: withCtx(() => [
                                          createVNode(unref(_sfc_main$1), { class: "font-medium" }, {
                                            default: withCtx(() => [
                                              createVNode("div", { class: "flex items-center gap-2" }, [
                                                courier.logo ? (openBlock(), createBlock("img", {
                                                  key: 0,
                                                  src: courier.logo,
                                                  alt: courier.name,
                                                  class: "w-6 h-6 object-contain rounded"
                                                }, null, 8, ["src", "alt"])) : createCommentVNode("", true),
                                                createVNode("span", null, toDisplayString(courier.name), 1)
                                              ])
                                            ]),
                                            _: 2
                                          }, 1024),
                                          createVNode(unref(_sfc_main$1), null, {
                                            default: withCtx(() => [
                                              createVNode(_sfc_main$f, { variant: "outline" }, {
                                                default: withCtx(() => [
                                                  createTextVNode(toDisplayString(courier.totalParcel), 1)
                                                ]),
                                                _: 2
                                              }, 1024)
                                            ]),
                                            _: 2
                                          }, 1024),
                                          createVNode(unref(_sfc_main$1), null, {
                                            default: withCtx(() => [
                                              createVNode(_sfc_main$f, { variant: "success" }, {
                                                default: withCtx(() => [
                                                  createTextVNode(toDisplayString(courier.successParcel), 1)
                                                ]),
                                                _: 2
                                              }, 1024)
                                            ]),
                                            _: 2
                                          }, 1024),
                                          createVNode(unref(_sfc_main$1), null, {
                                            default: withCtx(() => [
                                              createVNode(_sfc_main$f, { variant: "destructive" }, {
                                                default: withCtx(() => [
                                                  createTextVNode(toDisplayString(courier.cancelledParcel), 1)
                                                ]),
                                                _: 2
                                              }, 1024)
                                            ]),
                                            _: 2
                                          }, 1024),
                                          createVNode(unref(_sfc_main$1), { class: "text-right" }, {
                                            default: withCtx(() => [
                                              createVNode(_sfc_main$f, {
                                                class: [courier.successRatio >= 90 ? "bg-green-500 hover:bg-green-600" : courier.successRatio >= 70 ? "bg-yellow-500 hover:bg-yellow-600" : "bg-red-500 hover:bg-red-600", "text-white"]
                                              }, {
                                                default: withCtx(() => [
                                                  createTextVNode(toDisplayString(courier.successRatio.toFixed(1)) + "% ", 1)
                                                ]),
                                                _: 2
                                              }, 1032, ["class"])
                                            ]),
                                            _: 2
                                          }, 1024)
                                        ]),
                                        _: 2
                                      }, 1024);
                                    }), 128))
                                  ];
                                }
                              }),
                              _: 1
                            }, _parent4, _scopeId3));
                          } else {
                            return [
                              createVNode(unref(_sfc_main$5), null, {
                                default: withCtx(() => [
                                  createVNode(unref(_sfc_main$3), null, {
                                    default: withCtx(() => [
                                      createVNode(unref(_sfc_main$2), { class: "w-[180px]" }, {
                                        default: withCtx(() => [
                                          createTextVNode("Courier")
                                        ]),
                                        _: 1
                                      }),
                                      createVNode(unref(_sfc_main$2), null, {
                                        default: withCtx(() => [
                                          createTextVNode("Orders")
                                        ]),
                                        _: 1
                                      }),
                                      createVNode(unref(_sfc_main$2), null, {
                                        default: withCtx(() => [
                                          createTextVNode("Delivered")
                                        ]),
                                        _: 1
                                      }),
                                      createVNode(unref(_sfc_main$2), null, {
                                        default: withCtx(() => [
                                          createTextVNode("Cancelled")
                                        ]),
                                        _: 1
                                      }),
                                      createVNode(unref(_sfc_main$2), { class: "text-right" }, {
                                        default: withCtx(() => [
                                          createTextVNode("Success Rate")
                                        ]),
                                        _: 1
                                      })
                                    ]),
                                    _: 1
                                  })
                                ]),
                                _: 1
                              }),
                              createVNode(unref(_sfc_main$4), null, {
                                default: withCtx(() => [
                                  (openBlock(true), createBlock(Fragment, null, renderList(courierList.value, (courier) => {
                                    return openBlock(), createBlock(unref(_sfc_main$3), {
                                      key: courier.name
                                    }, {
                                      default: withCtx(() => [
                                        createVNode(unref(_sfc_main$1), { class: "font-medium" }, {
                                          default: withCtx(() => [
                                            createVNode("div", { class: "flex items-center gap-2" }, [
                                              courier.logo ? (openBlock(), createBlock("img", {
                                                key: 0,
                                                src: courier.logo,
                                                alt: courier.name,
                                                class: "w-6 h-6 object-contain rounded"
                                              }, null, 8, ["src", "alt"])) : createCommentVNode("", true),
                                              createVNode("span", null, toDisplayString(courier.name), 1)
                                            ])
                                          ]),
                                          _: 2
                                        }, 1024),
                                        createVNode(unref(_sfc_main$1), null, {
                                          default: withCtx(() => [
                                            createVNode(_sfc_main$f, { variant: "outline" }, {
                                              default: withCtx(() => [
                                                createTextVNode(toDisplayString(courier.totalParcel), 1)
                                              ]),
                                              _: 2
                                            }, 1024)
                                          ]),
                                          _: 2
                                        }, 1024),
                                        createVNode(unref(_sfc_main$1), null, {
                                          default: withCtx(() => [
                                            createVNode(_sfc_main$f, { variant: "success" }, {
                                              default: withCtx(() => [
                                                createTextVNode(toDisplayString(courier.successParcel), 1)
                                              ]),
                                              _: 2
                                            }, 1024)
                                          ]),
                                          _: 2
                                        }, 1024),
                                        createVNode(unref(_sfc_main$1), null, {
                                          default: withCtx(() => [
                                            createVNode(_sfc_main$f, { variant: "destructive" }, {
                                              default: withCtx(() => [
                                                createTextVNode(toDisplayString(courier.cancelledParcel), 1)
                                              ]),
                                              _: 2
                                            }, 1024)
                                          ]),
                                          _: 2
                                        }, 1024),
                                        createVNode(unref(_sfc_main$1), { class: "text-right" }, {
                                          default: withCtx(() => [
                                            createVNode(_sfc_main$f, {
                                              class: [courier.successRatio >= 90 ? "bg-green-500 hover:bg-green-600" : courier.successRatio >= 70 ? "bg-yellow-500 hover:bg-yellow-600" : "bg-red-500 hover:bg-red-600", "text-white"]
                                            }, {
                                              default: withCtx(() => [
                                                createTextVNode(toDisplayString(courier.successRatio.toFixed(1)) + "% ", 1)
                                              ]),
                                              _: 2
                                            }, 1032, ["class"])
                                          ]),
                                          _: 2
                                        }, 1024)
                                      ]),
                                      _: 2
                                    }, 1024);
                                  }), 128))
                                ]),
                                _: 1
                              })
                            ];
                          }
                        }),
                        _: 1
                      }, _parent3, _scopeId2));
                    } else {
                      return [
                        createVNode("h3", { class: "text-lg font-bold mb-4 flex items-center gap-2" }, [
                          createVNode(unref(BarChart3), { class: "w-5 h-5 text-primary" }),
                          createTextVNode(" কুরিয়ার ডিটেইলস ")
                        ]),
                        createVNode(unref(_sfc_main$6), null, {
                          default: withCtx(() => [
                            createVNode(unref(_sfc_main$5), null, {
                              default: withCtx(() => [
                                createVNode(unref(_sfc_main$3), null, {
                                  default: withCtx(() => [
                                    createVNode(unref(_sfc_main$2), { class: "w-[180px]" }, {
                                      default: withCtx(() => [
                                        createTextVNode("Courier")
                                      ]),
                                      _: 1
                                    }),
                                    createVNode(unref(_sfc_main$2), null, {
                                      default: withCtx(() => [
                                        createTextVNode("Orders")
                                      ]),
                                      _: 1
                                    }),
                                    createVNode(unref(_sfc_main$2), null, {
                                      default: withCtx(() => [
                                        createTextVNode("Delivered")
                                      ]),
                                      _: 1
                                    }),
                                    createVNode(unref(_sfc_main$2), null, {
                                      default: withCtx(() => [
                                        createTextVNode("Cancelled")
                                      ]),
                                      _: 1
                                    }),
                                    createVNode(unref(_sfc_main$2), { class: "text-right" }, {
                                      default: withCtx(() => [
                                        createTextVNode("Success Rate")
                                      ]),
                                      _: 1
                                    })
                                  ]),
                                  _: 1
                                })
                              ]),
                              _: 1
                            }),
                            createVNode(unref(_sfc_main$4), null, {
                              default: withCtx(() => [
                                (openBlock(true), createBlock(Fragment, null, renderList(courierList.value, (courier) => {
                                  return openBlock(), createBlock(unref(_sfc_main$3), {
                                    key: courier.name
                                  }, {
                                    default: withCtx(() => [
                                      createVNode(unref(_sfc_main$1), { class: "font-medium" }, {
                                        default: withCtx(() => [
                                          createVNode("div", { class: "flex items-center gap-2" }, [
                                            courier.logo ? (openBlock(), createBlock("img", {
                                              key: 0,
                                              src: courier.logo,
                                              alt: courier.name,
                                              class: "w-6 h-6 object-contain rounded"
                                            }, null, 8, ["src", "alt"])) : createCommentVNode("", true),
                                            createVNode("span", null, toDisplayString(courier.name), 1)
                                          ])
                                        ]),
                                        _: 2
                                      }, 1024),
                                      createVNode(unref(_sfc_main$1), null, {
                                        default: withCtx(() => [
                                          createVNode(_sfc_main$f, { variant: "outline" }, {
                                            default: withCtx(() => [
                                              createTextVNode(toDisplayString(courier.totalParcel), 1)
                                            ]),
                                            _: 2
                                          }, 1024)
                                        ]),
                                        _: 2
                                      }, 1024),
                                      createVNode(unref(_sfc_main$1), null, {
                                        default: withCtx(() => [
                                          createVNode(_sfc_main$f, { variant: "success" }, {
                                            default: withCtx(() => [
                                              createTextVNode(toDisplayString(courier.successParcel), 1)
                                            ]),
                                            _: 2
                                          }, 1024)
                                        ]),
                                        _: 2
                                      }, 1024),
                                      createVNode(unref(_sfc_main$1), null, {
                                        default: withCtx(() => [
                                          createVNode(_sfc_main$f, { variant: "destructive" }, {
                                            default: withCtx(() => [
                                              createTextVNode(toDisplayString(courier.cancelledParcel), 1)
                                            ]),
                                            _: 2
                                          }, 1024)
                                        ]),
                                        _: 2
                                      }, 1024),
                                      createVNode(unref(_sfc_main$1), { class: "text-right" }, {
                                        default: withCtx(() => [
                                          createVNode(_sfc_main$f, {
                                            class: [courier.successRatio >= 90 ? "bg-green-500 hover:bg-green-600" : courier.successRatio >= 70 ? "bg-yellow-500 hover:bg-yellow-600" : "bg-red-500 hover:bg-red-600", "text-white"]
                                          }, {
                                            default: withCtx(() => [
                                              createTextVNode(toDisplayString(courier.successRatio.toFixed(1)) + "% ", 1)
                                            ]),
                                            _: 2
                                          }, 1032, ["class"])
                                        ]),
                                        _: 2
                                      }, 1024)
                                    ]),
                                    _: 2
                                  }, 1024);
                                }), 128))
                              ]),
                              _: 1
                            })
                          ]),
                          _: 1
                        })
                      ];
                    }
                  }),
                  _: 1
                }, _parent2, _scopeId));
                _push2(ssrRenderComponent(_sfc_main$a, { class: "p-6" }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(`<div class="flex justify-between items-center mb-6"${_scopeId2}><h2 class="text-xl font-bold flex items-center gap-2"${_scopeId2}>`);
                      _push3(ssrRenderComponent(unref(MessageSquare), { class: "w-5 h-5 text-indigo-600" }, null, _parent3, _scopeId2));
                      _push3(` গ্রাহক রিভিউ </h2>`);
                      _push3(ssrRenderComponent(_sfc_main$b, {
                        variant: "secondary",
                        onClick: ($event) => showRatingModal.value = true
                      }, {
                        default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                          if (_push4) {
                            _push4(ssrRenderComponent(unref(Plus), { class: "w-4 h-4 mr-1" }, null, _parent4, _scopeId3));
                            _push4(` নতুন রিভিউ `);
                          } else {
                            return [
                              createVNode(unref(Plus), { class: "w-4 h-4 mr-1" }),
                              createTextVNode(" নতুন রিভিউ ")
                            ];
                          }
                        }),
                        _: 1
                      }, _parent3, _scopeId2));
                      _push3(`</div>`);
                      if (reviews.value.length === 0) {
                        _push3(`<div class="text-center py-10 text-gray-500 dark:text-gray-400"${_scopeId2}>`);
                        _push3(ssrRenderComponent(unref(MessageSquare), { class: "w-12 h-12 mx-auto mb-4 opacity-50" }, null, _parent3, _scopeId2));
                        _push3(`<p${_scopeId2}>এই নাম্বারের জন্য কোন রিভিউ নেই</p><p class="text-sm mt-2"${_scopeId2}>প্রথম রিভিউ দিয়ে অন্যদের সাহায্য করুন</p></div>`);
                      } else {
                        _push3(`<div class="space-y-4"${_scopeId2}><!--[-->`);
                        ssrRenderList(reviews.value, (review) => {
                          _push3(`<div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg"${_scopeId2}><div class="flex justify-between items-start mb-2"${_scopeId2}><div${_scopeId2}><h4 class="font-semibold"${_scopeId2}>${ssrInterpolate(review.name)} (${ssrInterpolate(unref(maskPhoneNumber)(review.commenter_phone))})</h4>`);
                          _push3(ssrRenderComponent(_sfc_main$7, {
                            "model-value": review.rating,
                            readonly: "",
                            size: "sm",
                            class: "my-1"
                          }, null, _parent3, _scopeId2));
                          _push3(`</div><div class="text-xs text-gray-500 dark:text-gray-400"${_scopeId2}>${ssrInterpolate(unref(formatBengaliDate)(review.created_at))}</div></div><p class="text-gray-700 dark:text-gray-300"${_scopeId2}>${ssrInterpolate(review.comment)}</p></div>`);
                        });
                        _push3(`<!--]--></div>`);
                      }
                    } else {
                      return [
                        createVNode("div", { class: "flex justify-between items-center mb-6" }, [
                          createVNode("h2", { class: "text-xl font-bold flex items-center gap-2" }, [
                            createVNode(unref(MessageSquare), { class: "w-5 h-5 text-indigo-600" }),
                            createTextVNode(" গ্রাহক রিভিউ ")
                          ]),
                          createVNode(_sfc_main$b, {
                            variant: "secondary",
                            onClick: ($event) => showRatingModal.value = true
                          }, {
                            default: withCtx(() => [
                              createVNode(unref(Plus), { class: "w-4 h-4 mr-1" }),
                              createTextVNode(" নতুন রিভিউ ")
                            ]),
                            _: 1
                          }, 8, ["onClick"])
                        ]),
                        reviews.value.length === 0 ? (openBlock(), createBlock("div", {
                          key: 0,
                          class: "text-center py-10 text-gray-500 dark:text-gray-400"
                        }, [
                          createVNode(unref(MessageSquare), { class: "w-12 h-12 mx-auto mb-4 opacity-50" }),
                          createVNode("p", null, "এই নাম্বারের জন্য কোন রিভিউ নেই"),
                          createVNode("p", { class: "text-sm mt-2" }, "প্রথম রিভিউ দিয়ে অন্যদের সাহায্য করুন")
                        ])) : (openBlock(), createBlock("div", {
                          key: 1,
                          class: "space-y-4"
                        }, [
                          (openBlock(true), createBlock(Fragment, null, renderList(reviews.value, (review) => {
                            return openBlock(), createBlock("div", {
                              key: review.id,
                              class: "bg-gray-50 dark:bg-gray-700 p-4 rounded-lg"
                            }, [
                              createVNode("div", { class: "flex justify-between items-start mb-2" }, [
                                createVNode("div", null, [
                                  createVNode("h4", { class: "font-semibold" }, toDisplayString(review.name) + " (" + toDisplayString(unref(maskPhoneNumber)(review.commenter_phone)) + ")", 1),
                                  createVNode(_sfc_main$7, {
                                    "model-value": review.rating,
                                    readonly: "",
                                    size: "sm",
                                    class: "my-1"
                                  }, null, 8, ["model-value"])
                                ]),
                                createVNode("div", { class: "text-xs text-gray-500 dark:text-gray-400" }, toDisplayString(unref(formatBengaliDate)(review.created_at)), 1)
                              ]),
                              createVNode("p", { class: "text-gray-700 dark:text-gray-300" }, toDisplayString(review.comment), 1)
                            ]);
                          }), 128))
                        ]))
                      ];
                    }
                  }),
                  _: 1
                }, _parent2, _scopeId));
                _push2(`<!--]-->`);
              } else {
                _push2(ssrRenderComponent(_sfc_main$a, { class: "h-full p-6 text-center bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 flex flex-col items-center justify-center" }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(`<img src="https://img.freepik.com/free-vector/work-office-computer-man-woman-business-character-marketing-online-employee-technology-business-man-cartoon-co-working-flat-design-freelance_1150-41790.jpg?w=1060" alt="Search illustration" class="mx-auto mb-4 rounded-lg shadow-md w-48 sm:w-56 md:w-64"${_scopeId2}><h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-100"${_scopeId2}>কুরিয়ার ফ্রড চেক করুন</h3><p class="text-gray-600 dark:text-gray-400 mb-4 max-w-sm mx-auto text-sm"${_scopeId2}> মোবাইল নাম্বার দিয়ে সার্চ করুন এবং গ্রাহকের ডেলিভারি ইতিহাস দেখুন। </p><div class="flex flex-wrap justify-center gap-2"${_scopeId2}><div class="flex items-center gap-1.5 bg-green-50 dark:bg-green-900/30 px-3 py-1.5 rounded-full"${_scopeId2}><div class="w-2.5 h-2.5 rounded-full bg-green-500"${_scopeId2}></div><span class="text-xs text-green-700 dark:text-green-300 font-medium"${_scopeId2}>Low Risk</span></div><div class="flex items-center gap-1.5 bg-yellow-50 dark:bg-yellow-900/30 px-3 py-1.5 rounded-full"${_scopeId2}><div class="w-2.5 h-2.5 rounded-full bg-yellow-500"${_scopeId2}></div><span class="text-xs text-yellow-700 dark:text-yellow-300 font-medium"${_scopeId2}>Medium Risk</span></div><div class="flex items-center gap-1.5 bg-red-50 dark:bg-red-900/30 px-3 py-1.5 rounded-full"${_scopeId2}><div class="w-2.5 h-2.5 rounded-full bg-red-500"${_scopeId2}></div><span class="text-xs text-red-700 dark:text-red-300 font-medium"${_scopeId2}>High Risk</span></div></div>`);
                    } else {
                      return [
                        createVNode("img", {
                          src: "https://img.freepik.com/free-vector/work-office-computer-man-woman-business-character-marketing-online-employee-technology-business-man-cartoon-co-working-flat-design-freelance_1150-41790.jpg?w=1060",
                          alt: "Search illustration",
                          class: "mx-auto mb-4 rounded-lg shadow-md w-48 sm:w-56 md:w-64"
                        }),
                        createVNode("h3", { class: "text-lg font-bold mb-2 text-gray-800 dark:text-gray-100" }, "কুরিয়ার ফ্রড চেক করুন"),
                        createVNode("p", { class: "text-gray-600 dark:text-gray-400 mb-4 max-w-sm mx-auto text-sm" }, " মোবাইল নাম্বার দিয়ে সার্চ করুন এবং গ্রাহকের ডেলিভারি ইতিহাস দেখুন। "),
                        createVNode("div", { class: "flex flex-wrap justify-center gap-2" }, [
                          createVNode("div", { class: "flex items-center gap-1.5 bg-green-50 dark:bg-green-900/30 px-3 py-1.5 rounded-full" }, [
                            createVNode("div", { class: "w-2.5 h-2.5 rounded-full bg-green-500" }),
                            createVNode("span", { class: "text-xs text-green-700 dark:text-green-300 font-medium" }, "Low Risk")
                          ]),
                          createVNode("div", { class: "flex items-center gap-1.5 bg-yellow-50 dark:bg-yellow-900/30 px-3 py-1.5 rounded-full" }, [
                            createVNode("div", { class: "w-2.5 h-2.5 rounded-full bg-yellow-500" }),
                            createVNode("span", { class: "text-xs text-yellow-700 dark:text-yellow-300 font-medium" }, "Medium Risk")
                          ]),
                          createVNode("div", { class: "flex items-center gap-1.5 bg-red-50 dark:bg-red-900/30 px-3 py-1.5 rounded-full" }, [
                            createVNode("div", { class: "w-2.5 h-2.5 rounded-full bg-red-500" }),
                            createVNode("span", { class: "text-xs text-red-700 dark:text-red-300 font-medium" }, "High Risk")
                          ])
                        ])
                      ];
                    }
                  }),
                  _: 1
                }, _parent2, _scopeId));
              }
              _push2(`</div></div>`);
            }
            _push2(`</section><section class="container mx-auto px-4 py-12"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$a, { class: "p-6" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<h2 class="text-2xl font-bold mb-8 text-center"${_scopeId2}>কেন কুরিয়ার ফ্রড চেক করা প্রয়োজন?</h2><div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8"${_scopeId2}><div class="p-5 border border-gray-200 dark:border-gray-600 rounded-xl text-center bg-gray-50 dark:bg-gray-700 hover:shadow-lg transition-shadow"${_scopeId2}><div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4"${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(Shield), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400" }, null, _parent3, _scopeId2));
                  _push3(`</div><h3 class="text-lg font-semibold mb-2"${_scopeId2}>ব্যবসা সুরক্ষা</h3><p class="text-gray-600 dark:text-gray-300"${_scopeId2}>আপনার ব্যবসাকে সম্ভাব্য কুরিয়ার ফ্রড থেকে রক্ষা করুন। প্রতি মাসে হাজার হাজার টাকা সাশ্রয় করুন।</p></div><div class="p-5 border border-gray-200 dark:border-gray-600 rounded-xl text-center bg-gray-50 dark:bg-gray-700 hover:shadow-lg transition-shadow"${_scopeId2}><div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4"${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(TrendingUp), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400" }, null, _parent3, _scopeId2));
                  _push3(`</div><h3 class="text-lg font-semibold mb-2"${_scopeId2}>ডেলিভারি সাফল্য বাড়ান</h3><p class="text-gray-600 dark:text-gray-300"${_scopeId2}>বিশ্বস্ত গ্রাহকদের চিহ্নিত করে আপনার ডেলিভারি সাফল্যের হার বাড়ান এবং ব্যবসার লাভ বৃদ্ধি করুন।</p></div><div class="p-5 border border-gray-200 dark:border-gray-600 rounded-xl text-center bg-gray-50 dark:bg-gray-700 hover:shadow-lg transition-shadow"${_scopeId2}><div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4"${_scopeId2}>`);
                  _push3(ssrRenderComponent(unref(History), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400" }, null, _parent3, _scopeId2));
                  _push3(`</div><h3 class="text-lg font-semibold mb-2"${_scopeId2}>রিয়েল-টাইম ডাটা</h3><p class="text-gray-600 dark:text-gray-300"${_scopeId2}>সর্বাধিক আপডেটেড ডাটা দিয়ে গ্রাহকের আচরণ বিশ্লেষণ করুন এবং সঠিক সিদ্ধান্ত নিন।</p></div></div><div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl"${_scopeId2}><h3 class="text-xl font-semibold mb-4"${_scopeId2}>বাংলাদেশে কুরিয়ার ফ্রড সম্পর্কে জানুন</h3><p class="mb-4 text-gray-700 dark:text-gray-300"${_scopeId2}> বাংলাদেশে প্রতি বছর হাজার হাজার ব্যবসায়ী কুরিয়ার ফ্রডের শিকার হন। কুরিয়ার ফ্রড হল যখন একজন গ্রাহক ইচ্ছাকৃতভাবে পণ্য গ্রহণ করে না বা ডেলিভারি বাতিল করে। </p><p class="mb-4 text-gray-700 dark:text-gray-300"${_scopeId2}> FraudShield আপনাকে একটি গ্রাহকের পূর্ববর্তী ডেলিভারি ইতিহাস দেখার সুযোগ দেয়, যাতে আপনি সিদ্ধান্ত নিতে পারেন যে তাদের কাছে পণ্য পাঠানো নিরাপদ কিনা। </p><p class="text-gray-700 dark:text-gray-300"${_scopeId2}> আমাদের সিস্টেম বাংলাদেশের সকল প্রধান কুরিয়ার সার্ভিসের ডাটা ব্যবহার করে এবং একটি বিশ্বস্ত ফ্রড স্কোর প্রদান করে। </p></div>`);
                } else {
                  return [
                    createVNode("h2", { class: "text-2xl font-bold mb-8 text-center" }, "কেন কুরিয়ার ফ্রড চেক করা প্রয়োজন?"),
                    createVNode("div", { class: "grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" }, [
                      createVNode("div", { class: "p-5 border border-gray-200 dark:border-gray-600 rounded-xl text-center bg-gray-50 dark:bg-gray-700 hover:shadow-lg transition-shadow" }, [
                        createVNode("div", { class: "w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4" }, [
                          createVNode(unref(Shield), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400" })
                        ]),
                        createVNode("h3", { class: "text-lg font-semibold mb-2" }, "ব্যবসা সুরক্ষা"),
                        createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "আপনার ব্যবসাকে সম্ভাব্য কুরিয়ার ফ্রড থেকে রক্ষা করুন। প্রতি মাসে হাজার হাজার টাকা সাশ্রয় করুন।")
                      ]),
                      createVNode("div", { class: "p-5 border border-gray-200 dark:border-gray-600 rounded-xl text-center bg-gray-50 dark:bg-gray-700 hover:shadow-lg transition-shadow" }, [
                        createVNode("div", { class: "w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4" }, [
                          createVNode(unref(TrendingUp), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400" })
                        ]),
                        createVNode("h3", { class: "text-lg font-semibold mb-2" }, "ডেলিভারি সাফল্য বাড়ান"),
                        createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "বিশ্বস্ত গ্রাহকদের চিহ্নিত করে আপনার ডেলিভারি সাফল্যের হার বাড়ান এবং ব্যবসার লাভ বৃদ্ধি করুন।")
                      ]),
                      createVNode("div", { class: "p-5 border border-gray-200 dark:border-gray-600 rounded-xl text-center bg-gray-50 dark:bg-gray-700 hover:shadow-lg transition-shadow" }, [
                        createVNode("div", { class: "w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4" }, [
                          createVNode(unref(History), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400" })
                        ]),
                        createVNode("h3", { class: "text-lg font-semibold mb-2" }, "রিয়েল-টাইম ডাটা"),
                        createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "সর্বাধিক আপডেটেড ডাটা দিয়ে গ্রাহকের আচরণ বিশ্লেষণ করুন এবং সঠিক সিদ্ধান্ত নিন।")
                      ])
                    ]),
                    createVNode("div", { class: "bg-gray-50 dark:bg-gray-700 p-6 rounded-xl" }, [
                      createVNode("h3", { class: "text-xl font-semibold mb-4" }, "বাংলাদেশে কুরিয়ার ফ্রড সম্পর্কে জানুন"),
                      createVNode("p", { class: "mb-4 text-gray-700 dark:text-gray-300" }, " বাংলাদেশে প্রতি বছর হাজার হাজার ব্যবসায়ী কুরিয়ার ফ্রডের শিকার হন। কুরিয়ার ফ্রড হল যখন একজন গ্রাহক ইচ্ছাকৃতভাবে পণ্য গ্রহণ করে না বা ডেলিভারি বাতিল করে। "),
                      createVNode("p", { class: "mb-4 text-gray-700 dark:text-gray-300" }, " FraudShield আপনাকে একটি গ্রাহকের পূর্ববর্তী ডেলিভারি ইতিহাস দেখার সুযোগ দেয়, যাতে আপনি সিদ্ধান্ত নিতে পারেন যে তাদের কাছে পণ্য পাঠানো নিরাপদ কিনা। "),
                      createVNode("p", { class: "text-gray-700 dark:text-gray-300" }, " আমাদের সিস্টেম বাংলাদেশের সকল প্রধান কুরিয়ার সার্ভিসের ডাটা ব্যবহার করে এবং একটি বিশ্বস্ত ফ্রড স্কোর প্রদান করে। ")
                    ])
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</section><section class="container mx-auto px-4 py-12"${_scopeId}><div class="text-center mb-8"${_scopeId}><h2 class="text-2xl font-bold mb-2"${_scopeId}>সাধারণ জিজ্ঞাসা (FAQ)</h2><p class="text-gray-600 dark:text-gray-400"${_scopeId}>আপনার FraudShield সম্পর্কিত সব প্রশ্নের উত্তর এখানে পাবেন</p></div><div class="max-w-3xl mx-auto space-y-4"${_scopeId}><!--[-->`);
            ssrRenderList(faqs, (faq, index) => {
              _push2(ssrRenderComponent(_sfc_main$a, {
                key: index,
                class: "overflow-hidden border-l-4 border-indigo-500 hover:shadow-lg transition-shadow"
              }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`<button class="w-full p-5 flex justify-between items-center text-left font-semibold text-gray-800 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"${_scopeId2}><span${_scopeId2}>${ssrInterpolate(faq.question)}</span><div class="p-1 bg-indigo-100 dark:bg-indigo-900 rounded-full text-indigo-600 dark:text-indigo-400"${_scopeId2}>`);
                    if (activeFaq.value === index) {
                      _push3(ssrRenderComponent(unref(ChevronUp), { class: "w-5 h-5" }, null, _parent3, _scopeId2));
                    } else {
                      _push3(ssrRenderComponent(unref(ChevronDown), { class: "w-5 h-5" }, null, _parent3, _scopeId2));
                    }
                    _push3(`</div></button>`);
                    if (activeFaq.value === index) {
                      _push3(`<div class="px-5 pb-5 text-gray-600 dark:text-gray-300 overflow-hidden"${_scopeId2}>${ssrInterpolate(faq.answer)}</div>`);
                    } else {
                      _push3(`<!---->`);
                    }
                  } else {
                    return [
                      createVNode("button", {
                        onClick: ($event) => toggleFaq(index),
                        class: "w-full p-5 flex justify-between items-center text-left font-semibold text-gray-800 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"
                      }, [
                        createVNode("span", null, toDisplayString(faq.question), 1),
                        createVNode("div", { class: "p-1 bg-indigo-100 dark:bg-indigo-900 rounded-full text-indigo-600 dark:text-indigo-400" }, [
                          activeFaq.value === index ? (openBlock(), createBlock(unref(ChevronUp), {
                            key: 0,
                            class: "w-5 h-5"
                          })) : (openBlock(), createBlock(unref(ChevronDown), {
                            key: 1,
                            class: "w-5 h-5"
                          }))
                        ])
                      ], 8, ["onClick"]),
                      createVNode(Transition, {
                        "enter-active-class": "transition-all duration-200 ease-out",
                        "enter-from-class": "opacity-0 max-h-0",
                        "enter-to-class": "opacity-100 max-h-96",
                        "leave-active-class": "transition-all duration-150 ease-in",
                        "leave-from-class": "opacity-100 max-h-96",
                        "leave-to-class": "opacity-0 max-h-0"
                      }, {
                        default: withCtx(() => [
                          activeFaq.value === index ? (openBlock(), createBlock("div", {
                            key: 0,
                            class: "px-5 pb-5 text-gray-600 dark:text-gray-300 overflow-hidden"
                          }, toDisplayString(faq.answer), 1)) : createCommentVNode("", true)
                        ]),
                        _: 2
                      }, 1024)
                    ];
                  }
                }),
                _: 2
              }, _parent2, _scopeId));
            });
            _push2(`<!--]--></div></section><div class="fixed bottom-8 right-8 z-40"${_scopeId}><a href="/download" class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-full font-semibold hover:shadow-2xl hover:scale-105 transition-all duration-300 shadow-xl animate-pulse"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(Download), { class: "w-5 h-5" }, null, _parent2, _scopeId));
            _push2(`<span${_scopeId}>অ্যাপ ডাউনলোড করুন</span></a></div>`);
            _push2(ssrRenderComponent(_sfc_main$8, {
              open: showRatingModal.value,
              "onUpdate:open": ($event) => showRatingModal.value = $event
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<h3 class="text-xl font-bold mb-4"${_scopeId2}>Rate This Customer</h3><p class="text-gray-600 dark:text-gray-300 mb-4"${_scopeId2}> Share your experience with <span class="font-medium"${_scopeId2}>${ssrInterpolate(phoneInput.value)}</span></p><form class="space-y-4"${_scopeId2}><div${_scopeId2}><label class="block text-sm font-medium mb-2"${_scopeId2}>আপনার নম্বর</label><input${ssrRenderAttr("value", reviewForm.value.ownNumber)} type="text" placeholder="আপনার নম্বর লিখুন" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" required${_scopeId2}></div><div${_scopeId2}><label class="block text-sm font-medium mb-2"${_scopeId2}>আপনার নাম</label><input${ssrRenderAttr("value", reviewForm.value.name)} type="text" placeholder="আপনার নাম লিখুন" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" required${_scopeId2}></div><div${_scopeId2}><label class="block text-sm font-medium mb-2"${_scopeId2}>রেটিং দিন</label>`);
                  _push3(ssrRenderComponent(_sfc_main$7, {
                    modelValue: reviewForm.value.rating,
                    "onUpdate:modelValue": ($event) => reviewForm.value.rating = $event,
                    size: "lg"
                  }, null, _parent3, _scopeId2));
                  _push3(`</div><div${_scopeId2}><label class="block text-sm font-medium mb-2"${_scopeId2}>আপনার মন্তব্য</label><textarea placeholder="আপনার অভিজ্ঞতা শেয়ার করুন" rows="3" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" required${_scopeId2}>${ssrInterpolate(reviewForm.value.comment)}</textarea></div><div class="flex justify-end"${_scopeId2}>`);
                  _push3(ssrRenderComponent(_sfc_main$b, {
                    type: "submit",
                    loading: isSubmittingReview.value
                  }, {
                    default: withCtx((_3, _push4, _parent4, _scopeId3) => {
                      if (_push4) {
                        _push4(ssrRenderComponent(unref(Send), { class: "w-4 h-4 mr-2" }, null, _parent4, _scopeId3));
                        _push4(` জমা দিন `);
                      } else {
                        return [
                          createVNode(unref(Send), { class: "w-4 h-4 mr-2" }),
                          createTextVNode(" জমা দিন ")
                        ];
                      }
                    }),
                    _: 1
                  }, _parent3, _scopeId2));
                  _push3(`</div></form>`);
                } else {
                  return [
                    createVNode("h3", { class: "text-xl font-bold mb-4" }, "Rate This Customer"),
                    createVNode("p", { class: "text-gray-600 dark:text-gray-300 mb-4" }, [
                      createTextVNode(" Share your experience with "),
                      createVNode("span", { class: "font-medium" }, toDisplayString(phoneInput.value), 1)
                    ]),
                    createVNode("form", {
                      onSubmit: withModifiers(submitReview, ["prevent"]),
                      class: "space-y-4"
                    }, [
                      createVNode("div", null, [
                        createVNode("label", { class: "block text-sm font-medium mb-2" }, "আপনার নম্বর"),
                        withDirectives(createVNode("input", {
                          "onUpdate:modelValue": ($event) => reviewForm.value.ownNumber = $event,
                          type: "text",
                          placeholder: "আপনার নম্বর লিখুন",
                          class: "w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white",
                          required: ""
                        }, null, 8, ["onUpdate:modelValue"]), [
                          [vModelText, reviewForm.value.ownNumber]
                        ])
                      ]),
                      createVNode("div", null, [
                        createVNode("label", { class: "block text-sm font-medium mb-2" }, "আপনার নাম"),
                        withDirectives(createVNode("input", {
                          "onUpdate:modelValue": ($event) => reviewForm.value.name = $event,
                          type: "text",
                          placeholder: "আপনার নাম লিখুন",
                          class: "w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white",
                          required: ""
                        }, null, 8, ["onUpdate:modelValue"]), [
                          [vModelText, reviewForm.value.name]
                        ])
                      ]),
                      createVNode("div", null, [
                        createVNode("label", { class: "block text-sm font-medium mb-2" }, "রেটিং দিন"),
                        createVNode(_sfc_main$7, {
                          modelValue: reviewForm.value.rating,
                          "onUpdate:modelValue": ($event) => reviewForm.value.rating = $event,
                          size: "lg"
                        }, null, 8, ["modelValue", "onUpdate:modelValue"])
                      ]),
                      createVNode("div", null, [
                        createVNode("label", { class: "block text-sm font-medium mb-2" }, "আপনার মন্তব্য"),
                        withDirectives(createVNode("textarea", {
                          "onUpdate:modelValue": ($event) => reviewForm.value.comment = $event,
                          placeholder: "আপনার অভিজ্ঞতা শেয়ার করুন",
                          rows: "3",
                          class: "w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white",
                          required: ""
                        }, null, 8, ["onUpdate:modelValue"]), [
                          [vModelText, reviewForm.value.comment]
                        ])
                      ]),
                      createVNode("div", { class: "flex justify-end" }, [
                        createVNode(_sfc_main$b, {
                          type: "submit",
                          loading: isSubmittingReview.value
                        }, {
                          default: withCtx(() => [
                            createVNode(unref(Send), { class: "w-4 h-4 mr-2" }),
                            createTextVNode(" জমা দিন ")
                          ]),
                          _: 1
                        }, 8, ["loading"])
                      ])
                    ], 32)
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
          } else {
            return [
              createVNode("section", { class: "py-12 px-4 overflow-visible" }, [
                createVNode("div", { class: "container mx-auto overflow-visible" }, [
                  createVNode("div", { class: "text-center mb-8" }, [
                    createVNode("h2", { class: "text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2 flex items-center justify-center gap-2" }, [
                      createVNode(unref(BarChart3), { class: "w-6 h-6 text-indigo-600 dark:text-indigo-400" }),
                      createTextVNode(" সার্চ পরিসংখ্যান ")
                    ]),
                    createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "রিয়েল-টাইম সার্চ ডেটা এবং ব্যবহারকারীর কার্যক্রম")
                  ]),
                  createVNode("div", { class: "grid grid-cols-2 lg:grid-cols-4 gap-4" }, [
                    createVNode(_sfc_main$a, { class: "p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/50 dark:to-blue-800/50 border-blue-200 dark:border-blue-700 hover:scale-[1.02] transition-transform text-center" }, {
                      default: withCtx(() => [
                        createVNode("div", { class: "inline-flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-xl shadow-lg mb-3" }, [
                          createVNode(unref(Clock), { class: "w-5 h-5" })
                        ]),
                        createVNode("div", { class: "text-2xl font-bold text-blue-600 dark:text-blue-300 mb-1" }, toDisplayString(unref(formatBengaliNumber)(stats.value.lastHour)), 1),
                        createVNode("div", { class: "text-sm text-blue-500 dark:text-blue-300 font-semibold mb-1" }, "শেষ ১ ঘন্টায়"),
                        createVNode("p", { class: "text-xs text-gray-500 dark:text-gray-400" }, "সর্বশেষ ৬০ মিনিটের সার্চ")
                      ]),
                      _: 1
                    }),
                    createVNode(_sfc_main$a, { class: "p-4 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/50 dark:to-green-800/50 border-green-200 dark:border-green-700 hover:scale-[1.02] transition-transform text-center" }, {
                      default: withCtx(() => [
                        createVNode("div", { class: "inline-flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-xl shadow-lg mb-3" }, [
                          createVNode(unref(Calendar), { class: "w-5 h-5" })
                        ]),
                        createVNode("div", { class: "text-2xl font-bold text-green-600 dark:text-green-300 mb-1" }, toDisplayString(unref(formatBengaliNumber)(stats.value.today)), 1),
                        createVNode("div", { class: "text-sm text-green-500 dark:text-green-300 font-semibold mb-1" }, "আজকের সার্চ"),
                        createVNode("p", { class: "text-xs text-gray-500 dark:text-gray-400" }, "আজ রাত ১২টা থেকে এখন পর্যন্ত")
                      ]),
                      _: 1
                    }),
                    createVNode(_sfc_main$a, { class: "p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/50 dark:to-purple-800/50 border-purple-200 dark:border-purple-700 hover:scale-[1.02] transition-transform text-center" }, {
                      default: withCtx(() => [
                        createVNode("div", { class: "inline-flex items-center justify-center w-10 h-10 bg-purple-500 text-white rounded-xl shadow-lg mb-3" }, [
                          createVNode(unref(Infinity), { class: "w-5 h-5" })
                        ]),
                        createVNode("div", { class: "text-2xl font-bold text-purple-600 dark:text-purple-300 mb-1" }, toDisplayString(unref(formatBengaliNumber)(stats.value.allTime)), 1),
                        createVNode("div", { class: "text-sm text-purple-500 dark:text-purple-300 font-semibold mb-1" }, "সর্বমোট সার্চ"),
                        createVNode("p", { class: "text-xs text-gray-500 dark:text-gray-400" }, "সর্বকালের মোট সার্চ সংখ্যা")
                      ]),
                      _: 1
                    }),
                    createVNode(_sfc_main$a, { class: "p-4 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/50 dark:to-orange-800/50 border-orange-200 dark:border-orange-700 hover:scale-[1.02] transition-transform text-center" }, {
                      default: withCtx(() => [
                        createVNode("div", { class: "inline-flex items-center justify-center w-10 h-10 bg-orange-500 text-white rounded-xl shadow-lg mb-3" }, [
                          createVNode(unref(PhoneCall), { class: "w-5 h-5" })
                        ]),
                        createVNode("div", { class: "text-2xl font-bold text-orange-600 dark:text-orange-300 mb-1" }, toDisplayString(unref(formatBengaliNumber)(stats.value.uniqueNumbers)), 1),
                        createVNode("div", { class: "text-sm text-orange-500 dark:text-orange-300 font-semibold mb-1" }, "ইউনিক নাম্বার"),
                        createVNode("p", { class: "text-xs text-gray-500 dark:text-gray-400" }, "চেক করা মোট নাম্বার সংখ্যা")
                      ]),
                      _: 1
                    })
                  ]),
                  createVNode("div", { class: "text-center mt-6" }, [
                    createVNode("p", { class: "text-sm text-gray-500 dark:text-gray-400" }, [
                      createVNode(unref(RefreshCw), { class: "w-4 h-4 inline-block align-middle mr-1" }),
                      createVNode("span", { class: "align-middle" }, [
                        createTextVNode("সর্বশেষ আপডেট: "),
                        createVNode("span", { class: "font-medium text-gray-700 dark:text-gray-300" }, toDisplayString(lastUpdated.value), 1)
                      ])
                    ])
                  ])
                ])
              ]),
              createVNode("section", { class: "container mx-auto px-4 py-4" }, [
                createVNode(_sfc_main$a, { class: "p-4 mb-4 bg-gradient-to-r from-indigo-500/5 to-purple-500/5 dark:from-indigo-500/10 dark:to-purple-500/10 border-indigo-200 dark:border-indigo-800" }, {
                  default: withCtx(() => [
                    createVNode("div", { class: "text-center mb-3" }, [
                      createVNode("h1", { class: "text-lg md:text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-1" }, " কুরিয়ার ফ্রড চেক করুন "),
                      createVNode("p", { class: "text-sm text-gray-600 dark:text-gray-400" }, "মোবাইল নাম্বার দিয়ে গ্রাহকের ডেলিভারি ইতিহাস যাচাই করুন")
                    ]),
                    createVNode("div", { class: "flex flex-col md:flex-row gap-3 max-w-xl mx-auto" }, [
                      createVNode("div", { class: "relative flex-1" }, [
                        createVNode("div", { class: "absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none" }, [
                          createVNode(unref(Phone), { class: "h-4 w-4 text-indigo-500" })
                        ]),
                        withDirectives(createVNode("input", {
                          "onUpdate:modelValue": ($event) => phoneInput.value = $event,
                          type: "text",
                          placeholder: "মোবাইল নাম্বার লিখুন (যেমন: 01600000000)",
                          class: "w-full pl-10 p-3 border border-indigo-200 dark:border-indigo-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition duration-300 text-sm",
                          onKeypress: withKeys(performSearch, ["enter"])
                        }, null, 40, ["onUpdate:modelValue"]), [
                          [vModelText, phoneInput.value]
                        ])
                      ]),
                      createVNode(_sfc_main$b, {
                        size: "default",
                        loading: isSearching.value,
                        onClick: performSearch,
                        class: "min-w-[140px] shadow-md"
                      }, {
                        default: withCtx(() => [
                          createVNode(unref(Search), { class: "w-4 h-4 mr-1" }),
                          createTextVNode(" রিপোর্ট দেখুন ")
                        ]),
                        _: 1
                      }, 8, ["loading"])
                    ])
                  ]),
                  _: 1
                }),
                isSearching.value ? (openBlock(), createBlock("div", {
                  key: 0,
                  class: "text-center py-16"
                }, [
                  createVNode("div", { class: "relative w-20 h-20 mx-auto mb-6" }, [
                    createVNode("div", { class: "absolute inset-0 rounded-full border-4 border-indigo-200 dark:border-indigo-800" }),
                    createVNode("div", { class: "absolute inset-0 rounded-full border-4 border-indigo-600 border-t-transparent animate-spin" }),
                    createVNode(unref(Shield), { class: "absolute inset-0 m-auto w-8 h-8 text-indigo-600" })
                  ]),
                  createVNode("p", { class: "text-gray-600 dark:text-gray-400 text-lg" }, "ডেলিভারি ইতিহাস বিশ্লেষণ করা হচ্ছে...")
                ])) : (openBlock(), createBlock("div", {
                  key: 1,
                  class: "grid grid-cols-1 lg:grid-cols-3 gap-4"
                }, [
                  createVNode(_sfc_main$a, { class: "p-4 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 border border-gray-100 dark:border-gray-700" }, {
                    default: withCtx(() => {
                      var _a, _b, _c, _d, _e, _f;
                      return [
                        createVNode("h2", { class: "text-base font-bold mb-3 flex items-center gap-2 text-gray-800 dark:text-gray-100" }, [
                          createVNode("div", { class: "p-1.5 bg-indigo-100 dark:bg-indigo-900 rounded-lg" }, [
                            createVNode(unref(PieChart), { class: "w-4 h-4 text-indigo-600 dark:text-indigo-400" })
                          ]),
                          createTextVNode(" Delivery Success Ratio ")
                        ]),
                        createVNode("div", { class: "flex justify-center mb-3" }, [
                          createVNode("div", { class: "relative w-28 h-28" }, [
                            createVNode("div", {
                              class: "absolute inset-0 rounded-full border-2 border-dashed border-gray-200 dark:border-gray-700 animate-spin",
                              style: { "animation-duration": "20s" }
                            }),
                            createVNode("div", { class: "absolute inset-1 rounded-full bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 shadow-inner" }),
                            (openBlock(), createBlock("svg", {
                              class: "absolute inset-1 w-[calc(100%-8px)] h-[calc(100%-8px)] transform -rotate-90",
                              viewBox: "0 0 100 100"
                            }, [
                              createVNode("circle", {
                                class: "text-gray-200 dark:text-gray-700 stroke-current",
                                "stroke-width": "10",
                                fill: "transparent",
                                r: "40",
                                cx: "50",
                                cy: "50"
                              }),
                              createVNode("circle", {
                                class: "stroke-current transition-all duration-1000 ease-out",
                                style: { color: searchResults.value ? unref(getColorForRatio)(successRatio.value) : "#6366f1" },
                                "stroke-width": "10",
                                "stroke-linecap": "round",
                                fill: "transparent",
                                r: "40",
                                cx: "50",
                                cy: "50",
                                "stroke-dasharray": 251,
                                "stroke-dashoffset": searchResults.value ? 251 - 251 * successRatio.value / 100 : 251
                              }, null, 12, ["stroke-dashoffset"])
                            ])),
                            createVNode("div", { class: "absolute inset-0 flex items-center justify-center flex-col" }, [
                              createVNode("span", {
                                class: ["text-xl font-bold", searchResults.value ? "" : "text-gray-400 dark:text-gray-500"]
                              }, toDisplayString(searchResults.value ? successRatio.value.toFixed(0) : "0") + "% ", 3),
                              createVNode("span", {
                                class: ["text-xs font-medium px-2 py-0.5 rounded-full", {
                                  "bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300": searchResults.value && ratingText.value === "Excellent",
                                  "bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300": searchResults.value && ratingText.value === "Good",
                                  "bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300": searchResults.value && ratingText.value === "Poor",
                                  "bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400": !searchResults.value || ratingText.value === "New"
                                }]
                              }, toDisplayString(searchResults.value ? ratingText.value : "N/A"), 3)
                            ])
                          ])
                        ]),
                        createVNode("div", {
                          class: ["text-center mb-3 p-2 rounded-lg text-sm", {
                            "bg-gray-100 dark:bg-gray-800": !searchResults.value,
                            "bg-green-50 dark:bg-green-900/30": searchResults.value && riskLevel.value.level === "low",
                            "bg-yellow-50 dark:bg-yellow-900/30": searchResults.value && riskLevel.value.level === "medium",
                            "bg-red-50 dark:bg-red-900/30": searchResults.value && riskLevel.value.level === "high"
                          }]
                        }, [
                          !searchResults.value ? (openBlock(), createBlock("p", {
                            key: 0,
                            class: "text-gray-600 dark:text-gray-400 text-xs"
                          }, [
                            createVNode(unref(Phone), { class: "w-3 h-3 inline-block mr-1 -mt-0.5" }),
                            createTextVNode(" মোবাইল নাম্বার দিয়ে সার্চ করুন ")
                          ])) : (openBlock(), createBlock("p", {
                            key: 1,
                            class: ["font-medium text-xs", {
                              "text-green-700 dark:text-green-300": riskLevel.value.level === "low",
                              "text-yellow-700 dark:text-yellow-300": riskLevel.value.level === "medium",
                              "text-red-700 dark:text-red-300": riskLevel.value.level === "high",
                              "text-gray-600 dark:text-gray-400": riskLevel.value.level === "unknown"
                            }]
                          }, toDisplayString(riskLevel.value.level === "low" ? "এই গ্রাহক বিশ্বস্ত!" : riskLevel.value.level === "medium" ? "সতর্কতার সাথে এগিয়ে যান" : riskLevel.value.level === "high" ? "উচ্চ ঝুঁকিপূর্ণ গ্রাহক!" : "ডেলিভারি ইতিহাস নেই"), 3))
                        ], 2),
                        createVNode("div", {
                          class: ["text-center py-2 px-3 rounded-lg flex items-center justify-center gap-2 font-medium text-sm transition-all duration-300", {
                            "bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-md": searchResults.value && riskLevel.value.level === "low",
                            "bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-md": searchResults.value && riskLevel.value.level === "medium",
                            "bg-gradient-to-r from-red-500 to-rose-500 text-white shadow-md": searchResults.value && riskLevel.value.level === "high",
                            "bg-gradient-to-r from-gray-400 to-gray-500 text-white": !searchResults.value || riskLevel.value.level === "unknown"
                          }]
                        }, [
                          (openBlock(), createBlock(resolveDynamicComponent(searchResults.value ? riskLevel.value.icon : unref(HelpCircle)), { class: "w-4 h-4" })),
                          createTextVNode(" " + toDisplayString(searchResults.value ? riskLevel.value.label : "Waiting"), 1)
                        ], 2),
                        createVNode("div", { class: "mt-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700" }, [
                          createVNode("h3", { class: "font-medium text-xs mb-2 flex items-center gap-1.5 text-gray-800 dark:text-gray-100" }, [
                            createVNode(unref(Shield), { class: "w-3 h-3 text-indigo-600 dark:text-indigo-400" }),
                            createTextVNode(" Risk Factors ")
                          ]),
                          createVNode("ul", { class: "space-y-1.5" }, [
                            createVNode("li", {
                              class: ["flex items-center text-xs gap-2 p-1.5 rounded", searchResults.value && successRatio.value >= 90 ? "bg-green-50 dark:bg-green-900/20" : "bg-gray-50 dark:bg-gray-700/50"]
                            }, [
                              createVNode("div", {
                                class: ["p-1 rounded-full", searchResults.value && successRatio.value >= 90 ? "bg-green-500" : "bg-gray-300 dark:bg-gray-600"]
                              }, [
                                createVNode(unref(CheckCircle), { class: "w-2.5 h-2.5 text-white" })
                              ], 2),
                              createVNode("span", {
                                class: searchResults.value && successRatio.value >= 90 ? "text-green-700 dark:text-green-300" : "text-gray-500 dark:text-gray-400"
                              }, " High success rate ", 2)
                            ], 2),
                            createVNode("li", {
                              class: ["flex items-center text-xs gap-2 p-1.5 rounded", searchResults.value && ((_b = (_a = searchResults.value.courierData) == null ? void 0 : _a.summary) == null ? void 0 : _b.cancelled_parcel) > 3 ? "bg-red-50 dark:bg-red-900/20" : "bg-gray-50 dark:bg-gray-700/50"]
                            }, [
                              createVNode("div", {
                                class: ["p-1 rounded-full", searchResults.value && ((_d = (_c = searchResults.value.courierData) == null ? void 0 : _c.summary) == null ? void 0 : _d.cancelled_parcel) > 3 ? "bg-red-500" : "bg-gray-300 dark:bg-gray-600"]
                              }, [
                                createVNode(unref(XCircle), { class: "w-2.5 h-2.5 text-white" })
                              ], 2),
                              createVNode("span", {
                                class: searchResults.value && ((_f = (_e = searchResults.value.courierData) == null ? void 0 : _e.summary) == null ? void 0 : _f.cancelled_parcel) > 3 ? "text-red-700 dark:text-red-300" : "text-gray-500 dark:text-gray-400"
                              }, " Multiple cancellations ", 2)
                            ], 2),
                            createVNode("li", { class: "flex items-center text-xs gap-2 p-1.5 rounded bg-gray-50 dark:bg-gray-700/50" }, [
                              createVNode("div", { class: "p-1 rounded-full bg-gray-300 dark:bg-gray-600" }, [
                                createVNode(unref(AlertCircle), { class: "w-2.5 h-2.5 text-white" })
                              ]),
                              createVNode("span", { class: "text-gray-500 dark:text-gray-400" }, "Inconsistent patterns")
                            ])
                          ])
                        ])
                      ];
                    }),
                    _: 1
                  }),
                  createVNode("div", { class: "lg:col-span-2 space-y-6" }, [
                    searchResults.value ? (openBlock(), createBlock(Fragment, { key: 0 }, [
                      createVNode(unref(_sfc_main$c), {
                        variant: riskLevel.value.level === "low" ? "success" : riskLevel.value.level === "medium" ? "warning" : riskLevel.value.level === "high" ? "destructive" : "default",
                        class: "border-l-4"
                      }, {
                        default: withCtx(() => [
                          (openBlock(), createBlock(resolveDynamicComponent(riskLevel.value.icon), { class: "h-5 w-5" })),
                          createVNode(unref(_sfc_main$d), { class: "text-lg" }, {
                            default: withCtx(() => [
                              createTextVNode(toDisplayString(riskLevel.value.level === "low" ? "বিশ্বস্ত গ্রাহক" : riskLevel.value.level === "medium" ? "সতর্কতার সাথে এগিয়ে যান" : riskLevel.value.level === "high" ? "উচ্চ ঝুঁকি সতর্কতা" : "নতুন গ্রাহক"), 1)
                            ]),
                            _: 1
                          }),
                          createVNode(unref(_sfc_main$e), null, {
                            default: withCtx(() => [
                              riskLevel.value.level === "low" ? (openBlock(), createBlock(Fragment, { key: 0 }, [
                                createTextVNode(" এই গ্রাহকের " + toDisplayString(successRatio.value.toFixed(1)) + "% সাফল্যের হার সহ চমৎকার ডেলিভারি ইতিহাস রয়েছে। ", 1)
                              ], 64)) : riskLevel.value.level === "medium" ? (openBlock(), createBlock(Fragment, { key: 1 }, [
                                createTextVNode(toDisplayString(successRatio.value.toFixed(1)) + "% সাফল্যের হার সহ সাধারণত ভালো ইতিহাস, তবে কিছু যাচাই করা উচিত। ", 1)
                              ], 64)) : riskLevel.value.level === "high" ? (openBlock(), createBlock(Fragment, { key: 2 }, [
                                createTextVNode(" মাত্র " + toDisplayString(successRatio.value.toFixed(1)) + "% সাফল্যের হার। অতিরিক্ত যাচাই দৃঢ়ভাবে সুপারিশ করা হয়। ", 1)
                              ], 64)) : (openBlock(), createBlock(Fragment, { key: 3 }, [
                                createTextVNode(" এই নম্বরের জন্য কোন ডেলিভারি ইতিহাস পাওয়া যায়নি। ")
                              ], 64))
                            ]),
                            _: 1
                          })
                        ]),
                        _: 1
                      }, 8, ["variant"]),
                      createVNode("div", { class: "grid grid-cols-3 gap-4" }, [
                        createVNode(_sfc_main$a, { class: "p-5 text-center hover:shadow-lg transition-all" }, {
                          default: withCtx(() => {
                            var _a, _b;
                            return [
                              createVNode("div", { class: "text-sm text-muted-foreground mb-2 font-medium" }, "মোট অর্ডার"),
                              createVNode("div", { class: "text-4xl font-bold text-primary mb-2" }, toDisplayString(((_b = (_a = searchResults.value.courierData) == null ? void 0 : _a.summary) == null ? void 0 : _b.total_parcel) || 0), 1),
                              createVNode(_sfc_main$f, {
                                variant: "outline",
                                class: "text-xs"
                              }, {
                                default: withCtx(() => [
                                  createTextVNode("Total Orders")
                                ]),
                                _: 1
                              })
                            ];
                          }),
                          _: 1
                        }),
                        createVNode(_sfc_main$a, { class: "p-5 text-center hover:shadow-lg transition-all" }, {
                          default: withCtx(() => {
                            var _a, _b;
                            return [
                              createVNode("div", { class: "text-sm text-muted-foreground mb-2 font-medium" }, "মোট ডেলিভারি"),
                              createVNode("div", { class: "text-4xl font-bold text-green-600 dark:text-green-400 mb-2" }, toDisplayString(((_b = (_a = searchResults.value.courierData) == null ? void 0 : _a.summary) == null ? void 0 : _b.success_parcel) || 0), 1),
                              createVNode(_sfc_main$f, {
                                variant: "success",
                                class: "text-xs"
                              }, {
                                default: withCtx(() => [
                                  createTextVNode("Delivered")
                                ]),
                                _: 1
                              })
                            ];
                          }),
                          _: 1
                        }),
                        createVNode(_sfc_main$a, { class: "p-5 text-center hover:shadow-lg transition-all" }, {
                          default: withCtx(() => {
                            var _a, _b;
                            return [
                              createVNode("div", { class: "text-sm text-muted-foreground mb-2 font-medium" }, "মোট বাতিল"),
                              createVNode("div", { class: "text-4xl font-bold text-red-600 dark:text-red-400 mb-2" }, toDisplayString(((_b = (_a = searchResults.value.courierData) == null ? void 0 : _a.summary) == null ? void 0 : _b.cancelled_parcel) || 0), 1),
                              createVNode(_sfc_main$f, {
                                variant: "destructive",
                                class: "text-xs"
                              }, {
                                default: withCtx(() => [
                                  createTextVNode("Cancelled")
                                ]),
                                _: 1
                              })
                            ];
                          }),
                          _: 1
                        })
                      ]),
                      createVNode(_sfc_main$a, { class: "p-5" }, {
                        default: withCtx(() => [
                          createVNode("div", { class: "flex items-center justify-between mb-3" }, [
                            createVNode("span", { class: "text-sm font-medium text-muted-foreground" }, "সাফল্যের হার"),
                            createVNode(_sfc_main$f, {
                              variant: successRatio.value >= 90 ? "success" : successRatio.value >= 70 ? "warning" : "destructive"
                            }, {
                              default: withCtx(() => [
                                createTextVNode(toDisplayString(successRatio.value.toFixed(1)) + "% ", 1)
                              ]),
                              _: 1
                            }, 8, ["variant"])
                          ]),
                          createVNode(_sfc_main$g, {
                            "model-value": successRatio.value,
                            class: "h-3",
                            "indicator-class": successRatio.value >= 90 ? "bg-green-500" : successRatio.value >= 70 ? "bg-yellow-500" : "bg-red-500"
                          }, null, 8, ["model-value", "indicator-class"])
                        ]),
                        _: 1
                      }),
                      createVNode(_sfc_main$a, { class: "p-6" }, {
                        default: withCtx(() => [
                          createVNode("h3", { class: "text-lg font-bold mb-4 flex items-center gap-2" }, [
                            createVNode(unref(BarChart3), { class: "w-5 h-5 text-primary" }),
                            createTextVNode(" কুরিয়ার ডিটেইলস ")
                          ]),
                          createVNode(unref(_sfc_main$6), null, {
                            default: withCtx(() => [
                              createVNode(unref(_sfc_main$5), null, {
                                default: withCtx(() => [
                                  createVNode(unref(_sfc_main$3), null, {
                                    default: withCtx(() => [
                                      createVNode(unref(_sfc_main$2), { class: "w-[180px]" }, {
                                        default: withCtx(() => [
                                          createTextVNode("Courier")
                                        ]),
                                        _: 1
                                      }),
                                      createVNode(unref(_sfc_main$2), null, {
                                        default: withCtx(() => [
                                          createTextVNode("Orders")
                                        ]),
                                        _: 1
                                      }),
                                      createVNode(unref(_sfc_main$2), null, {
                                        default: withCtx(() => [
                                          createTextVNode("Delivered")
                                        ]),
                                        _: 1
                                      }),
                                      createVNode(unref(_sfc_main$2), null, {
                                        default: withCtx(() => [
                                          createTextVNode("Cancelled")
                                        ]),
                                        _: 1
                                      }),
                                      createVNode(unref(_sfc_main$2), { class: "text-right" }, {
                                        default: withCtx(() => [
                                          createTextVNode("Success Rate")
                                        ]),
                                        _: 1
                                      })
                                    ]),
                                    _: 1
                                  })
                                ]),
                                _: 1
                              }),
                              createVNode(unref(_sfc_main$4), null, {
                                default: withCtx(() => [
                                  (openBlock(true), createBlock(Fragment, null, renderList(courierList.value, (courier) => {
                                    return openBlock(), createBlock(unref(_sfc_main$3), {
                                      key: courier.name
                                    }, {
                                      default: withCtx(() => [
                                        createVNode(unref(_sfc_main$1), { class: "font-medium" }, {
                                          default: withCtx(() => [
                                            createVNode("div", { class: "flex items-center gap-2" }, [
                                              courier.logo ? (openBlock(), createBlock("img", {
                                                key: 0,
                                                src: courier.logo,
                                                alt: courier.name,
                                                class: "w-6 h-6 object-contain rounded"
                                              }, null, 8, ["src", "alt"])) : createCommentVNode("", true),
                                              createVNode("span", null, toDisplayString(courier.name), 1)
                                            ])
                                          ]),
                                          _: 2
                                        }, 1024),
                                        createVNode(unref(_sfc_main$1), null, {
                                          default: withCtx(() => [
                                            createVNode(_sfc_main$f, { variant: "outline" }, {
                                              default: withCtx(() => [
                                                createTextVNode(toDisplayString(courier.totalParcel), 1)
                                              ]),
                                              _: 2
                                            }, 1024)
                                          ]),
                                          _: 2
                                        }, 1024),
                                        createVNode(unref(_sfc_main$1), null, {
                                          default: withCtx(() => [
                                            createVNode(_sfc_main$f, { variant: "success" }, {
                                              default: withCtx(() => [
                                                createTextVNode(toDisplayString(courier.successParcel), 1)
                                              ]),
                                              _: 2
                                            }, 1024)
                                          ]),
                                          _: 2
                                        }, 1024),
                                        createVNode(unref(_sfc_main$1), null, {
                                          default: withCtx(() => [
                                            createVNode(_sfc_main$f, { variant: "destructive" }, {
                                              default: withCtx(() => [
                                                createTextVNode(toDisplayString(courier.cancelledParcel), 1)
                                              ]),
                                              _: 2
                                            }, 1024)
                                          ]),
                                          _: 2
                                        }, 1024),
                                        createVNode(unref(_sfc_main$1), { class: "text-right" }, {
                                          default: withCtx(() => [
                                            createVNode(_sfc_main$f, {
                                              class: [courier.successRatio >= 90 ? "bg-green-500 hover:bg-green-600" : courier.successRatio >= 70 ? "bg-yellow-500 hover:bg-yellow-600" : "bg-red-500 hover:bg-red-600", "text-white"]
                                            }, {
                                              default: withCtx(() => [
                                                createTextVNode(toDisplayString(courier.successRatio.toFixed(1)) + "% ", 1)
                                              ]),
                                              _: 2
                                            }, 1032, ["class"])
                                          ]),
                                          _: 2
                                        }, 1024)
                                      ]),
                                      _: 2
                                    }, 1024);
                                  }), 128))
                                ]),
                                _: 1
                              })
                            ]),
                            _: 1
                          })
                        ]),
                        _: 1
                      }),
                      createVNode(_sfc_main$a, { class: "p-6" }, {
                        default: withCtx(() => [
                          createVNode("div", { class: "flex justify-between items-center mb-6" }, [
                            createVNode("h2", { class: "text-xl font-bold flex items-center gap-2" }, [
                              createVNode(unref(MessageSquare), { class: "w-5 h-5 text-indigo-600" }),
                              createTextVNode(" গ্রাহক রিভিউ ")
                            ]),
                            createVNode(_sfc_main$b, {
                              variant: "secondary",
                              onClick: ($event) => showRatingModal.value = true
                            }, {
                              default: withCtx(() => [
                                createVNode(unref(Plus), { class: "w-4 h-4 mr-1" }),
                                createTextVNode(" নতুন রিভিউ ")
                              ]),
                              _: 1
                            }, 8, ["onClick"])
                          ]),
                          reviews.value.length === 0 ? (openBlock(), createBlock("div", {
                            key: 0,
                            class: "text-center py-10 text-gray-500 dark:text-gray-400"
                          }, [
                            createVNode(unref(MessageSquare), { class: "w-12 h-12 mx-auto mb-4 opacity-50" }),
                            createVNode("p", null, "এই নাম্বারের জন্য কোন রিভিউ নেই"),
                            createVNode("p", { class: "text-sm mt-2" }, "প্রথম রিভিউ দিয়ে অন্যদের সাহায্য করুন")
                          ])) : (openBlock(), createBlock("div", {
                            key: 1,
                            class: "space-y-4"
                          }, [
                            (openBlock(true), createBlock(Fragment, null, renderList(reviews.value, (review) => {
                              return openBlock(), createBlock("div", {
                                key: review.id,
                                class: "bg-gray-50 dark:bg-gray-700 p-4 rounded-lg"
                              }, [
                                createVNode("div", { class: "flex justify-between items-start mb-2" }, [
                                  createVNode("div", null, [
                                    createVNode("h4", { class: "font-semibold" }, toDisplayString(review.name) + " (" + toDisplayString(unref(maskPhoneNumber)(review.commenter_phone)) + ")", 1),
                                    createVNode(_sfc_main$7, {
                                      "model-value": review.rating,
                                      readonly: "",
                                      size: "sm",
                                      class: "my-1"
                                    }, null, 8, ["model-value"])
                                  ]),
                                  createVNode("div", { class: "text-xs text-gray-500 dark:text-gray-400" }, toDisplayString(unref(formatBengaliDate)(review.created_at)), 1)
                                ]),
                                createVNode("p", { class: "text-gray-700 dark:text-gray-300" }, toDisplayString(review.comment), 1)
                              ]);
                            }), 128))
                          ]))
                        ]),
                        _: 1
                      })
                    ], 64)) : (openBlock(), createBlock(_sfc_main$a, {
                      key: 1,
                      class: "h-full p-6 text-center bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 flex flex-col items-center justify-center"
                    }, {
                      default: withCtx(() => [
                        createVNode("img", {
                          src: "https://img.freepik.com/free-vector/work-office-computer-man-woman-business-character-marketing-online-employee-technology-business-man-cartoon-co-working-flat-design-freelance_1150-41790.jpg?w=1060",
                          alt: "Search illustration",
                          class: "mx-auto mb-4 rounded-lg shadow-md w-48 sm:w-56 md:w-64"
                        }),
                        createVNode("h3", { class: "text-lg font-bold mb-2 text-gray-800 dark:text-gray-100" }, "কুরিয়ার ফ্রড চেক করুন"),
                        createVNode("p", { class: "text-gray-600 dark:text-gray-400 mb-4 max-w-sm mx-auto text-sm" }, " মোবাইল নাম্বার দিয়ে সার্চ করুন এবং গ্রাহকের ডেলিভারি ইতিহাস দেখুন। "),
                        createVNode("div", { class: "flex flex-wrap justify-center gap-2" }, [
                          createVNode("div", { class: "flex items-center gap-1.5 bg-green-50 dark:bg-green-900/30 px-3 py-1.5 rounded-full" }, [
                            createVNode("div", { class: "w-2.5 h-2.5 rounded-full bg-green-500" }),
                            createVNode("span", { class: "text-xs text-green-700 dark:text-green-300 font-medium" }, "Low Risk")
                          ]),
                          createVNode("div", { class: "flex items-center gap-1.5 bg-yellow-50 dark:bg-yellow-900/30 px-3 py-1.5 rounded-full" }, [
                            createVNode("div", { class: "w-2.5 h-2.5 rounded-full bg-yellow-500" }),
                            createVNode("span", { class: "text-xs text-yellow-700 dark:text-yellow-300 font-medium" }, "Medium Risk")
                          ]),
                          createVNode("div", { class: "flex items-center gap-1.5 bg-red-50 dark:bg-red-900/30 px-3 py-1.5 rounded-full" }, [
                            createVNode("div", { class: "w-2.5 h-2.5 rounded-full bg-red-500" }),
                            createVNode("span", { class: "text-xs text-red-700 dark:text-red-300 font-medium" }, "High Risk")
                          ])
                        ])
                      ]),
                      _: 1
                    }))
                  ])
                ]))
              ]),
              createVNode("section", { class: "container mx-auto px-4 py-12" }, [
                createVNode(_sfc_main$a, { class: "p-6" }, {
                  default: withCtx(() => [
                    createVNode("h2", { class: "text-2xl font-bold mb-8 text-center" }, "কেন কুরিয়ার ফ্রড চেক করা প্রয়োজন?"),
                    createVNode("div", { class: "grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" }, [
                      createVNode("div", { class: "p-5 border border-gray-200 dark:border-gray-600 rounded-xl text-center bg-gray-50 dark:bg-gray-700 hover:shadow-lg transition-shadow" }, [
                        createVNode("div", { class: "w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4" }, [
                          createVNode(unref(Shield), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400" })
                        ]),
                        createVNode("h3", { class: "text-lg font-semibold mb-2" }, "ব্যবসা সুরক্ষা"),
                        createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "আপনার ব্যবসাকে সম্ভাব্য কুরিয়ার ফ্রড থেকে রক্ষা করুন। প্রতি মাসে হাজার হাজার টাকা সাশ্রয় করুন।")
                      ]),
                      createVNode("div", { class: "p-5 border border-gray-200 dark:border-gray-600 rounded-xl text-center bg-gray-50 dark:bg-gray-700 hover:shadow-lg transition-shadow" }, [
                        createVNode("div", { class: "w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4" }, [
                          createVNode(unref(TrendingUp), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400" })
                        ]),
                        createVNode("h3", { class: "text-lg font-semibold mb-2" }, "ডেলিভারি সাফল্য বাড়ান"),
                        createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "বিশ্বস্ত গ্রাহকদের চিহ্নিত করে আপনার ডেলিভারি সাফল্যের হার বাড়ান এবং ব্যবসার লাভ বৃদ্ধি করুন।")
                      ]),
                      createVNode("div", { class: "p-5 border border-gray-200 dark:border-gray-600 rounded-xl text-center bg-gray-50 dark:bg-gray-700 hover:shadow-lg transition-shadow" }, [
                        createVNode("div", { class: "w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4" }, [
                          createVNode(unref(History), { class: "w-8 h-8 text-indigo-600 dark:text-indigo-400" })
                        ]),
                        createVNode("h3", { class: "text-lg font-semibold mb-2" }, "রিয়েল-টাইম ডাটা"),
                        createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "সর্বাধিক আপডেটেড ডাটা দিয়ে গ্রাহকের আচরণ বিশ্লেষণ করুন এবং সঠিক সিদ্ধান্ত নিন।")
                      ])
                    ]),
                    createVNode("div", { class: "bg-gray-50 dark:bg-gray-700 p-6 rounded-xl" }, [
                      createVNode("h3", { class: "text-xl font-semibold mb-4" }, "বাংলাদেশে কুরিয়ার ফ্রড সম্পর্কে জানুন"),
                      createVNode("p", { class: "mb-4 text-gray-700 dark:text-gray-300" }, " বাংলাদেশে প্রতি বছর হাজার হাজার ব্যবসায়ী কুরিয়ার ফ্রডের শিকার হন। কুরিয়ার ফ্রড হল যখন একজন গ্রাহক ইচ্ছাকৃতভাবে পণ্য গ্রহণ করে না বা ডেলিভারি বাতিল করে। "),
                      createVNode("p", { class: "mb-4 text-gray-700 dark:text-gray-300" }, " FraudShield আপনাকে একটি গ্রাহকের পূর্ববর্তী ডেলিভারি ইতিহাস দেখার সুযোগ দেয়, যাতে আপনি সিদ্ধান্ত নিতে পারেন যে তাদের কাছে পণ্য পাঠানো নিরাপদ কিনা। "),
                      createVNode("p", { class: "text-gray-700 dark:text-gray-300" }, " আমাদের সিস্টেম বাংলাদেশের সকল প্রধান কুরিয়ার সার্ভিসের ডাটা ব্যবহার করে এবং একটি বিশ্বস্ত ফ্রড স্কোর প্রদান করে। ")
                    ])
                  ]),
                  _: 1
                })
              ]),
              createVNode("section", { class: "container mx-auto px-4 py-12" }, [
                createVNode("div", { class: "text-center mb-8" }, [
                  createVNode("h2", { class: "text-2xl font-bold mb-2" }, "সাধারণ জিজ্ঞাসা (FAQ)"),
                  createVNode("p", { class: "text-gray-600 dark:text-gray-400" }, "আপনার FraudShield সম্পর্কিত সব প্রশ্নের উত্তর এখানে পাবেন")
                ]),
                createVNode("div", { class: "max-w-3xl mx-auto space-y-4" }, [
                  (openBlock(), createBlock(Fragment, null, renderList(faqs, (faq, index) => {
                    return createVNode(_sfc_main$a, {
                      key: index,
                      class: "overflow-hidden border-l-4 border-indigo-500 hover:shadow-lg transition-shadow"
                    }, {
                      default: withCtx(() => [
                        createVNode("button", {
                          onClick: ($event) => toggleFaq(index),
                          class: "w-full p-5 flex justify-between items-center text-left font-semibold text-gray-800 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"
                        }, [
                          createVNode("span", null, toDisplayString(faq.question), 1),
                          createVNode("div", { class: "p-1 bg-indigo-100 dark:bg-indigo-900 rounded-full text-indigo-600 dark:text-indigo-400" }, [
                            activeFaq.value === index ? (openBlock(), createBlock(unref(ChevronUp), {
                              key: 0,
                              class: "w-5 h-5"
                            })) : (openBlock(), createBlock(unref(ChevronDown), {
                              key: 1,
                              class: "w-5 h-5"
                            }))
                          ])
                        ], 8, ["onClick"]),
                        createVNode(Transition, {
                          "enter-active-class": "transition-all duration-200 ease-out",
                          "enter-from-class": "opacity-0 max-h-0",
                          "enter-to-class": "opacity-100 max-h-96",
                          "leave-active-class": "transition-all duration-150 ease-in",
                          "leave-from-class": "opacity-100 max-h-96",
                          "leave-to-class": "opacity-0 max-h-0"
                        }, {
                          default: withCtx(() => [
                            activeFaq.value === index ? (openBlock(), createBlock("div", {
                              key: 0,
                              class: "px-5 pb-5 text-gray-600 dark:text-gray-300 overflow-hidden"
                            }, toDisplayString(faq.answer), 1)) : createCommentVNode("", true)
                          ]),
                          _: 2
                        }, 1024)
                      ]),
                      _: 2
                    }, 1024);
                  }), 64))
                ])
              ]),
              createVNode("div", { class: "fixed bottom-8 right-8 z-40" }, [
                createVNode("a", {
                  href: "/download",
                  class: "flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-full font-semibold hover:shadow-2xl hover:scale-105 transition-all duration-300 shadow-xl animate-pulse"
                }, [
                  createVNode(unref(Download), { class: "w-5 h-5" }),
                  createVNode("span", null, "অ্যাপ ডাউনলোড করুন")
                ])
              ]),
              createVNode(_sfc_main$8, {
                open: showRatingModal.value,
                "onUpdate:open": ($event) => showRatingModal.value = $event
              }, {
                default: withCtx(() => [
                  createVNode("h3", { class: "text-xl font-bold mb-4" }, "Rate This Customer"),
                  createVNode("p", { class: "text-gray-600 dark:text-gray-300 mb-4" }, [
                    createTextVNode(" Share your experience with "),
                    createVNode("span", { class: "font-medium" }, toDisplayString(phoneInput.value), 1)
                  ]),
                  createVNode("form", {
                    onSubmit: withModifiers(submitReview, ["prevent"]),
                    class: "space-y-4"
                  }, [
                    createVNode("div", null, [
                      createVNode("label", { class: "block text-sm font-medium mb-2" }, "আপনার নম্বর"),
                      withDirectives(createVNode("input", {
                        "onUpdate:modelValue": ($event) => reviewForm.value.ownNumber = $event,
                        type: "text",
                        placeholder: "আপনার নম্বর লিখুন",
                        class: "w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white",
                        required: ""
                      }, null, 8, ["onUpdate:modelValue"]), [
                        [vModelText, reviewForm.value.ownNumber]
                      ])
                    ]),
                    createVNode("div", null, [
                      createVNode("label", { class: "block text-sm font-medium mb-2" }, "আপনার নাম"),
                      withDirectives(createVNode("input", {
                        "onUpdate:modelValue": ($event) => reviewForm.value.name = $event,
                        type: "text",
                        placeholder: "আপনার নাম লিখুন",
                        class: "w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white",
                        required: ""
                      }, null, 8, ["onUpdate:modelValue"]), [
                        [vModelText, reviewForm.value.name]
                      ])
                    ]),
                    createVNode("div", null, [
                      createVNode("label", { class: "block text-sm font-medium mb-2" }, "রেটিং দিন"),
                      createVNode(_sfc_main$7, {
                        modelValue: reviewForm.value.rating,
                        "onUpdate:modelValue": ($event) => reviewForm.value.rating = $event,
                        size: "lg"
                      }, null, 8, ["modelValue", "onUpdate:modelValue"])
                    ]),
                    createVNode("div", null, [
                      createVNode("label", { class: "block text-sm font-medium mb-2" }, "আপনার মন্তব্য"),
                      withDirectives(createVNode("textarea", {
                        "onUpdate:modelValue": ($event) => reviewForm.value.comment = $event,
                        placeholder: "আপনার অভিজ্ঞতা শেয়ার করুন",
                        rows: "3",
                        class: "w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white",
                        required: ""
                      }, null, 8, ["onUpdate:modelValue"]), [
                        [vModelText, reviewForm.value.comment]
                      ])
                    ]),
                    createVNode("div", { class: "flex justify-end" }, [
                      createVNode(_sfc_main$b, {
                        type: "submit",
                        loading: isSubmittingReview.value
                      }, {
                        default: withCtx(() => [
                          createVNode(unref(Send), { class: "w-4 h-4 mr-2" }),
                          createTextVNode(" জমা দিন ")
                        ]),
                        _: 1
                      }, 8, ["loading"])
                    ])
                  ], 32)
                ]),
                _: 1
              }, 8, ["open", "onUpdate:open"])
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Welcome.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
