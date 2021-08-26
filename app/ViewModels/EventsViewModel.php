<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class EventsViewModel extends ViewModel
{
    public $trending;

    public function __construct($trending)
    {
        $this->trending = $trending;
    }

    public function trending()
    {
        return $this->FormatMovies($this->trending);
    }

    private function FormatMovies($trending)
    {
        return collect($trending)->map(function ($trending) {
            return collect($trending);
        });
    }
}
