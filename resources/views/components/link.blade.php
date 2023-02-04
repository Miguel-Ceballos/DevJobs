<!-- Declaramos las clases en una variable -->
@php
    $classes = "text-sm text-blue-600 hover:text-gray-900"
@endphp

<!-- Pasamos las clases como argumento
    Esto hace que identifique de mejor manera la ruta de los links "a"-->
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
