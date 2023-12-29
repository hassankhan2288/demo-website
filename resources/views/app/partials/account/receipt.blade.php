@extends('layouts.app')
@section('content')
<section id="pricing" class="pricing">
  <div class="container">

    <div class="section-title">
      <h2 class="text-center"></h2>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
              <h4 class="card-title mb-3">Billing history</h4>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Invoice</th>
                  </thead>
                  <tbody>
                    @foreach ($receipts as $receipt)
                        <tr>
                            <td>{{ $receipt->paid_at->toFormattedDateString() }}</td>
                            <td>{{ $receipt->amount() }}</td>
                            <td><a href="{{ $receipt->receipt_url }}" class="btn btn-outline-primary btn-sm" target="_blank" >Download</a></td>
                        </tr>
                    @endforeach
                  </tbody>
              </table>
            </div>
            @if($subscription)
              <p class="text-muted">Next payment: {{ $subscription->nextPayment()->amount() }} due on {{ $subscription->nextPayment()->date()->format('d/m/Y') }}</p>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection

