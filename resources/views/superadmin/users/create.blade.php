<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Add New User') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8" x-data="{ role: '{{ old('role', 'reviewer') }}' }">
                    <form method="POST" action="{{ route('superadmin.users.store') }}">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="role" :value="__('Assign Role')" />
                            <select id="role" name="role" x-model="role" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="reviewer">ABS Soft Reviewer</option>
                                <option value="college_admin">College Admin</option>
                            </select>
                        </div>
                        <!-- THE FIX: This dropdown will now only show for College Admins -->
                        <div class="mt-4" x-show="role === 'college_admin'" x-transition>
                            <x-input-label for="college_id" :value="__('Assign to College')" />
                            <select id="college_id" name="college_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">-- Select a College --</option>
                                @foreach ($colleges as $college)
                                    <option value="{{ $college->id }}" @selected(old('college_id') == $college->id)>{{ $college->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('college_id')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('superadmin.users.index') }}" class="text-sm text-gray-600 dark:text-gray-400">Cancel</a>
                            <x-primary-button class="ms-4">Create User</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>