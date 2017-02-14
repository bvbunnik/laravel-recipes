<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Recipes Database</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300" rel="stylesheet">
    <!-- Styles -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.6/cerulean/bootstrap.min.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.theme.css">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
    <!-- CKEditor -->
    <script src="//cdn.ckeditor.com/4.5.9/standard/ckeditor.js"></script>

</head>
<body>
    <nav class="navbar navbar-static-top">
        <button class="navbar-toggler" style="clear: both" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar" aria-controls="exCollapsingNavbar" aria-expanded="false" aria-label="Toggle navigation">
            &#9776;
        </button>
        <div class="collapse" id="exCollapsingNavbar">
            <div class="bg-inverse p-a-3">
                <h4>Collapsed content</h4>
                <span class="text-muted">All your favourite recipes in one place!</span>
            </div>
        </div>
        <a href={{ url('/') }} class="navbar-brand">Home</a>
        <ul class="nav navbar-nav mr-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="supportedContentDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Recipes</a>
            <div class="dropdown-menu" aria-labelledby="supportedContentDropdown">
                <a class="dropdown-item" href="{{ url('/recipes/create') }}">Add Recipe</a>
                <a class="dropdown-item" href="{{ url('/recipes/import') }}">Import Recipe</a>
            </div>
        </li>
            <li class="nav-item">
                <a class="nav-link" href="/recipes/favourites">Favourites</a>
            </li>
        </ul>
        <form class="form-inline pull-xs-right" action="/recipes/search" method="get">
            <input class="form-control" type="text" placeholder="Type your keywords" name="q">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </nav>
    <div id="head-c" class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                <h1>Recipes Database</h1>
            </div>
        </div>
    </div>
    @yield('content')
    <!-- JavaScripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
    @yield('after-script')
</body>
</html>