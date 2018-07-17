<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Sistema de Gestion de Garantias</title>
        <!-- Tell the browser to be responsive to screen width -->
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

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <!-- Google Maps -->
        
    </head>
    <body class="hold-transition skin-black sidebar-mini">
      <div class="wrapper">
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



  <div class="container">
    <div class="row">

        @foreach($query as $result)
          <div class="panel">
          <div class="panel-body">
            <h5 class="panel-title">Cuenta: {{$result->Numero_Cuenta}}</h5>
            <h5>Fecha: {{$result->Fecha}}</h5>
            <span class="label label-primary">Sub Tipo de Orden: {{$result->SubTipo_Orden}}</span>
            <p class="panel-text">Notas Entrantes: <br> {{$result->Notas_Entrantes}}</p>
            <p class="panel-text">Notas de Cierre: <br>
              @if($result->Notas_Cierre == null)
                No existen notas de cierre
              @else
                {{$result->Notas_Cierre}}
              @endif
               </p>
            <p class="panel-text">Direccion: <br>
				{{$result->Direccion}}
            </p>
          </div>
        </div>
        @endforeach
        <br>
        <div class="alert alert-info" role="alert">
        @php
          if(count($query) == 1){
            echo "Se encontro un (1) solo registro.";
          }else if(count($query) == 0){
            echo "No existen registros";
          }else{
            echo "Se encontraron ".count($query)." registros";
          }
        @endphp
        </div>
    </div>
  </div>

				<!--
                Form de consultas para el operador
                -->

                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title">Consulta Numero de Cliente</h3>
                  </div>
                  <div class="panel-body">

                    <form action="/search" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                      <div class="form-group">
                        <label for="n_contrato" class="col-sm-2 control-label">No. de Cliente</label>
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
</div>

 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
         <script href="{{asset('bootstrap/dist/js/bootstrap.min.js')}}"></script>
         <script href="{{asset('bootstrap/dist/js/custom.js')}}"></script>
         <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
    </html>