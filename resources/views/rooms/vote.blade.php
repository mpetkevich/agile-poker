@extends('layouts.app')

@section('content')
<div id="votePageContent" data-room="{{$roomID}}"></div>
@endsection

@section('footerScripts')
    @parent
    <script src="{{ asset('js/vote.js') }}"></script>
@endsection
