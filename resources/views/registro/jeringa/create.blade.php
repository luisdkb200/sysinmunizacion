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
            {!! Form::open(['url' => 'registro/jeringa', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
            {!! Form::token() !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="descripcion">Nombre de Jeringa<span class="text-danger" title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-syringe"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-sm {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" name="descripcion" id="descripcion" placeholder="Ingrese jeringa " value="{{ old('descripcion') }}" required>
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
