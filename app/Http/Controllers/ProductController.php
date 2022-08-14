<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductUpdateRequest; 
use Illuminate\Http\Request;
use App\Models\Room;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->get('name');
        if($name){
            $products = Product::where('name','like','%'.$name.'%')
        ->paginate(5);
        }else{
            $products = Product::select('id', 'name', 'price', 'thumbnail_url', 'status', 'room_id')
            ->with('room')
            ->paginate(5); 
        } 
        return view('admin.product.list', [
            'product_list' => $products,
            'name' => $name
        ]);
    }
    public function delete(Product $product) {
        if($product->delete()) {
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $rooms = Room::where('parent_id', '=', 1 )->get();
        return view('admin.product.create', [
            'rooms' => $rooms
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductUpdateRequest $request)
    {  
        $product = new product(); 
        $product->fill($request->all()); 
        if($request->hasFile('thumbnail_url')) { 
            $thumbnail_url = $request->thumbnail_url;
            $thumbnail_urlName = $thumbnail_url->hashName();
            $thumbnail_urlName = $request->productname . '_' . $thumbnail_urlName; 
            $product->thumbnail_url = $thumbnail_url->storeAs('images/products', $thumbnail_urlName); 
        } else {
            $product->thumbnail_url = '';
        } 
        $product->save();

        return redirect()->route('products.list'); 

    }

    public function changeStatus(Request $request)

    { 
        $product = product::find($request->id); 
        $product->status = $request->status; 
        $product->save(); 
        return response()->json(['success'=>'Status change successfully.']); 
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
        // $product->birthday = date('Y-m-d', strtotime($product->birthday));
        $rooms = Room::select('id', 'name')->where('parent_id', '=', 1 )->get();
        return view('admin.product.create', [
            'product' => $product,
            'rooms' => $rooms,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    private function saveFile($file, $prefixName = '', $folder = 'public')
    {
        $fileName = $file->hashName();
        $fileName = $prefixName
            ? $prefixName . '_' . $fileName
            : $fileName;

        return $file->storeAs($folder, $fileName);
    }

    public function update(ProductUpdateRequest $request, Product $product) { 
        $product->fill($request->except('->id'));

        if($request->hasFile('thumbnail_url')) {
            $product->thumbnail_url = $this->saveFile(
                $request->thumbnail_url,
                $request->name,
                'images/products/'
            );
        }    
        if($request->id) {
            $product->id = $request->id;
        }
        $product->save();
        return redirect()->route('products.list');
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
}
