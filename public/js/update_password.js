document.addEventListener('DOMContentLoaded', function () {
    console.log('update_password.js loaded');

    const form = document.getElementById('passwordForm');
    if (!form) {
        console.error('passwordForm NOT FOUND');
        return;
    }

    /* 🔥 CLEAR OLD PHP ERRORS ON LOAD */
    clearErrors();

    function clearErrors() {
        form.querySelectorAll('.error-text').forEach(el => {
            el.textContent = '';
        });
        form.querySelectorAll('.form-group').forEach(group => {
            group.classList.remove('error');
        });
    }

    function submitHandler(e) {
        e.preventDefault();
        console.log('AJAX submit triggered');

        /* 🔥 CLEAR BEFORE NEW SUBMIT */
        clearErrors();

        const formData = new FormData(form);

        fetch(form.getAttribute('action'), {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);

            if (data.success) {
                window.location.href = data.redirect;
                return;
            }

            if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (!input) return;

                    const group = input.closest('.form-group');
                    group.classList.add('error');

                    const errorBox = group.querySelector('.error-text');
                    if (errorBox) {
                        errorBox.textContent = data.errors[key];
                    }
                });
            }
        })
        .catch(err => {
            console.error('AJAX failed', err);
        });
    }

    // Submit via button or Enter key
    form.addEventListener('submit', submitHandler);

    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.addEventListener('click', submitHandler);
    }
});
