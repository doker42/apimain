<?php

namespace App\Common;

use App\Services\Images\TinifyService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tinify\Source;

class ImageManager
{
    use UploadTrait;

    public const DIR_IMAGES = '/images';

    public StorageLocalPublic $storage;

    public TinifyService $service;

    public function __construct(StorageLocalPublic $storage)
    {
        $this->storage = $storage;
        $this->service = new TinifyService();
    }


    /**
     * @param string $content
     * @param array $options
     * @return Source
     */
    public function resize(string $content, array $options=[]): Source
    {
        return $this->service->resize($content, $options);
    }


    /**
     * @param UploadedFile $file
     * @param array $options
     * @return string|null
     */
    public function storeAndResize(UploadedFile $file, array $options=[]): string|null
    {
        $fileName = self::createFileName($file);
        $fileContent = $file->getContent();
        $resized = $this->service->resize($fileContent);
        $resizedContent = $resized->result()->data();

        $storePath = self::DIR_IMAGES . '/' . $fileName;
        $this->storage->put($storePath, $resizedContent);

        return Storage::disk('public')->exists($storePath) ? $fileName : null;
    }


    /**
     * @param $image
     * @return string|null
     */
    public function store($image): string|null
    {
        $filename = self::createFileName($image);

        $result = $this->storage->putAs(self::DIR_IMAGES, $image, $filename);

        return $result ? $filename : null;
    }


    public function delete($filename): void
    {
        $filename = self::DIR_IMAGES . '/' . $filename;

        $this->storage->delete($filename);
    }
}
