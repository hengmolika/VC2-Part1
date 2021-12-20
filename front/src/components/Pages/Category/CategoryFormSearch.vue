<template>
    <section> 
        <form class="form">
            <div class="input-group">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Search here..."
                    aria-label="Username"
                    aria-describedby="basic-addon1"
                    v-model="name"
                    @keyup.prevent="addName" 
                />
                <div class="input-group-prepend">
                    <button
                    class="btn rounded-right fa fa-remove text-white" if
                    id="basic-addon1"
                    @click.prevent="clearName"
                    ></button>
                </div>
            </div>
        </form>
    </section>
</template>
<script>
export default {
    emits: ['addName'],
    data() {
        return {
            name: ''
        }
    },
    methods: {
        addName() {
            this.$emit('addName', this.name);
        },
        clearName() {
            this.name = '';
            this.addName();
        }
    },
    mounted() {
        
    },
}
</script>

<style scoped>
    #basic-addon1{
         background:#022669;
    }
</style>