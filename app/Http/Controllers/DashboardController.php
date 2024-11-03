<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

class DashboardController extends Controller
{
    use Helper;

    public function __construct()
    {

    }
    public function dashboardData(){
        $user = auth()->user();
        $data['user_create_date'] = $created_at = $user->created_at ? $created_at = $user->created_at->format('d-M-Y') : null;

        return returnData(2000, $data);
    }
}
