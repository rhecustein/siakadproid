<?php

use Illuminate\Support\Facades\Route;

// Academic
use App\Http\Controllers\Academic\{
    AcademicYearController,
    CetakRaportController,
    ClassEnrollmentController,
    ClassroomAssignmentController,
    CurriculumController,
    EkstrakurikulerController,
    GradeDetailController,
    GradeInputController,
    GradeLevelController,
    GradePromotionController,
    GradeReportController,
    GradesController,
    KelulusanController,
    KenaikanController,
    LaporanKenaikanController,
    LaporanNilaiController,
    LessonTimeController,
    LevelController,
    MemorizationReportController,
    OnlineExamController,
    PengampuController,
    PrintReportController,
    RaporController,
    RaportsController,
    ReportCardController,
    StoranHafalanController,
    StudentNoteController,
    SubjectController,
    SubjectTeacherController,
    TeacherController,
    TimetableController,
    UjianController,
    UjianOnlineController
};

// Admission
use App\Http\Controllers\Admission\{
    AdmissionController,
    AdmissionFileController,
    AdmissionPaymentController,
    AdmissionScheduleController,
    AdmissionSelectionController,
    FormulirController,
    VerifikasiController
};

// Canteen
use App\Http\Controllers\Canteen\{
    CanteenBalanceController,
    CanteenCashShiftController,
    CanteenController,
    CanteenProductCategoryController,
    CanteenProductController,
    CanteenProductStockController,
    CanteenPurchaseController,
    CanteenPurchaseItemController,
    CanteenPurchaseRequestController,
    CanteenSaleController,
    CanteenSaleItemController,
    CanteenSettingController,
    CanteenShoppingListController,
    CanteenStockOpnameController,
    CanteenSupplierController,
    CanteenTransactionController,
    CanteenUserController,
    POSController
};

// Communication
use App\Http\Controllers\Communication\{
    AnnouncementCommentController,
    AnnouncementController,
    AnnouncementFilesController,
    AnnouncementUserController
};

// Core
use App\Http\Controllers\Core\{
    RoleHasPermissionsController,
    RolePermissionController,
    RolesController,
    SessionsController,
    UsersController
};

// Employee
use App\Http\Controllers\Employee\{
    ActivityLogController,
    EmployeeAttendanceController,
    EmployeeController,
    EmployeeDisciplinaryController,
    EmployeeLeaveController,
    EmployeeOvertimeController,
    EmployeeSalaryController,
    EmployeeStatusController,
    EmployeeTrainingController,
    PayrollController,
    PerformanceReviewController,
    PromotionLogController,
    StaffsController
};

// Facility
use App\Http\Controllers\Facility\{
    LaundryRecordController,
    ParkingLogController,
    ParkirController
};

// Finance
use App\Http\Controllers\Finance\{
    BankAccountController,
    BillController,
    BillGroupController,
    BillPaymentController,
    BillReportController,
    BillTypeController,
    BsiVaLogController,
    TopupController,
    VirtualAccountController,
    WalletController,
    WalletLogController,
    WalletTransactionController,
    WalletTransferController
};

// Healthcare
use App\Http\Controllers\Healthcare\{
    MedicalRecordController,
    MedicineStockController
};

// Parent
use App\Http\Controllers\Parent\{
    InboxSchoolController,
    MessageSchoolController,
    ParentChildController,
    PermissionSchoolController
};

// Religion
use App\Http\Controllers\Religion\{
    MemorizationSubmissionController,
    MengajiController,
    MonthlyTahfidzTargetController,
    MurojaahController,
    QuranReadingController,
    QuranReviewScheduleController,
    StoranController,
    TahfidzProgressController
};

// Setting
use App\Http\Controllers\Setting\{
    SettingController
};

// Shared
use App\Http\Controllers\Shared\{
    BranchController,
    BuildingsController,
    CityController,
    ConfigController,
    DistrictController,
    DomainsController,
    ProvincesController,
    RoomController,
    SchoolController,
    SchoolYearController,
    SemesterController,
    VillagesController
};

// Student
use App\Http\Controllers\Student\{
    CounselingHistoryController,
    CounselingScheduleController,
    ParentController,
    StudentCaseController,
    StudentController,
    StudentIllnessController
};



// Route definitions grouped by role and section will follow here...

// ======================================================
// ROUTES: PUBLIC / GUEST
// ======================================================
Route::get('/', fn() => view('welcome'));
Route::get('/ai', fn() => view('ai.index'));
Route::get('/pos', fn() => view('canteen.pos'));
Route::get('/dashboard', fn() => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

// ======================================================
// ROUTES: AUTHENTICATED USERS
// ======================================================
Route::middleware('auth')->group(function () {

    // ================================
    // PROFILE & AKUN
    // ================================
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // ================================
    // ADMIN - SISTEM & PENGATURAN
    // ================================
    Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UsersController::class);
        Route::resource('jobs', JobsController::class)->except(['show']);
        Route::resource('settings', SettingController::class);
        Route::resource('activity-logs', ActivityLogController::class);
        Route::resource('role-permissions', RolePermissionController::class);
    });

    // ADMIN - Master Data
    Route::middleware('auth')->prefix('admin/master')->name('master.')->group(function () {
        Route::resources([
            'schools' => SchoolController::class,
            'academic_years' => AcademicYearController::class,
            'subjects' => SubjectController::class,
            'teachers' => TeacherController::class,
            'homeroom' => HomeroomAssignmentController::class,
            'students' => StudentController::class,
            'parents' => ParentController::class,
            'branches' => BranchController::class,
            'curriculums' => CurriculumController::class,
            'majors' => MajorController::class,
            'classrooms' => ClassroomController::class,
            'levels' => LevelController::class,
            'grade-levels' => GradeLevelController::class,
            'semesters' => SemesterController::class,
            'bank-accounts' => BankAccountController::class,
            'bill-types' => BillTypeController::class,
        ]);
        //academic_years.activate
        Route::get('academic_years/{academic_year}/activate', [AcademicYearController::class, 'activate'])->name('academic_years.activate');
        //master.curriculums.activate
        Route::get('curriculums/{curriculum}/activate', [CurriculumController::class, 'activate'])->name('curriculums.activate');
        Route::get('curriculums/{curriculum}/deactivate', [CurriculumController::class, 'deactivate'])->name('curriculums.deactivate');
    });

    // ADMIN - Pengumuman
    Route::resource('announcements', AnnouncementController::class);
    Route::get('announcements/list', [AnnouncementController::class, 'manage'])->name('announcements.list');
    Route::post('announcements/{announcement}/read', [AnnouncementController::class, 'markAsRead'])->name('announcements.read');
    Route::post('announcements/{announcement}/comment', [AnnouncementController::class, 'comment'])->name('announcements.comment');


    // ================================
    // ADMIN - Akademik & Penilaian
    // ================================
    Route::prefix('admin/academic')->name('academic.')->group(function () {

    // Penilaian Harian
    Route::get('grades/daily', [DailyAssessmentController::class, 'index'])->name('grades.daily.index');
    Route::get('grades/daily/create', [DailyAssessmentController::class, 'create'])->name('grades.daily.create');
    Route::post('grades/daily', [DailyAssessmentController::class, 'store'])->name('grades.daily.store');
    Route::get('grades/daily/{id}', [DailyAssessmentController::class, 'show'])->name('grades.daily.show');
    Route::get('grades/daily/{id}/edit', [DailyAssessmentController::class, 'edit'])->name('grades.daily.edit');
    Route::put('grades/daily/{id}', [DailyAssessmentController::class, 'update'])->name('grades.daily.update');
    Route::delete('grades/daily/{id}', [DailyAssessmentController::class, 'destroy'])->name('grades.daily.destroy');

    // Nilai Ujian
    Route::get('grades/exams', [ExamScoreController::class, 'index'])->name('grades.exams.index');
    Route::get('grades/exams/create', [ExamScoreController::class, 'create'])->name('grades.exams.create');
    Route::post('grades/exams', [ExamScoreController::class, 'store'])->name('grades.exams.store');
    Route::get('grades/exams/{id}', [ExamScoreController::class, 'show'])->name('grades.exams.show');
    Route::get('grades/exams/{id}/edit', [ExamScoreController::class, 'edit'])->name('grades.exams.edit');
    Route::put('grades/exams/{id}', [ExamScoreController::class, 'update'])->name('grades.exams.update');
    Route::delete('grades/exams/{id}', [ExamScoreController::class, 'destroy'])->name('grades.exams.destroy');

    // Nilai Ekskul
    Route::get('grades/extracurricular', [ExtracurricularScoresController::class, 'index'])->name('grades.extracurricular.index');
    Route::get('grades/extracurricular/create', [ExtracurricularScoresController::class, 'create'])->name('grades.extracurricular.create');
    Route::post('grades/extracurricular', [ExtracurricularScoresController::class, 'store'])->name('grades.extracurricular.store');
    Route::get('grades/extracurricular/{id}', [ExtracurricularScoresController::class, 'show'])->name('grades.extracurricular.show');
    Route::get('grades/extracurricular/{id}/edit', [ExtracurricularScoresController::class, 'edit'])->name('grades.extracurricular.edit');
    Route::put('grades/extracurricular/{id}', [ExtracurricularScoresController::class, 'update'])->name('grades.extracurricular.update');
    Route::delete('grades/extracurricular/{id}', [ExtracurricularScoresController::class, 'destroy'])->name('grades.extracurricular.destroy');

    // Rapor
    Route::get('report-cards', [ReportCardController::class, 'index'])->name('report-cards.index');
    Route::get('report-cards/create', [ReportCardController::class, 'create'])->name('report-cards.create');
    Route::post('report-cards', [ReportCardController::class, 'store'])->name('report-cards.store');
    //edit
    Route::get('report-cards/{id}/edit', [ReportCardController::class, 'edit'])->name('report-cards.edit');
    Route::put('report-cards/{id}', [ReportCardController::class, 'update'])->name('report-cards.update');
    //delete
    Route::delete('report-cards/{id}', [ReportCardController::class, 'destroy'])->name('report-cards.destroy');
    //show
    Route::get('report-cards/{id}', [ReportCardController::class, 'show'])->name('report-cards.show');

    // Kenaikan
    Route::get('promotions', [KenaikanController::class, 'index'])->name('promotions.index');
    Route::post('promotions', [KenaikanController::class, 'store'])->name('promotions.store');

    // Kelulusan
    Route::get('graduations', [GraduationController::class, 'index'])->name('graduations.index');
    Route::post('graduations', [GraduationController::class, 'store'])->name('graduations.store');

    // Pengampu Mapel
    Route::get('subject-teachers', [SubjectTeacherController::class, 'index'])->name('subject-teachers.index');
    Route::post('subject-teachers', [SubjectTeacherController::class, 'store'])->name('subject-teachers.store');
    Route::delete('subject-teachers/{id}', [SubjectTeacherController::class, 'destroy'])->name('subject-teachers.destroy');

    // Laporan Nilai
    Route::get('grade-reports', [GradeReportController::class, 'index'])->name('grade-reports.index');

    // Laporan Storan Hafalan Memorize Storage
    Route::get('memorization-reports', [MemorizationReportController::class, 'index'])->name('memorization-reports.index');
    Route::get('memorization-reports/create', [MemorizationReportController::class, 'create'])->name('memorization-reports.create');
    Route::post('memorization-reports', [MemorizationReportController::class, 'store'])->name('memorization-reports.store');
    Route::get('memorization-reports/{id}/edit', [MemorizationReportController::class, 'edit'])->name('memorization-reports.edit');
    Route::put('memorization-reports/{id}', [MemorizationReportController::class, 'update'])->name('memorization-reports.update');
    Route::delete('memorization-reports/{id}', [MemorizationReportController::class, 'destroy'])->name('memorization-reports.destroy');
    Route::get('memorization-reports/{id}', [MemorizationReportController::class, 'show'])->name('memorization-reports.show');

    // laporan kenaikan kelas grade promotion
    Route::get('report-grade-promotions', [GradePromotionController::class, 'index'])->name('grade-promotions.index');

    //online exam
    Route::get('online-exams', [OnlineExamController::class, 'index'])->name('online-exams.index');
    Route::get('online-exams/create', [OnlineExamController::class, 'create'])->name('online-exams.create');
    Route::post('online-exams', [OnlineExamController::class, 'store'])->name('online-exams.store');
    Route::get('online-exams/{id}', [OnlineExamController::class, 'show'])->name('online-exams.show');
    Route::get('online-exams/{id}/edit', [OnlineExamController::class, 'edit'])->name('online-exams.edit');
    Route::put('online-exams/{id}', [OnlineExamController::class, 'update'])->name('online-exams.update');
    Route::delete('online-exams/{id}', [OnlineExamController::class, 'destroy'])->name('online-exams.destroy');

    //print report
    Route::get('print-reports', [PrintReportController::class, 'index'])->name('print-reports.index');

     // Timetable (Jadwal Pelajaran)
    Route::get('timetables', [TimetableController::class, 'index'])->name('timetables.index');
    Route::get('timetables/create', [TimetableController::class, 'create'])->name('timetables.create');
    Route::post('timetables', [TimetableController::class, 'store'])->name('timetables.store');
    Route::get('timetables/{id}', [TimetableController::class, 'show'])->name('timetables.show');
    Route::get('timetables/{id}/edit', [TimetableController::class, 'edit'])->name('timetables.edit');
    Route::put('timetables/{id}', [TimetableController::class, 'update'])->name('timetables.update');
    Route::delete('timetables/{id}', [TimetableController::class, 'destroy'])->name('timetables.destroy');

    // Pengelolaan Kelas Paralel dan Wali Kelas
    Route::get('classroom-assignments', [ClassroomAssignmentController::class, 'index'])->name('classroom-assignments.index');
    Route::get('classroom-assignments/create', [ClassroomAssignmentController::class, 'create'])->name('classroom-assignments.create');
    Route::post('classroom-assignments', [ClassroomAssignmentController::class, 'store'])->name('classroom-assignments.store');
    Route::get('classroom-assignments/{id}/edit', [ClassroomAssignmentController::class, 'edit'])->name('classroom-assignments.edit');
    Route::put('classroom-assignments/{id}', [ClassroomAssignmentController::class, 'update'])->name('classroom-assignments.update');
    Route::delete('classroom-assignments/{id}', [ClassroomAssignmentController::class, 'destroy'])->name('classroom-assignments.destroy');
    Route::get('classroom-assignments/{id}', [ClassroomAssignmentController::class, 'show'])->name('classroom-assignments.show');

    // Catatan Siswa
    Route::get('student-notes', [StudentNoteController::class, 'index'])->name('student-notes.index');
    Route::get('student-notes/create', [StudentNoteController::class, 'create'])->name('student-notes.create');
    Route::post('student-notes', [StudentNoteController::class, 'store'])->name('student-notes.store');
    Route::get('student-notes/{id}', [StudentNoteController::class, 'show'])->name('student-notes.show');
    Route::get('student-notes/{id}/edit', [StudentNoteController::class, 'edit'])->name('student-notes.edit');
    Route::put('student-notes/{id}', [StudentNoteController::class, 'update'])->name('student-notes.update');
    Route::delete('student-notes/{id}', [StudentNoteController::class, 'destroy'])->name('student-notes.destroy');

    // Penempatan Kelas Siswa
    Route::get('class-enrollments', [ClassEnrollmentController::class, 'index'])->name('class-enrollments.index');
    Route::get('class-enrollments/create', [ClassEnrollmentController::class, 'create'])->name('class-enrollments.create');
    Route::post('class-enrollments', [ClassEnrollmentController::class, 'store'])->name('class-enrollments.store');
    Route::get('class-enrollments/{id}', [ClassEnrollmentController::class, 'show'])->name('class-enrollments.show');
    Route::get('class-enrollments/{id}/edit', [ClassEnrollmentController::class, 'edit'])->name('class-enrollments.edit');
    Route::put('class-enrollments/{id}', [ClassEnrollmentController::class, 'update'])->name('class-enrollments.update');
    Route::delete('class-enrollments/{id}', [ClassEnrollmentController::class, 'destroy'])->name('class-enrollments.destroy');
    Route::get('class-enrollments/group', [ClassEnrollmentController::class, 'showGroup'])->name('class-enrollments.show_group');

    Route::get('/ajax/available-times', [TimetableController::class, 'availableTimes'])->name('timetables.available-times');
});


    // KURIKULUM KEISLAMAN
    Route::prefix('admin/tahfidz')->name('tahfidz.')->group(function () {
    Route::get('monthly', [MonthlyTahfidzTargetController::class, 'index'])->name('monthly.index');
    Route::get('monthly/create', [MonthlyTahfidzTargetController::class, 'create'])->name('monthly.create');
    Route::post('monthly', [MonthlyTahfidzTargetController::class, 'store'])->name('monthly.store');

    //progress
    Route::get('progress', [TahfidzProgressController::class, 'index'])->name('progress.index');
    Route::get('progress/create', [TahfidzProgressController::class, 'create'])->name('progress.create');
    Route::post('progress', [TahfidzProgressController::class, 'store'])->name('progress.store');
    Route::get('progress/{progress}/edit', [TahfidzProgressController::class, 'edit'])->name('progress.edit');
    Route::put('progress/{progress}', [TahfidzProgressController::class, 'update'])->name('progress.update');
    Route::delete('progress/{progress}', [TahfidzProgressController::class, 'destroy'])->name('progress.destroy');

    //setoran
    Route::get('submissions', [MemorizationSubmissionController::class, 'index'])->name('submissions.index');
    Route::get('submissions/create', [MemorizationSubmissionController::class, 'create'])->name('submissions.create');
    Route::post('submissions', [MemorizationSubmissionController::class, 'store'])->name('submissions.store');
    Route::get('submissions/{memorizationSubmission}/edit', [MemorizationSubmissionController::class, 'edit'])->name('submissions.edit');
    Route::put('submissions/{memorizationSubmission}', [MemorizationSubmissionController::class, 'update'])->name('submissions.update');
    Route::delete('submissions/{memorizationSubmission}', [MemorizationSubmissionController::class, 'destroy'])->name('submissions.destroy');

    //mengaji
    Route::get('readings', [QuranReadingController::class, 'index'])->name('readings.index');
    Route::get('readings/create', [QuranReadingController::class, 'create'])->name('readings.create');
    Route::post('readings', [QuranReadingController::class, 'store'])->name('readings.store');
    Route::get('readings/{quranReading}/edit', [QuranReadingController::class, 'edit'])->name('readings.edit');
    Route::put('readings/{quranReading}', [QuranReadingController::class, 'update'])->name('readings.update');
    Route::delete('readings/{quranReading}', [QuranReadingController::class, 'destroy'])->name('readings.destroy');

    //schedule
    Route::get('schedules', [QuranReviewScheduleController::class, 'index'])->name('schedules.index');
    Route::get('schedules/create', [QuranReviewScheduleController::class, 'create'])->name('schedules.create');
    Route::post('schedules', [QuranReviewScheduleController::class, 'store'])->name('schedules.store');
    Route::get('schedules/{quranReviewSchedule}/edit', [QuranReviewScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('schedules/{quranReviewSchedule}', [QuranReviewScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('schedules/{quranReviewSchedule}', [QuranReviewScheduleController::class, 'destroy'])->name('schedules.destroy');
    });

    Route::prefix('admissions')->name('admissions.')->group(function () {
        Route::get('/', [AdmissionController::class, 'index'])->name('index');
        Route::get('/create', [AdmissionController::class, 'create'])->name('create'); // 👈 pindah ke atas
        Route::post('/', [AdmissionController::class, 'store'])->name('store');
        Route::get('/{id}', [AdmissionController::class, 'show'])->name('show');
        Route::get('/{id}/verify', [AdmissionController::class, 'verify'])->name('verify');
        Route::post('/{id}/status-log', [AdmissionController::class, 'storeStatusLog'])->name('status-log.store');
        Route::get('/verifikasi/list', [AdmissionController::class, 'listForVerification'])->name('verify.list');
        Route::get('/{id}/payment', [AdmissionController::class, 'paymentForm'])->name('payment.form');
        Route::post('/{id}/payment', [AdmissionController::class, 'storePayment'])->name('payment.store');
    });
    Route::resource('admission-schedules', AdmissionScheduleController::class)->except(['show']);
    Route::get('admission-payments', [AdmissionPaymentController::class, 'index'])->name('admission_payments.index');

    // ================================
    // ADMIN - Kepegawaian
    // ================================
    Route::resources([
        'employees' => EmployeeController::class,
        'employee-statuses' => EmployeeStatusController::class,
        'employee-salaries' => EmployeeSalaryController::class,
        'employee-leaves' => EmployeeLeaveController::class,
        'employee-overtimes' => EmployeeOvertimeController::class,
        'employee-attendances' => EmployeeAttendanceController::class,

    ]);

    // ADMIN - Kesehatan
    // ================================
    Route::resources([
        'medical-records' => MedicalRecordController::class,
        'student-illnesses' => StudentIllnessController::class,
        'medicine-stocks' => MedicineStockController::class,
    ]);

    // ================================
    // ADMIN - BK & Konseling
    // ================================
    Route::resources([
        'student-cases' => StudentCaseController::class,
        'counseling-schedules' => CounselingScheduleController::class,
        'counseling-histories' => CounselingHistoryController::class,
    ]);

    // ================================
    // ADMIN - Kesiswaan & Dokumen
    // ================================
    Route::resource('admission-selections', AdmissionSelectionController::class);
    Route::resource('admission-files', AdmissionFileController::class);

    // ================================
    // ADMIN - Kehadiran & Absensi
    // ================================
    // Kehadiran (Absensi)
    Route::get('absences', [AbsenceRecordController::class, 'index'])->name('absences.index');
    Route::get('absences/create', [AbsenceRecordController::class, 'create'])->name('absences.create');
    Route::post('absences', [AbsenceRecordController::class, 'store'])->name('absences.store');
    Route::get('absences/{id}', [AbsenceRecordController::class, 'show'])->name('absences.show');
    Route::get('absences/{id}/edit', [AbsenceRecordController::class, 'edit'])->name('absences.edit');
    Route::put('absences/{id}', [AbsenceRecordController::class, 'update'])->name('absences.update');
    Route::delete('absences/{id}', [AbsenceRecordController::class, 'destroy'])->name('absences.destroy');

    // ================================
    // ADMIN - Inventaris & Ruangan
    // ================================
    Route::resources([
        'rooms' => RoomController::class,
        'inventories' => InventoryController::class,
        'inventory-types' => InventoryTypeController::class,
        'inventory-conditions' => InventoryConditionController::class,
    ]);

    // ================================
    // ADMIN - Jadwal & Semester
    // ================================
    Route::resources([
        'schedules' => SchedulesController::class,
       
        'school-years' => SchoolYearController::class,
    ]);

    // ================================
    // ADMIN - Fasilitas
    // ================================
    Route::resources([
        'canteen-transactions' => CanteenTransactionController::class,
        'parking-logs' => ParkingLogController::class,
        'laundry-records' => LaundryRecordController::class,
        'document-archives' => DocumentArchiveController::class,
    ]);


    // ================================
    // ORANG TUA / WALI
    // ================================
    Route::middleware('role:orang_tua')->prefix('parent')->name('parent.')->group(function () {
        Route::resource('students', ParentChildController::class);
        Route::get('messages', [MessageSchoolController::class, 'messages'])->name('messages.index');
        Route::get('messages/create', [MessageSchoolController::class, 'createMessage'])->name('messages.create');
        Route::post('messages', [MessageSchoolController::class, 'storeMessage'])->name('messages.store');
        Route::get('messages/{id}', [MessageSchoolController::class, 'showMessage'])->name('messages.show');
        Route::get('messages/{id}/edit', [MessageSchoolController::class, 'editMessage'])->name('messages.edit');
        Route::put('messages/{id}', [MessageSchoolController::class, 'updateMessage'])->name('messages.update');

        Route::get('permissions', [PermissionSchoolController::class, 'permissions'])->name('permissions.index');
        Route::get('permissions/create', [PermissionSchoolController::class, 'createPermission'])->name('permissions.create');
        Route::post('permissions', [PermissionSchoolController::class, 'storePermission'])->name('permissions.store');
        Route::get('permissions/{id}', [PermissionSchoolController::class, 'showPermission'])->name('permissions.show');
        Route::get('permissions/{id}/edit', [PermissionSchoolController::class, 'editPermission'])->name('permissions.edit');
        Route::put('permissions/{id}', [PermissionSchoolController::class, 'updatePermission'])->name('permissions.update');
    });

    // ================================
    // KEUANGAN ADMIN
    // ================================
    Route::prefix('admin/finance')->middleware(['auth'])->name('finance.')->group(function () {
    Route::get('/wallets', [WalletController::class, 'index'])->name('wallets.index');
    Route::get('/wallets/{wallet}/topup', [TopupController::class, 'create'])->name('wallet.topup');
    Route::post('/wallets/{wallet}/topup', [TopupController::class, 'store'])->name('wallet.topup.store');
    Route::get('/wallets/{wallet}/transfer', [WalletController::class, 'transferForm'])->name('wallet.transfer');
    Route::post('/wallets/{wallet}/transfer', [WalletController::class, 'transfer'])->name('wallet.transfer.store');
    Route::get('/wallets/{wallet}/transactions', [WalletController::class, 'transactions'])->name('wallet.transactions');

    //topup
    Route::get('/topup', [TopupController::class, 'index'])->name('topup.index');
    Route::get('/topup/create', [TopupController::class, 'create'])->name('topup.create');
    Route::post('/topup', [TopupController::class, 'store'])->name('topup.store');
    
    //history // log
    Route::get('wallet/logs', [WalletController::class, 'logs'])->name('logs.index');
    Route::get('/wallets/{wallet}/transactions', [WalletController::class, 'transactions'])->name('wallet.transactions');
    Route::get('/wallets/{wallet}/transfer-multi', [WalletController::class, 'multiTransferForm'])->name('wallet.transfer.multi');
    Route::post('/wallets/{wallet}/transfer-multi', [WalletController::class, 'multiTransfer'])->name('wallet.transfer.multi.store');
    Route::get('/wallets/{wallet}/transfer-multi/create', [WalletController::class, 'createMultiTransfer'])->name('wallet.transfer.multi.create');

    //bill
     Route::resource('bill-groups', BillGroupController::class)->except(['show']);

     //tagihan & pembayaran
       // Route khusus untuk generate tagihan masal
    Route::get('bills/generate-masal', [BillController::class, 'generateMasalForm'])
        ->name('bills.generate-masal');

    Route::post('bills/generate-masal', [BillController::class, 'generateMasal'])
        ->name('bills.generate-masal.store');

     Route::resource('bills', BillController::class)->except(['show']);
     Route::get('bills/{bill}', [BillController::class, 'show'])->name('bills.show');


     Route::resource('payments', BillPaymentController::class)->except(['show']);
     Route::resource('bill-reports', BillReportController::class)->except(['show']);
     

    });

    Route::prefix('canteen')->middleware(['auth'])->group(function () {

    Route::get('/pos', [POSController::class, 'index'])->name('canteen.pos');
    Route::resource('products', CanteenProductController::class)->names('canteen.products');
    //canteen.reports.pareto
    Route::get('/reports/pareto', [CanteenReportController::class, 'paretoIndex'])->name('canteen.reports.pareto');
    Route::resource('product_categories', CanteenProductCategoryController::class)->names('canteen.product_categories');
    
    Route::resource('sales', CanteenSaleController::class)->only(['index', 'show'])->names('canteen.sales');

    // Pembelian
    Route::resource('purchases', CanteenPurchaseController::class)->names('canteen.purchases');

    // Permintaan Pembelian
    Route::resource('purchase-requests', CanteenPurchaseRequestController::class)->names('canteen.purchase_requests');

    // Supplier
    Route::resource('suppliers', CanteenSupplierController::class)->names('canteen.suppliers');

    // Pengguna Kantin
    Route::resource('users', CanteenUserController::class)->names('canteen.users');

    Route::get('/shifts', [CanteenCashShiftController::class, 'index'])->name('canteen.shifts.index');
    Route::get('/shifts/open', [CanteenCashShiftController::class, 'open'])->name('canteen.shifts.open');
    Route::post('/shifts', [CanteenCashShiftController::class, 'store'])->name('canteen.shifts.store');
    Route::post('/shifts/{id}/close', [CanteenCashShiftController::class, 'close'])->name('canteen.shifts.close');

    //canteen.stock_opname.index
    Route::get('/stock-opnames', [CanteenStockOpnameController::class, 'index'])->name('canteen.stock_opname.index');
    //create
    Route::get('/stock-opnames/create', [CanteenStockOpnameController::class, 'create'])->name('canteen.stock_opname.create');
    //canteen.shopping_list
    Route::get('/shopping-lists', [CanteenShoppingListController::class, 'index'])->name('canteen.shopping_list');
     Route::get('/shopping-lists/{id}', [CanteenShoppingListController::class, 'show'])->name('canteen.shopping_list.show');
    Route::post('/shopping-lists/{id}/receive', [CanteenShoppingListController::class, 'markAsReceived'])->name('canteen.shopping_list.receive');
    //create
    Route::get('/shopping-lists/create', [CanteenShoppingListController::class, 'create'])->name('canteen.shopping_list.create');
    
   

});
   

    // Tambahkan route-role spesifik lainnya di sini jika dibutuhkan...

}); // End of Route::middleware('auth')

require __DIR__.'/auth.php';
