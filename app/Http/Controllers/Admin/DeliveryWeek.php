<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OAuthClient;
use App\Delivery_week;
use Illuminate\Support\Facades\Auth;
use Session;

class DeliveryWeek extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
        generateBreadcrumb();

    }

    public function index()
    {
        //dd(982);
        $data=Delivery_week::with('warehouse')->orderBy('id','DESC')->paginate(10);
        //dd($stock->toArray());

        return view('admin.partials.deliveryweek.index')->with('data',$data);
    }
    public function create()
    {
        return view('admin.partials.deliveryweek.create');
    }
    public function store(Request $request)
    {
        // return $request->all();
        //dd(12);
        $this->validate($request,[
            'delivery_day'=>'required',
            'warehouse_id'=>'required',
            'limit_orders'=>'required|numeric',
            //'address'=>'required',
            'is_active'=>'required|in:1,0',
        ]);
        $data=$request->all();

        $status=Delivery_week::create($data);
        if($status){
            request()->session()->flash('success','Delivery Days successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding Delivery Days');
        }
        Session::save();
        return redirect()->route('deliveryr.index');
    }
    public function edit($id)
    {
        $Delivery=Delivery_week::where('id',$id)->get();
        
        return view('admin.partials.deliveryweek.edit')->with('Delivery',$Delivery);
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
        $stock=Delivery_week::findOrFail($id);
        $this->validate($request,[
            'delivery_day'=>'required',
            'warehouse_id'=>'required',
            'limit_orders'=>'required|numeric',
            'is_active'=>'required|in:1,0',
        ]);
        $data=$request->all();
        $status=$stock->fill($data)->save();
        if($status){
            request()->session()->flash('success','Delivery Days successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating Delivery Days');
        }
        return redirect()->route('deliveryr.index');
    }

    public function delete($id)
    {
        $stock=Delivery_week::findOrFail($id);
        $status=$stock->delete();
        if($status){
            request()->session()->flash('success','Delivery Days successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting Delivery Days');
        }
        return redirect()->route('deliveryr.index');
    }
}
