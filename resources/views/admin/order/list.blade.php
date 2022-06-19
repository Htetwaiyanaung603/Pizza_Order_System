@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
     
      <div class="container-fluid">
    
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <span class="fs-5 ms-3">Total = {{ $order->total() }}</span>
                <div class="card-tools d-flex">
                  <div>
                    <a href="{{ route('admin#orderDownload') }}"><button class="btn btn-sm mt-1 me-3 btn-success">Download CSV</button></a>
                  </div>
                  <form action="{{ route('admin#orderSearch') }}" method="GET">
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
                      <th>Customer Name</th>
                      <th>Pizza Name</th>
                      <th>Pizza Count</th>
                      <th>Order Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @foreach ($order as $items)
                      <tr>
                        <td>{{ $items->order_id }}</td>
                        <td>{{ $items->customer_name }}</td>
                        <td>{{ $items->pizza_name }}</td>
                        <td>{{ $items->count }}</td>
                        <td>{{ $items->order_time }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                {{-- <div class="mt-2">{{ $category->links() }}</div> --}}
                
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