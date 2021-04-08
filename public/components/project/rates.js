Vue.component('project-rates', {
    template: `
        <div class="row pl-2 pr-2">
        <div class="card card-info w-100 collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Rates</h3>
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
                            <input class="form-control" name="date" v-validate="'required'" type="date"
                                   v-model="form.date">
                            <span class="error invalid-feedback d-block">{{ errors.first('date') }}</span>
                        </div>
                        <div class="form-group input-group-sm">
                            <input type="number" class="form-control" v-validate="'required|min_value:1|max_value:31'" name="pay_day"
                                   placeholder="Pay day"
                                   data-vv-as="Pay day"
                                   v-model="form.pay_day">
                            <span class="error invalid-feedback d-block">{{ errors.first('pay_day') }}</span>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <button type="button"
                                            class="btn btn-dark dropdown-toggle currency_show_btn"
                                            data-toggle="dropdown" aria-expanded="false"
                                            style="background-color: grey;border-radius: 0;border-color: grey">
                                        Currency
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-item">
                                            <div class="form-check" v-for="(currency,index) in currencies">
                                                <input class="form-check-input" v-validate="'required'"
                                                       :id="'c'+index" type="radio"
                                                       name="currency" :value="currency.label"
                                                       v-model="form.currency">
                                                <label class="form-check-label" :for="'c'+index"><i
                                                    :class="currency.icon"></i>{{ currency.label }}</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->


                                <input type="number" class="form-control" v-validate="'required'" name="budget"
                                       placeholder="Budget"
                                       v-model="form.budget">
                                <span class="error invalid-feedback d-block">{{ errors.first('budget') }}</span>
                                <span
                                    class="error invalid-feedback d-block">{{ errors.first('currency') }}</span>

                            </div>


                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-success float-right mb-2"><i
                                class="fa fa-check-circle"></i> Submit
                            </button>

                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="form-group p-4 mt-2  w-100">
                <table class="table table-striped projects" v-if="rates.length">
                    <thead>
                    <tr>
                        <th> CURRENCY</th>
                        <th> BUDGET</th>
                        <th> DATE</th>
                        <th> PAY DAY</th>
                        <th> DEFAULT</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(rate,index) in rates">
                        <td>{{ rate.currency }}</td>
                        <td>{{ rate.budget }}</td>
                        <td>{{ rate.date}}</td>
                        <td>{{ rate.pay_day }}</td>
                        <td>{{ rate.default}}</td>
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
                pay_day: '',
                budget: '',
                currency: ''
            },
            rates: []
        }
    },
    props: ['currencies', 'project','rates'],
    mounted() {
        this.id = this.project.id;
    },
    methods: {
        submit: function () {

            this.$validator.validate().then(valid => {
                if (valid) {
                    this.$http.put(`/dashboard/projects/${this.id}/rates`, this.form)
                        .then(() => {
                            location.reload();
                        }).catch((error) => {
                        this.$setErrorsFromResponse(error.response.data);
                    })
                }
            });
        },



    }


})
