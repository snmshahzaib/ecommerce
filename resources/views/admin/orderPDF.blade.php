<!DOCTYPE html>
<html>
   <head>
  
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('home/css/bootstrap.css') }}" />
      <!-- font awesome style -->
      <!-- Custom styles for this template -->
      <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" />

      
    {{-- @livewireStyles --}}
    <style>
       .product_section .options .option2 {
    background-color: #000000;
    border: 1px solid #000000;
    color: #ffffff;
   }
   .product_section .options button {
      display: inline-block;
      padding: 8px 15px;
      border-radius: 30px;
      width: 165px;
      text-align: center;
      -webkit-transition: all .3s;
      transition: all .3s;
      margin: 5px 0;
   }
   .row nav{
      margin: auto;
    margin-top: 50px;
   }
   .page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #e3342f;
    border-color: #e3342f;
}
.page-link {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #e3342f;
    background-color: #fff;
    border: 1px solid #dee2e6;
}
li.nav-item #cart {
   width: 300px!important;
}
    </style>
   </head>
   <body>
      <div>
      <div class="hero_area">
         <!-- header section strats -->
         <nav class="navbar navbar-expand-lg custom_nav-container ">
            <img width="250" src="{{ asset('home/images/logo.png') }}" alt="#" />
         </nav>
         <!-- end header section -->
         <!-- slider section -->
         <table id="cart" class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th style="width:50%">Product</th>
                    <th style="width:10%">Price</th>
                    <th style="width:8%">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{ asset('product_images/'.$orders->product->image) }}" width="100" height="100" class="img-responsive"/></div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $orders->name }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">${{  $orders->price }}</td>
                    <td data-th="Quantity">
                        <h4 > {{  $orders->quantity }} </h4>
                    </td>
                </tr>
            </tbody>
        </table>
      </div>
      <!-- why section -->

      </div>
    
      <!-- footer start -->
      <!-- footer end -->
      </div>
      <!-- jQery -->
      {{-- <script src="{{ asset('home/js/jquery-3.4.1.min.js') }}"></script>
      <!-- popper js -->
      <script src="{{ asset('home/js/popper.min.js') }}"></script>
      <!-- bootstrap js -->
      <script src="{{ asset('home/js/bootstrap.js') }}"></script>
      <!-- custom js -->
      <script src="{{ asset('home/js/custom.js') }}"></script> --}}
   </body>
</html>