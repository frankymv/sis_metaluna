<div class="flex flex-wrap">

    <div class="flex w-full ">
        <div class="flex w-full md:w-2/6">
            <x-frk.components.label-input label="compra no" error="compra_no" :disabled="$disabled" wire:model="compra_no" />
        </div>

        <div class="flex w-full md:w-2/6">
            <x-frk.components.label-input label="no recibo compra" error="no_recibo_compra" :disabled="$disabled" wire:model="no_recibo_compra" />
        </div>
        <div class="flex w-full md:w-2/6">
            <x-frk.components.date-picker wire:model="compra_fecha" error="compra_fecha" label="Fecha de Compra"/>
        </div>
    </div>
    <div class="flex w-full ">
        <div class="flex w-full md:w-3/6">
            <x-frk.components.select label="proveedor" error="proveedor_id" :disabled="$disabled" wire:model="proveedor_id" id="marca_id">
                @foreach ($this->proveedores as $data)
                <option value="{{ $data->id }} " wire:key="data-{{ $data->id }}">{{ $data->nombre }}</option>
                @endforeach
            </x-forms.select>
    </div>
    <div class="flex w-full md:w-3/6">
            <x-frk.components.select label="Sucursal" error="sucursal_id" :disabled="$disabled" wire:model="sucursal_id" >
                @foreach ($this->sucursals as $data)
                <option value="{{ $data->id }} " wire:key="data-{{ $data->id }}">{{ $data->nombre }}</option>
                @endforeach
            </x-forms.select>
        </div>
    </div>


    @if (!$isShow)
    <div class="flex w-full ">
        <div class="flex w-full md:w-4/6">
            <x-frk.components.select label="producto" error="producto_id" :disabled="$disabled" wire:model="producto_id" >
                @foreach ($this->productos as $data)
                <option value="{{ $data->id }}" wire:key="data-{{ $data->id }}">{{ $data->nombre }}</option>
                @endforeach
            </x-forms.select>
        </div>

        <div class="flex w-full md:w-1/6">
            <x-frk.components.label-input label="cantidad" :disabled="$disabled" wire:model="cantidad" />
        </div>


        <div class="flex flex-wrap md:w-1/6">
            <x-frk.components.label  label="Agregar" class="font-semibold capitalize"/>
            <x-frk.components.button color="blue" label="+" wire:click.prevent="addDetalle()" />
        </div>
    </div>
    @endif


    <div class="flex w-full ">
            <x-frk.components.subtitle label="Detalle compra" />

    </div>

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

</div>
