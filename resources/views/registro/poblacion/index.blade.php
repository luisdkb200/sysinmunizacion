<?php use App\Http\Controllers\AreasController; ?>
@extends('layouts.admin')
@section('contenido')
    {{-- <style>
        .vacuna-button:hover {
            background-color: #bcbad7;
        }
    </style> --}}
    <div class="card">
        <div class="card-header text-center">
            <h4>
                <b>ASIGNACION DE POBLACION POR VACUNAS</b>
            </h4>
            {{-- <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
            </a> --}}
        </div>
        {{-- <div class="card-body"> --}}
        {{-- @include('registro.vacuna.search') --}}
        {{-- </div> --}}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @foreach ($vacunas as $v)
                            <div class="col-md-3">
                                <div class="card mb-4">
                                    <a type="button" href="{{ route('vistaPoblacion', $v->cod_vacuna) }}"
                                        class="btn btn-outline-info"
                                        style="padding: 8px 15px;"><b>{{ $v->sigla }}</b></a>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- @include('registro.vacuna.create') --}}
    </div>
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
