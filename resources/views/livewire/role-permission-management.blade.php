<div>
    @if (session()->has('error'))
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        @foreach($roles as $role)
            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                    <h3 class="text-lg font-semibold text-brand">
                        Rol: {{ $this->roleLabel($role->name) }}
                        @if($role->name !== $this->roleLabel($role->name))
                            <span class="text-sm font-normal text-slate-500">({{ $role->name }})</span>
                        @endif
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($groupedPermissions as $module => $permissions)
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <h4 class="mb-3 border-b border-slate-200 pb-2 text-sm font-bold uppercase tracking-wide text-slate-600">
                                    {{ $this->moduleLabel($module) }}
                                </h4>
                                
                                <div class="space-y-3">
                                    @foreach($permissions as $perm)
                                        <label class="flex cursor-pointer items-center space-x-3">
                                            <input type="checkbox" 
                                                wire:click="togglePermission({{ $role->id }}, '{{ $perm->name }}')"
                                                @if($role->hasPermissionTo($perm->name)) checked @endif
                                                @if($role->name === 'Admin') disabled @endif
                                                class="h-5 w-5 rounded border-slate-300 text-brand focus:ring-brand/30">
                                            <span class="text-sm font-medium text-slate-700">
                                                {{ $this->actionLabel($perm->name) }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
