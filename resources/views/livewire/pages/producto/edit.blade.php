<div>
    <x-frk.components.template-crud maxWidth="5xl">
        <x-slot:title>
            <x-frk.components.title label="Editar {{$title}}" />
        </x-slot>
        <x-slot:body>
            @include('livewire.pages.producto.form')
        </x-slot>
        <x-slot:footer>
            <x-frk.components.button label="guardar"  color="blue" ="update({{$id_data}})" />
            <x-frk.components.button label="cancelar" wire:click="cancel()" />
        </x-slot>
   </x-frk.components.template-crud>
  </div>
