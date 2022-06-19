@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-3 mt-5">
            <div class="col-md-9">
              <div class="mb-4"><a href="{{ route('admin#pizza') }}" class="text-decoration-none text-dark"><i class="fas fa-arrow-left"></i>back</a>
              </div>
              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">Pizza Information</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane d-flex justify-content-center" id="activity">
                      <div class="mt-2 d-flex align-items-center pr-4">
                          <img src="{{ asset('images/'.$pizza->image) }}" alt="Not Found" style="width: 200px; height: 200px" class="img-thumbnail rounded-circle">
                      </div>
                      <div class="mt-2">
                          <div class="mt-2">
                              <b>Name</b> : <span>{{ $pizza->pizza_name }}</span>
                          </div>
                          <div class="mt-2">
                            <b>Price</b> : <span>{{ $pizza->price }} lyats</span>
                        </div>
                        <div class="mt-2">
                            <b>Publish Status</b> : <span>
                                @if( $pizza->publish_status == 0)
                                 Publish
                                @else
                                 Unpublish
                                @endif
                            </span>
                        </div>
                        <div class="mt-2">
                            <b>Category</b> : <span>{{ $pizza->category_id }}</span>
                        </div>
                        <div class="mt-2">
                            <b>Discount</b> : <span>{{ $pizza->discount_price }} kyats</span>
                        </div>
                        <div class="mt-2">
                            <b>Buy 1 Get 1</b> : <span>
                                @if ($pizza->buy_one_get_one_status == 1)
                                    Yes
                                @else
                                    No
                                @endif
                            </span>
                        </div>
                        <div class="mt-2">
                            <b>Waiting Time</b> : <span>{{ $pizza->waiting_time }} min</span>
                        </div>
                        <div class="mt-2">
                            <b>Description</b> : <span>{{ $pizza->description }}</span>
                        </div>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection