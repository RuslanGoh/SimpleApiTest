document.addEventListener('DOMContentLoaded', function() {
    const leadForm = document.getElementById('leadForm');
    const messageDiv = document.getElementById('message');

    if (leadForm) {
        leadForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            

            messageDiv.textContent = '';
            messageDiv.className = 'message';

            fetch('lead', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    messageDiv.textContent = data.message;
                    messageDiv.className = 'message success';
                    leadForm.reset();
                } else {
                    messageDiv.textContent = 'Error: ' + (data.message || 'Unknown error');
                    messageDiv.className = 'message error';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageDiv.textContent = 'An error occurred while sending the form.';
                messageDiv.className = 'message error';
            });
        });
    }
});