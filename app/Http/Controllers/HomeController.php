<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Product;
use App\Order;
use App\User;
use App\Category;
use Notification;
use App\Notifications\AlertNotification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return view('home.index');
    }
    public function home()
    {
        // return view('home');
        if(Auth::user()->role=='admin'){
            return redirect('admin/dashboard');
        }elseif(Auth::user()->role=='customer'){
            return redirect('customer/home');
        }else{
            return redirect('/');
        }

    }

    public function admin() {
        $data['total_orders']= Order::all()->count();
        $data['total_customers'] = User::all()->count();
        $data['total_products'] = Product::all()->count();
        $data['order_delivered'] = Order::where('delivery_status', '=', 'delivered')->get()->count();
        $data['order_processing'] = Order::where('delivery_status', '=', 'processing')->get()->count();
        $data['total_revenue'] = Order::sum('price');
        $data['total_Categories'] = Category::get()->count();
        // dd($data);
        return view('admin.index', $data);
    }

    public function customer(Product $product) {
        $data= [];
        $data['products'] = $product->paginate(3);
        return view('home.index', $data);
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
                     <a href="/product_detail" class="option1">
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
   

    public function sendNotification()
    {
        $order = Order::all();
  
        $details = [
            'greeting' => 'Hi Artisan',
            'body' => 'This is my first notification from ItSolutionStuff.com',
            'thanks' => 'Thank you for using ItSolutionStuff.com tuto!',
            'actionText' => 'View My Site',
            'actionURL' => url('/'),
            'order_id' => 101
        ];
  
        Notification::send($order, new AlertNotification($details));
   
        dd('done');
    }
}
