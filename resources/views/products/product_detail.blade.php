@extends('layouts.app')
@section('content')
<section id="services" class="services section-bg">
    <div class="container-fluid">
        @php
        $product_image = explode(",",$product->image);
            // print_r($product);exit;
        @endphp
       <div class="row row-sm">
          <div class="col-md-6 _boxzoom">
             <div class="zoom-thumb">
                <ul class="piclist">
                    @foreach ($product_image as $key => $value)
                        <li><img src="{{asset('img/product/'.$value)}}" alt=""></li>
                    @endforeach
                   
                </ul>
             </div>
             <div class="_product-images">
                <div class="picZoomer">
                   <img class="my_img" src="{{asset('img/product/primary_image/'.$product->primary_image)}}" alt="">
                </div>
             </div>
          </div>
          <div class="col-md-6">
             <div class="_product-detail-content">
                <p class="_p-name"> {{$product->name}} </p>
                <div class="_p-price-box">
                   <div class="p-list">
                      <span> M.R.P. : <i class="fa fa-inr"></i> <del> {{$product->price}}  </del>   </span>
                      <span class="price"> {{$product->discount_price}} </span>
                   </div>
                   <div class="_p-add-cart">
                      <div class="_p-qty">
                         <span>Add Quantity</span>
                         <div class="value-button decrease_" id="" value="Decrease Value">-</div>
                         <input type="number" name="qty" id="number" value="1" />
                         <div class="value-button increase_" id="" value="Increase Value">+</div>
                      </div>
                   </div>
                   <div class="_p-features">
                      <span> Description About this product:- </span>
                      {!! $product->description !!}                       
                   </div>
                   <form action="" method="post" accept-charset="utf-8">
                      <ul class="spe_ul"></ul>
                      <div class="_p-qty-and-cart">
                         <div class="_p-add-cart">
                             <a href="{{url('product/add_to_cart/'.$product['id'])}}" class="btn-theme btn buy-btn" tabindex="0">  <i class="fa fa-shopping-cart"></i> Buy Now</a>
                            {{-- <button >
                            <i class="fa fa-shopping-cart"></i> Buy Now
                            </button> --}}
                            <button class="btn-theme btn btn-success" tabindex="0">
                            <i class="fa fa-shopping-cart"></i> Add to Cart
                            </button>
                            <input type="hidden" name="pid" value="18" />
                            <input type="hidden" name="price" value="850" />
                            <input type="hidden" name="url" value="" />    
                         </div>
                      </div>
                   </form>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
 <section class="sec bg-light">
    <div class="container">
       <div class="row">
          <div class="col-sm-12 title_bx">
             <h3 class="title"> Recent Post   </h3>
          </div>
       </div>
       @php
           $recent_product = \App\Models\Products::where('id','!=',$product['id'])
                        ->where('price','>=', $product['discount_price'])
                        ->orwhere('price','=<',$product['discount_price'])
                        ->where('cat_id',$product['cat_id'])
                        ->get()->toArray();
            // print_r($recent_product);exit;
            // ->where('price','>', $product['discount_price'])->orwhere('price','<',$product['discount_price'])->orwhere('cat_id',$product['cat_id'])
       @endphp
       <div class="row">
          <div class="col-md-12 list-slider mt-4">
             <div class="owl-carousel common_wd  owl-theme" id="recent_post">
                 @foreach ($recent_product as $r_key => $r_value)
                    <div class="item">
                        <div class="sq_box shadow">
                        <div class="pdis_img"> 
                            <span class="wishlist">
                                {{-- <input type="hidden" name="id" class="product-id" value="{{$r_value['id']}}"> --}}
                                <a alt="Add to Wish List" title="Add to Wish List" href="javascript:void(0);" class="add-to-favorite"> <i class="fa fa-heart add_to_favourite" ><input type="hidden" name="id" class="product-id" value="{{$r_value['id']}}"></i></a>
                            </span>
                            <a href="#">
                            <img src="{{asset('img/product/primary_image/'.$r_value['primary_image'])}}"> 
                            </a>
                        </div>
                        <h4 class="mb-1"> <a href="{{url('product/product_detail/'.$r_value['id'])}}"> {{$r_value['name']}} </a> </h4>
                        <div class="price-box mb-2">
                            <span class="price"> Price <i class="fa fa-inr"></i> {{$r_value['price']}} </span>
                            <span class="offer-price"> Offer Price <i class="fa fa-inr"></i> {{$r_value['discount_price']}} </span>
                        </div>
                        <div class="btn-box text-center">
                            <a class="btn btn-sm" href="{{url('product/add_to_cart/'.$r_value['id'])}}"> <i class="fa fa-shopping-cart"></i> Add to Cart </a>
                        </div>
                        </div>
                    </div>
                 @endforeach
             </div>
          </div>
       </div>
    </div>
 </section>
 <script>

;(function($){
	$.fn.picZoomer = function(options){
		var opts = $.extend({}, $.fn.picZoomer.defaults, options), 
			$this = this,
			$picBD = $('<div class="picZoomer-pic-wp"></div>').css({'width':opts.picWidth+'px', 'height':opts.picHeight+'px'}).appendTo($this),
			$pic = $this.children('img').addClass('picZoomer-pic').appendTo($picBD),
			$cursor = $('<div class="picZoomer-cursor"><i class="f-is picZoomCursor-ico"></i></div>').appendTo($picBD),
			cursorSizeHalf = {w:$cursor.width()/2 ,h:$cursor.height()/2},
			$zoomWP = $('<div class="picZoomer-zoom-wp"><img src="" alt="" class="picZoomer-zoom-pic"></div>').appendTo($this),
			$zoomPic = $zoomWP.find('.picZoomer-zoom-pic'),
			picBDOffset = {x:$picBD.offset().left,y:$picBD.offset().top};

		
		opts.zoomWidth = opts.zoomWidth||opts.picWidth;
		opts.zoomHeight = opts.zoomHeight||opts.picHeight;
		var zoomWPSizeHalf = {w:opts.zoomWidth/2 ,h:opts.zoomHeight/2};
		$zoomWP.css({'width':opts.zoomWidth+'px', 'height':opts.zoomHeight+'px'});
		$zoomWP.css(opts.zoomerPosition || {top: 0, left: opts.picWidth+30+'px'});
		$zoomPic.css({'width':opts.picWidth*opts.scale+'px', 'height':opts.picHeight*opts.scale+'px'});
		$picBD.on('mouseenter',function(event){
			$cursor.show();
			$zoomWP.show();
			$zoomPic.attr('src',$pic.attr('src'))
		}).on('mouseleave',function(event){
			$cursor.hide();
			$zoomWP.hide();
		}).on('mousemove', function(event){
			var x = event.pageX-picBDOffset.x,
				y = event.pageY-picBDOffset.y;

			$cursor.css({'left':x-cursorSizeHalf.w+'px', 'top':y-cursorSizeHalf.h+'px'});
			$zoomPic.css({'left':-(x*opts.scale-zoomWPSizeHalf.w)+'px', 'top':-(y*opts.scale-zoomWPSizeHalf.h)+'px'});
		});
		return $this;
	};
	$.fn.picZoomer.defaults = {
        picHeight: 460,
		scale: 2.5,
		zoomerPosition: {top: '0', left: '380px'},
		zoomWidth: 400,
		zoomHeight: 460
	};
})(jQuery); 
$(document).ready(function () {
     $('.picZoomer').picZoomer();
    $('.piclist li').on('click', function (event) {
        var $pic = $(this).find('img');
        $('.picZoomer-pic').attr('src', $pic.attr('src'));
    });
    var owl = $('#recent_post');
              owl.owlCarousel({
                margin:20,
                dots:false,
                nav: true,
                navText: [
                  "<i class='fa fa-chevron-left'></i>",
                  "<i class='fa fa-chevron-right'></i>"
                ],
                autoplay: true,
                autoplayHoverPause: true,
                responsive: {
                  0: {
                    items: 2
                  },
                  600: {
                    items:3
                  },
                  1000: {
                    items:5
                  },
                  1200: {
                    items:4
                  }
                }
            });    
  
        $('.decrease_').click(function () {
            decreaseValue(this);
        });
        $('.increase_').click(function () {
            increaseValue(this);
        });
        function increaseValue(_this) {
            var value = parseInt($(_this).siblings('input#number').val(), 10);
            value = isNaN(value) ? 0 : value;
            value++;
            $(_this).siblings('input#number').val(value);
        }

        function decreaseValue(_this) {
            var value = parseInt($(_this).siblings('input#number').val(), 10);
            value = isNaN(value) ? 0 : value;
            value < 1 ? value = 1 : '';
            value--;
            $(_this).siblings('input#number').val(value);
        }
    });

    $(function() {
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
    });

 </script>
@endsection