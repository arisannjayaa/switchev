import {formatRupiah, swalSuccess} from "@/apps/utils/helper.js";
import Swal from "sweetalert2";
import {csrfToken, handleValidation} from "@/app.js";

document.addEventListener('DOMContentLoaded', function() {
    function select_sepeda_motor() {
        return `
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_rem" value="Uji rem">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_rem" value="${formatRupiah(890000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_rem" id="vol_uji_rem" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_rem" id="total_uji_rem">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_lampu_utama" value="Uji lampu utama">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_lampu_utama" value="${formatRupiah(765000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_lampu_utama" id="vol_uji_lampu_utama" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_lampu_utama" id="total_uji_lampu_utama">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_speedometer" value="Uji speedometer">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_speedometer" value="${formatRupiah(1000000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_speedometer" id="vol_uji_speedometer" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_speedometer" id="total_uji_speedometer">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_kontruksi" value="Pemeriksaan konstruksi">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_kontruksi" value="${formatRupiah(445000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_kontruksi" id="vol_uji_kontruksi" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_kontruksi" id="total_uji_kontruksi">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_klakson" value="Uji klakson">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_klakson" value="${formatRupiah(710000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_klakson" id="vol_uji_klakson" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_klakson" id="total_uji_klakson">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_berat" value="Pengukuran berat kendaraan bermotor">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_berat" value="${formatRupiah(430000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_berat" id="vol_uji_berat" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_berat" id="total_uji_berat">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_dimensi" value="Pengukuran dimensi">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_dimensi" value="${formatRupiah(660000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_dimensi" id="vol_uji_dimensi" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_dimensi" id="total_uji_dimensi">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_kebisingan" value="Uji Kebisingan R 41">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_kebisingan" value="${formatRupiah(3000000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_kebisingan" id="vol_uji_kebisingan" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_kebisingan" id="total_uji_kebisingan">
                </td>
            </tr>
        `
    }

    function select_selain_sepeda_motor() {
        return `
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_rem" value="Uji rem">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_rem" value="${formatRupiah(1970000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_rem" id="vol_uji_rem" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_rem" id="total_uji_rem">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_lampu_utama" value="Uji lampu utama">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_lampu_utama" value="${formatRupiah(1050000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_lampu_utama" id="vol_uji_lampu_utama" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_lampu_utama" id="total_uji_lampu_utama">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_radius_putar" value="Uji lampu utama">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_radius_putar" value="${formatRupiah(500000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_radius_putar" id="vol_uji_radius_putar" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_radius_putar" id="total_uji_radius_putar">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_klakson" value="Uji klakson">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_klakson" value="${formatRupiah(1060000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_klakson" id="vol_uji_klakson" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_klakson" id="total_uji_klakson">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_side_slip" value="Uji kincup roda (side slip)">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_side_slip" value="${formatRupiah(1050000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_side_slip" id="vol_uji_side_slip" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_side_slip" id="total_uji_side_slip">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_berat" value="Pengukuran berat kendaraan bermotor">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_berat" value="${formatRupiah(870000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_berat" id="vol_uji_berat" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_berat" id="total_uji_berat">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_dimensi" value="Pengukuran dimensi">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_dimensi" value="${formatRupiah(1320000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_dimensi" id="vol_uji_dimensi" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_dimensi" id="total_uji_dimensi">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_speedometer" value="Uji speedometer">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_speedometer" value="${formatRupiah(3040000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_speedometer" id="vol_uji_speedometer" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_speedometer" id="total_uji_speedometer">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_kontruksi" value="Pemeriksaan konstruksi">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_kontruksi" value="${formatRupiah(3700000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_kontruksi" id="vol_uji_kontruksi" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_kontruksi" id="total_uji_kontruksi">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" readonly class="form-control" name="name_uji_kebisingan" value="Uji Kebisingan R 51">
                </td>
                <td>
                    <input type="text" readonly class="form-control convert-currency" name="amount_uji_kebisingan" value="${formatRupiah(7000000,"IDR",0)}">
                </td>
                <td>
                    <input type="number" class="form-control" name="vol_uji_kebisingan" id="vol_uji_kebisingan" value="0">
                </td>
                <td>
                    <input type="text" class="form-control" readonly value="${formatRupiah(0,"IDR",0)}" name="total_uji_kebisingan" id="total_uji_kebisingan">
                </td>
            </tr>
        `
    }

    // Fungsi untuk menghitung total
    function calculateTotal(type_vehicle) {
        let types = [];
        if (type_vehicle === "Sepeda Motor") {
            types = [
                { name: "uji_rem", amount: 890000 },
                { name: "uji_lampu_utama", amount: 765000 },
                { name: "uji_speedometer", amount: 1000000 },
                { name: "uji_kontruksi", amount: 445000 },
                { name: "uji_klakson", amount: 710000 },
                { name: "uji_berat", amount: 430000 },
                { name: "uji_dimensi", amount: 660000 },
                { name: "uji_kebisingan", amount: 3000000 },
            ];
        }

        if (type_vehicle === "Selain Sepeda Motor") {
            types = [
                { name: "uji_rem", amount: 1970000 },
                { name: "uji_lampu_utama", amount: 1050000 },
                { name: "uji_radius_putar", amount: 500000 },
                { name: "uji_speedometer", amount: 3040000 },
                { name: "uji_klakson", amount: 1060000 },
                { name: "uji_side_slip", amount: 1050000 },
                { name: "uji_berat", amount: 870000 },
                { name: "uji_dimensi", amount: 1320000 },
                { name: "uji_kontruksi", amount: 3700000 },
                { name: "uji_kebisingan", amount: 7000000 },];
        }

        types.forEach((item) => {
            const volume = parseFloat($(`#vol_${item.name}`).val()) || 0;
            const total = volume * item.amount;
            const formattedTotal = formatRupiah(total,"IDR",0);
            $(`#total_${item.name}`).val(formattedTotal);
        });
    }


    $('#type').on('change', function () {
        const jenis = $(this).val();
        const $tbody = $('#table-amount tbody');
        $tbody.empty();

        if (jenis === 'Sepeda Motor') {
            $tbody.append(select_sepeda_motor());
        } else if (jenis === 'Selain Sepeda Motor') {
            $tbody.append(select_selain_sepeda_motor());
        } else {
            $tbody.empty();
        }

        $(document).on('input', 'input[name^="vol_"]', function () {
            calculateTotal(jenis);
        });
    });

    $("#form-generate-spu").submit(function (e) {
        e.preventDefault();

        let id = $("#id").val();
        let formData = new FormData(this);
        let btn = "#btn-submit"
        let url = $("#generate-spu-url").val();

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
                    $(btn).empty().append('Generate Surat Pengantar Uji').prop('disabled', false);
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                $(btn).empty().append('Generate Surat Pengantar Uji').prop('disabled', false);
            });
    });

    $("#btn-send-spu-submit").click(function (e) {
        e.preventDefault();

        let id = $("#id").val();
        let formData = new FormData();
        formData.append('id', id);
        formData.append('spu_attachment', $('#spu_attachment')[0].files[0]);
        let btn = "#btn-send-spu-submit"
        let url = $("#send-spu-url").val();

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
                    $(btn).empty().append('Kirim').prop('disabled', false);
                }

            })
            .catch(error => {
                console.log('Error:', error);
            })
            .finally(() => {
                $(btn).empty().append('Kirim').prop('disabled', false);
            });
    });

    $("#btn-send-spu").click(function () {
        $(".modal-title").html('Kirim Surat Pengantar Uji');
        $("#modal-send-spu").modal("show");
    })
});
