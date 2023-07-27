@extends('frontend.master')

@section('content')
    <section class="py-1">
        <div class="w-full px-4 mx-auto mt-2">
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white ">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex justify-center">
                        <h3 class="font-semibold text-base text-gray-700">
                            Convert History
                        </h3>
                    </div>
                </div>

                <div class="block w-full overflow-x-auto">
                    <table class="items-center w-full text-gray-700">
                        <thead class="thead-light">
                            <tr>
                                <th
                                    class="bg-gray-50 text-gray-500 align-middle border border-solid border-gray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                    Sl
                                </th>
                                <th
                                    class="bg-gray-50 text-gray-500 align-middle border border-solid border-gray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                    Date/Time
                                </th>
                                <th
                                    class="bg-gray-50 text-gray-500 align-middle border border-solid border-gray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left pl-5">
                                    Files
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history as $key => $data)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <th class="border-t-0 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                        {{ date('d M, Y', strtotime($data->created_at)) }}
                                    </th>
                                    <td
                                        class="border-t-0 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 ">
                                        <ul class="list-disc px-5">
                                            @foreach ($data->items as $key => $value)
                                                <li class="p-1">
                                                    <a href="{{ $value['file_url'] }}" target="_blank"
                                                        title="Download: {{ $value['file_name'] }}">
                                                        {{ $value['file_name'] }}
                                                    </a>
                                                    <a href="{{ $value['file_url'] }}" target="_blank"
                                                        download="{{ $value['file_name'] }}" title="Download"
                                                        class="bg-sky-400 hover:bg-blue-500 text-white text-sm py-1 px-1  rounded">
                                                        Download
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('script')
@endpush
