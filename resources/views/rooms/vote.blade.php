@extends('layouts.app')

@section('content')
<div id="votePageContent" data-room="{{$roomID}}"></div>
@endsection

@section('footerScripts')
    @parent
    <script>
        window.agileCards = {!! $cards !!};
    </script>
    <script src="{{ url(mix('js/vote.js')) }}"></script>
@endsection
