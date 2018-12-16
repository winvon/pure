function select2_input(select,url,placeholder,minimumResultsForSearch) {
    if (!arguments[3]){minimumResultsForSearch=1};
    $(select).select2({
        ajax: {
            url: url,
            dataType: 'json',
            method: 'post',
            delay: 250,
            cache: true,
            data: function (params) {
                return {
                    name: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 2) < data.total_count
                    }
                };
            },
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        language: "zh-CN",
        placeholder:placeholder,
        minimumResultsForSearch:minimumResultsForSearch,
    });
}