@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading"><h5>Things to do:</h5></div>

        <ul class="list-group">
          @foreach($todos as $todo)
            <li class="list-group-item">
              <div>
                <h4>
                  {{ $todo->title }}
                </h4>
                <p>
                  by {{ $todo->user->name }}
                </p>
              </div>
              @if($todo->finished)
                <a href="{!! route('todo.update', [ 'id' => $todo->id, 'finished' => 0]) !!}" class="btn btn-default btn-sm{!! (auth()->guest() or auth()->user()->cant('update', $todo))? ' disabled' : '' !!}" data-toggle="tooltip" data-placement="bottom" title="Click to mark as not finished"><span class="glyphicon glyphicon-ok"></span> Finished</a>
              @else
                <a href="{!! route('todo.update', [ 'id' => $todo->id, 'finished' => 1]) !!}" class="btn btn-default btn-sm{!! (auth()->guest() or auth()->user()->cant('update', $todo))? ' disabled' : '' !!}" data-toggle="tooltip" data-placement="bottom" title="Click to mark as finished"><span class="glyphicon glyphicon-time"></span> Not finished</a>
              @endif
              @if($todo->privacy == 'public')
                <a href="{!! route('todo.update', [ 'id' => $todo->id, 'privacy' => 'private']) !!}" class="btn btn-default btn-sm{!! (auth()->guest() or auth()->user()->cant('update', $todo))? ' disabled' : '' !!}" data-toggle="tooltip" data-placement="bottom" title="Click to make it private"><span class="glyphicon glyphicon-globe"></span> Public</a>
              @else
                <a href="{!! route('todo.update', [ 'id' => $todo->id, 'privacy' => 'public']) !!}" class="btn btn-default btn-sm{!! (auth()->guest() or auth()->user()->cant('update', $todo))? ' disabled' : '' !!}" data-toggle="tooltip" data-placement="bottom" title="Click to make it public"><span class="glyphicon glyphicon-lock"></span> Private</a>
              @endif
              @can('delete', $todo)
                <a href="{!! route('todo.delete', $todo->id) !!}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Click to delete this"><span class="glyphicon glyphicon-trash"></span> delete</a>
              @endcan
            </li>
          @endforeach
        </ul>
        @if(auth()->user())
          <div class="panel-body">
            <form method="post" action="{!! route('todo.store') !!}">
              {!! csrf_field() !!}
              <div class="input-group">
                <span class="input-group-addon">
                  <input type="checkbox" name="privacy" value="private"> <span class="glyphicon glyphicon-lock"></span> Private
                </span>
                <input class="form-control" type="text" name="title" placeholder="Add new task...">
              </div>
              <button type="submit" style="display: none;"></button>
            </form>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
