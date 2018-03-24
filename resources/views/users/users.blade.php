@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">User Settings</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="user-register" class="col-md-4 control-label">User self register</label>
                                <div class="col-md-6">
                                    <label class="switch">
                                        <input id="user-register" name="user-register" type="checkbox" @if(1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading">Users</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach ($users as $user)
                                <li class="list-group-item">
                                    <a href="{{route('users.edit', ['id' => $user])}}">
                                        {{ $user->name }}
                                    </a>

                                    <span class="pull-right"><a href="{{ route('users.delete',['id'=> $user]) }}"><span class="glyphicon glyphicon-minus-sign room-delete" aria-hidden="true"></span></a></span>

                                </li>
                            @endforeach
                        </ul>
                        <div>
                            <div class="pull-right"><a href="{{ route('users.new') }}"><span class="glyphicon glyphicon-plus-sign room-add" aria-hidden="true"></span></a></div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
    </div>
@endsection
