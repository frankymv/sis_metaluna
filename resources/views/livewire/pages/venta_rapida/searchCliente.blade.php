<x-frk.components.template-crud maxWidth="3xl">
    <x-slot:title>
        <x-frk.components.title label="Buscar Cliente" />
    </x-slot>

        <x-slot:body>
            <div class="flex flex-wrap w-full">
                    <div class="    flex-wrap w-full">
                        <div class="flex-wrap w-full">
                            <div class="flex w-full ">
                                <x-frk.components.label-input label="nombres_cliente" :disabled="$disabled" wire:model.live="search_nombres_cliente" />
                                <x-frk.components.label-input label="codigo_cliente" :disabled="$disabled" wire:model.live="search_codigo_cliente" />
                                <x-frk.components.label-input label="nit_cliente" :disabled="$disabled" wire:model.live="search_nit_cliente" />
                                <x-frk.components.button label="cancelar" wire:click="cancelarBuscarCliente()" />
                            </div>

                        </div>

                        @if ($clientes)

                        <div class="w-full   shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-2 py-1">
                                            Codigo Interno
                                        </th>
                                        <th scope="col" class="px-2 py-1">
                                            Codigo Mayorista
                                        </th>

                                        <th scope="col" class="px-2 py-1">
                                            Nombre completo
                                        </th>
                                        <th scope="col" class="px-2 py-1">
                                            Empresa
                                        </th>
                                        <th scope="col" class="px-2 py-1">
                                            Tipo
                                        </th>
                                        <th scope="col" class="px-2 py-1">
                                            Accion
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($clientes as $key => $value)
                                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                        <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-prewrap dark:text-white">
                                            {{$value->codigo_interno}}
                                        </th>
                                        <td class="px-2 py-1">
                                            {{$value->codigo_mayorista}}
                                        </th>
                                        <td class="px-2 py-1">
                                            {{$value->nombres_cliente}}
                                        </th>

                                        <td class="px-2 py-1">
                                            {{$value->nombre_empresa}}
                                        </th>
                                        <td class="px-2 py-1">
                                            {{$value->tipo_cliente}}
                                        </th>

                                        <td class="px-2 py-1">
                                            <x-frk.buttons.plus-button color="blue" label="agregar" wire:click="agregarCliente({{$value['id']}})" />
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

