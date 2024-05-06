{!! Form::open([
    'url' => 'registro/poblacion/asignacion/' . $vacunas->cod_vacuna,
    'method' => 'GET',
    'autocomplete' => 'off',
    'role' => 'search',
    'id' => 'myForm',
]) !!}
<div class="col-md-12 col-12">
    <div class="card-tools">
        <div class="input-group input-group-sm">
            <select name="acopio" id="acopio" class="form-control">
                <option value="" disabled selected>Seleccione acopio</option>
                @foreach ($acopio as $a)
                   
                    <option value="{{ $a->cod_acopio }}">
                        {{ $a->nombre_acopio }}
                    </option>
                @endforeach
            </select>
            <select name="searchText1" id="searchText1" class="form-control">
                @foreach ($anioM as $a)
                    <option value="{{ $a }}" {{ $a == $searchText1 ? 'selected' : '' }}>
                        {{ $a }}
                    </option>
                @endforeach
            </select>
            {{-- <div class="input-group-append">
                <button type="submit" id="buscar" class="btn btn-default text-white" style="background: #365c88">
                    <i class="fas fa-search"></i>
                </button>
            </div> --}}
        </div>
    </div>
</div>
{{ Form::close() }}

<script>
    // Esperar a que se cargue completamente el DOM
    document.addEventListener('DOMContentLoaded', function() {
        // Captura el evento de cambio en los select
        document.getElementById('acopio').addEventListener('change', function() {
            document.getElementById('myForm').submit(); // Envía el formulario al hacer la selección
        });

        document.getElementById('searchText1').addEventListener('change', function() {
            document.getElementById('myForm').submit(); // Envía el formulario al hacer la selección
        });
    });
</script>
