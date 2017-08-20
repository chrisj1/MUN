@extends('layout')

@section('title')
	Home
@endsection

@section('content')
	<body>
	<style type="text/css">
		img {
			margin-left: auto;
			margin-right: auto;
			display: block;
			width: 75%;
		}
	</style>

	<div>
		<p>
		<h1 class="text-center">St. John's Prep Eleventh Annual<br>Model United Nations Conference</h1>
		<h3 class="text-center">December 9, 2017</h3>
	</div>


	<div id="highlightsCaressel" class="carousel slide" data-interval="3000">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
			<li data-target="#myCarousel" data-slide-to="3"></li>
			<li data-target="#myCarousel" data-slide-to="4"></li>

		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner">
			<div class="item active">
				<img class="highlightImage" src="https://photos.smugmug.com/Student-Life/SJP-MUN-X/i-NvQ89kz/0/X2/IMG_6322-X2.jpg" alt="1">
				<div class="carousel-caption">
					@if(Carbon\Carbon::createFromDate(2017, 10, 1) <= \Carbon\Carbon::now())
						<h2>Registration is now open</h2>
						<button href="/register" class="btn btn-primary btn-xlarge">Register</button>
					@else
						<h3 class="text-center">Registration opens November 1, 2017</h3><br>
						<h4>In the meantime you can browse our committees or our about us page.</h4>
					@endif

				</div>
			</div>

			<div class="item">
				<img class="highlightImage" src="https://photos.smugmug.com/Student-Life/Model-UN-Event-Photos-by-Nik/i-qQJLZ7H/0/e9b31ff1/X3/IMG_3568-X3.jpg" alt="2">
				<div class="carousel-caption">
					<h3 class="text-center">Large Variety of Great Committees</h3>
					<h3 class="text-center"><button class="btn btn-xlarge btn-primary">Check out The Committees</button></h3>
				</div>
			</div>

			<div class="item">
				<img class="highlightImage" src="https://photos.smugmug.com/Student-Life/Model-UN-Event-Photos-by-Nik/i-qNChZtZ/0/83a132bd/X5/IMG_3801-X5.jpg" alt="3">

				<div class="carousel-caption">
					<h3 class="text-center">more highlights</h3>
				</div>
			</div>

			<div class="item">
				<img class="highlightImage" src="https://photos.smugmug.com/Student-Life/Model-UN-Event-Photos-by-Nik/i-SZGhJpH/0/93a1118a/X3/IMG_3620-X3.jpg" alt="4">
				<div class="carousel-caption">
					<h3 class="text-center">Large Variety of Great Committees</h3>
					<h3 class="text-center"><button class="btn btn-xlarge btn-primary">Check out The Committees</button></h3>
				</div>
			</div>

			<div class="item">
				<img class="highlightImage" src="https://photos.smugmug.com/Student-Life/Model-UN-Event-Photos-by-Nik/i-JbV9kjM/0/79af841f/X3/IMG_3744-X3.jpg" alt="5">
				<div class="carousel-caption">
					<h3 class="text-center">Large Variety of Great Committees</h3>
					<h3 class="text-center"><button class="btn btn-xlarge btn-primary">Check out The Committees</button></h3>
				</div>
			</div>
		</div>

		<!-- Left and right controls -->
		<a class="left carousel-control" href="#highlightsCaressel" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#highlightsCaressel" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

	<script>
		$(document).ready(function(){
			$("#highlightsCaressel").carousel("cycle");
		});

		// Enable Carousel Controls
		$(".left").click(function(){
			$("#myCarousel").carousel("prev");
		});
		$(".right").click(function(){
			$("#myCarousel").carousel("next");
		});
	</script>
	<link href="/css/carousel.css" type="text/css" rel="stylesheet">
	</body>
@endsection