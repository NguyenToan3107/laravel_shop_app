@props(['category'])

<div class="category_recursive" data-slug="{{$category->slug}}">
    @if(!is_null($category->children) && count($category->children) > 0)
        <a href="/products/{{$category->slug}}" style="font-weight: bold">{{ucwords($category->title)}}</a>
    @else
        <a href="/products/{{$category->slug}}">{{ucwords($category->title)}}</a>
    @endif
</div>

@if(count($category->children) > 0)
    @foreach($category->children as $child)
        <div style="margin-left: 20px">
            <x-category-item-banner :category="$child"/>
        </div>
    @endforeach
@endif
