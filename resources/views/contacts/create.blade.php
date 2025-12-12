<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-plus-circle mr-2"></i>{{ __('Create New Contact') }}
            </h2>
            <a href="{{ route('contacts.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">
                                <i class="fas fa-exclamation-triangle mr-2"></i>Please correct the following errors:
                            </strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contacts.store') }}" method="POST" id="contactForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 required-field">
                                    Full Name
                                </label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value="{{ old('name') }}"
                                       class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm @error('name') border-red-300 @enderror"
                                       placeholder="Enter full name (min. 5 characters)"
                                       required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @else
                                    <p class="mt-2 text-sm text-gray-500">Minimum 5 characters required</p>
                                @enderror
                            </div>

                            <!-- Contact Field -->
                            <div>
                                <label for="contact" class="block text-sm font-medium text-gray-700 required-field">
                                    Contact Number
                                </label>
                                <input type="text"
                                       name="contact"
                                       id="contact"
                                       value="{{ old('contact') }}"
                                       maxlength="9"
                                       class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm @error('contact') border-red-300 @enderror"
                                       placeholder="Enter 9-digit number"
                                       required>
                                @error('contact')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @else
                                    <p class="mt-2 text-sm text-gray-500">Exactly 9 digits required</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 required-field">
                                    Email Address
                                </label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ old('email') }}"
                                       class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm @error('email') border-red-300 @enderror"
                                       placeholder="Enter valid email address"
                                       required>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address Field -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">
                                    Address
                                </label>
                                <textarea name="address"
                                          id="address"
                                          rows="3"
                                          class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm @error('address') border-red-300 @enderror"
                                          placeholder="Enter address (optional)">{{ old('address') }}</textarea>
                                <div class="flex justify-between items-center mt-2">
                                    @error('address')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @else
                                        <p class="text-sm text-gray-500">Maximum 500 characters</p>
                                    @enderror
                                    <div id="address-counter" class="text-sm text-gray-500">0/500</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <i class="fas fa-save mr-2"></i>Create Contact
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
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
                        addressCounter.classList.remove('text-gray-500');
                        addressCounter.classList.add('text-red-600');
                    } else {
                        addressCounter.classList.remove('text-red-600');
                        addressCounter.classList.add('text-gray-500');
                    }
                }

                addressTextarea.addEventListener('input', updateCounter);
                updateCounter(); // Initial call
            }

            // Required field indicator
            const style = document.createElement('style');
            style.textContent = '.required-field::after { content: " *"; color: #dc3545; }';
            document.head.appendChild(style);
        });
    </script>
    @endsection
</x-app-layout>
