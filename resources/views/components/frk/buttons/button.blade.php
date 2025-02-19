@props(['label'=>'','color'=>'gray'])

<div class="flex">
    <button {{  $attributes->merge(['type' => 'submit', 'class' => "bg-$color-500 hover:bg-$color-800 text-white text-base capitalize py-0.5 mx-2 my-0.5 px-2 rounded "]) }} >
        {{ $label }}
    </button>
</div>



