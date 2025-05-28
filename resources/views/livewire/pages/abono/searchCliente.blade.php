<x-frk.components.template-crud maxWidth="3xl">
    <x-slot:title>
        <x-frk.components.title label="Buscar Cliente" />
    </x-slot>

        <x-slot:body>
            <div class="flex flex-wrap w-full">
                    <div class="    flex-wrap w-full">
                        <div class="flex-wrap w-full">
                            <div class="flex w-full ">
                                <x-frk.components.label-input label="codigo_cliente"  wire:model.live="search_codigo_cliente_anticipado" />
                                <x-frk.components.label-input label="nombres_cliente"  wire:model.live="search_nombres_cliente_anticipado" />


                                <x-frk.components.button label="cancelar" wire:click="cancelarBuscarVenta()" />
                            </div>
                        </div>

                        @if ($clientes_search)

                        <div class="w-full   shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-2 py-1">
                                            Codigo Cliente Mayorista
                                        </th>
                                        <th scope="col" class="px-2 py-1">
                                            Nombre Clinete
                                        </th>
                                        <th scope="col" class="px-2 py-1">
                                            Accion
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($clientes_search as $key => $value)
                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">

                                    <td class="px-2 py-1">
                                        {{$value->codigo_mayorista}}
                                    </th>
                                    <td class="px-2 py-1">
                                        {{$value->nombres_cliente}} {{$value->apellidos_cliente}}
                                    </th>
                                    <td class="px-2 py-1">
                                        <x-frk.buttons.plus-button color="blue" label="agregar" wire:click="agregarCliente({{$value->id}})" />
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

