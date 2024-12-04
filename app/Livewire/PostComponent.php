<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PostComponent extends Component
{
    use WithPagination;
    use WithFileUploads;

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
        $this->categories = Category::all();
    }

    public function render()
    {
        $posts = Post::latest()->paginate(2);

        return view('livewire.post', [
            'models' => $posts,
            'categories' => $this->categories
        ]);
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
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->category_id = '';
        $this->title = '';
        $this->description = '';
        $this->text = '';
        $this->img = '';
        $this->activeCreate = false;
    }

    public function delete(Post $post)
    {
        $post->delete();
        session()->flash('message', 'Post deleted successfully!');
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
        } else {
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
    }

    public function toggleDescription($id)
    {
        $this->showDescription[$id] = !$this->showDescription[$id];
    }

    public function toggleText($id)
    {
        $this->showText[$id] = !$this->showText[$id];
    }

    public function toggleTitle($id)
    {
        $this->showTitle[$id] = !$this->showTitle[$id];
    }
}
