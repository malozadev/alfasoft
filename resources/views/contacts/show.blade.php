<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-semibold text-gray-800 mb-0 d-flex align-items-center">
                <i class="fas fa-user-circle me-2 text-info"></i>{{ __('Contact Details') }}
            </h2>
            <div class="d-flex gap-2 align-items-center">
                <span class="badge bg-info text-dark rounded-pill">
                    <i class="fas fa-hashtag me-1"></i>ID: {{ $contact->id }}
                </span>
                <a href="{{ route('contacts.index') }}"
                    class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid px-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2 fs-5"></i>
                        <div>
                            <strong class="fw-bold">Success!</strong>
                            <span class="ms-2">{{ session('success') }}</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Contact Header -->
                    <div class="d-flex align-items-start mb-4 pb-3 border-bottom">
                        <div class="flex-shrink-0 me-4">
                            <div class="bg-info bg-opacity-10 rounded-circle p-4">
                                <i class="fas fa-user text-info fs-2"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="h2 fw-bold text-gray-900 mb-1">{{ $contact->name }}</h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i>Contact Information
                            </p>
                            <div class="mt-2">
                                <span class="badge bg-light text-dark border me-2">
                                    <i class="fas fa-calendar-plus me-1"></i>
                                    Created {{ $contact->created_at->diffForHumans() }}
                                </span>
                                @if ($contact->updated_at != $contact->created_at)
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        Updated {{ $contact->updated_at->diffForHumans() }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="row g-4">
                        <!-- Email Card -->
                        <div class="col-md-6">
                            <div class="card h-100 border">
                                <div class="card-header bg-light d-flex align-items-center">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <strong class="card-title mb-0">Email Address</strong>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fas fa-at text-muted fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <a href="mailto:{{ $contact->email }}"
                                                class="text-decoration-none text-primary fw-medium d-block mb-1">
                                                {{ $contact->email }}
                                            </a>
                                            <small class="text-muted">Click to send email</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Number Card -->
                        <div class="col-md-6">
                            <div class="card h-100 border">
                                <div class="card-header bg-light d-flex align-items-center">
                                    <i class="fas fa-phone text-success me-2"></i>
                                    <strong class="card-title mb-0">Contact Number</strong>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fas fa-mobile-alt text-muted fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="fw-medium text-dark d-block mb-1 fs-5">
                                                {{ $contact->contact }}
                                            </span>
                                            <small class="text-muted">9-digit contact number</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Card (if exists) -->
                        @if ($contact->address)
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header bg-light d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-warning me-2"></i>
                                        <strong class="card-title mb-0">Address</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="fas fa-home text-muted fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-0 text-dark">{{ $contact->address }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Metadata Card -->
                        <div class="col-12">
                            <div class="card border">
                                <div class="card-header bg-light d-flex align-items-center">
                                    <i class="fas fa-history text-secondary me-2"></i>
                                    <strong class="card-title mb-0">Record Information</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-calendar-plus text-success me-2"></i>
                                                <span class="fw-medium me-2">Created:</span>
                                            </div>
                                            <div class="ms-4">
                                                <div class="text-dark">{{ $contact->created_at->format('F d, Y') }}
                                                </div>
                                                <small
                                                    class="text-muted">{{ $contact->created_at->format('h:i A') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-calendar-check text-primary me-2"></i>
                                                <span class="fw-medium me-2">Last Updated:</span>
                                            </div>
                                            <div class="ms-4">
                                                <div class="text-dark">{{ $contact->updated_at->format('F d, Y') }}
                                                </div>
                                                <small
                                                    class="text-muted">{{ $contact->updated_at->format('h:i A') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('contacts.index') }}"
                                    class="btn btn-outline-secondary d-flex align-items-center">
                                    <i class="fas fa-list me-2"></i>View All Contacts
                                </a>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('contacts.edit', $contact->id) }}"
                                    class="btn btn-warning d-flex align-items-center">
                                    <i class="fas fa-edit me-2"></i>Edit Contact
                                </a>
                                <button type="button"
                                    onclick="return confirmDelete({{ $contact->id }}, '{{ addslashes($contact->name) }}')"
                                    class="btn btn-danger d-flex align-items-center">
                                    <i class="fas fa-trash me-2"></i>Delete Contact
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card shadow-sm mt-4 border">
                <div class="card-header bg-light">
                    <h6 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-bolt text-warning me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="mailto:{{ $contact->email }}"
                                class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-paper-plane me-2"></i>Send Email
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="tel:{{ $contact->contact }}"
                                class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-phone-alt me-2"></i>Call Contact
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('contacts.create') }}"
                                class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-plus me-2"></i>Add New Contact
                            </a>
                        </div>
                    </div>
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

        // Copy to clipboard functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add copy buttons to contact info
            const emailElement = document.querySelector('a[href^="mailto:"]');
            const contactElement = document.querySelector('.card-body .fw-medium.text-dark');

            if (emailElement) {
                const copyEmailBtn = document.createElement('button');
                copyEmailBtn.className = 'btn btn-sm btn-outline-secondary ms-2';
                copyEmailBtn.innerHTML = '<i class="fas fa-copy"></i>';
                copyEmailBtn.title = 'Copy email';
                copyEmailBtn.onclick = function(e) {
                    e.preventDefault();
                    navigator.clipboard.writeText('{{ $contact->email }}').then(() => {
                        const originalHTML = copyEmailBtn.innerHTML;
                        copyEmailBtn.innerHTML = '<i class="fas fa-check"></i>';
                        copyEmailBtn.classList.remove('btn-outline-secondary');
                        copyEmailBtn.classList.add('btn-success');
                        setTimeout(() => {
                            copyEmailBtn.innerHTML = originalHTML;
                            copyEmailBtn.classList.remove('btn-success');
                            copyEmailBtn.classList.add('btn-outline-secondary');
                        }, 2000);
                    });
                };
                emailElement.parentNode.appendChild(copyEmailBtn);
            }

            if (contactElement) {
                const copyContactBtn = document.createElement('button');
                copyContactBtn.className = 'btn btn-sm btn-outline-secondary ms-2';
                copyContactBtn.innerHTML = '<i class="fas fa-copy"></i>';
                copyContactBtn.title = 'Copy contact number';
                copyContactBtn.onclick = function() {
                    navigator.clipboard.writeText('{{ $contact->contact }}').then(() => {
                        const originalHTML = copyContactBtn.innerHTML;
                        copyContactBtn.innerHTML = '<i class="fas fa-check"></i>';
                        copyContactBtn.classList.remove('btn-outline-secondary');
                        copyContactBtn.classList.add('btn-success');
                        setTimeout(() => {
                            copyContactBtn.innerHTML = originalHTML;
                            copyContactBtn.classList.remove('btn-success');
                            copyContactBtn.classList.add('btn-outline-secondary');
                        }, 2000);
                    });
                };
                contactElement.parentNode.appendChild(copyContactBtn);
            }
        });
    </script>
</x-app-layout>
