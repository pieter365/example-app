<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;

class Products extends Component
{
    public $products, $name, $description, $price, $productId;
    public $isEditMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
    ];

    public function render()
    {
        $this->products = Product::all();
        return view('livewire.admin.products');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->productId = null;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate();

        Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        session()->flash('message', 'Product created successfully.');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate();

        $product = Product::findOrFail($this->productId);
        $product->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        session()->flash('message', 'Product updated successfully.');
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'Product deleted successfully.');
    }
}