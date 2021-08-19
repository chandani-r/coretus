@extends('layouts.app')
@section('content')
    <section class="jumbotron text-center">
        <div class="category-page float-right">
            <a href="{{route('product.create')}}" class="btn btn-success"> Create New</a>
        </div>
        @php
            $products = \App\Models\Products::where('status','active')->select('id','name','price','discount_price','image')->get()->toArray();
        @endphp
        <div class="product-area most-popular section">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="section-title">
							<h2>Products</h2>
						</div>
					</div>
				</div>
                <div class="row">
                    @foreach ($products as $p_key => $p_value)
                    <div id="product_images_{{$p_key}}" class="carousel slide col-lg-4" data-ride="carousel">
                        <div class="carousel-inner">
                            @php
                                $product_image = explode(",",$p_value['image']);
                            @endphp
                            @foreach ($product_image as $i_key => $i_value)
                                <div class="carousel-item {{$i_key == "0"?"active":""}}" id="carousel_image_{{$i_key}}">
                                    <img class="" src="{{asset('img/product/'.$i_value)}}">
                                </div>
                            @endforeach
                        
                        </div>
                        <div class="product-content">
                            <h3><a href="{{url('product_detail/'.$p_value["id"])}}">{{$p_value['name']}}</a></h3>
                            <div class="product-price">
                                <span class="old"><del> {{$p_value['price']}}</del></span>
                                <span>{{$p_value['discount_price']}}</span>
                            </div>

                            <a href="{{url('product/edit/'.$p_value['id'])}}" class=" btn btn-success"><i class="fa fa-edit"></i></a>
                            <a href="{{url('product_detail/'.$p_value['id'])}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                            <form action="{{ route('product.delete', ['id'=>$p_value['id']]) }}" method="POST" onsubmit="return confirm('Are you sure want to delete');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="delete"> 
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="{{ $p_value['id'] }}">
                                <button type="submit" class="btn btn-danger"> 
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>


                        <a class="carousel-control-prev" href="#product_images_{{$p_key}}" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#product_images_{{$p_key}}" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                        </a>
                    </div>
                @endforeach
                </div>
                

			</div>
		</div>

    </section> 
    <script>
        $(function () {
            $('.carousel').carousel();
        })
    </script>
@endsection