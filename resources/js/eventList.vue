<template>
    <div>
        <div class="heading">
            <h3 id="title"> Event Calendar</h3>
            <table class="table table" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th width="10%">{{month}}</th>
                        <th >{{year}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(event, index) in events" :key="index">
                            <th scope="row" >{{event.date}}</th>
                            <td>{{event.event}}</td>
                    </tr>
                </tbody>
                    
            </table>
            
                
        </div>
    </div>
    
</template>

<script >
const moment= require('moment') 
import addEventForm from "./addEventForm.vue";

export default{
    props: ['events'],
    data(){
        return{
            month: moment().format('MMMM'),
            year: moment().format('Y')
        }
    },
    components: {
        addEventForm
    }
}
</script>