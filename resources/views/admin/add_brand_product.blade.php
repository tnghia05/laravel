@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm thương hiệu sản phẩm
            </header>

            <div class="panel-body">
                <div class="position-center">
                    @if(Session::get('message'))
                        <div class="alert alert-success">
                            {{Session::get('message')}}
                        </div>
                    @endif

                    <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu</label>
                            <input type="text" name="brand_product_name" class="form-control" 
                                   placeholder="Tên thương hiệu">
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" name="brand_slug" class="form-control" 
                                   placeholder="Slug">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                            <textarea style="resize: none" rows="8" class="form-control" 
                                      name="brand_product_desc" placeholder="Mô tả thương hiệu"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="brand_product_status" class="form-control">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>

                        <button type="submit" name="add_brand_product" class="btn btn-info">
                            Thêm thương hiệu
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection