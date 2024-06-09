<div class="d-flex align-items-center">
    <a href="/products/{{$product->id}}/edit"
       class="btn btn-primary btn-sm mr-2">Edit</a>
    <form action="/products/{{ $product->id }}" method="post" class="mb-0">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
    </form>
</div>
