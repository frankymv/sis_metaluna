@props(['label'=>'','color'=>'blue','icon'=>'fa-solid fa-question'])

<div class="flex">
    <button  {{ $attributes->merge(['type' => 'submit', 'class' => "bg-$color-500 hover:bg-$color-800 text-white text-base capitalize py-0.5 px-1 mx-0.5 my-0.5 rounded "]) }} >
        {{$label}} <i class="{{$icon}}"></i>
    </button>
</div>


