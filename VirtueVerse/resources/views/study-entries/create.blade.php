@extends('app')

@section('content')
<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<h1 class="text-3xl font-bold underline">Create study entry</h1>

<!-- Study entry Creation Form -->
<form action="{{ route('study-entry.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    @csrf

    @if ($errors->any())
        <x-forms.validation-errors :errors="$errors" />
    @endif

    {{-- study_trajectory_id --}}
    {{-- read_pages --}}
    {{-- notes --}}
    {{-- date --}}
    <x-forms.text-input type="date" id="date" label="Reading date" name="date" placeholder="Reading date" value="{{ old('date') }}" />
    <x-forms.text-input type="number" id="read-pages" label="Read pages" name="read-pages" placeholder="Read pages" value="{{ old('read-pages') }}" /> 
    <x-forms.text-input type="text" id="notes" label="Notes" name="notes" placeholder="Notes" value="{{ old('notes') }}" />

    <input type="hidden" name="study-trajectory-id" id="study-trajectory-id" value="{{ $study_trajectory_id }}">

    <div class="flex items-center justify-between">
        <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit">
            Add study entry
        </button>
    </div>
</form>

@endsection