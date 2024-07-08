<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Models\Page;
use illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Edit Page'), Layout('components.layouts.admin')] class extends Component {
    use Toast;

    public Page $page;
    public string $body = '';
    public string $title = '';
    public string $slug = '';
    public string $seo_title = '';
    public string $meta_description = '';
    public string $meta_keywords = '';

    // Initialise le composant avec la page donnée.
    public function mount(Page $page): void
    {
        $this->page = $page;

        $this->fill($this->page);
    }

    // Méthode appelée avant la mise à jour de la propriété $title
    public function updatedTitle($value): void
    {
        $this->generateSlug($value);
    }

    // Enregistre les modifications de la page
    public function save()
    {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|max:65000',
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('pages')->ignore($this->page->id)],
            'seo_title' => 'required|max:70',
            'meta_description' => 'required|max:160',
            'meta_keywords' => 'required|regex:/^[A-Za-z0-9-éèàù]{1,50}?(,[A-Za-z0-9-éèàù]{1,50})*$/',
        ]);

        $this->page->update($data);

        $this->success(__('Page edited with success.'), redirectTo: '/admin/pages/index');
    }

    // Méthode pour générer le slug à partir du titre
    private function generateSlug(string $title): void
    {
        $this->slug = Str::of($title)->slug('-');
    }
}; ?>

<div>
    <a href="/admin/dashboard" title="{{ __('Back to Dashboard') }}">
        <x-card title="{{ __('Edit a page') }}" shadow separator progress-indicator>
    </a>
    <x-form wire:submit="save">
        <x-input type="text" wire:model="title" label="{{ __('Title') }}" placeholder="{{ __('Enter the title') }}"
            wire:change="$refresh" />
        <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
        <x-editor wire:model="body" label="{{ __('Content') }}" :config="config('tinymce.config')"
            folder="{{ 'photos/' . now()->format('Y/m') }}" />
        <x-card title="{{ __('SEO') }}" shadow separator>
            <x-input placeholder="{{ __('Title') }}" wire:model="seo_title" hint="{{ __('Max 70 chars') }}" />
            <br>
            <x-textarea label="{{ __('META Description') }}" wire:model="meta_description"
                hint="{{ __('Max 160 chars') }}" rows="2" inline />
            <br>
            <x-textarea label="{{ __('META Keywords') }}" wire:model="meta_keywords"
                hint="{{ __('Keywords separated by comma') }}" rows="1" inline />
        </x-card>
        <x-slot:actions>
            <x-button label="{{ __('Cancel') }}" icon="o-hand-thumb-down" class="btn-outline"
                link="/admin/pages/index" />
            <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                class="btn-primary" />
        </x-slot:actions>
    </x-form>
    </x-card>
</div>
