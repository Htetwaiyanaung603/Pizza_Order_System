@extends('user.layout.style')

@section('content')
    
    <div class="row mt-5 d-flex justify-content-center">

        <div class="col-4 ">
            <img src="{{ asset('images/'.$pizza->image) }}" class="img-thumbnail" width="100%">    <br>            
                <div class="row">
                    <div class=" col-3">
                        <a href="{{ route('user#index') }}">
                            <button class="btn bg-dark text-white" style="margin-top: 20px;">
                                <i class="fas fa-backspace"></i> Back
                            </button>
                        </a>
                     </div>     
                </div>
        </div>
        <div class="col-6">
            @if(Session::has('time'))
            <div class="alert alert-primary alert-dismissible fade show mt-2" role="alert">
              Order Success.. You Have to wait {{ Session::get('time') }} minutes.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <h5>Name</h5>
            <span>{{ $pizza->pizza_name }}</span>   <hr>
            <h5>Price</h5>
            <span> {{ $pizza->price - $pizza->discount_price}} kyats</span>  <hr>
            <h5>Waiting Time</h5>
            <span>{{ $pizza->waiting_time }} Minutes</span>     <hr>

            <form action="{{ route('user#placeOrder') }}" method="POST">
                @csrf
                <h5 class="mb-3">Number Of Pizza</h5>
                <input type="number" name="countPizza" class="form-control"> 
                @if($errors->has('countPizza'))
                    <p class="text-danger">{{ $errors->first('countPizza') }}</p>
                @endif
                <hr>

                <h5 class="mb-3">Payment Status</h5>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="paymentType" id="inlineRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Credit Card</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="paymentType" id="inlineRadio2" value="2">
                    <label class="form-check-label" for="inlineRadio2">Cash</label>
                </div>
                @if($errors->has('paymentType'))
                <p class="text-danger">{{ $errors->first('paymentType') }}</p>
                @endif

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Place Order</button>
                </div>
            </form>
        </div>
    </div>
@endsection