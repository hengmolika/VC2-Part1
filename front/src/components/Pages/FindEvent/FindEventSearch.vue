<template>
    <section> 
        <form class="form row">
            <div class="form-group  col-sm-6">
                <label for="name">Find by name</label>
                <div class="input-group form-group">
                    <input
                        id="name"
                        type="text"
                        class="form-control"
                        placeholder="Search your event here..."
                        aria-label="Username"
                        aria-describedby="basic-addon1"
                        v-model="title"
                        @keyup="searchTitle"
                    />
                    <div class="input-group-prepend">
                        <button
                        class="btn btn-danger rounded-right fa fa-remove"
                        id="basic-addon1"
                        @click.prevent="clearSearchTitle"
                        ></button>
                    </div>
                </div>
            </div>
            <div class="form-group  col-sm-6">
                <label for="city">Find by city</label>
                <div class="input-group form-group">
                    <select class="form-control" @change="searchCity" v-model="city">
                        <option> </option>
                        <option v-for="city of cities" :key="city" :value="city"> {{city}} </option>
                    </select>
                </div>
            </div>
            
        </form>
    </section>
</template>
<script>
import axios from '../../../axios-http.js'
export default {
    emits: ['searchFindEvent', 'searchEventCity'],
    data() {
        return {
            title: '',
            cities: [],
            city: ''
        }
    },
    methods: {
        searchTitle() {
            this.$emit('searchFindEvent', this.title);
        },
        clearSearchTitle() {
            this.title = "";
            this.searchTitle();
        },
        searchCity() {
            this.$emit('searchEventCity', this.city);
        }
     },
    mounted() {
        axios.get('/countries')
        .then(res => {

            for (let city of res.data["Cambodia"]) {
                this.cities.push(city);
            }
        })
    },
}
</script>

<style scoped>
label {
  font-weight: bold;
  display: block;
  margin-bottom: 0.5rem;
}
</style>