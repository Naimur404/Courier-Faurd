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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #eef2ff;
            --secondary: #10b981;
            --secondary-light: #d1fae5;
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
            background-color: #f8fafc;
            color: #334155;
            line-height: 1.6;
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
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03), 0 5px 10px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05), 0 10px 25px rgba(0, 0, 0, 0.03);
        }
        
        .header {
            text-align: center;
            margin-bottom: 2.5rem;
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
            transition: transform 0.3s ease;
        }
        
        .header-logo:hover {
            transform: rotate(5deg) scale(1.05);
        }
        
        .header-logo svg {
            width: 40px;
            height: 40px;
            color: var(--primary);
        }
        
        .title {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, var(--primary), #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.025em;
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
            transition: all 0.3s;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--primary), #818cf8);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(to right, var(--primary-dark), #6366f1);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            transform: translateY(-1px);
        }
        
        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
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
        
        /* Data visualization improvements */
        .data-card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.2s;
            border: 1px solid var(--border);
        }
        
        .data-card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
            border-color: var(--primary-light);
        }
        
        .data-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            background-color: #fafafa;
        }
        
        .data-card-title {
            font-weight: 600;
            font-size: 1rem;
            color: var(--dark);
        }
        
        .data-card-subtitle {
            font-size: 0.875rem;
            color: var(--gray);
        }
        
        .data-card-body {
            padding: 1.25rem;
        }
        
        .data-field {
            margin-bottom: 0.5rem;
        }
        
        .data-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray);
            display: block;
        }
        
        .data-value {
            font-size: 1rem;
            color: var(--dark);
            font-weight: 500;
        }
        
        .json-data {
            font-family: 'Fira Code', monospace;
            font-size: 0.875rem;
            padding: 1rem;
            background-color: #f9fafb;
            border-radius: 0.5rem;
            max-height: 150px;
            overflow-y: auto;
            color: #334155;
            border: 1px solid #f1f5f9;
            white-space: pre-wrap;
        }
        
        .json-data::-webkit-scrollbar {
            width: 6px;
        }
        
        .json-data::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .json-data::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 6px;
        }
        
        .status-tag {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-success {
            background-color: var(--secondary-light);
            color: var(--secondary);
        }
        
        .status-warning {
            background-color: #fef3c7;
            color: var(--warning);
        }
        
        .status-error {
            background-color: #fee2e2;
            color: var(--danger);
        }
        
        .data-metrics {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .metric-card {
            flex: 1;
            min-width: 120px;
            background-color: #f9fafb;
            border-radius: 0.5rem;
            padding: 1rem;
            text-align: center;
            border: 1px solid #f1f5f9;
            transition: all 0.2s;
        }
        
        .metric-card:hover {
            background-color: var(--primary-light);
            border-color: var(--primary-light);
        }
        
        .metric-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }
        
        .metric-label {
            font-size: 0.75rem;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .ratio-bar {
            height: 8px;
            background-color: #f1f5f9;
            border-radius: 4px;
            overflow: hidden;
            margin: 0.5rem 0;
        }
        
        .ratio-fill {
            height: 100%;
            background: linear-gradient(to right, var(--primary), #818cf8);
            border-radius: 4px;
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
        
        /* DataTables customization */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--dark);
            margin-bottom: 1rem;
        }
        
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            margin-left: 0.5rem;
        }
        
        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            min-width: 2rem;
            padding: 0.375rem 0.75rem;
            margin: 0 0.25rem;
            border-radius: 0.5rem;
            color: var(--dark) !important;
            border: 1px solid var(--border) !important;
            background: white;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: white !important;
            border: 1px solid var(--primary) !important;
            background: var(--primary) !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: var(--primary) !important;
            border: 1px solid var(--primary-light) !important;
            background: var(--primary-light) !important;
        }
        
        /* Custom table styling */
        table.dataTable {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        table.dataTable thead th {
            background-color: #f8fafc;
            font-weight: 600;
            color: var(--dark);
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem;
        }
        
        table.dataTable tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }
        
        table.dataTable tbody tr:hover {
            background-color: #f9fafb;
        }
        
        /* Expandable JSON preview */
        .json-preview {
            position: relative;
            cursor: pointer;
        }
        
        .json-preview-toggle {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            background-color: #f1f5f9;
            border-radius: 0.25rem;
            color: var(--primary);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            margin-bottom: 0.5rem;
        }
        
        .json-preview-toggle:hover {
            background-color: var(--primary-light);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-section {
                padding: 1.25rem;
            }
            
            .card-section-header {
                padding: 1.25rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .title {
                font-size: 1.75rem;
            }
            
            .data-metrics {
                flex-direction: column;
            }
            
            .metric-card {
                min-width: 100%;
            }
            
            .json-data {
                max-height: 100px;
                font-size: 0.75rem;
            }
        }
        
        @media (max-width: 480px) {
            .card-section {
                padding: 1rem;
            }
            
            .title {
                font-size: 1.5rem;
            }
            
            .header-logo {
                width: 60px;
                height: 60px;
            }
            
            .header-logo svg {
                width: 30px;
                height: 30px;
            }
        }
        
        /* Modern Display for JSON Data */
        .json-card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
            transition: all 0.2s;
            overflow: hidden;
        }
        
        .json-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .json-card-header {
            padding: 0.75rem 1rem;
            background-color: #f9fafb;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .json-card-title {
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--dark);
        }
        
        .json-card-body {
            padding: 0;
            position: relative;
        }
        
        .json-pretty {
            margin: 0;
            padding: 0.75rem;
            background-color: #ffffff;
            font-family: 'Fira Code', monospace;
            font-size: 0.875rem;
            line-height: 1.5;
            overflow-x: auto;
            color: #374151;
        }
        
        .json-key {
            color: #8b5cf6;
            font-weight: 500;
        }
        
        .json-string {
            color: #10b981;
        }
        
        .json-number {
            color: #3b82f6;
        }
        
        .json-boolean {
            color: #f59e0b;
        }
        
        .json-null {
            color: #ef4444;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-logo">
                <a href="/">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg></a>
            </div>
            <h1 class="title">Customer Portal</h1>
            <p class="subtitle">Enter your access token to view customer data</p>
        </div>

        <div class="card" x-data="customerApp()">
            <div class="card-section">
                <form @submit.prevent="authenticate" class="space-y-4">
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

            <!-- Customer Data Table (shown if authenticated) -->
            <div x-show="isAuthenticated" x-cloak>
                <div class="card-section-header">
                    <h2 class="section-title">Customer Data</h2>
                    <span class="badge" id="total-records">
                        <span>Loading...</span>
                    </span>
                </div>
                
                <div class="card-section">
                    <table id="customers-table" class="display responsive nowrap w-full" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Phone</th>
                                <th>Count</th>
                                <th>Search By</th>
                                <th>Ip Address</th>
                                <th>Last Searched at</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded by DataTables -->
                        </tbody>
                    </table>
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
                isLoading: false,
                errorMessage: '',
                isAuthenticated: false,
                showEmptyState: false,
                dataTable: null,
                
                authenticate() {
                    this.isLoading = true;
                    this.errorMessage = '';
                    this.showEmptyState = false;
                    
                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    axios.post('/authenticate', {
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
                            this.isAuthenticated = true;
                            
                            // Initialize DataTable after a short delay to ensure the DOM is updated
                            setTimeout(() => {
                                this.initDataTable();
                            }, 100);
                        } else {
                            this.errorMessage = response.data.message || 'Authentication failed';
                        }
                    })
                    .catch(error => {
                        this.isLoading = false;
                        if (error.response && error.response.data && error.response.data.message) {
                            this.errorMessage = error.response.data.message;
                        } else {
                            this.errorMessage = 'Authentication failed';
                        }
                    });
                },
                
                initDataTable() {
                    // If DataTable is already initialized, destroy it first
                    if (this.dataTable) {
                        this.dataTable.destroy();
                    }
                    
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const self = this;
                    
                    // Initialize DataTable with server-side processing
                    this.dataTable = $('#customers-table').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: {
                            url: '/customer-data',
                            type: 'POST',
                            data: function(d) {
                                d.token = self.token;
                                return d;
                            },
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            error: function(xhr) {
                                self.errorMessage = 'Error loading data. Please try again.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    self.errorMessage = xhr.responseJSON.message;
                                }
                            },
                            dataSrc: function(json) {
                                if (json.recordsTotal === 0) {
                                    self.showEmptyState = true;
                                }
                                
                                // Update total records badge
                                document.getElementById('total-records').innerText = 'Total records: ' + json.recordsTotal;
                                
                                return json.data;
                            }
                        },
                        columns: [
                            { data: 'id' },
                            { 
                                data: 'phone',
                                render: function(data) {
                                    return self.formatPhone(data);
                                }
                            },
                            { data: 'count' },
                            { data: 'search_by' },
                            { data: 'ip_address' },
                            { data: 'last_searched_at' },
                            { 
                                data: 'data',
                                render: function(data) {
                                    if (!data) return '<span class="text-gray italic">No data</span>';
                                    return '<pre class="json-data">' + self.formatJson(data) + '</pre>';
                                }
                            }
                        ],
                        order: [[0, 'asc']],
                        pageLength: 10,
                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        language: {
                            processing: '<div class="flex justify-center p-4"><svg class="spinner h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>'
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
                    // Format phone number
                    if (!phone) return '';
                    // Basic international format
                    return phone.replace(/(\d{2})(\d{3})(\d{3})(\d{4})/, '+$1 $2 $3 $4');
                }
            };
        }
    </script>
</body>
</html>