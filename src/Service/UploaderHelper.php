<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    private string $uploadsPath;
    public function __construct(string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadCakeFiles(UploadedFile $uploadedFile): string
    {
        $destination = $this->uploadsPath . '/cakes';
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move(
            $destination,
            $newFilename
        );
        return $newFilename;
    }
}
