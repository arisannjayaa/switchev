import {alertError, csrfToken, handleValidation, alertSuccess} from "@/app.js";
import {loadingScreen} from "@/apps/utils/helper.js";

document.addEventListener('DOMContentLoaded', function() {
    $('#form-login').submit(function (e) {
        e.preventDefault();

        let url = $('#login-url').val();
        let formData = new FormData(this);
        $("#btn-login").empty().append(`<div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                                </div>`);
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
            },
            body: formData,
        })
            .then(response => {
                return response.json();
            })
            .then(data => {
                if(data.code == 200) {
                    let html = alertSuccess(data.message);
                    $(".alert-container").html(html);

                    setTimeout(function() {
                         window.location.href = data.data.redirect;
                    }, 2000);
                }

                if (data.errors || data.invalid) {
                    new handleValidation(data.errors || data.invalid)
                }

                if (data.code == 401) {
                    let html = alertError(data.message);
                    $(".alert-container").html(html);

                    setTimeout(function() {
                        $(".alert-container").fadeOut(500);
                    }, 2000);

                    $(".alert-container").show();
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                $("#btn-login").empty().append("Login");
            });
    });
});
