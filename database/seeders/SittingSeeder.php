<?php

namespace Database\Seeders;

use App\Models\Sitting;
use Illuminate\Database\Seeder;

class SittingSeeder extends Seeder
{
    protected $setting_data = [
        ['name' => 'title', 'value' => 'IMS'],
        ['name'=> 'address','value' =>''],

        
        ['name' => 'currency_code', 'value' => 'BDT'],
        ['name' => 'currency_symbol', 'value' => 'TK'],
        ['name' => 'currency_position', 'value' => 'right'],
        
        ['name' => 'logo', 'value' => ''],
        ['name' => 'favicon', 'value' => ''],

        ['name'=> 'invoice_number','value'=>'000001'],
        ['name'=> 'invoice_prefix','value'=>'INV-'],
        ['name'=> 'timezone','value'=>'Asia/Dhaka-'],
        ['name'=> 'datae_formate','value'=>'d-m-Y'],


        
        ['name' => 'mail_mailer', 'value' => 'smtp'],
        ['name' => 'mail_host', 'value' => 'smtp'],
        ['name' => 'mail_port', 'value' => ''],
        ['name' => 'mail_username', 'value' => ''],
        ['name' => 'mail_password', 'value' => 'smtp'],
        ['name' => 'mail_encryption', 'value' => ''],
        ['name' => 'mail_from_address', 'value' => ''],
        ['name' => 'mail_from_name', 'value' => ''],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sitting::insert($this->setting_data);
    }
}
