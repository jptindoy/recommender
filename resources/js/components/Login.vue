<template>
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <a href="javascript:void(0)"><b>AUP</b> STORE</a>
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
                        <input type="email" class="form-control" placeholder="@email" v-model="user_credential.email" v-bind:class="{ 'is-invalid': hasError }" required autofocus>
                        
                        <div class="input-group-append">
                        <button type="submit" id="submit" class="btn"><i class="fas fa-arrow-right text-muted"></i></button>
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
                    <img :src="'/storage/img/profile-img/' + user_info.img" alt="User Image">
                </div>
                <!-- /.lockscreen-image -->

                <!-- lockscreen credentials (contains the form) -->
                <form @submit.prevent="login()" class="lockscreen-credentials">
                     <input type="hidden" name="_token" :value="user_credential._token">
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="password" id="password" v-model="user_credential.password" v-bind:class="{ 'is-invalid': hasError }" required autofocus>
                        
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
                Copyright &copy; 2019-2020 <b><a href="javascript:void(0)" class="text-black">AUPStore</a></b><br>
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
                login_info:{
                    id:'',
                    token: '',
                },
                
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
                fetch('/login', {
                    method: 'POST',
                    body: JSON.stringify(this.user_credential),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res =>{
                    if (res.data.err == false) {
                        // console.log(res.data.session.login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d)
                        this.login_info.id = res.data.session.login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d;
                        this.login_info.token = res.data.session._token;
                        this.logInfo();
                        window.location = '/home';
                    } else {
                        this.hasError = true;
                        this.msg = res.data.msg;
                    }
                })
                .then(data => {
                    
                })
                .catch(err => console.log(err));
            },

            logInfo(){
                fetch('api/log',{
                    method: 'POST',
                    body: JSON.stringify(this.login_info),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {})
                .catch(err => console.log(err));
            }
        }
    }
</script>
