<div>
    <x-frk.components.template-crud maxWidth="2xl">
        <x-slot:title>
            <x-frk.components.title label="Venta Completa" />
        </x-slot>
        <x-slot:body>
            <x-frk.components.label label="Datos de la venta realizada:" />
            <div class="flex w-full mb-5">
                <div class="w-full md:w-1/2">
                    <x-frk.components.label-input   label="No Venta:" wire:model="no_venta_detalle" disabled  />
                </div>
                <div class="w-full md:w-1/2">
                    <x-frk.components.label-input   label="Total Venta:" wire:model="total_venta_detalle" disabled  />
                </div>
                <div class="w-full md:w-1/2">
                    <x-frk.components.label-input   label="No Credito:" wire:model="no_credito_detalle" disabled  />
                </div>
            </div>
                <div class="flex w-full mb-5">
                <div class="w-full md:w-1/2">
                    <x-frk.components.label-input   label="Nombres Cliente:" wire:model="nombres_cliente_detalle" disabled  />
                </div>
                <div class="w-full md:w-1/2">
                    <x-frk.components.label-input   label="Apellidos Cliente:" wire:model="apellidos_cliente_detalle" disabled  />
                </div>
            </div>
        </x-slot>
        <x-slot:footer>

            <x-frk.components.button-icon label="exportar" color="red" icon="fa-solid fa-file-pdf" wire:click="exportarGeneral({{$no_venta_detalle}})" />
            <x-frk.components.button label="Continuar" wire:click.prevent="cancel()" />
        </x-slot>
   </x-frk.components.template-crud>
</div>
