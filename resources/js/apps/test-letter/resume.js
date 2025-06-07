import {formatRupiah, hideLoading, resetValidation, swalSuccess} from "@/apps/utils/helper.js";
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
            { data: 'user.name', name: 'user.name', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'workshop_type', name: 'workshop_type', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'status', name: 'status', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'action', name: 'action', className: 'text-nowrap', orderable: false, searchable: false},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
        ],
    });

    $("#table").on("click", ".show-modal-physical", function () {
        let id = $(this).data("id");
        let url = $("#show-physical-test-url").val();
        url = url.replace(":id", id);

        // send data
        fetch(url, {
            method: 'GET',
        })
            .then(response => {
                return response.json();
            })
            .then(res => {
                if(res.code == 200) {
                    $(".modal-title").empty().append("Upload Resume Hasil Uji");
                    $("#id").val(res.data.id);

                    $("#modal-test-physical").modal("show");
                    resetValidation();
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                hideLoading(1000);
            });
    })

    $("#form-test-physical").submit(function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let btn = "#btn-upload-physical-test";
        let form = "#form-test-physical";
        let modal = "#modal-test-physical";
        let url = $("#upload-physical-test-url").val()

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

                    window.location.reload();
                }

                if (data.errors || data.invalid) {
                    new handleValidation(data.errors || data.invalid)
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                hideLoading(1000);
                $(btn).empty().append("Upload");
            });
    })
});
