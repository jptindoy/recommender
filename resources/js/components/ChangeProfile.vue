<template>
    <form @submit.prevent="saveProfile">
        
        <div class="modal fade" id="modal-profile-picture" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Change Profile</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>                            
                    <div class="modal-body mx-auto">
                        <div class="profile">
                            <h5>Drag or select image</h5>
                            <div class="dropzone">
                                <div class="form-group">
                                    <img v-if="avatar" :src="avatar" alt="" class="img-fluid">
                                    <input type="file" ref="image" class="input-file" name="" id="" @change="getImage" required>
                                    
                                </div>
                            </div>
                            <div v-if="uploading" class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" :style="{width: progress +'%'}">{{progress}}%</div>
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
                    progress: 0,
                    avatar: null,
                    update: {
                        id: this.userId,
                        file: null,
                    },
                    uploading: false,
            }
        },

        methods: {
            getImage(e) {
                let image = e.target.files[0];
                let reader = new FileReader();
                
                reader.readAsDataURL(image);
                reader.onload = e => {
                    this.avatar = e.target.result;
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
                
                axios.post('api/profile', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function( progressEvent ) {
                        this.uploading = true;
                        this.progress = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ));
                    }.bind(this)
                    
                })
                // .then(res => res.json())
                .then(res => {
                    if(res.status === 200 || res.status === 201){
                        this.uploading = false;
                        this.$refs.image.value = '';
                        this.avatar = null;
                        Event.$emit('profile');
                        toastr.success('Profile change!')           
                    }
                })
                .catch(err => toastr.error(err));
                
            },
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