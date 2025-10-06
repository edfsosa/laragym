<div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-2">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            👋 {{ __('Welcome back') }}, {{ auth()->user()->name ?? 'User' }}!
        </h1>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ now()->format('l, F j, Y') }} · {{ __('Here’s an overview of your progress.') }}
        </p>

    </div>
    <button class="mt-4 md:mt-0 px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition">
        {{ __('View Reports') }}
    </button>
</div>
