@props(['label'=>'','error'=>'','placeholder'=>'Ingrese aqui'])

@php
if ($error==='') {
    $error=$label;
}
@endphp


<div class="flex-wrap w-full  items-center px-1">
    <x-frk.components.label label="{{$label}}" class="font-semibold text-sm capitalize"  />
    <select {{$attributes}} class="flex w-full border border-gray-400 pt-1 pb-1 text-sm shadow text-gray-900 rounded-md focus:border-blue-500 focus:border-2 placeholder-gray-400 focus:outline-none focus:shadow-outline" >
        <option  value="null" disabled>{{ __('Seleccione una opcion') }}</option>
            {{ $slot}}
    </select>
    @include('components.frk.components.error')
</div>

