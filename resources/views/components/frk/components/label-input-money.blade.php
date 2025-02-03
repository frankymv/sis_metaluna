@props(['label'=>'','error'=>null,'placeholder'=>'Ingrese aqui'])
@php
if ($error==null) {
    $error=$label;
}
@endphp

<div class="w-full flex-wrap items-center px-1">
    <x-frk.components.label label="{{$label}}" class="font-semibold text-sm capitalize "  />
    <div class="relative rounded-md shadow-sm">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <span class="text-gray-500 sm:text-sm">Q. </span>
          </div>
        <x-frk.components.input class="py-1.5 pl-7" {{$attributes}} placeholder="{{$placeholder}}"  />
    </div>
    @include('components.frk.components.error')
</div>











