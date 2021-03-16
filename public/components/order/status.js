Vue.component('order-status', {
    template: `
        <div class="card card-purple w-100 collapsed-card">
        <div class="card-header">
            <h3 class="card-title">Change status</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse" style="margin-top: -10px!important;">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: none">
            <form @submit.prevent="submit">
                <fieldset :disabled="disabled">
                    <div class="form-group">
                        <label for="agent">Status</label>
                        <select class="form-control" id="status" name="status" v-model="form.status">
                            <option :value="index" v-for="(status,index) in statuses">{{ status }}</option>
                        </select>
                        <span class="error invalid-feedback d-block">{{ errors.first('status') }}</span>

                    </div>

                    <div class="form-group">
                        <label for="comment">Message</label>
                        <textarea class="form-control" name="comment" id="comment" rows="2"
                                  v-model="form.comment"></textarea>
                        <span class="error invalid-feedback d-block">{{ errors.first('comment') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="comment">Attachment</label>
                        <input type="file" name="attachment" class="form-control" style="padding-top: 3px!important;"
                               ref="attachment" v-on:change="handleFileUpload">
                        <span class="error invalid-feedback d-block"
                              ref="attachment-error">{{ errors.first('attachment') }}</span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right mb-2"><i
                            class="fa fa-check-circle"></i> Submit
                        </button>

                    </div>
                </fieldset>
            </form>
        </div>

        <div class="form-group p-4 mt-2">

            <div class="row w-100" style="max-height: 600px;overflow-y: auto" v-if="comments.length">
                <div class="col-12 p-3 border ">
                    <div class="post" style="padding-bottom: 0!important;" :key="index"
                         v-for="(comment,index) in comments">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" :src="comment.creator.avatar" alt="user image">
                            <span class="username">
                          <a href="#">{{ comment.creator.fullName }}</a>
                        </span>
                            <span class="description">Change status to <span
                                class="text-danger font-weight-bold"> {{ comment.status }}</span> -
                                {{ comment.date }}</span>
                        </div>

                        <p style="font-size: 13px">{{ comment.text }}</p>

                        <p v-if="comment.attachment">
                            <a :href="comment.attachment" target="_blank" class="link-black text-sm"><i
                                class="fas fa-link mr-1"></i> Attachment</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
        </div>

    `,
    data: function () {
        return {
            id: '',
            disabled: false,
            form: {
                status: '',
                comment: '',
                attachment: ''
            },
            comments: []
        }
    },
    props: ['statuses', 'order'],
    mounted() {
        this.id = this.order.id;
        if (this.order.status === 12) {
            this.disabled = true;
        }
        this.form.status = this.order.status;
        this.getComments();
    },
    methods: {
        submit: function () {

            this.$validator.validate().then(valid => {
                if (valid) {
                    this.$http.put(`/dashboard/orders/${this.id}/status`, this.form)
                        .then(() => {
                            if (this.form.status === 12) {
                                this.disabled = true;
                            }
                            this.getComments();
                            this.form.comment = '';
                            this.form.attachment = '';
                            this.$validator.reset();
                            this.$refs['attachment'].value = null;
                            this.$refs['attachment-error'].innerHTML = '';
                            toastr.success('Successfully changed');

                        }).catch((error) => {
                        this.$setErrorsFromResponse(error.response.data);
                    })
                }
            });
        },

        getComments: function () {

            this.$http.get(`/dashboard/orders/${this.id}/status`)
                .then((response) => {
                    this.comments = response.data.data;
                }).catch(() => {
            })
        },
        handleFileUpload: function () {
            var self = this;
            var file = this.$refs['attachment'].files[0];
            var reader = new FileReader();
            if (typeof file !== 'object') {
                self.form.attachment = '';
                return;
            }
            reader.onloadend = function () {
                self.form.attachment = reader.result;
            };
            reader.readAsDataURL(file);
        },

    }
})
