<template>
    <div>
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
    
                    <div class="info-box-content">
                        <span class="info-box-text">Pending Request</span>
                        <span class="info-box-number">
                         {{widget.countallRequest}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>   
            <div class="col-xs-12 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-ban"></i></span>
    
                    <div class="info-box-content">
                        <span class="info-box-text">Disapproved Request</span>
                        <span class="info-box-number">
                         {{widget.countcancelled}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>   
            <div class="col-xs-12 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tags"></i></span>
    
                    <div class="info-box-content">
                        <span class="info-box-text">Approved Request</span>
                        <span class="info-box-number">
                          {{widget.countapproved}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
              <!-- /.info-box -->

            </div>   
        </div> 

        <div class="row">
            <div class="col-8">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h5 class="card-title">
                            Request Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
            
                            <div class="col-6">
                                <label for="search"> Search Request</label>
                                <form @submit.prevent="editRequest(input)">
                                    <div class="input-group input-group-sm">
                                        <input type="number" v-model="input" @input="searchNumber" list="po-number" name=""  class="form-control" placeholder="search PO Number" required>
                                        <datalist id="po-number">
                                            <option v-for="item in searchItem" :key="item.id">{{item.po_number}}</option>
                                        </datalist>
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-info btn-flat" title="Show this request!" data-toggle="modal" data-target="#showModal"><i class="fas fa-search"></i></button>
                                        </span>
                                        
                                    </div>
                                    
                                      
                                </form>
                                
                            </div>                            
                            
                        </div>
                        
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                
                                <a class="nav-item nav-link active" id="nav-2-tab" data-toggle="tab" href="#nav-2" role="tab" aria-controls="nav-2" aria-selected="false">Pending Request</a>
                                <a class="nav-item nav-link" id="nav-3-tab" data-toggle="tab" href="#nav-3" role="tab" aria-controls="nav-3" aria-selected="false">Disapproved Request</a>
                                <a class="nav-item nav-link" id="nav-4-tab" data-toggle="tab" href="#nav-4" role="tab" aria-controls="nav-4" aria-selected="false">On Proccess Request</a>
                                
                            </div>
                        </nav>
                        <div class="tab-content item-list" id="nav-tabContent" >
                            <div class="tab-pane fade show active" id="nav-2" role="tabpanel" aria-labelledby="nav-2-tab">
                                <div class="card-body">
                                    <div v-if="widget.allRequest == ''" class="text-center">
                                        <h5>No Records</h5>
                                    </div>
                                    <table v-else class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>PO Number</td>
                                                <td>Date Needed</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in widget.allRequest" :key="item.id">
                                                <td>{{item.po_number}}</td>
                                                <td>{{item.date_needed}}</td>
                                                <td>
                                                    <button @click="editRequest(item.po_number)" class="btn btn-info" title="Show this request!" data-toggle="modal" data-target="#showModal"><i class="fas fa-eye"></i></button>
                                                    <button v-if="rights.update" @click="approvedRequest(item)" class="btn btn-primary" title="Aprove this request!"><i class="fas fa-check"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <div class="tab-pane fade" id="nav-3" role="tabpanel" aria-labelledby="nav-3-tab">
                                <div class="card-body">
                                    <div v-if="widget.cancelled == ''" class="text-center">
                                        <h5>No Records</h5>
                                    </div>
                                    <table v-else class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>PO Number</td>
                                                <td>Date Needed</td> 
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in widget.cancelled" :key="item.id">
                                                <td>{{item.po_number}}</td>
                                                <td>{{item.date_needed}}</td>
                                                <td>
                                                    <button @click="editRequest(item.po_number)" class="btn btn-info" title="Show this request!" data-toggle="modal" data-target="#showModal"><i class="fas fa-eye"></i></button>
                                                    <button  v-if="rights.update" @click="approvedRequest(item)" class="btn btn-primary" title="Approve this request!"><i class="fas fa-check"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <div class="tab-pane fade" id="nav-4" role="tabpanel" aria-labelledby="nav-4-tab">
                                <div class="card-body">
                                    <div v-if="widget.approved == ''" class="text-center">
                                        <h5>No Records</h5>
                                    </div>
                                    <table v-else class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>PO Number</td>
                                                <td>Date Needed</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in widget.approved" :key="item.id">
                                                <td>{{item.po_number}}</td>
                                                <td>{{item.date_needed}}</td>
                                                <td>
                                                    <button @click="editRequest(item.po_number)" class="btn btn-info" title="Show this request!" data-toggle="modal" data-target="#showModal"><i class="fas fa-eye"></i></button>
                                                    <button  v-if="rights.update" @click="disapprovedRequest(item)" class="btn btn-danger" title="Disapprove this request!"><i class="fas fa-times"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>     
            <div class="col-4">
            
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Create Request</h3>

                        <p>Create list of item to be request.</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="/request" class="small-box-footer">Create <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                <div class="mt-3">
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsa odio suscipit quis eius fuga alias recusandae voluptatem autem, totam neque quae consequuntur soluta. Exercitationem animi vero dolore qui earum magnam.</p>
                </div>
            </div>
        </div> 
        <div class="row">
            <!-- Modal -->
            <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button> -->
                        </div>
                        <div class="modal-body">
                            <request-item :editId="editId" :user-role="userRole"  :user-id="userId"></request-item>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props : {
            userId: Number,
            userRole: Number,
        },
        data() {
            return {
                widget : [],
                editId: null,
                update: {},
                searchItem :[],
                po_number : null,
                input : null,
                rights : {
                    view: 0,
                    create: 0,
                    update: 0,
                    delete: 0,
                }
            }
        },

        created() {
            Event.$on('widget', (e) => {
                this.getWidget();
            });
            this.getWidget();
            this.getRights();
            this.getRights();
        },

        methods: {
            getWidget() {
                fetch('api/request-widget')
                .then(res => res.json())
                .then(res => {
                    this.widget = res
                })
                .catch(err => toastr.err(err))
            },

            editRequest(id){
                this.editId = id
                Event.$emit('editRequest', this.editId);
                
            },

            approvedRequest(id) {
                this.update.PO_number = id.po_number;
                this.update.dateNeeded = id.date_needed;
                this.update.action = 'approved';
                this.update.user = this.userId;
                fetch('api/update-request', {
                    method:'POST',
                    body: JSON.stringify(this.update),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {            
                    this.getWidget();              
                    toastr[res.type](res.msg);              
                })
                .catch(err => toastr.error(err))
            },

            disapprovedRequest(id) {
                this.update.PO_number = id.po_number;
                this.update.dateNeeded = id.date_needed;
                this.update.action = 'disapproved';
                this.update.user = this.userId;
                fetch('api/update-request', {
                    method:'POST',
                    body: JSON.stringify(this.update),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {            
                    this.getWidget(); 
                    toastr[res.type](res.msg);          
                })
                .catch(err => toastr.error(err))
            },

            searchNumber(event){
                if(event.target.value != ''){
                    fetch(`api/search-request/${event.target.value}`)
                    .then(res => res.json())
                    .then(res => {
                        this.searchItem = res.items
                        this.po_number = event.target.value
                    })
                    .catch(err => toastr.err(err))
                }             
            },

            getRights(){
                fetch(`api/module-right/${this.userRole}`)
                .then(res => res.json())
                .then(res => {
                    this.rights.view = res.data[2].view
                    this.rights.create = res.data[2].create
                    this.rights.update = res.data[2].update
                    this.rights.delete = res.data[2].delete
                    // console.log(this.rights.view)
                })
                .catch(err => toastr.error(err))
            }
        }
    }

</script>
<style  scoped>
.tab-pane {
    max-height: 500px;
    overflow: auto;
}

</style>