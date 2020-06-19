<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUploader {

    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $image)
    {
        $originalImageFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $safeImageFileName = $this->slugger->slug($originalImageFileName);
        $newImageFileName = $safeImageFileName.'-'.uniqid().'.'.$image->guessExtension();

        try {
            $image->move(
                $this->getTargetDirectory(),
                $newImageFileName
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $newImageFileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}