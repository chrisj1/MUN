@extends('layout')

@section('content')
@yield('stuff')
@endsection

@section('nav')
</li>
<li>
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Actions<span
				class="caret"></span></a>
	<ul class="dropdown-menu">
		<li role="presentation"><a href="/dashboard/">Home</a></li>
		<li role="presentation"><a href="/admin/delegates">Delegates</a></li>
		<li role="presentation"><a href="/admin/delegations">Delegations</a></li>
		<li role="presentation"><a href="/admin/payment">Payment</a></li>
		<li role="presentation"><a href="/admin/positions">Positions</a></li>
		<li role="presentation"><a href="/admin/committees">Committees</a></li>
		<li role="presentation"><a href="/admin/lunches">Lunches</a></li>
		<li role="presentation"><a href="/admin/papers">Briefing Papers</a></li>
		<li role="presentation"><a href="/admin/alerts">Alerts</a></li>
		<li role="presentation"><a href="/admin/groups">Groups</a></li>
		@if(Auth::user()->id == 1)
			<li role="separator" class="divider"></li>
			<li role="presentation"><a href="/admin/admin">Administration</a></li>
		@endif
	</ul>
</li>
</li>
@endsection
