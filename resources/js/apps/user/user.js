import {hideLoading, loadingScreen, reloadTable, resetValidation} from "@/apps/utils/helper.js";
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
            { data: 'name', name: 'name', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'email', name: 'email', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'telephone', name: 'telephone', className: 'text-nowrap', orderable: false, searchable: true},
            { data: 'action', name: 'action', className: 'text-nowrap', orderable: false, searchable: false},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
        ],
    });

    $('#btn-add').click(function () {
        $("#form-user")[0].reset();
        $("#id").val("");
        $("#modal-user").modal('show');
        $('.modal-title').empty().append('Tambah User');
        resetValidation();
    });

    $("#form-user").submit(function (e) {
        e.preventDefault();
        loadingScreen();

        let id = $("#id").val();
        let formData = new FormData(this);
        let btn = "#btn-submit";
        let table = "#table";
        let form = "#form-user";
        let modal = "#modal-user";

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

                    reloadTable(table);
                    $(form)[0].reset();
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
                $(btn).empty().append("Simpan");
            });
    });

    $("#table").on("click", ".edit", function () {
        let id = $(this).data("id");
        let url = $("#edit-url").val();
        url = url.replace(":id", id);
        loadingScreen();

        // send data
        fetch(url, {
            method: 'GET',
        })
            .then(response => {
                return response.json();
            })
            .then(res => {
                console.log(res);
                if(res.code == 200) {
                    $(".modal-title").empty().append("Edit User");
                    $("#id").val(res.data.id);
                    $("#name").val(res.data.name);
                    $("#email").val(res.data.email);
                    $("#telephone").val(res.data.telephone);

                    $("#modal-user").modal("show");
                    resetValidation();
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                hideLoading(1000);
            });
    });


    $("#table").on("click", ".delete", function () {
        let id = $(this).data("id");
        let url = $("#delete-url").val();
        let table = "#table";
        let formData = new FormData();
        formData.append("id", id);
        loadingScreen();

        Swal.fire({
            html: `<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 text-danger"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg>
                    <h3>Apakah anda yakin</h3>
                    <div class="text-secondary" style="font-size: 14px !important;">Apakah Anda benar-benar ingin menghapus data ini? Apa yang telah Anda lakukan tidak dapat dibatalkan.</div>`,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
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
                            reloadTable(table);

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

                    })
                    .catch(error => {
                        console.log('Error:', error);
                    })
                    .finally(() => {
                        hideLoading();
                    });
            }
            hideLoading(1000);
        });
    });
});
