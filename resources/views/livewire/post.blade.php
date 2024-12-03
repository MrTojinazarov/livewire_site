<div>
    <div class="ms-1">
        <h2 style="color:rgb(25, 53, 80)">The Catyegories Page</h2>
        <button class="btn btn-outline-success mt-2" wire:click="CreateModal"
            style="width: 120px; height: auto;font-size: 20px; border-radius: 10px;">
            {{ $activeCreate ? 'Cancel' : 'Create' }}
        </button>

        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>{{ session('message') }}strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        @endif
        @if ($activeCreate)
            <div class="row">
                <div class="col-6 offset-3">
                    <form wire:submit.prevent="store">
                        @csrf
                        <div class="form-group">
                            <label for="category_id">Category:</label>
                            <select wire:model="category_id" class="form-control"
                                wire:blur="validateOnBlur('category_id')" required>
                                <option value="" disabled selected>Select a Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" wire:model="title" class="form-control" placeholder="Title"
                                wire:blur="validateOnBlur('title')" required>
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea wire:model="description" class="form-control" placeholder="Description" rows="3"
                                wire:blur="validateOnBlur('description')" required></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="text">Text:</label>
                            <textarea wire:model="text" class="form-control" placeholder="Text" rows="5" wire:blur="validateOnBlur('text')"
                                required></textarea>
                            @error('text')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="img">Image:</label>
                            <input type="file" wire:model="img" class="form-control" placeholder="Image"
                                wire:blur="validateOnBlur('img')" required>
                            @error('img')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-warning"
                                style="width: 100px; font-size:19px; border-radius:10px;">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        @endif

    </div>

    @if (!$activeCreate)
        <div class="row mt-4">
            <div class="col-12">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 2%;">Id</th>
                        <th style="width: 15%;">Category</th>
                        <th style="width: 15%;">Title</th>
                        <th style="width: 18%;">Description</th>
                        <th style="width: 20%;">Text</th>
                        <th style="width: 10%;">Image</th>
                        <th style="width: 5%;">Likes</th>
                        <th style="width: 5%;">Dislikes</th>
                        <th style="width: 5%;">Views</th>
                        <th style="width: 5%;">Options</th>
                    </tr>
                    @foreach ($models as $model)
                        @if ($editFormPost != $model->id)
                            <tr>
                                <th>{{ $model->id }}</th>
                                <td wire:click="editForm({{ $model->id }})" style="cursor: pointer;">
                                    {{ $model->category->name }}
                                </td>
                                <td>
                                    @if (empty($showTitle[$model->id]))
                                        <span class="d-inline-block text-truncate" style="max-width: 200px;"
                                            title="{{ $model->title }}">
                                            {{ Str::limit($model->title, 60) }}
                                        </span>
                                    @endif
                                    @if (strlen($model->title) > 60)
                                        <a href="javascript:void(0);" class="view-link"
                                            wire:click="toggleTitle({{ $model->id }})">View</a>
                                    @endif
                                    @if (isset($showTitle[$model->id]) && $showTitle[$model->id])
                                        <span class="full-text">{{ $model->title }}</span>
                                    @endif
                                <td>
                                    @if (empty($showTitle[$model->id]))
                                        <span class="d-inline-block text-truncate" style="max-width: 200px;"
                                            title="{{ $model->description }}">
                                            {{ Str::limit($model->description, 60) }}
                                        </span>
                                    @endif
                                    @if (strlen($model->description) > 60)
                                        <a href="javascript:void(0);" class="view-link"
                                            wire:click="toggleDescription({{ $model->id }})">View</a>
                                    @endif
                                    @if (isset($showDescription[$model->id]) && $showDescription[$model->id])
                                        <span class="full-text">{{ $model->description }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if (empty($showText[$model->id]))
                                        <span class="d-inline-block text-truncate" style="max-width: 200px;"
                                            title="{{ $model->text }}">
                                            {{ Str::limit($model->text, 60) }}
                                        </span>
                                    @endif
                                    @if (strlen($model->text) > 60)
                                        <a href="javascript:void(0);" class="view-link"
                                            wire:click="toggleText({{ $model->id }})">View</a>
                                    @endif
                                    @if (isset($showText[$model->id]) && $showText[$model->id])
                                        <span class="full-text">{{ $model->text }}</span>
                                    @endif
                                </td>
                                <td wire:click="editForm({{ $model->id }})" style="cursor: pointer;">
                                    <img src="{{ asset('storage/' . $model->img) }}" width="100px;" alt="No image">
                                </td>
                                <td>{{ $model->likes }}</td>
                                <td>{{ $model->dislikes }}</td>
                                <td>{{ $model->views }}</td>
                                <td>
                                    <a class="badge text-bg-warning p-1 mb-1" style="cursor: pointer;"
                                        wire:click="editForm({{ $model->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil" style="color: rgb(25, 53, 80);"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                        </svg>
                                    </a>
                                    <a class="badge text-bg-danger p-1 mb-1" style="cursor: pointer;"
                                        wire:click="delete({{ $model->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @elseif ($editFormPost == $model->id)
                            <tr>
                                <th>{{ $model->id }}</th>
                                <td>
                                    <select wire:model.defer="editCategory_id" wire:keydown.enter="updatePost"
                                        class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" wire:model.defer="editTitle"
                                        wire:keydown.enter="updatePost" class="form-control" placeholder="Title"
                                        required>
                                </td>
                                <td>
                                    <textarea wire:model.defer="editDescription" wire:keydown.enter="updatePost" class="form-control"
                                        placeholder="Description" required cols="3" rows="1"></textarea>
                                </td>
                                <td>
                                    <textarea wire:model.defer="editText" wire:keydown.enter="updatePost" class="form-control" placeholder="Text"
                                        required cols="3" rows="1"></textarea>
                                </td>
                                <td>
                                    <input type="file" wire:model.defer="editImg" wire:keydown.enter="updatePost"
                                        class="form-control" placeholder="Image" required>
                                </td>
                                <td>
                                    <label class="form-label">{{ $model->likes }}</label>
                                </td>
                                <td>
                                    <label class="form-label">{{ $model->dislikes }}</label>
                                </td>
                                <td>
                                    <label class="form-label">{{ $model->views }}</label>
                                </td>
                                <td>
                                    <a type="submit" class="badge text-bg-success p-1 mt-2" wire:click="updatePost">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                            <path
                                                d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>

            {{ $models->links() }}
        </div>
    @endif

</div>
