<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Illuminate\Http\Request;

class ExternalLinkController extends Controller
{
    public function show(Request $request)
    {
        $url = (string) $request->query('url', '');
        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (! in_array($scheme, ['http', 'https', 'mailto', 'tel'], true)) {
            abort(404);
        }

        if (in_array($scheme, ['http', 'https'], true) && ! filter_var($url, FILTER_VALIDATE_URL)) {
            abort(404);
        }

        $qr = (new Builder())->build(
            data: $url,
            encoding: new Encoding('UTF-8'),
            size: 240,
            margin: 10
        );

        $qrCodeDataUri = $qr->getDataUri();
        $host = parse_url($url, PHP_URL_HOST);
        if (! $host) {
            $host = match ($scheme) {
                'mailto' => 'E-mail',
                'tel' => 'Telefone',
                default => 'link externo',
            };
        }

        return view('totem.external', compact('url', 'host', 'qrCodeDataUri'));
    }
}
