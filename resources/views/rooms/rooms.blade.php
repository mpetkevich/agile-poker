@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Rooms</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach ($rooms as $room)
                                <li class="list-group-item">
                                    <a href="{{route('rooms.vote', ['id' => $room])}}">
                                        {{ $room->name }}
                                    </a>
                                    (owner <b>{{$room->user->name}}</b>)
                                    @if (\App\User::isAdmin() || $room->user == $user)
                                        <span class="pull-right"><a href="{{ route('rooms.delete',['id'=> $room]) }}"><span class="glyphicon glyphicon-minus-sign room-delete" aria-hidden="true"></span></a></span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                            <div>
                                <div class="pull-right"><a href="{{ route('rooms.new') }}"><span class="glyphicon glyphicon-plus-sign room-add" aria-hidden="true"></span></a></div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
