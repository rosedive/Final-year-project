<div class="form-group">
    <label for="email">E-mail</label>
    <input type="email" class="form-control" id="email"
           name="email" placeholder="@lang('app.email')" value="{{ $edit ? $user->email : '' }}">
</div>
<div class="form-group">
    <label for="username">Username or Rego. No if student</label>
    <input type="text" class="form-control" id="username" 
           placeholder="Username or Rego. No if student"
           name="username" value="{{ $edit ? $user->username : '' }}">
</div>
<div class="form-group">
    <label for="password">{{ $edit ? 'New password' : 'Password' }}</label>
    <input type="password" class="form-control" id="password"
           name="password" 
           @if ($edit) placeholder="Leave blank if you dn't want to change it" @endif>
</div>
<div class="form-group">
    <label for="password_confirmation">{{ $edit ? 'Confirm new password' : 'Confirm password' }}</label>
    <input type="password" class="form-control" id="password_confirmation"
           name="password_confirmation" 
           @if ($edit) placeholder="Leave blank if you dn't want to change it" @endif>
</div>
@if ($edit)
    <button type="submit" class="btn btn-primary mt-2" id="update-login-details-btn">
        <i class="fa fa-refresh"></i>
        Update details
    </button>
@endif