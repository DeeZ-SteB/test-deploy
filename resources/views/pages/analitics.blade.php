<x-app-layout>
    <x-slot name="header">
        <div class="card-content card-dark py-3 px-4 mb-5">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item text-white active" aria-current="page">
                    {{ __('Analytics') }}
                </li>
            </ol>
        </div>
    </x-slot>

    <div>
        <analytics-page
            :filters="{{ json_encode($analiticFilters) }}"
        />
    </div>
</x-app-layout>

