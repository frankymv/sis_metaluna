<x-frk.components.template-index>
    <x-slot:head>
        <x-frk.components.title label="{{$title}}" />
        <x-frk.components.button label="agregar" wire:click="create()" />
    </x-slot:head>
    <x-slot:body>

    </x-slot:body>
    <x-slot:footer>
        @if($isCreate)
            @include('livewire.pages.estado_envio.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.estado_envio.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.estado_envio.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.estado_envio.delete')
        @endif

    </x-slot:footer>
</x-frk.components.template-index>
