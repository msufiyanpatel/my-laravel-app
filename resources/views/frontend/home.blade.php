@extends('frontend.master')
@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
@endpush

@section('content')

    <h1 class="flex justify-center pt-5 text-6xl">
        <img src="{{ assetImage(readconfig('site_logo')) }}" alt="Logo" width="60px">
        {{ readConfig('site_name') }}
    </h1>
    <p class="flex justify-center pt-5">
        Convert JPEG, PNG, BMP and more
    </p>

    {{-- top add --}}
    @if ($top_add && $top_add->status == 1)
        @if ($top_add->type == 1)
            {!! $top_add->code_body !!}
        @else
            <a href="{{ $top_add->img_url }}" class="flex justify-center">
                <img src="{{ $top_add->img }}">
            </a>
        @endif
    @endif

    <div id="first" class="max-w-screen-xl px-4 py-2 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8 mt-5">
        {!! Form::open([
            'route' => ['dropzone.store'],
            'files' => true,
            'enctype' => 'multipart/form-data',
            'class' => 'dropzone',
            'id' => 'image-upload',
        ]) !!}

        <div class="justify-center dz-default dz-message">
            <div class="flex justify-center">
                <svg width="40" height="40" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M22.71 6.29a1 1 0 0 0-1.42 0L20 7.59V2a1 1 0 0 0-2 0v5.59l-1.29-1.3a1 1 0 0 0-1.42 1.42l3 3a1 1 0 0 0 .33.21.94.94 0 0 0 .76 0 1 1 0 0 0 .33-.21l3-3a1 1 0 0 0 0-1.42ZM19 13a1 1 0 0 0-1 1v.38l-1.48-1.48a2.79 2.79 0 0 0-3.93 0l-.7.7-2.48-2.48a2.85 2.85 0 0 0-3.93 0L4 12.6V7a1 1 0 0 1 1-1h8a1 1 0 0 0 0-2H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-5a1 1 0 0 0-1-1ZM5 20a1 1 0 0 1-1-1v-3.57l2.9-2.9a.79.79 0 0 1 1.09 0l3.17 3.17 4.3 4.3Zm13-1a.89.89 0 0 1-.18.53L13.31 15l.7-.7a.77.77 0 0 1 1.1 0L18 17.21Z"
                        fill="#000000" class="fill-6563ff"></path>
                </svg>
            </div>
            <span>Drop file here to upload</span>
        </div>

        {!! Form::close() !!}
    </div>

    <form action="{{ route('convert') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="file" id="uploaded-images" value="[]">
        <input type="hidden" name="name" id="uploaded-images-name" value="[]">
        <div class="flex justify-center">
            <div class="m-1 hidden" id="from-format">
                <select name="type"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" hidden>Choose a format</option>
                    <option value="" selected id="from-select">
                        jpg
                    </option>
                </select>
            </div>
            <span class="mt-3 hidden" id="to-text">To</span>

            <div class="m-1">
                <select name="type" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Choose a format</option>
                    <option value="jpg" {{ strCut(@$_GET['convert']) == 'jpg' ? 'selected' : '' }}>
                        jpg
                    </option>
                    <option value="png" {{ strCut(@$_GET['convert']) == 'png' ? 'selected' : '' }}>
                        png
                    </option>
                    <option value="gif" {{ strCut(@$_GET['convert']) == 'gif' ? 'selected' : '' }}>
                        gif
                    </option>
                    <option value="bmp" {{ strCut(@$_GET['convert']) == 'bmp' ? 'selected' : '' }}>
                        bmp
                    </option>
                    <option value="webp" {{ strCut(@$_GET['convert']) == 'webp' ? 'selected' : '' }}>
                        webp
                    </option>
                    {{-- <option value="tif">tif</option> --}}
                    {{-- <option value="ico">ico</option> --}}
                    {{-- <option value="psd">psd</option> --}}
                </select>
            </div>
            <div class="m-1">
                <button type="submit"
                    class="py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                    Convert
                </button>
            </div>
        </div>

        <!-- Add this right after the form tag -->
        @if (count($files) > 0)
            <div class="max-w-screen-xl px-4 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8 mt-5">
                <div class="p-4 space-y-8 border border-gray-200 rounded">
                    <h1>Output:</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($files as $key => $data)
                            <div class="flex justify-center">
                                <div>
                                    <a href="{{ $data->converted }}" target="_blank"
                                        title="Download: {{ $data->file_name }}">
                                        <img class="object-scale-down h-48 w-96" src="{{ $data->converted }}"
                                            alt="{{ $data->file_name }}">
                                        <br>
                                        <span class="text-blue-400">{{ $data->file_name }}</span>
                                    </a>
                                    <a href="{{ $data->converted }}" target="_blank" download="{{ $data->file_name }}"
                                        title="Download"
                                        class="bg-sky-400 hover:bg-blue-500 text-white text-sm py-1 px-1 rounded ml-1">
                                        Download
                                    </a>
                                    <a href="{{ route('delete.image', routeEncrypt($data->id)) }}"
                                        title="Delete this image"
                                        class="bg-red-400 hover:bg-red-500 text-white text-sm py-1 px-1 rounded ml-1">
                                        Delete
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="max-w-screen-xl px-4 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8 mt-5">
            <div class="flex justify-center">
                <div class="flex flex-wrap-mx-3 mb-2">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="height">
                            Height
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            type="number" name="height" placeholder="">
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="width">
                            Width
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            type="number" name="width" placeholder="">
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="fit">
                            Fit
                        </label>
                        <div class="relative">
                            <select
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                name="size_type">
                                <option>Max</option>
                                <option>Crop</option>
                                <option>Scale</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                                title="Setting these options is optional. The default values are a good start for most cases.">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <span class="text-gray-400 text-xs">
                Sets the mode of resizing the image. "Max" resizes the image to fit within the width and height, but will
                not increase the size of the image if it is smaller than width or height. "Crop" resizes the image to
                fill the width and height dimensions and crops any excess image data. "Scale" enforces the image width
                and height by scaling.
            </span>
        </div>

        <div class="max-w-screen-xl px-4 py-2 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8">
            <div class="quality text-gray-500 mt-6">
                <div class="slider-container">
                    <input id="large-range" type="range" value="95" min="10" max="100" step="1"
                        name="range">
                    <span id="range-value" class="slider-value">95</span>
                </div>
                <h5 class="text-3xl">Image Quality:</h5>
                <p class="mb-2">
                    Use the slider to select the image compression quality:
                </p>
                <ul class="mb-4">
                    <li>Lower values give better compression (at the cost of image quality). Lowest value is 10.</li>
                    <li>Higher values may increase the size of the image. Higest value is 100.</li>
                    <li>Default (95) is a good balance between image quality and compression.</li>
                </ul>
            </div>
        </div>
    </form>

    <div class="max-w-screen-xl px-4 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8 flex justify-center">
        <div class="p-4 space-y-8" id="recent-button-section">
            <button type="button" onclick="loadRecentImages()" title="View your last 12 converted images"
                class="py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                Recently converted images
            </button>
        </div>
    </div>

    {{-- middle add --}}
    @if ($middle_add && $middle_add->status == 1)
        @if ($middle_add->type == 1)
            {!! $middle_add->code_body !!}
        @else
            <a href="{{ $middle_add->img_url }}" class="flex justify-center">
                <img src="{{ $middle_add->img }}">
            </a>
        @endif
    @endif

    {{-- footer top section --}}
    <div class="max-w-screen-xl px-4 py-12 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8 mt-5">
        <h5 class="text-4xl">How to convert?</h5>
        <p>
            1. Upload an image<br>
            2. Select the output image format<br>
            3. Click the "Convert" button<br>
            4. Wait for the conversion to finish and hit the "Download" button to download a single image<br>
            5. Finally, click on "Convert another image" to try another one.
        </p>

        <h5 class="text-4xl">Popular Fromats:</h5>
        <div class="grid grid-cols-2 grid-flow-row">
            <div class="text-blue-500">
                ><a class="popular-format" href="{{ route('home', ['convert' => 'jpg-to-png']) }}">
                    Convert jpg to png
                </a>
                <br>
                ><a class="popular-format" href="{{ route('home', ['convert' => 'jpg-to-gif']) }}">
                    Convert jpg to gif
                </a>
                <br>
                ><a class="popular-format" href="{{ route('home', ['convert' => 'jpg-to-bmp']) }}">
                    Convert jpg to bmp
                </a>
                <br>
                ><a class="popular-format" href="{{ route('home', ['convert' => 'png-to-jpg']) }}">
                    Convert png to jpg
                </a>
                <br>
                ><a class="popular-format" href="{{ route('home', ['convert' => 'png-to-gif']) }}">
                    Convert png to gif
                </a>
                <br>
                ><a class="popular-format" href="{{ route('home', ['convert' => 'png-to-bmp']) }}">
                    Convert png to bmp
                </a>
            </div>
            <div class="text-blue-500">
                ><a class="popular-format" href="{{ route('home', ['convert' => 'gif-to-jpg']) }}">
                    Convert gif to jpg
                </a>
                <br>
                ><a class="popular-format" href="{{ route('home', ['convert' => 'gif-to-png']) }}">
                    Convert gif to png
                </a>
                <br>
                ><a class="popular-format" href="{{ route('home', ['convert' => 'gif-to-bmp']) }}">
                    Convert gif to bmp
                </a>
                <br>
                ><a class="popular-format" href="{{ route('home', ['convert' => 'bmp-to-jpg']) }}">
                    Convert bmp to jpg
                </a>
                <br>
                ><a class="popular-format" href="{{ route('home', ['convert' => 'bmp-to-png']) }}">
                    Convert bmp to png
                </a>
                <br>
                ><a class="popular-format" href="{{ route('home', ['convert' => 'bmp-to-gif']) }}">
                    Convert bmp to gif
                </a>
            </div>
        </div>
    </div>

    {{-- bottom add --}}
    @if ($bottom_add && $bottom_add->status == 1)
        @if ($bottom_add->type == 1)
            {!! $bottom_add->code_body !!}
        @else
            <a href="{{ $bottom_add->img_url }}" class="flex justify-center">
                <img src="{{ $bottom_add->img }}">
            </a>
        @endif
    @endif
@endsection

@push('script')
    <script>
        function loadRecentImages() {
            $.ajax({
                url: "{{ route('recent.images') }}",
                success(response) {
                    $('#recent-button-section')
                        .addClass("rounded border border-gray-200")
                        .html(response);
                }
            });
        }
    </script>

    <script>
        const rangeSlider = document.getElementById("large-range");
        const rangeValueElement = document.getElementById("range-value");

        // Function to update the range value display
        function updateRangeValue() {
            const newValue = rangeSlider.value;
            const newPosition = (rangeSlider.offsetWidth - 28) * (newValue - rangeSlider.min) / (rangeSlider.max -
                rangeSlider.min);
            rangeValueElement.innerText = newValue;
            rangeValueElement.style.left = newPosition + "px";
        }

        // Call the function to update the display initially
        updateRangeValue();

        // Add an event listener to listen for changes in the range slider value
        rangeSlider.addEventListener("input", updateRangeValue);
    </script>

    <script type="text/javascript">
        Dropzone.options.imageUpload = {
            maxFilesize: 2,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            init: function() {
                var uploadedImages = [];
                var uploadedImagesName = [];

                this.on("success", function(file, response) {
                    if (response && response.file_path) {
                        uploadedImages.push(response.file_path);
                        uploadedImagesName.push(response.file_name);

                        document.getElementById("uploaded-images").value = JSON.stringify(uploadedImages);
                        document.getElementById("uploaded-images-name").value = JSON.stringify(
                            uploadedImagesName);

                        document.getElementById("from-format").classList.remove("hidden");
                        document.getElementById("from-select").innerHTML = response.file_extension;
                        document.getElementById("to-text").classList.remove("hidden");
                    }
                });
            },
        };
    </script>
@endpush
