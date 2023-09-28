<?php

namespace App\Services;

class PayPalService
{

    /**
     * PayPalService constructor.
     */
    public function __construct(private string $order_id)
    {
    }

    public function redirectAddress(float $price, string $currency, bool $noRedirect)
    {
        $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-60U79048BN7719609&price='.$price.'&currency='.$currency.'&order_id='.$this->order_id;

        if($noRedirect) {
             return $url;
        }

        return redirect($url);
    }
}
