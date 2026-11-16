<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Header --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        Shipping Settings
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Manage delivery charges, free shipping rules and estimated delivery times.
                    </p>
                </div>

                <div class="flex items-center gap-2 text-sm font-medium text-primary-600">
                    <x-heroicon-o-truck class="h-6 w-6" />
                    Delivery Configuration
                </div>
            </div>
        </div>

        {{-- Quick Information Cards --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-primary-50 p-3 dark:bg-primary-950">
                        <x-heroicon-o-truck class="h-6 w-6 text-primary-600" />
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Default Shipping
                        </p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            Configure below
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-success-50 p-3 dark:bg-success-950">
                        <x-heroicon-o-gift class="h-6 w-6 text-success-600" />
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Free Shipping
                        </p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            Set a minimum order amount
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-warning-50 p-3 dark:bg-warning-950">
                        <x-heroicon-o-clock class="h-6 w-6 text-warning-600" />
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Delivery Time
                        </p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            Set estimated days
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Settings Form --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Configure Shipping
                </h3>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Changes will be saved to your website settings.
                </p>
            </div>

            <form wire:submit="save" class="space-y-6">

                {{ $this->form }}

                <div class="flex justify-end border-t border-gray-200 pt-5 dark:border-gray-700">
                    <x-filament::button
                        type="submit"
                        icon="heroicon-o-check-circle"
                    >
                        Save Shipping Settings
                    </x-filament::button>
                </div>

            </form>
        </div>

        {{-- Information Notice --}}
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-800 dark:bg-blue-950">
            <div class="flex items-start gap-3">
                <x-heroicon-o-information-circle
                    class="h-6 w-6 shrink-0 text-blue-600"
                />

                <div>
                    <h3 class="font-semibold text-blue-900 dark:text-blue-200">
                        Important Information
                    </h3>

                    <p class="mt-1 text-sm text-blue-800 dark:text-blue-300">
                        These are the default shipping preferences. Your Shipping Zones,
                        Shipping Methods and Delivery Charges may have their own rules.
                        Make sure your checkout logic uses the appropriate configuration.
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-filament-panels::page>
