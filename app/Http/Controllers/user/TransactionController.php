<?php

namespace App\Http\Controllers\user;


use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    //use invoke since a single method is present in the class
    public function __invoke()
    {
        //please refer to UserTransactionIndexComposer for data passed to this view
        return view('users.transaction.index');
    }


}
