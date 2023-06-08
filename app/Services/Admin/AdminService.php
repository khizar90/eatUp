<?php

namespace  App\Services\Admin;

use App\Models\Category;
use App\Models\Deal;
use App\Models\SubCategory;

class AdminService{
    
    public function addCategory($request,$filename)
    {

        

        $categories = new Category();
        $categories->name = $request->category;
        $categories->image = $filename;

        $categories->save();
        $categories = Category::paginate(10);
        session()->flash('add', 'catgory added successfully!');

        return view('categories', compact('categories'));
    }

    public function updateCategory($request, $cat_id,$filename)
    {


        $cat = Category::where('id', $cat_id)->first();
        $cat->name = $request->category_name;
        if($filename){
            $cat->image = $filename;
        }
        $cat->save();
        return redirect()->back();
    }


    public function addSubCategory($request,$filename)
    {

        $categories = new SubCategory();
        $categories->name = $request->name;
        $categories->time = $request->time;
        $categories->discription = $request->discription;
        $categories->price = $request->price;
        $categories->category_id = $request->category_id;

        $categories->image = $filename;

        $categories->save();

        session()->flash('add', 'Product added successfully!');
        return redirect()->back();
    }

    public function updateSubCategory($request,$filename)
    {

       
        $cat = SubCategory::where('id', $request->id)->first();
        $cat->name = $request->name;
        $cat->discription = $request->discription;
        $cat->price = $request->price;
        $cat->category_id = $request->category_id;


        if ($filename) {
            $cat->image = $filename;
        }

        $cat->save();

        $cat_id = $request->category_id;
        session()->flash('add', 'Product updated successfully!');

        return redirect()->route('listSubCategories', ['cat_id' => $cat_id]);
    }

    public function adddeals($request)
    {
        
        $deal = new Deal();

        $deal->sub_category_id = $request->sub_category_id;
        $deal->discount_percentage = $request->percentage;

        $deal->save();
        session()->flash('add', 'Product updated successfully!');

        return redirect()->back();
    }

    public function updateDeals($request, $cat_id)
    {
     
        Deal::where('id', $cat_id)->update([
            'discount_percentage' =>  $request->percentage
        ]);
        session()->flash('edit', 'Deal Price updated successfully!');

        return redirect()->back();
    }
}