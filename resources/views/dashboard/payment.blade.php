@extends('dashboard.dashboard_layout')

@section('title')
    Dashboard
@endsection

@section('stuff')
    <div class="panel panel-primary">
        <div class="panel-heading" >Price Per Delegate: {{$price_per_delegate}}</div>
    </div>
    <div class="panel panel-danger">
        <div class="panel-heading" >Registration Fee: {{\App\Utils::money_format('%#10n', \App\Http\Controllers\DashboardController::$registartion_fee)}}</div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading" >Total Cost: {{$cost}}</div>
    </div>
    <div class="panel panel-warning">
        <div class="panel-heading" >Amount Due: {{$amount_due}}</div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            Sending money
        </div>
        <div class="panel-body">
            Your spot will not be reserved until full payment is received.
            Please send checks to: <br> St. John's Prep Model United Nations <br>
            72 Spring Street Danvers, Ma 01923 <br> Online payment can also be done.
            Please give 48 hours between payment received and the portal update.
        </div>
    </div>

@endsection