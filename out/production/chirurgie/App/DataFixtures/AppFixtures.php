<?php

namespace App\DataFixtures;

//use App\Entity\Ad;
//use App\Entity\Booking;
//use App\Entity\Image;


use App\Entity\Article;
use App\Entity\Client;
use App\Entity\Comment;
use App\Entity\Employe;
use App\Entity\Famille;
use App\Entity\Role;
use App\Entity\Size;
use App\Entity\SousFamille;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Cocur\Slugify\Slugify;

class AppFixtures extends Fixture {

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager) {
        $faker = Factory::create('FR-fr');
        $roles = ["ROLE_USER", "ROLE_CUSTOMER", "ROLE_OPERATOR", "ROLE_EMPLOYE", "ROLE_DELEGUE", "ROLE_ADMIN"];
        $userRoles = [];
        $slugify = new Slugify();

        for ($e = 0; $e <= 5; $e++) {
            $role = new Role();
            $role->setTitle($roles[$e]);
            $manager->persist($role);
            $userRoles[] = $role;
        }
        $adminUser = new User();
        $adminUser
                ->setCivilite('Mr')
                ->setFirstName("Hamid")
                ->setLastName("Niri")
                ->setEmail("hniri@gmail.com")
                ->setPicture("https://randomuser.me/api/portraits/men/62.jpg")
                ->setHash($this->encoder->encodePassword($adminUser, '123456'))
                ->setIntroduction($faker->sentence)
                ->setJob('Dev')
                ->setCompany('Chirurgie-Med')
                ->setAdresse('15, rue Roudani, Temara')
                ->setVille('Temara')
                ->setCodePostal('20150')
                ->setTel($faker->phoneNumber)
                ->setGsm($faker->phoneNumber)
                ->addUserRole($userRoles[5])
                ->setEnabled(true)
        ;
        $manager->persist($adminUser);
        $adminUser2 = new User();
        $adminUser2
                ->setCivilite('Mr')
                ->setFirstName("Abdelkabir")
                ->setLastName("Ghyati")
                ->setEmail("aghyati@gmail.com")
                ->setPicture("https://randomuser.me/api/portraits/men/64.jpg")
                ->setHash($this->encoder->encodePassword($adminUser, '123456'))
                ->setIntroduction($faker->sentence)
                ->setJob('Dev')
                ->setCompany('Chirurgie-Med')
                ->setAdresse('15, rue Roudani, Temara')
                ->setVille('Temara')
                ->setCodePostal('20150')
                ->setTel($faker->phoneNumber)
                ->setGsm($faker->phoneNumber)
                ->addUserRole($userRoles[5])
                ->setEnabled(true)
        ;
        $manager->persist($adminUser2);

        $users = [];
        $genres = ['male', 'female'];
        $actifs = [true, false];
        //Gestion des tailles
        $original_sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $sizes = [];
        for ($h = 0; $h <= 5; $h++) {
            $size = new Size();
            $size->setSize($original_sizes[$h]);
            $manager->persist($size);
            $sizes[] = $size;
        }
        //Gestion des utilisateurs
        for ($i = 0; $i <= 120; $i++) {
            $type = mt_rand(0, 2);
            if ($type == 0) {
                $user = new User();
            } else if ($type == 1) {
                $user = new Client();
            } else {
                $user = new Employe();
            }
            $genre = $faker->randomElement($genres);
            $actif = $faker->randomElement($actifs);
            $picture = "https://randomuser.me/api/portraits/" . ($genre == "male" ? "men" : "women" ) . "/" . mt_rand(1, 99) . ".jpg";
            $user
                    ->setCivilite($genre == "male" ? "Mr" : "Mme" )
                    ->setFirstName($faker->firstName($genre))
                    ->setLastName($faker->lastName)
                    ->setEmail($faker->email)
                    ->setPicture($picture)
                    ->setHash($this->encoder->encodePassword($adminUser, '123456'))
                    ->setIntroduction($faker->sentence)
                    ->setJob($faker->jobTitle)
                    ->setCompany($faker->company)
                    ->setAdresse($faker->address)
                    ->setVille($faker->city)
                    ->setCodePostal($faker->postcode)
                    ->setTel($faker->phoneNumber)
                    ->setGsm($faker->phoneNumber)
                    ->setEnabled($actif)
                    ->addUserRole($faker->randomElement($userRoles));
            ;
            $manager->persist($user);
            $users[] = $user;
        }

        for ($i = 0; $i <= 50; $i++) {
            $fam = new Famille();
            $famille = $faker->sentence();
//            $coverImage = "https://loremflickr.com/400/350/medical/?random=" . $i;
            $coverImage = "800x800.jpg";
            $fam->setFamille($famille);
            $fam->setCoverImage($coverImage);
            for ($j = 0; $j <= mt_rand(1, 5); $j++) {
                $sousfam = new SousFamille();
                $sousfamille = $faker->sentence(6,true);
                $coverImage = "128x128.jpg";
                $sousfam->setSousFamille($sousfamille);
                $sousfam->setFamille($fam);
                $sousfam->setCoverImage($coverImage);
                for ($k = 0; $k <= mt_rand(1, 5); $k++) {
                    $article = new Article();
                    $article->setReference(strtoupper($faker->lexify('???')) . $faker->numberBetween(1000, 9999));
                    $designation = $faker->sentence(5, true);
                    $article->setDesignation($designation);
                    $content = '<p>' . join('<p></p>', $faker->paragraphs(3)) . '</p>';
                    $article->setDescription($content);
                    $article->setCoverImage($coverImage);
                    $article->setPrice($faker->randomFloat(2, 100, 10000));
                    $article->setSlug($slugify->slugify($designation));
                    $article->setSousFamille($sousfam);
                    $manager->persist($article);
                }
                $manager->persist($sousfam);
            }
            $manager->persist($fam);
        }

        //Gestion des annonces
//        for ($i = 0; $i <= 50; $i++) {
//            $ad = new Ad();
//            $title = $faker->sentence();
////            $coverImage = $faker->imageUrl(1000, 350);
//            $coverImage = "https://loremflickr.com/1000/350/apartment/?random=" . $i;
//            $introduction = $faker->paragraph(2);
//            $content = '<p>' . join('<p></p>', $faker->paragraphs(5)) . '</p>';
//            $user = $users[mt_rand(0, count($users) - 1)];
//            $ad->setTitle($title)
//                    ->setCoverImage($coverImage)
//                    ->setIntroduction($introduction)
//                    ->setContent($content)
//                    ->setPrice(mt_rand(40, 200))
//                    ->setRooms(mt_rand(1, 5))
//                    ->setAuthor($user)
//            ;
//            for ($j = 0; $j <= mt_rand(2, 5); $j++) {
//                $image = new Image();
//                $image->setAd($ad)
////                        ->setUrl($faker->imageUrl(1000, 350))
//                        ->setUrl("https://loremflickr.com/1000/350/apartment/?random=" . $i * $j)
//                        ->setCaption($faker->sentence());
//                $manager->persist($image);
//            }
//            for ($k = 0; $k <= mt_rand(0, 10); $k++) {
//                $booking = new Booking();
//                $createdAt = $faker->dateTimeBetween('-6 months');
//                $startDate = $faker->dateTimeBetween('-3 months');
//                $duration = mt_rand(3, 10);
//                $endDate = (clone $startDate)->modify("+$duration days");
//                $amount = $ad->getPrice() * $duration;
//                $booker = $users[mt_rand(0, count($users) - 1)];
//                $comment = $faker->paragraph();
//                $booking->setBooker($booker)
//                        ->setAd($ad)
//                        ->setStartDate($startDate)
//                        ->setEndDate($endDate)
//                        ->setCreatedAt($createdAt)
//                        ->setAmount($amount)
//                        ->setComment($comment)
//                ;
//                $manager->persist($booking);
//                if (mt_rand(0, 1)) {
//                    $comment = new Comment();
//                    $comment->setContent($faker->paragraph())
//                            ->setRating(mt_rand(1, 5))
//                            ->setAuthor($booker)
//                            ->setAd($ad)
//                    ;
//                    $manager->persist($comment);
//                }
//            }
//
//            $manager->persist($ad);
//        }

        $manager->flush();
    }

}
