<?php use App\Http\Controllers\UsuarioController as UC; ?>
@extends('layouts.admin')
@section('contenido')

    {!! Form::open([
        'url' => route('usuario.update', $usuario->id),
        'method' => 'PUT',
        'autocomplete' => 'off',
        'files' => true,
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <b>Editar | {{ 'Usuario' }}</b>
                        <input type="hidden" name="id" value="{{ $usuario->id }}">
                        <h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                {{-- @if ($usuario->email != 'admin@gmail.com')
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="roles">Rol</label> <span class="text-danger"></span>
                                            <div class="input-group a mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <select name="roles" class="form-control">
                                                    @foreach ($roles as $r)
                                                    <option value="{{$r}}" {{UC::rol($usuario->id) == $r ? 'selected' : ''}}>{{$r}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif --}}

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Nombres<span class="text-danger" title="Campo obligatorio">*</span></label>
                                        <div class="input-group a mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="name" placeholder="Ingrese nombres de Usuario... " value="{{ empty(old('name')) ? $usuario->name : old('name') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">Correo<span class="text-danger" title="Campo obligatorio">*</span></label>
                                        <div class="input-group a mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" id="email" placeholder="Ingrese correo del Usuario... " value="{{ empty(old('email')) ? $usuario->email : old('email') }}" {{$usuario->email == 'admin@gmail.com' ? 'readOnly' : ''}} required>
                                        </div>
                                        @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="password">Contraseña</label>
                                        <div class="input-group a mb-6">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" id="password" class="form-control form-control-sm {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" placeholder="Ingrese contraseña...">
                                        </div>
                                        @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="password-confirm">Repetir Contraseña</label>
                                        <div class="input-group a mb-6">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input id="password-confirm" type="password" class="form-control form-control-sm {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" placeholder="Repita su contraseña..." name="password_confirmation" autocomplete="new-password">
                                        </div>
                                        @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div style="margin: 0px auto 0px auto">
                            <div style="margin: 0px auto 0px auto">
                                <a href="{{ route('usuario.index') }}" type="button" class="btn btn-danger ">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Modificar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
    <script>
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
    </script>
    @push('scripts')
        <script>
            $('.phoneUsers').on('input', function() {
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
