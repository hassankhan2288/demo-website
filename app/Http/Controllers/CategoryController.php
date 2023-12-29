<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $baseURL = 'https://cater-choice-assets.s3.eu-west-2.amazonaws.com/';

        $categories =  Category::with(["sub"=>function($query){

            $query->withCount("product")->whereHas("product");

        }])->withCount("product")->whereNull("parent_id")->orWhere("parent_id",0)->get();

        $categories->transform(function ($category) use ($baseURL) {
            if ($category->image) {
                $category->image = $baseURL . $category->image;
            }

            if ($category->sub) {
                $category->sub->transform(function ($subCategory) use ($baseURL) {
                    if ($subCategory->image) {
                        $subCategory->image = $baseURL . $subCategory->image;
                    }
                    return $subCategory;
                });
            }

            return $category;
        });

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
