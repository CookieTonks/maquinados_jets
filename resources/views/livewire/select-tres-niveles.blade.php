<div>
    <label>Empresa:</label>
    <select wire:model="selectedEmpresa" wire:change="updatedSelectedEmpresa($event.target.value)">
        <option value="">Seleccione una empresa</option>
        @foreach($empresas as $empresa)
            <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
        @endforeach
    </select>
</div>

<div>
    <label>Cliente:</label>
    <select wire:model="selectedCliente" wire:change="updatedSelectedCliente($event.target.value)">
        <option value="">Seleccione un cliente</option>
        @foreach($clientes as $cliente)
            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
        @endforeach
    </select>
</div>

<div>
   
