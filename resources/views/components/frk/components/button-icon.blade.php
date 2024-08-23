@props(['label'=>'','color'=>'blue','icon'=>'fa-solid fa-question'])

@php

@endphp

<div class="flex w-full">
    <button  {{ $attributes->merge(['type' => 'submit', 'class' => "text-white bg-$color-500 text-base capitalize py-1 mx-1 my-1 px-1 rounded lg:px-2    md:px-1 sm:px-1"]) }}  >
        {{$label}} <i class="{{$icon}}"></i>
    </button>
</div>


