@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Invoices</div>

                    <div class="panel-body">
                        <table class="table">
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                                    <td>{{ $invoice->total() }}</td>
                                    <td><a href="{{ route('invoice.download', $invoice->id) }}">Download</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection