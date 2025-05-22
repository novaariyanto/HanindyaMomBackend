@props(['id', 'editButton' => false, 'deleteButton' => false])

<div class="btn-group" role="group">
    @if($editButton)
    <button type="button" class="btn btn-sm btn-info btn-edit" data-id="{{ $id }}" title="Edit">
        <i class="fas fa-edit"></i>
    </button>
    @endif

    @if($deleteButton)
    <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $id }}" title="Hapus">
        <i class="fas fa-trash"></i>
    </button>
    @endif
</div> 