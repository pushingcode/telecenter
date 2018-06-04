@extends('admin.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

	        <div class="panel">
	        	<div class="panel-body">
	        		<div class="media">
					  <div class="media-left">
					    <a href="#">
					      <img class="media-object" src="{{url('storage')}}/{{ $miperfil->foto }}" alt="..." height="60" width="60">
					    </a>
					  </div>
					  <div class="media-body">
					    <h4 class="media-heading">Cargo: {{ $miperfil->cargo }}</h4>
					    
					  </div>
					</div>
	        	</div>
	        </div>

            <div class="panel">

                <div class="panel-body">
                    <h4>Actualice su Perfil</h4>

                    <form action="/perfil" method="POST" enctype='multipart/form-data'>
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Cargo') }}</label>

                            <div class="col-md-6">
                                <input id="cargo" type="text" class="form-control{{ $errors->has('cargo') ? ' is-invalid' : '' }}" name="cargo" value="{{ $miperfil->cargo }}" required autofocus>

                                @if ($errors->has('cargo'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('cargo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Imagen') }}</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" name="file" value="{{ old('file') }}" required autofocus>

                                @if ($errors->has('file'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Genero') }}</label>

                            <div class="col-md-6">

                                <select name="genero" id="genero" class="form-control" required autofocus>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                    <option value="I">Indeterminado</option>
                                </select>

                                @if ($errors->has('imagen'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('genero') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Crear') }}
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection