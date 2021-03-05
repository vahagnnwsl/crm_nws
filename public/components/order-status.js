Vue.component('order-status', {
    template: `
        <div class="card-body" style="display: block">
        <form @submit.prevent="submit">
            <div class="form-group">
                <label for="agent">Status</label>
                <select class="form-control" id="status" name="status" v-model="form.status">
                    <option :value="index" v-for="(status,index) in statuses">{{ status }}</option>
                </select>
                <span class="error invalid-feedback d-block">{{ errors.first('status') }}</span>

            </div>

            <div class="form-group">
                <label for="comment">Message</label>
                <textarea class="form-control" name="comment" id="comment" rows="2" v-model="form.comment"></textarea>
                <span class="error invalid-feedback d-block">{{ errors.first('comment') }}</span>
            </div>

            <div class="form-group">
                <label for="comment">Attachment</label>
                <input type="file" name="attachment" class="form-control" style="padding-top: 3px!important;"
                       ref="attachment" v-on:change="handleFileUpload">
                <span class="error invalid-feedback d-block" ref="attachment-error">{{ errors.first('attachment') }}</span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success float-right mb-2"><i
                    class="fa fa-check-circle"></i> Submit
                </button>

            </div>
        </form>

        <div class="form-group mt-2">

            <div class="row w-100" style="max-height: 600px;overflow-y: auto">
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
        this.form.status = this.order.status;
        this.getComments();
    },
    methods: {
        submit: function () {

            this.$validator.validate().then(valid => {
                if (valid) {
                    this.$http.put(`/dashboard/orders/${this.id}/status`, this.form)
                        .then(() => {
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
