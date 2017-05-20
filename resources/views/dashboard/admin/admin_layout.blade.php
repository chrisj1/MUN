@extends('layout')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs" style="margin: 1%; padding-bottom: 1%">
            <li role="presentation"><a href="/dashboard/" class="list-group-item">Home</a></li>
            <li role="presentation"><a href="/admin/delegates" class="list-group-item">Delegates</a></li>
            <li role="presentation"><a href="/admin/delegations" class="list-group-item">Delegations</a></li>
            <li role="presentation"><a href="/admin/payment" class="list-group-item">Payment</a></li>
            <li role="presentation"><a href="/admin/positions" class="list-group-item">Positions</a></li>
            <li role="presentation"><a href="/admin/committees" class="list-group-item">Committees</a></li>
            <li role="presentation"><a href="/admin/lunches" class="list-group-item">Lunches</a></li>
            <li role="presentation"><a href="/admin/papers" class="list-group-item">Briefing Papers</a></li>
        </ul>
        @yield('stuff')
    </div>
@endsection

