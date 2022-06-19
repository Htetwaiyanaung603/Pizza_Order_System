@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
     
      <div class="container-fluid">
        
        <div class="row mt-4">
          <div class="col-8 offset-2">
            <div class="card">
              <div class="card-header">
                <span class="fs-4 ms-3">Total = {{ $contact->total() }}</span>
                <div class="card-tools d-flex">
                  <div>
                    <a href="{{ route('admin#contactDownload') }}"><button class="btn btn-sm mt-1 me-3 btn-success">Download CSV</button></a>
                  </div>
                  <form action="{{ route('admin#contactSearch') }}" method="GET">
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
                      <th>Message</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                   @if ($status == 0)
                        <tr>
                            <td colspan="4">
                            <small class="text-muted">There is no data...</small>
                            </td>
                        </tr>
                   @else
                        @foreach ($contact as $items)
                        <tr>
                            <td>{{ $items->contacy_id }}</td>
                            <td>{{ $items->name }}</td>
                            <td>{{ $items->email }}</td>
                            <td>{{ $items->message }}</td>
                        </tr>
                        @endforeach
                   @endif
                  </tbody>
                </table>
                <div class="mt-2">{{ $contact->links() }}</div>
                
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