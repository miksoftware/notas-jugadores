<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionManagement extends Component
{
    private const MODULE_LABELS = [
        'users' => 'Usuarios',
        'notes' => 'Notas',
        'players' => 'Jugadores',
    ];

    private const ACTION_LABELS = [
        'view' => 'Ver',
        'create' => 'Crear',
        'edit' => 'Editar',
        'delete' => 'Eliminar',
    ];

    private const ROLE_LABELS = [
        'Admin' => 'Administrador',
        'Support Agent' => 'Agente de Soporte',
    ];

    public function togglePermission($roleId, $permissionName)
    {
        $role = Role::findById($roleId);
        
        if ($role->name === 'Admin') {
            session()->flash('error', 'No se pueden modificar los permisos del Administrador principal.');
            return;
        }

        if ($role->hasPermissionTo($permissionName)) {
            $role->revokePermissionTo($permissionName);
            session()->flash('success', 'Permiso revocado correctamente.');
        } else {
            $role->givePermissionTo($permissionName);
            session()->flash('success', 'Permiso asignado correctamente.');
        }
    }

    public function moduleLabel(string $module): string
    {
        return self::MODULE_LABELS[$module] ?? ucfirst($module);
    }

    public function actionLabel(string $permissionName): string
    {
        $action = explode('.', $permissionName)[1] ?? $permissionName;

        return self::ACTION_LABELS[$action] ?? ucfirst($action);
    }

    public function roleLabel(string $roleName): string
    {
        return self::ROLE_LABELS[$roleName] ?? $roleName;
    }

    public function render()
    {
        $roles = Role::all();
        $allPermissions = Permission::orderBy('name')->get();
        
        // Agrupar permisos por módulo (ej: "users.create" -> módulo "users")
        $groupedPermissions = [];
        foreach($allPermissions as $perm) {
            $parts = explode('.', $perm->name);
            $module = $parts[0] ?? 'general';
            $groupedPermissions[$module][] = $perm;
        }

        return view('livewire.role-permission-management', [
            'roles' => $roles,
            'groupedPermissions' => $groupedPermissions
        ])->layout('components.layouts.app');
    }
}
