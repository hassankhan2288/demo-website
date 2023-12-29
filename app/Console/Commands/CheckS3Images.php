<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class CheckS3Images extends Command
{
    protected $signature = 'check:s3images';
    protected $description = 'Check S3 images and update database';

    public function handle()
    {
        // $folderName = 'storage/thumbnail';
        // $placeholderImageUrl = "https://fakeimg.pl/200x200";

        // $products = Product::all();

        // foreach ($products as $product) {
        //     $imageName = $product->image;

        //     try {
        //         $exists = Storage::disk('s3')->exists($folderName . '/' . $imageName);

        //         if (!$exists) {
        //             $product->update(['image' => null]);
        //         }
        //     } catch (\Exception $e) {
        //         // Log the error if necessary
        //         \Log::error('Error checking S3 image existence: ' . $e->getMessage());
        //     }
        // }

        // $this->info('S3 image check completed.');
    }
}
