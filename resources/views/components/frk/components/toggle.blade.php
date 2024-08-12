@props(['label'=>'','left'=>'Si','right'=>'No','attrib','disabled'])

<div class="w-full flex-wrap  rounded-lg mx-1 px-1 pb-1 ">

    <x-frk.components.label label="{{$label}}"  class="font-semibold text-sm capitalize"  />
    @if ($disabled)
    <div class="flex items-center cursor-pointer cm-toggle-wrapper justify-center" {{$attributes}}     >
    @else
    <div class="flex items-center cursor-pointer cm-toggle-wrapper justify-center " {{$attributes}}    @click="open =! open"  >
        @endif
        <span class="font-semibold text-xs mr-1">{{$left}}</span>

        <div class="rounded-full w-8 h-4 p-0.5"  :class="{'bg-red-500': open === false,'bg-green-500':open === true}">
            <div class="rounded-full w-3 h-3 bg-white transform mx-auto duration-300 ease-in-out" disabled :class="{'-translate-x-2': open === false,'translate-x-2': open === true}"></div>
        </div>
        <span class="font-semibold text-xs ml-1">{{$right}}</span>
    </div>
</div>
