<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Slots;
use App\Product;
use App\Warehouse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Session;

class SlotsController extends Controller
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
        $slots=Slots::with('warehouse')->orderBy('id','DESC')->paginate(10);
        //dd($stock->toArray());

        return view('admin.partials.slots.index')->with('slots',$slots);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.partials.slots.create');
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
        $slotsObj = new Slots();
        $this->validate($request,[
            'name'=>'required',
            'warehouse_id'=>'required',
            'start_time'=>'required',
            'duration'=>'required',
            'end_time'=>'required',
            'start_day'=>'required',
            'end_day'=>'required',
            'per_slot_order'=>'required',
            'is_active'=>'required|in:1,0',
        ]);
        $data=$request->all();
        if($request->is_active == 1){
            $flag = $slotsObj->checkActiveSlots($request->warehouse_id);
            
            if($flag){
                return redirect()->route('slots.index')->with('error', 'Each warehouse can have only seven active slot');
                // return redirect()->route('slots.index')->with('error', 'Each warehouse can have only one active slot');
                // request()->session()->flash('error','Each wearhouse can have only one active slot');
                // Session::save();
                // return redirect()->route('slots.index');
            }
        }
        
        $status=Slots::create($data);
        if($status){
            return redirect()->route('slots.index')->with('success', 'slots successfully added');
        }
        else{
            // request()->session()->flash('error','Error occurred while adding slots');
            return redirect()->route('slots.index')->with('error', 'Error occurred while adding slots');
        }
        // Session::save();
        // return redirect()->route('slots.index')->with('success', 'The post created successfully.');
        // return redirect()->route('slots.index')->with('success', 'The post created successfully.');
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
        $slot=Slots::where('id',$id)->with('warehouse')->first();
        //dd($stock[0]['id']);
        return view('admin.partials.slots.edit')->with('slot',$slot);
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
        $slotsObj = new Slots();
        $slots=Slots::findOrFail($id);
        $this->validate($request,[
            'name'=>'required',
            'warehouse_id'=>'required',
            'start_time'=>'required',
            'duration'=>'required',
            'end_time'=>'required',
            'per_slot_order'=>'required',
            'is_active'=>'required|in:1,0',
        ]);
        $data=$request->all();
        if($request->is_active == 1){
            $checkSlot = Slots::where('is_active',1)->where('id',$id)->first();
            if($checkSlot == null){
                $flag = $slotsObj->checkActiveSlots($request->warehouse_id);
                if($flag){
                    return redirect()->route('slots.index')->with('not_permitted', 'Each warehouse can have only seven active slot');
                    // request()->session()->flash('error','Each wearhouse can have only one active slot');
                    // return redirect()->route('slots.index');
                }

            }
        }
        // $slug=Str::slug($request->title);
        // $count=Banner::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['slug']=$slug;
        // return $slug;
        $status=$slots->fill($data)->save();
        if($status){
            // request()->session()->flash('success','slots successfully updated');
            return redirect()->route('slots.index')->with('success', 'slots successfully updated');
        }
        else{
            // request()->session()->flash('error','Error occurred while updating slots');
            return redirect()->route('slots.index')->with('error', 'Error occurred while updating slots');
        }
        // return redirect()->route('slots.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slots=Slots::findOrFail($id);
        $status=$slots->delete();
        if($status){
            request()->session()->flash('success','slot successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting slot');
        }
        return redirect()->route('slots.index');
    }

    // public function searchProduct(Request $request){
    //     //dd(1);
    //     $data = [];
    //     //$data[] = ['text'=>"All", 'id'=>""];
    //     $users = Product::where("name", "like", '%'.$request->search."%")->limit(10)->get();
    //     if($users){
    //         foreach ($users as $user) {
    //             $data[] = ['text'=>$user->name, 'id'=>$user->id,'value'=>$user->id];
    //         }
    //     }
    //     return  response()->json(['results'=>$data]);
    // }

    // public function searchWarehouse(Request $request){
    //     //dd(1);
    //     $data = [];
    //    // $data[] = ['text'=>"All", 'id'=>""];
    //     $users = Warehouse::where("name", "like", '%'.$request->search."%")->limit(10)->get();
    //     if($users){
    //         foreach ($users as $user) {
    //             $data[] = ['text'=>$user->name, 'id'=>$user->id,'value'=>$user->id];
    //         }
    //     }
    //     return  response()->json(['results'=>$data]);
    // }
}
