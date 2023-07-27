@extends('backend.master')

@section('title', 'Adds Manager')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('backend.admin.adds.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <h4 class="fw-500">Top ad</h4>
                <div class="mb-5 border bg-light rounded-1 p-3">
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <div class="fs-5 form-check-label me-3 flex-grow-1">
                                <select class="custom-select col-md-2 col-6" name="top_add_type" id="top_add_type">
                                    <option value="1" {{ !$top_add || @$top_add->type == 1 ? 'selected' : '' }}>
                                        Code
                                    </option>
                                    <option value="2" {{ @$top_add->type == 2 ? 'selected' : '' }}>
                                        Image
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="top_add_btn"
                                        name="top_add_status" {{ @$top_add->status ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="top_add_btn">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="top_add_code_field" class="{{ @$top_add->type == 2 ? 'd-none' : '' }}">
                        <label for="top-add-code" class="fs-5 form-label">Code</label>
                        <textarea class="form-control" name="top_add_code" id="top_add_code" rows="12">{{ @$top_add->code_body }}</textarea>
                    </div>
                    <div id="top_add_image_field" class="{{ !$top_add || @$top_add->type == 1 ? 'd-none' : '' }}">
                        <div class="form-group">
                            <label for="top_add_img" class="form-label">
                                Image:
                                <small>[630 x 1200 px]</small>
                            </label>

                            <input type="file" class="form-control" name="top_add_img" id="top_add_img"
                                onchange="previewThumbnail(this)">
                            <img class="img-fluid thumbnail-preview mt-2" src="{{ @$top_add->img }}" alt="preview-image">
                        </div>
                        <div class="form-group">
                            <label for="top_add_img_url" class="form-label">
                                Url:
                            </label>

                            <input type="url" placeholder="Enter redirect url..." class="form-control"
                                name="top_add_img_url" id="top_add_img_url" value="{{ @$top_add->img_url }}">
                        </div>
                    </div>
                </div>
                <h4 class="fw-500">Middle ad</h4>
                <div class="mb-5 border bg-light rounded-1 p-3">
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <div class="fs-5 form-check-label me-3 flex-grow-1">
                                <select class="custom-select col-md-2 col-6" name="middle_add_type" id="middle_add_type">
                                    <option value="1" {{ !$middle_add || @$middle_add->type == 1 ? 'selected' : '' }}>
                                        Code
                                    </option>
                                    <option value="2" {{ @$middle_add->type == 2 ? 'selected' : '' }}>
                                        Image
                                    </option>
                                </select>
                            </div>
                            <div class="form-check form-switch">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="middle_add_btn"
                                        name="middle_add_status" {{ @$middle_add->status ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="middle_add_btn">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="middle_add_code_field" class="{{ @$middle_add->type == 2 ? 'd-none' : '' }}">
                        <label for="middle-add-code" class="fs-5 form-label">Code</label>
                        <textarea class="form-control" name="middle_add_code" id="middle-add-code" rows="12">{{ @$middle_add->code_body }}</textarea>
                    </div>

                    <div id="middle_add_image_field" class="{{ !$middle_add || @$middle_add->type == 1 ? 'd-none' : '' }}">
                        <div class="form-group">
                            <label for="middle_add_img" class="form-label">
                                Image:
                                <small>[630 x 1200 px]</small>
                            </label>

                            <input type="file" class="form-control" name="middle_add_img" id="middle_add_img"
                                onchange="previewThumbnail(this)">
                            <img class="img-fluid thumbnail-preview mt-2" src="{{ @$middle_add->img }}"
                                alt="preview-image">
                        </div>
                        <div class="form-group">
                            <label for="middle_add_img_url" class="form-label">
                                Url:
                            </label>

                            <input type="url" placeholder="Enter redirect url..." class="form-control"
                                name="middle_add_img_url" id="middle_add_img_url" value="{{ @$middle_add->img_url }}">
                        </div>
                    </div>
                </div>
                <h4 class="fw-500">Bottom ad</h4>
                <div class="mb-5 border bg-light rounded-1 p-3">
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <div class="fs-5 form-check-label me-3 flex-grow-1">
                                <select class="custom-select col-md-2 col-6" name="bottom_add_type" id="bottom_add_type">
                                    <option value="1"
                                        {{ !$bottom_add || @$bottom_add->type == 1 ? 'selected' : '' }}>
                                        Code
                                    </option>
                                    <option value="2" {{ @$bottom_add->type == 2 ? 'selected' : '' }}>
                                        Image
                                    </option>
                                </select>
                            </div>
                            <div class="form-check form-switch">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="bottom_add_btn"
                                        name="bottom_add_status" {{ @$bottom_add->status ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="bottom_add_btn">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="bottom_add_code_field" class="{{ @$bottom_add->type == 2 ? 'd-none' : '' }}">
                        <label for="footer-ad-code" class="fs-5 form-label">Code</label>
                        <textarea class="form-control" name="bottom_add_code" id="footer-ad-code" rows="12">{{ @$bottom_add->code_body }}</textarea>
                    </div>

                    <div id="bottom_add_image_field"
                        class="{{ !$bottom_add || @$bottom_add->type == 1 ? 'd-none' : '' }}">
                        <div class="form-group">
                            <label for="bottom_add_img" class="form-label">
                                Image:
                                <small>[630 x 1200 px]</small>
                            </label>

                            <input type="file" class="form-control" name="bottom_add_img" id="bottom_add_img"
                                onchange="previewThumbnail(this)">
                            <img class="img-fluid thumbnail-preview mt-2" src="{{ @$bottom_add->img }}"
                                alt="preview-image">
                        </div>
                        <div class="form-group">
                            <label for="bottom_add_img_url" class="form-label">
                                Url:
                            </label>

                            <input type="url" placeholder="Enter redirect url..." class="form-control"
                                name="bottom_add_img_url" id="bottom_add_img_url"
                                value="{{ @$bottom_add->img_url }}">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-block bg-gradient-primary">
                    Update
                </button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $("#top_add_type").on('change', function() {
            if (this.value == 1) {
                $("#top_add_code_field").removeClass("d-none");
                $("#top_add_image_field").addClass("d-none");
            } else {
                $("#top_add_code_field").addClass("d-none");
                $("#top_add_image_field").removeClass("d-none");
            }
        });
        $("#middle_add_type").on('change', function() {
            if (this.value == 1) {
                $("#middle_add_code_field").removeClass("d-none");
                $("#middle_add_image_field").addClass("d-none");
            } else {
                $("#middle_add_code_field").addClass("d-none");
                $("#middle_add_image_field").removeClass("d-none");
            }
        });
        $("#bottom_add_type").on('change', function() {
            if (this.value == 1) {
                $("#bottom_add_code_field").removeClass("d-none");
                $("#bottom_add_image_field").addClass("d-none");
            } else {
                $("#bottom_add_code_field").addClass("d-none");
                $("#bottom_add_image_field").removeClass("d-none");
            }
        });
    </script>
@endpush
