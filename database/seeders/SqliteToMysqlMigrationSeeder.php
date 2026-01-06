<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PDO;

class SqliteToMysqlMigrationSeeder extends Seeder
{
    private $sqliteDb;
    
    /**
     * Complete SQLite to MySQL migration seeder
     * Migrates all data from SQLite database to MySQL
     * 
     * Usage: php artisan db:seed --class=SqliteToMysqlMigrationSeeder
     */
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('🚀 Starting SQLite to MySQL Migration...');
        $this->command->info('==========================================');
        
        // Connect to SQLite database
        $sqlitePath = database_path('database.sqlite');
        
        if (!file_exists($sqlitePath)) {
            $this->command->error('SQLite database not found at: ' . $sqlitePath);
            return;
        }
        
        $this->sqliteDb = new PDO('sqlite:' . $sqlitePath);
        $this->sqliteDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $this->command->info('Connected to SQLite: ' . $sqlitePath);
        $this->command->info('');
        
        // Migrate all tables in correct order (respecting foreign keys)
        $this->migrateUsers();
        $this->migrateCustomers();
        $this->migrateCustomerReviews();
        $this->migratePlans();
        $this->migrateApiKeys();
        $this->migrateSubscriptions();
        $this->migrateWebsiteSubscriptions();
        $this->migrateApiUsages();
        $this->migrateAppDownloadTracks();
        $this->migrateDownloadTrackers();
        
        $this->command->info('');
        $this->command->info('==========================================');
        $this->command->info('📊 FINAL VERIFICATION');
        $this->command->info('==========================================');
        $this->verifyAllTables();
        
        $this->command->info('');
        $this->command->info('🎉 Migration completed successfully!');
        $this->command->info('==========================================');
    }
    
    private function migrateUsers(): void
    {
        $this->command->info('Migrating users...');
        
        $stmt = $this->sqliteDb->query('SELECT * FROM users ORDER BY id');
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($records)) {
            $this->command->info('  No users to migrate');
            return;
        }
        
        foreach ($records as $record) {
            try {
                DB::table('users')->updateOrInsert(
                    ['id' => $record['id']],
                    [
                        'name' => $record['name'],
                        'email' => $record['email'],
                        'role' => $record['role'],
                        'email_verified_at' => $record['email_verified_at'],
                        'password' => $record['password'],
                        'remember_token' => $record['remember_token'],
                        'created_at' => $record['created_at'],
                        'updated_at' => $record['updated_at'],
                    ]
                );
            } catch (\Exception $e) {
                $this->command->warn('  Error migrating user ID ' . $record['id'] . ': ' . $e->getMessage());
            }
        }
        
        $count = DB::table('users')->count();
        $this->command->info("  ✅ users: {$count} records");
    }
    
    private function migrateCustomers(): void
    {
        $this->command->info('Migrating customers...');
        
        $stmt = $this->sqliteDb->query('SELECT * FROM customers ORDER BY id');
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($records)) {
            $this->command->info('  No customers to migrate');
            return;
        }
        
        $this->command->info('  Found ' . count($records) . ' customers');
        
        $chunks = array_chunk($records, 50);
        
        foreach ($chunks as $index => $chunk) {
            $insertData = [];
            foreach ($chunk as $record) {
                $insertData[] = [
                    'id' => $record['id'],
                    'phone' => $record['phone'],
                    'count' => $record['count'] ?? 0,
                    'data' => $record['data'],
                    'created_at' => $record['created_at'],
                    'updated_at' => $record['updated_at'],
                    'search_by' => $record['search_by'] ?? 'web',
                    'ip_address' => $record['ip_address'],
                    'last_searched_at' => $record['last_searched_at'],
                    'user_id' => $record['user_id'],
                    'subscription_type' => $record['subscription_type'],
                    'subscription_id' => $record['subscription_id'],
                ];
            }
            
            try {
                DB::table('customers')->insertOrIgnore($insertData);
            } catch (\Exception $e) {
                $this->command->warn('  Error in chunk ' . ($index + 1));
            }
            
            if (($index + 1) % 100 == 0) {
                $this->command->info('  Processed ' . (($index + 1) * 50) . ' customers...');
            }
        }
        
        $count = DB::table('customers')->count();
        $this->command->info("  ✅ customers: {$count} records");
    }
    
    private function migrateCustomerReviews(): void
    {
        $this->command->info('Migrating customer_reviews...');
        
        $stmt = $this->sqliteDb->query('SELECT * FROM customer_reviews ORDER BY id');
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($records)) {
            $this->command->info('  No customer reviews to migrate');
            return;
        }
        
        $chunks = array_chunk($records, 50);
        
        foreach ($chunks as $chunk) {
            $insertData = [];
            foreach ($chunk as $record) {
                $insertData[] = [
                    'id' => $record['id'],
                    'commenter_phone' => $record['commenter_phone'],
                    'phone' => $record['phone'],
                    'customer_id' => $record['customer_id'],
                    'name' => $record['name'],
                    'rating' => $record['rating'],
                    'comment' => $record['comment'],
                    'created_at' => $record['created_at'],
                    'updated_at' => $record['updated_at'],
                ];
            }
            
            try {
                DB::table('customer_reviews')->insertOrIgnore($insertData);
            } catch (\Exception $e) {
                $this->command->warn('  Error migrating customer reviews chunk');
            }
        }
        
        $count = DB::table('customer_reviews')->count();
        $this->command->info("  ✅ customer_reviews: {$count} records");
    }
    
    private function migratePlans(): void
    {
        $this->command->info('Migrating plans...');
        
        $stmt = $this->sqliteDb->query('SELECT * FROM plans ORDER BY id');
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($records)) {
            $this->command->info('  No plans to migrate');
            return;
        }
        
        foreach ($records as $record) {
            try {
                DB::table('plans')->updateOrInsert(
                    ['id' => $record['id']],
                    [
                        'name' => $record['name'],
                        'slug' => $record['slug'],
                        'price' => $record['price'],
                        'duration_months' => $record['duration_months'],
                        'request_limit' => $record['request_limit'],
                        'description' => $record['description'],
                        'features' => $record['features'],
                        'is_active' => $record['is_active'],
                        'sort_order' => $record['sort_order'],
                        'created_at' => $record['created_at'],
                        'updated_at' => $record['updated_at'],
                    ]
                );
            } catch (\Exception $e) {
                $this->command->warn('  Error migrating plan ID ' . $record['id']);
            }
        }
        
        $count = DB::table('plans')->count();
        $this->command->info("  ✅ plans: {$count} records");
    }
    
    private function migrateApiKeys(): void
    {
        $this->command->info('Migrating api_keys...');
        
        $stmt = $this->sqliteDb->query('SELECT * FROM api_keys ORDER BY id');
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($records)) {
            $this->command->info('  No API keys to migrate');
            return;
        }
        
        foreach ($records as $record) {
            try {
                DB::table('api_keys')->updateOrInsert(
                    ['id' => $record['id']],
                    [
                        'user_id' => $record['user_id'],
                        'name' => $record['name'],
                        'key' => $record['key'],
                        'secret' => $record['secret'],
                        'is_active' => $record['is_active'],
                        'rate_limit' => $record['rate_limit'],
                        'usage_count' => $record['usage_count'],
                        'last_used_at' => $record['last_used_at'],
                        'expires_at' => $record['expires_at'],
                        'permissions' => $record['permissions'],
                        'created_at' => $record['created_at'],
                        'updated_at' => $record['updated_at'],
                    ]
                );
            } catch (\Exception $e) {
                $this->command->warn('  Error migrating API key ID ' . $record['id']);
            }
        }
        
        $count = DB::table('api_keys')->count();
        $this->command->info("  ✅ api_keys: {$count} records");
    }
    
    private function migrateSubscriptions(): void
    {
        $this->command->info('Migrating subscriptions...');
        
        $stmt = $this->sqliteDb->query('SELECT * FROM subscriptions ORDER BY id');
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($records)) {
            $this->command->info('  No subscriptions to migrate');
            return;
        }
        
        foreach ($records as $record) {
            try {
                $status = in_array($record['status'], ['pending', 'active', 'expired', 'cancelled']) 
                    ? $record['status'] : 'pending';
                
                $paymentMethod = in_array($record['payment_method'], ['bkash', 'manual']) 
                    ? $record['payment_method'] : 'bkash';
                
                DB::table('subscriptions')->updateOrInsert(
                    ['id' => $record['id']],
                    [
                        'user_id' => $record['user_id'],
                        'plan_id' => $record['plan_id'],
                        'transaction_id' => $record['transaction_id'],
                        'status' => $status,
                        'payment_method' => $paymentMethod,
                        'amount_paid' => $record['amount_paid'],
                        'starts_at' => $record['starts_at'],
                        'expires_at' => $record['expires_at'],
                        'activated_at' => $record['activated_at'],
                        'admin_notes' => $record['admin_notes'],
                        'created_at' => $record['created_at'],
                        'updated_at' => $record['updated_at'],
                    ]
                );
            } catch (\Exception $e) {
                $this->command->warn('  Error migrating subscription ID ' . $record['id']);
            }
        }
        
        $count = DB::table('subscriptions')->count();
        $this->command->info("  ✅ subscriptions: {$count} records");
    }
    
    private function migrateWebsiteSubscriptions(): void
    {
        $this->command->info('Migrating website_subscriptions...');
        
        $stmt = $this->sqliteDb->query('SELECT * FROM website_subscriptions ORDER BY id');
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($records)) {
            $this->command->info('  No website subscriptions to migrate');
            return;
        }
        
        foreach ($records as $record) {
            try {
                $planType = in_array($record['plan_type'], ['daily', 'weekly']) 
                    ? $record['plan_type'] : 'daily';
                
                $status = in_array($record['status'], ['active', 'expired', 'cancelled']) 
                    ? $record['status'] : 'active';
                
                $verificationStatus = in_array($record['verification_status'], ['pending', 'verified', 'rejected']) 
                    ? $record['verification_status'] : 'pending';
                
                DB::table('website_subscriptions')->updateOrInsert(
                    ['id' => $record['id']],
                    [
                        'user_id' => $record['user_id'],
                        'plan_type' => $planType,
                        'amount' => $record['amount'],
                        'starts_at' => $record['starts_at'],
                        'expires_at' => $record['expires_at'],
                        'status' => $status,
                        'verification_status' => $verificationStatus,
                        'verified_at' => $record['verified_at'],
                        'verified_by' => $record['verified_by'],
                        'admin_notes' => $record['admin_notes'],
                        'payment_method' => $record['payment_method'],
                        'transaction_id' => $record['transaction_id'],
                        'created_at' => $record['created_at'],
                        'updated_at' => $record['updated_at'],
                    ]
                );
            } catch (\Exception $e) {
                $this->command->warn('  Error migrating website subscription ID ' . $record['id']);
            }
        }
        
        $count = DB::table('website_subscriptions')->count();
        $this->command->info("  ✅ website_subscriptions: {$count} records");
    }
    
    private function migrateApiUsages(): void
    {
        $this->command->info('Migrating api_usages...');
        
        $stmt = $this->sqliteDb->query('SELECT * FROM api_usages ORDER BY id');
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($records)) {
            $this->command->info('  No API usages to migrate');
            return;
        }
        
        $this->command->info('  Found ' . count($records) . ' API usage records');
        
        $successCount = 0;
        
        foreach ($records as $record) {
            try {
                DB::table('api_usages')->insertOrIgnore([
                    'id' => $record['id'],
                    'user_id' => $record['user_id'],
                    'api_key_id' => $record['api_key_id'],
                    'endpoint' => $record['endpoint'],
                    'method' => $record['method'],
                    'request_data' => $record['request_data'],
                    'response_data' => $record['response_data'],
                    'response_code' => $record['response_code'],
                    'response_time' => $record['response_time'],
                    'ip_address' => $record['ip_address'],
                    'user_agent' => $record['user_agent'],
                    'requested_at' => $record['requested_at'],
                    'created_at' => $record['created_at'],
                    'updated_at' => $record['updated_at'],
                ]);
                $successCount++;
            } catch (\Exception $e) {
                // Skip duplicates silently
            }
            
            if ($successCount % 1000 == 0 && $successCount > 0) {
                $this->command->info("  Processed {$successCount} records...");
            }
        }
        
        $count = DB::table('api_usages')->count();
        $this->command->info("  ✅ api_usages: {$count} records");
    }
    
    private function migrateAppDownloadTracks(): void
    {
        $this->command->info('Migrating app_download_tracks...');
        
        $stmt = $this->sqliteDb->query('SELECT * FROM app_download_tracks ORDER BY id');
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($records)) {
            $this->command->info('  No app download tracks to migrate');
            return;
        }
        
        $chunks = array_chunk($records, 50);
        
        foreach ($chunks as $chunk) {
            $insertData = [];
            foreach ($chunk as $record) {
                $insertData[] = [
                    'id' => $record['id'],
                    'ip_address' => $record['ip_address'],
                    'status' => $record['status'] ?? 'complete',
                    'completed_at' => $record['completed_at'],
                    'created_at' => $record['created_at'],
                    'updated_at' => $record['updated_at'],
                ];
            }
            
            try {
                DB::table('app_download_tracks')->insertOrIgnore($insertData);
            } catch (\Exception $e) {
                // Skip errors
            }
        }
        
        $count = DB::table('app_download_tracks')->count();
        $this->command->info("  ✅ app_download_tracks: {$count} records");
    }
    
    private function migrateDownloadTrackers(): void
    {
        $this->command->info('Migrating download_trackers...');
        
        $stmt = $this->sqliteDb->query('SELECT * FROM download_trackers ORDER BY id');
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($records)) {
            $this->command->info('  No download trackers to migrate');
            return;
        }
        
        $chunks = array_chunk($records, 50);
        
        foreach ($chunks as $chunk) {
            $insertData = [];
            foreach ($chunk as $record) {
                $insertData[] = [
                    'id' => $record['id'],
                    'track_id' => $record['track_id'],
                    'ip_address' => $record['ip_address'],
                    'user_agent' => $record['user_agent'],
                    'format' => $record['format'] ?? 'csv',
                    'status' => $record['status'] ?? 'intent',
                    'completed_at' => $record['completed_at'],
                    'created_at' => $record['created_at'],
                    'updated_at' => $record['updated_at'],
                ];
            }
            
            try {
                DB::table('download_trackers')->insertOrIgnore($insertData);
            } catch (\Exception $e) {
                // Skip errors
            }
        }
        
        $count = DB::table('download_trackers')->count();
        $this->command->info("  ✅ download_trackers: {$count} records");
    }
    
    private function verifyAllTables(): void
    {
        $tables = [
            'users',
            'customers', 
            'customer_reviews',
            'plans',
            'subscriptions',
            'api_keys',
            'api_usages',
            'website_subscriptions',
            'app_download_tracks',
            'download_trackers',
        ];
        
        $total = 0;
        
        foreach ($tables as $table) {
            try {
                $count = DB::table($table)->count();
                $status = $count > 0 ? '✅' : '⚠️';
                $this->command->info("{$status} {$table}: {$count} records");
                $total += $count;
            } catch (\Exception $e) {
                $this->command->error("❌ {$table}: " . $e->getMessage());
            }
        }
        
        $this->command->info('');
        $this->command->info("📊 Total records migrated: {$total}");
    }
}
