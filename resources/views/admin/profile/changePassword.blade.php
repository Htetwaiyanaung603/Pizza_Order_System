@extends('admin.layout.app')

@section('content')

<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-3 mt-5">
            <div class="col-md-9">
              <div class="mb-4"><a href="{{ route('admin#profile') }}" class="text-decoration-none text-dark"><i class="fas fa-arrow-left"></i>back</a>
              </div>
              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">Change Password</legend>
                </div>
                <div class="card-body">
                  @if(Session::has('error'))
                  <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif

                  @if(Session::has('success'))
                  <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">

                        <form action="{{ route('admin#change', Auth()->user()->id ) }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="oldPassword" class="col-sm-4 col-form-label">Old Password</label>
                                <div class="col-sm-8">
                                  <input type="password" class="form-control" name="oldPassword" >
                                  @if($errors->has('oldPassword'))
                                    <p class="text-danger">{{ $errors->first('oldPassword')}}</p>
                                  @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="newPassword" class="col-sm-4 col-form-label">New Password</label>
                                <div class="col-sm-8">
                                  <input type="password" class="form-control" name="newPassword" >
                                  @if($errors->has('newPassword'))
                                    <p class="text-danger">{{ $errors->first('newPassword')}}</p>
                                  @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="confirmPassword" class="col-sm-4 col-form-label">Confirm Password</label>
                                <div class="col-sm-8">
                                  <input type="password" class="form-control" name="confirmPassword" >
                                  @if($errors->has('confirmPassword'))
                                    <p class="text-danger">{{ $errors->first('confirmPassword')}}</p>
                                  @endif
                                </div>
                            </div>

                            
                            <div class="mt-2 float-right">
                                <input type="submit" value="Change" class="btn btn-dark">
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