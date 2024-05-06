<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
    id="modal-add-{{ $empresa->idEmpresa }}">

    {!! Form::model($empresa, [
        'method' => 'PATCH',
        'route' => ['ajustes.update', $empresa->idEmpresa],
        'files' => 'true',
    ]) !!}
    {{ Form::token() }}
    <style>
        .imagen img {
            width: 100px;
            height: auto;
        }
    </style>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: #36679e">
                <span>Mi Empresa</span>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <div class="input-group a mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-id-card fa-2x-x"></i><span
                            class="tooltiptext">Ingrese su Número de Documento</span></span>
                    </div>
                    <input type="text" class="form-control" name="numDocumento" placeholder="Número de Documento"
                    @if (empty(old('numDocumento'))) value="{{ $usuario->numDocumento }}"
                    @else
                        value="{{ old('numDocumento') }}" @endif>
                </div> --}}
                <div class="form-group row">
                    <span class="col-sm-3 col-form-label"><b>Nombres:</b></span>
                    <div class="col-sm-9">
                        <div class="input-group a mb-3">

                            <input type="hidden" name="idEmpresa" id="" value="{{ $empresa->idEmpresa }}">
                            <input type="text" class="form-control" name="nomEmp" placeholder="Nombres"
                                value="{{ empty(old('nomEmp')) ? $empresa->nomEmp : old('nomEmp') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <span class="col-sm-3 col-form-label"><b>N° Teléfono: </b></span>
                    <div class="col-sm-9">
                        <div class="input-group a mb-6">

                            <input type="text" class="form-control" name="telefEmp" placeholder="Teléfono"
                                value="{{ empty(old('telefEmp')) ? $empresa->telefEmp : old('telefEmp') }}">
                        </div>
                        @if ($errors->has('telefEmp'))
                            <div>
                                <span class="text-danger">{{ $errors->first('phoneUsers') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <span class="col-sm-3 col-form-label">Correo</span>
                    <div class="col-sm-9">
                        <div class="input-group a mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-at fa-2x-x"></i>
                            </div>
                            <input type="text" class="form-control" name="email" placeholder="Correo Electrónico"
                                value="{{ empty(old('email')) ? $empresa->email : old('email') }}">
                        </div>
                    </div>
                </div> --}}
                <div class="form-group row">
                    <span class="col-sm-3 col-form-label"><b>Numero de RUC: </b></span>
                    <div class="col-sm-9">
                        <div class="input-group a mb-3">

                            <input type="text" class="form-control" name="nroRucEmp" placeholder="RUC"
                                value="{{ empty(old('nroRucEmp')) ? $empresa->nroRucEmp : old('nroRucEmp') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="col-sm-3 col-form-label"><b>Dirección: </b></span>
                    <div class="col-sm-9">
                        <div class="input-group a mb-3">

                            <input type="text" class="form-control" name="direcEmp" placeholder="Dirección"
                                value="{{ empty(old('direcEmp')) ? $empresa->direcEmp : old('direcEmp') }}">
                        </div>
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <span class="col-sm-3 col-form-label">Tipo de cambio</span>
                    <div class="col-sm-9">
                        <div class="input-group a mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt fa-2x-x"></i>
                            </div>
                            <input type="text" class="form-control" name="currency" placeholder="Tipo de cambio"
                                value="{{ empty(old('currency')) ? $empresa->currency : old('currency') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="col-sm-3 col-form-label">IVA</span>
                    <div class="col-sm-9">
                        <div class="input-group a mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt fa-2x-x"></i>
                            </div>
                            <input type="text" class="form-control" name="IVA" placeholder="Tipo de cambio"
                                value="{{ empty(old('IVA')) ? $empresa->IVA : old('IVA') }}">
                        </div>
                    </div>
                </div> --}}
                <div class="input-group a mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="tooltiptext"><b>Ingrese su Logo: </b></span></span>
                        </div>
                        <input type="file" name="logoEmp" id="Imagen" accept="image/png, .jpeg, .jpg, image/gif"
                            class="form-control" onchange="mostrar()">
                    </div>
                    <div>
                        {{-- @if ($usuario->foto != '') --}}
                        <img src="{{ asset('empresas/' . $empresa->logoEmp) }}" id="img" / width="100"
                            height="100">
                        {{-- @endif --}}
                    </div>
                </div>

                <div class="modal-footer">
                    @if (count($errors) > 0)
                        <div style="margin: 0px auto 0px auto">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </div>

        </div>
        {{ Form::Close() }}

    </div>
</div>
