<div>
    <div class="mb-8">
<<<<<<< HEAD
        <label class="inline-block w-32 font-bold">Country:</label>
        <select name="country" wire:model="country" class="form-control custom-select d-block w-100">
            <option value=''>Choose a country</option>
=======
        <label class="inline-block w-32 font-bold">Empresa:</label>
        <select name="empresa" wire:model="country" class="form-control custom-select d-block w-100">
                <option value=''>Seleccione una empresa</option>
>>>>>>> master
            @foreach($countries as $country)
                <option value={{ $country->name}}>{{ $country->name }}</option>
            @endforeach
        </select>
    </div>
    @if(count($cities) > 0)
        <div class="mb-8">
<<<<<<< HEAD
            <label class="inline-block w-32 font-bold">City:</label>
            <select name="city" wire:model="city" 
                class="form-control custom-select d-block w-100">
                <option value=''>Choose a city</option>
                @foreach($cities as $city)
                    <option value={{$city->cliente}}>{{ $city->cliente}}</option>
=======
            <label class="inline-block w-32 font-bold">Cliente:</label>
            <select name="cliente" wire:model="city" 
                class="form-control custom-select d-block w-100">
                <option value=''>Seleccione un cliente</option>
                @foreach($cities as $city)
                    <option value={{$city->id}}>{{ $city->cliente}}</option>
>>>>>>> master
                @endforeach
            </select>
        </div>
    @endif
    @if(count($users) > 0)
        <div class="mb-8">
<<<<<<< HEAD
            <label class="inline-block w-32 font-bold">City:</label>
            <select name="user" wire:model="user" 
                class="form-control custom-select d-block w-100">
                <option value=''>Choose a city</option>
                @foreach($users as $user)
                    <option value={{$user->name}}>{{ $user->name }}</option>
=======
            <label class="inline-block w-32 font-bold">Usuario:</label>
            <select wire:model="user" 
                class="form-control custom-select d-block w-100">
                <option value=''>Seleccione un usuario</option>
                @foreach($users as $user)
                    <option name="usuario" value={{$user->name}}>{{ $user->name }}</option>
>>>>>>> master
                @endforeach
            </select>
        </div>
    @endif
</div>