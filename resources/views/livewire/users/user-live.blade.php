<div>
    <form class="grid grid-cols-4 gap-3" wire:submit="saveUser">
        <div class="form-group">
            <label for="name" class="form-label
                @error('name') is-invalid @enderror">
                Nombre de Usuario
            </label>
            <input type="text" class="form-text" id="name"
                   wire:model="form.name" placeholder="Nombre de Usuario">
            @error('form.name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email" class="form-label
                @error('email') is-invalid @enderror">
                Email
            </label>
            <input type="email" class="form-text" id="email"
                   wire:model="form.email" placeholder="Email">
            @error('form.email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="form-label
                @error('password') is-invalid @enderror">
                Contraseña
            </label>
            <input type="password" class="form-text" id="password"
                   wire:model="form.password" placeholder="Contraseña">
            @error('form.password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="roles" class="form-label
                @error('roles') is-invalid @enderror">
                Rol
            </label>
            <select id="roles" class="form-select" wire:model="form.role">
                <option value="">Seleccione un rol</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}">{{ __($role) }}</option>
                @endforeach
            </select>
            @error('form.roles')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="active" class="form-label mb-2 inline-block">Estado</label>
            <div class="flex items-center">
                <div class="relative inline-block w-12 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" id="active" wire:model="form.active"
                           class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-transform duration-200 ease-in"/>
                    <label for="active"
                           class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                </div>
                <span class="ml-2 text-sm">
                    {{ $form->active  ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
            @error('form.active')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="pt-12">
            <button type="submit" class="btn-primary">
                @if($isEdit)
                    Actualizar
                @else
                    Guardar
                @endif
            </button>
        </div>

    </form>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRoleNames()->map(fn($role) => __($role))->join(' | ') }}</td>
                    <td>{{ $user->active_text }}</td>
                    <td>
                        <button wire:click="editUser({{ $user->id }})" class="btn-secondary">
                            Editar
                        </button>
                        <button @click="$dispatch('alert-delete',{{$user->id}})" class="btn-danger">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>
</div>
@script
<script>
    $wire.on('alert-delete', (user_id) => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo'
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.deleteUser(user_id);
                Swal.fire(
                    'Eliminado!',
                    'La Usuario ha sido eliminado.',
                    'success'
                )
            }
        })
    });
</script>
@endscript
