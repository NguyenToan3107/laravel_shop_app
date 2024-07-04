@props(['category'])

@if(is_null($category->parent_id))
    <div class="category_recursive" data-id="{{$category->id}}">
        <a href="">{{ucwords($category->title)}}</a>
    </div>
@else
    <div class="category_recursive_brand" data-id="{{$category->id}}">
        <a href="">{{ucwords($category->title)}}</a>
    </div>
@endif

@if(count($category->children) > 0)
    @foreach($category->children as $child)
        <div style="margin-left: 20px">
            <x-category-item-banner :category="$child"/>
        </div>
    @endforeach
@endif
