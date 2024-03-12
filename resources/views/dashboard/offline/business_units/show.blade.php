@extends('adminlte::page')

@section('title', 'Business '.$businessUnit->name)

@section('content')
  <div class="card">
    <form action={{route('offline.business_units.update')}} method="post">
      @csrf
      <div class="card-body">
        <div class="form-group row">
          <input type="hidden" name="id" value="{{ $businessUnit->id }}">
          <label for="name" class="col-sm-2 col-form-label">Business Unit Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ $businessUnit->name }}">
          </div>
        </div>
      </div>
      <div class="card-footer">
        <a href="{{ route('offline.business_units.index') }}" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
  
@endsection