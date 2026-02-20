<?php

namespace App\Traits;


use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

trait ImagesUtility
{
    function storeImage($imageRequest, $type): string|array|JsonResource
    {

        $image = $imageRequest;
        /** @var string $directoryPath */
        $directoryPath = $this->generatePath($type); // Images/Category/ || Images/TourLarge/, Images/TourSmall/

        $this->makeDirectory($directoryPath);

        $uniqueName = $this->generateUniqueImageName();
        $manager = new ImageManager(new Driver());
        try {
            $img = $manager->read($image);
            $resizedImages = $this->resizeImage($img, $type); // Small and Large Images
            $resizedImages->toWebp()->save(storage_path('app/public/' . $directoryPath . $uniqueName));

            // return url('storage/' . $directoryPath . $uniqueName);
            return '/storage/' . $directoryPath . $uniqueName;
        } catch (Exception $e) {
            return response()->json(['message' => 'Error processing image: ' . $e->getMessage()], 500);
        }
    }

    function makeDirectory($directoryPath): void
    {
        if (!$this->isDirectoryExists($directoryPath)) {
            mkdir(storage_path('app/public/' . $directoryPath), 0755, true);
        }
    }

    function isDirectoryExists($directoryPath): bool
    {
        if (file_exists(storage_path('app/public/' . $directoryPath))) {
            return true;
        }
        return false;
    }


    function getRelativePath($path)
    {
        return str_replace(url('storage'), '', $path);
    }

    function generatePath($type): string
    {
        return "Images/" . $type . "/";
    }

    function generateUniqueImageName(): string
    {
        return uniqid() . '.webp';
    }

    function resizeImage($image, $type)
    {
        return match ($type) {
            'tour' => $image->scaleDown(width: 1200),
            'blog' => $image->scaleDown(width: 1000),
            'location' => $image->scaleDown(width: 900),
            'tourCover' => $image->scaleDown(width: 1400),
            'category' => $image->scaleDown(width: 1200),
            default => $image
        };
    }
}
