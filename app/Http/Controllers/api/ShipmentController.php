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
use Notification;

class ShipmentController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();
        if ($user->hasRole('Client')) {
            $shipment = Shipment::where('client_id', Auth::id())->orderBy('id', 'desc')->paginate();
        } else {
            $shipment = Shipment::where('country_id', $user->country_id)->orderBy('id', 'desc')->paginate();
        }
        return ShipmentResource::collection($shipment);
    }

    public function show($id)
    {
        return ShipmentResource::collection(Shipment::where('id', $id)->get());
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
        if ($request->selectCl == []) {
            $shipment->client_id = null;
        } else {
            $shipment->client_id = $request->selectCl['id'];
        }
        if ($request->selectD == []) {
            $shipment->driver = '';
        } else {
            $shipment->driver = $request->selectD['id'];
        }

        if ($request->selectB == []) {
            $shipment->branch_id = $user_data->branch_id;
        } else {
            $shipment->branch_id = $request->selectB['id'];
        }

        // $shipment->sub_total = $products->sum('total');
        $shipment->client_name = $request->client_name;
        $shipment->client_phone = $request->client_phone;
        $shipment->client_email = $request->client_email;
        $shipment->client_address = $request->client_address;
        $shipment->client_city = $request->client_city;
        $shipment->airway_bill_no = $request->bar_code;
        $shipment->country_id = $request->country_id;
        $shipment->booking_date = $request->booking_date;
        $shipment->derivery_date = $request->derivery_date;
        $shipment->derivery_time = $request->derivery_time;
        $shipment->bar_code = $request->bar_code;
        $shipment->to_city = $request->to_city;
        $shipment->cod_amount = $request->cod_amount;
        $shipment->from_city = $request->from_city;
        $shipment->user_id = $user_id;

        if ($request->model) {
            $shipment->client_id = $request->model;
            $sender = User::find($request->model);
            $shipment->sender_name = $sender->name;
            $shipment->sender_email = 'info@speedballcourier.com';
            $shipment->sender_phone = '+254743332743';
            $shipment->sender_address = '636400100';
            $shipment->sender_city = $sender->city;
        } else {
            $shipment->sender_name = 'Speedball Courier';
            $shipment->sender_email = 'info@speedballcourier.com';
            $shipment->sender_phone = '+254743332743';
            $shipment->sender_address = '636400100';
            $shipment->sender_city = 'Nairobi';
        }

        // return $user_id;
        $shipment->shipment_id = random_int(1000000, 9999999);
        $shipment->save();
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
        $shipment = Shipment::where($id)->get();
        if ($request->selectCl == []) {
            // $shipment->client_id = null;
            // dd('nn');
        } else {
            $shipment->client_id = $request->selectCl['id'];
            // dd( $request->selectCl['id']);
        }
        if ($request->selectD == []) {
            // $shipment->driver = '';
            // dd('renn');
        } else {
            $shipment->driver = $request->selectD['id'];
            // dd( $request->selectD['id']);
        }

        if ($request->selectB == []) {
            // $shipment->branch_id = Auth::user()->branch_id;
            // dd(Auth::user()->branch_id);
        } else {
            $shipment->branch_id = $request->selectB['id'];
            // dd( $request->selectB['id']);
        }

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
        Shipment::find($shipment->id)->delete();
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

    public function glSearch(Request $request)
    {
        // return $request->all();
        $search = $request->search;
        return Shipment::where('bar_code', 'LIKE', "%{$search}%")
            ->orwhere('client_phone', 'LIKE', "%{$search}%")
            ->orwhere('client_email', 'LIKE', "%{$search}%")
            ->orwhere('client_name', 'LIKE', "%{$search}%")->take(500)->get();
    }

}
