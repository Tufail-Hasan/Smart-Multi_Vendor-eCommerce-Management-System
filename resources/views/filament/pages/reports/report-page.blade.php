<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Report Header --}}
        <div class="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-900">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $reportData['title'] }}
            </h2>

            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ $reportData['description'] }}
            </p>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($reportData['cards'] as $card)
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ $card['label'] }}
                    </p>

                    <p class="mt-3 text-2xl font-bold text-primary-600 dark:text-primary-400">
                        {{ $card['value'] }}
                    </p>
                </div>
            @endforeach
        </div>

        {{-- Report Table --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">

            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Report Details
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            @foreach ($reportData['columns'] as $column)
                                <th class="whitespace-nowrap px-6 py-4 font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $column }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($reportData['rows'] as $row)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                @foreach ($reportData['columns'] as $column)
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-700 dark:text-gray-300">
                                        {{ $row[$column] ?? '—' }}
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="{{ count($reportData['columns']) }}"
                                    class="px-6 py-10 text-center text-gray-500 dark:text-gray-400"
                                >
                                    No report data available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-filament-panels::page>
