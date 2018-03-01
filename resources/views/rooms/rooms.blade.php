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
                                    @if ($isAdmin)
                                        <span class=""> delete </span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        @if ($isAdmin)
                            <div>
                                <button class="btn btn-default pull-right"><span class="glyphicon glyphicon-plus"
                                                                                 aria-hidden="true"></span></button>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
