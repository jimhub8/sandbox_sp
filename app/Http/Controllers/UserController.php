<?php

namespace App\Http\Controllers;

use App\Notifications\SignupActivate;
use App\Shipment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Branch;
use App\Client as AppClient;
use App\Country;
use App\models\Rider;
use App\PasswordSecurity;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\models\Apimft;

class UserController extends Controller
{
    public function token_f()
    {
        // return session()->get('token.access_token');
        $token = Apimft::where('user_id', Auth::id())->first();
        if ($token) {
            return $token->access_token;
        } else {
            abort(401);
        }
    }
    public function getUsers(Request $request)
    {
        // return User::find(1)->country;
        // return $request->all();
        // return User::with(['roles'])->get();
        $users = User::with('branch', 'country_')->orderBy('name')->get();
        $users->transform(function ($user) {
            // dd($user->country);
            // dd($user);
            // $branch_name = Branch::find($user->branch_id);
            // dd($user);
            // $country_name = Country::find($user->country_id);
            // $user->branch = ($user->branch) ? $user->branch->branch_name : null;
            $user->country = ($user->country_) ? $user->country_->country_name : '';
            $user->country_name = ($user->country) ? $user->country : 'null';
            $user->country_name = ($user->country) ? $user->country : 'null';
            $user->status = 'active';
            return $user;
        });
        // return $users;
        return response()->json($users);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $this->generateRandomString();
        // return $request->all();
        $this->Validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'countryList' => 'required',
            'role_id' => 'required',
        ]);
        // return $request->all();
        $user = new User;
        $password = $this->generateRandomString();
        $password_hash = Hash::make($password);
        $user->password = $password_hash;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->branch_id = $request->branch_id;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->country_id = $request->countryList;
        $user->activation_token = str_random(60);
        $user->save();
        $create_user = $user;
        $user->assignRole($request->role_id);
        $user->givePermissionTo($request->selected);
        $user->password_hash = $password_hash;
        $user = $user->makeVisible('password')->toArray();
        if ($request->role_id == 'Client') {
            $this->client_api($user);
        } elseif ($request->role_id == 'Rider') {
            return $user->makeHidden('password_hash')->toArray();
        } else {
            $create_user->notify(new SignupActivate($create_user, $password));
            $this->user_api($user);
        }
        $passwordSecurity = PasswordSecurity::create([
            'user_id' => $user['id'],
            'password_expiry_days' => 1,
            'password_updated_at' => Carbon::now(),
        ]);
        return;
        // $user->splice('password_hash');
        // return $user->makeHidden('password_hash')->toArray();
    }
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // return $request->all();
        // return $request->selected;
        $this->Validate($request, [
            'form.name' => 'required',
            'form.email' => 'required|email',
            'form.phone' => 'required|numeric',
        ]);
        $old_email = $user->email;
        $user = User::find($request->form['id']);
        // $user = $user->makeVisible('password')->toArray();
        $user->name = $request->form['name'];
        $user->email = $request->form['email'];
        $user->phone = $request->form['phone'];
        $user->branch_id = $request->form['branch_id'];
        $user->address = $request->form['address'];
        $user->city = $request->form['city'];
        // $user->country = $request->form['country_name'];
        $user->country_id = $request->form['country_id'];
        $user->save();
        foreach ($request->form['roles'] as $role) {
            $role_name = $role['name'];
        }
        $user->syncRoles($role_name);
        $user->old_email = $old_email;
        if ($request->role_id == 'Client') {
            $this->clientupdate_api($user);
        } else {
            $this->userupdate_api($user);
        }
        return $user->makeHidden('password')->toArray();
    }

    public function AuthUserUp(Request $request)
    {
        $user = User::find(Auth::id());
        $old_email = $user->email;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->branch_id = $request->branch_id;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->save();
        $user->old_email = $old_email;
        $this->userupdate_api($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::find($user->id)->delete();
        $this->api_delete($user->email);
    }

    public function getLogedinUsers()
    {
        return Auth::user();
    }

    public function profile(Request $request, $id)
    {
        $upload = User::find($request->id);
        if ($request->hasFile('image')) {
            $img = $request->image;
            if (File::exists('storage/profile/' . $upload->image)) {

                // return('test');
                $image_path = 'storage/profile/' . $upload->image;

                File::delete($image_path);
            }
            $imagename = Storage::disk('public')->put('profile', $img);
            // return('noop');
            $imgArr = explode('/', $imagename);
            $image_name = $imgArr[1];
            $upload->profile = '/storage/profile/' . $image_name;
            // $upload->profile = '/healthwise/products/'.$image_name;
            $upload->save();
            return $upload;
        }
    }

    public function getDrivers()
    {
        return Rider::where('country_id', Auth::user()->country_id)->orderBy('name')->get();
        // $userArr = [];
        // foreach ($users as $user) {
        //     if ($user->hasRole('Rider')) {
        //         $userArr[] = $user;
        //     }
        // }
        // return $userArr;
    }

    public function getCustomer()
    {
        return $users = AppClient::all();
        // $userArr = [];
        // foreach ($users as $user) {
        //     if ($user->hasRole('Client')) {
        //         $userArr[] = $user;
        //     }
        // }
        // return $userArr;
    }

    public function getSorted(Request $request)
    {
        // return $request->all();
        $roles = User::all();
        $users_id = [];
        $users = User::all();
        $userArr = [];
        foreach ($users as $user) {
            if ($user->hasRole($request->name)) {
                $userArr[] = $user;
            }
        }
        return $userArr;
    }

    public function getUserPro(Request $request, $id)
    {
        return Shipment::where('client_id', $id)->paginate(10);
    }

    public function getUserPerm(Request $request, $id)
    {
        $user = User::find($id);
        $permissions = $user->getAllPermissions();
        $can = [];
        foreach ($permissions as $perm) {
            $can[] = $perm->name;
        }
        return $can;
    }

    public function password(Request $request)
    {
        $this->Validate($request, [
            'password' => 'required|string|min:6',
        ]);
        $user = User::find(Auth::id());
        $password_hash = Hash::make($request->password);
        // dd($password_hash);
        $user->password_hash = $password_hash;
        $this->reset_password($user);
        $user = User::find(Auth::id());
        $user->password = $password_hash;
        $user->save();
        // return $user->makeHidden('password')->toArray();
    }

    public function UserShip($id)
    {
        return Shipment::where('client_id', $id)->orWhere('driver', $id)->paginate(10);
    }
    public function logoutOther()
    {
        return view('auth.Logout');
    }

    public function logOtherDevices(Request $request)
    {
        Auth::logoutOtherDevices($request->password);
        return redirect('/courier');
    }

    public function permisions(Request $request, $id)
    {
        // return $request->all();
        $user = User::find($id);
        $user->syncPermissions($request->selected);
        return $user;
    }


    public function undeletedUser($id)
    {
        return User::where('id', $id)->restore();
    }

    public function deletedUsers()
    {
        $users = User::onlyTrashed()->get();
        $users->transform(function ($user, $key) {
            $branch_name = Branch::find($user->branch_id);
            $country_name = Country::find($user->country_id);
            $user->branch = $branch_name->branch_name;
            $user->country = $country_name->country_name;
            $user->status = 'active';
            return $user;
        });
        return $users;
    }

    public function user_api($user)
    {
        $token = $this->token_f();
        try {
            $client = new Client();
            $request = $client->request('POST', env('API_URL') . '/api/user', [
                'headers' => [
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'body' => json_encode([
                    'data' => $user,
                ])
            ]);
            return $response = $request->getBody()->getContents();
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());

            $message = $e->getResponse()->getBody();
            $code = $e->getResponse()->getStatusCode();
            if ($code == 401) {
                abort(401);
            }
            abort(422, $message);
            return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        }
    }

    public function client_api($user)
    {
        $token = $this->token_f();
        try {
            $client = new Client();
            $request = $client->request('POST', env('API_URL') . '/api/clients', [
                'headers' => [
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'body' => json_encode([
                    'data' => $user,
                ])
            ]);
            return $response = $request->getBody()->getContents();
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());

            $message = $e->getResponse()->getBody();
            $code = $e->getResponse()->getStatusCode();
            if ($code == 401) {
                abort(401);
            }
            abort(422, $message);
            return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        }
    }

    public function clientupdate_api($user)
    {
        $token = $this->token_f();
        try {
            $client = new Client();
            $request = $client->request('PATCH', env('API_URL') . '/api/clients', [
                'headers' => [
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'body' => json_encode([
                    'data' => $user,
                ])
            ]);
            return $response = $request->getBody()->getContents();
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());

            $message = $e->getResponse()->getBody();
            $code = $e->getResponse()->getStatusCode();
            if ($code == 401) {
                abort(401);
            }
            abort(422, $message);
            return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        }
    }

    public function userupdate_api($user)
    {
        $token = $this->token_f();
        try {
            $client = new Client();
            $request = $client->request('POST', env('API_URL') . '/api/update_user', [
                'headers' => [
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'body' => json_encode([
                    'data' => $user,
                ])
            ]);
            return $response = $request->getBody()->getContents();
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());

            $message = $e->getResponse()->getBody();
            $code = $e->getResponse()->getStatusCode();
            if ($code == 401) {
                abort(401);
            }
            abort(422, $message);
            return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        }
    }

    public function reset_password($user)
    {
        $token = $this->token_f();
        try {
            $client = new Client();
            $request = $client->request('POST', env('API_URL') . '/api/user_password', [
                'headers' => [
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'body' => json_encode([
                    'data' => $user,
                ])
            ]);
            return $response = $request->getBody()->getContents();
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());

            $message = $e->getResponse()->getBody();
            $code = $e->getResponse()->getStatusCode();
            if ($code == 401) {
                abort(401);
            }
            abort(422, $message);
            return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        }
    }


    public function api_delete($user)
    {
        $token = $this->token_f();
        try {
            $client = new Client();
            $request = $client->request("DELETE", env('API_URL') . '/api/user', [
                'headers' => [
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
                'body' => json_encode([
                    'data' => $user,
                ])
            ]);
            return $response = $request->getBody()->getContents();
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());

            $message = $e->getResponse()->getBody();
            $code = $e->getResponse()->getStatusCode();
            if ($code == 401) {
                abort(401);
            }
            abort(422, $message);
            return $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile();
        }
    }


    public function change_password(Request $request, $id)
    {
        $this->Validate($request, [
            'password' => 'required|string|min:6',
        ]);
        $user = User::find($id);
        $password_hash = Hash::make($request->password);
        $user->password  = $password_hash;
        // $this->reset_password($user);
        // $user = User::find($id);
        // $user->password = $password_hash;
        $user->save();
    }
}
