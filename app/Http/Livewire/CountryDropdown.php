<?php

namespace App\Http\Livewire;

use App\Models\cliente;
use App\Models\usuarios;
use Livewire\Component;

class CountryDropdown extends Component
{
    public $countries = [], $cities = [];
    public $country, $city;

    public function mount()
    {
        $this->countries = cliente::all();;
        $this->cities = collect();
    }

    public function updatedCountry($value)
    {
        $this->cities = usuarios::where('cliente', $value)->get();
        $this->city = $this->cities->first()->id ?? null;
    }

    public function render()
    {
        return view('livewire.country-dropdown');
    }
}
