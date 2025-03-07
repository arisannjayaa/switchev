import "./bootstrap";
import {hideLoading, loadingScreen} from "@/apps/utils/helper.js";
export function csrfToken() {
    let csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    return csrfToken;
}

export function handleValidation(messages) {
    // reset before looping
    $(".invalid-feedback").remove();
    for (let i in messages) {
        for (let t in messages[i]) {
            $("[name=" + i + "]")
                .addClass("is-invalid")
                .after(
                    '<div class="text-left invalid-feedback">' +
                        messages[i][t] +
                        "</div>"
                );
        }

        // remove message if event key press
        $("[name=" + i + "]").keypress(function () {
            $("[name=" + i + "]").removeClass("is-invalid");
        });

        // remove message if event change
        $("[name=" + i + "]").change(function () {
            $("[name=" + i + "]").removeClass("is-invalid");
        });
    }
}

export function handleValidationWithFile(messages) {
    // reset before looping
    $(".invalid-feedback").remove();
    for (let i in messages) {
        for (let t in messages[i]) {

            if (i == "photo") {
                $(".dropify-wrapper").addClass('has-error').attr('style', 'border: 1px #d63939 dashed !important; border-radius: 4px !important');
                $(`#hint-photo`)
                    .before(
                        '<div class="text-left invalid-feedback" style="display: block">' +
                        messages[i][t] +
                        "</div>"
                    );
            }

            if (i != "photo") {
                $("[name=" + i + "]")
                    .addClass("is-invalid")
                    .after(
                        '<div class="text-left invalid-feedback">' +
                        messages[i][t] +
                        "</div>"
                    );

                $("#quill-"+i).addClass('quill-has-error').after(
                    '<div class="text-left invalid-feedback d-block">' +
                    messages[i][t] +
                    "</div>"
                );
            }
        }

        // remove message if event key press
        $("[name=" + i + "]").keypress(function () {
            $("[name=" + i + "]").removeClass("is-invalid");
        });

        // remove message if event change
        $("[name=" + i + "]").change(function () {
            $("[name=" + i + "]").removeClass("is-invalid");
            $('#hint-photo').siblings('.invalid-feedback').remove();
            $(".dropify-wrapper").removeClass('has-error').attr('style', 'border: 1px #dadfe5 dashed !important; border-radius: 4px !important');
        });
    }
}

export function alertError(message) {
    return `<div class="alert alert-danger alert-dismissible" role="alert">
                      <div class="d-flex">
                        <div>
                          <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>
                        </div>
                        <div>
                          ${message}
                        </div>
                      </div>
                      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>`;
}

export function alertSuccess(message) {
    return `<div class="alert alert-success alert-dismissible" role="alert">
                      <div class="d-flex">
                        <div>
                          <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                        </div>
                        <div>
                          ${message}
                        </div>
                      </div>
                      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>`;
}

export function removeAlert(count) {
    if (count > 0) {
        $(".alert-container").empty();
    }
}

$("body").append(loadingScreen());
hideLoading(1000);
