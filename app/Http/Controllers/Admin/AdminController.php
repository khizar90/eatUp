<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ImageUploadAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddCategoryRequest;
use App\Http\Requests\Admin\AddDealRequest;
use App\Http\Requests\Admin\AddProductRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Requests\Admin\UpdateDealRequest;
use App\Models\Category;
use App\Models\Deal;
use App\Models\SubCategory;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }


    public function listCategories()
    {

        $categories = Category::paginate(15);

        return view('categories', compact('categories'));
    }


    public function addCategory(AddCategoryRequest $request, ImageUploadAction $image)
    {

        $images = $request->file('image');
        $filename = $image->handle('cat_images', $images);
        return $this->adminService->addCategory($request, $filename);
    }


    public function deleteCategory($cat_id)
    {

        Category::where('id', $cat_id)->delete();
        return redirect()->back()->with('delete', 'Record Delete');
    }



    public function updateCategory(UpdateCategoryRequest $request, $cat_id, ImageUploadAction $image)
    {

        if (($request->hasFile('category_image'))) {
            $images = $request->file('category_image');
            $filename = $image->handle('cat_images', $images);
        } else {
            $filename = '';
        }
        return $this->adminService->updateCategory($request, $cat_id, $filename);
    }

    public function getCategories()
    {
        $categories = Category::all();
        return view('addProduct', compact('categories'));
    }

    public function addSubCategory(AddProductRequest $request,ImageUploadAction $image)
    {
    
        $images = $request->file('image');
        $filename = $image->handle('sub_cat_images', $images);
        return $this->adminService->addSubCategory($request, $filename);
    }


    public function listSubCategories($cat_id)
    {
        $categoryname = Category::find($cat_id);
        $categories =  SubCategory::where('category_id', $cat_id)->paginate(15);

        return view('listProduct', compact('categories', 'categoryname'));
    }


    public function deleteSubCategory($cat_id)
    {

        SubCategory::where('id', $cat_id)->delete();
        return redirect()->back()->with('delete', 'Record Delete');
    }

    public function editSubCategory($cat_id)
    {

        $categories = Category::all();
        $subcat = SubCategory::where('id', $cat_id)->first();
        return view('editProduct', compact('categories', 'subcat'));
    }


    public function updateSubCategory(AddProductRequest $request,ImageUploadAction $image)
    {

        if (($request->hasFile('category_image'))) {
            $images = $request->file('category_image');
            $filename = $image->handle('sub_cat_images', $images);
        }
        else{
            $filename = '';
        }

        return $this->adminService->updateSubCategory($request, $filename);

    }


    public function showadddeals()
    {
        $products =  SubCategory::all();

        return view('adddeals', compact('products'));
    }

    public function adddeals(AddDealRequest $request)
    {
        
        return $this->adminService->adddeals($request);
      
    }

    public function listDeals()
    {


        $categories = Deal::with('product')->paginate(15);

        return view('listDeals', compact('categories'));
    }

    public function updateDeals(UpdateDealRequest $request, $cat_id)
    {
        return $this->adminService->updateDeals($request,$cat_id);
     
        
    }

    public function deleteDeal($cat_id)
    {

        Deal::where('id', $cat_id)->delete();
        return redirect()->back()->with('delete', 'Record Delete');
    }
}
