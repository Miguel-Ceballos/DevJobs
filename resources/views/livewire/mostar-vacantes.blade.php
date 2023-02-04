<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        @forelse ($vacantes as $vacante)
            <div class="p-6 bg-white border-b border-gray-200 md:flex md:justify-between md:items-center">
                <div class="p-4 text-gray-900 bg-white border-gray-200">
                    <div class="leading-10">
                        <a href="{{ route('vacantes.show', $vacante->id) }}" class="text-xl font-bold">
                            {{ $vacante->titulo }}
                        </a>
                    </div>
                    <p class="text-sm text-gray-600 font-bold">{{ $vacante->empresa }}</p>
                    <p class="text-sm text-gray-500">{{ $vacante->ultimo_dia->format('d/m/Y') }}</p>
                </div>

                <div class="flex flex-col md:flex-row items-stretch gap-3 mt-5 md:mt-0">
                    <a href="{{ route('candidatos.index', $vacante) }}"
                       class="bg-slate-800 py-2 px-4 rounded-lg text-white text-xs font-bold text-center"
                    >
                        {{ $vacante->candidatos->count() }}
                        Candidatos
                    </a>
                    <a href="{{ route('vacantes.edit',$vacante->id) }}"
                       class="bg-yellow-500 py-2 px-4 rounded-lg text-white text-xs font-bold text-center">
                        Editar
                    </a>
                    <button wire:click="$emit('mostrarAlerta', {{ $vacante->id }})"
                            class="bg-red-700 py-2 px-4 rounded-lg text-white text-xs font-bold text-center">
                        Eliminar
                    </button>
                </div>
            </div>
        @empty
            <p class="p-3 text-center text-sm text-gray-600">No hay vacantes que mostrar</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $vacantes->links() }}
    </div>
</div>
{{-- Asi se importa un script personal desde app.blade.php --}}
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Livewire.on('mostrarAlerta', vacanteId => {
            Swal.fire({
                title: '¿Eliminar vacante?',
                text: "Una vacante eliminada no se puede recuperar",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Eliminar vacante
                    Livewire.emit('eliminarVacante', vacanteId)


                    Swal.fire(
                        'Se elimino correctamente',
                        'La vacante se ha eliminado correctamente',
                        'success'
                    )
                }
            })
        })
    </script>
@endpush
