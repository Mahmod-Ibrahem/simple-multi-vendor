<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Product::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $admin = User::where('email', 'admin@admin.com')->first();
        $categories = Category::all();

        if (!$admin || $categories->isEmpty()) {
            return;
        }

        $baseProducts = [
            [
                'title' => 'بخور دوسري ملكي فاخر',
                'price' => 180,
                'description' => 'شغل منزلي فاخر بأجود أنواع العطور والخلطات الخاصة. يتميز برائحة ثبات عالية تدوم طويلاً في المكان والملابس.',
                'published' => true,
                'locations' => 'الرياض - حي الملز',
                'quantity' => 10,
                'user_id' => $admin->id,
                'category_id' => $categories->random()->id,
            ],
            [
                'title' => 'طقم سدو مطرز يدوياً',
                'price' => 350,
                'description' => 'تصميم تراثي أصيل محاك بأيدي أسر منتجة محترفة. جودة عالية وخيوط متينة تدوم لسنوات.',
                'published' => true,
                'locations' => 'حائل - حي الجامعيين',
                'quantity' => 5,
                'user_id' => $admin->id,
                'category_id' => $categories->random()->id,
            ],
            [
                'title' => 'كعك ومعمول تمر فاخر',
                'price' => 65,
                'description' => 'طعم الأصالة في كل قطعة، محضر بعناية من التمر السكري الفاخر ودقيق البر العضوي.',
                'published' => true,
                'locations' => 'القصيم - حي الريان',
                'quantity' => 20,
                'user_id' => $admin->id,
                'category_id' => $categories->random()->id,
            ],
            [
                'title' => 'لوحة فنية تشكيلية',
                'price' => 500,
                'description' => 'رسم يدوي بألوان زيتية تعبر عن التراث السعودي العريق. قطعة فنية فريدة لتزيين منزلك.',
                'published' => true,
                'locations' => 'جدة - حي الحمراء',
                'quantity' => 1,
                'user_id' => $admin->id,
                'category_id' => $categories->random()->id,
            ],
            [
                'title' => 'كليجا القصيم الأصلية',
                'price' => 120,
                'description' => 'كليجا منزلية فاخرة محضرة من دقيق البر العضوي ودبس التمر الفاخر، مخبوزة يومياً لضمان الجودة والطعم الأصيل.',
                'published' => true,
                'locations' => 'القصيم - حي الياسمين',
                'quantity' => 15,
                'user_id' => $admin->id,
                'category_id' => $categories->random()->id,
            ],
        ];

        // Add 20 more variations to test pagination
        for ($i = 1; $i <= 20; $i++) {
            $base = $baseProducts[array_rand($baseProducts)];
            Product::create([
                'title' => $base['title'] . ' ' . $i,
                'price' => $base['price'] + ($i * 5),
                'description' => $base['description'],
                'published' => true,
                'locations' => $base['locations'],
                'quantity' => rand(1, 50),
                'user_id' => $admin->id,
                'category_id' => $categories->random()->id,
            ]);
        }

        foreach ($baseProducts as $productData) {
            Product::create($productData);
        }
    }
}
