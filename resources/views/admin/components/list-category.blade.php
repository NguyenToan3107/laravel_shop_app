@props(['category', 'level'])

<tr>
    <td>{{$category->id}}</td>
    <td><img class="img-thumbnail user-image-45" src="{{$category->image}}" alt="{{$category->title}}"></td>
    <td>
        @if ($level > 0)
            ¦
            {{ str_repeat('––', $level) }}
        @endif
        {{$category->title}}
    </td>
    <td>
        <div class="d-flex align-items-center">
            @can('edit-category')
                <a href="/admin/categories/{{$category->slug}}/edit" class="btn btn-primary btn-sm mr-2"
                   style="margin-right: 6px"><i class="fa-solid fa-pen-to-square"></i></a>
            @endcan

            @can('delete-category')
                <form action="/admin/categories/{{ $category->slug }}" method="post" class="mb-0">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                </form>
            @endcan
        </div>
    </td>

    @if(count($category->children) > 0)
        @foreach($category->children as $child)
            <div style="margin-left: 20px">
                <x-list-category :category="$child" :level="$level + 1"/>
            </div>
        @endforeach
    @endif
</tr>
