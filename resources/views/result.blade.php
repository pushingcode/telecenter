
 @extends('admin.admin')

@section('content')
  <div class="container">
    <div class="row">

        @foreach($query as $result)
          <div class="panel">
          <div class="panel-body">
            <h5 class="panel-title">Cuenta: {{$result->Numero_Cuenta}}</h5>
            <h5>Fecha: {{$result->Fecha}}</h5>
            <h5>Tecnico: {{$result->Tecnico}}</h5>
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
</div>
</div>
</div>

@endsection
