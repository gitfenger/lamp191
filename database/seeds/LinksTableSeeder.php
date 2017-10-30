<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name' => '兄弟连',
                'link_title' => '最好的PHP培训机构',
                'link_url' => 'http://www.itxdl.cn',
                'link_order' => 1,
            ],
            [
                'link_name' => '兄弟连论坛',
                'link_title' => '最大的PHP论坛',
                'link_url' => 'http://www.bbs.itxdl.cn',
                'link_order' => 2,
            ]
        ];
        DB::table('links')->insert($data);

//        factory(App\Http\Model\User::class, 5)->create()->each(function($u) {
//
//        });
    }
}
