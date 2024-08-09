<x-frk.components.template-index>
    <x-slot:head>
        <div class="w-full">
            <div class="flex w-full">
                <x-frk.components.title label="{{$title}}" />
                <x-frk.components.button color="red" label="Exportar PDF" wire:click="exportarGeneral()" />
            </div>
            <div class="flex w-full">

                <x-frk.components.label-input label="Codigo Producto" wire:model.live="filtroCodigoProducto"/>
                <x-frk.components.label-input label="Nombre Producto" wire:model.live="filtroNombreProducto"/>
                <x-frk.components.selectFiltro label="Tipo" wire:model.live="filtroTipo">
                    @foreach ($this->tipos as $data)
                    <option value="{{ $data->id }}" wire:key="tipo-{{ $data['id'] }}">{{ $data->nombre }}</option>
                    @endforeach
                </x-forms.select>

                <x-frk.components.selectFiltro label="Marca" wire:model.live="filtroMarca">
                    @foreach ($this->marcas as $data)
                    <option value="{{ $data->id }}" wire:key="tipo-{{ $data['id'] }}">{{ $data->nombre }}</option>
                    @endforeach
                </x-forms.select>

                <x-frk.components.selectFiltro label="Diseño" wire:model.live="filtroDisenio">
                    @foreach ($this->disenios as $data)
                    <option value="{{ $data->id }}" wire:key="tipo-{{ $data['id'] }}">{{ $data->nombre }}</option>
                    @endforeach
                </x-forms.select>

                <x-frk.components.selectFiltro label="Material" wire:model.live="filtroMaterial">
                    @foreach ($this->materiales as $data)
                    <option value="{{ $data->id }}" wire:key="tipo-{{ $data['id'] }}">{{ $data->nombre }}</option>
                    @endforeach
                </x-forms.select>


            </div>
        </div>

    </x-slot:head>
    <x-slot:body>


    <section class="container mx-auto p-6 font-mono">
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
          <div class="w-full overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                    <th class="px-4 py-3">Codigo Producto</th>
                    <th class="px-4 py-3">Nombre Producto</th>
                    <th class="px-4 py-3">Existencia General</th>
                    <th class="px-4 py-3">Cantidad Sucursal</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3">Marca</th>
                    <th class="px-4 py-3">Diseño</th>
                    <th class="px-4 py-3">Material</th>
                    <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($productos as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->codigo}}</td>

                        <td class="px-4 py-3 border">
                            <p class="text-xs text-gray-600">{{$data->nombre}} </p>
                            <p class="text-xs text-gray-600">{{$data->descripcion}} </p>
                        </td>
                        <td class="px-4 py-3 text-sm border">{{$data->existencia}}</td>
                        <td class="px-4 py-3 text-sm border">
                            @foreach ($data->sucursales as $data_a)
                                <p class="text-xs text-gray-600">{{$data_a->nombre}}: {{$data_a->pivot->cantidad}}</p>

                            @endforeach
                        </td>
                        <td class="px-4 py-3 text-sm border">{{$data->tipo->nombre}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->marca->nombre}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->disenio->nombre}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->material->nombre}}</td>
                         <td class="px-4 py-3 text-sm border flex w-full">
                            <td class="px-4 py-3 text-sm border flex w-full">
                                <x-frk.components.button-icon color="yellow" icon="fa-solid fa-eye" wire:click="exportarFila({{$data->id}})" />

                            </td>                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="px-4 py-3 text-sm border"></td>
                        <td class="px-4 py-3 text-sm border"></td>
                        <td class="px-4 py-3 text-sm border"></td>
                        <td class="px-4 py-3 text-sm border"></td>
                        <td class="px-4 py-3 text-sm border"></td>


                        <td class="px-4 py-3 text-sm border"></td>
                    </tr>

                </tbody>
            </table>
          </div>
        </div>
    </section>



    </x-slot:body>
    <x-slot:footer>

    </x-slot:footer>
</x-frk.components.template-index>
