<template>

     <div class="col-md-8 col-md-offset-2">

          <history_back></history_back>

          <!-- Default box -->
          <div class="box">

               <div class="box-header with-border">
                    <h3 class="box-title">Переупорядочить категории</h3>
               </div>

               <div class="box-body">

                    <p>Вы можете изменить порядок категорий.</p>

                    <div class="sortable-tree-block">
                         <SortableTree :data="treeData" mixinParentKey="$parent" @changePosition="changePosition" :dragEnable="true" closeStateKey="$foldClose">
                              <template slot-scope="{item}">
                                   <div class="custom-tree-content" :class="{'exitChild': item.children && item.children.length}">
                                        <span v-if="item['$foldClose'] && item.children && item.children.length" @click="changeState(item)">
                                             <button class="btn btn-plus">
                                                  <i class="glyphicon glyphicon-plus"></i>
                                             </button>
                                        </span>
                                        <span v-else-if="!item['$foldClose'] && item.children && item.children.length" @click="changeState(item)">
                                             <button class="btn btn-minus">
                                                   <i class="glyphicon glyphicon-minus"></i>
                                             </button>
                                        </span>
                                        <span class="category-name" v-bind:class="{'red': item.active == 0, 'category-parent': (item['$foldClose'] && item.children && item.children.length)
                                                                      ||
                                                                   (!item['$foldClose'] && item.children && item.children.length) }">
                                             {{ item.name }}
                                        </span>
                                   </div>
                              </template>
                         </SortableTree>
                    </div>


                    <button id="toArray" class="btn btn-success ladda-button" data-style="zoom-in"  @click="reorderSave">
                         <span class="ladda-label">
                              <i class="fa fa-save"></i> Сохранить
                         </span>
                    </button>

               </div><!-- /.box-body -->
          </div><!-- /.box -->
     </div>


</template>

<script>
    import SortableTree from 'vue-sortable-tree';
    export default {
        components: {
            SortableTree
        },
        name: 'hello',
        data () {
            return {
                treeData: {
                    name: 'Категория',
                    children: []
                },
                reorder_send: []
            }
        },
        methods: {

            reorderSendConvert(list, parent_id){

                if(!parent_id) parent_id = 0;

                var self = this;
                list.forEach(function (item, key) {


                    self.reorder_send.push({
                        id: item.id,
                        name: item.name,
                        parent_id: parent_id
                    });

                    if(item.children.length)
                        self.reorderSendConvert(item.children, item.id);
                });

            },

            reorderSave () {
                this.reorderSendConvert(this.treeData.children);

                axios.post('/admin/reorder-save', {reorder_send: this.reorder_send} ).then((res)=>{
                    if(res.data)
                    {
                        this.reorder_send = [];
                        this.getCategoryReorder();
                        this.$helper.swalSuccess('Успешно изменено порядок');
                    }
                });

            },
            changeState (item) {
                this.$set(item, '$foldClose', !item['$foldClose'])
            },
            changePosition (option) {
                //console.log('changePosition: ', option)
            },
            getCategoryReorder(){
                axios.get('/admin/catalogs-tree/2').then((res)=>{
                    this.treeData.children = res.data;
                });
            }
        },
        created(){
            this.getCategoryReorder();
        }
    }
</script>


<style scoped>
     .btn-plus, .btn-minus{
          padding: 0 6px;
          margin-left: -12px;
          z-index: 21;
          position: absolute;
          margin-top: 3px;
     }
     .btn-plus i, .btn-minus i{
          font-size: 8px;
          top: -1px;
     }
     .category-parent{
          margin-left: 15px;
     }
     .sortable-tree-block{
          padding: 10px 0 25px 35px;
     }
     .btn-minus{
          border: 1.2px solid #00A0FF;
          color: #00A0FF;
          background-color: #fff;
     }
     .btn-plus{
          border: 1.2px solid #C6CFDA;
          color: #000;
          background-color: #fff;
     }
     .custom-tree-content{
          cursor: move;
     }
     .custom-tree-content:hover{
          background-color: #f6f6f6;
     }
     .category-name{
          padding-left: 5px;
     }
</style>
