<?php


namespace App\Http\Repositories;

use Illuminate\Support\Facades\Storage;

class Repository
{

    /**
     * @param string $base64
     * @param string $path
     * @return string
     */
    public function base64Upload(string $base64, string $path): string
    {
        $mimeType = explode("/", mime_content_type($base64))[1];
        $imageFileName = time() . '-' . rand(1, 999999999) . '.' . $mimeType;
        $s3 = Storage::disk();
        $filePath = '/public/' . $path . '/' . $imageFileName;
        $s3->put($filePath, file_get_contents($base64), 'public');

        return $path . '/' . $imageFileName;
    }

}
