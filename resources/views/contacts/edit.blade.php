<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-semibold text-gray-800 mb-0 d-flex align-items-center">
                <i class="fas fa-edit me-2 text-warning"></i>{{ __('Edit Contact') }}: {{ $contact->name }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('contacts.show', $contact->id) }}"
                    class="btn btn-secondary btn-sm d-flex align-items-center">
                    <i class="fas fa-eye me-2"></i>View
                </a>
                <a href="{{ route('contacts.index') }}"
                    class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="card shadow-sm">
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

                    <form action="{{ route('contacts.update', $contact->id) }}" method="POST" id="editForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Name Field -->
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-medium">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $contact->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter full name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Field -->
                            <div class="col-md-6">
                                <label for="contact" class="form-label fw-medium">
                                    Contact Number <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="contact" id="contact"
                                    value="{{ old('contact', $contact->contact) }}" maxlength="9"
                                    class="form-control @error('contact') is-invalid @enderror"
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
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $contact->email) }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Enter email address" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address Field -->
                            <div class="col-12">
                                <label for="address" class="form-label fw-medium">
                                    Address
                                </label>
                                <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Enter full address">{{ old('address', $contact->address) }}</textarea>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    @error('address')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @else
                                        <div class="form-text">Maximum 500 characters</div>
                                    @enderror
                                    <div id="address-counter" class="text-muted small">0/500</div>
                                </div>
                            </div>

                            <!-- Updated At Info -->
                            <div class="col-12">
                                <div class="alert alert-info d-flex align-items-center mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <div class="small">
                                        <strong>Last updated:</strong>
                                        {{ $contact->updated_at->format('M d, Y h:i A') }}
                                        @if ($contact->updated_at != $contact->created_at)
                                            <br>
                                            <strong>Created:</strong>
                                            {{ $contact->created_at->format('M d, Y h:i A') }}
                                        @endif
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
                                <button type="reset" class="btn btn-outline-warning d-flex align-items-center">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-warning d-flex align-items-center">
                                    <i class="fas fa-save me-2"></i>Update Contact
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
                    } else {
                        addressCounter.classList.remove('text-danger', 'fw-bold');
                        addressCounter.classList.add('text-muted');
                        addressTextarea.classList.remove('is-invalid');
                    }
                }

                addressTextarea.addEventListener('input', updateCounter);
                updateCounter(); // Initial call
            }

            // Form validation enhancement
            const editForm = document.getElementById('editForm');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    const contactValue = contactInput.value;
                    if (contactValue.length !== 9) {
                        e.preventDefault();
                        contactInput.classList.add('is-invalid');
                        contactInput.focus();

                        // Create or update error message
                        let errorDiv = contactInput.nextElementSibling;
                        if (!errorDiv.classList.contains('invalid-feedback')) {
                            errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            contactInput.parentNode.insertBefore(errorDiv, contactInput.nextSibling);
                        }
                        errorDiv.textContent = 'Contact number must be exactly 9 digits.';
                    }
                });
            }

            // Auto-focus on name field
            document.getElementById('name')?.focus();
        });
    </script>
@endpush
