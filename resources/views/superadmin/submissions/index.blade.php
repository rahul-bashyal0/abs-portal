<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Project Submissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @forelse ($submissions as $submission)
                        <div class="p-4 rounded-lg border dark:border-gray-700 {{ !$loop->last ? 'mb-4' : '' }}">
                            <div class="flex flex-col md:flex-row justify-between">
                                <div>
                                    <h3 class="font-bold text-lg text-indigo-600 dark:text-indigo-400">{{ $submission->title }}</h3>
                                    <p class="text-sm mt-1">By: <span class="font-semibold">{{ $submission->student->name }}</span> ({{ $submission->student->college->name ?? 'N/A' }})</p>
                                    <p class="text-xs text-gray-500">Submitted: {{ $submission->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="mt-4 md:mt-0 md:text-right">
                                    <p class="text-sm">Status: <span class="font-semibold">{{ $submission->status }}</span></p>
                                    <p class="text-sm">Reviewer: <span class="font-semibold">{{ $submission->reviewer->name ?? 'Not Assigned' }}</span></p>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t dark:border-gray-700">
                                <form action="{{ route('superadmin.submissions.assign', $submission) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center space-x-4">
                                        <select name="reviewer_id" class="block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="">-- Assign a Reviewer --</option>
                                            @foreach($reviewers as $reviewer)
                                                <option value="{{ $reviewer->id }}" @selected($submission->reviewer_id == $reviewer->id)>{{ $reviewer->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-primary-button>Assign</x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">No submissions yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>