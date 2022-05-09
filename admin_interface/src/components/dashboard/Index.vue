<template>
    <div class="pcoded-inner-content" v-if="userLogin">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- [ Main Content ] start -->
                    <div class="row" v-if="profitData != ''">
                        <!--[ daily sales section ] start-->
                        <div class="col-md-6 col-xl-4">
                            <div class="card daily-sales">
                                <div class="card-block">
                                    <h6 class="mb-4">Profit of the week</h6>
                                    <div class="row d-flex align-items-center">
                                        <div class="col-9">
                                            <h3 class="f-w-300 d-flex align-items-center m-b-0">
                                                <i class="feather icon-arrow-up text-c-green f-30 m-r-10" v-if="profitData.profitOfWeek.evaluation == 'increase'"></i>
                                                <i class="feather icon-arrow-down text-c-red f-30 m-r-10" v-else></i>
                                                $ {{ profitData.profitOfWeek.profit }}
                                            </h3>
                                        </div>

                                        <div class="col-3 text-right">
                                            <p class="m-b-0">{{profitData.profitOfWeek.percent}}%</p>
                                        </div>
                                    </div>
                                    <div class="progress m-t-30" style="height: 7px;">
                                        <div class="progress-bar progress-c-theme" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" v-if="profitData.profitOfWeek.evaluation == 'increase'"></div>
                                        <div class="progress-bar progress-c-theme2" role="progressbar" style="width: 100%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" v-else></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--[ daily sales section ] end-->
                        <!--[ Monthly  sales section ] starts-->
                        <div class="col-md-6 col-xl-4">
                            <div class="card Monthly-sales">
                                <div class="card-block">
                                    <h6 class="mb-4">Profit of the month</h6>
                                    <div class="row d-flex align-items-center">
                                        <div class="col-9">
                                            <h3 class="f-w-300 d-flex align-items-center  m-b-0">
                                                <i class="feather icon-arrow-up text-c-green f-30 m-r-10" v-if="profitData.profitOfMonth.evaluation == 'increase'"></i>
                                                <i class="feather icon-arrow-down text-c-red f-30 m-r-10" v-else></i>
                                            $ {{ profitData.profitOfMonth.profit }}</h3>
                                        </div>
                                        <div class="col-3 text-right">
                                            <p class="m-b-0">{{ profitData.profitOfMonth.percent }}%</p>
                                        </div>
                                    </div>
                                    <div class="progress m-t-30" style="height: 7px;">
                                        <div class="progress-bar progress-c-theme" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" v-if="profitData.profitOfMonth.evaluation == 'increase'"></div>
                                        <div class="progress-bar progress-c-theme2" role="progressbar" style="width: 100%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" v-else></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--[ Monthly  sales section ] end-->
                        <!--[ year  sales section ] starts-->
                        <div class="col-md-12 col-xl-4">
                            <div class="card yearly-sales">
                                <div class="card-block">
                                    <h6 class="mb-4">Profit of the year</h6>
                                    <div class="row d-flex align-items-center">
                                        <div class="col-9">
                                            <h3 class="f-w-300 d-flex align-items-center  m-b-0">
                                                <i class="feather icon-arrow-up text-c-green f-30 m-r-10" v-if="profitData.profitOfYear.evaluation == 'increase'"></i>
                                                <i class="feather icon-arrow-down text-c-red f-30 m-r-10" v-else></i>
                                                $ {{ profitData.profitOfYear.profit }}</h3>
                                        </div>
                                        <div class="col-3 text-right">
                                            <p class="m-b-0">{{ profitData.profitOfYear.percent }}%</p>
                                        </div>
                                    </div>
                                    <div class="progress m-t-30" style="height: 7px;">
                                         <div class="progress-bar progress-c-theme" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" v-if="profitData.profitOfYear.evaluation == 'increase'"></div>
                                        <div class="progress-bar progress-c-theme2" role="progressbar" style="width: 100%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" v-else></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Profit statistic -->
                    <div class="col-12 text-center">
                        <h3>Profit statistic</h3>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p style="color:black;">Filter by date:</p>
                            <div class="row">
                            <p>From: <input type="text" id="datepickerStart" autocomplete="off" class="fromDate"></p>
                            <p>To: <input type="text" id="datepickerEnd" autocomplete="off" style="margin-right:2px;" class="toDate"> 
                                <button style="cursor:pointer; border-radius:5px; border-color:gray;" v-on:click="filterByDate()">filter</button>
                            </p>
                            </div>
                        </div>
                        <div class="col-5">
                            <p style="color:black;">Filter:</p>
                            <div class="row">
                                <select v-on:change="filterBySelect()" v-model="filter">
                                    <option value="7Ago">7 days ago</option>
                                    <option value="14Ago">14 days ago</option>
                                    <option value="monthAgo">a month ago</option>
                                    <option value="6MonthAgo">6 months ago</option>
                                    <option value="yearAgo">a year ago</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div id="myfirstchart" style="height: 250px;"></div>
                        </div>
                    </div>
                    <!-- end Profit statistic -->
                    
                    <!-- Statistic quantity sold and purchased -->
                    <div class="col-12 text-center mt-4">
                        <h3>Statistic quantity sold and purchased</h3>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div id="mySecondaryChart" style="height: 250px;"></div>
                        </div>
                    </div>
                    <!-- end Statistic quantity sold and purchased -->

                    <!-- Statistic new user -->
                    <div class="col-12 text-center mt-4">
                        <h3>New user statistic</h3>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div id="newUserChart" style="height: 250px;"></div>
                        </div>
                    </div>
                    <!-- end Statistic new user -->

                    <!-- Statistic payment -->
                    <div class="col-12 text-center mt-4">
                        <h3>payment statistic</h3>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div id="paymentStatisticChart" style="height: 250px;"></div>
                        </div>
                    </div>
                    <!-- end Statistic payment -->
                </div>
            </div>
        </div>
 
    </div>
</template>
<script>
import axios from "axios"
    export default {
        props:['userLogin'],
        data(){
           return {
               user:null,
               filter:"",
               fromDate:"",
               toDate:"",
               profitData:"",
               profitStatisticChart:"",
               soldAndPurchaseStatisticChart:"",
               newUserStatisticChart:"",
               paymentStatisticChart:""
           }
        },
        mounted(){
            this.filter = '7Ago'
            $( "#datepickerStart" ).datepicker();
            $( "#datepickerStart" ).datepicker("option", "dateFormat",'yy-mm-dd');
            $( "#datepickerEnd" ).datepicker();
            $( "#datepickerEnd" ).datepicker("option", "dateFormat",'yy-mm-dd');
            this.profitStatisticChart = new Morris.Line({
                // ID of the element in which to draw the chart.
                element: 'myfirstchart',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: [],
                // The name of the data record attribute that contains x-values.
                xkey: 'year',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['profit'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['profit'],
                parseTime:false

            }),
            this.soldAndPurchaseStatisticChart = new Morris.Line({
                // ID of the element in which to draw the chart.
                element: 'mySecondaryChart',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: [],
                // The name of the data record attribute that contains x-values.
                xkey: 'year',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['quantitySold','quantityPurchased'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['quantity Sold','quantity Purchased'],
                parseTime:false

            }),
            this.newUserStatisticChart = new Morris.Line({
                // ID of the element in which to draw the chart.
                element: 'newUserChart',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: [],
                // The name of the data record attribute that contains x-values.
                xkey: 'year',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['newUser'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['new user'],
                parseTime:false

            }),
            this.paymentStatisticChart = new Morris.Donut({
                element: 'paymentStatisticChart',
                data: [
                    {label: "", value: 0}
                ]
            });

            this.filterBySelect();

            axios.post(this.$hostname +'/api/v1/statistic/profitData',{value:this.filter},{headers:{"Authorization" : "Bearer " + this.userLogin.token,'Content-Type': 'application/json','Accept': 'application/json'}})
                .then(res => {
                    this.profitData = res.data;
                    // console.log(this.profitData.profitOfWeek.profit)
                })
            
        },
        methods: {
            filterBySelect:function (){
                axios.post(this.$hostname +'/api/v1/statistic/filterBySelect',{value:this.filter},{headers:{"Authorization" : "Bearer " + this.userLogin.token,'Content-Type': 'application/json','Accept': 'application/json'}})
                    .then(res => {
                        this.profitStatisticChart.setData(res.data.dataLineChart)
                        this.soldAndPurchaseStatisticChart.setData(res.data.dataLineChart)
                        this.newUserStatisticChart.setData(res.data.dataLineChart)
                        this.paymentStatisticChart.setData(res.data.dataDonutChart)
                    })
            },
            filterByDate:function (){
                this.fromDate = $( ".fromDate" ).val();
                this.toDate = $( ".toDate" ).val();
                axios.post(this.$hostname +'/api/v1/statistic/filterByDate',{fromDate:this.fromDate,toDate:this.toDate},{headers:{"Authorization" : "Bearer " + this.userLogin.token,'Content-Type': 'application/json','Accept': 'application/json'}})
                    .then(res => {
                        this.profitStatisticChart.setData(res.data.dataLineChart)
                        this.soldAndPurchaseStatisticChart.setData(res.data.dataLineChart)
                        this.newUserStatisticChart.setData(res.data.dataLineChart)
                        this.paymentStatisticChart.setData(res.data.dataDonutChart)
                    })
            }
        },
    }
</script>
<style>
    
</style>