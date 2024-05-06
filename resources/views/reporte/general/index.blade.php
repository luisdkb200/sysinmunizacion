<?php use App\Http\Controllers\AreasController; ?>
@extends('layouts.admin')
@section('contenido')
    <div class="card">
        <div class="card-header text-center">
            <h5>
                <b>Exportar Control de Entrega Anual</b>
            </h5>
            {{-- <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
            </a> --}}
        </div>
        <div class="card-body">
            @include('reporte.general.search')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="card mb-3">
                                {{-- {{ route('vistaMovimiento', $v->cod_vacuna) }} --}}
                                {{-- href="{{ route('vale.excel', ['id' => $a->cod_acopio, 'id2' => $searchText, 'id3' => $searchText1]) }}" --}}
                                <a type="button" href="{{ route('general.excel', ['id' => $searchText1]) }}"
                                    class="btn btn-outline-success"><b>Exportar todo</b></a>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- @include('registro.vacuna.create') --}}
    </div>
@endsection
