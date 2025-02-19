@props(['label'=>'','error'=>null,'placeholder'=>'Ingrese aqui','moneda'=>''])
@php
if ($error==null) {
    $error=$label;
}
@endphp

<div class="w-full flex items-center px-1">
    <div class="flex items-center mx-2">
        <x-frk.components.label label="{{$label}}" class="font-semibold text-sm capitalize text-center" />
        @include('components.frk.components.error')
    </div>
    <div class="w-full flex">
        <x-frk.components.input   {{$attributes}}  placeholder="{{$placeholder}}" moneda="{{$moneda}}" />
    </div>
</div>


