<?php use App\Http\Controllers\VacunaController as VC; ?>
<form action="{{ route('numJeringas', $v->cod_vacuna) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="modalJeringa-{{ $v->cod_vacuna }}" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: #36679e">
                    <h4 class="modal-title" id="myModalLabel">Jeringas Asignadas</h4>
                    <button type="button" class="close text-light" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">

                    @php($jeringas = VC::obtenerJeringas($v->cod_vacuna))

                    <input type="hidden" name="cod_vacuna" id="" value="{{ $v->cod_vacuna }}">

                    @if (count($jeringas) > 0)
                        @foreach ($jeringas as $j)
                            <div> <label for="">{{ $j->descripcion }}</label>
                                <input type="hidden" name="cod_jeringa" value="{{ $j->cod_jeringa }}">
                                <input type="text"
                                    class="form-control form-control-sm {{ $errors->has('num_mul') ? 'is-invalid' : '' }} esNumero"
                                    name="num_mul" id="num_mul" placeholder="Ejm. 4"
                                    value="{{ old('num_mul', $j->num_mul) }}">
                            </div>
                        @endforeach
                    @else
                        Ninguna
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</form>
