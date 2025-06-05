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

    $("#table").DataTable({
        order: [[0, 'desc']],
        ordering: true,
        serverSide: true,
        processing: true,
        autoWidth: false,
        responsive: true,
        ajax: {
            url: tableUrl,
            data: function (d) {
                d.status_conversion = $("#status-filter").val() ?? "";
                d.workshop_type = $("#workshop-type-filter").val() ?? "";
                d.date_range = $("#date-range").val() ?? "";
            }
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
            { data: 'conversion.type', name: 'conversion.type', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'conversion.certificate_code', name: 'conversion.certificate_code', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'conversion.sk_code', name: 'conversion.sk_code', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'status', name: 'status', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'action', name: 'action', className: 'text-nowrap', orderable: false, searchable: false},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
        ],
    });

    const isCertificate = $("#is-certificate-ready").val();
    $("#btn-approve").prop('disabled', true);

    if (isCertificate == 1) {
        $("#btn-approve").prop('disabled', false);
    }

    $("#btn-apply-filter").on('click', function() {
        $("#table").DataTable().ajax.reload();
    });

    // Hanya preset, tanpa custom range
    $('#date-range').daterangepicker({
        autoUpdateInput: false,
        showCustomRangeLabel: true,
        locale: {
            format: 'YYYY-MM-DD',
            applyLabel: 'Pilih',
            cancelLabel: 'Bersihkan',
        },
        opens: 'left',
        ranges: {
            'Hari Ini': [moment(), moment()],
            'Minggu Ini': [moment().startOf('week'), moment().endOf('week')],
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
        }
    });

    // Saat preset dipilih
    $('#date-range').on('apply.daterangepicker', function (ev, picker) {
        const start = picker.startDate.format('YYYY-MM-DD');
        const end = picker.endDate.format('YYYY-MM-DD');
        $(this).val(`${start} - ${end}`);
         $("#table").DataTable().ajax.reload();
    });

    // Saat dibersihkan
    $('#date-range').on('cancel.daterangepicker', function () {
        $(this).val('');
         $("#table").DataTable().ajax.reload();
    });

    $('#btn-export').on('click', function () {
        let formData = new FormData();
        const range = $('#date-range').val();
        const status = $('#status-filter').val();
        const workshop_type = $('#workshop-type-filter').val();
        formData.append('date_range', range);
        formData.append('status', status);
        formData.append('type', workshop_type);
        const url = $('#export-url').val();

        $('#btn-export').empty().append(`<div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                                </div>`).prop('disabled', true);

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
                console.log(data);
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
                    for (let i in data.errors) {
                        for (let t in data.errors[i]) {
                            $("[name=" + i + "]")
                                .addClass("is-invalid");
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

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                $("#btn-export").empty().append(`
                    Export
                `).prop('disabled', false);
            });
    });


    $("#btn-download-sk").click(function () {
        let url = $("#download-sk-url").val();
        let formData = new FormData();
        formData.append("id", $("#id").val());
        formData.append("accreditation_type", $("#accreditation_type").val());

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
        formData.append("accreditation_type", $("#accreditation_type").val());

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
        let id = $("#certificate_id").val();
        let userId = $("#user-id").val();
        let btn = "#btn-upload-archive";
        formData.append('sk_attachment', fileSk);
        formData.append('sft_attachment', fileCertificate);
        formData.append('conversion_id', conversionId);
        formData.append('user_id', userId);
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


    $("#btn-send-draft").click(function () {
        let url = $("#send-draft-url").val();
        let formData = new FormData();
        formData.append("id", $("#id").val());
        formData.append("accreditation_type", $("#accreditation_type").val());

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
});
