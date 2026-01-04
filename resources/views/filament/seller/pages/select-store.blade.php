<x-filament-panels::page>
    <h1 class="text-2xl font-bold mb-4">اختر المتجر الذي تريد إدارته</h1>

    @if ($stores->isEmpty())
        <p>ليس لديك متاجر حاليًا. يرجى إنشاء واحد.</p>
        {{-- لو عايز زر إنشاء متجر --}}
    @else
        <ul class="space-y-4">
            @foreach ($stores as $store)
                <li>
                    <button wire:click="selectStore({{ $store->id }})" class="bg-green-500 text-white px-4 py-2 rounded">
                        {{ $store->name }} ({{ $store->slug }})
                    </button>
                </li>
            @endforeach
        </ul>
    @endif
</x-filament-panels::page>
