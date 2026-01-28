<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold text-dark mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>