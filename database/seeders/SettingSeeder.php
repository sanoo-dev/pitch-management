<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'open_time' => '00:00',
            'close_time' => '23:00',
            'location' => '236B Lê Văn Sỹ, Phường 1, Tân Bình, Thành phố Hồ Chí Minh',
            'location_url' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.193895746118!2d106.66459191462269!3d10.796456692307947!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175292e780bc82f%3A0x41b3ce1213cdb644!2zMjM2QiBMw6ogVsSDbiBT4bu5LCBQaMaw4budbmcgMSwgVMOibiBCw6xuaCwgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1653508916441!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'phone' => '0388883533',
            'email' => 'sanbong@gmail.com',
        ]);
    }
}
