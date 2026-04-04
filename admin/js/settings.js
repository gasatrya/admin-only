/**
 * UserFlow Settings JavaScript
 *
 * Handles UI interactions on the settings page.
 */
document.addEventListener('DOMContentLoaded', function() {
    var sessionTimeoutSelect = document.getElementById('session_timeout');
    if (sessionTimeoutSelect) {
        // Initial setup on load if needed
        toggleCustomTimeout(sessionTimeoutSelect.value);

        // Add event listener for changes
        sessionTimeoutSelect.addEventListener('change', function() {
            toggleCustomTimeout(this.value);
        });
    }
});

function toggleCustomTimeout(value) {
    var customInput = document.getElementById('custom-timeout-input');
    if (customInput) {
        if (value === 'custom') {
            customInput.style.display = 'block';
        } else {
            customInput.style.display = 'none';
        }
    }
}
