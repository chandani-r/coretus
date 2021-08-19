@extends('layouts.app')
@section('content')
    <section>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                        <input type="hidden" name="id" id="product_id">
                    </div>
                    @php
                        // $id = "<script>$('#product_modal').attr('data-id');</script>";
                        $product_image = explode(",",$product->image);
                    @endphp
                    <div class="modal-body">
                        <div class="row no-gutters">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <!-- Product Slider -->
                                    <div class="product-gallery">
                                        <div class="quickview-slider-active">
                                            @foreach ($product_image as $pro_key => $pro_value)
                                                <div class="single-slider">
                                                    <img src="{{asset('img/product/'.$pro_value)}}" alt="#">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                <!-- End Product slider -->
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="quickview-content">
                                    <h2>{{$product->name}}</h2>
                                    <div class="quickview-ratting-review">
                                        <div class="quickview-ratting-wrap">
                                            <div class="quickview-ratting">
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <a href="#"> (1 customer review)</a>
                                        </div>
                                        <div class="quickview-stock">
                                            <span><i class="fa fa-check-circle-o"></i> in stock</span>
                                        </div>
                                    </div>
                                    <span class="old"><del>{{$product->price}}</del></span>
                                    <span><strong>{{$product->discount_price}}</strong></span>
                                    <div class="quickview-peragraph">
                                        {!! $product->detailed_description!!}
                                    </div>
                                    <div class="size">
                                        <div class="row">
                                            <div class="col-lg-6 col-12">
                                                <h5 class="title">Size</h5>
                                                <select>
                                                    <option selected="selected">s</option>
                                                    <option>m</option>
                                                    <option>l</option>
                                                    <option>xl</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <h5 class="title">Color</h5>
                                                <select>
                                                    <option selected="selected">orange</option>
                                                    <option>purple</option>
                                                    <option>black</option>
                                                    <option>pink</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="quantity">
                                        <!-- Input Order -->
                                        <div class="input-group">
                                            <div class="button minus">
                                                <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                </button>
                                            </div>
                                            <input type="number" name="quant[]" class="input-number"  data-min="1" data-max="1000">
                                            <div class="button plus">
                                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                    {{-- <i class="ti-plus"></i> --}}
                                                </button>
                                            </div>
                                        </div>
                                        <!--/ End Input Order -->
                                    </div>
                                    <div class="add-to-cart">
                                        <form action="{{ route('product.checkout') }}" method="POST" >

                                            @csrf
                                            
                                            <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('RAZORPAY_KEY') }}" data-amount="1000" data-buttontext="Add to Cart" data-buttonclass="btn b" data-name="add-to-cart" data-description="Rozerpay" data-image="" data-prefill.name="name" data-prefill.email="email" data-theme.color="#528FF0"></script>
                                            <input type="hidden" name="id" value="{{ $product->id}}">

                                        </form>
                                        {{-- <a href="{{route('product.checkout')}}" class="btn">Add to cart</a> --}}
                                        @php
                                            $add_to_favorite = \App\Models\AddtoFavorite::where('product_id',$product->id)->where('add_to_favourite','y')->first();   
                                        @endphp
                                        <a alt="Add to Wish List" title="Add to Wish List" href="javascript:void(0);" class="btn min {{!empty($add_to_favorite)?"":"active"}}"> <i class="fa fa-heart add_to_favourite" ><input type="hidden" name="id" class="product-id" value="{{$product->id}}"></i></a>

                                        {{-- <a href="javascript:void(0);" class="btn min"><i class="fa fa-heart"></i></a> --}}
                                        <a href="#" class="btn min"><i class="fa fa-compress"></i></a>
                                    </div>
                                    <div class="default-social">
                                        <h4 class="share-now">Share:</h4>
                                        <ul>
                                            <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                            <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    <script>
        $(function () {
            $("#exampleModal").modal("show"); 
            $(".add_to_favourite").on("click",function(){
                alert("askdjkas");
                var id = $(".product-id").val();
                console.log(id);
                $.ajax({
                    type:"post",
                    url:"{{route('product.wishlist')}}",
                    data:{ 
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    success:function(data, textStatus, jqXHR){
                        // console.log(data);
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                    }
                })
            });
        })
       
    </script>
@endsection