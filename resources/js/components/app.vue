<script>
import axios from 'axios';

export default {
    data() {
        return {
            task_assignments: [],
            developers: []
        }
    },
    mounted() {
        this.fetchTasks();
    },
    computed: {
        totalTime() {
            let hours = 0;
            let days = 0;
            let weeks = 0;
            let months = 0;

            this.developers.forEach(developer => {
                developer.task_assignments.forEach(assignment => {
                    hours += assignment.hours_allocated.hour || 0;
                    days += assignment.hours_allocated.day || 0;
                    weeks += assignment.hours_allocated.week || 0;
                });
            });

            days += Math.floor(hours / 24);
            hours %= 24;

            weeks += Math.floor(days / 7);
            days %= 7;

            months += Math.floor(weeks / 4);
            weeks %= 4;

            return {hours, days, weeks, months};
        }
    },
    methods: {
        fetchTasks() {
            axios.get('/api/task-assignments')
                .then(response => {
                    this.task_assignments = response.data;
                })
                .catch(error => {
                    console.log(error);
                });

            axios.get('/api/developers')
                .then(response => {
                    this.developers = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        developerTotalTime(developer) {
            let hours = 0;
            let days = 0;
            let weeks = 0;
            let months = 0;

            developer.task_assignments.forEach(assignment => {
                hours += assignment.hours_allocated.hour || 0;
                days += assignment.hours_allocated.day || 0;
                weeks += assignment.hours_allocated.week || 0;
            });

            days += Math.floor(hours / 24);
            hours %= 24;

            weeks += Math.floor(days / 7);
            days %= 7;

            months += Math.floor(weeks / 4);
            weeks %= 4;

            let timeString = '';
            if (months) timeString += months + ' ay ';
            if (weeks) timeString += weeks + ' hafta ';
            if (days) timeString += days + ' gün ';
            if (hours) timeString += hours + ' saat ';

            return timeString;
        },
        formatTime(hours) {
            let timeString = '';
            if (hours.week) {
                timeString += hours.week + ' hafta ';
            }
            if (hours.day) {
                timeString += hours.day + ' gün ';
            }
            if (hours.hour) {
                timeString += hours.hour + ' saat ';
            }

            return timeString;
        },
    }
}
</script>

<template>
    <div class="container mt-5">

        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3 w-75" id="v-pills-tab" role="tablist"
                 aria-orientation="vertical">
                <button v-for="developer in developers" :key="developer" class="nav-link" :class="developer.id === 1 ? ' active' : ''"
                        :id="'v-pills-' + developer.id + '-tab'" data-bs-toggle="pill"
                        :data-bs-target="'#' + developer.id" type="button" role="tab" aria-controls="v-pills-home"
                        aria-selected="true">
                    {{ developer.name }}
                </button>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div v-for="developer in developers" :key="developer" class="tab-pane fade " :class="developer.id === 1 ? ' show active' : ''"
                     :id="'' + developer.id"
                     role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">
                    <div class="row">
                        <div class="col-md-2 card my-2 mx-2" v-for="assignment in developer.task_assignments"
                             :key="assignment">
                            <div class="card-header">
                                {{ assignment.task.name }}
                            </div>
                            <div class="card-body">
                                <span>{{ formatTime(assignment.hours_allocated) }} </span>
                            </div>
                        </div>
                        <div class="col-md-6 card my-2 mx-2">
                            <div class="card-header">
                                Görevlerin Bitirilmesi Gereken Toplam Süre:
                            </div>
                            <div class="card-body">
                                {{ developerTotalTime(developer) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
