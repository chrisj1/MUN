@extends('layout')

@section('content')
	<div class="container">
		<ul class="nav nav-tabs" style="margin: 2%; padding-bottom: 2%">
			<li role="presentation"><a href="/dashboard" class="list-group-item" data-toggle="tooltip"
			                           data-placement="top" title="Return to your dashboard home">Home</a></li>
			<li role="presentation"><a href="/dashboard/requests" class="list-group-item" data-toggle="tooltip"
			                           data-placement="top" title="Request positions">Request Positions</a></li>
			<li role="presentation"><a href="/dashboard/manage" class="list-group-item" data-toggle="tooltip"
			                           data-placement="top" title="Manage your delegates">Manage Delegates</a></li>
			<li role="presentation"><a href="/dashboard/payment" class="list-group-item" data-toggle="tooltip"
			                           data-placement="top"
			                           title="View your payments and the confrence costs">Payment</a></li>
			<li role="presentation"><a href="#" class="list-group-item" data-toggle="tooltip" data-placement="top"
			                           title="View the briefing papers for each committee">Briefing Papers</a></li>
		</ul>
		@yield('stuff')
	</div>
@endsection
