@if ($message = Session::get('ordered'))
      <div class="alert alert-success alert-block text-center">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{{ $message }}</strong>
      </div>
      @endif
<div class="py-5">
    <!-- For demo purpose -->
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-6">Choose Payment Method</h1>
        </div>
    </div> <!-- End -->
    <div class="row pb-5">
        <div class="col-lg-6 mx-auto">
            <div class="card ">
                <div class="card-header">
                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                        <!-- Credit card form tabs -->
                        <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                            <li class="nav-item"> <a data-toggle="pill" href="#credit-card" class="nav-link active "> <i class="fas fa-credit-card mr-2"></i> Card </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Paypal </a> </li>
                            <li class="nav-item"> <a data-toggle="pill" href="#cash" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> Cash on Delivery</a> </li>
                        </ul>
                    </div> <!-- End -->
                    <!-- Credit card form content -->
                    <div class="tab-content">
                        <!-- credit card info-->
                        <div id="credit-card" class="tab-pane fade show active pt-3">
                            <form
                                role="form" 
                                action="{{ route('stripe.post') }}"
                                method="POST"
                                class="require-validation"
                                data-cc-on-file="false"
                                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                id="payment-form">
                                @csrf
                                <div class="form-group required"> <label for="username">
                                        <h6>Card Owner</h6>
                                    </label> <input type="text" placeholder="Card Owner Name" required class="form-control "> </div>
                                <div class="form-group card required"> <label for="cardNumber">
                                        <h6>Card number</h6>
                                    </label>
                                    <div class="input-group"> <input autocomplete='off' class='form-control card-number' size='20' placeholder="Valid card number" required>
                                        <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fab fa-cc-visa mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group expiration required"> <label><span class="hidden-xs">
                                                    <h6>Expiration Date</h6>
                                                </span></label>
                                            <div class="input-group"> <input  class='form-control card-expiry-month' placeholder='MM' size='2'
                                                type='text' required> <input  class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                                type='text' required> </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group mb-4 cvc required"> <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                                                <h6>CVC <i class="fa fa-question-circle d-inline"></i></h6>
                                            </label> <input autocomplete='off'
                                            class='form-control card-cvc' placeholder='ex. 311' size='4'
                                            type='text' required> </div>
                                    </div>
                                </div>
                                <div class="card-footer"> <button  type="submit" class="subscribe btn btn-danger btn-block shadow-sm"> Confirm Payment Rs.{{$total}} </button>
                            </form>
                        </div>
                    </div> <!-- End -->
                    <!-- Paypal info -->
                    <div id="paypal" class="tab-pane fade pt-3">
                        <form action="{{ url('customer/charge') }}" method="post">
                            <p class="h4">Total Payment</p>
                            <p class="h5 mb-3">Rs. {{$total}}</p>
                            <input type="hidden" value="{{$total}}" name="amount" />
                            {{ csrf_field() }}
                            {{-- <input type="submit" name="submit" value="Pay Now"> --}}
                        <p class=" text-center"> <button type="submit" class="btn btn-danger"><i class="fab fa-paypal mr-2"></i> Log into my Paypal</button> </p>
                        </form>
                    </div> <!-- End -->
                    <!-- bank transfer info -->
                    <div id="cash" class="tab-pane fade pt-3">
                        
                     <form action="{{ url('customer/ordered') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="usr">Name:</label>
                            <input type="text" class="form-control" value="{{auth()->user()->name}}" name="name">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Email:</label>
                            <input type="email" class="form-control" value="{{auth()->user()->email}}" name="email">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Contact</label>
                            <input type="phone" class="form-control" value="{{auth()->user()->phone}}" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="comment">Address:</label>
                            <textarea class="form-control" rows="5" name="address"> {{auth()->user()->address}}</textarea>
                        </div>
                        <div class="form-group">
                            <p> <button type="submit" class="btn btn-danger "><i class="fas fa-mobile-alt mr-2"></i> Place Order</button> </p>
                        </div>
                     </form>
                    </div> <!-- End -->
                    <!-- End -->
                </div>
            </div>
        </div>
    </div>