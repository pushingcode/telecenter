 @extends('admin.admin')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8">

		<!-- Consumo del Disco -->
	    <div class="panel panel-default">
		  <div class="panel-body">
		  	<h3>Consumo del Disco Local</h3>
		    <div class="progress">
			  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$porcentajes}}%;">
			    {{$porcentajes}}%
			  </div>
			</div>
		  </div>
		</div>
		<!-- Consumo del Disco -->

		<!-- Descripcion del Disco -->
		<div class="panel panel-default">
		  <div class="panel-body">
		  	<h3>Informacion del Disco Local</h3>
		    <p>Ubicacion: {{$disco}}</p>
		    <p>Tamano: {{$size}}Mb</p>
		  </div>
		</div>
		<!-- Descripcion del Disco -->
       </div>
    </div>
  </div>

@endsection