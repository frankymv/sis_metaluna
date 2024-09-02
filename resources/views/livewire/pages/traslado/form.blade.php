<div class="flex flex-wrap">
    <div class="flex w-full ">
        <div class="flex w-full md:w-1/6">
            <x-frk.components.label-input label="No Traslado" error="traslado_no" :disabled="$disabled" wire:model="traslado_no" />
        </div>
        <div class="flex w-full md:w-1/6">
            <x-frk.components.date-picker wire:model="traslado_fecha" error="traslado_fecha" label="Traslado Fecha"/>
        </div>

    </div>
    <div class="flex w-full">
        <div class="flex w-full md:w-1/2">
            <x-frk.components.select label="origen" error="sucursal_origen_id" :disabled="$disabledSucursalOrigen" wire:model.live="sucursal_origen_id" >
                @foreach ($this->sucursals_origen as $data)
                <option value="{{ $data->id }}" wire:key="data-{{ $data->id }}">{{ $data->nombre }}</option>
                @endforeach
            </x-forms.select>
        </div>
        <div class="flex w-full md:w-1/2">
            <x-frk.components.select label="destino" error="sucursal_destino" :disabled="$disabledSucursalDestino" wire:model.live="sucursal_destino_id" >
                @foreach ($this->sucursals_destino as $data)
                <option value="{{ $data->id }}" wire:key="data-{{ $data->id }}">{{ $data->nombre }}</option>
                @endforeach
            </x-forms.select>
        </div>
    </div>
    @if (!$isShow)
    <div class="flex w-full ">
        <div class="flex w-full md:w-4/6">
            <x-frk.components.select label="producto" error="producto_id" :disabled="$disabled" wire:model.live="producto_id" id="producto_id">
                @foreach ($this->productos as $data)
                <option value="{{ $data->id }}" wire:key="data-{{ $data->id }}">{{ $data->nombre }}</option>
                @endforeach
            </x-forms.select>
        </div>
        <div class="flex w-full md:w-1/6">
            <x-frk.components.label-input label="existencia" error="cantidad_existencia" :disabled="$disabled_existencia" wire:model="cantidad_existencia" />
        </div>
        <div class="flex w-full md:w-1/6">
            <x-frk.components.label-input label="trasladar" error="trasladar" error="cantidad_transferir" :disabled="$disabled" wire:model.live="cantidad_transferir" />
        </div>
        <div class="flex w-full  flex-wrap md:w-1/6">
            <x-frk.components.label label="Accion"  />
            <x-frk.components.button label="agregar" wire:click.prevent="addDetalle()" />
        </div>
    </div>
    @endif


<div class="flex w-full">
    <div class="flex w-full ">
        <div class="flex w-full flex-col">

            <div class="flex w-full w-grap">
                <div class="flex w-full md:w-4/6">
                    <x-frk.components.label label="Producto"  />
                </div>

                <div class="flex w-full md:w-1/6">
                    <x-frk.components.label label="Cantidad" />
                </div>

                <div class="flex w-full  md:w-1/6">
                    <x-frk.components.label label="Quitar" />
                </div>
            </div>

            @if ($inputs!=null)
                @foreach($inputs as $key => $value)
                <div class="flex w-full w-grap ">
                    <div class="flex w-full md:w-4/6">
                        <x-frk.components.list-input :disabled="$disabled_producto" wire:model="nombresDetalle.{{$value}}" />
                    </div>
                    <div class="flex w-full md:w-1/6">
                        <x-frk.components.list-input :disabled="$disabled_cantidad" wire:model="cantidadesDetalle.{{$value}}" />
                    </div>
                    @if (!$isShow)
                        <div class="w-full md:w-1/6">
                            <x-frk.components.button label="-" color="red" wire:click.prevent="removeDetalle({{$key}})" />
                        </div>
                    @endif
                </div>
                @endforeach

            @else

                <div class="flex w-full ">
                    <x-frk.components.label-error label="Sin productos" error="inputs"/>


                </div>
            @endif
        </div>
    </div>
</div>







    <div class="flex w-full flex-col">
        @if ($isShow)
        <div class="flex w-full ">
            <x-frk.components.label-input label="created_at" :disabled="$disabled" wire:model="created_at" />
            <x-frk.components.label-input label="updated_at" :disabled="$disabled" wire:model="updated_at" />
        </div>
        @endif
    </div>
    <!-- ///////////////////////////////////// -->
    <!-- //////////vehiculos/////////////-->
<!-- //////////vehiculos/////////////-->
<!-- //////////vehiculos/////////////-->
<!-- //////////vehiculos/////////////-->
</div>
