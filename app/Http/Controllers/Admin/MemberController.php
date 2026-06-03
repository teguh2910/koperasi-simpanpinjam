<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'member')->latest()->get();
        return view('admin.members.index', compact('members'));
    }

    public function show(User $member)
    {
        return view('admin.members.show', compact('member'));
    }
}