@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
     
      <div class="container-fluid">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
          {{ Session::get('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <span class="fs-3">Admin List</span>
                  <a href="{{ route('admin#userList') }}"><button class="btn btn-sm btn-outline-dark ms-3">User List</button></a>
                  {{-- <a href="{{ route('admin#adminList') }}"><button class="btn btn-sm btn-outline-dark">Admin List</button></a> --}}
                </h3>

                <div class="card-tools d-flex">
                  <div>
                    <a href="{{ route('admin#adminDownload') }}"><button class="btn btn-sm mt-1 me-3 btn-success">Download CSV</button></a>
                  </div>
                  <form action="{{ route('admin#adminSearch') }}" method="GET">
                    @csrf
                    <div class="input-group input-group-sm mt-1" style="width: 150px;">
                      <input type="text" name="searchData" class="form-control float-right" placeholder="Search">
  
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
               
                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Address</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @foreach ($admin as $items)
                      <tr>
                        <td>{{ $items->id }}</td>
                        <td>{{ $items->name }}</td>
                        <td>{{ $items->email }}</td>
                        <td>{{ $items->phone }}</td>
                        <td>{{ $items->address }}</td>
                        <td>
                          <a href="{{ route('admin#adminDelete', $items->id) }}"><button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button></a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="mt-2">{{ $admin->links() }}</div>
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection