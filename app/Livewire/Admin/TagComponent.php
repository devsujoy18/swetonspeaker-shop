<?php

namespace App\Livewire\Admin;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class TagComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $modalOpen = false;
    public $isEdit = false;

    public $tagId;
    public $title;
    public $status = true;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:tags,title,' . $this->tagId,
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->validate();

        Tag::updateOrCreate(
            ['id' => $this->tagId],
            [
                'title' => trim((string) $this->title),
                'status' => $this->status,
            ]
        );

        $this->modalOpen = false;
        $this->dispatch('notify', message: 'Tag saved successfully');
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->resetForm();

        if ($id) {
            $tag = Tag::findOrFail($id);
            $this->tagId = $tag->id;
            $this->title = $tag->title;
            $this->status = $tag->status;
            $this->isEdit = true;
        }

        $this->modalOpen = true;
    }

    public function openCreateModal()
    {
        $this->openModal();
    }

    public function resetForm()
    {
        $this->reset(['tagId', 'title', 'status', 'isEdit']);
        $this->status = true;
    }

    public function toggleStatus($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->update(['status' => ! $tag->status]);
    }

    public function render()
    {
        $tags = Tag::when($this->search, function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.tag-component', [
            'tags' => $tags,
        ]);
    }
}
