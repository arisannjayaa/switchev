import Swal from "sweetalert2";
import {csrfToken} from "@/app.js";

export function resetValidation() {
    $(".form-control").removeClass("is-invalid");
    $(".form-select").removeClass("is-invalid");
}

export function reloadTable(id) {
    var table = $(id).DataTable();
    table.cleanData;
    table.ajax.reload();
}

export function swalSuccess(message) {
    Swal.fire({
        html: `<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 text-green"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path><path d="M9 12l2 2l4 -4"></path></svg>
                            <h3>Berhasil</h3>
                            <div class="text-secondary">${message}</div>`,
        confirmButtonText: 'Ok',
        confirmButtonColor: '#2fb344',
        customClass: {
            confirmButton: 'btn btn-success w-100'
        }
    });
}

export function swalError(errors) {
    console.log(errors)
    Swal.fire({
        html: `<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-danger"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>
                            <h3>Terjadi Kesalahan</h3>
        <div>${handleModalError(errors)}</div>`,
        confirmButtonText: 'Ok',
        confirmButtonColor: '#d63939',
        customClass: {
            confirmButton: 'btn btn-success w-100'
        }
    });
}

export function handleModalError(errors) {
    let html = '';
    for (let i in errors) {
        for (let t in errors[i]) {
            html += `<div class="alert alert-danger" style="font-size: 14px !important;" role="alert">
                      ${errors[i][t]}
                    </div>`;
        }
    }

    return html;
}

export function loadingScreen() {
    const html = `<div class="loading-screen">
                        <div class="container container-tight">
                            <div class="text-center">
                                <div class="mb-3">
                                    <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo-small.svg" height="36" alt=""></a>
                                </div>
                                <div class="text-secondary mb-3">Mohon Menunggu</div>
                                <div class="progress progress-sm">
                                    <div class="progress-bar progress-bar-indeterminate"></div>
                                </div>
                            </div>
                        </div>
                    </div>`;

    $("body").append(html);
}

export function hideLoading(second = 1000) {
    $(".page").removeClass("d-none");
    setTimeout(() => {
        $(".loading-screen").remove();
    }, second);
}
