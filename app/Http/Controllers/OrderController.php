<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Omnipay\Omnipay;
use Session;
use Stripe;

use Notification;
use App\Notifications\AlertNotification;

class OrderController extends Controller
{
    public $detail;
    private $gateway;
   
    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true); //set it to 'false' when go live
        $this->middleware(['auth','verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment = 0;
        if(session('cart')){
            foreach (session('cart') as $key => $value) {
                $payment += $value['price'] * $value['quantity'];
            }
        }
        // dd($this->gateway);
        $total['total'] = $payment;
        return view('payment.methods', $total);
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
        $this->sendNotification();
        $order = new Order;
        $this->detail = $request->all();
        $this->cleanData($this->detail);  
        if(session('cart')){
            $this->detail['payment_method'] = 'cash';
            $this->detail['payment_status'] = 'unpaid';
            $this->store_cart_session();
        }else{
            return redirect()->back()->with('ordered', 'Do not have anything in cart');
        }
        return redirect()->back()->with('ordered', 'Your order has been placed!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $data['orders'] = Order::where('order_by', 'like', '%'.Auth::user()->id.'%')
        ->where('delivery_status', 'like', '%processing%')->get();
        return view('home.orders', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data['delivery_status'] = 'cancelled';
        $order = Order::find($id);
        $order->update($data);
        $this->sendCancelNotification();
        return redirect()->back()->with('message', 'Your Order has beem cancelled.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
    
    public function stripePay(Request $request)
    {
        $this->sendNotification();
        $payment = 0;
        if(session('cart')){
            foreach (session('cart') as $key => $value) {
                $payment += $value['price'] * $value['quantity'];
            }
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            Stripe\Charge::create ([
                    "amount" => $payment * 100,
                    "currency" => "usd",
                    "source" => $request->stripeToken,
                    "description" => "Web paid" 
            ]);
            $this->detail['name'] = Auth::user()->name;
            $this->detail['email'] = Auth::user()->email;
            $this->detail['phone'] = Auth::user()->phone;
            $this->detail['address'] = Auth::user()->address;
            $this->detail['payment_method'] = 'card';
            $this->detail['payment_status'] = 'paid';
            $this->store_cart_session();
        }else{
            return redirect()->back()->with('ordered', 'Do not have anything in cart');
        }
        Session::flash('ordered', 'Payment successful!');
          
        return back();
    }
//paypal integration
    public function charge(Request $request)
    {
       
        try {
            $response = $this->gateway->purchase(array(
                'amount' => $request->input('amount'),
                'items' => array(
                    array(
                        'name' => 'Product Purchase',
                        'price' => $request->input('amount'),
                        'description' => 'Happy Purchasing',
                        'quantity' => 1
                    ),
                ),
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('customer/success'),
                'cancelUrl' => url('customer/error'),
            ))->send();
        
            if ($response->isRedirect()) {
                $response->redirect(); // this will automatically forward the customer
            } else {
                // not successful
                return $response->getMessage();
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
   
    /**
     * Charge a payment and store the transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function success(Request $request)
    {
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();
           
            if ($response->isSuccessful())
            {
                // The customer has successfully paid.
                $this->sendNotification();
                $arr_body = $response->getData();
                $this->detail['name'] = Auth::user()->name;
                $this->detail['email'] = Auth::user()->email;
                $this->detail['phone'] = Auth::user()->phone;
                $this->detail['address'] = Auth::user()->address;
                $this->detail['payment_method'] = 'paypal';
                $this->detail['payment_status'] = 'paid';
                $this->detail['transaction_id'] = $arr_body['id'];
                $this->store_cart_session();
                return redirect('customer/payment_method')->with('ordered', 'Payment is successful. Your transaction id is: '. $arr_body['id']);
            }
                // return "Payment is successful. Your transaction id is: ". $arr_body['id'];
            else {
                return $response->getMessage();
            }
        }else{
            return 'Transaction is declined';
        }
    }
   
    /**
     * Error Handling.
     */
    public function error()
    {
        return 'User cancelled the payment.';
    }
//end paypal integration

    public function store_cart_session(){
        $order = new Order;
        foreach (session('cart') as $id => $product) {
            $this->detail['order_by'] = Auth::user()->id;
            $this->detail['product_id'] = $product['product_id'];
            $this->detail['delivery_status'] = 'processing';
            $this->detail['quantity'] = $product['quantity'];
            $this->detail['price'] = $product['price'];
            $order->insert($this->detail);
        }
        session()->forget('cart');
    }
    public function cleanData(&$data) {
        $unset = ['ConfirmPassword','q','_token'];
        foreach ($unset as $value) {
            if(array_key_exists ($value,$data))  {
                unset($data[$value]);
            }
        }
    }


    public function sendNotification()
    {
        $order = Auth::user()->id;
        $user = User::find($order);

        $details = [
            'greeting' => 'Hi '.Auth::user()->name,
            'body' => 'Thank you for visiting EcommerceFirst. I hope You have had the great shopping!',
            'thanks' => 'Thank you! Your is placed! Will be at your door soon!',
            'actionText' => 'View My Site',
            'actionURL' => url('http://localhost/laravel/EcommerceProject/customer/home'),
            'order_id' => 101
        ];
        
        Notification::send($user, new AlertNotification($details));
    }

    public function sendCancelNotification()
    {
        $order = Auth::user()->id;
        $user = User::find($order);

        $details = [
            'greeting' => 'Hi '.Auth::user()->name,
            'body' => 'Thank you for visiting EcommerceFirst. I hope You have had the great shopping!',
            'thanks' => 'Thank you! Your order is canceled! Hope to see you again! Come shope again',
            'actionText' => 'View My Site',
            'actionURL' => url('http://localhost/laravel/EcommerceProject/customer/home'),
            'order_id' => 101
        ];
        
        Notification::send($user, new AlertNotification($details));
    }

}
