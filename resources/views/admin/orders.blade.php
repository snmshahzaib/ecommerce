<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- plugins:css -->

    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.png') }}" />

    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
    <style>
        input, textarea{
            /* color:white!important; */
            background-color: white!important;
        }
        .select2-container{
      z-index: 9999999;
    }
    a{
        text-decoration: none;
    }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      @include('admin.navbar')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row h5 ml-1 card-title">
                All Orders
            </div>
            @if ($message = Session::get('updated'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong>{{ $message }}</strong>
            </div>
            @endif

            <div class="row ">
                <div class="col-12 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search Customer Data" />
                       </div>
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th> Order No </th>
                              <th> Product </th>
                              <th> Client Name </th>
                              <th> Email </th>
                              <th> Contact </th>
                              <th> Address </th>
                              <th> Quantity </th>
                              <th> Price </th>
                              <th> Payment Mode </th>
                              <th> Payment Status </th>
                              <th> Delivery Status </th>
                              <th> Change Payment Status </th>
                              <th> Change Delivery Status </th>
                              <th> Download PDF </th>
                            </tr>
                          </thead>
                          <tbody>
                            {{-- @foreach ($orders as $order)
                            <tr>
                                <td>
                                  {{$order->id}}
                                </td>
                                <td>
                                    <div class="inline">
                                        <img class="mr-2" src="{{ asset('product_images/'.$order->product->image) }}" alt="image" />
                                        {{$order->product->name}}
                                    </div>
                                </td>
                                <td> {{$order->name}} </td>
                                <td> {{$order->email}} </td>
                                <td> {{$order->phone}} </td>
                                <td> {{$order->address}} </td>
                                <td> {{$order->quantity}} </td>
                                <td> {{$order->price}} </td>
                                <td> {{$order->payment_method}} </td>
                                <td>
                                @if($order->payment_status == 'paid')
                                  <div class="badge badge-outline-success">
                                    Paid
                                  </div>
                                @else
                                <div class="badge badge-outline-warning">
                                    UnPaid
                                </div> 
                                @endif
                                </td>
                                <td>
                                @if($order->delivery_status == 'delivered')
                                  <div class="badge badge-outline-success">
                                    Delivered
                                  </div>
                                @else
                                <div class="badge badge-outline-warning">
                                    Processing
                                </div> 
                                @endif
                                </td>
                                <td>
                                    <form method="POST" action="change_status">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$order->id}}" id="post_id">
                                        <input type="hidden" name="req" value="payment_status" >
                                        <button type="submit" class="btn btn-outline-primary">Change Payment Status</button>
                                    </form>    
                                </td>
                                <td>
                                    <form method="POST" action="change_status">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$order->id}}" >
                                        <input type="hidden" name="req" value="delivery_status" >
                                        <button type="submit" class="btn btn-outline-primary">Change Delivery Status</button>
                                    </form> 
                                </td>
                                <td>
                                  <a href="generate-pdf/{{$order->id}}}" class="btn btn-outline-secondary">Download</a>
                                </td>
                              </tr>
                            @endforeach --}}
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('admin/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/assets/js/misc.js') }}"></script>
    <script src="{{ asset('admin/assets/js/settings.js') }}"></script>
    <script src="{{ asset('admin/assets/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>
    <!-- End custom js for this page -->
    <script>
      $(document).ready(function(){
      
       fetch_customer_data();
      
       function fetch_customer_data(query = '')
       {
        $.ajax({
         url:"{{ route('live_search.action') }}",
         method:'GET',
         data:{query:query},
         dataType:'json',
         success:function(data)
         {
          $('tbody').html(data.table_data);
          $('#total_records').text(data.total_data);
         }
        })
       }
      
       $(document).on('keyup', '#search', function(){
        var query = $(this).val();
        fetch_customer_data(query);
       });
      });
      </script>
  </body>
</html>