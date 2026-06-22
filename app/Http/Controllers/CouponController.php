<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\auth;
use Carbon\Carbon;
class CouponController extends Controller
{
    // CouponController
    // CouponController@appliquer
    public function appliquer(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', $request->code)->first();
        $dateFin = Carbon::parse($coupon->date_fin);
        if (!$coupon) {
            return back()->withErrors(['code' => 'Code invalide']);
        }

        $coupons = session('coupons', []); // tableau d'ids

        if (in_array($coupon->id, $coupons)) {
            return back()->withErrors(['code' => 'Coupon déjà appliqué']);
        }

        if (($coupon->date_fin && $dateFin->isPast())) {
            return back()->withErrors(['code' => 'Code expiré']);
        }

        if ($coupon->utilisations_max && $coupon->utilisations_actuelles >= $coupon->utilisations_max) {
            return back()->withErrors(['code' => 'Code épuisé']);
        }

        $client = Auth::user()->client;
        $total = $client->tirages->sum('prix');

        if ($coupon->montant_min && $total < $coupon->montant_min) {
            return back()->withErrors(['code' => "Panier minimum de {$coupon->montant_min}€ requis"]);
        }

        $coupons[] = $coupon->id;
        session(['coupons' => $coupons]);

        return back()->with('success', 'Coupon appliqué !');
    }

    public function retirer(Coupon $coupon)
    {
        $coupons = session('coupons', []);
        $coupons = array_diff($coupons, [$coupon->id]);
        session(['coupons' => array_values($coupons)]);

        return back()->with('success', 'Coupon retiré');
    }
}
