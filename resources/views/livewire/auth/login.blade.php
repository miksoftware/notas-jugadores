<div class="flex min-h-screen">
    {{-- Panel izquierdo decorativo --}}
    <div class="relative hidden w-1/2 flex-col justify-between bg-brand p-12 text-white lg:flex">
        <div>
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/20">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold">Notas de Jugadores</h1>
            </div>
        </div>
        <div>
            <p class="text-3xl font-bold leading-snug">Gestiona observaciones internas sobre tus jugadores.</p>
            <p class="mt-4 max-w-md text-white/70">Plataforma de soporte para registrar, consultar y dar seguimiento a las notas del equipo.</p>
        </div>
        <p class="text-sm text-white/40">&copy; {{ date('Y') }} Notas de Jugadores</p>
    </div>

    {{-- Formulario --}}
    <div class="flex w-full flex-col items-center justify-center bg-slate-50 px-6 py-12 lg:w-1/2">
        <div class="mb-8 text-center lg:hidden">
            <h1 class="text-2xl font-bold text-brand">Notas de Jugadores</h1>
        </div>

        <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-200/50">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-slate-800">Bienvenido</h2>
                <p class="mt-2 text-slate-500">Inicia sesión para continuar</p>
            </div>

            <form wire:submit="login" class="space-y-5">
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Correo electrónico</label>
                    <input id="email" wire:model="email" type="email" required
                        class="block w-full rounded-xl border border-slate-200 px-4 py-2.5 text-slate-800 shadow-sm transition focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                    @error('email') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Contraseña</label>
                    <input id="password" wire:model="password" type="password" required
                        class="block w-full rounded-xl border border-slate-200 px-4 py-2.5 text-slate-800 shadow-sm transition focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                    @error('password') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <button type="submit"
                    class="w-full rounded-xl bg-brand py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand/50">
                    Ingresar
                </button>
            </form>
        </div>
    </div>
</div>
