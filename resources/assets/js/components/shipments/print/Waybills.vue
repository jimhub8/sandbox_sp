<template>
<div>
    <Tzprint v-if="country === 'Tanzania'"></Tzprint>
    <myKenPrint v-if="country === 'Kenya'"></myKenPrint>
    <Ugprint v-if="country === 'Uganda'"></Ugprint>
    <Rwprint v-if="country === 'Rwanda'"></Rwprint>
    <Nprint v-if="country === 'Nigeria'"></Nprint>
</div>
</template>

<script>
import myKenPrint from './KPrintPdf.vue';
import Tzprint from './Tzprint';
import Ugprint from './Ugprint';
import Rwprint from './Rwprint';
import Nprint from './nigeria/Nigeria'
export default {
    components: {
        Tzprint,
        myKenPrint,
        Ugprint,
        Rwprint,
        Nprint
    },
    props: ['user'],
    data() {
        return {
            AllCountries: [],
            country: '',
        }
    },
    methods: {
        country_name(data) {
            data.forEach(element => {
                if (parseInt(this.user.country_id) === parseInt(element.id)) {
                    this.country = element.country_name
                }
            });
        }
    },
    mounted() {
        axios.get('/getCountry')
            .then((response) => {
                this.AllCountries = response.data
                this.country_name(response.data)
            })
            .catch((error) => {
                this.errors = error.response.data.errors
            })
    },
}
</script>

<style>

</style>
