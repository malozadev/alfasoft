<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fas fa-address-book mr-3 text-indigo-600"></i>{{ __('Contact Manager') }}
            </h2>
            <div class="flex space-x-3 items-center">
                <span class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-semibold shadow-sm">
                    {{ $contacts->total() }} Contacts
                </span>

                @auth
                    <a href="{{ route('contacts.create') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wider shadow-lg hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-4 focus:ring-indigo-300 transition duration-150 ease-in-out transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>{{ __('New Contact') }}
                    </a>
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-md" role="alert">
                    <strong class="font-bold">
                        <i class="fas fa-check-circle mr-2"></i>Success!
                    </strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg shadow-md" role="alert">
                    <strong class="font-bold">
                        <i class="fas fa-exclamation-circle mr-2"></i>Error!
                    </strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($contacts->isEmpty())
                        <div class="text-center py-16">
                            <i class="fas fa-address-book text-gray-300 text-7xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No contacts found</h3>
                            <p class="text-gray-500 mb-8">
                                @auth
                                    Start by adding your first contact
                                @else
                                    No contacts to display. Please log in to manage them.
                                @endauth
                            </p>

                            @auth
                                <a href="{{ route('contacts.create') }}"
                                   class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wider shadow-lg hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-4 focus:ring-indigo-300 transition duration-150 ease-in-out transform hover:scale-105">
                                    <i class="fas fa-plus mr-2"></i>Create First Contact
                                </a>
                            @endauth
                        </div>
                    @else
                        <div class="mb-8">
                            <form action="{{ route('contacts.index') }}" method="GET" class="flex max-w-lg">
                                <input type="text"
                                       name="search"
                                       class="rounded-l-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 flex-1 shadow-sm p-3"
                                       placeholder="Search contacts..."
                                       value="{{ request('search') }}">
                                <button type="submit"
                                        class="bg-indigo-600 text-white px-6 py-3 rounded-r-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>

                        <div class="overflow-x-auto border border-gray-100 rounded-xl shadow-md">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Address</th>

                                        @auth
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($contacts as $contact)
                                        <tr class="hover:bg-indigo-50/50 transition duration-100">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    #{{ $contact->id }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $contact->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-700">{{ $contact->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                {{ $contact->contact }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-700">
                                                    @if($contact->address)
                                                        {{ Str::limit($contact->address, 30) }}
                                                    @else
                                                        <span class="text-gray-400 italic">No address</span>
                                                    @endif
                                                </div>
                                            </td>

                                            @auth
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex space-x-2 items-center">

                                                        <a href="{{ route('contacts.show', $contact->id) }}"
                                                           class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-500 text-white shadow-md hover:bg-blue-600 transition duration-150 hover:scale-105"
                                                           title="View Details">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </a>

                                                        <a href="{{ route('contacts.edit', $contact->id) }}"
                                                           class="w-8 h-8 flex items-center justify-center rounded-full bg-yellow-500 text-white shadow-md hover:bg-yellow-600 transition duration-150 hover:scale-105"
                                                           title="Edit">
                                                            <i class="fas fa-edit text-xs"></i>
                                                        </a>

                                                        <button type="button"
                                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-red-500 text-white shadow-md hover:bg-red-600 transition duration-150 hover:scale-105"
                                                                title="Delete"
                                                                onclick="confirmDelete({{ $contact->id }}, '{{ addslashes($contact->name) }}')">
                                                            <i class="fas fa-trash text-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            @endauth

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8">
                            <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow-inner">
                                <div class="text-sm text-gray-600 font-medium">
                                    Showing <span class="font-semibold">{{ $contacts->firstItem() }}</span> to <span class="font-semibold">{{ $contacts->lastItem() }}</span> of <span class="font-semibold">{{ $contacts->total() }}</span> results
                                </div>
                                <div>
                                    {{ $contacts->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @auth
        <script>
            function confirmDelete(id, name) {
                // Additional security check before confirmation
                if (confirm(`Are you sure you want to delete the contact "${name}"? This action cannot be undone.`)) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/contacts/${id}`;

                    // Get the CSRF token.
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
        @endauth
    @endpush
</x-app-layout>
