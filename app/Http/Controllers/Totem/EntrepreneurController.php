<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use App\Models\Entrepreneur;
use App\Support\UnitContext;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;

class EntrepreneurController extends Controller
{
    public function index()
    {
        $unitId = UnitContext::resolveTotemUnitId(request());
        $entrepreneurs = Entrepreneur::where('status', 'approved')
            ->where('unidade_id', $unitId)
            ->with('images')
            ->latest()
            ->paginate(12);

        return view('totem.entrepreneurs.index', compact('entrepreneurs'));
    }

    public function show(Entrepreneur $entrepreneur)
    {
        $unitId = UnitContext::resolveTotemUnitId(request());
        abort_unless($entrepreneur->status === 'approved' && (int) $entrepreneur->unidade_id === (int) $unitId, 404);

        $entrepreneur->load('images');

        $number = preg_replace('/\D+/', '', $entrepreneur->whatsapp_number);
        if (!str_starts_with($number, '55')) {
            $number = '55' . $number;
        }
        $message = urlencode($entrepreneur->whatsapp_message_template);
        $whatsUrl = "https://wa.me/{$number}?text={$message}";

        $qr = (new Builder())->build(
            data: $whatsUrl,
            encoding: new Encoding('UTF-8'),
            size: 320,
            margin: 10
        );

        $qrCodeDataUri = $qr->getDataUri();

        return view('totem.entrepreneurs.show', compact('entrepreneur', 'qrCodeDataUri'));
    }
}
