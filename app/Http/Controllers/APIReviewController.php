<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Combo;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class APIReviewController extends Controller
{
    public function create(Request $request)
    {
        $book_id = $request->input('book_id', null);
        $combo_id = $request->input('combo_id', null);

        Review::updateOrCreate([
            'customer_id' => $request->customer_id,
            'book_id' => $book_id,
            'combo_id' => $combo_id,
        ], [
            'rating' => $request->rating,
            'content' => $request->content,
        ]);

        if ($request->input('rating')) {
            $product = $book_id ? Book::find($book_id) : Combo::find($combo_id);

            $averageRating = $product->average_rating === null ? $request->rating : ($product->average_rating + $request->rating) / 2;

            $product->update(['average_rating' => $averageRating]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đánh giá sản phẩm thành công!'
        ]);
    }

    public function getReviewsByProductId(Request $request)
    {
        $bookId = $request->input('book_id');
        $comboId = $request->input('combo_id');

        $reviews = [];
        $totalReviews = 0;
        $count1StarReviews = 0;
        $count2StarsReviews = 0;
        $count3StarsReviews = 0;
        $count4StarsReviews = 0;
        $count5StarsReviews = 0;

        if ($bookId) {
            $reviews = Review::with('customer')
                ->where('book_id', $bookId)
                ->latest()
                ->get();
            $totalReviews = $reviews->count();
            $count1StarReviews = $reviews->where('rating', 1)->count();
            $count2StarsReviews = $reviews->where('rating', 2)->count();
            $count3StarsReviews = $reviews->where('rating', 3)->count();
            $count4StarsReviews = $reviews->where('rating', 4)->count();
            $count5StarsReviews = $reviews->where('rating', 5)->count();
        } else if ($comboId) {
            $reviews = Review::with('customer')
                ->where('combo_id', $comboId)
                ->latest()
                ->get();
            $totalReviews = $reviews->count();
            $count1StarReviews = $reviews->where('rating', 1)->count();
            $count2StarsReviews = $reviews->where('rating', 2)->count();
            $count3StarsReviews = $reviews->where('rating', 3)->count();
            $count4StarsReviews = $reviews->where('rating', 4)->count();
            $count5StarsReviews = $reviews->where('rating', 5)->count();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'reviews' => $reviews,
                'total_reviews' => $totalReviews,
                'count_1_star_reviews' => $count1StarReviews,
                'count_2_stars_reviews' => $count2StarsReviews,
                'count_3_stars_reviews' => $count3StarsReviews,
                'count_4_stars_reviews' => $count4StarsReviews,
                'count_5_stars_reviews' => $count5StarsReviews,
            ],
        ]);
    }

    public function checkDelivered(Request $request)
    {
        $customer_id = $request->customer_id;
        $book_id = $request->book_id;
        $combo_id = $request->combo_id;

        $query = Order::where('customer_id', $customer_id);

        if ($book_id) {
            $query->whereHas('order_detail', function ($q) use ($book_id) {
                $q->where('book_id', $book_id);
            });
        } else if ($combo_id) {
            $query->whereHas('order_detail', function ($q) use ($combo_id) {
                $q->where('combo_id', $combo_id);
            });
        }

        $isDelivered = $query->exists();

        return response()->json([
            'success' => true,
            'is_delivered' => $isDelivered,
        ]);
    }
}
