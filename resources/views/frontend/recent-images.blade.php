@if (count($images) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 ">
        @foreach ($images as $key => $data)
            <div class="flex justify-center">
                <div>
                    <a href="{{ $data->converted }}" target="_blank" title="Download: {{ $data->file_name }}">
                        <img class="object-scale-down h-48 w-96" src="{{ $data->converted }}" alt="{{ $data->file_name }}">
                        <br>
                        <span class="text-blue-400">{{ $data->file_name }}</span>
                    </a>
                    <a href="{{ $data->converted }}" target="_blank" download="{{ $data->file_name }}" title="Download"
                        class="bg-sky-400 hover:bg-blue-500 text-white text-sm py-1 px-1 rounded ml-1">
                        Download
                    </a>
                    <a href="{{ route('delete.image', routeEncrypt($data->id)) }}" title="Delete this image"
                        class="bg-red-400 hover:bg-red-500 text-white text-sm py-1 px-1 rounded ml-1">
                        Delete
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>No image found</p>
@endif
