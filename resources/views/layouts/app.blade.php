<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
	<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" />
    <link rel="stylesheet" href="{{ asset('css/mtffl.css') }}">
</head>
<body>
    <div class="wrap">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul id="w2" class="nav navbar-nav">
                    	<li><a href="/smackroom">Smackroom</a></li>
						@if( isset( $mflUrl ) )
                    	<li><a href="{{ $mflUrl }}">MTFFL @ MFL</a></li>
						@endif
						<li><a href="{{ url('teams') }}">Teams</a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" href="hall-of-champions" data-toggle="dropdown">History <b class="caret"></b></a>
							<ul id="w2" class="dropdown-menu">
								<li><a href="{{ url('hall-of-champions') }}" tabindex="-1">Hall of Champions</a></li>
								<li><a href="{{ url('division-winners') }}" tabindex="-1">Division Winners</a></li>
								<li><a href="{{ url('history-grid') }}" tabindex="-1">History Grid</a></li>
								<li><a href="{{ url('trophies') }}" tabindex="-1">Trophies</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-toggle" href="rulebook" data-toggle="dropdown">Rulebook <b class="caret"></b></a>
							<ul id="w3" class="dropdown-menu">
								<li><a href="{{ url('rulebook') }}" tabindex="-1">Rulebook</a></li>
								<li><a href="{{ url('rule-amendments') }}" tabindex="-1">Rule Amendments</a></li>
								<li><a href="{{ url('scoring-rules') }}" tabindex="-1">Scoring Rules</a></li>
								<li><a href="{{ url('cost') }}" tabindex="-1">Prizes / Cost Breakdown</a></li>
								<li><a href="{{ url('tie-breakers') }}" tabindex="-1">Tiebreakers</a></li>
								<li><a href="{{ url('point-calculator') }}" tabindex="-1">Point Calculator</a></li>
							</ul>
						</li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Admin</a></li>
                        @else
                            <li class="dropdown">
							<a class="dropdown-toggle" href="#" data-toggle="dropdown">Admin <b class="caret"></b></a>
							<ul id="w3" class="dropdown-menu">
                            	<li><a href="{{ url('admin') }}">Admin</a></li>
                                   <li>
                                       <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                           Logout
                                       </a>

                                       <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                           {{ csrf_field() }}
                                       </form>
                                   </li>
							</ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

		<div class="content">
			<div class="container">
				@if( '' != Session::get('message') )
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-primary">
						<div class="panel-heading">{{ Session::get('message') }}</div>
						</div>
					</div>
				</div>
				@endif
				<div class="row content">
					<div class="col-md-9">
			        @yield('content')
					</div>
					<div class="col-md-3">
						<h5>FootballGuys News</h5>
						<div>
						@foreach( $news->stories as $n )
						<div class='news-story'>
							<a href="{{ $n->link }}" class='NewsLink' target='_news'>{{ $n->title }}</a>
							&nbsp;&nbsp;<span class='news-desc'>{{ $n->story }}</span>
							&nbsp;<span class='news-date'>{{ date('m/d H:i', $n->date ) }}</span>
						</div>
						@endforeach
						<div class='news-update'>
						Updated {{ date('Y-m-d H:i:s', $news->update_time) }}
						</div>
					</div>

					</div>
				</div>
			</div>
		</div>
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="{{ asset('js/mtffl.js') }}"></script>
</body>
</html>
