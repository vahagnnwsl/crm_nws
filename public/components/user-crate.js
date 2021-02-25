Vue.component('user-crate-component', {

    template: `
        <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Create new user</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="card-body">
            <form @submit.prevent="submit">
                <input name="email" v-model="form.email" data-vv-as="Email" v-validate="'required|email'" class="form-control"
                       type="text" placeholder="Email">
                <span class="error invalid-feedback d-block mb-2">{{ errors.first('email') }}</span>

                <div class="form-group">
                    <select class="form-control" name="role" v-model="form.role" v-validate="'required'">
                        <option value="" selected disabled>Select one</option>
                        <option :value="item.id" v-for="(item,index) in roles">{{item.name}}</option>
                    </select>
                </div>
                <span class="error invalid-feedback d-block mb-2">{{ errors.first('role') }}</span>


                <div class="btn-group float-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>

            </form>
        </div>
        </div>`,

    data: function () {
        return {
            form: {
                email: '',
                role: ''
            }
        }
    },
    props:['roles'],
    methods: {
        submit: function () {
            this.$validator.validate().then(valid => {
                if (valid) {


                    this.$http.post('/dashboard/users', this.form)
                        .then((response) => {
                            $('#user__create').modal('hide');
                            setTimeout(function () {
                                location.reload();
                            },200)
                        }).catch((error) => {
                        this.$setErrorsFromResponse(error.response.data);
                    })
                }

            });
        }
    }
})
