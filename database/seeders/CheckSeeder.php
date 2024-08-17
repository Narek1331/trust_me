<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Check;
class CheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Сайты',
                'slug' => 'site',
            ],
            [
                'name' => 'Соцсети',
                'slug' => 'social_network',
                'childs' => [
                    [
                        'name' => 'Telegram',
                        'slug' => 'telegram',
                        'url' => 'https://t.me',
                        'logo_path' => 'telegram.png'
                    ],
                    [
                        'name' => 'Instagram',
                        'slug' => 'instagram',
                        'url' => 'https://www.instagram.com',
                        'logo_path' => 'instagram.png'
                    ],
                    [
                        'name' => 'Facebook',
                        'slug' => 'facebook',
                        'url' => 'https://www.facebook.com',
                        'logo_path' => 'facebook.png'
                    ],
                    [
                        'name' => 'ВКонтакте',
                        'slug' => 'vk',
                        'url' => 'https://vk.com',
                        'logo_path' => 'vk.png'
                    ],
                    [
                        'name' => 'Одноклассники',
                        'slug' => 'ok',
                        'url' => 'https://ok.ru/profile',
                        'logo_path' => 'ok.png'

                    ],
                    [
                        'name' => 'Youtube',
                        'slug' => 'youtube',
                        'url' => 'https://www.youtube.com/channel',
                        'logo_path' => 'youtube.png'
                    ],
                ]
                ],
            [
                'name' => 'Телефон',
                'slug' => 'phone',
            ],
        ];

        foreach($datas as $data)
        {
            $check = Check::create([
                'name'=> $data['name'],
                'slug'=> $data['slug'],
            ]);

            if(isset($data['childs']) && count($data['childs']))
            {
                foreach($data['childs'] as $child)
                {
                    Check::create([
                        'name'=> $child['name'],
                        'slug'=> $child['slug'],
                        'logo_path'=> $child['logo_path'] ?? null,
                        'url'=> $child['url'] ?? null,
                        'parent_id'=> $check->id,
                    ]);
                }
            }
        }
    }
}
