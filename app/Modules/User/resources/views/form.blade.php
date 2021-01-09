<div class="card-body" style="font-family: Roboto">
    <div class="row">
        <div class="col-md-4">
            {{--            {{name}}--}}
            <div class="form-group">
                <label for="name" class="form-label">Name <span class='required-star'></span></label>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                       name="name" value="{{ old('name', optional($user)->name) }}" autofocus>

            </div>
        </div>
        <div class="col-md-4">
            {{--            {{name}}--}}
            <div class="form-group">
                <label for="username" class="form-label">User Name <span class='required-star'></span></label>
                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                       name="username" value="{{ old('name', optional($user)->username) }}" autofocus>

            </div>
        </div>
        <div class="col-md-4">
            {{-- email --}}
            <div class="form-group">
                <label for="email" class="form-label">E-mail <span class='required-star'></span></label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                       name="email" value="{{ old('email', optional($user)->email) }}">

                {{--                @if ($errors->has('email'))--}}
                {{--                    <span class="invalid-feedback">--}}
                {{--                        <strong>{{ $errors->first('email') }}</strong>--}}
                {{--                    </span>--}}
                {{--                @endif--}}
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-4">
            {{-- email --}}
            <div class="form-group">
                <label for="user_type" class="form-label"> User Type <span class='required-star'></span></label>
                <select class="form-control" name="user_type">
                    <option selected disabled>Select User Type</option>
                    <?php if($user!=null){ ?>
                    <option value="Admin" <?php if($user->user_type == "Admin"){echo "selected";} ?>>Admin</option>
                    <option value="User" <?php if($user->user_type == "User"){echo "selected";} ?>>User</option>
                    <option value="team_manager" <?php if($user->team_manager == "team_manager"){echo "selected";} ?>>Team Manager</option>
                    <?php }else{ ?>
                    <option value="Admin" >Admin</option>
                    <option value="User" >User</option>
                    <option value="team_manager">Team Manager</option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            {{-- email --}}
            <div class="form-group">
                <label for="password" class="form-label">Password <span class='required-star'></span></label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                       name="password" value="">

                {{--                @if ($errors->has('email'))--}}
                {{--                    <span class="invalid-feedback">--}}
                {{--                        <strong>{{ $errors->first('email') }}</strong>--}}
                {{--                    </span>--}}
                {{--                @endif--}}
            </div>
        </div>
        <div class="col-md-4">
            {{-- email --}}
            <div class="form-group">
                <label for="confirm_password" class="form-label">Confirm Password <span class='required-star'></span></label>
                <input id="confirm_password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                       name="confirm_password" value="">

                {{--                @if ($errors->has('email'))--}}
                {{--                    <span class="invalid-feedback">--}}
                {{--                        <strong>{{ $errors->first('email') }}</strong>--}}
                {{--                    </span>--}}
                {{--                @endif--}}
            </div>
        </div>

    </div>




</div>
<div class="card-footer">
    <a href="{{ route('view-user') }}">
        <button type="button" class="btn btn-danger">Close</button>
    </a>
    <button onclick="clientsubmit()" type="submit" class="btn btn-info float-right">Submit</button>
</div>

