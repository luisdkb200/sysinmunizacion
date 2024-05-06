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
                <span>Nuevo</span>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open([
                'url' => 'registro/establecimiento',
                'method' => 'POST',
                'autocomplete' => 'off',
                'files' => 'true',
            ]) !!}
            {!! Form::token() !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Microred<span class="text-danger" title="Campo obligatorio">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                </div>
                                <select
                                    class="form-control form-control-sm selectpicker {{ $errors->has('cod_microred') ? 'is-invalid' : '' }}"
                                    name="cod_microred" data-live-search="true" required>
                                    <option value="">Seleccionar microred</option>
                                    @foreach ($microred as $mr)
                                        <option value="{{ $mr->cod_microred }}"
                                            {{ old('cod_microred') == $mr->cod_microred ? 'selected' : '' }}>
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
                    <div class="col-12">
                        <div class="form-group">
                            <label>Acopio<span class="text-danger" title="Campo obligatorio">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-warehouse"></i></span>
                                </div>
                                <select
                                    class="form-control form-control-sm selectpicker {{ $errors->has('cod_acopio') ? 'is-invalid' : '' }}"
                                    name="cod_acopio" data-live-search="true" required>
                                    <option value="">Seleccionar acopio</option>
                                    @foreach ($acopio as $ac)
                                        <option value="{{ $ac->cod_acopio }}"
                                            {{ old('cod_acopio') == $ac->cod_acopio ? 'selected' : '' }}>
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
                            <label for="nombre_est">Nombre de Establecimiento<span class="text-danger"
                                    title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-hospital-alt"></i></span>
                                </div>
                                <input type="text"
                                    class="form-control form-control-sm {{ $errors->has('nombre_est') ? 'is-invalid' : '' }}"
                                    name="nombre_est" id="nombre_est" placeholder="Ingrese nombre de establecimiento... " value="{{ old('nombre_est') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="codigo_est">Codigo de Establecimiento<span class="text-danger"
                                    title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                </div>
                                <input type="text"
                                    class="form-control form-control-sm {{ $errors->has('codigo_est') ? 'is-invalid' : '' }}"
                                    name="codigo_est" id="codigo_est" placeholder="Ingrese codigo de establecimiento... " value="{{ old('codigo_est') }}">
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
        $('.phoneUsers').on('input', function() {
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
