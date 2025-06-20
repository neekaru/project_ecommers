<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4>Edit Profil</h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updateProfile">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        <!-- Avatar -->
                        <div class="mb-3 text-center">
                            @if ($avatar)
                                <img src="{{ $avatar->temporaryUrl() }}" class="rounded-circle mb-2" width="150" height="150">
                            @elseif ($existingAvatar)
                                <img src="{{ asset('storage/' . $existingAvatar) }}" class="rounded-circle mb-2" width="150" height="150">
                            @else
                                <img src="{{ asset('storage/avatar.jpg') }}" class="rounded-circle mb-2" width="150" height="150">
                            @endif
                            <div class="mt-2">
                                <label for="avatar" class="form-label">Ubah Foto Profil</label>
                                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" wire:model="avatar">
                                <div wire:loading wire:target="avatar" class="text-muted">Uploading...</div>
                                @error('avatar') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" wire:model.defer="nama">
                            @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" wire:model.defer="email">
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <!-- Telepon -->
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" wire:model.defer="telepon">
                            @error('telepon') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" rows="3" wire:model.defer="alamat"></textarea>
                            @error('alamat') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                                <span wire:loading wire:target="updateProfile">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>