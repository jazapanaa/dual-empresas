<x-layouts.app title="Roles">
    <h1 class="title-page">
        <i class="fas fa-sliders-h"></i>
        Roles y permisos
    </h1>
    <hr class="my-4">
    <livewire:users.role-permission-live :role_id="$role_id" />
</x-layouts.app>
