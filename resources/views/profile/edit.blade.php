<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-10">
        
        <!-- Elegant Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-[#E8E4D9] pb-8 gap-6">
            <div>
                <p class="text-[10px] font-black text-[#B8860B] uppercase tracking-[0.4em] mb-2">System Configuration</p>
                <h2 class="text-4xl font-black tracking-tighter text-[#062C2C] uppercase leading-none">Account Settings</h2>
                <p class="text-xs font-bold text-slate-400 mt-4 uppercase tracking-widest">Personal credentials & security protocols</p>
            </div>
            <div class="hidden sm:block text-right">
                <p class="text-[9px] font-bold text-[#B8860B] uppercase tracking-widest">Status: Authenticated</p>
                <p class="text-xs font-black text-[#062C2C] uppercase">{{ now()->format('H:i T') }}</p>
            </div>
        </div>

        <!-- Membership Bar -->
        @include('profile.partials.membership-card')

        <!-- Settings Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-10 items-start">
            
            <!-- Left: Profile Info -->
            <div class="xl:col-span-7 bg-[#062C2C] rounded-[2.5rem] overflow-hidden border border-white/5 shadow-2xl">
                <div class="px-10 py-6 border-b border-white/5 bg-white/5 flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-[#B8860B]"></div>
                    <h3 class="text-[11px] font-black text-white uppercase tracking-widest">Personal Protocol</h3>
                </div>
                <div class="p-10 text-white">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Right: Security & Actions -->
            <div class="xl:col-span-5 space-y-10">
                <!-- Security Card -->
                <div class="bg-[#062C2C] rounded-[2.5rem] overflow-hidden border border-white/5 shadow-2xl">
                    <div class="px-10 py-6 border-b border-white/5 bg-white/5 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-[#B8860B]"></div>
                        <h3 class="text-[11px] font-black text-white uppercase tracking-widest">Access & Security</h3>
                    </div>
                    <div class="p-10 text-white">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="premium-card rounded-[2.5rem] overflow-hidden border-rose-100 border-2">
                    <div class="px-10 py-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <h3 class="text-[11px] font-black text-rose-900 uppercase tracking-widest mb-1">Decommission Account</h3>
                            <p class="text-[9px] text-slate-400 font-bold uppercase">Irreversible removal of all digital assets</p>
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* Unified Form Controls for Soft Paper Theme */
        input, textarea, select {
            background-color: rgba(255, 255, 255, 0.05) !important; 
            border: 1px solid rgba(255, 255, 255, 0.1) !important; 
            border-radius: 16px !important;
            padding: 0.85rem 1.25rem !important;
            font-size: 0.85rem !important;
            font-weight: 500 !important;
            color: #FFFFFF !important; 
            transition: all 0.3s ease !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: none !important;
        }
        input:focus {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-color: #B8860B !important;
            box-shadow: 0 0 0 4px rgba(184, 134, 11, 0.1) !important;
            outline: none !important;
        }
        label {
            font-size: 10px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.15em !important;
            color: rgba(255, 255, 255, 0.4) !important;
            margin-bottom: 0.6rem !important;
            display: block;
        }

        /* Danger Zone Override (Stay Light) */
        .premium-card input, .premium-card textarea, .premium-card select {
            background-color: #FDFCF9 !important;
            border: 1px solid #E8E4D9 !important;
            color: #062C2C !important;
        }
        .premium-card label {
            color: #062C2C !important;
            opacity: 0.6;
        }

        button[type="submit"] {
            background-color: #B8860B !important;
            color: #FFFFFF !important;
            padding: 1rem 2rem !important;
            border-radius: 16px !important;
            font-size: 10px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.2em !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 10px 30px rgba(184, 134, 11, 0.1) !important;
        }
        button[type="submit"]:hover {
            background-color: #8B6508 !important;
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(184, 134, 11, 0.2) !important;
        }
        .space-y-6 > * + * { margin-top: 1.5rem !important; }
    </style>
</x-app-layout>
