<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for($i = 0; $i < 20; $i++) {
            $book = new Book();
            $book->setTitle(substr($faker->unique()->text, 0, 40));
            $book->setPublicationDate($faker->dateTime('now'));
            $book->setIsbn(rand(0, 1) ? $faker->unique()->isbn13 : $faker->unique()->isbn10 );
            $book->setPageCount($faker->unique()->randomNumber(3));
            $book->setImage($faker->unique()->imageUrl(800, 600, 'technics'));


            for($j = 0, $jMax = random_int(1, 3); $j < $jMax; $j++) {
                $author = new Author();
                $author->setFirstName($faker->unique()->firstName);
                $author->setLastName($faker->unique()->lastName);
                $author->setMiddleName(substr($faker->unique()->text, 0, 10));

                $manager->persist($author);
                $book->addAuthor($author);
            }

            $manager->persist($book);
        }

        $manager->flush();    }
}
