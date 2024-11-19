<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
session_start();

class ProductController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');
        if (!$admin_id) {
            return Redirect::to('admin');
        }
    }

    public function add_product()
    {
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')
            ->orderBy('category_id', 'desc')
            ->get();
        $brand_product = DB::table('tbl_brand')
            ->orderBy('brand_id', 'desc')
            ->get();

        return view('admin.add_product')
            ->with('cate_product', $cate_product)
            ->with('brand_product', $brand_product);
    }

    public function save_product(Request $request)
    {
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_slug'] = $request->product_slug;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;

        $get_image = $request->file('product_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product', $new_image);
            $data['product_image'] = $new_image;
        } else {
            $data['product_image'] = '';
        }

        try {
            DB::table('tbl_product')->insert($data);
            Session::put('message', 'Thêm sản phẩm thành công');
            return Redirect::to('all-product');
        } catch (\Exception $e) {
            Session::put('message', 'Thêm sản phẩm thất bại: ' . $e->getMessage());
            return Redirect::to('add-product');
        }
    }
    public function all_product()
    {     $this->AuthLogin(); 
        $all_product = Product::orderBy('product_id', 'DESC')->get();
        
        return view('admin.all_product', [
            'all_product' => $all_product
        ]); 
    }
    public function unactive_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')
            ->where('product_id', $product_id)
            ->update(['product_status' => 1]);
        Session::put('message', 'Ẩn sản phẩm thành công');
        return Redirect::to('all-product');
    }

    public function active_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')
            ->where('product_id', $product_id)
            ->update(['product_status' => 0]);
        Session::put('message', 'Kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function delete_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')
            ->where('product_id', $product_id)
            ->delete();
        Session::put('message', 'Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function edit_product($product_id)
    {
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')
            ->orderBy('category_id', 'desc')
            ->get();
        $brand_product = DB::table('tbl_brand')
            ->orderBy('brand_id', 'desc')
            ->get();
        $edit_product = DB::table('tbl_product')
            ->where('product_id', $product_id)
            ->get();
        return view('admin.edit_product')
            ->with('edit_product', $edit_product)
            ->with('cate_product', $cate_product)
            ->with('brand_product', $brand_product);
    }
    public function show_category_home(Request $request ,$slug_category_product){
        $cate_product = DB::table('tbl_category_product')
        ->where('category_status','1')->orderby('category_id','desc')->get();  
                $brand_product = DB::table('tbl_brand')->where('brand_status','1')
        ->orderby('brand_id','desc')->get(); 
        $category_by_id = DB::table('tbl_product')
->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.cat
 egory_id')
->where('tbl_category_product.slug_category_product',$slug_category_product)
->get();
foreach($category_by_id as $key => $val){ 
    //seo  
      $meta_desc = $val->category_desc;  
      $meta_keywords = $val->meta_keywords; 
      $meta_title = $val->category_name; 
      $url_canonical = $request->url();
    }
    $category_name = DB::table('tbl_category_product')
    ->where('tbl_category_product.slug_category_product',$slug_category_product)
    ->limit(1)->get(); 
     
            return view('pages.category.show_category')->with('category',$cate_product)
    ->with('brand',$brand_product)->with('category_by_id',$category_by_id)
    ->with('category_name',$category_name)->with('meta_desc',$meta_desc)
    ->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
    ->with('url_canonical',$url_canonical);
}
}