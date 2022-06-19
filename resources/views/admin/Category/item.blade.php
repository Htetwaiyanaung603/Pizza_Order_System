@extends('admin.layout.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-2">
             <h3 class="my-2">{{ $pizza[0]->categoryName}}</h3> 
            <div class="card">
              <div class="card-header">

                <span class="fs-4 ms-3">Total = {{ $pizza->total() }}</span>

               
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                
                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Pizza name</th>
                      <th>Price</th>
                      
                    </tr>
                  </thead>
                  <tbody>

                   @foreach ($pizza as $items)
                   <tr>
                    <td>{{ $items->pizza_id }}</td>
                   
                    <td>
                      <img src="{{ asset('images/'.$items->image)}}" class="img-thumbnail" width="100px">
                    </td>
                    <td>{{ $items->pizza_name }}</td>
                    <td>{{ $items->price }} kyats</td>
    
                    {{-- <td>
                      <a href="{{ route('admin#infoPizza', $items->pizza_id) }}"><button class="btn btn-sm bg-primary text-white"><i class="fas fa-info"></i></button></a>
                    </td> --}}
                 </tr>
                   @endforeach
               

                  </tbody>
                </table>
                
                <div class="mt-2">{{ $pizza->links() }}</div>
              </div>
              <!-- /.card-body -->
              <div>
                <a href="{{ route('admin#category')}}">
                    <button class="btn btn-sm btn-dark m-2">Back</button>
                </a>
              </div>
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