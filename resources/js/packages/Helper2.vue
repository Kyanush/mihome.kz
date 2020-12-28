<script>
    export default {
        methods: {
            $isObject(obj) {
                return JSON.stringify(obj) === '{}' ? false : true;
            },
            $can(_permissions) {
                if ($.isArray(_permissions)) {

                    var result = false;

                    _permissions.forEach(function (item) {
                        if (window.permissions.indexOf(item) !== -1) {
                            result = true;
                            return;
                        }
                    });

                    return result;
                } else {
                    return window.permissions.indexOf(_permissions) !== -1;
                }
            },
            $getCurrentDate(format, split, old) {

                if (!format) format = 'dd-mm-yyyy';
                if (!old) old = 0;
                if (!split) split = '-';

                format = format.split(split);

                var d = new Date();
                d.setDate(d.getDate() - old);

                var date = '';
                format.forEach(function (item) {

                    if (item == 'dd')
                        date += String(d.getDate()).padStart(2, '0') + split;

                    if (item == 'mm')
                        date += String(d.getMonth() + 1).padStart(2, '0') + split;

                    if (item == 'yyyy')
                        date += d.getFullYear() + split;

                });

                date = date.substring(0, date.length - 1);

                return date;
            },
            $clearParams(filters) {
                var params = {};
                if (filters.page > 1)
                    params['page'] = filters.page;
                Object.keys(filters).forEach(function (column) {
                    if (filters[column] && column != 'page') {
                        params[column] = filters[column];
                    }
                });
                return params;
            },
            $setImgSrc(value, element) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(element).attr('src', e.target.result);
                }
                reader.readAsDataURL(value);
            },

            $isMobile() {
                return window.screen.width < 800 ? true : false;
            },
            $formData(data, variable) {
                var form_data = new FormData();

                Object.keys(data).forEach(function (column) {
                    if ($.isArray(data[column])) {
                        if (data[column]) {
                            if (Object.keys(data[column]).length) {
                                Object.keys(data[column]).forEach(function (index) {
                                    var value = data[column][index] === undefined ? '' : data[column][index];

                                    if (variable)
                                        form_data.append(variable + '[' + column + '][' + index + ']', value);
                                    else
                                        form_data.append(column + '[' + index + ']', value);
                                });
                            } else {
                                if (variable)
                                    form_data.append(variable + '[' + column + ']', []);
                                else
                                    form_data.append(column, []);
                            }
                        }
                    } else {

                        var value = data[column] === undefined ? '' : data[column];

                        if (variable)
                            form_data.append(variable + '[' + column + ']', value);
                        else
                            form_data.append(column, value);
                    }
                });
                return form_data;
            },
            $swalSuccess(title, type, timer) {
                if (title) {
                    const toast = Vue.swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: timer ? timer : 3000,
                        width: '300px'
                    });
                    toast({
                        type: type ? type : 'success',
                        title: title,
                    });
                }
            },
            $swalError(errors, title) {


                if (errors) {
                    var swal_html = '';

                    if ($.isArray(errors) || typeof errors === 'object') {
                        Object.keys(errors).forEach(function (key) {
                            if ($.isArray(errors[key])) {
                                errors[key].forEach(error => {
                                    swal_html += error + '<br/>';
                                });
                            } else {
                                swal_html += errors[key] + '<br/>';
                            }
                        });
                    } else {
                        swal_html = errors;
                    }

                    if (swal_html) {
                        swal_html = '<span class="error">' + swal_html + '</span>';
                        Vue.swal({
                            // type:  'error',
                            title: title ? title : 'Ошибка',
                            html: swal_html
                        });
                    }
                }
            },

            $isNullClear(value, default_value) {
                if (!default_value)
                    default_value = '';

                if (value === null) {
                    return default_value;
                } else {
                    return value;
                }
            },

            $dateFormat(dateString, type_format) {

                if (!dateString) return '';
                if (!type_format) type_format = 'datetime';

                var reggie = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
                var dateArray = reggie.exec(dateString);

                if (!dateArray) {
                    reggie = /(\d{4})-(\d{2})-(\d{2})/;
                    dateArray = reggie.exec(dateString);
                }

                if (dateArray) {

                    if (type_format == 'date')
                        return dateArray[3] + '.' + dateArray[2] + '.' + dateArray[1];

                    else if (type_format == 'datetime')
                        return dateArray[3] + '.' + dateArray[2] + '.' + dateArray[1]
                            + ' ' +
                            dateArray[4] + ':' + dateArray[5];

                    else if (type_format == 'full')
                        return dateArray[3] + '.' + dateArray[2] + '.' + dateArray[1]
                            + ' ' +
                            dateArray[4] + ':' + dateArray[5] + ':' + dateArray[6];

                    else if (type_format == 'time')
                        return dateArray[4] + ':' + dateArray[5];

                    else if (type_format == 'fulltime')
                        return dateArray[4] + ':' + dateArray[5] + ':' + dateArray[6];
                } else {
                    return '';
                }
            },

            $dateFormatTodayYesterday(dateString) {
                var date = this.dateFormat(dateString, 'date');


                var today = new Date();
                var month = today.getMonth() + 1;
                var current_date = (today.getDate() < 10 ? ('0' + today.getDate()) : today.getDate())
                    + '.' + (month < 10 ? ('0' + month) : month)
                    + '.' + today.getFullYear();


                var today = new Date(Date.now() - 86400000);
                var month = today.getMonth() + 1;
                var yesterday_date = (today.getDate() < 10 ? ('0' + today.getDate()) : today.getDate())
                    + '.' + (month < 10 ? ('0' + month) : month)
                    + '.' + today.getFullYear();


                if (date == current_date)
                    return 'сегодня в ' + this.dateFormat(dateString, 'time');

                if (date == yesterday_date)
                    return 'вчера в ' + this.dateFormat(dateString, 'time');

                return this.dateFormat(dateString, 'datetime');
            },
            $groupArrayByValue(data, key) {

                var result = data.reduce(function (r, a) {
                    r[a[key]] = r[a[key]] || [];
                    r[a[key]].push(a);
                    return r;
                }, Object.create(null));

                return result;
            },
            $getNumberLength(num) {
                return (Math.log(Math.abs(this.modul_num) + 1) * 0.43429448190325176 | 0) + 1
            },
            $oneParameterCurrent(parameter_name, type, value) {
                let query = Object.assign({}, this.$route.query);
                if (type == 'add') {
                    if (value)
                        query[parameter_name] = value;
                } else if (type == 'delete') {
                    delete query[parameter_name];
                }
                this.$router.replace({query});
            },
        }
    };
</script>
