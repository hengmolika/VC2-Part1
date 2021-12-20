<template>
  <section>
    <div class="container p-4">
      <h2 class="text-dark">Find and Join the event here.</h2>

      <hr class="pb-1 bg-secondary mt-4 mb-4" />
      <!-- ########################### FIND EVENT SEARCH FORM COMPONENT ###################### -->
      <my-event-search
        @searchFindEvent="searchFindEvent"
        @searchEventCity="findEventByCity"
      >
      </my-event-search>

      <!-- ########################### FIND EVENT CARD COMPONENT ###################### -->
      <find-event-card
        v-for="event of events"
        :key="event.id"
        :event="event"
        :buttonMode="findEventMode"
        @toJoin="joinEvent"
        @toQuit="quitEvent"
        class="mt-3"
      >
      </find-event-card>
    </div>

    <!-- <div>
      <event-card></event-card>
    </div> -->
  </section>
</template>

<script>
import axios from "../axios-http.js";
import FindEventCard from "../components/Pages/myevent/MyEventCard.vue";
// import FindEvent from '../components/Pages/myevent/MyEventCard.vue'
import FindEventSearch from "../components/Pages/FindEvent/FindEventSearch.vue";
// import EventCard from "../components/Pages/myevent/MyEventCard.vue";
export default {
  components: {
    "find-event-card": FindEventCard,
    "my-event-search": FindEventSearch,
    // "find-event-card": EventCard,
  },
  data() {
    return {
      events: [],
      findEventMode: "findEvent",
    };
  },
  methods: {
    // ############################# GET EVENT FUNCTION #############################
    getFindEventData() {
      axios.get("/myevent").then((res) => {
        this.events = res.data.filter(
          (event) => event.user_id !== parseInt(localStorage.getItem("userId"))
        );
      });
    },
    // ############################# FIND EVENT BY TITLE FUNCTION #############################
    searchFindEvent(title) {
      if (title !== "") {
        axios.get("/myevent/search/" + title).then((res) => {
          this.events = res.data.filter(
            (event) =>
              event.user_id !== parseInt(localStorage.getItem("userId"))
          );
        });
      } else {
        this.getFindEventData();
      }
    },
    // ############################# FIND EVENT BY CITY FUNCTION #############################
    findEventByCity(city) {
      if (city !== "") {
        axios.get("/myevent/searchCity/" + city).then((res) => {
          this.events = res.data.filter(
            (event) =>
              event.user_id !== parseInt(localStorage.getItem("userId"))
          );
        });
      } else {
        this.getFindEventData();
      }
    },
    // ############################# JOIN EVENT  FUNCTION #############################
    joinEvent(event) {
      let joinData = {
        user_id: parseInt(localStorage.getItem("userId")),
        my_event_id: event.id,
      };
      axios.post("/join", joinData).then(() => {
        this.getFindEventData();
      });
    },
    // ############################# QUIT EVENT FUNCTION ###############################
    quitEvent(event) {
      let joinId = "";
      for (let join of event.join) {
        if (join.user_id === parseInt(localStorage.getItem("userId"))) {
          joinId = join.id;
        }
      }
      axios.delete("/join/" + joinId).then(() => {
        this.getFindEventData();
      });
    },
  },
  mounted() {
    this.getFindEventData();
  },
};
</script>

<style>
</style>