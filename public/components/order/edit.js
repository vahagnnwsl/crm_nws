Vue.component('order-edit', {

    template: `
        <div class="card  card-primary">
        <div class="card-header">
            <h2 class="card-title">General</h2>
        </div>
        <div class="card-body">
            <form method="POST" @submit.prevent="submit">
                <div class="form-group">
                    <label for="inputName">Name *</label>
                    <input type="text" id="inputName" class="form-control" name="name" v-model="form.name"
                           v-validate="'required'">
                    <span class="error invalid-feedback d-block">{{ errors.first('name') }}</span>
                </div>

                <div class="form-group">
                    <label for="agent">Agent * </label>
                    <select class="form-control" id="agent" name="agent_id" v-model="form.agent_id"
                            v-validate="'required'">
                        <option value="">Select one</option>
                        <option :value="agent.id" v-for="agent in agents">
                            {{ agent.first_name + ' ' + agent.last_name }}
                        </option>
                    </select>
                    <span class="error invalid-feedback d-block">{{ errors.first('agent_id') }}</span>
                </div>

                <div class="form-group">
                    <label for="developer_id">Developer * </label>
                    <select class="form-control" id="developer_id" name="developer_id" v-model="form.developer_id"
                            v-validate="'required'">
                        <option value="">Select one</option>
                        <option :value="developer.id" v-for="developer in developers">
                            {{ developer.first_name + ' ' + developer.last_name }}
                        </option>
                    </select>
                    <span class="error invalid-feedback d-block">{{ errors.first('developer_id') }}</span>
                </div>
<!--                <div class="form-group">-->
<!--                    <div class="form-check-inline">-->
<!--                        <label class="form-check-label">-->
<!--                            <input type="radio" class="form-check-input" name="optradio" @click="show('expert')"-->
<!--                                   :checked="showType==='expert'">Expert-->
<!--                        </label>-->
<!--                    </div>-->
<!--                    <div class="form-check-inline">-->
<!--                        <label class="form-check-label">-->
<!--                            <input type="radio" class="form-check-input" name="optradio" @click="show('team_lid')"-->
<!--                                   :checked="showType==='team_lid'">Team lead-->
<!--                        </label>-->
<!--                    </div>-->


<!--                </div>-->
<!--                <div class="form-group" v-if="showType === 'expert'">-->
<!--                    <label for="expert_id">Expert </label>-->
<!--                    <select class="form-control" id="expert_id" name="expert_id" v-model="form.expert_id">-->
<!--                        <option value="">Select one</option>-->
<!--                        <option :value="developer.id" v-for="developer in developers">-->
<!--                            {{ developer.first_name + ' ' + developer.last_name }}-->
<!--                        </option>-->
<!--                    </select>-->
<!--                    <span class="error invalid-feedback d-block">{{ errors.first('expert_id') }}</span>-->
<!--                </div>-->

<!--                <div class="form-group" v-if="showType === 'team_lid'">-->
<!--                    <label for="team_lid_id">Team lid </label>-->
<!--                    <select class="form-control" id="team_lid_id" name="team_lid_id" v-model="form.team_lid_id">-->
<!--                        <option value="">Select one</option>-->
<!--                        <option :value="developer.id" v-for="developer in developers">-->
<!--                            {{ developer.first_name + ' ' + developer.last_name }}-->
<!--                        </option>-->
<!--                    </select>-->
<!--                    <span class="error invalid-feedback d-block">{{ errors.first('team_lid_id') }}</span>-->
<!--                </div>-->

                <div class="form-group">
                    <label for="source">Source * </label>
                    <select class="form-control" id="source" name="source" v-model="form.source"
                            v-validate="'required'">
                        <option value="">Select one</option>
                        <option :value="source" v-for="source in sources">{{ source }}</option>
                    </select>
                    <span class="error invalid-feedback d-block">{{ errors.first('source') }}</span>
                </div>

                <div class="form-group">
                    <label for="link">Link *</label>
                    <input type="text" id="link" class="form-control" name="link" v-model="form.link"
                           v-validate="'required'">
                    <span class="error invalid-feedback d-block">{{ errors.first('link') }}</span>
                </div>

                <div class="form-group">
                    <div class="input-group input-group-lg mb-3">
                        <div class="input-group-prepend">
                            <button type="button"
                                    class="btn btn-dark dropdown-toggle currency_show_btn"
                                    data-toggle="dropdown" aria-expanded="false"
                                    style="background-color: grey;border-radius: 0;border-color: grey">
                                Currency
                            </button>
                            <ul class="dropdown-menu" style="">
                                <li class="dropdown-item" v-for="currency in currencies">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               :id="'currency__'+currency.label"
                                               type="radio" name="currency"
                                               :value="currency.label"
                                               v-model="form.currency"
                                        >
                                        <label class="form-check-label"
                                               :for="'currency__'+currency.label">
                                            <i :class="currency.icon"></i>
                                            {{ currency.label }}

                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <input type="number" class="form-control" name="budget" placeholder="Budget"
                               v-model="form.budget">
                        <span class="error invalid-feedback d-block">{{ errors.first('currency') }}</span>
                        <span class="error invalid-feedback d-block">{{ errors.first('budget') }}</span>

                    </div>
                </div>

                <div class="form-group">
                    <label for="stacks">Stacks *</label>
                    <select ref="select2" class="select2" style="width: 100%;" name="stacks[]" id="stacks"
                            multiple="multiple">
                    </select>
                    <span class="error invalid-feedback d-block">{{ errors.first('stacks') }}</span>
                </div>

                <div class="form-group">
                    <label for="inputDescription">Description </label>
                    <textarea id="inputDescription" class="form-control" rows="4" name="description"
                              v-model="form.description"></textarea>
                    <span class="error invalid-feedback d-block">{{ errors.first('description') }}</span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success float-right"><i class="fa fa-check-circle"></i>Submit
                    </button>

                </div>
            </form>
        </div>
        </div>
    `,
    data: function () {
        return {
            form: {
                name: '',
                agent_id: '',
                developer_id: '',
                source: '',
                link: '',
                stacks: [],
                description: '',
                budget: '',
                currency: ''
            }
        }
    },
    props: ['agents', 'developers', 'sources', 'stacks', 'currencies', 'order'],
    mounted() {

        for (const [key] of Object.entries(this.form)) {
            if (this.order.hasOwnProperty(key)) {
                this.form[key] = this.order[key];
            }
        }


        this.form.team_lid_id ? this.showType = 'team_lid' : this.showType = 'expert';


        let vm = this

        let select = $(this.$refs.select2)

        select
            .select2({
                placeholder: 'Select',
                width: '100%',
                allowClear: true,
                data: this.stacks
            })
            .on('change', function () {
                vm.form.stacks = select.val();
            });



        select.val(this.order.stacks.map(function (item) {
            return item.id
        })).trigger('change')

    },

    methods: {
        submit: function () {
            this.$validator.validate().then(valid => {
                if (valid) {
                    this.$http.put(`/dashboard/orders/${this.order.id}`, this.form)
                        .then((response) => {
                            this.$validator.reset();
                            location.reload();
                        }).catch((error) => {
                        this.$setErrorsFromResponse(error.response.data);
                    })
                }

            });
        }
    }
})
