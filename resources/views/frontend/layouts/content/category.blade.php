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
            <a href="" class="category_item" value="{{$category->id}}">
                <img class="category_item--img" src="{{$category->image}}" alt="">
                <p>{{$category->title}}</p>
            </a>
        @endforeach
    </div>

</div>

