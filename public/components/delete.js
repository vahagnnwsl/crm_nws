

Vue.component('delete', {
    template: `
        <div class="modal fade" id="model__delete" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Delete</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    `,
    data: function () {
        return {

        }
    },
    mounted(){
        // let _this = this;
        // $(document).on('loader.update', function (e, response) {
        //     _this.show = response;
        // });
    }
})
