@extends('admin.layout.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
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
                  <a href="{{ route('admin#addPizza') }}" >
                    <button class="btn btn-sm btn-dark">
                      <i class="fas fa-plus"></i>
                    </button>
                  </a>
                </h3>

                <span class="fs-4 ms-3">Total = {{ $pizza->total() }}</span>

                <div class="card-tools d-flex">
                  <div>
                    <a href="{{ route('admin#pizzaDownload') }}"><button class="btn btn-sm mt-1 me-3 btn-success">Download CSV</button></a>
                  </div>
                  <form action="{{ route('admin#searchPizza') }}" method="GET">
                    @csrf
                    <div class="input-group input-group-sm mt-1" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
  
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
                      <th>Pizza Name</th>
                      <th>Image</th>
                      <th>Price</th>
                      <th>Publish Status</th>
                      <th>Buy 1 Get 1 Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                   @if ( $status == 0)
                    
                    <tr>
                      <td colspan="7">
                        <small class="text-muted">There is no data...</small>
                      </td>
                    </tr>
                      
                     
                   @else

                   @foreach ($pizza as $items)
                   <tr>
                    <td>{{ $items->pizza_id }}</td>
                    <td>{{ $items->pizza_name }}</td>
                    <td>
                      <img src="{{ asset('images/'.$items->image)}}" class="img-thumbnail" width="100px">
                    </td>
                    <td>{{ $items->price }} kyats</td>
                    <td>
                      @if ($items->publish_status == '0') 
                        Publish
                      @else
                        Unpublish
                      @endif
                    </td>
                    <td>
                      @if ($items->buy_one_get_one_status == '0') 
                        No
                      @else
                        Yes
                      @endif
                    </td>
                    <td>
                      <a href="{{ route('admin#editPizza', $items->pizza_id) }}"><button class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button></a>
                      <a href="{{ route('admin#deletePizza', $items->pizza_id) }}"><button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button></a>
                      <a href="{{ route('admin#infoPizza', $items->pizza_id) }}"><button class="btn btn-sm bg-primary text-white"><i class="fas fa-info"></i></button></a>
                    </td>
                 </tr>
                   @endforeach
                   @endif

                  </tbody>
                </table>
                <div is no data...iv class="mt-2">{{ $pizza->links() }}</div>
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
  <!-- /.content-wrapper -->
@endsection