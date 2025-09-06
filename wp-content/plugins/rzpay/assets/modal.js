/**
 * Custom Modal System for Rzpay
 * Replaces standard JavaScript alerts with beautiful modals
 */

// Create a single instance of the modal container
document.addEventListener('DOMContentLoaded', function() {
    // Create modal overlay
    const modalOverlay = document.createElement('div');
    modalOverlay.className = 'rzpay-modal-overlay';
    document.body.appendChild(modalOverlay);
});

/**
 * Show a custom modal
 * @param {Object} options - Modal options
 * @param {string} options.title - Modal title
 * @param {string} options.message - Modal message
 * @param {string} [options.type='info'] - Modal type: 'info', 'success', 'warning', 'error'
 * @param {string} [options.confirmText='OK'] - Text for the confirm button
 * @param {string} [options.cancelText='Cancel'] - Text for the cancel button (only for confirm modals)
 * @param {Function} [options.onConfirm] - Callback function when confirm button is clicked
 * @param {Function} [options.onCancel] - Callback function when cancel button is clicked
 * @param {boolean} [options.showCancel=false] - Whether to show the cancel button
 */
function rzpayShowModal(options) {
    const {
        title,
        message,
        type = 'info',
        confirmText = 'OK',
        cancelText = 'Cancel',
        onConfirm = null,
        onCancel = null,
        showCancel = false
    } = options;

    // Get the overlay
    const modalOverlay = document.querySelector('.rzpay-modal-overlay');
    if (!modalOverlay) return;

    // Clear any existing modals
    modalOverlay.innerHTML = '';

    // Create modal HTML
    let iconClass = '';
    switch (type) {
        case 'success':
            iconClass = 'fas fa-check-circle';
            break;
        case 'error':
            iconClass = 'fas fa-times-circle';
            break;
        case 'warning':
            iconClass = 'fas fa-exclamation-triangle';
            break;
        case 'info':
        default:
            iconClass = 'fas fa-info-circle';
            break;
    }

    const modalHTML = `
        <div class="rzpay-modal ${type}">
            <div class="rzpay-modal-header">
                <h3 class="rzpay-modal-title">${title}</h3>
                <button class="rzpay-modal-close">&times;</button>
            </div>
            <div class="rzpay-modal-body">
                <div class="rzpay-modal-icon">
                    <i class="${iconClass}"></i>
                </div>
                <div class="rzpay-modal-message">${message}</div>
            </div>
            <div class="rzpay-modal-footer">
                ${showCancel ? `<button class="rzpay-modal-btn rzpay-modal-btn-secondary rzpay-modal-cancel">${cancelText}</button>` : ''}
                <button class="rzpay-modal-btn rzpay-modal-btn-primary rzpay-modal-confirm">${confirmText}</button>
            </div>
        </div>
    `;

    // Add modal to overlay
    modalOverlay.innerHTML = modalHTML;

    // Show the modal
    modalOverlay.classList.add('active');

    // Handle close button
    const closeBtn = modalOverlay.querySelector('.rzpay-modal-close');
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modalOverlay.classList.remove('active');
            if (onCancel) onCancel();
        });
    }

    // Handle confirm button
    const confirmBtn = modalOverlay.querySelector('.rzpay-modal-confirm');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            modalOverlay.classList.remove('active');
            if (onConfirm) onConfirm();
        });
    }

    // Handle cancel button
    const cancelBtn = modalOverlay.querySelector('.rzpay-modal-cancel');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            modalOverlay.classList.remove('active');
            if (onCancel) onCancel();
        });
    }

    // Allow closing with ESC key
    const handleEscKey = function(event) {
        if (event.key === 'Escape') {
            modalOverlay.classList.remove('active');
            if (onCancel) onCancel();
            document.removeEventListener('keydown', handleEscKey);
        }
    };
    document.addEventListener('keydown', handleEscKey);
}

/**
 * Show an alert modal
 * @param {string} message - The message to display
 * @param {string} [title='Notice'] - The modal title
 * @param {Function} [callback] - Optional callback after user confirms
 */
function rzpayAlert(message, title = 'Notice', callback = null) {
    rzpayShowModal({
        title: title,
        message: message,
        type: 'info',
        onConfirm: callback
    });
}

/**
 * Show a success modal
 * @param {string} message - The message to display
 * @param {string} [title='Success'] - The modal title
 * @param {Function} [callback] - Optional callback after user confirms
 */
function rzpaySuccess(message, title = 'Success', callback = null) {
    rzpayShowModal({
        title: title,
        message: message,
        type: 'success',
        onConfirm: callback
    });
}

/**
 * Show an error modal
 * @param {string} message - The message to display
 * @param {string} [title='Error'] - The modal title
 * @param {Function} [callback] - Optional callback after user confirms
 */
function rzpayError(message, title = 'Error', callback = null) {
    rzpayShowModal({
        title: title,
        message: message,
        type: 'error',
        onConfirm: callback
    });
}

/**
 * Show a warning modal
 * @param {string} message - The message to display
 * @param {string} [title='Warning'] - The modal title
 * @param {Function} [callback] - Optional callback after user confirms
 */
function rzpayWarning(message, title = 'Warning', callback = null) {
    rzpayShowModal({
        title: title,
        message: message,
        type: 'warning',
        onConfirm: callback
    });
}

/**
 * Show a confirmation modal
 * @param {string} message - The message to display
 * @param {string} [title='Confirm'] - The modal title
 * @param {Function} [onConfirm] - Callback when user confirms
 * @param {Function} [onCancel] - Callback when user cancels
 */
function rzpayConfirm(message, title = 'Confirm', onConfirm = null, onCancel = null) {
    rzpayShowModal({
        title: title,
        message: message,
        type: 'warning',
        confirmText: 'Yes',
        cancelText: 'No',
        showCancel: true,
        onConfirm: onConfirm,
        onCancel: onCancel
    });
}
