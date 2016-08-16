@extends('layout')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs" style="margin: 2%; padding-bottom: 2%">
            <li role="presentation"><a href="/dashboard" class="list-group-item">Home</a></li>
            <li role="presentation"><a href="/dashboard/manage" class="list-group-item">Manage Delegates</a></li>
            <li role="presentation"><a href="/dashboard/payment" class="list-group-item">Payment</a></li>
            <li role="presentation"><a href="/dashboard/papers" class="list-group-item">Briefing Papers</a></li>
        </ul>
        @yield('stuff')
    </div>
@endsection
