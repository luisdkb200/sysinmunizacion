{!! Form::open([
    'url' => 'reporte/vale/',
    'method' => 'GET',
    'autocomplete' => 'off',
    'role' => 'search',
]) !!}
<div class="col-md-6 col-12">
    <div class="card-tools">
        <div class="input-group input-group-sm">
            <select name="searchText" id="" class="form-control">
                @foreach ($mesM as $key => $value)
                    <option value="{{ $key }}" {{ $key == $searchText ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            <select name="searchText1" id="" class="form-control">
                @foreach ($anioM as $a)
                    <option value="{{ $a }}" {{ $a == $searchText1 ? 'selected' : '' }}>
                        {{ $a }}
                    </option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button type="submit" id="buscar" class="btn btn-default text-white" style="background: #365c88">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
