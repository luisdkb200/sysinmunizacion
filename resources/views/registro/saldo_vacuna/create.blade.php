{{-- <style>
    .imagen img {
        background: #f8eded;
        width: 100px;
        height: auto;
    }
</style> --}}
<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: #36679e">
                <span>Asignar Saldo</span>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open([
                'url' => 'registro/saldo_vacuna',
                'method' => 'POST',
                'autocomplete' => 'off',
                'files' => 'true',
            ]) !!}
            {!! Form::token() !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Vacuna<span class="text-danger" title="Campo obligatorio">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-syringe"></i></span>
                                </div>
                                <select
                                    class="form-control form-control-sm selectpicker {{ $errors->has('cod_vacuna') ? 'is-invalid' : '' }}"
                                    name="cod_vacuna" data-live-search="true" required>
                                    <option value="">Seleccionar vacuna</option>
                                    @foreach ($vacuna as $v)
                                        <option value="{{ $v->cod_vacuna }}"
                                            {{ old('cod_vacuna') == $v->cod_vacuna ? 'selected' : '' }}>
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
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></i></span>
                                </div>
                                <select
                                    class="form-control form-control-sm selectpicker {{ $errors->has('mes') ? 'is-invalid' : '' }}"
                                    name="mes" data-live-search="true" required>
                                    <option value="">Seleccionar mes</option>
                                    @foreach ($mesM as $key => $value)
                                        <option value="{{ $key }}" {{ old('mes') == $key ? 'selected' : '' }}>
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
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></i></span>
                                </div>
                                <select
                                    class="form-control form-control-sm selectpicker {{ $errors->has('anio') ? 'is-invalid' : '' }}"
                                    name="anio" data-live-search="true" required>
                                    <option value="">Seleccionar año</option>
                                    @foreach ($anioM as $a)
                                        <option value="{{ $a }}" {{ old('anio') == $a ? 'selected' : '' }}>
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
                    <div class="col-12">
                        <div class="form-group">
                            <label for="stock">Numero de Vacunas<span class="text-danger"
                                    title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-box"></i></span>
                                </div>
                                <input type="text"
                                    class="form-control form-control-sm {{ $errors->has('stock') ? 'is-invalid' : '' }} cantidad" 
                                    name="stock" id="stock" placeholder="Ingrese cantidad de vacunas..."
                                    value="{{ old('stock') }}" required>
                            </div>
                        </div>
                    </div>
                    
                   
                </div>
            </div>
            <div class="row justify-content-center pb-4">
                <div class="col-12 text-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            {{ Form::Close() }}
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $('.cantidad').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
        });
    </script>
    <script>
        function mostrarContrasena() {
            var tipo = document.getElementById("password");
            if (tipo.type == "password") {
                tipo.type = "text";
            } else {
                tipo.type = "password";
            }
        }
    </script>
@endpush
