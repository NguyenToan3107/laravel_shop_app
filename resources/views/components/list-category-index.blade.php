@props(['category', 'level'])
{{--<div>--}}
{{--    <p>{{$category->name}}</p>--}}
{{--    @if (count($category->children) > 0)--}}
{{--        @foreach($category->children as $child)--}}
{{--            <div style="margin-left: 20px">--}}
{{--                <x-category-index :category="$child"/>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    @endif--}}
{{--</div>--}}

{{--<option value="{{ $category->id }}" style="margin-left: {{ $level * 20 }}px;">--}}
{{--    @if ($level > 0)--}}
{{--        ¦--}}
{{--        {{ str_repeat('––', $level) }}--}}
{{--    @endif--}}
{{--    {{ $category->name }}--}}

{{--    @if (count($category->children) > 0)--}}
{{--        @foreach($category->children as $child)--}}
{{--            <div style="margin-left: 20px">--}}
{{--                <x-category-item :category="$child" :level="$level + 1"/>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    @endif--}}
{{--</option>--}}

<tr>
    <td><a href="/categories/{{$category->id}}">{{$category->id}}</a></td>
    <td>
        @if ($level > 0)
            ¦
            {{ str_repeat('––', $level) }}
        @endif
        {{$category->name}}
    </td>
    <td>{{$category->description}}</td>
    <td>
        <div class="d-flex align-items-center">
            <a href="/categories/{{$category->id}}/edit" class="btn btn-primary btn-sm mr-2">Edit</a>
            <form action="/categories/{{ $category->id }}" method="post" class="mb-0">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    </td>

    @if(count($category->children) > 0)
        @foreach($category->children as $child)
            <div style="margin-left: 20px">
                <x-category-index :category="$child" :level="$level + 1"/>
            </div>
        @endforeach
    @endif
</tr>
