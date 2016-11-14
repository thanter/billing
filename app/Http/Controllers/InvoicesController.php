<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function all()
    {
        $invoices = auth()->user()->invoices();

        return view('billing.invoices.index', compact('invoices'));
    }



    public function download($id)
    {
        return auth()->user()->downloadInvoice($id, [
            'vendor'  => 'Acme Corp',
            'product' => 'Dynamite',
        ]);
    }
}
