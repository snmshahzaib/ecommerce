<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class LoadMoreController extends Controller
{
    public function index()
    {
     return view('home.index');
    }

    function load_data(Product $product, Request $request)
    {
     if($request->ajax())
     {
      if($request->id > 0)
      {
       $data = $product
          ->where('id', '<', $request->id)
          ->orderBy('id', 'DESC')
          ->limit(3)
          ->get();
      }
      else
      {
       $data = $product
          ->orderBy('id', 'DESC')
          ->limit(3)
          ->get();
      }
      $output = '<div class="row">';
      $last_id = '';
      
      $app_url = env("APP_URL");
      if(!$data->isEmpty())
      {
       foreach($data as $product)
       {
        $output .= '
        <div class="col-sm-6 col-md-4 col-lg-4">
            <div class="box">
               <div class="option_container">
                  <div class="options">
                     <a href="product_detail/'.$product->id.'" class="option1">
                     Product Details
                     </a>
                     <form action="'.route("cart.store", $product->id).'" class="text-center" method="POST">
                      '.csrf_field().'
                      <input type="number" value="1" name="quantity" class="w-50" min=1>
                      <button type="submit" class="option2">
                        Add to Cart
                      </button>
                     </form>
                  </div>
               </div>
               <div class="img-box">
               <img src="'.$app_url.'/public/product_images/'.$product->image.'" alt="">
               </div>
               <div class="detail-box">
                  <h5>'.
                     $product->name.'
                  </h5>
                  <h6>
                     Rs. '.$product->price.'
                  </h6>
               </div>
            </div>
         </div>
        ';
        $last_id = $product->id;
       }
       $output .= '</div>
           <div id="load_more"  class="btn-box">
                <a name="load_more_button"  data-id="'.$last_id.'" id="load_more_button">
                Load more products
                </a>
            </div>
          ';
      }
      else
      {
        $output .= '</div>
        <div id="load_more"  class="btn-box">
             <a name="load_more_button">
             No more products
             </a>
         </div>
        </div>
     </section>';

      }
      echo $output;
     }
    }
    public function detail(Product $product, $id){
        $data['product'] = $product->find($id);
        return view('home.product_detail', $data);
    }
}
