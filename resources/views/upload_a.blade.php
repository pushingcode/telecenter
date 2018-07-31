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

        </div>
    </div>
</div>
@endsection
