<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Session;

class BannerController extends Controller
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
        $banner=Banner::orderBy('id','DESC')->paginate(10);

        return view('admin.partials.banner.index')->with('banners',$banner);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.partials.banner.create');
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
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'link'=>'string|required',
            'photo'=>'required|image|mimes:jpeg,jpg,png,gif',
            'status'=>'required|in:active,inactive',
            'type' => 'required|in:website,mobile'
        ]);
        $data=$request->all();
        $photo = $request->photo;
        if ($photo) {
            $photoName = $photo->getClientOriginalName();
            $photo->move('public/banners/', $photoName);
            $data['photo'] = $photoName;
        }
        
        // if ($photo) {
        //     $data['photo'] = \Helper::upload_S3_image($photo,'public/banners/','storage/banners/');
            // $extension      = $photo->getClientOriginalExtension();
            // $imageName      = $photo->getClientOriginalName();
            // $imageName      = str_replace(' ', '_', $imageName);
            // $fileNameWithoutExt = pathinfo($imageName, PATHINFO_FILENAME);
            // $destinationPath = base_path('public/banners/');
            // $imageUrl       = $fileNameWithoutExt . '.' . $extension;
            // // $photoName = $photo->getClientOriginalName();
            // $photo->move($destinationPath, $imageUrl);
            // $urlImage = $destinationPath . '' . $imageUrl;
            // // dd($urlImage);
            // $imagePath = 'storage/banners/' . $imageUrl;
            // // dd($imagePath);
            // $imageS3Storage = Storage::disk('s3')->put($imagePath, file_get_contents($urlImage),'public');
            // // $imageS3Storage = Storage::disk('s3')->url($imageS3Storage);
            // if($imageS3Storage){
            //     $data['photo'] = 'storage/banners/'.$imageUrl;
            //     unlink($urlImage);
            // }
        // }

        $slug=Str::slug($request->title);
        $count=Banner::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        if(isset($request->link)){
            $data['link']=$request->link;
        }
        $data['slug']=$slug;
        // return $slug;
        $status=Banner::create($data);
        if($status){
            request()->session()->flash('success','Banner successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding banner');
        }
        Session::save();
        return redirect()->route('banner.index');
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
        $banner=Banner::findOrFail($id);
        return view('admin.partials.banner.edit')->with('banner',$banner);
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
        $banner=Banner::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'photo'=>'required|image|mimes:jpeg,jpg,png,gif',
            'status'=>'required|in:active,inactive',
            'type' => 'required|in:website,mobile'
        ]);
        $data=$request->all();
        $photo = $request->photo;
        // if ($photo) {
        //     $photoName = $photo->getClientOriginalName();
        //     $photo->move('banners/', $photoName);
        //     $data['photo'] = $photoName;
        // }
        if ($photo) {
            $data['photo'] = \Helper::upload_S3_image($photo,'public/banners/','storage/banners/');
            // $extension      = $photo->getClientOriginalExtension();
            // $imageName      = $photo->getClientOriginalName();
            // $imageName      = str_replace(' ', '_', $imageName);
            // $fileNameWithoutExt = pathinfo($imageName, PATHINFO_FILENAME);

            // $destinationPath = base_path('public/banners/');

            // $imageUrl       = $fileNameWithoutExt . '.' . $extension;

            // // $photoName = $photo->getClientOriginalName();
            // $photo->move($destinationPath, $imageUrl);

            // $urlImage = $destinationPath . '' . $imageUrl;
            // // dd($urlImage);
            // $imagePath = 'storage/banners/' . $imageUrl;
            // // dd($imagePath);
            // $imageS3Storage = Storage::disk('s3')->put($imagePath, file_get_contents($urlImage),'public');

            // // $imageS3Storage = Storage::disk('s3')->url($imageS3Storage);
            // if($imageS3Storage){
            //     $data['photo'] = 'storage/banners/'.$imageUrl;
            //     unlink($urlImage);
            // }
        }
        // $slug=Str::slug($request->title);
        // $count=Banner::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['slug']=$slug;
        // return $slug;
        $status=$banner->fill($data)->save();
        if($status){
            request()->session()->flash('success','Banner successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating banner');
        }
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner=Banner::findOrFail($id);
        $status=$banner->delete();
        if($status){
            request()->session()->flash('success','Banner successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting banner');
        }
        return redirect()->route('banner.index');
    }
}
