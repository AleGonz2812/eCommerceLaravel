<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            // VIDEOJUEGOS (category_id: 1)
            [
                'category_id' => 1,
                'name' => 'Cyberpunk 2077',
                'slug' => 'cyberpunk-2077',
                'description' => 'Juego de rol de acción y aventura en un mundo abierto futurista. Incluye expansión Phantom Liberty.',
                'price' => 29.99,
                'image' => 'products/cyberpunk-2077.jpg',
                'stock' => 150,
                'featured' => true
            ],
            [
                'category_id' => 1,
                'name' => 'Elden Ring',
                'slug' => 'elden-ring',
                'description' => 'RPG de acción desarrollado por FromSoftware. Un vasto mundo lleno de peligros y maravillas.',
                'price' => 39.99,
                'image' => 'products/elden-ring.jpg',
                'stock' => 200,
                'featured' => true
            ],
            [
                'category_id' => 1,
                'name' => 'Red Dead Redemption 2',
                'slug' => 'red-dead-redemption-2',
                'description' => 'Épica aventura del Salvaje Oeste. La historia de Arthur Morgan y la banda de Van der Linde.',
                'price' => 24.99,
                'image' => 'products/rdr2.jpg',
                'stock' => 100,
                'featured' => false
            ],
            [
                'category_id' => 1,
                'name' => 'The Witcher 3: Wild Hunt GOTY',
                'slug' => 'witcher-3-goty',
                'description' => 'Edición Game of the Year con todas las expansiones. La historia de Geralt de Rivia.',
                'price' => 19.99,
                'image' => 'products/witcher-3.jpg',
                'stock' => 180,
                'featured' => true
            ],
            [
                'category_id' => 1,
                'name' => 'Grand Theft Auto V',
                'slug' => 'gta-v',
                'description' => 'GTA V Premium Edition. Incluye Criminal Enterprise Starter Pack y GTA Online.',
                'price' => 14.99,
                'image' => 'products/gta-v.jpg',
                'stock' => 250,
                'featured' => false
            ],

            // TARJETAS DE SUSCRIPCIÓN (category_id: 2)
            [
                'category_id' => 2,
                'name' => 'Netflix Premium 1 Mes',
                'slug' => 'netflix-premium-1-mes',
                'description' => 'Suscripción Premium de Netflix por 1 mes. 4 pantallas simultáneas en 4K Ultra HD.',
                'price' => 17.99,
                'image' => 'products/netflix.jpg',
                'stock' => 500,
                'featured' => true
            ],
            [
                'category_id' => 2,
                'name' => 'Spotify Premium 3 Meses',
                'slug' => 'spotify-premium-3-meses',
                'description' => 'Spotify Premium por 3 meses. Música sin anuncios y descargas ilimitadas.',
                'price' => 29.99,
                'image' => 'products/spotify.jpg',
                'stock' => 300,
                'featured' => false
            ],
            [
                'category_id' => 2,
                'name' => 'Xbox Game Pass Ultimate 3 Meses',
                'slug' => 'xbox-game-pass-ultimate-3-meses',
                'description' => 'Acceso a más de 100 juegos de alta calidad en consola, PC y la nube.',
                'price' => 44.99,
                'image' => 'products/gamepass.jpg',
                'stock' => 200,
                'featured' => true
            ],
            [
                'category_id' => 2,
                'name' => 'PlayStation Plus Essential 12 Meses',
                'slug' => 'ps-plus-essential-12-meses',
                'description' => 'PlayStation Plus Essential por 1 año. Multijugador online y juegos mensuales gratis.',
                'price' => 59.99,
                'image' => 'products/ps-plus.jpg',
                'stock' => 150,
                'featured' => false
            ],
            [
                'category_id' => 2,
                'name' => 'Disney+ Premium 1 Año',
                'slug' => 'disney-plus-1-ano',
                'description' => 'Suscripción anual a Disney+. Todo el contenido de Disney, Pixar, Marvel, Star Wars y National Geographic.',
                'price' => 89.99,
                'image' => 'products/disney-plus.jpg',
                'stock' => 100,
                'featured' => false
            ],

            // TARJETAS PSN/XBOX/STEAM (category_id: 3)
            [
                'category_id' => 3,
                'name' => 'Steam Wallet €20',
                'slug' => 'steam-wallet-20',
                'description' => 'Tarjeta regalo de Steam por valor de €20. Úsala para comprar juegos, DLC y contenido.',
                'price' => 20.00,
                'image' => 'products/steam-20.jpg',
                'stock' => 400,
                'featured' => true
            ],
            [
                'category_id' => 3,
                'name' => 'Steam Wallet €50',
                'slug' => 'steam-wallet-50',
                'description' => 'Tarjeta regalo de Steam por valor de €50. Perfecta para las rebajas de Steam.',
                'price' => 50.00,
                'image' => 'products/steam-50.jpg',
                'stock' => 350,
                'featured' => false
            ],
            [
                'category_id' => 3,
                'name' => 'PlayStation Store €25',
                'slug' => 'playstation-store-25',
                'description' => 'Tarjeta PSN de €25 para PlayStation Store. Compra juegos, DLC y más.',
                'price' => 25.00,
                'image' => 'products/psn-25.jpg',
                'stock' => 300,
                'featured' => false
            ],
            [
                'category_id' => 3,
                'name' => 'Xbox Gift Card €50',
                'slug' => 'xbox-gift-card-50',
                'description' => 'Tarjeta regalo Xbox de €50. Compatible con Xbox Series X|S, One y PC.',
                'price' => 50.00,
                'image' => 'products/xbox-50.jpg',
                'stock' => 280,
                'featured' => false
            ],

            // MYSTERY KEYS (category_id: 4)
            [
                'category_id' => 4,
                'name' => 'Mystery Steam Key - Bronze',
                'slug' => 'mystery-steam-key-bronze',
                'description' => 'Clave aleatoria de Steam. Puede contener juegos valorados entre €5-€15.',
                'price' => 2.99,
                'image' => 'products/mystery-bronze.jpg',
                'stock' => 1000,
                'featured' => false
            ],
            [
                'category_id' => 4,
                'name' => 'Mystery Steam Key - Silver',
                'slug' => 'mystery-steam-key-silver',
                'description' => 'Clave aleatoria de Steam. Puede contener juegos valorados entre €15-€30.',
                'price' => 5.99,
                'image' => 'products/mystery-silver.jpg',
                'stock' => 800,
                'featured' => true
            ],
            [
                'category_id' => 4,
                'name' => 'Mystery Steam Key - Gold',
                'slug' => 'mystery-steam-key-gold',
                'description' => 'Clave aleatoria de Steam. Puede contener juegos valorados entre €30-€60.',
                'price' => 9.99,
                'image' => 'products/mystery-gold.jpg',
                'stock' => 500,
                'featured' => true
            ],
            [
                'category_id' => 4,
                'name' => 'Mystery Steam Key - Diamond',
                'slug' => 'mystery-steam-key-diamond',
                'description' => 'Clave aleatoria de Steam. Puede contener juegos AAA valorados en más de €60.',
                'price' => 14.99,
                'image' => 'products/mystery-diamond.jpg',
                'stock' => 300,
                'featured' => true
            ],

            // SOFTWARE (category_id: 5)
            [
                'category_id' => 5,
                'name' => 'Microsoft Office 2021 Professional Plus',
                'slug' => 'microsoft-office-2021',
                'description' => 'Licencia permanente de Office 2021. Incluye Word, Excel, PowerPoint, Outlook y más.',
                'price' => 49.99,
                'image' => 'products/office-2021.jpg',
                'stock' => 150,
                'featured' => true
            ],
            [
                'category_id' => 5,
                'name' => 'Windows 11 Pro',
                'slug' => 'windows-11-pro',
                'description' => 'Licencia digital de Windows 11 Professional. Activación permanente.',
                'price' => 39.99,
                'image' => 'products/windows-11.jpg',
                'stock' => 200,
                'featured' => true
            ],
            [
                'category_id' => 5,
                'name' => 'Kaspersky Total Security 1 Dispositivo',
                'slug' => 'kaspersky-total-security',
                'description' => 'Antivirus premium para 1 dispositivo por 1 año. Protección completa.',
                'price' => 29.99,
                'image' => 'products/kaspersky.jpg',
                'stock' => 100,
                'featured' => false
            ],
            [
                'category_id' => 5,
                'name' => 'Adobe Creative Cloud 1 Mes',
                'slug' => 'adobe-creative-cloud-1-mes',
                'description' => 'Acceso a todas las aplicaciones de Adobe por 1 mes. Photoshop, Illustrator, Premiere y más.',
                'price' => 59.99,
                'image' => 'products/adobe-cc.jpg',
                'stock' => 80,
                'featured' => false
            ],
            [
                'category_id' => 5,
                'name' => 'Malwarebytes Premium 1 Año',
                'slug' => 'malwarebytes-premium',
                'description' => 'Protección anti-malware premium por 1 año. Para 1 dispositivo.',
                'price' => 34.99,
                'image' => 'products/malwarebytes.jpg',
                'stock' => 120,
                'featured' => false
            ]
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'category_id' => $product['category_id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'description' => $product['description'],
                'price' => $product['price'],
                'image' => $product['image'],
                'stock' => $product['stock'],
                'featured' => $product['featured'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
