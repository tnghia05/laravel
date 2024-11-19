@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm sản phẩm
            </header>

            @if(Session::get('message'))
                <div class="alert alert-success">
                    {{Session::get('message')}}
                </div>
            @endif

            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label for="product_name">Tên sản phẩm</label>
                            <input type="text" 
                                   name="product_name" 
                                   class="form-control" 
                                   data-validation="length" 
                                   data-validation-length="min10" 
                                   data-validation-error-msg="Làm ơn điền ít nhất 10 ký tự"
                                   placeholder="Nhập tên sản phẩm">
                        </div>

                        <div class="form-group">
                            <label for="product_slug">Slug</label>
                            <input type="text" name="product_slug" class="form-control" placeholder="Nhập slug">
                        </div>

                        <div class="form-group">
                            <label for="product_price">Giá sản phẩm</label>
                            <input type="text" 
                                   name="product_price" 
                                   class="form-control"
                                   data-validation="number"
                                   data-validation-error-msg="Làm ơn điền số tiền"
                                   placeholder="Nhập giá sản phẩm">
                        </div>

                        <div class="form-group">
                            <label for="product_image">Hình ảnh sản phẩm</label>
                            <input type="file" name="product_image" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="product_desc">Mô tả sản phẩm</label>
                            <textarea style="resize: none" 
                                      rows="8" 
                                      class="form-control" 
                                      name="product_desc" 
                                      id="ckeditor1" 
                                      placeholder="Mô tả sản phẩm"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product_content">Nội dung sản phẩm</label>
                            <textarea style="resize: none" 
                                      rows="8" 
                                      class="form-control" 
                                      name="product_content"
                                      id="id4" 
                                      placeholder="Nội dung sản phẩm"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product_cate">Danh mục sản phẩm</label>
                            <select name="product_cate" class="form-control">
                                @foreach($cate_product as $key => $cate)
                                    <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product_brand">Thương hiệu</label>
                            <select name="product_brand" class="form-control">
                                @foreach($brand_product as $key => $brand)
                                    <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product_status">Hiển thị</label>
                            <select name="product_status" class="form-control">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>

                        <button type="submit" name="add_product" class="btn btn-info">
                            Thêm sản phẩm
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection