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
            ->select('domain_id', 'status_code', \DB::raw('max(created_at) as created_at'))
            ->groupBy('domain_id', 'status_code')
            ->get()
            ->keyBy('domain_id');
        return view('domain.index', compact('domains', 'lastChecks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            flash('Enter the url of the Internet resource')->error();
            return redirect()
            ->route('welcome');
        }
        $domain = $validator->valid();

        $parsedUrl = parse_url($domain['name']);

        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
        $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        if (!$scheme && !$host) {
            flash('Not a valid url')->error();
            return redirect()
            ->route('welcome', ['name' => $domain['name']]);
        }

        $normalizedUrl = $scheme . $host;

        if (!empty(\DB::table('domains')->where('name', $normalizedUrl)->get()->all())) {
            flash('Url already added')->warning();
            return redirect()
            ->route('welcome', ['name' => $domain['name']]);
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
