<x-frk.components.template-crud>
    <x-slot:title>
        <x-frk.components.title label="Finalizar {{$title}}" />
    </x-slot>
    <x-slot:body>
        <div class="flex flex-wrap w-full">
            <div class="flex w-full">
                <div class="flex w-full md:w-1/3">
                    <x-frk.components.label-input label="no envio" :disabled=true wire:model="envio_no" />
                </div>
                <div class="flex w-full md:w-1/3">
                    <x-frk.components.date-picker wire:model="envio_fecha" :disabled=true label="envio_fecha"/>
                </div>
                <div class="flex w-full md:w-1/3">
                    <x-frk.components.select label="ruta_id" error="ruta_id" :disabled=true wire:model="ruta_id" >
                        @foreach ($this->rutas as $data)
                            <option value="{{ $data->id }}" wire:key="data-{{ $data->id }}">{{ $data->nombre }}</option>
                        @endforeach
                    </x-frk.components.select>
                </div>
            </div>

        <!-- //////////Ventas/////////////-->
            <div class="flex w-full ">
                <div class="flex w-full flex-col">
                    <div class="flex w-full w-grap">
                        <div class="flex w-full ">
                            <x-frk.components.subtitle label="Ventas Asignadas"  />
                        </div>
                    </div>
                    <div class="flex w-full flex-wrap md:w-3/9">
                        <div class="flex w-full flex-col">
                            <div class="w-full   shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                                            <th class="px-4 py-1">No Venta</th>
                                            <th class="px-4 py-1">Fecha Venta</th>
                                            <th class="px-4 py-1">NIT</th>
                                            <th class="px-4 py-1">Nombres Cliente</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($envio->ventas as $data)
                                        <tr class="text-gray-700">
                                            <td class="px-4 py-1 text-ms font-semibold border">{{$data->no_venta}}</td>
                                            <td class="px-4 py-1 text-ms font-semibold border">{{$data->fecha_venta}}</td>
                                            <td class="px-4 py-1 text-ms font-semibold border">{{$data->cliente->nit}}</td>
                                            <td class="px-4 py-1 border">
                                                <p class="text-xs text-gray-600">{{$data->cliente->nombres_cliente}} {{$data->cliente->apellidos_cliente}} </p>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        <!-- //////////Usuarios/////////////-->
        <div class="flex w-full ">
            <div class="flex w-full flex-col">
                <div class="flex w-full w-grap">
                    <div class="flex w-full ">
                        <x-frk.components.subtitle label="Usuarios Asignados"  />
                    </div>
                </div>

                <div class="flex w-full flex-wrap md:w-3/9">
                    <div class="flex w-full flex-col">
                        <div class="w-full   shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                                        <th class="px-4 py-1">Codigo</th>
                                        <th class="px-4 py-1">Usuario</th>
                                        <th class="px-4 py-1">Telefono</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($envio->users as $data)
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-1 text-ms font-semibold border">{{$data->codigo}}</td>
                                        <td class="px-4 py-1 border">
                                            <p class="text-xs text-gray-600">{{$data->nombres}} {{$data->apellidos}} </p>
                                        </td>
                                        <td class="px-4 py-1 text-ms font-semibold border">{{$data->telefono_principal}}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- //////////vehiculos/////////////-->
        <div class="flex w-full ">
            <div class="flex w-full flex-col">
                <div class="flex w-full w-grap">
                    <div class="flex w-full ">
                        <x-frk.components.subtitle label="Vehiculos Asignados"  />
                    </div>
                </div>

                <div class="flex w-full flex-wrap md:w-3/9">
                    <div class="flex w-full flex-col">
                        <div class="w-full   shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                                        <th class="px-4 py-1">Codigo</th>
                                        <th class="px-4 py-1">Alias</th>
                                        <th class="px-4 py-1">Placa</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach($this->envio->vehiculos as $key => $data)
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-1 text-ms font-semibold border">{{$data->codigo}}</td>
                                        <td class="px-4 py-1 border">
                                            <p class="text-xs text-gray-600">{{$data->alias}} </p>
                                        </td>
                                        <td class="px-4 py-1 text-ms font-semibold border">{{$data->numero_placa}}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!-- //////////vehiculos/////////////-->




            <div class="flex flex-wrap w-full">


                <div class="flex w-full ">
                    <x-frk.components.text-area label="observacion al inicio" :disabled="$disabled_observaciones_inicio_envio" wire:model="observaciones_inicio_envio" />
                </div>

                <div class="flex w-full ">
                    <x-frk.components.text-area label="observacion al finalizar" :disabled="$disabled_observaciones_final_envio" wire:model="observaciones_final_envio" />
                </div>


            </div>




















        </div>




    </x-slot>
    <x-slot:footer>
        <x-frk.components.button label="finalizar" wire:click.prevent="store_finish()" />
        <x-frk.components.button label="cancelar" wire:click.prevent="cancel()" />
    </x-slot>
</x-frk.components.template-create>

