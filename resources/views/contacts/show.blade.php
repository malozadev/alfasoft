<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-user-circle mr-2"></i>{{ __('Contact Details') }}
            </h2>
            <div class="flex space-x-2">
                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    ID: #{{ $contact->id }}
                </span>
                <a href="{{ route('contacts.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">
                        <i class="fas fa-check-circle mr-2"></i>Success!
                    </strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Contact Header -->
                    <div class="flex items-start space-x-4 mb-8">
                        <div class="flex-shrink-0">
                            <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $contact->name }}</h3>
                            <p class="text-gray-600">Contact Information</p>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="space-y-6">
                        <!-- Email -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Email Address</label>
                            <div class="mt-1 flex items-center">
                                <i class="fas fa-envelope text-gray-400 mr-3"></i>
                                <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $contact->email }}
                                </a>
                            </div>
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Contact Number</label>
                            <div class="mt-1 flex items-center">
                                <i class="fas fa-phone text-gray-400 mr-3"></i>
                                <span class="text-gray-900">{{ $contact->contact }}</span>
                            </div>
                        </div>

                        <!-- Address -->
                        @if($contact->address)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Address</label>
                            <div class="mt-1 flex">
                                <i class="fas fa-map-marker-alt text-gray-400 mr-3 mt-1"></i>
                                <p class="text-gray-900">{{ $contact->address }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Metadata -->
                        <div class="pt-6 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                                <div>
                                    <i class="fas fa-calendar-plus mr-2"></i>
                                    Created: {{ $contact->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div>
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Last Updated: {{ $contact->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
                        <a href="{{ route('contacts.edit', $contact->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:border-yellow-900 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>

                        <button type="button"
                                onclick="confirmDelete({{ $contact->id }}, '{{ addslashes($contact->name) }}')"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-trash mr-2"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        function confirmDelete(id, name) {
            if (confirm(`Are you sure you want to delete the contact "${name}"? This action cannot be undone.`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/contacts/${id}`;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
    @endsection
</x-app-layout>
