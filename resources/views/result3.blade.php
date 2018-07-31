@extends('admin.admin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

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
                  <th scope="col">Celda</th>
                  <th scope="col">Numero de Cuenta</th>
                  <th scope="col">SubTipo Orden Pendiente</th>
                  <th scope="col">Fecha Pendiente</th>
                  <th scope="col">Ultima Visita</th>
                  <th scope="col">SubTipo Orden Ultima Visita</th>
                </tr>
              </thead>
              <tbody>
                @foreach($analisis as $registro)
                <tr>
                  <th scope="row">{{$registro["id"]}}</th>
                  <td>{{$registro["Numero_Cuenta"]}}</td>
                  <td>{{$registro["SubTipo_Orden"]}}</td>
                  <td>{{$registro["Fecha_Pendiente"]}}</td>
                  <td>{{$registro["Ultima_Visita"]}}</td>
                  <td>{{$registro["SubTipo_OrdenUV"]}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @endempty

        </div>
    </div>
</div>

@endsection
