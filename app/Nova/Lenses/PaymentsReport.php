<?php

namespace App\Nova\Lenses;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Http\Requests\LensRequest;

class PaymentsReport extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return 
            $query
                ->selectRaw('date(created_at) as `date`')
                ->selectRaw("IFNULL((SELECT SUM(amount) FROM transactions WHERE date(created_at) = `date` AND type = 'deposit'), 0) as deposits")
                ->selectRaw("IFNULL((SELECT SUM(amount) FROM transactions WHERE date(created_at) = `date` AND type = 'withdrawal'), 0) as withdrawals")
                ->selectRaw("IFNULL((SELECT SUM(amount) FROM transactions WHERE date(created_at) = `date` AND type = 'entry_fee'), 0) as entry_fees")
                ->selectRaw("IFNULL((SELECT SUM(commission) FROM transactions WHERE date(created_at) = `date` AND type = 'entry_fee'), 0) as commission")
                ->from('transactions')
                ->groupBy('date')
                ->orderBy('date', 'desc');
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('Date', 'date'),

            Currency::make('Deposits'),
            Currency::make('Withdrawals'),
            Currency::make('Entry Fees'),
            Currency::make('Commission'),
        ];
    }

    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'payments-report';
    }
}
