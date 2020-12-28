<template>
    <div class="box">

        <div class="box-header with-border">
            <table class="table-top-btn">
                <tr>
                    <td>
                        <select class="form-control" v-model="table">
                            <option v-for="table_name in table_list" :value="table_name">{{ table_name }}</option>
                        </select>
                    </td>
                    <td v-if="table == 't_products'">
                        <select class="form-control" v-model="attribute_group_id">
                            <option value=""></option>
                            <option v-for="group in attributes_sets_more_info" :value="group.id">{{ group.name }}</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-file">
                            <i class="fa fa-download" aria-hidden="true"></i>
                            Загрузить Excel
                            <input id="readExcel" type="file" accept=".xlsx, .xls, .csv" @change="readExcel($event)"/>
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-primary" @click="exportTable">
                            <i class="fa fa-upload" aria-hidden="true"></i>
                            Экспортировать таблицу
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-danger" @click="clear">
                            <i class="fa fa-remove" aria-hidden="true"></i> Очистить
                        </button>
                    </td>
                </tr>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-data-excel">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th width="130" v-for="(number, index) in data_item_max_length">
                            <select class="form-control" @change="disabled_column(index)" v-model="data_column[ number - 1 ]">
                                <option></option>
                                <option v-for="column in columns"
                                        v-bind:disabled="column.selected_index >= 0 && column.selected_index != index && column.type != 'multiple_select'"
                                        :value="column.column">
                                    {{ column.title ? column.title : column.column }}
                                </option>
                            </select>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in data">
                        <td>{{ index + 1 }}</td>
                        <td>
                            <input type="checkbox" v-model="selected[ index ]"/>
                        </td>
                        <td width="130" v-for="number in data_item_max_length">
                            {{ limitText(item, number) }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th width="130" v-for="number in data_item_max_length">
                            <select class="form-control" v-model="data_column[ number - 1 ]">
                                <option></option>
                                <option v-for="column in columns" :value="column.column">
                                    {{ column.title ? column.title : column.column }}
                                </option>
                            </select>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-md-4" style="float: right;">
            <div class="form-group">
                <label>
                    Поле для идентификации элемента:
                </label>
                <p class="identification-column-desc">
                    По данному полю (полям) будет производиться поиск элемента.
                    Если элемент будет найден по данному полю (полям), то он будет обновлен, иначе будет создан новый элемент.
                </p>
                <select class="form-control" v-model="identification_column">
                    <option value=""></option>
                    <option :value="column.column" v-for="column in columns" v-if="column.selected_index >= 0">
                        {{ column.title ? column.title : column.column }}
                    </option>
                </select>
            </div>
            <div class="form-group" v-if="mgs">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">
                        Результат:
                        <b>все:</b> {{ mgs.total }} |
                        <b>добавлен:</b> {{ mgs.new }} |
                        <b>обновлен:</b> {{ mgs.update }}
                    </li>
                </ul>
            </div>
            <div class="form-group text-right">
                <button class="btn btn-primary" :disabled="!sendActive" @click="send">
                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                    Сохранить
                </button>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data () {
            return {
                columns:[],
                identification_column: '',
                data: [],
                data_column: [],
                data_item_max_length: 0,
                selected: [],
                wait: false,
                table_list: [],
                table: 't_products',
                mgs: null,
                attributes_sets_more_info: [],
                attributes: [],
                attribute_group_id: 0
            }
        },
        created() {
            axios.get('/admin/table-list').then((res)=>{
                this.table_list = res.data;
            });
            this.tableColumns();
            axios.get('/admin/attribute-sets-more-info').then((res)=>{
                this.attributes_sets_more_info = res.data;
            });
        },
        computed: {
            sendActive(){
                var _result = false;
                this.columns.forEach((item, i) => {
                    if(item.selected_index >= 0){
                        _result = true;
                        return;
                    }
                });
                return _result;
            }
        },
        watch: {
            table: {
                handler: function (val, oldVal) {
                    this.tableColumns(val);
                },
                deep: true
            },
            attribute_group_id:{
                handler: function (val, oldVal) {

                    for (var i = this.columns.length-1; i >= 0; i--)
                    {
                        if(typeof this.columns[i].column == 'number')
                        {
                            this.$delete(this.columns, i);
                        }
                    }

                    setTimeout(function (){
                        var self = this;
                        this.attributes_sets_more_info.forEach((item, i) => {
                            if(item.id == val)
                            {
                                    item.attributes.forEach((item, index) => {
                                        self.columns.push({
                                            column: item.id,
                                            selected_index: -1,
                                            title: 'Атрибут: ' + item.name,
                                            type: item.type
                                        });
                                    });
                                return;
                            }
                        });
                    }.bind(this), 1000);
                },
                deep: true
            }
        },
        methods:{
            tableColumns(table){

                if(!table)
                    table = this.table;

                axios.get('/admin/table-columns/' + table).then((res)=>{
                    this.columns = res.data;

                    var self = this;
                    this.columns.forEach((item, i) => {
                        self.$set(self.columns[i], 'selected_index', -1);
                        self.$set(self.columns[i], 'type', '');
                    });

                    if(table == 't_products')
                    {
                        this.columns.push(
                            {
                                column:         "categories",
                                selected_index: -1,
                                title:          "Категория",
                                type:           "multiple_select"
                            },
                            {
                                column:         "images",
                                selected_index: -1,
                                title:          "Картинки",
                                type:           "multiple_select"
                            }
                        );
                    }

                });
            },
            clear(){
                this.identification_column = '';
                this.data = [];
                this.data_column = [];
                this.data_item_max_length = 0;
                this.selected = [];

                this.mgs = null;

                var self = this;
                this.columns.forEach((item, i) => {
                   self.$set(self.columns[i], 'selected_index', -1);
                });
            },
            disabled_column(index){
                var self = this;

                this.columns.forEach((item, i) => {
                    if(item.column == self.data_column[ index ]){
                        self.$set(self.columns[i], 'selected_index', index);
                    }else if(self.columns[i].selected_index == index){
                        self.$set(self.columns[i], 'selected_index', -1);
                    }
                });
            },

            limitText(item, number){

                if(item[ number - 1 ])
                {
                    return item[ number - 1 ].length > 50
                         ? item[ number - 1 ].substr(0, 50) + '...'
                         : item[ number - 1 ];
                }

                return '';
            },
            send(){
                if(!this.wait)
                {
                    this.wait = true;
                    var data = {
                        identification_column: this.identification_column,
                        data:                  this.data,
                        data_column:           this.data_column,
                        selected:              this.selected,
                        table:                 this.table,
                        attributes:            this.attributes,
                        attribute_group_id:    this.attribute_group_id
                    };

                    axios.post('/admin/import', data).then((res)=>{
                        var data = res.data;



                        this.mgs = data;
                        this.wait = false;

                    }).catch(error => {
                        this.wait = false;
                    });
                }
            },
            exportTable(){
                window.open('/admin/export-table/' + this.table, '_blank');
            },
            readExcel(event){

                var oFile = event.target.files[0];

                document.getElementById("readExcel").value = "";

                var sFilename = oFile.name;

                var reader = new FileReader();
                var self = this;

                reader.onload = function (e) {
                    var data = e.target.result;
                    data = new Uint8Array(data);
                    var workbook = XLSX.read(data, {type: 'array'});

                    var result = {};
                    workbook.SheetNames.forEach(function (sheetName) {
                        var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {header: 1});
                        if (roa.length) result[sheetName] = roa;
                    });
                    // see the result, caution: it works after reader event is done.

                    self.data = result[ workbook.SheetNames ];

                    self.data.forEach(function (item, index) {

                        self.selected[index] = true;

                        if(item.length > self.data_item_max_length)
                            self.data_item_max_length = item.length;

                    });

                    for (var number = 0; number < self.data_item_max_length; number++)
                    {
                        self.data.forEach(function (item, index) {
                            if(!self.data[ index ][ number ])
                                 self.data[ index ][ number ] = '';
                        });
                        self.data_column[ number ] = '';
                    }

                    for (var i = self.data.length; i >= 0; i--)
                    {
                        if(self.data[i])
                        {
                            var empty_count = 0;
                            for (var number = 0; number < self.data_item_max_length; number++)
                            {
                                if (!self.data[i][number])
                                    empty_count++;
                            }

                            if(empty_count == self.data_item_max_length)
                                self.$delete(self.data, i);

                        }
                    }

                };
                reader.readAsArrayBuffer(oFile);

            }
        }
    }
</script>

<style scoped>
    .table-data-excel {
        height: 400px;
        overflow: auto;
        display:inline-block;
    }
    .table-top-btn td, .table-top-btn th{
        padding: 0px 5px;
    }
    .identification-column-desc{
        font-size: 12px;
        color: #dd4b39;
    }
</style>
