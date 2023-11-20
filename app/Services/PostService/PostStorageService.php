<?php

namespace App\Services\PostService;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostStorageService
{
    protected function organizeStorage(
        string $destinyPath,
        array $imageList,
        bool $deleteRestInDestiny,
    )
    {
        if (empty($imageList))  return;

        $destinyContentsDirectoryPath  = "{$destinyPath}/contents";

        $originDestinyRelativePathList = $this->organize(
            $destinyPath,
            $imageList,
            $destinyContentsDirectoryPath
        );

        $this->resetGenericContentDirectory();

        if($deleteRestInDestiny){
            $this->deleteRestFilesInDestiny(
                $destinyContentsDirectoryPath,
                $originDestinyRelativePathList
            );
        }
    }

    private function organize(
        string $destinyPath,
        array $imageList,
        string $destinyContentsDirectoryPath,
    ):array
    {
        $originDestinyRelativePathList = [];

        foreach ($imageList as $image) {
            $originRelativePath = Str::after($image, Storage::url(''));

            $domain = Str::before($image, Str::after($image, url('/')));

            if($domain == url('/')){

                $filename = pathinfo($originRelativePath, PATHINFO_BASENAME);
                $destinyPathFull = "{$destinyPath}/contents/{$filename}";

                if(Storage::exists($originRelativePath)){
                    if(!Storage::directoryExists($destinyPath)){
                        Storage::makeDirectory($destinyPath);
                    }

                    if(!Storage::directoryExists($destinyContentsDirectoryPath)){
                        Storage::makeDirectory($destinyContentsDirectoryPath);
                    }

                    Storage::move($originRelativePath, $destinyPathFull);
                }

                $originDestinyRelativePathList[] = $destinyPathFull;
            }
        }

        return $originDestinyRelativePathList;
    }

    private function resetGenericContentDirectory()
    {
        $geralContents = '/uploads/posts/contents';
        Storage::deleteDirectory($geralContents);
        Storage::makeDirectory($geralContents);
    }

    private function deleteRestFilesInDestiny(
        string $destinyDirectoryPath,
        array $postContentImageList
    )
    {
        $allFilesOnDestinyDirectory = Storage::files($destinyDirectoryPath);

        if(empty($allFilesOnDestinyDirectory)) return;

        foreach($allFilesOnDestinyDirectory as $file){
            if(!in_array($file, $postContentImageList)){
                Storage::delete($file);
            }
        }
    }


    protected function modifyPostContent(
        string $content,
        string $destinyPath,
        array $imageList
    ): string
    {
        if (empty($imageList)) {
            return $content;
        }

        $newContent = $content;

        foreach ($imageList as $image) {
            $filename = pathinfo($image, PATHINFO_BASENAME);
            $destinyPathFull = Storage::url("{$destinyPath}/contents/{$filename}");

            $newContent = str_replace($image, $destinyPathFull, $content);
        }

        return $newContent;
    }
}
