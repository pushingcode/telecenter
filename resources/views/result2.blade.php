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
        <style>
             #map {
              height: 400px;
              width: 100%;
             }
        </style>
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
      <div class="col-md-8">

        @foreach($query as $result)
          <div class="panel" style="width: 78rem;">
          <div class="panel-body">
            <h5 class="panel-title">Cuenta: {{$result->Numero_Cuenta}}</h5>
            <h6 class="panel-subtitle mb-2 text-muted">Abonado: {{$result->Nombre}}</h6>
            <span class="label label-primary">Orden: {{$result->Numero_Orden}}</span>
            <span class="label label-primary">{{$result->SubTipo_Orden}}</span>
            <span class="label label-success">{{$result->Estado}}</span>
            <p class="panel-text">Comentario Ultima Orden: <br> {{$result->Notas_Entrantes}}</p>
            <p class="panel-text">Tecnico: <br> {{$result->Tecnico}}</p>
            <a href="#" class="panel-link">Ultima Visita: {{$result->Fecha}}</a>
            <a href="#" class="panel-link">Telefono: {{$result->Telefono}}</a>
          </div>
        </div>
        @endforeach
        <br>
        <div class="alert alert-info" role="alert" style="width: 78rem;">
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

        <div class="panel" style="width: 78rem;">
          <div id="map"></div>

          <div class="panel-body">
            <h5 class="panel-title">Direccion</h5>
            <p class="panel-text">{{$result->Direccion}}</p>
            <p class="text-info">Nodo: {{$result->Nodo}}</p>
            <div>
              <input id="address" type="hidden" value="{{$result->Direccion}}, {{$result->Ciudad}}, Argentina"> <input id="submit" type="button" value="Localizar">

            </div>
          </div>
        </div>
        <script>
          function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
              zoom: 8,
              center: {lat: -34.6083, lng: -58.3712}
            });
            var geocoder = new google.maps.Geocoder();

            document.getElementById('submit').addEventListener('click', function() {
              geocodeAddress(geocoder, map);
            });
          }

          function geocodeAddress(geocoder, resultsMap) {
            var address = document.getElementById('address').value;
            geocoder.geocode({'address': address}, function(results, status) {
              if (status === 'OK') {
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                  map: resultsMap,
                  position: results[0].geometry.location
                });
              } else {
                alert('Geocode was not successful for the following reason: ' + status);
              }
            });
          }
        </script>

      </div>
    </div>
  </div>
</div>
</div>
</div>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOZQRPFPuRw3EeoXwW_7v47ikP0F3JXeo&callback=initMap">
</script>

 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
         <script href="{{asset('bootstrap/dist/js/bootstrap.min.js')}}"></script>
         <script href="{{asset('bootstrap/dist/js/custom.js')}}"></script>
         <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
white prime