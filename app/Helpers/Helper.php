<?php
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\Event;
use App\Setting;
use App\EventDescription;
use Carbon\Carbon;
use App\Message;
use App\Category;
use App\PostTag;
use App\PostCategory;
use App\Order;
use App\Wishlist;
use App\Shipping;
use App\Cart;
use App\Product_Sale;
use App\Customer;
use App\Stock;
use App\Warehouse;
use Illuminate\Support\Facades\DB;

function image_url($resource){

	return config("app.aws_url")."/".$resource;
}

function generateBreadcrumb($shop = null){

	if(Route::is('app.dashboard')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Dashboard', [
			['name'=>'Dashboard', 'route'=>'app.dashboard'],
		]));
	}


	if(Route::is('app.account.settings')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Settings', [
			['name'=>'Dashboard', 'route'=>'app.dashboard'],
			['name'=>'Settings', 'route'=>'account.settings'],
		]));
	}

	if(Route::is('app.branch')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Branch', [
			['name'=>'Dashboard', 'route'=>'app.dashboard'],
			['name'=>'Branch', 'route'=>'app.branch'],
		]));
	}

	if(Route::is('app.branch.form')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Branch', [
			['name'=>'Dashboard', 'route'=>'app.dashboard'],
			['name'=>'Branch', 'route'=>'app.branch'],
			['name'=>'Add', 'route'=>'app.branch'],
		]));
	}

	if(Route::is('app.product')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Products', [
			['name'=>'Dashboard', 'route'=>'app.dashboard'],
			['name'=>'Products', 'route'=>'app.product'],
		]));
	}

	/** Admin Breadcrumb **/

	if(Route::is('admin.dashboard')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Dashboard', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
		]));
	}

	if(Route::is('products.index')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Products', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Products', 'route'=>'products.index'],
		]));
	}
	if(Route::is('admin.tax')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Tax', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Tax', 'route'=>'admin.tax'],
		]));
	}
	if(Route::is('warehouse.index')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Warehouse', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Warehouse', 'route'=>'warehouse.index'],
		]));
	}
	if(Route::is('deliveryr.index')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Delivery Setting', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Delivery Setting', 'route'=>'deliveryr.index'],
		]));
	}
	if(Route::is('stock.index')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Stock', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Stock', 'route'=>'stock.index'],
		]));
	}

	if(Route::is('slots.index')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Slots', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Slots', 'route'=>'slots.index'],
		]));
	}
	if(Route::is('leaves.index')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Leaves', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Leaves', 'route'=>'leaves.index'],
		]));
	}
	if(Route::is('admin.sale.list')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Sales', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Sales', 'route'=>'admin.sale.list'],
		]));
	}
	if(Route::is('admin.pos.sale.list')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('POS Sales', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'POS Sales', 'route'=>'admin.pos.sale.list'],
		]));
	}
	if(Route::is('admin.sub')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Admin', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Admin', 'route'=>'admin.sub'],
		]));
	}

	if(Route::is('admin.user')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('User', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'User', 'route'=>'admin.user'],
		]));
	}

	if(Route::is('admin.user.form')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('User', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'User', 'route'=>'admin.user'],
			['name'=>'Add', 'route'=>'admin.user'],
		]));
	}

	if(Route::is('admin.company')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Company', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Company', 'route'=>'admin.company'],
		]));
	}

	if(Route::is('admin.company.form')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Company', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Company', 'route'=>'admin.company'],
			['name'=>'Add', 'route'=>'admin.company'],
		]));
	}

	if(Route::is('admin.company.assign')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Company Product', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Company', 'route'=>'admin.company'],
			['name'=>'Company Product', 'route'=>'admin.company'],
		]));
	}

	if(Route::is('admin.vehicle')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Vehicle', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Vehicle', 'route'=>'admin.vehicle'],
		]));
	}

	if(Route::is('admin.vehicle.form')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Vehicle', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Vehicle', 'route'=>'admin.vehicle'],
			['name'=>'Add', 'route'=>'admin.vehicle'],
		]));
	}

	if(Route::is('admin.service')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Service', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Service', 'route'=>'admin.service'],
		]));
	}

	if(Route::is('admin.service.form')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Service', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Service', 'route'=>'admin.service'],
			['name'=>'Add', 'route'=>'admin.service'],
		]));
	}

	if(Route::is('category.index')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Category', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Category', 'route'=>'category.index'],
		]));
	}
	if(Route::is('customer_category.index')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Customer Category', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Customer Category', 'route'=>'customer_category.index'],
		]));
	}

	if(Route::is('category.form')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Category', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Category', 'route'=>'admin.category'],
			['name'=>'Add', 'route'=>'category.form'],
		]));
	}

	if(Route::is('brand.index')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Brand', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Brand', 'route'=>'brand.index'],
		]));
	}
	if(Route::is('admin.coupon')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Coupon', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Coupon', 'route'=>'admin.coupon'],
		]));
	}
	if(Route::is('admin.search_term')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Search Analytics', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Search Analytics', 'route'=>'admin.search_term'],
		]));
	}
	if(Route::is('admin.product_price')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Product Price Table', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Product Price Table', 'route'=>'admin.product_price'],
		]));
	}
	if(Route::is('admin.company_pricing')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Company Pricing Table', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Company Pricing Table', 'route'=>'admin.company_pricing'],
		]));
	}
	if(Route::is('banner.index')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Banner', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Banner', 'route'=>'banner.index'],
		]));
	}
	if(Route::is('branches.index')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Branches', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Branches', 'route'=>'branches.index'],
		]));
	}
	if(Route::is('admin.role')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Role', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Role', 'route'=>'admin.role'],
		]));
	}

	if(Route::is('admin.role.form')){

		View::share('renderBreadcrumb', generateBreadcrumbLink('Role', [
			['name'=>'Dashboard', 'route'=>'admin.dashboard'],
			['name'=>'Role', 'route'=>'admin.role'],
			['name'=>'Add', 'route'=>'admin.role'],
		]));
	}
    if(Route::is('admin.product.assign.free.product')){

        View::share('renderBreadcrumb', generateBreadcrumbLink('Free Product', [
            ['name'=>'Dashboard', 'route'=>'admin.dashboard'],
            ['name'=>'Products', 'route'=>'products.index'],
            ['name'=>'Assign', 'route'=>'admin.product.assign.free.product'],
        ]));
    }



}


function generateBreadcrumbLink(String $title, Array $links){

	$html = '';
	$html .= '<h1 class="mr-2">'.$title.'</h1>';
	if($links):
		$html .= '<ul>';
		foreach ($links as $key => $value):
			$html .= '<li>';
			if(count($links)!==($key+1)):
				$html .= '<a href="'.route($value['route']).'">'.ucfirst($value['name']).'</a>';
			else:
				$html .= ucfirst($value['name']).'</li>';
			endif;

		endforeach;
		$html .= '</ul>';
	endif;

	return $html;
}

function isPassworedConfirmed($password){
	return Hash::check($password, Auth::user()->password);
}

function nice_number($n, $numner = 0) {
    // first strip any formatting;
    $n = (0+str_replace(",", "", $n));

    // is this a number?
    if (!is_numeric($n)) return false;

    // now filter it;
    if ($n >= 1000000000000) return round(($n/1000000000000), 2).'T';
    elseif ($n >= 1000000000) return round(($n/1000000000), 2).'B';
    elseif ($n >= 1000000) return round(($n/1000000), 2).'M';
    elseif ($n >= 1000) return round(($n/1000), 2).'K';

    return number_format($n, $numner);
}

function generateUserEvent($id){
	$data = [];
	$event_count = Event::where("user_id",$id)->count();
	if($event_count===0){
		$event_descriptions = EventDescription::all();
		foreach($event_descriptions as $event){
			$data[] = ['user_id'=>$id, 'event_description_id'=>$event->id, 'type'=>'shopify','channel'=>$event->channel];
		}
		Event::insert($data);
	}

}

function currency(){
	return "£";
}

function getAccessToken(){
	$setting = Setting::pluck("setting_value", "setting_key");
	if(isset($setting['access_token'])){
		if(Carbon::now()->diffInSeconds($setting['token_expires_in']??0, false)<60){
			$payload = generateAccessToken();
			$setting = Setting::updateOrCreate(
			    ['setting_key' =>  'access_token'],
			    ['setting_value' => $payload->access_token]
			);
			$setting->save();
			$setting = Setting::updateOrCreate(
			    ['setting_key' =>  'token_expires_in'],
			    ['setting_value' => Carbon::now()->addSeconds($payload->expires_in)]
			);
			$setting->save();
		}
	} else {
		$payload = generateAccessToken();
		$setting = Setting::updateOrCreate(
		    ['setting_key' =>  'access_token'],
		    ['setting_value' => $payload->access_token]
		);
		$setting->save();
		$setting = Setting::updateOrCreate(
		    ['setting_key' =>  'token_expires_in'],
		    ['setting_value' => Carbon::now()->addSeconds($payload->expires_in)]
		);
		$setting->save();
	}
	return Setting::pluck("setting_value", "setting_key");
}

function generateAccessToken(){
	$response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->asForm()->post('https://login.microsoftonline.com/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/oauth2/v2.0/token', [
            'client_id' => '18893c0a-a50d-4825-9cba-a52c6f8a0565',
            'client_secret' => 'vct8Q~e~2HrJoJ9JXurcan68mFa2R7S6jHXfFbOQ',
            'grant_type' => 'client_credentials',
            'scope' => 'https://api.businesscentral.dynamics.com/.default',
        ]);
        return json_decode($response->body());
}


class Helper{
public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    }
    public static function getAllCategory(){
        $category=new Category();
        $menu=$category->getAllParentWithChild();
        return $menu;
    }

    public static function getHeaderCategory(){
        $category = new Category();
        // dd($category);
        $menu=$category->getAllParentWithChild();

        if($menu){
            ?>

            <li>
            <a href="javascript:void(0);">Category<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                <?php
                    foreach($menu as $cat_info){
                        if($cat_info->child_cat->count()>0){
                            ?>
                            <li><a href="<?php echo route('product-cat',$cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    foreach($cat_info->child_cat as $sub_menu){
                                        ?>
                                        <li><a href="<?php echo route('product-sub-cat',[$cat_info->slug,$sub_menu->slug]); ?>"><?php echo $sub_menu->title; ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        else{
                            ?>
                                <li><a href="<?php echo route('product-cat',$cat_info->slug);?>"><?php echo $cat_info->title; ?></a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
    }

    public static function productCategoryList($option='all'){
        if($option='all'){
            return Category::orderBy('id','DESC')->get();
        }
        return Category::has('products')->orderBy('id','DESC')->get();
    }

    public static function postTagList($option='all'){
        if($option='all'){
            return PostTag::orderBy('id','desc')->get();
        }
        return PostTag::has('posts')->orderBy('id','desc')->get();
    }

    public static function postCategoryList($option="all"){
        if($option='all'){
            return PostCategory::orderBy('id','DESC')->get();
        }
        return PostCategory::has('posts')->orderBy('id','DESC')->get();
    }
    // Cart Count
    public static function cartCount($user_id=''){

       // if(Auth::check()){
            //if($user_id=="")
			if(\Auth::guard('customer')->user()){
				$user_id=\Auth::guard('customer')->user()->id;
			}else
			{
				$user_id=0;
			}

            //return Cart::where('user_id',$user_id)->where('order_id',null)->sum('quantity');
            $cart = Cart::where('user_id',$user_id)->where('order_id',null)->get();
			// $cart = Cart::where('user_id',$user_id)->where('order_id',null)->sum('quantity');
			return count($cart);
			// return $cart;
       // }
       // else{
        //    return 0;
        //}
    }
	public static function cartCountQuantity($user_id=''){

		// if(Auth::check()){
			 //if($user_id=="")
			 if(\Auth::guard('customer')->user()){
				 $user_id=\Auth::guard('customer')->user()->id;
			 }else
			 {
				 $user_id=0;
			 }

			 //return Cart::where('user_id',$user_id)->where('order_id',null)->sum('quantity');
			 // $cart = Cart::where('user_id',$user_id)->where('order_id',null)->get();
			 $cart = Cart::where('user_id',$user_id)->where('order_id',null)->sum('quantity');
			 // return count($cart);
			 return (int)$cart;
		// }
		// else{
		 //    return 0;
		 //}
	 }
    // relationship cart with product
    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public static function getAllProductFromCart($user_id=''){
       // if(Auth::check()){
         //   if($user_id=="") $user_id=auth()->user()->id;
		 if(\Auth::guard('customer')->user()){
				$user_id=\Auth::guard('customer')->user()->id;
			}else
			{
				$user_id=0;
			}
//            return Cart::with('product')->where('user_id',$user_id)->where('order_id',null)->get();
            return Cart::with(['product', 'product.freeProduct'])->where('user_id',$user_id)->where('order_id',null)->get();
    }
    // Total amount cart
    public static function totalCartPrice($user_id=''){
        if(\Auth::guard('customer')->user()){
				$user_id=\Auth::guard('customer')->user()->id;
			}else
			{
				$user_id=0;
			}
            return Cart::where('user_id',$user_id)->where('order_id',null)->sum('amount');
        // }
        // else{
        //     return 0;
        // }
    }
    public static function totalCartVatPrice($user_id=''){
        if(\Auth::guard('customer')->user()){
            $user_id=\Auth::guard('customer')->user()->id;
        }else
        {
            $user_id=0;
        }
        return Cart::where('user_id',$user_id)->where('order_id',null)->sum('vat');
        // }
        // else{
        //     return 0;
        // }
    }

	// Total amount cart with order ID
	public static function totalCartPriceOfOrder($order_id){
		if(\Auth::guard('customer')->user()){
			$user_id=\Auth::guard('customer')->user()->id;
		}else
		{
			$user_id=0;
		}
		return Cart::where('user_id',$user_id)->where('order_id',$order_id)->sum('amount');
	}
	public static function totalCartVatPriceOfOrder($order_id){
        if(\Auth::guard('customer')->user()){
            $user_id=\Auth::guard('customer')->user()->id;
        }else
        {
            $user_id=0;
        }
        return Cart::where('user_id',$user_id)->where('order_id',$order_id)->sum('vat');
        // }
        // else{
        //     return 0;
        // }
    }
    // Wishlist Count
    public static function wishlistCount($user_id=''){

        if(\Auth::guard('customer')->user()){
				$user_id=\Auth::guard('customer')->user()->id;
			}else
			{
				$user_id=0;
			}
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('quantity');
        // }
        // else{
        //     return 0;
        // }
    }
    public static function getAllProductFromWishlist($user_id=''){
        if(\Auth::guard('customer')->user()){
				$user_id=\Auth::guard('customer')->user()->id;
			}else
			{
				$user_id=0;
			}
            return Wishlist::with('product')->where('user_id',$user_id)->where('cart_id',null)->get();
        // }
        // else{
        //     return 0;
        // }
    }
    public static function totalWishlistPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('amount');
        }
        else{
            return 0;
        }
    }

    // Total price with shipping and coupon
    public static function grandPrice($id,$user_id){
        $order=Order::find($id);
        // dd($id);
        if($order){
            $shipping_price=(float)$order->shipping->price;
            $order_price=self::orderPrice($id,$user_id);
            return number_format((float)($order_price+$shipping_price),2,'.','');
        }else{
            return 0;
        }
    }

	public static function getDeliveryCharges($user_id,$warehouse_id){
		$warehouse = Warehouse::select('delivery_charges', 'amount_over')->where('id', $warehouse_id)->first();
		$total_quantity = Cart::where('user_id', $user_id)->where('order_id', null)->sum('quantity');
		$total_amount = Cart::where('user_id', $user_id)->where('order_id', null)->sum('amount');
		if($total_quantity >= 100 || $total_amount >= $warehouse->amount_over){
			return 0;
		}else{
			return $warehouse->delivery_charges;
		}
		// return $total_quantity;
	}

	public static function checkWarehouseOfProduct($product_id,$warehouse_id){
		$check = Stock::where('warehouse_id',$warehouse_id)->where('product_id',$product_id)->where('is_active', 1)->first();
		if($check){
			return true;
		}
		return false;
	}

	// Total price with shipping and coupon of an ORDER ID
	public static function getDeliveryChargesOfOrder($user_id,$warehouse_id,$order_id){
		$warehouse = Warehouse::select('delivery_charges', 'amount_over')->where('id', $warehouse_id)->first();
		$total_quantity = Cart::where('user_id', $user_id)->where('order_id', $order_id)->sum('quantity');
		$total_amount = Cart::where('user_id', $user_id)->where('order_id', $order_id)->sum('amount');
		if($total_quantity >= 100 || $total_amount >= $warehouse->amount_over){
			return 0;
		}else{
			return $warehouse->delivery_charges;
		}
		// return $total_quantity;
	}

    // Admin home
    public static function earningPerMonth(){
        $month_data=Order::where('status','delivered')->get();
        // return $month_data;
        $price=0;
        foreach($month_data as $data){
            $price = $data->cart_info->sum('price');
        }
        return number_format((float)($price),2,'.','');
    }

    public static function shipping(){
        return Shipping::orderBy('id','DESC')->get();
    }


	public static function upload_S3_image($photo,$upload_path_public,$upload_path_s3){
		
		$extension      = $photo->getClientOriginalExtension();
            $imageName      = $photo->getClientOriginalName();
			$imageName = date("Ymd").$imageName;
//			$imageName = now().$imageName;
            // $image = str_replace(array(',','.','-',':'),'',$image);
            $imageName      = str_replace(array(',','-',':',' '), '_', $imageName);
            $fileNameWithoutExt = pathinfo($imageName, PATHINFO_FILENAME);

            $destinationPath = base_path($upload_path_public);
			// $destinationPath = base_path('public/banners/');

            $imageUrl       = $fileNameWithoutExt . '.' . $extension;

            // $photoName = $photo->getClientOriginalName();
            $photo->move($destinationPath, $imageUrl);

            $urlImage = $destinationPath . '' . $imageUrl;
            // dd($urlImage);
            $imagePath = $upload_path_s3 . $imageUrl;
            $site_url = config('app.url');
			$env = config('msdynamic.app_env');
            if($env != 'local'){
				$original = $urlImage;
				// $proper_path = str_replace('/www/wwwroot/sale.cater-choice.com/public','',$urlImage);
				// $proper_path = str_replace('/www/wwwroot/cater-choice.com/public','',$urlImage);
				// $urlImage = $site_url.$proper_path;
				$imageS3Storage = Storage::disk('s3')->put($imagePath, file_get_contents($urlImage),'public');
				if($imageS3Storage){
					$data = $upload_path_s3.$imageUrl;
					unlink($original);
					return $data;
				}
				return null;
			}else{
				$imageS3Storage = Storage::disk('s3')->put($imagePath, file_get_contents($urlImage),'public');
				if($imageS3Storage){
					$data = $upload_path_s3.$imageUrl;
					unlink($urlImage);
					return $data;
				}
				return null;
			}

            // $imageS3Storage = Storage::disk('s3')->url($imageS3Storage);
	}

   public static function resizeAndUploadS3($photo, $upload_path_public, $upload_path_s3)
   {
       // Get the file extension and name
       $extension = $photo->getClientOriginalExtension();
       $imageName = $photo->getClientOriginalName();
       $imageName = now() . $imageName;
       $imageName = str_replace(array(',', '-', ':', ' '), '_', $imageName);
       $fileNameWithoutExt = pathinfo($imageName, PATHINFO_FILENAME);

       // Set the destination path for local storage
       $destinationPath = base_path($upload_path_public);

       // Generate a unique filename
       $imageUrl = $fileNameWithoutExt . '.' . $extension;

       // Move the original image to the local storage
       $photo->move($destinationPath, $imageUrl);

       // Resize the image
       $resizedImage = Image::make($photo)->resize(512, 512);

       // Set the path for the resized image on S3
       $imagePath = $upload_path_s3 . $imageUrl;

       // Get the public URL for the local image
       $urlImage = $destinationPath . '/' . $imageUrl;

       // Check the environment
       $env = config('msdynamic.app_env');

       if ($env != 'local') {
           // If not local, upload to S3 and remove the local image
           $imageS3Storage = Storage::disk('s3')->put($imagePath, $resizedImage->encode(), 'public');
           if ($imageS3Storage) {
               $data = $upload_path_s3 . $imageUrl;
               unlink($urlImage);
               return $data;
           }
       } else {
           // If local, upload to S3 and remove the local image
           $imageS3Storage = Storage::disk('s3')->put($imagePath, $resizedImage->encode(), 'public');
           if ($imageS3Storage) {
               $data = $upload_path_s3 . $imageUrl;
               unlink($urlImage);
               return $data;
           }
       }

       return null;
   }



	// Function to make arrays
	public static function makeDynamicsJobData($order,$user){
		$items = Cart::where('user_id',$order->customer_id)->where('order_id',$order->id)->get();
		//$items = Cart::where('user_id',$user->id)->where('order_id',$order->id)->get();

        $webItems = $items;

		$payment['TransactionDate'] = date('Y-m-d');
		$payment['DocumentType'] ="Invoice";
		$payment['CustomerNo'] = $user->ms_number;
		$payment['CustomerName'] = $user->name;
		$payment['PaymentAgainst'] = "";
		$payment['Amount'] = $order->total_price + $order->total_tax;
		$payment['Cash'] = 0;
		$payment['Card'] = $order->total_price + $order->total_tax;
		$payment['Cheque'] = 0;
		$payment['BankTransfer'] = 0;
		$payment['Others'] = 0;
		$payment['CreditMemo'] = 0;
		$payment['Total'] = $order->total_price + $order->total_tax;
		switch ($order->warehouse->name) {//change warehouse to getwarehoue on 25-nov-2023
			case 'BFD':
				// $salespersonCode = "BFD MANGR";
				$resposibilityCenter = "BRADFORD";
				// $customerPriceGroup = "BFD CC";
				break;
			case 'BDC':
				// $salespersonCode = "BDC MANGR";
				$resposibilityCenter = "JACKSON ST";
				// $customerPriceGroup = "BELLA PIZZ";
				break;
			case 'BOL':
				// $salespersonCode = "BOL MANGR";
				$resposibilityCenter = "BOLTON";
				// $customerPriceGroup = "BOL CC";
				break;
			case 'DIS':
				// $salespersonCode = "DIST MANGR";
				$resposibilityCenter = "JACKSON ST";
				// $customerPriceGroup = "DISTRIBUT";
				break;
			case 'LDS':
				// $salespersonCode = "LDS MANGR";
				$resposibilityCenter = "LEEDS";
				// $customerPriceGroup = "LDS CC";
				break;
			case 'SHE':
				// $salespersonCode = "SHEFF MANG";
				$resposibilityCenter = "JACKSON ST";
				// $customerPriceGroup = "SHEFFIELD";
				break;
			case 'BIR':
				// $salespersonCode = "BIR MAN";
				// $resposibilityCenter = "BIRMINGHAM";
				$resposibilityCenter = "BIRG";
				// $customerPriceGroup = "BARNIS";
				break;
			default:
				// $salespersonCode = "LEEDS MANG";
				$resposibilityCenter = "LEEDS";
				// $customerPriceGroup = "LDS CC";
				break;
		}
		$current_time = \Carbon\Carbon::now()->timestamp;
        $orderid= $order->id.'-'.$current_time;
		if($order->pick_time == null){ // Delivery will hit for pos
			$collectData['HeaderNo'] = "WED".$orderid;
			$collectData['DocumentType'] = "Order";
			$collectData['LocationCode'] = $user->getwarehouse->name;
			$collectData['PostingDate'] = $order->created_at;
			$collectData['SelltoCustomerNo'] = $user->ms_number;
			$collectData['Status'] = "Open";
			$collectData['YourReference'] = "Click & Delivery";
			$collectData['postingno'] = "WED".$orderid;
			$collectData['posnotes'] = "";
			$collectData['ExternalDocumentNo'] = "WED".$orderid;
			$collectData['PaymentTermsCode'] = "PREPAID";
			$collectData['Source'] = "Click & Delivery";
			foreach($webItems as $item){
				$itemDataCC['DocumentType'] = "Order";
				$itemDataCC['Type'] = "Item";
				// $itemDataCC['PostingDate'] = date('Y-m-d');
				$itemDataCC['No'] = $item->product->ms_id;
				$itemDataCC['Quantity'] = $item->quantity;
				// $itemDataCC['UnitofMeasureCode'] = "SINGLE";//item->type;
				$itemDataCC['UnitofMeasureCode'] = $item->type;
				// $itemDataCC['LocationCode'] = $order->warehouse->name;
				$itemDataCC['UnitPrice'] = $item->price;
				$collectData['lines'][] = $itemDataCC;
			}
			$payment['No'] = "WED".$orderid;
			$payment['ExtDocumentNo'] = $orderid;
			$payment['Source'] = "Click & Delivery";

			return Array([
				"collectData" => $collectData,
				"payment" => $payment
			 ]);
		}else{
			$collectData['HeaderNo'] = $orderid;
			$collectData['DocumentType'] = "order";
			$collectData['LocationCode'] = $order->warehouse->name;
			$collectData['ResponsibilityCenter'] =  $resposibilityCenter;
			$collectData['PostingDate'] = date('Y-m-d');
			$collectData['SelltoCustomerNo'] = $user->ms_number;
			$collectData['Status'] = "Open";
			$collectData['YourReference'] = "Click & Collect";
			$collectData['postingno'] = "CC-".$orderid;
			$collectData['posnotes'] = null;
			$collectData['ExtDocumentNo'] = $orderid;
			$collectData['PaymentTerms'] = "PREPAID";
			$collectData['Source'] = "Click & Collect";
			$dateToFormat = strtotime($order->pick_date);
			$dateToFormat = date('Y-m-d',$dateToFormat);

			$collectionTime = date("H:i:s", strtotime($order->pick_time));
			$collectData['CollectionTime'] = $collectionTime;
			$collectData['CollectionDate'] = $dateToFormat;
			$collectData['PaymentTerms'] = "PREPAID";
			
			foreach($webItems as $item){
				$itemDataCC['DocumentType'] = "Order";
				$itemDataCC['Type'] = "Item";
				$itemDataCC['PostingDate'] = date('Y-m-d');
				$itemDataCC['No'] = $item->product->ms_id;
				$itemDataCC['Quantity'] = $item->quantity;
				$itemDataCC['UnitofMeasureCode'] = $item->type;
				$itemDataCC['LocationCode'] = $order->warehouse->name;
				$itemDataCC['UnitPrice'] = $item->price;
				$collectData['cclines'][] = $itemDataCC;
			}
			$payment['No'] = $orderid;
			$payment['ExtDocumentNo'] = $orderid;
			$payment['Source'] = "Click & Collect";
			return ["collectData" => $collectData, "payment" => $payment];
			// return Array([
			// 	"collectData" => $collectData,
			// 	"payment" => $payment
			// 	]);
		}
	}
	public static function PosMakeDynamicsJobData($order,$user){
		//$items = Cart::where('user_id',$order->customer_id)->where('order_id',$order->id)->get();
		$items = Product_Sale::where('sale_id',$order->id)->get();

        $webItems = $items;

		$payment['TransactionDate'] = date('Y-m-d');
		$payment['DocumentType'] ="Invoice";
		$payment['CustomerNo'] = $user->ms_number;
		$payment['CustomerName'] = $user->name;
		$payment['PaymentAgainst'] = "";
		$payment['Amount'] = $order->total_price + $order->total_tax;
		$payment['Cash'] = 0;
		$payment['Card'] = $order->total_price + $order->total_tax;
		$payment['Cheque'] = 0;
		$payment['BankTransfer'] = 0;
		$payment['Others'] = 0;
		$payment['CreditMemo'] = 0;
		$payment['Total'] = $order->total_price + $order->total_tax;
		switch ($user->getwarehouse->name) {//change warehouse to getwarehoue on 25-nov-2023
			case 'BFD':
				// $salespersonCode = "BFD MANGR";
				$resposibilityCenter = "BRADFORD";
				// $customerPriceGroup = "BFD CC";
				break;
			case 'BDC':
				// $salespersonCode = "BDC MANGR";
				$resposibilityCenter = "JACKSON ST";
				// $customerPriceGroup = "BELLA PIZZ";
				break;
			case 'BOL':
				// $salespersonCode = "BOL MANGR";
				$resposibilityCenter = "BOLTON";
				// $customerPriceGroup = "BOL CC";
				break;
			case 'DIS':
				// $salespersonCode = "DIST MANGR";
				$resposibilityCenter = "JACKSON ST";
				// $customerPriceGroup = "DISTRIBUT";
				break;
			case 'LDS':
				// $salespersonCode = "LDS MANGR";
				$resposibilityCenter = "LEEDS";
				// $customerPriceGroup = "LDS CC";
				break;
			case 'SHE':
				// $salespersonCode = "SHEFF MANG";
				$resposibilityCenter = "JACKSON ST";
				// $customerPriceGroup = "SHEFFIELD";
				break;
			case 'BIR':
				// $salespersonCode = "BIR MAN";
				// $resposibilityCenter = "BIRMINGHAM";
				$resposibilityCenter = "BIRG";
				// $customerPriceGroup = "BARNIS";
				break;
			default:
				// $salespersonCode = "LEEDS MANG";
				$resposibilityCenter = "LEEDS";
				// $customerPriceGroup = "LDS CC";
				break;
		}
		$current_time = \Carbon\Carbon::now()->timestamp;
        $orderid= $order->id.'-'.$current_time;
		if($order->pick_time == null){ // Delivery will hit for pos
			$collectData['HeaderNo'] = "WED".$orderid;
			$collectData['DocumentType'] = "Order";
			$collectData['LocationCode'] = $user->getwarehouse->name;
			$collectData['PostingDate'] =  date('Y-m-d');
			$collectData['SelltoCustomerNo'] = $user->ms_number;
			$collectData['Status'] = "Open";
			$collectData['YourReference'] = "POS";
			$collectData['postingno'] = "WED".$orderid;
			$collectData['posnotes'] = "";
			$collectData['ExternalDocumentNo'] = "WED".$orderid;
			$collectData['PaymentTermsCode'] = "PREPAID";
			$collectData['Source'] = "Click & Delivery";
			 \Log::info('collection check in helper', [$collectData]);
			foreach($webItems as $item){
				$itemDataCC['DocumentType'] = "Order";
				$itemDataCC['Type'] = "Item";
				//$itemDataCC['PostingDate'] = date('Y-m-d'); //
				$itemDataCC['No'] = $item->product->ms_id;
				$itemDataCC['Quantity'] = $item->qty;
				//$itemDataCC['UnitofMeasureCode'] = "SINGLE";//item->type;//
				$itemDataCC['UnitofMeasureCode'] = $item->type;
				//$itemDataCC['LocationCode'] = $user->getwarehouse->name;//
				$itemDataCC['UnitPrice'] = $item->net_unit_price;
				$collectData['lines'][] = $itemDataCC;
			}
			 \Log::info('webitems check in helper', [$webItems]);
			$payment['No'] = "WED".$orderid;
			$payment['ExtDocumentNo'] = $orderid;
			$payment['Source'] = "Click & Delivery";

			return Array([
				"collectData" => $collectData,
				"payment" => $payment
			 ]);
		}
	}
	public static function popularCategories(){
		$cats = DB::select("Select categories.name,categories.id from categories
		INNER JOIN products ON products.category_id = categories.id
		INNER JOIN (select product_id, sum(amount) 
			   from carts 
			   group by product_id 
			   order by sum(amount) desc 
			   limit 6) popular ON popular.product_id = products.id
			   GROUP BY categories.id;");

		return $cats;
	}

	public static function defaultCategories(){
		$cats = Category::orderBy('id','Desc')->limit(5)->get();
		return $cats;
	}


}
