@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('users.delete',['id'=>$user]) }}">
                               {{ csrf_field() }}
                                <div class="alert alert-danger" role="alert">Delete <b>{{$user->name}}</b> ({{$user->email}}) ?</div>
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>
                                    <a  class="btn btn-link" href="{{ route('users') }}">
                                        Cancel
                                    </a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
