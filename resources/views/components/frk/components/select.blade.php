@props(['label'=>'','error'=>'','placeholder'=>'Ingrese aqui'])

@php
if ($error==='') {
    $error=$label;
}
@endphp


<div class="flex w-full flex-wrap px-1 bg-red-400">
    <x-frk.components.label label="{{$label}}" class="font-semibold text-sm capitalize"  />
        <!--<select {{$attributes}} type="text"  class="  flex w-full rounded border text-4xl border-gray-400 px-2 py-1 leading-tight text-gray-700 focus:bg-white focus:outline-none" >-->

    <select {{$attributes}} class="flex w-full border border-gray-400 text-sm shadow  text-gray-900  rounded-lg  focus:border-blue-500 focus:border-2   placeholder-gray-400 focus:outline-none focus:shadow-outline" >
        <option  value="null" disabled>{{ __('Seleccione una opcion') }}</option>
            {{ $slot}}
    </select>
    @include('components.frk.components.error')
</div>

