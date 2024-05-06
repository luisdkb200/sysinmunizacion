@extends('layouts.admin')
@section('contenido')
    <style>
        .imagen img {
            background: #f8eded;
            width: 100px;
            height: auto;
        }
    </style>
    {!! Form::open([
        'url' => route('establecimiento.update', $establecimiento->cod_establecimiento),
        'method' => 'PUT',
        'autocomplete' => 'off',
        'files' => true,
    ]) !!}

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>Editar | {{ 'Establecimiento' }}</b>
                        <input type="hidden" name="cod_establecimiento" value="{{ $establecimiento->cod_establecimiento }}">
                        <h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Microred<span class="text-danger" title="Campo obligatorio">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                            </div>
                                            <select
                                                class="form-control form-control-sm selectpicker {{ $errors->has('cod_microred') ? 'is-invalid' : '' }}"
                                                name="cod_microred" data-live-search="true" required>
                                                @foreach ($microred as $mr)
                                                    <option value="{{ $mr->cod_microred }}"
                                                        {{ old('cod_microred', $establecimiento->cod_microred) == $mr->cod_microred ? 'selected' : '' }}>
                                                        {{ $mr->nombre_microred }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('cod_microred'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('cod_microred') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Acopio<span class="text-danger" title="Campo obligatorio">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-warehouse"></i></span>
                                            </div>
                                            <select
                                                class="form-control form-control-sm selectpicker {{ $errors->has('cod_acopio') ? 'is-invalid' : '' }}"
                                                name="cod_acopio" data-live-search="true" required>
                                                @foreach ($acopio as $ac)
                                                    <option value="{{ $ac->cod_acopio }}"
                                                        {{ old('cod_acopio', $establecimiento->cod_acopio) == $ac->cod_acopio ? 'selected' : '' }}>
                                                        {{ $ac->nombre_acopio }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('cod_acopio'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('cod_acopio') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Nombre de Establecimiento<span class="text-danger"
                                                title="Campo obligatorio">*</span></label>
                                        <div class="input-group a mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-hospital-alt"></i></span>
                                            </div>
                                            <input type="text"
                                                class="form-control form-control-sm {{ $errors->has('nombre_est') ? 'is-invalid' : '' }}"
                                                name="nombre_est" placeholder="Ingrese nombre de establecimiento... "
                                                value="{{ empty(old('nombre_est')) ? $establecimiento->nombre_est : old('nombre_est') }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Codigo de Establecimiento<span class="text-danger"
                                                title="Campo obligatorio">*</span></label>
                                        <div class="input-group a mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                            </div>
                                            <input type="text"
                                                class="form-control form-control-sm {{ $errors->has('codigo_est') ? 'is-invalid' : '' }}"
                                                name="codigo_est" placeholder="Ingrese codigo de establecimiento..."
                                                value="{{ empty(old('codigo_est')) ? $establecimiento->codigo_est : old('codigo_est') }}"
                                                required>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div style="margin: 0px auto 0px auto">
                            <div style="margin: 0px auto 0px auto">
                                <a href="{{ route('establecimiento.index') }}" type="button"
                                    class="btn btn-danger ">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Modificar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
    {{-- <script>
        document.getElementById("imageUsers").onchange = function(e) {
            console.log("das");
            // Creamos el objeto de la clase FileReader
            let reader = new FileReader();

            // Leemos el archivo subido y se lo pasamos a nuestro fileReader
            reader.readAsDataURL(e.target.files[0]);

            // Le decimos que cuando este listo ejecute el código interno
            reader.onload = function() {
                let preview = document.getElementById('img2'),
                    image = document.createElement('img');
                console.log("mostrado")
                image.src = reader.result;

                preview.innerHTML = '';
                preview.append(image);
            };
        }
    </script> --}}
    @push('scripts')
        <script>
            $('.numdosis').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
            });
        </script>

        @if (Session::has('success'))
            <script type="text/javascript">
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @elseif(Session::has('error'))
            <script type="text/javascript">
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('error') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif
    @endpush
@endsection
