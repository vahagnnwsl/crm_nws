Vue.component('project-payments', {
    template: `
        <div class="row pl-2 pr-2">
        <div class="card card-secondary w-100  collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Payments</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse" style="margin-top: -10px!important;">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body  w-100" style="display: none">
                <form @submit.prevent="submit">
                    <fieldset>
                        <div class="form-group input-group-sm">
                            <label for="date">Date</label>
                            <input class="form-control" name="date" v-validate="'required'"  type="date" v-model="form.date">
                            <span class="error invalid-feedback d-block">{{ errors.first('date') }}</span>
                        </div>


                        <div class="form-group  input-group-sm">
                            <label for="file">Attachment</label>
                            <input type="file" name="file" class="form-control"
                                   style="padding-top: 3px!important;"
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
                <table class="table table-striped projects" v-if="payments.length">
                    <thead>
                    <tr>
                        <th> CREATOR</th>
                        <th> AMOUNT</th>
                        <th> DATE</th>
                        <th> CREATED_AT</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(payment,index) in payments">
                        <td>{{ payment.creator }}</td>
                        <td>{{ payment.amount }}</td>
                        <td>{{ payment.date }}</td>
                        <td>{{ payment.created_at }}</td>
                        <td class="text-right">
                            <a v-if="payment.attachment" :href="payment.attachment" target="_blank"><i
                                class="fa fa-file-invoice-dollar text-blue"></i> </a>
                            <a target="_blank" @click="deletePayment(payment.id)"><i class="fas fa-trash text-danger"></i> </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>

    `,
    data: function () {
        return {
            id: '',
            form: {
                date: '',
                attachment: ''
            },
            rates: [],
            payments: []
        }
    },
    props: ['currencies', 'project','rates'],
    mounted() {
        this.id = this.project.id;
        this.getPayments();

        this.form.rate = this.rates.filter(function (item){
           return item.default === 1
        })[0].id;
    },
    methods: {
        submit: function () {
            this.$validator.validate().then(valid => {
                if (valid) {
                    this.$http.post(`/dashboard/projects/${this.id}/payment`, this.form)
                        .then(() => {
                            location.reload();
                        }).catch((error) => {
                        this.$setErrorsFromResponse(error.response.data);
                    })
                }
            });
        },
        getPayments() {
            this.$http.get(`/dashboard/projects/${this.id}/payment`)
                .then((response) => {
                    this.payments = response.data.data;
                }).catch((error) => {
            })
        },
        deletePayment: function (id) {
             if (confirm('Confirm delete')){
                 this.$http.delete(`/dashboard/projects/${this.id}/payment/${id}`)
                     .then(() => {
                         this.getPayments();
                         toastr.success('Successfully deleted');

                     }).catch((error) => {
                 })
             }
        },
        formClear: function () {
            this.form.date = '';
            this.form.attachment = '';
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
