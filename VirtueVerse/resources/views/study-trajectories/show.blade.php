@extends('app')

@section('content')
<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/studyTrajectories/studyTrajectory.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<h1 class="text-3xl font-semibold mb-6">Study trajectory</h1>
<div class="flex justify-center mt-8">

    <!-- Book image and actions -->
    <div class="w-1/4">
        <img src="{{ asset('book-template.png') }}" alt="Book Cover" class="w-full">
        
        <div class="mt-4 flex flex-col space-y-4">
            @if($studyTrajectory->created_by === Auth::user()->id)
                @if ($studyTrajectory->active)
                    <form class="w-full" method="POST" action="{{ route('study-trajectory.changeTrajectoryStatus', ['id' => $studyTrajectory->id, 'active' => 0]) }}">
                        @csrf
                        @method('PUT')
                        <button class="w-full bg-red-500 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg">Pause Trajectory</button>
                    </form>
                @else
                    <form class="w-full" method="POST" action="{{ route('study-trajectory.changeTrajectoryStatus', ['id' => $studyTrajectory->id, 'active' => 1]) }}">
                        @csrf
                        @method('PUT')
                        <button class="w-full bg-green-500 hover-bg-green-700 text-white font-medium py-2 px-4 rounded-lg">Resume Trajectory</button>
                    </form>
                @endif
            @endif

            <a href="{{ route('study-entry.create', $studyTrajectory->id) }}" class="text-center bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">Add study entry</a>
        </div>
    </div>

    <div class="w-3/4 ml-8">
        <h1 class="text-4xl font-semibold mb-1">{{ $studyTrajectory->title }}</h1>
        <p class="mt-2">{{ $studyTrajectory->description }}</p>
    </div>
</div>

<div class="trajectory-charts">
    <input type="hidden" id="study-trajectory-id" value="{{ $studyTrajectory->id }}">
    <h1>Chart data</h1>

    <div>
        <canvas id="readPagesChart"></canvas>
        <canvas id="pagesByMonthChart"></canvas>
        <canvas id="readingSpeedChart"></canvas>
        <canvas id="inputtedRecordsChart"></canvas>
    </div>      
</div>
@endsection