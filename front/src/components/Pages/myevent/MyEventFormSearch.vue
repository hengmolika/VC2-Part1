<template>
    <section> 
        <form class="form row">
            <div class="form-group  col-sm-12">
                <label for="name">Search Event Title</label>
                <div class="input-group form-group">
                    <input
                        id="name"
                        type="text"
                        class="form-control"
                        placeholder="Search your event here..."
                        aria-label="Username"
                        aria-describedby="basic-addon1"
                        v-model="name"
                        @keyup="search"
                    />
                    <div class="input-group-prepend" >
                        <button
                        class="btn rounded-right fa fa-remove" 
                        id="basic-addon1"
                        @click.prevent="clearName"
                        ></button>
                    </div>
                </div>
            </div>
            
        </form>
    </section>
</template>
<script>
export default {
    emits: ['searchName'],
    data() {
        return {
            name: ''
        }
    },
    methods: {
        search() {
            this.$emit('searchName', this.name);
        },
        clearName() {
            this.name = '';
            this.search();
        }
    },

  mounted() {
  
  },
};
</script>

<style scoped>
label {
  font-weight: bold;
  display: block;
  margin-bottom: 0.5rem;
}
.btn{
    background: #020269;
    color: rgb(219, 217, 211);

}
</style>