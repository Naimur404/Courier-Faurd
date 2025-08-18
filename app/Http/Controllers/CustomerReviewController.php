<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerReview;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric',
            'ownNumber' => [
                'required',
                'numeric',
                Rule::unique('customer_reviews', 'commenter_phone')
                    ->where(function ($query) use ($request) {
                        return $query->where('phone', $request->phone);
                    })
            ],
            'name' => 'required|string',
            'rating' => 'required|numeric',
            'comment' => 'required|string',
        ]);

        $customerId = Customer::where('phone', $request->phone)->first();

        $customerReview = new CustomerReview();
        $customerReview->customer_id = $customerId->id;
        $customerReview->phone = $request->phone;
        $customerReview->commenter_phone = $request->ownNumber;
        $customerReview->name = $request->name;
        $customerReview->rating = $request->rating;
        $customerReview->comment = $request->comment;
        $customerReview->save();

        return response()->json([
            'message' => 'Customer review created successfully',
            'data' => $customerReview,
        ]);
    }

    public function list($phone)
    {
        $customerReviews = CustomerReview::where('phone', $phone)->get();

        return response()->json([
            'message' => 'Customer reviews retrieved successfully',
            'data' => $customerReviews,
        ]);
    }

    /**
     * Get reviews with additional metadata about reports
     */
    public function getReviewsWithReports($phone)
    {
        $customerReviews = CustomerReview::where('phone', $phone)
            ->orderBy('created_at', 'desc')
            ->get();

        // Separate reviews into reports (rating = 1.0) and regular reviews
        $reports = $customerReviews->where('rating', 1.0)->values()->map(function($review) {
            // For reports, the structure is:
            // - phone: the number being reported
            // - name: name of the person being reported  
            // - commenter_phone: user ID of who made the report (prefixed with 'user_')
            // - comment: report details with metadata
            
            $review->reported_person_name = $review->name; // Name of person being reported
            $review->reporter_id = str_replace('user_', '', $review->commenter_phone); // Who made the report
            return $review;
        });
        
        $regularReviews = $customerReviews->where('rating', '!=', 1.0)->values();

        return response()->json([
            'message' => 'Customer reviews retrieved successfully',
            'data' => [
                'all_reviews' => $customerReviews,
                'reports' => $reports,
                'regular_reviews' => $regularReviews,
                'total_reports' => $reports->count(),
                'total_reviews' => $customerReviews->count(),
            ],
        ]);
    }
}
