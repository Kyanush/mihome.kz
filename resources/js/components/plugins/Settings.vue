<template>
<div class="box">
<table class="table table-bordered ">
   <tbody>
     <tr>
        <td width="25%" class="text-right">
          <label>Уведомление о заказе:</label>
        </td>
        <td width="75%">
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr v-for="(item, index) in order_notification_email">
                  <td width="75%" class="text-right">
                        <input type="text" class="form-control" v-model="item.value"/>
                  </td>
                  <td width="25%">
                     <a @click="orderDelete(item, index)" title="Удалить" class="btn btn-xs btn-default">
                          <i class="fa" :class="{ 'fa-remove red': !item.delete, 'fa-refresh green': item.delete }"></i>
                     </a>
                  </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
                        <button class="btn btn-success" @click="orderAdd">
                             <a class="fa fa-plus"></a>
                        </button>
                    </td>
                </tr>
              </tbody>
            </table>
          </div>
        </td>
     </tr>


     <tr>
         <td width="25%" class="text-right">
             <label>Уведомление об обратным звоноке:</label>
         </td>
         <td width="75%">
             <div class="col-md-6">
                 <table class="table">
                     <tbody>
                     <tr v-for="(item, index) in сallback_notification_email">
                         <td width="75%" class="text-right">
                             <input type="text" class="form-control" v-model="item.value"/>
                         </td>
                         <td width="25%">
                             <a @click="callbackDelete(item, index)" title="Удалить" class="btn btn-xs btn-default">
                                 <i class="fa" :class="{ 'fa-remove red': !item.delete, 'fa-refresh green': item.delete }"></i>
                             </a>
                         </td>
                     </tr>
                     <tr>
                         <td colspan="2" class="text-right">
                             <button class="btn btn-success" @click="callbackAdd">
                                 <a class="fa fa-plus"></a>
                             </button>
                         </td>
                     </tr>
                     </tbody>
                 </table>
             </div>
         </td>
     </tr>
     <tr>
         <td colspan="2" class="text-right">
             <button type="button" class="btn btn-success float-right"  @click="save">
                 <i role="presentation" aria-hidden="true" class="fa fa-save"></i>
                 &nbsp;
                 Сохранить
             </button>
         </td>
     </tr>
   </tbody>
</table>
</div>
</template>

<script>
    export default {
        data () {
            return {
                order_notification_email:[
                    {
                        id: 0,
                        key: 'order_notification_email',
                        value: '',
                        delete: false
                    }
                ],
                сallback_notification_email:[
                    {
                        id: 0,
                        key: 'сallback_notification_email',
                        value: '',
                        delete: false
                    }
                ]
            }
        },
        methods:{
            orderAdd(){
                this.order_notification_email.push({
                    id: 0,
                    key: 'order_notification_email',
                    value: '',
                    delete: false
                });
            },
            orderDelete(item, index){
                if(item.id){
                    this.$set(this.order_notification_email[index], 'delete', !item.delete);
                }else{
                    this.$delete(this.order_notification_email, index);
                }
            },


            callbackAdd(){
                this.сallback_notification_email.push({
                    id: 0,
                    key: 'сallback_notification_email',
                    value: '',
                    delete: false
                });
            },
            callbackDelete(item, index){
                if(item.id){
                    this.$set(this.сallback_notification_email[index], 'delete', !item.delete);
                }else{
                    this.$delete(this.сallback_notification_email, index);
                }
            },





            save(){
                var data = [];

                this.order_notification_email.forEach(function (item) {
                    if(item.value)
                        data.push(item);
                });

                this.сallback_notification_email.forEach(function (item) {
                    if(item.value)
                        data.push(item);
                });

                axios.post('/admin/save-settings', data).then((res)=>{
                    this.getData();
                });
            },
            getData(){
                this.order_notification_email = [];
                this.сallback_notification_email = [];

                var self = this;
                axios.get('/admin/get-settings').then((res)=>{
                    var data = res.data;
                    data.forEach(function (item) {
                        if(item.key == 'order_notification_email')
                        {
                            self.order_notification_email.push(
                                {
                                    id:    item.id,
                                    value: item.value,
                                    key:  'order_notification_email',
                                    delete: false
                                }
                            );
                        }
                        if(item.key == 'сallback_notification_email')
                        {
                            self.сallback_notification_email.push(
                                {
                                    id:    item.id,
                                    value: item.value,
                                    key:  'сallback_notification_email',
                                    delete: false
                                }
                            );
                        }
                    });
                });
            }
        },
        created(){
            this.getData();
        }
    }
</script>