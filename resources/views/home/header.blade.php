<header class="header_section">
    <div class="container">
       <nav class="navbar navbar-expand-lg custom_nav-container ">
         @if (Auth::check())
          <a class="navbar-brand" href="{{ url('/customer/home')}}"><img width="250" src="{{ asset('home/images/logo.png') }}" alt="#" /></a>
         @else
         <a class="navbar-brand" href="{{ url('/')}}"><img width="250" src="{{ asset('home/images/logo.png') }}" alt="#" /></a>
         @endif
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""> </span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item active">
                  @if (Auth::check())
                  <a class="nav-link" href="{{ url('/customer/home')}}">Home <span class="sr-only">(current)</span></a>
                 @else
                   <a class="nav-link" href="{{ url('/')}}">Home <span class="sr-only">(current)</span></a>
                   @endif
                </li>
               <li class="nav-item dropdown">
                   <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> <span class="nav-label">Pages <span class="caret"></span></a>
                   <ul class="dropdown-menu">
                      <li><a href="about.html">About</a></li>
                      <li><a href="testimonial.html">Testimonial</a></li>
                   </ul>
                   
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="">Products</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="orders">Orders</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="contact.html">Contact</a>
               </li>
               <li class="nav-item">
                  <div class="dropdown">
                     <a class="nav-link dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart
                        @if ( count((array) session('cart')) > 0)
                        <span class="badge badge-pill badge-danger">
                           {{-- @livewire('cart-counter') --}}
                           {{count((array) session('cart'))}}
                        </span>
                        @endif 
                     </a>
                     <ul id="cart" class="dropdown-menu">
                        <li>
                           <div class="row">
                              <div class="col-lg-6 col-sm-6 col-6">
                                 <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                 @if ( count((array) session('cart')) > 0)
                                 <span class="badge badge-pill badge-danger">
                                    {{-- @livewire('cart-counter') --}}
                                    {{count((array) session('cart'))}}
                                 </span>
                                 @endif 
                              </div>
                              @php $total = 0 @endphp
                              @foreach((array) session('cart') as $id => $details)
                                 @php $total += $details['price'] * $details['quantity'] @endphp
                              @endforeach
                              <div class="col-lg-6 col-sm-6 col-6 total-section text-left">
                                 <p>Total: <span class="text-info">$ {{$total}} </span></p>
                              </div>
                           </div>
                        </li>
                        @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                        <li>
                            <div class="row cart-detail">
                                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                 
                                    <img src="{{ asset('product_images/'.$details['image']) }}" />
                                </div>
                                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                    <p>{{ $details['name'] }}</p>
                                    <span class="price text-info"> ${{ $details['price'] }}</span> <span class="count"> Quantity:{{ $details['quantity'] }}</span>
                                </div>
                            </div>
                        </li>    
                        @endforeach
                        @endif
                        <li>
                           <div class="row">
                              <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                  <a href="{{ route('cart')}}" class="btn btn-danger btn-block text-white">View all</a>
                              </div>
                          </div>
                        </li>
                     </ul>
                   </div>
               </li>
            </ul>
            <form class="form-inline">
               <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
               <i class="fa fa-search" aria-hidden="true"></i>
               </button>
            </form>
            <ul class="navbar-nav ml-auto">
               <!-- Authentication Links -->
               @guest
                <li class="nav-item">
                   <a class="btn btn-danger ml-lg-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                   <a class="btn btn-danger ml-lg-3" href="{{ route('register') }}">{{ __('Register') }}</a>
               </li>
                @endif
                @else
                <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                   {{ Auth::user()->name }}
               </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                   @if (Auth::user()->role=='admin')
                   <a class="dropdown-item" href="{{ url('admin/dashboard') }}">Dashboard</a>
                   @endif
                   <a class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                         {{ __('Logout') }}
                   </a>
                   <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                         @csrf
                   </form>
                </div>
             </li>
               @endguest
            </ul>
          </div>
       </nav>
    </div>
 </header>