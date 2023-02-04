<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Salario;
use Livewire\Component;

class FiltrarVacantes extends Component
{

    public $termino;
    public $categoria;
    public $salario;

    public function buscador()
    {
        // Con emit podemos pasar valores de un componente a otro
        $this->emit('terminosBusqueda', $this->termino, $this->categoria, $this->salario);
    }

    public function render()
    {

        $salarios = Salario::all();
        $categorias = Categoria::all();

        // Asi se pasan a la vista para usar estas variables que contienen el modelo
        return view('livewire.filtrar-vacantes', [
            'salarios' => $salarios,
            'categorias' => $categorias
        ]);
    }
}
