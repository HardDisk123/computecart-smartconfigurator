<div x-data="{ open: false }">
    <button @click="open = true" class="px-2 py-1 bg-red-600 text-white rounded">Delete</button>

    <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-lg font-bold">Confirm Delete</h2>
            <p>Are you sure you want to delete this item?</p>
            <div class="mt-4 flex space-x-2">
                <form method="POST" action="{{ $action }}">
                    @csrf
                    @method('DELETE')
                    <button class="px-4 py-2 bg-red-600 text-white rounded">Yes</button>
                </form>
                <button @click="open = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
            </div>
        </div>
    </div>
</div>