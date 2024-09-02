@props(['label'=>'','error'=>'','placeholder'=>'Ingrese aqui'])

@php
if ($error==='') {
    $error=$label;
}
@endphp


<div class="flex-wrap w-full  items-center px-1">
    <select {{$attributes}}  class="flex w-full border pt-1 pb-1 text-xs shadow text-black rounded-md  " >
        <option  value="null" >Seleccione una opcion</option>
            {{ $slot}}
    </select>
    @include('components.frk.components.error')
</div>

