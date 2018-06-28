<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Ad;
use Cocur\Slugify\Slugify;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UsersAdsFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;    
    }
    
    public function load(ObjectManager $manager)
    {
        // Mise en place
        $faker      = Factory::create('fr-FR');
        $slugifier  = new Slugify();
        
        // Mise en place des utilisateurs
        $users = [];
        $genders = ['male', 'female'];
        
        for($i = 1; $i < mt_rand(20, 30); $i++) {
            $user       = new User();
            
            $gender     = $genders[mt_rand(0,1)];
            $firstName  = $faker->firstName($gender);
            $lastName   = $faker->lastName($gender);
            $slug       = $slugifier->slugify("$firstName $lastName");
            $picture    = 'https://randomuser.me/api/portraits/' . ($gender === 'male' ? 'men' : 'women') . '/' . $faker->numberBetween(0, 99) . '.jpg';
            $password   = $this->encoder->encodePassword($user, 'password');
            $description = '<p>' . join($faker->paragraphs(mt_rand(1, 8)), '</p><p>') . '</p>';
            $email      = $faker->email;
            
            $user
                ->setFirstName($firstName)
                ->setLastName($lastName)
                ->setEmail($email)
                ->setSlug($slug)
                ->setPicture($picture)
                ->setPassword($password)
                ->setDescription($description);
                 
            $manager->persist($user);
            $users[] = $user;
        }
        
        // Mise en place des appartements
        for($i = 1; $i <= mt_rand(30, 40); $i++) {
            $ad = new Ad();
            
            $title          = $faker->sentence();
            $slug           = $slugifier->slugify($title);
            $introduction   = $faker->sentence(mt_rand(10, 15));
            $content        = '<p>' . join($faker->paragraphs(mt_rand(3, 8)), '</p><p>') . '</p>';
            $cover          = $faker->imageUrl(1200, 500);
            $imagesArray    = [];
            
            for($j = 0; $j < mt_rand(2, 10); $j++) {
                $imagesArray[] = $faker->imageUrl();
            }
            
            $images = json_encode($imagesArray);
            $price  = round(mt_rand(3000, 25000) / 1000, 2);
            $rooms  = mt_rand(1, 6);
            
            $owner  = $users[mt_rand(0, count($users) - 1)];
            
            $ad->setTitle($title)
                ->setSlug($slug)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setCoverImage($cover)
                ->setImages($images)
                ->setPrice($price)
                ->setOwner($owner)
                ->setRooms($rooms);
                
            $manager->persist($ad);
        }
        
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
