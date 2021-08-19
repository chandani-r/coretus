<?php

use Illuminate\Support\Facades\Route;
use App\product\SearchRepository;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$client =  Elasticsearch\ClientBuilder::create()->build();
$total = \App\Models\Products::count();
$product = \App\Models\Products::all();

// $result = $client->search([
//                 'index'=>'products',
//                 'body'=>[
//                     'query'=>[
//                         'match'=>[
//                             '_all'=>'active'
//                         ]
//                     ]
//                 ]
//             ]);
// var_dump($total);
// var_dump($product);
$params = ['body'=>[]];
for ($i=0; $i <$total ; $i++) { 
    $params['body'][] = [
        'index'=>[
                '_type'=>'products',
                // '_id'=>$product[$i]->id,
                '_cat_id'=>"1"
            ]
        ];
        $params['body'][] = $product[$i]->toArray();

        if($i%10==0 && $i!=0){
            $responses = $client->bulk($params);
            var_dump("done Product".$i);
            // $params = ['body'=>[]];
            // unset($responses);
        }
        // var_dump($params);
}
$search = request()->has('search');
Route::get('/', function (SearchRepository $searchRepository) {
    // return view('index');.
        return view('index', [
            'products' => request()->has('search')
                ? $searchRepository->search(request('search'))
                : App\Models\Products::where('name','like','%'.request('search').'%')->get(),
        ]);
   
});
// Route::get('/dashboard', function (SearchRepository $searchRepository) {
// return view('dashboard', [
//     'articles' => request()->has('q')
//         ? $searchRepository->search(request('q'))
//         : App\Models\Article::all(),
// ]);
// })

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/product', [App\Http\Controllers\productController::class, 'index'])->name('product');
Route::get('/category/index', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('category.create');
Route::get('/category/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/store', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
Route::post('/category/update', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
Route::post('/category/view', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');
Route::delete('/category/delete', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.delete');

Route::get('/product/index', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
Route::get('/product/create', [App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
Route::get('/product/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
Route::post('/product/store', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
Route::post('/product/update', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
Route::post('/product/view', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
Route::delete('/product/delete', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.delete');
Route::get('/product/add_to_cart/{id}', [App\Http\Controllers\ProductController::class, 'add_to_cart'])->name('product.add_to_cart');
Route::get('/product/check_out', [App\Http\Controllers\ProductController::class, 'checkout'])->name('product.checkout');
Route::get('/product_detail/{id}', [App\Http\Controllers\ProductController::class, 'product_detail'])->name('product.product_detail');
Route::post('/product/wishlist', [App\Http\Controllers\ProductController::class, 'wishlist'])->name('product.wishlist');
