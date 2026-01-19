<div>
    <h3 class="mb-3">Materias ({{ count($subjects) }})</h3>

    <div class="border rounded p-3 max-h-80 overflow-auto">
        @forelse($subjects as $s)
            <div class="py-2 border-b">
                <span class="font-medium">{{ $s['name'] }}</span>
                <span class="text-sm opacity-70">#{{ $s['id'] }}</span>
            </div>
        @empty
            <div>No hay materias activas.</div>
        @endforelse
    </div>
</div>
