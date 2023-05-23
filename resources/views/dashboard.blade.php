<x-app-layout>
    <x-slot name="header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden">
                <div class="p-6">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
