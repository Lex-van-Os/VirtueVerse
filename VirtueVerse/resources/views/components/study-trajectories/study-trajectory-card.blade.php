<a href="{{ route('study-trajectory.show', $studyTrajectory->id) }}" class="block bg-white rounded-lg shadow-md cursor-pointer">
    <div class="p-4">
        <h2 class="text-lg font-semibold mb-2">{{ $studyTrajectory->title }}</h2>
        <p class="text-gray-700 mb-4">{{ Str::limit($studyTrajectory->description, 150) }}</p>
        <span class="text-sm py-1 px-2 rounded-full {{ $studyTrajectory->active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
            {{ $studyTrajectory->active ? 'Active' : 'Paused' }}
        </span>
    </div>
    <div class="p-4 border-t border-gray-300">
        <p class="text-gray-400 text-sm italic">Created on: {{ $studyTrajectory->created_at->format('d-m-Y') }}</p>
    </div>
</a>