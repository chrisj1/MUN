<header>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
	      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
	      integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css"
	      href="https://cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.css"/>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"
	        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
	        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
	        crossorigin="anonymous"></script>
	<script type="text/javascript"
	        src="https://cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
	<title>@yield('title')</title>

</header>
<body style="padding-top: 70px">
<nav class="navbar navbar-default navbar-fixed-top" style="margin-bottom: 100px">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
			        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">SJP MUN XII</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li>
					<a class="navbar-link" href="/aboutUs">About Us</a>
				</li>
				<li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false">Contact<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="/contact">Contact Us</a></li>
						<li><a href="/directions">Directions</a></li>
						<li><a href="/campusMap">Campus Map</a></li>
					</ul>
				</li>
				</li>
				<li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false">Committees<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="dropdown-header">General Assembly</li>
						<li><a href="/committees/africanUnion">African Union: Freedom of the Press</a></li>
						<li><a href="/committees/arctic">General Assembly: Arctic Circle</a></li>
						<li><a href="/committees/cyber">General Assembly: Digital Geneva Convention</a></li>
						<li><a href="/committees/women">Commission on the Status of Women: Women's Rights</a></li>
						<li role="separator" class="divider"></li>
						<li class="dropdown-header">Economic and Social Council</li>
						<li><a href="/committees/who">World Health Organization: Pamdemic Prevention Policy</a></li>
						<li role="separator" class="divider"></li>
						<li class="dropdown-header">Specialized</li>
						<li><a href="/committees/fantasy">Fantasy: Climate Change</a></li>
						<li><a href="/committees/opioid">MA State Legislature: Opioid Crisis</a></li>
						<li><a href="/committees/prison">Senate Judiciary Committee: Prison Privatization</a></li>
						<li><a href="/committees/robots">Senate: Automation in the Workforce</a></li>
						<li><a href="/committees/china">One Belt One Road Forum: One Belt One Road</a></li>
						<li role="separator" class="divider"></li>
						<li class="dropdown-header">Historical</li>
						<li><a href="/committees/cuba">Joint Crisis: Cuban Missile Crisis</a></li>
						<li><a href="/committees/ussr">Soviet Central Committee:?????</a></li>
					</ul>
				</li>
				@yield('nav')
			</ul>
			<ul class="nav navbar-nav navbar-right">
				@if(Auth::check())
					<li><a href="/logout">Logout</a></li>
					<li><a href="/dashboard">{{ Auth::user()->name }}'s portal</a></li>
				@else
					<li><a href="/login">Login</a></li>
					<li><a href="/register">Register</a></li>
					@endif
					</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
@yield('content')
</body>
<footer>
	<div class="container">
		<script>
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			})
		</script>
	</div>
	<div style="margin-left: 2%">
		<p class="text-muted credit">SJPMUN-2017</p>
	</div>

	<script>
		(function (i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r;
			i[r] = i[r] || function () {
						(i[r].q = i[r].q || []).push(arguments)
					}, i[r].l = 1 * new Date();
			a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m)
		})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-72015410-1', 'auto');
		ga('require', 'linkid');
		ga('send', 'pageview');
	</script>
</footer>