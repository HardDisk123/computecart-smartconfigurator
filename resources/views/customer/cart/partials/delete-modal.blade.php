<!-- Remove Item Modal -->
<div class="modal fade" id="removeItemModal{{ Auth::check() ? $item->id : $item->product->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Remove Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to remove {{ $item->product->name ?? 'this product' }} from your cart?
      </div>
      <div class="modal-footer">
        <form action="{{ route('cart.remove', Auth::check() ? $item->id : $item->product->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Yes, Remove</button>
</form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>