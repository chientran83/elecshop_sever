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
                        <div class="col-11 ml-auto mr-auto">
                            <canvas id="profitStatisticChart"></canvas>
                        </div>
                    </div>
                    <!-- end Profit statistic -->
                    
                    <!-- Statistic quantity sold and purchased -->
                    <div class="col-12 text-center mt-4">
                        <h3>Statistic quantity sold and purchased</h3>
                    </div>
                    <div class="row">
                        <div class="col-11 ml-auto mr-auto">
                            <canvas id="soldAndPurchaseStatisticChart"></canvas>
                        </div>
                    </div>
                    <!-- end Statistic quantity sold and purchased -->

                    <!-- Statistic new user -->
                    <div class="col-12 text-center mt-4">
                        <h3>New user statistic</h3>
                    </div>
                    <div class="row">
                        <div class="col-11 ml-auto mr-auto">
                            <canvas id="newUserStatisticChart"></canvas>
                        </div>
                    </div>
                    <!-- end Statistic new user -->

                    <!-- Statistic payment -->
                    <div class="col-12 text-center mt-4">
                        <h3>payment statistic</h3>
                    </div>
                    <div class="row ">
                        <div class="col-6 ml-auto mr-auto">
                            <canvas id="paymentStatisticChart"></canvas>
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
        
            // profit statistic
                this.profitStatisticChart = new Chart(
                    document.getElementById('profitStatisticChart'),
                        {
                        type: 'line',
                        data: {
                            labels: [
                                'January',
                                'February',
                                'March',
                                'April',
                                'May',
                                'June',
                            ],
                        datasets: [{
                            label: 'profit',
                            backgroundColor: 'rgb(255, 99, 132)',
                            borderColor: 'rgb(255, 99, 132)',
                            data: [0, 0, 0, 0, 0, 0, 0],
                        }]
                    },
                        options: {}
                    }
                );

            //end profit statistic
            
            // quantity sold and purchased statistic
                this.soldAndPurchaseStatisticChart = new Chart(
                    document.getElementById('soldAndPurchaseStatisticChart'),
                        {
                        type: 'line',
                        data: {
                            labels: [
                                'January',
                                'February',
                                'March',
                                'April',
                                'May',
                                'June',
                            ],
                        datasets:[{
                            label: 'quantity sold',
                            backgroundColor: '#99ff99',
                            borderColor: '#99ff99',
                            data: [0, 0, 0, 0, 0, 0, 0]
                        },{
                            label: 'quantity purchased',
                            backgroundColor: 'rgb(255, 99, 132)',
                            borderColor: 'rgb(255, 99, 132)',
                            data: [0, 0, 0, 0, 0, 0, 0]
                        }]
                    },
                        options: {}
                    }
                );

            //end quantity sold and purchased statistic

            // new User statistic
                this.newUserStatisticChart = new Chart(
                    document.getElementById('newUserStatisticChart'),
                        {
                        type: 'line',
                        data: {
                            labels: [
                                'January',
                                'February',
                                'March',
                                'April',
                                'May',
                                'June',
                            ],
                        datasets: [{
                            label: 'profit',
                            backgroundColor: 'rgb(255, 99, 132)',
                            borderColor: 'rgb(255, 99, 132)',
                            data: [0, 0, 0, 0, 0, 0, 0],
                        }]
                    },
                        options: {}
                    }
                );

            //new User statistic

            // payment method statistic
                this.paymentStatisticChart = new Chart(
                    document.getElementById('paymentStatisticChart'),
                        {
                        type: 'pie',
                        data: {
                            labels: [
                                'payment online',
                                'payment later'
                            ],
                            datasets: [{
                                label: 'My First Dataset',
                                data: [0, 100],
                                backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)'
                                ],
                                hoverOffset: 4
                            }]
                    },
                        options: {}
                    }
                            
                      
                );

            // payment method statistic

            this.filterBySelect();

            axios.post(this.$hostname +'/api/v1/statistic/profitData',{value:this.filter},{headers:{"Authorization" : "Bearer " + this.userLogin.token,'Content-Type': 'application/json','Accept': 'application/json'}})
                .then(res => {
                    this.profitData = res.data;
                })
            
        },
        methods: {
            filterBySelect:function (){
                axios.post(this.$hostname +'/api/v1/statistic/filterBySelect',{value:this.filter},{headers:{"Authorization" : "Bearer " + this.userLogin.token,'Content-Type': 'application/json','Accept': 'application/json'}})
                    .then(res => {
                        /* this.profitStatisticChart.setData(res.data.dataLineChart) */
                        /* 
                        this.paymentStatisticChart.setData(res.data.dataDonutChart) */

                        // profit statistic chart
                        this.updateLineChart(res.data.dataLineChart.profit,res.data.dataLineChart.profit.chartLabel,this.profitStatisticChart);
                        // new user statistic chart
                        this.updateLineChart(res.data.dataLineChart.newUser,res.data.dataLineChart.newUser.chartLabel,this.newUserStatisticChart);
                        // payment statistic chart
                        this.updateLineChart(res.data.dataDonutChart.payment,res.data.dataDonutChart.payment.chartLabel,this.paymentStatisticChart);
                        // quantity sold and quantity purchase statistic
                        var data =  this.soldAndPurchaseStatisticChart.config.data;
                        data.datasets[0].data = res.data.dataLineChart.quantitySold.chartData;
                        data.datasets[1].data = res.data.dataLineChart.quantityPurchased.chartData;
                        data.labels = res.data.dataLineChart.quantitySoldAndPurchased.chartLabel;
                         this.soldAndPurchaseStatisticChart.update();
                    })
            },
            filterByDate:function (){
                this.fromDate = $( ".fromDate" ).val();
                this.toDate = $( ".toDate" ).val();
                axios.post(this.$hostname +'/api/v1/statistic/filterByDate',{fromDate:this.fromDate,toDate:this.toDate},{headers:{"Authorization" : "Bearer " + this.userLogin.token,'Content-Type': 'application/json','Accept': 'application/json'}})
                    .then(res => {
                        // profit statistic chart
                        this.updateLineChart(res.data.dataLineChart.profit,res.data.dataLineChart.profit.chartLabel,this.profitStatisticChart);
                        // new user statistic chart
                        this.updateLineChart(res.data.dataLineChart.newUser,res.data.dataLineChart.newUser.chartLabel,this.newUserStatisticChart);
                        // payment statistic chart
                        this.updateLineChart(res.data.dataDonutChart.payment,res.data.dataDonutChart.payment.chartLabel,this.paymentStatisticChart);
                        // quantity sold and quantity purchase statistic
                        var data =  this.soldAndPurchaseStatisticChart.config.data;
                        data.datasets[0].data = res.data.dataLineChart.quantitySold.chartData;
                        data.datasets[1].data = res.data.dataLineChart.quantityPurchased.chartData;
                        data.labels = res.data.dataLineChart.quantitySoldAndPurchased.chartLabel;
                         this.soldAndPurchaseStatisticChart.update();
                        /* 
                        this.paymentStatisticChart.setData(res.data.dataDonutChart) */
                    })
            },
            updateLineChart:function (value,label,chart) {
                var data = chart.config.data;
                data.datasets[0].data = value.chartData;
                data.labels = label;
                chart.update();
            }
        },
    }
</script>
<style>
    
</style>