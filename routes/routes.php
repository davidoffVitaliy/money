<?php

function routes()
{
    return [
        'main'=>'Main',
        'createpayment'=>'createPayment',
        //'exchange'=>'createExchange',  
        'editpayment/([0-9]+)'=>'editPayment/$1',
        'editexchange/([0-9]+)'=>'editexchangePayment/$1',
        'updatepayment'=>'updatePayment',
        'deletepayment'=>'deleteOnePayment',
        'cabinet'=>'cabinet',
        ''=>'Main'
    ];
}