<x-frk.components.template-crud maxWidth="3xl">
    <x-slot:title>
        <div class="flex w-full md:w-2/4">
            <x-frk.components.title label="Nuevo Abono Anticiado" />
        </div>
        <div class=" w-full md:w-1/4">
            <x-frk.components.label-input label="No abono" :disabled="$disabledAsignarAbonoAnticipado"  wire:model.live="no_abono" />
        </div>
        <div class="flex w-full md:w-1/4">
            <x-frk.components.date-picker wire:model="fecha_abono" label="Fecha abono"/>
        </div>
    </x-slot>
    <x-slot:body>


    <div class="flex w-full flex-wrap m-4">


        <div class="flex w-full">
            <div class="flex w-full md:w-1/2">
                <x-frk.components.select label="Venta Numero" error="asignar_venta_id" wire:model.live="asignar_venta_id">
                    @foreach ($this->ventas_credito as $data)
                    <option value="{{ $data->id }}" wire:key="tipo-{{ $data->id }}">No. Venta: {{ $data->no_venta }} Saldo Credito:{{ ($data->total_venta - $data->total_nota_credito) - $data->total_abono}}</option>
                    @endforeach
                </x-forms.select>
            </div>

            <div class="flex w-full md:w-1/2">
                <x-frk.components.select label="No. Abono Anticipado" error="asignar_abono_anticipado_id" wire:model.live="asignar_abono_anticipado_id" >
                    @foreach ($this->abono_anticipados as $data)
                    <option value="{{ $data->id }}" wire:key="tipo-{{ $data->id }}"> No. Abono{{ $data->no_abono }}TotalAbono: {{ $data->total_abono }}</option>
                    @endforeach
                </x-forms.select>
            </div>
        </div>

        <div class="flex w-full ">
            <div class="flex w-full md:w-1/4">
                <x-frk.components.label-input  label="No venta" error="codigo" :disabled="$disabledAsignarAbonoAnticipado" wire:model.live="no_venta" />
            </div>
            <div class=" flex w-full md:w-1/4">
                <x-frk.components.date-picker label="Fecha venta" :disabled="$disabledAsignarAbonoAnticipado" wire:model.live="fecha_venta" />

            </div>

        </div>

        <div class="flex w-full ">
            <div class="flex w-full md:w-1/4">
                <x-frk.components.label-input  label="codigo interno" error="codigo" :disabled="$disabledAsignarAbonoAnticipado" wire:model.live="codigo_interno" />
            </div>
            <div class="flex w-full md:w-1/4">
                <x-frk.components.label-input  label="nombre_empresa" error="codigo" :disabled="$disabledAsignarAbonoAnticipado" wire:model.live="nombre_empresa" />
            </div>
            <div class="flex w-full md:w-1/4">
                <x-frk.components.label-input  label="nombre_cliente" error="codigo" :disabled="$disabledAsignarAbonoAnticipado" wire:model.live="nombres_cliente" />
            </div>
            <div class="flex w-full md:w-1/4">
                <x-frk.components.label-input  label="apellidos cliente" error="codigo" :disabled="$disabledAsignarAbonoAnticipado" wire:model.live="apellidos_cliente" />
            </div>

        </div>

        <div class="flex w-full ">
            <div class="flex w-full md:w-1/4">
                <x-frk.components.input-money  label="total venta" error="total_venta" :disabled="$disabledAsignarAbonoAnticipado" wire:model.live="total_venta" />
            </div>

            <div class=" w-full md:w-1/4">
                <x-frk.components.input-money  label="Cantidad Abono:" error="cantidad_abono" :disabled="$disabledAsignarAbonoAnticipado" wire:model.live="cantidad_abono_asignar" />
            </div>
            <div class=" w-full md:w-1/4">
                <x-frk.components.input-money label="Nuevo saldo:" error="nuevo_saldo" :disabled="$disabledAsignarAbonoAnticipado" wire:model.live="nuevo_saldo_asignar" />
            </div>
        </div>











        <div class="flex w-full ">
            <x-frk.components.label-input label="Observaciones"   wire:model="observaciones" />
        </div>

    </div>




    </x-slot>
    <x-slot:footer>
        <x-frk.components.button label="guardar" wire:click.prevent="storeAsignarAbonoAnticipado({{$asignar_abono_anticipado_id}})" />
        <x-frk.components.button label="cancelar" wire:click.prevent="cancel()" />
    </x-slot>
</x-frk.modal>

