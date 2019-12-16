//Importing Line class from the vue-chartjs wrapper
import { Bar } from 'vue-chartjs'
//Exporting this so it can be used in other components
export default {
    props: ['client'],
    // extend: Line,
    extends: Bar,
    data() {
        return {
            label: [],
            rows: []
        }
    },
    // mounted() {
    //     this.screen_chart()
    // },
    methods: {
        screen_chart() {
            axios.get(`/screen_filter_chart/${this.client.id}`)
                .then((response) => {
                    // console.log(response);
                    this.label = response.data.data.lables
                    this.rows = response.data.data.rows
                    this.setGraph()
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
        },
        screen_c_chart(id) {
            axios.get(`/screen_filter_chart/${id}`)
                .then((response) => {
                    // console.log(response);
                    this.label = response.data.data.lables
                    this.rows = response.data.data.rows
                    this.setGraph()
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
        },
        setGraph() {
            this.renderChart({
                labels: this.label,
                datasets: [
                    {
                        label: 'Week Delivery Graph',
                        backgroundColor: '#2a513e',
                        data: this.rows
                    }
                ]
            }, { responsive: true, maintainAspectRatio: false })
        },
        ref() {
            axios.get('/getChartBranch')
                .then((response) => {
                    console.log(response);
                    this.label = response.data.lables
                    this.data = response.data.rows
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
        }
    },
    created() {
        eventBus.$on('chartEvent', data => {
            this.label = data.lables
            this.data = data.rows
        });
        eventBus.$on('refreshChartEvent', data => {
            this.screen_chart()
        });
        eventBus.$on('getChartEvent', data => {
            this.screen_c_chart(data.id)
        });
    },
}
