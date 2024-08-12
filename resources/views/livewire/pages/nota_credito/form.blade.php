<div class="flex w-full flex-wrap m-4">

    <div class="flex w-full ">
        <x-frk.components.subtitle  label="VENTA" />
        <x-frk.components.button label="Buscar" wire:click="buscarVenta()" />
    </div>




    <div class="flex w-full ">
        <div class="flex w-full md:w-1/4">
            <x-frk.components.label-input  label="No venta" error="no_venta" :disabled="$disabled" wire:model.live="no_venta" />
        </div>
        <div class=" flex w-full md:w-1/4">
            <x-frk.components.date-picker label="Fecha venta" :disabled="$disabled" wire:model.live="fecha_venta" />

        </div>
    </div>


    <div class="flex w-full ">
        <div class="flex w-full md:w-1/4">
            <x-frk.components.label-input  label="codigo interno" error="codigo" :disabled="$disabled" wire:model.live="codigo_interno" />
        </div>
        <div class="flex w-full md:w-1/4">
            <x-frk.components.label-input  label="nombre_empresa" error="codigo" :disabled="$disabled" wire:model.live="nombre_empresa" />
        </div>
        <div class="flex w-full md:w-1/4">
            <x-frk.components.label-input  label="nombre_cliente" error="codigo" :disabled="$disabled" wire:model.live="nombres_cliente" />
        </div>
        <div class="flex w-full md:w-1/4">
            <x-frk.components.label-input  label="apellidos cliente" error="codigo" :disabled="$disabled" wire:model.live="apellidos_cliente" />
        </div>
    </div>
    <div class="flex w-full ">
        <div class="flex w-full md:w-1/4">
            <x-frk.components.input-money  label="total venta" error="total_venta" :disabled="$disabled" wire:model.live="total_venta" />
        </div>

        <div class="flex w-full md:w-1/4">
            <x-frk.components.input-money  label="Total nota credito" error="total_nota_credito" :disabled="$disabledTotalNotaCredito" wire:model.live="total_nota_credito" />
        </div>
        <div class="flex w-full md:w-1/4">
            <x-frk.components.input-money label="Nuevo saldo" error="nuevo_saldo" :disabled="$disabled" wire:model.live="nuevo_saldo" />
        </div>

        <div class="flex w-full md:w-1/4"  x-data="{open: @entangle('anulado')}"  >
            <x-frk.components.toggle :disabled="$disabled" wire:click="anulacionVenta()" label="Anulacion Venta" left="No" right="Si"   />
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
