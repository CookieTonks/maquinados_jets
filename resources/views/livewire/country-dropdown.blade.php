<div class="row">
    <div class="col-md-6 mb-3">
        <label for="country" class="block text-sm font-medium text-gray-700">Cliente</label>
        <select id="cliente" name="cliente" class="form-control" wire:model="country">
            <option>--- Selecciona un cliente ---</option>
            @foreach($countries as $country)
            <option value="{{$country->cliente}}">{{$country->cliente}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="city" class="block text-sm font-medium text-gray-700">Usuario</label>
        <select id="usuario" name="usuario" class="form-control" wire:model="city">
            @if($cities->count() == 0)
            <option>Selecciona cliente primero</option>
            @endif
            @foreach($cities as $city)
            <option value="{{$city->nombre}}">{{$city->nombre}}</option>
            @endforeach
        </select>
    </div>
</div>