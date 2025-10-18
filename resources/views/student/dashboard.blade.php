<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Student Dashboard
            </h2>
            <a href="{{ route('student.submission.create') }}" class="px-4 py-2 bg-brand-primary hover:bg-brand-primary/80 text-white rounded-md font-semibold text-sm w-full sm:w-auto text-center">
                Submit New Project
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-semibold border-b border-gray-200 dark:border-gray-700 pb-3 mb-4 text-gray-900 dark:text-gray-100">Your Submissions Timeline</h3>
                <div class="space-y-12">
                    @forelse ($submissions as $submission)
                        @php
                            // Define the stages and current status
                            $stages = [
                                'Submitted' => ['label' => 'Idea Submitted', 'complete' => false, 'current' => false],
                                'Under Review' => ['label' => 'Under Review', 'complete' => false, 'current' => false],
                                'Decision Made' => ['label' => 'Decision Made', 'complete' => false, 'current' => false]
                            ];
                            $currentStatus = $submission->status;
                            $isComplete = false;

                            if ($currentStatus === 'Submitted') {
                                $stages['Submitted']['complete'] = true;
                                $stages['Under Review']['current'] = true;
                            } elseif ($currentStatus === 'Under Review') {
                                $stages['Submitted']['complete'] = true;
                                $stages['Under Review']['complete'] = true;
                                $stages['Decision Made']['current'] = true;
                            } elseif (in_array($currentStatus, ['Shortlisted', 'Rejected'])) {
                                $stages['Submitted']['complete'] = true;
                                $stages['Under Review']['complete'] = true;
                                $stages['Decision Made']['complete'] = true;
                                $isComplete = true;
                            }
                        @endphp
                        <div class="glass-card p-6 rounded-lg">
                            <!-- Top section with Title and Button -->
                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div>
                                    <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $submission->title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Submitted: {{ $submission->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="flex justify-end items-start">
                                    <!-- THE LOGIC FIX: Only show button if status is exactly 'Shortlisted' -->
                                    @if($submission->status === 'Shortlisted')
                                        <a href="{{ route('student.submission.certificate', $submission) }}" class="inline-block px-4 py-2 bg-green-500 text-white text-sm font-bold rounded-md hover:bg-green-600 transition-colors">
                                            Download Certificate
                                        </a>
                                    @elseif($submission->status === 'Rejected')
                                         <span class="inline-block px-4 py-2 bg-red-100 dark:bg-red-800/50 text-red-800 dark:text-red-300 text-sm font-bold rounded-md">Not Shortlisted</span>
                                    @else
                                         <span class="inline-block px-4 py-2 bg-blue-100 dark:bg-blue-800/50 text-blue-800 dark:text-blue-300 text-sm font-bold rounded-md">{{ $currentStatus }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- THE LAYOUT FIX: Stepper Progress Bar -->
                            <div class="w-full">
                                <div class="flex">
                                    @foreach($stages as $stage)
                                        <!-- Step Item -->
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <!-- Step Circle -->
                                                <div class="flex-shrink-0">
                                                    @if($stage['complete'])
                                                        <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        </div>
                                                    @else
                                                        <div class="w-8 h-8 rounded-full border-2 {{ $stage['current'] ? 'border-brand-primary' : 'border-gray-300 dark:border-gray-600' }}"></div>
                                                    @endif
                                                </div>
                                                <!-- Connector Line -->
                                                @if(!$loop->last)
                                                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $stage['complete'] ? 'border-green-500' : 'border-gray-300 dark:border-gray-600' }}"></div>
                                                @endif
                                            </div>
                                            <!-- Label -->
                                            <div class="mt-2 text-xs font-medium uppercase {{ $stage['complete'] ? 'text-green-500' : ($stage['current'] ? 'text-brand-primary' : 'text-gray-500 dark:text-gray-400') }}">
                                                {{ $stage['label'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" /></svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">No submissions</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by submitting a new project idea.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>