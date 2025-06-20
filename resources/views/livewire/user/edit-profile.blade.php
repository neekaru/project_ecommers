<div class="container mt-5" style="max-width: 500px;">
    <form wire:submit.prevent="updateProfile">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="position-relative me-3">
                        <label for="avatar" style="cursor: pointer;">
                            @if ($avatar)
                                <img src="{{ $avatar->temporaryUrl() }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                            @elseif ($existingAvatar)
                                <img src="{{ asset('storage/' . $existingAvatar) }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/avatar.jpg') }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                            @endif
                            <div class="position-absolute bottom-0 end-0">
                                <span class="bg-danger rounded-circle p-1 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                    </svg>
                                </span>
                            </div>
                        </label>
                        <input type="file" id="avatar" wire:model="avatar" class="d-none">
                    </div>
                    <div>
                        <h5 class="mb-1">{{ $nama }}</h5>
                        <p class="text-muted mb-0 small">{{ $email }}</p>
                    </div>
                </div>
                <div wire:loading wire:target="avatar" class="text-muted small mt-2">Uploading...</div>
                @error('avatar') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" wire:model.defer="nama" placeholder="Nama:" style="padding: 0.75rem 1rem; border: none; box-shadow: 0 2px 4px rgba(0,0,0,.05);">
            @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" wire:model.defer="email" placeholder="email:" style="padding: 0.75rem 1rem; border: none; box-shadow: 0 2px 4px rgba(0,0,0,.05);">
            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" wire:model.defer="telepon" placeholder="Nomor Telpon:" style="padding: 0.75rem 1rem; border: none; box-shadow: 0 2px 4px rgba(0,0,0,.05);">
            @error('telepon') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" rows="3" wire:model.defer="alamat" placeholder="Alamat:" style="padding: 0.75rem 1rem; border: none; box-shadow: 0 2px 4px rgba(0,0,0,.05); resize: none;"></textarea>
            @error('alamat') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="d-grid mt-4 mb-4">
            <button type="submit" class="btn btn-success rounded-pill" style="padding: 0.75rem;">
                <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                <span wire:loading wire:target="updateProfile">Menyimpan...</span>
            </button>
        </div>
    </form>
</div>