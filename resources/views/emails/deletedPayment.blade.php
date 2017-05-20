@extends('emails.email_layout')

@section('content')
	Hello, {{$user->school}} <br>
	Your payment has been removed or declined. If this is incorrect please
	contact us to correct this. We look forwards to seeing you in December.

	<br>
	<br>

	<h3>Your payment infomation:</h3>

	<table>
		<tr>
			<td>
				<strong>Cost:</strong>
			</td>
			<td>
				{{$cost}}
			</td>

		<tr>
			<td>
				<strong>Amount paid:</strong>
			</td>
			<td>
				{{$paid_amount}}
			</td>
		<tr>
			<td>
				<strong>Balance:</strong>
			</td>
			<td>
				{{$amount_due}}
			</td>
		</tr>
	</table>
@endsection