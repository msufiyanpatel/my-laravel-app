@php
    $route = request()
        ->route()
        ->getName();
@endphp
<div class="rounded-t mb-0 px-4 py-3 border-0">
    <div class="flex justify-center">
        <h3 class="font-semibold text-base text-gray-700 flex gap-1">
            <a href="{{ route('frontend.user.dashboard') }}" title="Show Convert History"
                class="{{ $route == 'frontend.user.dashboard' ? 'bg-blue-500' : 'bg-sky-400' }} hover:bg-blue-500 text-white rounded p-1">
                <span class="p-2">History</span>
            </a>
            <a href="{{ route('frontend.user.profile') }}" title="Show Profile"
                class="{{ $route == 'frontend.user.profile' ? 'bg-blue-500' : 'bg-sky-400' }} hover:bg-blue-500 text-white rounded p-1">
                <span class="p-2">Profile</span>
            </a>
        </h3>
    </div>
</div>
