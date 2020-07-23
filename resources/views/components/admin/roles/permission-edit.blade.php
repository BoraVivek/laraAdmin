<div class="form-group row">
    <div class="custom-control custom-checkbox large mr-1 col-sm-2" id="permissions_checkbox">
        <input type="checkbox" class="role-checkbox" id="add-{{ $name }}" value="add-{{ $name }}" name="permissions[]" {{ $isChecked("add-$name") ? 'checked' : '' }}>
        <label for="add-{{ $name }}">Add {{ $title }}</label>
    </div>
    <div class="custom-control custom-checkbox large mr-1 col-sm-2" id="permissions_checkbox">
        <input type="checkbox" class="role-checkbox" id="edit-{{ $name }}" value="edit-{{ $name }}" name="permissions[]" {{ $isChecked("edit-$name") ? 'checked' : '' }}>
        <label for="edit-{{ $name }}">Edit {{ $title }}</label>
    </div>
    <div class="custom-control custom-checkbox large mr-1 col-sm-2" id="permissions_checkbox">
        <input type="checkbox" class="role-checkbox" id="view-{{ $name }}" value="view-{{ $name }}" name="permissions[]" {{ $isChecked("view-$name") ? 'checked' : '' }} >
        <label for="view-{{ $name }}">View {{ $title }}</label>
    </div>
    <div class="custom-control custom-checkbox large mr-1 col-sm-2" id="permissions_checkbox">
        <input type="checkbox" class="role-checkbox" id="delete-{{ $name }}" value="delete-{{ $name }}" name="permissions[]" {{ $isChecked("delete-$name") ? 'checked' : '' }}>
        <label for="delete-{{ $name }}">Delete {{ $title }}</label>
    </div>
</div>
