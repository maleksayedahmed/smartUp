<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('user.components.head')

<style>
    .testimonial-nav-btn {
        display: none !important;
    }

    /* Custom styles for intl-tel-input */
    .iti {
        width: 100%;
    }

    .iti__country-list {
        z-index: 9999; /* Ensure dropdown appears above modal */
    }

    .iti__selected-flag {
        padding: 0 8px;
    }

    .iti input[type="tel"] {
        width: 100%;
        padding: 0.375rem 0.75rem;
        padding-left: 52px;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        font-size: 1rem;
        line-height: 1.5;
    }

    .iti input[type="tel"]:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .iti input[type="tel"].is-invalid {
        border-color: #dc3545;
    }

    .iti input[type="tel"].is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }
</style>

<body class="{{ $body ?? '' }}">
    @yield('content')

    <!-- Consultation Modal -->
    <div class="modal fade" id="consultationModal" tabindex="-1" aria-labelledby="consultationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="consultationModalLabel">{{ __('components.header.book_consultation') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="consultationForm">
                        @csrf
                        <div class="mb-3">
                            <label for="consultationName" class="form-label">{{ __('validation.attributes.name') }}
                                *</label>
                            <input type="text" class="form-control" id="consultationName" name="name" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="consultationPhone" class="form-label">{{ __('validation.attributes.phone') }}
                                *</label>
                            <input type="tel" class="form-control" id="consultationPhone" name="phone" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="consultationEmail"
                                class="form-label">{{ __('validation.attributes.email') }}</label>
                            <input type="email" class="form-control" id="consultationEmail" name="email">
                            <div class="invalid-feedback"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ app()->getLocale() == 'ar' ? 'إغلاق' : 'Close' }}</button>
                    <button type="button" class="btn btn-primary"
                        onclick="submitConsultation()">{{ app()->getLocale() == 'ar' ? 'إرسال' : 'Submit' }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media Floating Buttons -->

    @include('user.components.footer')

    @include('user.components.whatsapp')

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- International Telephone Input CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">

    <!-- International Telephone Input JS -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script src="{{ asset('assets/js/forms.js') }}"></script>

    <!-- Consultation Modal Script -->
    <script>
        let phoneInput;

        function openConsultationModal() {
            const modal = new bootstrap.Modal(document.getElementById('consultationModal'));
            modal.show();

            // Initialize phone input after modal is shown
            modal._element.addEventListener('shown.bs.modal', function () {
                if (!phoneInput) {
                    initializePhoneInput();
                }
            });
        }

        function initializePhoneInput() {
            const phoneInputElement = document.querySelector('#consultationPhone');

            phoneInput = window.intlTelInput(phoneInputElement, {
                initialCountry: "{{ app()->getLocale() == 'ar' ? 'sa' : 'auto' }}", // Default to Egypt for Arabic, auto-detect for others
                geoIpLookup: function(callback) {
                    fetch('https://ipapi.co/json')
                        .then(function(res) { return res.json(); })
                        .then(function(data) { callback(data.country_code); })
                        .catch(function() { callback('eg'); }); // Fallback to Egypt
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
                preferredCountries: ['sa', 'eg', 'ae', 'us', 'gb'],
                separateDialCode: true,
                formatOnDisplay: true,
                autoPlaceholder: "aggressive",
                placeholderNumberType: "MOBILE"
            });

            // Add validation on blur
            phoneInputElement.addEventListener('blur', function() {
                if (phoneInput.isValidNumber()) {
                    phoneInputElement.classList.remove('is-invalid');
                    phoneInputElement.classList.add('is-valid');
                } else if (phoneInputElement.value.trim() !== '') {
                    phoneInputElement.classList.add('is-invalid');
                    phoneInputElement.classList.remove('is-valid');
                    const feedback = phoneInputElement.closest('.mb-3').querySelector('.invalid-feedback');
                    feedback.textContent = '{{ app()->getLocale() == "ar" ? "رقم الهاتف غير صحيح" : "Invalid phone number" }}';
                }
            });

            // Clear validation on input
            phoneInputElement.addEventListener('input', function() {
                phoneInputElement.classList.remove('is-invalid', 'is-valid');
                const feedback = phoneInputElement.closest('.mb-3').querySelector('.invalid-feedback');
                feedback.textContent = '';
            });
        }

        function submitConsultation() {
            const form = document.getElementById('consultationForm');
            const formData = new FormData(form);

            // Get the full international number from intl-tel-input
            if (phoneInput) {
                const fullNumber = phoneInput.getNumber();
                formData.set('phone', fullNumber);
            }

            // Clear previous validation errors
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

            // Validate phone number before submitting
            if (phoneInput && !phoneInput.isValidNumber()) {
                const phoneInputElement = document.querySelector('#consultationPhone');
                phoneInputElement.classList.add('is-invalid');
                const feedback = phoneInputElement.closest('.mb-3').querySelector('.invalid-feedback');
                feedback.textContent = '{{ app()->getLocale() == "ar" ? "يرجى إدخال رقم هاتف صحيح" : "Please enter a valid phone number" }}';
                return;
            }

            fetch('{{ route('consultation.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('consultationModal'));
                        modal.hide();

                        // Clear form and reset phone input
                        form.reset();
                        if (phoneInput) {
                            phoneInput.setNumber('');
                        }

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: '{{ app()->getLocale() == 'ar' ? 'تم بنجاح!' : 'Success!' }}',
                            text: data.message,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: '{{ app()->getLocale() == 'ar' ? 'موافق' : 'OK' }}'
                        });
                    } else {
                        // Handle validation errors
                        if (data.errors) {
                            Object.keys(data.errors).forEach(field => {
                                let input;
                                if (field === 'phone') {
                                    input = document.querySelector('#consultationPhone');
                                } else {
                                    input = document.querySelector(`[name="${field}"]`);
                                }

                                if (input) {
                                    const feedback = input.closest('.mb-3').querySelector('.invalid-feedback');
                                    input.classList.add('is-invalid');
                                    feedback.textContent = data.errors[field][0];
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ app()->getLocale() == 'ar' ? 'خطأ!' : 'Error!' }}',
                                text: data.message,
                                confirmButtonColor: '#d33',
                                confirmButtonText: '{{ app()->getLocale() == 'ar' ? 'موافق' : 'OK' }}'
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: '{{ app()->getLocale() == 'ar' ? 'خطأ!' : 'Error!' }}',
                        text: '{{ app()->getLocale() == 'ar' ? 'حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.' : 'An unexpected error occurred. Please try again.' }}',
                        confirmButtonColor: '#d33',
                        confirmButtonText: '{{ app()->getLocale() == 'ar' ? 'موافق' : 'OK' }}'
                    });
                });
        }

        // Clean up phone input when modal is hidden
        document.getElementById('consultationModal').addEventListener('hidden.bs.modal', function () {
            if (phoneInput) {
                phoneInput.destroy();
                phoneInput = null;
            }
        });
    </script>

    @yield('scripts')

</body>

</html>
