<div>
    <div class="mb-8">
        <label class="inline-block w-32 font-bold">Country:</label>
        <select name="country" wire:model="country" class="form-control custom-select d-block w-100">
            <option value=''>Choose a country</option>
            @foreach($countries as $country)
                <option value={{ $country->id }}>{{ $country->name }}</option>
            @endforeach
        </select>
    </div>
    @if(count($cities) > 0)
        <div class="mb-8">
            <label class="inline-block w-32 font-bold">City:</label>
            <select name="city" wire:model="city" 
                class="form-control custom-select d-block w-100">
                <option value=''>Choose a city</option>
                @foreach($cities as $city)
                    <option value={{ $city->id }}>{{ $city->cliente }}</option>
                @endforeach
            </select>
        </div>
    @endif
    @if(count($users) > 0)
        <div class="mb-8">
            <label class="inline-block w-32 font-bold">City:</label>
            <select name="user" wire:model="user" 
                class="form-control custom-select d-block w-100">
                <option value=''>Choose a city</option>
                @foreach($users as $user)
                    <option value={{ $user->id }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    @endif
</div>