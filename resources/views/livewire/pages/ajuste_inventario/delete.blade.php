<div>
    <x-frk.components.template-crud>
        <x-slot:title>
            <x-frk.components.title label="Borrar {{$title}}" />
        </x-slot>
        <x-slot:body>
            <x-frk.components.label label="Desea borrar el siguiente registro?" />
            <x-frk.components.label-input   wire:model="ajuste_inventario_no" disabled  />
        </x-slot>
        <x-slot:footer>
            <x-frk.components.button label="borrar" wire:click="destroy({{$id_data}})"/>
            <x-frk.components.button label="cancelar" wire:click.prevent="cancel()" />
        </x-slot>
   </x-frk.components.template-crud>
</div>








