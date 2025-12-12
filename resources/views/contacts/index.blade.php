@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <h2 class="h4 fw-semibold text-gray-800 mb-0 d-flex align-items-center">
                <i class="fas fa-address-book me-2 text-primary"></i>
                {{ __('Contact Manager') }}
            </h2>

            <div class="d-flex flex-wrap gap-2 align-items-center">
                <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill fs-6">
                    {{ $contacts->total() }} Contacts
                </span>
                @auth
                    <a href="{{ route('contacts.create') }}" class="btn btn-primary btn-sm d-flex align-items-center">
                        <i class="fas fa-plus me-1"></i>New Contact
                    </a>
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">

            {{-- Mensagens de sucesso ou erro --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4"
                    role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4"
                    role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">

                    {{-- Caso não haja contatos --}}
                    @if ($contacts->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-address-book text-muted mb-3" style="font-size: 4rem;"></i>
                            <h3 class="h5 fw-medium text-gray-900 mb-2">No contacts found</h3>
                            <p class="text-muted mb-4">Start by adding your first contact</p>
                            @auth
                                <a href="{{ route('contacts.create') }}"
                                    class="btn btn-primary d-inline-flex align-items-center">
                                    <i class="fas fa-plus me-2"></i>Create First Contact
                                </a>
                            @endauth
                        </div>
                    @else
                        {{-- Table --}}
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-nowrap">ID</th>
                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">Email</th>
                                        <th class="text-nowrap">Contact</th>
                                        <th class="text-nowrap">Address</th>
                                        @auth
                                            <th class="text-nowrap text-center">Actions</th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $contact)
                                        <tr>
                                            <td class="text-nowrap">
                                                <span class="badge bg-secondary">#{{ $contact->id }}</span>
                                            </td>
                                            <td class="text-nowrap fw-medium">{{ $contact->name }}</td>
                                            <td class="text-nowrap text-muted">{{ $contact->email }}</td>
                                            <td class="text-nowrap text-muted">{{ $contact->contact }}</td>
                                            <td class="text-muted">
                                                {{ Str::limit($contact->address, 30, '...') ?? 'No address' }}
                                            </td>
                                            @auth
                                                <td class="text-nowrap">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('contacts.show', $contact->id) }}"
                                                            class="btn btn-info btn-sm d-flex align-items-center">
                                                            <i class="fas fa-eye me-1"></i>View
                                                        </a>
                                                        <a href="{{ route('contacts.edit', $contact->id) }}"
                                                            class="btn btn-warning btn-sm d-flex align-items-center">
                                                            <i class="fas fa-edit me-1"></i>Edit
                                                        </a>
                                                        <button
                                                            onclick="return confirmDelete({{ $contact->id }}, '{{ addslashes($contact->name) }}')"
                                                            class="btn btn-danger btn-sm d-flex align-items-center">
                                                            <i class="fas fa-trash me-1"></i>Delete
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
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
                            <div class="text-muted small mb-2 mb-md-0">
                                Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} of
                                {{ $contacts->total() }} results
                            </div>
                            <div>
                                {{ $contacts->links() }}
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Script inline para evitar problemas com @push --}}
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
            return false;
        }
    </script>
</x-app-layout>
