<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Payment;
use App\Models\Appartment;
use Livewire\Attributes\Validate; 

class PaymentForm extends Component
{ 
    public $username;
    public $amount;

    public $apartment_id='';

    public $payment_method='';

    public $category='';
    public $status='';

    #[Validate('required')]
    public $users;

    public $user_id;    


    public function searchUser()
    {
        $this->users = User::where('role', 'renter')
        ->where('name', 'like', '%' . $this->username . '%')
        ->get();    
    }
    public function selectUser($user_id,$username)
    {
        $this->username = $username;
        $this->user_id = $user_id;
        $this->users = null; // Hide the suggestions once a user is selected
    }
    public function save()
    {
        $this->validate([
            'apartment_id'=>'required',
            'user_id'=>'required',
            'amount'=>'required|numeric',
            'category'=>'required',
            'payment_method'=>'required',
            'status'=>'required',
        ]); 
        Payment::create(
            $this->only(['apartment_id', 'user_id','amount','category','payment_method','status'])
        );
        return redirect()->route('admin.payments.index')->with('success','Adding payment success');
    }
    public function render()
    {
        $apartments = Appartment::all();
        return view('livewire.admin.payment-form',compact('apartments'));
    }
}
