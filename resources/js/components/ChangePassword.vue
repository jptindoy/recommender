<template>
    <form @submit.prevent="changePassword">
        
        <div class="modal fade" id="modal-password" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Change Password</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>                            
                    <div class="modal-body mx-auto">
                        <div class="password">
                            <div class="form-group">
                                <label for="password">New password</label>
                                <input type="password" name="password" id="password" class="form-control" v-model="update_password.password" required>
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">Confirm password</label>
                                <input type="password" name="password-confirm" class="form-control" v-model="update_password.password_confirm" required>
                            </div>
                        </div>                  
                            
                    </div>        
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" >Save changes</button>
                    </div>
                    
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->                
    </form>
</template>

<script>
    export default {
        props: {
            userId: Number,
        },

        data() {
            return {
                    update_password: {
                    id: this.userId,
                    password: '',
                    password_confirm: '',
                }
            }
        },

        methods: {
            changePassword(){
                fetch('api/password', {
                    method: 'PUT',
                    body: JSON.stringify(this.update_password),
                    headers: {
                        'Content-Type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    if(res.err === true){
                        toastr[res.errType](res.msg)        
                    } else {                        
                        toastr.success('Password change!')           
                        this.update_password.password = '';
                        this.update_password.password_confirm = '';
                    }
                    
                })
                .catch(err => toastr.error(err));
            }
        }
    }
</script>
