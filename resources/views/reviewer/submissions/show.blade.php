<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Reviewing Project: {{ $submission->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Submission Details</h3>
                    <div class="mt-4 space-y-2 text-gray-700 dark:text-gray-300">
                        <p><strong>Problem:</strong><br>{{ $submission->problem_statement }}</p>
                        <p class="mt-2"><strong>Solution:</strong><br>{{ $submission->solution_description }}</p>
                        <p class="mt-2"><strong>Technologies:</strong><br>{{ $submission->technologies_used }}</p>
                    </div>

                    <hr class="my-6 dark:border-gray-600">
                    
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Submit Your Feedback</h3>
                    <form method="POST" action="{{ route('reviewer.submission.feedback', $submission) }}" class="mt-4">
                        @csrf
                        <div class="mt-4">
                            <label for="rating" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Overall Rating</label>
                            <select id="rating" name="rating" required class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">Select a rating</option>
                                <option value="5" @selected(old('rating') == 5)>5 - Excellent</option>
                                <option value="4" @selected(old('rating') == 4)>4 - Very Good</option>
                                <option value="3" @selected(old('rating') == 3)>3 - Good</option>
                                <option value="2" @selected(old('rating') == 2)>2 - Fair</option>
                                <option value="1" @selected(old('rating') == 1)>1 - Poor</option>
                            </select>
                            <!-- THE FIX: Display validation errors -->
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <label for="comment" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Feedback Comments</label>
                            <textarea id="comment" name="comment" rows="6" required class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('comment') }}</textarea>
                            <!-- THE FIX: Display validation errors -->
                            <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <label for="status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Final Decision</label>
                            <select id="status" name="status" required class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">Select a decision</option>
                                <option value="Shortlisted" @selected(old('status') == 'Shortlisted')>Shortlist</option>
                                <option value="Rejected" @selected(old('status') == 'Rejected')>Reject</option>
                            </select>
                            <!-- THE FIX: Display validation errors -->
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-semibold text-sm">Submit Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>