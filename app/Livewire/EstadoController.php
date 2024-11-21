<?php

namespace App\Livewire;

use Livewire\Component;

class EstadoController extends Component
{
    use LivewireAlert;
    use WithPagination;
    public function render()
    {
        return view('livewire.pages.estado-controller');
    }
}
