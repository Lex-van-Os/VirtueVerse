<?php

namespace App\View\Components\StudyTrajectories;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class StudyTrajectoryCard extends Component
{
    public $studyTrajectory;

    public function __construct($studyTrajectory)
    {
        $this->studyTrajectory = $studyTrajectory;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.study-trajectories.study-trajectory-card');
    }
}
