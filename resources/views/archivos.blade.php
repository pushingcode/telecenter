@extends('admin.admin')

@section('content')
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Fecha de Creacion</th>
      <th scope="col">Referencias</th>
      <th scope="col">Ubicacion</th>
      <th scope="col">Descargar</th>
    </tr>
  </thead>
  <tbody>
    @foreach($recursos as $recurso)
    <tr class="table-active">
      <td>{{ $recurso->created_at }}</td>
      <td>El archivo posee entredas desde {{$inicio[$recurso->id]}} hasta {{$fin[$recurso->id]}}</td>
      <td>{{ $recurso->manifest }}</td>
      <td><a href="donwload/{{ $recurso->id }}">Binario</a></td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
