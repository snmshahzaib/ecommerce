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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        input, textarea{
            /* color:white!important; */
            background-color: white!important;
            color:black!important;
        }
        .select2-container{
      z-index: 9999999;
     
    }
    .card{
        float: left!important;
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
                All Product
            </div>
            {{-- {{dd($products)}} --}}
              @foreach ($products as $product)
              <div class="card col-4 border p-0 mb-5" style="background-color: white;">
                <div class="product-box pb-4">
                  <div class="product-img">
                    </div><img src="{{ asset('product_images/'.$product->image)}}" alt="" class="img-fluid m-auto d-block">
                  </div>
                  <div class="text-center">
                    <p class="text-muted font-size-13">{{$product->brand.' brand'}}</p>
                    <h5 class="font-size-15">
                      <p class="text-dark" >{{$product->name}} </p>
                    </h5>
                    <p class="text-dark" >{{$product->discription}} </p>
                    <h5 class="mt-3 mb-0">
                      <p class="text-dark"><b>{{'Rs. '.$product->price}}</b></p>
                    </h5>
                    <a href="" class="btn btn-outline-warning mb-1 mb-sm-1 mb-md-2 " data-toggle="modal" data-target="#update{{ $product->id }}">UPDATE</a>
                    <form style="display:inline!important;" method="POST" action="{{ route('delete.product', $product->id) }}">
                      @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <button type="submit" class="btn btn-outline-danger mb-1 ml-1 mb-sm-1 mb-md-2 show_confirm" data-toggle="tooltip" title='Delete'>Delete</button>
                  </form>
                  </div>
              </div>
              <div id="update{{ $product->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog text-white bg" style="max-width:80%!important">
                  <div class="modal-content" style="background-color: #191c24!important;">
                    <div class="modal-header">
                      <h5 class="modal-title">Update product</h5>
                      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body bg">
                      <div class="col-md-12 grid-margin stretch-card">
                        <div class="card text-white bg border-0">
                          <div class="card-body p-0 m-0">
                            <h4 class="card-title"></h4>
                          
                            <form method="POST" action="{{route('product.update', $product->id)}}" class="" enctype="multipart/form-data">
                              @csrf
                              <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input id="name" name="name" value="{{$product->name}}" type="text" class="form-control form-control ">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Manufacturer Brand</label>
                                        <input id="brand" name="brand" value="{{$product->brand}}" type="text" class="form-control form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input id="price" name="price" value="{{$product->price}}" type="text" class="form-control form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <select name="title[]" multiple data-allow-clear="1" class="form-control select2">
                                            @foreach ($categories as $category)
                                                <option value='{{$category->id}}'>{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="files" class="form-label mt-4">Upload Product Images:</label>
                                            <input 
                                                type="file" 
                                                name="image[]"
                                                class="form-control" 
                                                accept="image/*"
                                                multiple
                                            >
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="productdesc">Product Description</label>
                                <textarea class="form-control" value="" name="discription" id="productdesc" rows="5">{{$product->discription}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-primary float-right">Save Product</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script type="text/javascript">
    $('.select2').select2({
                    width: '100%'
                });
  </script>
<script type="text/javascript">
 
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this record?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
  
</script>
  </body>
</html>