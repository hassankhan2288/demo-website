<?php

namespace App\Http\Controllers\Admin;

use App\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Session;


class PromotionControler extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        generateBreadcrumb();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotion =Promotion::orderBy('id','DESC')->paginate(10);

        return view('admin.partials.promotion_banner.index')->with('promotions',$promotion);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.partials.promotion_banner.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    dd($request->all());

        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'color'=>'string|required',
            'start_date'=>'required',
            'end_date'=>'required',
            'status'=>'required|in:active,inactive',

        ]);
        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Promotion::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $status=Promotion::create($data);
        if($status){
            request()->session()->flash('success','Promotion Banner successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding banner');
        }
        Session::save();
        return redirect()->route('admin.promotion');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $promotion =Promotion::findOrFail($id);
        return view('admin.partials.promotion_banner.edit')->with('promotion',$promotion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function promotion_store(Request $request, $id)
    {
        $promotion =Promotion::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'color'=>'string|required',
            'start_date'=>'required',
            'end_date'=>'required',
            'status'=>'required|in:active,inactive',

        ]);
        $data=$request->all();  
        $status=$promotion->fill($data)->save();
        if($status){
            request()->session()->flash('success','Promotion Banner successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating banner');
        }
        return redirect()->route('admin.promotion');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function promotion_delete(Request $request, $id)
    {
        $promotion = Promotion::where('id',$id)->first();

        $promotion->delete();
        
        return redirect()->route( 'admin.promotion' )->with('success', 'Deleted successfully.');
    }
}
