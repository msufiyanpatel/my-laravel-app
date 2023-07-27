@extends('frontend.master')

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

    <form action="{{ route('convert') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="bg-white p7 rounded w-9/12 mx-auto my-10 z-0 converter-panel">
            <div x-data="dataFileDnD()" class="relative flex flex-col p-4 text-gray-400 border border-gray-200 rounded">
                <div x-ref="dnd"
                    class="relative flex flex-col text-gray-400 border border-gray-200 border-dashed rounded cursor-pointer">
                    <input accept="*" type="file" multiple name="file[]" required
                        class="absolute inset-0 z-0 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer"
                        @change="addFiles($event)"
                        @dragover="$refs.dnd.classList.add('border-blue-400'); $refs.dnd.classList.add('ring-4'); $refs.dnd.classList.add('ring-inset');"
                        @dragleave="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                        @drop="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                        title="" />

                    <div class="flex flex-col items-center justify-center py-10 text-center">
                        <svg class="w-6 h-6 mr-1 text-current-50" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="m-0">Drag your files here or click in this area.</p>
                    </div>
                </div>

                <template x-if="files.length > 0">
                    <div class="grid grid-cols-2 gap-4 mt-4 md:grid-cols-6" @drop.prevent="drop($event)"
                        @dragover.prevent="$event.dataTransfer.dropEffect = 'move'">
                        <template x-for="(_, index) in Array.from({ length: files.length })">
                            <div class="relative flex flex-col items-center overflow-hidden text-center bg-gray-100 border rounded cursor-move select-none"
                                style="padding-top: 100%;" @dragstart="dragstart($event)" @dragend="fileDragging = null"
                                :class="{ 'border-blue-600': fileDragging == index }" draggable="true"
                                :data-index="index">
                                <button class="absolute top-0 right-0 z-0 p-1 bg-white rounded-bl focus:outline-none"
                                    type="button" @click="remove(index)">
                                    <svg class="w-4 h-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <template x-if="files[index].type.includes('audio/')">
                                    <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                </template>
                                <template x-if="files[index].type.includes('application/') || files[index].type === ''">
                                    <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </template>
                                <template x-if="files[index].type.includes('image/')">
                                    <img class="absolute inset-0 z-0 object-cover w-full h-full border-4 border-white preview"
                                        x-bind:src="loadFile(files[index])" />
                                </template>
                                <template x-if="files[index].type.includes('video/')">
                                    <video
                                        class="absolute inset-0 object-cover w-full h-full border-4 border-white pointer-events-none preview">
                                        <fileDragging x-bind:src="loadFile(files[index])" type="video/mp4">
                                    </video>
                                </template>

                                <div
                                    class="absolute bottom-0 left-0 right-0 flex flex-col p-2 text-xs bg-white bg-opacity-50">
                                    <span class="w-full font-bold text-gray-900 truncate"
                                        x-text="files[index].name">Loading</span>
                                    <span class="text-xs text-gray-900" x-text="humanFileSize(files[index].size)">...</span>
                                </div>

                                <div class="absolute inset-0 z-0 transition-colors duration-300"
                                    @dragenter="dragenter($event)" @dragleave="fileDropping = null"
                                    :class="{ 'bg-blue-200 bg-opacity-80': fileDropping == index && fileDragging != index }">
                                </div>
                            </div>
                        </template>

                    </div>
                </template>
            </div>
            <small class="text-gray-500">[jpg,png,gif,bmp]</small>
        </div>


        <div class="flex justify-center">
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

    </form>

    <!-- Add this right after the form tag -->
    @if (count($downloadLinks) > 0)
        <div class="bg-white p7 rounded w-9/12 mx-auto my-10">
            <div class="relative flex flex-col p-4 text-blue-400 border border-gray-200 rounded">
                <ul class="list-disc px-5">
                    @foreach ($downloadLinks as $key => $data)
                        <li class="p-1">
                            <a href="{{ $data['link'] }}" target="_blank" title="Download: {{ $data['name'] }}">
                                {{ $data['name'] }}
                            </a>
                            <a href="{{ $data['link'] }}" target="_blank" download="{{ $data['name'] }}"
                                title="Download"
                                class="bg-sky-400 hover:bg-blue-500 text-white text-sm py-1 px-1  rounded">
                                Download
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

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
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://unpkg.com/create-file-list"></script>
    <script>
        function dataFileDnD() {
            return {
                files: [],
                fileDragging: null,
                fileDropping: null,
                humanFileSize(size) {
                    const i = Math.floor(Math.log(size) / Math.log(1024));
                    return (
                        (size / Math.pow(1024, i)).toFixed(2) * 1 +
                        " " + ["B", "kB", "MB", "GB", "TB"][i]
                    );
                },
                remove(index) {
                    let files = [...this.files];
                    files.splice(index, 1);

                    this.files = createFileList(files);
                },
                drop(e) {
                    let removed, add;
                    let files = [...this.files];

                    removed = files.splice(this.fileDragging, 1);
                    files.splice(this.fileDropping, 0, ...removed);

                    this.files = createFileList(files);

                    this.fileDropping = null;
                    this.fileDragging = null;
                },
                dragenter(e) {
                    let targetElem = e.target.closest("[draggable]");

                    this.fileDropping = targetElem.getAttribute("data-index");
                },
                dragstart(e) {
                    this.fileDragging = e.target
                        .closest("[draggable]")
                        .getAttribute("data-index");
                    e.dataTransfer.effectAllowed = "move";
                },
                loadFile(file) {
                    const preview = document.querySelectorAll(".preview");
                    const blobUrl = URL.createObjectURL(file);

                    preview.forEach((elem) => {
                        elem.onload = () => {
                            URL.revokeObjectURL(elem.src); // free memory
                        };
                    });

                    return blobUrl;
                },
                addFiles(e) {
                    const files = createFileList([...this.files], [...e.target.files]);
                    this.files = files;
                    this.form.formData.files = [...files];
                },
            };
        }
    </script>
@endpush
