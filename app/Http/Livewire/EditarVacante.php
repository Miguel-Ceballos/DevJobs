<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Salario;
use App\Models\Vacante;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditarVacante extends Component
{

    public $vacante_id;
    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;
    public $imagen_nueva;

    // Esta linea se agrega cada que se quieran subir archivos
    use WithFileUploads;

    protected $rules = [
        'titulo' => ['required', 'string'],
        'salario' => ['required'],
        'categoria' => ['required'],
        'empresa' => ['required'],
        'ultimo_dia' => ['required'],
        'descripcion' => ['required'],
        'imagen_nueva' => ['nullable', 'required', 'image'],
    ];

    // Mount se ejecuta solo una vez cuando el componente ha sido instanciado
    public function mount(Vacante $vacante)
    {
        $this->vacante_id = $vacante->id; // Asi recuperamos el id
        $this->titulo = $vacante->titulo;
        $this->salario = $vacante->salario_id;
        $this->categoria = $vacante->categoria_id;
        $this->empresa = $vacante->empresa;
        // Esta linea se hace asi solo cuando el formato es diferente al que guardamos en la base
        $this->ultimo_dia = Carbon::parse($vacante->ultimo_dia)->format('Y-m-d');
        $this->descripcion = $vacante->descripcion;
        $this->imagen = $vacante->imagen;
    }

    public function editarVacante()
    {
        $datos = $this->validate();

        // Si hay una nueva imagen
        if ($this->imagen_nueva) {
            $imagen = $this->imagen_nueva->store('public/vacantes');
            $datos['imagen'] = str_replace('public/vacantes/', '', $imagen);
        }

        // Encontrar la vacante a editar
        $vacante = Vacante::find($this->vacante_id);

        // Asignar los valores
        $vacante->titulo = $datos['titulo'];
        $vacante->salario_id = $datos['salario'];
        $vacante->categoria_id = $datos['categoria'];
        $vacante->empresa = $datos['empresa'];
        $vacante->ultimo_dia = $datos['ultimo_dia'];
        $vacante->descripcion = $datos['descripcion'];
        // Si hay una nueva imagen la agrega y si no, asigana el valor anterior
        $vacante->imagen = $datos['imagen'] ?? $vacante->imagen;

        // Guardar la vacante
        $vacante->save();

        // Redireccionar
        session()->flash('mensaje', 'La vacante se actualizo correctamente');

        return redirect()->route('vacantes.index');

    }

    public function render()
    {

        //  Consultar base de datos, la mejor manera es creando un modelo.
        // all recupera todos los registros
        $salarios = Salario::all();
        $categorias = Categoria::all();

        return view('livewire.editar-vacante', [
            'salarios' => $salarios,
            'categorias' => $categorias
        ]);
    }
}
