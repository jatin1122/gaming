<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use App\Nova\Filters\GameInstanceStatus;

class GameInstance extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\GameInstance';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function label()
    {
        return 'Game Instances';
    }

    public static function singularLabel()
    {
        return 'Game Instance';
    }

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
            BelongsTo::make('Game'),
            BelongsTo::make('Room'),
            Select::make('State')->options([
                'in_progress' => 'In Progress',
                'finished' => 'Finished'
            ])->displayUsingLabels(),
            DateTime::make('Started At', 'created_at')->hideFromIndex(),
            DateTime::make('Last Interaction', 'updated_at')->hideFromIndex(),
            Date::make('Date', 'created_at')->onlyOnIndex(),
            BelongsToMany::make('Players', 'players', User::class)->fields(function () {
                return [
                    Boolean::make('Winner', 'winner')
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
        return [
            new GameInstanceStatus
        ];
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
        return [];
    }
}
