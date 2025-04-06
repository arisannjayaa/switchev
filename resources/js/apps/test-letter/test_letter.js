import {
    hideLoading,
    loadingScreen,
    reloadTable,
    resetValidation,
    capitalizeFirstLetter,
    conversionStatus,
    destroyQuill, btnLoading, handleModalError, swalError,
} from "@/apps/utils/helper.js";
import {csrfToken, handleValidation} from "@/app.js";
import Swal from "sweetalert2";

document.addEventListener('DOMContentLoaded', function() {

    $("#sop_component_installation").change(function () {
        if ($('[name="old_sop_component_installation"]').length) {
            $('[name="old_sop_component_installation"]').remove();
        }
    })

    $("#technical_drawing").change(function () {
        if ($('[name="old_technical_drawing"]').length) {
            $('[name="old_technical_drawing"]').remove();
        }
    })

    $("#conversion_workshop_certificate").change(function () {
        if ($('[name="old_conversion_workshop_certificate"]').length) {
            $('[name="old_conversion_workshop_certificate"]').remove();
        }
    })

    $("#electrical_diagram").change(function () {
        if ($('[name="old_electrical_diagram"]').length) {
            $('[name="old_electrical_diagram"]').remove();
        }
    })

    $("#photocopy_stnk").change(function () {
        if ($('[name="old_photocopy_stnk"]').length) {
            $('[name="old_photocopy_stnk"]').remove();
        }
    })

    $("#physical_inspection").change(function () {
        if ($('[name="old_physical_inspection"]').length) {
            $('[name="old_physical_inspection"]').remove();
        }
    })

    $("#test_report").change(function () {
        if ($('[name="old_test_report"]').length) {
            $('[name="old_test_report"]').remove();
        }
    })

    $("#form-test-letter").submit(function (e) {
        e.preventDefault();

        let id = $("#id").val();
        let formData = new FormData(this);
        let btn = "#btn-submit"
        let url = $("#upsert-form-url").val();

        $(btn).empty().append(`<div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                                </div>`).prop('disabled', true);

        // send data
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
                    window.location.href = data.data.redirect;
                }

                if (data.code == 403) {
                    Swal.fire({
                        html: `<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-danger"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>
                            <h3>Terjadi Kesalahan</h3>
        <div>${data.message}</div>`,
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#d63939',
                        customClass: {
                            confirmButton: 'btn btn-success w-100'
                        }
                    });

                    $(btn).empty().append(data.data.button).prop('disabled', false);
                }


                if (data.errors || data.invalid) {
                    new handleValidation(data.errors || data.invalid)
                    $(btn).empty().append('Kirim Pengajuan').prop('disabled', false);
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
            });
    });

    $("#table").on("click", ".detail", function () {
        let id = $(this).data("id");
        let url = $("#show-url").val();
        url = url.replace(":id", id);

        window.location.href = url;
    })
});
