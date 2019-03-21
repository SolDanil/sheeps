<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>


        <!-- Fonts -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        
        <!-- <script src="https://unpkg.com/vue"></script> -->
        <script src="/js/app.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <style type="text/css">
            .flex{
                display: flex;
            }
            .flex-center{
                justify-content: center;
                align-items: center;
            }
            .flex-between{
                justify-content: space-between;
            }
            .flex-wrap{
                flex-wrap: wrap;
            }
            .zagons{
                border: 2px solid darkblue;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 10px;
                
                min-height: 100px;
                flex-wrap:wrap;

            }
            .zagons div{
                width: 20%
            }
            .zagons img{
                width: 100%
            }
            
            .col-6{
                max-width: calc(50% - 20px);

            }
            .col-sm-3{
                max-width: calc(25% - 20px);
            }
            .br-btm{
                border-bottom: 2px solid green;
            }
            .br-rht{
                border-right: 2px solid green;
            }
            .br-all{
                border:2px solid green;

            }
            .br-top{
                border-top: 2px solid green;

            }
            .pad{
                padding: 10px 0;

            }
            .marg{
                margin: 0 10px;
            }
            .green-bold{
                color:green;
                font-weight: bold;
            }
            .table td{
                text-align: center;
            }
        </style>
    </head>
    <body>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12 flex flex-center br-btm">
                        <h1>Загоны</h1>
                        
                    </div>
                    
                </div>
            
                <!--Жизнь в загонах-->
                <div class="row">
                    <div class="col-12 pad">

                        <div id="app" class="flex flex-wrap br-all" >                            

                            <div class="col-4 flex flex-center pad">
                                <button class="btn btn-primary marg" v-on:click="begin_game">Начать</button>
                                <button class="btn btn-primary marg" v-on:click="end_game">Завершить</button>
                            </div>
                            <div class="col-4 flex flex-center">
                                <h3 v-html="title_name" style="color: darkblue;">День</h3>
                            </div>
                            <div class="col-4 flex flex-center pad">
                                <label>Время периода суток (сек)</label><input class="form-control" type="text" name="interval" :value="interval" v-on:input="interval=$event.target.value" style="width: 50px;margin-left: 10px;">
                            </div>
                            
                            <div class="col-12 flex flex-between pad br-top">

                                <!-- Начало Загоны -->

                                <div class="col-6 col-sm-3 zagons" v-for="zag in zagon" style="">
                                    <div v-for='i in zag'>
                                        <img src="/images/oven.jpg">
                                    </div> 
                                </div>

                                <!-- Конец Загоны -->
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        <!--История жизни в загонах-->
        <section>
            <div class="container">
                <div class="row">                    
                    <div id="history" class="col-12 br-all">
                        <div class="col-12 flex flex-wrap">

                            <div class="col-12 pad">
                                <button v-on:click="show_history" class="btn btn-primary">Показать историю</button>
                            </div>
                            
                            <div class="col-6 br-top pad br-rht" v-if="show">                                
                                
                                <table class="table" style="width: 100%">

                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">День</th>
                                            <th scope="col">Загон №1</th>
                                            <th scope="col">Загон №2</th>
                                            <th scope="col">Загон №3</th>
                                            <th scope="col">Загон №4</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="zagon in list" >
                                            <td v-html="zagon['day']"></td>  
                                            <td v-html="zagon['zagon1']"></td> 
                                            <td v-html="zagon['zagon2']"></td> 
                                            <td v-html="zagon['zagon3']"></td> 
                                            <td v-html="zagon['zagon4']"></td>                                       
                                        </tr>
                                    </tbody>
                                    
                                </table>

                            </div>
                            <div class="col-6 br-top" v-if="show">

                                <div class="pad">
                                    <button v-on:click="comp_data" class="btn btn-success marg">
                                        Загрузить данные
                                    </button>                                    
                                </div>

                                <div class="pad">
                                    <button v-on:click="prevPage" :disabled="pageNumber==1" class="btn btn-success marg">
                                        Previous
                                    </button>
                                    <button v-on:click="nextPage" :disabled="pageNumber>=countPage" class="btn btn-success marg">
                                        Next
                                    </button>
                                </div>

                                <div class="pad">
                                    <div class="green-bold">Всего: <span v-html="all_sheeps"></span></div>
                                    <div class="green-bold">Пополнение: <span v-html="add_sheeps"></span></div>
                                    <div class="green-bold">Съедено: <span v-html="del_sheeps"></span></div>                                    
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    	
            

            
    	
    </body>
    <script type="text/javascript">

        // Объект герерации жизни загонов (вычисление, отображение, сохранение)

        new Vue({
            el: '#app',
           
            data: {
                interval:10,
                zagon: [], // Массив загонов
                array: [],
                id_day: 1, // номер дня
                title_name:"День" // Заголовок с номером дня
            },
            methods: {
                
                //Отправка данных в базу
                sendData() {
                    axios.post('/oven_day', {
                            array:this.zagon,
                            days:this.id_day}
                        ).then(response => {
                            console.log(JSON.stringify(response.data));
                        }).catch(error => {
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors || {};
                            }
                        });
                },
                //Функция начала генерации расчетов
                begin_game(){

                    var v = this;


                    this.begin();

                    this.zagon=this.check(this.zagon);

                    timerId=setInterval(function(){v.oven()}, v.interval*1000);

                },
                //Функция завершения генерации расчетов
                end_game(){
                    clearInterval(timerId);
                    this.id_day=1;
                },
                //Получение начальных данных
                begin(){
                    this.zagon=[];
                    kol=0;
                    for (i=0;i<=2;i++){  
                        this.zagon[i]=Math.floor(Math.random() * 2) + 0;
                        kol=kol+this.zagon[i]; 
                    }
                    this.zagon[3]=10-kol;                 
                },
                //Проверка на максимальное количество
                id_max(array){
                    max=0;
                    max_id=0;
                    
                    for (i=0;i<array.length;i++){
                        if (max<array[i]){
                            max=array[i];
                            max_id=i;
                        }                        
                    }

                    return max_id;
                },
                //перемещение из загона в загон
                change(array,i,k,ind){

                    array[k]=array[k]-ind;
                    array[i]=array[i]+ind;
                    return array;

                },
                //Проверка на одиночество в загоне
                check(array){

                    for (j=0;j<array.length;j++){
                        if (array[j]<2){
                            if (array[j]==1){
                                k=this.id_max(array);
                                array=this.change(array,j,k,1);
                            }
                            if (array[j]==0){
                                k=this.id_max(array);
                                array=this.change(array,j,k,2);

                            }
                        }
                    }
                    return array;

                },
                //Генерация событий за день
                day(array,id_days){

                    rand=Math.floor(Math.random() * 4) + 0;

                    array[rand]++;

                    if ((id_days % 10) ==0){
                        rand=Math.floor(Math.random() * 4) + 0;
                        array[rand]--;
                    }

                    array=this.check(array);

                    return array;
                },
                //Основная функция
                oven(){    
                    
                    this.zagon=this.day(this.zagon,this.id_day);

                    // this.history[this.id_day]=this.zagon;

                    this.title_name='День '+this.id_day;

                    this.sendData();

                    this.id_day++;  
                    
                    
                }
            }
        });
    </script>
    <script type="text/javascript">

        // Объект вывода истории

        new Vue({
            el: '#history',
           
            data: {                
                zagons: [],
                day: 1,
                all_sheeps:10,
                add_sheeps:0,
                del_sheeps:0,
                pageNumber:1,
                list:[],
                size:10,
                countPage:1,
                show:false
            },
            methods: {
                receive_data() {                    
                    axios.get('/history', {}
                    ).then(response => {
                            // console.log(JSON.stringify(response.data));
                            this.zagons=response.data;
                            console.log(this.zagons);

                    }).catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        }
                    });

                },
                nextPage(){
                    this.pageNumber++;
                    this.paginatedData();
                },
                prevPage(){
                    this.pageNumber--;
                    this.paginatedData();
                },

                show_history(){
                    this.show=!this.show;
                    this.comp_data();
                    
                },              

                comp_data(){
                    this.receive_data();
                    count=this.zagons.length;
                    console.log(count);
                    this.add_sheeps=this.zagons[count-1].all_plus;
                    console.log(this.add_sheeps);
                    this.del_sheeps=this.zagons[count-1].all_minus;
                    this.all_sheeps=10+this.add_sheeps-this.del_sheeps;
                    this.pageCount();
                    this.paginatedData();
                    console.log('list='+this.list);
                    console.log('countpage='+this.countPage);
                    
                },

                pageCount(){
                    let l = this.zagons.length,
                    s = this.size;
                    // редакция переводчика спасибо комментаторам
                    this.countPage= Math.ceil(l/s);
                    // оригинал
                    // return Math.floor(l/s);
                },
                paginatedData(){
                    const start = this.pageNumber * this.size-this.size,
                    end = start + this.size;
                    console.log('start='+start);
                    console.log('end='+end);
                    this.list= this.zagons.slice(start, end);
                }
                
            }
            

        });


    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>