<div class="detail_nav">
    <a href="/">Trang chủ</a>
    <i class="fa-solid fa-chevron-right"></i>
    <a href="/products">Sản phẩm</a>
    @if(isset($category_parent) || !is_null($category_parent))
        <i class="fa-solid fa-chevron-right"></i>
        <a href="/products/{{$category_parent->slug}}">{{$category_parent->title}}</a>
    @endif
    @if(isset($category_brand) || !is_null($category_brand))
        <i class="fa-solid fa-chevron-right"></i>
        <a href="/products">{{$category_brand->title}}</a>
    @endif
</div>
<div class="category">
    <div class="product-detail_related">
        <div></div>
        <p>Danh mục</p>
    </div>
    <div style="margin-top: 15px; display: flex; justify-content: space-between">
        <h4>Danh sách danh mục sản phẩm</h4>
        <div style="display: flex; flex-direction: row; gap: 20px">
            <div class="category_arrow"><i class="fa-solid fa-arrow-left"></i></div>
            <div class="category_arrow"><i class="fa-solid fa-arrow-right"></i></div>
        </div>
    </div>

    <div class="category_list">
        @foreach($categories as $category)
            <a href="/products/{{$category->slug}}" class="category_item" data-id="{{$category->id}}" data-slug="{{$category->slug}}">
                <img class="category_item--img" src="{{$category->image}}" alt="">
                <p>{{$category->title}}</p>
            </a>
        @endforeach
    </div>

    <div id="category-brand--item">
        @if(isset($category_parent) || !is_null($category_parent))
            <div class="category_item--sub--item">
                @if(count($category_parent->children) > 0)
                    @foreach($category_parent->children as $child)
                        <div
                           id="category_item_brand"
                           data-slug="{{$child->slug}}" data-category="{{$category_parent->slug}}">
                            <img class="category_item--item--img" src="{{$child->image}}" alt="{{$child->title}}">
                        </div>
                    @endforeach
                @endif
            </div>
        @endif
    </div>
</div>

