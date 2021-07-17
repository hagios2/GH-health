<?php

namespace App\Observers;

use App\Models\IssuedProduct;

class IssuedOutProductObserver
{
    /**
     * Handle the issued product "created" event.
     *
     * @param  \App\Models\IssuedProduct $issuedProduct
     * @return void
     */
    public function created(IssuedProduct $issuedProduct)
    {
        $product = $issuedProduct->product;

        if($product)
        {
            $remaining_quantity = $product->quanity - $issuedProduct->quantity;

            $product->update(['quantity' => $remaining_quantity]);
        }
    }

    /**
     * Handle the issued product "updated" event.
     *
     * @param  \App\Models\IssuedProduct  $issuedProduct
     * @return void
     */
    public function updated(IssuedProduct $issuedProduct)
    {

    }

    /**
     * Handle the issued product "deleted" event.
     *
     * @param  \App\Models\IssuedProduct  $issuedProduct
     * @return void
     */
    public function deleted(IssuedProduct $issuedProduct)
    {
        //
    }

    /**
     * Handle the issued product "restored" event.
     *
     * @param  \App\Models\IssuedProduct  $issuedProduct
     * @return void
     */
    public function restored(IssuedProduct $issuedProduct)
    {
        //
    }

    /**
     * Handle the issued product "force deleted" event.
     *
     * @param  \App\Models\IssuedProduct  $issuedProduct
     * @return void
     */
    public function forceDeleted(IssuedProduct $issuedProduct)
    {
        //
    }
}
