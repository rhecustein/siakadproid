<?php

use Illuminate\Support\Facades\Route;

// Default fallback route
Route::get('/', function () {
    return view('welcome');
});

// =====================
// 📚 Academic
// =====================
use App\Http\Controllers\Academic\{
    AcademicYearController,
    CetakRaportController,
    ClassEnrollmentController,
    ClassroomAssignmentController,
    ClassroomController,
    ClassroomScheduleController,
    CurriculumController,
    DailyAssessmentController,
    EnrollmentController,
    EkstrakurikulerController,
    ExamScoreController,
    GradeDetailController,
    GradeInputController,
    GradeLevelController,
    GradePromotionController,
    GradeReportController,
    GradeController,
    GradeExamController,
    GradeExtraCurricularController,
    GradeGraduationController,
    GradeDailyController,
    HomeroomAssignmentController,
    KelulusanController,
    KenaikanController,
    LaporanKenaikanController,
    LaporanNilaiController,
    LessonTimeController,
    LevelController,
    MemorizationReportController,
    MajorController,
    OnlineExamController,
    PengampuController,
    PrintReportController,
    RaporController,
    RaportController,
    ReportCardController,
    StoranHafalanController,
    StudentNoteController,
    SchedulesController,
    SubjectController,
    SubjectTeacherController,
    TeacherController,
    TimetableController,
    UjianController,
    UjianOnlineController
};

Route::prefix('academic')->name('academic.')->group(function () {
    Route::get('class-enrollments/group/{level_id}/{grade_level_id}/{classroom_id}/{academic_year_id}/{semester_id}', [ClassEnrollmentController::class, 'show_group'])
    ->name('class-enrollments.show_group');
    Route::resource('academic-years', AcademicYearController::class);
    Route::match(['post', 'patch'], '{id}/activate', [AcademicYearController::class, 'activate'])->name('academic-years.activate');
    Route::resource('curriculums', CurriculumController::class);
    Route::resource('classrooms', ClassroomController::class);
    Route::resource('classroom-assignments', ClassroomAssignmentController::class);
    Route::resource('class-enrollments', ClassEnrollmentController::class);
   

    Route::resource('classrooms-schedules', ClassroomScheduleController::class);
    Route::resource('daily-assessments', DailyAssessmentController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('exam-scores', ExamScoreController::class);
    Route::resource('ekstrakurikuler', EkstrakurikulerController::class);
    Route::resource('schedules', SchedulesController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('teachers', TeacherController::class);
    
    Route::resource('grades', GradeController::class);
    Route::resource('grade-exams', GradeExamController::class);
    Route::get('grade-exams/{id}/input', [GradeExamController::class, 'input'])->name('grade-exams.input');

    Route::resource('grade-extracurriculars', GradeExtraCurricularController::class);
    Route::resource('grade-details', GradeDetailController::class);
    Route::resource('grade-inputs', GradeInputController::class);
    //grade-exams. input

    Route::resource('grade-levels', GradeLevelController::class);
    Route::resource('grade-promotions', GradePromotionController::class);
    Route::resource('grade-reports', GradeReportController::class);
    Route::resource('grade-graduations', GradeGraduationController::class);
    Route::resource('grade-dailies', GradeDailyController::class);
    Route::resource('homeroom', HomeroomAssignmentController::class);
    Route::resource('levels', LevelController::class);
    Route::resource('lessons', LessonTimeController::class);
    Route::resource('online-exams', OnlineExamController::class);
    Route::resource('print-reports', PrintReportController::class);
    Route::resource('pengampu', PengampuController::class);
    Route::resource('rapors', RaporController::class);
    Route::resource('raports', RaportController::class);
    Route::resource('report-cards', ReportCardController::class);
    Route::resource('student-notes', StudentNoteController::class);
    Route::resource('subjects-teachers', SubjectTeacherController::class);
    Route::resource('timetables', TimetableController::class);
    Route::resource('ujians', UjianController::class);
    Route::resource('ujian-onlines', UjianOnlineController::class);
    Route::resource('kelulusans', KelulusanController::class);
    Route::resource('kenaikans', KenaikanController::class);
    Route::resource('laporan-kenaikans', LaporanKenaikanController::class);
    Route::resource('laporan-nilais', LaporanNilaiController::class);
    Route::resource('cetak-raports', CetakRaportController::class);
    Route::resource('memorization-reports', MemorizationReportController::class);
    Route::resource('majors', MajorController::class);
    Route::resource('storan-hafalans', StoranHafalanController::class);
    //SubjectTeacherController
    Route::resource('subject-teachers', SubjectTeacherController::class);
    //StudentNoteController
    Route::resource('student-notes', StudentNoteController::class);
    Route::resource('curriculums', CurriculumController::class);
    Route::post('{id}/activate', [CurriculumController::class, 'activate'])->name('curriculums.activate');
    Route::post('{id}/deactivate', [CurriculumController::class, 'deactivate'])->name('curriculums.deactivate');

});

// ========== Tambahan grup lain dapat dimasukkan di bawah ini mengikuti struktur di atas ==========


// =====================
// 🎓 Admission
// =====================
use App\Http\Controllers\Admission\{
    AdmissionController,
    AdmissionFileController,
    AdmissionPaymentController,
    AdmissionScheduleController,
    AdmissionSelectionController,
    
    FormulirController,
    VerifikasiController
};

Route::prefix('admission')->name('admission.')->group(function () {
    Route::resource('admissions', AdmissionController::class);
    Route::resource('files', AdmissionFileController::class);
    Route::resource('payments', AdmissionPaymentController::class);
    Route::resource('schedules', AdmissionScheduleController::class);
    Route::resource('selections', AdmissionSelectionController::class);
    Route::resource('forms', FormulirController::class);
    Route::resource('verifications', VerifikasiController::class);
});

// =====================
// 🥘 Canteen
// =====================
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

Route::prefix('canteen')->name('canteen.')->group(function () {
    Route::resource('transactions', CanteenTransactionController::class);
    Route::resource('products', CanteenProductController::class);
    Route::resource('sales', CanteenSaleController::class);
    Route::resource('purchases', CanteenPurchaseController::class);
    Route::resource('pos', POSController::class);
    Route::resource('users', CanteenUserController::class);
    Route::resource('suppliers', CanteenSupplierController::class);
    Route::resource('categories', CanteenProductCategoryController::class);
    Route::resource('stocks', CanteenProductStockController::class);
    Route::resource('stock-opnames', CanteenStockOpnameController::class);
    Route::resource('cash-shifts', CanteenCashShiftController::class);
    Route::resource('balances', CanteenBalanceController::class);
    Route::resource('settings', CanteenSettingController::class);
    Route::resource('shopping-lists', CanteenShoppingListController::class);
    Route::get('shopping-lists/receive/{id}', [CanteenShoppingListController::class, 'receive'])->name('shopping-lists.receive');
    Route::resource('purchase-requests', CanteenPurchaseRequestController::class);
    Route::resource('purchase-items', CanteenPurchaseItemController::class);
    Route::resource('sales-items', CanteenSaleItemController::class);
    Route::resource('purchase-orders', CanteenPurchaseController::class);
    Route::resource('canteens', CanteenController::class);
});

// =====================
// 📢 Communication
// =====================
use App\Http\Controllers\Communication\{
    AnnouncementCommentController,
    AnnouncementController,
    AnnouncementFilesController,
    AnnouncementUserController,
    EventsController,
    EventTypesController,
};

Route::prefix('communication')->name('communication.')->group(function () {
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('announcement-comments', AnnouncementCommentController::class);
    Route::resource('announcement-users', AnnouncementUserController::class);
    Route::resource('announcement-files', AnnouncementFilesController::class);
    Route::resource('events', EventsController::class);
    Route::resource('event-types', EventTypesController::class);
});

// =====================
// 🛠️ Core
// =====================
use App\Http\Controllers\Core\{
    AttendanceController,
    EmployeeAttendanceController,
    RolePermissionController,
    RolesController,
    SessionsController,
    UsersController,
    DashboardController,
    ParentManagementController,
    FingerprintController,
    StudentManagementController,
    ManualAttendanceController,
    AttendanceRecapController,
    AttendanceScheduleController,
    FingerprintLogController,
    AiController,
    PermissionsController,
    UserRoleController,
    DataVisualizationController,

};

Route::prefix('core')->name('core.')->group(function () {

    Route::get('/map', [DataVisualizationController::class, 'index'])->name('map.index');

    // AI Module Routes
    Route::prefix('ai')->name('ai.')->group(function () {
        Route::get('/', [AiController::class, 'index'])->name('index');
        Route::post('/chat', [AiController::class, 'chat'])->name('chat');
        Route::post('/upload-document', [AiController::class, 'uploadDocument'])->name('upload.document');
        Route::post('/generate-content', [AiController::class, 'generateContent'])->name('generate.content');
        Route::post('/generate-visualization', [AiController::class, 'generateVisualization'])->name('generate.visualization');
        Route::post('/query-database', [AiController::class, 'queryDatabase'])->name('query.database');
        // Future feature routes can be added here
        Route::post('/future-feature', [AiController::class, 'futureFeatureExample'])->name('future.feature');
    });

    Route::prefix('access')->name('access.')->group(function () {
        // Role Management
        Route::resource('roles', RolesController::class); // CRUD untuk Peran
        // Permission Management
        Route::resource('permissions', PermissionsController::class); // CRUD untuk Izin
        // Role-Permission Assignment
        Route::get('role-permissions', [RolePermissionController::class, 'index'])->name('role-permissions.index');
        Route::get('role-permissions/{role}/edit', [RolePermissionController::class, 'edit'])->name('role-permissions.edit');
        Route::put('role-permissions/{role}', [RolePermissionController::class, 'update'])->name('role-permissions.update');
        // User-Role Assignment
        Route::get('user-roles', [UserRoleController::class, 'index'])->name('user-roles.index');
        Route::get('user-roles/{user}/edit', [UserRoleController::class, 'edit'])->name('user-roles.edit');
        Route::put('user-roles/{user}', [UserRoleController::class, 'update'])->name('user-roles.update');
    });

    Route::resource('roles', RolesController::class);
    Route::resource('users', UsersController::class);
     // Tambah sidik jari
    Route::get('{user}/fingerprint/create', [FingerprintController::class, 'create'])->name('fingerprint.create');
    Route::post('{user}/fingerprint', [FingerprintController::class, 'store'])->name('fingerprint.store');

    // Aktifkan & Nonaktifkan user
    Route::post('{user}/activate', [UsersController::class, 'activate'])->name('users.activate');
    Route::post('{user}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');

    Route::resource('parents', ParentManagementController::class);
    Route::resource('students', StudentManagementController::class);
    Route::resource('role-permissions', RolePermissionController::class);
    Route::resource('sessions', SessionsController::class);
    Route::resource('dashboard', DashboardController::class);   
    // 🔹 Absensi Umum (Student & Teacher)
    Route::resource('attendances', AttendanceController::class)->except(['edit', 'update']);
    Route::get('manual-input', [AttendanceController::class, 'manual'])->name('attendances.manual-input');
    Route::post('manual', [AttendanceController::class,'storeManual'])->name('attendances.manual.store');

    // 🔹 Absensi Pegawai / Karyawan
    Route::prefix('employee-attendance')->group(function () {
        Route::get('/', [EmployeeAttendanceController::class, 'index'])->name('employee.attendance.index');
        Route::post('/check-in', [EmployeeAttendanceController::class, 'checkIn'])->name('employee.attendance.checkin');
        Route::post('/check-out', [EmployeeAttendanceController::class, 'checkOut'])->name('employee.attendance.checkout');
        Route::get('/summary', [EmployeeAttendanceController::class, 'summary'])->name('employee.attendance.summary');
    });

    // 🔹 Rekap Absensi
    Route::prefix('attendance-recap')->group(function () {
        Route::get('/daily', [AttendanceRecapController::class, 'dailyRecap'])->name('attendance.recap.daily');
        Route::get('/monthly', [AttendanceRecapController::class, 'monthlyRecap'])->name('attendance.recap.monthly');
        Route::get('/download/{userId}/{month}', [AttendanceRecapController::class, 'cetakRekapBulanan'])->name('attendance.recap.download');
    });

    // 🔹 Jadwal Absensi
    Route::get('attendance-schedule', [AttendanceScheduleController::class, 'index'])->name('attendance.schedule.index');
    Route::post('attendance-schedule', [AttendanceScheduleController::class, 'store'])->name('attendance.schedule.store');
    Route::delete('attendance-schedule/{id}', [AttendanceScheduleController::class, 'destroy'])->name('attendance.schedule.delete');

    // 🔹 Log Fingerprint Device
    Route::get('fingerprint/logs', [FingerprintLogController::class, 'logs'])->name('fingerprint.logs');
    Route::post('fingerprint/scan', [FingerprintLogController::class, 'logScan'])->name('fingerprint.scan');
});

// =====================
// 👷 Employee
// =====================
use App\Http\Controllers\Employee\{
    ActivityLogController,
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
    StaffController,
};
 
Route::prefix('employee')->name('employee.')->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('staffs', StaffController::class);
    Route::resource('activity-logs', ActivityLogController::class);
    Route::resource('promotions', PromotionLogController::class);
    Route::resource('leave-requests', EmployeeLeaveController::class);
    Route::resource('overtimes', EmployeeOvertimeController::class);
    Route::resource('trainings', EmployeeTrainingController::class);
    Route::resource('disciplinary-cases', EmployeeDisciplinaryController::class);
    Route::resource('attendance-logs', EmployeeAttendanceController::class);
    Route::resource('salary-logs', EmployeeSalaryController::class);
    Route::resource('status-logs', EmployeeStatusController::class);
    Route::resource('payrolls', PayrollController::class);
    Route::resource('performance-reviews', PerformanceReviewController::class);
});

// =====================
// 🏫 Facility
// =====================
use App\Http\Controllers\Facility\{
    LaundryRecordController,
    ParkingLogController,
    ParkirController,
    RoomController,
    DocumentArchiveController,
    InventoryController,
    InventoryTypeController,
    InventoryConditionController,
};

Route::prefix('facility')->name('facility.')->group(function () {
    Route::resource('parkir', ParkirController::class);
    Route::resource('parking-logs', ParkingLogController::class);
    Route::resource('laundry-records', LaundryRecordController::class);
    Route::resource('rooms', RoomController::class);
    
    Route::resource('document-archives', DocumentArchiveController::class);
    Route::resource('inventories', InventoryController::class);
    Route::resource('inventory-types', InventoryTypeController::class);
    Route::resource('inventory-conditions', InventoryConditionController::class);
});

// =====================
// 💰 Finance
// =====================
use App\Http\Controllers\Finance\{
    BankAccountController,
    BillController,
    BillGroupController,
    BillPaymentController,
    BillReportController,
    BillTypeController,
    BillGenerateController,
    BillManualController,
    UnpaidBillController,
    IncomingTransactionController,
    OutgoingTransactionController,
    JournalEntryController,
    BsiVaLogController,
    TopupController,
    VirtualAccountController,
    WalletController,
    WalletLogController,
    WalletTransactionController,
    WalletTransferController,
    MonthlyRecapController,
    FinancialReportController,
}; 

Route::prefix('finance')->name('finance.')->group(function () {
    Route::resource('wallets', WalletController::class);
    Route::resource('bills', BillController::class);
    Route::resource('bill-types', BillTypeController::class);
    Route::resource('bill-groups', BillGroupController::class);
    Route::resource('bill-payments', BillPaymentController::class); 
    Route::resource('bill-reports', BillReportController::class);
    Route::resource('bill-generates', BillGenerateController::class);
    Route::resource('bill-manuals', BillManualController::class);
    Route::resource('unpaid-bills', UnpaidBillController::class);
    Route::resource('wallet-logs', WalletLogController::class);
    Route::resource('wallet-transactions', WalletTransactionController::class);
    Route::resource('wallet-transfers', WalletTransferController::class);
    Route::resource('incoming-transactions', IncomingTransactionController::class);
    Route::resource('outgoing-transactions', OutgoingTransactionController::class);
    Route::resource('journal-entries', JournalEntryController::class);
    Route::resource('virtual-accounts', VirtualAccountController::class);
    Route::resource('bsi-va-logs', BsiVaLogController::class);
    Route::resource('topups', TopupController::class);
    Route::resource('bank-accounts', BankAccountController::class);
    Route::resource('monthly-recaps', MonthlyRecapController::class);
    Route::get('financial-reports', [FinancialReportController::class, 'index'])->name('financial-reports.index');
    Route::get('financial-reports/balance-sheet', [FinancialReportController::class, 'balanceSheet'])->name('financial-reports.balance-sheet');
    Route::get('financial-reports/profit-loss', [FinancialReportController::class, 'profitLoss'])->name('financial-reports.profit-loss');
    Route::get('financial-reports/changes-in-equity', [FinancialReportController::class, 'changesInEquity'])->name('financial-reports.changes-in-equity');
    Route::get('financial-reports/cash-flow', [FinancialReportController::class, 'cashFlow'])->name('financial-reports.cash-flow');

    //tambahan 
});

// =====================
// 🏥 Healthcare
// =====================
use App\Http\Controllers\Healthcare\{
    MedicalRecordController,
    MedicineStockController
};

Route::prefix('healthcare')->name('healthcare.')->group(function () {
    Route::resource('medical-records', MedicalRecordController::class);
    Route::resource('medicine-stocks', MedicineStockController::class);
});

// =====================
// 👪 Parent
// =====================
use App\Http\Controllers\Parent\{
    InboxSchoolController,
    MessageSchoolController,
    ParentChildController,
    PermissionSchoolController
};

Route::prefix('parent')->name('parent.')->group(function () {
    Route::resource('children', ParentChildController::class);
    Route::resource('permissions', PermissionSchoolController::class);
    Route::resource('inbox', InboxSchoolController::class);
    Route::resource('messages', MessageSchoolController::class);
});

// =====================
// 🕌 Religion
// =====================
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

Route::prefix('religion')->name('religion.')->group(function () {
    Route::resource('mengaji', MengajiController::class);
    Route::resource('murojaah', MurojaahController::class);
    Route::resource('quran-readings', QuranReadingController::class);
    Route::resource('quran-review-schedules', QuranReviewScheduleController::class);
    Route::resource('storan', StoranController::class);
    Route::resource('monthly-tahfidz-targets', MonthlyTahfidzTargetController::class);
    Route::resource('tahfidz-progresses', TahfidzProgressController::class);
    Route::resource('memorization-submissions', MemorizationSubmissionController::class);
});

// =====================
// ⚙️ Setting
// =====================
use App\Http\Controllers\Setting\{
    SettingController
};

Route::prefix('setting')->name('setting.')->group(function () {
    Route::resource('general', SettingController::class);
});

// =====================
// 🏛 Shared
// =====================
use App\Http\Controllers\Shared\{
    BranchController,
    BuildingsController,
    CityController,
    ConfigController,
    DistrictController,
    DomainsController,
    ProvincesController,
    SchoolController,
    SchoolYearController,
    SemesterController,
    VillagesController
};

Route::prefix('shared')->name('shared.')->group(function () {
    Route::resource('branches', BranchController::class);
    Route::resource('buildings', BuildingsController::class);
    Route::resource('cities', CityController::class);
    Route::resource('configs', ConfigController::class);
    Route::resource('districts', DistrictController::class);
    Route::resource('domains', DomainsController::class);
    Route::resource('provinces', ProvincesController::class);
    Route::resource('schools', SchoolController::class);
    Route::resource('school-years', SchoolYearController::class);
    Route::resource('semesters', SemesterController::class);
    Route::resource('villages', VillagesController::class);
});

// =====================
// 🎓 Student
// =====================
use App\Http\Controllers\Student\{
    CounselingHistoryController,
    CounselingScheduleController,
    ParentController as StudentParentController,
    StudentCaseController,
    StudentController,
    StudentIllnessController,
    AbsenceController,
    AbsenceTypeController,
    AttendancesController,
};

Route::prefix('student')->name('student.')->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('parents', StudentParentController::class);
    Route::resource('student-illnesses', StudentIllnessController::class);
    Route::resource('student-cases', StudentCaseController::class);
    Route::resource('counseling-schedules', CounselingScheduleController::class);
    Route::resource('counseling-histories', CounselingHistoryController::class);
    Route::resource('absences', AbsenceController::class);
    Route::resource('absence-types', AbsenceTypeController::class);
});


use App\Http\Controllers\Api\AttendanceApiController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::post('/update-fingerprint', [AttendanceApiController::class, 'update'])
    ->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/test-users', [AttendanceApiController::class, 'getAllUsers']);




require __DIR__.'/auth.php';

