<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Leaves;
use App\Product;
use App\Warehouse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Session;

class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:admin');
        generateBreadcrumb();

    }

    public function index()
    {
        //dd(982);
        $leaves=Leaves::with('warehouse')->orderBy('id','DESC')->paginate(10);
        // dd($leaves[0]->warehouse->name);


        return view('admin.partials.leaves.index')->with('leaves',$leaves);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouses = Warehouse::all();
        return view('admin.partials.leaves.create',compact('warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        //dd(12);
        $this->validate($request,[
            'warehouse_id'=>'required|numeric',
            'name'=>'required',
            'date'=>'required',
            //'stocks'=>'required|numeric',
            //'address'=>'required',
            'is_active'=>'required|in:1,0',
        ]);
        $data=$request->all();
        

        // dd($data);
        // $photo = $request->photo;
        // if ($photo) {
        //     $photoName = $photo->getClientOriginalName();
        //     $photo->move('banners/', $photoName);
        //     $data['photo'] = $photoName;
        // }

        // $slug=Str::slug($request->title);
        // $count=Banner::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['slug']=$slug;
        // return $slug;
        $status=Leaves::create($data);
        if($status){
            request()->session()->flash('success','leaves successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding leaves');
        }
        Session::save();
        return redirect()->route('leaves.index');
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
        //dd(12);
        $leaves=Leaves::with('warehouse')->where('id',$id)->get();
        $warehouses = Warehouse::all();

        //dd($stock[0]['id']);
        return view('admin.partials.leaves.edit')->with('leaves',$leaves)->with('warehouses',$warehouses);
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
        $leaves=Leaves::findOrFail($id);
        $this->validate($request,[
            'name'=>'required',
            'date'=>'required',
            //'stocks'=>'required|numeric',
            //'address'=>'required',
            'is_active'=>'required|in:1,0',
        ]);
        $data=$request->all();
        
        // $slug=Str::slug($request->title);
        // $count=Banner::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['slug']=$slug;
        // return $slug;
        $status=$leaves->fill($data)->save();
        if($status){
            request()->session()->flash('success','leaves successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating leaves');
        }
        return redirect()->route('leaves.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leaves=Leaves::findOrFail($id);
        $status=$leaves->delete();
        if($status){
            request()->session()->flash('success','leaves successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting leaves');
        }
        return redirect()->route('leaves.index');
    }

    

    
}
