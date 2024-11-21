<div class="flex w-full flex-wrap m-4">
    <x-frk.components.label-input label="nombre" :disabled="$disabled" wire:model="nombre" />
    <x-frk.components.label-input label="descripcion" :disabled="$disabled" wire:model="descripcion" />

    <div class="w-full md:w-1/3"  x-data="{open: @entangle('estado')}"  >
        <x-frk.components.toggle :disabled="$disabled" label="estado" left="Inactivo" right="Activo"   />
    </div>

    @if ($isShow)
        <div class="flex w-full ">
            <x-frk.components.label-input label="created_at" :disabled="$disabled" wire:model="created_at" />
            <x-frk.components.label-input label="updated_at" :disabled="$disabled" wire:model="updated_at" />
        </div>
    @endif
</div>
