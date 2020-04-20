<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DomainController extends Controller
{
    public function index()
    {
        $domains = \DB::table('domains')
            ->get();

        $lastChecks = \DB::table('domain_checks')
            ->distinct('domain_id')
            ->orderBy('domain_id')
            ->orderBy('created_at', 'desc')
            ->get()
            ->keyBy('domain_id');
        return view('domain.index', compact('domains', 'lastChecks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|url|max:255'
        ]);
        if ($validator->fails()) {
            flash('Not a valid url')->error();
            return redirect()
            ->route('welcome');
        }
        $domain = $validator->valid();
        $parsedUrl = parse_url($domain['name']);
        $normalizedUrl = "{$parsedUrl['scheme']}://{$parsedUrl['host']}";

        $existingDomain = \DB::table('domains')->where('name', $normalizedUrl)->first();
        if ($existingDomain) {
            flash('Url already added')->warning();
            return redirect()
            ->route('domains.show', ['domain' => $existingDomain->id]);
        }

        $domain = new Domain();
        $domain->name = $normalizedUrl;
        $domain->save();

        flash('Url added successfully')->success();

        return redirect()
            ->route('domains.show', compact('domain'));
    }

    public function show(Domain $domain)
    {
        return view('domain.show', compact('domain'));
    }
}
