<x-frk.components.template-crud maxWidth="3xl">
    <x-slot:title>
        <x-frk.components.title label="Buscar Producto" />
    </x-slot>

        <x-slot:body>
            <div class="flex flex-wrap w-full">
                    <div class="    flex-wrap w-full">
                        <div class="flex-wrap w-full">
                            <div class="flex w-full ">
                                <x-frk.components.label-input label="buscar_producto" :disabled="$disabled" wire:model.live="buscar_producto" />
                                <x-frk.components.button label="cancelar" wire:click="cancelarBuscarProducto()" />
                            </div>
                            <div class="flex w-full">
                                <div class="flex w-full md:w-1/3 ">
                                    <x-frk.components.select label="tipo" :disabled="$disabled" wire:model.live="id_tipo">
                                        @foreach ($this->tipos as $data)
                                        <option value="{{ $data->id }}" wire:key="data-{{ $data->id }}">{{ $data->nombre }}</option>
                                        @endforeach
                                    </x-forms.select>
                                </div>
                                <div class="flex w-full md:w-1/3 ">
                                    <x-frk.components.select label="marca" :disabled="$disabled" wire:model.live="id_marca">
                                        @foreach ($this->marcas as $data)
                                        <option value="{{ $data->id }}" wire:key="data-{{ $data->id }}">{{ $data->nombre }}</option>
                                        @endforeach
                                    </x-forms.select>
                                </div>
                                <div class="flex w-full md:w-1/3 ">
                                    <x-frk.components.select label="material" :disabled="$disabled" wire:model.live="id_material">
                                        @foreach ($this->materiales as $data)
                                        <option value="{{ $data->id }}" wire:key="data-{{ $data->id }}">{{ $data->nombre }}</option>
                                        @endforeach
                                    </x-forms.select>
                                </div>

                            </div>
                        </div>

                        @if ($productos)

                        <div class="w-full   shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-2 py-1">
                                            Codigo / Producto
                                        </th>

                                        <th scope="col" class="px-2 py-1">
                                            Existencia
                                        </th>
                                        <th scope="col" class="px-2 py-1">
                                            Accion
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($productos as $key => $value)
                                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                        <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-prewrap dark:text-white">
                                            {{$value->codigo}} /
                                            {{$value->nombre}} / {{$value->id}}

                                        </th>

                                        <td class="px-2 py-1">
                                            {{$value->existencia}}

                                        </td>
                                        <td class="px-2 py-1">


                                            <td class="px-2 py-1">

                                                entonces    {{ count($productosDetalle)}}

                                                <x-frk.buttons.plus-button label="{{$value->id}}" color="blue" wire:click="agregarCantidadProducto({{$value['id']}})" />

                                            </td>



                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @endif

                    </div>
                </div>
        </x-slot>

    <x-slot:footer>
    </x-slot>


</x-frk.modal>

