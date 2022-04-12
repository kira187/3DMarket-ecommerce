<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\City;
use App\Models\District;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;

class CreateOrder extends Component
{
    public $address, $references, $envio_type = 1, $contact, $phone, $shipping_cost = 0;
    public $departments, $cities = [], $districts = [];
    public $department_id = '', $city_id = '', $district_id = '';
    
    public $rules = [
        'contact' => 'required',
        'phone' => 'required',
        'envio_type' => 'required'
    ];

    public function mount()
    {
        $this->departments = Department::all();         
    }

    public function createOrder()
    {
        $rules = $this->rules;

        if ($this->envio_type == 2) {
            $rules['department_id'] = 'required';
            $rules['city_id'] = 'required';
            $rules['district_id'] = 'required';
            $rules['references'] = 'required';
            $rules['address'] = 'required';
        }

        $this->validate($rules);

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->contact = $this->contact;
        $order->phone = $this->phone;
        $order->envio_type = $this->envio_type;
        $order->shipping_cost = 0;
        $order->total = $this->shipping_cost + Cart::subtotal();
        $order->content = Cart::content();
        
        if ($this->envio_type == 2) {
            $order->shipping_cost = $this->shipping_cost;
            $order->department_id = $this->department_id ;
            $order->city_id = $this->city_id ;
            $order->district_id = $this->district_id ;
            $order->references = $this->references ;
            $order->address = $this->address ;
        }
        $order->save();
        
        Cart::destroy();

        return redirect()->route('orders.payment', $order);
    }

    public function updatedDepartmentId($value)
    {
        $this->cities = City::where('department_id', $value)->get();
        $this->reset(['city_id', 'district_id']);
    }

    public function updatedCityId($value)
    {
        $city = City::find($value);
        $this->shipping_cost = $city->cost;

        $this->districts = District::where('city_id', $value)->get();
        $this->reset('district_id');
    }

    public function updatedEnvioType($value)
    {
        if ($value == 1) {
            $this->resetValidation([
                'department_id', 'city_id', 'district_id', 'references', 'address'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.create-order');
    }
}
