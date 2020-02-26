<template>
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <a href="../../index2.html"><b>Admin</b>LTE</a>
        </div>
        <div v-if="!show_pass_input" class="form" id="login">
            <!-- User name -->
            <div class="lockscreen-name mb-4">Email</div>

            <!-- START LOCK SCREEN ITEM -->
            <div class="lockscreen-item">
                <!-- lockscreen image -->
                <div class="lockscreen-image">
                    <img src="/storage/img/blank-img.png" alt="User Image">
                </div>
                <!-- /.lockscreen-image -->

                <!-- lockscreen credentials (contains the form) -->
                <form @submit.prevent="fetchEmail" class="lockscreen-credentials">
                    <input type="hidden" name="_token" :value="user_credential._token">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="@email" v-model="user_credential.email" v-bind:class="{ 'is-invalid': hasError }" required>
                        
                        <div class="input-group-append">
                        <button type="submit" class="btn"><i class="fas fa-arrow-right text-muted"></i></button>
                        </div>
                    </div>
                    
                </form>
                <!-- /.lockscreen credentials -->
                
            </div>
            <p v-if="hasError" class="text-danger text-center">{{msg}}</p>
            <!-- /.lockscreen-item -->
            <div class="help-block text-center">
                Enter your email to verify your account </div>
        </div>

        <div v-if="show_pass_input" class="form" id="pass">
            <!-- User name -->
            <div class="lockscreen-name mb-4">{{user_credential.email}}</div>

            <!-- START LOCK SCREEN ITEM -->
            <div class="lockscreen-item">
                <!-- lockscreen image -->
                <div class="lockscreen-image">
                    <img :src="'/storage/img/' + user_info.img" alt="User Image">
                </div>
                <!-- /.lockscreen-image -->

                <!-- lockscreen credentials (contains the form) -->
                <form @submit.prevent="login()" class="lockscreen-credentials">
                     <input type="hidden" name="_token" :value="user_credential._token">
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="password" v-model="user_credential.password" v-bind:class="{ 'is-invalid': hasError }" required>
                        
                        <div class="input-group-append">
                        <button type="submit" class="btn"><i class="fas fa-arrow-right text-muted"></i></button>
                        </div>
                    </div>
                    
                </form>
                <!-- /.lockscreen credentials -->
                
            </div>
            <!-- message -->
            <p v-if="hasError" class="text-danger text-center">{{msg}}</p>
            <!-- /.lockscreen-item -->
            <div class="help-block text-center">
                Enter your password to start your session  </div>
        </div>   

            
            
            <div class="lockscreen-footer text-center">
                Copyright &copy; 2014-2019 <b><a href="http://adminlte.io" class="text-black">AdminLTE.io</a></b><br>
                All rights reserved
            </div>
    </div>
        <!-- /.center -->
  
</template>

<script>
    
    export default {
        data() {
            return {
                user_info: [],
                user_credential:{
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    email: '',
                    password: '',
                    
                },
                show_pass_input: false,
                hasError: false,
                msg:'',
                
            }
        },
        
        methods: {
            fetchEmail() {
                fetch(`api/email/${this.user_credential.email}`, {
                    method: 'GET'
                })
                .then(res => res.json())
                .then(res => {
                    
                    if(res.data.err === true){
                        this.hasError = true;
                        this.msg = res.data.msg;
                    }else {   
                        this.user_info = res.data;
                        this.hasError = false;
                        this.show_pass_input = true;
                    }
                })
                .then(data => {
                    
                })
                .catch(err => console.log(err));
            },

            login(){
                fetch('/api/login', {
                    method: 'POST',
                    body: JSON.stringify(this.user_credential),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.text())
                .then(res =>console.log(res))
                .then(data => {})
                .catch(err => console.log(err));
            }
        }
    }
</script>
