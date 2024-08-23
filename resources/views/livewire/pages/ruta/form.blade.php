<div class="flex flex-wrap">
    <div class="w-full md:w-1/2">
        <x-frk.components.label-input label="codigo" :disabled="$disabled" wire:model="codigo" />
    </div>

    <div class="w-full md:w-1/2">
        <x-frk.components.label-input label="nombre" :disabled="$disabled" wire:model="nombre" />
    </div>
        <div class="w-full">
        <x-frk.components.text-area label="descripcion" row=¨2¨ :disabled="$disabled" wire:model="descripcion" />

    </div>


    <div class="flex w-full">
        <div class="flex w-full md:w-2/9">
            <x-frk.components.select label="departamento" error="direccion_departamento" :disabled="$disabled" wire:model.live="departamento_id" >
              @foreach ($this->departamentos as $data)
              <option value="{{ $data['id'] }}" wire:key="data-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
              @endforeach
            </x-frk.components.select>

        </div>
        <div class="flex w-full md:w-2/9">
            <x-frk.components.select label="municipio" error="direccion_municipio" :disabled="$disabled" wire:model.live="municipio_id">
                @foreach ($this->municipios as $data)
                <option value="{{ $data['id'] }}" wire:key="data-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                @endforeach
            </x-frk.components.select>
        </div>

        <div class="flex w-full md:w-4/9">
            <x-frk.components.label-input label="Observaciones" :disabled="$disabled" wire:model="observaciones" />
        </div>


        <div class="flex flex-wrap md:w-1/9">
            <x-frk.components.label label="Agregar" class="font-semibold capitalize"/>
            <x-frk.components.button label="+" wire:click.prevent="addDetalle()" />
        </div>
        </div>



        <div class="flex w-full ">
                <x-frk.components.subtitle label="Detalle Ruta" />
        </div>

        <div class="flex w-full">
            <div class="flex w-full ">
                <div class="flex w-full flex-col">
                    <div class="w-full   shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-2 py-1">
                                        Departamento
                                    </th>
                                    <th scope="col" class="px-2 py-1">
                                        Municipio
                                    </th>

                                    <th scope="col" class="px-2 py-1">
                                        Observacion
                                    </th>
                                    <th scope="col" class="px-2 py-1">
                                        Accion
                                    </th>
                                </tr>
                            </thead>
                            @if ($inputs!=null)
                            <tbody>
                                @foreach($inputs as $key => $value)
                                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                        <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-prewrap dark:text-white">
                                            {{$nombreDepartamento[$value]}}
                                        </th>
                                        <td class="px-2 py-1">
                                            {{$nombreMunicipio[$value]}}
                                        </th>
                                        <td class="px-2 py-1">
                                            {{$observacionDetalle[$value]}}
                                        </th>
                                        <td class="px-2 py-1">
                                            <x-frk.components.button label="-" color="red" wire:click.prevent="removeDetalle({{$value}})" />
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                    @else
                            <tbody>

                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-prewrap dark:text-white">
                                        <x-frk.components.label-error label="Sin Departamentos" error="inputs"/>
                                    </th>
                                </tr>

                            </tbody>
                    @endif
                </table>
            </div>
                </div>
            </div>
        </div>
    </div>









</div>
