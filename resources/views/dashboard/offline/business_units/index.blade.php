@extends('adminlte::page')

@section('title', 'Business Units')

@section('content')
{{-- create button --}}
<div class="card mt-3">
  <div class="card-header">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
      Create Business Unit
    </button>
  </div>
</div>
<div class="card">
  {{-- search --}}
  <div class="card-header">
    <form action="{{ route('offline.business_units.index') }}" method="get">
      <label for="">Search business units</label>
      <div class="input-group">
        <input type="search" name="search" class="form-control form-control" placeholder="Type your keywords here"
          value="{{ Request::get('search') }}">
        <div class="input-group-append">
          <button type="submit" class="btn btn-default">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
  </div>

  <div class="card-body p-0">
    <table class="table table-striped">
      <thead>
        <tr>
          <th style="width: 10px">#</th>
          <th>Business Unit Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        {{-- {{$i=1}} --}}
        @foreach ($businessUnits as $businessUnit)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $businessUnit->name }}</td>
            <td>
              <a href="{{ route('offline.business_units.show', $businessUnit->id) }}" class="btn btn-primary">Edit</a>
              <form action="{{ route('offline.business_units.destroy', $businessUnit->id) }}" method="post" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>
  <!-- /.card-body -->

  <div class="card-footer clearfix">
    <ul class="pagination
      pagination-sm m-0 float-right">
      {{ $businessUnits->links() }}
    </ul>
  </div>

</div>

{{-- modal for create --}}
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('offline.business_units.create') }}" method="post">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">Create Business Unit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group
            @error('name') has-error @enderror">
            <label for="name">Business Unit Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter Business Unit Name"
              value="{{ old('name') }}">
            @error('name')
              <span class="help-block
                text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
@endsection