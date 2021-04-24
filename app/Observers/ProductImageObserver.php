<?php

namespace App\Observers;

use App\Jobs\ShopObserverJob;
use App\ProductImage;
use Illuminate\Support\Facades\Log;

class ProductImageObserver
{
    /**
     * Handle the product image "created" event.
     *
     * @param  \App\ProductImage  $productImage
     * @return void
     */
    public function created(ProductImage $productImage)
    {
        $product = $productImage->product;

        if($product->image->count() == 1)
        {
            Log::info(json_encode($product));

            if($product->merchandiser && $product->merchandiser->followers->count() > 0)
            {
                ShopObserverJob::dispatch($product->merchandiser, $product);
            }
        }
    }

    /**
     * Handle the product image "updated" event.
     *
     * @param  \App\ProductImage  $productImage
     * @return void
     */
    public function updated(ProductImage $productImage)
    {
        //
    }

    /**
     * Handle the product image "deleted" event.
     *
     * @param  \App\ProductImage  $productImage
     * @return void
     */
    public function deleted(ProductImage $productImage)
    {
        //
    }

    /**
     * Handle the product image "restored" event.
     *
     * @param  \App\ProductImage  $productImage
     * @return void
     */
    public function restored(ProductImage $productImage)
    {
        //
    }

    /**
     * Handle the product image "force deleted" event.
     *
     * @param  \App\ProductImage  $productImage
     * @return void
     */
    public function forceDeleted(ProductImage $productImage)
    {
        //
    }
}
