<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryComponent extends Component
{

    use WithPagination;

    public $models;
    public $activeCreate = false;
    public $editFormCategory = false;

    public $name;
    public $editName;
    
    public function mount()
    {
        $this->all();
    }

    public function all()
    {
        $this->models = Category::orderBy('tr', 'asc')->get();
        return $this->models;
    }

    public function render()
    {
        return view('livewire.category');
    }
    
    public function CreateModal()
    {
        $this->activeCreate = !$this->activeCreate;
    }

    public function store()
    {

        $count = Category::all()->count();
        
        if(!empty($this->name)){
            Category::create([
                'name' => $this->name,
                'tr' => ($count+1),
            ]);
            $this->activeCreate = false;
        }
        $this->name = '';
        $this->all();
    }

    public function delete(Category $category)
    {
        $category->delete();
        $this->all();
    }

    public function editForm(Category $category)
    {
        $this->editFormCategory = $category->id;
        $this->editName = $category->name;
    }
    
    public function update()
    {

        $category = Category::findOrFail($this->editFormCategory);
        $category->update([
            'name' => $this->editName,
        ]);
        $this->editFormCategory = false;
        $this->all();

    }

    public function updateCategoryTr($updateCategoryIds)
    {
        foreach ($updateCategoryIds as $key)
        {
            Category::where('id', $key['value'])->update((['tr' => $key['order']]));
        }
        $this->models = Category::orderBy('tr', 'asc')->paginate(10);
    }
}
