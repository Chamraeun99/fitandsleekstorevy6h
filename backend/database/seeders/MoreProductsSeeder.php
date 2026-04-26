<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MoreProductsSeeder extends Seeder
{
    public function run(): void
    {
        $cat   = fn(string $slug) => Category::where('slug', $slug)->firstOrFail();
        $brand = fn(string $slug) => Brand::where('slug', $slug)->firstOrFail();

        // ── Unsplash image helper ──────────────────────────────────────────────
        $img = fn(string $id) => "https://images.unsplash.com/photo-{$id}?w=800&h=800&fit=crop&q=80";

        $products = [

            // ═══════════════════════════════════════════════════════════
            // MEN CLOTHES  (12 products — Nike, Adidas, H&M, Uniqlo,
            //               Champion, Zara, Lacoste, Puma, Under Armour)
            // ═══════════════════════════════════════════════════════════
            [
                'category' => 'men-clothes', 'brand' => 'nike',
                'sku'   => 'NK-MC-001',
                'name'  => 'Nike Dri-FIT Training T-Shirt',
                'price' => 34.99, 'compare_at_price' => 44.99, 'stock' => 120,
                'image_url'   => $img('1521572163474-6864f9cf17ab'),
                'description' => 'Nike Dri-FIT fabric wicks sweat away to help keep you dry and comfortable during workouts.',
                'sizes' => ['S','M','L','XL','XXL'],
                'colors' => ['White','Black','Grey','Navy'],
            ],
            [
                'category' => 'men-clothes', 'brand' => 'nike',
                'sku'   => 'NK-MC-002',
                'name'  => 'Nike Tech Fleece Jogger Pants',
                'price' => 89.99, 'compare_at_price' => 109.99, 'stock' => 75,
                'image_url'   => $img('1542272604-787c3835535d'),
                'description' => 'Nike Tech Fleece Jogger Pants combine warmth with a slim, tapered fit for everyday wear.',
                'sizes' => ['S','M','L','XL'],
                'colors' => ['Black','Dark Grey','Navy'],
            ],
            [
                'category' => 'men-clothes', 'brand' => 'Adidas',
                'sku'   => 'AD-MC-001',
                'name'  => 'Adidas Originals Trefoil Hoodie',
                'price' => 64.99, 'compare_at_price' => 79.99, 'stock' => 88,
                'image_url'   => $img('1556821840-3a63f15732ce'),
                'description' => 'Classic Adidas hoodie with the iconic Trefoil logo, crafted from soft fleece fabric.',
                'sizes' => ['S','M','L','XL','XXL'],
                'colors' => ['Black','White','Grey Heather','Navy'],
            ],
            [
                'category' => 'men-clothes', 'brand' => 'Adidas',
                'sku'   => 'AD-MC-002',
                'name'  => 'Adidas Essentials 3-Stripes T-Shirt',
                'price' => 29.99, 'compare_at_price' => null, 'stock' => 140,
                'image_url'   => $img('1576566588028-4147f3842f27'),
                'description' => 'A go-to everyday tee with the signature 3-Stripes logo on the chest.',
                'sizes' => ['XS','S','M','L','XL','XXL'],
                'colors' => ['Black','White','Blue','Red'],
            ],
            [
                'category' => 'men-clothes', 'brand' => 'H&M',
                'sku'   => 'HM-MC-001',
                'name'  => 'H&M Slim Fit Oxford Shirt',
                'price' => 24.99, 'compare_at_price' => 34.99, 'stock' => 95,
                'image_url'   => $img('1598300042247-d088f8ab3a91'),
                'description' => 'Slim-fit Oxford shirt in soft woven cotton. Button-down collar and chest pocket.',
                'sizes' => ['S','M','L','XL'],
                'colors' => ['White','Light Blue','Pink','Grey'],
            ],
            [
                'category' => 'men-clothes', 'brand' => 'uniqlo',
                'sku'   => 'UQ-MC-001',
                'name'  => 'Uniqlo AIRism Cotton T-Shirt',
                'price' => 19.90, 'compare_at_price' => null, 'stock' => 160,
                'image_url'   => $img('1583743814966-8936f5b7be1a'),
                'description' => 'Ultra-breathable AIRism mesh lining keeps you cool all day. Soft cotton outer shell.',
                'sizes' => ['XS','S','M','L','XL','XXL'],
                'colors' => ['White','Black','Navy','Grey','Olive'],
            ],
            [
                'category' => 'men-clothes', 'brand' => 'champion',
                'sku'   => 'CH-MC-001',
                'name'  => 'Champion Powerblend Fleece Hoodie',
                'price' => 54.99, 'compare_at_price' => 69.99, 'stock' => 80,
                'image_url'   => $img('1574180566232-aaad1b5b8450'),
                'description' => 'Reduced-pill, Powerblend fleece with soft interior for a comfortable, warm fit.',
                'sizes' => ['S','M','L','XL','XXL','3XL'],
                'colors' => ['Oxford Grey','Navy','Black','Crimson'],
            ],
            [
                'category' => 'men-clothes', 'brand' => 'zara',
                'sku'   => 'ZR-MC-001',
                'name'  => 'Zara Structured Blazer',
                'price' => 79.99, 'compare_at_price' => 99.99, 'stock' => 45,
                'image_url'   => $img('1507679799987-c73779587ccf'),
                'description' => 'Tailored blazer with structured shoulders. Essential for a polished office look.',
                'sizes' => ['S','M','L','XL'],
                'colors' => ['Navy','Charcoal','Beige'],
            ],
            [
                'category' => 'men-clothes', 'brand' => 'Lacoste',
                'sku'   => 'LC-MC-001',
                'name'  => 'Lacoste Classic Fit Polo Shirt',
                'price' => 89.99, 'compare_at_price' => null, 'stock' => 65,
                'image_url'   => $img('1571945153237-4929e783af4a'),
                'description' => 'The iconic Lacoste petit piqué polo. Classic fit, ribbed collar and sleeve ends.',
                'sizes' => ['S','M','L','XL','XXL'],
                'colors' => ['White','Navy','Black','Red','Green'],
            ],
            [
                'category' => 'men-clothes', 'brand' => 'Under',
                'sku'   => 'UA-MC-001',
                'name'  => 'Under Armour HeatGear Compression Shirt',
                'price' => 44.99, 'compare_at_price' => 54.99, 'stock' => 100,
                'image_url'   => $img('1618354691551-44882d098a2d'),
                'description' => 'HeatGear fabric moves sweat away fast so you stay cool and dry during intense training.',
                'sizes' => ['SM','MD','LG','XL','2XL'],
                'colors' => ['Black','White','Royal Blue','Red'],
            ],
            [
                'category' => 'men-clothes', 'brand' => 'H&M',
                'sku'   => 'HM-MC-002',
                'name'  => 'H&M Regular Fit Chino Pants',
                'price' => 34.99, 'compare_at_price' => 44.99, 'stock' => 85,
                'image_url'   => $img('1624378439575-d8705ad7ae80'),
                'description' => 'Regular-fit chinos in cotton twill. Welt back pockets and coin pocket.',
                'sizes' => ['28','30','32','34','36','38'],
                'colors' => ['Beige','Navy','Khaki','Olive'],
            ],
            [
                'category' => 'men-clothes', 'brand' => 'puma',
                'sku'   => 'PM-MC-001',
                'name'  => 'PUMA Essentials+ Logo Tee',
                'price' => 26.99, 'compare_at_price' => null, 'stock' => 130,
                'image_url'   => $img('1619412939373-a7e7d97ded7c'),
                'description' => 'PUMA Essentials+ logo tee in soft cotton jersey for everyday comfort.',
                'sizes' => ['XS','S','M','L','XL','XXL'],
                'colors' => ['Black','White','Burgundy','Teal'],
            ],

            // ═══════════════════════════════════════════════════════════
            // MEN SHOES  (8 products)
            // ═══════════════════════════════════════════════════════════
            [
                'category' => 'men-shoes', 'brand' => 'nike',
                'sku'   => 'NK-MS-001',
                'name'  => 'Nike Air Max 270',
                'price' => 149.99, 'compare_at_price' => 179.99, 'stock' => 55,
                'image_url'   => $img('1542291026-7eec264c27ff'),
                'description' => 'The Nike Air Max 270 features Nike\'s biggest heel Air unit yet for a super-soft ride.',
                'sizes' => ['40','41','42','43','44','45','46'],
                'colors' => ['Black/White','White/Blue','Triple Black'],
            ],
            [
                'category' => 'men-shoes', 'brand' => 'Adidas',
                'sku'   => 'AD-MS-001',
                'name'  => 'Adidas Ultraboost 23',
                'price' => 189.99, 'compare_at_price' => 219.99, 'stock' => 40,
                'image_url'   => $img('1608231387042-66d1773d3028'),
                'description' => 'The Adidas Ultraboost 23 features responsive Boost cushioning for maximum energy return.',
                'sizes' => ['40','41','42','43','44','45'],
                'colors' => ['Core Black','Cloud White','Grey'],
            ],
            [
                'category' => 'men-shoes', 'brand' => 'Adidas',
                'sku'   => 'AD-MS-002',
                'name'  => 'Adidas Stan Smith Sneakers',
                'price' => 89.99, 'compare_at_price' => null, 'stock' => 70,
                'image_url'   => $img('1539185441755-769473a23570'),
                'description' => 'The iconic Stan Smith silhouette with perforated 3-Stripes and a clean leather upper.',
                'sizes' => ['39','40','41','42','43','44','45'],
                'colors' => ['White/Green','White/Navy','Triple White'],
            ],
            [
                'category' => 'men-shoes', 'brand' => 'puma',
                'sku'   => 'PM-MS-001',
                'name'  => 'PUMA RS-X3 Puzzle Sneakers',
                'price' => 94.99, 'compare_at_price' => 119.99, 'stock' => 50,
                'image_url'   => $img('1595950653106-6c9ebd614d3a'),
                'description' => 'The RS-X3 Puzzle features a chunky sole and multicolour upper for a bold retro look.',
                'sizes' => ['40','41','42','43','44','45'],
                'colors' => ['White/Red/Blue','Black/Gold'],
            ],
            [
                'category' => 'men-shoes', 'brand' => 'reebok',
                'sku'   => 'RB-MS-001',
                'name'  => 'Reebok Club C 85 Sneakers',
                'price' => 74.99, 'compare_at_price' => 89.99, 'stock' => 65,
                'image_url'   => $img('1491553895911-0055eca6402d'),
                'description' => 'A classic tennis shoe silhouette with a clean leather upper and vintage Reebok badge.',
                'sizes' => ['39','40','41','42','43','44','45','46'],
                'colors' => ['White/Green','All White','White/Grey'],
            ],
            [
                'category' => 'men-shoes', 'brand' => 'Timberland',
                'sku'   => 'TB-MS-001',
                'name'  => 'Timberland 6-Inch Premium Waterproof Boot',
                'price' => 199.99, 'compare_at_price' => 229.99, 'stock' => 35,
                'image_url'   => $img('1520639888713-7851133b1ed0'),
                'description' => 'The original Timberland boot with waterproof nubuck leather and lug outsole.',
                'sizes' => ['40','41','42','43','44','45','46'],
                'colors' => ['Wheat Nubuck','Black Nubuck','Dark Brown'],
            ],
            [
                'category' => 'men-shoes', 'brand' => 'New balance',
                'sku'   => 'NB-MS-001',
                'name'  => 'New Balance 574 Core Sneakers',
                'price' => 84.99, 'compare_at_price' => null, 'stock' => 60,
                'image_url'   => $img('1617952739676-b3b9c2e7b5fb'),
                'description' => 'A true New Balance icon, the 574 combines ENCAP midsole cushioning with a classic silhouette.',
                'sizes' => ['39','40','41','42','43','44','45'],
                'colors' => ['Navy/White','Grey/White','Black'],
            ],
            [
                'category' => 'men-shoes', 'brand' => 'nike',
                'sku'   => 'NK-MS-002',
                'name'  => 'Nike Air Force 1 \'07',
                'price' => 109.99, 'compare_at_price' => null, 'stock' => 80,
                'image_url'   => $img('1579338559194-a162d19bf842'),
                'description' => 'The radically original Air Force 1 — born in 1982 — lets you express your style with classic hoops DNA.',
                'sizes' => ['40','41','42','43','44','45','46'],
                'colors' => ['Triple White','Black/Black','White/Black'],
            ],

            // ═══════════════════════════════════════════════════════════
            // MEN BELT  (4 products)
            // ═══════════════════════════════════════════════════════════
            [
                'category' => 'men-belt', 'brand' => 'tommy',
                'sku'   => 'TH-MB-001',
                'name'  => 'Tommy Hilfiger Leather Dress Belt',
                'price' => 49.99, 'compare_at_price' => 64.99, 'stock' => 90,
                'image_url'   => $img('1553062407-98eeb64c6a62'),
                'description' => 'Full-grain leather belt with polished silver-tone buckle. Classic Tommy Hilfiger branding.',
                'sizes' => ['S/M','M/L','L/XL'],
                'colors' => ['Black','Brown','Tan'],
            ],
            [
                'category' => 'men-belt', 'brand' => 'Lacoste',
                'sku'   => 'LC-MB-001',
                'name'  => 'Lacoste Reversible Leather Belt',
                'price' => 59.99, 'compare_at_price' => null, 'stock' => 75,
                'image_url'   => $img('1624222247344-550fb60583dc'),
                'description' => 'Reversible belt in grained leather with matte metallic buckle. Two looks in one.',
                'sizes' => ['80cm','85cm','90cm','95cm','100cm'],
                'colors' => ['Black/Brown'],
            ],
            [
                'category' => 'men-belt', 'brand' => 'polo',
                'sku'   => 'PL-MB-001',
                'name'  => 'Polo Ralph Lauren Pony Leather Belt',
                'price' => 54.99, 'compare_at_price' => 69.99, 'stock' => 80,
                'image_url'   => $img('1624395312720-7a2a734d9b97'),
                'description' => 'Signature Polo pony embossed on genuine leather. Adjustable nickel-tone buckle.',
                'sizes' => ['S','M','L','XL'],
                'colors' => ['Black','Dark Brown','Cognac'],
            ],
            [
                'category' => 'men-belt', 'brand' => 'Wrangler',
                'sku'   => 'WR-MB-001',
                'name'  => 'Wrangler Men Canvas Web Belt',
                'price' => 19.99, 'compare_at_price' => null, 'stock' => 150,
                'image_url'   => $img('1601924994987-d5a68b5e0a79'),
                'description' => 'Durable woven canvas belt with D-ring nickel buckle. Trim to fit any waist.',
                'sizes' => ['One Size (Trimmable)'],
                'colors' => ['Khaki','Navy','Black','Olive'],
            ],

            // ═══════════════════════════════════════════════════════════
            // MEN HAT  (4 products)
            // ═══════════════════════════════════════════════════════════
            [
                'category' => 'men-hat', 'brand' => 'kangol',
                'sku'   => 'KG-MH-001',
                'name'  => 'Kangol Wool Flex-Fit Cap',
                'price' => 44.99, 'compare_at_price' => 54.99, 'stock' => 85,
                'image_url'   => $img('1514327605112-b887c0e61c0a'),
                'description' => 'Kangol\'s iconic signature shape in premium wool blend with flexible fit.',
                'sizes' => ['S/M','L/XL'],
                'colors' => ['Black','Navy','Grey','Camel'],
            ],
            [
                'category' => 'men-hat', 'brand' => 'nike',
                'sku'   => 'NK-MH-001',
                'name'  => 'Nike Dri-FIT Pro Fitted Cap',
                'price' => 27.99, 'compare_at_price' => null, 'stock' => 110,
                'image_url'   => $img('1578932750294-f5075e85f44a'),
                'description' => 'Nike Dri-FIT technology helps you stay cool during your workout. Structured front panels.',
                'sizes' => ['S/M','L/XL'],
                'colors' => ['Black','White','Navy','Red'],
            ],
            [
                'category' => 'men-hat', 'brand' => 'Adidas',
                'sku'   => 'AD-MH-001',
                'name'  => 'Adidas Originals Trefoil Beanie',
                'price' => 24.99, 'compare_at_price' => 29.99, 'stock' => 120,
                'image_url'   => $img('1565839072-64c12e28be3e'),
                'description' => 'Ribbed beanie with embroidered Trefoil logo. Soft fabric blend for warmth.',
                'sizes' => ['One Size'],
                'colors' => ['Black','White','Grey Heather','Navy'],
            ],
            [
                'category' => 'men-hat', 'brand' => 'The north face',
                'sku'   => 'TNF-MH-001',
                'name'  => 'The North Face Bones Recycled Beanie',
                'price' => 34.99, 'compare_at_price' => null, 'stock' => 100,
                'image_url'   => $img('1576566588028-4147f3842f27'),
                'description' => 'Classic beanie in recycled polyester with TNF box logo. Perfect for cold adventures.',
                'sizes' => ['One Size'],
                'colors' => ['TNF Black','TNF Red','Brilliant Blue'],
            ],

            // ═══════════════════════════════════════════════════════════
            // MEN BAG  (4 products)
            // ═══════════════════════════════════════════════════════════
            [
                'category' => 'men-bag', 'brand' => 'The north face',
                'sku'   => 'TNF-MBG-001',
                'name'  => 'The North Face Borealis Backpack 28L',
                'price' => 99.99, 'compare_at_price' => 119.99, 'stock' => 50,
                'image_url'   => $img('1575032617751-6ddec2089882'),
                'description' => '28L capacity backpack with FlexVent suspension, laptop sleeve, and water bottle pocket.',
                'sizes' => ['One Size'],
                'colors' => ['TNF Black','Navy Peaks','Burnt Coral'],
            ],
            [
                'category' => 'men-bag', 'brand' => 'Columbia',
                'sku'   => 'CB-MBG-001',
                'name'  => 'Columbia Zigzag 22L Backpack',
                'price' => 64.99, 'compare_at_price' => 79.99, 'stock' => 60,
                'image_url'   => $img('1547949003-9792a18a2601'),
                'description' => '22L trail-ready backpack with adjustable sternum strap and multiple organiser pockets.',
                'sizes' => ['One Size'],
                'colors' => ['Black','Collegiate Navy','Dark Stone'],
            ],
            [
                'category' => 'men-bag', 'brand' => 'Adidas',
                'sku'   => 'AD-MBG-001',
                'name'  => 'Adidas Classic 3-Stripes Backpack',
                'price' => 44.99, 'compare_at_price' => null, 'stock' => 75,
                'image_url'   => $img('1585386959984-a4155224a1ad'),
                'description' => 'Iconic 3-Stripes backpack with padded back and adjustable shoulder straps. 21L capacity.',
                'sizes' => ['One Size'],
                'colors' => ['Black/White','Navy/White','Burgundy/White'],
            ],
            [
                'category' => 'men-bag', 'brand' => 'nike',
                'sku'   => 'NK-MBG-001',
                'name'  => 'Nike Brasilia 9.5 Training Backpack',
                'price' => 54.99, 'compare_at_price' => 64.99, 'stock' => 65,
                'image_url'   => $img('1553062407-98eeb64c6a62'),
                'description' => 'Durable training backpack with separate shoe compartment and water bottle pockets. 24L.',
                'sizes' => ['One Size'],
                'colors' => ['Black','Midnight Navy','Dark Smoke Grey'],
            ],

            // ═══════════════════════════════════════════════════════════
            // MEN ACCESSORY  (4 products)
            // ═══════════════════════════════════════════════════════════
            [
                'category' => 'men-accessory', 'brand' => 'tommy',
                'sku'   => 'TH-MA-001',
                'name'  => 'Tommy Hilfiger Leather Bifold Wallet',
                'price' => 49.99, 'compare_at_price' => 59.99, 'stock' => 100,
                'image_url'   => $img('1624395312720-7a2a734d9b97'),
                'description' => 'Slim bifold wallet in smooth leather with multiple card slots and a bill section.',
                'sizes' => ['One Size'],
                'colors' => ['Black','Brown','Cognac'],
            ],
            [
                'category' => 'men-accessory', 'brand' => 'Lacoste',
                'sku'   => 'LC-MA-001',
                'name'  => 'Lacoste Polarised Sport Sunglasses',
                'price' => 89.99, 'compare_at_price' => 109.99, 'stock' => 70,
                'image_url'   => $img('1529391409965-e46d3c2e3e0e'),
                'description' => 'UV400 polarised lenses with lightweight frame. Iconic Lacoste crocodile on temples.',
                'sizes' => ['One Size'],
                'colors' => ['Matte Black','Tortoise','Navy'],
            ],
            [
                'category' => 'men-accessory', 'brand' => 'polo',
                'sku'   => 'PL-MA-001',
                'name'  => 'Polo Ralph Lauren Wool Scarf',
                'price' => 59.99, 'compare_at_price' => null, 'stock' => 80,
                'image_url'   => $img('1578932750294-f5075e85f44a'),
                'description' => 'Soft Merino wool scarf with signature Polo embroidery. Fringe ends.',
                'sizes' => ['One Size'],
                'colors' => ['Navy/Red','Camel','Grey Heather'],
            ],
            [
                'category' => 'men-accessory', 'brand' => 'Calivin Klein',
                'sku'   => 'CK-MA-001',
                'name'  => 'Calvin Klein Stainless Steel Watch',
                'price' => 149.99, 'compare_at_price' => 179.99, 'stock' => 45,
                'image_url'   => $img('1513201099705-a9746e1e201f'),
                'description' => 'Minimalist stainless steel watch with quartz movement. 3-hand display.',
                'sizes' => ['One Size'],
                'colors' => ['Silver/Black','Gold/Brown','Rose Gold'],
            ],

            // ═══════════════════════════════════════════════════════════
            // WOMEN CLOTHES  (10 products)
            // ═══════════════════════════════════════════════════════════
            [
                'category' => 'women-clothes', 'brand' => 'zara',
                'sku'   => 'ZR-WC-001',
                'name'  => 'Zara Satin Midi Slip Dress',
                'price' => 59.99, 'compare_at_price' => 79.99, 'stock' => 55,
                'image_url'   => $img('1572804013309-59a88b7e92f1'),
                'description' => 'Satin slip dress with spaghetti straps and a bias-cut midi length. Effortlessly elegant.',
                'sizes' => ['XS','S','M','L','XL'],
                'colors' => ['Black','Champagne','Dusty Pink','Forest Green'],
            ],
            [
                'category' => 'women-clothes', 'brand' => 'H&M',
                'sku'   => 'HM-WC-001',
                'name'  => 'H&M Wrap-Front Midi Dress',
                'price' => 34.99, 'compare_at_price' => 44.99, 'stock' => 68,
                'image_url'   => $img('1496747611176-843222e1e57c'),
                'description' => 'Fluid wrap-front dress with floral print. V-neckline and flared skirt.',
                'sizes' => ['XS','S','M','L','XL','XXL'],
                'colors' => ['Floral Print','Solid Black','Dusty Mauve'],
            ],
            [
                'category' => 'women-clothes', 'brand' => 'uniqlo',
                'sku'   => 'UQ-WC-001',
                'name'  => 'Uniqlo Ribbed Crewneck Sweater',
                'price' => 29.90, 'compare_at_price' => null, 'stock' => 90,
                'image_url'   => $img('1594938298603-c8148c4b4357'),
                'description' => 'Soft ribbed crewneck sweater in Merino wool blend. Versatile basic for any season.',
                'sizes' => ['XS','S','M','L','XL'],
                'colors' => ['Oatmeal','Black','Blush Pink','Baby Blue','Sage'],
            ],
            [
                'category' => 'women-clothes', 'brand' => 'zara',
                'sku'   => 'ZR-WC-002',
                'name'  => 'Zara Oversized Blazer',
                'price' => 79.99, 'compare_at_price' => 99.99, 'stock' => 40,
                'image_url'   => $img('1548576290-b9d0be1af87f'),
                'description' => 'Oversized blazer in double-face fabric. Notched lapels and patch pockets.',
                'sizes' => ['XS','S','M','L'],
                'colors' => ['Black','Ecru','Camel','Tweed'],
            ],
            [
                'category' => 'women-clothes', 'brand' => 'H&M',
                'sku'   => 'HM-WC-002',
                'name'  => 'H&M High-Waist Wide-Leg Jeans',
                'price' => 39.99, 'compare_at_price' => 49.99, 'stock' => 75,
                'image_url'   => $img('1434389677669-e08b4cac3105'),
                'description' => 'Wide-leg jeans with a high waist and a five-pocket design. Sustainable cotton blend.',
                'sizes' => ['25','26','27','28','29','30','31','32'],
                'colors' => ['Light Denim','Dark Denim','Black Denim'],
            ],
            [
                'category' => 'women-clothes', 'brand' => 'Express',
                'sku'   => 'EX-WC-001',
                'name'  => 'Express Bodycon Mini Dress',
                'price' => 49.99, 'compare_at_price' => 64.99, 'stock' => 60,
                'image_url'   => $img('1485968579580-b6d095142e6e'),
                'description' => 'Figure-hugging bodycon dress with a square neckline. Perfect for nights out.',
                'sizes' => ['XXS','XS','S','M','L','XL'],
                'colors' => ['Black','Red','Cobalt Blue','Emerald'],
            ],
            [
                'category' => 'women-clothes', 'brand' => 'Lacoste',
                'sku'   => 'LC-WC-001',
                'name'  => 'Lacoste Piqué Polo Dress',
                'price' => 99.99, 'compare_at_price' => 119.99, 'stock' => 35,
                'image_url'   => $img('1536766768598-e09213fdcf22'),
                'description' => 'Iconic Lacoste polo shirt reimagined as a short dress with a belted waist.',
                'sizes' => ['34','36','38','40','42','44'],
                'colors' => ['White','Navy','Black','Blush'],
            ],
            [
                'category' => 'women-clothes', 'brand' => 'H&M',
                'sku'   => 'HM-WC-003',
                'name'  => 'H&M Linen-Blend Blouse',
                'price' => 24.99, 'compare_at_price' => null, 'stock' => 95,
                'image_url'   => $img('1525507119028-ed4c629a60a3'),
                'description' => 'Relaxed linen-blend blouse with a V-neckline and 3/4 sleeves. Breathable summer staple.',
                'sizes' => ['XS','S','M','L','XL','XXL'],
                'colors' => ['White','Sand','Sage Green','Dusty Lilac'],
            ],
            [
                'category' => 'women-clothes', 'brand' => 'uniqlo',
                'sku'   => 'UQ-WC-002',
                'name'  => 'Uniqlo Ultra Stretch Active Leggings',
                'price' => 24.90, 'compare_at_price' => 34.90, 'stock' => 110,
                'image_url'   => $img('1571945153237-4929e783af4a'),
                'description' => 'Ultra-stretchy leggings with moisture-wicking finish. High-rise fit for full coverage.',
                'sizes' => ['XS','S','M','L','XL','XXL'],
                'colors' => ['Black','Dark Navy','Charcoal','Burgundy'],
            ],
            [
                'category' => 'women-clothes', 'brand' => 'zara',
                'sku'   => 'ZR-WC-003',
                'name'  => 'Zara Pleated Midi Skirt',
                'price' => 45.99, 'compare_at_price' => 59.99, 'stock' => 58,
                'image_url'   => $img('1515347619252-60a4bf4fff4f'),
                'description' => 'Pleated satin-feel midi skirt with elasticated waistband. Elegant and easy to wear.',
                'sizes' => ['XS','S','M','L','XL'],
                'colors' => ['Black','Rose Taupe','Cobalt Blue','Emerald'],
            ],

            // ═══════════════════════════════════════════════════════════
            // WOMEN SHOES  (6 products)
            // ═══════════════════════════════════════════════════════════
            [
                'category' => 'women-shoes', 'brand' => 'nike',
                'sku'   => 'NK-WS-001',
                'name'  => 'Nike Air Max 90 Women',
                'price' => 129.99, 'compare_at_price' => 149.99, 'stock' => 55,
                'image_url'   => $img('1543163521-1bf539c55dd2'),
                'description' => 'Nike Air Max 90 for women — the OG running shoe with plush Max Air cushioning.',
                'sizes' => ['36','37','38','39','40','41','42'],
                'colors' => ['White/Black','Triple White','Black/Gold'],
            ],
            [
                'category' => 'women-shoes', 'brand' => 'Adidas',
                'sku'   => 'AD-WS-001',
                'name'  => 'Adidas Ultraboost 23 Women',
                'price' => 179.99, 'compare_at_price' => 209.99, 'stock' => 40,
                'image_url'   => $img('1560769629-975ec94e6a86'),
                'description' => 'Women\'s Ultraboost with responsive Boost cushioning and Primeknit+ upper.',
                'sizes' => ['36','37','38','39','40','41'],
                'colors' => ['Core Black','Cloud White','Coral Pink'],
            ],
            [
                'category' => 'women-shoes', 'brand' => 'reebok',
                'sku'   => 'RB-WS-001',
                'name'  => 'Reebok Classic Leather Women',
                'price' => 79.99, 'compare_at_price' => null, 'stock' => 65,
                'image_url'   => $img('1631729371254-42c2892f0e6e'),
                'description' => 'The iconic Reebok Classic Leather silhouette in a women\'s specific last for perfect fit.',
                'sizes' => ['35','36','37','38','39','40','41'],
                'colors' => ['White/Grey','Chalk/Pink','Black/White'],
            ],
            [
                'category' => 'women-shoes', 'brand' => 'puma',
                'sku'   => 'PM-WS-001',
                'name'  => 'PUMA Cali Women Sneakers',
                'price' => 84.99, 'compare_at_price' => 104.99, 'stock' => 60,
                'image_url'   => $img('1584735175315-9d5df23860e6'),
                'description' => 'PUMA Cali — California cool meets street style. Platform sole with soft leather upper.',
                'sizes' => ['35','36','37','38','39','40','41','42'],
                'colors' => ['White/White','White/Black','Beige/Tan'],
            ],
            [
                'category' => 'women-shoes', 'brand' => 'New balance',
                'sku'   => 'NB-WS-001',
                'name'  => 'New Balance 574 Core Women',
                'price' => 79.99, 'compare_at_price' => null, 'stock' => 70,
                'image_url'   => $img('1515347619252-60a4bf4fff4f'),
                'description' => 'Women\'s NB 574 with ENCAP midsole technology and premium suede/mesh upper.',
                'sizes' => ['35','36','37','38','39','40','41'],
                'colors' => ['Pink/White','Navy/White','Rose Gold'],
            ],
            [
                'category' => 'women-shoes', 'brand' => 'zara',
                'sku'   => 'ZR-WS-001',
                'name'  => 'Zara Block Heel Ankle Boots',
                'price' => 79.99, 'compare_at_price' => 99.99, 'stock' => 42,
                'image_url'   => $img('1543163521-1bf539c55dd2'),
                'description' => 'Leather ankle boots with a stable block heel. Side zip and almond toe.',
                'sizes' => ['35','36','37','38','39','40','41'],
                'colors' => ['Black','Tan','Dark Brown'],
            ],

            // ═══════════════════════════════════════════════════════════
            // WOMEN BELT  (3 products)
            // ═══════════════════════════════════════════════════════════
            [
                'category' => 'women-belt', 'brand' => 'zara',
                'sku'   => 'ZR-WB-001',
                'name'  => 'Zara Gold Chain Waist Belt',
                'price' => 29.99, 'compare_at_price' => 39.99, 'stock' => 90,
                'image_url'   => $img('1624222247344-550fb60583dc'),
                'description' => 'Statement gold-tone chain belt to cinch dresses and oversized blazers.',
                'sizes' => ['One Size'],
                'colors' => ['Gold','Silver'],
            ],
            [
                'category' => 'women-belt', 'brand' => 'H&M',
                'sku'   => 'HM-WB-001',
                'name'  => 'H&M Wide Faux-Leather Belt',
                'price' => 19.99, 'compare_at_price' => null, 'stock' => 110,
                'image_url'   => $img('1553062407-98eeb64c6a62'),
                'description' => 'Wide waist belt in faux leather with a classic rectangular buckle.',
                'sizes' => ['XS/S','M/L','XL/XXL'],
                'colors' => ['Black','Camel','Snake Print'],
            ],
            [
                'category' => 'women-belt', 'brand' => 'Calivin Klein',
                'sku'   => 'CK-WB-001',
                'name'  => 'Calvin Klein Logo Plaque Belt',
                'price' => 44.99, 'compare_at_price' => 54.99, 'stock' => 70,
                'image_url'   => $img('1601924994987-d5a68b5e0a79'),
                'description' => 'Smooth leather belt with engraved CK logo plaque buckle. Minimalist luxury.',
                'sizes' => ['S','M','L'],
                'colors' => ['Black','White','Beige'],
            ],

            // ═══════════════════════════════════════════════════════════
            // WOMEN HAT  (3 products)
            // ═══════════════════════════════════════════════════════════
            [
                'category' => 'women-hat', 'brand' => 'kangol',
                'sku'   => 'KG-WH-001',
                'name'  => 'Kangol Bucket Hat',
                'price' => 44.99, 'compare_at_price' => 54.99, 'stock' => 85,
                'image_url'   => $img('1514327605112-b887c0e61c0a'),
                'description' => 'The iconic Kangol bucket hat in premium wool with signature Kangaroo logo.',
                'sizes' => ['S','M','L'],
                'colors' => ['Black','Khaki','White','Terracotta'],
            ],
            [
                'category' => 'women-hat', 'brand' => 'H&M',
                'sku'   => 'HM-WH-001',
                'name'  => 'H&M Wide-Brim Straw Hat',
                'price' => 19.99, 'compare_at_price' => null, 'stock' => 100,
                'image_url'   => $img('1565839072-64c12e28be3e'),
                'description' => 'Classic wide-brim straw hat with ribbon trim. UV protection for sunny days.',
                'sizes' => ['One Size'],
                'colors' => ['Natural','Black Ribbon','Brown'],
            ],
            [
                'category' => 'women-hat', 'brand' => 'zara',
                'sku'   => 'ZR-WH-001',
                'name'  => 'Zara Knit Beret',
                'price' => 22.99, 'compare_at_price' => 29.99, 'stock' => 95,
                'image_url'   => $img('1578932750294-f5075e85f44a'),
                'description' => 'Soft ribbed-knit beret with a classic Parisian silhouette.',
                'sizes' => ['One Size'],
                'colors' => ['Black','Camel','Dark Red','Ivory'],
            ],

            // ═══════════════════════════════════════════════════════════
            // WOMEN BAG  (3 products)
            // ═══════════════════════════════════════════════════════════
            [
                'category' => 'women-bag', 'brand' => 'zara',
                'sku'   => 'ZR-WBG-001',
                'name'  => 'Zara Leather Tote Bag',
                'price' => 89.99, 'compare_at_price' => 109.99, 'stock' => 45,
                'image_url'   => $img('1547949003-9792a18a2601'),
                'description' => 'Spacious tote in genuine leather with magnetic-snap closure and inner pockets.',
                'sizes' => ['One Size'],
                'colors' => ['Black','Camel','White'],
            ],
            [
                'category' => 'women-bag', 'brand' => 'H&M',
                'sku'   => 'HM-WBG-001',
                'name'  => 'H&M Chain-Strap Shoulder Bag',
                'price' => 39.99, 'compare_at_price' => null, 'stock' => 70,
                'image_url'   => $img('1585386959984-a4155224a1ad'),
                'description' => 'Mini shoulder bag with gold-tone chain strap. Flap closure with turn-lock.',
                'sizes' => ['One Size'],
                'colors' => ['Black','Nude','Silver','Pink'],
            ],
            [
                'category' => 'women-bag', 'brand' => 'Calivin Klein',
                'sku'   => 'CK-WBG-001',
                'name'  => 'Calvin Klein Crossbody Bag',
                'price' => 99.99, 'compare_at_price' => 119.99, 'stock' => 40,
                'image_url'   => $img('1575032617751-6ddec2089882'),
                'description' => 'Smooth leather crossbody with adjustable strap and engraved CK logo hardware.',
                'sizes' => ['One Size'],
                'colors' => ['Black','Nude','Navy'],
            ],

            // ═══════════════════════════════════════════════════════════
            // WOMEN ACCESSORY  (3 products)
            // ═══════════════════════════════════════════════════════════
            [
                'category' => 'women-accessory', 'brand' => 'zara',
                'sku'   => 'ZR-WA-001',
                'name'  => 'Zara Pearl Hoop Earrings',
                'price' => 17.99, 'compare_at_price' => null, 'stock' => 150,
                'image_url'   => $img('1529391409965-e46d3c2e3e0e'),
                'description' => 'Gold-plated hoop earrings with freshwater pearl drops. Hypoallergenic posts.',
                'sizes' => ['One Size'],
                'colors' => ['Gold/Pearl','Silver/Pearl'],
            ],
            [
                'category' => 'women-accessory', 'brand' => 'H&M',
                'sku'   => 'HM-WA-001',
                'name'  => 'H&M Satin Scrunchie Set (5-pack)',
                'price' => 9.99, 'compare_at_price' => null, 'stock' => 200,
                'image_url'   => $img('1513201099705-a9746e1e201f'),
                'description' => 'Set of 5 satin scrunchies in coordinating pastel and neutral tones.',
                'sizes' => ['One Size'],
                'colors' => ['Mixed Pastels','Mixed Neutrals','Mixed Brights'],
            ],
            [
                'category' => 'women-accessory', 'brand' => 'tommy',
                'sku'   => 'TH-WA-001',
                'name'  => 'Tommy Hilfiger Women Leather Wallet',
                'price' => 44.99, 'compare_at_price' => 54.99, 'stock' => 85,
                'image_url'   => $img('1624395312720-7a2a734d9b97'),
                'description' => 'Zip-around wallet in smooth leather with multiple card slots and coin pocket.',
                'sizes' => ['One Size'],
                'colors' => ['Black','Crimson','Tan'],
            ],
        ];

        $count = 0;
        foreach ($products as $p) {
            $category = $cat($p['category']);
            $brandModel = $brand($p['brand']);

            Product::updateOrCreate(
                ['sku' => $p['sku']],
                [
                    'category_id'      => $category->id,
                    'brand_id'         => $brandModel->id,
                    'sku'              => $p['sku'],
                    'name'             => $p['name'],
                    'slug'             => Str::slug($p['name']),
                    'description'      => $p['description'],
                    'price'            => $p['price'],
                    'compare_at_price' => $p['compare_at_price'] ?? null,
                    'image_url'        => $p['image_url'],
                    'stock'            => $p['stock'],
                    'sizes'            => $p['sizes'] ?? null,
                    'colors'           => $p['colors'] ?? null,
                    'is_active'        => true,
                ]
            );
            $count++;
        }

        $this->command->info("✅ {$count} products seeded with brands, categories, sizes and colours.");
    }
}
