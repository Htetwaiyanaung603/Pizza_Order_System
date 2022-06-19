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
                  <legend class="text-center">Edit Pizza</legend>
                </div>
                <div class="card-body">
                    <div class="text-center mb-2">
                        <img src="{{ asset('images/'.$pizza->image)}}" class="img-thumbnail" style="width:120px; height:120px">
                    </div>
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form action="{{ route('admin#updatePizza',$pizza->pizza_id)}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                          <label for="name" class="col-sm-3 col-form-label">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name', $pizza->pizza_name) }}">
                            @if ($errors->has('name'))
                            <p class="text-danger">{{ $errors->first('name')}}</p>
                            @endif
                          </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                              <input type="file" class="form-control" name="image" >
                              @if ($errors->has('image'))
                              <p class="text-danger">{{ $errors->first('image')}}</p>
                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="price" class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                              <input type="number" class="form-control" name="price" placeholder="Price" value="{{ old('price', $pizza->price ) }}">
                              @if ($errors->has('price'))
                              <p class="text-danger">{{ $errors->first('price')}}</p>
                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="publish" class="col-sm-3 col-form-label">Publish Status</label>
                            <div class="col-sm-9">
                             <select name="publish" class="form-control">
                                 @if ($pizza->publish_status == 0)
                                 <option value="">Choose publish</option>
                                 <option value="0" selected>Publish</option>
                                 <option value="1">Unpublish</option>
                                 @else
                                 <option value="">Choose publish</option>
                                 <option value="0">Publish</option>
                                 <option value="1" selected>Unpublish</option>
                                 @endif
                             </select>
                              @if ($errors->has('publish'))
                              <p class="text-danger">{{ $errors->first('publish')}}</p>
                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="category" class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                              <select name="category" class="form-control">
                                  <option value="{{ $pizza->category_id }}">{{ $pizza->category_name}}</option>
                                  @foreach ($category as $items)
                                    @if ($items->category_id == $pizza->category_id)
                                        @continue
                                    @endif
                                    <option value="{{ $items->category_id }}">{{ $items->category_name }}</option>
                                  @endforeach
                              </select>
                              @if ($errors->has('category'))
                              <p class="text-danger">{{ $errors->first('category')}}</p>
                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="discount" class="col-sm-3 col-form-label">Discount</label>
                            <div class="col-sm-9">
                              <input type="number" class="form-control" name="discount" placeholder="discount" value="{{ old('discount', $pizza->discount_price) }}">
                              @if ($errors->has('discount'))
                              <p class="text-danger">{{ $errors->first('discount')}}</p>
                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="buyOnegetOne" class="col-sm-3 col-form-label">Buy1Get1</label>
                            <div class="col-sm-9 mt-2">
                              @if ($pizza->buy_one_get_one_status == 1)
                              <input type="radio" name="buyOnegetOne" value="1" class="form-input-check" checked>Yes
                              <input type="radio" name="buyOnegetOne" value="0" class="form-input-check">No
                              @else
                              <input type="radio" name="buyOnegetOne" value="1" class="form-input-check">Yes
                              <input type="radio" name="buyOnegetOne" value="0" class="form-input-check" checked>No
                              @endif
                              @if ($errors->has('buyOnegetOne'))
                              <p class="text-danger">{{ $errors->first('buyOnegetOne')}}</p>
                              @endif
                            </div>
                            
                          </div>

                          <div class="form-group row">
                            <label for="waitingTime" class="col-sm-3 col-form-label">Waiting Time</label>
                            <div class="col-sm-9">
                              <input type="number" class="form-control" name="waitingTime" placeholder="waitingTime" value="{{ old('waitingTime', $pizza->waiting_time) }}">
                              @if ($errors->has('waitingTime'))
                              <p class="text-danger">{{ $errors->first('waitingTime')}}</p>
                              @endif
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                              <textarea name="description" class="form-control" >{{ old('description', $pizza->description) }}</textarea>
                              @if ($errors->has('description'))
                              <p class="text-danger">{{ $errors->first('description')}}</p>
                              @endif
                            </div>
                          </div>

                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn bg-dark text-white">Create</button>
                          </div>
                        </div>
                      </form>
                      
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