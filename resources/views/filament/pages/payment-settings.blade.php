<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Page Header --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        Payment Settings
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Manage payment methods and payment gateway configuration.
                    </p>
                </div>

                <div class="flex items-center gap-2 text-sm font-medium text-success-600">
                    <x-heroicon-o-shield-check class="h-5 w-5" />
                    Secure Configuration
                </div>
            </div>
        </div>

        {{-- Payment Settings Form --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">

            <form wire:submit="save" class="space-y-6">

                {{ $this->form }}

                <div class="flex flex-col justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-700 sm:flex-row">

                    <x-filament::button
                        type="submit"
                        icon="heroicon-o-check-circle"
                    >
                        Save Payment Settings
                    </x-filament::button>

                </div>

            </form>
        </div>

        {{-- Security Notice --}}
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-800 dark:bg-amber-950">
            <div class="flex items-start gap-3">
                <x-heroicon-o-exclamation-triangle
                    class="h-6 w-6 shrink-0 text-amber-600"
                />

                <div>
                    <h3 class="font-semibold text-amber-900 dark:text-amber-200">
                        Payment Security Notice
                    </h3>

                    <p class="mt-1 text-sm text-amber-800 dark:text-amber-300">
                        Never share your payment gateway secret keys publicly.
                        Use official gateway credentials and test transactions
                        before enabling live payments.
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-filament-panels::page>
