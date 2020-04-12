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
    public function store(Request $request, Domain $domain)
    {
        try {
            $response = Http::get($domain->name);
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
        $h1 = $document->has('h1') ?
        mb_strimwidth($document->first('h1')->text(), 0, 255) :
        null;
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
}
