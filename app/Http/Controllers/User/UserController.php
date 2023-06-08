<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CategoryFoodRequest;
use App\Http\Requests\User\FavoriteRequest;
use App\Http\Requests\User\RatingRequest;
use App\Models\Category;
use App\Models\Deal;
use App\Models\SubCategory;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use stdClass;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

  
    public function homePage(){
        return $this->userService->homePage();
        
    }

    public function categoryFood(CategoryFoodRequest $request,$cat_id){
        return $this->userService->categoryFood($request,$cat_id);

    }


    public function foodDetail(CategoryFoodRequest $request,$food_id){
        return $this->userService->foodDetail($request,$food_id);

    }

    public function addRating(RatingRequest $request){
        return $this->userService->addRating($request);

    }

    public function listCategories(){
        return $this->userService->listCategories();

    }

    public function listRating($food_id){
        return $this->userService->listRating($food_id);

    }

    public function listDeals(){
        return $this->userService->listDeals();
    }

    public function dealDetail($deal_id){
        return $this->userService->dealDetail($deal_id);
        
    }

    public function search(Request $request){
        return $this->userService->search($request);
        
    }

    public function favorite(FavoriteRequest $request){
        return $this->userService->favorite($request);
        
    }
    public function favoriteList(CategoryFoodRequest $request){
        return $this->userService->favoriteList($request);
        
    }
}
