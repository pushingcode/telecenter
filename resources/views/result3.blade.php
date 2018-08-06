@extends('admin.admin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="panel">
                <div class="panel-header">Dashboard</div>

                <div class="panel-body">
                    <form action="/testAnalitico" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <input name="file" type="file">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
            @empty($analisis)
                <b>El archivo no posee registros en VGs</b>
            @else
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Orden</th>
                  <th scope="col">Numero de Cuenta</th>
                  <th scope="col">SubTipo Orden Pendiente</th>
                  <th scope="col">Fecha Pendiente</th>
                  <th scope="col">Ultima Visita</th>
                  <th scope="col">Tecnico</th>
                  <th scope="col">SubTipo Orden Ultima Visita</th>
                  <th scope="col">Estado Actual</th>
                </tr>
              </thead>
              <tbody>
                @foreach($analisis as $registro)

                  <tr>
                    <th scope="row">{{$registro["Numero_Orden"]}}</th>
                    <td>{{$registro["Numero_Cuenta"]}}</td>
                    <td>{{$registro["SubTipo_Orden"]}}</td>
                    <td>{{$registro["Fecha_Pendiente"]}}</td>
                    <td>{{$registro["Ultima_Visita"]}}</td>
                    <td>{{$registro["Tecnico"]}}</td>
                    <td>{{$registro["SubTipo_OrdenUV"]}}</td>
                    <td>{{$registro["EstadoUV"]}}</td>
                  </tr>

                @endforeach
              </tbody>
            </table>
            @endempty

        </div>
    </div>
</div>

@endsection
