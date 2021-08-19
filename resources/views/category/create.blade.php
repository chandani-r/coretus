@extends('layouts.app')
@section('content')
<!------ Include the above in your HEAD tag ---------->

<div class="container-fluid">
		<div class="container">
			<div class="formBox">
				{!! Form::open(['url'=>route('category.store'),'method'=>'post','enctype'=>"multipart/form-data"]) !!}
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
                                                <input type="text" name="name" id="name" class="form-control">
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
                                                            <option value="{{$c_value['id']}}">{{$c_value['name']}}</option>
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
                                                <input class="form-check-input" type="checkbox" name="status" id="flexSwitchCheckChecked" checked>
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
                                            <input type="file" name="category_image" id="category_image" >
                                            <label for="category_image"></label>
                                            <img id="preview_img" src="" class="" width="200" height="150"/>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="created_at" value="{{now();}}">
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
    <script>
        $(function () {

    //         $(document).ready(()=>{
    //   $('#photo').change(function(){
    //     const file = this.files[0];
    //     console.log(file);
    //     if (file){
    //       let reader = new FileReader();
    //       reader.onload = function(event){
    //         console.log(event.target.result);
    //         $('#imgPreview').attr('src', event.target.result);
    //       }
    //       reader.readAsDataURL(file);
    //     }
    //   });
    // });
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

            })
//             imgInp.onchange = evt => {
//   const [file] = imgInp.files
//   if (file) {
//     blah.src = URL.createObjectURL(file)
//   }
// } 
        });
    </script>
@endsection