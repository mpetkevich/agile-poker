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
                                <label for="user-self-register-allowed" class="col-md-4 control-label">User self register</label>
                                <div class="col-md-6">
                                    <select id="user-self-register-allowed" name="user-self-register-allowed" class="form-control">
                                        <option value="1" @if(App\Settings::get('userSelfRegisterAllowed', true)) selected @endif >On</option>
                                        <option value="0" @if(!App\Settings::get('userSelfRegisterAllowed', true)) selected @endif >Off</option>
                                    </select>
                                    @if ($errors->has('user-self-register-allowed'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('user-self-register-allowed') }}</strong>
                                    </span>
                                    @endif
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
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="3">
                                    Users
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <a href="{{route('users.edit', ['id' => $user])}}">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($user->role == \App\User::ROLE_ADMIN )
                                            <span class="badge">admin</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="pull-right"><a href="{{ route('users.delete',['id'=> $user]) }}"><span class="glyphicon glyphicon-minus-sign item-delete" aria-hidden="true"></span></a></span>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3">
                                    <div class="pull-right"><a href="{{ route('users.new') }}"><span class="glyphicon glyphicon-plus-sign item-add" aria-hidden="true"></span></a></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
