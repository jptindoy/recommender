<template>
    <div class="row">
        <!-- PRODUCT LIST -->
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Category</h3>
                    <div class="float-right">                
                                      
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <tbody v-for="role in roles" v-bind:key="role.r_id">
                            <tr>
                                <td>{{role.r_category}}</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-info" title="click to update info..."><i class="fas fa-edit"></i></a>
                                        <a href="#" class="btn btn-danger"  title="click to delete..."><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                            
                <div class="card-footer text-center">      
                    
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                        <a class="page-link" href="#" aria-label="Previous" @click="fetchRoles(pagination.prev_page_url)">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="#">{{pagination.current_page}} of {{pagination.last_page}}</a></li>
                        <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                        <a class="page-link" href="#" aria-label="Next" @click="fetchRoles(pagination.next_page_url)">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                        </li>
                    </ul> 
                    <form @submit.prevent="addRole()" role="form">       
                        <div class="input-group input-group-sm" style="width:70%;">
                            <input type="text" class="form-control" v-model="role.r_category" required>
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-info btn-flat">Save</button>
                            </span>
                        </div> 
                    </form>            
                    
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>


        <!-- Note -->
        <div class="col-8">
            <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
                Note: Only Administrator account has the acces to this page. 
            </div>
        </div>
    </div>
    
</template>

<script>
    export default {
        data() {
            return {
                modules: [],
                mod: {
                    m_id: '',
                    m_category: '',
                    m_name: '',
                    m_view: '',
                    m_add: '',
                    m_edit: '',
                    m_delete: ''
                },
                roles: [],
                role: {
                    r_id: '',
                    r_category: ''
                },
                edit: false,
                module_id: '',
                role_id: '',
                pagination: {}
            }
        }, 

        props: {
            userId: Number,
        },

        created() {
            this.fetchRoles();
        },
        
        methods: {
            fetchRoles(page_url) {
                let vm = this;
                page_url = page_url || 'api/roles'
                fetch(page_url)
                .then(res => res.json())
                //.then(text => console.log(text))
                .then(res => {
                    this.roles = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },

            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };

                this.pagination = pagination;    
            },

            // deleteUser(u_id) {
            //     if(confirm('Are you sure?')) {
            //         fetch(`api/user/${id}`, {
            //             method: 'delete'
            //         })
            //         .then(res => res.json())
            //         .then(data => {
            //             alert('User Removed!');
            //             this.fetchRoles();
            //         })
            //         .catch(err => console.log(err));
            //     }
            // },

            addRole() {
                if(this.edit === false) {
                    fetch('api/role',{
                        method: 'POST',
                        body: JSON.stringify(this.role),
                        headers: {
                            'Content-type' : 'Application/json'
                        }

                    })
                    .then( res => res.json())
                    // .then(text => console.log(text))
                    .then( data => {
                        this.role.r_category = '';
                        this.fetchRoles();
                        //alert('User Added!');
                    })
                    .catch(err => console.log(err));
                }
            },

            // clearForm() {
            //     this.edit = false;
            //     this.user.u_id = null;
            //     this.user.user_id = null;
            //     this.user.u_fname = '';
            //     this.user.u_lname = '';                 
            //     this.user.u_email = '';                 
            //     this.user.u_role = '';                 
            //     this.user.u_password = '';                  
            // },

            // editUser() {
            //     this.edit = true;
            //     this.add = false;
            //     this.isHidden = true;
                
            // }

        }
    }
</script>