<div class="flex flex-wrap w-full">

    <div class="flex w-full">
        <div class="flex w-full md:w-3/9">
            <x-frk.components.label-input label="no envio" :disabled="$disabled_envio_no" wire:model="envio_no" />
        </div>
        <div class="flex w-full md:w-3/9">
            <x-frk.components.date-picker wire:model="envio_fecha" label="envio_fecha"/>
        </div>
        <div class="flex w-full md:w-3/9">
            <x-frk.components.select label="ruta_id" error="ruta_id" :disabled="$disabled" wire:model="ruta_id" >
                @foreach ($this->rutas as $data)
                    <option value="{{ $data->id }}" wire:key="data-{{ $data->id }}">{{ $data->nombre }}</option>
                @endforeach
            </x-frk.components.select>
        </div>
    </div>

    <div class="flex w-full">

    <!-- //////////Ventas/////////////-->
        <div class="flex w-full flex-wrap md:w-3/9">
            <div class="flex w-full" >
                    <x-frk.components.select label="Ventas" error="venta_id" :disabled="$disabled" wire:model="venta_id" >
                        @foreach ($this->ventas as $data)
                            <option value="{{ $data->id }}" wire:key="data-{{ $data->no_venta }}">No. Venta: {{ $data->no_venta }}-{{ $data->cliente->nombres_cliente }} Total: {{ $data->total_venta }}</option>
                        @endforeach
                    </x-frk.components.select>
                    <x-frk.components.button-icon icon="fa-solid fa-plus" wire:click.prevent="addDetalleVenta()" />
            </div>

            <div class="flex w-full flex-col">
                <div class="w-full   shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-2 py-1">
                                    Venta Asignada
                                </th>
                                <th scope="col" class="px-2 py-1">
                                    Accion
                                </th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach($inputs as $key => $value)
                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-prewrap dark:text-white">
                                        <p>No Venta.  {{$noVenta[$value]}}, Total: {{$totalVenta[$value]}}</p>
                                        <p>Cliente:  {{$nombreCliente[$value]}}</p>
                                    </th>
                                    <td class="px-2 py-1">
                                        <x-frk.components.button label="-" color="red" wire:click.prevent="removeDetalleVenta({{$value}})" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- //////////Ventas/////////////-->






    <!-- //////////Usuarios/////////////-->
    <div class="flex w-full flex-wrap md:w-3/9">

        <div class="flex w-full">
            <div class="flex w-full flex-wrap md:w-2/3">
                <x-frk.components.select label="usuario" error="ruta" :disabled="$disabled" wire:model="user_id" >
                    @foreach ($this->usuarios as $data)
                        <option value="{{ $data->id }}" wire:key="data-{{ $data->no_venta }}">{{ $data->nombres }}</option>
                    @endforeach
                </x-frk.components.select>

            </div>
            <div class="flex w-full md:w-1/3">
                <x-frk.components.button-icon icon="fa-solid fa-plus" wire:click.prevent="addDetalleUsuario()" />
            </div>

        </div>


                <div class="flex w-full ">
                    <div class="flex w-full flex-col">
                        <div class="w-full shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-2 py-1">
                                            Usuario Asignado
                                        </th>
                                        <th scope="col" class="px-2 py-1">
                                            Accion
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($inputsUsuario as $key => $value)
                                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-prewrap dark:text-white">
                                                <p>No Venta.  {{$idDetalleUsuario[$value]}}
                                                <p>Cliente:  {{$usuarioDetalle[$value]}}</p>
                                            </th>
                                            <td class="px-2 py-1">
                                                <x-frk.components.button label="-" color="red" wire:click.prevent="removeDetalleVenta({{$value}})" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


    <!-- //////////Usuarios/////////////-->


    <!-- //////////vehiculos/////////////-->
    <div class="flex w-full flex-wrap md:w-3/9">
            <div class="flex w-full">
                <div class="flex w-full flex-wrap md:w-2/3">
                    <x-frk.components.select label="vehiculos" error="ruta" :disabled="$disabled" wire:model="vehiculo_id" >
                        @foreach ($this->vehiculos as $data)
                            <option value="{{ $data->id }}" wire:key="data-{{ $data->no_venta }}">{{ $data->alias}}</option>
                        @endforeach
                    </x-frk.components.select>

                </div>
                <div class="flex w-full flex-wrap md:w-1/3">
                    <x-frk.components.button-icon icon="fa-solid fa-plus" wire:click.prevent="addDetalleVehiculo()" />
                </div>
            </div>
            <div class="flex w-full">
                <div class="flex w-full flex-col">
                    <div class="flex w-full ">
                        <div class="flex w-full flex-col">
                            <div class="w-full shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-2 py-1">
                                                Vehiculo Asignado
                                            </th>
                                            <th scope="col" class="px-2 py-1">
                                                Accion
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($inputsVehiculo as $key => $value)
                                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                                <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-prewrap dark:text-white">
                                                    <p>Codigo:.  {{$codigoVehiculo[$value]}}
                                                    <p>Alias:  {{$aliasVehiculo[$value]}}</p>
                                                </th>
                                                <td class="px-2 py-1">
                                                    <x-frk.components.button label="-" color="red" wire:click.prevent="removeDetalleVenta({{$value}})" />
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
        </div>
    <!-- //////////vehiculos/////////////-->
    </div>

    <div class="flex w-full ">
        <x-frk.components.text-area label="observacion" :disabled="$disabled_observaciones_inicio_envio" wire:model="observaciones_inicio_envio" />
    </div>

</div>
