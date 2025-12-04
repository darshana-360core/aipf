<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\settingModel;
use Illuminate\Http\Request;

class coinPriceFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:coin-fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(Request $request)
    {
        $getPrice = file_get_contents("https://aipf-api.vercel.app/aipf-price");
        echo $getPrice . "\n";
        $data = json_decode($getPrice, true);

        if (isset($data['price'])) {
            settingModel::where(['id' => 1])->update(['coin_price' => $data['price']]);
        }
    }
}
