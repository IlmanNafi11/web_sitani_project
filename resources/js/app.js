import './bootstrap';
import "flyonui/flyonui"
import "lodash"
import ApexCharts from 'apexcharts';
import {buildChart} from 'flyonui/src/js/helpers/apexcharts/index.js';

window.ApexCharts = ApexCharts;
window.buildChart = buildChart;
