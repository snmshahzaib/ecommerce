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
      
      {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
      <style>
         .reply{
            margin:0px!important;
         }
      </style>
   </head>
   <body>
      <div>
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         {{-- {{dd($product)}} --}}
         <div class="row">
            <div class="col-6">
               <img class="ml-5 mt-5" src="{{ asset('product_images/'.$product->image) }}" style="width: 60%">
            </div>
            <div class="col-6">
               <div class="" style="margin-top: 15%">
                  <H1 class="mb-5">{{$product->name}}</H1>
                  <h2 class="mb-3">{{$product->brand}}</h2>
                  <h5  class="mb-3">Rs. {{$product->price}}</h5>
                  <p class="mb-5">{{$product->discription}}</p>
                  <form action="{{route("add.to.cart", $product->id)}}" class="" method="POST">
                     {{csrf_field()}}
                     <input type="number" value="1" name="quantity" class="w-50" min=1>
                     <button type="submit" class="option2 btn btn-danger">
                       Add to Cart
                     </button>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="row justify-content-center">
             <div class="col-md-8">
                 <div class="card mb-5">
                     <div class="card-body">
       
                         @include('home.commentsDisplay', ['comments' => $product->comments, 'product_id' => $product->id])
   
                         <h4>Add comment</h4>
                         <form method="post" action="{{ route('comments.store') }}">
                             @csrf
                             <div class="form-group">
                                 <textarea class="form-control" name="body"></textarea>
                                 <input type="hidden" name="product_id" value="{{$product->id}}" />
                             </div>
                             <div class="form-group">
                                 <input type="submit" class="btn btn-success" value="Add Comment" />
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
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
      <script>
         
      </script>
      {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}


      {{-- <script>
         $(document).ready(function(){
          
          var _token = $('input[name="_token"]').val();
         
          load_data('', _token);
         
          function load_data(id="", _token)
          {
           $.ajax({
            url:"{{ route('loadmore.load_data') }}",
            method:"POST",
            data:{id:id, _token:_token},
            success:function(data)
            {
             $('#load_more_button').remove();
             $('#products').append(data);
            }
           })
          }
         
          $(document).on('click', '#load_more_button', function(){
           var id = $(this).data('id');
           $('#load_more_button').html('<b>Loading...</b>');
           load_data(id, _token);
          });
         
         });
         </script>          --}}
   </body>
</html>