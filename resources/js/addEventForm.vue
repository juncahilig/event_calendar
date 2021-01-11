<template>
    <div>
        <div class="addEvent">
            <div class="row">
                <div class="row">
                    <div class="col-md-12">
                        <label>Title:</label>
                        <input type="text" id="title" class="title" v-model="event.title"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Date Range:</label>
                        <DatePicker is-range v-model="event.date_range" />
                    </div>
                </div>
                <div class="row">
                        <label>Days:</label>

                    <div class="col-md-4" v-for="day in days" :key="day.id">
                        <input id=" day.name " type="checkbox" v-model="day.check"/>
                        <label for=" day.name ">{{ day.name }}</label>

                    </div>
                </div>
                <span class="error-message">{{error_message}}</span><br/>
                <button @click="addEvent()" class="btn btn-primary" >Save</button>
                
            </div>
            

        </div>
    </div>
    
</template>

<script>

import DatePicker from 'v-calendar/lib/components/date-picker.umd'


export default{
    
    components: {
        DatePicker
    },
    data: function (){
    
        return {
           
            error_message: "",
            event:{
                title:"",
                date_range: null,
                
            },
            days: [
                    {
                        id: 1,
                        name: "Monday",
                        check: false
                    },
                    {
                        id: 2,
                        name: "Tuesday",
                        check: false
                    },
                    {
                        id: 3,
                        name: "Wednesday",
                        check: false
                    },
                    {
                        id: 4,
                        name: "Thursday",
                        check: false
                    },
                    {
                        id: 5,
                        name: "Friday",
                        check: false
                    },
                    {
                        id: 6,
                        name: "Saturday",
                        check: false
                    },
                    {
                        id: 7,
                        name: "Sunday",
                        check: false
                    }

                ]
        }
    },
    methods:{
        addEvent() {
            if( this.event.title == '' || this.event.date_range == null){
                this.error_message = "Please Complete Event Details";
                return;
            }
            this.error_message = "";
            axios.post('api/event/store', {
                event: this.event,
                days: this.days
            })
            .then( response => {
                if( response.status == 201){
                    this.event.title =="";
                    this.event.date_range =="";

                    this.$emit("refreshCalendar");
                }
            })
            .catch( error => {
                console.log( error );
            })
        }
    }
}
</script>

<style scoped>
.addEvent {
    align-items: center;
}
.title {
    background: #f7f7f7;
    margin:10px;
    width: 100%;
}
.plus {
    font-size: 20px;
}
.active {
    color : #00ce25
}
.inactive{
    color: #999999
}

.error-message {
    color: red;
    font-weight: 700;
}

::-webkit-scrollbar {
  width: 0px;
}
::-webkit-scrollbar-track {
  display: none;
}
/deep/ .custom-calendar.vc-container {
  --day-border: 1px solid #b8c2cc;
  --day-border-highlight: 1px solid #b8c2cc;
  --day-width: 90px;
  --day-height: 90px;
  --weekday-bg: #f8fafc;
  --weekday-border: 1px solid #eaeaea;
  border-radius: 0;
  width: 100%;
  & .vc-header {
    background-color: #f1f5f8;
    padding: 10px 0;
  }
  & .vc-weeks {
    padding: 0;
  }
  & .vc-weekday {
    background-color: var(--weekday-bg);
    border-bottom: var(--weekday-border);
    border-top: var(--weekday-border);
    padding: 5px 0;
  }
  & .vc-day {
    padding: 0 5px 3px 5px;
    text-align: left;
    height: var(--day-height);
    min-width: var(--day-width);
    background-color: white;
    &.weekday-1,
    &.weekday-7 {
      background-color: #eff8ff;
    }
    &:not(.on-bottom) {
      border-bottom: var(--day-border);
      &.weekday-1 {
        border-bottom: var(--day-border-highlight);
      }
    }
    &:not(.on-right) {
      border-right: var(--day-border);
    }
  }
  & .vc-day-dots {
    margin-bottom: 5px;
  }
}
</style>