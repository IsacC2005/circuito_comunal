<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invalid ? 'Enlace inválido' : 'Registro — ' . $community->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f3f4f6; font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4">

    <div class="w-full max-w-md">

        {{-- Logo / cabecera --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-amber-500 mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Circuito Comunal</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            @if ($invalid)
                {{-- Estado: enlace inválido --}}
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-red-100 mb-4">
                        <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Enlace inválido</h2>
                    <p class="text-gray-500 text-sm">
                        Este enlace de registro es inválido o ya fue utilizado.<br>
                        Por favor, solicita un nuevo enlace al administrador.
                    </p>
                </div>

            @else
                {{-- Estado: formulario válido --}}
                <div class="px-8 pt-8 pb-2 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Crear cuenta</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Estás registrándote como administrador de
                        <span class="font-medium text-amber-600">{{ $community->name }}</span>.
                    </p>
                </div>

                <form method="POST" action="{{ route('invite.store', $token) }}" class="p-8 space-y-5">
                    @csrf

                    {{-- Nombre --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre completo
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            class="w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500
                                   {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Correo --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Correo electrónico
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500
                                   {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        >
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contraseña --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Contraseña
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500
                                   {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirmar contraseña
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            class="w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500
                                   {{ $errors->has('password_confirmation') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full py-2.5 px-4 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg text-sm
                               transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2"
                    >
                        Crear cuenta
                    </button>
                </form>
            @endif

        </div>

        <p class="text-center text-xs text-gray-400 mt-6">Circuito Comunal &copy; {{ date('Y') }}</p>
    </div>

</body>
</html>
