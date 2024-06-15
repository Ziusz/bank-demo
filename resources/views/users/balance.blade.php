<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Balance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800">
                    <div class="mb-4">
                        <p class="text-lg text-gray-900 dark:text-gray-100">Your current balance:</p>
                        <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">${{ number_format(auth()->user()->balance, 2) }}</p>
                    </div>
                    <div class="flex items-center justify-end">
                        <a href="{{ route('transactions.index') }}" class="btn btn-primary">View Transactions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
