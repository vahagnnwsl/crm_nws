<div class="modal fade" id="user__create" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-body">
                <user-crate-component :roles="{{json_encode($roles)}}"></user-crate-component>
            </div>
        </div>
    </div>
</div>

@push('js')

    <script src="/components/user-crate.js"></script>

@endpush
