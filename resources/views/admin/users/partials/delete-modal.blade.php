<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" 
     aria-labelledby="deleteUserLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteUserLabel{{ $user->id }}">Delete Customer</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong>{{ $user->name }}</strong> ({{ $user->email }})?
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.users.destroy',$user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>