<?php

namespace App\Http\Controllers;

use App\Scopes\ShipmentScope;
use App\Shipment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilterController extends Controller
{
    public function filterShipment(Request $request)
    {
        if (Auth::guard('clients')->check()) {
            $shipment_filter = Shipment::withoutGlobalScope(ShipmentScope::class);
            if ($request->country_id) {
                    $shipment_filter = $shipment_filter->where('country_id', $request->country_id);
            }
            if ($request->status == "Returned" && ($request->start_date && $request->end_date)) {
                $date_b = [
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date
                ];
                $shipment_filter = $shipment_filter->whereBetween('return_date', $date_b);
            } else {
                if ($request->start_date && $request->end_date) {
                    $date_b = [
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date
                    ];
                    $shipment_filter = $shipment_filter->whereBetween('created_at', $date_b);
                }
            }

            if ($request->status) {
                $shipment_filter = $shipment_filter->where('status', $request->status);
            }
            if ($request->branch_id) {
                $shipment_filter = $shipment_filter->where('branch_id', $request->branch_id);
            }
            if ($request->client_id) {
                $shipment_filter = $shipment_filter->where('client_id', $request->client_id);
            }
            $shipment_filter = $shipment_filter->paginate(500);
            return $shipment_filter;
        }
        // return $request->all();
        $shipment_filter = new Shipment;
        // $start = $request->no_btw['start'] - 1;
        $shipment_filter = $shipment_filter->latest();
        if (Auth::user()->hasRole('Admin') || Auth::user()->hasPermissionTo('filter by country')) {
            if ($request->country_id) {
                $shipment_filter = $shipment_filter->withoutGlobalScope(ShipmentScope::class)->where('country_id', $request->country_id);
            }
        }
        // if ($request->selectCountry['id'] != 'all') {
        //     $shipment_filter = $shipment_filter->withoutGlobalScope(ShipmentScope::class)->where('country_id', $request->selectCountry['id']);
        // }
        if ($request->status == "Returned" && ($request->start_date && $request->end_date)) {
            $date_b = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ];
            $shipment_filter = $shipment_filter->whereBetween('return_date', $date_b);
        } else {
            if ($request->start_date && $request->end_date) {
                $date_b = [
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date
                ];
                $shipment_filter = $shipment_filter->whereBetween('created_at', $date_b);
            }
        }

        if ($request->status) {
            $shipment_filter = $shipment_filter->where('status', $request->status);
        }
        if ($request->branch_id) {
            $shipment_filter = $shipment_filter->where('branch_id', $request->branch_id);
        }
        if ($request->client_id) {
            $shipment_filter = $shipment_filter->where('client_id', $request->client_id);
        }
        $shipment_filter = $shipment_filter->paginate(500);
        return $shipment_filter;
    }

    public function filterCount(Request $request)
    {
        //  return $request->all();
        $shipment_filter = new Shipment;
        // $start = $request->no_btw['start'] - 1;
        if (Auth::user()->hasRole('Admin') || Auth::user()->hasPermissionTo('filter by country')) {
            if ($request->selectCountry['id'] != 'all') {
                $shipment_filter = $shipment_filter->withoutGlobalScope(ShipmentScope::class);
            }
        }
        if ($request->selectCountry['id'] != 'all') {
            $shipment_filter = $shipment_filter->withoutGlobalScope(ShipmentScope::class);
        }
        if ($request->form['start_date'] && $request->form['end_date']) {
            $shipment_filter = $shipment_filter->whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']]);
        }
        if ($request->selectStatus['name'] != 'All') {
            $shipment_filter = $shipment_filter->where('status', $request->selectStatus['name']);
        }
        $shipment_filter = $shipment_filter->count();
        return $shipment_filter;
    }

    public function getDeriveredS(Request $request)
    {
        if ($request->form['start_date'] == '' || $request->form['end_date'] == '') {
            if ($request->select['id'] == 'all') {
                if ($request->selectStatus['name'] == 'All') {
                    // return 'st6';
                    return Shipment::where('status', 'Delivered')->count();
                } else {
                    // return 'st5';
                    return Shipment::where('status', 'Delivered')->count();
                }
            } else {
                // return 'st4';
                return Shipment::where('status', 'Delivered')->where('branch_id', $request->select['id'])->count();
            }
        } else {
            if ($request->select['id'] == 'all') {
                if ($request->selectStatus['name'] == 'All') {
                    // return 'st1';
                    return Shipment::where('status', 'Delivered')->whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->count();
                } else {
                    // return 'st2';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->where('status', 'Delivered')->count();
                }
            } else {
                if ($request->selectStatus['name'] == 'All') {
                    // return 'st1';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->where('branch_id', $request->select['id'])->where('status', 'Delivered')->count();
                } else {
                    // return 'st2';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->where('branch_id', $request->select['id'])->where('status', 'Delivered')->count();
                }
                // return 'st3';
                // return Shipment::where('branch_id', $request->select['id'])
                //                 // ->where('status', 'Delivered')
                //                 ->whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])
                //                 ->count();
            }
        }
    }

    public function getOrdersS(Request $request)
    {
        // return $request->all();
        if ($request->form['start_date'] == '' || $request->form['end_date'] == '') {
            if ($request->select['id'] == 'all') {
                if ($request->selectStatus['name'] == 'All') {
                    // return 'st6';
                    return Shipment::count();
                } else {
                    // return 'st5';
                    return Shipment::count();
                }
            } else {
                // return 'st4';
                return Shipment::where('branch_id', $request->select['id'])->count();
            }
        } else {
            if ($request->select['id'] == 'all') {
                if ($request->selectStatus['name'] == 'All') {
                    // return 'st1';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->count();
                } else {
                    // return 'st2';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->count();
                }
            } else {
                if ($request->selectStatus['name'] == 'All') {
                    // return 'st1';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->where('branch_id', $request->select['id'])->count();
                } else {
                    // return 'st2';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->where('branch_id', $request->select['id'])->count();
                }
                // return Shipment::where('branch_id', $request->select['id'])
                //                 //
                //                 ->whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])
                //                 ->count();
            }
        }
    }

    public function getPendingS(Request $request)
    {
        if ($request->form['start_date'] == '' || $request->form['end_date'] == '') {
            if ($request->select['id'] == 'all') {
                if ($request->selectStatus['name'] == 'All') {
                    // return 'st6';
                    return Shipment::where('status', '!=', 'Delivered')->count();
                } else {
                    // return 'st5';
                    return Shipment::where('status', '!=', 'Delivered')->count();
                }
            } else {
                // return 'st4';
                return Shipment::where('status', '!=', 'Delivered')->where('branch_id', $request->select['id'])->count();
            }
        } else {
            if ($request->select['id'] == 'all') {
                if ($request->selectStatus['name'] == 'All') {
                    // return 'st1';
                    return Shipment::where('status', '!=', 'Delivered')->whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->count();
                } else {
                    // return 'st2';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->where('status', '!=', 'Delivered')->count();
                }
            } else {
                if ($request->selectStatus['name'] == 'All') {
                    // return 'st1';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->where('branch_id', $request->select['id'])->where('status', '!=', 'Delivered')->count();
                } else {
                    // return 'st2';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->where('branch_id', $request->select['id'])->where('status', '!=', 'Delivered')->count();
                }
                // return 'st3';
                // return Shipment::where('branch_id', $request->select['id'])
                //                 // ->where('status', '!=', 'Delivered')
                //                 ->whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])
                //                 ->count();
            }
        }
    }

    public function filterPayment(Request $request)
    {
        if ($request->abbr == 'All') {
            $usersAll = User::latest()->take(200)->get();
            $userArr = [];
            foreach ($usersAll as $userAll) {
                if ($userAll->hasRole('Client')) {
                    $userArr[] = $userAll;
                }
            }
            return $userArr;
        } else {
            $users = User::latest()->take(200)->where('payment_status', $request->abbr)->get();
            // return $user->hasRole('Client');
            $userArr = [];
            foreach ($users as $user) {
                if ($user->hasRole('Client')) {
                    $userArr[] = $user;
                }
            }
            return $userArr;
        }
    }

    public function getreturned(Request $request)
    {
        if ($request->form['start_date'] == '' || $request->form['end_date'] == '') {
            if ($request->select['id'] == 'all') {
                if ($request->selectStatus['name'] == 'All') {
                    // return 'st6';
                    return Shipment::where('status', 'Returned')->count();
                } else {
                    // return 'st5';
                    return Shipment::where('status', 'Returned')->count();
                }
            } else {
                // return 'st4';
                return Shipment::where('status', 'Returned')->where('branch_id', $request->select['id'])->count();
            }
        } else {
            if ($request->select['id'] == 'all') {
                if ($request->selectStatus['name'] == 'All') {
                    // return 'st1';
                    return Shipment::where('status', 'Returned')->whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->count();
                } else {
                    // return 'st2';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->where('status', 'Returned')->count();
                }
            } else {
                if ($request->selectStatus['name'] == 'All') {
                    // return 'st1';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->where('branch_id', $request->select['id'])->where('status', 'Returned')->count();
                } else {
                    // return 'st2';
                    return Shipment::whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])->where('branch_id', $request->select['id'])->where('status', 'Returned')->count();
                }
                // return 'st3';
                // return Shipment::where('branch_id', $request->select['id'])
                //                 // ->where('status', 'Returned')
                //                 ->whereBetween('created_at', [$request->form['start_date'], $request->form['end_date']])
                //                 ->count();
            }
        }
    }

    public function btwSTdate(Request $request)
    {
        return $request->all();
    }

    public function getShipmentsBtw(Request $request)
    {
        return $request->all();
    }
    public function glSearch(Request $request)
    {
        // return $request->all();
        $search = $request->search;
        if (!$search) {
            return;
        }
        $search = str_replace(' ', '', $search);

        if (Auth::user()->hasRole('Admin')) {
            return Shipment::withoutGlobalScope(ShipmentScope::class)->where('bar_code', 'LIKE', "%{$search}%")
                ->orwhere('client_phone', 'LIKE', "%{$search}%")
                ->orwhere('client_email', 'LIKE', "%{$search}%")
                ->orwhere('client_name', 'LIKE', "%{$search}%")->paginate(500);
        } else {
            return Shipment::where('bar_code', 'LIKE', "%{$search}%")
                ->orwhere('client_phone', 'LIKE', "%{$search}%")
                ->orwhere('client_email', 'LIKE', "%{$search}%")
                ->orwhere('client_name', 'LIKE', "%{$search}%")->paginate(500);
        }
    }
}
