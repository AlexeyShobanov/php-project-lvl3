<?php

namespace App\Http\Controllers;

use App\Domain;
use App\DomainCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\ConnectionException;
use DiDom\Document;
use DiDom\Query;

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
        try {
            $response = Http::timeout(3)->get($domain->name);
        } catch (ConnectionException $e) {
            flash('Connection timed out')->error();
            return redirect()
            ->route('domains.show', compact('domain'));
        }
        if ($response->clientError()) {
            flash('Status code 400: Bad Request')->error();
            return redirect()
            ->route('domains.show', compact('domain'));
        }
        if ($response->serverError()) {
            flash('Status code 500: Internal Server Error')->error();
            return redirect()
            ->route('domains.show', compact('domain'));
        }
        $document = new Document($response->body());
        $statusCode = $response->status();
        $h1 = $document->has('h1') ? $document->first('h1')->text() : null;
        $keywords = $document->has('meta[name="keywords"]') ?
        $document->first('meta[name="keywords"]')->getAttribute('content') :
        null;
        $description = $document->has('meta[name="description"]') ?
        $document->first('meta[name="description"]')->getAttribute('content') :
        null;
        $params = [
            'status_code' => $statusCode,
            'h1' => $h1,
            'keywords' => $keywords,
            'description' => $description,
        ];
        $check = $domain->checks()->make($params);
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
