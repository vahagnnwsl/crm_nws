Vue.component('order-person-component', {
    template: `
        <div class="modal fade" id="order__person" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h2 class="card-title">Add new person</h2>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                                <span aria-hidden="true" class="text-white">×</span>
                            </button>
                        </div>

                    </div>
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="person_first_name">First name</label>
                                        <input type="text" id="person_first_name" class="form-control"
                                               v-model="form.first_name" name="first_name"
                                               v-validate="'required|max:200'" data-vv-as="First name">
                                        <span
                                            class="error invalid-feedback d-block mb-2">{{ errors.first('first_name') }}</span>

                                    </div>

                                    <div class="form-group">
                                        <label for="person_last_name">Last name</label>
                                        <input type="text" id="person_last_name" class="form-control"
                                               v-model="form.last_name" name="last_name" v-validate="'required|max:200'"
                                               data-vv-as="Last name">
                                        <span
                                            class="error invalid-feedback d-block mb-2">{{ errors.first('last_name') }}</span>

                                    </div>

                                    <div class="form-group">
                                        <label for="person_position">Position</label>
                                        <input type="text" id="person_position" class="form-control"
                                               v-model="form.position" name="position">
                                        <span
                                            class="error invalid-feedback d-block mb-2">{{ errors.first('position') }}</span>

                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="person_email">E-mail</label>
                                        <input type="email" id="person_email" class="form-control" v-model="form.email"
                                               name="email">
                                        <span
                                            class="error invalid-feedback d-block mb-2">{{ errors.first('email') }}</span>

                                    </div>

                                    <div class="form-group">
                                        <label for="person_telegram">Telegram</label>
                                        <input type="text" id="person_telegram" class="form-control"
                                               v-model="form.telegram" name="telegram">
                                        <span
                                            class="error invalid-feedback d-block mb-2">{{ errors.first('telegram') }}</span>

                                    </div>

                                    <div class="form-group">
                                        <label for="person_skype">Skype</label>
                                        <input type="text" id="person_skype" class="form-control" v-model="form.skype"
                                               name="skype">
                                        <span
                                            class="error invalid-feedback d-block mb-2">{{ errors.first('skype') }}</span>

                                    </div>

                                    <div class="form-group">
                                        <label for="person_phone">Phone</label>
                                        <input type="number" id="person_phone" class="form-control" v-model="form.phone"
                                               name="phone">
                                        <span
                                            class="error invalid-feedback d-block mb-2">{{ errors.first('phone') }}</span>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <hr/>
                                    <div class="btn-group float-right">
                                        <button type="button" data-dismiss="modal" class="btn btn-default">Close
                                        </button>
                                        <button type="submit" class="btn btn-dark"><i class="fa fa-check"></i> Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        </div>
    `,

    data: function () {
        return {
            form: {
                first_name: '',
                last_name: '',
                position: '',
                email: '',
                phone: '',
                telegram: '',
                skype: '',
                order_id: ''
            },
            url: '/dashboard/order-peoples'
        }
    },
    props: ['order'],
    mounted() {
        let _this = this;

        $(document).on('hidden.bs.modal', '#order__person', function () {
            _this.setDefaults();

            _this.url = '/dashboard/order-peoples';
        });

        $(document).on('order_person_id.update', function (e, response) {
            _this.getPerson(response);
            _this.url = `/dashboard/order-peoples/${response}`;

        });


    },
    methods: {
        submit: function () {
            this.form.order_id = this.order.id;
            this.$validator.validate().then(valid => {
                if (valid) {
                    this.$http.post(this.url, this.form)
                        .then((response) => {
                            setTimeout(function () {
                                location.reload();
                            }, 200)
                        }).catch((error) => {
                        this.$setErrorsFromResponse(error.response.data);
                    })

                }

            });
        },
        getPerson: function (id) {
            this.$http.get(`/dashboard/order-peoples/${id}`)
                .then((response) => {

                    let form = this.form;
                    let data = response.data.data;


                    for (let key in form) {
                        if (data.hasOwnProperty(key)) {
                            form[key] = data[key]
                        }
                    }

                }).catch((error) => {

            })
        },
        setDefaults: function () {

            this.form.first_name = '';
            this.form.last_name = '';
            this.form.position = '';
            this.form.email = '';
            this.form.phone = '';
            this.form.telegram = '';
            this.form.skype = '';
            this.form.order_id = '';

        }

    }
})
