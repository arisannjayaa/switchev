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
    const isCertificate = $("#is-certificate-ready").val();
    $("#btn-approve").prop('disabled', true);

    if (isCertificate == 1) {
        $("#btn-approve").prop('disabled', false);
    }


    $("#btn-download-sk").click(function () {
        let url = $("#download-sk-url").val();
        let formData = new FormData();
        formData.append("id", $("#id").val());

        let btn = "#btn-download-sk";
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
                    fetch(data.data.download)
                        .then(response => response.blob())
                        .then(blob => {
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = data.data.file_name;
                            document.body.appendChild(a);
                            a.click();
                            window.URL.revokeObjectURL(url);
                        });
                }

                if (data.errors || data.invalid) {
                    new handleValidation(data.errors || data.invalid)
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                $(btn).empty().append(`
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon mx-0 icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                `).prop('disabled', false);
            });
    })

    $("#btn-download-certificate").click(function () {
        let url = $("#download-certificate-url").val();
        let formData = new FormData();
        formData.append("id", $("#id").val());

        let btn = "#btn-download-certificate";
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
                    fetch(data.data.download)
                        .then(response => response.blob())
                        .then(blob => {
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = data.data.file_name;
                            document.body.appendChild(a);
                            a.click();
                            window.URL.revokeObjectURL(url);
                        });
                }

                if (data.errors || data.invalid) {
                    new handleValidation(data.errors || data.invalid)
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                $(btn).empty().append(`
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon mx-0 icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                `).prop('disabled', false);
            });
    })

    $("#btn-upload-archive").click(function () {
        let url = $("#upload-archive-url").val();
        let formData = new FormData();
        let fileSk = document.getElementById('sk_attachment').files[0];
        let fileCertificate = document.getElementById('sft_attachment').files[0];
        let conversionId = $("#id").val();
        let userId = $("#user-id").val();
        let btn = "#btn-upload-archive";
        formData.append('sk_attachment', fileSk);
        formData.append('sft_attachment', fileCertificate);
        formData.append('conversion_id', conversionId);
        formData.append('user_id', userId);

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

                    $("#btn-approve").empty().append("Selesai").prop('disabled', false);

                }



                if (data.errors || data.invalid) {
                    new handleValidation(data.errors || data.invalid)
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                $(btn).empty().append(`<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="mx-0 icon icon-tabler icons-tabler-outline icon-tabler-upload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 9l5 -5l5 5" /><path d="M12 4l0 12" /></svg>`).prop('disabled', false);
            });
    })
});
