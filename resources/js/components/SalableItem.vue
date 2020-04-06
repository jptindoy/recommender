<template>
    
    <div class="card card-secondary">
        <div class="card-header">
            <h5>Salable Items</h5>
        </div>
        <div class="card-body">
            <form @submit.prevent="salableItemSearch" method="post">
                <div class="form-group  float-right">                           
                    <button v-if="!newRequest" @click="showDraft" class="btn btn-info float-right">Create Request</button>
                    <button v-else class="btn btn-info float-right disabled">Create Request</button>  
                </div>            
                <div class="row">                                                           
                    <div class="form-group mr-2">
                        <input type="date" class="form-control" v-model="date" required>
                    </div>
                    <div class="form-group">                           
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>          
                
            </form>
            <div v-if="searchDate" class="text-center">
                <h4 class="text-warning">Search Date {{searchDate}}</h4>
                <p class="text-danger"><i>This would be most item list to buy on the search date.</i></p>
            </div>
            <div v-else class="text-center">
                <h5 class="text-warning"><i>Item list is for today.</i></h5>
            </div>
            <div v-if="isLoading" class="text-center mt-5">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Loading items... <br> It takes several minutes to load.</p>
            </div>
            <div v-else>
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th v-if="newRequest">Action</th>
                        </tr>
                    </thead>  
                    <tbody>                           
                        <tr v-for="item in salableToday" :key="item.id">
                            <td>{{item.product_name}}</td>
                            <td>{{item.qty}} Sold</td>
                            <td v-if="newRequest">
                                <button class="btn btn-primary" @click="addRequest(item.product_name)" title="Add to Request"><i class="fa fa-shopping-cart"></i></button>
                            </td>
                        </tr>                
                    </tbody>                            
                </table>
                <ul class="pagination pagination-sm">
                    <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a class="page-link" href="javascript:void(0)" aria-label="Previous" @click="salableItemToday(pagination.prev_page_url)">
                        <span aria-hidden="true" style="color:black">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                    </li>
                    <li class="page-item disabled"><a class="page-link" href="#" style="color:black">{{pagination.current_page}} of {{pagination.last_page}}</a></li>
                    <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                    <a class="page-link" href="javascript:void(0)" aria-label="Next" @click="salableItemToday(pagination.next_page_url)">
                        <span aria-hidden="true" style="color:black">&raquo;</span> 
                        <span class="sr-only">Next</span>
                    </a>
                    </li>
                </ul>      
            </div>
        </div>
    </div>
    
</template>

<script>
    export default {
       data() {
           return {
                isLoading : true,
                salableToday : [],
                pagination : {},
                date : null,
                searchDate : null,
                newRequest : false,
            }
        },

        created(){
            this.salableItemToday();
             Event.$on('cancelled', (cancelled) => {
                this.newRequest = false;
            });
        },

        methods: {
            salableItemToday(page_url){
                let vm = this;
                if(this.isLoading){
                    page_url = `api/salable-item/${this.date}`
                }else{
                    page_url = page_url
                }
                
                fetch(page_url)
                .then(res => res.json())
                //.then(text => console.log(text))
                .then(res => {
                    this.salableToday = res.data
                    this.isLoading = false;
                    
                    vm.Pagination(res);
                })
                .catch(err => toastr.error(err));
            },

            salableItemSearch(){
                let vm = this;
                fetch(`api/salable-item/${this.date}`)
                .then(res => res.json())
                //.then(text => console.log(text))
                .then(res => {
                    this.salableToday = res.data
                    this.isLoading = false;
                    this.searchDate = this.date;
                    this.date = null;
                    vm.Pagination(res);
                })
                .catch(err => toastr.error(err));
            },

            Pagination(res) {
                let pagination = {
                    current_page: res.current_page,
                    last_page: res.last_page,
                    next_page_url: res.next_page_url,
                    prev_page_url: res.prev_page_url
                };

                this.pagination = pagination;    
            },

            showDraft() {
                Event.$emit('draft');
                this.newRequest = true;
            },

            addRequest(id) {
                fetch('api/request-draft', {
                    method:'POST',
                    body: JSON.stringify(id),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {                    
                    toastr[res.type](res.msg); 
                    Event.$emit('draft');
                                  
                })
                .catch(err => toastr.error(err))
            }
        },
    }
</script>

