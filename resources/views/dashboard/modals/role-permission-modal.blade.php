<div class="modal fade" id="role__permission" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-body">
                <role-permissions-component :permissions="{{json_encode($permissions)}}"></role-permissions-component>
            </div>
        </div>
    </div>
</div>

@push('js')

    <script>

        $(document).on("click", ".edit-btn", function () {
            $(document).trigger('role_id.update',$(this).attr('data-id'));
        });

    </script>

    <script src="/components/role_permissions.js"></script>

@endpush
