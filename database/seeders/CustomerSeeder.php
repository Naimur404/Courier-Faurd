<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->command->info('Starting Customer seeder...');
        
        // Path to the CSV file
        $csvFile = database_path('customer_data.csv');
        
        // Check if file exists
        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found: $csvFile");
            return;
        }
        
        // Read CSV file
        $file = fopen($csvFile, 'r');
        
        // Get headers from first row
        $headers = fgetcsv($file);
        
        // Convert headers to lowercase and trim
        $headers = array_map(function($header) {
            return strtolower(trim($header));
        }, $headers);
        
        // Initialize counter
        $count = 0;
        
        // Use a transaction for better performance
        DB::beginTransaction();
        
        try {
            // Read data rows
            while (($row = fgetcsv($file)) !== false) {
                // Skip empty rows
                if (empty($row[0])) continue;
                
                // Combine headers with row values to create associative array
                $data = array_combine($headers, $row);
                
                // Process data fields
                $customerData = $this->processCustomerData($data);
                
                // Create customer record
                Customer::create($customerData);
                
                $count++;
                
                // Show progress every 100 records
                if ($count % 100 === 0) {
                    $this->command->info("Processed $count records");
                }
            }
            
            DB::commit();
            $this->command->info("Customer seeding completed. Total records: $count");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error importing customers: ' . $e->getMessage());
            throw $e;
        } finally {
            fclose($file);
        }
    }
    
    /**
     * Process and format customer data from CSV
     *
     * @param array $data
     * @return array
     */
    private function processCustomerData($data)
    {
        $result = [];
        
        // Map and convert fields as needed
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'id':
                    // Skip ID field if auto-incrementing is enabled
                    // Uncomment if you need to preserve original IDs
                    // $result['id'] = $value;
                    break;
                    
                case 'phone':
                    $result['phone'] = $value;
                    break;
                    
                case 'count':
                    $result['count'] = (int) $value;
                    break;
                    
                case 'data':
                    // Handle JSON data
                    try {
                        // If it's a JSON string, decode it
                        if (!empty($value) && $this->isJson($value)) {
                            $result['data'] = $value;
                        } else {
                            $result['data'] = $value;
                        }
                    } catch (\Exception $e) {
                        $result['data'] = $value;
                    }
                    break;
                    
                case 'search_by':
                    $result['search_by'] = $value;
                    break;
                    
                case 'ip_address':
                    $result['ip_address'] = $value;
                    break;
                    
                case 'last_searched_at':
                    // Convert date string to proper datetime format
                    try {
                        $result['last_searched_at'] = !empty($value) ? Carbon::parse($value) : null;
                    } catch (\Exception $e) {
                        $result['last_searched_at'] = null;
                    }
                    break;
                    
                case 'created_at':
                case 'updated_at':
                    // Handle timestamps
                    try {
                        $result[$key] = !empty($value) ? Carbon::parse($value) : now();
                    } catch (\Exception $e) {
                        $result[$key] = now();
                    }
                    break;
                    
                default:
                    // Include any other fields from the CSV
                    $result[$key] = $value;
                    break;
            }
        }
        
        // Ensure timestamps exist
        if (!isset($result['created_at'])) {
            $result['created_at'] = now();
        }
        
        if (!isset($result['updated_at'])) {
            $result['updated_at'] = now();
        }
        
        return $result;
    }
    
    /**
     * Check if a string is valid JSON
     *
     * @param string $string
     * @return bool
     */
    private function isJson($string)
    {
        if (!is_string($string)) {
            return false;
        }
        
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
