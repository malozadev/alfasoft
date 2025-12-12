<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-semibold text-gray-800 mb-0 d-flex align-items-center">
                <i class="fas fa-plus-circle me-2 text-success"></i>{{ __('Create New Contact') }}
            </h2>
            <a href="{{ route('contacts.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="fas fa-user-plus me-2 text-primary"></i>Contact Information
                    </h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
                                <div>
                                    <strong class="fw-bold">Please correct the following errors:</strong>
                                    <ul class="mb-0 mt-1 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('contacts.store') }}" method="POST" id="contactForm">
                        @csrf

                        <div class="row g-3">
                            <!-- Name Field -->
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-medium">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter full name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="form-text">Minimum 5 characters required</div>
                                @enderror
                            </div>

                            <!-- Contact Field -->
                            <div class="col-md-6">
                                <label for="contact" class="form-label fw-medium">
                                    Contact Number <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="contact" id="contact" value="{{ old('contact') }}"
                                    maxlength="9" class="form-control @error('contact') is-invalid @enderror"
                                    placeholder="Enter 9-digit contact number" required>
                                @error('contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="form-text">Exactly 9 digits required</div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-medium">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Enter email address" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address Field -->
                            <div class="col-12">
                                <label for="address" class="form-label fw-medium">
                                    Address <span class="text-danger">*</span> <!-- Adicionado asterisco -->
                                </label>
                                <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Enter full address" required>{{ old('address') }}</textarea> <!-- Removido (optional) e adicionado required -->
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    @error('address')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @else
                                        <div class="form-text">Minimum 5 characters, maximum 500 characters</div>
                                        <!-- Atualizada a mensagem -->
                                    @enderror
                                    <div id="address-counter" class="text-muted small">0/500</div>
                                </div>
                            </div>

                            <!-- Form Guidelines -->
                            <div class="col-12">
                                <div class="alert alert-light border d-flex mb-0">
                                    <div class="me-3">
                                        <i class="fas fa-lightbulb text-warning fs-4"></i>
                                    </div>
                                    <div class="small">
                                        <strong>Guidelines:</strong>
                                        <ul class="mb-0 mt-1">
                                            <li>All fields marked with <span class="text-danger">*</span> are required
                                            </li>
                                            <li>Name must be at least 5 characters long</li>
                                            <li>Contact number must be exactly 9 digits</li>
                                            <li>Email must be unique and valid</li>
                                            <li>Address must be at least 5 characters and maximum 500 characters</li>
                                            <!-- Atualizada a mensagem -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="{{ route('contacts.index') }}"
                                class="btn btn-outline-secondary d-flex align-items-center">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-outline-danger d-flex align-items-center">
                                    <i class="fas fa-redo me-2"></i>Clear Form
                                </button>
                                <button type="submit" class="btn btn-success d-flex align-items-center">
                                    <i class="fas fa-save me-2"></i>Create Contact
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Allow only numbers in contact field
            const contactInput = document.getElementById('contact');
            if (contactInput) {
                contactInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            // Address character counter
            const addressTextarea = document.getElementById('address');
            const addressCounter = document.getElementById('address-counter');

            if (addressTextarea && addressCounter) {
                function updateCounter() {
                    const length = addressTextarea.value.length;
                    addressCounter.textContent = `${length}/500`;

                    if (length > 500) {
                        addressCounter.classList.remove('text-muted');
                        addressCounter.classList.add('text-danger', 'fw-bold');
                        addressTextarea.classList.add('is-invalid');
                    } else if (length > 0 && length < 5) {
                        addressCounter.classList.remove('text-muted');
                        addressCounter.classList.add('text-warning', 'fw-bold');
                        addressTextarea.classList.add('is-invalid');
                    } else if (length >= 5 && length <= 500) {
                        addressCounter.classList.remove('text-danger', 'text-warning', 'fw-bold');
                        addressCounter.classList.add('text-muted');
                        addressTextarea.classList.remove('is-invalid');
                    } else {
                        addressCounter.classList.remove('text-danger', 'text-warning', 'fw-bold');
                        addressCounter.classList.add('text-muted');
                        addressTextarea.classList.remove('is-invalid');
                    }
                }

                addressTextarea.addEventListener('input', updateCounter);
                updateCounter(); // Initial call
            }

            // Form validation enhancement
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    let hasError = false;

                    // Validate contact length
                    if (contactInput && contactInput.value.length !== 9) {
                        e.preventDefault();
                        contactInput.classList.add('is-invalid');
                        if (!hasError) {
                            contactInput.focus();
                            hasError = true;
                        }

                        let errorDiv = contactInput.nextElementSibling;
                        if (!errorDiv.classList.contains('invalid-feedback')) {
                            errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            contactInput.parentNode.insertBefore(errorDiv, contactInput.nextSibling);
                        }
                        errorDiv.textContent = 'Contact number must be exactly 9 digits.';
                    }

                    // Validate name length
                    const nameInput = document.getElementById('name');
                    if (nameInput && nameInput.value.length < 5) {
                        e.preventDefault();
                        nameInput.classList.add('is-invalid');
                        if (!hasError) {
                            nameInput.focus();
                            hasError = true;
                        }

                        let errorDiv = nameInput.nextElementSibling;
                        if (!errorDiv.classList.contains('invalid-feedback')) {
                            errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            nameInput.parentNode.insertBefore(errorDiv, nameInput.nextSibling);
                        }
                        errorDiv.textContent = 'Name must be at least 5 characters long.';
                    }

                    // Validate address length
                    if (addressTextarea && addressTextarea.value.length < 5) {
                        e.preventDefault();
                        addressTextarea.classList.add('is-invalid');
                        if (!hasError) {
                            addressTextarea.focus();
                            hasError = true;
                        }

                        let errorDiv = addressTextarea.parentNode.querySelector('.invalid-feedback');
                        if (!errorDiv) {
                            errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback d-block';
                            addressTextarea.parentNode.insertBefore(errorDiv, addressTextarea
                                .nextElementSibling);
                        }
                        errorDiv.textContent = 'Address must be at least 5 characters long.';
                    }
                });
            }

            // Auto-focus on name field
            document.getElementById('name')?.focus();

            // Real-time validation for name field
            const nameInput = document.getElementById('name');
            if (nameInput) {
                nameInput.addEventListener('input', function() {
                    if (this.value.length >= 5) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else if (this.value.length > 0 && this.value.length < 5) {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    } else {
                        this.classList.remove('is-invalid', 'is-valid');
                    }
                });
            }

            // Real-time validation for contact field
            if (contactInput) {
                contactInput.addEventListener('input', function() {
                    if (this.value.length === 9) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else if (this.value.length > 0 && this.value.length !== 9) {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    } else {
                        this.classList.remove('is-invalid', 'is-valid');
                    }
                });
            }

            // Real-time validation for email field
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.addEventListener('input', function() {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (emailPattern.test(this.value)) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else if (this.value.length > 0) {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    } else {
                        this.classList.remove('is-invalid', 'is-valid');
                    }
                });
            }

            // Real-time validation for address field
            if (addressTextarea) {
                addressTextarea.addEventListener('input', function() {
                    if (this.value.length >= 5 && this.value.length <= 500) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else if (this.value.length > 0 && this.value.length < 5) {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    } else if (this.value.length > 500) {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    } else {
                        this.classList.remove('is-invalid', 'is-valid');
                    }
                });
            }
        });
    </script>
@endpush
