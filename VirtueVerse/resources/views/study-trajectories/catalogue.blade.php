@extends('app')

@section('content')

<head>
    @vite('resources/css/app.css')
    @vite('resources/js/shared/regexHelper.js')
</head>

    <h1 class="text-3xl font-semibold mb-6">Study Trajectory catalogue</h1>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($studyTrajectories as $studyTrajectory)
            <x-study-trajectories.study-trajectory-card :studyTrajectory="$studyTrajectory" />
        @endforeach
    </div>

@endsection