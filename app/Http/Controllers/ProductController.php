<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\AddtoFavorite;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r($request->all());exit;
        $product_image = $request->product_image;
        foreach($product_image as $key => $value){
            $imageName = time().rand(3,5).'.'.$value->extension();  
            $value->move(public_path('img/product'), $imageName);
            $pro_img[] = $imageName; 
        }
        Products::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'discount_price'=>$request->discount_price,
            'cat_id'=>$request->category_id == "any"?0:$request->category_id,
            'description'=>$request->description,
            'detailed_description'=>$request->detailed_description,
            'status'=>$request->status == "on"?"active":"inactive",
            'image'=>implode(",",$pro_img) 
        ]);
        return redirect('product/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // $uri_segments = explode('/', $uri_path);

        // if(count($uri_segments) !== 3){
        //     $category = Category::where('id',$uri_segments[3])->first();
        // }else{
        //     $category = [];
        // }
        // $data = $request->all();
        // return view('product.edit',['category'=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        if(count($uri_segments) !== 3){
            $product = Products::where('id',$uri_segments[3])->first();
        }else{
            $product = [];
        }
        $data = $request->all();
        return view('products.edit',['product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $product)
    {
        // print_r($request->all());exit;
        $product_image = $request->product_image;
        $primary_image = $request->primary_image;
        $pro_img = [];
        if($product_image != null){
            foreach($product_image as $key => $value){
                $imageName = time().rand(3,5).'.'.$value->extension();  
                $value->move(public_path('img/product'), $imageName);
                $pro_img[] = $imageName; 
            }
        }
        if($primary_image != null){
            $primary_imageName = time().rand(3,5).'.'.$primary_image->extension();  
            $primary_image->move(public_path('img/product/primary_image'), $primary_imageName);
        }else{
            $primary_imageName = $primary_image;    
        }
       
        Products::where('id',$request->id)->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'discount_price'=>$request->discount_price,
            'cat_id'=>$request->category_id == "any"?0:$request->category_id,
            'description'=>$request->description,
            'detailed_description'=>$request->detailed_description,
            'status'=>$request->status == "on"?"active":"inactive",
            'image'=>implode(",",$pro_img),
            'primary_image'=>$primary_imageName 
        ]);
        return redirect('product/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $product, Request $request)
    {
        $product_detail = Products::where('id',$request->id)->first();
        $product_image = explode(",",$product_detail->image);
        foreach($product_image as $pro_key=>$pro_value){
            $image_path = public_path('img/product'.$product_detail->image); 
            if(file_exists($image_path)) {
                @unlink($image_path);
            }
        }
        $primary_image_path = public_path('img/product/primary_image'.$product_detail->primary_image); 
        if(file_exists($primary_image_path)) {
            @unlink($primary_image_path);
        }
        $product_detail->delete();
        return redirect('product/index')->with('delete', 'Product Deleted Successfully');
    }

    public function add_to_cart()
    {
         $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        if(count($uri_segments) !== 3){
                $product = Products::where('id',$uri_segments[3])->first();
            }else{
                $product = [];
            }
        return view('products.cart',['product'=>$product]);
    }

    public function checkout(Request $request)
    {
        print_r($request->all());exit;
    }

    public function product_detail(Products $product)
    {
        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        if(count($uri_segments) !== 2){
            $product = Products::where('id',$uri_segments[2])->first();
        }else{
            $product = [];
        }
        return view('products.product_detail',['product'=>$product]);

    }
    public function wishlist(Request $request,AddtoFavorite $add_to_favorite )
    {
        $already_user = AddtoFavorite::where('product_id',$request->id)->first();
        $already_favorite = AddtoFavorite::where('product_id',$request->id)->where('add_to_favourite','y')->first();
        if(empty($already_user)){
            AddtoFavorite::create([
                'product_id'=>$request->id,
                'add_to_favourite'=>'y'
            ]);
            return redirect('/product/index')->with('success','Favourite Added successfully!');
        }else{
            if(!empty($already_favorite)){
                $already_favorite->update([
                    'add_to_favourite'=>'n'
                ]);
            }else{
                \App\Models\AddtoFavorite::where('product_id',$request->id)->update(['add_to_favourite'=>'y']);
            }
            return redirect('/product/index')->with('success','Favourite removed successfully!');
        }
    
    }
}
