
<script>
    import { HorizontalBar } from 'vue-chartjs'

    export default {
        extends: HorizontalBar,
        
		props: {
			datacollection: {
                type: Object,
                default: null
            },
			options: {
				type: Object,
                default: null
            }	
		
	    },
        mounted () {
            // this.chartData is created in the mixin
            this.renderChart(this.datacollection, this.options)
        }
    }
</script>
