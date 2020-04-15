<?php

namespace App\Http\Controllers;

use App\Domain;
use App\DomainCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use DiDom\Document;
use DiDom\Query;
use Illuminate\Http\Client\ConnectionException;

class DomainCheckController extends Controller
{
    public function store(Request $request, Domain $domain)
    {
        try {
            $response = Http::get($domain->name);
        } catch (ConnectionException $e) {
            flash('Request timed out')->error();
            return redirect()
            ->route('domains.show', compact('domain'));
        }
        if ($response->clientError()) {
            flash('Status code 40x: Bad Request')->warning();
        }
        if ($response->serverError()) {
            flash('Status code 50x: Internal Server Error')->warning();
        }
        $document = new Document($response->body());
        $statusCode = $response->status();
        $h1 = mb_strimwidth(optional($document->first('h1'))->text(), 0, 255);
        $keywords = optional($document->first('meta[name="keywords"]'))->getAttribute('content');
        $description = optional($document->first('meta[name="description"]'))->getAttribute('content');
        $params = [
            'status_code' => $statusCode,
            'h1' => $h1,
            'keywords' => $keywords,
            'description' => $description,
        ];
        $check = $domain->checks()->make($params);
        $check->save();

        flash('Url verification completed')->success();

        return redirect()
            ->route('domains.show', compact('domain'));
    }
}
