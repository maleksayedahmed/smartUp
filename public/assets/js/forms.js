// Form submission handling
document.addEventListener('DOMContentLoaded', function() {
    // Contact form submission
    const contactForms = document.querySelectorAll('.contact-form');
    contactForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            submitContactForm(this);
        });
    });
});

// Submit contact form
function submitContactForm(form) {
    const submitBtn = form.querySelector('.contact-submit-btn');
    const originalText = submitBtn.querySelector('span').textContent;

    // Disable button and show loading
    submitBtn.disabled = true;
    submitBtn.querySelector('span').textContent = 'جاري الإرسال...';

    const formData = new FormData(form);

    // Debug: log form field values to the console to verify they are populated
    try {
        const entries = {};
        for (const pair of formData.entries()) {
            entries[pair[0]] = pair[1];
        }
        console.debug('Submitting contact form, FormData contents:', entries);
    } catch (err) {
        console.debug('Could not serialize FormData for debug:', err);
    }

    fetch('/contact/submit', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            showSuccessMessage(data.message);
            form.reset();
        } else {
            showErrorMessage(data.errors ? data.errors.join('\n') : data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorMessage('حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.');
    })
    .finally(() => {
        // Restore button
        submitBtn.disabled = false;
        submitBtn.querySelector('span').textContent = originalText;
    });
}

// Consultation functionality moved to layout file

// Copy to clipboard functionality
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showSuccessMessage('تم نسخ النص بنجاح');
        }).catch(() => {
            fallbackCopyToClipboard(text);
        });
    } else {
        fallbackCopyToClipboard(text);
    }
}

function fallbackCopyToClipboard(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        document.execCommand('copy');
        showSuccessMessage('تم نسخ النص بنجاح');
    } catch (err) {
        console.error('Could not copy text: ', err);
        showErrorMessage('فشل في نسخ النص');
    }

    document.body.removeChild(textArea);
}

// Language toggle moved to route-based switching

