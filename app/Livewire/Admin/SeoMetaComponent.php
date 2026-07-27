<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\SeoMeta;
use Livewire\Component;
use Livewire\WithPagination;

class SeoMetaComponent extends Component
{
    use WithPagination;

    public const TargetStaticPage = 'static_page';

    public const TargetCategory = 'category';

    public const TargetProduct = 'product';

    public $search = '';

    public $modalOpen = false;

    public $isEdit = false;

    public $seoMetaId;

    public $targetType = self::TargetStaticPage;

    public $targetValue = 'default';

    public $title;

    public $keywords;

    public $description;

    public $canonicalUrl;

    public $robots = 'index, follow';

    public $isActive = true;

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'targetType' => ['required', 'in:'.implode(',', [
                self::TargetStaticPage,
                self::TargetCategory,
                self::TargetProduct,
            ])],
            'targetValue' => ['required'],
            'title' => ['required', 'string', 'max:255'],
            'keywords' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'canonicalUrl' => ['nullable', 'url', 'max:255'],
            'robots' => ['required', 'string', 'max:255'],
            'isActive' => ['boolean'],
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedTargetType(): void
    {
        $this->targetValue = array_key_first($this->pageOptionsForTargetType($this->targetType)) ?? '';
    }

    public function openCreateModal(): void
    {
        $this->openModal();
    }

    public function openModal(?int $id = null): void
    {
        $this->resetValidation();
        $this->resetForm();

        if ($id) {
            $seoMeta = SeoMeta::findOrFail($id);

            $this->seoMetaId = $seoMeta->id;
            $this->fillTargetSelection($seoMeta);
            $this->title = $seoMeta->title;
            $this->keywords = $seoMeta->keywords;
            $this->description = $seoMeta->description;
            $this->canonicalUrl = $seoMeta->canonical_url;
            $this->robots = $seoMeta->robots;
            $this->isActive = $seoMeta->is_active;
            $this->isEdit = true;
        }

        $this->modalOpen = true;
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function resetForm(): void
    {
        $this->reset([
            'seoMetaId',
            'title',
            'keywords',
            'description',
            'canonicalUrl',
            'isEdit',
        ]);

        $this->targetType = self::TargetStaticPage;
        $this->targetValue = 'default';
        $this->robots = 'index, follow';
        $this->isActive = true;
    }

    public function save(): void
    {
        $validated = $this->validate();
        $targetData = $this->resolveTargetData($validated['targetType'], (string) $validated['targetValue']);

        SeoMeta::updateOrCreate(
            ['id' => $this->seoMetaId],
            [
                ...$targetData,
                'type' => SeoMeta::TypeShopSite,
                'title' => trim((string) $validated['title']),
                'keywords' => $this->nullableString($validated['keywords']),
                'description' => $this->nullableString($validated['description']),
                'canonical_url' => $this->nullableString($validated['canonicalUrl']),
                'robots' => trim((string) $validated['robots']),
                'is_active' => (bool) $validated['isActive'],
            ]
        );

        $this->modalOpen = false;
        $this->dispatch('notify', message: 'SEO data saved successfully');
    }

    public function toggleStatus(int $id): void
    {
        $seoMeta = SeoMeta::findOrFail($id);
        $seoMeta->update(['is_active' => ! $seoMeta->is_active]);
    }

    public function render()
    {
        $seoMetas = SeoMeta::query()
            ->where('type', SeoMeta::TypeShopSite)
            ->when($this->search, function ($query): void {
                $query->where(function ($query): void {
                    $query
                        ->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('route_name', 'like', '%'.$this->search.'%')
                        ->orWhere('path', 'like', '%'.$this->search.'%')
                        ->orWhere('slug', 'like', '%'.$this->search.'%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.seo-meta-component', [
            'seoMetas' => $seoMetas,
            'targetTypeOptions' => $this->targetTypeOptions(),
            'pageOptions' => $this->pageOptionsForTargetType($this->targetType),
        ]);
    }

    /**
     * @return array<string, string>
     */
    protected function targetTypeOptions(): array
    {
        return [
            self::TargetStaticPage => 'Page',
            self::TargetCategory => 'Category',
            self::TargetProduct => 'Product',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function pageOptionsForTargetType(string $targetType): array
    {
        return match ($targetType) {
            self::TargetCategory => Category::query()
                ->select(['id', 'name'])
                ->orderBy('name')
                ->get()
                ->mapWithKeys(fn (Category $category): array => [(string) $category->id => $this->displayLabel($category->name)])
                ->all(),
            self::TargetProduct => Product::query()
                ->select(['id', 'name'])
                ->orderBy('name')
                ->get()
                ->mapWithKeys(fn (Product $product): array => [(string) $product->id => $this->displayLabel($product->name)])
                ->all(),
            default => $this->staticPageOptions(),
        };
    }

    /**
     * @return array<string, string>
     */
    protected function staticPageOptions(): array
    {
        return [
            'default' => 'Default SEO',
            'home' => 'Home',
            'type:pro-loudspeaker' => 'Pro Loudspeaker Listing',
            'type:home-loudspeaker' => 'Home Loudspeaker Listing',
            'cart' => 'Cart',
            'checkout' => 'Checkout',
            'guest.checkout' => 'Guest Checkout',
            'razorpay.payment.page' => 'Payment Page',
            'checkout.success' => 'Checkout Success',
            'checkout.failed' => 'Checkout Failed',
            'login' => 'Login',
            'register' => 'Register',
            'password.request' => 'Forgot Password',
            'password.reset' => 'Reset Password',
            '404' => '404 Page',
        ];
    }

    public function targetLabel(SeoMeta $seoMeta): string
    {
        if ($seoMeta->entity_type === Category::class && $seoMeta->entity_id) {
            $categoryName = Category::query()->whereKey($seoMeta->entity_id)->value('name');

            return $categoryName ? $this->displayLabel($categoryName) : 'Category #'.$seoMeta->entity_id;
        }

        if ($seoMeta->entity_type === Product::class && $seoMeta->entity_id) {
            $productName = Product::query()->whereKey($seoMeta->entity_id)->value('name');

            return $productName ? $this->displayLabel($productName) : 'Product #'.$seoMeta->entity_id;
        }

        if ($seoMeta->page_type === SeoMeta::PageTypeDefault) {
            return 'Default SEO';
        }

        if ($seoMeta->route_name === 'type.category' && $seoMeta->path) {
            $targetValue = 'type:'.ltrim($seoMeta->path, '/');

            return $this->staticPageOptions()[$targetValue] ?? $seoMeta->path;
        }

        if ($seoMeta->path === '/404') {
            return '404 Page';
        }

        return $seoMeta->route_name
            ? ($this->staticPageOptions()[$seoMeta->route_name] ?? $seoMeta->route_name)
            : ($seoMeta->path ?: 'Default SEO');
    }

    /**
     * @return array{page_type: string, route_name: string|null, path: string|null, entity_type: string|null, entity_id: int|null, slug: string|null}
     */
    protected function resolveTargetData(string $targetType, string $targetValue): array
    {
        $data = [
            'page_type' => SeoMeta::PageTypePage,
            'route_name' => null,
            'path' => null,
            'entity_type' => null,
            'entity_id' => null,
            'slug' => null,
        ];

        if ($targetType === self::TargetCategory) {
            $category = Category::findOrFail((int) $targetValue);

            return [
                ...$data,
                'page_type' => SeoMeta::PageTypeCategory,
                'entity_type' => Category::class,
                'entity_id' => $category->id,
                'slug' => $category->slug,
            ];
        }

        if ($targetType === self::TargetProduct) {
            $product = Product::findOrFail((int) $targetValue);

            return [
                ...$data,
                'page_type' => SeoMeta::PageTypeProduct,
                'entity_type' => Product::class,
                'entity_id' => $product->id,
                'slug' => $product->slug,
            ];
        }

        if ($targetValue === 'default') {
            return [
                ...$data,
                'page_type' => SeoMeta::PageTypeDefault,
            ];
        }

        if (str_starts_with($targetValue, 'type:')) {
            return [
                ...$data,
                'route_name' => 'type.category',
                'path' => '/'.str_replace('type:', '', $targetValue),
            ];
        }

        if ($targetValue === '404') {
            return [
                ...$data,
                'path' => '/404',
            ];
        }

        return [
            ...$data,
            'route_name' => $targetValue,
        ];
    }

    protected function fillTargetSelection(SeoMeta $seoMeta): void
    {
        if ($seoMeta->entity_type === Category::class && $seoMeta->entity_id) {
            $this->targetType = self::TargetCategory;
            $this->targetValue = (string) $seoMeta->entity_id;

            return;
        }

        if ($seoMeta->entity_type === Product::class && $seoMeta->entity_id) {
            $this->targetType = self::TargetProduct;
            $this->targetValue = (string) $seoMeta->entity_id;

            return;
        }

        $this->targetType = self::TargetStaticPage;

        if ($seoMeta->page_type === SeoMeta::PageTypeDefault) {
            $this->targetValue = 'default';

            return;
        }

        if ($seoMeta->route_name === 'type.category' && $seoMeta->path) {
            $this->targetValue = 'type:'.ltrim($seoMeta->path, '/');

            return;
        }

        if ($seoMeta->path === '/404') {
            $this->targetValue = '404';

            return;
        }

        $this->targetValue = $seoMeta->route_name ?: 'default';
    }

    protected function nullableString(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    protected function displayLabel(?string $value): string
    {
        return str_replace(
            ['â„¦', 'â€', 'â€œ', 'â€™', 'â€“', 'â€”'],
            ['Ω', '"', '"', "'", '-', '-'],
            (string) $value
        );
    }
}
