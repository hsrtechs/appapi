<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>{{ $title or 'No  Title' }}</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap.theme.min.css" rel="stylesheet">
    <style>
        @yield('head-css')
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('head-js')
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Rest Client Frontend</a>
        </div>
        @if(loggedAdmin())
        <ul class="nav navbar-nav">
            <li{!! $_SERVER['REQUEST_URI'] == '/' ? ' class ="active"' : '' !!}><a href="/">Add App</a></li>
            <li{!! $_SERVER['REQUEST_URI'] == '/list-apps' ? ' class ="active"' : '' !!}><a href="/list-apps">List Apps</a></li>
            <li{!! $_SERVER['REQUEST_URI'] == '/list-users' ? ' class ="active"' : '' !!}><a href="/list-users">List
                    Users</a></li>
            <li{!! $_SERVER['REQUEST_URI'] == '/registration' ? ' class ="active"' : '' !!}><a href="/registration">Registration</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="/api/list">Api List</a></li>
            <li><a href="/logout">Logout</a></li>
        </ul>
        @endif
    </div>
</nav>
<div class="container">
    <div class="row">
        @yield('container')
    </div>
</div>

@yield('footer-js')
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/js/bootstrap.min.js"></script>
</body>
</html>