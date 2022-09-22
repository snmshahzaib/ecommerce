<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
           <h2>
              Our <span>products</span>
           </h2>
        </div>
        <div class="row">
           @foreach ($products as $product)
           <div class="col-sm-6 col-md-4 col-lg-4">
             <div class="box">
                <div class="option_container">
                   <div class="options">
                      <a href="product_detail/{{ $product->id}}" class="option1">
                         Product Details
                      </a>
                      <form action="{{route("add.to.cart", $product->id)}}" class="text-center form" method="POST">
                        {{csrf_field()}}
                        <input type="number" value="1" name="quantity" class="w-50" min=1>
                        <input type="hidden" value="1" name="product_id" value="{{$product->id}}" class="w-50" min=1>
                        <button type="submit" class="option2">
                          Add to Cart
                        </button>
                     </form>
                        
                   </div>
                </div>
                <div class="img-box">
                   <img src="{{ asset('product_images/'.$product->image) }}" alt="">
                </div>
                <div class="detail-box">
                   <h5>
                      {{$product->name}}
                   </h5>
                   <h6>
                      Rs. {{$product->price}}
                   </h6>
                </div>
             </div>
          </div>
           @endforeach
          
        </div>
        <div class="row">
          {{ $products->links() }}
        </div>
        
     </div>
 </section>