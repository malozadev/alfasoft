<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-0">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <i class="fas fa-address-book mr-2 text-blue-600"></i>
                {{ __('Contact Manager') }}
            </h2>

            <div class="flex flex-wrap gap-2 items-center">
                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    {{ $contacts->total() }} Contacts
                </span>
                @auth
                    <a href="{{ route('contacts.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring focus:ring-blue-300 transition duration-150">
                        <i class="fas fa-plus mr-2"></i>New Contact
                    </a>
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensagens de sucesso ou erro --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Caso não haja contatos --}}
                @if ($contacts->isEmpty())
                    <div class="text-center py-12">
                        <i class="fas fa-address-book text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No contacts found</h3>
                        <p class="text-gray-500 mb-6">Start by adding your first contact</p>
                        @auth
                            <a href="{{ route('contacts.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring focus:ring-blue-300 transition duration-150">
                                <i class="fas fa-plus mr-2"></i>Create First Contact
                            </a>
                        @endauth
                    </div>
                @else
                    {{-- Search Form --}}
                    <div class="mb-6">
                        <form action="{{ route('contacts.index') }}" method="GET" class="flex max-w-md mx-auto sm:mx-0">
                            <input type="text"
                                   name="search"
                                   class="flex-1 rounded-l-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-3 py-2"
                                   placeholder="Search contacts..."
                                   value="{{ request('search') }}">
                            <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                    @auth
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    @endauth
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($contacts as $contact)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">#{{ $contact->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">{{ $contact->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $contact->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $contact->contact }}</td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ Str::limit($contact->address, 30, '...') ?? 'No address' }}
                                        </td>
                                        @auth
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('contacts.show', $contact->id) }}"
                                                       class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                                                        <i class="fas fa-eye mr-1"></i>View
                                                    </a>
                                                    <a href="{{ route('contacts.edit', $contact->id) }}"
                                                       class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-medium rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition duration-150">
                                                        <i class="fas fa-edit mr-1"></i>Edit
                                                    </a>
                                                    <button onclick="confirmDelete({{ $contact->id }}, '{{ addslashes($contact->name) }}')"
                                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150">
                                                        <i class="fas fa-trash mr-1"></i>Delete
                                                    </button>
                                                </div>
                                            </td>
                                        @endauth
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginação --}}
                    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="text-sm text-gray-700 mb-2 sm:mb-0">
                            Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} of {{ $contacts->total() }} results
                        </div>
                        <div>
                            {{ $contacts->links() }}
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Mova o script para fora do x-app-layout e use @push --}}
@push('scripts')
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
@endpush
