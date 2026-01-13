<div>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>Log</th>
                <th>Descripción</th>
                <th>Tipo de asunto</th>
                <th>Evento</th>
                <th>Id asunto</th>
                <th>Tipo de causa</th>
                <th>Id de causa</th>
                <th>Propiedades</th>
                <th>Fecha</th>

            </tr>
            </thead>
            <tbody>
            @foreach ($audits as $audit)
                <tr>
                    <td>{{ $audit->log_name }}</td>
                    <td>
                        @if ($audit->description)
                            {{ $audit->description }}
                        @else
                            {{ $audit->properties['attributes']['description'] ?? 'No description available' }}
                        @endif
                    </td>
                    <td>{{ $audit->subject_type }}</td>
                    <td>{{ $audit->event }}</td>
                    <td>{{ $audit->subject_id }}</td>
                    <td>{{ $audit->causer_type }}</td>
                    <td>{{ $audit->causer_id }}</td>
                    <td>{{ $audit->properties }}</td>
                    <td>{{ $audit->created_at->format('Y-m-d H:i:s') }}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $audits->links() }}
        </div>
    </div>
</div>

