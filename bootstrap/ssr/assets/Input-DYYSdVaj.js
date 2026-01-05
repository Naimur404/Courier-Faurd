import { defineComponent, ref, computed, mergeProps, useSSRContext } from "vue";
import { ssrRenderAttrs } from "vue/server-renderer";
import { c as cn } from "./utils-DvCvi0aN.js";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Input",
  __ssrInlineRender: true,
  props: {
    modelValue: { default: "" },
    placeholder: { default: "" },
    type: { default: "text" },
    class: {},
    error: {}
  },
  emits: ["update:modelValue", "enter"],
  setup(__props, { emit: __emit }) {
    const props = __props;
    const inputRef = ref(null);
    const classes = computed(
      () => cn(
        "flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm",
        props.error && "border-destructive focus-visible:ring-destructive",
        props.class
      )
    );
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<input${ssrRenderAttrs(mergeProps({
        ref_key: "inputRef",
        ref: inputRef,
        type: __props.type,
        value: __props.modelValue,
        placeholder: __props.placeholder,
        class: classes.value
      }, _attrs))}>`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ui/Input.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as _
};
