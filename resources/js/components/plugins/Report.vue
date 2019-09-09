<template>
    <div class="modal fade form-popup" id="popup-peport" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <b><i class="fa fa-print" aria-hidden="true"></i> Отчеты</b>
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Вид отчета:</label>
                                <Select2 v-model="report.view" :options="report_types" @select="selectReportType($event)" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Формат</label>
                                <select class="selectpicker form-control" v-model="report.ext">
                                    <option :data-icon="'fa fa-file-excel-o'" value="excel">Excel</option>
                                    <option :data-icon="'fa fa-file-pdf-o'"   value="pdf">PDF</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row btn-item">
                        <div class="form-group col-md-6">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                Закрыть
                            </button>
                        </div>
                        <div class="form-group col-md-6">
                            <button class="btn btn-primary pull-right" @click="reportDownload" v-bind:disabled="!report.view">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                Загрузить отчет
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Select2 from 'v-select2-component';
    export default {
        components:{
            Select2
        },
        props:['report_types', 'filter'],
        data () {
            return {
                report: {
                    id: 0,
                    title: '',
                    ext: 'excel'
                }
            }
        },
        updated(){
            $('.selectpicker').selectpicker('refresh');
        },
        methods:{
            selectReportType({id, text}){
                this.report.view  = id;
                this.report.title = text;
            },
            reportDownload(){

                console.log(this.filter);

                if(this.report.view && this.report.ext)
                {

                    if(this.filter)
                        var query = this.filter;
                    else
                        var query = this.$route.query;

                    this.$set(query, 'title', this.report.title);

                    let routeData = this.$router.resolve({
                        path: this.report.view + '/' + this.report.ext,
                        query: query
                    });

                    window.open(routeData.href, '_blank');

                }else{
                    alert('Выберите');
                }
            },
        },
    }
</script>