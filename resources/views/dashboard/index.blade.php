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
		<div class="panel-heading">Security Council 1 (SC1) and the Fund for Peace</div>

		<div class="panel-body">
			Security Council 1 (SC1) and the Fund for Peace will be filmed for the purpose of
			creating instructional videos, using real SJPMUN XI delegate negotiations as examples.
			Parents of the delegates participating in either of the two filmed committees will need to sign a waiver
			permitting their child to participate.
			Delegates selecting these committees should be experienced in debate and comfortable with being filmed.
		</div>
	</div>
	<div class="panel panel-danger">
		<div class="panel-heading">Payment Due November 20th!</div>

		<div class="panel-body">
			Please make sure you are payed in full or your spot may be forfeit.
		</div>
	</div>

	<div class="panel panel-warning">
		<div class="panel-heading">Awards</div>

		<div class="panel-body">
			Each committee will give out awards, the number of awards per committee will be about a tenth the number of
			delegates in the committe.
			Awards include Best delegate, outstanding delegate and honorable mentions.
		</div>
	</div>
	<div>
		<div class="panel panel-info">
			<div class="panel-heading">Assigning positions</div>

			<div class="panel-body">
				Positions will assigned manually to each delegation after the registration deadline. You will have to
				finalize the assignments, just
				because a committee is requested<strong> does not mean you are guaranteed to receive that
					position.</strong>
			</div>
		</div>
	</div>

	<div>
		<div class="panel panel-danger">
			<div class="panel-heading">Payment</div>
			<div class="panel-body">
				Your Delegate assignments are <strong> not </strong> finalized until
				payment is recieved. It is in your best interests to ensure that payment is
				made online or through a check as soon as possible.
			</div>
		</div>
	</div>
@endsection
