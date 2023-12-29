<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Warehouse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Services\MSDynamic;
use DataTables;
use Session;

class WareHouseController extends Controller
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
        $warehouse=Warehouse::orderBy('id','DESC')->paginate(10);
        //dd($warehouse);

        return view('admin.partials.warehouse.index')->with('warehouse',$warehouse);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.partials.warehouse.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MSDynamic $api)
    {
        // return $request->all();
        //dd(12);
        $this->validate($request,[
            'name'=>'string|required|max:100',
            'phone'=>'required|numeric|min:11',
            'email'=>'required|email|max:255|unique:warehouses',
            'address'=>'required',
            'is_active'=>'required|in:1,0',
        ]);
        $data=$request->all();
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
        $status=Warehouse::create($data);
        $location = [
            'code'=>Str::limit($data['name'], 10, '' ),
            'displayName'=>$data['name'],
            'addressLine1'=>$data['address'],
            'email'=>$data['email'],
            'phoneNumber'=>$data['phone'],

        ];
        // $api->location($location, $status);

        if($status){
            request()->session()->flash('success','Warehouse successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding Warehouse');
        }
        Session::save();
        return redirect()->route('warehouse.index');
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
        $warehouse=Warehouse::findOrFail($id);
        //dd(12);
        return view('admin.partials.warehouse.edit')->with('warehouse',$warehouse);
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
        $warehouse=Warehouse::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required|max:100',
            'phone'=>'required|numeric|min:11',
            'email'=>'required|email',
            'address'=>'required',
            'is_active'=>'required|in:1,0',
        ]);
        $data=$request->all();
        // dd($data);
        $warehouse->title = $request->title;
        $warehouse->phone = $request->phone;
        $warehouse->address = $request->address;
        $warehouse->delivery_charges = $request->delivery_charges;
        $warehouse->amount_over = $request->amount_over;
        $warehouse->is_active = $request->is_active;
        $warehouse->postcodes = $request->postcodes;
        $status = $warehouse->save();
        // $status=$warehouse->fill($data)->save();
        // dd($status);
        if($status){
            request()->session()->flash('success','warehouse successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating warehouse');
        }
        return redirect()->route('warehouse.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warehouse=Warehouse::findOrFail($id);
        $status=$warehouse->delete();
        if($status){
            request()->session()->flash('success','warehouse successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting warehouse');
        }
        return redirect()->route('warehouse.index');
    }
}
