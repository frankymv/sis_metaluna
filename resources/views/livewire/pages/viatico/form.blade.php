<div class="flex w-full flex-wrap m-4">


        <div class=" fleX w-full">
            <x-frk.components.subtitle  label="VIATICO" />
        </div>

        <div class="flex w-full ">

            <div class="flex w-full md:w-1/3">
                <x-frk.components.label-input  label="No Viatico" error="codigo" :disabled="$disabled" wire:model.live="no_viatico" />
            </div>

            <div class=" flex w-full md:w-1/3">
                <x-frk.components.date-picker label="Fecha viatico" error="fecha_viatico" :disabled="$disabled" wire:model.live="fecha_viatico" />

            </div>
            <div class="flex w-full md:w-1/3">
                <x-frk.components.label-input-money label="total viatico" error="total_viatico" :disabled="$disabled" wire:model.live="total_viatico" />
            </div>
        </div>


        <div class="flex w-full ">
            <div class=" flex w-full md:w-1/2">
                <x-frk.components.select label="Usuario" :disabled="$disabled" error="user_id" wire:model.live="user_id" id="user_id">
                    @foreach ($this->users as $data)
                    <option value="{{ $data->id }}" wire:key="tipo-{{ $data->id }}">{{ $data->nombres}}  {{ $data->apellidos }}</option>
                    @endforeach
                </x-forms.select>
            </div>

        </div>




        <div class="flex w-full ">
            <x-frk.components.label-input label="Observaciones"   wire:model="observaciones" />
        </div>

    @if ($isShow)
        <div class="flex w-full ">
            <x-frk.components.label-input label="created_at" :disabled="$disabled" wire:model="created_at" />
            <x-frk.components.label-input label="updated_at" :disabled="$disabled" wire:model="updated_at" />
        </div>
    @endif
</div>
