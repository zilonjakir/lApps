@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
    @endif
    <form method="post" action="{{URL::to('user/store')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="Name">User Name :</label>
            <input type="hidden" class="form-control" name="id" value="{{@$userInfo->id}}">
            <input type="text" class="form-control" name="name" value="{{@$userInfo->name}}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="Email">Email:</label>
              <input type="text" class="form-control" name="email" value="{{@$userInfo->email}}">
            </div>
          </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4" style="">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </div>
      </form>
</div>
@endsection
