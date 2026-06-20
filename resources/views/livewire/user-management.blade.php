<div>
    @if (session()->has('message'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-slate-800">Crear nuevo usuario</h3>
            
            <form wire:submit="createUser" class="space-y-4">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Nombre</label>
                    <input type="text" wire:model="name" class="block w-full rounded-xl border border-slate-200 p-2.5 shadow-sm focus:border-brand focus:ring-2 focus:ring-brand/20">
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" wire:model="email" class="block w-full rounded-xl border border-slate-200 p-2.5 shadow-sm focus:border-brand focus:ring-2 focus:ring-brand/20">
                    @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Contraseña</label>
                    <input type="password" wire:model="password" class="block w-full rounded-xl border border-slate-200 p-2.5 shadow-sm focus:border-brand focus:ring-2 focus:ring-brand/20">
                    @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Rol</label>
                    <select wire:model="role" class="block w-full rounded-xl border border-slate-200 bg-white p-2.5 shadow-sm focus:border-brand focus:ring-2 focus:ring-brand/20">
                        <option value="">Seleccione un rol...</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
                    @error('role') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full rounded-xl bg-brand py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                    Crear usuario
                </button>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm md:col-span-2">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Rol(es)</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Fecha alta</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($users as $user)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm font-medium text-slate-900">{{ $user->name }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm text-slate-500">{{ $user->email }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex rounded-full bg-teal-50 px-2.5 py-0.5 text-xs font-semibold text-brand">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
