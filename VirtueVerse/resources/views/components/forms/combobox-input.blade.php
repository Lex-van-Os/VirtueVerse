<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="{{ $name }}">
        {{ $label }}
    </label>
    <select
        class="block appearance-none w-full rounded text-red-700 leading-tight focus:outline-none focus:shadow-outline selectize"
        id="{{ $name }}"
        name="{{ $name }}"
        required
    >
        <option value="" disabled selected>Select a {{ strtolower($label) }}</option>
        @foreach ($models as $model)
            <option value="{{ $model[$idField] }}">{{ $model[$valueField] }}</option>
        @endforeach
    </select>
</div>