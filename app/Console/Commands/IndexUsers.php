<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TeamTNT\TNTSearch\Indexer\TNTGeoIndexer;

class IndexUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index the users table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $candyShopIndexer = new TNTGeoIndexer();
        $candyShopIndexer->loadConfig([
            'driver'    => env('DB_CONNECTION', 'mysql'),
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE', 'dentist'),
            'username'  => env('DB_USERNAME', 'root'),
            'password'  => env('DB_PASSWORD', 'root'),
            'storage'   => storage_path(),
            'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class,
            'tokenizer' => \TeamTNT\TNTSearch\Support\ProductTokenizer::class
        ]);
        $candyShopIndexer->createIndex('candyShops.index');
        $candyShopIndexer->query('SELECT * FROM users;');
        $candyShopIndexer->run();
    }
}
