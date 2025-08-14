<?php
namespace Modules\Payment\Libraries;


trait PaymentHelpersTrait
{
    /**
     * Calculate total amount with SSLCommerz gateway fee
     *
     * @param float $amount Base amount
     * @return array ['base_amount' => float, 'fee' => float, 'total' => float]
     */
    public static function calculateSSLCommerzTotal($amount)
    {
        $baseAmount = (float) $amount;
        $feePercentage = config('global.sslcommerz_payment_gateway_charge', 2.10);
        $fee = ($baseAmount * $feePercentage) / 100;
        $total = $baseAmount + $fee;

        return [
            'base_amount' => $baseAmount,
            'fee' => round($fee, 2),
            'total' => round($total, 2)
        ];
    }

    /**
     * Calculate total amount with bKash gateway fee
     *
     * @param float $amount Base amount
     * @return array ['base_amount' => float, 'fee' => float, 'total' => float]
     */
    public static function calculateBkashTotal($amount)
    {
        $baseAmount = (float) $amount;
        $feePercentage = config('global.bkash_payment_gateway_charge', 1.5);
        $fee = ($baseAmount * $feePercentage) / 100;
        $total = $baseAmount + $fee;

        return [
            'base_amount' => $baseAmount,
            'fee' => round($fee, 2),
            'total' => round($total, 2)
        ];
    }

    /**
     * Get payment gateway fee rates
     *
     * @return array
     */
    public static function getPaymentGatewayRates()
    {
        return [
            'sslcommerz' => config('global.sslcommerz_payment_gateway_charge', 2.10),
            'bkash' => config('global.bkash_payment_gateway_charge', 1.5)
        ];
    }
}