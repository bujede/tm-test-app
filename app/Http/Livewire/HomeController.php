<?php

namespace App\Http\Livewire;

use App\Models\StockReport;
use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class HomeController extends Component
{
    public $symbol, $res, $data;
    use LivewireAlert;
    public $user;
    protected $listeners = [ 'fbLogOut' => 'makeSocialLogOut'];

    public function makeSocialLogOut()
    {
        $this->dispatchBrowserEvent('fbLogOut');
    }

    public function getStockDetails()
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=' . $this->symbol . '&apikey=0O18XUJW9P8QVGQJ',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        // $response = json_encode($response);
        $response = json_decode($response);
        Debugbar::info( $this->symbol);
        $globalQuote = "Global Quote";
        $open = "02. open";
        $high = "03. high";
        $low = "04. low";
        $price = "05. price";
        Debugbar::info( $response->$globalQuote);
        Debugbar::info( $response->$globalQuote->$low);
        Debugbar::info( $response->$globalQuote->$high);
        Debugbar::info( $response->$globalQuote->$price);
        // Debugbar::info( "Price is: " . $response.$globalQuote.$price);
        if ( $httpcode == 200 ) {
            $this->alert('success', 'Details fetched successfully!');
            StockReport::create([
                'symbol' => $this->symbol,
                'high' => $response->$globalQuote->$high,
                'low' => $response->$globalQuote->$low,
                'price' => $response->$globalQuote->$price,
                'user_id' => Auth::user()->id
            ]);
        } else {
            $this->alert('error', 'Error fetching details!');
        }
    }

    public function flushDataAndRecreateTable()
    {
        DB::statement(
            'DROP TABLE IF EXISTS `stock_reports`'
        );
        DB::statement(
            'CREATE TABLE `stock_reports` (
                `id` bigint(20) UNSIGNED NOT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                `symbol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `high` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `low` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `user_id` bigint(20) UNSIGNED NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;'
        );
        DB::statement(
            'ALTER TABLE `stock_reports`
            ADD PRIMARY KEY (`id`);'
        );
        DB::statement(
            'ALTER TABLE `stock_reports` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;'
        );
    }

    public function runMigration()
    {
        $this->alert(
            'success', 'Migration was successful!'
        );
        Artisan::call('migrate', array('--path' => 'app/migrations', '--force' => true));
    }

    public function render()
    {
        $this->user = User::findOrFail( Auth::user()->id); 
        $this->data = StockReport::orderBy('created_at', 'Desc')->get();
        return view('livewire.home-controller');
    }
}
