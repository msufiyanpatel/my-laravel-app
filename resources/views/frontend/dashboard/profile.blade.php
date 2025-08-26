@extends('frontend.master')

@section('content')
    <section class="max-w-screen-xl mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8">
        <div class="w-full mx-auto mt-2">
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">

                @include('frontend.dashboard.user-nav')

                <div class="block w-full overflow-x-auto">

                    <!-- This is an example component -->

                    <div class="p-8">
                        <form action="{{ route('frontend.user.profile') }}" method="post">
                            @csrf
                            <div class="mt-8 grid lg:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="text-sm text-gray-700 block mb-1 font-medium">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="bg-gray-100 border border-gray-200 rounded py-1 px-3 block focus:ring-blue-500 focus:border-blue-500 text-gray-700 w-full"
                                        placeholder="Enter your name" value="{{ $user->name }}" />
                                </div>
                                <div>
                                    <label for="email" class="text-sm text-gray-700 block mb-1 font-medium">
                                        Email Adress
                                    </label>
                                    <input type="email" name="email" id="email"
                                        class="bg-gray-100 border border-gray-200 rounded py-1 px-3 block focus:ring-blue-500 focus:border-blue-500 text-gray-700 w-full"
                                        placeholder="yourmail@provider.com" value="{{ $user->email }}" />
                                </div>
                            </div>
                            <p class="text-gray-600 mt-6">Change Password</p>
                            <div class="mt-8 grid lg:grid-cols-2 gap-4">
                                <div class="{{ $user->is_google_registered ? 'hidden' : '' }}">
                                    <label for="job" class="text-sm text-gray-700 block mb-1 font-medium">
                                        Current Password
                                    </label>
                                    <input type="password" id="current_password"
                                        class="bg-gray-100 border border-gray-200 rounded py-1 px-3 block focus:ring-blue-500 focus:border-blue-500 text-gray-700 w-full"
                                        placeholder="Enter your password" name="current_password"
                                        autocomplete="new-password" />
                                </div>
                                <div>
                                    <label for="new_password" class="text-sm text-gray-700 block mb-1 font-medium">
                                        New Password
                                    </label>
                                    <input type="password" id="new_password"
                                        class="bg-gray-100 border border-gray-200 rounded py-1 px-3 block focus:ring-blue-500 focus:border-blue-500 text-gray-700 w-full"
                                        placeholder="Confirm password" name="password" />
                                </div>

                            </div>
                            <div class="space-x-4 mt-8 flex justify-center">
                                <button type="submit"
                                    class="py-2 px-4 font-semibold bg-blue-500 text-white rounded-lg hover:bg-blue-600 active:bg-blue-700 disabled:opacity-50">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection

@push('script')
@endpush
