<div>
    <form class="grid grid-cols-4 gap-3" wire:submit="saveProduct">
        <div class="form-group">
            <label for="code" class="form-label
                @error('code') is-invalid @enderror">
                Código del producto
            </label>
            <input type="text" class="form-text" id="code"
                   wire:model="form.code" placeholder="Código del producto">
            @error('form.code')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name" class="form-label
                @error('name') is-invalid @enderror">
                Nombre del producto
            </label>
            <input type="text" class="form-text" id="name"
                   wire:model="form.name" placeholder="Nombre del producto">
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
            <label for="category_id" class="form-label
                @error('category_id') is-invalid @enderror">
                Categoría
            </label>
            <select class="form-select" id="category_id"
                    wire:model="form.category_id">
                <option value="">Seleccione una categoría</option>
                @foreach($categories as $key => $category)
                    <option value="{{ $key }}">{{ $category }}</option>
                @endforeach
            </select>
            @error('form.category_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="unit_id" class="form-label
                @error('unit_id') is-invalid @enderror">
                Unidad
            </label>
            <select class="form-select" id="unit_id"
                    wire:model="form.unit_id">
                <option value="">Seleccione una unidad</option>
                @foreach($units as $key => $unit)
                    <option value="{{ $key }}">{{ $unit }}</option>
                @endforeach
            </select>
            @error('form.unit_id')
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
    <div class="py-2 flex gap-2">
        <button type="button" class="btn-secondary cursor-pointer"
                wire:click="exportFile">
            <i class="fas fa-file-excel text-2xl"></i>
        </button>
        <a href="{{route('reports.products')}}" target="_blank" class="btn-secondary">
            <i class="fas fa-file-pdf text-2xl"></i>
        </a>
        <input type="text" class="form-text" id="search"
               wire:model="search"
               wire:keydown.enter="buscar"
               placeholder="Buscar producto">

    </div>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Unidad</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->category?->name }}</td>
                    <td>{{ $product->unit?->code }}</td>
                    <td>
                        <a href="{{route('warehouse.product.suppliers',$product->id)}}" class="btn-primary m-1">
                            Ver
                        </a>
                        <button wire:click="editProduct({{ $product->id }})" class="btn-secondary m-1">
                            Editar
                        </button>
                        <button @click="$dispatch('alert-delete',{{$product->id}})" class="btn-danger m-1">
                            Eliminar
                        </button>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $products->links() }}
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
                $wire.deleteProduct(category_id);
                Swal.fire(
                    'Eliminado!',
                    'El producto ha sido eliminada.',
                    'success'
                )
            }
        })
    });
</script>
@endscript
