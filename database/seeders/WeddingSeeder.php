<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WeddingHall;
use App\Models\WeddingPackage;
use App\Models\WeddingCatering;
use App\Models\WeddingDecoration;

class WeddingSeeder extends Seeder
{
    public function run(): void
    {
        
        WeddingHall::create([
            'name' => 'Mounts Edge Grand Hall',
            'tagline' => 'Grand Celebrations',
            'description' => 'Our elegant indoor wedding hall accommodates up to 200 guests with stunning mountain views through panoramic windows. The versatile space can be configured for ceremonies, receptions, or both in a climate-controlled environment.',
            'capacity' => 'Up to 200 guests',
            'area' => '3,500 sq ft',
            'style' => 'Indoor with views',
            'image' => '/storage/weddings/indoor-hall.jpg',
            'features' => [
                'Climate controlled', 
                'Built-in sound system', 
                'Ambient lighting', 
                'Bridal room access'
            ]
        ]);

        WeddingHall::create([
            'name' => 'Mounts Edge Grand Lawn',
            'tagline' => 'Open-Air Elegance',
            'description' => 'Celebrate your special day under the open sky. Our spacious outdoor venue is perfect for grand weddings, accommodating over 400 guests with breathtaking natural surroundings, starlight ambiance, and highly flexible seating arrangements.',
            'capacity' => '400+ guests',
            'area' => '12,000 sq ft',
            'style' => 'Outdoor / Garden',
            'image' => '/storage/weddings/outdoor-hall.jpg', 
            'features' => [
                'Marquee & Tent setups available', 
                'Garden fairy lighting', 
                'Open-air dance floor', 
                'Large stage area'
            ]
        ]);

        WeddingCatering::create([
            'name' => 'Catering & Menu',
            'tagline' => 'Culinary Excellence',
            'description' => 'Our award-winning chefs create memorable dining experiences with authentic Sri Lankan cuisine and international options. All menus are customizable to your preferences.',
            'image' => '/storage/weddings/catering.jpg',
            'list_title' => 'Menu Options',
            'list_items' => ['Traditional Sri Lankan Feast', 'International Fusion', 'Vegetarian Delight', 'Custom Menu'],
            'tags' => ['Welcome drinks', 'Appetizers', 'Main course buffet', 'Dessert station', 'Wedding cake']
        ]);

        WeddingDecoration::create([
            'name' => 'Decorations',
            'tagline' => 'Your Vision, Our Art',
            'description' => 'From elegant minimalist designs to lavish traditional setups, our decoration team brings your wedding vision to life. We also offer unique Kandyan cultural elements.',
            'image' => '/storage/weddings/decoration.jpg',
            'list_title' => 'Decoration Styles',
            'list_items' => ['Modern Minimalist', 'Romantic Garden', 'Traditional Kandyan', 'Bohemian Chic', 'Rustic Elegance'],
            'tags' => ['Kandyan dancers', 'Traditional drummers', 'Poruwa ceremony setup', 'Oil lamp lighting']
        ]);

        $packages = [
            [
                'name' => 'Bronze Menu',
                'guests' => '100 - 500 Guests',
                'is_popular' => false,
                'includes' => [
                    ['title' => 'Welcome Drink', 'rule' => null, 'items' => ['Mixed Fruit', 'Mango', 'Orange']],
                    ['title' => 'Salads', 'rule' => 'Choice of Two', 'items' => ['Bitter Gourd Salad', 'Green Salad', 'Cucumber Raita Salad', 'Mixed Salad']],
                    ['title' => 'From the Hotel', 'rule' => null, 'items' => ['Tomato Onion Salad', 'Spiced Coleslaw Salad']],
                    ['title' => 'Sauce & Dressings', 'rule' => null, 'items' => ['Vinaigrette', 'Green Chili with Soya Sauce', 'Hot Garlic Sauce']],
                    ['title' => 'Rice & Noodles', 'rule' => 'Choice of Three', 'items' => ['Vegetable Fried Rice', 'Red Country Rice', 'Yellow Rice with Plums', 'Egg & Vegetable Noodles']],
                    ['title' => 'Chicken', 'rule' => 'Choice of One', 'items' => ['Chicken Black Pepper Curry', 'Thai Chicken Red Curry', 'Crispy Fried Chicken', 'Chicken Devilled']],
                    ['title' => 'Fish', 'rule' => 'Choice of One', 'items' => ['Devilled Fish', 'Fish Curry', 'Fish Ambulthiyal', 'Fish Sweet & Sour']],
                    ['title' => 'Vegetables', 'rule' => 'Choice of Four', 'items' => ['Dhal Curry', 'Potato Curry or Bedum', 'Brinjal Morju / Pahie', 'Mixed Vegetable Curry', 'Bean Curry', 'Batter Fried Mushroom']],
                    ['title' => 'Condiments', 'rule' => null, 'items' => ['Fried Chili Pods', 'Mango Chutney', 'Papadam', 'Cutlet']],
                    ['title' => 'Desserts', 'rule' => 'Choice of Two', 'items' => ['Ice Cream', 'Fruit Trifle', 'Chocolate Biscuit Pudding', 'Fresh Fruit Salad']],
                    ['title' => 'From the Hotel (Desserts)', 'rule' => null, 'items' => ['Jelly', 'Bread Pudding']],
                ]
            ],
            [
                'name' => 'Silver Menu',
                'guests' => '100 - 500 Guests',
                'is_popular' => true,
                'includes' => [
                    ['title' => 'Welcome Drink', 'rule' => null, 'items' => ['Mixed Fruit', 'Mango', 'Orange']],
                    ['title' => 'Salads', 'rule' => 'Choice of Three', 'items' => ['Bitter Gourd Salad', 'Green Salad', 'Cucumber Raita Salad', 'Mixed Salad']],
                    ['title' => 'From the Hotel', 'rule' => null, 'items' => ['Tomato Onion Salad', 'Spiced Coleslaw Salad']],
                    ['title' => 'Sauce & Dressings', 'rule' => null, 'items' => ['Vinaigrette', 'Green Chili with Soya Sauce', 'Hot Garlic Sauce']],
                    ['title' => 'Rice & Noodles', 'rule' => 'Choice of Three', 'items' => ['Vegetable Fried Rice', 'Red Country Rice', 'Yellow Rice with Plums', 'Egg & Vegetable Noodles']],
                    ['title' => 'Chicken', 'rule' => 'Choice of One', 'items' => ['Chicken Black Pepper Curry', 'Thai Chicken Red Curry', 'Crispy Fried Chicken', 'Chicken Devilled']],
                    ['title' => 'Fish', 'rule' => 'Choice of One', 'items' => ['Devilled Fish', 'Fish Curry', 'Fish Ambulthiyal', 'Fish Sweet & Sour']],
                    ['title' => 'Vegetables', 'rule' => 'Choice of Four', 'items' => ['Dhal Curry', 'Potato Curry or Bedum', 'Brinjal Morju / Pahie', 'Mixed Vegetable Curry', 'Bean Curry', 'Batter Fried Mushroom']],
                    ['title' => 'Condiments', 'rule' => null, 'items' => ['Fried Chili Pods', 'Mango Chutney', 'Papadam', 'Cutlet']],
                    ['title' => 'Desserts', 'rule' => 'Choice of Four', 'items' => ['Ice Cream', 'Chocolate Mousse', 'Fruit Trifle', 'Chocolate Biscuit Pudding', 'Fresh Fruit Salad']],
                    ['title' => 'From the Hotel (Desserts)', 'rule' => null, 'items' => ['Jelly', 'Bread Pudding']],
                ]
            ],
            [
                'name' => 'Gold Menu',
                'guests' => '100 - 500 Guests',
                'is_popular' => false,
                'includes' => [
                    ['title' => 'Welcome Drink', 'rule' => null, 'items' => ['Mixed Fruit', 'Mango', 'Orange']],
                    ['title' => 'Salads', 'rule' => 'Choice of Two', 'items' => ['Spiced Coleslaw Salad', 'Bitter Gourd Salad', 'Green Salad', 'Cucumber Raita Salad', 'Mixed Salad', 'Tomato Onion Salad']],
                    ['title' => 'From the Hotel', 'rule' => null, 'items' => ['Russian Egg Salad', 'Macaroni Chicken Salad']],
                    ['title' => 'Sauce & Dressings', 'rule' => null, 'items' => ['Vinaigrette', 'Green Chili with Soya Sauce', 'Hot Garlic Sauce']],
                    ['title' => 'Rice & Noodles', 'rule' => 'Choice of Three', 'items' => ['Vegetable Fried Rice', 'Red Country Rice', 'Yellow Rice with Plums', 'Egg & Vegetable Noodles']],
                    ['title' => 'Chicken', 'rule' => 'Choice of One', 'items' => ['Chicken Black Pepper Curry', 'Thai Chicken Red Curry', 'Crispy Fried Chicken', 'Chicken Devilled']],
                    ['title' => 'Fish', 'rule' => 'Choice of One', 'items' => ['Devilled Fish', 'Fish Curry', 'Fish Ambulthiyal', 'Fish Sweet & Sour']],
                    ['title' => 'Vegetables', 'rule' => 'Choice of Four', 'items' => ['Dhal Curry', 'Potato Curry or Bedum', 'Brinjal Morju / Pahie', 'Mixed Vegetable Curry', 'Bean Curry', 'Batter Fried Mushroom']],
                    ['title' => 'Condiments', 'rule' => null, 'items' => ['Fried Chili Pods', 'Mango Chutney', 'Papadam', 'Cutlet']],
                    ['title' => 'Desserts', 'rule' => 'Choice of Four', 'items' => ['Ice Cream', 'Chocolate Mousse', 'Fruit Trifle', 'Chocolate Biscuit Pudding', 'Fresh Fruit Salad']],
                    ['title' => 'From the Hotel (Desserts)', 'rule' => null, 'items' => ['Jelly', 'Bread Pudding']],
                ]
            ],
            [
                'name' => 'Platinum Menu',
                'guests' => '100 - 500 Guests',
                'is_popular' => false,
                'includes' => [
                    ['title' => 'Deluxe Fruit Punch', 'rule' => 'Choice of One', 'items' => ['Mixed Fruit', 'Mango', 'Orange', 'Strawberry']],
                    ['title' => 'Salads', 'rule' => 'Choice of Five', 'items' => ['MER Special Salad', 'Spiced Coleslaw Salad', 'Bitter Gourd Salad', 'Green Salad', 'Cucumber Raita Salad', 'Mixed Salad', 'Tomato Onion Salad']],
                    ['title' => 'From the Hotel', 'rule' => null, 'items' => ['Russian Egg Salad', 'Macaroni Chicken Salad']],
                    ['title' => 'Sauce & Dressings', 'rule' => null, 'items' => ['Garlic Mayonnaise', 'Vinaigrette', 'Hot Garlic Sauce', 'Green Chili Sauce', 'French Dressing', 'Green Chili with Soya Sauce']],
                    ['title' => 'Rice & Noodles', 'rule' => 'Choice of Four', 'items' => ['Steamed Basmathi Rice', 'Mixed Fried Rice', 'Nasi Goreng Rice', 'Yellow Rice', 'Chicken Noodles', 'Red Country Rice', 'Egg Fried Noodles', 'Vegetable Noodles']],
                    ['title' => 'Chicken', 'rule' => 'Choice of One', 'items' => ['Chicken Black Pepper Curry', 'Thai Chicken Red Curry', 'Crispy Fried Chicken', 'Chicken Devilled']],
                    ['title' => 'Fish', 'rule' => 'Choice of One', 'items' => ['Devilled Fish', 'Fish Curry', 'Fish Ambulthiyal', 'Fish Sweet & Sour']],
                    ['title' => 'Vegetables', 'rule' => 'Choice of Six', 'items' => ['Maldive Fish with Capsicum', 'Dhal Curry', 'Potato Curry or Bedum', 'Brinjal Morju / Pahie', 'Mixed Vegetable Curry with Cashew Nut', 'Bean Curry', 'Batter Fried Mushroom']],
                    ['title' => 'Pork', 'rule' => 'Choice of One', 'items' => ['Sweet & Sour Pork', 'Pork Black Curry', 'Pork Stew', 'Devilled Pork']],
                    ['title' => 'Seafood', 'rule' => 'Choice of One', 'items' => ['Devilled Prawn or Cuttlefish', 'Batter Prawn or Cuttlefish', 'Sweet Sour Prawn or Cuttlefish', 'Prawn Curry', 'Cuttlefish Curry (Kalu pol)', 'Crab Curry']],
                    ['title' => 'Mutton', 'rule' => 'Choice of One', 'items' => ['Mutton Black Pepper Curry', 'Mutton Red Curry']],
                    ['title' => 'Condiments', 'rule' => null, 'items' => ['Maldive Fish Sambol', 'Mango Chutney', 'Papadam', 'Cutlet', 'Malay Pickle', 'Lime Pickle']],
                    ['title' => 'Desserts', 'rule' => null, 'items' => ['Ice Cream', 'Watalappan', 'Chocolate Mousse', 'Fruit Trifle', 'Chocolate Biscuit Pudding', 'Fresh Fruit Salad']],
                    ['title' => 'From the Hotel (Desserts)', 'rule' => null, 'items' => ['Jelly', 'Bread Pudding']],
                ]
            ],
        ];

        foreach ($packages as $package) {
            WeddingPackage::create($package);
        }
    }
}