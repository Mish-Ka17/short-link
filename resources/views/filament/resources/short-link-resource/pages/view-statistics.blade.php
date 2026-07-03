<x-filament-panels::page>

    <x-filament::section>

        <h2 class="text-xl font-bold">

            {{ $record->title }}

        </h2>

        <p>

            <strong>Оригинальная ссылка:</strong>

            {{ $record->original_url }}

        </p>

        <p>

            <strong>Короткая ссылка:</strong>

            {{ url($record->short_code) }}

        </p>

    </x-filament::section>

    {{ $this->table }}

</x-filament-panels::page>
