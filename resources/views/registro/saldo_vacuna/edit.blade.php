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
        'url' => route('saldo_vacuna.update', $saldo_vacuna->cod_saldo),
        'method' => 'PUT',
        'autocomplete' => 'off',
        'files' => true,
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>Editar | {{ 'Saldo de Vacuna' }}</b>
                        <input type="hidden" name="cod_saldo" value="{{ $saldo_vacuna->cod_saldo }}">
                        <h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Vacuna<span class="text-danger" title="Campo obligatorio">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                            </div>
                                            <select
                                                class="form-control form-control-sm selectpicker {{ $errors->has('cod_vacuna') ? 'is-invalid' : '' }}"
                                                name="cod_vacuna" data-live-search="true" required >
                                                @foreach ($vacuna as $v)
                                                    <option value="{{ $v->cod_vacuna }}"
                                                        {{ old('cod_vacuna', $saldo_vacuna->cod_vacuna) == $v->cod_vacuna ? 'selected' : '' }} >
                                                        {{ $v->sigla }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('cod_vacuna'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('cod_vacuna') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Mes<span class="text-danger" title="Campo obligatorio">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-warehouse"></i></span>
                                            </div>
                                            <select
                                                class="form-control form-control-sm selectpicker {{ $errors->has('mes') ? 'is-invalid' : '' }}"
                                                name="mes" data-live-search="true" required >
                                                @foreach ($mesM as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('mes', $saldo_vacuna->mes) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('mes'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('mes') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Año<span class="text-danger" title="Campo obligatorio">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                            </div>
                                            <select
                                                class="form-control form-control-sm selectpicker {{ $errors->has('anio') ? 'is-invalid' : '' }}"
                                                name="anio" data-live-search="true" required>
                                                @foreach ($anioM as $a)
                                                    <option value="{{ $a }}"
                                                        {{ old('anio', $saldo_vacuna->anio) == $a ? 'selected' : '' }}>
                                                        {{ $a }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('anio'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('anio') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Stock<span class="text-danger"
                                                title="Campo obligatorio">*</span></label>
                                        <div class="input-group a mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-hospital-alt"></i></span>
                                            </div>
                                            <input type="text"
                                                class="form-control form-control-sm {{ $errors->has('stock') ? 'is-invalid' : '' }}"
                                                name="stock" placeholder="Ingrese stock de establecimiento... "
                                                value="{{ empty(old('stock')) ? $saldo_vacuna->stock : old('stock') }}"
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
                                <a href="{{ route('saldo_vacuna.index') }}" type="button" class="btn btn-danger ">Cancelar</a>
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
