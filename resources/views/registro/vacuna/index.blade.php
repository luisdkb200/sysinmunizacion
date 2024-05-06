<?php use App\Http\Controllers\VacunaController as VC; ?>
@extends('layouts.admin')
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h4>
                <b>Vacunas</b>
            </h4>

            <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
            </a>

        </div>
        <div class="card-body">
            @include('registro.vacuna.search')
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
                                <th>Nombre de Vacuna</th>
                                <th>Sigla de Vacuna</th>
                                <th>Numero de dosis</th>
                                <th>Estado</th>
                                <th align="center">Jeringa</th>
                                <th colspan="2" style="text-align: center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                            @php($cont = ($page - 1) * $paginate + 1)
                            @foreach ($vacunas as $v)
                                <tr>
                                    <td>{{ $cont++ }}</td>
                                    <td>{{ $v->nombre }}</td>
                                    <td>{{ $v->sigla }}</td>
                                    <td>{{ $v->num_dosis }}</td>
                                    <td align="center">

                                        @if ($v->estado == 1)
                                            <button class="btn apertura" title="Cambiar de estado a {{ $v->cod_vacuna }}"
                                                data-nombre="{{ $v->cod_vacuna }}">
                                                <span
                                                    class="badge badge-success">{{ $v->estado == 1 ? 'ACTIVO' : 'INACTIVO' }}</span>
                                            @else
                                                <button class="btn apertura"
                                                    title="Cambiar de estado a {{ $v->cod_vacuna }}"
                                                    data-nombre="{{ $v->cod_vacuna }}">
                                                    <span
                                                        class="badge badge-danger">{{ $v->estado == 1 ? 'ACTIVO' : 'INACTIVO' }}</span>
                                        @endif

                                    </td>{{-- <td>{{ $v->descripcion }}</td>                                         --}}
                                    <td align="center">

                                        <button type="button" class="btn btn-sm btn-default" data-toggle="modal"
                                            data-target="#modalJeringa-{{ $v->cod_vacuna }}">
                                            @php($jeringas = VC::obtenerJeringas($v->cod_vacuna))


                                            @if (count($jeringas) > 0)
                                                @foreach ($jeringas as $j)
                                                    <span>{{ $j->descripcion }}</span><br>
                                                @endforeach
                                            @else
                                                Ninguna
                                            @endif

                                        </button>
                                    </td>

                                    <td align="center">

                                        <a class="btn btn-sm btn-info" href="{{ route('vacuna.edit', $v->cod_vacuna) }}">
                                            <i class="far fa-edit" title="EDITAR VACUNA {{ $v->nombre }}"></i>
                                        </a>

                                    </td>
                                    <td class="text-center">

                                        {{-- @if (UserController::validate_destroy($v->idUsers)) --}}
                                        {{-- @if ($v->id != 1) --}}
                                        <form action="{{ route('vacuna.destroy', $v->cod_vacuna) }}"
                                            style="margin-bottom: 0px" method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-danger borrar btn-sm"
                                                title="Eliminar Vacuna {{ $v->nombre }}"
                                                data-nombre="{{ $v->nombre }}"><i class="fas fa-trash"
                                                    aria-hidden="true"></i></button>
                                        </form>
                                        {{-- @endif --}}
                                        {{-- @endif --}}

                                    </td>
                                </tr>
                                @include('registro.vacuna.jeringa')
                            @endforeach
                        </tbody>
                    </table>
                    {{ $vacunas->appends(['searchText' => $searchText]) }}
                </div>
            </div>
        </div>
        @include('registro.vacuna.create')
    </div>

    @push('scripts')
        <script>
            $('.esNumero').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
            });
        </script>
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
        <script>
            $('.apertura').unbind().click(function() {
                var $button = $(this);
                var data_nombre = $button.attr('data-nombre');
                Swal.fire({
                    title: '¿Desea cambiar el estado de la Vacuna?',
                    showDenyButton: true,
                    confirmButtonText: `Cambiar`,
                    denyButtonText: `Cancelar`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var d = '{{ route('vacuna.show', 0) }}' + data_nombre
                        window.location.href = d;
                    } else if (result.isDenied) {
                        Swal.fire('No se realizó ningún cambio', '', 'info')
                    }
                })
                return false;
            });
        </script>

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
