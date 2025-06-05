<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\CertificateTestLetterController;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MechanicalController;
use App\Http\Controllers\SecureFileController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TestLetterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

date_default_timezone_set('Asia/Makassar');

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::get('/register', [RegistrationController::class, 'index'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/registration', [RegistrationController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // user
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'create'])->name('create');
        Route::get('/table', [UserController::class, 'table'])->name('table');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::post('/delete', [UserController::class, 'delete'])->name('delete');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
    });

    Route::prefix('akun')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/ubah-kata-sandi', [AccountController::class, 'change_password'])->name('change.password');
        Route::post('/ubah-kata-sandi', [AccountController::class, 'change_password_submit'])->name('change.password.submit');
        Route::post('/update-akun', [AccountController::class, 'update_account'])->name('update');
    });

    // conversion
    Route::prefix('conversion')->name('conversion.')->group(function () {
        Route::get('/', [ConversionController::class, 'index'])->name('index');
        Route::post('/form', [ConversionController::class, 'formResponsibleWorkshop'])->name('form');
        Route::post('/upsert', [ConversionController::class, 'upsertFormResponsibleWorkshop'])->name('upsertFormResponsibleWorkshop');
        Route::post('/upsert/document', [ConversionController::class, 'upsertFormDocument'])->name('upsertFormDocument');
        Route::get('/table', [ConversionController::class, 'table'])->name('table');
        Route::post('/update', [ConversionController::class, 'update'])->name('update');
        Route::post('/delete', [ConversionController::class, 'delete'])->name('delete');
        Route::post('/checklist', [ConversionController::class, 'checklist'])->name('checklist');
        Route::post('/approve', [ConversionController::class, 'approve'])->name('approve');
        Route::post('/reject', [ConversionController::class, 'reject'])->name('reject');
        Route::post('/send-mail', [ConversionController::class, 'sendMail'])->name('send-mail');
        Route::get('/form/step/{step}/{id?}', [ConversionController::class, 'formResponsibleWorkshop'])->name('form');
        Route::get('/verification/{id}', [ConversionController::class, 'verification'])->name('verification');
        Route::get('/proses-detail/{id}', [ConversionController::class, 'process_detail'])->name('process.detail');
        Route::get('/{id}', [ConversionController::class, 'show'])->name('show');
    });

    // mechanical
    Route::prefix('mechanical')->name('mechanical.')->group(function () {
        Route::get('/', [MechanicalController::class, 'index'])->name('index');
        Route::post('/', [MechanicalController::class, 'create'])->name('create');
        Route::get('/table/{conversion_id}', [MechanicalController::class, 'table'])->name('table');
        Route::post('/update', [MechanicalController::class, 'update'])->name('update');
        Route::post('/delete', [MechanicalController::class, 'delete'])->name('delete');
        Route::post('/check-available', [MechanicalController::class, 'checkIsAvailable'])->name('check.available');
        Route::get('/{id}', [MechanicalController::class, 'show'])->name('show');
    });

    // equipment
    Route::prefix('equipment')->name('equipment.')->group(function () {
        Route::get('/', [EquipmentController::class, 'index'])->name('index');
        Route::post('/', [EquipmentController::class, 'create'])->name('create');
        Route::get('/table/{conversion_id}', [EquipmentController::class, 'table'])->name('table');
        Route::post('/update', [EquipmentController::class, 'update'])->name('update');
        Route::post('/delete', [EquipmentController::class, 'delete'])->name('delete');
        Route::post('/check-available', [EquipmentController::class, 'checkIsAvailable'])->name('check.available');
        Route::get('/{id}', [EquipmentController::class, 'show'])->name('show');
    });

    Route::prefix('certificate')->name('certificate.')->group(function () {
        Route::get('/daftar-permohonan', [\App\Http\Controllers\CertificateController::class, 'index'])->name('index');
        Route::post('/verifikasi', [\App\Http\Controllers\CertificateController::class, 'verify_draft'])->name('verification');
        Route::post('/export', [\App\Http\Controllers\CertificateController::class, 'export_data'])->name('export');
        Route::get('/table', [\App\Http\Controllers\CertificateController::class, 'table'])->name('table');
        Route::post('/generate-certificate', [\App\Http\Controllers\CertificateController::class, 'generate_certificate'])->name('generate.certificate');
        Route::post('/generate-sk', [\App\Http\Controllers\CertificateController::class, 'generate_sk'])->name('generate.sk');
        Route::post('/upload-archive', [\App\Http\Controllers\CertificateController::class, 'upload_archive'])->name('upload.archive');
        Route::post('/send-draft', [\App\Http\Controllers\CertificateController::class, 'send_draft'])->name('send.draft');
        Route::get('/verifikasi/{id}', [\App\Http\Controllers\CertificateController::class, 'verify_draft_view'])->name('verification.form');
        Route::get('/certification-form/{conversion_id}}', [\App\Http\Controllers\CertificateController::class, 'certification_form'])->name('certificate.form');
    });

    Route::prefix('pelayanan/sut-srut')->name('test.letter.')->group(function () {
        Route::get('/', [TestLetterController::class, 'index'])->name('index');
        Route::post('/', [TestLetterController::class, 'upsert_form'])->name('upsert.form');
        Route::get('/table', [TestLetterController::class, 'table'])->name('table');
        Route::post('/update', [TestLetterController::class, 'update'])->name('update');
        Route::post('/delete', [TestLetterController::class, 'delete'])->name('delete');
        Route::post('/approve', [TestLetterController::class, 'approve'])->name('approve');
        Route::post('/physical-test', [TestLetterController::class, 'upload_physical_test_letter'])->name('upload_physical_test_letter');
        Route::get('/form-registration/{id?}', [TestLetterController::class, 'form'])->name('form');
        Route::get('/generate-surat-spu/{id}', [TestLetterController::class, 'generate_spu'])->name('generate.spu');
        Route::post('/generate-surat-spu', [TestLetterController::class, 'generate_spu_submit'])->name('generate.spu.submit');
        Route::post('/send-surat-spu', [TestLetterController::class, 'send_spu'])->name('send.spu.submit');
        Route::post('/approve-srut', [TestLetterController::class, 'approve_srut'])->name('approve.srut');
        Route::get('/permohonan-sertifikat-srut/{id}', [TestLetterController::class, 'permohonan_sertifikat_srut_form'])->name('permohonan.srut');
        Route::post('/permohonan-sertifikat-srut', [TestLetterController::class, 'permohonan_sertifikat_srut_submit'])->name('permohonan.srut.submit');
        Route::get('verification-srut/{id}', [TestLetterController::class, 'verification_srut'])->name('verification.srut');
        Route::get('verification/{id}', [TestLetterController::class, 'verification'])->name('verification');
        Route::get('sertifikat/{id}', [TestLetterController::class, 'certificate'])->name('certificate');
        Route::get('/physical-test/{id}', [TestLetterController::class, 'show_physical_test_letter'])->name('show_physical_test_letter');
        Route::get('/{id}', [TestLetterController::class, 'show'])->name('show');
        Route::get('/detail-permohonan/{id}', [TestLetterController::class, 'show_guest'])->name('show.guest');
    });

    Route::prefix('pelayanan/sut-srut/sertifikat-surat-keterangan')->name('certificate.test.letter.')->group(function () {
        Route::get('/daftar-permohonan', [CertificateTestLetterController::class, 'index'])->name('index');
        Route::get('/table', [CertificateTestLetterController::class, 'table'])->name('table');
        Route::post('/send-draft', [CertificateTestLetterController::class, 'send_draft'])->name('send.draft');
        Route::post('/upload-archive', [\App\Http\Controllers\CertificateTestLetterController::class, 'upload_archive'])->name('upload.archive');
        Route::post('/sertifikat', [CertificateTestLetterController::class, 'certificate_form_submit'])->name('certificate.submit');
        Route::post('/generate-certificate-srut', [CertificateTestLetterController::class, 'generate_certificate_srut'])->name('generate.certificate.srut');
        Route::post('/generate-certificate-sut', [CertificateTestLetterController::class, 'generate_certificate_sut'])->name('generate.certificate.sut');
        Route::post('/generate-sk', [CertificateTestLetterController::class, 'generate_sk'])->name('generate.sk');
        Route::post('/generate-certificate-attachment', [CertificateTestLetterController::class, 'generate_certificate_attachment'])->name('generate.certificate.attachment');
        Route::post('/verifikasi-draft', [\App\Http\Controllers\CertificateTestLetterController::class, 'verify_draft'])->name('verification.draft.submit');
        Route::post('/request-hasil-uji', [\App\Http\Controllers\CertificateTestLetterController::class, 'request_testing'])->name('request.testing');

        Route::post('/export', [\App\Http\Controllers\CertificateTestLetterController::class, 'export_data'])->name('export');

        Route::get('/verifikasi-draft/{id}', [\App\Http\Controllers\CertificateTestLetterController::class, 'verify_draft_view'])->name('verification.draft.form');
        Route::get('/sertifikat/{id}', [CertificateTestLetterController::class, 'certificate'])->name('certificate');
        Route::get('/sertifikat-srut/{id}', [CertificateTestLetterController::class, 'certificate_srut'])->name('certificate.srut');
        Route::get('/generate/{id}', [CertificateTestLetterController::class, 'generate'])->name('generate');
        Route::get('/{id}', [CertificateTestLetterController::class, 'show'])->name('show');
    });

    Route::prefix('hasil-uji')->name('testing.')->group(function () {
        Route::get('/', [CertificateTestLetterController::class, 'index_testing'])->name('index');
        Route::get('/table', [CertificateTestLetterController::class, 'table_testing'])->name('table');
        Route::post('/update', [CertificateTestLetterController::class, 'form_testing_submit'])->name('update');
        Route::get('/form/{id}', [CertificateTestLetterController::class, 'form_testing'])->name('form');
    });

    // template
    Route::prefix('template')->name('template.')->group(function () {
        Route::get('/', [TemplateController::class, 'index'])->name('index');
        Route::get('/table', [TemplateController::class, 'table'])->name('table');
        Route::post('/update', [TemplateController::class, 'update'])->name('update');
        Route::get('/form/{id}', [TemplateController::class, 'form'])->name('form');
        Route::get('/{id}', [TemplateController::class, 'detail'])->name('detail');
    });


});

Route::prefix('/')->name('home.')->group(function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');
});


Route::get('/s/{path}', [SecureFileController::class, 'index'])->name('secure.file');
Route::get('/d/{path}', [SecureFileController::class, 'download'])->name('secure.file.download');
Route::get('/qr-code/{path}', [SecureFileController::class, 'index'])->name('qr.secure.file');
