<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="{{ asset('home/images/favicon.png') }}" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('home/css/bootstrap.css') }}" />
      <!-- font awesome style -->
      <link href="{{ asset('home/css/font-awesome.min.css') }}" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" />
      <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

      
      {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
         @include('home.header')
         <!-- end header section -->
         <!-- slider section -->
         @include('home.slider')
         <!-- end slider section -->
      </div>
      <!-- why section -->
      @include('home.why')
      <!-- end why section -->
      
      <!-- arrival section -->
      @include('home.arrival')
      <!-- end arrival section -->
      
      <!-- product section -->
      {{-- @livewire('products') --}}
      
      @if ($message = Session::get('message'))
      <div class="alert alert-success alert-block text-center">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{{ $message }}</strong>
      </div>
      @endif
      @include('home.product')
      {{-- <section class="product_section layout_padding">
         <div class="container">
            <div class="heading_container heading_center">
               <h2>
                  Our <span>products</span>
               </h2>
            </div>
            <div id="products">
               {{ csrf_field() }}
            </div>
         </div>
      </section> --}}
      {{-- @livewire('product-listing') --}}
      <!-- end product section -->

      <!-- subscribe section -->
      @include('home.subscribe')
      <!-- end subscribe section -->

      <!-- client section -->
      @include('home.client')
      <!-- end client section -->

      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      </div>
      <!-- jQery -->
      <script src="{{ asset('home/js/jquery-3.4.1.min.js') }}"></script>
      <!-- popper js -->
      <script src="{{ asset('home/js/popper.min.js') }}"></script>
      <!-- bootstrap js -->
      <script src="{{ asset('home/js/bootstrap.js') }}"></script>
      <!-- custom js -->
      <script src="{{ asset('home/js/custom.js') }}"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
      {{-- @livewireScripts --}}
      {{-- <script>
         $(document).ready(function(){
          $('.form').submit(function(e){
            e.preventDefault();
            $.ajax({
               url: "{{ route('add.to.cart') }}",
                 method: "post",
                 data: $('.form').serialize(),
                 success: function (response) {
                  console.log(data);
                 }
            });
          });
         
         
         });
      </script> --}}
      <script type="text/javascript">  

         $(".update-cart").change(function (e) {
             e.preventDefault();
        
             var ele = $(this);
        
             $.ajax({
                 url: "{{ route('update.cart') }}",
                 method: "patch",
                 data: {
                     _token: '{{ csrf_token() }}', 
                     id: ele.parents("tr").attr("data-id"), 
                     quantity: ele.parents("tr").find(".quantity").val()
                 },
                 success: function (response) {
                  console.log(response);
                 }
             });
         });
        
         $(".remove-from-cart").click(function (e) {
             e.preventDefault();
        
             var ele = $(this);
        
             if(confirm("Are you sure want to remove?")) {
                 $.ajax({
                     url: "{{ route('remove.from.cart') }}",
                     method: "DELETE",
                     data: {
                         _token: '{{ csrf_token() }}', 
                         id: ele.parents("tr").attr("data-id")
                     },
                     success: function (response) {
                        console.log(response);
                     }
                 });
             }
         });
        
     </script>
   </body>
</html>