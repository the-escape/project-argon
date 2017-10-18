@if($grpImage = $group->getSetting('image'))

    <span class="grp-preview preview-popover" title="Block preview" data-container="body" data-content=""data-placement="top" data-trigger="hover" data-img="{{ $grpImage }}">
        <i class="fa fa-picture-o" aria-hidden="true"></i>
    </span>

@else

    <span class="grp-preview" title="No preview available">
        <i class="fa fa-ban" aria-hidden="true"></i>
    </span>

@endif
