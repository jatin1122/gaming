<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use App\Nova\Metrics\GamesPlayedPerRoom;
use Laravel\Nova\Fields\HasMany;

class Game extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Game';

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
        'id',
        'name'
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

            TextWithSlug::make('Name')
                ->sortable()
                ->slug('Slug')
                ->rules('required', 'max:255'),

            Slug::make('Slug'),
            HasMany::make('Rooms', 'rooms', Room::class)
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
        $cards = [];

        foreach ($this->rooms as $room) {
            $cards[] = (new GamesPlayedPerRoom($room))->width('1/4')->onlyOnDetail();
        }

        return $cards;

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
        return [];
    }
}
