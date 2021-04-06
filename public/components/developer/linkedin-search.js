Vue.component('developer-linkedin-search', {

    template: `
        <div data-select2-id="33" class="card card-primary p-2" v-if="show">
        <div class="card-header">
            <h3 class="card-title">Linkedin search</h3>
            <div class="card-tools">
                <button type="button" data-card-widget="collapse" class="btn btn-tool"><i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div data-select2-id="31" class="card-body" style="display: block;">
            <form @submit.prevent="onsubmit">
                <div class="row">
                    <div class="input-group input-group-md">
                        <input type="text" class="form-control" v-model="key" name="key" v-validate="'required|min:3'">
                        <button type="submit" class="btn btn-primary btn-flat">Go</button>
                        <span class="error invalid-feedback d-block"
                              ref="attachment-error">{{ errors.first('key') }}</span>
                    </div>
                </div>
            </form>
            <div class="row border p-2" v-if="result.length">
                <div class="col-md-12">
                    <button type="button" class="btn float-right" data-toggle="collapse" data-target="#demo"
                            @click="resultShowFn">
                        <i v-if="resultShow" class="fas fa-minus"></i>
                        <i v-else class="fas fa-plus"></i>
                    </button>
                </div>
                <div id="demo" class="collapse show w-100" style="max-height: 600px;overflow-y: scroll">
                    <table class="table table-hover w-100">
                        <thead>
                        <tr>
                            <th>FULL NAME</th>
                            <th>DISTANCE</th>
                            <th>POSITION</th>
                            <th>PUBLIC IDENTIFIER</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in result">
                            <td>{{ item.full_name }}</td>
                            <td>{{ item.memberDistance }}</td>
                            <td>{{ item.position }}</td>
                            <td>{{ item.publicIdentifier }}</td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    `,

    data: function () {
        return {
            key: '',
            show: false,
            resultShow: true,
            result: []
        }
    },
    props: ['user'],
    mounted() {
        if (this.user.linkedin_password && this.user.linkedin_login) {
            this.show = true;
        }

    },
    methods: {
        resultShowFn: function () {
            if (this.resultShow) {
                this.resultShow = false
            } else {
                this.resultShow = true
            }

        },
        fetchOptions: function (search) {
            this.key = search
            console.log(this.key)
        },
        onsubmit: function () {
            if (this.key.length > 3) {
                this.$http.get(`${pythonServer}/search`, {
                    params: {
                        key: this.key,
                        password: this.user.linkedin_password,
                        login: this.user.linkedin_login
                    }
                }).then((response) => {
                    this.result = response.data.data;
                    console.log(this.result)
                }).catch((error) => {
                    this.$setErrorsFromResponse(error.response.data);
                })
            }

        }
    }
})
