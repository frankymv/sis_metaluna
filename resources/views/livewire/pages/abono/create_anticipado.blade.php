<x-frk.components.template-crud maxWidth="3xl">
    <x-slot:title>
        <div class=" w-full md:w-2/4">
            <x-frk.components.title label="Nuevo Abono Anticiado" />
        </div>
        <div class=" w-full md:w-1/4">
            <x-frk.components.label-input label="No abono"   wire:model.live="no_abono" />
        </div>
        <div class="flex w-full md:w-1/4    ">
            <x-frk.components.date-picker error="fecha_abono" wire:model="fecha_abono" label="Fecha abono"/>
        </div>
    </x-slot>
    <x-slot:body>



    <div class="flex w-full flex-wrap m-4">
        <div class="flex w-full ">
            <x-frk.components.select label="Nombre Cliente" :disabled="$disabled" error="venta_id" wire:model.live="cliente_id" id="cliente_id">
                @foreach ($this->clientes as $data)
                <option value="{{ $data->id }}" wire:key="tipo-{{ $data->id }}"> {{ $data->nombres_cliente }} {{ $data->codigo }}</option>
                @endforeach
            </x-forms.select>
        </div>




            <div class="flex w-full ">
                <div class=" w-full md:w-1/4">
                    <x-frk.components.input-money  label="Total Abono" error="total_abono" :disabled="$disabled" wire:model.live="cantidad_abono" />
                </div>
                <div class=" w-full md:w-3/4">
                <x-frk.components.label-input label="Observaciones"   wire:model="observaciones" />
            </div>
            </div>


        <div class="flex w-full ">
            <div class=" w-full md:w-1/2">
                <x-frk.components.select label="Tipo Pago" error="tipo_pago_id" :disabled="$disabled" wire:model.live="tipo_pago_id">
                    @foreach ($this->tipo_pago as $data)
                    <option value="{{ $data['valor'] }}" >{{ $data['nombre']}} </option>
                    @endforeach
                </x-forms.select>

            </div>


        </div>
        <div class="flex w-full ">
            <x-frk.components.label-input label="Detalle Pago"   wire:model="detalle_pago" />
        </div>
        @if ($isShow)
            <div class="flex w-full ">
                <x-frk.components.label-input label="created_at" :disabled="$disabled" wire:model="created_at" />
                <x-frk.components.label-input label="updated_at" :disabled="$disabled" wire:model="updated_at" />
            </div>
        @endif
        </div>

    </x-slot>
    <x-slot:footer>
        <x-frk.components.button label="guardar" wire:click.prevent="storeAnticipado()" />
        <x-frk.components.button label="cancelar" wire:click.prevent="cancel()" />
    </x-slot>
</x-frk.modal>

