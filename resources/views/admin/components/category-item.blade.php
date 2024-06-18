@props(['category', 'level'])

<option value="{{ $category->id }}" style="margin-left: {{ $level * 20 }}px;">
    @if ($level > 0)
        ¦
        {{ str_repeat('––', $level) }}
    @endif
    {{ $category->title }}

    @if (count($category->children) > 0)
            @foreach($category->children as $child)
                <div style="margin-left: 20px">
                    <x-category-item :category="$child" :level="$level + 1"/>
                </div>
            @endforeach
    @endif
</option>
