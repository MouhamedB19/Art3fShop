<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Http\Resources\CouponResource;

class CouponController extends Controller
{
    public function appliquer(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', $request->code)->first();

        $coupons = session('coupons', []); 

        if($coupon && in_array($coupon->id, $coupons)) {
            return response()->json([
                'message' => 'Coupon déjà appliqué.',
                'code' => 400
            ]);
        }

        if (!$coupon) {
            return response()->json([
                'message' => 'Coupon invalide.',
                'code' => 400
            ]);
        }

        if ($coupon->date_expiration < now()) {
            return response()->json([
                'message' => 'Ce coupon a expiré.',
                'code' => 400
            ]);
        }

        if($coupon->nombre_utilisations >= $coupon->utilisations_max){
            return response()->json([
                'message' => 'Ce coupon a atteint son nombre maximum d\'utilisations.',
                'code' => 400
            ]);
        }
        
        $coupons[] = $coupon->id;
        session(['coupons' => $coupons]);
        return response()->json([
            'message' => 'Coupon appliqué avec succès.',
            'discount' => $coupon->remise,
            'code' => 200
        ]);
    }

    public function index()
    {
        $coupons = Coupon::all();

        return response()->json([
            'coupons' => CouponResource::collection($coupons),
            'code' => 200
        ]);
    }
}
