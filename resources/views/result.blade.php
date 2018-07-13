
 @extends('admin.admin')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8">

        @foreach($query as $result)
          <div class="panel" style="width: 78rem;">
          <div class="panel-body">
            <h5 class="panel-title">Cuenta: {{$result->Numero_Cuenta}}</h5>
            <a href="#" class="panel-link">Fecha: {{$result->Fecha}}</a>
            <span class="label label-primary">Orden: {{$result->Numero_Orden}}</span>
            <span class="label label-primary">{{$result->SubTipo_Orden}}</span>
            @php
              if($result->Estado == "Completado"){
                $label = "success";
              } else {
                $label = "warning";
              }
            @endphp
            <span class="label label-{{$label}}">{{$result->Estado}}</span>
            <p class="panel-text">Notas Entrantes: <br> {{$result->Notas_Entrantes}}</p>
            <p class="panel-text">Notas de Cierre: <br>
              @if($result->Habilidades_Trabajo == null)
                No existen notas de cierre
              @else
                {{$result->Habilidades_Trabajo}}
              @endif
               </p>
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

      </div>
    </div>
  </div>

@endsection
