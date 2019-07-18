<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr-FR");
        // $slugify = new Slugify();
        
        for ($i = 1; $i <= 30; $i++){
            $ad = new Ad();


            $title = $faker->sentence();
            // $slug  = $slugify->slugify($title);
            $coverImage  = $faker->imageUrl();
            $introduction  = $faker->paragraph(2);
            $content  = '<p>'. join ('</p><p>', $faker->paragraphs(5)) . '</p>';

            $ad->setTitle($title);
            // $ad->setSlug($slug);
            $ad->setCoverImage($coverImage);
            $ad->setIntroduction($introduction);
            $ad->setContent($content);
            $ad->setPrice(mt_rand(40, 200));
            $ad->setRooms(mt_rand(1, 5));
            
            for ($j = 0; $j <= mt_rand(2, 5); $j++){
                $image = new Image();

                $image->setUrl($faker->imageUrl());
                $image->setCaption($faker->sentence());
                $image->setAd($ad);

                $manager->persist($image);
            }


            $manager->persist($ad);
        }
        $manager->flush();
    }
}
