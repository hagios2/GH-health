<?php

namespace App\Jobs;

use App\Mail\ShopFollowersNewProductMail;
use App\Merchandiser;
use App\Product;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ShopObserverJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $merchandiser;

    public $product;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Merchandiser $merchandiser, Product $product)
    {
        $this->merchandiser = $merchandiser;

        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $followers = $this->merchandiser->followers;

        foreach ($followers as $follower)
        {
            Mail::to($follower->email)->cc($this->merchandiser->email)->queue(new ShopFollowersNewProductMail($this->merchandiser, $this->product, $follower));
        }
    }
}
