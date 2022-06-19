@extends('user.layout.style')

@section('content')
     <!-- Page Content-->
     <div class="container px-4 px-lg-5" id="home">
        <!-- Heading Row-->
        <div class="row gx-4 gx-lg-5 align-items-center my-5">
            <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" id="code-lab-pizza" src="https://www.pizzamarumyanmar.com/wp-content/uploads/2019/04/chigago.jpg" alt="..." /></div>
            <div class="col-lg-5">
                <h1 class="font-weight-light">CODE LAB Pizza</h1>
                <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
                <a class="btn btn-primary" href="#!">Enjoy!</a>
            </div>
        </div>

        <!-- Content Row-->
        <div class="d-flex justify-content-arround">
            <div class="col-3 me-5">
                <div class="">
                    <div class="py-5 text-center">
                        <form class="d-flex m-5" method="GET" action="{{ route('admin#searchItem')}}">
                            @csrf
                            <input class="form-control me-2" type="search" name="searchData" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-dark" type="submit">Search</button>
                        </form>

                        <div class="">
                            <a href="{{ route('user#index')}}" class="text-decoration-none text-dark"><div class="m-2 p-2">All</div></a>
                            @foreach ($category as $items)
                               <a href="{{ route('user#category', $items->category_id)}}" class="text-decoration-none text-dark"> <div class="m-2 p-2">{{ $items->category_name }}</div></a>
                            @endforeach
                        </div>
                        <hr>
                        <form action="{{ route('admin#searchPrice')}}" method="GET">
                            @csrf
                            <div class="text-center m-4 p-2">
                                <h3 class="mb-3">Start Date - End Date</h3>
    
                                    <input type="date" name="startDate" id="" class="form-control"> -
                                    <input type="date" name="endDate" id="" class="form-control">
                                
                            </div>
                            <hr>
                            <div class="text-center m-4 p-2">
                                <h3 class="mb-3">Min - Max Amount</h3>
                                
                                <input type="number" name="minPrice" id="" class="form-control" placeholder="minimum price"> -
                                <input type="number" name="maxPrice" id="" class="form-control" placeholder="maximun price">
                                
                            </div>
                            <div>
                                <button type='submit' class="btn btn-dark text-white"><i class="fas fa-search"></i>Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mt-5 col-9">
                <div class="row gx-4 gx-lg-5  " id="pizza">
                    @if ($status == 0 )
                       <div class="mt-5 fs-5 alert alert-danger" role="alert">
                            {{-- <p class="text-danger text-center">There is no pizza here...</p> --}}
                            There is no pizza here...
                       </div>
                    @else
                        @foreach ($pizza as $items)
                        <div class="col-4 mb-5">
                            <div class="card h-100" style="width: 270px">
                                <!-- Sale badge-->

                                @if ($items->buy_one_get_one_status == 1)
                                    <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">buy 1 get 1</div>
                                @endif
                                <!-- Product image-->
                                <img class="card-img-top" id="pizza-image" src="{{ asset('images/'.$items->image)}}" alt="..." style="height: 200px"/>
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder">{{ $items->pizza_name }}</h5>
                                        <!-- Product price-->
                                        {{-- <span class="text-muted text-decoration-line-through">$20.00</span> $18.00 --}}
                                        <span>{{ $items->price }}kyats</span>
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{ route('admin#details', $items->pizza_id )}}">More Detail</a></div>
                                </div>
                            </div>
                        </div>
                        
                        @endforeach
                    @endif
                 
                </div>
            </div>
        </div>
    </div>

    <div class="text-center d-flex justify-content-center align-items-center" id="contact">
        <div class="col-4 border shadow-sm ps-5 pt-5 pe-5 pb-2 mb-5">
            <h3>Contact Us</h3>
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
            <form action="{{ route('admin#createContact')}}" class="my-4" method="POST">
                @csrf
                <input type="text" name="name" value="{{ old('name')}}" class="form-control " placeholder="Name">
                @if($errors->has('name'))
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                @endif
                <input type="text" name="email" value="{{ old('email')}}" class="form-control mt-3" placeholder="Email">
                @if($errors->has('email'))
                    <p class="text-danger">{{ $errors->first('email') }}</p>
                @endif
                <textarea class="form-control my-3" name="message" id="exampleFormControlTextarea1" rows="3" placeholder="Message">{{ old('message')}}</textarea>
                @if($errors->has('message'))
                    <p class="text-danger">{{ $errors->first('message') }}</p>
                @endif
                <button type="submit" class="btn btn-outline-dark">Send  <i class="fas fa-arrow-right"></i></button>
            </form>
        </div>
    </div>
@endsection