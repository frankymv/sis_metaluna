<div class="flex w-full flex-wrap m-4">
    <div class="flex w-full ">
        <div class="w-full md:w-1/6">
            <x-frk.components.label-input label="codigo" :disabled="$disabledCodigo" wire:model="codigo" placeholder="Código generado automaticamente"/>
        </div>
        <div class="w-full md:w-3/6">
            <x-frk.components.label-input label="nombre" :disabled="$disabledNombre" wire:model="nombre" placeholder="Nombre generado automaticamente"/>
        </div>
        <div class="flex w-full md:w-2/6  items-center">
            <x-frk.components.button label="generar" :disabled="$disabledGenerar" color="blue" wire:click.prevent="generar()" />
            <x-frk.components.button label="borrar" :disabled="$disabledButton" wire:click.prevent="resetInput()" />
        </div>
    </div>


    <div class="flex w-full">
        <x-frk.components.select :disabled="$disabledTipo" label="Tipo" error="tipo_id" wire:model="tipo_id">
            @foreach ($this->tipos as $data)
                <option value="{{ $data->id }}" @if(!$data->estado) disabled  @endif wire:key="tipo-{{ $data->id }}">{{ $data->nombre }}</option>
            @endforeach
        </x-forms.select>
        <x-frk.components.select label="Diseño" :disabled="$disabledDisenio" wire:model="disenio_id" >
            @foreach ($this->disenios as $data)
                <option value="{{ $data->id }}" @if(!$data->estado) disabled  @endif wire:key="forma-{{ $data->id }}">{{ $data->nombre }}</option>
            @endforeach
        </x-forms.select>
        <x-frk.components.select label="Marca" :disabled="$disabledMarca" wire:model="marca_id" >
            @foreach ($this->marcas as $data)
                    <option value="{{ $data->id }}" @if(!$data->estado) disabled  @endif wire:key="marca-{{ $data->id }}"> {{ $data->nombre }}</option>
            @endforeach
        </x-forms.select>

        <x-frk.components.select label="Material" :disabled="$disabledMaterial" wire:model="material_id" >
            @foreach ($this->materiales as $data)
                <option value="{{ $data->id }}" @if(!$data->estado) disabled @endif wire:key="material-{{ $data->id }}">{{ $data->nombre }}</option>
            @endforeach
        </x-forms.select>
        <x-frk.components.label-input label="calibre" :disabled="$disabled" wire:model.lazy="calibre" />
    </div>



    <div class="flex md:w-1/3 ">
        <div class="flex md:w-1/2 ">
            <x-frk.components.label-input label="longitud" :disabled="$disabled" wire:model.lazy="longitud" />
        </div>
        <div class="flex md:w-1/2 ">
            <x-frk.components.select label="Longitud" error="tipo_longitud"  :disabled="$disabledLongitud" wire:model="tipo_longitud">
                @foreach ($this->longitudes as $key => $data)
                <option value="{{ $key }}">{{ $data }}</option>
                @endforeach
            </x-forms.select>
        </div>
    </div>






    <div class="flex md:w-1/3 ">
        <div class="flex md:w-1/2 ">
            <x-frk.components.label-input label="peso" :disabled="$disabled" wire:model.lazy="peso" />
        </div>
        <div class="flex md:w-1/2 ">
            <x-frk.components.select label="Peso" error="tipo_peso"  :disabled="$disabledTipo" wire:model="tipo_peso">
                @foreach ($this->pesos as $key => $data)
                <option value="{{ $key }}">{{ $data }}</option>
                @endforeach
            </x-forms.select>
        </div>
    </div>

    <div class="flex md:w-1/3 ">
        <div class="flex md:w-1/2 ">
            <x-frk.components.label-input label="diametro" :disabled="$disabled" wire:model.lazy="diametro" />
        </div>
        <div class="flex md:w-1/2 ">
            <x-frk.components.select label="Diametro" error="tipo_diametro"  :disabled="$disabledDiametro" wire:model="tipo_diametro">
                @foreach ($this->diametros as $key => $data)
                <option value="{{ $key }}">{{ $data }}</option>
                @endforeach
            </x-forms.select>
        </div>
    </div>



    <div class="flex w-full">
        <x-frk.components.label-input label="descripcion" :disabled="$disabled" wire:model="descripcion" />
    </div>


    <div class="flex flex-wrap w-full md:w-1/2">
        <div class="flex w-full md:w-1/3"  x-data="{open: @entangle('estado')}"  >
            <x-frk.components.toggle :disabled="$disabled" label="estado" left="Inactivo" right="Activo"   />
        </div>
        <div class="flex w-full md:w-1/3"  x-data="{open: @entangle('divisible')}"  >
            <x-frk.components.toggle :disabled="$disabled" label="divisible" left="No" right="Si"   />
        </div>
    </div>

    <div class="flex  w-full md:w-1/2 " >

        <x-frk.components.input-money label="Precio" :disabled="$disabled" wire:model="precio_venta_producto" />
    </div>
</div>
