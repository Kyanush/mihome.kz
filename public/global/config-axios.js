// Add a response interceptor
axios.interceptors.response.use(function (response) {
    console.log(response);
    // Do something with response data
    return response;
}, function (error) {
    console.log(error.response);

    var res = error.response;
    if(res.data)
    {
        if(res.data.errors)
        {
            swalErrors(res.data.errors);
        }
    }

    // Do something with response error
    return Promise.reject(error);
});