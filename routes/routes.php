<?php

function routes()
{
    return [
        'main'=>'Main',
        'createpayment'=>'createPayment',
        'editpayment/([0-9]+)'=>'editPayment/$1',
        'updatepayment'=>'updatePayment',
        'deletepayment'=>'deleteOnePayment',
        ''=>'Main'
    ];
}