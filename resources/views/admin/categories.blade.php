@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
          <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title flex-grow-1 ">Category Table</h3>
            <a href="{{ URL::route('create.category') }}">

                <i class="fas fa-plus-circle " style="font-size: 1.4em"></i>
              </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created</th>
                    <th>Updated</th>
                  </tr>
                </thead>
                <tbody>
                    @if($categories->count() > 0)
                        @foreach ($categories as $category)
                            <tr>
                                <td> {{ $category->id }}</td>
                                <td> {{ $category->name }}</td>
                                <td> {{ $category->created_at }}</td>
                                <td> {{ $category->updated_at }}</td>
                            </tr>
                        @endforeach
                    @endif
                 
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
</div>
    
@endsection