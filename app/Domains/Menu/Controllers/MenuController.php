<?php

namespace App\Domains\Menu\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Menu\Models\Menu;
use App\Domains\Menu\Models\MenuItem;
use App\Domains\Page\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display all menus
     */
    public function index()
    {
        $menus = Menu::withCount('items')->get();
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form to create a new menu
     */
    public function create()
    {
        $locations = $this->getAvailableLocations();
        return view('admin.menus.create', compact('locations'));
    }

    /**
     * Store a new menu
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|unique:menus,location',
            'description' => 'nullable|string',
        ]);

        $menu = Menu::create($request->only('name', 'location', 'description'));
        clear_menu_cache();

        return redirect()->route('admin.menus.edit', $menu->id)
            ->with('success', 'تم إنشاء القائمة بنجاح. يمكنك الآن إضافة العناصر.');
    }

    /**
     * Edit a menu and its items (main page)
     */
    public function edit(Menu $menu)
    {
        $menu->load(['items' => function ($q) {
            $q->orderBy('sort_order');
        }, 'items.page', 'items.children']);

        $pages = Page::where('status', 'published')->orderBy('title')->get();
        $menuTree = $this->buildAdminTree($menu->items, null);

        return view('admin.menus.edit', compact('menu', 'pages', 'menuTree'));
    }

    /**
     * Update menu settings
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|unique:menus,location,' . $menu->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $menu->update([
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);
        clear_menu_cache();

        return redirect()->route('admin.menus.edit', $menu->id)
            ->with('success', 'تم تحديث إعدادات القائمة بنجاح.');
    }

    /**
     * Delete a menu
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        clear_menu_cache();
        return redirect()->route('admin.menus.index')
            ->with('success', 'تم حذف القائمة بنجاح.');
    }

    /**
     * Add a new item to the menu (AJAX)
     */
    public function storeItem(Request $request, Menu $menu)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:page,custom',
            'page_id' => 'nullable|exists:pages,id',
            'url' => 'nullable|string|max:500',
            'target' => 'in:_self,_blank',
            'icon' => 'nullable|string|max:100',
            'css_class' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:menu_items,id',
        ]);

        $maxOrder = $menu->items()->where('parent_id', $request->parent_id)->max('sort_order') ?? -1;

        $item = $menu->items()->create([
            'title' => $request->title,
            'type' => $request->type,
            'page_id' => $request->type === 'page' ? $request->page_id : null,
            'url' => $request->type === 'custom' ? $request->url : null,
            'target' => $request->target ?? '_self',
            'icon' => $request->icon,
            'css_class' => $request->css_class,
            'parent_id' => $request->parent_id,
            'sort_order' => $maxOrder + 1,
        ]);

        $item->load('page');
        clear_menu_cache();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة العنصر بنجاح.',
                'item' => $item,
                'html' => view('admin.menus._item_card', ['item' => $item, 'depth' => 0])->render(),
            ]);
        }

        return redirect()->route('admin.menus.edit', $menu->id)
            ->with('success', 'تم إضافة العنصر بنجاح.');
    }

    /**
     * Update a menu item (AJAX)
     */
    public function updateItem(Request $request, MenuItem $item)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:page,custom',
            'page_id' => 'nullable|exists:pages,id',
            'url' => 'nullable|string|max:500',
            'target' => 'in:_self,_blank',
            'icon' => 'nullable|string|max:100',
            'css_class' => 'nullable|string|max:100',
        ]);

        $item->update([
            'title' => $request->title,
            'type' => $request->type,
            'page_id' => $request->type === 'page' ? $request->page_id : null,
            'url' => $request->type === 'custom' ? $request->url : null,
            'target' => $request->target ?? '_self',
            'icon' => $request->icon,
            'css_class' => $request->css_class,
        ]);
        clear_menu_cache();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث العنصر بنجاح.',
            ]);
        }

        return redirect()->route('admin.menus.edit', $item->menu_id)
            ->with('success', 'تم تحديث العنصر بنجاح.');
    }

    /**
     * Delete a menu item (AJAX)
     */
    public function deleteItem(MenuItem $item)
    {
        $menuId = $item->menu_id;
        $item->delete();
        clear_menu_cache();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم حذف العنصر بنجاح.',
            ]);
        }

        return redirect()->route('admin.menus.edit', $menuId)
            ->with('success', 'تم حذف العنصر بنجاح.');
    }

    /**
     * Toggle item active state (AJAX)
     */
    public function toggleItem(MenuItem $item)
    {
        $item->update(['is_active' => !$item->is_active]);
        clear_menu_cache();

        return response()->json([
            'success' => true,
            'is_active' => $item->is_active,
            'message' => $item->is_active ? 'تم تفعيل العنصر.' : 'تم تعطيل العنصر.',
        ]);
    }

    /**
     * Reorder items (AJAX) - handles nested hierarchy
     */
    public function reorderItems(Request $request, Menu $menu)
    {
        $request->validate([
            'items' => 'required|array',
        ]);

        $this->updateItemOrder($request->items, null);
        clear_menu_cache();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث ترتيب العناصر بنجاح.',
        ]);
    }

    /**
     * Recursively update item order and parent
     */
    protected function updateItemOrder(array $items, ?int $parentId): void
    {
        foreach ($items as $index => $itemData) {
            MenuItem::where('id', $itemData['id'])->update([
                'sort_order' => $index,
                'parent_id' => $parentId,
            ]);

            if (!empty($itemData['children'])) {
                $this->updateItemOrder($itemData['children'], $itemData['id']);
            }
        }
    }

    /**
     * Build tree for admin display (all items, not just active)
     */
    protected function buildAdminTree($items, $parentId): \Illuminate\Support\Collection
    {
        return $items
            ->where('parent_id', $parentId)
            ->sortBy('sort_order')
            ->map(function ($item) use ($items) {
                $item->admin_children = $this->buildAdminTree($items, $item->id);
                return $item;
            })
            ->values();
    }

    /**
     * Get available location options
     */
    protected function getAvailableLocations(?int $excludeId = null): array
    {
        $used = Menu::when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->pluck('location')
            ->toArray();

        $all = [
            'header' => 'الهيدر (القائمة العلوية)',
            'footer' => 'الفوتر (القائمة السفلية)',
        ];

        return array_diff_key($all, array_flip($used));
    }
}
