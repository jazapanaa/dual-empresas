<div>
    <div class="py-2 flex gap-2">
        <button type="button" class="btn-secondary cursor-pointer"
                wire:click="exportFile">
            <i class="fas fa-file-excel text-2xl"></i>
        </button>
        <a href="{{route('reports.inventory')}}" target="_blank" class="btn-secondary">
            <i class="fas fa-file-pdf text-2xl"></i>
        </a>
    </div>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>Producto</th>
                <th>Almacén</th>
                <th>Cantidad</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock->product->name }}</td>
                    <td>{{ $stock->warehouse->name }}</td>
                    <td>{{ $stock->quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $stocks->links() }}
        </div>
    </div>
</div>
