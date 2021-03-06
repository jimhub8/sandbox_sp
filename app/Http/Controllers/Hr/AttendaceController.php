<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\models\Hr\Attendace;
use Illuminate\Http\Request;

class AttendaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Attendace::paginate(500);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Hr\Attendace  $attendace
     * @return \Illuminate\Http\Response
     */
    public function show(Attendace $attendace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\Hr\Attendace  $attendace
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendace $attendace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Hr\Attendace  $attendace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendace $attendace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Hr\Attendace  $attendace
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendace $attendace)
    {
        //
    }
}
