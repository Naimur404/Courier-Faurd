<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/components/ui/Card.vue';
import Button from '@/components/ui/Button.vue';
import { ref, computed, watch } from 'vue';
import { Search, Users, Shield, Phone, Package, CheckCircle, XCircle, ChevronLeft, ChevronRight, Code, Eye, EyeOff, ArrowUpDown, ArrowUp, ArrowDown, X, Filter } from 'lucide-vue-next';

interface CustomerData {
    id: number;
    phone: string;
    count: number;
    data: {
        status: string;
        courierData?: {
            summary?: {
                total_parcel: number;
                success_parcel: number;
                cancelled_parcel: number;
                success_ratio: number;
            };
        };
    };
    created_at: string;
    updated_at: string;
}

const token = ref('');
const isLoading = ref(false);
const customers = ref<CustomerData[]>([]);
const totalRecords = ref(0);
const currentPage = ref(1);
const perPage = ref(25);
const serverPerPage = ref(100);
const serverPage = ref(1);
const error = ref<string | null>(null);
const rawResponse = ref<any>(null);

// Search & Sort
const searchQuery = ref('');
const sortField = ref<string>('id');
const sortDirection = ref<'asc' | 'desc'>('desc');

// Individual response modal
const selectedCustomer = ref<CustomerData | null>(null);
const showResponseModal = ref(false);

const totalPages = computed(() => Math.ceil(filteredCustomers.value.length / perPage.value));

// Filter customers by search query
const filteredCustomers = computed(() => {
    let result = [...customers.value];
    
    // Apply search filter
    if (searchQuery.value.trim()) {
        const query = searchQuery.value.toLowerCase();
        result = result.filter(c => 
            c.phone.toLowerCase().includes(query) ||
            c.id.toString().includes(query)
        );
    }
    
    // Apply sorting
    result.sort((a, b) => {
        let aVal: any, bVal: any;
        
        switch (sortField.value) {
            case 'id':
                aVal = a.id;
                bVal = b.id;
                break;
            case 'phone':
                aVal = a.phone;
                bVal = b.phone;
                break;
            case 'count':
                aVal = a.count;
                bVal = b.count;
                break;
            case 'total':
                aVal = getTotalParcels(a);
                bVal = getTotalParcels(b);
                break;
            case 'success':
                aVal = getSuccessParcels(a);
                bVal = getSuccessParcels(b);
                break;
            case 'cancelled':
                aVal = getCancelledParcels(a);
                bVal = getCancelledParcels(b);
                break;
            case 'ratio':
                aVal = getSuccessRatio(a);
                bVal = getSuccessRatio(b);
                break;
            default:
                aVal = a.id;
                bVal = b.id;
        }
        
        if (sortDirection.value === 'asc') {
            return aVal > bVal ? 1 : -1;
        } else {
            return aVal < bVal ? 1 : -1;
        }
    });
    
    return result;
});

// Paginated customers
const paginatedCustomers = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return filteredCustomers.value.slice(start, end);
});

// Reset to page 1 when search changes
watch(searchQuery, () => {
    currentPage.value = 1;
});

const toggleSort = (field: string) => {
    if (sortField.value === field) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = field;
        sortDirection.value = 'desc';
    }
    currentPage.value = 1;
};

const getSortIcon = (field: string) => {
    if (sortField.value !== field) return ArrowUpDown;
    return sortDirection.value === 'asc' ? ArrowUp : ArrowDown;
};

const showCustomerResponse = (customer: CustomerData) => {
    selectedCustomer.value = customer;
    showResponseModal.value = true;
};

const closeModal = () => {
    showResponseModal.value = false;
    selectedCustomer.value = null;
};

const fetchCustomers = async (page: number = 1) => {
    if (!token.value) {
        error.value = 'Please enter a valid token';
        return;
    }
    
    isLoading.value = true;
    error.value = null;
    
    try {
        const response = await fetch('/customer-data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
            body: JSON.stringify({ token: token.value, page: page }),
        });
        
        const data = await response.json();
        rawResponse.value = data;
        
        if (data.success) {
            customers.value = data.data || [];
            totalRecords.value = data.total || 0;
            serverPage.value = data.current_page || 1;
            serverPerPage.value = data.per_page || 100;
            currentPage.value = 1; // Reset client-side page
        } else {
            error.value = data.message || 'Failed to fetch customer data';
            customers.value = [];
        }
    } catch (err) {
        error.value = 'An error occurred while fetching data';
        rawResponse.value = { error: String(err) };
        customers.value = [];
    } finally {
        isLoading.value = false;
    }
};

// Navigate to different API page
const loadServerPage = (page: number) => {
    const maxServerPages = Math.ceil(totalRecords.value / serverPerPage.value);
    if (page >= 1 && page <= maxServerPages && !isLoading.value) {
        fetchCustomers(page);
    }
};

const goToPage = (page: number) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const getSuccessRatio = (customer: CustomerData): number => {
    return customer.data?.courierData?.summary?.success_ratio || 0;
};

const getTotalParcels = (customer: CustomerData): number => {
    return customer.data?.courierData?.summary?.total_parcel || 0;
};

const getSuccessParcels = (customer: CustomerData): number => {
    return customer.data?.courierData?.summary?.success_parcel || 0;
};

const getCancelledParcels = (customer: CustomerData): number => {
    return customer.data?.courierData?.summary?.cancelled_parcel || 0;
};

const getRiskClass = (ratio: number): string => {
    if (ratio >= 90) return 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400';
    if (ratio >= 70) return 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400';
    return 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400';
};

const formatJson = (obj: any): string => {
    return JSON.stringify(obj, null, 2);
};

const visiblePages = computed(() => {
    const pages: number[] = [];
    const start = Math.max(1, currentPage.value - 2);
    const end = Math.min(totalPages.value, currentPage.value + 2);
    
    for (let i = start; i <= end; i++) {
        pages.push(i);
    }
    return pages;
});
</script>

<template>
    <Head>
        <title>Customer Portal | FraudShield</title>
        <meta name="robots" content="noindex, nofollow" />
    </Head>
    
    <AppLayout>
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center justify-center gap-3">
                        <Users class="w-8 h-8 text-indigo-600" />
                        Customer Portal
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Access customer delivery data with your authentication token
                    </p>
                </div>
                
                <!-- Token Input -->
                <Card class="p-6 mb-8">
                    <form @submit.prevent="() => fetchCustomers(1)" class="flex gap-4">
                        <div class="flex-1">
                            <input 
                                type="password" 
                                v-model="token"
                                placeholder="Enter your authentication token"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                            />
                        </div>
                        <Button 
                            type="submit"
                            :disabled="isLoading"
                            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg flex items-center gap-2"
                        >
                            <Search class="w-4 h-4" />
                            <span v-if="isLoading">Loading...</span>
                            <span v-else>Load Data</span>
                        </Button>
                    </form>
                    
                    <p v-if="error" class="mt-3 text-red-500 text-sm">{{ error }}</p>
                </Card>
                
                <!-- Quick Stats -->
                <div v-if="customers.length > 0" class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                    <Card class="p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ totalRecords }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Total in DB</div>
                    </Card>
                    <Card class="p-4 text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ customers.length }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Loaded</div>
                    </Card>
                    <Card class="p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ filteredCustomers.length }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Filtered</div>
                    </Card>
                    <Card class="p-4 text-center">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ currentPage }} / {{ totalPages }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">View Page</div>
                    </Card>
                    <Card class="p-4 text-center">
                        <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">{{ serverPage }} / {{ Math.ceil(totalRecords / serverPerPage) }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">API Page</div>
                    </Card>
                </div>
                
                <!-- DataTable -->
                <Card v-if="customers.length > 0" class="p-6">
                    <!-- DataTable Header: Search & Per Page -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div class="flex items-center gap-2">
                            <Package class="w-5 h-5 text-indigo-600" />
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Customer Data</h2>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- Search Input -->
                            <div class="relative">
                                <Search class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                                <input 
                                    type="text"
                                    v-model="searchQuery"
                                    placeholder="Search by phone or ID..."
                                    class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-sm w-full sm:w-64"
                                />
                                <button 
                                    v-if="searchQuery"
                                    @click="searchQuery = ''"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                >
                                    <X class="w-4 h-4" />
                                </button>
                            </div>
                            
                            <!-- Per Page Select -->
                            <select 
                                v-model="perPage"
                                @change="currentPage = 1"
                                class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white text-sm"
                            >
                                <option :value="10">10 per page</option>
                                <option :value="25">25 per page</option>
                                <option :value="50">50 per page</option>
                                <option :value="100">100 per page</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Table -->
                    <div class="overflow-x-auto border dark:border-gray-700 rounded-lg">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th @click="toggleSort('id')" class="text-left py-3 px-4 font-semibold cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 select-none">
                                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                            ID
                                            <component :is="getSortIcon('id')" class="w-4 h-4" />
                                        </div>
                                    </th>
                                    <th @click="toggleSort('phone')" class="text-left py-3 px-4 font-semibold cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 select-none">
                                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                            Phone
                                            <component :is="getSortIcon('phone')" class="w-4 h-4" />
                                        </div>
                                    </th>
                                    <th @click="toggleSort('total')" class="text-center py-3 px-4 font-semibold cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 select-none">
                                        <div class="flex items-center justify-center gap-2 text-gray-600 dark:text-gray-400">
                                            Total
                                            <component :is="getSortIcon('total')" class="w-4 h-4" />
                                        </div>
                                    </th>
                                    <th @click="toggleSort('success')" class="text-center py-3 px-4 font-semibold cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 select-none">
                                        <div class="flex items-center justify-center gap-2 text-gray-600 dark:text-gray-400">
                                            Success
                                            <component :is="getSortIcon('success')" class="w-4 h-4" />
                                        </div>
                                    </th>
                                    <th @click="toggleSort('cancelled')" class="text-center py-3 px-4 font-semibold cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 select-none">
                                        <div class="flex items-center justify-center gap-2 text-gray-600 dark:text-gray-400">
                                            Cancelled
                                            <component :is="getSortIcon('cancelled')" class="w-4 h-4" />
                                        </div>
                                    </th>
                                    <th @click="toggleSort('ratio')" class="text-center py-3 px-4 font-semibold cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 select-none">
                                        <div class="flex items-center justify-center gap-2 text-gray-600 dark:text-gray-400">
                                            Rate
                                            <component :is="getSortIcon('ratio')" class="w-4 h-4" />
                                        </div>
                                    </th>
                                    <th @click="toggleSort('count')" class="text-center py-3 px-4 font-semibold cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 select-none">
                                        <div class="flex items-center justify-center gap-2 text-gray-600 dark:text-gray-400">
                                            Searches
                                            <component :is="getSortIcon('count')" class="w-4 h-4" />
                                        </div>
                                    </th>
                                    <th class="text-center py-3 px-4 font-semibold text-gray-600 dark:text-gray-400">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="customer in paginatedCustomers" :key="customer.id" class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="py-3 px-4 text-gray-500 dark:text-gray-400 font-mono text-xs">{{ customer.id }}</td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <Phone class="w-4 h-4 text-indigo-500" />
                                            <span class="font-mono text-gray-800 dark:text-gray-200">{{ customer.phone }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-200 font-medium">
                                        {{ getTotalParcels(customer) }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-flex items-center gap-1 text-green-600 dark:text-green-400">
                                            <CheckCircle class="w-4 h-4" />
                                            {{ getSuccessParcels(customer) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-flex items-center gap-1 text-red-600 dark:text-red-400">
                                            <XCircle class="w-4 h-4" />
                                            {{ getCancelledParcels(customer) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span :class="['px-2 py-1 rounded text-xs font-medium', getRiskClass(getSuccessRatio(customer))]">
                                            {{ getSuccessRatio(customer).toFixed(1) }}%
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center text-gray-600 dark:text-gray-400">
                                        {{ customer.count }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <Button 
                                            type="button"
                                            @click="showCustomerResponse(customer)"
                                            class="px-3 py-1.5 bg-indigo-100 hover:bg-indigo-200 dark:bg-indigo-900/30 dark:hover:bg-indigo-900/50 text-indigo-700 dark:text-indigo-400 rounded-lg flex items-center gap-1 text-xs mx-auto"
                                        >
                                            <Eye class="w-3 h-3" />
                                            View
                                        </Button>
                                    </td>
                                </tr>
                                <tr v-if="paginatedCustomers.length === 0">
                                    <td colspan="8" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                        <Filter class="w-8 h-8 mx-auto mb-2 opacity-50" />
                                        No results found for "{{ searchQuery }}"
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination Footer -->
                    <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Showing {{ ((currentPage - 1) * perPage) + 1 }} to {{ Math.min(currentPage * perPage, filteredCustomers.length) }} of {{ filteredCustomers.length }} entries
                            <span v-if="searchQuery" class="text-indigo-600 dark:text-indigo-400">(filtered from {{ totalRecords }} total)</span>
                        </div>
                        
                        <div v-if="totalPages > 1" class="flex items-center gap-1 flex-wrap justify-center">
                            <Button 
                                type="button"
                                @click="goToPage(1)"
                                :disabled="currentPage === 1"
                                class="px-2 py-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded text-xs disabled:opacity-50"
                            >
                                First
                            </Button>
                            <Button 
                                type="button"
                                @click="goToPage(currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="px-2 py-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded disabled:opacity-50"
                            >
                                <ChevronLeft class="w-4 h-4" />
                            </Button>
                            
                            <template v-for="page in visiblePages" :key="page">
                                <button 
                                    type="button"
                                    @click="goToPage(page)"
                                    :class="[
                                        'px-3 py-1.5 rounded text-sm font-medium transition-colors',
                                        page === currentPage 
                                            ? 'bg-indigo-600 text-white' 
                                            : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200'
                                    ]"
                                >
                                    {{ page }}
                                </button>
                            </template>
                            
                            <Button 
                                type="button"
                                @click="goToPage(currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="px-2 py-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded disabled:opacity-50"
                            >
                                <ChevronRight class="w-4 h-4" />
                            </Button>
                            <Button 
                                type="button"
                                @click="goToPage(totalPages)"
                                :disabled="currentPage === totalPages"
                                class="px-2 py-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded text-xs disabled:opacity-50"
                            >
                                Last
                            </Button>
                        </div>
                    </div>
                    
                    <!-- Server-side Pagination (Load different 100 records from API) -->
                    <div v-if="Math.ceil(totalRecords / serverPerPage) > 1" class="mt-4 pt-4 border-t dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-medium">API Page {{ serverPage }}</span> of {{ Math.ceil(totalRecords / serverPerPage) }} 
                                ({{ serverPerPage }} records per API call)
                            </div>
                            <div class="flex items-center gap-2">
                                <Button 
                                    type="button"
                                    @click="loadServerPage(serverPage - 1)"
                                    :disabled="serverPage === 1 || isLoading"
                                    class="px-3 py-2 bg-cyan-100 hover:bg-cyan-200 dark:bg-cyan-900/30 dark:hover:bg-cyan-900/50 text-cyan-700 dark:text-cyan-400 rounded-lg disabled:opacity-50 flex items-center gap-1"
                                >
                                    <ChevronLeft class="w-4 h-4" />
                                    Prev 100
                                </Button>
                                <Button 
                                    type="button"
                                    @click="loadServerPage(serverPage + 1)"
                                    :disabled="serverPage >= Math.ceil(totalRecords / serverPerPage) || isLoading"
                                    class="px-3 py-2 bg-cyan-100 hover:bg-cyan-200 dark:bg-cyan-900/30 dark:hover:bg-cyan-900/50 text-cyan-700 dark:text-cyan-400 rounded-lg disabled:opacity-50 flex items-center gap-1"
                                >
                                    Next 100
                                    <ChevronRight class="w-4 h-4" />
                                </Button>
                            </div>
                        </div>
                    </div>
                </Card>
                
                <!-- Empty State -->
                <Card v-else-if="!isLoading && !error" class="p-8 text-center">
                    <Shield class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" />
                    <p class="text-gray-600 dark:text-gray-400">
                        Enter your authentication token to view customer data.
                    </p>
                </Card>
                
                <!-- Loading State -->
                <Card v-if="isLoading" class="p-8 text-center">
                    <div class="animate-spin w-8 h-8 border-4 border-indigo-600 border-t-transparent rounded-full mx-auto mb-4"></div>
                    <p class="text-gray-600 dark:text-gray-400">Loading customer data...</p>
                </Card>
            </div>
        </div>
        
        <!-- Individual Response Modal -->
        <Teleport to="body">
            <div v-if="showResponseModal && selectedCustomer" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4" @click.self="closeModal">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between px-6 py-4 border-b dark:border-gray-700">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                                <Code class="w-5 h-5 text-indigo-600" />
                                Customer Response
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Phone: <span class="font-mono">{{ selectedCustomer.phone }}</span> (ID: {{ selectedCustomer.id }})
                            </p>
                        </div>
                        <button @click="closeModal" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <X class="w-5 h-5 text-gray-500" />
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <div class="p-6 overflow-y-auto max-h-[70vh]">
                        <!-- Summary Cards -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-3 text-center">
                                <div class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ getTotalParcels(selectedCustomer) }}</div>
                                <div class="text-xs text-blue-500 dark:text-blue-300">Total Parcels</div>
                            </div>
                            <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-3 text-center">
                                <div class="text-xl font-bold text-green-600 dark:text-green-400">{{ getSuccessParcels(selectedCustomer) }}</div>
                                <div class="text-xs text-green-500 dark:text-green-300">Success</div>
                            </div>
                            <div class="bg-red-50 dark:bg-red-900/30 rounded-lg p-3 text-center">
                                <div class="text-xl font-bold text-red-600 dark:text-red-400">{{ getCancelledParcels(selectedCustomer) }}</div>
                                <div class="text-xs text-red-500 dark:text-red-300">Cancelled</div>
                            </div>
                            <div :class="['rounded-lg p-3 text-center', getRiskClass(getSuccessRatio(selectedCustomer))]">
                                <div class="text-xl font-bold">{{ getSuccessRatio(selectedCustomer).toFixed(1) }}%</div>
                                <div class="text-xs opacity-75">Success Rate</div>
                            </div>
                        </div>
                        
                        <!-- Raw JSON Response -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Raw Data</h4>
                            <pre class="bg-gray-900 text-green-400 p-4 rounded-lg overflow-x-auto text-xs">{{ formatJson(selectedCustomer.data) }}</pre>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="px-6 py-4 border-t dark:border-gray-700 flex justify-end">
                        <Button 
                            type="button"
                            @click="closeModal"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg"
                        >
                            Close
                        </Button>
                    </div>
                </div>
            </div>
        </Teleport>
    </AppLayout>
</template>
