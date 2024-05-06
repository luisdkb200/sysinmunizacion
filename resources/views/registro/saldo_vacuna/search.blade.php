{!! Form::open(['url' => 'registro/saldo_vacuna', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search',  'id' => 'myForm']) !!}
<div class="col-md-6 col-12">
    <div class="card-tools">
        <div class="input-group input-group-sm" >
            <input type="text" name="searchText" id="searchText" class="form-control float-right" value="{{$searchText}}" placeholder="Buscar ...">
            <select name="searchText1" id="searchText1" class="form-control">
                @foreach ($mesM as $key => $value)
                    <option value="{{ $key }}" {{ $key == $searchText1 ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            {{-- <div class="input-group-append">
                <button type="submit" class="btn btn-default text-white" style="background: #365c88">
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
        document.getElementById('searchText').addEventListener('change', function() {
            document.getElementById('myForm').submit(); // Envía el formulario al hacer la selección
        });

        document.getElementById('searchText1').addEventListener('change', function() {
            document.getElementById('myForm').submit(); // Envía el formulario al hacer la selección
        });
    });
</script>
