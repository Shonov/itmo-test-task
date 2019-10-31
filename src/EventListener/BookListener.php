<?php
/**
 * Created by PhpStorm.
 * User: Виталий Шонов
 * Date: 31.10.2019
 * Time: 13:07
 */

namespace App\EventListener;


use App\Entity\Book;
use App\Service\FileUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BookListener
{
    private $uploader;
    private $container;

    /**
     * BookListener constructor.
     * @param FileUploader $uploader
     * @param ContainerInterface $container
     */
    public function __construct(FileUploader $uploader, ContainerInterface $container)
    {
        $this->uploader = $uploader;
        $this->container = $container;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
        $this->fileToString($entity);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args): void
    {

        $entity = $args->getEntity();

        $this->stringToFile($entity);
    }

    /**
     * @param $entity
     */
    private function uploadFile($entity): void
    {

        if (!$entity instanceof Book) {
            return;
        }

        $file = $entity->getImage();

        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setImage($fileName);
        }
    }

    /**
     * @param $entity
     */
    private function stringToFile($entity): void
    {
        if (!$entity instanceof Book) {
            return;
        }

        if ($fileName = $entity->getImage()) {
            $path = $this->container->getParameter('web_images_directory');
            $entity->setImage(new File($path . $fileName));
        }
    }

    /**
     * @param $entity
     */
    private function fileToString($entity): void
    {
        if (!$entity instanceof Book) {
            return;
        }

        $logoFile = $entity->getImage();

        if ($logoFile instanceof File) {
            $entity->setImage($logoFile->getFilename());
        }
    }
}
