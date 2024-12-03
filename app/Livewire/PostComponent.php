<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PostComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $models;
    public $categories;
    public $activeCreate = false;
    public $editFormPost = false;

    public $category_id;
    public $title;
    public $description;
    public $text;
    public $img;
    public $likes;
    public $dislikes;
    public $views;

    public $editCategory_id;
    public $editTitle;
    public $editDescription;
    public $editText;
    public $editImg;

    public $showDescription = [];
    public $showText = [];
    public $showTitle = [];

    protected $rules = [
        'category_id' => 'required|integer|exists:categories,id',
        'title' => 'required|string|min:20',
        'description' => 'required|string|min:20',
        'text' => 'required|string|min:20',
        'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
    ];

    public function validateOnBlur($field)
    {
        $this->validateOnly($field);
    }

    public function mount()
    {
        $this->all();
    }

    public function all()
    {
        $this->models = Post::paginate(10);
        $this->categories = Category::all();
        return [$this->models, $this->categories];
    }

    public function render()
    {
        return view('livewire.post');
    }

    public function CreateModal()
    {
        $this->activeCreate = !$this->activeCreate;
    }

    public function store()
    {
        $validatedData = $this->validate();

        if ($validatedData) {
            if ($this->img) {
                $ext = $this->img->getClientOriginalExtension();
                $date = now();

                $folder = "pictures";
                $filename = $date->format('YmdHisv') . '.' . $ext;


                $path = $this->img->storeAs($folder, $filename, 'public');

                $validatedData['img'] = $path;
            }


            Post::create($validatedData);

            session()->flash('message', 'Post created successfully!');
            $this->all();
        }
        $this->category_id = '';
        $this->title = '';
        $this->description = '';
        $this->text = '';
        $this->img = '';
        $this->activeCreate = false;
        $this->all();
    }

    public function delete(Post $post)
    {
        $post->delete();
        $this->all();
    }

    public function editForm(Post $post)
    {
        $this->editFormPost = $post->id;
        $this->editCategory_id = $post->category_id;
        $this->editTitle =  $post->title;
        $this->editDescription = $post->description;
        $this->editText = $post->text;
        $this->editImg = $post->img;
    }

    public function updatePost()
    {
        $post = Post::findOrFail($this->editFormPost);
        if ($this->editImg != $post->img) {
            $ext = $this->editImg->getClientOriginalExtension();
            $date = now();

            $folder = "pictures";
            $filename = $date->format('YmdHisv') . '.' . $ext;


            $path = $this->editImg->storeAs($folder, $filename, 'public');

            $this->editImg = $path;
        }else{
            $this->editImg = $post->img;
        }
        $post->update([
            'category_id' => $this->editCategory_id,
            'title' => $this->editTitle,
            'description' => $this->editDescription,
            'text' => $this->editText,
            'img' => $this->editImg,
        ]);
        $this->editFormPost = false;
        $this->all();
    }

    public function toggleDescription($id)
    {
        if (isset($this->showDescription[$id]) && $this->showDescription[$id] === true) {
            $this->showDescription[$id] = false;
        } else {
            $this->showDescription[$id] = true;
        }
    }

    public function toggleText($id)
    {
        if (isset($this->showText[$id]) && $this->showText[$id] === true) {
            $this->showText[$id] = false;
        } else {
            $this->showText[$id] = true;
        }
    }

    public function toggleTitle($id)
    {
        if (isset($this->showTitle[$id]) && $this->showTitle[$id] === true) {
            $this->showTitle[$id] = false;
        } else {
            $this->showTitle[$id] = true;
        }
    }

}
