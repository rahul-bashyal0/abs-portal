<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Reviewing: <span class="text-brand-primary">{{ $submission->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side: Submission Details -->
            <div class="lg:col-span-2 space-y-6">
                <div class="glass-card p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-bold border-b dark:border-gray-700 pb-2 text-gray-900 dark:text-gray-100">Problem Statement</h3>
                    <p class="mt-4 text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $submission->problem_statement }}</p>
                </div>
                <div class="glass-card p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-bold border-b dark:border-gray-700 pb-2 text-gray-900 dark:text-gray-100">Proposed Solution</h3>
                    <p class="mt-4 text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $submission->solution_description }}</p>
                </div>
                <div class="glass-card p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-bold border-b dark:border-gray-700 pb-2 text-gray-900 dark:text-gray-100">Technologies & Links</h3>
                     <p class="mt-4 font-semibold text-gray-700 dark:text-gray-300">Technologies: <span class="font-normal">{{ $submission->technologies_used }}</span></p>
                    @if($submission->video_link)
                        <a href="{{ $submission->video_link }}" target="_blank" class="mt-4 inline-block text-brand-primary hover:underline font-semibold">View Video Demo →</a>
                    @endif
                    @if($submission->file_path)
                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="mt-4 inline-block text-brand-primary hover:underline font-semibold ml-4">Download Supporting File →</a>
                    @endif
                </div>
            </div>

            <!-- Right Side: Feedback Form -->
            <div class="lg:col-span-1">
                 <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 sticky top-24">
                    <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Submit Your Feedback</h3>
                     <form method="POST" action="{{ route('reviewer.submission.feedback', $submission) }}">
                        @csrf
                        <div>
                            <x-input-label for="rating" value="Overall Rating" />
                            <select id="rating" name="rating" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">-- Select Rating --</option>
                                <option value="1">1 - Poor</option>
                                <option value="2">2 - Fair</option>
                                <option value="3">3 - Good</option>
                                <option value="4">4 - Very Good</option>
                                <option value="5">5 - Excellent</option>
                            </select>
                             <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="comment" value="Feedback Comment" />
                            <textarea id="comment" name="comment" rows="8" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                             <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="status" value="Final Decision" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">-- Select Decision --</option>
                                <option value="Shortlisted">Shortlist for Next Round</option>
                                <option value="Rejected">Reject</option>
                            </select>
                             <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        
                        <div class="mt-6">
                            <x-primary-button class="w-full justify-center">Submit Review</x-primary-button>
                        </div>
                     </form>
                 </div>
            </div>
        </div>
    </x-app-layout>