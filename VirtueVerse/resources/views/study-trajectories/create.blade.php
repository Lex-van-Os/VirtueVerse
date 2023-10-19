@extends('app')

@section('content')
<head>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/studyTrajectories/studyTrajectoryCombobox.js')
    @vite('resources/js/shared/regexHelper.js')
</head>

<h1 class="text-3xl font-bold underline">Create study trajectory</h1>


<!-- Study trajectory Creation Form -->
<form action="{{ route('study-trajectory.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    @csrf

    @if ($errors->any())
        <x-forms.validation-errors :errors="$errors" />
    @endif

    <x-forms.text-input type="text" id="title" label="Title" name="title" placeholder="Title" value="{{ old('title') }}" /> 
    <x-forms.text-input type="text" id="description" label="Description" name="description" placeholder="Description" value="{{ old('description') }}" />
    <x-forms.combobox-input id="book-edition" name="book-edition" label="Book edition" :models="$bookEditions" idField="id" valueField="title"></x-forms.combobox-input>

    <input type="hidden" name="book-edition-id" id="book-edition-id" value="{{ old('book-edition-id') }}">

    <div class="flex items-center justify-between">
        <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit">
            Add study trajectory
        </button>
    </div>
</form>


@endsection