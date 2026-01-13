<div>
    <form wire:submit="save">
        <div class="space-y-4">
            @foreach ($modules as $index => $module)
                <div class="flex items-center bg-gray-50 p-3 rounded-md shadow-sm">
                    <input wire:model.defer="modules.{{ $index }}.value"
                        type="checkbox" name="modules[{{ $module['id'] }}]" id="module_{{ $module['id'] }}"
                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="module_{{ $module['id'] }}" class="text-gray-700 font-medium ms-4">
                        {{ ucfirst(str_replace('modules.', '', $module['key'])) }}
                    </label>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            <button type="submit"
                    class="btn-primary">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
