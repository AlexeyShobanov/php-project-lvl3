<?php

namespace App\Http\Controllers;

use App\Domain;
use App\DomainCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DomainCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function index(Domain $domain)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function create(Domain $domain)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Domain $domain)
    {
        //$redirectResponse = redirect()->away($domain->name);
        $response = Http::get($domain->name);

        $check = $domain->checks()->make();
        $check->status_code = $response->status();
        $check->save();

        return redirect()
            ->route('domains.show', compact('domain'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Domain  $domain
     * @param  \App\DomainCheck  $domainCheck
     * @return \Illuminate\Http\Response
     */
    public function show(Domain $domain, DomainCheck $domainCheck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Domain  $domain
     * @param  \App\DomainCheck  $domainCheck
     * @return \Illuminate\Http\Response
     */
    public function edit(Domain $domain, DomainCheck $domainCheck)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Domain  $domain
     * @param  \App\DomainCheck  $domainCheck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domain $domain, DomainCheck $domainCheck)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Domain  $domain
     * @param  \App\DomainCheck  $domainCheck
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domain $domain, DomainCheck $domainCheck)
    {
        //
    }
}
