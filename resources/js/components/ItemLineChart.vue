<template>
    <div v-if="loaded">
        <div class="text-center mb-4">
            <h4>Daily, Monthly and Yearly Sales Quantity of this <span class="text-danger">"{{items}}"</span> item.</h4>
        </div>
        <div class="row">        
            <div class="col-4">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Daily Sales Quantity of Selected Item</h3>
                        
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                        <bar-chart v-if="loaded" :datacollection="barChartDataDaily" :options="barChartOption" id="sales-chart"></bar-chart>
                        </div>
                        <div class="d-flex flex-row justify-content-end">
                        <span class="mr-2">
                            
                        </span>

                        </div>
                    </div>
                </div>
            </div>    
            <div class="col-4">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Monthly Sales Quantity of Selected Item</h3>
                        
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                        <bar-chart v-if="loaded" :datacollection="barChartDataMonth" :options="barChartOption" id="sales-chart"></bar-chart>
                        </div>
                        <div class="d-flex flex-row justify-content-end">
                        <span class="mr-2">
                            
                        </span>

                        </div>
                    </div>
                </div>
            </div>          
            <div class="col-4">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Yearly Sales Quantity of Selected Item</h3>
                        
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                        <line-chart
                            v-if="loaded"
                            :chartdata="lineChartData"
                            :options="lineChartOptions"
                            />
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                        <span class="mr-2">
                            
                        </span>

                        </div>
                    </div>
                </div>
            </div>       
                
        </div>
    </div>
    
</template>

<script>
    import LineChart from './LineChart.vue'
    import BarChart from './Chart.vue'
    export default {
        components: { LineChart, BarChart },

        data() {
            return {
                items: null,
                loaded : false,
                barChartDataDaily : null,
                barChartDataMonth :null,
                lineChartData: null,
                lineChartOptions: {
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
                    
                },
                barChartOption : {
                    scales: {
                        xAxes: [
                            {
                                type: "category",
                                stacked: true,
                                gridLines: {
                                    display: false
                                }
                            }
                        ],
                        yAxes: [    
                            {
                                type: "linear",
                                stacked: true,
                                ticks: {
                                    min: 0,
                                    stepSize: 0.5,
                                },
                            }
                        ]
                    }
                }
            }
        },
        
        created(){
            
           Event.$on('get-chart', ($event) => {    
                this.items = $event;
                this.getChart();               
            });
        },

        methods: {
            getChart() {
                this.loaded = false
                fetch('api/item-chart',{
                    method: 'POST',
                    body: JSON.stringify(this.items),
                    headers: {
                        'Content-type' : 'Application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.barChartDataDaily = res.dailyqty
                    this.barChartDataMonth = res.monthlyqty
                    this.lineChartData = res.yearlyqty
                    this.loaded = true
                })
                .catch(err => toastr.error(err))
            }
        }
    }
</script>

