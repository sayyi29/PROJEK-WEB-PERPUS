<section>
    <div class="mb-10">
        <h3 class="text-xl font-black text-[#1A1A1A] tracking-tight uppercase tracking-widest">
            {{ __('messages.account_profile') }}
        </h3>
        <p class="mt-2 text-[#888888] font-bold text-[10px] uppercase tracking-[0.2em]">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo -->
        <div class="space-y-4">
            <x-input-label for="profile_photo" :value="__('messages.profile_photo')" />
            
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-[#FAF9F6] border-2 border-dashed border-[#EFEFE9] flex items-center justify-center overflow-hidden transition-all duration-500">
                    @if ($user->profile_photo_path)
                        <img id="preview" src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover">
                    @else
                        <div id="placeholder" class="text-[#888888]">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="flex-1 space-y-2">
                    <input id="profile_photo" name="profile_photo" type="file" class="hidden" accept="image/*" onchange="previewImage(event)" />
                    <button type="button" onclick="document.getElementById('profile_photo').click()" class="px-5 py-2.5 bg-[#FAF9F6] border border-[#EFEFE9] rounded-xl text-[10px] font-black text-[#1A1A1A] uppercase tracking-widest hover:bg-[#EFEFE9] transition-all">
                        {{ __('messages.click_to_upload') }}
                    </button>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <div class="space-y-2">
            <x-input-label for="name" :value="__('messages.full_name')" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-2">
            <x-input-label for="email" :value="__('messages.email_address')" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 border border-amber-100 rounded-xl">
                    <p class="text-[10px] text-amber-800 font-bold uppercase tracking-widest">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="ml-2 underline hover:text-amber-600 transition-all font-black">
                            {{ __('Click here to re-send.') }}
                        </button>
                    </p>
                </div>
            @endif
        </div>

        <!-- Address -->
        <div class="space-y-2">
            <x-input-label for="address" :value="__('messages.address')" />
            <textarea id="address" name="address" rows="3" placeholder="{{ __('messages.enter_address') }}">{{ old('address', $user->address) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit">
                {{ __('messages.save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-[10px] font-black text-green-600 uppercase tracking-widest">
                    {{ __('messages.book_updated_success') }}
                </p>
            @endif
        </div>
    </form>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('preview');
                const placeholder = document.getElementById('placeholder');
                
                if (output) {
                    output.src = reader.result;
                } else {
                    const newImg = document.createElement('img');
                    newImg.id = 'preview';
                    newImg.src = reader.result;
                    newImg.className = 'w-full h-full object-cover';
                    placeholder.parentNode.appendChild(newImg);
                    placeholder.remove();
                }
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</section>
