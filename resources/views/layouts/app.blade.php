<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .margin {
            margin: 0.5em;
        }
    </style>
</head>
<body>
    <div id="app">
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
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
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

        @yield('content')
    </div>

    <!-- Scripts -->
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script src="https://www.gstatic.com/firebasejs/3.9.0/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyD5LkxJYlnXxbb1MrRYBljpRU7H2oFqDwk",
            authDomain: "shopping-list-f3b3f.firebaseapp.com",
            databaseURL: "https://shopping-list-f3b3f.firebaseio.com",
            projectId: "shopping-list-f3b3f",
            storageBucket: "shopping-list-f3b3f.appspot.com",
            messagingSenderId: "141470586772"
        };
        firebase.initializeApp(config);
        var database = firebase.database().ref().child('items');
        database.on('value', function(snapshot) {
            var list = $('#items');
            list.empty();
            var i = 1;
            for(var item in snapshot.val())
            {
                list.append("<div id='item-div-" + i + "' class='row margin'><li><span>" + snapshot.val()[item].name + "</span><i>, x<b>" + snapshot.val()[item].quantity + "</b></i><button class='pull-right' id='item-" + i + "' data-id='" + item + "' onClick='delete_item(" + i + ")'>Remove item</button></li></div>");
                i++;
            }
        });

        $(document).ready(function() {
            $('#submit_item').click(function () {
                var name = $('#name').val();
                var qty = $('#qty').val();
                if(name == '' || name == undefined || qty =='' || qty == undefined || name == ' ' || qty == ' ')
                {
                    alert('Name and Qunatity are required');
                    return false;
                }
                var item = {
                    name: name,
                    quantity: qty
                };
                database.push(item);
                return false;
            });

            $('#remove_all').click(function () {
               var sure = confirm('Are you sure? This cannot be undone!');
               if (sure) {
                    database.remove();
               }
            });
        });

        var deleted;

        function delete_item(i) {
            var id = $('#item-' + i).attr('data-id');
            deleted = $('#item-div-'+i);
            database.child(id).remove();
        }

        function restore_deleted () {
            if(deleted != null && deleted != undefined && deleted != '')
            {
                var name = deleted.find('span').text();
                var qty = deleted.find('b').text();
                var item = {
                    name: name,
                    quantity: qty
                };
                database.push(item);
            }
        }
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
