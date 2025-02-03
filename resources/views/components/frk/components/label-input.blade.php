@props(['label'=>'','error'=>null,'placeholder'=>'Ingrese aqui','moneda'=>''])
@php
if ($error==null) {
    $error=$label;
}
@endphp

<div class="w-full flex-wrap items-center px-1">
    <x-frk.components.label label="{{$label}}" class="font-semibold text-sm capitalize "  />
    <x-frk.components.input   {{$attributes}}  placeholder="{{$placeholder}}" moneda="{{$moneda}}" />
    @include('components.frk.components.error')
</div>
