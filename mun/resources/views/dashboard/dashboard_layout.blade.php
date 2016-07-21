@extends('layout')

@section('content')
    <div class="container">
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Tasks</div>
                <div class="list-group">
                    <a href="/dashboard" class="list-group-item">Home</a>
                    <a href="/dashboard/contact" class="list-group-item">Contact</a>
                    <a href="/dashboard/manage" class="list-group-item">Manage Delegates</a>
                    <a href="/dashboard/payment" class="list-group-item">Payment</a>
                    <a href="/dashboard/papers" class="list-group-item">Briefing Papers</a>
                </div>
            </div>
        </div>
        @yield('stuff')
    </div>
@endsection
