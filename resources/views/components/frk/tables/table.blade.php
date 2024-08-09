@props(['label'=>'Borrar','data'=>'','columnas'=>1,'titulos'=>''])

<div {{  $attributes->merge(['class'=>'flex w-full px-3 mb-3 justify-center']) }}>
    <x-frk.buttons.button label="{{$label}}" class="bg-red-500 hover:bg-red-700" wire:click="destroy({{$data}})"  />
</div>


<section class="container mx-auto p-6 font-mono">
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
      <div class="w-full overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                    sss{{$titulos[0]}}
sss
                </tr>
            </thead>
            <tbody class="bg-white">



            </tbody>
        </table>
      </div>
    </div>
</section>











<div class=" w-full relative overflow-x-auto">
    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>


                {{$head}}
            </tr>
        </thead>
        <tbody>



                {{$body}}


        </tbody>
    </table>
</div>
