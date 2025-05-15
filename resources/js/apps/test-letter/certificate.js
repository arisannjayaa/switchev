import {formatRupiah, swalSuccess} from "@/apps/utils/helper.js";
import Swal from "sweetalert2";
import {csrfToken, handleValidation} from "@/app.js";

document.addEventListener('DOMContentLoaded', function() {
    const tableUrl = $('#table-url').val();
    const asset = $("#asset-url").val();

    $("#table").DataTable({
        order: [[0, 'desc']],
        ordering: true,
        serverSide: true,
        processing: true,
        autoWidth: false,
        responsive: true,
        ajax: {
            url: tableUrl
        },
        language: {
            search: "Cari:",
            paginate: {
                "first":      "Pertama",
                "last":       "Terakhir",
                "next":       "Berikutnya",
                "previous":   "Sebelumnya"
            },
            info: 'Menampilkan halaman _PAGE_ dari _PAGES_',
            infoEmpty: 'Tidak ada data yang tersedia',
            infoFiltered: '(Terfilter dari _MAX_ jumlah data)',
            lengthMenu: 'Tampilkan _MENU_ data per halaman',
            emptyTable: `<div class="text-center"><img class="mb-3" width="200" src="${asset+'assets/dist/img/undraw_no_data_re_kwbl.svg'}"><p>Data Masih Kosong</p></div>`,
            zeroRecords: `<div class="text-center"><img class="mb-3" width="200" src="${asset+'assets/dist/img/undraw_not_found_re_bh2e.svg'}"><p>Data Tidak Ditemukan</p></div>`
        },
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                width: "40px",
                orderable: false,
                searchable: false,
            },
            { data: 'test_letter.code', name: 'test_letter.code', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'user.name', name: 'user.name', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'brand', name: 'brand', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'test_letter.workshop', name: 'test_letter.workshop', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'test_letter.workshop_type', name: 'test_letter.workshop_type', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'status', name: 'status', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'action', name: 'action', className: 'text-nowrap', orderable: false, searchable: false},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
        ],
    });

    $("#form-certificate").submit(function (e) {
        e.preventDefault();

        let id = $("#id").val();
        let formData = new FormData(this);
        let btn = "#btn-submit"
        let url = $("#certificate-form-url").val();

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
                    swalSuccess(data.message);
                    setTimeout(() => {
                        window.location.href = data.data.redirect;
                    },2000)
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
                    let hasScrolled = false;

                    $.each(data.errors, function(fieldName) {
                        const $input = $(`[name="${fieldName}"]`);

                        if ($input.length) {
                            if (!hasScrolled) {
                                const $rowCards = $('.row-cards'); // targetkan div row-cards
                                const offset = $input.offset().top - $rowCards.offset().top - 100; // offset dari row-cards
                                $rowCards.animate({ scrollTop: $rowCards.scrollTop() + offset }, 500);
                                $input.focus();
                                hasScrolled = true;
                            }
                        }
                    });
                    $(btn).empty().append('Simpan').prop('disabled', false);
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                $(btn).empty().append('Simpan').prop('disabled', false);
            });
    });

    $("#btn-download-certificate-srut").click(function () {
        let url = $("#download-certificate-srut-url").val();
        let formData = new FormData();
        formData.append("id", $("#id").val());

        let btn = "#btn-download-certificate-srut";
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

    $("#btn-download-certificate-sut").click(function () {
        let url = $("#download-certificate-sut-url").val();
        let formData = new FormData();
        formData.append("id", $("#id").val());

        let btn = "#btn-download-certificate-sut";
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

    $("#btn-download-certificate-attachment").click(function () {
        let url = $("#download-certificate-attachment-url").val();
        let formData = new FormData();
        formData.append("id", $("#id").val());

        let btn = "#btn-download-certificate-attachment";
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

    $("#btn-send-draft").click(function () {
        let url = $("#send-draft-url").val();
        let formData = new FormData();
        formData.append("id", $("#id").val());

        let btn = "#btn-send-draft";
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

                    window.location.reload()
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
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-send mx-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
                `).prop('disabled', false);
            });
    })

    $("#btn-verification").click(function () {
        let url = $("#verify-url").val();
        let formData = new FormData();
        formData.append("id", $("#id").val());

        let btn = "#btn-verification";
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

                    setTimeout(function() {
                        window.location.href = data.data.redirect;
                    }, 1000);
                }

                if (data.errors || data.invalid) {
                    new handleValidation(data.errors || data.invalid)
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                $(btn).empty().append(`Verifikasi`).prop('disabled', false);
            });
    })

    $("#btn-upload-archive").click(function () {
        let url = $("#upload-archive-url").val();
        let formData = new FormData();

        if ($("#workshop_type").val() == "A" && $("#test_letter_step").val() != "create_certificate_srut") {
            let fileCertificateSUT = document.getElementById('type_test_attachment').files[0];
            let fileSk = document.getElementById('sk_attachment').files[0];
            formData.append('sk_attachment', fileSk);
            formData.append('type_test_attachment', fileCertificateSUT);
            formData.append('workshop_type', "A");
        }

        if ($("#workshop_type").val() == "A" && $("#test_letter_step").val() == "create_certificate_srut") {
            let fileCertificateSRUT = document.getElementById('registration_attachment').files[0];
            formData.append('registration_attachment', fileCertificateSRUT);
            formData.append('workshop_type', "A");
            formData.append('test_letter_step', $("#test_letter_step").val());
            formData.append('old_type_test_attachment', $("#old_type_test_attachment").val());
        }

        if ($("#workshop_type").val() == "B") {
            let fileSk = document.getElementById('sk_attachment').files[0];
            let fileCertificateSRUT = document.getElementById('registration_attachment').files[0];
            let fileCertificateSUT = document.getElementById('type_test_attachment').files[0];
            formData.append('sk_attachment', fileSk);
            formData.append('registration_attachment', fileCertificateSRUT);
            formData.append('type_test_attachment', fileCertificateSUT);
        }

        let testLetterId = $("#id").val();
        let id = $("#certificate_id").val();
        let userId = $("#user-id").val();
        let btn = "#btn-upload-archive";
        formData.append('conversion_id', testLetterId);
        formData.append('user_id', userId);
        formData.append('id', id);

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
                    window.location.href = data.data.redirect;
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
