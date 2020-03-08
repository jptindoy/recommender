<template>
    <div class="row">
        <div class="col-8">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username">{{profile.u_fname}} {{profile.u_lname}}</h3>
                    <h5 class="widget-user-desc">{{profile.r_category}}</h5>
                </div>
                <div class="widget-user-image">
                    <img v-bind:src="'/storage/img/' + profile.u_image" class="img-circle elevation-2" alt="User Avatar">
                </div>
                <div class="card-footer">

                    <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">{{profile.email}}</h5>
                        <span class="description-text">Email</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">
                            <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger ">
                                <input type="checkbox" class="custom-control-input"  :id="'view' + profile.u_status"  v-model="profile.u_status" v-bind:value="profile.u_status" checked-value="true" unchecked-value="false" disabled>
                                    <label class="custom-control-label" :for="'view' + profile.u_status"></label>
                            </div>
                        </h5>
                        <span class="description-text">Satus</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                        <h5 class="description-header">{{moment(profile.created_at).format('MMMM D, YYYY')}}</h5>
                        <span class="description-text">Date Created</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->


                <div class="form-group">

                </div>

                <hr>
                <strong><i class="fas fa-th-list mr-1"></i> Logs</strong>
                <table class="table table-bordered mt-3">
                    <thead>
                    <tr>
                        <th style="width: 30%">Date</th>
                        <th>Sission ID</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="log in logs" v-bind:key="log.ul_id">
                        <td>{{moment(log.created_at).format('MMMM Do YYYY, h:mm:ss a')}}</td>
                        <td>{{log.ul_session_id}}</td>
                    </tr>
                    </tbody>
                </table>
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
                </div>
            </div>
            <!-- /.widget-user -->
        </div>
        <div class="col-4">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Actions</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item active">
                            <a href="#modal-default" data-toggle="modal" class="nav-link">
                                <i class="fas fa-inbox"></i> Chage Profile Picture
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-envelope"></i> Change Password
                            </a>
                        </li>                        
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-filter"></i> Notifications
                                <span class="badge bg-danger float-right">65</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <br>

            <form @submit.prevent="saveProfile">
                <div class="modal fade" id="modal-default" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Default Modal</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-auto">
                                <h5>Drag or select image</h5>
                                <div class="dropzone">
                                    <div class="form-group">
                                        <img v-if="avatar" :src="avatar" alt="" class="img-fluid">
                                        <input type="file" class="input-file" name="" id="" @change="getImage">
                                        
                                    </div>
                                </div>
                                 <p>{{progress}}</p>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" :style="{width: progress +'%'}">{{progress}}</div>
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
        </div>
    </div>



</template>

<script>
    import moment from 'moment'

    export default {
        props: {
            userId: Number,
        },

        data() {
            return {
                profile: [],
                logs: [],
                progress: 0,
                avatar: null,
                update: {
                    id: this.userId,
                    file: null,
                }
            }
        },

        

        created(){
            this.fetchProfile(this.userId);
            this.getUserLog(this.userId);
        },

        methods: {
            moment,

            fetchProfile(id){
                fetch(`/api/user/${id}`, {
                    method: 'GET'
                })
                .then(res => res.json())
                .then(res => {
                    this.profile = res.data;
                })
                .then(data => {})
                .catch(err => console.log(err));
            },

            getUserLog(id) {
                fetch(`api/log/${id}`, {
                    method: 'GET'
                })
                .then(res => res.json())
                .then(res =>{
                    this.logs = res.data;
                })
                .then(data => {})
                .catch(err => console.log(err));
            },

            getImage(e) {
                let image = e.target.files[0];
                let reader = new FileReader();
                
                reader.readAsDataURL(image);
                reader.onload = e => {
                    this.avatar = e.target.result;
                    console.log(this.avatar)
                }
                this.update.file = e.target.files[0];
            },

            saveProfile(){

                let formData = new FormData();

                /*
                    Add the form data we need to submit
                */
                formData.append('file', this.update.file);
                formData.append('id', this.update.id);
                
                axios.post('api/save', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function( progressEvent ) {
                        this.progress = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ));
                    }.bind(this)
                    
                })
                .then(res => res.json())
                .then(data => {})
                .catch(err => console.log(err));
            }
        }
    }
</script>
<style scoped>
    .dropzone {
        height: 200px;
        width: 200px;
        padding: 10px;
        cursor: pointer;
        outline: 2px dashed grey;
        outline-offset: -10px;
    }
    
    .input-file {
        opacity: 0;
        height: 200px;
        width: 200px;
        position: absolute ;
        cursor: pointer;
    }

    /* .dropzone .form-group {
        text-align: center;
        padding: 75px;
        cursor: pointer;
    } */
</style>