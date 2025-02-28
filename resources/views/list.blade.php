<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #eef2ff;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --border: #e2e8f0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #334155;
            line-height: 1.5;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04), 0 5px 15px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06), 0 10px 25px rgba(0, 0, 0, 0.04);
        }
        
        .header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .header-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-light);
            border-radius: 50%;
        }
        
        .header-logo svg {
            width: 40px;
            height: 40px;
            color: var(--primary);
        }
        
        .title {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, var(--primary), #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .subtitle {
            font-size: 1.1rem;
            color: var(--gray);
            font-weight: 400;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }
        
        .input-group {
            position: relative;
        }
        
        .input-control {
            width: 100%;
            padding: 0.875rem 1rem;
            padding-right: 3rem;
            font-size: 1rem;
            background-color: #f8fafc;
            border: 2px solid var(--border);
            border-radius: 0.75rem;
            transition: all 0.2s;
            color: var(--dark);
        }
        
        .input-control:focus {
            outline: none;
            border-color: var(--primary);
            background-color: white;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }
        
        .input-icon {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            color: var(--gray);
        }
        
        .error-message {
            font-size: 0.875rem;
            color: var(--danger);
            margin-top: 0.5rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0.75rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--primary), #818cf8);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(to right, var(--primary-dark), #6366f1);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        
        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .btn-block {
            width: 100%;
        }
        
        .card-section {
            padding: 2rem;
        }
        
        .card-section-header {
            padding: 1.5rem 2rem;
            background-color: var(--primary-light);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary);
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 9999px;
            background-color: var(--primary);
            color: white;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        thead th {
            padding: 1rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--gray);
            background-color: #f8fafc;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        
        tbody td {
            padding: 1.25rem 1.5rem;
            font-size: 0.875rem;
            border-bottom: 1px solid var(--border);
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tbody tr:hover {
            background-color: #f8fafc;
        }
        
        .json-data {
            font-family: 'Fira Code', monospace;
            font-size: 0.75rem;
            padding: 1rem;
            background-color: #f1f5f9;
            border-radius: 0.5rem;
            max-height: 150px;
            overflow-y: auto;
            color: #334155;
        }
        
        .empty-state {
            padding: 3rem 2rem;
            text-align: center;
        }
        
        .empty-icon {
            margin: 0 auto 1rem;
            width: 4rem;
            height: 4rem;
            color: var(--gray);
        }
        
        .empty-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }
        
        .empty-description {
            color: var(--gray);
            max-width: 20rem;
            margin: 0 auto;
        }
        
        .spinner {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
            gap: 0.5rem;
        }
        
        .pagination-info {
            font-size: 0.875rem;
            color: var(--gray);
            margin: 0 1rem;
        }
        
        .pagination-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border);
            background-color: white;
            color: var(--dark);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .pagination-button:hover {
            background-color: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary-light);
        }
        
        .pagination-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: #f8fafc;
        }
        
        .pagination-button.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-section {
                padding: 1.5rem;
            }
            
            .title {
                font-size: 1.75rem;
            }
            
            .pagination {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-logo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h1 class="title">Customer Portal</h1>
            <p class="subtitle">Enter your access token to view customer data</p>
        </div>

        <div class="card" x-data="customerApp()">
            <div class="card-section">
                <form @submit.prevent="fetchCustomers" class="space-y-4">
                    <div class="form-group">
                        <label for="token" class="form-label">Access Token</label>
                        <div class="input-group">
                            <input 
                                type="text" 
                                name="token" 
                                id="token" 
                                x-model="token"
                                placeholder="Enter your access token" 
                                class="input-control"
                                required
                            >
                            <div class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <p class="error-message" x-text="errorMessage" x-show="errorMessage"></p>
                    </div>
                    <div>
                        <button 
                            type="submit" 
                            class="btn btn-primary btn-block"
                            x-bind:disabled="isLoading"
                        >
                            <span x-show="!isLoading">Access Customer Data</span>
                            <span x-show="isLoading" class="flex items-center">
                                <svg class="spinner mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Customer Data Table (shown if data exists) -->
            <div x-show="customers.length > 0" x-cloak>
                <div class="card-section-header">
                    <h2 class="section-title">Customer Data</h2>
                    <span class="badge">
                        <span>Total records:</span>
                        <span x-text="customers.length" class="ml-1"></span>
                    </span>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Phone</th>
                                <th>Count</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="customer in paginatedCustomers" :key="customer.id">
                                <tr>
                                    <td class="font-medium" x-text="formatPhone(customer.phone)"></td>
                                    <td x-text="customer.count"></td>
                                    <td>
                                        <template x-if="customer.data">
                                            <div>
                                                <pre class="json-data" x-text="formatJson(customer.data)"></pre>
                                            </div>
                                        </template>
                                        <template x-if="!customer.data">
                                            <span class="text-gray italic">No data</span>
                                        </template>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Controls -->
                <div class="pagination" x-show="totalPages > 1">
                    <button 
                        class="pagination-button" 
                        @click="goToPage(currentPage - 1)" 
                        :disabled="currentPage === 1"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    
                    <div class="pagination-info">
                        Page <span x-text="currentPage"></span> of <span x-text="totalPages"></span>
                    </div>
                    
                    <button 
                        class="pagination-button"
                        @click="goToPage(currentPage + 1)"
                        :disabled="currentPage === totalPages"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Empty state (shown if no results after valid token) -->
            <div x-show="showEmptyState" class="empty-state" x-cloak>
                <svg class="empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="empty-title">No customers found</h3>
                <p class="empty-description">No customer data available for the provided token.</p>
            </div>
        </div>
    </div>

    <script>
        function customerApp() {
            return {
                token: '',
                customers: [],
                isLoading: false,
                errorMessage: '',
                showEmptyState: false,
                currentPage: 1,
                itemsPerPage: 5,
                
                get totalPages() {
                    return Math.ceil(this.customers.length / this.itemsPerPage);
                },
                
                get paginatedCustomers() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.customers.slice(start, end);
                },
                
                goToPage(page) {
                    if (page >= 1 && page <= this.totalPages) {
                        this.currentPage = page;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },
                
                fetchCustomers() {
                    this.isLoading = true;
                    this.errorMessage = '';
                    this.showEmptyState = false;
                    this.currentPage = 1;
                    
                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    axios.post('/customer-list', {
                        token: this.token
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        this.isLoading = false;
                        if (response.data.success) {
                            this.customers = response.data.customers;
                            this.showEmptyState = this.customers.length === 0;
                        } else {
                            this.errorMessage = response.data.message || 'An error occurred';
                        }
                    })
                    .catch(error => {
                        this.isLoading = false;
                        if (error.response && error.response.data && error.response.data.message) {
                            this.errorMessage = error.response.data.message;
                        } else {
                            this.errorMessage = 'An error occurred while fetching data';
                        }
                    });
                },
                
                formatJson(data) {
                    try {
                        if (typeof data === 'string') {
                            data = JSON.parse(data);
                        }
                        return JSON.stringify(data, null, 2);
                    } catch (e) {
                        return data;
                    }
                },
                
                formatPhone(phone) {
                    // Format phone number as needed
                    if (!phone) return '';
                    // Basic international format
                    return phone.replace(/(\d{2})(\d{3})(\d{3})(\d{4})/, '+$1 $2 $3 $4');
                }
            };
        }
    </script>
</body>
</html>