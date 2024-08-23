<div class="flex w-full flex-wrap m-4">
    <div class="flex w-full md:w-1/4">
        <x-frk.components.label-input label="no_servicio" error="no_servicio" :disabled="$disabled" wire:model="no_servicio" />
    </div>

    <div class="flex w-full md:w-1/4">

    </div>
    <div class="flex w-full md:w-1/4">
        <x-frk.components.date-picker :disabled="$disabledInput" error="fecha_servicio" wire:model="fecha_servicio" label="Fecha Servicio"/>
    </div>
    <div class="flex w-full md:w-1/4">
        <x-frk.components.input-money label="Costo del servicio" error="total_servicio"  wire:model="total_servicio" />
    </div>



    <x-frk.components.select label="Vehiculo" error="vehiculo_id" wire:model="vehiculo_id" id="vehiculo_id">
        @foreach ($this->vehiculos as $data)
          <option value="{{ $data->id }}" wire:key="tipo-{{ $data->id }}">{{ $data->codigo }} / {{ $data->numero_placa }} /  {{ $data->alias }}</option>
        @endforeach
      </x-forms.select>



    <div class="flex w-full">
        <x-frk.components.text-area label="descripcion del servicio" error="descripcion" :disabled="$disabled" wire:model="descripcion" />
    </div>
    <div class="flex w-full">
        <x-frk.components.label-input  label="Observaciones" :disabled="$disabled" wire:model="observaciones"/>
    </div>


</div>





