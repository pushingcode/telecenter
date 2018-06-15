<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistema de Gestion de Garantias</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
          <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
          <!-- Ionicons -->
        <link rel="stylesheet" href="{{asset('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
          <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('adminlte/dist/css/AdminLTE.min.css')}}">
          <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
                page. However, you can choose any other skin. Make sure you
                apply the skin class to the body tag so the changes take effect. -->
        <link rel="stylesheet" href="{{asset('adminlte/dist/css/skins/skin-black.min.css')}}">
    </head>
    <body>
            <div class="container">

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
            <br><br>
                <!--
                Form de consultas para el operador
                -->

                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title">Consulta de Contrato</h3>
                  </div>
                  <div class="panel-body">

                    <form action="/search" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                      <!--<div class="form-group">
                        <label for="inputID" class="col-sm-2 control-label">No. Telefono o Email</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputID" placeholder="Telefono / Email">
                        </div>
                      </div> -->
                      <div class="form-group">
                        <label for="n_contrato" class="col-sm-2 control-label">No. de Contrato</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="n_contrato" name="n_contrato" placeholder="Contrato">
                          <input type="hidden" name="from" value="frontend">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-default">Consultar</button>
                        </div>
                      </div>
                    </form>

                  </div>
                </div>

                <!--
                Form de consultas para el operador
                -->
            </div>
            
        </div>
         <!-- jQuery 3 -->
        <script src="{{asset('adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>

        <script src="{{asset('adminlte/bower_components/jquery-knob/js/jquery.knob.js')}}"></script>

        <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. -->

        <!-- page script -->

        <!-- page script -->
    </body>
</html>
