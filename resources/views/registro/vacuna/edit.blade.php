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
        'url' => route('vacuna.update', $vacunas->cod_vacuna),
        'method' => 'PUT',
        'autocomplete' => 'off',
        'files' => true,
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>Editar | {{ 'Vacunas' }}</b>
                        <input type="hidden" name="cod_vacuna" value="{{ $vacunas->cod_vacuna }}">
                        <h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Nombre de Vacuna<span class="text-danger"
                                                title="Campo obligatorio">*</span></label>
                                        <div class="input-group a mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-syringe"></i></span>
                                            </div>
                                            <input type="text"
                                                class="form-control form-control-sm {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                                                name="nombre" placeholder=" "
                                                value="{{ empty(old('nombre')) ? $vacunas->nombre : old('nombre') }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Sigla de Vacuna<span class="text-danger"
                                                title="Campo obligatorio">*</span></label>
                                        <div class="input-group a mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                            </div>
                                            <input type="text"
                                                class="form-control form-control-sm {{ $errors->has('sigla') ? 'is-invalid' : '' }}"
                                                name="sigla" placeholder=" "
                                                value="{{ empty(old('sigla')) ? $vacunas->sigla : old('sigla') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Numero de dosis<span class="text-danger"
                                                title="Campo obligatorio">*</span></label>
                                        <div class="input-group a mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fas fa-prescription-bottle"></i></span>
                                            </div>
                                            <input type="text"
                                                class="form-control form-control-sm {{ $errors->has('num_dosis') ? 'is-invalid' : '' }} numdosis"
                                                name="num_dosis" placeholder=" "
                                                value="{{ empty(old('num_dosis')) ? $vacunas->num_dosis : old('num_dosis') }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Jeringa<span class="text-danger" title="Campo obligatorio">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                            </div>
                                            <select
                                                class="form-control form-control-sm selectpicker {{ $errors->has('cod_jeringa') ? 'is-invalid' : '' }}"
                                                name="cod_jeringa[]" data-live-search="true" multiple required>
                                                @foreach ($jeringa as $j)
                                                    <option value="{{ $j->cod_jeringa }}"
                                                        {{ old('cod_jeringa') == $j->cod_jeringa || $jeringas_asignadas->contains('cod_jeringa', $j->cod_jeringa) ? 'selected' : '' }}>
                                                        {{ $j->descripcion }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('cod_jeringa'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('cod_jeringa') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div style="margin: 0px auto 0px auto">
                            <div style="margin: 0px auto 0px auto">
                                <a href="{{ route('vacuna.index') }}" type="button" class="btn btn-danger ">Cancelar</a>
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
