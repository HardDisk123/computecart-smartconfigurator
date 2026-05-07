<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1" 
     aria-labelledby="deleteCategoryLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteCategoryLabel{{ $category->id }}">Delete Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong>{{ $category->name }}</strong>?
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.categories.destroy',$category->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
               