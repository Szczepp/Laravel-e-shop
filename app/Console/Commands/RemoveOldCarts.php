<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;

class RemoveOldCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carts:remove-old {--days=7 : Cart age in days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove old carts';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $deadline = now()->subDays($this->option('days'));
        $counter = Cart::whereDate('updated_at', '<=', $deadline)->delete();
        $this->info("Done! {$counter} carts removed.");

        return 0;
    }
}
