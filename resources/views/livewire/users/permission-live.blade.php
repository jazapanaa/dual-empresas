<div>
    <form class="grid grid-cols-4 gap-3" wire:submit="savePermission">
        <div class="form-group">
            <label for="name" class="form-label
                @error('name') is-invalid @enderror">
                Nombre del Permiso
            </label>
            <input type="text" class="form-text" id="name"
                   wire:model="form.name" placeholder="Nombre del Permiso">
            @error('form.name')
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
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <button wire:click="editPermission({{ $permission->id }})" class="btn-secondary">
                            Editar
                        </button>
                        <button @click="$dispatch('alert-delete',{{$permission->id}})" class="btn-danger">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $permissions->links() }}
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
                $wire.deletePermission(user_id);
                Swal.fire(
                    'Eliminado!',
                    'El permiso ha sido eliminado.',
                    'success'
                )
            }
        })
    });
</script>
@endscript
