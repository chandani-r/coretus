@extends('layouts.app')
@section('content')
    <section class="jumbotron text-center">
        <div class="category-page">
            <a href="{{route('category.create')}}" class="btn btn-sucess"> Create New</a>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-3">
                    <div class="card bg-light mb-3">
                        <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-list"></i> Categories</div>
                        <ul class="list-group category_block">
                            @php
                                $category = \App\Models\Category::where('status','active')->where('cat_id',0)->get()->toArray();   
                                $sub_category = \App\Models\Category::where('status','active')->where('cat_id','!=',0)->get()->toArray();   
                            @endphp
                                @foreach ($category as $c_key => $c_value)
                                    <li class="list-group-item" data-value="{{$c_value['name']}}" id="cat_{{$c_value['id']}}"><a href="#cat_{{$c_value['id']}}">{{$c_value['name']}}</a></li>
                                @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                            @foreach ($sub_category as $s_key => $s_value)
                                @php
                                    $cat = \App\Models\Category::where('id',$s_value['cat_id'])->first();
                                @endphp
                            <div class="col-12 col-md-6 col-lg-4 cat_img" id="cat_{{$s_value['cat_id']}}">
                                <div class="card" >
                                    <div class="cat-img">
                                        <img class="card-img-top" src="{{asset('img/'.$s_value['image'])}}">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title"><a href="product.html" title="View Product">{{$s_value['name']}}</a></h4>
                                    </div>
                                </div>
                                <a href="{{url('category/edit/'.$s_value['id'])}}" class="btn-success"><i class="fa fa-pencil"></i></a>

                                <a href="{{route('category.show')}}" class="btn-info"><i class="fa fa-eye"></i></a>
                                <form action="{{ route('category.delete', ['id'=>$s_value['id']]) }}" method="POST" onsubmit="return confirm('Are you sure want to delete');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="delete"> 
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id" value="{{ $s_value['id'] }}">
                                    <button type="submit">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section> 
    <script>
        $(function () {
            
      
        });
    </script>  
@endsection