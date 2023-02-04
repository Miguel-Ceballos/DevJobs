<?php

namespace App\Http\Livewire;

use App\Models\Vacante;
use Livewire\Component;

class MostarVacantes extends Component
{

    // Para que se ejecuten las funciones deben agregarse a la siguiente linea
    protected $listeners = ['eliminarVacante'];

    public function eliminarVacante( Vacante $vacante )
    {
        $vacante->delete();
    }

    public function render()
    {
        $vacantes = Vacante::where('user_id', auth()->user()->id)->paginate(10);

        return view('livewire.mostar-vacantes', [
            'vacantes' => $vacantes
        ]);
    }
}
