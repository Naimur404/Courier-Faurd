import { defineComponent, ref, unref, withCtx, createVNode, createTextVNode, createBlock, openBlock, Fragment, renderList, toDisplayString, useSSRContext } from "vue";
import { ssrRenderComponent, ssrRenderClass, ssrRenderList, ssrRenderAttr, ssrInterpolate } from "vue/server-renderer";
import { h as head_default, l as link_default } from "../ssr.js";
import { _ as _sfc_main$2 } from "./Card-DfyUDDxC.js";
import { _ as _sfc_main$1 } from "./Button-Dm3W5gAW.js";
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
  __name: "Documentation",
  __ssrInlineRender: true,
  setup(__props) {
    const mobileNavOpen = ref(false);
    const navLinks = [
      { href: "#quick-start", label: "Quick Start" },
      { href: "#authentication", label: "Authentication" },
      { href: "#endpoints", label: "API Endpoints" },
      { href: "#rate-limiting", label: "Rate Limiting" },
      { href: "#errors", label: "Error Handling" },
      { href: "#examples", label: "Code Examples" }
    ];
    const codeExamples = {
      curl: `curl -X POST "https://api.fraudshield.bd/api/customer/check" \\
  -H "Authorization: Bearer YOUR_API_KEY" \\
  -H "Content-Type: application/json" \\
  -d '{"phone": "01700000000"}'`,
      php: `<?php
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.fraudshield.bd/api/customer/check',
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer YOUR_API_KEY',
        'Content-Type: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode(['phone' => '01700000000']),
    CURLOPT_RETURNTRANSFER => true
]);
$response = curl_exec($ch);
$data = json_decode($response, true);`,
      javascript: `fetch('https://api.fraudshield.bd/api/customer/check', {
    method: 'POST',
    headers: {
        'Authorization': 'Bearer YOUR_API_KEY',
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ phone: '01700000000' })
})
.then(response => response.json())
.then(data => console.log(data));`,
      python: `import requests

response = requests.post(
    'https://api.fraudshield.bd/api/customer/check',
    headers={
        'Authorization': 'Bearer YOUR_API_KEY',
        'Content-Type': 'application/json'
    },
    json={'phone': '01700000000'}
)
data = response.json()`
    };
    const activeTab = ref("curl");
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(head_default), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title${_scopeId}>API Documentation - FraudShield</title><meta name="description" content="Complete API documentation for FraudShield Courier Fraud Detection System. Learn how to integrate our API into your applications."${_scopeId}><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, "API Documentation - FraudShield"),
              createVNode("meta", {
                name: "description",
                content: "Complete API documentation for FraudShield Courier Fraud Detection System. Learn how to integrate our API into your applications."
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
      _push(`<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"><div class="text-center mb-12"><h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4"><i class="fas fa-code text-primary mr-3"></i> API Documentation </h1><p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto"> Integrate FraudShield&#39;s powerful courier fraud detection into your applications with our RESTful API. </p><div class="mt-6 flex flex-col sm:flex-row justify-center gap-4 sm:space-x-4">`);
      _push(ssrRenderComponent(unref(link_default), { href: "/login" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(ssrRenderComponent(_sfc_main$1, { class: "bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 transition-colors" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<i class="fas fa-key mr-2"${_scopeId2}></i>Get API Key `);
                } else {
                  return [
                    createVNode("i", { class: "fas fa-key mr-2" }),
                    createTextVNode("Get API Key ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
          } else {
            return [
              createVNode(_sfc_main$1, { class: "bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 transition-colors" }, {
                default: withCtx(() => [
                  createVNode("i", { class: "fas fa-key mr-2" }),
                  createTextVNode("Get API Key ")
                ]),
                _: 1
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<a href="#quick-start">`);
      _push(ssrRenderComponent(_sfc_main$1, {
        variant: "outline",
        class: "bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-6 py-3 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<i class="fas fa-rocket mr-2"${_scopeId}></i>Quick Start `);
          } else {
            return [
              createVNode("i", { class: "fas fa-rocket mr-2" }),
              createTextVNode("Quick Start ")
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</a></div></div><div class="lg:hidden mb-6"><button class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 flex items-center justify-between"><span class="text-lg font-semibold text-gray-900 dark:text-white">Documentation Menu</span><i class="${ssrRenderClass(["fas text-gray-600 dark:text-gray-300 transition-transform", mobileNavOpen.value ? "fa-chevron-up" : "fa-chevron-down"])}"></i></button>`);
      if (mobileNavOpen.value) {
        _push(`<div class="mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4"><nav class="space-y-2"><!--[-->`);
        ssrRenderList(navLinks, (link) => {
          _push(`<a${ssrRenderAttr("href", link.href)} class="block text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary py-2 border-b border-gray-200 dark:border-gray-700 last:border-0">${ssrInterpolate(link.label)}</a>`);
        });
        _push(`<!--]--></nav></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div class="grid grid-cols-1 lg:grid-cols-4 gap-8"><div class="lg:col-span-1 hidden lg:block">`);
      _push(ssrRenderComponent(_sfc_main$2, { class: "sticky top-8 p-6" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4"${_scopeId}>Documentation</h3><nav class="space-y-2"${_scopeId}><!--[-->`);
            ssrRenderList(navLinks, (link) => {
              _push2(`<a${ssrRenderAttr("href", link.href)} class="block text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary py-1"${_scopeId}>${ssrInterpolate(link.label)}</a>`);
            });
            _push2(`<!--]--></nav>`);
          } else {
            return [
              createVNode("h3", { class: "text-lg font-semibold text-gray-900 dark:text-white mb-4" }, "Documentation"),
              createVNode("nav", { class: "space-y-2" }, [
                (openBlock(), createBlock(Fragment, null, renderList(navLinks, (link) => {
                  return createVNode("a", {
                    key: link.href,
                    href: link.href,
                    class: "block text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary py-1"
                  }, toDisplayString(link.label), 9, ["href"]);
                }), 64))
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div><div class="col-span-1 lg:col-span-3 space-y-8">`);
      _push(ssrRenderComponent(_sfc_main$2, {
        id: "quick-start",
        class: "p-8"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4"${_scopeId}><i class="fas fa-rocket text-primary mr-2"${_scopeId}></i>Quick Start </h2><p class="text-gray-600 dark:text-gray-300 mb-6"${_scopeId}> Get started with the FraudShield API in minutes. Follow these simple steps to make your first API call. </p><div class="space-y-4"${_scopeId}><div class="border-l-4 border-primary pl-4"${_scopeId}><h4 class="font-semibold text-gray-900 dark:text-white"${_scopeId}>1. Get Your API Key</h4><p class="text-gray-600 dark:text-gray-300"${_scopeId}>Register an account and generate your API key from the dashboard.</p></div><div class="border-l-4 border-primary pl-4"${_scopeId}><h4 class="font-semibold text-gray-900 dark:text-white"${_scopeId}>2. Make Your First Request</h4><p class="text-gray-600 dark:text-gray-300"${_scopeId}>Use your API key to authenticate and check customer fraud data.</p></div><div class="border-l-4 border-primary pl-4"${_scopeId}><h4 class="font-semibold text-gray-900 dark:text-white"${_scopeId}>3. Handle the Response</h4><p class="text-gray-600 dark:text-gray-300"${_scopeId}>Process the JSON response to integrate fraud detection into your workflow.</p></div></div>`);
          } else {
            return [
              createVNode("h2", { class: "text-2xl font-bold text-gray-900 dark:text-white mb-4" }, [
                createVNode("i", { class: "fas fa-rocket text-primary mr-2" }),
                createTextVNode("Quick Start ")
              ]),
              createVNode("p", { class: "text-gray-600 dark:text-gray-300 mb-6" }, " Get started with the FraudShield API in minutes. Follow these simple steps to make your first API call. "),
              createVNode("div", { class: "space-y-4" }, [
                createVNode("div", { class: "border-l-4 border-primary pl-4" }, [
                  createVNode("h4", { class: "font-semibold text-gray-900 dark:text-white" }, "1. Get Your API Key"),
                  createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "Register an account and generate your API key from the dashboard.")
                ]),
                createVNode("div", { class: "border-l-4 border-primary pl-4" }, [
                  createVNode("h4", { class: "font-semibold text-gray-900 dark:text-white" }, "2. Make Your First Request"),
                  createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "Use your API key to authenticate and check customer fraud data.")
                ]),
                createVNode("div", { class: "border-l-4 border-primary pl-4" }, [
                  createVNode("h4", { class: "font-semibold text-gray-900 dark:text-white" }, "3. Handle the Response"),
                  createVNode("p", { class: "text-gray-600 dark:text-gray-300" }, "Process the JSON response to integrate fraud detection into your workflow.")
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$2, {
        id: "authentication",
        class: "p-8"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4"${_scopeId}><i class="fas fa-shield-alt text-primary mr-2"${_scopeId}></i>Authentication </h2><p class="text-gray-600 dark:text-gray-300 mb-6"${_scopeId}> The FraudShield API uses API keys for authentication. Include your API key in every request. </p><div class="space-y-6"${_scopeId}><div${_scopeId}><h4 class="font-semibold text-gray-900 dark:text-white mb-2"${_scopeId}>Authorization Header (Recommended)</h4><div class="bg-gray-900 rounded-lg p-4 overflow-x-auto"${_scopeId}><code class="text-green-400"${_scopeId}>Authorization: Bearer YOUR_API_KEY</code></div></div><div${_scopeId}><h4 class="font-semibold text-gray-900 dark:text-white mb-2"${_scopeId}>X-API-Key Header</h4><div class="bg-gray-900 rounded-lg p-4 overflow-x-auto"${_scopeId}><code class="text-green-400"${_scopeId}>X-API-Key: YOUR_API_KEY</code></div></div><div${_scopeId}><h4 class="font-semibold text-gray-900 dark:text-white mb-2"${_scopeId}>Query Parameter</h4><div class="bg-gray-900 rounded-lg p-4 overflow-x-auto"${_scopeId}><code class="text-green-400"${_scopeId}>?api_key=YOUR_API_KEY</code></div></div></div>`);
          } else {
            return [
              createVNode("h2", { class: "text-2xl font-bold text-gray-900 dark:text-white mb-4" }, [
                createVNode("i", { class: "fas fa-shield-alt text-primary mr-2" }),
                createTextVNode("Authentication ")
              ]),
              createVNode("p", { class: "text-gray-600 dark:text-gray-300 mb-6" }, " The FraudShield API uses API keys for authentication. Include your API key in every request. "),
              createVNode("div", { class: "space-y-6" }, [
                createVNode("div", null, [
                  createVNode("h4", { class: "font-semibold text-gray-900 dark:text-white mb-2" }, "Authorization Header (Recommended)"),
                  createVNode("div", { class: "bg-gray-900 rounded-lg p-4 overflow-x-auto" }, [
                    createVNode("code", { class: "text-green-400" }, "Authorization: Bearer YOUR_API_KEY")
                  ])
                ]),
                createVNode("div", null, [
                  createVNode("h4", { class: "font-semibold text-gray-900 dark:text-white mb-2" }, "X-API-Key Header"),
                  createVNode("div", { class: "bg-gray-900 rounded-lg p-4 overflow-x-auto" }, [
                    createVNode("code", { class: "text-green-400" }, "X-API-Key: YOUR_API_KEY")
                  ])
                ]),
                createVNode("div", null, [
                  createVNode("h4", { class: "font-semibold text-gray-900 dark:text-white mb-2" }, "Query Parameter"),
                  createVNode("div", { class: "bg-gray-900 rounded-lg p-4 overflow-x-auto" }, [
                    createVNode("code", { class: "text-green-400" }, "?api_key=YOUR_API_KEY")
                  ])
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$2, {
        id: "endpoints",
        class: "p-8"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4"${_scopeId}><i class="fas fa-sitemap text-primary mr-2"${_scopeId}></i>API Endpoints </h2><div class="space-y-8"${_scopeId}><div class="border-b border-gray-200 dark:border-gray-700 pb-8"${_scopeId}><div class="flex flex-col sm:flex-row sm:items-center mb-4 gap-2"${_scopeId}><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium w-fit"${_scopeId}>POST</span><code class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200 text-sm break-all"${_scopeId}>/api/customer/check</code></div><h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2"${_scopeId}>Check Customer Fraud Data</h4><p class="text-gray-600 dark:text-gray-300 mb-4"${_scopeId}> Retrieve comprehensive fraud detection data for a customer using their phone number. </p><div class="space-y-4"${_scopeId}><div${_scopeId}><h5 class="font-medium text-gray-900 dark:text-white mb-2"${_scopeId}>Request Body</h5><div class="bg-gray-900 rounded-lg p-4 overflow-x-auto"${_scopeId}><pre class="text-green-400"${_scopeId}><code${_scopeId}>{
  &quot;phone&quot;: &quot;01700000000&quot;
}</code></pre></div></div><div${_scopeId}><h5 class="font-medium text-gray-900 dark:text-white mb-2"${_scopeId}>Response</h5><div class="bg-gray-900 rounded-lg p-4 overflow-x-auto"${_scopeId}><pre class="text-green-400"${_scopeId}><code${_scopeId}>{
  &quot;success&quot;: true,
  &quot;data&quot;: {
    &quot;phone&quot;: &quot;01700000000&quot;,
    &quot;total_parcels&quot;: 45,
    &quot;successful_deliveries&quot;: 42,
    &quot;failed_deliveries&quot;: 3,
    &quot;success_rate&quot;: 93.33,
    &quot;fraud_risk&quot;: &quot;low&quot;,
    &quot;last_delivery&quot;: &quot;2025-10-03&quot;,
    &quot;courier_history&quot;: [
      {
        &quot;courier&quot;: &quot;Steadfast&quot;,
        &quot;total&quot;: 25,
        &quot;successful&quot;: 24,
        &quot;failed&quot;: 1
      }
    ]
  }
}</code></pre></div></div></div></div><div class="border-b border-gray-200 dark:border-gray-700 pb-8"${_scopeId}><div class="flex flex-col sm:flex-row sm:items-center mb-4 gap-2"${_scopeId}><span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium w-fit"${_scopeId}>GET</span><code class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200 text-sm break-all"${_scopeId}>/api/customer/list</code></div><h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2"${_scopeId}>List Customer Data</h4><p class="text-gray-600 dark:text-gray-300 mb-4"${_scopeId}> Retrieve a paginated list of customer fraud data with filtering options. </p><div class="space-y-4"${_scopeId}><div${_scopeId}><h5 class="font-medium text-gray-900 dark:text-white mb-2"${_scopeId}>Query Parameters</h5><div class="space-y-2"${_scopeId}><div class="flex flex-col sm:flex-row sm:items-center gap-2"${_scopeId}><code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-sm w-fit"${_scopeId}>page</code><span class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId}>Page number (default: 1)</span></div><div class="flex flex-col sm:flex-row sm:items-center gap-2"${_scopeId}><code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-sm w-fit"${_scopeId}>limit</code><span class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId}>Items per page (default: 20, max: 100)</span></div><div class="flex flex-col sm:flex-row sm:items-center gap-2"${_scopeId}><code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-sm w-fit"${_scopeId}>risk_level</code><span class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId}>Filter by risk level (low, medium, high)</span></div></div></div></div></div><div${_scopeId}><div class="flex flex-col sm:flex-row sm:items-center mb-4 gap-2"${_scopeId}><span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium w-fit"${_scopeId}>GET</span><code class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200 text-sm break-all"${_scopeId}>/api/usage/stats</code></div><h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2"${_scopeId}>Get Usage Statistics</h4><p class="text-gray-600 dark:text-gray-300 mb-4"${_scopeId}> Retrieve your API usage statistics and remaining quota. </p><div class="space-y-4"${_scopeId}><div${_scopeId}><h5 class="font-medium text-gray-900 dark:text-white mb-2"${_scopeId}>Response</h5><div class="bg-gray-900 rounded-lg p-4 overflow-x-auto"${_scopeId}><pre class="text-green-400"${_scopeId}><code${_scopeId}>{
  &quot;success&quot;: true,
  &quot;data&quot;: {
    &quot;today_usage&quot;: 25,
    &quot;monthly_usage&quot;: 450,
    &quot;daily_limit&quot;: 1000,
    &quot;remaining_today&quot;: 975,
    &quot;subscription&quot;: {
      &quot;plan_name&quot;: &quot;Professional&quot;,
      &quot;expires_at&quot;: &quot;2025-11-04T00:00:00Z&quot;,
      &quot;days_remaining&quot;: 31
    }
  }
}</code></pre></div></div></div></div></div>`);
          } else {
            return [
              createVNode("h2", { class: "text-2xl font-bold text-gray-900 dark:text-white mb-4" }, [
                createVNode("i", { class: "fas fa-sitemap text-primary mr-2" }),
                createTextVNode("API Endpoints ")
              ]),
              createVNode("div", { class: "space-y-8" }, [
                createVNode("div", { class: "border-b border-gray-200 dark:border-gray-700 pb-8" }, [
                  createVNode("div", { class: "flex flex-col sm:flex-row sm:items-center mb-4 gap-2" }, [
                    createVNode("span", { class: "bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium w-fit" }, "POST"),
                    createVNode("code", { class: "bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200 text-sm break-all" }, "/api/customer/check")
                  ]),
                  createVNode("h4", { class: "text-lg font-semibold text-gray-900 dark:text-white mb-2" }, "Check Customer Fraud Data"),
                  createVNode("p", { class: "text-gray-600 dark:text-gray-300 mb-4" }, " Retrieve comprehensive fraud detection data for a customer using their phone number. "),
                  createVNode("div", { class: "space-y-4" }, [
                    createVNode("div", null, [
                      createVNode("h5", { class: "font-medium text-gray-900 dark:text-white mb-2" }, "Request Body"),
                      createVNode("div", { class: "bg-gray-900 rounded-lg p-4 overflow-x-auto" }, [
                        createVNode("pre", { class: "text-green-400" }, [
                          createVNode("code", null, '{\n  "phone": "01700000000"\n}')
                        ])
                      ])
                    ]),
                    createVNode("div", null, [
                      createVNode("h5", { class: "font-medium text-gray-900 dark:text-white mb-2" }, "Response"),
                      createVNode("div", { class: "bg-gray-900 rounded-lg p-4 overflow-x-auto" }, [
                        createVNode("pre", { class: "text-green-400" }, [
                          createVNode("code", null, '{\n  "success": true,\n  "data": {\n    "phone": "01700000000",\n    "total_parcels": 45,\n    "successful_deliveries": 42,\n    "failed_deliveries": 3,\n    "success_rate": 93.33,\n    "fraud_risk": "low",\n    "last_delivery": "2025-10-03",\n    "courier_history": [\n      {\n        "courier": "Steadfast",\n        "total": 25,\n        "successful": 24,\n        "failed": 1\n      }\n    ]\n  }\n}')
                        ])
                      ])
                    ])
                  ])
                ]),
                createVNode("div", { class: "border-b border-gray-200 dark:border-gray-700 pb-8" }, [
                  createVNode("div", { class: "flex flex-col sm:flex-row sm:items-center mb-4 gap-2" }, [
                    createVNode("span", { class: "bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium w-fit" }, "GET"),
                    createVNode("code", { class: "bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200 text-sm break-all" }, "/api/customer/list")
                  ]),
                  createVNode("h4", { class: "text-lg font-semibold text-gray-900 dark:text-white mb-2" }, "List Customer Data"),
                  createVNode("p", { class: "text-gray-600 dark:text-gray-300 mb-4" }, " Retrieve a paginated list of customer fraud data with filtering options. "),
                  createVNode("div", { class: "space-y-4" }, [
                    createVNode("div", null, [
                      createVNode("h5", { class: "font-medium text-gray-900 dark:text-white mb-2" }, "Query Parameters"),
                      createVNode("div", { class: "space-y-2" }, [
                        createVNode("div", { class: "flex flex-col sm:flex-row sm:items-center gap-2" }, [
                          createVNode("code", { class: "bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-sm w-fit" }, "page"),
                          createVNode("span", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "Page number (default: 1)")
                        ]),
                        createVNode("div", { class: "flex flex-col sm:flex-row sm:items-center gap-2" }, [
                          createVNode("code", { class: "bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-sm w-fit" }, "limit"),
                          createVNode("span", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "Items per page (default: 20, max: 100)")
                        ]),
                        createVNode("div", { class: "flex flex-col sm:flex-row sm:items-center gap-2" }, [
                          createVNode("code", { class: "bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-sm w-fit" }, "risk_level"),
                          createVNode("span", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "Filter by risk level (low, medium, high)")
                        ])
                      ])
                    ])
                  ])
                ]),
                createVNode("div", null, [
                  createVNode("div", { class: "flex flex-col sm:flex-row sm:items-center mb-4 gap-2" }, [
                    createVNode("span", { class: "bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium w-fit" }, "GET"),
                    createVNode("code", { class: "bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200 text-sm break-all" }, "/api/usage/stats")
                  ]),
                  createVNode("h4", { class: "text-lg font-semibold text-gray-900 dark:text-white mb-2" }, "Get Usage Statistics"),
                  createVNode("p", { class: "text-gray-600 dark:text-gray-300 mb-4" }, " Retrieve your API usage statistics and remaining quota. "),
                  createVNode("div", { class: "space-y-4" }, [
                    createVNode("div", null, [
                      createVNode("h5", { class: "font-medium text-gray-900 dark:text-white mb-2" }, "Response"),
                      createVNode("div", { class: "bg-gray-900 rounded-lg p-4 overflow-x-auto" }, [
                        createVNode("pre", { class: "text-green-400" }, [
                          createVNode("code", null, '{\n  "success": true,\n  "data": {\n    "today_usage": 25,\n    "monthly_usage": 450,\n    "daily_limit": 1000,\n    "remaining_today": 975,\n    "subscription": {\n      "plan_name": "Professional",\n      "expires_at": "2025-11-04T00:00:00Z",\n      "days_remaining": 31\n    }\n  }\n}')
                        ])
                      ])
                    ])
                  ])
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$2, {
        id: "rate-limiting",
        class: "p-8"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4"${_scopeId}><i class="fas fa-tachometer-alt text-primary mr-2"${_scopeId}></i>Rate Limiting </h2><p class="text-gray-600 dark:text-gray-300 mb-6"${_scopeId}> API requests are rate-limited based on your subscription plan and API key settings. </p><div class="space-y-4"${_scopeId}><div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4"${_scopeId}><h4 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-2"${_scopeId}>Rate Limit Headers</h4><p class="text-yellow-700 dark:text-yellow-300 text-sm mb-3"${_scopeId}>Every response includes rate limit information in headers:</p><div class="space-y-1 text-sm"${_scopeId}><div${_scopeId}><code class="bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded"${_scopeId}>X-RateLimit-Limit</code> - Your rate limit per minute</div><div${_scopeId}><code class="bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded"${_scopeId}>X-RateLimit-Remaining</code> - Remaining requests in current window</div><div${_scopeId}><code class="bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded"${_scopeId}>X-RateLimit-Reset</code> - Time when the rate limit resets</div></div></div><div class="grid grid-cols-1 md:grid-cols-3 gap-4"${_scopeId}><div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4"${_scopeId}><h5 class="font-semibold text-gray-900 dark:text-white"${_scopeId}>Basic Plan</h5><p class="text-2xl font-bold text-primary"${_scopeId}>60/min</p><p class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId}>60 requests per minute</p></div><div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4"${_scopeId}><h5 class="font-semibold text-gray-900 dark:text-white"${_scopeId}>Professional</h5><p class="text-2xl font-bold text-primary"${_scopeId}>300/min</p><p class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId}>300 requests per minute</p></div><div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4"${_scopeId}><h5 class="font-semibold text-gray-900 dark:text-white"${_scopeId}>Enterprise</h5><p class="text-2xl font-bold text-primary"${_scopeId}>1000/min</p><p class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId}>1000 requests per minute</p></div></div></div>`);
          } else {
            return [
              createVNode("h2", { class: "text-2xl font-bold text-gray-900 dark:text-white mb-4" }, [
                createVNode("i", { class: "fas fa-tachometer-alt text-primary mr-2" }),
                createTextVNode("Rate Limiting ")
              ]),
              createVNode("p", { class: "text-gray-600 dark:text-gray-300 mb-6" }, " API requests are rate-limited based on your subscription plan and API key settings. "),
              createVNode("div", { class: "space-y-4" }, [
                createVNode("div", { class: "bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4" }, [
                  createVNode("h4", { class: "font-semibold text-yellow-800 dark:text-yellow-200 mb-2" }, "Rate Limit Headers"),
                  createVNode("p", { class: "text-yellow-700 dark:text-yellow-300 text-sm mb-3" }, "Every response includes rate limit information in headers:"),
                  createVNode("div", { class: "space-y-1 text-sm" }, [
                    createVNode("div", null, [
                      createVNode("code", { class: "bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded" }, "X-RateLimit-Limit"),
                      createTextVNode(" - Your rate limit per minute")
                    ]),
                    createVNode("div", null, [
                      createVNode("code", { class: "bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded" }, "X-RateLimit-Remaining"),
                      createTextVNode(" - Remaining requests in current window")
                    ]),
                    createVNode("div", null, [
                      createVNode("code", { class: "bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded" }, "X-RateLimit-Reset"),
                      createTextVNode(" - Time when the rate limit resets")
                    ])
                  ])
                ]),
                createVNode("div", { class: "grid grid-cols-1 md:grid-cols-3 gap-4" }, [
                  createVNode("div", { class: "border border-gray-200 dark:border-gray-700 rounded-lg p-4" }, [
                    createVNode("h5", { class: "font-semibold text-gray-900 dark:text-white" }, "Basic Plan"),
                    createVNode("p", { class: "text-2xl font-bold text-primary" }, "60/min"),
                    createVNode("p", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "60 requests per minute")
                  ]),
                  createVNode("div", { class: "border border-gray-200 dark:border-gray-700 rounded-lg p-4" }, [
                    createVNode("h5", { class: "font-semibold text-gray-900 dark:text-white" }, "Professional"),
                    createVNode("p", { class: "text-2xl font-bold text-primary" }, "300/min"),
                    createVNode("p", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "300 requests per minute")
                  ]),
                  createVNode("div", { class: "border border-gray-200 dark:border-gray-700 rounded-lg p-4" }, [
                    createVNode("h5", { class: "font-semibold text-gray-900 dark:text-white" }, "Enterprise"),
                    createVNode("p", { class: "text-2xl font-bold text-primary" }, "1000/min"),
                    createVNode("p", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "1000 requests per minute")
                  ])
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$2, {
        id: "errors",
        class: "p-8"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4"${_scopeId}><i class="fas fa-exclamation-triangle text-primary mr-2"${_scopeId}></i>Error Handling </h2><p class="text-gray-600 dark:text-gray-300 mb-6"${_scopeId}> The API uses conventional HTTP response codes to indicate success or failure of requests. </p><div class="space-y-3"${_scopeId}><div class="flex items-center flex-wrap gap-2"${_scopeId}><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center"${_scopeId}>200</span><span class="text-gray-900 dark:text-white font-medium"${_scopeId}>OK</span><span class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId}>- Request succeeded</span></div><div class="flex items-center flex-wrap gap-2"${_scopeId}><span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center"${_scopeId}>400</span><span class="text-gray-900 dark:text-white font-medium"${_scopeId}>Bad Request</span><span class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId}>- Invalid parameters</span></div><div class="flex items-center flex-wrap gap-2"${_scopeId}><span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center"${_scopeId}>401</span><span class="text-gray-900 dark:text-white font-medium"${_scopeId}>Unauthorized</span><span class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId}>- Invalid or missing API key</span></div><div class="flex items-center flex-wrap gap-2"${_scopeId}><span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center"${_scopeId}>429</span><span class="text-gray-900 dark:text-white font-medium"${_scopeId}>Too Many Requests</span><span class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId}>- Rate limit exceeded</span></div><div class="flex items-center flex-wrap gap-2"${_scopeId}><span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center"${_scopeId}>500</span><span class="text-gray-900 dark:text-white font-medium"${_scopeId}>Server Error</span><span class="text-gray-600 dark:text-gray-300 text-sm"${_scopeId}>- Something went wrong on our end</span></div></div>`);
          } else {
            return [
              createVNode("h2", { class: "text-2xl font-bold text-gray-900 dark:text-white mb-4" }, [
                createVNode("i", { class: "fas fa-exclamation-triangle text-primary mr-2" }),
                createTextVNode("Error Handling ")
              ]),
              createVNode("p", { class: "text-gray-600 dark:text-gray-300 mb-6" }, " The API uses conventional HTTP response codes to indicate success or failure of requests. "),
              createVNode("div", { class: "space-y-3" }, [
                createVNode("div", { class: "flex items-center flex-wrap gap-2" }, [
                  createVNode("span", { class: "bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center" }, "200"),
                  createVNode("span", { class: "text-gray-900 dark:text-white font-medium" }, "OK"),
                  createVNode("span", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "- Request succeeded")
                ]),
                createVNode("div", { class: "flex items-center flex-wrap gap-2" }, [
                  createVNode("span", { class: "bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center" }, "400"),
                  createVNode("span", { class: "text-gray-900 dark:text-white font-medium" }, "Bad Request"),
                  createVNode("span", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "- Invalid parameters")
                ]),
                createVNode("div", { class: "flex items-center flex-wrap gap-2" }, [
                  createVNode("span", { class: "bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center" }, "401"),
                  createVNode("span", { class: "text-gray-900 dark:text-white font-medium" }, "Unauthorized"),
                  createVNode("span", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "- Invalid or missing API key")
                ]),
                createVNode("div", { class: "flex items-center flex-wrap gap-2" }, [
                  createVNode("span", { class: "bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center" }, "429"),
                  createVNode("span", { class: "text-gray-900 dark:text-white font-medium" }, "Too Many Requests"),
                  createVNode("span", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "- Rate limit exceeded")
                ]),
                createVNode("div", { class: "flex items-center flex-wrap gap-2" }, [
                  createVNode("span", { class: "bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center" }, "500"),
                  createVNode("span", { class: "text-gray-900 dark:text-white font-medium" }, "Server Error"),
                  createVNode("span", { class: "text-gray-600 dark:text-gray-300 text-sm" }, "- Something went wrong on our end")
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$2, {
        id: "examples",
        class: "p-8"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4"${_scopeId}><i class="fas fa-code text-primary mr-2"${_scopeId}></i>Code Examples </h2><p class="text-gray-600 dark:text-gray-300 mb-6"${_scopeId}> Copy and paste these examples to get started quickly. </p><div class="flex flex-wrap gap-2 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2"${_scopeId}><!--[-->`);
            ssrRenderList(codeExamples, (_2, key) => {
              _push2(`<button class="${ssrRenderClass([
                "px-4 py-2 rounded-lg text-sm font-medium transition-colors",
                activeTab.value === key ? "bg-primary text-white" : "bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600"
              ])}"${_scopeId}>${ssrInterpolate(key.charAt(0).toUpperCase() + key.slice(1))}</button>`);
            });
            _push2(`<!--]--></div><div class="bg-gray-900 rounded-lg p-4 overflow-x-auto"${_scopeId}><pre class="text-green-400 text-sm"${_scopeId}><code${_scopeId}>${ssrInterpolate(codeExamples[activeTab.value])}</code></pre></div>`);
          } else {
            return [
              createVNode("h2", { class: "text-2xl font-bold text-gray-900 dark:text-white mb-4" }, [
                createVNode("i", { class: "fas fa-code text-primary mr-2" }),
                createTextVNode("Code Examples ")
              ]),
              createVNode("p", { class: "text-gray-600 dark:text-gray-300 mb-6" }, " Copy and paste these examples to get started quickly. "),
              createVNode("div", { class: "flex flex-wrap gap-2 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2" }, [
                (openBlock(), createBlock(Fragment, null, renderList(codeExamples, (_2, key) => {
                  return createVNode("button", {
                    key,
                    onClick: ($event) => activeTab.value = key,
                    class: [
                      "px-4 py-2 rounded-lg text-sm font-medium transition-colors",
                      activeTab.value === key ? "bg-primary text-white" : "bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600"
                    ]
                  }, toDisplayString(key.charAt(0).toUpperCase() + key.slice(1)), 11, ["onClick"]);
                }), 64))
              ]),
              createVNode("div", { class: "bg-gray-900 rounded-lg p-4 overflow-x-auto" }, [
                createVNode("pre", { class: "text-green-400 text-sm" }, [
                  createVNode("code", null, toDisplayString(codeExamples[activeTab.value]), 1)
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div></div><div class="text-center mt-12">`);
      _push(ssrRenderComponent(unref(link_default), { href: "/" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(ssrRenderComponent(_sfc_main$1, {
              variant: "outline",
              class: "px-6 py-3"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`<i class="fas fa-arrow-left mr-2"${_scopeId2}></i>Back to Home `);
                } else {
                  return [
                    createVNode("i", { class: "fas fa-arrow-left mr-2" }),
                    createTextVNode("Back to Home ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
          } else {
            return [
              createVNode(_sfc_main$1, {
                variant: "outline",
                class: "px-6 py-3"
              }, {
                default: withCtx(() => [
                  createVNode("i", { class: "fas fa-arrow-left mr-2" }),
                  createTextVNode("Back to Home ")
                ]),
                _: 1
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div></div></div><!--]-->`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Api/Documentation.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
