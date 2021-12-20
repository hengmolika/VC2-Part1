<template>
    <section>
        <div class="row" v-if="event.end_date > currentDateTime">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="row p-3">
                        <div class="col-sm-5  d-flex justify-content-start">
                            <img  :src="event.image !== '' ? url + event.image : url + 'empty.jpg' " class="img-fluid rounded" style="max-height: 200px; width: 70%;" alt="">
                        </div>
                        <img src="" alt="">
                        <div class="col-sm-4 d-flex flex-column justify-content-between">
                            <h5>{{event.category.name}}</h5>
                            <h3>{{event.title}}</h3>
                            <p>{{event.description}}</p>
                            <h6>{{event.join.length}} member joined</h6>
                        </div>
                        <div class="col-sm-3 d-flex flex-column justify-content-around">
                            <div class="btn-action d-flex justify-content-end" v-if="buttonMode === 'myEvent' ">
                                <button class="btn btn-danger fa fa-remove mr-3" @click="toRemove(event.id)"></button>
                                <button class="btn btn-success fa fa-pencil" @click="toEdit(event)"></button>
                            </div>
                            <div class="btn-action d-flex justify-content-end" v-if="buttonMode === 'findEvent' ">
                                <button class="btn btn-outline-success fa fa-check-circle" v-if="isJoin" @click="join(event)">  Join</button>
                                <button class="btn btn-outline-danger fa fa-times-circle" v-else @click="quit(event)">  Quit</button>
                            </div>
                            <div class=" d-flex flex-column justify-content-center align-items-center">
                                <div class="mt-4">
                                    <p class="text-muted">Start: {{event.start_date}}</p>
                                    <p class="text-muted">End: {{event.end_date}}</p>
                                    <p class="text-muted">Place: {{event.country}}, {{event.city}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        
</template>
<script>
export default {
    props: ['event', 'buttonMode'],
    emits: ['requestToEdt', 'requestToDelete', 'toJoin', 'toQuit'],
    data() {
        return {
            url : 'http://localhost:8000/storage/images/events/',
            userId: localStorage.getItem('userId'),
            isJoin: true,
        }
    },
    computed: {
        currentDateTime() {
            let today = new Date();
            let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            let time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            let dateTime = date +' '+ time;
            return dateTime;
        }
    },
    methods: {
        toRemove(id) {
            this.$emit('requestToDelete', id);
        },
        toEdit(data) {
            this.$emit('requestToEdt', data);
            console.log(data.user_id, data.user.id, this.userId)
        },
        join(event) {
            this.$emit('toJoin', event);
            this.isJoin = false;
        },
        quit(event){
            this.$emit('toQuit', event)
            this.isJoin = true;
        }
    },
    mounted() {
        if(this.event !== null) {
            for(let join of this.event.join) {
                if(parseInt(localStorage.getItem("userId")) === join.user_id) {
                    this.isJoin = false;
                }
            }
        }
    },

    
};
</script>
<style>
    .card {
        box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
    }

    
</style>