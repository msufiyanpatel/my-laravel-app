@extends('backend.master')

@section('title', 'General Settings')

@section('content')

    <div class="row">
        <div class="col-4 col-sm-2">
            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link {{ @$_GET['active-tab'] == 'website-info' ? 'active' : '' }}" id="vert-tabs-1"
                    data-toggle="pill" href="#tabs-1" role="tab" aria-controls="tabs-1" aria-selected="true">
                    <i class="fas fa-desktop"></i>
                    &nbsp;Website Info
                </a>
                <a class="nav-link {{ @$_GET['active-tab'] == 'social-links' ? 'active' : '' }}" id="vert-tabs-3"
                    data-toggle="pill" href="#tabs-3" role="tab" aria-controls="tabs-3" aria-selected="false">
                    <i class="fas fa-share-alt"></i>
                    &nbsp;Social Links
                </a>
                <a class="nav-link {{ @$_GET['active-tab'] == 'style-settings' ? 'active' : '' }}" id="vert-tabs-4"
                    data-toggle="pill" href="#tabs-4" role="tab" aria-controls="tabs-4" aria-selected="false">
                    <i class="fas fa-swatchbook"></i>
                    &nbsp;Style Settings
                </a>
                <a class="nav-link {{ @$_GET['active-tab'] == 'custom-css' ? 'active' : '' }}" id="vert-tabs-5"
                    data-toggle="pill" href="#tabs-5" role="tab" aria-controls="tabs-5" aria-selected="false">
                    <i class="fas fa-code"></i>
                    &nbsp;Custom CSS
                </a>
                <a class="nav-link {{ @$_GET['active-tab'] == 'google-analytics' ? 'active' : '' }}" id="vert-tabs-6"
                    data-toggle="pill" href="#tabs-6" role="tab" aria-controls="tabs-6" aria-selected="false">
                    <i class="far fa-chart-bar"></i>
                    &nbsp;Google Analytics
                </a>
                <a class="nav-link {{ @$_GET['active-tab'] == 'google-sign-up' ? 'active' : '' }}" id="vert-tabs-7"
                    data-toggle="pill" href="#tabs-7" role="tab" aria-controls="tabs-7" aria-selected="false">
                    <i class="fab fa-google"></i>
                    &nbsp;Google Sign up
                </a>
            </div>
        </div>
        <div class="col-8 col-sm-10">
            <div class="tab-content" id="vert-tabs-tabContent">
                <div class="tab-pane fade {{ @$_GET['active-tab'] == 'website-info' ? 'active show' : '' }}" id="tabs-1"
                    role="tabpanel" aria-labelledby="vert-tabs-1">

                    <form action="{{ route('backend.admin.settings.website.info.update') }}" method="post">
                        @csrf
                        <div class="col-md-12 d-flex justify-content-between">
                            <h5>
                                <i class="fas fa-desktop"></i>
                                &nbsp;&nbsp;Website Info
                            </h5>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-reply"></i>
                                &nbsp;Save Changes
                            </button>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Website Title</label>
                                <input class="form-control" name="site_name" type="text"
                                    value="{{ readConfig('site_name') }}" placeholder="Enter Site Title">
                            </div>
                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea class="form-control" rows="2" name="meta_description" cols="50"
                                    placeholder="Enter Meta Description">{{ readConfig('meta_description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Meta Keywords</label>
                                <textarea class="form-control" rows="2" name="meta_keywords" cols="50" placeholder="Enter Keywords">{{ readConfig('meta_keywords') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Website URL</label>
                                <input class="form-control" name="site_url" type="url"
                                    value="{{ readConfig('site_url') }}" placeholder="Enter Site URL">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="tab-pane fade {{ @$_GET['active-tab'] == 'social-links' ? 'active show' : '' }}" id="tabs-3"
                    role="tabpanel" aria-labelledby="vert-tabs-3">
                    <form action="{{ route('backend.admin.settings.website.social.link.update') }}" method="post">
                        @csrf
                        <div class="col-md-12 d-flex justify-content-between">
                            <h5>
                                <i class="fas fa-share-alt"></i>
                                &nbsp;&nbsp;Social Links
                            </h5>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-reply"></i>
                                &nbsp;Save Changes
                            </button>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    <i class="fab fa-facebook"></i>
                                    &nbsp; Facebook
                                </label>
                                <input placeholder="Facebook" class="form-control" name="facebook_link" type="url"
                                    value="{{ readConfig('facebook_link') }}">
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fab fa-twitter"></i>
                                    &nbsp; Twitter
                                </label>
                                <input placeholder="Twitter" class="form-control" name="twitter_link" type="url"
                                    value="{{ readConfig('twitter_link') }}">
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fab fa-linkedin"></i>
                                    &nbsp; Linkedin
                                </label>
                                <input placeholder="Linkedin" class="form-control" name="linkedin_link" type="url"
                                    value="{{ readConfig('linkedin_link') }}">
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fab fa-youtube"></i>
                                    &nbsp; Youtube
                                </label>
                                <input placeholder="Youtube" class="form-control" name="youtube_link" type="url"
                                    value="{{ readConfig('youtube_link') }}">
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fab fa-instagram"></i>
                                    &nbsp; Instagram
                                </label>
                                <input placeholder="Instagram" class="form-control" name="instagram_link" type="url"
                                    value="{{ readConfig('instagram_link') }}">
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fab fa-pinterest"></i>
                                    &nbsp; Pinterest
                                </label>
                                <input placeholder="Pinterest" class="form-control" name="pinterest_link" type="url"
                                    value="{{ readConfig('pinterest_link') }}">
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fab fa-tumblr"></i>
                                    &nbsp; Tumblr
                                </label>
                                <input placeholder="Tumblr" class="form-control" name="tumblr_link" type="url"
                                    value="{{ readConfig('tumblr_link') }}">
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fab fa-snapchat"></i>
                                    &nbsp; Snapchat
                                </label>
                                <input placeholder="Snapchat" class="form-control" name="snapchat_link" type="url"
                                    value="{{ readConfig('snapchat_link') }}">
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fab fa-whatsapp"></i>
                                    &nbsp; Whatsapp
                                </label>
                                <input placeholder="Whatsapp" class="form-control" name="whatsapp_link" type="url"
                                    value="{{ readConfig('whatsapp_link') }}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade {{ @$_GET['active-tab'] == 'style-settings' ? 'active show' : '' }}"
                    id="tabs-4" role="tabpanel" aria-labelledby="vert-tabs-4">

                    <form action="{{ route('backend.admin.settings.website.style.settings.update') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 d-flex justify-content-between">
                            <h5>
                                <i class="fas fa-swatchbook"></i>
                                &nbsp;&nbsp;Style Settings
                            </h5>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-reply"></i>
                                &nbsp;Save Changes
                            </button>
                        </div>

                        <div class="col-12 my-2">
                            <label>Site Logo</label>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-12 box p-a-xs text-center">
                                        <img src="{{ assetImage(readconfig('site_logo')) }}"
                                            class="img-fluid thumbnail-preview site-logo-placeholder">
                                    </div>
                                </div>
                            </div>
                            <input class="form-control" accept="image/*" name="site_logo" type="file"
                                onchange="previewThumbnail(this)">
                            <small>
                                <i class="far fa-question-circle"></i>
                                ( 260x60 px ) - Extensions: .png, .jpg, .jpeg, .gif, .svg
                            </small>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="style_fav">Favicon</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 box p-a-xs text-center">
                                            <a target="_blank" href="{{ assetImage(readconfig('favicon_icon')) }}">
                                                <img src="{{ assetImage(readconfig('favicon_icon')) }}"
                                                    class="img-fluid thumbnail-preview site-logo-placeholder">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <input class="form-control" accept="image/*" name="favicon_icon" type="file"
                                    onchange="previewThumbnail(this)">
                                <small>
                                    <i class="far fa-question-circle"></i>
                                    ( 32x32 px ) - Extensions: .png, .jpg, .jpeg, .gif, .svg
                                </small>
                            </div>
                            <div class="col-sm-6">
                                <label for="style_apple">Apple Icon</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 box p-a-xs text-center">
                                            <a target="_blank" href="{{ assetImage(readconfig('favicon_icon_apple')) }}">
                                                <img src="{{ assetImage(readconfig('favicon_icon_apple')) }}"
                                                    class="img-fluid thumbnail-preview site-logo-placeholder">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <input class="form-control" accept="image/*" name="favicon_icon_apple" type="file"
                                    onchange="previewThumbnail(this)">
                                <small>
                                    <i class="far fa-question-circle"></i>
                                    ( 180x180 px ) - Extensions: .png, .jpg, .jpeg, .gif, .svg
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade {{ @$_GET['active-tab'] == 'custom-css' ? 'active show' : '' }}" id="tabs-5"
                    role="tabpanel" aria-labelledby="vert-tabs-5">
                    <form action="{{ route('backend.admin.settings.website.custom.css.update') }}" method="post">
                        @csrf
                        <div class="col-md-12 d-flex justify-content-between">
                            <h5>
                                <i class="fas fa-code"></i>
                                &nbsp;&nbsp;Custom CSS
                            </h5>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-reply"></i>
                                &nbsp;Save Changes
                            </button>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="form-group">
                                <textarea placeholder="" class="form-control" rows="17" name="custom_css" cols="50">{{ readConfig('custom_css') }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade {{ @$_GET['active-tab'] == 'google-analytics' ? 'active show' : '' }}"
                    id="tabs-6" role="tabpanel" aria-labelledby="vert-tabs-6">
                    <form action="{{ route('backend.admin.settings.website.google.analytics.update') }}" method="post">
                        @csrf
                        <div class="col-md-12 d-flex justify-content-between">
                            <h5>
                                <i class="far fa-chart-bar"></i>
                                &nbsp;&nbsp;Google Analytics
                            </h5>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-reply"></i>
                                &nbsp;Save Changes
                            </button>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="google_analytics_status">Status</label>
                                    <div class="form-group">
                                        <div
                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input"
                                                id="google_analytics_status" name="google_analytics_status"
                                                {{ readConfig('google_analytics_status') == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="google_analytics_status">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="google_analytics_type">Type</label>
                                    <div class="form-group">
                                        <select name="google_analytics_type" id="google_analytics_type"
                                            class="form-control">
                                            <option value="id"
                                                {{ readConfig('google_analytics_type') == 'id' ? 'selected' : '' }}>
                                                ID
                                            </option>
                                            <option value="code"
                                                {{ readConfig('google_analytics_type') == 'code' ? 'selected' : '' }}>
                                                Code
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 {{ readConfig('google_analytics_type') || !readConfig('google_analytics_type') == 'id' ? '' : 'd-none' }}"
                            id="google_analytics_id_section">
                            <label for="">Container Id</label>
                            <div class="form-group">
                                <input type="text" name="google_analytics_id" class="form-control"
                                    value="{{ readConfig('google_analytics_id') }}">
                            </div>
                        </div>
                        <div class="col-md-12 {{ readConfig('google_analytics_type') == 'code' ? '' : 'd-none' }}"
                            id="google_analytics_code_section">
                            <label for="">Or you can paste your Google code directly here</label>
                            <div class="form-group">
                                <textarea placeholder="" class="form-control" rows="17" name="google_analytics_code" cols="50">{{ readConfig('google_analytics_code') }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade {{ @$_GET['active-tab'] == 'google-sign-up' ? 'active show' : '' }}"
                    id="tabs-7" role="tabpanel" aria-labelledby="vert-tabs-7">
                    <form action="{{ route('backend.admin.settings.website.google.sign.up.update') }}" method="post">
                        @csrf
                        <div class="col-md-12 d-flex justify-content-between">
                            <h5>
                                <i class="fab fa-google"></i>
                                &nbsp;&nbsp;Google Sign up
                            </h5>
                            <button type="submit" class="btn bg-gradient-primary">
                                <i class="fas fa-reply"></i>
                                &nbsp;Save Changes
                            </button>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="google_sign_up_status">Status</label>
                            <div class="form-group">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="google_sign_up_status"
                                        name="google_sign_up_status"
                                        {{ readConfig('google_sign_up_status') == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="google_sign_up_status">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="">Google Client ID</label>
                            <div class="form-group">
                                <input type="text" name="google_client_id" class="form-control"
                                    value="{{ readConfig('google_client_id') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="">Google Client Secret</label>
                            <div class="form-group">
                                <input type="text" name="google_client_secret" class="form-control"
                                    value="{{ readConfig('google_client_secret') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted">
                                [N.B: Add this redirection url "<span
                                    class="text-primary">{{ readConfig('site_url') }}/auth/google/callback</span>" to your
                                google api Authorized redirect URIs section.]
                            </p>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('input[type=radio][name=is_live]').on("change", function() {
            if (this.value == '0') {
                $("#close_msg_div").removeClass('d-none');
            } else {
                $("#close_msg_div").addClass('d-none');
            }
        });

        $("#google_analytics_type").on('change', function() {
            if (this.value == 'id') {
                $("#google_analytics_id_section").removeClass("d-none");
                $("#google_analytics_code_section").addClass("d-none");
            } else {
                $("#google_analytics_id_section").addClass("d-none");
                $("#google_analytics_code_section").removeClass("d-none");
            }
        });
    </script>
@endpush
