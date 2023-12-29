<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class UpdateCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-category:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $category_products = DB::table("categories")
        ->selectRaw("categories.*, categories.id as original_category_id,  categories_tbl.*,products_tbl.*")
        ->join('categories_tbl','categories_tbl.category_id','=','categories.code')
        ->join('products_tbl', 'products_tbl.category_id', '=', 'categories_tbl.id')
        ->get();
        foreach($category_products as $product){
            DB::table("products")->where("code",$product->product_code)->update(["category_id"=>$product->original_category_id]);
        }

        $category_products = DB::table("categories")
        ->selectRaw("categories.*, categories.id as original_category_id,  sub_categories_tbl.*,products_tbl.*")
        ->join('sub_categories_tbl','sub_categories_tbl.subcategory_id','=','categories.code')
        ->join('products_tbl', 'products_tbl.subcategory_id', '=', 'sub_categories_tbl.id')
        ->get();
        foreach($category_products as $product){
            DB::table("products")->where("code",$product->product_code)->update(["category_id"=>$product->original_category_id]);
        }

        $this->line("done");
    }
}
