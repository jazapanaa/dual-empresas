<div>
    <form class="grid grid-cols-4 gap-3" wire:submit="saveCategory">
        <div class="form-group">
            <label for="name" class="form-label
                @error('name') is-invalid @enderror">
                Nombre de la categoría
            </label>
            <input type="text" class="form-text" id="name"
                wire:model="form.name" placeholder="Nombre de la categoría">
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
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>{{ $category->active_text }}</td>
                        <td>
                            <button wire:click="editCategory({{ $category->id }})" class="btn-secondary">
                                Editar
                            </button>
                            <button @click="$dispatch('alert-delete',{{$category->id}})" class="btn-danger">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@script
<script>
    $wire.on('alert-delete', (category_id) => {
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
                $wire.deleteCategory(category_id);
                Swal.fire(
                    'Eliminado!',
                    'La categoría ha sido eliminada.',
                    'success'
                )
            }
        })
    });
</script>
@endscript
