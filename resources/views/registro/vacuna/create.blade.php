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
            {!! Form::open(['url' => 'registro/vacuna', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
            {!! Form::token() !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="nombre">Nombre de Vacuna<span class="text-danger"
                                    title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-syringe"></i></span>
                                </div>
                                <input type="text"
                                    class="form-control form-control-sm {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                                    name="nombre" id="nombre" placeholder="Ingrese nombre de vacuna..."
                                    value="{{ old('nombre') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="sigla">Sigla de Vacuna<span class="text-danger"
                                    title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                </div>
                                <input type="text"
                                    class="form-control form-control-sm {{ $errors->has('sigla') ? 'is-invalid' : '' }}"
                                    name="sigla" id="sigla" placeholder="Ingrese sigla de vacuna..."
                                    value="{{ old('sigla') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="num_dosis">Numero de Dosis<span class="text-danger"
                                    title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-prescription-bottle"></i></span>
                                </div>
                                <input type="text"
                                    class="form-control form-control-sm {{ $errors->has('num_dosis') ? 'is-invalid' : '' }} numerodosis"
                                    name="num_dosis" id="num_dosis"
                                    placeholder="Ingrese numero de dosis por contenido..."
                                    value="{{ old('num_dosis') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>Jeringa<span class="text-danger" title="Campo obligatorio">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-syringe"></i></span>
                                </div>
                                <select
                                    class="form-control form-control-sm selectpicker {{ $errors->has('cod_jeringa') ? 'is-invalid' : '' }}"
                                    name="cod_jeringa[]" data-live-search="true" multiple required>
                                    {{-- <option value="" disabled selected>Selecciona jeringas</option> --}}
                                    @foreach ($jeringa as $j)
                                        <option value="{{ $j->cod_jeringa }}"
                                            {{ old('cod_jeringa') == $j->cod_jeringa ? 'selected' : '' }}>
                                            {{ $j->descripcion }}
                                        </option>
                                        {{-- <input type="text"> --}}
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
        $('.numerodosis').on('input', function() {
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
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker({
                noneSelectedText: 'Selecciona opciones'
            });
        });
    </script>
    
@endpush
