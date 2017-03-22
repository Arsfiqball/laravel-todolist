@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <todo{!! Auth::user() ? " :auth='".Auth::user()->toJSON()."'" : '' !!}></todo>
    </div>
  </div>
</div>
@endsection
