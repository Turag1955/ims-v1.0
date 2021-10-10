<ol class="dd-list">
    @forelse ($menuItem as $item )
        <li class="dd-item" data-id="{{ $item->id }}">
            <div class="pull-right item-action">
                <button type="button" class="btn btn-danger btn-sm float-right"
                    onclick="deletModule({{ $item->id }})">
                    <i class="fas fa-trash"></i>
                </button>
                <form action="{{ route('menu.module.delete', ['module' => $item->id]) }}" method="POST"
                    id="delete_form_{{ $item->id }}" style="display: none">
                    @csrf
                    @method('DELETE')
                </form>
                <a href="{{ route('menu.module.edit', ['menu' => $item->menu_id, 'module' => $item->id]) }}"
                    class="btn btn-primary btn-sm float-right"><i class="fas fa-edit"></i></a>
                <div class="dd-handle">
                    @if ($item->type == 1)
                        <strong>Divider: {{ $item->devider_name }}</strong>
                    @else
                        <span> {{ $item->module_name }}</span> <small class="url">{{ $item->url }}</small>
                    @endif

                </div>
                @if (!$item->children->isEmpty())
                    <x-menu-builder :menuItem="$item->children" />
                @endif
            </div>
        </li>
    @empty
        <div class="text-center">
            No Menu Item Found
        </div>
    @endforelse
</ol>
