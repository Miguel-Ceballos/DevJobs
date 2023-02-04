<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Salario;
use App\Models\Vacante;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrearVacante extends Component
{

    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;

    use WithFileUploads;

    protected $rules = [
        'titulo' => ['required', 'string'],
        'salario' => ['required'],
        'categoria' => ['required'],
        'empresa' => ['required'],
        'ultimo_dia' => ['required'],
        'descripcion' => ['required'],
        'imagen' => ['required', 'image'],
    ];

    public function crearVacante()
    {
        // valida el formulario, si hay un error lo manda a crear-vacante
        $datos = $this->validate();

        // Almacenar imagen
        $imagen = $this->imagen->store('public/vacantes');
        // en esta linea remplazamos la ruta por nada para que solo quede el nombre de la imagen
        $nombre_imagen = str_replace('public/vacantes/', '', $imagen);
        //dd($nombre_imagen);

        // Crear la vacante
        Vacante::create([
            'titulo' => $datos['titulo'],
            'salario_id' => $datos['salario'],
            'categoria_id' => $datos['categoria'],
            'empresa' => $datos['empresa'],
            'ultimo_dia' => $datos['ultimo_dia'],
            'descripcion' => $datos['descripcion'],
            'imagen' => $nombre_imagen,
            'user_id' => auth()->user()->id,
        ]);

        // Crear un mensaje
        session()->flash('mensaje', 'La vacante se publico exitosamente');

        //Redireccionar al usuario
        return redirect()->route('vacantes.index');
    }

    public function render()
    {
        //  Consultar base de datos, la mejor manera es creando un modelo.
        // all recupera todos los registros
        $salarios = Salario::all();
        $categorias = Categoria::all();


        return view('livewire.crear-vacante', [
            'salarios' => $salarios,
            'categorias' => $categorias
        ]);
    }
}
