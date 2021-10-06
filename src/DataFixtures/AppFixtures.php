<?php

namespace App\DataFixtures;

use App\Entity\Admin;
#use App\Entity\User;
use App\Factory\ArticleFactory;
use App\Factory\CategorieFactory;
use App\Factory\CommentArticleFactory;
use App\Factory\CommentVideoFactory;
use App\Factory\UserFactory;
use App\Factory\VideoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager)
    {

        CategorieFactory::new()->createMany(4);
        VideoFactory::new()->createMany(5, function () { // note the callback - this ensures that each of the 5 comments has a different Post
            return [
                'categorie' => CategorieFactory::random(),
            ];
        });
        ArticleFactory::new()->createMany(10, function () { // note the callback - this ensures that each of the 5 comments has a different Post
            return [
                'categorie' => CategorieFactory::random(),
            ];
        });
        CommentVideoFactory::new()->createMany(3, function () { // note the callback - this ensures that each of the 5 comments has a different Post
            return [
                'video' => VideoFactory::random(),
            ];
        });
        CommentArticleFactory::new()->createMany(4, function () { // note the callback - this ensures that each of the 5 comments has a different Post
            return [
                'article' => ArticleFactory::random(),
            ];
        });
        // $product = new Product();
        // $manager->persist($product);
        $user1 = $this->createUser("kacou585");;

        $manager->persist($user1);
        $manager->flush();
    }

    public function createUser($username, $password = "azertyuiop")
    {
        $user = new Admin();
        $user->setUsername($username);


        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $password
            )
        );



        $user->setRoles(['ROLE_ADMIN']);
        return $user;
    }
}
