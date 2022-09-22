<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Image;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $categories = Category::all();
        $data['categories'] = $categories;
        return view('admin.add_product', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $this->cleanData($data);
            $obj = new Product;
            $data['created_by'] = Auth::user()->id;
            unset($data['categories']);
            unset($data['image']);
            
            $image = $request->file('image');
            foreach ($image as $files) {
                $destinationPath = 'product_images';
                $file_name =$files->getClientOriginalName();
                $data['image'] = $file_name;
            }
            $createdProduct = $obj->create($data);
            $catId = $request->title;
            foreach ($catId as $id) {
                $createdProduct->categories()->attach($id);
            }
            if($request->has('image')){
                foreach($request->file('image') as $image){
                    $imageName =$image->getClientOriginalName();
                    $image->move(public_path('product_images'),$imageName);
                    Image::create([
                        'product_id'=>$createdProduct->id,
                        'image'=>$imageName
                    ]);
                }
            }
            return redirect()->back()->with('created','Product Created successfully!');   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data = [];
        $products = Product::all();
        $categories = Category::all();  
        // dd($products->images->image);
        $data['products'] = $products;
        $data['categories'] = $categories;
        return view('admin.show_products', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $this->cleanData($data);
            $obj = $product->find($id);
            $data['created_by'] = Auth::user()->id;
            unset($data['categories']);
            unset($data['image']);
            $image = $request->file('image');
            if(!$image==null){
                $this->deleteImageFromPublic($id);
                foreach ($image as $files) {
                    $destinationPath = 'product_images';
                    $file_name =$files->getClientOriginalName();
                    $data['image'] = $file_name;
                }
            }
            $obj->update($data);
            $catId = $request->title;
            if(!$catId==null){
                $obj->categories()->detach();
                
                foreach ($catId as $id) {
                    $obj->categories()->attach($id);
                }                
            }
            if($request->has('image')){
                foreach($request->file('image') as $image){
                    $imageName =$image->getClientOriginalName();
                    $image->move(public_path('product_images'),$imageName);
                    Image::create([
                        'product_id'=>$id,
                        'image'=>$imageName
                    ]);
                }
            }
            return redirect()->back()->with('created','Product Created successfully!');   
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $id)
    {
        $obj = $product->find($id); //delete attached category to the product
        $obj->categories()->detach();
        $this->deleteImageFromPublic($id);
        $product->destroy($id);
        return redirect()->back()->with('deleted','Category deleted successfully!');
    }
    public function cleanData(&$data) {
        $unset = ['ConfirmPassword','q','_token'];
        foreach ($unset as $value) {
            if(array_key_exists ($value,$data))  {
                unset($data[$value]);
            }
        }
    }
    public function deleteImageFromPublic($id){
        $images = Image::where('product_id', $id)->get();
        foreach ($images as $image) {
            $path = 'product_images/'.$image->image;
            File::delete(public_path($path));
        }
    }

}
