<?php

namespace App\Http\Controllers;

use App\Order;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use PDF;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    public function index()
    {
        // $orders['orders'] = Order::all();
        return view('admin.orders');
    }

    function action(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = Order::
        where('id', 'like', '%'.$query.'%')
         ->orWhere('name', 'like', '%'.$query.'%')
         ->orWhere('email', 'like', '%'.$query.'%')
        //  ->orWhere('phone', 'like', '%'.$query.'%')
         ->orWhere('payment_method', 'like', '%'.$query.'%')
         ->get();
         
      }
      else
      {
       $data = Order::all();
      }
      $total_row = $data->count();
      $app_url = env("APP_URL");
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
        <td>
            '.$row->id.'
        </td>
        <td>
            <div class="inline">
            <img class="mr-2" src="'.$app_url.'/public/product_images/'.$row->product->image.'" alt="">
                '.$row->product->name.'
            </div>
        </td>
        <td> '.$row->name.' </td>
        <td> '.$row->email.' </td>
        <td> '.$row->phone.' </td>
        <td> '.$row->address.' </td>
        <td> '.$row->quantity.' </td>
        <td> '.$row->price.' </td>
        <td> '.$row->payment_method.' </td>
        <td>
        ';
        if($row->payment_status == "paid"){
            $output .= '
            <div class="badge badge-outline-success">
                Paid
            </div>';
        }else{
            $output .= '
            <div class="badge badge-outline-warning">
                UnPaid
            </div>';
        }
        $output .= '
        </td>
        <td>';
        if($row->delivery_status == "delivered"){
            $output .= '
            <div class="badge badge-outline-success">
            Delivered
            </div>';
        }else{
            $output .= '
            <div class="badge badge-outline-warning">
            Processing
        </div>';
        }
            
        $output .= '
        </td>
        <td>
            <form method="POST" action="change_status">'.
                csrf_field().'
                <input type="hidden" name="id" value="'.$row->id.'" id="post_id">
                <input type="hidden" name="req" value="payment_status" >
                <button type="submit" class="btn btn-outline-primary">Change Payment Status</button>
            </form>    
        </td>
        <td>
            <form method="POST" action="change_status">'.
                csrf_field().'
                <input type="hidden" name="id" value="'.$row->id.'" >
                <input type="hidden" name="req" value="delivery_status" >
                <button type="submit" class="btn btn-outline-primary">Change Delivery Status</button>
            </form> 
        </td>
        <td>
            <a href="generate-pdf/'.$row->id.'" class="btn btn-outline-secondary">Download</a>
        </td>
        </tr>     
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="11">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $req = $request->req;
        if($req == 'payment_status'){
            $order = Order::find($request->id);
            $data['payment_status'] = 'paid';
            $order->update($data);
            return back()->with('updated', "UPDATED");
        }
        if($req == 'delivery_status'){
            $order = Order::find($request->id);
            $data['delivery_status'] = 'delivered';
            $order->update($data);
            return back()->with('updated', "UPDATED");
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function generatePDF($id)
    {
        $orders['orders'] = Order::find($id);
        $pdf = PDF::loadView('admin.orderPDF', $orders);
  
        return $pdf->download('itsolutionstuff.pdf');
    }
}
