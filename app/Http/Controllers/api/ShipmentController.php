<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShipmentResource;
use App\Http\Resources\UserResource;
use App\Notifications\ShipmentNoty;
use App\Pincode;
use App\Product;
use App\Shipment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ShipmentController extends Controller
{
    /**
     * Get you orders
     * The orders will have a pagination of 100
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('api')->user();
        // return $user;
        // $shipment = Shipment::setEagerLoads([])->where('id', 1)->paginate(2);
        // if ($user->hasRole('Client')) {
        //     $shipment = Shipment::setEagerLoads([])->where('client_id', Auth::id())->orderBy('id', 'desc')->paginate();
        // } else {
        $shipment = Shipment::setEagerLoads([])->where('client_id', $user->id)->orderBy('id', 'desc')->paginate(100);
        // }
        return ShipmentResource::collection($shipment);
    }

    public function show($id)
    {
        return ShipmentResource::collection(Shipment::setEagerLoads([])->where('id', $id)->get());
    }

    /**
     * Create a new order.
     *Send a json file with the following details
     *
     *

{
    "data": {
        "bar_code": "SP0000001",
        "quantity": 1,
        "client_address": "123 main street",
        "client_city": "Nairobi",
        "product_name": "SLICER",
        "client_name": "John Doe",
        "client_phone": "+257000...",
        "cod_amount": "1900.00",
        "products": [
            {
                "product_name": "Test Product",
                "price": 400,
                "total": 400,
                "quantity": 1
            },
            {
                "product_name": "Test Product",
                "price": 1500,
                "total": 1500,
                "quantity": 1
            }
        ]
    }
}
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->data['bar_code'];
        // return $request->all();
        $data = $request->data;
        $user = auth('api')->user();
        // $api_user = new ApiUser();
        // $user_data = $api_user->login($request);
        $user_data = auth('api')->user();
        $user_id = $user_data->id;
        // $user_id = !empty($user_data['id']) ? $user_data['id'] : '';
        // $products = collect($request->form['products'])->transform(function ($product) use ($user_id) {
        //     $product['total'] = $product['quantity'] * $product['price'];
        //     $product['user_id'] = $user_id;
        //     return new Product($product);
        // });

        // if ($products->isEmpty()) {
        //     return response()->json([
        //         'product_empty' => ['One or more products is required'],
        //     ], 422);
        // }
        $shipment = new Shipment;
        // if ($request->selectCl == []) {
        //     $shipment->client_id = null;
        // } else {
        //     $shipment->client_id = $request->selectCl['id'];
        // }
        // if ($request->selectD == []) {
        //     $shipment->driver = '';
        // } else {
        //     $shipment->driver = $request->selectD['id'];
        // }

        // if ($request->selectB == []) {
        //     $shipment->branch_id = $user_data->branch_id;
        // } else {
        //     $shipment->branch_id = $request->selectB['id'];
        // }

        // $shipment->sub_total = $products->sum('total');
        $shipment->client_name = (array_key_exists('client_name', $data)) ? $data['client_name'] : null;
        $shipment->client_phone = (array_key_exists('client_phone', $data)) ? $data['client_phone'] : null;
        $shipment->client_email = (array_key_exists('client_email', $data)) ? $data['product_name'] : null;
        $shipment->client_address = (array_key_exists('client_address', $data)) ? $data['client_address'] : null;
        $shipment->client_city = (array_key_exists('client_city', $data)) ? $data['client_city'] : null;
        $shipment->airway_bill_no = (array_key_exists('airway_bill_no', $data)) ? $data['bar_code'] : null;
        $shipment->country_id = (array_key_exists('country_id', $data)) ? $data['country_id'] : null;
        $shipment->booking_date = (array_key_exists('booking_date', $data)) ? $data['booking_date'] : null;
        $shipment->derivery_date = (array_key_exists('derivery_date', $data)) ? $data['derivery_date'] : null;
        $shipment->derivery_time = (array_key_exists('derivery_time', $data)) ? $data['derivery_time'] : null;
        $shipment->bar_code = (array_key_exists('bar_code', $data)) ? $data['bar_code'] : null;
        $shipment->to_city = (array_key_exists('to_city', $data)) ? $data['to_city'] : null;
        $shipment->cod_amount = (array_key_exists('cod_amount', $data)) ? $data['cod_amount'] : null;
        $shipment->from_city = (array_key_exists('from_city', $data)) ? $data['from_city'] : null;
        $shipment->amount_ordered = (array_key_exists('amount_ordered', $data)) ? $data['quantity'] : null;
        $shipment->user_id = (array_key_exists('user_id', $data)) ? $user_id : null;

        $shipment->sender_name = $user->name;
        $shipment->sender_email = $user->email;
        $shipment->sender_phone = $user->phone;
        $shipment->sender_address = $user->address;
        $shipment->sender_city = $user->city;
        $shipment->user_id = $user->id;
        $shipment->client_id = $user->id;

        $product_name = '';
        foreach ($data['products'] as  $product_) {
            $product_name = $product_name . ',' .  $product_['product_name'];
        }
        // dd($product_name);


        // return $user_id;
        $shipment->shipment_id = random_int(1000000, 9999999);
        // dd($shipment);
        $shipment->save();

        if (!empty($data['products'])) {
            // dd('test');
            $products = collect($data['products'])->transform(function ($product) {
                $product['total'] = $product['quantity'] * $product['price'];
                $product['user_id'] = Auth::id();
                return new Product($product);
            });

            $shipment->sub_total = $products->sum('total');
            // return $products;
        }
        // dd('dwd');

        if (!empty($data['products'])) {
            $shipment->products()->saveMany($products);
        }
        $users = $this->getAdmin();
        // $users = User::all();
        // if ($shipment->save()) {
        //     $shipment->products()->saveMany($products);
        // }
        $type = 'shipment';
        Notification::send($users, new ShipmentNoty($shipment, $type));
        // return ShipmentResource::collection($shipment);

        return response()->json(['success' => $shipment, 'status' => '200'], '200');
        // die();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // if ($products->isEmpty()) {
        //     return response()->json([
        //         'product_empty' => ['One or more products is required'],
        //     ], 422);
        // }
        $shipment = Shipment::setEagerLoads([])->where($id)->get();

        // $shipment->sub_total = $products->sum('total');
        $shipment->client_name = $request->form['client_name'];
        $shipment->client_phone = $request->form['client_phone'];
        $shipment->client_email = $request->form['client_email'];
        $shipment->client_address = $request->form['client_address'];
        $shipment->client_city = $request->form['client_city'];
        // $shipment->assign_staff = $request->form['assign_staff'];
        $shipment->airway_bill_no = $request->form['bar_code'];
        $shipment->shipment_type = $request->form['shipment_type'];
        $shipment->payment = $request->form['payment'];
        // $shipment->total_freight = $request->form['total_freight'];
        // $shipment->total = $request->form['total'];
        $shipment->insuarance_status = $request->form['insuarance_status'];
        $shipment->status = $request->form['status'];
        $shipment->booking_date = $request->form['booking_date'];
        $shipment->derivery_date = $request->form['derivery_date'];
        $shipment->derivery_time = $request->form['derivery_time'];
        $shipment->bar_code = $request->form['bar_code'];
        $shipment->to_city = $request->form['to_city'];
        $shipment->cod_amount = $request->form['cod_amount'];
        // $shipment->receiver_name = $request->form['receiver_name'];
        $shipment->from_city = $request->form['from_city'];

        // if ($request->model) {
        // $shipment->sender_name = $request->form['sender_name'];
        // $shipment->sender_email = $request->form['sender_email'];
        // $shipment->sender_phone = $request->form['sender_phone'];
        // $shipment->sender_address = $request->form['sender_address'];
        // $shipment->sender_city = $request->form['sender_city'];
        // } else {
        $shipment->sender_name = $request->form['sender_name'];
        $shipment->sender_email = $request->form['sender_email'];
        $shipment->sender_phone = $request->form['sender_phone'];
        $shipment->sender_address = $request->form['sender_address'];
        $shipment->sender_city = $request->form['sender_city'];
        // }

        // return $request->form['customer_id'];
        $shipment->user_id = Auth::id();
        $shipment->shipment_id = random_int(1000000, 9999999);
        // $shipment->branch_id = Auth::user()->branch_id;
        $shipment->save();
        $users = $this->getAdmin();
        // if ($shipment->save()) {
        //     $shipment->products()->saveMany($products);
        // }
        // Notification::send($users, new ShipmentNoty($shipment));
        // $users->notify(new ShipmentNoty($shipment));
        return ShipmentResource::collection($shipment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipment $shipment)
    {
        // Shipment::find($shipment->id)->delete();
    }

    public function getAdmin()
    {
        $usersRolem = User::with('roles')->get();
        $userArr = [];
        foreach ($usersRolem as $user) {
            // var_dump($user->roles); die;
            foreach ($user->roles as $role) {
                if ($role->name == 'Admin') {
                    $userArr[] = $role->id;
                }
            }
        }
        $users = $userArr;
        return $admin = User::whereIn('id', $userArr)->get();
        // return UserResource::collection($admin);
    }

    public function delete(Request $request)
    {
        // $api_user = new ApiUser();
        // $user_data = $api_user->login($request);
        $user_data = auth('api')->user();

        if (empty($user_data) || isset($user_data['error'])) {
            return response()->json(['error' => 'Unauthorised User', 'status' => '401'], 401);
        }

        if (empty($user_data['id']) || empty($request->get('awb_no'))) {
            return response()->json(['error' => 'Required Parameter Missing', 'status' => '400'], 400);
        }

        $data = Shipment::where(['user_id' => $user_data['id'], 'airway_bill_no' => $request->get('awb_no')])->select()->get()->toArray();
        if (empty($data)) {
            return response()->json(['error' => 'Awb Number Does not exsist', 'status' => '200'], 200);
        }

        Shipment::where(['user_id' => $user_data['id'], 'airway_bill_no' => $request->get('awb_no')])->delete();

        return response()->json(['success' => 'Tracking number sucessfully deleted', 'status' => '200'], 200);
    }

    public function track(Request $request)
    {
        $user_data = auth('api')->user();

        if (empty($user_data) || isset($user_data['error'])) {
            return response()->json(['error' => 'Unauthorised User', 'status' => '401'], 401);
        }

        if (empty($user_data['id']) || empty($request->get('awb_no'))) {
            return response()->json(['error' => 'Required Parameter Missing', 'status' => '400'], 400);
        }

        $data = Shipment::where(['user_id' => $user_data['id'], 'airway_bill_no' => $request->get('awb_no')])->select()->get()->first();
        if (empty($data)) {
            return response()->json(['error' => 'Awb Number Does not exsist', 'status' => '200'], 200);
        }

        $status = !empty($data['status']) ? $data['status'] : 'No Status Found';
        return response()->json(['success' => $status, 'status' => '200'], 200);
    }

    public function pincode(Request $request)
    {
        // return $request->all();
        $user_data = auth('api')->user();

        if (empty($user_data) || isset($user_data['error'])) {
            return response()->json(['error' => 'Unauthorised User', 'status' => '401'], 401);
        }

        if (empty($request->get('pincode'))) {
            return response()->json(['error' => 'Required Parameter Missing', 'status' => '400'], 400);
        }

        $pincode = Pincode::where(['pincode' => $request->get('pincode')])->select('cod', 'prepaid')->get()->first();

        if (empty($pincode)) {
            return response()->json(['error' => 'Pincode is not Available', 'status' => '200'], 200);
        }

        $pincode_data = array();
        $pincode_data['cod'] = !empty($pincode['cod']) ? $pincode['cod'] : 0;
        $pincode_data['prepaid'] = !empty($pincode['prepaid']) ? $pincode['prepaid'] : 0;

        return response()->json(['success' => $pincode_data, 'status' => '200'], 200);
    }

    public function createPickup(Request $request)
    {

        $user_data = auth('api')->user();

        $response = array();
        if (empty($user_data) || isset($user_data['error'])) {
            return response()->json(['error' => 'Unauthorised User', 'status' => '401'], 401);
        }

        if (empty($request->get('request'))) {
            return response()->json(['error' => 'Required Parameter Missing', 'status' => '400'], 400);
        }
        foreach ($request->get('request') as $key => $value) {

            $response[$key]['status'] = 0;

            if (empty($value['awb_no']) || empty($value['pickup_at'])) {
                continue;
            }

            $response[$key]['awb_no'] = $value['awb_no'];

            $data = Shipment::where(['user_id' => $user_data['id'], 'airway_bill_no' => $value['awb_no']])->select()->get()->first();

            if (empty($data)) {
                continue;
            } elseif (!empty($data['pickup_id'])) {
                $response[$key]['pickup_id'] = $data['pickup_id'];
                continue;
            }

            $pickup_time = strtotime($value['pickup_at']);

            $pickup_id = Shipment::max('pickup_id');
            $pickup_id = !empty($pickup_id) ? $pickup_id + 1 : 1;

            Shipment::where(['user_id' => $user_data['id'], 'airway_bill_no' => $value['awb_no']])->update(['pickup_id' => $pickup_id, 'pickup_at' => $pickup_time]);

            $response[$key]['pickup_id'] = $pickup_id;
            $response[$key]['status'] = 1;
        }

        return response()->json(['success' => json_encode($response), 'status' => '200'], 200);
    }

    public function deletePickup(Request $request)
    {
        return $request->all();
        return $request['awb_no'];
        $user_data = auth('api')->user();

        $response = array();
        if (empty($user_data) || isset($user_data['error'])) {
            return response()->json(['error' => 'Unauthorised User', 'status' => '401'], 401);
        }

        if (empty($request->get('awb_no'))) {
            return response()->json(['error' => 'Required Parameter Missing', 'status' => '400'], 400);
        }

        $data = Shipment::where(['user_id' => $user_data['id'], 'airway_bill_no' => $request->get('awb_no')])->select()->get()->first();
        if (empty($data)) {
            return response()->json(['error' => 'Awb Number Does not exsist', 'status' => '200'], 200);
        }

        Shipment::where(['user_id' => $user_data['id'], 'airway_bill_no' => $request->get('awb_no')])->update(['pickup_id' => '', 'pickup_at' => '']);

        return response()->json(['success' => 'Sucessfully Deleted', 'status' => '200'], 200);
    }


    /**
     * Search through you orders
     * Search by order_no, client phone number or client name
     * The orders will have a pagination of 100
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search($order_no)
    {
        // return $request->all();
        $user = auth('api')->user();
        $search = $order_no;
        $shipment = Shipment::setEagerLoads([])
            ->where('client_id', $user->id)
            ->where('bar_code', 'LIKE', "%{$search}%")
            ->orwhere('client_phone', 'LIKE', "%{$search}%")
            ->orwhere('client_email', 'LIKE', "%{$search}%")
            ->orwhere('client_name', 'LIKE', "%{$search}%")
            ->paginate(1);
        return ShipmentResource::collection($shipment);
    }
}
