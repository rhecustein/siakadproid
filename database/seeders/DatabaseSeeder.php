<?php

namespace Database\Seeders;

use App\Models\BillGroup;
use App\Models\BillType;
use App\Models\Branch;
use App\Models\ExamType;
use App\Models\GlAccount;
use App\Models\GradeLevel;
use App\Models\User;
use App\Models\Wallet;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            SubjectSeeder::class,
            CurriculumSeeder::class,
            // BranchSeeder::class,
            RoomSeeder::class,
            // LevelSeeder::class,
            AcademicYearSeeder::class,
            InitialSetupSchoolSeeder::class,
            MajorSeeder::class,
            TeacherSeeder::class,
            HomeroomAssignmentSeeder::class,
            // ClassroomSeeder::class,
            // GradeSeeder::class,
            ParentSeeder::class,
            StudentSeeder::class,
            AbsenceTypeSeeder::class,
            AnnouncementSeeder::class,
            AnnouncementCommentSeeder::class,
            LessonTimeSeeder::class,
            InventoryTypeSeeder::class,
            InventoryConditionSeeder::class,
            InventorySeeder::class,
            ScheduleSeeder::class,
            GlCategorySeeder::class,
            GlAccountSeeder::class,
            WalletSeeder::class,
            // GradeLevelSeeder::class,
            BillTypeSeeder::class,
            BillGroupSeeder::class,
             // Struktur utama
            CanteenSeeder::class,
            CanteenSupplierSeeder::class,
            CanteenUserSeeder::class,

            // Produk & stok awal
            CanteenProductCategorySeeder::class,
            CanteenProductSeeder::class,
            CanteenProductStockSeeder::class,

            // Penjualan (kasir)
            CanteenSaleSeeder::class,
            CanteenSaleItemSeeder::class,

            // Permintaan & pembelian stok
            CanteenPurchaseRequestSeeder::class,
            CanteenPurchaseSeeder::class,
            CanteenPurchaseItemSeeder::class,

            // semster
            SemesterSeeder::class,

            //LessonTimeSeeder
            LessonTimeSeeder::class,

            EmployeeSeeder::class,
            ExamTypeSeeder::class,

        ]);
       
    }
}
