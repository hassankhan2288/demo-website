<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Stock;
use App\Product;
use App\Warehouse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Session;

class StockController extends Controller
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
        $stock=Stock::with('warehouse','product')->orderBy('id','DESC')->paginate(10);
        //dd($stock->toArray());

        return view('admin.partials.stock.index')->with('stock',$stock);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.partials.stock.create');
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
            'product_id'=>'required',
            'warehouse_id'=>'required',
            'stocks'=>'required|numeric',
            //'address'=>'required',
            'is_active'=>'required|in:1,0',
        ]);
        $data=$request->all();
        //dd($data);
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
        $status=Stock::create($data);
        if($status){
            request()->session()->flash('success','stock successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding stock');
        }
        Session::save();
        return redirect()->route('stock.index');
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
        $stock=Stock::where('id',$id)->with('warehouse','product')->get();
        //dd($stock[0]['id']);
        return view('admin.partials.stock.edit')->with('stock',$stock);
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
        $stock=Stock::findOrFail($id);
        $this->validate($request,[
            'product_id'=>'required',
            'warehouse_id'=>'required',
            'stocks'=>'required|numeric',
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
        $status=$stock->fill($data)->save();
        if($status){
            request()->session()->flash('success','stock successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating stock');
        }
        return redirect()->route('stock.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock=Stock::findOrFail($id);
        $status=$stock->delete();
        if($status){
            request()->session()->flash('success','stock successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting stock');
        }
        return redirect()->route('stock.index');
    }

    public function searchProduct(Request $request){
        //dd(1);
        $data = [];
        //$data[] = ['text'=>"All", 'id'=>""];
        $users = Product::where("name", "like", '%'.$request->search."%")->limit(10)->get();
        if($users){
            foreach ($users as $user) {
                $data[] = ['text'=>$user->name, 'id'=>$user->id,'value'=>$user->id];
            }
        }
        return  response()->json(['results'=>$data]);
    }

    public function searchWarehouse(Request $request){
        //dd(1);
        $data = [];
       // $data[] = ['text'=>"All", 'id'=>""];
        $users = Warehouse::where("name", "like", '%'.$request->search."%")->limit(10)->get();
        if($users){
            foreach ($users as $user) {
                $data[] = ['text'=>$user->name.'-'.$user->title, 'id'=>$user->id,'value'=>$user->id];
            }
        }
        return  response()->json(['results'=>$data]);
    }
}
