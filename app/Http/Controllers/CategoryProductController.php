<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CategoryProductController extends Controller
{
    // Add this method
    public function add_category_product(){
        $this->AuthLogin();
        return view('admin.add_category_product');
    }

    // Your existing methods
    public function all_category_product(){ 
        $this->AuthLogin(); 
        $all_category_product = DB::table('tbl_category_product')->get(); 
        $manager_category_product = view('admin.all_category_product')
            ->with('all_category_product',$all_category_product); 
        return view('admin_layout')
            ->with('admin.all_category_product', $manager_category_product); 
    }

    public function save_category_product(Request $request){ 
        $this->AuthLogin(); 
        $data = array(); 
        $data['category_name'] = $request->category_product_name;
        $data['category_product_keywords'] = $request->category_product_keywords;
        $data['slug_category_product'] = $request->slug_category_product;
        $data['category_desc'] = $request->category_product_desc;
        $data['category_status'] = $request->category_product_status;

        DB::table('tbl_category_product')->insert($data);
        Session::put('message','Thêm danh mục sản phẩm thành công');
        return Redirect::to('add-category-product');
    }

    public function AuthLogin(){ 
        $admin_id = Session::get('admin_id'); 
        if(!$admin_id){ 
            return Redirect::to('admin');
        }
    }
    public function unactive_category_product($category_product_id){ 
        $this->AuthLogin();
        DB::table('tbl_category_product')
            ->where('category_id', $category_product_id)  // Fix arrow operator
            ->update(['category_status' => 1]);
        Session::put('message','Ẩn danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    
    public function active_category_product($category_product_id){ 
        $this->AuthLogin();
        DB::table('tbl_category_product')
            ->where('category_id', $category_product_id)  // Fix arrow operator
            ->update(['category_status' => 0]);
        return Redirect::to('all-category-product');
    }
    public function delete_category_product($category_product_id){ 
        $this->AuthLogin();
        DB::table('tbl_category_product')
            ->where('category_id', $category_product_id)  // Fix arrow operator
            ->delete();
        Session::put('message','Xóa danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

public function show_category_home(Request $request, $slug_category_product)
{
    try {
        // Get categories
        $cate_product = DB::table('tbl_category_product')
            ->where('category_status', '1')
            ->orderBy('category_id', 'desc')
            ->get();

        // Get brands    
        $brand_product = DB::table('tbl_brand')
            ->where('brand_status', '1')
            ->orderBy('brand_id', 'desc')
            ->get();

        // Get products by category - Fixed column name spacing
        $category_by_id = DB::table('tbl_product')
            ->select('tbl_product.*', 'tbl_category_product.category_name', 
                    'tbl_category_product.category_desc', 'tbl_category_product.meta_keywords')
            ->join('tbl_category_product', function($join) {
                $join->on('tbl_product.category_id', '=', 'tbl_category_product.category_id');
            })
            ->where('tbl_category_product.slug_category_product', $slug_category_product)
            ->get();

        if($category_by_id->isEmpty()) {
            return redirect()->back()->with('message', 'No products found in this category');
        }

        // Get first item for meta data
        $first_item = $category_by_id->first();
        $meta_desc = $first_item->category_desc;
        $meta_keywords = $first_item->meta_keywords;
        $meta_title = $first_item->category_name;
        $url_canonical = $request->url();

        $category_name = DB::table('tbl_category_product')
            ->where('slug_category_product', $slug_category_product)
            ->first();

        return view('pages.category.show_category', compact(
            'category', 'brand_product', 'category_by_id', 
            'category_name', 'meta_desc', 'meta_keywords',
            'meta_title', 'url_canonical'
        ));

    } catch(\Exception $e) {
        \Log::error($e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while loading the category');
    }
}

}
