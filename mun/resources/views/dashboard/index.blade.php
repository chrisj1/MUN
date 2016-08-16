@extends('dashboard.dashboard_layout')

@section('title')
	Dashboard
@endsection

@section('stuff')
	<div class="panel panel-info">
		<div class="panel-heading">Dashboard</div>

		<div class="panel-body">
			Welcome to your dashboard. Here you will be able to see various
			updates and infomation about the confrence!
		</div>
	</div>
	<div class="panel panel-danger">
		<div class="panel-heading">Payment Due November 30th!</div>

		<div class="panel-body">
			Please make sure you are payed in full or your spot may be forfeit.
		</div>
	</div>

	<div class="panel panel-warning">
		<div class="panel-heading">Awards</div>

		<div class="panel-body">
			Each committee will give out awards, the number of awards per committee will be about a tenth the number of delegates in the committe.
			Awards include Best delegate, outstanding delegate and honorable mentions.
		</div>
	</div>
@endsection
