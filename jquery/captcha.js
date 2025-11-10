$(document).ready(function() {
    // Rafraîchir le CAPTCHA
    $('#refreshCaptcha').click(function() {
        refreshCaptcha();
    });

    // Soumission du formulaire
    $('#captchaForm').submit(function(e) {
        e.preventDefault();
        $('#submitBtn').prop('disabled', true);
        
        $.ajax({
            url: '../requete/captcha_verify.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showMessage(response.message, 'success');
                    $('#captchaForm')[0].reset();
                } else {
                    showMessage(response.error, 'error');
                }
                refreshCaptcha();
            },
            error: function() {
                showMessage('Erreur de connexion', 'error');
            },
            complete: function() {
                $('#submitBtn').prop('disabled', false);
            }
        });
    });
});

function refreshCaptcha() {
    $('#captchaImage').attr('src', '../requete/captcha.php?t=' + Date.now());
    $('#captchaInput').val('');
}

function showMessage(text, type) {
    $('#message')
        .removeClass('error success')
        .addClass(type)
        .text(text)
        .fadeIn()
        .delay(3000)
        .fadeOut();
}