<div class="login-page-main-content">
    <div class="login-box">
        <div class="text-center login-logo mb-4">
            <img src="{{ asset('icon/logo baru.png') }}" alt="Logo Toko">
            <h4 class="login-title mt-3">BEBEK GALAK RARA 57</h4>
        </div>
        <form wire:submit.prevent="login">
            <div class="mb-3">
                <label for="email" class="form-label">EMAIL <span class="text-danger">*</span></label>
                <input type="email" id="email" class="form-control" wire:model.defer="email" placeholder="Masukan Email Anda">
                @error('email') <span class="text-danger d-block mt-1">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn btn-login w-100">LOGIN</button>
        </form>
        <div class="mt-3 text-center">
            <button wire:click="redirectToGoogle" class="btn btn-google-login w-100">
                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo">
                Login Dengan Google
            </button>
        </div>
    </div>
</div> 