<div class="mb-4">
    <label for="{{ $name }}" class="block text-gray-700 text-sm font-bold mb-2">{{ $label }}</label>
    <textarea type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error($name) border-red-500 @enderror" value="{{ old($name) }}"></textarea>
    @error($name)
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
</div>