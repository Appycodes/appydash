<form  method="POST" action="{{ route('users.store') }}">

        @csrf
          <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
              <div class="w-full">
                  <x-input-label for="name" :value="__('Name')" />
                  <x-input-text id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="given-name" />
                  <x-input-error :messages="$errors->get('name')" class="mt-2" />
              </div>
              <div class="w-full">
                  <x-input-label for="email" :value="__('Email')" />
                  <x-input-text id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" />
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
              </div>
              <div class="w-full">
                  <x-input-label for="password" :value="__('Password')" />
                  <x-input-text id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')" required autofocus autocomplete="password" />
                  <x-input-error :messages="$errors->get('password')" class="mt-2" />
              </div>
              <div class="w-full">
                  <x-input-label for="phone" :value="__('Phone')" />
                  <x-input-text id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
                  <x-input-error :messages="$errors->get('password')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="gender" :value="__('Gender')" />
                <x-input-select name="gender" id="gender" :options="$genders" />
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
              </div>
              <div class="w-full">
                  <x-input-label for="dob" :value="__('Date of Birth')" />
                  <x-input-text id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')"/>
                  <x-input-error :messages="$errors->get('dob')" class="mt-2" />
              </div>
              <div class="sm:col-span-2">
                  <x-input-label for="bio" :value="__('Bio')" />
                  <x-input-textarea id="bio" name="bio"></x-input-textarea>
                  <x-input-error :messages="$errors->get('bio')" class="mt-2" />
              </div>
              <div class="w-full">
                <x-input-switch :label="__('Admin')" name="is_admin" value="1"/>
              </div>
              <div class="w-full">
                <x-input-switch :label="__('Status')" name="status" value="1" />
              </div>
              
          </div>

          <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8">

          <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
          <div class="w-full">
                  <x-input-label for="name" :value="__('Name')" />
                  <x-input-text id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="given-name" />
                  <x-input-error :messages="$errors->get('name')" class="mt-2" />
              </div>
              <div class="w-full">
                  <x-input-label for="email" :value="__('Email')" />
                  <x-input-text id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" />
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
              </div>
          </div>


          <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
              Add User
          </button>
</form>