document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('profileForm');
    if (!form) return;

    clearErrors();

    function clearErrors() {
        form.querySelectorAll('.error-text').forEach(e => e.textContent = '');
        const general = document.getElementById('generalError');
        if (general) general.textContent = '';
    }

    function submitHandler(e) {
        e.preventDefault();
        clearErrors();

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
                return;
            }

            if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    if (key === 'general') {
                        document.getElementById('generalError').textContent = data.errors[key];
                        return;
                    }

                    const input = form.querySelector(`[name="${key}"]`);
                    if (!input) return;

                    const errorBox = input.closest('.form-group')
                                          .querySelector('.error-text');
                    if (errorBox) errorBox.textContent = data.errors[key];
                });
            }
        });
    }

    form.addEventListener('submit', submitHandler);
});
