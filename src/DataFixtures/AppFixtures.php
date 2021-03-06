<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{

    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $faker->addProvider(new \Liior\Faker\Prices($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));

        for ($c = 0; $c < 3; $c++) {
            $category = new Category();
            $category->setName($faker->department())
                ->setSlug(strtolower($this->slugger->slug($category->getName())));
            $manager->persist($category);


            for ($p = 0; $p < mt_rand(8, 13); $p++) {
                $product = new Product();
                $product
                    // ->setName($faker->sentence())
                    ->setName($faker->productName())
                    // ->setPrice(mt_rand(100, 200))
                    ->setPrice($faker->price(4000, 20000))
                    // ->setSlug($faker->slug());
                    ->setSlug(strtolower($this->slugger->slug($product->getName())))
                    ->setCategory($category)
                    ->setShortDescription($faker->paragraph())
                    ->setMainPicture($faker->imageUrl(400, 400, true));


                $manager->persist($product);
            }
        }



        $manager->flush();
    }
}
