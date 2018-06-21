<div class="modal fade" id="groupExport" tabindex="-1" role="dialog" aria-labelledby="groupExport">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="groupExport">Export Group</h4>
            </div>
            <div class="modal-body">
                <textarea class="form-control" name="group-export-json" rows="10">{!! json_encode($result, JSON_PRETTY_PRINT) !!}</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary js-copy-to-clip">Copy to clipboard</button>
            </div>
        </div>
    </div>
</div>