<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeamMember;

class TeamController extends Controller
{
    public function index()
    {
        $team = TeamMember::where('status', true)
            ->orderBy('order', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $team->map(function ($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->name,
                    'last_name' => $member->last_name,
                    'full_name' => $member->name . ' ' . $member->last_name,
                    'role' => $member->role,
                    'order' => $member->order,
                    'platform' => $member->platform,
                    'platform_link' => $member->platform_link,
                    'photo' => $member->photo ? asset('storage/' . $member->photo) : null,
                ];
            })
        ]);
    }
}
