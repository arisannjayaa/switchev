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

    const tableUrl = $('#table-url').val();
    const asset = $("#asset-url").val();

    var quillReject;

    $("#check-all").change(function() {
        if ($("#check-all:checked").length === $("#check-all").length) {
            $("input[value='Sesuai']").prop("checked", true);
        } else {
            $("input[value='Sesuai']").prop("checked", false);
        }
    });

    $('#modal-reject').on('hidden.bs.modal', function () {
        destroyQuill(quillReject, "#editor-reject");
    });

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
            { data: 'person_responsible', name: 'person_responsible', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'workshop', name: 'workshop', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'whatapp_responsible', name: 'whatapp_responsible', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'type', name: 'type', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'status', name: 'status', className: 'text-nowrap', orderable: false, searchable: true, render: function (data) { return `<span class="badge bg-primary text-primary-fg">${conversionStatus(data)}</span>` }},
            { data: 'action', name: 'action', className: 'text-nowrap', orderable: false, searchable: false},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
        ],
    });

    if ($("#type").val() === 'Selain Sepeda Motor') {
        $("#select-wiring-diagram").show();
    }

    // Event listener ketika ada perubahan pada <select>
    $("#type").change(function() {
        // console.log($("#type").val());
        let selectedValue = $(this).val();

        if (selectedValue === 'Selain Sepeda Motor') {
            $("#select-wiring-diagram").show();  // Tampilkan elemen input file
        } else {
            $("#select-wiring-diagram").hide();  // Sembunyikan elemen input file
        }
    });


    $("#application_letter").change(function () {
        if ($('[name="old_application_letter"]').length) {
            $('[name="old_application_letter"]').remove();
        }
    })

    $("#technician_competency").change(function () {
        if ($('[name="old_technician_competency"]').length) {
            $('[name="old_technician_competency"]').remove();
        }
    })

    $("#equipment").change(function () {
        if ($('[name="old_equipment"]').length) {
            $('[name="old_equipment"]').remove();
        }
    })

    $("#sop").change(function () {
        if ($('[name="old_sop"]').length) {
            $('[name="old_sop"]').remove();
        }
    })

    $("#wiring_diagram").change(function () {
        if ($('[name="old_wiring_diagram"]').length) {
            $('[name="old_wiring_diagram"]').remove();
        }
    })

    $("#form-conversion").submit(function (e) {
        e.preventDefault();

        let id = $("#id").val();
        let formData = new FormData(this);
        let btn = "#btn-next";
        let table = "#table";
        let form = "#form-conversion";
        let step = $("#step").val();
        let url;
        console.log(step)

        if (step == 1) {
            url = $("#form-responsible-url").val();
        }

        if (step == 2) {
            url = $("#form-document-url").val();
        }

        if (step == 3) {
            url = $("#form-mechanical-url").val();
        }

        if (step == 4) {
            url = $("#form-equipment-url").val();
        }


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
                    // Swal.fire({
                    //     html: `<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 text-green"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path><path d="M9 12l2 2l4 -4"></path></svg>
                    // <h3>Berhasil</h3>
                    // <div class="text-secondary">${data.message}</div>`,
                    //     confirmButtonText: 'Ok',
                    //     confirmButtonColor: '#2fb344',
                    //     customClass: {
                    //         confirmButton: 'btn btn-success w-100'
                    //     }
                    // });

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
                    $(btn).empty().append('Selanjutnya').prop('disabled', false);
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

    $("#form-checklist-equipment").submit(function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let btn = "#btn-checklist-confirm";
        let modal = "#modal-checklist-equipment";
        let url = $("#checklist-url").val();

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
                    $(modal).modal("hide");

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

                }

                if (data.errors || data.invalid) {
                    swalError(data.errors);
                }

                window.location.reload();

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                hideLoading(1000);
                $(btn).empty().append("Simpan").prop('disabled', false);
            });
    });

    $("#btn-approve").click(function (){
        let id = $("#id").val();
        let url = $("#approve-url").val();
        let btn = $("#btn-approve")
        let step = $("#step").val()
        url = url.replace(":id", id);
        let formData = new FormData();
        formData.append("id", id);

        $(btn).empty().append(`<div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                                </div>`).prop('disabled', true);


        Swal.fire({
            html: `<svg  xmlns="http://www.w3.org/2000/svg"  width="100"  height="100"  viewBox="0 0 24 24"  fill="currentColor"  class="mb-2 text-info"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" /></svg>
                    <h3>Apakah anda yakin</h3>
                    <div class="text-secondary" style="font-size: 14px !important;">Apakah anda sudah yakin dari data ini?</div>`,
            confirmButtonText: 'Verifikasi',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-info w-100',
                cancelButton: 'btn w-100'
            },
            showCancelButton: true,
        }).then((result) => {
            if (result.isDismissed) {
                if (step == 4) {
                    $(btn).empty().append(`Selesai`).prop('disabled', false);
                } else {
                    $(btn).empty().append(`Verifikasi`).prop('disabled', false);
                }
                return;
            }

            if (result.isConfirmed) {
                if (step == 3) {
                    $("#modal-checklist-equipment").modal('show');
                    return;
                }

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
                            }, 2000);
                        }

                        if (step == 4) {
                            $(btn).empty().append(`Selesai`).prop('disabled', false);
                        } else {
                            $(btn).empty().append(`Verifikasi`).prop('disabled', false);
                        }

                    })
                    .catch(error => {
                        console.log('Error:', error);
                    })
                    .finally(() => {
                    });
            }
            hideLoading(1000);
        });
    })

    $("#btn-reject").click(function (){
        let id = $("#id").val();
        let url = $("#reject-url").val();
        url = url.replace(":id", id);
        let formData = new FormData();
        formData.append("id", id);

        Swal.fire({
            html: `<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 text-danger"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg>
                    <h3>Apakah anda yakin</h3>
                    <div class="text-secondary" style="font-size: 14px !important;">Apakah Anda benar ingin menolak data ini?</div>`,
            confirmButtonText: 'Tolak',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-danger w-100',
                cancelButton: 'btn w-100'
            },
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $("#modal-reject").modal('show');

                quillReject = new Quill('#editor-reject', {
                    theme: 'snow'
                });

                const btnRejectConfirm = "#btn-reject-confirm";

                $("#btn-reject-confirm").off('click').on('click', function () {
                    btnLoading(btnRejectConfirm);
                    let message = quillReject.root.innerHTML;
                    let noHtml = quillReject.getText().trim();
                    formData.append('message', message);
                    formData.append('nohtml', noHtml);

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
                                }, 2000);
                            }

                            if (data.errors || data.invalid) {
                                let messages = data.errors || data.invalid;
                                $(".invalid-feedback").remove();
                                for (let i in messages) {
                                    for (let t in messages[i]) {
                                        $("[key=" + i + "]")
                                            .addClass("is-invalid")
                                            .after(
                                                '<div class="text-left invalid-feedback">' +
                                                messages[i][t] +
                                                "</div>"
                                            );
                                    }

                                    // remove message if event key press
                                    $("[key=" + i + "]").keypress(function () {
                                        $("[key=" + i + "]").removeClass("is-invalid");
                                    });

                                    // remove message if event change
                                    $("[key=" + i + "]").change(function () {
                                        $("[key=" + i + "]").removeClass("is-invalid");
                                    });
                                }
                            }
                        })
                        .catch(error => {
                            console.log('Error:', error);
                        })
                        .finally(() => {
                            $(btnRejectConfirm).empty().append("Konfirmasi").prop('disabled', false);
                        });
                })
            }
            hideLoading(1000);
        });
    })

    $("#btn-send-mail").click(function () {
        let id = $("#id").val();
        let message = quill.root.innerHTML;
        let url = $("#mail-url").val();
        url = url.replace(":id", id);
        let formData = new FormData();
        let btn = "#btn-send-mail";
        let step = $("#step").val();
        let title = '';

        if (step == 2) {
            title = 'Jadwal Verifikasi Zoom';
        }

        if (step == 3) {
            title = 'Jadwal Verifikasi Lapangan';
        }

        formData.append("id", id);
        formData.append('message', message);
        formData.append('title', title);

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
                }

                $(btn).empty().append("Kirim");

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                $(btn).empty().append("Kirim");
            });
    })
});
