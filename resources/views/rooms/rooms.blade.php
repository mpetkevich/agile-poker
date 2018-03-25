@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">

                    <div class="panel-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="3">
                                    Rooms
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($rooms as $room)
                                <tr>
                                    <td>
                                        <a href="{{route('rooms.vote', ['id' => $room])}}">
                                            {{ $room->name }}
                                        </a>
                                    </td>
                                    <td>
                                        owner <b>{{$room->user->name}}</b>
                                    </td>
                                    <td>
                                        @if (\App\User::isAdmin() || $room->user == $user)
                                            <span class="pull-right"><a href="{{ route('rooms.delete',['id'=> $room]) }}"><span class="glyphicon glyphicon-minus-sign item-delete" aria-hidden="true"></span></a></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3">
                                    <div class="pull-right"><a href="{{ route('rooms.new') }}"><span class="glyphicon glyphicon-plus-sign item-add" aria-hidden="true"></span></a></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
