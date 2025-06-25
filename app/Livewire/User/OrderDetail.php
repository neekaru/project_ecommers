<?php

namespace App\Livewire\User;

use App\Models\Komentar;
use App\Models\Pesanan;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => 'Detail Order'])]
class OrderDetail extends Component
{
    public Pesanan $order;
    public $rating = 0;
    public $komentar = '';
    public $product_id;
    public $ratingModel = null;

    public function mount(Pesanan $order)
    {
        $this->order = $order->load('transaction.details.product', 'transaction.details.varian', 'orderMethod');

        if ($this->order->transaction && $this->order->transaction->details->first()) {
            $this->product_id = $this->order->transaction->details->first()->product_id;
        }

        // Fetch rating manually by product_id and customer_id
        if ($this->product_id) {
            $this->ratingModel = \App\Models\Rating::where('product_id', $this->product_id)
                ->where('customer_id', Auth::guard('customers')->id())
                ->first();
            if ($this->ratingModel) {
                $this->rating = $this->ratingModel->rating;
            }
        }

        // komentar relationship removed; fetch manually if needed
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function saveReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:5',
            'product_id' => 'required|exists:products,id'
        ]);

        Rating::updateOrCreate(
            [
                'customer_id' => Auth::guard('customers')->id(),
                'product_id' => $this->product_id,
            ],
            [
                'rating' => $this->rating,
            ]
        );

        Komentar::updateOrCreate(
            [
                'customer_id' => Auth::guard('customers')->id(),
                'product_id' => $this->product_id,
            ],
            [
                'isi' => $this->komentar
            ]
        );

        session()->flash('message', 'Ulasan berhasil disimpan.');
        $this->redirect(route('user.dashboard'));
    }

    public function render()
    {
        return view('livewire.user.order-detail', [
            'ratingModel' => $this->ratingModel,
        ]);
    }
} 