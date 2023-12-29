<?php

namespace App\Services;

use App\Branch;
use App\Customer;
use Illuminate\Support\Facades\Http;
use App\Product;
use App\Sale;
use App\Warehouse;

class MSDynamic
{
	protected $company = "";
	protected $environment = "";

	public function __construct()
    {
        $this->company = config("msdynamic.company_id");
        $this->environment = config("msdynamic.environment");
    }


	public function order($sale_data, $user){

		$payload = getAccessToken();

		$warehouse = Warehouse::find($user->warehouse);

		try {

			$order =  Http::withToken($payload['access_token']??"")->post("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/api/v2.0/companies($this->company)/salesOrders",
        	[
			    'orderDate' => date('Y-m-d'),
			    'customerNumber' => $user->ms_number,
			]
			)->body();

			$order = json_decode($order);
			\Log::info(json_encode($order));
			if(isset($order->id)){
				$data = [];
				if($sale_data){
					foreach($sale_data as $sale){
						$product = Product::select("id", "ms_item_id", "ms_id")->where("id",$sale['product_id'])->first();
						$data = [
						    'itemId' => $product->ms_item_id,
						    'lineType' => 'Item',
						    'lineObjectNumber'=>$product->ms_id,
						    'description'=>'',
						    'unitOfMeasureId'=>'0f0f3b65-2a67-ed11-8c34-000d3a0d28a2',
						    "unitOfMeasureCode"=> "SINGLE",
						    'quantity'=>$sale['qty'],
						    'unitPrice'=>$sale['net_unit_price'],
						    'discountAmount'=>0,
						    'discountPercent'=>0,
						    'taxCode'=>'STANDARD',
						    'invoiceQuantity'=>1,
						    //'itemVariantId'=>'',
						];
						if($warehouse){
							if($warehouse->ms_id){
								$data['locationId'] = $warehouse->ms_id;
							}
						}
						\Log::info(json_encode($data));
						$orderItem =  Http::withToken($payload['access_token']??"")->post("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/api/v2.0/companies($this->company)/salesOrders($order->id)/salesOrderLines",
			        	$data
						)->body();

						$orderItem = json_decode($orderItem);
						\Log::info(json_encode($orderItem));
					}
				}

			}

		} catch(\Exception $e){
			\Log::info($e->getMessage());
		}

	}

	public function location($data, $model){

		$payload = getAccessToken();

		try {

			$location =  Http::withToken($payload['access_token']??"")->post("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/api/v2.0/companies($this->company)/locations",$data
			)->body();

			$location = json_decode($location);

			if(isset($location->id)){

				$model->ms_id = $location->id;
				$model->save();

			}

		} catch(\Exception $e){
			\Log::info($e->getMessage());
		}
	}

	public function customer($data, $model){

		$payload = getAccessToken();

		try {

			$customer =  Http::withToken($payload['access_token']??"")->post("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/api/v2.0/companies($this->company)/customers",$data
			)->body();

			$customer = json_decode($customer);
			if(isset($customer->id)){

				$model->ms_id = $customer->id;
				$model->ms_number = $customer->number;
				$model->save();

			}

		} catch(\Exception $e){
			\Log::info($e->getMessage());
		}
	}


	public function createCustomer($data,$customer_id,$branch_id){

		$payload = getAccessToken();

		try {

			// $customer =  Http::withToken($payload['access_token']??"")->post("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/api/v2.0/companies($this->company)/customers",$data
			// )->body();
			$customer =  Http::withToken($payload['access_token']??"")->post("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/ODataV4/Company('$this->company')/WS_Customer",$data
			)->body();

			$customer = json_decode($customer);

			\Log::info('this is new 2 image: ', [$customer->No]);
			\Log::info('this is new 2 image: ', [$customer]);

			\Log::info('this is new 2 image: ', [$customer_id]);
			\Log::info('this is new 2 image: ', [$branch_id]);

			if(isset($customer->No)){
				// $customerUpdate = Customer::where('id', $customer_id)->update(['ms_id'=> ($customer->id)?$customer->id:'No_ID' , 'ms_number' =>  ($customer->No)?$customer->No:'No_Number' ]);
				// $update = Branch::where('id', $branch_id)->update(['ms_id'=>  ($customer->id)?$customer->id:'No_ID' , 'ms_number' =>  ($customer->No)?$customer->No:'No_Number' ]);
				// $dynamic['number'] = $customer->No;
				// $dynamic['customer_id'] = $customer->id;
				// \Log::info(json_encode($dynamic));
				return $customer->No;
			}

		} catch(\Exception $e){
			\Log::info($e->getMessage());
		}
	}

	public function createClickAndCollectOrder($sale_data,$order_id){
		$payload = getAccessToken();

		// $warehouse = Warehouse::find($user->warehouse);

		try {

			// $order =  Http::withToken($payload['access_token']??"")->post("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/api/Robosol/orders/v1.0/companies($this->company)/ccheaders",
        	// $sale_data
			// )->body();

			$order =  Http::withToken($payload['access_token']??"")->post("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/api/Robosol/orders/v1.0/companies($this->company)/ccheaders",
        	$sale_data
			)->body();
			\Log::info('This is return from Dynamic Click & Collect API: ', [$order]);
			$order = json_decode($order);
			\Log::info('This is return from Dynamic Click & Collect API json: ', [$order]);
			\Log::info('This Click & Collect API ID: ', [$order->id]);
			if($order->id){
				return $order->id;
			}


		} catch(\Exception $e){
			\Log::info($e);
		}
	}

	public function getLocationWiseStock(){
		$payload = getAccessToken();

		try {
			//TESTING
			// $stocks =  Http::withToken($payload['access_token']??"")->get("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/ODataV4/Company('ICS%20UK%20LIMITED%20COPY%2005122022')/LocationWiseInventory",
			// )->body();

			//LIVE
			$stocks =  Http::withToken($payload['access_token']??"")
                ->get("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/ODataV4/Company('$this->company')/LocationWiseInventory")->body();

			$stocks = json_decode($stocks);
			return $stocks;
			// \Log::info(json_encode($stocks));


		} catch(\Exception $e){
			\Log::info($e->getMessage());
		}
	}

	public function orderDelivery($sale_data,$order_id){
		$payload = getAccessToken();

		// $warehouse = Warehouse::find($user->warehouse);

		try {

			//TESTING
			// $order =  Http::withToken($payload['access_token']??"")->post("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/api/Robosol/orders/v1.0/companies($this->company)/headers?\$expand=lines",
        	// $sale_data
			// )->body();

			//LIVE
			$order =  Http::withToken($payload['access_token']??"")->post("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/api/Robosol/orders/v1.0/companies($this->company)/headers",
        	$sale_data
			)->body();

			$order = json_decode($order);
			\Log::info(json_encode($order));
			if($order){
				Sale::where('id',$order_id)->update(['ms_order_no' => $order->id]);
			}


		} catch(\Exception $e){
			\Log::info($e->getMessage());
		}
	}

	public function payment($payment){
		$payload = getAccessToken();

		// $warehouse = Warehouse::find($user->warehouse);

		try {

			$pay =  Http::withToken($payload['access_token']??"")->post("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/api/Robosol/orders/v1.0/companies($this->company)/cashcentralpayments",
        	$payment
			)->body();

			$pay = json_decode($pay);
			\Log::info(json_encode($pay));


		} catch(\Exception $e){
			\Log::info($e->getMessage());
		}
	}
}
