<div>
    <form class="grid grid-cols-4 gap-3" wire:submit="saveMovementType">
        <div class="form-group">
            <label for="name" class="form-label
                @error('name') is-invalid @enderror">
                Nombre del tipo de movimiento
            </label>
            <input type="text" class="form-text" id="name"
                   wire:model="form.name" placeholder="Nombre del tipo de movimiento">
            @error('form.name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description" class="form-label
                @error('description') is-invalid @enderror">
                Descripción
            </label>
            <input type="text" class="form-text" id="description"
                   wire:model="form.description" placeholder="Descripción">
            @error('form.description')
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
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($movements_type as $movement_type)
                <tr>
                    <td>{{ $movement_type->name }}</td>
                    <td>{{ $movement_type->description }}</td>
                    <td>
                        <button wire:click="editMovementType({{ $movement_type->id }})" class="btn-secondary">
                            Editar
                        </button>
                        <button @click="$dispatch('alert-delete',{{$movement_type->id}})" class="btn-danger">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $movements_type->links() }}
        </div>
    </div>
</div>
@script
<script>
    $wire.on('alert-delete', (movement_type_id) => {
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
                $wire.deleteMovementType(movement_type_id);
                Swal.fire(
                    'Eliminado!',
                    'La tipo de movimiento ha sido eliminada.',
                    'success'
                )
            }
        })
    });
</script>
@endscript
