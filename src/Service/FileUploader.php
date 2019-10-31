<?php
/**
 * Created by PhpStorm.
 * User: Виталий Шонов
 * Date: 30.10.2019
 * Time: 16:37
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Psr\Log\LoggerInterface;

class FileUploader
{
    private $logger;

    private $targetDirectory;

    /**
     * @param LoggerInterface $logger
     * @param $targetDirectory
     */
    public function __construct(LoggerInterface $logger, $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
        $this->logger = $logger;
    }

    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    public function upload(UploadedFile $file) : string
    {
        try{
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename . '-' . uniqid('', true) . '.' . $file->guessExtension();

            $file->move($this->targetDirectory, $newFilename);
        }
        catch(FileException $e){
            $this->logger->error('failed to upload image: ' . $e->getMessage());
            throw new FileException('Failed to upload file');
        }

        return $newFilename;
    }

    /**
     * @return string
     */
    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}
