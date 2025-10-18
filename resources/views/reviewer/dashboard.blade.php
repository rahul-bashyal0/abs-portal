<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Assigned Projects for Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-4">
                @forelse ($assignedSubmissions as $submission)
                     <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4 flex flex-col md:flex-row justify-between items-center">
                        <div class="w-full md:w-3/4">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $submission->title }}</h3>
                            <p class="text-sm mt-1 text-gray-600 dark:text-gray-400">
                                By: <span class="font-semibold">{{ $submission->student->name }}</span> ({{ $submission->student->college->name ?? 'N/A' }})
                            </p>
                        </div>
                        <div class="w-full md:w-1/4 text-left md:text-right mt-4 md:mt-0">
                            <a href="{{ route('reviewer.submission.show', $submission) }}" class="inline-block px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-semibold text-sm">
                                Review
                            </a>
                        </div>
                     </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg text-center p-12">
                        <p class="text-gray-500 dark:text-gray-400">You have no active submissions to review.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>