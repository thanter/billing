<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function all()
    {
        $invoices = auth()->user()->invoices();

        dd($invoices);

        return view('billing.invoices.index', compact('invoices'));
    }



    public function download($invoiceId)
    {
        $invoice = auth()->user()->invoices()->first();

        echo $invoice->id;
        echo $invoice->date()->toFormattedDateString(). "<br>";
        echo $invoice->total(). "<br>";
    }
}
