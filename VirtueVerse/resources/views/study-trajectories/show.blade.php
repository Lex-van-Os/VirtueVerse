@extends('app')

@section('content')
<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/studyTrajectories/studyTrajectory.js')
    @vite('resources/js/studyTrajectories/studyTrajectoryCharts.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<h1 class="text-3xl font-semibold mb-6">Study trajectory</h1>
<div class="flex justify-center mt-8 mb-8">

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
        <p class="mt-2 mb-2">{{ $studyTrajectory->description }}</p>
        <p class="text-sm text-gray-600">Linked entries: {{ $totalStudyEntries }}</p>

        <div class="trajectory-charts h-5/6">
            <input type="hidden" id="study-trajectory-id" value="{{ $studyTrajectory->id }}">
            <h2 class="text-3xl font-semibold mb-6 mt-6">Chart data</h2>

            <ul class="flex">
                <li class="mr-6">
                    <a href="#" class="text-blue-500 hover:text-blue-800 focus:outline-none focus:text-blue-800" onclick="switchChartTab('readPagesTab')">
                        Read pages
                    </a>
                </li>
                <li class="mr-6">
                    <a href="#" class="text-blue-500 hover:text-blue-800 focus:outline-none focus:text-blue-800" onclick="switchChartTab('pagesByMonthTab')">
                        Pages by month
                    </a>
                </li>
                <li class="mr-6">
                    <a href="#" class="text-blue-500 hover:text-blue-800 focus:outline-none focus:text-blue-800" onclick="switchChartTab('readingSpeedTab')">
                        Reading speed
                    </a>
                </li>
                <li>
                    <a href="#" class="text-blue-500 hover:text-blue-800 focus:outline-none focus:text-blue-800" onclick="switchChartTab('inputtedRecordsTab')">
                        Inputted records
                    </a>
                </li>
            </ul>
        
            <div id="readPagesTab" class="chart-tab" style="height: inherit">
                <canvas id="readPagesChart"></canvas>
            </div>
            <div id="pagesByMonthTab" class="chart-tab hidden" style="height: inherit">
                <canvas id="pagesByMonthChart"></canvas>
            </div>
            <div id="readingSpeedTab" class="chart-tab hidden" style="height: inherit">
                <canvas id="readingSpeedChart"></canvas>
            </div>
            <div id="inputtedRecordsTab" class="chart-tab hidden" style="height: inherit">
                <canvas id="inputtedRecordsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="trajectory-entries mb-8">
    <h2 class="text-3xl font-semibold mb-6">Study entries</h2>
    <div>
        <ul class="flex mb-2">
            <li class="mr-6">
                <a href="#" class="text-blue-500 hover:text-blue-800 focus:outline-none focus:text-blue-800" onclick="showTab('pages-tab')">
                    Read pages
                </a>
            </li>
            <li class="mr-6">
                <a href="#" class="text-blue-500 hover:text-blue-800 focus:outline-none focus:text-blue-800" onclick="showTab('read-minutes-tab')">
                    Minutes read
                </a>
            </li>
            <li>
                <a href="#" class="text-blue-500 hover:text-blue-800 focus:outline-none focus:text-blue-800" onclick="showTab('notes-tab')">
                    Notes
                </a>
            </li>
        </ul>
    
        <!-- Table for Pages Entries -->
        <div id="pages-tab" class="study-entries-tab">
            <div class="bg-white overflow-hidden shadow-md rounded-lg">

                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Read Pages</th>
                            <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Edit</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($studyTrajectory->pagesEntries as $pagesEntry)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ date("d-m-Y", strtotime($pagesEntry->date)) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pagesEntry->read_pages }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    
        <!-- Table for Read Minutes Entries -->
        <div id="read-minutes-tab" class="study-entries-tab hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Read minutes</th>
                        <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Edit</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($studyTrajectory->readMinutesEntries as $readMinutesEntry)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ date("d-m-Y", strtotime($readMinutesEntry->date)) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $readMinutesEntry->read_minutes }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <!-- Table for Notes Entries -->
        <div id="notes-tab" class="study-entries-tab hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Edit</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($studyTrajectory->notesEntries as $notesEntry)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ date("d-m-Y", strtotime($notesEntry->date)) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $notesEntry->notes }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showTab(tabId) {
        event.preventDefault();

        // Hide all tabs
        document.querySelectorAll('.study-entries-tab').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Show the selected tab
        document.getElementById(tabId).classList.remove('hidden');
    }

    function switchChartTab(selectedChart) {
        event.preventDefault();

        // Hide all tabs
        document.querySelectorAll('.chart-tab').forEach(chart => {
            chart.classList.add('hidden');
        });

        // Show the selected tab
        document.getElementById(selectedChart).classList.remove('hidden');
    }
</script>
@endsection