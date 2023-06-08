<?php

namespace  App\Services\User;

use App\Http\Requests\User\CategoryFoodRequest;
use App\Models\Category;
use App\Models\Deal;
use App\Models\Favorite;
use App\Models\Rating;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;
use Illuminate\Pagination\Paginator;

class UserService
{

    public function homePage()
    {
        $obj = new stdClass();
        $deals = Deal::with('product:id,image,name')->select('sub_category_id', 'discount_percentage')->orderBy('created_at', 'desc')->get();



        $categories = Category::select('name', 'image')->paginate(5);
        $foods = SubCategory::select('id', 'name', 'image', 'price', 'discription')->paginate(10);
        $obj->deals = $deals;
        $obj->categories = $categories;
        foreach ($foods as $food) {
            $ratings  = Rating::where('sub_category_id', $food->id)->get();
            $avgRating = $ratings->avg('rating');
            $food->avgRating = $avgRating;
        }
        $obj->foods = $foods;

        return response()->json([
            'status' => true,
            'data' => $obj,
            'error' => []
        ]);
    }



    public function categoryFood($request, $cat_id)
    {


        $foods = SubCategory::select('id', 'name', 'image', 'price')->where('category_id', $cat_id)->paginate(10);

        if ($foods) {


            foreach ($foods as $food) {
                $favorite = Favorite::where('user_id', $request->user_id)
                    ->where('sub_category_id', $food->id)
                    ->exists();

                $ratings = Rating::where('sub_category_id', $food->id)->get();
                $avgRating = $ratings->avg('rating');

                $food->rating = $avgRating;
                $food->is_favorite = $favorite;
            }

            return response()->json([
                'status' => true,
                'data' => $foods,
                'error' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'data' => $foods,
                'error' => ['Category id is invalid']
            ]);
        }
    }

    public function foodDetail($request, $food_id)
    {
        $obj  = new stdClass();

        $food = SubCategory::where('id', $food_id)->first();

        $ratings = Rating::where('sub_category_id', $food_id)->orderBy('created_at', 'desc')->limit(3)->get();

        $avgRating = $ratings->avg('rating');

        foreach ($ratings as $rating) {
            $user = User::select('id', 'name', 'username')->where('id', $rating->user_id)->first();
            $rating->user = $user;
        }

        $favorite = Favorite::where('user_id', $request->user_id)
            ->where('sub_category_id', $food->id)
            ->exists();

        $food->is_favorite = $favorite;

        $food->avgRating = $avgRating;
        $food->ratings = $ratings;

        if ($food) {
            return response()->json([
                'status' => true,
                'data' => $food,
                'error' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'data' => $obj,
                'error' => ['Food id is invalid']
            ]);
        }
    }


    public function listCategories()
    {
        $obj = new stdClass();
        $categories = Category::select('id', 'name', 'image')->get();

        if ($categories) {
            return response()->json([
                'status' => true,
                'data' => $categories,
                'error' => []
            ]);
        } else {
            return response()->json([
                'status' => true,
                'data' => $obj,
                'error' => []
            ]);
        }
    }

    public function addRating($request)
    {
        $obj  = new stdClass();

        $rate = new Rating();
        $rate->user_id = $request->user_id;
        $rate->sub_category_id = $request->food_id;
        $rate->rating = $request->rating;

        if ($request->has('feedback')) {
            $rate->feedback = $request->feedback;
        }
        $rate->save();
        return response()->json([
            'status' => true,
            'action' => 'Rating added',
            'data' => $obj,
            'error' => []
        ]);
    }

    public function listRating($food_id)
    {

        $obj = new stdClass();
        $ratings = Rating::where('sub_category_id', $food_id)->orderBy('created_at', 'desc')->get();

        $avgRating = $ratings->avg('rating');

        foreach ($ratings as $rating) {
            $user = User::select('id', 'name', 'username')->where('id', $rating->user_id)->first();
            $rating->user = $user;
        }

        $obj->avgRating = $avgRating;
        $obj->rating = $ratings;

        return response()->json([
            'status' => true,
            'data' => $obj,
            'error' => []
        ]);
    }

    public function listDeals()
    {
        $obj = new stdClass();
        $deals = Deal::with('product:id,image,name')->select('sub_category_id', 'discount_percentage')->orderBy('created_at', 'desc')->get();
        if ($deals) {
            return response()->json([
                'status' => true,
                'data' => $deals,
                'error' => []
            ]);
        } else {
            return response()->json([
                'status' => true,
                'data' => $obj,
                'error' => []
            ]);
        }
    }


    public function dealDetail($deal_id)
    {
        $obj = new stdClass();

        $deal = Deal::with('product')->where('id', $deal_id)->select('id', 'sub_category_id', 'discount_percentage')->first();
        if ($deal) {

            $ratings = Rating::where('sub_category_id', $deal->sub_category_id)->orderBy('created_at', 'desc')->limit(3)->get();
            $avgRating = $ratings->avg('rating');
            foreach ($ratings as $rating) {
                $user = User::select('id', 'name', 'username')->where('id', $rating->user_id)->first();
                $rating->user = $user;
            }

            $actualPrice = $deal->product->price;
            $discountPercentage = $deal->discount_percentage;

            $discountPrice = $actualPrice - ($actualPrice * ($discountPercentage / 100));
            $deal->discountPrice = $discountPrice;
            $deal->avgRating = $avgRating;
            $deal->rating = $ratings;

            return response()->json([
                'status' => true,
                'data' => $deal,
                'error' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'data' => $obj,
                'error' => ['Deal not found']
            ]);
        }
    }

    public function search($request)
    {

        $search = SubCategory::select('id', 'name', 'price', 'image')->where('name', 'like', "%$request->name%")->get();

        return response()->json([
            'status' => true,
            'data' => $search,
            'error' => []
        ]);
    }

    public function favorite($request)
    {

        $favorite = Favorite::where('user_id',$request->user_id)->where('sub_category_id',$request->food_id)->first();
        if($favorite){

            $favorite->delete();

            return response()->json([
                'status' => true,
                'action' => 'Favorite remove'
            ]);
        }
        else{
            $favorite = new Favorite();
            $favorite->user_id = $request->user_id;
            $favorite->sub_category_id = $request->food_id;
    
            $favorite->save();
            return response()->json([
                'status' => true,
                'action' => 'Favorite added'
            ]);
        }
       

        
    }

    public function favoriteList($request)
    {
        $favorites =  Favorite::with('favorites')->select('sub_category_id')->where('user_id', $request->user_id)->get();
        foreach ($favorites as $favorite) {

            $ratings = Rating::where('sub_category_id', $favorite->sub_category_id)->get();
            $avgRating = $ratings->avg('rating');
            $favorite->rating = $avgRating;
        }
        return response()->json([
            'status' => true,
            'action' => 'Favourite list',
            'data' =>   $favorites,
            'error' => []
        ]);
    }

}
