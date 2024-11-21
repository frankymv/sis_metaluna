<div class="flex w-full flex-wrap m-4">
    <x-frk.components.label-input label="nombre" :disabled="$disabled" wire:model="nombre" />
    <x-frk.components.label-input label="descripcion" :disabled="$disabled" wire:model="descripcion" />

    <div class="w-full md:w-1/3"  x-data="{open: @entangle('estado')}"  >
        <x-frk.components.toggle :disabled="$disabled" label="estado" left="Inactivo" right="Activo"   />
    </div>

    <div class="mb-3 row">
        <label for="permissions" class="col-md-4 col-form-label text-md-end text-start">Permissions</label>
        <div class="col-md-6">
            <select class="form-select @error('permissions') is-invalid @enderror" multiple aria-label="Permissions" id="permissions" name="permissions[]" style="height: 210px;">
                @forelse ($permisos as $permission)
                    <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                        {{ $permission->name }}
                    </option>
                @empty

                @endforelse
            </select>
            @if ($errors->has('permissions'))
                <span class="text-danger">{{ $errors->first('permissions') }}</span>
            @endif
        </div>
    </div>

    @if ($isShow)
        <div class="flex w-full ">
            <x-frk.components.label-input label="created_at" :disabled="$disabled" wire:model="created_at" />
            <x-frk.components.label-input label="updated_at" :disabled="$disabled" wire:model="updated_at" />
        </div>
    @endif
</div>
