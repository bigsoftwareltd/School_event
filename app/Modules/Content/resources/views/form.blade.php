<div class="card-body" id="photo_section">
    <div class="row" >

        <div class="col-md-12">
            {{-- date of birth --}}
            <div class="form-group">
                    <label for="description">Description</label>

                   <textarea name="description" id="description">
                    {!! old('description', optional($content)->description) !!}
                   </textarea>



            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title"> Content Title</label>
                {{--                Date of birth--}}
                <input id="title" type="text"
                       class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                       name="title"
                       value="{{ old('title', optional($content)->title) }}">
            </div>
            </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="image">Content Image</label>

                <div class="input-group mb-1">
                    <div class="custom-file">
                        <input type="file" value="{{ optional($content)->image }}" name="image" id="image" class="form-control-file{{ $errors->has('image') ? ' is-invalid' : '' }}" accept="image/jpeg, image/png" onchange="imageUpload(this, 'show_photo')">
                        <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                </div>
                <small id="emailHelp" class="form-text text-muted">
                    File Format: *.jpg/ .png | Max file size: 3MB
                </small>
                <div class="mb-1">
                    {{--                    <img class="mb-1" id="photo_preview" height="100" width="100">--}}
                    {!! CommonFunction::getImageFromURL(optional($content)->image, '', 'show_photo') !!}
                </div>
            </div>
    </div>
    <input type="hidden" value="" name="content_id" id="content_id">

</div>
<div class="card-footer">
    <button onclick="contentsubmit()" type="submit" class="btn btn-info float-right">Submit</button>
</div>
