<?php

namespace App\Http\Livewire;

use App\Models\Vacante;
use App\Notifications\NuevoCandidato;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostularVacante extends Component
{
    // Simpre debe importarse para la subida de archivos
    use WithFileUploads;

    public $cv;
    public $vacante;

    protected $rules = [
        'cv' => 'required|mimes:pdf'
    ];

    public function mount(Vacante $vacante)
    {
        $this->vacante = $vacante;
    }

    public function postularme()
    {
        $this->validate();

        // Almacenar cv en el disco
        $cv = $this->cv->store('public/cv');
        // en esta linea remplazamos la ruta por nada para que solo quede el nombre del cv
        $nombre_cv = str_replace('public/cv/', '', $cv);

        // Crear el candidato de la vacante
        $this->vacante->candidatos()->create([
            'user_id' => auth()->user()->id,
            'cv' => $nombre_cv,
        ]);

        // Crear notificacion y enviar email
        $this->vacante->reclutador->notify(new NuevoCandidato($this->vacante->id, $this->vacante->titulo, auth()->user()->id));

        // Mostrar al usuario un mensaje de ok
        session()->flash('mensaje', 'Tu informacion se envio correctamente, mucha suerte.');
        return redirect()->back();

    }

    public function render()
    {
        return view('livewire.postular-vacante');
    }
}
