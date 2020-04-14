<template>
    <div class="card card-secondary" id="app">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Sales</h3>
                
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex">
                <p class="d-flex flex-column">
                <span v-if="loaded" class="text-bold text-lg">Php {{total}}</span>
                <span>Sales Over This Year</span>
                </p>
                <p class="ml-auto d-flex flex-column text-right">
                <span v-if="percentage > 0" class="text-success">
                    <i class="fas fa-arrow-up"></i> {{percentage}}%
                </span>
                <span v-if="percentage < 0" class="text-danger">
                    <i class="fas fa-arrow-down"></i> {{percentage}}%
                </span>
                <span class="text-muted">Since last month</span>
                </p>
            </div>
        <!-- /.d-flex -->

            <div class="position-relative mb-4">
               <bar-chart v-if="loaded" :datacollection="datacollection" :options="options" id="sales-chart"></bar-chart>
            </div>

            <div class="d-flex flex-row justify-content-end">
                <span class="mr-2">
                <i class="fas fa-square text-primary"></i> This year
                </span>

                <span>
                <i class="fas fa-square text-gray"></i> Last year
                </span>
            </div>
        </div>
    </div>
    <!-- /.card -->
</template>

<script>
    import BarChart from './Chart.vue'
    export default {
      components: { BarChart },
       data() {
           return{
            datacollection: null,
            options: {
                responsive: true,
				maintainAspectRatio: false,
				height: 200,
                scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						},
						gridLines: {
							display: true
						}
					}],
					xAxes: [{
						ticks: {
							beginAtZero: true
						},
						gridLines: {
							display: false
						},
					}]
				},
				legend: {
					display: false
				},
				tooltips: {
					enabled: true,
					mode: 'single',
					callbacks: {
						label: function(tooltipItems, data) {
							return 'Php ' + tooltipItems.yLabel;
						}
					}
				},
				
            },
            loaded: false,
            total: null,
            percentage: 0,
           }
           
        },

        async mounted () {
            this.loaded = false
            try {
                await fetch('/api/month-sales')
                .then(res => res.json())
                .then(res => {
                    this.datacollection = res
                    this.loaded = true                    
                })
                .catch(err => toastr.error(err))          
            
            } catch (e) {
                toastr.error(e)
            }
            
            try {
                await fetch('/api/total-sales')
                .then(res => res.json())
                .then(res => {
                    this.total = res.data
                    this.percentage = res.percentage
                })
                .catch(err => toastr.error(err))
            } catch (e) {
                toastr.error(e)
            }
        }
    }
</script>
