<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('category/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('category/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageName = time().'.'.$request->category_image->extension();  
        $request->category_image->move(public_path('img'), $imageName);
        Category::create(['name'=>$request->name,'cat_id'=>$request->category_id == 'any'?0:$request->category_id,'status'=>$request->status == "on"?"active":"inactive",'image'=>$imageName]);
        return redirect('category/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category,Request $request)
    {
        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);

        if(count($uri_segments) !== 3){
            $category = Category::where('id',$uri_segments[3])->first();
        }else{
            $category = [];
        }
        $data = $request->all();
        return view('category.edit',['category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if($request->category_image != null){
            $imageName = time().'.'.$request->category_image->extension();  
            $request->category_image->move(public_path('img'), $imageName);
        }else{
            $imageName = $request->category_image;
        }
        Category::where('id',$request->id)->update(['name'=>$request->name,'cat_id'=>$request->category_id == 'any'?0:$request->category_id,'status'=>$request->status == "on"?"active":"inactive",'image'=>$imageName]);
        return redirect('category/index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Request $request)
    {
        $category_detail = Category::where('id',$request->id)->first();
        $image_path = public_path('img/'.$category_detail->image); 
        if(file_exists($image_path)) {
            @unlink($image_path);
        }
        $category_detail->delete();
        return redirect('category/index')->with('delete', 'Category Deleted Successfully');

    }
}
