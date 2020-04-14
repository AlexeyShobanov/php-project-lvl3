<?php

namespace App\Http\Controllers;

use App\Domain;
use App\DomainCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use DiDom\Document;
use DiDom\Query;
use Exception;

class DomainCheckController extends Controller
{
    public function store(Request $request, Domain $domain)
    {
        try {
            $response = Http::get($domain->name);
            if ($response->clientError()) {
                throw new Exception('Status code 400: Bad Request');
            }
            if ($response->serverError()) {
                throw new Exception('Status code 500: Internal Server Error');
            }
        } catch (Exception $e) {
            flash('Something was wrong')->error();
            return redirect()
            ->route('domains.show', compact('domain'));
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

        return redirect()
            ->route('domains.show', compact('domain'));
    }
}
