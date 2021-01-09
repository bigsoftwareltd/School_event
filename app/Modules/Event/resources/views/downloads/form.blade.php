<div class="card-body" id="photo_section">
    <div class="row">
        <div class="col-md-6">
            {{-- name --}}
            <div class="form-group">
                <label for="document_name" class="form-label"> Document Name <span class='required-star'></span></label>
                <input id="document_name" type="text" required class="form-control{{ $errors->has('document_name') ? ' is-invalid' : '' }}" name="document_name" value="{{ old('document_name', optional($downloads)->document_name) }}" autofocus>

                @if ($errors->has('document_name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('document_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            {{-- date of birth --}}
            <div class="form-group">
                <label for="date" class="form-label">Date</label>

                <input id="date" type="text" data-select="datepicker"
                       class=" form-control{{ $errors->has('date') ? ' is-invalid' : '' }}"
                       name="date"
                       value="{{ old('date', (!empty($downloads->date) ? CommonFunction::dateShow($downloads->date) : null)) }}">

                @if ($errors->has('date'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('date') }}</strong>
                    </span>
                @endif
            </div>
        </div>

    </div>
    <input type="hidden" value="" name="document_id" id="document_id">
    <div class="row" >

        <div class="col-md-6"  >
            <div class="form-group">
                <label for="file" class="form-label">File/Documents</label>

                <div class="input-group mb-1" >
                    <div class="custom-file">
                        <input type="file" value="{{ optional($downloads)->file }}" name="file" id="file" class="form-control-file{{ $errors->has('file') ? ' is-invalid' : '' }}" onchange="fileUpload(this)" >
                        <label class="custom-file-label" for="file">Choose file</label>
                    </div>
                </div>




                @if ($errors->has('file'))
                    <span style="display:block;" class="invalid-feedback">
                        <strong>{{ $errors->first('file') }}</strong>
                    </span>
                @endif

                {{--Show image--}}

            </div>
            <small id="emailHelp" class="form-text text-muted">
                File Format: *.doc/.docx,.ppt/.pptx,.xls/.xlsx,.txt | Max file size: 5MB
            </small>

        </div>
        <div class="col-md-6">
            <div class="mb-1 first">

            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-info float-right">Submit</button>
</div>
