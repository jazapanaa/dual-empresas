<div>
    <div>
        <h1 class="text-3xl mb-4 ">{{__($role->name)}}</h1>
        <div class="flex gap-4 mb-4">
            <div>
                <select id="permissions" class="form-select" wire:model="select_permission">
                    <option value="">Seleccione un permiso</option>
                    @foreach($ddl_permissions as $key => $ddl_permission)
                        <option value="{{ $key }}">{{ __($ddl_permission) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button wire:click="addPermission" class="btn-primary">
                    Agregar Permiso
                </button>
            </div>

        </div>
    </div>
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
                    <td>{{ __($permission->name) }}</td>
                    <td>
                        <button wire:click="removePermission({{$permission->id}})" class="btn-danger">
                            Quitar permiso
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
