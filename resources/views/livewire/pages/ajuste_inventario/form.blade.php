<div class="flex w-full flex-wrap m-4">
    <div class="flex w-full md:w-1/4">
        <x-frk.components.label-input label="Ajuste Inventario No."  error="ajuste_inventario_no" :disabled="$disabled" wire:model="ajuste_inventario_no" />
    </div>

    <div class="flex w-full md:w-1/4">
        <x-frk.components.date-picker  error="fecha_ajuste_inventario" wire:model="fecha_ajuste_inventario" label="Fecha Ajuste Bodega"/>
    </div>
    <div class="flex w-full">
        <x-frk.components.select label="Producto" error="producto_id" wire:model="producto_id">
            @foreach ($this->productos->productos as $dataa)
            <option value="{{ $dataa->id }}" wire:key="data-{{ $dataa->id }}">{{ $dataa->codigo }} - {{ $dataa->nombre }} - Existencia: {{ $dataa->pivot->cantidad }}</option>
            @endforeach
        </x-forms.select>
    </div>
    <div class="flex w-full">
        <div class="flex w-full md:w-1/2">
            <x-frk.components.select label="Tipo Ajuste" error="tipo_ajuste" wire:model="tipo_ajuste">
                @foreach ($this->tipos_ajustes as $data)
                <option value="{{ $data['valor'] }}" wire:key="producto-{{ $data['valor'] }}">{{ $data['nombre'] }}</option>
                @endforeach
            </x-forms.select>
        </div>
        <div class="flex w-full md:w-1/2">
            <x-frk.components.label-input label="cantidad a trasladar" error="cantidad_traslado" :disabled="$disabled" wire:model="cantidad_traslado" />
        </div>
    </div>
    <div class="flex w-full">
        <x-frk.components.text-area label="descripcion" row="2" :disabled="$disabled" wire:model="descripcion" />
    </div>
</div>
