// install/install.js — Vérification AJAX des connexions (version sans texte en dur)

function testConnections() {
    const form = document.getElementById('install-form');
    const formData = new FormData(form);
    const statusDiv = document.getElementById('install-status');

    statusDiv.innerHTML = installLang.testing;
    statusDiv.style.color = '';

    fetch('test.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            statusDiv.innerHTML = installLang.success;
            statusDiv.style.color = 'green';
        } else {
            statusDiv.innerHTML = data.message || installLang.odoo_error;
            statusDiv.style.color = 'red';
        }
    })
    .catch(error => {
        console.error(error);
        statusDiv.innerHTML = installLang.network_error;
        statusDiv.style.color = 'red';
    });
}
