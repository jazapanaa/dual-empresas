<div>
    <div>
        Producto: <span>{{$product->name}}</span>

    </div>
    <form class="grid grid-cols-4 gap-3" wire:submit="saveProductSupplier">
        <div class="form-group">
            <label for="supplier_id" class="form-label
                @error('supplier_id') is-invalid @enderror">
                Proveedor
            </label>
            <select class="form-select" id="supplier_id"
                    wire:model="form.supplier_id">
                <option value="">Seleccione un proveedor</option>
                @foreach($suppliers as $key => $supplier)
                    <option value="{{ $key }}">{{ $supplier }}</option>
                @endforeach
            </select>
            @error('supplier_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="cost_price" class="form-label
                @error('cost_price') is-invalid @enderror">
                Precio de costo
            </label>
            <input type="number" class="form-text" id="cost_price"
                   wire:model="form.cost_price" placeholder="Precio de costo" step="0.01" min="0">
            @error('cost_price')
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
            <a href="{{route('warehouse.products')}}" class="btn-secondary">
                Cancelar
            </a>
        </div>

    </form>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>Proveedor</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products_suppliers as $product_supplier)
                <tr>
                    <td>{{ $product_supplier->supplier->name }}</td>
                    <td>{{ $product_supplier->cost_price }}</td>
                    <td>
                        <button wire:click="editProductSupplier({{ $product_supplier->id }})" class="btn-secondary">
                            Editar
                        </button>
                        <button @click="$dispatch('alert-delete',{{$product_supplier->id}})" class="btn-danger">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>


</div>
@script
<script>
    $wire.on('alert-delete', (product_supplier_id) => {
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
                $wire.deleteProductSupplier(product_supplier_id);
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
