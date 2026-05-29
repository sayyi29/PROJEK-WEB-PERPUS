<section>
    <button type="button" 
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="text-[9px] font-black text-red-600 border border-red-200 bg-white hover:bg-red-600 hover:text-white px-5 py-2.5 rounded-xl uppercase tracking-widest transition-all">
        Terminate Account
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-[#062C2C] rounded-[2rem] text-white">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-white uppercase tracking-tighter">Confirm Deletion</h2>

            <p class="mt-4 text-[10px] font-bold text-white/40 leading-relaxed uppercase tracking-widest">
                Please enter your password to confirm permanent deletion.
            </p>

            <div class="mt-6">
                <x-text-input id="password" name="password" type="password" placeholder="Confirm Password" class="w-full" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 rounded-xl text-[9px] font-black uppercase tracking-widest text-[#888888] hover:bg-gray-100 transition-all">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-red-600 text-white hover:bg-red-700 transition-all shadow-lg shadow-red-600/20">
                    Delete
                </button>
            </div>
        </form>
    </x-modal>
</section>
