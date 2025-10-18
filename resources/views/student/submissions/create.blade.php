<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Submit New Project Idea') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('student.submission.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Project Title -->
                        <div>
                            <x-input-label for="title" :value="__('Project Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Problem Statement -->
                        <div class="mt-4">
                            <x-input-label for="problem_statement" :value="__('Problem Statement')" />
                            <textarea id="problem_statement" name="problem_statement" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('problem_statement') }}</textarea>
                            <x-input-error :messages="$errors->get('problem_statement')" class="mt-2" />
                        </div>

                        <!-- Solution Description -->
                        <div class="mt-4">
                            <x-input-label for="solution_description" :value="__('Proposed Solution')" />
                            <textarea id="solution_description" name="solution_description" rows="6" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('solution_description') }}</textarea>
                            <x-input-error :messages="$errors->get('solution_description')" class="mt-2" />
                        </div>
                        
                        <!-- Technologies Used -->
                        <div class="mt-4">
                            <x-input-label for="technologies_used" :value="__('Technologies (e.g., Laravel, Vue, Python, etc.)')" />
                            <x-text-input id="technologies_used" class="block mt-1 w-full" type="text" name="technologies_used" :value="old('technologies_used')" required />
                            <x-input-error :messages="$errors->get('technologies_used')" class="mt-2" />
                        </div>

                        <!-- Video Link (Optional) -->
                        <div class="mt-4">
                            <x-input-label for="video_link" :value="__('Video Link (Optional Demo/Walkthrough)')" />
                            <x-text-input id="video_link" class="block mt-1 w-full" type="url" name="video_link" :value="old('video_link')" placeholder="https://youtube.com/..." />
                            <x-input-error :messages="$errors->get('video_link')" class="mt-2" />
                        </div>
                        
                        <!-- File Upload (Optional) -->
                        <div class="mt-4">
                            <x-input-label for="file" :value="__('Supporting File (Optional PDF, ZIP, DOC - Max 10MB)')" />
                            <input id="file" name="file" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-1">
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Cancel</a>
                            <x-primary-button class="ms-4">
                                {{ __('Submit Idea') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>