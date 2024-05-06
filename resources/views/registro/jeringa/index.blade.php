<?php use App\Http\Controllers\AreasController; ?>
@extends('layouts.admin')
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h4>
                <b>Jeringas</b>
            </h4>
           
                <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                    <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
                </a>
           
        </div>
        <div class="card-body">
            @include('registro.jeringa.search')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive p-0" id="table_refresh">
                    <table id="datatable" class="table table-sm table-hover text-nowrap">
                        <thead class="text-white" style="background: #365c88">
                            <tr>
                                <th>N°</th>
                                <th>Jeinga</th>                               
                                <th colspan="2" style="text-align: center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                            @php($cont = ($page - 1) * $paginate + 1)
                            @foreach ($jeringa as $j)
                                <tr>
                                    <td>{{ $cont++ }}</td>
                                    <td>{{ $j->descripcion }}</td>                                    
                                    <td align="center">
                                       
                                            <a class="btn btn-sm btn-info" href="{{ route('jeringa.edit', $j->cod_jeringa) }}">
                                                <i class="far fa-edit" title="EDITAR JERINGA {{ $j->descripcion }}"></i>
                                            </a>
                                        
                                    </td>
                                    <td class="text-center">
                                       
                                        {{-- @if (UserController::validate_destroy($a->idUsers)) --}}
                                        {{-- @if ($a->id != 1) --}}
                                            <form action="{{ route('jeringa.destroy', $j->cod_jeringa) }}"
                                                style="margin-bottom: 0px" method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-danger borrar btn-sm"
                                                    title="Eliminar Jeringa {{ $j->descripcion }}"
                                                    data-nombre="{{ $j->descripcion }}"><i class="fas fa-trash"
                                                        aria-hidden="true"></i></button>
                                            </form>
                                        {{-- @endif --}}
                                        {{-- @endif --}}
                                       
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $jeringa->appends(['searchText' => $searchText]) }}
                </div>
            </div>
        </div>
        @include('registro.jeringa.create')
    </div>

    @push('scripts')
        @if (count($errors) > 0)
            <script>
                $(document).ready(function() {
                    Snackbar.show({
                        text: 'Registre de forma correcta los campos.',
                        actionText: 'CERRAR',
                        pos: 'bottom-right',
                        duration: 5000
                    });
                    $('#modal-add').modal('show');
                });
            </script>
        @endif

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

        {{-- <script>
            document.getElementById("imageUsers").onchange = function(e) {
                let reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
                reader.onload = function() {
                    let preview = document.getElementById('img'),
                        image = document.createElement('img');

                    image.src = reader.result;

                    preview.innerHTML = '';
                    preview.append(image);
                };
            }
        </script> --}}
        {{-- <script>
            $('.apertura').unbind().click(function() {
                var $button = $(this);
                var data_nombre = $button.attr('data-nombre');
                Swal.fire({
                    title: '¿Desea cambiar el estado del Usuario?',
                    showDenyButton: true,
                    confirmButtonText: `Cambiar`,
                    denyButtonText: `Cancelar`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var d = '{{ route('usuario.show', 0) }}' + data_nombre
                        window.location.href = d;
                    }
                    // else if (result.isDenied) {
                    //     Swal.fire('No se realizó ningún cambio', '', 'info')
                    // }
                })
                return false;
            });
        </script> --}}
    @endpush
@endsection
