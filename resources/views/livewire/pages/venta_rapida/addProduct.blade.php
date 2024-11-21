<x-frk.components.template-crud maxWidth=3xl>
    <x-slot:title>
        <x-frk.components.title label="Agregar Producto" />
    </x-slot>
    <x-slot:body>
        <div class="flex flex-wrap">
            <div class="flex w-full">
                <div class="flex w-full flex-wrap md:w-2/6">
                    <x-frk.components.label-input label="codigo_producto" :disabled="$disabled_codigo_producto" wire:model="codigo_producto" />
                </div>
                <div class="flex w-full md:w-4/6">
                    <x-frk.components.label-input label="nombre_producto" :disabled="$disabled_nombre_producto" wire:model="nombre_producto" />
                </div>

            </div>
            <div class="flex w-full">

                <div class="flex flex-wrap md:w-2/3">
                    <div class="flex w-full">
                        <div class="flex w-full md:w-1/2">
                            <x-frk.components.label-input label="existencia_producto" :disabled="$disabled_existencia_producto" wire:model="existencia_producto" />
                        </div>
                        <div class="flex w-full md:w-1/2">
                            <x-frk.components.label-input label="Precio: Q" :disabled="$disabled_precio_venta_producto" wire:model="precio_venta_producto" />
                        </div>
                    </div>
                    <div class="flex w-full">

                    </div>

                </div>


                <div class="flex flex-wrap md:w-1/3">
                    <div class="flex w-full">
                        <x-frk.components.label-input label="Cantidad" error="cantidad_producto" :disabled="$disabled_cantidad_producto" wire:model.live="cantidad_producto" />
                    </div>
                    <div class="flex w-full">
                        <x-frk.components.label-input label="Subtotal: Q" error="subtotal_producto" :disabled="$disabled_subtotal_producto" wire:model.live="subtotal_producto" />
                    </div>
                </div>
            </div>
        </div>

    </x-slot>
    <x-slot:footer>
        <x-frk.components.button label="agregar" color="blue" wire:click="agregarDetalle({{$this->id_producto}})" />


        <x-frk.components.button label="cancelar" wire:click="cancelProductQuantity()" />



        @if ($disabledInputPasswordAdmin)

            <x-frk.components.label-input wire:model="email_edit" placeholder="Email" />
            <x-frk.components.label-input type="password" wire:model="codigo_edit" placeholder="Contraseña" />
            <x-frk.buttons.unlock-icon-button class="bg-orange-500 hover:bg-orange-700 label" wire:click="unlock()" />

        @else

        <x-frk.buttons.unlock-icon-button class="bg-green-500 hover:bg-green-700" wire:click="actualizarPrecio()" />
        @endif

    </x-slot>
    <div class="flex w-full md:w-1/3">
        <x-frk.components.error error="menor_existencia" />
    </div>

</x-frk.modal>

