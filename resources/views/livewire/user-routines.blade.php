<div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
        {{ __('My Routines') }}
    </h1>

    @if ($routines->count())
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($routines as $routine)
                <div
                    class="relative rounded-xl border-l-4 border-indigo-500 dark:border-indigo-400 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $routine->name }}
                        </h2>
                        @php
                            $statusColors = [
                                'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                'active' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
                                'paused' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            ];
                        @endphp

                        <span
                            class="px-3 py-1 rounded-full text-xs font-medium capitalize {{ $statusColors[$routine->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200' }}">
                            {{ $routine->status }}
                        </span>

                    </div>

                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                        <strong>Trainer:</strong> {{ $routine->trainer }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <strong>Assigned on:</strong> {{ $routine->assigned_date }}
                    </p>

                    <div class="mt-6 flex justify-end">
                        <button wire:click="viewDetails({{ $routine->id }})"
                            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                            {{ __('View Details') }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Modal con ejercicios --}}
    @if ($showModal && $selectedRoutine)
        <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div
                class="bg-white dark:bg-gray-900 rounded-xl shadow-xl w-full max-w-lg p-6 border-t-4 border-indigo-600 relative">
                <button wire:click="closeModal"
                    class="absolute top-2 right-3 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    ✕
                </button>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    {{ $selectedRoutine->name }}
                </h2>

                @php
                    $total = count($selectedRoutine->exercises);
                    $done = isset($completedExercises[$selectedRoutine->id])
                        ? count($completedExercises[$selectedRoutine->id])
                        : 0;
                    $percent = $total > 0 ? round(($done / $total) * 100) : 0;
                @endphp

                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                        <span>{{ $done }} / {{ $total }} {{ __('completed') }}</span>
                        <span>{{ $percent }}%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-2 bg-indigo-600 rounded-full transition-all duration-300"
                            style="width: {{ $percent }}%"></div>
                    </div>
                </div>


                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">
                    Trainer: {{ $selectedRoutine->trainer }} — Assigned on: {{ $selectedRoutine->assigned_date }}
                </p>

                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Exercises</h3>

                @if (!empty($selectedRoutine->exercises))
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($selectedRoutine->exercises as $index => $exercise)
                            @php
                                $isCompleted =
                                    isset($completedExercises[$selectedRoutine->id]) &&
                                    in_array($index, $completedExercises[$selectedRoutine->id]);
                            @endphp
                            <li
                                class="py-3 px-4 border rounded-lg mb-2 flex items-center justify-between
                            {{ $isCompleted ? 'bg-green-50 dark:bg-green-900/20 border-green-300 dark:border-green-700' : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700' }}">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox"
                                        wire:click="toggleExerciseCompletion({{ $selectedRoutine->id }}, {{ $index }})"
                                        @checked($isCompleted)
                                        class="rounded text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    <span
                                        class="{{ $isCompleted ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-800 dark:text-gray-200' }}">
                                        {{ $exercise['name'] }}
                                    </span>
                                </div>
                                <span class="text-gray-500 dark:text-gray-400 text-xs">
                                    {{ $exercise['sets'] }} × {{ $exercise['reps'] }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-400 text-sm">No exercises found for this routine.</p>
                @endif

                <div class="mt-6 flex justify-end">
                    <button wire:click="closeModal"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
