<template>
    <div>
        <div class="heading">
             <div class="row">
                <div class="col-md-3">
                    <h3 id="title"> Add Event</h3>
                    <add-event-form v-on:refreshCalendar="getList()"/>
                </div>
                <div class="col-md-9">
                    <eventList :events="events" />
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
import addEventForm from "./addEventForm.vue";
import eventList from "./eventList.vue";
import Calendar from 'v-calendar/lib/components/calendar.umd'

export default{
    components: {
        eventList,
        addEventForm,
        Calendar
    },
    data: function(){
        return {
            events: []
        }
    },
    methods: {
        getList (){
            axios.get('api/events')
            .then ( response => {
                this.events = response.data
            })
            .catch( error => {
                console.log(error);
            })
        }
    },
    created() {
        this.getList();
    }
}
</script>