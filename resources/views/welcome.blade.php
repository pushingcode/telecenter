<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="{{asset('bootstrap/dist/css/bootstrap.css')}}">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Inicio</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            @endif
            @if($errors->any())
                @php
                    $flashData = explode("*",$errors->first());
                @endphp
                <div class="alert alert-{{$flashData[0]}} alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Atencion!</strong> <h4>{{$flashData[1]}}</h4>
                </div>

            @endif
            <!--
            Form de consultas para el operador
            -->

            <div class="panel">
                <div class="panel"></div>
            </div>

            <!--
            Form de consultas para el operador
            -->
        </div>
         <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
         <script href="{{asset('bootstrap/dist/js/bootstrap.min.js')}}"></script>
         <script href="{{asset('bootstrap/dist/js/custom.js')}}"></script>
    </body>
</html>
