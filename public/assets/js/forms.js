// Form submission handling
document.addEventListener('DOMContentLoaded', function() {
    // Contact form submission
    const contactForms = document.querySelectorAll('.contact-form');
    contactForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            submitContactForm(this);
        });

        // Also prevent double-click on submit button
        const submitBtn = form.querySelector('.contact-submit-btn');
        if (submitBtn) {
            submitBtn.addEventListener('click', function(e) {
                if (this.dataset.submitting === 'true') {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        }
    });
});

// Submit contact form
function submitContactForm(form) {
    const submitBtn = form.querySelector('.contact-submit-btn');
    const originalText = submitBtn.querySelector('span').textContent;

    // Prevent double submission by checking if already submitting
    if (submitBtn.dataset.submitting === 'true') {
        return;
    }

    // Mark as submitting and disable button
    submitBtn.dataset.submitting = 'true';
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

        // Additional debug: check if form has expected fields
        const expectedFields = ['name', 'email', 'phone', 'subject', 'message'];
        const missingFields = expectedFields.filter(field => !formData.has(field) || !formData.get(field));
        if (missingFields.length > 0) {
            console.warn('Missing or empty form fields:', missingFields);
        }
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
        // Always restore button state
        submitBtn.dataset.submitting = 'false';
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

// Show success message
function showSuccessMessage(message) {
    // Create a toast notification
    createToast(message, 'success');
}

// Show error message
function showErrorMessage(message) {
    // Create a toast notification
    createToast(message, 'error');
}

// Create toast notification
function createToast(message, type) {
    // Remove any existing toasts
    const existingToasts = document.querySelectorAll('.toast-notification');
    existingToasts.forEach(toast => toast.remove());

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <span class="toast-icon">${type === 'success' ? '✓' : '✕'}</span>
            <span class="toast-message">${message}</span>
        </div>
    `;

    // Add styles
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#4CAF50' : '#f44336'};
        color: white;
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        font-family: Arial, sans-serif;
        max-width: 350px;
        animation: slideIn 0.3s ease;
        direction: rtl;
    `;

    // Add animation keyframes if not already added
    if (!document.querySelector('#toast-styles')) {
        const styles = document.createElement('style');
        styles.id = 'toast-styles';
        styles.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            .toast-content {
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .toast-icon {
                font-weight: bold;
                font-size: 16px;
            }
        `;
        document.head.appendChild(styles);
    }

    // Add to document
    document.body.appendChild(toast);

    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 300);
    }, 5000);

    // Allow manual close on click
    toast.addEventListener('click', () => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 300);
    });
}

