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
            {!! Form::open(['url' => 'acceso/usuario', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
            {!! Form::token() !!}
            <div class="modal-body">
                <div class="row">
                    {{-- <div class="col-md-12">
                        <div class="form-group">
                            <label for="roles">Rol <span class="text-danger" title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <select name="roles" id="roles" class="form-control form-control-sm" required>
                                    <option value="" selected hidden>Seleccionar</option>
                                    @foreach ($roles as $r)
                                    <option value="{{$r}}">{{$r}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">Nombres<span class="text-danger" title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-sm {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="name" placeholder="Ingrese nombres del usuario... " value="{{ old('name') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="email">Correo <span class="text-danger" title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" id="email" placeholder="Ingrese el correo del usuario... " value="{{ old('email') }}" required>
                            </div>
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="password">Contraseña <span class="text-danger" title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" id="password" class="form-control form-control-sm {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" placeholder="Ingrese su contraseña..." required>
                            </div>
                            @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="password-confirm">Repetir Contraseña<span class="text-danger" title="Campo obligatorio">*</span></label>
                            <div class="input-group a mb-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input id="password-confirm" type="password" class="form-control form-control-sm {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" placeholder="Repita su contraseña " name="password_confirmation" autocomplete="new-password" required>
                            </div>
                            @if ($errors->has('password_confirmation'))
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                    </div>                </div>
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
