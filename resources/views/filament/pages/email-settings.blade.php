<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Page Header --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        Email Settings
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Configure SMTP, sender information and administrative email notifications.
                    </p>
                </div>

                <div class="flex items-center gap-2 text-sm font-medium text-primary-600">
                    <x-heroicon-o-envelope class="h-6 w-6" />
                    Email Configuration
                </div>
            </div>
        </div>

        {{-- Information Cards --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-primary-50 p-3 dark:bg-primary-950">
                        <x-heroicon-o-server class="h-6 w-6 text-primary-600" />
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Mail Server
                        </p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            SMTP Configuration
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-success-50 p-3 dark:bg-success-950">
                        <x-heroicon-o-paper-airplane class="h-6 w-6 text-success-600" />
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Sender Details
                        </p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            Email & Name
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-warning-50 p-3 dark:bg-warning-950">
                        <x-heroicon-o-shield-check class="h-6 w-6 text-warning-600" />
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Security
                        </p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            Protected Credentials
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Email Settings Form --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Configure Email Service
                </h3>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Enter the settings provided by your email service provider.
                </p>
            </div>

            <form wire:submit="save" class="space-y-6">

                {{ $this->form }}

                <div class="flex justify-end border-t border-gray-200 pt-5 dark:border-gray-700">
                    <x-filament::button
                        type="submit"
                        icon="heroicon-o-check-circle"
                    >
                        Save Email Settings
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
                        Email Security Notice
                    </h3>

                    <p class="mt-1 text-sm text-amber-800 dark:text-amber-300">
                        Never share your SMTP password or email credentials.
                        Use an App Password when required by your email provider.
                        Saving these settings does not automatically configure
                        Laravel's mail service.
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-filament-panels::page>
