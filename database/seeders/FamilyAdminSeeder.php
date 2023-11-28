<?php

namespace Database\Seeders;

use App\Constants\UserType;
use App\Models\FamilyTree;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FamilyAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $familyTree = FamilyTree::create([
            'title' => 'Trần Nguyễn Lê',
            'template_id' => 1,
            'description' => '123123'
        ]);

        $familyAdmin = User::create([
            'email' => 'family@admin.com',
            'full_name' => 'Nguyễn Văn A',
            'cccd_number' => '123456789',
            'role_name' => 'Trưởng gia đình',
            'birthday' => '2023-07-18',
            'address' => 'Việt Nam',
            'domicile' => 'Việt Nam',
            'phone' => '0123456789',
            'gender' => 1,
            'type' => UserType::FAMILY_ADMIN,
            'password' => Hash::make('123123123'),
            'family_tree_id' => $familyTree->id,
            'avatar' => '123',
        ]);

        $familyAdmin->userInfo()->create([
            'cccd_image_before' => 'cccd_image_before',
            'cccd_image_after' => 'cccd_image_after',
        ]);
    }
}
