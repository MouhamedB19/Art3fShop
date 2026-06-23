<?php
namespace App\Calculs;  

trait CalculeReduction
{
    protected function calculerReduction($total, $coupons)
    {
        $reduction = 0;

        foreach ($coupons as $coupon) {
            $reduction += $coupon->type === 'pourcentage'
                ? $total * $coupon->valeur / 100
                : $coupon->valeur;
        }

        return min($reduction, $total);
    }
}

