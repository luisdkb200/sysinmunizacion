{!! Form::open(['url' => 'registro/jeringa', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="col-md-3 col-12">
    <div class="card-tools">
        <div class="input-group input-group-sm" >
            <input type="text" name="searchText" class="form-control float-right" value="{{$searchText}}" placeholder="Buscar ...">
            {{-- <input type="date" name="searchText2" class="form-control float-right" value="{{$searchText2}}"> --}}
            <div class="input-group-append">
                <button type="submit" class="btn btn-default text-white" style="background: #365c88">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
