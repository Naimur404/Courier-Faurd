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
}
