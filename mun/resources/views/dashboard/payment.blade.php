@extends('dashboard.dashboard_layout')

@section('title')
    Dashboard
@endsection

@section('stuff')
    <div class="col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading" >Price Per Delegate: {{$price_per_delegate}}</div>
        </div>
    </div>

@endsection