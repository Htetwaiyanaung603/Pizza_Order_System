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
                  <a href="{{ route('admin#addCategory') }}"><button class="btn btn-sm btn-outline-dark">Add Category</button></a>
                </h3>

                <span class="fs-5 ms-3">Total = {{ $category->total() }}</span>

                <div class="card-tools d-flex">
                  <div>
                    <a href="{{ route('admin#categoryDownload') }}"><button class="btn btn-sm mt-1 me-3 btn-success">Download CSV</button></a>
                  </div>
                  <form action="{{ route('admin#searchCategory') }}" method="GET">
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
                      <th>Category Name</th>
                      <th>Product Count</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @foreach ($category as $items)
                      <tr>
                        <td>{{ $items->category_id }}</td>
                        <td>{{ $items->category_name }}</td>
                        <td>
                            @if ($items->count == 0 )
                              {{ $items->count }}
                            @else
                              <a href=" {{ route('admin#categoryItem', $items->category_id) }}" class="text-decoration-none text-dark">{{ $items->count }}</a>
                            @endif
                        </td>
                        <td>
                          <a href="{{ route('admin#editCategory', $items->category_id ) }}"><button class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button></a>
                          <a href="{{ route('admin#deleteCategory', $items->category_id ) }}"><button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button></a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="mt-2">{{ $category->links() }}</div>
                
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