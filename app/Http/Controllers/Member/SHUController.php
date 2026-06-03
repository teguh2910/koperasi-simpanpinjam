<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\SHUPeriod;
use App\Models\SHUMember;

class SHUController extends Controller
{
    public function index()
    {
        $periods = SHUPeriod::where('status', 'completed')
            ->with(['members' => fn($q) => $q->where('user_id', auth()->id())])
            ->latest()
            ->get();

        return view('member.shu.index', compact('periods'));
    }
}
