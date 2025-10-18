<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Super Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Card 1: Manage institutes -->
                <a href="{{ route('superadmin.colleges.index') }}" class="glass-card p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="p-3 bg-brand-primary/20 rounded-full">
                           <svg class="w-6 h-6 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manage Colleges</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Add, edit, and remove partners.</p>
                        </div>
                    </div>
                </a>

                <!-- Card 2: Manage Users -->
                <a href="{{ route('superadmin.users.index') }}" class="glass-card p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-1">
                     <div class="flex items-center">
                        <div class="p-3 bg-brand-secondary/20 rounded-full">
                           <svg class="w-6 h-6 text-brand-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manage Users</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Create Admins and Reviewers.</p>
                        </div>
                    </div>
                </a>

                <!-- Card 3: Manage Submissions -->
                 <a href="{{ route('superadmin.submissions.index') }}" class="glass-card p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-1">
                     <div class="flex items-center">
                        <div class="p-3 bg-green-500/20 rounded-full">
                           <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manage Submissions</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Assign projects to reviewers.</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>