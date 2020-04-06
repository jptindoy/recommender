<template>
    <div>   
        
        <div class="card card-secondary">
        
            <div class="card-header">
                <h5>Frequent Set of Items</h5>
            </div>
            
            <div class="card-body">
                <form @submit.prevent="searchFrequentitemSet" method="post">
                    <div v-if="btnToday" class="form-group  float-right">                           
                        <button @click="getFrequentItemToday" class="btn btn-info float-right">Show frequent items for today</button>
                    </div>
                    <div v-else class="form-group  float-right">                           
                        <button @click="getFrequentItemSet" class="btn btn-info float-right">Show frequent items for all records</button>
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
                    <p class="text-danger"><i>This would be most item set's to buy on the search date.</i></p>
                </div>
                <div class="text-center">
                    <p><i>The item set's below are base in the records in POS System that most frequently buy per transactions.</i></p>
                </div>
                <div v-if="isLoading" class="text-center mt-5">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p>Loading items... <br> It takes several minutes to load.</p>
                </div>
                <div v-else>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link disabled" id="nav-9-tab" data-toggle="tab" href="#nav-9" role="tab" aria-controls="nav-9" aria-selected="false">Item set's of</a>
                            <a class="nav-item nav-link  active" id="nav-1-tab" data-toggle="tab" href="#nav-1" role="tab" aria-controls="nav-1" aria-selected="true">1</a>
                            <a class="nav-item nav-link" id="nav-2-tab" data-toggle="tab" href="#nav-2" role="tab" aria-controls="nav-2" aria-selected="false">2</a>
                            <a class="nav-item nav-link" id="nav-3-tab" data-toggle="tab" href="#nav-3" role="tab" aria-controls="nav-3" aria-selected="false">3</a>
                            <a class="nav-item nav-link" id="nav-4-tab" data-toggle="tab" href="#nav-4" role="tab" aria-controls="nav-4" aria-selected="false">4</a>
                            <a class="nav-item nav-link" id="nav-5-tab" data-toggle="tab" href="#nav-5" role="tab" aria-controls="nav-5" aria-selected="false">5</a>
                            <a class="nav-item nav-link" id="nav-6-tab" data-toggle="tab" href="#nav-6" role="tab" aria-controls="nav-6" aria-selected="false">6</a>
                            <a class="nav-item nav-link" id="nav-7-tab" data-toggle="tab" href="#nav-7" role="tab" aria-controls="nav-7" aria-selected="false">7</a>
                            <a class="nav-item nav-link" id="nav-8-tab" data-toggle="tab" href="#nav-8" role="tab" aria-controls="nav-8" aria-selected="false">8</a>
                            <a class="nav-item nav-link" id="nav-9-tab" data-toggle="tab" href="#nav-9" role="tab" aria-controls="nav-9" aria-selected="false">9</a>
                        </div>
                    </nav>
                    <div class="tab-content item-list" id="nav-tabContent" >
                        <div class="tab-pane fade  show active" id="nav-1" role="tabpanel" aria-labelledby="nav-1-tab">
                            <ol v-for="item1 in frequentItemSet" :key="item1.id">                            
                                <ul v-for="val in item1[1]" :key="val.id">
                                    <li v-for="item2 in val" :key="item2.id">{{item2}}</li>
                                </ul>                                                     
                            </ol>
                        </div>
                        <div class="tab-pane fade" id="nav-2" role="tabpanel" aria-labelledby="nav-2-tab">
                            <ol v-for="item1 in frequentItemSet" :key="item1.id">
                                <li v-for="val in item1[2]" :key="val.id">
                                    <ul class="mb-2">
                                        <li v-for="item2 in val" :key="item2.id">{{item2}}</li>
                                    </ul>                                
                                </li>                                                      
                            </ol>
                        </div>
                        <div class="tab-pane fade" id="nav-3" role="tabpanel" aria-labelledby="nav-3-tab">
                            <ol v-for="item1 in frequentItemSet" :key="item1.id">
                                <li v-for="val in item1[3]" :key="val.id">
                                    <ul class="mb-2">
                                        <li v-for="item2 in val" :key="item2.id">{{item2}}</li>
                                    </ul>                                
                                </li>                                                      
                            </ol>
                        </div>
                        <div class="tab-pane fade" id="nav-4" role="tabpanel" aria-labelledby="nav-4-tab">
                            <ol v-for="item1 in frequentItemSet" :key="item1.id">
                                <li v-for="val in item1[4]" :key="val.id">
                                    <ul class="mb-2">
                                        <li v-for="item2 in val" :key="item2.id">{{item2}}</li>
                                    </ul>                                
                                </li>                                                      
                            </ol>
                        </div>
                        <div class="tab-pane fade" id="nav-5" role="tabpanel" aria-labelledby="nav-5-tab">
                            <ol v-for="item1 in frequentItemSet" :key="item1.id">
                                <li v-for="val in item1[5]" :key="val.id">
                                    <ul class="mb-2">
                                        <li v-for="item2 in val" :key="item2.id">{{item2}}</li>
                                    </ul>                                
                                </li>                                                      
                            </ol>
                        </div>
                        <div class="tab-pane fade" id="nav-6" role="tabpanel" aria-labelledby="nav-6-tab">
                            <ol v-for="item1 in frequentItemSet" :key="item1.id">
                                <li v-for="val in item1[6]" :key="val.id">
                                    <ul class="mb-2">
                                        <li v-for="item2 in val" :key="item2.id">{{item2}}</li>
                                    </ul>                                
                                </li>                                                      
                            </ol>
                        </div>
                        <div class="tab-pane fade" id="nav-7" role="tabpanel" aria-labelledby="nav-7-tab">
                            <ol v-for="item1 in frequentItemSet" :key="item1.id">
                                <li v-for="val in item1[7]" :key="val.id">
                                    <ul class="mb-2">
                                        <li v-for="item2 in val" :key="item2.id">{{item2}}</li>
                                    </ul>                                
                                </li>                                                      
                            </ol>
                        </div>
                        <div class="tab-pane fade" id="nav-8" role="tabpanel" aria-labelledby="nav-8-tab">
                            <ol v-for="item1 in frequentItemSet" :key="item1.id">
                                <li v-for="val in item1[8]" :key="val.id">
                                    <ul class="mb-2">
                                        <li v-for="item2 in val" :key="item2.id">{{item2}}</li>
                                    </ul>                                
                                </li>                                                      
                            </ol>
                        </div>
                        <div class="tab-pane fade" id="nav-9" role="tabpanel" aria-labelledby="nav-9-tab">
                            <ol v-for="item1 in frequentItemSet" :key="item1.id">
                                <li v-for="val in item1[9]" :key="val.id">
                                    <ul class="mb-2">
                                        <li v-for="item2 in val" :key="item2.id">{{item2}}</li>
                                    </ul>                                
                                </li>                                                      
                            </ol>
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
                isLoading : true,
                frequentItemSet : [],
                btnToday : true,
                date : null,
                searchDate : null,
            }
        },
        
        created(){
            this.getFrequentItemSet();
        },

        methods: {
            getFrequentItemSet() {
                this.isLoading = true;
                fetch('api/item-sets')
                .then(res => res.json())
                .then(res => {
                    this.frequentItemSet = res;
                    this.isLoading = false;
                    this.btnToday = true;
                    this.searchDate = null; 
                })
                .catch(err => toastr.error(err))
            },

            getFrequentItemToday() {     
                this.isLoading = true;           
                fetch('api/item-set-today')
                .then(res => res.json())
                .then(res => {
                    this.frequentItemSet = res;
                    this.isLoading = false;
                    this.btnToday = false;
                    this.searchDate = null;     
                })
                .catch(err => toastr.error(err))
            },

            searchFrequentitemSet() {     
                this.isLoading = true; 
                this.searchDate = this.date;          
                fetch(`api/item-set-search/${this.date}`)
                .then(res => res.json())
                .then(res => {
                    this.frequentItemSet = res;
                    this.isLoading = false;
                    this.date = null;
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