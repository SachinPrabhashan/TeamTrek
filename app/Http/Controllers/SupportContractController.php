<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SupportContract;
use Illuminate\Support\Carbon;

class SupportContractController extends Controller
{
    public function ScIndex(SupportContract $supportcontract)
    {
        //$this->authorize('view', $usermanagement);
        $supportcontracts= SupportContract::All();
        $users=User::where('role_id',4)->get();

        return view('admin.ScHandling', compact('supportcontracts'));
    }
}
