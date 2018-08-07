@extends('admin.admin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="panel">
                <div class="panel-header">Analisis de Numeros de Ordenes Pendientes que estan en Rango de Garantias</div>

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
                  <th scope="col">Nota</th>
                </tr>
              </thead>
              <tbody>
                @foreach($analisis as $registro)

                  @foreach($registro as $item)
                    <tr>
                      <th scope="row">{{$item->Numero_Orden}}</th>
                      <td>Esta orden tiene VG.</td>
                    </tr>
                  @endforeach

                @endforeach
              </tbody>
            </table>
            @endempty

        </div>
    </div>
</div>

@endsection
