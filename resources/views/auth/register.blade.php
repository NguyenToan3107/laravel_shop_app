<x-guest-layout>
        <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                          autofocus autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                          autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')"/>

            <x-text-input id="phone" class="block mt-1 w-full"
                          type="text"
                          name="phoneNumber"
                          required/>
            <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')"/>

            <x-text-input id="address" class="block mt-1 w-full"
                          type="text"
                          name="address"
                          required/>
            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="age" :value="__('Age')"/>

            <x-text-input id="age" class="block mt-1 w-full"
                          type="text"
                          name="age"
                          required/>
            <x-input-error :messages="$errors->get('age')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="roles" :value="__('Roles')"/>
            @foreach($roles as $role)
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" name="roles[]" value="{{ $role }}" class="form-check-input">
                        {{ $role }}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-end mt-4">
            <a style="margin-right: 10px" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <button type="submit" class="btn btn-primary">Đăng ký</button>
        </div>
    </form>
    <a class="btn btn-secondary" href="/login">Đăng nhập</a>
</x-guest-layout>
