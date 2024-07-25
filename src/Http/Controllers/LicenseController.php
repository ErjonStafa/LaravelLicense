<?php

namespace Erjon\LaravelLicense\Http\Controllers;

use App\Http\Controllers\Controller;
use Erjon\LaravelLicense\Facades\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function showActivateForm()
    {
        return view('license::activate');
    }

    public function activateLicense(Request $request)
    {
        $items = \Validator::make($request->all(), ['license' => ['required', 'min:8', 'max:30']]);
        $data = $items->validated();

        try {
            License::activate($data['license']);
            return redirect(config('vendor.license.php.license.route.home', '/'));
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
