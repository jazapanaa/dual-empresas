<div>
    <form class="grid grid-cols-4 gap-3" wire:submit="saveCompany">
        <div class="form-group">
            <label for="name" class="form-label
                @error('name') is-invalid @enderror">
                Nombre de la empresa
            </label>
            <input type="text" class="form-text" id="name"
                   wire:model="form.name" placeholder="Nombre de la empresa">
            @error('form.name')
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
                Correo electrónico
            </label>
            <input type="text" class="form-text" id="email"
                   wire:model="form.email" placeholder="Correo electrónico">
            @error('form.email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="website" class="form-label
                @error('website') is-invalid @enderror">
                Página web
            </label>
            <input type="text" class="form-text" id="website"
                   wire:model="form.website" placeholder="Página web">
            @error('form.website')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="imagen" class="form-label
                @error('imagen') is-invalid @enderror">
                Imagen
            </label>
            <input type="file" class="form-file" id="imagen"
                   wire:model="imagen" placeholder="Imagen">
            @error('imagen')
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
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo electrónico</th>
                <th>Página web</th>
                <th>Logo</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($companies as $company)
                <tr>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->address }}</td>
                    <td>{{ $company->phone }}</td>
                    <td>{{ $company->email }}</td>
                    <td>{{ $company->website }}</td>
                    <td>
                        @if($company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="logo">
                        @else
                            Sin logo
                        @endif
                    <td>
                        <button wire:click="editCompany({{ $company->id }})" class="btn-secondary">
                            Editar
                        </button>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $companies->links() }}
        </div>
    </div>
</div>
@script
<script>
    $wire.on('alert-delete', (company_id) => {
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
                $wire.deleteCompany(company_id);
                Swal.fire(
                    'Eliminado!',
                    'La empresa ha sido eliminada.',
                    'success'
                )
            }
        })
    });
</script>
@endscript
