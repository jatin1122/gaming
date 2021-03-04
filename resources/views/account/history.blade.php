@extends('layouts.account')

@section('title', 'History')

@section('panel')

    <ul class="history-card-wrapper">
        @foreach ($transactions as $monthsAgo => $transaction)
            <li class="history-card">

                <button 
                    type="button" 
                    class="history-card__header"
                    data-accordian-group="transaction" 
                    data-accordian-trigger="{{ $loop->index }}" 
                >
                    <div class="history-card__month">
                        {{ date('F Y',strtotime('-'. $monthsAgo .' month')) }}
                        <small>({{ $transaction->count() }})</small>
                    </div>
                    <!-- /.history-card__month -->
                    <div class="history-card__arrow"></div>
                </button>
                <!-- /.history-card__header -->
                <ul 
                    class="history-card__panel"
                    data-accordian-group="transaction" 
                    data-accordian-content="{{ $loop->index }}" 
                    hidden
                >
                    @if($transaction->count() > 0)
                        @foreach($transaction->sortByDesc('created_at') as $item)
                            <li class="history-card__item">
                                
                                <div class="history-card__type">
                                    {{ str_replace('_', ' ', $item->type) }}
                                </div>
                                <div class="history-card__date">
                                    {{ $item->created_at->format('d/m/Y - H.i') }}
                                </div>
                                <!-- /.history-card__date -->
                                <div class="history-card__price history-card__price--{{ in_array($item->type, ['deposit', 'refund', 'win']) ? 'plus' : 'minus' }}">
                                    {{ in_array($item->type, ['deposit', 'refund', 'win']) ? '+' : '-' }}£{{ number_format(abs($item->amount), 2) }}
                                </div>
                                <!-- /.history-card__price -->
                            </li>
                        @endforeach
                    @else
                        <li class="history-card__item">
                            No history for {{ date('F Y',strtotime('-'. $monthsAgo .' month')) }}
                        </li>

                    @endif
                </ul>

            </li>
        @endforeach
    </ul>
        
@endsection
