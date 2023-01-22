<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create',[
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = Str::slug($request->product_name)."_".Str::random(5);
        $sku = "pro"."-".Str::random(8);
        $product_id = Product::insertGetId($request->except('_token')+[
            'slug' => $slug,
            'product_sku' => $sku,
            'created_at' => Carbon::now()
        ]);
        // Image Upload Str //
        if($request->hasFile('product_thumbnail_photo')){
            $new_name = $product_id.".".$request->file('product_thumbnail_photo')->getClientOriginalExtension();
            Image::make($request->file('product_thumbnail_photo'))->resize(270,310)->save(base_path('public/uploads/product_thumbnail/'.$new_name));
        // Image Upload End //
            Product::find($product_id)->update([
                'product_thumbnail_photo' => $new_name
            ]);
        }
        return back()->with('success', 'New Product Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function getsubcategory(Request $request)
    {
        foreach (Subcategory::where('category_id', $request->category_id)->get() as $subcategory) {
            echo "<option value='$subcategory->id'>$subcategory->subcategory_name</option>";
        }
    }

    public function color(Request $request)
    {
        $colors =  Color::all();
        return view('product.color', compact('colors'));
    }
    public function colorstore(Request $request)
    {
        Color::insert($request->except('_token')+[
            'created_at' => Carbon::now()
        ]);
        return back()->with('success' , 'Color Added Successfully!');
    }
    public function size(Request $request)
    {
        $sizes =  Size::all();
        return view('product.size', compact('sizes'));
    }
    public function sizestore(Request $request)
    {
        Size::insert($request->except('_token')+[
            'created_at' => Carbon::now()
        ]);
        return back()->with('success' , 'Size Added Successfully!');
    }

    public function inventory($product_id)
    {
        $product = Product::find($product_id);
        $colors =  Color::all();
        $sizes =  Size::all();
        $inventories = Inventory::where('product_id', $product_id)->get();
        return view('product.inventory', compact('colors','sizes','product','inventories'));
    }
    public function inventorystore($product_id, Request $request)
    {
        $exists_check = Inventory::where([
            'product_id' => $product_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
        ])->exists();

        if($exists_check ==1){
            Inventory::where([
                'product_id' => $product_id,
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
            ])->increment('quantity', $request->quantity);
        }
        else{
            Inventory::insert($request->except('_token')+[
                'product_id' => $product_id,
                'created_at' => Carbon::now()
            ]);
        }
        return back()->with('success' , 'Products Successfully Added to Inventory!');
    }
}
