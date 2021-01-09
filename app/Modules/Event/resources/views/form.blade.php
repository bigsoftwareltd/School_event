<div class="card-body" id="photo_section">
    <div class="row">
        <div class="col-md-6">
            {{-- name --}}
            <div class="form-group">
                <label for="event_name" class="form-label"> Event Name <span class='required-star'></span></label>
                <input id="event_name" type="text" required class="form-control{{ $errors->has('event_name') ? ' is-invalid' : '' }}" name="name" value="{{ old('event_name', optional($event)->event_name) }}" autofocus>

                @if ($errors->has('event_name'))
                    <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('event_name') }}</strong>
                                                </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            {{-- date of birth --}}
            <div class="form-group">
                <label for="date_of_birth" class="form-label">Date</label>

                <input id="date_of_birth" type="text" data-select="datepicker"
                       class=" form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}"
                       name="date_of_birth"
                       value="{{ old('date_of_birth', (!empty($user->date_of_birth) ? CommonFunction::dateShow($user->date_of_birth) : null)) }}">

                @if ($errors->has('date_of_birth'))
                    <span class="invalid-feedback">
                                                <strong>{{ $errors->first('date_of_birth') }}</strong>
                                            </span>
                @endif
            </div>
        </div>

    </div>







    <div class="row" >

        <div class="col-md-6"  >
            <div class="form-group">
                <label for="photo" class="form-label">Photo</label>

                <div class="input-group mb-1" >
                    <div class="custom-file">
                        <input type="file" value="{{ optional($event)->photo }}" name="photo[]" multiple id="photo" class="form-control-file{{ $errors->has('photo') ? ' is-invalid' : '' }}" accept="image/jpeg, image/png" onchange="imageUpload(this, 'show_photo')">
                        <label class="custom-file-label" for="photo">Choose file</label>
                    </div>
                </div>
                <button class="btn btn-info" role="button" onclick="addphotorow()">Add</button>




                @if ($errors->has('photo'))
                    <span style="display:block;" class="invalid-feedback">
                                                <strong>{{ $errors->first('photo') }}</strong>
                                            </span>
                @endif

                {{--Show image--}}

            </div>
            <small id="emailHelp" class="form-text text-muted">
                File Format: *.jpg/ .png | Max file size: 3MB
            </small>

        </div>
        <div class="col-md-6">
            <div class="mb-1 first">
                {!! CommonFunction::getImageFromURL(optional($event)->photo, '', 'show_photo') !!}
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <a href="{{ route('view-gallery') }}">
        <button type="button" class="btn btn-danger">Close</button>
    </a>
    <button type="submit" class="btn btn-info float-right">Submit</button>
</div>
