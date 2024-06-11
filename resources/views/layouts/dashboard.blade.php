@extends('layouts.app')

@section('content')
    <!-- ======================= Cards ================== -->
    <div class="cardBox">
        <a href="/users" class="card">
            <div class="flex_dash">
                <div class="numbers">{{$count_users}}</div>
                <div class="cardName">Users</div>
            </div>

        </a>

        <a href="/categories" class="card">
            <div>
                <div class="numbers">{{$count_categories}}</div>
                <div class="cardName">Categories</div>
            </div>

            <div class="iconBx">
                <ion-icon name="cart-outline"></ion-icon>
            </div>
        </a>

        <a href="/products" class="card">
            <div>
                <div class="numbers">{{$count_products}}</div>
                <div class="cardName">Products</div>
            </div>

            <div class="iconBx">
                <ion-icon name="chatbubbles-outline"></ion-icon>
            </div>
        </a>

        <a href="/posts" class="card">
            <div>
                <div class="numbers">{{$count_posts}}</div>
                <div class="cardName">Posts</div>
            </div>

            <div class="iconBx">
                <ion-icon name="cash-outline"></ion-icon>
            </div>
        </a>
    </div>
@endsection
