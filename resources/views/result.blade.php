
 @extends('admin.admin')

@section('content')
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


<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOZQRPFPuRw3EeoXwW_7v47ikP0F3JXeo&callback=initMap">
</script>

@endsection