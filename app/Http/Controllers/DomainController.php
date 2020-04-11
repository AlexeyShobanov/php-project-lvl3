<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = \DB::table('domains')
        ->groupBy('id')
        ->get();

        $lastChecks = \DB::table('domains')->find(1) ?
        \DB::table('domain_checks')
        ->select('domain_id', 'status_code', \DB::raw('max(created_at) as created_at'))
        ->groupBy('domain_id', 'status_code')
        ->get()
        ->keyBy('domain_id') :
        null;
        return view('domain.index', compact('domains', 'lastChecks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $domain = $this->validate($request, [
                'name' => 'required'
            ]);
        } catch (ValidationException $e) {
            flash('Enter the url of the Internet resource')->error();
            return redirect()
            ->route('index');
        }

        $parsedUrl = parse_url($domain['name']);

        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
        $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        if (!$scheme && !$host) {
            flash('Not a valid url')->error();
            return redirect()
            ->route('index');
        }

        $normalizedUrl = $scheme . $host;

        if (!empty(\DB::table('domains')->where('name', $normalizedUrl)->get()->all())) {
            flash('Url already added')->warning();
            return redirect()
            ->route('index');
        }

        $domain = new Domain();
        $domain->name = $normalizedUrl;
        $domain->save();

        flash('Url added successfully')->success();

        return redirect()
            ->route('domains.show', compact('domain'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function show(Domain $domain)
    {
        return view('domain.show', compact('domain'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function edit(Domain $domain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domain $domain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domain $domain)
    {
        //
    }
}
