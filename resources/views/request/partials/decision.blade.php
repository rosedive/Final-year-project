{!! Form::open(['route' => 'request.update', 'id' => 'request-form']) !!}
<hr>
<h5>{{Auth::user()->role->display_name}} decision</h5>
<hr>

<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="hod">Decision</label>
        </div>
    </div>
    <div class="col-md-8">
        <input type="hidden" name="request_id" value="{{$res['request_id']}}">
        <div class="form-group">
            <select name="decision" class="form-control" id="decision">
                <option value="">--select--</option>
                <option value="1">Cleared</option>
                <option value="3">Refused</option>
            </select>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="message" id="message" 
                placeholder="Message"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Update
        </button>
    </div>
</div>
{!! Form::close() !!}