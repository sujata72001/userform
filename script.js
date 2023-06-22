document.getElementById("userForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission
    var form = event.target;
    
    // Perform your own custom validation here
    if (form.checkValidity()) {
        grecaptcha.ready(function() {
            grecaptcha.execute('your_recaptcha_site_key', {action: 'submit'}).then(function(token) {
                // Add the token value to the form data
                var formData = new FormData(form);
                formData.append('recaptcha_token', token);

                // Submit the form with reCAPTCHA token
                var xhr = new XMLHttpRequest();
                xhr.open("POST", form.action, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert("Form submitted successfully!");
                        form.reset();
                    } else {
                        alert("An error occurred while submitting the form.");
                    }
                };
                xhr.send(formData);
            });
        });
    } else {
        form.reportValidity();
    }
});
