<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="department">Department</label>
            <select class="form-control" id="department" name="department_id">
                <option value="">--select--</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ $edit && $department->id == $user->department_id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="option">Option</label>
            <select class="form-control" id="option" name="option_id">
                @if($edit)
                    <option value="">--select--</option>
                    @foreach($options as $option)
                        <option value="{{ $option->id }}" {{ $edit && $option->id == $user->option_id ? 'selected' : '' }}>
                            {{ $option->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="program">Program</label>
            <select class="form-control" id="program" name="program">
                <option value="Day" {{ $edit && $user->program =='Day' ? 'selected' : '' }}>
                    Day
                </option>
                <option value="Evening" {{ $edit && $user->program =='Evening' ? 'selected' : '' }}>
                    Evening
                </option>
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="sponsorship">Sponsorship</label>
            <select class="form-control" id="sponsorship" name="sponsorship">
                <option value="">--select</option>
                <option value="Goverment Sponsored" {{ $edit && $user->sponsorship =='Goverment Sponsored' ? 'selected' : '' }}>
                    Goverment Sponsored
                </option>
                <option value="Private Sponsored" {{ $edit && $user->sponsorship =='Private Sponsored' ? 'selected' : '' }}>
                    Private Sponsored
                </option>
            </select>
        </div>
    </div>
</div>

@if ($edit)
    <button type="submit" class="btn btn-primary mt-2" id="update-login-details-btn">
        <i class="fa fa-refresh"></i>
        Update Details
    </button>
@endif