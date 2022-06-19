@extends('user.layout.style')

@section('content')
    
    <div class="row mt-5 d-flex justify-content-center">

        <div class="col-4 ">
            <img src="{{ asset('images/'.$pizza->image) }}" class="img-thumbnail" width="100%">            <br>
            <a href="{{ route('user#orderPizza') }}"><button class="btn btn-primary float-end mt-2 col-12"><i class="fas fa-shopping-cart"></i>Order</button></a>
            
                <div class="row">
                    <div class=" col-3">
                        <a href="{{ route('user#index') }}">
                            <button class="btn bg-dark text-white" style="margin-top: 20px;">
                                <i class="fas fa-backspace"></i> Back
                            </button>
                        </a>
                    
                     </div>
                     <div class="col-8 text-danger pt-3 fs-4">
                        <p>Total Price : {{ $pizza->price - $pizza->discount_price}} kyats</p>
                     </div>
                </div>
                 
            
        </div>
        <div class="col-6">
            <h5>Name</h5>
            <span>{{ $pizza->pizza_name }}</span>   <hr>
            <h5>Price</h5>
            <span>{{ $pizza->price }} kyats</span>  <hr>
            <h5>Discount</h5>
            <span>{{ $pizza->discount_price }} kyats</span>   <hr>
            <h5>Buy One Get One</h5>
            <span>
                @if ($pizza->buy_one_get_one_status == 0)
                    Not Have
                @else
                    Have
                @endif
            </span>     <hr>
            <h5>Waiting Time</h5>
            <span>{{ $pizza->waiting_time }} Minutes</span>     <hr>
            <h5>Description</h5>
            <span>{{ $pizza->description}}</span>


            

        </div>
    </div>


@endsection