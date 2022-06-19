@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-3 mt-5">
            <div class="col-md-9">
              <div class="mb-4"><a href="{{ route('admin#category') }}" class="text-decoration-none text-dark"><i class="fas fa-arrow-left"></i>back</a>
              </div>
              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">Edit Category</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form action="{{ route('admin#updateCategory') }}" method="POST" class="form-horizontal">
                        @csrf

                        <div class="form-group row">
                          <label for="name" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">

                             <input type="hidden" name="id" value="{{ $category->category_id }}"> 

                            <input type="text" class="form-control" name="name" value="{{ old('name',$category->category_name) }}">
                            @if ($errors->has('name'))
                            <p class="text-danger">{{ $errors->first('name')}}</p>
                            @endif
                          </div>
                         
                        </div>

                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn bg-dark text-white">Update
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