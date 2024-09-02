<div>
  <x-modal name="texto" show="true" >
    <div class="flex w-full flex-wrap m-4">

      <x-forms.label-title label="Borrar {{$title}}" />

            <x-forms.label label="Desea borrar el siguiente registro?" />

              <x-forms.label-input   wire:model="nombre" disabled  />



            <div class="flex w-full md:w-1/2">

              <x-buttons.delete-button wire:click="destroy({{$id_data}})">
                Borrar
              </x-buttons.delete-button>
              <x-buttons.cancel-button wire:click="cancel()">
                Cancelar
              </x-buttons.cancel-button>

            </div>
        </div>



      </x-modal>





  </div>














