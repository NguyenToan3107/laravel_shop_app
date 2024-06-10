@props(['category', 'level'])

<tr>
    <td>{{$category->id}}</td>
    <td>
        @if ($level > 0)
            ¦
            {{ str_repeat('––', $level) }}
        @endif
        {{$category->title}}
    </td>
    <td>{{$category->description}}</td>
    <td>
        <div class="d-flex align-items-center">
            <a href="/categories/{{$category->id}}/edit" class="btn btn-primary btn-sm mr-2" style="margin-right: 6px">Sửa</a>
            <form action="/categories/{{ $category->id }}" method="post" class="mb-0">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
            </form>
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
