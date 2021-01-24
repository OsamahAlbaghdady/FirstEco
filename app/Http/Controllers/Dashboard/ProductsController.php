<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;

class ProductsController extends Controller
{

    public function index(Request $request)
    {
        // To Do Search
        $products = Product::when($request->search, function ($q) use ($request) {
            return $q->whereTranslationLike('name'  ,'%'. $request->search . '%');
        })->when($request->category_id , function ($q) use ($request){
            return $q->where('category_id' ,$request->category_id );
        })
        ->latest()->paginate(pages_count);
       $categories = Category::all();
        return view('dashboard.products.index', compact('products', 'categories'));
    } //End Of Index


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    } //End Of Create


    public function store(ProductsRequest $request)
    {
        if (!$request) {
            return redirect()->route('dashboard.products.index')->with(['error' => __('site.error')]);
        } //end of if

        $request_data = $request->except(['_token', 'method', 'image']);
        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(base_path('assets/dashboard/ProductImage/') . $request->image->hashName());
            $request_data['image'] = $request->image->hashName();
        }
        Product::create($request_data);
        return redirect()->route('dashboard.products.index')->with(['msg' => __('site.success')]);

        try {
        } catch (\Exception $ex) {
            return redirect()->route('dashboard.products.index')->with(['error' => __('site.error')]);
        } //end of catch

    } //End Of Store



    public function show(Product $product)
    {
        //

    } //End Of Show



    public function edit(Product $product)
    {
        if (!$product) {
            return redirect()->route('dashboard.products.index')->with(['error' => __('site.error')]);
        } //end of if
        $categories = Category::all();

        return view('dashboard.products.edit', compact('product', 'categories'));
    } //End Of Edit



    public function update(ProductsRequest $request, Product $product)
    {

        $request_data = $request->except(['_token', '_method', 'image']);
        if ($request->image) {
            if ($product->image != 'default.png') {
                Storage::disk('products_uploads')->delete($product->image);
            }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(base_path('assets/dashboard/ProductImage/') . $request->image->hashName());
            $request_data['image'] = $request->image->hashName();
        }

        $product->update($request_data);
        return redirect()->route('dashboard.products.index')->with(['msg' => __('site.success')]);


    } //End Of Update



    public function destroy(Product $product)
    {
        if ($product->image != 'default.png') {
            Storage::disk('products_uploads')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('dashboard.products.index')->with(['msg' => __('site.success')]);

    } //End Of Destroy

}//End Of Crontroller
