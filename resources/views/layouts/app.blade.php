<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('bootstrap/dist/css/bootstrap.css')}}">


</head>
<body>
    <div id="app">
        <main class="py-4">

            @if($errors->any())
                @php

                $type_error = strpos ( $errors->first(), "*");

                    if($type_error === false){

                        echo "<div class='container'><div class='row'><div class='alert alert-danger'>";
                            echo "<strong>Whoops!</strong> Tenemos un problema Capitan.<br><br>";
                            echo "<ul>";
                            foreach ($errors->all() as $error){
                                echo "<li> " .$error. " </li>";
                            }
                            echo"</ul>";
                        echo "</div></div></div>";

                    }else{

                        $flashData = explode("*",$errors->first());
                @endphp
                <div class='container'><div class='row'><div class="alert alert-{{$flashData[0]}} alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Atencion!</strong> <h4>{{$flashData[1]}}</h4>
                </div></div></div>
                @php
                }
                @endphp

            @endif

            @yield('content')
        </main>
    </div>
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
     <script href="{{asset('bootstrap/dist/js/bootstrap.min.js')}}"></script>
     <script href="{{asset('bootstrap/dist/js/custom.js')}}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
