<template>
    <div class="card card-secondary predict">
        <div class="card-header">
            <h5>Predict Item</h5>
        </div>
        <div class="card-body">
           
            <div class="row">
                <div class="col-6">
                     <div class="row">
                        <div class="form-goup mb-3">
                            <input type="text" class="form-control" @keyup="searchItem" v-model="search" placeholder="Search Item...">
                        </div>
                    </div>
                    <div class="row  item-list">
                        <div v-if="isLoading" class="mx-auto mt-5">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                Loading items...
                            </div>
                        <table v-else class="table table-bordered">
                            
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <tr v-for="item in itemLists" :key="item.id">
                                    <td>{{item.product_name}}</td>
                                    <td>
                                        <button class="btn btn-info" @click="addItem(item.product_name)"><i class="fa fa-arrow-right"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                        
                </div>
                <div class="col-6">                    
                     
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                <strong>Select item in left corner!</strong> Note: <i>Only 5 items will be allowed to select.</i>   
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div v-if="items.item1" class="alert alert-info alert-dismissible fade show" role="alert">
                                {{items.item1}}
                            </div>
                            <div v-if="items.item2" class="alert alert-info alert-dismissible fade show" role="alert">
                                {{items.item2}}
                            </div>
                            <div v-if="items.item3" class="alert alert-info alert-dismissible fade show" role="alert">
                                {{items.item3}}
                            </div>
                            <div v-if="items.item4" class="alert alert-info alert-dismissible fade show" role="alert">
                                {{items.item4}}
                            </div>
                            <div v-if="items.item5" class="alert alert-info alert-dismissible fade show" role="alert">
                                {{items.item5}}
                            </div>
                            
                        </div>
                        <div v-if="items.item1" class="card-footer">
                            <form @submit.prevent="predictItems">
                                <div class="row">
                                    <div class="form-group mr-2">
                                        <label for="">Date From:</label>
                                        <input type="date" class="form-control" v-model="date.from" required>
                                    </div>  
                                    <div class="form-group mr-2">
                                        <label for="">Date To:</label>
                                        <input type="date" class="form-control" v-model="date.to" required>
                                    </div>                                                 
                                    
                                    <div class="form-group">      
                                        <label for="">Action</label>    
                                        <br>
                                        <button v-if="!predicting" type="submit" class="btn btn-primary">Search</button>
                                        <button v-else class="btn btn-primary disabled">Seach</button>
                                        <a v-if="!predicting" type="input" @click="clearItems" class="btn btn-secondary" style="color:white;">Clear</a>
                                        <button v-else class="btn btn-secondary disabled">Clear</button>
                                    </div>
                                </div>
                            </form>
                            
                            
                        </div>
                    </div>                               
                    <div v-if="predicting" class="text-center mt-5">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p>Predicting items... <br> It takes several minutes to predict.</p>
                    </div>   
                    <div v-else-if="showRecord" class="card card-secondary"> 
                        <div class="card-header">
                            <h5><i>This are the set's of item when they buy the search item. </i>   </h5>
                        </div>               
                        <div class="card-body predict-list">
                            
                            <ol v-if="predictedItems != ''">
                                <li v-for="set1 in predictedItems" :key="set1.id" class="mb-2">
                                    <ul>
                                        <li v-for="set2 in set1" :key="set2.id">{{set2}}</li>
                                    </ul>
                                </li>
                            </ol>
                            <div v-else-if="predictedItems == ''" class="text-center">
                                <p>No item set's match found...</p>
                            </div>
                        </div>
                    </div>                   
                </div>
                
            </div>                
            
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isLoading: true,
                itemLists : [],
                itemToPredict : [],
                date : {
                    from: null,
                    to : null,
                },
                itemToSearch: {},
                items : {
                    item1 : null,
                    item2 : null,
                    item3 : null,
                    item4 : null,
                    item5 : null,
                },
                search : '',
                i : 0,
                predicting : false,
                predictedItems : null,
                showRecord : false,
            }
        },

        created() {
            this.getItemList();
        },

        methods: {
            getItemList() {
                fetch('api/item-list')
                .then(res => res.json())
                .then(res => {
                    this.itemLists = res.itemlist;
                    this.isLoading = false;
                })
                .catch(err => toastr.error(err))
            },

            searchItem(){
                this.isLoading = true;
                fetch(`api/item-list/${this.search}`)
                .then(res => res.json())
                .then(res => {
                    this.itemLists = res.itemlist;
                    this.isLoading = false;
                })
                .catch(err => toastr.error(err))
            },

            addItem(id) {                
                if(this.i >= 5){    
                    toastr.warning('Only 5 items is allowed in one batch');     
                }else {                        
                    this.itemToPredict[this.i] = id;
                    this.i++;      
                    if(!this.items.item1){
                        this.items.item1 = id
                    } else if(!this.items.item2) {
                        this.items.item2 = id
                    } else if(!this.items.item3) {
                        this.items.item3 = id
                    } else if(!this.items.item4) {
                        this.items.item4 = id
                    } else if(!this.items.item5) {
                        this.items.item5 = id
                    }                          
                }               
                
            },

            clearItems() {
                this.itemToPredict = [];
                this.items.item1 = null;
                this.items.item2 = null;
                this.items.item3 = null;
                this.items.item4 = null;
                this.items.item5 = null;
                this.i = 0;
            },

            predictItems(){
                this.predicting = true;
                this.itemToSearch.itemToPredict = this.itemToPredict
                this.itemToSearch.from = this.date.from
                this.itemToSearch.to = this.date.to
                fetch('api/predict-item',{
                    method: 'POST',
                    body: JSON.stringify(this.itemToSearch),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.predictedItems = res.predict
                    this.predicting = false;
                    this.showRecord = true;
                })
                .catch(err => toastr.error(err))
            }

        }
    }
</script>

<style  scoped>
    .item-list {
        max-height: 900px;
        overflow: auto;
    }
    .predict {
        min-height: 1000px;
    }
    .predict-list {
        max-height: 500px;
        overflow: auto;
    }
</style>