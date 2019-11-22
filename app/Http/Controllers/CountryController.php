<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CountryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// return $request->all();
        $this->Validate($request, [
            'country_name' => 'required',
        ]);
        $country = new Country;
        $country->country_name = $request->country_name;
        $country->user_id = Auth::id();
        $country->save();
        return $country;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {

        $country = Country::find($request->id);
        $country->country_name = $request->country_name;
        $country->save();
        return $country;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        Country::find($country->id)->delete();
    }

    public function getCountry()
    {
        return Country::with(['branches'])->get();
    }

	public function country_image(Request $request, $id)
	{
		// dd($request->all());
		$upload = Country::find($request->id);
        if ($request->hasFile('image')) {
        // dd($request->all());
        // return $upload->image;
            $img = $request->image;
            if (File::exists($upload->image)) {
                // return('test');
                $image_path = $upload->image;
                File::delete($image_path);
            }
            // dd('noo');
            $imagename = Storage::disk('public')->put('country', $img);
                // return('noop');
            $imgArr = explode('/', $imagename);
            $image_name = $imgArr[1];
            $upload->image = '/storage/country/' . $image_name;
            $upload->save();
            return $upload;
        }
	}
}
