<?php
/**
 * Created by PhpStorm.
 * User: FOCUS
 * Date: 2018/12/9
 * Time: 16:17
 */
?>
<style>
    .active {
        background-color: red;
        color: white;
    }
</style>
<div id="app">
    原文{{message }}<br>
    模板{{message.split('').reverse().join('')}}<br>
    方法{{reverse(message)}}<br>
    过滤器{{message|reverse}}<br>
    技术属性{{reverseMsg}}<br>
    <hr>
    <table :class="table_class">
        <tr>
            <th>编号</th>
            <th>姓名</th>
            <th>年龄</th>
        </tr>
        <tr v-for="(user ,index) in users">
            <td>{{index+1}}</td>
            <td>{{user.name}}</td>
            <td>{{user.age}}</td>
        </tr>
    </table>
</div>


<script src="/static/js/vue.js"></script>
<script>
    var row = {
        message: 'hello world',
        hobbys: ['吃饭', '睡觉', '打豆豆'],
        table_class: 'table',
        users: [
            {name: 'zhang', age: 18},
            {name: 'zhang1', age: 18},
            {name: 'zhang2', age: 18},
            {name: 'zhang3', age: 18},
        ],
    };
    var vm = new Vue({
        el: '#app',
        data: row,
        methods: {
            doThis: function (value, event) {
                console.log(value);
                console.log(event);
            },
            sp: function (value) {
                console.log(value.split(" "));
            },
            reverse: function (value) {
                return value.split('').reverse().join('');
            }
        },
        filters: {
            up: function (value) {
                return value.toUpperCase();
            }, capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            },
            reverse:function (value) {
                return value.split('').reverse().join('');
            }
        },
        computed:{
            reverseMsg:function () {
                return this.message.split('').reverse().join('');
            }
        }
    });

    setInterval(function () {
        vm.activeYes++;
        if (vm.activeYes > 2) {
            vm.activeYes = 0;
        }
    }, 2000)
</script>
