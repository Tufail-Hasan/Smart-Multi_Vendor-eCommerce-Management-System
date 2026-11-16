<x-filament-panels::page>
    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    General Settings
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Configure your store name, contact information, logo and regional preferences.
                </p>
            </div>

            <form wire:submit="save" class="space-y-6">
                {{ $this->form }}

                <div class="flex justify-end border-t border-gray-200 pt-5 dark:border-gray-700">
                    <x-filament::button
                        type="submit"
                        icon="heroicon-o-check"
                    >
                        Save Settings
                    </x-filament::button>
                </div>
            </form>
        </div>
    </div>
</x-filament-panels::page>
