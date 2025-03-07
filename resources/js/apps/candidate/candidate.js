import {hideLoading, loadingScreen, reloadTable, resetValidation, swalError} from "@/apps/utils/helper.js";
import {csrfToken, handleValidation, handleValidationWithFile} from "@/app.js";
import Swal from "sweetalert2";

const tableUrl = $('#table-url').val();
const asset = $("#asset-url").val();

$('.dropify').dropify({
    messages: {
        'default': `<p style="font-size: 14px !important;">Seret dan letakkan file di sini atau klik</p>`,
        'replace': `<p style="font-size: 14px !important;">Seret dan lepas atau klik untuk mengganti</p>`,
        'remove':  'Hapus',
        'error':   'Ooops, Terjadi Kesalahan'
    },
    tpl: {
        wrap:'<div class="dropify-wrapper" style="margin-bottom: .5rem !important; border: 1px #dadfe5 dashed !important; border-radius: .25rem !important; height: 300px;"></div>',
        message:'<div class="dropify-message"><span class="file-icon" /> <p>{{ default }}</p></div>',
        preview:'<div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-infos-message">{{ replace }}</p></div></div></div>',
        clearButton:'<button type="button" class="dropify-clear btn btn-primary">{{ remove }}</button>',
        errorLine:'<p class="dropify-error">{{ error }}</p>',
        errorsContainer: '<div class="dropify-errors-container"><ul></ul></div>'
    }
});

let currentStep = 1;

function showStep(stepNumber) {
    $('.card-step').addClass('d-none');
    $('#step-' + stepNumber).removeClass('d-none');

    // Update steps sidebar
    $('.step-item').removeClass('active');
    $('.step-item').eq(stepNumber - 1).addClass('active');
}

function fetchData() {
    fetch(url, {
        method: 'GET',
    })
        .then(response => {
            return response.json();
        })
        .then(res => {
            console.log(res);
            if(res.code == 200) {
            }

        })
        .catch(error => {
            console.log('Error:', error);
        })
        .finally(() => {

        });
}

$('#btn-next').on('click', function() {
    if (currentStep < 2) {
        currentStep++;
        showStep(currentStep);
    }
});

// $('#btn-submit').on('click', function() {
//     if (currentStep < 3) {
//         currentStep++;
//         showStep(currentStep);
//     }
// });

$('#btn-prev').on('click', function() {
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
});

showStep(currentStep);

$(".dropify-clear").click(function () {
    console.log("OK");
    $("#photo").attr('type', 'file').attr('value', '').attr('data-default-file', '');
    $("#old-photo").remove();
})

$("#form-candidate").submit(function (e) {
    e.preventDefault();
    loadingScreen(1500);

    let id = $('input[name="id"]').val();
    let formData = new FormData(this);
    let vision = editorVision.getSemanticHTML();
    let mission = editorMission.getSemanticHTML();
    let btn = "#btn-submit";
    let form = "#form-candidate";

    if (vision == "<p></p>") {
        vision = '';
    }

    if (mission == "<p></p>") {
        mission = '';
    }

    formData.append('vision', vision);
    formData.append('mission', mission);

    if (id !== "") {
        var url = $("#update-url").val();
    } else {
        var url = $("#create-url").val();
    }

    $(btn).empty().append(`<div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                                </div>`);

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
            if (data.errors || data.invalid) {
                new handleValidationWithFile(data.errors || data.invalid)
                swalError(data.errors);
            }

            if(data.code == 200) {
                $('#candidate-success').html(data.message);
                currentStep++;
                showStep(currentStep);
            }

        })
        .catch(error => {
            console.log('Error:', error);
        })
        .finally(() => {
            hideLoading(500);
            $(btn).empty().append("Simpan");
        });
});

$(document).on("click", 'a.card-btn.delete', function () {
    let id = $(this).data("id");
    let url = $("#delete-url").val();
    let formData = new FormData();
    formData.append("id", id);

    Swal.fire({
        html: `<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon mb-2 text-danger icon-lg"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg>
                    <h3>Apakah anda yakin</h3>
                    <div class="text-secondary" style="font-size: 14px !important;">Apakah Anda benar-benar ingin menghapus data ini? Apa yang telah Anda lakukan tidak dapat dibatalkan.</div>`,
        confirmButtonText: 'Hapus',
        customClass: {
            confirmButton: 'btn btn-danger w-100',
            cancelButton: 'btn w-100'
        },
        showCancelButton: true,
    }).then((result) => {
        if (result.isConfirmed) {
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

                        Swal.fire({
                            html: `<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 text-green"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path><path d="M9 12l2 2l4 -4"></path></svg>
                            <h3>Berhasil</h3>
                            <div class="text-secondary">${data.message}</div>`,
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#2fb344',
                            customClass: {
                                confirmButton: 'btn btn-success w-100'
                            }
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }

                })
                .catch(error => {
                    console.log('Error:', error);
                })
                .finally(() => {

                });
        }
    });
});
