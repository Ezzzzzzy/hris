<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * on system intitialization
         * defaults are:
         *  - region
         *  - tenure_type
         *  - employment_status
         *  - reason
         *  - document type
         *  - permission
         *  - admin
         */
        $this->call([
            // ClientSeeder::class,
            // BusinessUnitSeeder::class,
            // BrandSeeder::class,

            RegionSeeder::class,
            // CitySeeder::class,
            // LocationSeeder::class,

            // BranchSeeder::class,

            TenureTypeSeeder::class,
            // PositionSeeder::class,
            EmploymentStatusSeeder::class,
            ReasonSeeder::class,

            // AddressCitySeeder::class,
            // MemberSeeder::class,

            // ClientWorkHistorySeeder::class,
            // BranchWorkHistorySeeder::class,
            // DisciplinaryActionSeeder::class,

            // MobileNumberSeeder::class,
            // TelephoneNumberSeeder::class,

            // EmploymentHistorySeeder::class,

            DocumentTypeSeeder::class,
            // DocumentSeeder::class,

            // ReferenceSeeder::class,
            // SchoolSeeder::class,

            // FamilyMemberSeeder::class,
            // EmergencyContactSeeder::class,
            // RoleTableSeeder::class,
            PermissionTableSeeder::class,
            // UserSeeder::class,
            // ReportSeeder::class,
            AdminSeeder::class,
        ]);

        echo('Database seeded!!!');
    }
}
