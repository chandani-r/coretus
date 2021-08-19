@extends('layouts.app')
@section('content')
<!------ Include the above in your HEAD tag ---------->

<div class="container-fluid">
		<div class="container">
			<div class="formBox">
				{!! Form::open(['url'=>route('product.update'),'method'=>'post','enctype'=>"multipart/form-data", 'data-rule-validate'=>'true']) !!}
                    <div class="row">
                        <div class="col-sm-8 offset-2">
                            <h1>Product Form</h1>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-sm-8 offset-2">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="name">Name</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="">
                                                <input type="text" name="name" id="name" class="form-control" value="{{$product->name}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="name">Price</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="">
                                                <input type="number" step="0.25" name="price" id="price" class="form-control" value="{{$product->price}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="name">Discount Price</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="">
                                                <input type="number" step="0.25" name="discount_price" id="discount_price" class="form-control" value="{{$product->discount_price}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="category_image">Product Image</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="product_image[]" id="product_image" multiple>
                                            {{-- <label for="category_image">Product Image</label> --}}
                                            @php
                                                
                                            $product_image = explode(",",$product->image);
                                            @endphp
                                            <div class="img-preview">
                                                @foreach ($product_image as $p_key => $p_value)
                                                    <img id="preview_img" src="{{asset('img/product/'.$p_value)}}" class=""/>
                                                @endforeach
                                                </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="category_image">Primary Image</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="primary_image" id="primary_image" multiple>
                                            {{-- <label for="category_image">Product Image</label> --}}
                                            @php
                                                
                                            $primary_image = $product->primary_image;
                                            @endphp
                                            <div class="img-preview">
                                                @if(!empty($primary_image))
                                                    {{-- @foreach ($primary_image as $prim_key => $prim_value) --}}
                                                        <img id="preview_primary_img" src="{{asset('img/product/primary_image/'.$primary_image)}}" class=""/>
                                                    {{-- @endforeach --}}
                                                @endif
                                                </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="name">Select Category</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control form-select" name="category_id" id="category_id">
                                                @php
                                                    $category = [];
                                                    $category = \App\Models\Category::where('status','active')->get()->toArray();   
                                                @endphp
                                                <option value="any">Select Category</option>
                                                    @if(!@empty($category))
                                                        @foreach ($category as $c_key => $c_value)
                                                            @php
                                                                $selected = $product['cat_id'] == $c_value['id']?"selected":"";   
                                                            @endphp
                                                            <option value="{{$c_value['id']}}" {{$selected}}>{{$c_value['name']}}</option>
                                                        @endforeach
                                                    @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="description">Description</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="">
                                                <textarea class="ckeditor form-control" name="description">{!! $product->description !!}</textarea>

                                                {{-- <textarea name="description" id="description" cols="30" rows="10" class="ckeditor"></textarea> --}}
                                                {{-- <input type="textarea" name="description" id="description" class="ckeditor"> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="description">Detailed Description</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="">
                                                <textarea class="ckeditor form-control" name="detailed_description">{!! $product->detailed_description !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="description">Video</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="">
                                                <input type="file" name="video" accept="video/mp4,video/x-m4v,video/*">
                                                <video src=""></video>
                                                {{-- <textarea class="ckeditor form-control" name="detailed_description"></textarea> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="flexSwitchCheckChecked">Status</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="status" id="flexSwitchCheckChecked" {{$product->status == "active"?"checked":"off"}}>
                                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                              </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="id" value="{{$product->id}}">
                                <input type="hidden" name="updated_at" value="{{now();}}">
                                <input type="submit" value="Submit" class="btn btn-sucess" style="align-content: center">
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
				{!! Form::close()!!}
			</div>
		</div>
	</div>  
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        $(function () {
            $('.ckeditor').ckeditor({fullPage:true});
            $("#product_image").on("change",function () {
                var file = this.files[0];
                if (file){
                        let reader = new FileReader();
                        reader.onload = function(event){
                            console.log(event.target.result);
                            $('#preview_img').attr('src', event.target.result);
                        }
                    reader.readAsDataURL(file);
                    }

                }) 
            });
            $("#primary_image").on("change",function () {
                var file = this.files[0];
                if (file){
                        let reader = new FileReader();
                        reader.onload = function(event){
                            console.log(event.target.result);
                            $('#preview_primary_img').attr('src', event.target.result);
                        }
                    reader.readAsDataURL(file);
                    }

                }) 
            });
    </script>
@endsection