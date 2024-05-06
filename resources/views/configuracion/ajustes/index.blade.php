@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>
                        <b>{{ 'Configuración / Información' }}</b>
                    </h4>
                </div>
                {{-- <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Buttons</li>
                </ol>
            </div> --}}
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive" style="background: white">
                <table class="table ">
                    <tr>
                        <td colspan="2" class="text-danger">
                            *Esta información es importante para la emisión de reportes.
                        </td>
                    </tr>
                    <tr>
                        <td class="text-secondary"><b>Foto:</b></td>
                        <td>
                            @if (!empty($empresa->logoEmp))
                                <img src="{{ asset('empresas/' . $empresa->logoEmp) }}" alt="" width="100" height="100">
                            @else
                                Aún no tiene una foto.
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-secondary"><b>Nombre:</b></td>
                        <td>{{ $empresa->nomEmp }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary"><b>Teléfono:</b></td>
                        <td>{{ $empresa->telefEmp }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary"><b>Dirección:</b></td>
                        <td>{{ $empresa->direcEmp }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary"><b>RUC:</b></td>
                        <td>{{ $empresa->nroRucEmp }}</td>
                    </tr>
                   

                    <tr>
                      
                        <td colspan="2" style="text-align: center;">
                            <a class="btn btn-primary" style="width: 150px; background: #406ccc" href=""
                                data-target="#modal-add-{{ $empresa->idEmpresa }}" data-toggle="modal">
                                Editar <i class="far fa-edit" style="margin-left: 20px"></i>
                            </a>
                        </td>
                       
                    </tr>

                </table>
            </div>

        </div>
        {{-- <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <span class="text-danger"> *Esta configuración cambiará el modo de operar del sistema.</span>
                </div>
                <form action="{{ route('info_config') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{$empresa->idempresa}}">
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="saleDelete" name="saleDelete"
                                    {{ $empresa->saleDelete == 'on' ? 'checked' : ''}}>
                                <label class="custom-control-label" for="saleDelete">Eliminar definitivamente las
                                    ventas</label>
                                <p style="font-size: 0.8em">En caso se encuentre desactivado esta opción, solo se cambiará
                                    el estado de las ventas eliminadas.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div> --}}
    </div>

    @include('configuracion.ajustes.modal')
    <script type="text/javascript">
        function mostrar() {
            var archivo = document.getElementById("Imagen").files[0];
            var reader = new FileReader();
            if (archivo) {
                reader.readAsDataURL(archivo);
                reader.onloadend = function() {
                    document.getElementById("img").src = reader.result;
                    // document.getElementById("nombre_imagen").value = archivo.name;
                }
            } else {
                document.getElementById("img").src = "";
                // document.getElementById("nombre_imagen").value = "";
            }
        }
    </script>

    @push('scripts')
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
        @endif
        {{-- ----------------------------------------------- --}}
        @if (Session::has('error'))
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
        @if (count($errors) > 0)
            <script type="text/javascript">
                $(document).ready(function() {
                    // $('#modal-add').modal('show');
                    $('#modal-add-<?php echo old('idEmpresa'); ?>').modal('show');
                    $("#modal-add-<?php echo old('idEmpresa'); ?>").on('hidden.bs.modal', function() {
                        location.reload();
                    });
                });
            </script>
        @endif
    @endpush
@endsection
