@extends('layouts.app')
@section('content')
<!------ Include the above in your HEAD tag ---------->
   <div class="container-fluid">
        <div class="container">
            <div class="formBox">
                {!! Form::open(['url'=>route('category.update'),'method'=>'post','enctype'=>"multipart/form-data"]) !!}
                    <div class="row">
                        <div class="col-sm-8 offset-2">
                            <h1>Category form</h1>
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
                                                <input type="text" name="name" id="name" class="form-control" value="{{$category->name}}">
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
                                                    $categories = [];
                                                    $categories = \App\Models\Category::where('status','active')->get()->toArray();   
                                                @endphp
                                                <option value="any">Select Category</option>
                                                    @if(!@empty($categories))
                                                        @foreach ($categories as $c_key => $c_value)
                                                        @php

                                                            $selected = $c_value['id'] == $category->cat_id?"selected":"";   
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
                                            <label for="flexSwitchCheckChecked">Status</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="status" id="flexSwitchCheckChecked" {{$category->status == "active"?"checked":""}}>
                                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="flexSwitchCheckChecked">Category Image</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="file" name="category_image" id="category_image" value="{{asset('img/'.$category->image)}}" >
                                            <label for="category_image"></label>
                                            <input type="hidden" name="cateory_image" value="{{$category->image}}">
                                            <img id="preview_img" src="{{asset('img/'.$category->image)}}" class="" width="200" height="150"/>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="{{$category->id}}">
                                <input type="submit" value="Submit" class="btn btn-sucess" style="align-content: center">
                            </div>
                        </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>  
    <script>
        $(function () {
            $("#category_image").on("change",function () {
                var file = this.files[0];
                if (file){
                    let reader = new FileReader();
                    reader.onload = function(event){
                        console.log(event.target.result);
                        $('#preview_img').attr('src', event.target.result);
                    }
                reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection