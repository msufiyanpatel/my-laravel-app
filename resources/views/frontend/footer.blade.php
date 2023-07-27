<!-- Foooter -->
<section class="bg-gray-300">
    <div class="max-w-screen-xl px-4 py-12 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8">
        <div class="flex justify-center mt-8 space-x-6">
            @if (readConfig('facebook_link'))
                <a href="{{ readConfig('facebook_link') }}" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Facebook</span>
                    <img class="w-6 h-6" src="{{ asset('assets/images/icon/facebook-logo.svg') }}" alt="logo">
                </a>
            @endif
            @if (readConfig('instagram_link'))
                <a href="{{ readConfig('instagram_link') }}" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Instagram</span>
                    <img class="w-6 h-6" src="{{ asset('assets/images/icon/instagram-logo.svg') }}" alt="logo">
                </a>
            @endif
            @if (readConfig('twitter_link'))
                <a href="{{ readConfig('twitter_link') }}" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Twitter</span>
                    <img class="w-6 h-6" src="{{ asset('assets/images/icon/twitter-logo.svg') }}" alt="logo">
                </a>
            @endif
            @if (readConfig('youtube_link'))
                <a href="{{ readConfig('youtube_link') }}" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Youtube</span>
                    <img class="w-6 h-6" src="{{ asset('assets/images/icon/youtube-logo.svg') }}" alt="logo">
                </a>
            @endif
            @if (readConfig('linkedin_link'))
                <a href="{{ readConfig('linkedin_link') }}" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Linkedin</span>
                    <img class="w-6 h-6" src="{{ asset('assets/images/icon/linkedin-logo.svg') }}" alt="logo">
                </a>
            @endif
            @if (readConfig('pinterest_link'))
                <a href="{{ readConfig('pinterest_link') }}" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Pinterest</span>
                    <img class="w-6 h-6" src="{{ asset('assets/images/icon/pinterest-logo.svg') }}" alt="logo">
                </a>
            @endif
            @if (readConfig('whatsapp_link'))
                <a href="{{ readConfig('whatsapp_link') }}" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Whatsapp</span>
                    <img class="w-6 h-6" src="{{ asset('assets/images/icon/whatsapp-logo.svg') }}" alt="logo">
                </a>
            @endif
            @if (readConfig('snapchat_link'))
                <a href="{{ readConfig('snapchat_link') }}" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Snapchat</span>
                    <img class="w-6 h-6" src="{{ asset('assets/images/icon/snapchat-logo.svg') }}" alt="logo">
                </a>
            @endif
            @if (readConfig('tumblr_link'))
                <a href="{{ readConfig('tumblr_link') }}" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Tumblr</span>
                    <img class="w-6 h-6" src="{{ asset('assets/images/icon/tumblr-logo.svg') }}" alt="logo">
                </a>
            @endif
        </div>
        <p class="mt-8 text-base leading-6 text-center text-black">
            © 2023 {{ readConfig('site_name') }}. All rights reserved.
        </p>
    </div>
</section>
