<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ricesales\SalesHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    function index()
    {
        $sales_today = SalesHistory::get();

        $data = [
            'title' => 'Dashboard Admin',
            'sales' => $sales_today
        ];
    }
}
