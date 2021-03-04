<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\DateTime;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\User';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Avatar::make('Profile Image')->disk('local')->disableDownload()->exceptOnForms(),

            Text::make('Account No', function () {
                return $this->getAccountNumber();
            }),

            Text::make('Username')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,username,{{resourceId}}'),

            Select::make('Title')
                ->rules('required')    
                ->options([
                    'Mr' => 'Mr',
                    'Mrs' => 'Mrs',
                    'Miss' => 'Miss',
                    'Ms' => 'Ms'
                ])
                ->hideFromIndex(),

            Text::make('First Name')
                ->sortable()
                ->rules('required', 'max:255'),
                
            Text::make('Last Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Date::make('DOB')
                ->sortable()
                ->rules('required', 'date', 'before_or_equal:18 years ago')
                ->hideFromIndex()
                ->displayUsing(function ($dob) {
                    return "{$dob->format('d/m/Y')} ({$dob->diffInYears()} years old)";
                }),

            DateTime::make('Joined', 'created_at')
                ->sortable()
                ->hideFromIndex(),

            Country::make('Country', 'country'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:255')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),

            Select::make('Banned')->options([
                '' => 'Not Banned',
                'F' => 'Full',
                'P' => 'Partial'
            ])->rules('nullable')->displayUsingLabels(),

            Currency::make('Total Balance', function () {
                return $this->getBalance();
            }),

            Currency::make('Withdrawable Funds', function () {
                return $this->getWithdrawableFunds();
            }),

            BelongsToMany::make('Groups'),

            HasMany::make('Transactions'),

            BelongsToMany::make('Games', null, GameInstance::class)->fields(function () {
                return [
                    Boolean::make('Winner', 'winner'),
                ];
            }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new Actions\BanUser
        ];
    }
}
