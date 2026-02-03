<section id="contact" class="py-24 bg-graphite text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center mb-12 animate-fade-up">
            <div class="inline-block px-4 py-1 bg-accent/20 rounded-full mb-6">
                <span class="text-accent text-sm font-medium">{{ __('Exclusive Access') }}</span>
            </div>
            <h2 class="font-heading text-4xl md:text-5xl font-bold mb-6">
                {{ __('Join the Off Market Club') }}
            </h2>
            <p class="text-lg text-white/80">
                {{ __('Gain priority access to exclusive opportunities before they reach the open market') }}
            </p>
        </div>

        @if(session('success'))
            <div class="max-w-xl mx-auto mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-lg text-center">
                <p class="text-white">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="max-w-xl mx-auto mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-lg">
                <ul class="text-white text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('access-request.store') }}" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto space-y-6 animate-fade-up">
            @csrf
            
            <div>
                <input
                    type="text"
                    name="name"
                    placeholder="{{ __('Full Name') }}"
                    value="{{ old('name') }}"
                    required
                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-md text-white placeholder:text-white/50 focus:outline-none focus:ring-2 focus:ring-accent"
                />
            </div>

            <div>
                <input
                    type="email"
                    name="email"
                    placeholder="{{ __('Email Address') }}"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-md text-white placeholder:text-white/50 focus:outline-none focus:ring-2 focus:ring-accent"
                />
            </div>

            <div>
                <input
                    type="text"
                    name="country"
                    placeholder="{{ __('Country') }}"
                    value="{{ old('country') }}"
                    required
                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-md text-white placeholder:text-white/50 focus:outline-none focus:ring-2 focus:ring-accent"
                />
            </div>

            <div>
                <select
                    name="investor_type"
                    required
                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-accent"
                >
                    <option value="" disabled selected>{{ __('Investor Type') }}</option>
                    <option value="client" {{ old('investor_type') == 'client' ? 'selected' : '' }}>{{ __('Individual Investor (Client)') }}</option>
                    <option value="developer" {{ old('investor_type') == 'developer' ? 'selected' : '' }}>{{ __('Developer/Construction Company') }}</option>
                    <option value="family-office" {{ old('investor_type') == 'family-office' ? 'selected' : '' }}>{{ __('Family Office') }}</option>
                    <option value="institutional" {{ old('investor_type') == 'institutional' ? 'selected' : '' }}>{{ __('Institutional') }}</option>
                </select>
            </div>

            <div>
                <input
                    type="text"
                    name="investment_amount"
                    placeholder="{{ __('Investment Amount (e.g., €500,000)') }}"
                    value="{{ old('investment_amount') }}"
                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-md text-white placeholder:text-white/50 focus:outline-none focus:ring-2 focus:ring-accent"
                />
            </div>

            <div>
                <textarea
                    name="message"
                    placeholder="{{ __('Tell us about your investment interests...') }}"
                    rows="4"
                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-md text-white placeholder:text-white/50 resize-none focus:outline-none focus:ring-2 focus:ring-accent"
                >{{ old('message') }}</textarea>
            </div>

            <div>
                <label class="block text-sm text-white/70 mb-2">{{ __('Proof of Funds (Optional)') }}</label>
                <input
                    type="file"
                    name="proof_document"
                    accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-md text-white file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-accent/90"
                />
            </div>

            <div class="flex items-start gap-3">
                <input
                    type="checkbox"
                    id="consent"
                    name="consent"
                    required
                    class="mt-1 w-4 h-4 text-accent bg-white/10 border-white/20 rounded focus:ring-accent"
                />
                <label for="consent" class="text-sm text-white/70 cursor-pointer">
                    {{ __('I agree to the processing of my personal data according to the') }}
                    <a href="#" class="text-accent hover:underline">{{ __('Privacy Policy') }}</a> {{ __('and understand that access is subject to admin approval.') }}
                </label>
            </div>

            <button
                type="submit"
                class="w-full px-8 py-3 bg-accent hover:bg-accent/90 text-white font-medium rounded-md transition-colors"
            >
                {{ __('Submit Application') }}
            </button>
        </form>
    </div>
</section>