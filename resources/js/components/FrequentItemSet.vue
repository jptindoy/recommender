<template>
    <div>   
        
        <div class="card card-secondary">
        
            <div class="card-header">
                <h5 class="card-title">Frequent Set of Items</h5>
            </div>            
            <div class="card-body">
                <div v-if="date.from" class="text-center">
                    <h3>From {{moment(date.from).format('MMMM D')}} to {{moment(date.to).format('MMMM D')}}</h3>
                    <p class="text-danger"><i>This would be most item set's to buy on the search Date.</i></p>
                </div>
                <div v-else class="text-center">
                     <h3>Item set's for this Month</h3>
                    <p class="text-danger"><i>This would be most item set's to buy on the this month.</i></p>
                </div>
               
                <div class="text-center">
                    <p><i>The item set's below are base in the records in POS System that most frequently buy per transactions.</i></p>
                </div>
                <form @submit.prevent="searchFrequentitemSet" method="post">         
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
                            <button type="submit" class="btn btn-primary form-control">Search</button>
                        </div>
                        
                        
                    </div>          
                    <p><i>Note: You can only search in one whole year</i></p>
                </form>
                
                <div v-if="isLoading" class="text-center mt-5">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p>Loading items... <br> It takes several minutes to load.</p>
                </div>
                <div v-else >
                    <div class="row">
                        <div class="col">
                            <div class="form-group">                           
                                <button v-if="!newRequest" @click="showDraft" class="btn btn-info">Create Request</button>
                                <button v-else class="btn btn-info disabled">Create Request</button>  
                            </div>
                            <div class="item-list">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Estimated Qty</th>
                                            <th v-if="newRequest">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <tr v-for="item in item_qty" :key="item.id">                                            
                                            <td>{{item.name}}</td>
                                            <td>{{item.qty}}</td>
                                            <td v-if="newRequest">
                                                <button class="btn btn-primary" @click="addRequest(item)" title="Add to Request"><i class="fa fa-shopping-cart"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                    
                            
                        </div>

                        <div class="col">
                            
                            <nav class="mt-3">
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link disabled" id="nav-9-tab" data-toggle="tab" href="#nav-9" role="tab" aria-controls="nav-9" aria-selected="false">Item set's of</a>
                                    
                                    <a class="nav-item nav-link active" id="nav-2-tab" data-toggle="tab" href="#nav-2" role="tab" aria-controls="nav-2" aria-selected="false">2</a>
                                    <a class="nav-item nav-link" id="nav-3-tab" data-toggle="tab" href="#nav-3" role="tab" aria-controls="nav-3" aria-selected="false">3</a>
                                    <a class="nav-item nav-link" id="nav-4-tab" data-toggle="tab" href="#nav-4" role="tab" aria-controls="nav-4" aria-selected="false">4</a>
                                    <a class="nav-item nav-link" id="nav-5-tab" data-toggle="tab" href="#nav-5" role="tab" aria-controls="nav-5" aria-selected="false">5</a>
                                    <a class="nav-item nav-link" id="nav-6-tab" data-toggle="tab" href="#nav-6" role="tab" aria-controls="nav-6" aria-selected="false">6</a>
                                    <a class="nav-item nav-link" id="nav-7-tab" data-toggle="tab" href="#nav-7" role="tab" aria-controls="nav-7" aria-selected="false">7</a>
                                    <a class="nav-item nav-link" id="nav-8-tab" data-toggle="tab" href="#nav-8" role="tab" aria-controls="nav-8" aria-selected="false">8</a>
                                    <a class="nav-item nav-link" id="nav-9-tab" data-toggle="tab" href="#nav-9" role="tab" aria-controls="nav-9" aria-selected="false">9</a>
                                    <a class="nav-item nav-link" id="nav-10-tab" data-toggle="tab" href="#nav-10" role="tab" aria-controls="nav-10" aria-selected="false">10</a>
                                </div>
                            </nav>
                            <div class="tab-content item-list" id="nav-tabContent" >
                                <div class="tab-pane fade show active" id="nav-2" role="tabpanel" aria-labelledby="nav-2-tab">
                                    <div v-if="!frequentItemSet[2]" class="text-center mt-5">
                                        <h5>No set's of item on this tab</h5>
                                    </div>
                                    <ol>
                                        <li v-for="item1 in frequentItemSet[2]" :key="item1.id" class="mb-3">
                                            <ul v-for="val in item1" :key="val.id">
                                                <li >{{val}}</li>
                                            </ul>                                
                                        </li>                                                      
                                    </ol>
                                </div>
                                <div class="tab-pane fade" id="nav-3" role="tabpanel" aria-labelledby="nav-3-tab">
                                <div v-if="!frequentItemSet[3]" class="text-center mt-5">
                                        <h5>No set's of item on this tab</h5>
                                    </div>
                                    <ol>
                                        <li v-for="item1 in frequentItemSet[3]" :key="item1.id" class="mb-3">
                                            <ul v-for="val in item1" :key="val.id">
                                                <li >{{val}}</li>
                                            </ul>                                
                                        </li>                                                      
                                    </ol>
                                </div>
                                <div class="tab-pane fade" id="nav-4" role="tabpanel" aria-labelledby="nav-4-tab">
                                    <div v-if="!frequentItemSet[4]" class="text-center mt-5">
                                        <h5>No set's of item on this tab</h5>
                                    </div>
                                    <ol>
                                        <li v-for="item1 in frequentItemSet[4]" :key="item1.id" class="mb-3">
                                            <ul v-for="val in item1" :key="val.id">
                                                <li >{{val}}</li>
                                            </ul>                                
                                        </li>                                                      
                                    </ol>
                                </div>
                                <div class="tab-pane fade" id="nav-5" role="tabpanel" aria-labelledby="nav-5-tab">
                                    <div v-if="!frequentItemSet[5]" class="text-center mt-5">
                                        <h5>No set's of item on this tab</h5>
                                    </div>
                                    <ol>
                                        <li v-for="item1 in frequentItemSet[5]" :key="item1.id" class="mb-3">
                                            <ul v-for="val in item1" :key="val.id">
                                                <li >{{val}}</li>
                                            </ul>                                
                                        </li>                                                      
                                    </ol>
                                </div>
                                <div class="tab-pane fade" id="nav-6" role="tabpanel" aria-labelledby="nav-6-tab">
                                    <div v-if="!frequentItemSet[6]" class="text-center mt-5">
                                        <h5>No set's of item on this tab</h5>
                                    </div>
                                    <ol>
                                        <li v-for="item1 in frequentItemSet[6]" :key="item1.id" class="mb-3">
                                            <ul v-for="val in item1" :key="val.id">
                                                <li >{{val}}</li>
                                            </ul>                                
                                        </li>                                                      
                                    </ol>
                                </div>
                                <div class="tab-pane fade" id="nav-7" role="tabpanel" aria-labelledby="nav-7-tab">
                                    <div v-if="!frequentItemSet[7]" class="text-center mt-5">
                                        <h5>No set's of item on this tab</h5>
                                    </div>
                                    <ol>
                                        <li v-for="item1 in frequentItemSet[7]" :key="item1.id" class="mb-3">
                                            <ul v-for="val in item1" :key="val.id">
                                                <li >{{val}}</li>
                                            </ul>                                
                                        </li>                                                      
                                    </ol>
                                </div>
                                <div class="tab-pane fade" id="nav-8" role="tabpanel" aria-labelledby="nav-8-tab">
                                    <div v-if="!frequentItemSet[8]" class="text-center mt-5">
                                        <h5>No set's of item on this tab</h5>
                                    </div>
                                    <ol>
                                        <li v-for="item1 in frequentItemSet[8]" :key="item1.id" class="mb-3">
                                            <ul v-for="val in item1" :key="val.id">
                                                <li >{{val}}</li>
                                            </ul>                                
                                        </li>                                                      
                                    </ol>
                                </div>
                                <div class="tab-pane fade" id="nav-9" role="tabpanel" aria-labelledby="nav-9-tab">
                                    <div v-if="!frequentItemSet[9]" class="text-center mt-5">
                                        <h5>No set's of item on this tab</h5>
                                    </div>
                                    <ol>
                                        <li v-for="item1 in frequentItemSet[9]" :key="item1.id" class="mb-3">
                                            <ul v-for="val in item1" :key="val.id">
                                                <li >{{val}}</li>
                                            </ul>                                
                                        </li>                                                      
                                    </ol>
                                </div>
                                <div class="tab-pane fade" id="nav-10" role="tabpanel" aria-labelledby="nav-10-tab">
                                    <div v-if="!frequentItemSet[10]" class="text-center mt-5">
                                        <h5>No set's of item on this tab</h5>
                                    </div>
                                    <ol>
                                        <li v-for="item1 in frequentItemSet[10]" :key="item1.id" class="mb-3">
                                            <ul v-for="val in item1" :key="val.id">
                                                <li >{{val}}</li>
                                            </ul>                                
                                        </li>                                                      
                                    </ol>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <div class="item-list">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Antecedent</th>
                                            <th>Consequent</th>
                                            <th>Support</th>
                                            <th>Confidence</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <tr v-for="item in rules" :key="item.id">
                                            <td>
                                                <ul>
                                                    <li v-for="val in item.antecedent" :key="val.id">{{val}}</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li v-for="val in item.consequent" :key="val.id">{{val}}</li>
                                                </ul>
                                            </td>
                                            <td>{{item.support}}</td>
                                            <td>{{item.confidence}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>     
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    
</template>

<script>
    import LineChart from './LineChart.vue'
    import moment from 'moment';

    export default {
        name: 'LineChartContainer',
        components: { LineChart },
        data() {
            return {
                isLoading : true,
                frequentItemSet : [],
                btnToday : true,
                date : {
                    from : null,
                    to : null,
                },
                item_qty : [],
                newRequest : false,
                rules : [],
                loaded : true,
                
                chartdata: {
                    labels  : [],
                    datasets: [{
                        type                : 'line',
                        data                : [],
                        backgroundColor     : 'transparent',
                        borderColor         : '#007bff',
                        pointBorderColor    : '#007bff',
                        pointBackgroundColor: '#007bff',
                        fill                : false,
                        pointHoverBackgroundColor: '#007bff',
                        pointHoverBorderColor    : '#007bff'
                        }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips           : {
                        mode     : 'index',
                        intersect: true
                    },
                    hover              : {
                        mode     : 'index',
                        intersect: true
                    },
                    legend             : {
                        display: false
                    },
                    
                }
            }
        },
        
        created(){
            this.getFrequentItemSet();
            Event.$on('cancelled', (cancelled) => {
                this.newRequest = false;
            });
        },

        methods: {
            moment,
            getFrequentItemSet() {
                this.isLoading = true;
                fetch('api/item-sets')
                .then(res => res.json())
                .then(res => {
                    this.frequentItemSet = res.itemset;
                    this.item_qty = res.qty;
                    this.rules = res.rules;
                    this.isLoading = false;
                    this.btnToday = true;
                    this.searchDate = null; 
                    
                    
                })
                .catch(err => toastr.error(err))
            },

            showDraft() {
                Event.$emit('draft');
                this.newRequest = true;
            },
            
            searchFrequentitemSet() {     
                this.isLoading = true;                 
                fetch('api/item-set-search',{
                    method: 'POST',
                    body: JSON.stringify(this.date),
                    headers :{
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.frequentItemSet = res.itemset;
                    this.item_qty = res.qty;
                    this.isLoading = false;
                })
                .catch(err => toastr.error(err))
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
        }
    }
</script>

<style scoped>
.item-list{
    max-height: 400px;
    overflow: auto;
}

</style>