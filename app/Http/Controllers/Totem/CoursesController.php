<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;

class CoursesController extends Controller
{
    public function index()
    {
        $coursesUrl = config('totem.courses_url');
        $proxyPath = trim((string) config('totem.courses_proxy_path', ''), '/');
        $coursesProxyUrl = url('/senac-proxy/' . $proxyPath);

        $qr = (new Builder())->build(
            data: $coursesUrl,
            encoding: new Encoding('UTF-8'),
            size: 260,
            margin: 10
        );

        $qrCodeDataUri = $qr->getDataUri();

        return view('totem.courses', compact('coursesUrl', 'coursesProxyUrl', 'qrCodeDataUri'));
    }
}
