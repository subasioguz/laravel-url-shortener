<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class RedirectController extends Controller
{
    public function index($slug, Agent $agent, Request $request)
    {
        $link = Link::whereSlug($slug)
            ->firstOrFail();

        $link->visits()->create([
            'ip_address' => $request->ip(),
            'operating_system' => $agent->device(),
            'operating_system_version' => $agent->device(),
            'browser' => $agent->browser(),
            'browser_version' => $agent->browser(),
            'visited_at' => now(),
        ]);

        return redirect()->to($link->url);
    }
}
