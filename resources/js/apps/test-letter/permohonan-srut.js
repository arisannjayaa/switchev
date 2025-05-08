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
            { data: 'code', name: 'code', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'workshop_type', name: 'workshop_type', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'status', name: 'status', className: 'text-nowrap', orderable: false, searchable: true, render: function (data) { return '<span class="">'+capitalizeFirstLetter(data).status} },
            { data: 'action', name: 'action', className: 'text-nowrap', orderable: false, searchable: false},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
        ],
    });

    $("#permohonan_srut").change(function () {
        if ($('[name="old_permohonan_srut"]').length) {
            $('[name="old_permohonan_srut"]').remove();
        }
    })

    $("#quality_control").change(function () {
        if ($('[name="old_quality_control"]').length) {
            $('[name="old_quality_control"]').remove();
        }
    })

    $("#form-permohonan-srut").submit(function (e) {
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
                    $(btn).empty().append('Ajukan Pendaftaran').prop('disabled', false);
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
            });
    });

    $("#btn-approve").click(function (){
        let id = $("#id").val();
        let url = $("#approve-url").val();
        let btn = $("#btn-approve")
        let formData = new FormData();
        formData.append("id", id);
        formData.append("is_verified", 1);

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
                $(btn).empty().append(`Verifikasi`).prop('disabled', false);
            }

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
                                window.location.href = data.data.redirect;
                            }, 2000);
                        }

                    })
                    .catch(error => {
                        console.log('Error:', error);
                    })
                    .finally(() => {
                        $(btn).empty().append(`Verifikasi`).prop('disabled', true);
                    });
            }
            hideLoading(1000);
        });
    })
});
