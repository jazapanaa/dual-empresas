<div>
    <form class="grid grid-cols-3 gap-3" wire:submit="saveSupplier">
        <div class="form-group">
            <label for="name" class="form-label
                @error('name') is-invalid @enderror">
                Nombre completo del Proveedor
            </label>
            <input type="text" class="form-text" id="name"
                   wire:model="form.name" placeholder="Nombre del Proveedor">
            @error('form.name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="ruc" class="form-label
                @error('ruc') is-invalid @enderror">
                Número de ruc
            </label>
            <input type="number" class="form-text" id="ruc"
                   wire:model="form.ruc" placeholder="Descripción" any step="1" min="0">
            @error('form.ruc')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone" class="form-label
                @error('phone') is-invalid @enderror">
                Teléfono
            </label>
            <input type="text" class="form-text" id="phone"
                   wire:model="form.phone" placeholder="Teléfono">
            @error('form.phone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email" class="form-label
                @error('email') is-invalid @enderror">
                Correo Electrónico
            </label>
            <input type="email" class="form-text" id="email"
                   wire:model="form.email" placeholder="Correo Electrónico">
            @error('form.email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="address" class="form-label
                @error('address') is-invalid @enderror">
                Dirección
            </label>
            <input type="text" class="form-text" id="address"
                   wire:model="form.address" placeholder="Dirección">
            @error('form.address')
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
                <th>Ruc</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Dirección</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->ruc }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td>
                        <button wire:click="editSupplier({{ $supplier->id }})" class="btn-secondary">
                            Editar
                        </button>
                        <button @click="$dispatch('alert-delete',{{$supplier->id}})" class="btn-danger">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $suppliers->links() }}
        </div>

    </div>
</div>
@script
<script>
    $wire.on('alert-delete', (supplier_id) => {
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
                $wire.deleteSupplier(supplier_id);
                Swal.fire(
                    'Eliminado!',
                    'El Proveedor ha sido eliminada.',
                    'success'
                )
            }
        })
    });
</script>
@endscript
