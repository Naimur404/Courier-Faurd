import { defineComponent, computed, mergeProps, useSSRContext } from "vue";
import { ssrRenderAttrs, ssrRenderSlot } from "vue/server-renderer";
import { clsx } from "clsx";
import { twMerge } from "tailwind-merge";
function cn(...inputs) {
  return twMerge(clsx(inputs));
}
function convertToBengaliNumbers(number) {
  const bengaliDigits = ["০", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"];
  return number.toString().replace(/[0-9]/g, (digit) => bengaliDigits[parseInt(digit)]);
}
function formatBengaliNumber(number) {
  const formattedNumber = Math.round(number).toLocaleString("en-US");
  return convertToBengaliNumbers(formattedNumber);
}
function getColorForRatio(ratio) {
  if (ratio >= 90) return "#10b981";
  if (ratio >= 70) return "#f59e0b";
  return "#ef4444";
}
function maskPhoneNumber(phone) {
  if (!phone || phone.length < 4) return phone;
  const firstPart = phone.substring(0, 3);
  const lastPart = phone.substring(phone.length - 2);
  const maskedPart = "*".repeat(phone.length - 5);
  return firstPart + maskedPart + lastPart;
}
function formatBengaliDate(dateString) {
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
  const date = new Date(dateString);
  const day = convertToBengaliNumbers(date.getDate());
  const month = bengaliMonths[date.getMonth()];
  const year = convertToBengaliNumbers(date.getFullYear());
  return `${day} ${month} ${year}`;
}
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Card",
  __ssrInlineRender: true,
  props: {
    class: {}
  },
  setup(__props) {
    const props = __props;
    const classes = computed(
      () => cn(
        "rounded-xl border border-border bg-card text-card-foreground shadow-sm",
        props.class
      )
    );
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: classes.value }, _attrs))}>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</div>`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/Card.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as _,
  formatBengaliDate as a,
  convertToBengaliNumbers as b,
  cn as c,
  formatBengaliNumber as f,
  getColorForRatio as g,
  maskPhoneNumber as m
};
