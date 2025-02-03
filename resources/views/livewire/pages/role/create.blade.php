<div>
    <x-frk.components.template-crud>
        <x-slot:title>
            <x-frk.components.title label="Nuevo {{$title}}" />
        </x-slot>
        <x-slot:body>
            <x-frk.components.label-input label="nombre" wire:model="nombre" />

            <div class="flex w-full flex-wrap m-4">
              @foreach ($permisson as $item)
                <x-frk.components.checkbox wire:model="role_selected" value="{{$item->id}}" label="{{$item->name}}"   />
              @endforeach
            </div>

        </x-slot>
        <x-slot:footer>
            <x-frk.components.button label="guardar"  color="blue" wire:click.prevent="store()" />
            <x-frk.components.button label="cancelar" wire:click.prevent="cancel()" />
        </x-slot>
   </x-frk.components.template-crud>
</div>
