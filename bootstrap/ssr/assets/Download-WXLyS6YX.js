import { defineComponent, ref, onMounted, onUnmounted, unref, withCtx, createVNode, createBlock, createCommentVNode, createTextVNode, openBlock, toDisplayString, Fragment, renderList, useSSRContext } from "vue";
import { ssrRenderComponent, ssrRenderStyle, ssrRenderList, ssrRenderAttr, ssrInterpolate, ssrRenderClass } from "vue/server-renderer";
import { h as head_default, l as link_default } from "../ssr.js";
import { _ as _sfc_main$2 } from "./Button-Dm3W5gAW.js";
import { _ as _sfc_main$1 } from "./Card-DfyUDDxC.js";
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
  __name: "Download",
  __ssrInlineRender: true,
  props: {
    downloadCount: {},
    lastDownloadTime: {},
    downloadUrl: {},
    qrCodeUrl: {}
  },
  setup(__props) {
    const props = __props;
    const isDownloading = ref(false);
    const currentDeviceIndex = ref(0);
    let deviceRotationInterval = null;
    const screenshots = [
      "/assets/Sc1.png",
      "/assets/Sc2.png",
      "/assets/Sc3.png"
    ];
    const features = [
      {
        icon: "shield-alt",
        title: "Courier Fraud Detection",
        description: "Identify and prevent courier fraud with our advanced detection system"
      },
      {
        icon: "history",
        title: "Delivery History Check",
        description: "View complete delivery history and track courier reliability"
      },
      {
        icon: "chart-line",
        title: "Success Rate Analysis",
        description: "Check courier success rates and make informed decisions"
      },
      {
        icon: "star",
        title: "Customer Feedback System",
        description: "Read and share feedback on courier services"
      }
    ];
    const benefits = [
      {
        icon: "bolt",
        title: "Fast & Reliable",
        description: "Quick and accurate detection of potential courier fraud"
      },
      {
        icon: "lock",
        title: "Secure",
        description: "Your data is protected with enterprise-grade security"
      },
      {
        icon: "sync",
        title: "Regular Updates",
        description: "Constantly improving with frequent updates and new features"
      }
    ];
    const getDeviceStyle = (index) => {
      const positions = [
        { left: "25%", scale: 0.8, zIndex: 1 },
        { left: "50%", scale: 1, zIndex: 10 },
        { left: "75%", scale: 0.8, zIndex: 1 }
      ];
      const position = (index - currentDeviceIndex.value + 3) % 3;
      return {
        left: positions[position].left,
        transform: `translateX(-50%) scale(${positions[position].scale})`,
        zIndex: positions[position].zIndex
      };
    };
    const handleDownload = async () => {
      var _a;
      isDownloading.value = true;
      try {
        const response = await fetch("/api/track-download-intent", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": ((_a = document.querySelector('meta[name="csrf-token"]')) == null ? void 0 : _a.getAttribute("content")) || ""
          }
        });
        const data = await response.json();
        if (data.success) {
          window.location.href = `${props.downloadUrl}?track_id=${data.track_id}`;
        } else {
          window.location.href = props.downloadUrl;
        }
      } catch (error) {
        console.error("Error:", error);
        window.location.href = props.downloadUrl;
      } finally {
        setTimeout(() => {
          isDownloading.value = false;
        }, 2e3);
      }
    };
    onMounted(() => {
      deviceRotationInterval = setInterval(() => {
        currentDeviceIndex.value = (currentDeviceIndex.value + 1) % 3;
      }, 3e3);
    });
    onUnmounted(() => {
      if (deviceRotationInterval) {
        clearInterval(deviceRotationInterval);
      }
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(head_default), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title data-v-92121e49${_scopeId}>Download FraudShield App - কুরিয়ার ফ্রড ডিটেকশন অ্যাপ</title><meta name="description" content="Download FraudShield app for Android - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। ডেলিভারি ইতিহাস দেখুন এবং বিশ্বসযোগ্যতা যাচাই করুন।" data-v-92121e49${_scopeId}><meta name="keywords" content="FraudShield, courier fraud, delivery check, android app, কুরিয়ার, ফ্রড" data-v-92121e49${_scopeId}><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" data-v-92121e49${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, "Download FraudShield App - কুরিয়ার ফ্রড ডিটেকশন অ্যাপ"),
              createVNode("meta", {
                name: "description",
                content: "Download FraudShield app for Android - কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। ডেলিভারি ইতিহাস দেখুন এবং বিশ্বসযোগ্যতা যাচাই করুন।"
              }),
              createVNode("meta", {
                name: "keywords",
                content: "FraudShield, courier fraud, delivery check, android app, কুরিয়ার, ফ্রড"
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
      _push(`<div class="min-h-screen bg-[#121212] text-gray-100" data-v-92121e49><section class="relative overflow-hidden" data-v-92121e49><div class="absolute inset-0 bg-gradient-to-b from-purple-900/20 to-transparent pointer-events-none" data-v-92121e49></div><div class="absolute top-20 left-10 w-64 h-64 bg-purple-600/10 rounded-full blur-3xl animate-pulse" data-v-92121e49></div><div class="absolute top-40 right-10 w-72 h-72 bg-purple-800/10 rounded-full blur-3xl animate-pulse" style="${ssrRenderStyle({ "animation-delay": "1s" })}" data-v-92121e49></div><div class="bg-[#121212] py-3 px-4 flex justify-center" data-v-92121e49>`);
      _push(ssrRenderComponent(unref(link_default), {
        href: "/",
        class: "flex items-center gap-2 px-5 py-1.5 text-sm font-medium text-white bg-white/10 rounded-full transition-all duration-300 hover:bg-white/20"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<i class="fas fa-home" data-v-92121e49${_scopeId}></i><span data-v-92121e49${_scopeId}>Home</span>`);
          } else {
            return [
              createVNode("i", { class: "fas fa-home" }),
              createVNode("span", null, "Home")
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div><div class="relative container mx-auto px-4 pt-24 pb-64 text-center" data-v-92121e49><div class="flex flex-col items-center" data-v-92121e49><div class="relative mb-6 animate-bounce" style="${ssrRenderStyle({ "animation-duration": "3s" })}" data-v-92121e49><div class="absolute inset-0 bg-purple-600/30 rounded-3xl blur-xl" data-v-92121e49></div><img src="/assets/banner.jpg" alt="FraudShield Logo" class="relative w-24 h-24 object-cover rounded-2xl border-2 border-white/20 shadow-lg" data-v-92121e49></div><h1 class="text-4xl md:text-5xl font-bold mb-3 text-white" data-v-92121e49>FraudShield</h1><p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-10" data-v-92121e49> কুরিয়ার ফ্রড ডিটেকশন সিস্টেম - ডেলিভারি ইতিহাস দেখুন এবং বিশ্বসযোগ্যতা যাচাই করুন </p></div></div></section><section class="relative -mt-52 mb-24" data-v-92121e49><div class="container mx-auto px-4" data-v-92121e49><div class="relative h-[500px] md:h-[580px] overflow-visible" data-v-92121e49><!--[-->`);
      ssrRenderList(screenshots, (screenshot, index) => {
        _push(`<div class="device absolute w-[250px] md:w-[270px] rounded-[36px] overflow-hidden shadow-2xl bg-[#121212] border-[10px] border-[#383838] transition-all duration-500" style="${ssrRenderStyle(getDeviceStyle(index))}" data-v-92121e49><div class="device-screen w-full h-full rounded-[28px] overflow-hidden" data-v-92121e49><img${ssrRenderAttr("src", screenshot)}${ssrRenderAttr("alt", `FraudShield Screenshot ${index + 1}`)} class="w-full h-full object-cover" data-v-92121e49></div></div>`);
      });
      _push(`<!--]--></div></div></section><section class="mb-20" data-v-92121e49><div class="container mx-auto px-4" data-v-92121e49>`);
      _push(ssrRenderComponent(_sfc_main$1, { class: "p-10 text-center relative overflow-hidden max-w-3xl mx-auto bg-[#282828]/80 backdrop-blur-md border border-white/5" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="absolute -inset-x-10 -bottom-10 h-40 bg-purple-600/10 blur-3xl" data-v-92121e49${_scopeId}></div><h2 class="text-2xl font-bold mb-4 text-white relative z-10" data-v-92121e49${_scopeId}>Download Our Mobile App Now</h2><p class="text-gray-300 mb-8 max-w-lg mx-auto relative z-10" data-v-92121e49${_scopeId}> Experience the best courier fraud detection system with our FraudShield mobile application </p><div class="flex flex-col md:flex-row items-center justify-center gap-8 relative z-10" data-v-92121e49${_scopeId}><div class="flex-1" data-v-92121e49${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$2, {
              onClick: handleDownload,
              disabled: isDownloading.value,
              class: "group relative inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-white bg-purple-600 rounded-full overflow-hidden transition-all duration-300 hover:bg-purple-700 hover:shadow-[0_0_15px_rgba(130,87,230,0.5)] active:scale-95 disabled:opacity-70"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  if (isDownloading.value) {
                    _push3(`<svg class="w-5 h-5 mr-3 -ml-1 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" data-v-92121e49${_scopeId2}><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" data-v-92121e49${_scopeId2}></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" data-v-92121e49${_scopeId2}></path></svg>`);
                  } else {
                    _push3(`<!---->`);
                  }
                  _push3(`<i class="fas fa-download mr-2" data-v-92121e49${_scopeId2}></i> Download APK `);
                } else {
                  return [
                    isDownloading.value ? (openBlock(), createBlock("svg", {
                      key: 0,
                      class: "w-5 h-5 mr-3 -ml-1 animate-spin",
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
                    createVNode("i", { class: "fas fa-download mr-2" }),
                    createTextVNode(" Download APK ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div><div class="flex-1 flex flex-col items-center" data-v-92121e49${_scopeId}><div class="p-2 bg-white rounded-xl mb-3 transform transition hover:rotate-3 hover:scale-105 duration-300" data-v-92121e49${_scopeId}><img${ssrRenderAttr("src", __props.qrCodeUrl)} alt="QR Code for Download" class="w-32 h-32" data-v-92121e49${_scopeId}></div><p class="text-gray-400 text-sm" data-v-92121e49${_scopeId}>Or scan this QR code with your device</p></div></div>`);
          } else {
            return [
              createVNode("div", { class: "absolute -inset-x-10 -bottom-10 h-40 bg-purple-600/10 blur-3xl" }),
              createVNode("h2", { class: "text-2xl font-bold mb-4 text-white relative z-10" }, "Download Our Mobile App Now"),
              createVNode("p", { class: "text-gray-300 mb-8 max-w-lg mx-auto relative z-10" }, " Experience the best courier fraud detection system with our FraudShield mobile application "),
              createVNode("div", { class: "flex flex-col md:flex-row items-center justify-center gap-8 relative z-10" }, [
                createVNode("div", { class: "flex-1" }, [
                  createVNode(_sfc_main$2, {
                    onClick: handleDownload,
                    disabled: isDownloading.value,
                    class: "group relative inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-white bg-purple-600 rounded-full overflow-hidden transition-all duration-300 hover:bg-purple-700 hover:shadow-[0_0_15px_rgba(130,87,230,0.5)] active:scale-95 disabled:opacity-70"
                  }, {
                    default: withCtx(() => [
                      isDownloading.value ? (openBlock(), createBlock("svg", {
                        key: 0,
                        class: "w-5 h-5 mr-3 -ml-1 animate-spin",
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
                      createVNode("i", { class: "fas fa-download mr-2" }),
                      createTextVNode(" Download APK ")
                    ]),
                    _: 1
                  }, 8, ["disabled"])
                ]),
                createVNode("div", { class: "flex-1 flex flex-col items-center" }, [
                  createVNode("div", { class: "p-2 bg-white rounded-xl mb-3 transform transition hover:rotate-3 hover:scale-105 duration-300" }, [
                    createVNode("img", {
                      src: __props.qrCodeUrl,
                      alt: "QR Code for Download",
                      class: "w-32 h-32"
                    }, null, 8, ["src"])
                  ]),
                  createVNode("p", { class: "text-gray-400 text-sm" }, "Or scan this QR code with your device")
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div></section><section class="mb-20" data-v-92121e49><div class="container mx-auto px-4" data-v-92121e49><div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-v-92121e49>`);
      _push(ssrRenderComponent(_sfc_main$1, { class: "p-8 bg-[#282828]/80 backdrop-blur-md border border-white/5 transition-all duration-300 hover:shadow-[0_0_15px_rgba(130,87,230,0.5)] hover:-translate-y-1" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="flex flex-col items-center justify-center h-full" data-v-92121e49${_scopeId}><span class="text-4xl md:text-5xl font-bold text-purple-500 mb-2" data-v-92121e49${_scopeId}>${ssrInterpolate(__props.downloadCount.toLocaleString())}</span><span class="text-lg text-gray-300" data-v-92121e49${_scopeId}>Total Downloads</span></div>`);
          } else {
            return [
              createVNode("div", { class: "flex flex-col items-center justify-center h-full" }, [
                createVNode("span", { class: "text-4xl md:text-5xl font-bold text-purple-500 mb-2" }, toDisplayString(__props.downloadCount.toLocaleString()), 1),
                createVNode("span", { class: "text-lg text-gray-300" }, "Total Downloads")
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$1, { class: "p-8 bg-[#282828]/80 backdrop-blur-md border border-white/5 transition-all duration-300 hover:shadow-[0_0_15px_rgba(130,87,230,0.5)] hover:-translate-y-1" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="flex flex-col items-center justify-center h-full" data-v-92121e49${_scopeId}><span class="text-lg text-gray-300 mb-2" data-v-92121e49${_scopeId}>Last Download</span><span class="text-2xl md:text-3xl font-bold text-purple-500" data-v-92121e49${_scopeId}>${ssrInterpolate(__props.lastDownloadTime ?? "No downloads yet")}</span></div>`);
          } else {
            return [
              createVNode("div", { class: "flex flex-col items-center justify-center h-full" }, [
                createVNode("span", { class: "text-lg text-gray-300 mb-2" }, "Last Download"),
                createVNode("span", { class: "text-2xl md:text-3xl font-bold text-purple-500" }, toDisplayString(__props.lastDownloadTime ?? "No downloads yet"), 1)
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div></div></section><section class="mb-20" data-v-92121e49><div class="container mx-auto px-4" data-v-92121e49><h2 class="text-3xl font-bold text-center mb-12 text-white" data-v-92121e49><span class="inline-block relative" data-v-92121e49> Key Features <span class="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-purple-600 to-purple-400" data-v-92121e49></span></span></h2><div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-v-92121e49><!--[-->`);
      ssrRenderList(features, (feature) => {
        _push(ssrRenderComponent(_sfc_main$1, {
          key: feature.title,
          class: "p-6 flex items-center gap-4 bg-[#282828]/80 backdrop-blur-md border border-white/5 transition-all duration-300 hover:shadow-[0_0_15px_rgba(130,87,230,0.5)] hover:-translate-y-1"
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`<div class="flex-shrink-0 w-12 h-12 rounded-full bg-purple-600/20 flex items-center justify-center" data-v-92121e49${_scopeId}><i class="${ssrRenderClass(`fas fa-${feature.icon} text-xl text-purple-500`)}" data-v-92121e49${_scopeId}></i></div><div data-v-92121e49${_scopeId}><h3 class="text-lg font-semibold text-white mb-1" data-v-92121e49${_scopeId}>${ssrInterpolate(feature.title)}</h3><p class="text-gray-400 text-sm" data-v-92121e49${_scopeId}>${ssrInterpolate(feature.description)}</p></div>`);
            } else {
              return [
                createVNode("div", { class: "flex-shrink-0 w-12 h-12 rounded-full bg-purple-600/20 flex items-center justify-center" }, [
                  createVNode("i", {
                    class: `fas fa-${feature.icon} text-xl text-purple-500`
                  }, null, 2)
                ]),
                createVNode("div", null, [
                  createVNode("h3", { class: "text-lg font-semibold text-white mb-1" }, toDisplayString(feature.title), 1),
                  createVNode("p", { class: "text-gray-400 text-sm" }, toDisplayString(feature.description), 1)
                ])
              ];
            }
          }),
          _: 2
        }, _parent));
      });
      _push(`<!--]--></div></div></section><section class="mb-20" data-v-92121e49><div class="container mx-auto px-4" data-v-92121e49>`);
      _push(ssrRenderComponent(_sfc_main$1, { class: "p-8 md:p-12 relative overflow-hidden bg-[#282828]/80 backdrop-blur-md border border-white/5" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="absolute top-0 right-0 w-64 h-64 bg-purple-600/10 rounded-full blur-3xl" data-v-92121e49${_scopeId}></div><div class="relative z-10" data-v-92121e49${_scopeId}><h2 class="text-2xl md:text-3xl font-bold mb-8 text-center text-white" data-v-92121e49${_scopeId}>Why Choose FraudShield?</h2><div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-v-92121e49${_scopeId}><!--[-->`);
            ssrRenderList(benefits, (benefit) => {
              _push2(`<div class="flex flex-col items-center text-center" data-v-92121e49${_scopeId}><div class="w-16 h-16 rounded-full bg-purple-600/20 flex items-center justify-center mb-4" data-v-92121e49${_scopeId}><i class="${ssrRenderClass(`fas fa-${benefit.icon} text-2xl text-purple-500`)}" data-v-92121e49${_scopeId}></i></div><h3 class="text-lg font-semibold text-white mb-2" data-v-92121e49${_scopeId}>${ssrInterpolate(benefit.title)}</h3><p class="text-gray-400" data-v-92121e49${_scopeId}>${ssrInterpolate(benefit.description)}</p></div>`);
            });
            _push2(`<!--]--></div></div>`);
          } else {
            return [
              createVNode("div", { class: "absolute top-0 right-0 w-64 h-64 bg-purple-600/10 rounded-full blur-3xl" }),
              createVNode("div", { class: "relative z-10" }, [
                createVNode("h2", { class: "text-2xl md:text-3xl font-bold mb-8 text-center text-white" }, "Why Choose FraudShield?"),
                createVNode("div", { class: "grid grid-cols-1 md:grid-cols-3 gap-8" }, [
                  (openBlock(), createBlock(Fragment, null, renderList(benefits, (benefit) => {
                    return createVNode("div", {
                      key: benefit.title,
                      class: "flex flex-col items-center text-center"
                    }, [
                      createVNode("div", { class: "w-16 h-16 rounded-full bg-purple-600/20 flex items-center justify-center mb-4" }, [
                        createVNode("i", {
                          class: `fas fa-${benefit.icon} text-2xl text-purple-500`
                        }, null, 2)
                      ]),
                      createVNode("h3", { class: "text-lg font-semibold text-white mb-2" }, toDisplayString(benefit.title), 1),
                      createVNode("p", { class: "text-gray-400" }, toDisplayString(benefit.description), 1)
                    ]);
                  }), 64))
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div></section><div class="text-center text-gray-500 text-sm mb-12" data-v-92121e49><p data-v-92121e49>FraudShield v1.0.0 | Last updated: ${ssrInterpolate((/* @__PURE__ */ new Date()).toLocaleDateString("en-US", { year: "numeric", month: "long", day: "numeric" }))}</p></div><footer class="bg-gradient-to-r from-purple-800 to-purple-600 py-8 rounded-t-3xl" data-v-92121e49><div class="container mx-auto px-4 text-center" data-v-92121e49><p class="text-white/90" data-v-92121e49>© 2025 FraudShield. All rights reserved.</p><p class="text-white/70 text-sm mt-2" data-v-92121e49>Powered by Tyrodevs.com</p></div></footer></div><!--]-->`);
    };
  }
});
const _export_sfc = (sfc, props) => {
  const target = sfc.__vccOpts || sfc;
  for (const [key, val] of props) {
    target[key] = val;
  }
  return target;
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Download.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const Download = /* @__PURE__ */ _export_sfc(_sfc_main, [["__scopeId", "data-v-92121e49"]]);
export {
  Download as default
};
