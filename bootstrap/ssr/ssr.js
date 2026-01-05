import { ref, shallowRef, defineComponent, markRaw, h, computed, onMounted, watch, onBeforeUnmount, onUnmounted, Fragment, reactive, createSSRApp } from "vue";
import { renderToString } from "@vue/server-renderer";
import { createHeadManager, router, isUrlMethodPair, formDataToObject, mergeDataIntoQueryString, getScrollableParent, useInfiniteScroll, config as config$1, UseFormUtils, resetFormFields, shouldIntercept, shouldNavigate, getInitialPageFromDOM, setupProgress } from "@inertiajs/core";
import { escape, cloneDeep, has, set, get, isEqual } from "lodash-es";
import { createValidator, toSimpleValidationErrors, resolveName } from "laravel-precognition";
import createServer from "@inertiajs/core/server";
var remember = {
  created() {
    if (!this.$options.remember) {
      return;
    }
    if (Array.isArray(this.$options.remember)) {
      this.$options.remember = { data: this.$options.remember };
    }
    if (typeof this.$options.remember === "string") {
      this.$options.remember = { data: [this.$options.remember] };
    }
    if (typeof this.$options.remember.data === "string") {
      this.$options.remember = { data: [this.$options.remember.data] };
    }
    const rememberKey = this.$options.remember.key instanceof Function ? this.$options.remember.key.call(this) : this.$options.remember.key;
    const restored = router.restore(rememberKey);
    const rememberable = this.$options.remember.data.filter((key2) => {
      return !(this[key2] !== null && typeof this[key2] === "object" && this[key2].__rememberable === false);
    });
    const hasCallbacks = (key2) => {
      return this[key2] !== null && typeof this[key2] === "object" && typeof this[key2].__remember === "function" && typeof this[key2].__restore === "function";
    };
    rememberable.forEach((key2) => {
      if (this[key2] !== void 0 && restored !== void 0 && restored[key2] !== void 0) {
        hasCallbacks(key2) ? this[key2].__restore(restored[key2]) : this[key2] = restored[key2];
      }
      this.$watch(
        key2,
        () => {
          router.remember(
            rememberable.reduce(
              (data, key3) => ({
                ...data,
                [key3]: cloneDeep(hasCallbacks(key3) ? this[key3].__remember() : this[key3])
              }),
              {}
            ),
            rememberKey
          );
        },
        { immediate: true, deep: true }
      );
    });
  }
};
var remember_default = remember;
function useForm(...args) {
  let { rememberKey, data, precognitionEndpoint } = UseFormUtils.parseUseFormArguments(...args);
  const restored = rememberKey ? router.restore(rememberKey) : null;
  let defaults = typeof data === "function" ? cloneDeep(data()) : cloneDeep(data);
  let cancelToken = null;
  let recentlySuccessfulTimeoutId;
  let transform = (data2) => data2;
  let validatorRef = null;
  let defaultsCalledInOnSuccess = false;
  const form = reactive({
    ...restored ? restored.data : cloneDeep(defaults),
    isDirty: false,
    errors: restored ? restored.errors : {},
    hasErrors: false,
    processing: false,
    progress: null,
    wasSuccessful: false,
    recentlySuccessful: false,
    withPrecognition(...args2) {
      precognitionEndpoint = UseFormUtils.createWayfinderCallback(...args2);
      const formWithPrecognition = this;
      let withAllErrors = false;
      const validator = createValidator((client) => {
        const { method, url } = precognitionEndpoint();
        const transformedData = cloneDeep(transform(this.data()));
        return client[method](url, transformedData);
      }, cloneDeep(defaults));
      validatorRef = validator;
      validator.on("validatingChanged", () => {
        formWithPrecognition.validating = validator.validating();
      }).on("validatedChanged", () => {
        formWithPrecognition.__valid = validator.valid();
      }).on("touchedChanged", () => {
        formWithPrecognition.__touched = validator.touched();
      }).on("errorsChanged", () => {
        const validationErrors = withAllErrors ? validator.errors() : toSimpleValidationErrors(validator.errors());
        this.errors = {};
        this.setError(validationErrors);
        formWithPrecognition.__valid = validator.valid();
      });
      const tap = (value, callback) => {
        callback(value);
        return value;
      };
      Object.assign(formWithPrecognition, {
        __touched: [],
        __valid: [],
        validating: false,
        validator: () => validator,
        withAllErrors: () => tap(formWithPrecognition, () => withAllErrors = true),
        valid: (field) => formWithPrecognition.__valid.includes(field),
        invalid: (field) => field in this.errors,
        setValidationTimeout: (duration) => tap(formWithPrecognition, () => validator.setTimeout(duration)),
        validateFiles: () => tap(formWithPrecognition, () => validator.validateFiles()),
        withoutFileValidation: () => tap(formWithPrecognition, () => validator.withoutFileValidation()),
        touch: (field, ...fields) => {
          if (Array.isArray(field)) {
            validator.touch(field);
          } else if (typeof field === "string") {
            validator.touch([field, ...fields]);
          } else {
            validator.touch(field);
          }
          return formWithPrecognition;
        },
        touched: (field) => typeof field === "string" ? formWithPrecognition.__touched.includes(field) : formWithPrecognition.__touched.length > 0,
        validate: (field, config2) => {
          if (typeof field === "object" && !("target" in field)) {
            config2 = field;
            field = void 0;
          }
          if (field === void 0) {
            validator.validate(config2);
          } else {
            const fieldName = resolveName(field);
            const transformedData = transform(this.data());
            validator.validate(fieldName, get(transformedData, fieldName), config2);
          }
          return formWithPrecognition;
        },
        setErrors: (errors) => tap(formWithPrecognition, () => this.setError(errors)),
        forgetError: (field) => tap(
          formWithPrecognition,
          () => this.clearErrors(resolveName(field))
        )
      });
      return formWithPrecognition;
    },
    data() {
      return Object.keys(defaults).reduce((carry, key2) => {
        return set(carry, key2, get(this, key2));
      }, {});
    },
    transform(callback) {
      transform = callback;
      return this;
    },
    defaults(fieldOrFields, maybeValue) {
      if (typeof data === "function") {
        throw new Error("You cannot call `defaults()` when using a function to define your form data.");
      }
      defaultsCalledInOnSuccess = true;
      if (typeof fieldOrFields === "undefined") {
        defaults = cloneDeep(this.data());
        this.isDirty = false;
      } else {
        defaults = typeof fieldOrFields === "string" ? set(cloneDeep(defaults), fieldOrFields, maybeValue) : Object.assign({}, cloneDeep(defaults), fieldOrFields);
      }
      validatorRef == null ? void 0 : validatorRef.defaults(defaults);
      return this;
    },
    reset(...fields) {
      const resolvedData = typeof data === "function" ? cloneDeep(data()) : cloneDeep(defaults);
      const clonedData = cloneDeep(resolvedData);
      if (fields.length === 0) {
        defaults = clonedData;
        Object.assign(this, resolvedData);
      } else {
        fields.filter((key2) => has(clonedData, key2)).forEach((key2) => {
          set(defaults, key2, get(clonedData, key2));
          set(this, key2, get(resolvedData, key2));
        });
      }
      validatorRef == null ? void 0 : validatorRef.reset(...fields);
      return this;
    },
    setError(fieldOrFields, maybeValue) {
      const errors = typeof fieldOrFields === "string" ? { [fieldOrFields]: maybeValue } : fieldOrFields;
      Object.assign(this.errors, errors);
      this.hasErrors = Object.keys(this.errors).length > 0;
      validatorRef == null ? void 0 : validatorRef.setErrors(errors);
      return this;
    },
    clearErrors(...fields) {
      this.errors = Object.keys(this.errors).reduce(
        (carry, field) => ({
          ...carry,
          ...fields.length > 0 && !fields.includes(field) ? { [field]: this.errors[field] } : {}
        }),
        {}
      );
      this.hasErrors = Object.keys(this.errors).length > 0;
      if (validatorRef) {
        if (fields.length === 0) {
          validatorRef.setErrors({});
        } else {
          fields.forEach(validatorRef.forgetError);
        }
      }
      return this;
    },
    resetAndClearErrors(...fields) {
      this.reset(...fields);
      this.clearErrors(...fields);
      return this;
    },
    submit(...args2) {
      const { method, url, options } = UseFormUtils.parseSubmitArguments(args2, precognitionEndpoint);
      defaultsCalledInOnSuccess = false;
      const _options = {
        ...options,
        onCancelToken: (token) => {
          cancelToken = token;
          if (options.onCancelToken) {
            return options.onCancelToken(token);
          }
        },
        onBefore: (visit) => {
          this.wasSuccessful = false;
          this.recentlySuccessful = false;
          clearTimeout(recentlySuccessfulTimeoutId);
          if (options.onBefore) {
            return options.onBefore(visit);
          }
        },
        onStart: (visit) => {
          this.processing = true;
          if (options.onStart) {
            return options.onStart(visit);
          }
        },
        onProgress: (event) => {
          this.progress = event ?? null;
          if (options.onProgress) {
            return options.onProgress(event);
          }
        },
        onSuccess: async (page2) => {
          this.processing = false;
          this.progress = null;
          this.clearErrors();
          this.wasSuccessful = true;
          this.recentlySuccessful = true;
          recentlySuccessfulTimeoutId = setTimeout(
            () => this.recentlySuccessful = false,
            config.get("form.recentlySuccessfulDuration")
          );
          const onSuccess = options.onSuccess ? await options.onSuccess(page2) : null;
          if (!defaultsCalledInOnSuccess) {
            defaults = cloneDeep(this.data());
            this.isDirty = false;
          }
          return onSuccess;
        },
        onError: (errors) => {
          this.processing = false;
          this.progress = null;
          this.clearErrors().setError(errors);
          if (options.onError) {
            return options.onError(errors);
          }
        },
        onCancel: () => {
          this.processing = false;
          this.progress = null;
          if (options.onCancel) {
            return options.onCancel();
          }
        },
        onFinish: (visit) => {
          this.processing = false;
          this.progress = null;
          cancelToken = null;
          if (options.onFinish) {
            return options.onFinish(visit);
          }
        }
      };
      const transformedData = transform(this.data());
      if (method === "delete") {
        router.delete(url, { ..._options, data: transformedData });
      } else {
        router[method](url, transformedData, _options);
      }
    },
    get(url, options) {
      this.submit("get", url, options);
    },
    post(url, options) {
      this.submit("post", url, options);
    },
    put(url, options) {
      this.submit("put", url, options);
    },
    patch(url, options) {
      this.submit("patch", url, options);
    },
    delete(url, options) {
      this.submit("delete", url, options);
    },
    cancel() {
      if (cancelToken) {
        cancelToken.cancel();
      }
    },
    __rememberable: rememberKey === null,
    __remember() {
      return { data: this.data(), errors: this.errors };
    },
    __restore(restored2) {
      Object.assign(this, restored2.data);
      this.setError(restored2.errors);
    }
  });
  const typedForm = form;
  watch(
    typedForm,
    (newValue) => {
      typedForm.isDirty = !isEqual(typedForm.data(), defaults);
      if (rememberKey) {
        router.remember(cloneDeep(newValue.__remember()), rememberKey);
      }
    },
    { immediate: true, deep: true }
  );
  return precognitionEndpoint ? typedForm.withPrecognition(precognitionEndpoint) : typedForm;
}
var component = ref(void 0);
var page = ref();
var layout = shallowRef(null);
var key = ref(void 0);
var headManager;
var App = defineComponent({
  name: "Inertia",
  props: {
    initialPage: {
      type: Object,
      required: true
    },
    initialComponent: {
      type: Object,
      required: false
    },
    resolveComponent: {
      type: Function,
      required: false
    },
    titleCallback: {
      type: Function,
      required: false,
      default: (title) => title
    },
    onHeadUpdate: {
      type: Function,
      required: false,
      default: () => () => {
      }
    }
  },
  setup({ initialPage, initialComponent, resolveComponent, titleCallback, onHeadUpdate }) {
    component.value = initialComponent ? markRaw(initialComponent) : void 0;
    page.value = { ...initialPage, flash: initialPage.flash ?? {} };
    key.value = void 0;
    const isServer = typeof window === "undefined";
    headManager = createHeadManager(isServer, titleCallback || ((title) => title), onHeadUpdate || (() => {
    }));
    if (!isServer) {
      router.init({
        initialPage,
        resolveComponent,
        swapComponent: async (options) => {
          component.value = markRaw(options.component);
          page.value = options.page;
          key.value = options.preserveState ? key.value : Date.now();
        },
        onFlash: (flash) => {
          page.value = { ...page.value, flash };
        }
      });
      router.on("navigate", () => headManager.forceUpdate());
    }
    return () => {
      if (component.value) {
        component.value.inheritAttrs = !!component.value.inheritAttrs;
        const child = h(component.value, {
          ...page.value.props,
          key: key.value
        });
        if (layout.value) {
          component.value.layout = layout.value;
          layout.value = null;
        }
        if (component.value.layout) {
          if (typeof component.value.layout === "function") {
            return component.value.layout(h, child);
          }
          return (Array.isArray(component.value.layout) ? component.value.layout : [component.value.layout]).concat(child).reverse().reduce((child2, layout2) => {
            layout2.inheritAttrs = !!layout2.inheritAttrs;
            return h(layout2, { ...page.value.props }, () => child2);
          });
        }
        return child;
      }
    };
  }
});
var app_default = App;
var plugin = {
  install(app) {
    router.form = useForm;
    Object.defineProperty(app.config.globalProperties, "$inertia", { get: () => router });
    Object.defineProperty(app.config.globalProperties, "$page", { get: () => page.value });
    Object.defineProperty(app.config.globalProperties, "$headManager", { get: () => headManager });
    app.mixin(remember_default);
  }
};
function usePage() {
  return reactive({
    props: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.props;
    }),
    url: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.url;
    }),
    component: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.component;
    }),
    version: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.version;
    }),
    clearHistory: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.clearHistory;
    }),
    deferredProps: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.deferredProps;
    }),
    mergeProps: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.mergeProps;
    }),
    prependProps: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.prependProps;
    }),
    deepMergeProps: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.deepMergeProps;
    }),
    matchPropsOn: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.matchPropsOn;
    }),
    rememberedState: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.rememberedState;
    }),
    encryptHistory: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.encryptHistory;
    }),
    flash: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.flash;
    })
  });
}
async function createInertiaApp({
  id = "app",
  resolve,
  setup,
  title,
  progress: progress2 = {},
  page: page2,
  render,
  defaults = {}
}) {
  config.replace(defaults);
  const isServer = typeof window === "undefined";
  const useScriptElementForInitialPage = config.get("future.useScriptElementForInitialPage");
  const initialPage = page2 || getInitialPageFromDOM(id, useScriptElementForInitialPage);
  const resolveComponent = (name) => Promise.resolve(resolve(name)).then((module) => module.default || module);
  let head = [];
  const vueApp = await Promise.all([
    resolveComponent(initialPage.component),
    router.decryptHistory().catch(() => {
    })
  ]).then(([initialComponent]) => {
    const props = {
      initialPage,
      initialComponent,
      resolveComponent,
      titleCallback: title
    };
    if (isServer) {
      const ssrSetup = setup;
      return ssrSetup({
        el: null,
        App: app_default,
        props: { ...props, onHeadUpdate: (elements) => head = elements },
        plugin
      });
    }
    const csrSetup = setup;
    return csrSetup({
      el: document.getElementById(id),
      App: app_default,
      props,
      plugin
    });
  });
  if (!isServer && progress2) {
    setupProgress(progress2);
  }
  if (isServer && render) {
    const element = () => {
      if (!useScriptElementForInitialPage) {
        return h("div", {
          id,
          "data-page": JSON.stringify(initialPage),
          innerHTML: vueApp ? render(vueApp) : ""
        });
      }
      return [
        h("script", {
          "data-page": id,
          type: "application/json",
          innerHTML: JSON.stringify(initialPage).replace(/\//g, "\\/")
        }),
        h("div", {
          id,
          innerHTML: vueApp ? render(vueApp) : ""
        })
      ];
    };
    const body = await render(
      createSSRApp({
        render: () => element()
      })
    );
    return { head, body };
  }
}
defineComponent({
  name: "Deferred",
  props: {
    data: {
      type: [String, Array],
      required: true
    }
  },
  render() {
    var _a, _b;
    const keys = Array.isArray(this.$props.data) ? this.$props.data : [this.$props.data];
    if (!this.$slots.fallback) {
      throw new Error("`<Deferred>` requires a `<template #fallback>` slot");
    }
    return keys.every((key2) => this.$page.props[key2] !== void 0) ? (_b = (_a = this.$slots).default) == null ? void 0 : _b.call(_a) : this.$slots.fallback();
  }
});
var noop = () => void 0;
defineComponent({
  name: "Form",
  slots: Object,
  props: {
    action: {
      type: [String, Object],
      default: ""
    },
    method: {
      type: String,
      default: "get"
    },
    headers: {
      type: Object,
      default: () => ({})
    },
    queryStringArrayFormat: {
      type: String,
      default: "brackets"
    },
    errorBag: {
      type: [String, null],
      default: null
    },
    showProgress: {
      type: Boolean,
      default: true
    },
    transform: {
      type: Function,
      default: (data) => data
    },
    options: {
      type: Object,
      default: () => ({})
    },
    resetOnError: {
      type: [Boolean, Array],
      default: false
    },
    resetOnSuccess: {
      type: [Boolean, Array],
      default: false
    },
    setDefaultsOnSuccess: {
      type: Boolean,
      default: false
    },
    onCancelToken: {
      type: Function,
      default: noop
    },
    onBefore: {
      type: Function,
      default: noop
    },
    onStart: {
      type: Function,
      default: noop
    },
    onProgress: {
      type: Function,
      default: noop
    },
    onFinish: {
      type: Function,
      default: noop
    },
    onCancel: {
      type: Function,
      default: noop
    },
    onSuccess: {
      type: Function,
      default: noop
    },
    onError: {
      type: Function,
      default: noop
    },
    onSubmitComplete: {
      type: Function,
      default: noop
    },
    disableWhileProcessing: {
      type: Boolean,
      default: false
    },
    invalidateCacheTags: {
      type: [String, Array],
      default: () => []
    },
    validateFiles: {
      type: Boolean,
      default: false
    },
    validationTimeout: {
      type: Number,
      default: 1500
    },
    withAllErrors: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { slots, attrs, expose }) {
    const getTransformedData = () => {
      const [_url, data] = getUrlAndData();
      return props.transform(data);
    };
    const form = useForm({}).withPrecognition(
      () => method.value,
      () => getUrlAndData()[0]
    ).transform(getTransformedData).setValidationTimeout(props.validationTimeout);
    if (props.validateFiles) {
      form.validateFiles();
    }
    if (props.withAllErrors) {
      form.withAllErrors();
    }
    const formElement = ref();
    const method = computed(
      () => isUrlMethodPair(props.action) ? props.action.method : props.method.toLowerCase()
    );
    const isDirty = ref(false);
    const defaultData = ref(new FormData());
    const onFormUpdate = (event) => {
      isDirty.value = event.type === "reset" ? false : !isEqual(getData(), formDataToObject(defaultData.value));
    };
    const formEvents = ["input", "change", "reset"];
    onMounted(() => {
      defaultData.value = getFormData();
      form.defaults(getData());
      formEvents.forEach((e) => formElement.value.addEventListener(e, onFormUpdate));
    });
    watch(
      () => props.validateFiles,
      (value) => value ? form.validateFiles() : form.withoutFileValidation()
    );
    watch(
      () => props.validationTimeout,
      (value) => form.setValidationTimeout(value)
    );
    onBeforeUnmount(() => formEvents.forEach((e) => {
      var _a;
      return (_a = formElement.value) == null ? void 0 : _a.removeEventListener(e, onFormUpdate);
    }));
    const getFormData = (submitter) => new FormData(formElement.value, submitter);
    const getData = (submitter) => formDataToObject(getFormData(submitter));
    const getUrlAndData = (submitter) => {
      return mergeDataIntoQueryString(
        method.value,
        isUrlMethodPair(props.action) ? props.action.url : props.action,
        getData(submitter),
        props.queryStringArrayFormat
      );
    };
    const submit = (submitter) => {
      const maybeReset = (resetOption) => {
        if (!resetOption) {
          return;
        }
        if (resetOption === true) {
          reset();
        } else if (resetOption.length > 0) {
          reset(...resetOption);
        }
      };
      const submitOptions = {
        headers: props.headers,
        queryStringArrayFormat: props.queryStringArrayFormat,
        errorBag: props.errorBag,
        showProgress: props.showProgress,
        invalidateCacheTags: props.invalidateCacheTags,
        onCancelToken: props.onCancelToken,
        onBefore: props.onBefore,
        onStart: props.onStart,
        onProgress: props.onProgress,
        onFinish: props.onFinish,
        onCancel: props.onCancel,
        onSuccess: (...args) => {
          var _a, _b;
          (_a = props.onSuccess) == null ? void 0 : _a.call(props, ...args);
          (_b = props.onSubmitComplete) == null ? void 0 : _b.call(props, exposed);
          maybeReset(props.resetOnSuccess);
          if (props.setDefaultsOnSuccess === true) {
            defaults();
          }
        },
        onError: (...args) => {
          var _a;
          (_a = props.onError) == null ? void 0 : _a.call(props, ...args);
          maybeReset(props.resetOnError);
        },
        ...props.options
      };
      const [url, data] = getUrlAndData(submitter);
      form.transform(() => props.transform(data)).submit(method.value, url, submitOptions);
      form.transform(getTransformedData);
    };
    const reset = (...fields) => {
      resetFormFields(formElement.value, defaultData.value, fields);
      form.reset(...fields);
    };
    const clearErrors = (...fields) => {
      form.clearErrors(...fields);
    };
    const resetAndClearErrors = (...fields) => {
      clearErrors(...fields);
      reset(...fields);
    };
    const defaults = () => {
      defaultData.value = getFormData();
      isDirty.value = false;
    };
    const exposed = {
      get errors() {
        return form.errors;
      },
      get hasErrors() {
        return form.hasErrors;
      },
      get processing() {
        return form.processing;
      },
      get progress() {
        return form.progress;
      },
      get wasSuccessful() {
        return form.wasSuccessful;
      },
      get recentlySuccessful() {
        return form.recentlySuccessful;
      },
      get validating() {
        return form.validating;
      },
      clearErrors,
      resetAndClearErrors,
      setError: (fieldOrFields, maybeValue) => form.setError(typeof fieldOrFields === "string" ? { [fieldOrFields]: maybeValue } : fieldOrFields),
      get isDirty() {
        return isDirty.value;
      },
      reset,
      submit,
      defaults,
      getData,
      getFormData,
      // Precognition
      touch: form.touch,
      valid: form.valid,
      invalid: form.invalid,
      touched: form.touched,
      validate: (field, config2) => form.validate(...UseFormUtils.mergeHeadersForValidation(field, config2, props.headers)),
      validator: () => form.validator()
    };
    expose(exposed);
    return () => {
      return h(
        "form",
        {
          ...attrs,
          ref: formElement,
          action: isUrlMethodPair(props.action) ? props.action.url : props.action,
          method: method.value,
          onSubmit: (event) => {
            event.preventDefault();
            submit(event.submitter);
          },
          inert: props.disableWhileProcessing && form.processing
        },
        slots.default ? slots.default(exposed) : []
      );
    };
  }
});
var Head = defineComponent({
  props: {
    title: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      provider: this.$headManager.createProvider()
    };
  },
  beforeUnmount() {
    this.provider.disconnect();
  },
  methods: {
    isUnaryTag(node) {
      return typeof node.type === "string" && [
        "area",
        "base",
        "br",
        "col",
        "embed",
        "hr",
        "img",
        "input",
        "keygen",
        "link",
        "meta",
        "param",
        "source",
        "track",
        "wbr"
      ].indexOf(node.type) > -1;
    },
    renderTagStart(node) {
      node.props = node.props || {};
      node.props[this.provider.preferredAttribute()] = node.props["head-key"] !== void 0 ? node.props["head-key"] : "";
      const attrs = Object.keys(node.props).reduce((carry, name) => {
        const value = String(node.props[name]);
        if (["key", "head-key"].includes(name)) {
          return carry;
        } else if (value === "") {
          return carry + ` ${name}`;
        } else {
          return carry + ` ${name}="${escape(value)}"`;
        }
      }, "");
      return `<${String(node.type)}${attrs}>`;
    },
    renderTagChildren(node) {
      const { children } = node;
      if (typeof children === "string") {
        return children;
      }
      if (Array.isArray(children)) {
        return children.reduce((html, child) => {
          return html + this.renderTag(child);
        }, "");
      }
      return "";
    },
    isFunctionNode(node) {
      return typeof node.type === "function";
    },
    isComponentNode(node) {
      return typeof node.type === "object";
    },
    isCommentNode(node) {
      return /(comment|cmt)/i.test(node.type.toString());
    },
    isFragmentNode(node) {
      return /(fragment|fgt|symbol\(\))/i.test(node.type.toString());
    },
    isTextNode(node) {
      return /(text|txt)/i.test(node.type.toString());
    },
    renderTag(node) {
      if (this.isTextNode(node)) {
        return String(node.children);
      } else if (this.isFragmentNode(node)) {
        return "";
      } else if (this.isCommentNode(node)) {
        return "";
      }
      let html = this.renderTagStart(node);
      if (node.children) {
        html += this.renderTagChildren(node);
      }
      if (!this.isUnaryTag(node)) {
        html += `</${String(node.type)}>`;
      }
      return html;
    },
    addTitleElement(elements) {
      if (this.title && !elements.find((tag) => tag.startsWith("<title"))) {
        elements.push(`<title ${this.provider.preferredAttribute()}>${this.title}</title>`);
      }
      return elements;
    },
    renderNodes(nodes) {
      const elements = nodes.flatMap((node) => this.resolveNode(node)).map((node) => this.renderTag(node)).filter((node) => node);
      return this.addTitleElement(elements);
    },
    resolveNode(node) {
      if (this.isFunctionNode(node)) {
        return this.resolveNode(node.type());
      } else if (this.isComponentNode(node)) {
        console.warn(`Using components in the <Head> component is not supported.`);
        return [];
      } else if (this.isTextNode(node) && node.children) {
        return node;
      } else if (this.isFragmentNode(node) && node.children) {
        return node.children.flatMap((child) => this.resolveNode(child));
      } else if (this.isCommentNode(node)) {
        return [];
      } else {
        return node;
      }
    }
  },
  render() {
    this.provider.update(this.renderNodes(this.$slots.default ? this.$slots.default() : []));
  }
});
var head_default = Head;
var resolveHTMLElement = (value, fallback) => {
  if (!value) {
    return fallback;
  }
  if (typeof value === "string") {
    return document.querySelector(value);
  }
  if (typeof value === "function") {
    return value() || null;
  }
  return fallback;
};
defineComponent({
  name: "InfiniteScroll",
  slots: Object,
  props: {
    data: {
      type: String,
      required: true
    },
    buffer: {
      type: Number,
      default: 0
    },
    onlyNext: {
      type: Boolean,
      default: false
    },
    onlyPrevious: {
      type: Boolean,
      default: false
    },
    as: {
      type: String,
      default: "div"
    },
    manual: {
      type: Boolean,
      default: false
    },
    manualAfter: {
      type: Number,
      default: 0
    },
    preserveUrl: {
      type: Boolean,
      default: false
    },
    reverse: {
      type: Boolean,
      default: false
    },
    autoScroll: {
      type: Boolean,
      default: void 0
    },
    itemsElement: {
      type: [String, Function, Object],
      default: null
    },
    startElement: {
      type: [String, Function, Object],
      default: null
    },
    endElement: {
      type: [String, Function, Object],
      default: null
    }
  },
  inheritAttrs: false,
  setup(props, { slots, attrs, expose }) {
    const itemsElementRef = ref(null);
    const startElementRef = ref(null);
    const endElementRef = ref(null);
    const itemsElement = computed(
      () => resolveHTMLElement(props.itemsElement, itemsElementRef.value)
    );
    const scrollableParent = computed(() => getScrollableParent(itemsElement.value));
    const startElement = computed(
      () => resolveHTMLElement(props.startElement, startElementRef.value)
    );
    const endElement = computed(() => resolveHTMLElement(props.endElement, endElementRef.value));
    const loadingPrevious = ref(false);
    const loadingNext = ref(false);
    const requestCount = ref(0);
    const {
      dataManager,
      elementManager,
      flush: flushInfiniteScroll
    } = useInfiniteScroll({
      // Data
      getPropName: () => props.data,
      inReverseMode: () => props.reverse,
      shouldFetchNext: () => !props.onlyPrevious,
      shouldFetchPrevious: () => !props.onlyNext,
      shouldPreserveUrl: () => props.preserveUrl,
      // Elements
      getTriggerMargin: () => props.buffer,
      getStartElement: () => startElement.value,
      getEndElement: () => endElement.value,
      getItemsElement: () => itemsElement.value,
      getScrollableParent: () => scrollableParent.value,
      // Request callbacks
      onBeforePreviousRequest: () => loadingPrevious.value = true,
      onBeforeNextRequest: () => loadingNext.value = true,
      onCompletePreviousRequest: () => {
        requestCount.value = dataManager.getRequestCount();
        loadingPrevious.value = false;
      },
      onCompleteNextRequest: () => {
        requestCount.value = dataManager.getRequestCount();
        loadingNext.value = false;
      }
    });
    requestCount.value = dataManager.getRequestCount();
    const autoLoad = computed(() => !manualMode.value);
    const manualMode = computed(
      () => props.manual || props.manualAfter > 0 && requestCount.value >= props.manualAfter
    );
    const scrollToBottom = () => {
      if (scrollableParent.value) {
        scrollableParent.value.scrollTo({
          top: scrollableParent.value.scrollHeight,
          behavior: "instant"
        });
      } else {
        window.scrollTo({
          top: document.body.scrollHeight,
          behavior: "instant"
        });
      }
    };
    onMounted(() => {
      elementManager.setupObservers();
      elementManager.processServerLoadedElements(dataManager.getLastLoadedPage());
      const shouldAutoScroll = props.autoScroll !== void 0 ? props.autoScroll : props.reverse;
      if (shouldAutoScroll) {
        scrollToBottom();
      }
      if (autoLoad.value) {
        elementManager.enableTriggers();
      }
    });
    onUnmounted(flushInfiniteScroll);
    watch(
      () => [autoLoad.value, props.onlyNext, props.onlyPrevious],
      ([enabled]) => {
        enabled ? elementManager.enableTriggers() : elementManager.disableTriggers();
      }
    );
    expose({
      fetchNext: dataManager.fetchNext,
      fetchPrevious: dataManager.fetchPrevious,
      hasPrevious: dataManager.hasPrevious,
      hasNext: dataManager.hasNext
    });
    return () => {
      var _a, _b, _c;
      const renderElements = [];
      const sharedExposed = {
        loadingPrevious: loadingPrevious.value,
        loadingNext: loadingNext.value,
        hasPrevious: dataManager.hasPrevious(),
        hasNext: dataManager.hasNext()
      };
      if (!props.startElement) {
        const headerAutoMode = autoLoad.value && !props.onlyNext;
        const exposedPrevious = {
          loading: loadingPrevious.value,
          fetch: dataManager.fetchPrevious,
          autoMode: headerAutoMode,
          manualMode: !headerAutoMode,
          hasMore: dataManager.hasPrevious(),
          ...sharedExposed
        };
        renderElements.push(
          h(
            "div",
            { ref: startElementRef },
            slots.previous ? slots.previous(exposedPrevious) : loadingPrevious.value ? (_a = slots.loading) == null ? void 0 : _a.call(slots, exposedPrevious) : void 0
          )
        );
      }
      renderElements.push(
        h(
          props.as,
          { ...attrs, ref: itemsElementRef },
          (_b = slots.default) == null ? void 0 : _b.call(slots, {
            loading: loadingPrevious.value || loadingNext.value,
            loadingPrevious: loadingPrevious.value,
            loadingNext: loadingNext.value
          })
        )
      );
      if (!props.endElement) {
        const footerAutoMode = autoLoad.value && !props.onlyPrevious;
        const exposedNext = {
          loading: loadingNext.value,
          fetch: dataManager.fetchNext,
          autoMode: footerAutoMode,
          manualMode: !footerAutoMode,
          hasMore: dataManager.hasNext(),
          ...sharedExposed
        };
        renderElements.push(
          h(
            "div",
            { ref: endElementRef },
            slots.next ? slots.next(exposedNext) : loadingNext.value ? (_c = slots.loading) == null ? void 0 : _c.call(slots, exposedNext) : void 0
          )
        );
      }
      return h(Fragment, {}, props.reverse ? [...renderElements].reverse() : renderElements);
    };
  }
});
var noop2 = () => {
};
var Link = defineComponent({
  name: "Link",
  props: {
    as: {
      type: [String, Object],
      default: "a"
    },
    data: {
      type: Object,
      default: () => ({})
    },
    href: {
      type: [String, Object],
      default: ""
    },
    method: {
      type: String,
      default: "get"
    },
    replace: {
      type: Boolean,
      default: false
    },
    preserveScroll: {
      type: [Boolean, String, Function],
      default: false
    },
    preserveState: {
      type: [Boolean, String, Function],
      default: null
    },
    preserveUrl: {
      type: Boolean,
      default: false
    },
    only: {
      type: Array,
      default: () => []
    },
    except: {
      type: Array,
      default: () => []
    },
    headers: {
      type: Object,
      default: () => ({})
    },
    queryStringArrayFormat: {
      type: String,
      default: "brackets"
    },
    async: {
      type: Boolean,
      default: false
    },
    prefetch: {
      type: [Boolean, String, Array],
      default: false
    },
    cacheFor: {
      type: [Number, String, Array],
      default: 0
    },
    onStart: {
      type: Function,
      default: noop2
    },
    onProgress: {
      type: Function,
      default: noop2
    },
    onFinish: {
      type: Function,
      default: noop2
    },
    onBefore: {
      type: Function,
      default: noop2
    },
    onCancel: {
      type: Function,
      default: noop2
    },
    onSuccess: {
      type: Function,
      default: noop2
    },
    onError: {
      type: Function,
      default: noop2
    },
    onCancelToken: {
      type: Function,
      default: noop2
    },
    onPrefetching: {
      type: Function,
      default: noop2
    },
    onPrefetched: {
      type: Function,
      default: noop2
    },
    cacheTags: {
      type: [String, Array],
      default: () => []
    },
    viewTransition: {
      type: [Boolean, Object],
      default: false
    }
  },
  setup(props, { slots, attrs }) {
    const inFlightCount = ref(0);
    const hoverTimeout = ref();
    const prefetchModes = computed(() => {
      if (props.prefetch === true) {
        return ["hover"];
      }
      if (props.prefetch === false) {
        return [];
      }
      if (Array.isArray(props.prefetch)) {
        return props.prefetch;
      }
      return [props.prefetch];
    });
    const cacheForValue = computed(() => {
      if (props.cacheFor !== 0) {
        return props.cacheFor;
      }
      if (prefetchModes.value.length === 1 && prefetchModes.value[0] === "click") {
        return 0;
      }
      return config.get("prefetch.cacheFor");
    });
    onMounted(() => {
      if (prefetchModes.value.includes("mount")) {
        prefetch();
      }
    });
    onUnmounted(() => {
      clearTimeout(hoverTimeout.value);
    });
    const method = computed(
      () => isUrlMethodPair(props.href) ? props.href.method : (props.method ?? "get").toLowerCase()
    );
    const as = computed(() => {
      if (typeof props.as !== "string" || props.as.toLowerCase() !== "a") {
        return props.as;
      }
      return method.value !== "get" ? "button" : props.as.toLowerCase();
    });
    const mergeDataArray = computed(
      () => mergeDataIntoQueryString(
        method.value,
        isUrlMethodPair(props.href) ? props.href.url : props.href,
        props.data || {},
        props.queryStringArrayFormat
      )
    );
    const href = computed(() => mergeDataArray.value[0]);
    const data = computed(() => mergeDataArray.value[1]);
    const elProps = computed(() => {
      if (as.value === "button") {
        return { type: "button" };
      }
      if (as.value === "a" || typeof as.value !== "string") {
        return { href: href.value };
      }
      return {};
    });
    const baseParams = computed(() => ({
      data: data.value,
      method: method.value,
      replace: props.replace,
      preserveScroll: props.preserveScroll,
      preserveState: props.preserveState ?? method.value !== "get",
      preserveUrl: props.preserveUrl,
      only: props.only,
      except: props.except,
      headers: props.headers,
      async: props.async
    }));
    const visitParams = computed(() => ({
      ...baseParams.value,
      viewTransition: props.viewTransition,
      onCancelToken: props.onCancelToken,
      onBefore: props.onBefore,
      onStart: (visit) => {
        var _a;
        inFlightCount.value++;
        (_a = props.onStart) == null ? void 0 : _a.call(props, visit);
      },
      onProgress: props.onProgress,
      onFinish: (visit) => {
        var _a;
        inFlightCount.value--;
        (_a = props.onFinish) == null ? void 0 : _a.call(props, visit);
      },
      onCancel: props.onCancel,
      onSuccess: props.onSuccess,
      onError: props.onError
    }));
    const prefetch = () => {
      router.prefetch(
        href.value,
        {
          ...baseParams.value,
          onPrefetching: props.onPrefetching,
          onPrefetched: props.onPrefetched
        },
        {
          cacheFor: cacheForValue.value,
          cacheTags: props.cacheTags
        }
      );
    };
    const regularEvents = {
      onClick: (event) => {
        if (shouldIntercept(event)) {
          event.preventDefault();
          router.visit(href.value, visitParams.value);
        }
      }
    };
    const prefetchHoverEvents = {
      onMouseenter: () => {
        hoverTimeout.value = setTimeout(() => {
          prefetch();
        }, config.get("prefetch.hoverDelay"));
      },
      onMouseleave: () => {
        clearTimeout(hoverTimeout.value);
      },
      onClick: regularEvents.onClick
    };
    const prefetchClickEvents = {
      onMousedown: (event) => {
        if (shouldIntercept(event)) {
          event.preventDefault();
          prefetch();
        }
      },
      onKeydown: (event) => {
        if (shouldNavigate(event)) {
          event.preventDefault();
          prefetch();
        }
      },
      onMouseup: (event) => {
        if (shouldIntercept(event)) {
          event.preventDefault();
          router.visit(href.value, visitParams.value);
        }
      },
      onKeyup: (event) => {
        if (shouldNavigate(event)) {
          event.preventDefault();
          router.visit(href.value, visitParams.value);
        }
      },
      onClick: (event) => {
        if (shouldIntercept(event)) {
          event.preventDefault();
        }
      }
    };
    return () => {
      return h(
        as.value,
        {
          ...attrs,
          ...elProps.value,
          "data-loading": inFlightCount.value > 0 ? "" : void 0,
          ...(() => {
            if (prefetchModes.value.includes("hover")) {
              return prefetchHoverEvents;
            }
            if (prefetchModes.value.includes("click")) {
              return prefetchClickEvents;
            }
            return regularEvents;
          })()
        },
        slots
      );
    };
  }
});
var link_default = Link;
defineComponent({
  name: "WhenVisible",
  slots: Object,
  props: {
    data: {
      type: [String, Array]
    },
    params: {
      type: Object
    },
    buffer: {
      type: Number,
      default: 0
    },
    as: {
      type: String,
      default: "div"
    },
    always: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      loaded: false,
      fetching: false,
      observer: null
    };
  },
  unmounted() {
    var _a;
    (_a = this.observer) == null ? void 0 : _a.disconnect();
  },
  computed: {
    keys() {
      return this.data ? Array.isArray(this.data) ? this.data : [this.data] : [];
    }
  },
  created() {
    const page2 = usePage();
    this.$watch(
      () => this.keys.map((key2) => page2.props[key2]),
      () => {
        const exists = this.keys.length > 0 && this.keys.every((key2) => page2.props[key2] !== void 0);
        this.loaded = exists;
        if (exists && !this.always) {
          return;
        }
        this.$nextTick(this.registerObserver);
      },
      { immediate: true }
    );
  },
  methods: {
    registerObserver() {
      var _a;
      (_a = this.observer) == null ? void 0 : _a.disconnect();
      this.observer = new IntersectionObserver(
        (entries) => {
          if (!entries[0].isIntersecting) {
            return;
          }
          if (this.fetching) {
            return;
          }
          if (!this.always && this.loaded) {
            return;
          }
          this.fetching = true;
          const reloadParams = this.getReloadParams();
          router.reload({
            ...reloadParams,
            onStart: (e) => {
              var _a2;
              this.fetching = true;
              (_a2 = reloadParams.onStart) == null ? void 0 : _a2.call(reloadParams, e);
            },
            onFinish: (e) => {
              var _a2, _b;
              this.loaded = true;
              this.fetching = false;
              (_a2 = reloadParams.onFinish) == null ? void 0 : _a2.call(reloadParams, e);
              if (!this.always) {
                (_b = this.observer) == null ? void 0 : _b.disconnect();
              }
            }
          });
        },
        {
          rootMargin: `${this.$props.buffer}px`
        }
      );
      this.observer.observe(this.$el.nextSibling);
    },
    getReloadParams() {
      const reloadParams = { ...this.$props.params };
      if (this.$props.data) {
        reloadParams.only = Array.isArray(this.$props.data) ? this.$props.data : [this.$props.data];
      }
      return reloadParams;
    }
  },
  render() {
    const els = [];
    if (this.$props.always || !this.loaded) {
      els.push(h(this.$props.as));
    }
    if (!this.loaded) {
      els.push(this.$slots.fallback ? this.$slots.fallback({}) : null);
    } else if (this.$slots.default) {
      els.push(this.$slots.default({ fetching: this.fetching }));
    }
    return els;
  }
});
var config = config$1.extend({});
async function resolvePageComponent(path, pages) {
  for (const p of Array.isArray(path) ? path : [path]) {
    const page2 = pages[p];
    if (typeof page2 === "undefined") {
      continue;
    }
    return typeof page2 === "function" ? page2() : page2;
  }
  throw new Error(`Page not found: ${path}`);
}
const appName = "FraudshieldBD";
createServer(
  (page2) => createInertiaApp({
    page: page2,
    render: renderToString,
    title: (title) => title ? `${title} - ${appName}` : appName,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, /* @__PURE__ */ Object.assign({ "./Pages/About.vue": () => import("./assets/About-1Z0R8NtQ.js"), "./Pages/Api/Documentation.vue": () => import("./assets/Documentation-C3pxmEYE.js"), "./Pages/Auth/Login.vue": () => import("./assets/Login-D1CgSrTC.js"), "./Pages/Auth/Register.vue": () => import("./assets/Register-iPg57RRW.js"), "./Pages/Dashboard/Index.vue": () => import("./assets/Index-D87cFxuM.js"), "./Pages/Download.vue": () => import("./assets/Download-BgiuXk4g.js"), "./Pages/Pricing/Index.vue": () => import("./assets/Index-DdRwGvfn.js"), "./Pages/Welcome.vue": () => import("./assets/Welcome-gJU7t4v2.js") })),
    setup({ App: App2, props, plugin: plugin2 }) {
      return createSSRApp({ render: () => h(App2, props) }).use(plugin2).component("Head", head_default).component("Link", link_default);
    }
  })
);
export {
  usePage as a,
  head_default as h,
  link_default as l,
  useForm as u
};
