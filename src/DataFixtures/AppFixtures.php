<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ContainerInterface; // <- Add this

class AppFixtures extends Fixture
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * AppFixtures constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) // <- Add this
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        if ($_ENV['APP_ENV'] === 'dev') {
            $imagesDir = $this->container->getParameter('images_directory');
            $faker = Factory::create();

            for($i = 0; $i < 20; $i++) {
                $book = new Book();
                $book->setTitle(substr($faker->unique()->text, 0, 40));
                $book->setPublicationDate($faker->dateTime('now'));
                $book->setIsbn(rand(0, 1) ? $faker->unique()->isbn13 : $faker->unique()->isbn10 );
                $book->setPageCount($faker->unique()->randomNumber(3));

                $url = $faker->unique()->imageUrl(800, 600, 'technics');
                $fileName = random_int(1,100) . time() . '.jpeg';
                $path = $imagesDir . '/' . $fileName;

                if (copy($url, $path)) {
                    $book->setImage($fileName);
                }


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

            $manager->flush();
        }
    }
}
